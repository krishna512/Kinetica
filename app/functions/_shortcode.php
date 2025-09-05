<?php
//Short Code For Header Feature Post
function display_featured_post_shortcode($atts)
{
    // Get the featured post based on the meta key
    $args = [
        'meta_query' => [
            [
                'key'     => 'featured_post', // Adjust this meta key to the one used by your plugin
                'value'   => '1',            // Adjust this to the value that marks a post as featured
                'compare' => '='
            ]
        ],
        'post_type' => 'post',  // Change to your custom post type if needed
        'posts_per_page' => 1,  // Only display one post
    ];
    $featured_query = new WP_Query($args);
    if ($featured_query->have_posts()) {
        ob_start();
        while ($featured_query->have_posts()) {
            $featured_query->the_post();
            $id = get_the_ID();
            $custom_author = get_field('custom_author');
            // Assuming this is an ACF field
            // Retrieve terms for the 'blog_type' taxonomy
            $blog_type_terms = get_the_terms(get_the_ID(), 'blog_type');
?>
            <div class='featured-post'>
                <?php if (has_post_thumbnail()) : ?>
                    <div class='featured-image'>
                        <?php the_post_thumbnail('large');
                        ?>
                    </div>
                <?php endif;
                ?>
                <div class='featured-post__contents'>
                    <div class='category'>
                        <?php
                        if (!empty($blog_type_terms)) : ?>
                            <span class='categories'>
                                <?php
                                foreach ($blog_type_terms as $term) {
                                    $blog_type_links[] = esc_html($term->name);
                                }
                                echo implode(', ', $blog_type_links);
                                ?>
                            </span>
                        <?php endif;
                        ?>
                    </div>
                    <div class='featured-post__title'>
                        <a href='<?php the_permalink(); ?>'>
                            <h2><?php the_title();
                                ?></h2>
                        </a>
                    </div>
                    <div class='post-excerpt'>
                        <?php echo wp_trim_words(get_the_excerpt(), 20, '...');
                        ?>
                    </div>
                    <div class='post-meta'>
                        <div class='flex gap-x-2 items-center'>
                            <?php echo useSVG('user') ?>
                            <span class='author'><?php echo esc_html($custom_author->post_title);
                                                    ?></span>
                        </div>
                        <div class='flex gap-x-2 items-center'>
                            <?php echo useSVG('calendar') ?>
                            <span class='date'><?php echo get_the_date();
                                                ?></span>
                        </div>
                    </div>
                    <div class='featured-post__footer'>
                        <div class='w-full flex justify-end'>
                            <a href='<?php the_permalink(); ?>' class='flex items-center gap-x-2'>
                                <span class='learn-more'> Learn more </span>
                                <span class='arrow'> <?php echo useSVG('arrow-right-card') ?> </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
<?php
        }
        wp_reset_postdata();
        return ob_get_clean();
    } else {
        return '<p>No featured post found.</p>';
    }
}
add_shortcode('featured_post', 'display_featured_post_shortcode');

function kinetica_copyright_shortcode()
{
    return '© 2016-' . date("Y") . ' Kinetica DB Inc';
}
add_shortcode('kinetica_copyright', 'kinetica_copyright_shortcode');
?>