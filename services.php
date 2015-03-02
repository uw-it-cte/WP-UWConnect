<?php
function service_post_type() {
    $labels = array(
        'name' => _x('Services', 'post type general name'),
        'singular_name' => _x('Service', 'post type signular name'),
        'add_new' => _x('Add New', 'service'),
        'add_new_item' => __('Add New Service'),
        'edit_item' => __('Edit Service'),
        'new_item' => __('New Service'),
        'all_items' => __('All Services'),
        'view_item' => __('View Service'),
        'search_items' => __('Search Services'),
        'not_found' => __('No Services Found'),
        'not_found_in_trash' => __('No Services found in the Trash'),
        'parent_item_colon' => ''
    );

    $args = array(
        'labels' => $labels,
        'description' => 'Holds our services and service sepecific data.',
        'public' => true,
        'capability_type' => 'page',
        'menu_position' => 5,
        'register_meta_box_cb' => '',
        'supports' => array('title'),
        'has_archive' => false,
        'hierarchical' => true
    );
    register_post_type('service', $args);
}

add_action('init', 'service_post_type');
?>
