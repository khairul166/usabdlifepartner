<?php

// Step 1: Create the Admin Menu
function theme_settings_menu() {
    add_menu_page(
        'Theme Settings', // Page title
        'Theme Settings', // Menu title
        'manage_options', // Capability required to access
        'theme-settings', // Menu slug
        'theme_settings_page', // Callback function to display the page
        'dashicons-admin-generic', // Icon (optional)
        99 // Menu position (optional)
    );
}
add_action('admin_menu', 'theme_settings_menu');

// Step 2: Create the Settings Page
function theme_settings_page() {
    ?>
    <div class="wrap">
        <h1>Theme Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('theme_settings_group'); // Settings group name
            do_settings_sections('theme-settings'); // Page slug
            submit_button(); // Save changes button
            ?>
        </form>
    </div>
    <?php
}

// Step 3: Register Settings, Sections, and Fields
function theme_settings_init() {
    // Register a setting
    register_setting(
        'theme_settings_group', // Settings group name
        'theme_settings', // Option name
        'theme_settings_sanitize' // Sanitization callback (optional)
    );

    // Add a settings section
    add_settings_section(
        'theme_settings_section', // Section ID
        'General Settings', // Section title
        'theme_settings_section_callback', // Callback function (optional)
        'theme-settings' // Page slug
    );

    // Add a settings field
    add_settings_field(
        'theme_setting_field_1', // Field ID
        'Setting Field 1', // Field title
        'theme_setting_field_1_callback', // Callback function
        'theme-settings', // Page slug
        'theme_settings_section' // Section ID
    );

    // Add another settings field (example)
    add_settings_field(
        'theme_setting_field_2', // Field ID
        'Setting Field 2', // Field title
        'theme_setting_field_2_callback', // Callback function
        'theme-settings', // Page slug
        'theme_settings_section' // Section ID
    );
}
add_action('admin_init', 'theme_settings_init');

// Step 4: Define Callback Functions
function theme_settings_section_callback() {
    echo '<p>Configure your theme settings here.</p>';
}

function theme_setting_field_1_callback() {
    $options = get_option('theme_settings');
    $value = isset($options['field_1']) ? $options['field_1'] : '';
    echo '<input type="text" name="theme_settings[field_1]" value="' . esc_attr($value) . '" class="regular-text">';
}

function theme_setting_field_2_callback() {
    $options = get_option('theme_settings');
    $value = isset($options['field_2']) ? $options['field_2'] : '';
    echo '<textarea name="theme_settings[field_2]" class="large-text">' . esc_textarea($value) . '</textarea>';
}

// Step 5: Sanitize Settings (Optional)
function theme_settings_sanitize($input) {
    $sanitized_input = array();

    if (isset($input['field_1'])) {
        $sanitized_input['field_1'] = sanitize_text_field($input['field_1']);
    }

    if (isset($input['field_2'])) {
        $sanitized_input['field_2'] = sanitize_textarea_field($input['field_2']);
    }

    return $sanitized_input;
}