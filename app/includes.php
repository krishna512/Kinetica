<?php

/**
 * Set up
 */

$libDIR = dirname(__FILE__) . '/lib/';

// require_once $libDIR . '_vite.php';
require_once $libDIR . '_vite.lib.php';

require_once $libDIR . '_setup.php';

/**
 * Functions
 */

$functions = dirname(__FILE__) . '/functions/';

require_once $functions . '_login.php';

require_once $functions . '_securities.php';

require_once $functions . '_utils.php';

require_once $functions . '_acf-hooks.php';

require_once $functions . '_admin-hooks.php';

require_once $functions . '_dynamic-form-elements.php';

require_once $functions . '_pre_get_posts.php';

require_once $functions . '_custom-functions.php';

// require_once $functions . '_custom_post_types.php';

require_once $functions . '_tinymce.php';

require_once $functions . '_elementor-shapes.php';

require_once $functions . '_shortcode.php';

require_once $functions . '_icon-library.php';

require_once $functions . '_csf_filter_code.php';

/**
 * Elementor add on
 */

$eleDIR = dirname(__FILE__) . '/elementor-addon/';

require_once $eleDIR . '/elementor-addon.php';

/**
 * questions CPT
 */

require_once dirname(__FILE__) . '/questions-cpt/question.php';

/**
 * shortcodes
 */

$sDIR = dirname(__FILE__) . '/shortcodes/';

require_once $sDIR . '/_form-filter.php';

require_once $sDIR . '/_utils.php';

require_once $sDIR . '/_event-single.php';

require_once $sDIR . '/_blog-single.php';
