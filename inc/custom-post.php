<?php

function create_carousel_post_type() {
    register_post_type('carousel',
        array(
            'labels'      => array(
                'name'          => __('Carousels', 'textdomain'),
                'singular_name' => __('Carousel', 'textdomain'),
                'add_new_item'  => __('Add New Slide', 'textdomain'),
                'edit_item'     => __('Edit Slide', 'textdomain'),
                'all_items'     => __('All Slides', 'textdomain'),
                'view_item'     => __('View Slide', 'textdomain'),
            ),
            'public'      => true,
            'has_archive' => false,
            'supports'    => array('title', 'thumbnail', 'editor'),
            'menu_icon'   => 'dashicons-images-alt2',
        )
    );
}
add_action('init', 'create_carousel_post_type');



function create_success_story_post_type() {
    register_post_type('success_story',
        array(
            'labels' => array(
                'name' => __('Success Stories'),
                'singular_name' => __('Success Story'),
                'add_new' => __('Add New'),
                'add_new_item' => __('Add New Success Story'),
                'edit_item' => __('Edit Success Story'),
                'new_item' => __('New Success Story'),
                'view_item' => __('View Success Story'),
                'search_items' => __('Search Success Stories'),
                'not_found' => __('No success stories found'),
                'not_found_in_trash' => __('No success stories found in Trash')
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'thumbnail'), // Corrected supports array
            'taxonomies' => array('success_story_tags'), // Add support for custom taxonomy
            'menu_icon' => 'dashicons-heart',
        )
    );
}
add_action('init', 'create_success_story_post_type');

function create_success_story_taxonomy() {
    register_taxonomy(
        'success_story_tags', // Taxonomy slug
        'success_story', // Custom post type
        array(
            'label' => __('Tags'),
            'rewrite' => array('slug' => 'success-story-tags'),
            'hierarchical' => false, // Set to true for categories, false for tags
        )
    );
}
add_action('init', 'create_success_story_taxonomy');