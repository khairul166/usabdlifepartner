<?php
// enqueue.php

function matrimonials_enqueue_styles() {
    // Enqueue Bootstrap CSS
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '5.3.0');

    // Enqueue Global CSS
    wp_enqueue_style('global', get_template_directory_uri() . '/css/global.css', array(), '1.0.0');

    // Enqueue Index CSS
    wp_enqueue_style('index', get_template_directory_uri() . '/css/index.css', array(), '1.0.0');

    // Enqueue Google Fonts
    wp_enqueue_style('roboto-font', 'https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap', array(), null);
    wp_enqueue_style('poppins-font', 'https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap', array(), null);
    wp_enqueue_style('lexend-font', 'https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap', array(), null);

    // Enqueue Bootstrap Icons
    wp_enqueue_style('bootstrap-icons', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css', array(), '1.11.3');

    // Enqueue Slick Carousel CSS
    wp_enqueue_style('slick-carousel', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css', array(), '1.8.1');
    wp_enqueue_style('slick-carousel-theme', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css', array(), '1.8.1');

    // Enqueue Lightbox2 CSS
    wp_enqueue_style('lightbox2', 'https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css', array(), '2.11.3');
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css', array(), '6.0.0-beta3');
    wp_enqueue_style('cropper-css', 'https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css', array(), '6.0.0-beta3');
}
add_action('wp_enqueue_scripts', 'matrimonials_enqueue_styles');

function theme_scripts() {
    // Enqueue Bootstrap JS
    wp_enqueue_script(
        'bootstrap-bundle',
        get_template_directory_uri() . '/js/bootstrap.bundle.min.js',
        array(), // Dependencies (none in this case)
        '5.3.0', // Version number (update as needed)
        true // Load in footer
    );
    // wp_enqueue_script(
    //     'spinner-js',
    //     get_template_directory_uri() . '/js/spinner.js',
    //     array(), // Dependencies (none in this case)
    //     '1.0.0', // Version number (update as needed)
    //     true // Load in footer
    // );

    // Enqueue Theme JS
    wp_enqueue_script(
        'theme-js',
        get_template_directory_uri() . '/js/theme.min.js',
        array(), // Dependencies
        '1.0.0', // Version number
        true // Load in footer
    );
    // Enqueue Theme JS
    wp_enqueue_script(
        'cropprofilepic-js',
        get_template_directory_uri() . '/js/cropprofilepic.js',
        array(), // Dependencies
        '1.0.0', // Version number
        true // Load in footer
    );

       // Enqueue Theme JS
       wp_enqueue_script(
        'register-js',
        get_template_directory_uri() . '/js/register.js',
        array(), // Dependencies
        '1.0.0', // Version number
        true // Load in footer
    );

    // Enqueue Custom JS
    wp_enqueue_script(
        'custom-js',
        get_template_directory_uri() . '/js/custom.js',
        array('jquery'), // Dependencies (jQuery)
        '1.0.0', // Version number
        true // Load in footer
    );

    
    // Enqueue Custom JS
    wp_enqueue_script(
        'address-js',
        get_template_directory_uri() . '/js/address.js',
        array('jquery'), // Dependencies (jQuery)
        '1.0.0', // Version number
        true // Load in footer
    );

    // Localize script to pass data from PHP to JavaScript
    wp_localize_script(
        'custom-address-script', // Handle
        'addressData', // JavaScript object name
        array(
            'ajax_url' => admin_url('admin-ajax.php'), // AJAX URL
            'data_file' => get_template_directory_uri() . '/js/address.js' // Path to your JSON file
        )
    );

    // Enqueue Flowbite JS (from CDN)
    wp_enqueue_script(
        'flowbite-js',
        'https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js',
        array(), // Dependencies
        '3.1.2', // Version number
        true // Load in footer
    );

    // Enqueue jQuery (from CDN)
    wp_enqueue_script(
        'jquery-cdn',
        'https://code.jquery.com/jquery-3.6.0.min.js',
        array(), // Dependencies
        '3.6.0', // Version number
        true // Load in footer
    );

    // Enqueue Slick Slider JS (from CDN)
    wp_enqueue_script(
        'slick-slider',
        'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js',
        array('jquery'), // Dependencies (jQuery)
        '1.8.1', // Version number
        true // Load in footer
    );
    // Enqueue Slick Slider JS (from CDN)
    wp_enqueue_script(
        'bootstrap-foursixtwo',
        'https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js',
        array('jquery'), // Dependencies (jQuery)
        '1.8.1', // Version number
        true // Load in footer
    );
    wp_enqueue_script(
        'lightbox-js',
        'https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js',
        array('jquery'), // Dependencies (jQuery)
        '1.8.1', // Version number
        true // Load in footer
    );
    wp_enqueue_script(
        'cropper-js',
        'https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js',
        array('jquery'), // Dependencies (jQuery)
        '1.8.1', // Version number
        true // Load in footer
    );

    // Enqueue Slider JS (local file)
    wp_enqueue_script(
        'slider-js',
        get_template_directory_uri() . '/js/slider.js',
        array('jquery', 'slick-slider'), // Dependencies (jQuery and Slick Slider)
        '1.0.0', // Version number
        true // Load in footer
    );

    // Inline script for Back to Top Button
    wp_add_inline_script(
        'custom-js', // Attach to custom-js
        '
        jQuery(document).ready(function($) {
            var btn = $("#bctbutton");

            $(window).scroll(function() {
                if ($(window).scrollTop() > 300) {
                    btn.addClass("show");
                } else {
                    btn.removeClass("show");
                }
            });

            btn.on("click", function(e) {
                e.preventDefault();
                $("html, body").animate({scrollTop:0}, "300");
            });
        });
        '
    );
}
add_action('wp_enqueue_scripts', 'theme_scripts');


// Enqueue AJAX script for live search
function enqueue_matrimonial_search_script() {
    wp_enqueue_script('matrimonial-ajax', get_template_directory_uri() . '/js/matrimonial-ajax.js', array('jquery'), null, true);
    wp_localize_script('matrimonial-ajax', 'matrimonial_search_params', array(
        'ajax_url' => admin_url('admin-ajax.php'), // URL for AJAX requests
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_matrimonial_search_script');

function enqueue_interest_scripts() {
    wp_enqueue_script('interest-js', get_template_directory_uri() . '/js/interest.js', array('jquery'), null, true);
    wp_localize_script('interest-js', 'interest_ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('send_interest_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_interest_scripts');

