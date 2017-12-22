<?php

/** Constants */
defined('THEME_URI') || define('THEME_URI', get_template_directory_uri());
defined('THEME_PATH') || define('THEME_PATH', realpath(__DIR__));

include_once THEME_PATH . '/includes/functions.php';
require_once THEME_PATH . '/includes/register-sidebar.php';

// Constants
defined('DISALLOW_FILE_EDIT') || define('DISALLOW_FILE_EDIT', FALSE);
defined('TEXT_DOMAIN') || define('TEXT_DOMAIN', 'jp-basic');
define('JPB_THEME_PATH', realpath(__DIR__));


//include_once __DIR__ . '/includes/register-script.php';
include_once __DIR__ . '/includes/register-script-local.php';
include_once __DIR__ . '/includes/register-style.php';

//include_once __DIR__ . '/includes/register-style-local.php';

/*
  Favicon Admin
 */

function favicon() {
    echo '<link rel="shortcut icon" href="', get_template_directory_uri(), '/favicon.ico" />', "\n";
}

add_action('admin_head', 'favicon');

/**
 * Add scripts and styles to all Admin pages
 */
function jscustom_admin_scripts() {
    wp_enqueue_media();
    wp_register_script('custom-upload', get_template_directory_uri() . '/js/media-uploader.js', array('jquery'));
    wp_enqueue_script('custom-upload');
}

add_action('admin_print_scripts', 'jscustom_admin_scripts');

//Theme settings
require(get_template_directory() . '/inc/theme-options.php');

add_action('wp_enqueue_scripts', function () {

    /* Styles */
    wp_enqueue_style('bootstrap');
    wp_enqueue_style('animate');
    wp_enqueue_style('hover');
    wp_enqueue_style('font-awesome');
    // Theme
    wp_enqueue_style('main-theme');

    /* Scripts */
    wp_enqueue_script('modernizr');
    wp_enqueue_script('jquery');
    wp_enqueue_script('bootstrap');
    wp_enqueue_script('jquery-form');

    // Bootstrap Alerts
    wp_register_script('bootstrap-alerts', apply_filters('js_cdn_uri', THEME_URI . '/js/bootstrap-alerts.min.js', 'bootstrap-alerts'), array('jquery', 'bootstrap'), NULL, TRUE);
    wp_enqueue_script('bootstrap-alerts');


    // Add defer atribute
    do_action('defer_script', array('jquery-form', 'bootstrap-alerts'));

    // Bootstrap complemetary text align
    wp_register_style('bs-text-align', THEME_URI . '/css/bootstrap-text-align.min.css', array('bootstrap'), '1.0');
    wp_enqueue_style('bs-text-align');

    // Wordpress Core
    wp_register_style('wordpress-core', THEME_URI . '/css/wordpress-core.min.css', array('bootstrap', 'bs-text-align'), '1.0');
    wp_enqueue_style('wordpress-core');

    if (is_child_theme()) {
        // Theme
        wp_register_style('theme', get_stylesheet_uri(), array('animate'), '1.0');
        wp_enqueue_style('theme');
    }
});

include_once __DIR__ . '/includes/theme-features.php';

/**
 * Encoded Mailto Link
 *
 * Create a spam-protected mailto link written in Javascript
 *
 * @param	string	the email address
 * @param	string	the link title
 * @param	mixed	any attributes
 * @return	string
 */
function safe_mailto($email, $title = '', $attributes = '') {
    $title = (string) $title;

    if ($title === '') {
        $title = $email;
    }

    $x = str_split('<a href="mailto:', 1);

    for ($i = 0, $l = strlen($email); $i < $l; $i++) {
        $x[] = '|' . ord($email[$i]);
    }

    $x[] = '"';

    if ($attributes !== '') {
        if (is_array($attributes)) {
            foreach ($attributes as $key => $val) {
                $x[] = ' ' . $key . '="';
                for ($i = 0, $l = strlen($val); $i < $l; $i++) {
                    $x[] = '|' . ord($val[$i]);
                }
                $x[] = '"';
            }
        } else {
            for ($i = 0, $l = strlen($attributes); $i < $l; $i++) {
                $x[] = $attributes[$i];
            }
        }
    }

    $x[] = '>';

    $temp = array();
    for ($i = 0, $l = strlen($title); $i < $l; $i++) {
        $ordinal = ord($title[$i]);

        if ($ordinal < 128) {
            $x[] = '|' . $ordinal;
        } else {
            if (count($temp) === 0) {
                $count = ($ordinal < 224) ? 2 : 3;
            }

            $temp[] = $ordinal;
            if (count($temp) === $count) {
                $number = ($count === 3) ? (($temp[0] % 16) * 4096) + (($temp[1] % 64) * 64) + ($temp[2] % 64) : (($temp[0] % 32) * 64) + ($temp[1] % 64);
                $x[] = '|' . $number;
                $count = 1;
                $temp = array();
            }
        }
    }

    $x[] = '<';
    $x[] = '/';
    $x[] = 'a';
    $x[] = '>';

    $x = array_reverse($x);

    $output = "<script type=\"text/javascript\">\n"
            . "\t//<![CDATA[\n"
            . "\tvar l=new Array();\n";

    for ($i = 0, $c = count($x); $i < $c; $i++) {
        $output .= "\tl[" . $i . "] = '" . $x[$i] . "';\n";
    }

    $output .= "\n\tfor (var i = l.length-1; i >= 0; i=i-1) {\n"
            . "\t\tif (l[i].substring(0, 1) === '|') document.write(\"&#\"+unescape(l[i].substring(1))+\";\");\n"
            . "\t\telse document.write(unescape(l[i]));\n"
            . "\t}\n"
            . "\t//]]>\n"
            . '</script>';

    return $output;
}

require_once __DIR__ . '/admin/admin.php';

// Register Custom Navigation Walker
require_once('wp_bootstrap_navwalker.php');

class Custom_Walker extends Walker_Nav_Menu {

    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        global $wp_query;
        $indent = ( $depth > 0 ? str_repeat("\t", $depth) : '' ); // code indent
        // depth dependent classes
        $depth_classes = array(
            ( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
            ( $depth >= 2 ? 'sub-sub-menu-item' : '' ),
            ( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
            'menu-item-depth-' . $depth
        );
        $depth_class_names = esc_attr(implode(' ', $depth_classes));

        // passed classes
        $classes = empty($item->classes) ? array() : (array) $item->classes;

        if (!in_array($item->object, array('custom'))) {
            $post_data = get_post($item->object_id);
            $classes[] = $post_data->post_type . '-' . $post_data->post_name;
        }

        $class_names = esc_attr(implode(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item)));

        // build html
        $output .= $indent . '<li id="nav-menu-item-' . $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';

        // link attributes
        $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
        $attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';

        $item_output = sprintf('%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s', $args->before, $attributes, $args->link_before, apply_filters('the_title', $item->title, $item->ID), $args->link_after, $args->after
        );

        // build html
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

}

// Here go metabox

function rw_register_meta_box() {
    if (!class_exists('RW_Meta_Box') or ! is_admin())
        return;
    $post_ID = !empty($_POST['post_ID']) ?
            $_POST['post_ID'] :
            (!empty($_GET['post']) ? $_GET['post'] : FALSE);

    $post_name = '';
    if ($post_ID) {
        $current_post = get_post($post_ID);
        if ($current_post) {
            $current_post_type = $current_post->post_type;
            $post_name = $current_post->post_name;
        } else {
            $post_name = '';
        }
    }

    if ($post_name == 'home') {
        $meta_box[] = array(
            'title' => ('Container Gray - Home'),
            'pages' => array('page'),
            'fields' => array(
                array(
                    'id' => 'content_box_gray',
                    'type' => 'wysiwyg',
                )
            )
        );
        $meta_box[] = array(
            'title' => 'Boxes',
            'pages' => array('page'),
            'fields' => array(
                array(
                    'id' => 'boxes_group',
                    'type' => 'group',
                    'clone' => true,
                    'sort_clone' => true,
                    'fields' => array(
                        array(
                            'name' => 'Icon',
                            'id' => 'image_box',
                            'type' => 'image_advanced',
                            'max_file_uploads' => 1,
                        ),
                        array(
                            'name' => 'Title',
                            'id' => 'title_box',
                            'type' => 'text',
                        ),
                        array(
                            'name' => 'Url',
                            'id' => 'url_box',
                            'type' => 'text',
                        ),
                    ),
                ),
            ),
        );
    }

    if ($post_name == 'solution') {
        $meta_box[] = array(
            'title' => 'Boxes',
            'pages' => array('page'),
            'fields' => array(
                array(
                    'id' => 'boxes_group_solution',
                    'type' => 'group',
                    'clone' => true,
                    'sort_clone' => true,
                    'fields' => array(
                        array(
                            'name' => 'Image',
                            'id' => 'image_box_solution',
                            'type' => 'image_advanced',
                            'max_file_uploads' => 1,
                        ),
                        array(
                            'name' => 'Title',
                            'id' => 'title_box_solution',
                            'type' => 'text',
                        ),
                        array(
                            'name' => 'Description',
                            'id' => 'description_box_solution',
                            'type' => 'wysiwyg',
                        ),
                        array(
                            'name' => 'Order',
                            'id' => 'order_option',
                            'type' => 'select',
                            'options' => array(
                                'img_text' => 'Image/Text',
                                'text_img' => 'Text/Image',
                            ),
                        ),
                        array(
                            'name' => 'Invert in Mobile',
                            'id' => 'invert_option',
                            'type' => 'select',
                            'options' => array(
                                'No' => 'No',
                                'Yes' => 'Yes',
                            ),
                        ),
                    ),
                ),
            ),
        );
    }

    if ($post_name == 'about-us') {
        $meta_box[] = array(
            'title' => 'Timeline',
            'pages' => array('page'),
            'fields' => array(
                array(
                    'id' => 'boxes_timeline',
                    'type' => 'group',
                    'clone' => true,
                    'sort_clone' => true,
                    'fields' => array(
                        array(
                            'name' => 'Title',
                            'id' => 'title_timeline',
                            'type' => 'text',
                        ),
                        array(
                            'name' => 'Year',
                            'id' => 'description_timeline',
                            'type' => 'text',
                        )
                    ),
                ),
            ),
        );
    }

    $meta_box[] = array(
        'title' => ('Title Position'),
        'pages' => array('team'),
        'fields' => array(
            array(
                'id' => 'title_position',
                'type' => 'text',
            )
        )
    );

    if ($post_name == 'learn') {
        $meta_box[] = array(
            'id' => 'img_items',
            'title' => 'Image',
            'pages' => array('page'),
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'name' => 'Image',
                    'id' => 'img-right',
                    'type' => 'image_advanced',
                    'max_file_uploads' => 1,
                ),
        ));
    }


    $meta_box[] = array(
        'id' => 'id_videos',
        'title' => 'ID Video',
        'pages' => array('videos'),
        'context' => 'normal',
        'priority' => 'high',
        'fields' => array(
            array(
                'id' => 'id_video_url',
                'type' => 'text',
            )
    ));


    if (is_array($meta_box)) {
        foreach ($meta_box as $value) {
            new RW_Meta_Box($value);
        }
    }
}

add_action('wp_ajax_rwmb_reorder_images', array("RWMB_Image_Field", 'wp_ajax_reorder_images'));
add_action('wp_ajax_rwmb_delete_file', array("RWMB_File_Field", 'wp_ajax_delete_file'));
add_action('wp_ajax_rwmb_attach_media', array("RWMB_Image_Advanced_Field", 'wp_ajax_attach_media'));
add_action('admin_init', 'rw_register_meta_box');

function register_my_menu() {
    register_nav_menu('useful-links', __('Useful Links'));
    register_nav_menu('others-links', __('Others Links'));
}

add_action('init', 'register_my_menu');

// Register Custom Post Type
function custom_team() {

    $labels = array(
        'name' => _x('Teams', 'Post Type General Name', 'jp-basic'),
        'singular_name' => _x('Team', 'Post Type Singular Name', 'jp-basic'),
        'menu_name' => __('Team', 'jp-basic'),
        'name_admin_bar' => __('Team', 'jp-basic'),
        'archives' => __('Item Archives', 'jp-basic'),
        'attributes' => __('Item Attributes', 'jp-basic'),
        'parent_item_colon' => __('Parent Item:', 'jp-basic'),
        'all_items' => __('All Items', 'jp-basic'),
        'add_new_item' => __('Add New Item', 'jp-basic'),
        'add_new' => __('Add New', 'jp-basic'),
        'new_item' => __('New Item', 'jp-basic'),
        'edit_item' => __('Edit Item', 'jp-basic'),
        'update_item' => __('Update Item', 'jp-basic'),
        'view_item' => __('View Item', 'jp-basic'),
        'view_items' => __('View Items', 'jp-basic'),
        'search_items' => __('Search Item', 'jp-basic'),
        'not_found' => __('Not found', 'jp-basic'),
        'not_found_in_trash' => __('Not found in Trash', 'jp-basic'),
        'featured_image' => __('Featured Image', 'jp-basic'),
        'set_featured_image' => __('Set featured image', 'jp-basic'),
        'remove_featured_image' => __('Remove featured image', 'jp-basic'),
        'use_featured_image' => __('Use as featured image', 'jp-basic'),
        'insert_into_item' => __('Insert into item', 'jp-basic'),
        'uploaded_to_this_item' => __('Uploaded to this item', 'jp-basic'),
        'items_list' => __('Items list', 'jp-basic'),
        'items_list_navigation' => __('Items list navigation', 'jp-basic'),
        'filter_items_list' => __('Filter items list', 'jp-basic'),
    );
    $args = array(
        'label' => __('Team', 'jp-basic'),
        'labels' => $labels,
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail',),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-admin-users',
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'page',
    );
    register_post_type('team', $args);
}

add_action('init', 'custom_team', 0);

// Register Custom Taxonomy
function custom_support_categories() {

    $labels = array(
        'name' => _x('Categories', 'Taxonomy General Name', 'jp-basic'),
        'singular_name' => _x('Category', 'Taxonomy Singular Name', 'jp-basic'),
        'menu_name' => __('Categories', 'jp-basic'),
        'all_items' => __('All Items', 'jp-basic'),
        'parent_item' => __('Parent Item', 'jp-basic'),
        'parent_item_colon' => __('Parent Item:', 'jp-basic'),
        'new_item_name' => __('New Item Name', 'jp-basic'),
        'add_new_item' => __('Add New Item', 'jp-basic'),
        'edit_item' => __('Edit Item', 'jp-basic'),
        'update_item' => __('Update Item', 'jp-basic'),
        'view_item' => __('View Item', 'jp-basic'),
        'separate_items_with_commas' => __('Separate items with commas', 'jp-basic'),
        'add_or_remove_items' => __('Add or remove items', 'jp-basic'),
        'choose_from_most_used' => __('Choose from the most used', 'jp-basic'),
        'popular_items' => __('Popular Items', 'jp-basic'),
        'search_items' => __('Search Items', 'jp-basic'),
        'not_found' => __('Not Found', 'jp-basic'),
        'no_terms' => __('No items', 'jp-basic'),
        'items_list' => __('Items list', 'jp-basic'),
        'items_list_navigation' => __('Items list navigation', 'jp-basic'),
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => true,
    );
    register_taxonomy('categories', array('support_items'), $args);
}

add_action('init', 'custom_support_categories', 0);

// Register Custom Post Type
function custom_support_items() {

    $labels = array(
        'name' => _x('Support', 'Post Type General Name', 'jp-basic'),
        'singular_name' => _x('Support', 'Post Type Singular Name', 'jp-basic'),
        'menu_name' => __('Support', 'jp-basic'),
        'name_admin_bar' => __('Support', 'jp-basic'),
        'archives' => __('Item Archives', 'jp-basic'),
        'attributes' => __('Item Attributes', 'jp-basic'),
        'parent_item_colon' => __('Parent Item:', 'jp-basic'),
        'all_items' => __('All Items', 'jp-basic'),
        'add_new_item' => __('Add New Item', 'jp-basic'),
        'add_new' => __('Add New', 'jp-basic'),
        'new_item' => __('New Item', 'jp-basic'),
        'edit_item' => __('Edit Item', 'jp-basic'),
        'update_item' => __('Update Item', 'jp-basic'),
        'view_item' => __('View Item', 'jp-basic'),
        'view_items' => __('View Items', 'jp-basic'),
        'search_items' => __('Search Item', 'jp-basic'),
        'not_found' => __('Not found', 'jp-basic'),
        'not_found_in_trash' => __('Not found in Trash', 'jp-basic'),
        'featured_image' => __('Featured Image', 'jp-basic'),
        'set_featured_image' => __('Set featured image', 'jp-basic'),
        'remove_featured_image' => __('Remove featured image', 'jp-basic'),
        'use_featured_image' => __('Use as featured image', 'jp-basic'),
        'insert_into_item' => __('Insert into item', 'jp-basic'),
        'uploaded_to_this_item' => __('Uploaded to this item', 'jp-basic'),
        'items_list' => __('Items list', 'jp-basic'),
        'items_list_navigation' => __('Items list navigation', 'jp-basic'),
        'filter_items_list' => __('Filter items list', 'jp-basic'),
    );
    $args = array(
        'label' => __('Support', 'jp-basic'),
        'description' => __('Post Type Description', 'jp-basic'),
        'labels' => $labels,
        'supports' => array('title', 'editor',),
        'taxonomies' => array('dd'),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-sos',
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'page',
    );
    register_post_type('support_items', $args);
}

add_action('init', 'custom_support_items', 0);

// Register Custom Taxonomy
function custom_learn_categories() {

    $labels = array(
        'name' => _x('Categories', 'Taxonomy General Name', 'jp-basic'),
        'singular_name' => _x('Category', 'Taxonomy Singular Name', 'jp-basic'),
        'menu_name' => __('Categories', 'jp-basic'),
        'all_items' => __('All Items', 'jp-basic'),
        'parent_item' => __('Parent Item', 'jp-basic'),
        'parent_item_colon' => __('Parent Item:', 'jp-basic'),
        'new_item_name' => __('New Item Name', 'jp-basic'),
        'add_new_item' => __('Add New Item', 'jp-basic'),
        'edit_item' => __('Edit Item', 'jp-basic'),
        'update_item' => __('Update Item', 'jp-basic'),
        'view_item' => __('View Item', 'jp-basic'),
        'separate_items_with_commas' => __('Separate items with commas', 'jp-basic'),
        'add_or_remove_items' => __('Add or remove items', 'jp-basic'),
        'choose_from_most_used' => __('Choose from the most used', 'jp-basic'),
        'popular_items' => __('Popular Items', 'jp-basic'),
        'search_items' => __('Search Items', 'jp-basic'),
        'not_found' => __('Not Found', 'jp-basic'),
        'no_terms' => __('No items', 'jp-basic'),
        'items_list' => __('Items list', 'jp-basic'),
        'items_list_navigation' => __('Items list navigation', 'jp-basic'),
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => true,
    );
    register_taxonomy('categories', array('learn_items'), $args);
}

add_action('init', 'custom_learn_categories', 0);

// Register Custom Post Type
function custom_learn_items() {

    $labels = array(
        'name' => _x('Learn', 'Post Type General Name', 'jp-basic'),
        'singular_name' => _x('Learn', 'Post Type Singular Name', 'jp-basic'),
        'menu_name' => __('Learn', 'jp-basic'),
        'name_admin_bar' => __('Learn', 'jp-basic'),
        'archives' => __('Item Archives', 'jp-basic'),
        'attributes' => __('Item Attributes', 'jp-basic'),
        'parent_item_colon' => __('Parent Item:', 'jp-basic'),
        'all_items' => __('All Items', 'jp-basic'),
        'add_new_item' => __('Add New Item', 'jp-basic'),
        'add_new' => __('Add New', 'jp-basic'),
        'new_item' => __('New Item', 'jp-basic'),
        'edit_item' => __('Edit Item', 'jp-basic'),
        'update_item' => __('Update Item', 'jp-basic'),
        'view_item' => __('View Item', 'jp-basic'),
        'view_items' => __('View Items', 'jp-basic'),
        'search_items' => __('Search Item', 'jp-basic'),
        'not_found' => __('Not found', 'jp-basic'),
        'not_found_in_trash' => __('Not found in Trash', 'jp-basic'),
        'featured_image' => __('Featured Image', 'jp-basic'),
        'set_featured_image' => __('Set featured image', 'jp-basic'),
        'remove_featured_image' => __('Remove featured image', 'jp-basic'),
        'use_featured_image' => __('Use as featured image', 'jp-basic'),
        'insert_into_item' => __('Insert into item', 'jp-basic'),
        'uploaded_to_this_item' => __('Uploaded to this item', 'jp-basic'),
        'items_list' => __('Items list', 'jp-basic'),
        'items_list_navigation' => __('Items list navigation', 'jp-basic'),
        'filter_items_list' => __('Filter items list', 'jp-basic'),
    );
    $args = array(
        'label' => __('Learn', 'jp-basic'),
        'description' => __('Post Type Description', 'jp-basic'),
        'labels' => $labels,
        'supports' => array('title', 'editor',),
        'taxonomies' => array('dd'),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-media-text',
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'page',
    );
    register_post_type('learn_items', $args);
}

add_action('init', 'custom_learn_items', 0);

// Register Custom Post Type
function custom_videos() {

    $labels = array(
        'name' => _x('Videos', 'Post Type General Name', 'jp-basic'),
        'singular_name' => _x('Video', 'Post Type Singular Name', 'jp-basic'),
        'menu_name' => __('Videos', 'jp-basic'),
        'name_admin_bar' => __('Videos', 'jp-basic'),
        'archives' => __('Item Archives', 'jp-basic'),
        'attributes' => __('Item Attributes', 'jp-basic'),
        'parent_item_colon' => __('Parent Item:', 'jp-basic'),
        'all_items' => __('All Items', 'jp-basic'),
        'add_new_item' => __('Add New Item', 'jp-basic'),
        'add_new' => __('Add New', 'jp-basic'),
        'new_item' => __('New Item', 'jp-basic'),
        'edit_item' => __('Edit Item', 'jp-basic'),
        'update_item' => __('Update Item', 'jp-basic'),
        'view_item' => __('View Item', 'jp-basic'),
        'view_items' => __('View Items', 'jp-basic'),
        'search_items' => __('Search Item', 'jp-basic'),
        'not_found' => __('Not found', 'jp-basic'),
        'not_found_in_trash' => __('Not found in Trash', 'jp-basic'),
        'featured_image' => __('Featured Image', 'jp-basic'),
        'set_featured_image' => __('Set featured image', 'jp-basic'),
        'remove_featured_image' => __('Remove featured image', 'jp-basic'),
        'use_featured_image' => __('Use as featured image', 'jp-basic'),
        'insert_into_item' => __('Insert into item', 'jp-basic'),
        'uploaded_to_this_item' => __('Uploaded to this item', 'jp-basic'),
        'items_list' => __('Items list', 'jp-basic'),
        'items_list_navigation' => __('Items list navigation', 'jp-basic'),
        'filter_items_list' => __('Filter items list', 'jp-basic'),
    );
    $args = array(
        'label' => __('Video', 'jp-basic'),
        'description' => __('Videos', 'jp-basic'),
        'labels' => $labels,
        'supports' => array('title',),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-video-alt3',
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'page',
    );
    register_post_type('videos', $args);
}

add_action('init', 'custom_videos', 0);

@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );

// Register Custom Taxonomy
function custom_courses() {

	$labels = array(
		'name'                       => _x( 'Courses', 'Taxonomy General Name', 'jp-basic' ),
		'singular_name'              => _x( 'Course', 'Taxonomy Singular Name', 'jp-basic' ),
		'menu_name'                  => __( 'Courses', 'jp-basic' ),
		'all_items'                  => __( 'All Items', 'jp-basic' ),
		'parent_item'                => __( 'Parent Item', 'jp-basic' ),
		'parent_item_colon'          => __( 'Parent Item:', 'jp-basic' ),
		'new_item_name'              => __( 'New Item Name', 'jp-basic' ),
		'add_new_item'               => __( 'Add New Item', 'jp-basic' ),
		'edit_item'                  => __( 'Edit Item', 'jp-basic' ),
		'update_item'                => __( 'Update Item', 'jp-basic' ),
		'view_item'                  => __( 'View Item', 'jp-basic' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'jp-basic' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'jp-basic' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'jp-basic' ),
		'popular_items'              => __( 'Popular Items', 'jp-basic' ),
		'search_items'               => __( 'Search Items', 'jp-basic' ),
		'not_found'                  => __( 'Not Found', 'jp-basic' ),
		'no_terms'                   => __( 'No items', 'jp-basic' ),
		'items_list'                 => __( 'Items list', 'jp-basic' ),
		'items_list_navigation'      => __( 'Items list navigation', 'jp-basic' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'courses', array( 'lessons' ), $args );

}
add_action( 'init', 'custom_courses', 0 );

// Register Custom Post Type
function custom_lessons() {

	$labels = array(
		'name'                  => _x( 'Lessons', 'Post Type General Name', 'jp-basic' ),
		'singular_name'         => _x( 'Lesson', 'Post Type Singular Name', 'jp-basic' ),
		'menu_name'             => __( 'Lessons', 'jp-basic' ),
		'name_admin_bar'        => __( 'Lessons', 'jp-basic' ),
		'archives'              => __( 'Item Archives', 'jp-basic' ),
		'attributes'            => __( 'Item Attributes', 'jp-basic' ),
		'parent_item_colon'     => __( 'Parent Item:', 'jp-basic' ),
		'all_items'             => __( 'All Items', 'jp-basic' ),
		'add_new_item'          => __( 'Add New Item', 'jp-basic' ),
		'add_new'               => __( 'Add New', 'jp-basic' ),
		'new_item'              => __( 'New Item', 'jp-basic' ),
		'edit_item'             => __( 'Edit Item', 'jp-basic' ),
		'update_item'           => __( 'Update Item', 'jp-basic' ),
		'view_item'             => __( 'View Item', 'jp-basic' ),
		'view_items'            => __( 'View Items', 'jp-basic' ),
		'search_items'          => __( 'Search Item', 'jp-basic' ),
		'not_found'             => __( 'Not found', 'jp-basic' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'jp-basic' ),
		'featured_image'        => __( 'Featured Image', 'jp-basic' ),
		'set_featured_image'    => __( 'Set featured image', 'jp-basic' ),
		'remove_featured_image' => __( 'Remove featured image', 'jp-basic' ),
		'use_featured_image'    => __( 'Use as featured image', 'jp-basic' ),
		'insert_into_item'      => __( 'Insert into item', 'jp-basic' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'jp-basic' ),
		'items_list'            => __( 'Items list', 'jp-basic' ),
		'items_list_navigation' => __( 'Items list navigation', 'jp-basic' ),
		'filter_items_list'     => __( 'Filter items list', 'jp-basic' ),
	);
	$args = array(
		'label'                 => __( 'Lesson', 'jp-basic' ),
		'description'           => __( 'Post Type Description', 'jp-basic' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'trackbacks', 'revisions', 'page-attributes', 'post-formats', ),
		'taxonomies'            => array( 'courses' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-index-card',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'lessons', $args );

}
add_action( 'init', 'custom_lessons', 0 );