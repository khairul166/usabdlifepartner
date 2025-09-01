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
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');
    wp_enqueue_style('animate-style', 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css');
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


add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('jquery');

    // Enqueue both scripts
    wp_enqueue_script('interest-toggle', get_template_directory_uri() . '/js/interest-toggle.js', ['jquery'], '1.0', true);
    wp_enqueue_script('handle-interest', get_template_directory_uri() . '/js/handle-interest.js', ['jquery'], '1.0', true);

    // Shared AJAX config
    $ajax_config = [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('interest_nonce')
    ];

    // Localize to both scripts with SAME object name
    wp_localize_script('interest-toggle', 'interest_ajax', $ajax_config);
    wp_localize_script('handle-interest', 'interest_ajax', $ajax_config);
});




add_action('wp_enqueue_scripts', function () {
    // wp_enqueue_script('handle-interest', get_template_directory_uri() . '/js/handle-interest.js', ['jquery'], '1.0', true);

wp_localize_script('handle-interest', 'interest_ajax', [
    'ajax_url' => admin_url('admin-ajax.php'),
    'nonce'    => wp_create_nonce('interest_nonce')
]);
});

function kuki_enqueue_gallery_assets() {
    // Lightbox2 CSS
    wp_enqueue_style('lightbox2', 'https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css', [], '2.11.3');

    // Lightbox2 JS
    wp_enqueue_script('lightbox2', 'https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js', ['jquery'], '2.11.3', true);
}
add_action('wp_enqueue_scripts', 'kuki_enqueue_gallery_assets');
<<<<<<< HEAD


function enqueue_shortlist_script() {
    wp_enqueue_script('shortlist-js', get_template_directory_uri() . '/js/shortlist.js', ['jquery'], null, true);
    wp_localize_script('shortlist-js', 'my_ajax_object', [
        'ajax_url' => admin_url('admin-ajax.php')
    ]);
}
add_action('wp_enqueue_scripts', 'enqueue_shortlist_script');

function enqueue_custom_validation_scripts() {
    if(is_page('signup')){
        wp_enqueue_script(
            'plan-selection',
            get_template_directory_uri() . '/js/plan-selection.js',
            array('jquery'),
            '1.0',
            true
        );
    
        // Localize ajaxurl
        wp_localize_script('plan-selection', 'ajax_object', array(
            'ajax_url' => admin_url('admin-ajax.php')
        ));
    }

}
add_action('wp_enqueue_scripts', 'enqueue_custom_validation_scripts');



function usabdlp_enqueue_form_validation_js() {
    // Only load on register or login pages
    if (is_page('signup')) {
        wp_enqueue_script(
            'form-validation',
            get_template_directory_uri() . '/js/form-validation.js',
            array(),  // Dependencies (none required)
            '1.0',
            true // Load in footer
        );
        wp_enqueue_script(
            'signup-form-validation',
            get_template_directory_uri() . '/js/signup-form-validation.js',
            array(),  // Dependencies (none required)
            '1.0',
            true // Load in footer
        );
    }
}
add_action('wp_enqueue_scripts', 'usabdlp_enqueue_form_validation_js');

function usabdlp_enqueue_showhidepass_js() {
    // Only load on register or login pages
    if (is_page('signup') || is_page('login')) {
        wp_enqueue_script(
            'showhidepass',
            get_template_directory_uri() . '/js/showhidepass.js',
            array(),  // Dependencies (none required)
            '1.0',
            true // Load in footer
        );
    }
}
add_action('wp_enqueue_scripts', 'usabdlp_enqueue_showhidepass_js');

function usabdlp_load_dashicons_frontend() {
    wp_enqueue_style('dashicons');
}
add_action('wp_enqueue_scripts', 'usabdlp_load_dashicons_frontend');

function enqueue_payment_info_script() {
    // Enqueue the script only on the registration or checkout page
    if (is_page('signup') || is_page('checkout')) { // Change these conditions as needed
        wp_enqueue_script(
            'payment-info', // Handle for the script
            get_template_directory_uri() . '/js/payment-info.js', // Path to the JS file
            array('jquery'), // Dependencies (jQuery in this case, you can add more if needed)
            null, // Version (optional, use null to let WordPress handle it automatically)
            true // Load script in the footer (recommended for performance)
        );
    }
}
add_action('wp_enqueue_scripts', 'enqueue_payment_info_script');


function usabdlp_enqueue_admin_scripts($hook) {
    // Only load on your dashboard page
    if ($hook != 'toplevel_page_usabdlp-dashboard') {
        return;
    }

    // Enqueue WordPress's built-in jQuery
    wp_enqueue_script('jquery');

    // Enqueue Moment.js (required for daterangepicker)
    wp_enqueue_script('moment', 'https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js', [], null, true);


    // Enqueue Date Range Picker
    wp_enqueue_script('daterangepicker', 'https://cdn.jsdelivr.net/npm/daterangepicker@3.1.0/daterangepicker.min.js', ['jquery', 'moment'], null, true);
    wp_enqueue_style('daterangepicker', 'https://cdn.jsdelivr.net/npm/daterangepicker@3.1.0/daterangepicker.css');

    // Enqueue Chart.js
    wp_enqueue_script('chart-js', 'https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js', [], null, true);

    // Enqueue your custom admin script
    wp_enqueue_script(
        'usabdlp-admin-script',
        get_template_directory_uri() . '/js/usabdlp-admin.js',
        ['jquery', 'moment', 'daterangepicker', 'chart-js'],
        filemtime(get_template_directory() . '/js/usabdlp-admin.js'),
        true
    );

    // Enqueue your admin styles
    wp_enqueue_style(
        'usabdlp-admin-style',
        get_template_directory_uri() . '/css/usabdlp-dashboard.css',
        [],
        filemtime(get_template_directory() . '/css/usabdlp-dashboard.css')
    );
}
add_action('admin_enqueue_scripts', 'usabdlp_enqueue_admin_scripts');

// In functions.php
function font_awesome_select_preview() {
    ?>
    <style>
    /* Show icons in dropdown */
    .font-awesome-select .select2-results__option:before {
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        content: attr(data-icon);
        margin-right: 10px;
    }
    
    /* Show selected icon */
    .font-awesome-select .select2-selection__rendered:before {
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        content: attr(data-icon);
        margin-right: 10px;
    }
    </style>
    
    <script>
    jQuery(document).ready(function($) {
        // Add data-icon attribute for preview
        $('.font-awesome-select option').each(function() {
            $(this).attr('data-icon', '\\' + $(this).val().split('-').pop());
        });
    });
    </script>
    <?php
}
add_action('admin_footer', 'font_awesome_select_preview');

function load_font_awesome_admin() {
    if (is_admin()) {
        wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');
    }
}
add_action('admin_enqueue_scripts', 'load_font_awesome_admin');
=======
>>>>>>> 523a812 (Initial commit after system restore)
