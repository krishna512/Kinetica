<?php

/**
 * =================================================================
 * Text Search Field
 * 
 * Outputs - HTML for text search
 * =================================================================
 */
if (! function_exists('search_filter')) {
    function search_filter($params = [])
    {

        $defaults = [
            'placeholder' => 'Search by title or keyword'
        ];

        $parameter = array_merge($defaults, $params);

        $search = (isset($_GET['search'])) ? $_GET['search'] : '';

        ob_start();
        ?>
        <label class="yi-input-label">
            <input class="yi-text-input" type="text" placeholder="<?php echo $parameter['placeholder']; ?>" name="search"
                value="<?php echo $search; ?>" autocomplete="off" />
            <button class="yi-submit-btn" type="submit">Search</button>
        </label>
        <?php
        return ob_get_clean();
    }
}

if (! function_exists('search_filter_shortcode')) {
    function search_filter_shortcode($atts)
    {
        return search_filter($atts);
    }
    add_shortcode('searchFilter', 'search_filter_shortcode');
}



/**
 * =================================================================
 * Get terms for filter forms
 * 
 * Outputs - Dynamic Radio Fields
 * =================================================================
 */
if (! function_exists('taxonomies_radio_filter')) {
    function taxonomies_radio_filter($taxonomy_name, $html = "radio")
    {
        $taxonomies = get_terms(array(
            'taxonomy' => $taxonomy_name,
            'hide_empty' => false
        ));

        $_tax = (isset($_GET['tax_' . $taxonomy_name])) ? $_GET['tax_' . $taxonomy_name] : '';

        if (! empty($taxonomies) && "radio" === $html) {

            if (! $_tax) {

                $checked = 'checked = "checked"';

            } else {

                $checked = '';

            }

            $output = '<ul class="yi-input-radio"><li><input id="view_all" class="yi-input-radio__field" type="radio" name="tax_' . $taxonomy_name . '" value="" ' . $checked . '><label for="view_all"><span>' . __('View All', 'hello-elementor-child') . '</span></label></li>';

            foreach ($taxonomies as $category) {

                if ($_tax == $category->term_id) {

                    $checked = 'checked = "checked"';

                } else {

                    $checked = "";

                }

                $output .= '<li><input id="' . $category->term_id . '" class="yi-input-radio__field" type="radio" name="tax_' . $taxonomy_name . '" value="' . $category->term_id . '"' . $checked . '><label for="' . $category->term_id . '"><span>' . $category->name . '</span></label></li>';
            }

            $output .= '</ul>';

            return $output;

        } elseif (! empty($taxonomies) && "link" === $html) {

            $currentUrl = get_current_page_link() . '/';

            $output = '<ul>';

            foreach ($taxonomies as $category) {

                $taxUrl = get_term_link($category);

                $activeClass = ($currentUrl === $taxUrl) ? "active" : "";

                $output .= '<li class="' . $activeClass . '"><a href="' . get_term_link($category) . '">' . $category->name . '</a></li>';
            }

            $output .= '</ul>';

            return $output;
        }
    }
}

/**
 * =================================================================
 * Generate years based on available posts
 * 
 * Outputs - Dynamic Select Fields
 * =================================================================
 */

function get_years_with_posts($post_type = 'posts')
{
    global $wpdb;

    // Ensure $wpdb is recognized as an object
    if (! is_object($wpdb)) {
        return; // Or handle the error as needed
    }

    $_GET_year = (isset($_GET['filter_year'])) ? $_GET['filter_year'] : '';

    $years = $wpdb->get_col("
        SELECT DISTINCT YEAR(post_date)
        FROM $wpdb->posts
        WHERE post_status = 'publish'
        AND post_type = '$post_type'
        ORDER BY post_date DESC
    ");

    $output = '<div class="yi-input-select"><select name="filter_year"><option value="">Select Year</option>';

    foreach ($years as $year) {

        $selected = ($_GET_year === $year) ? 'selected' : '';
        $output .= '<option value="' . $year . '" ' . $selected . '>' . $year . '</option>';
    }

    $output .= '</select></div>';

    return $output;
}

add_shortcode('years_with_posts', 'get_years_with_posts');