<?php

function remove_posts_columns($defaults)
{
    unset($defaults['author']);
    return $defaults;
}
// add_filter('manage_posts_columns', 'remove_posts_columns');


/**
 * Remove support of author from posts
 * @return void
 */
function remove_author_support_from_post_type()
{
    remove_post_type_support('post', 'author');
}
add_action('init', 'remove_author_support_from_post_type');



/**
 * limit_title_character_count_script
 */
function limit_title_character_count_script()
{
    global $post_type;
    $allowed_post_types = ['question'];
    // allowed_post_types should not have Editor; post_types editor must be disable 
    if (in_array($post_type, $allowed_post_types)) {
?>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                var titleField = $('#title');
                // Set your desired character limit
                var characterLimit = 90;
                titleField.on('input', function() {
                    var currentLength = titleField.val().length;
                    if (currentLength > characterLimit) {
                        // Trim the title to the character limit
                        var trimmedTitle = titleField.val().substring(0, characterLimit);
                        titleField.val(trimmedTitle);
                        $('#title_limit_warning').remove();
                        $('#titlewrap').append(
                            '<div id="title_limit_warning" class="notice notice-warning is-dismissible"><p>Question character limit is ' +
                            characterLimit +
                            '</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>'
                        );
                        $('#title_limit_warning button').on('click', function() {
                            $('#title_limit_warning').remove();
                        });
                    }
                });

            });
        </script>
<?php
    }
}
add_action('admin_head-post.php', 'limit_title_character_count_script');
add_action('admin_head-post-new.php', 'limit_title_character_count_script');


/**
 * ====================================
 * Remove WPCode Page Scripts
 * ====================================
 */

function remove_wpcode_page_scripts_metabox()
{
    // Get an array of all registered post types
    $post_types = get_post_types();

    // Remove the metabox from each post type
    foreach ($post_types as $post_type) {
        remove_meta_box('wpcode-metabox-snippets', $post_type, 'normal');
    }
}
add_action('add_meta_boxes', 'remove_wpcode_page_scripts_metabox');


/**
 * Remove default tag
 */

// Remove default tag taxonomy
function remove_default_tag_taxonomy()
{
    unregister_taxonomy_for_object_type('post_tag', 'post');
}
add_action('init', 'remove_default_tag_taxonomy');
