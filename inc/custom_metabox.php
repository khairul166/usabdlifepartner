<?php

function add_marriage_date_meta_box() {
    add_meta_box(
        'marriage_date_meta_box', // ID of the meta box
        'Marriage Date', // Title of the meta box
        'render_marriage_date_meta_box', // Callback function to render the meta box
        'success_story', // Post type
        'side', // Context (normal, side, advanced)
        'default' // Priority (high, core, default, low)
    );
}
add_action('add_meta_boxes', 'add_marriage_date_meta_box');

function render_marriage_date_meta_box($post) {
    // Retrieve the current value of the marriage date
    $marriage_date = get_post_meta($post->ID, '_marriage_date', true);

    // Add a nonce field for security
    wp_nonce_field('marriage_date_nonce_action', 'marriage_date_nonce');

    // Display the input field
    echo '<label for="marriage_date">Marriage Date:</label>';
    echo '<input type="date" id="marriage_date" name="marriage_date" value="' . esc_attr($marriage_date) . '" />';
}


function save_marriage_date_meta($post_id) {
    // Check if the nonce is set and valid
    if (!isset($_POST['marriage_date_nonce']) || !wp_verify_nonce($_POST['marriage_date_nonce'], 'marriage_date_nonce_action')) {
        return;
    }

    // Check if the current user has permission to edit the post
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save the marriage date
    if (isset($_POST['marriage_date'])) {
        update_post_meta($post_id, '_marriage_date', sanitize_text_field($_POST['marriage_date']));
    }
}
add_action('save_post', 'save_marriage_date_meta');