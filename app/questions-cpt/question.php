<?php
// enqueue required script
function questions_script()
{
    // wp_enqueue_script('acf_script', get_stylesheet_directory_uri() . '/dist/js/acf_js.js', array('acf-input'), filemtime(get_stylesheet_directory() . '/dist/js/acf_js.js'));

    wp_enqueue_script('acf_script', get_stylesheet_directory_uri() . '/dist/js/acf_js.js', array('acf-input'));
}

add_action('admin_enqueue_scripts', 'questions_script', 20);

/**
 * Question : select_question list
 * Show the question which are in relation question level 
 * */
add_filter('acf/fields/post_object/query/name=select_question', 'load_next_select_question');
function load_next_select_question($select_question_args)
{
    if (!empty($_POST['question_level_id'])) {
        $question_level_id = (int)esc_attr($_POST['question_level_id']);
        $next_question_level_id = 0;
        $question_level = get_terms(['taxonomy' => 'question-level']);
        if ($question_level && is_array($question_level)) {
            foreach ($question_level as $key_lavel => $level) {
                if ($level->term_id == $question_level_id) {
                    $next_question_level_id = (isset($question_level[$key_lavel + 1])) ? $question_level[$key_lavel + 1]->term_id : 0;
                    break;
                }
            }
        }
    }
    $select_question_args['tax_query'] = [
        [
            'taxonomy' => 'question-level',
            'field' => 'id',
            'terms' =>     $next_question_level_id,
        ]
    ];
    return $select_question_args;
}


/**
 * 
 */
function get_questions_card_data()
{
    $post_type = 'question';
    $taxonomy = 'question-level';
    $card_data = [];
    $initial_question_ids = [];
    /**
     * Get all the defind question lavel 
     */
    $question_level = get_terms(['taxonomy' => $taxonomy]);
    if ($question_level && is_array($question_level)) {
        foreach ($question_level as $key_lavel => $level) {
            /**
             * Find all the question post for the current question lavel
             */
            $args = array(
                'post_type' => $post_type,
                'posts_per_page' => -1,
                'post_status' => array('publish'),
                'tax_query' => array(
                    array(
                        'taxonomy' => $taxonomy,
                        'field' => 'slug',
                        'terms' => $level->slug,
                    ),
                )
            );
            $posts = new WP_Query($args);
            $level_count_num = 1;
            if ($posts->have_posts()) {
                while ($posts->have_posts()) {
                    $posts->the_post();
                    $id = get_the_ID();
                    $title = get_the_title();
                    /**
                     * question score
                     */
                    $score = ($score = get_field('score', $id)) ? floatval($score) : 10;

                    /**
                     * find the related next questions for the current question
                     */
                    $next_question_ids = [];
                    $related_questions = (get_field('related_questions', $id)) ?: '';
                    if ($related_questions) {
                        foreach ($related_questions as $key => $question) {
                            $select_question = ($question['select_question']) ? (int) $question['select_question'] : '';
                            if ($select_question) {
                                $next_question_ids[] = $select_question;
                                $multiplier = ($question['multiplier']) ? $question['multiplier'] : 1;
                                $initial_question_ids[$select_question][] = [
                                    'id' => $id,
                                    'multiplier' => floatval($multiplier),
                                    'score' => $score
                                ];
                            }
                        }
                    }

                    /**
                     * get all card information
                     */
                    $card_data[$id] = [
                        'id' => $id,
                        'title' => $title,
                        'score' => $score,
                        'level_total_question' => $posts->found_posts,
                        'level_name' => $level->name,
                        'level_id' => $level->term_id,
                        'level_count_num' => $level_count_num++,
                        'next_question_ids' => $next_question_ids,
                        'initial_question_ids' => (isset($initial_question_ids[$id])) ? $initial_question_ids[$id] : []
                    ];
                }
                wp_reset_postdata();
            }
        }
    }
    return $card_data;
}
