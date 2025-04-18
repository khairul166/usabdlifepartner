<?php
// functions.php

require_once get_template_directory() . '/inc/enqueue.php';
require_once get_template_directory() . '/inc/wp-bootstrap-navwalker/class-wp-bootstrap-navwalker.php';
require_once get_template_directory() . '/inc/custom-post.php';
require_once get_template_directory() . '/inc/custom_metabox.php';
require_once get_template_directory() . '/inc/widget.php';
require_once get_template_directory() . '/inc/theme_settings.php';
require_once get_template_directory() . '/inc/admin-controls.php';
require_once get_template_directory() . '/inc/kirki-master/kirki.php';
require_once get_template_directory() . '/inc/codestar-framework/cs-framework.php';


// Include Custom Widgets
require get_template_directory() . '/inc/custom-widgets.php';

function theme_customizer_settings($wp_customize)
{
    // Add Section for Contact Info
    $wp_customize->add_section('contact_info_section', array(
        'title' => __('Contact Information', 'yourtheme'),
        'priority' => 25,
    ));

    // Phone Number
    $wp_customize->add_setting('contact_phone', array(
        'default' => '+1 234 567 890',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('contact_phone', array(
        'label' => __('Phone Number', 'yourtheme'),
        'section' => 'contact_info_section',
        'type' => 'text',
    ));

    // Email Address
    $wp_customize->add_setting('contact_email', array(
        'default' => 'info@yourdomain.com',
        'sanitize_callback' => 'sanitize_email',
    ));

    $wp_customize->add_control('contact_email', array(
        'label' => __('Email Address', 'yourtheme'),
        'section' => 'contact_info_section',
        'type' => 'email',
    ));
    // Address
    $wp_customize->add_setting('contact_address', array(
        'default' => ' ',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('contact_address', array(
        'label' => __('Address', 'yourtheme'),
        'section' => 'contact_info_section',
        'type' => 'text',
    ));

    // Add Section for Social Media
    $wp_customize->add_section('social_media_section', array(
        'title' => __('Social Media Links', 'yourtheme'),
        'priority' => 30,
    ));

    // Social Media Platforms
    $social_platforms = array('Facebook', 'Twitter', 'Instagram', 'LinkedIn');

    foreach ($social_platforms as $platform) {
        $slug = strtolower($platform);
        $wp_customize->add_setting("social_$slug", array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control("social_$slug", array(
            'label' => __("$platform URL", 'yourtheme'),
            'section' => 'social_media_section',
            'type' => 'url',
        ));
    }
}
add_action('customize_register', 'theme_customizer_settings');


function theme_customizer_logo($wp_customize)
{
    // Add a section for the site logo
    $wp_customize->add_section('site_logo_section', array(
        'title' => __('Site Logo', 'yourtheme'),
        'priority' => 20,
    ));

    // Add setting for the logo
    $wp_customize->add_setting('site_logo', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    // Add control to upload the logo
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'site_logo', array(
        'label' => __('Upload Logo', 'yourtheme'),
        'section' => 'site_logo_section',
        'settings' => 'site_logo',
    )));
}
add_action('customize_register', 'theme_customizer_logo');



// Nav Menu codes
function register_my_menus()
{
    register_nav_menus(
        array(
            'primary-menu' => __('Primary Menu'),
        )
    );
}
add_action('init', 'register_my_menus');


function enable_theme_features()
{
    add_theme_support('post-thumbnails'); // Enable featured images
    add_image_size('carousel-thumb', 1200, 500, true); // Custom size for carousel
}
add_action('after_setup_theme', 'enable_theme_features');




// Redirect users trying to access wp-login.php to the custom login page
function redirect_wp_login_page()
{
    $custom_login_url = home_url('/login/'); // Change '/login/' to your actual login page slug

    if (strpos($_SERVER['REQUEST_URI'], 'wp-login.php') !== false && !is_admin()) {
        wp_redirect($custom_login_url);
        exit;
    }
}
add_action('init', 'redirect_wp_login_page');


function redirect_non_admin_users()
{
    if (is_admin() && !current_user_can('administrator') && !(defined('DOING_AJAX') && DOING_AJAX)) {
        wp_redirect(home_url('/login/')); // Redirect non-admins to login page
        exit;
    }
}
add_action('admin_init', 'redirect_non_admin_users');

function force_logout_wp_login()
{
    if (strpos($_SERVER['REQUEST_URI'], 'wp-login.php') !== false) {
        wp_logout();
    }
}
add_action('init', 'force_logout_wp_login');





function handle_password_change()
{
    if (isset($_POST['change_password_submit'])) {
        // Verify nonce for security
        if (!isset($_POST['change_password_nonce']) || !wp_verify_nonce($_POST['change_password_nonce'], 'change_password_action')) {
            return '<div class="alert alert-danger">Security check failed.</div>';
        }

        // Get current user
        $user = wp_get_current_user();
        if (!$user->exists()) {
            return '<div class="alert alert-danger">User not found.</div>';
        }

        // Get form data
        $current_password = sanitize_text_field($_POST['c_password']);
        $new_password = sanitize_text_field($_POST['new_password']);
        $re_new_password = sanitize_text_field($_POST['re_new_password']);

        // Validate current password
        if (!wp_check_password($current_password, $user->user_pass, $user->ID)) {
            return '<div class="alert alert-danger">Current password is incorrect.</div>';
        }

        // Validate new passwords match
        if ($new_password !== $re_new_password) {
            return '<div class="alert alert-danger">New passwords do not match.</div>';
        }

        // Validate password strength (optional)
        if (strlen($new_password) < 8) {
            return '<div class="alert alert-danger">New password must be at least 8 characters long.</div>';
        }

        // Update password
        wp_set_password($new_password, $user->ID);

        // Log the user back in (since wp_set_password logs them out)
        wp_set_auth_cookie($user->ID);
        wp_set_current_user($user->ID);

        // Success message
        return '<div class="alert alert-success">Password changed successfully.</div>';
    }
}


function get_custom_registration_url()
{
    // Replace 'signup' with your custom registration page slug
    return home_url('/signup');
}

function create_registration_page_on_theme_activation()
{
    // Check if the page already exists
    $page = get_page_by_path('register'); // Change 'register' to your desired page slug
    if (!$page) {
        // Create the page
        $page_id = wp_insert_post(array(
            'post_title' => 'Register', // Page title
            'post_name' => 'register', // Page slug
            'post_content' => '', // Optional: Add content if needed
            'post_status' => 'publish', // Publish the page
            'post_author' => 1, // Admin user ID
            'post_type' => 'page', // It's a page
            'comment_status' => 'closed', // Disable comments
            'ping_status' => 'closed', // Disable pingbacks
        ));

        // Assign the "Register" template to the page
        if ($page_id && !is_wp_error($page_id)) {
            update_post_meta($page_id, '_wp_page_template', 'page-register.php');
        }
    }
}
add_action('after_switch_theme', 'create_registration_page_on_theme_activation');


// add_action('wp_logout', 'custom_redirect_after_logout');
// function custom_redirect_after_logout()
// {
//     wp_redirect(home_url('/')); // Redirect to homepage after logout
//     exit();
// }

// add_action('wp_logout', 'force_clear_user_session');
// function force_clear_user_session()
// {
//     // Destroy the user session
//     wp_destroy_current_session();
//     wp_clear_auth_cookie();

//     // Redirect to homepage
//     wp_redirect(home_url('/'));
//     exit();
// }

// Change the lost password URL to your custom page
add_filter('lostpassword_url', 'custom_lostpassword_url', 10, 2);
function custom_lostpassword_url($lostpassword_url, $redirect)
{
    // Replace 'forgot-password' with the slug of your custom Forget Password page
    return home_url('/forgot-password/');
}

function usabdlifepartner_register_sidebar()
{
    register_sidebar(array(
        'name' => __('Blog Sidebar', 'usabdlifepartner'),
        'id' => 'blog-sidebar',
        'before_widget' => '<div class="blog_pg1_right2 mt-4">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3><hr class="line mb-4">',
    ));
}
add_action('widgets_init', 'usabdlifepartner_register_sidebar');


function fix_comment_redirect($location)
{
    return isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : home_url();
}
add_filter('comment_post_redirect', 'fix_comment_redirect');


function handle_matrimonial_filter()
{
    // Get filter data from AJAX request
    $paged = isset($_GET['paged']) ? intval($_GET['paged']) : 1; // Get current page (sanitized as integer)
    $looking_for = isset($_GET['looking_for']) ? sanitize_text_field($_GET['looking_for']) : '';
    $country = isset($_GET['country']) ? sanitize_text_field($_GET['country']) : '';
    $marital_status = isset($_GET['marital_status']) ? sanitize_text_field($_GET['marital_status']) : '';
    $religion = isset($_GET['religion']) ? sanitize_text_field($_GET['religion']) : '';
    $profession = isset($_GET['profession']) ? sanitize_text_field($_GET['profession']) : '';
    $smoking_status = isset($_GET['smoking_status']) ? sanitize_text_field($_GET['smoking_status']) : '';
    $drinking_status = isset($_GET['drinking_status']) ? sanitize_text_field($_GET['drinking_status']) : '';

    // Define the query arguments to get users
    $args = array(
        'role' => 'subscriber',
        'number' => 10,  // Limit to 2 users per page (adjust as needed)
        'paged' => $paged, // Current page
        'meta_query' => array(
            'relation' => 'AND',
        ),
    );
    // Add conditions based on filters
    if ($looking_for) {
        $args['meta_query'][] = array(
            'key' => 'looking_for',
            'value' => $looking_for,
            'compare' => '=',
        );
    }
    if ($country) {
        $args['meta_query'][] = array(
            'key' => 'country',
            'value' => $country,
            'compare' => 'LIKE',
        );
    }
    if ($marital_status) {
        $args['meta_query'][] = array(
            'key' => 'marital_status',
            'value' => $marital_status,
            'compare' => '=',
        );
    }
    if ($religion) {
        $args['meta_query'][] = array(
            'key' => 'religion',
            'value' => $religion,
            'compare' => '=',
        );
    }
    if ($profession) {
        $args['meta_query'][] = array(
            'key' => 'profession',
            'value' => $profession,
            'compare' => '=',
        );
    }
    if ($smoking_status) {
        $args['meta_query'][] = array(
            'key' => 'smoking_habits',
            'value' => $smoking_status,
            'compare' => '='
        );
    }
    if ($drinking_status) {
        $args['meta_query'][] = array(
            'key' => 'drinking_habits',
            'value' => $drinking_status,
            'compare' => '='
        );
    }

    // Use WP_User_Query for pagination support
    $user_query = new WP_User_Query($args);

    // Get the filtered users
    $users = $user_query->get_results();
    $total_users = $user_query->get_total(); // Get the total number of users for pagination

    // Output the profiles
    if ($users) {
        ob_start(); // Start output buffering
        foreach ($users as $user) {
            // Get user meta data
            $about_yourself = get_user_meta($user->ID, 'about_yourself', true);
            $profile_pic = get_user_meta($user->ID, 'user_avatar', true);
            //If no profile picture is set, use a default placeholder
            if (empty($profile_pic)) {
                $profile_pic = get_template_directory_uri() . '/image/avater.webp'; // Path to your default avatar
            }
            $name = get_user_meta($user->ID, 'first_name', true) . ' ' . get_user_meta($user->ID, 'last_name', true);
            $age = get_user_meta($user->ID, 'age', true);
            $height = get_user_meta($user->ID, 'height', true);
            $religion = get_user_meta($user->ID, 'religion', true);

            $country = get_user_meta($user->ID, 'country', true);
            $division = get_user_meta($user->ID, 'division', true);
            $district = get_user_meta($user->ID, 'district', true);
            $upazila = get_user_meta($user->ID, 'upazila', true);
            $village = get_user_meta($user->ID, 'village', true);
            $landmark = get_user_meta($user->ID, 'landmark', true);

            $state = get_user_meta($user->ID, 'state', true);
            $city = get_user_meta($user->ID, 'city', true);
            $usaLandmark = get_user_meta($user->ID, 'usaLandmark', true);
            if ($country == "Bangladesh") {
                $location = $district . ', ' . $country;
            } else {
                $location = $city . ', ' . $country;
            }

            $education = get_user_meta($user->ID, 'education', true);
            $profession = get_user_meta($user->ID, 'profession', true);
            $annual_income = get_user_meta($user->ID, 'annual_income', true);
            $gender = get_user_meta($user->ID, 'gender', true);
            // Fetch linked accounts from user meta
            $facebook = get_user_meta($user->ID, 'facebook', true);
            $instagram = get_user_meta($user->ID, 'instagram', true);
            $linkedin = get_user_meta($user->ID, 'linkedin', true);
            $x = get_user_meta($user->ID, 'x', true);
            ?>
            <div class="list_1_right2_inner row border-top mt-4 pt-4 mx-0">
                <div class="col-md-4 ps-0 col-sm-4">
                    <div class="list_1_right2_inner_left">
                        <a href="<?php echo get_permalink(get_page_by_path('user-details')); ?>?user_id=<?php echo $user->ID; ?>">
                            <img src="<?php echo esc_url($profile_pic); ?>" class="img-fluid" alt="Profile Picture">
                        </a>
                    </div>
                </div>
                <div class="col-md-8 col-sm-8">
                    <div class="row row-cols-1 row-cols-lg-2 row-cols-md-1 list_1_right2_inner_right_inner">
                        <div class="col">
                            <div class="list_1_right2_inner_right">
                                <b class="d-block mb-3 fs-5">
                                    <a
                                        href="<?php echo get_permalink(get_page_by_path('user-details')); ?>?user_id=<?php echo $user->ID; ?>">
                                        <?php echo esc_html($name); ?>
                                    </a>
                                </b>
                                <ul class="font_15 mb-0">
                                    <li class="d-flex"><b class="me-2"> Age:</b><span><?php echo esc_html($age); ?> Yrs</span></li>
                                    <li class="d-flex mt-2"><b class="me-2">
                                            Religion:</b><span><?php echo esc_html($religion); ?></span></li>
                                    <li class="d-flex mt-2"><b class="me-2">
                                            Height:</b><span><?php echo esc_html($height); ?></span></li>
                                    <li class="d-flex mt-2"><b class="me-2">
                                            Location:</b><span><?php echo esc_html($location); ?></span></li>
                                    <li class="d-flex mt-2"><b class="me-2">
                                            Education:</b><span><?php echo esc_html($education); ?></span></li>
                                    <li class="d-flex mt-2"><b class="me-2">
                                            Profession:</b><span><?php echo esc_html($profession); ?></span></li>
                                    <li class="d-flex mt-2"><b class="me-2"> Annual
                                            Income:</b><span><?php echo esc_html($annual_income); ?></span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col">
                            <div class="list_1_right2_inner_right">
                                <p class="mt-1"><?php echo $about_yourself; ?></p>
                                <ul class="mb-0 d-flex social_brands">
                                    <?php if ($facebook) { ?>
                                        <li>
                                            <a class="bg-primary d-inline-block text-white text-center"
                                                href="https://www.facebook.com/<?php echo esc_attr($facebook); ?>" target="_blank">
                                                <i class="bi bi-facebook"></i>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <?php if ($instagram) { ?>
                                        <!-- Instagram -->
                                        <li class="ms-2">
                                            <a class="bg-success d-inline-block text-white text-center"
                                                href="https://www.instagram.com/<?php echo esc_attr($instagram); ?>" target="_blank">
                                                <i class="bi bi-instagram"></i>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <?php if ($linkedin) { ?>
                                        <!-- LinkedIn -->
                                        <li class="ms-2">
                                            <a class="bg-warning d-inline-block text-white text-center"
                                                href="https://www.linkedin.com/in/<?php echo esc_attr($linkedin); ?>" target="_blank">
                                                <i class="bi bi-linkedin"></i>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <?php if ($x) { ?>
                                        <!-- X (Twitter) -->
                                        <li class="ms-2">
                                            <a class="bg-dark d-inline-block text-white text-center"
                                                href="https://twitter.com/<?php echo esc_attr($x); ?>" target="_blank">
                                                <i class="bi bi-twitter-x"></i>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        $profiles = ob_get_clean(); // Get the buffered output of profiles

        // Generate pagination links with filter parameters
        $base_url = add_query_arg(
            array(
                'looking_for' => $looking_for,
                'country' => $country,
                'marital_status' => $marital_status,
                'religion' => $religion,
                'profession' => $profession,
                'smoking_status' => $smoking_status,
                'drinking_status' => $drinking_status,
            ),
            get_pagenum_link() // Retain base page URL with query args
        );

        // Generate pagination links with filter parameters
        $big = 999999999; // Unlikely integer for replacement
        $base_url = esc_url(add_query_arg('paged', '%#%', home_url($_SERVER['REQUEST_URI']))); // Generate correct URL

        $pagination = paginate_links(array(
            'base' => esc_url(get_pagenum_link(1)) . '%_%', // ✅ Generates frontend-friendly URLs
            'format' => '?paged=%#%', // ✅ Ensures correct page query parameter
            'current' => max(1, $paged),
            'total' => ceil($total_users / $args['number']),
            'prev_text' => '<i class="bi bi-chevron-left"></i>',
            'next_text' => '<i class="bi bi-chevron-right"></i>',
            'type' => 'array',
            'mid_size' => 2,
        ));

        $pagination_html = '';
        if (!empty($pagination)) {
            $pagination_html .= '<ul class="mb-0 paginate text-center mt-4">';
            foreach ($pagination as $page_link) {
                // ✅ Replace "current" class with "active"
                $page_link = str_replace('page-numbers current', 'border d-block active', $page_link);
                $page_link = str_replace('page-numbers', 'border d-block ajax-pagination', $page_link); // ✅ Add AJAX-friendly class
                $pagination_html .= '<li class="d-inline-block mt-1 mb-1">' . $page_link . '</li>';
            }
            $pagination_html .= '</ul>';
        } else {
            $pagination_html = ''; // Hide pagination if only 1 page exists
        }

        // Return JSON response
        wp_send_json_success(array(
            'profiles' => $profiles,
            'pagination' => $pagination_html,
        ));



    } else {
        wp_send_json_error(array('message' => 'No profiles found.'));
    }

    wp_die(); // Always call wp_die() to end the AJAX request
}

add_action('wp_ajax_filter_profiles', 'handle_matrimonial_filter');
add_action('wp_ajax_nopriv_filter_profiles', 'handle_matrimonial_filter');


// Register a widget area for the "Profile Page Widget Area"
function register_profile_page_widget_area()
{
    register_sidebar(array(
        'name' => 'Profile Page Widget Area',
        'id' => 'profile_page_widget_area',
        'before_widget' => '<div class="widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'register_profile_page_widget_area');


// Track user's last login time and mark user as online
function track_user_login_time($user_login, $user)
{
    // Store the login time in user meta
    update_user_meta($user->ID, 'last_login', current_time('mysql'));

    // Mark the user as online by setting a 'last_activity' timestamp
    update_user_meta($user->ID, 'last_activity', time());
}
add_action('wp_login', 'track_user_login_time', 10, 2);

// Mark user as offline when they log out
function track_user_logout($user_login)
{
    // Set the user's last activity to 0 or remove it when logging out
    update_user_meta($user_login, 'last_activity', 0);
}
add_action('wp_logout', 'track_user_logout');



function upload_cropped_profile_picture() {
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'User not logged in']);
    }

    // Get user ID
    $user_id = get_current_user_id();

    // Get cropped image data
    if (isset($_POST['cropped_image']) && !empty($_POST['cropped_image'])) {
        $cropped_image = $_POST['cropped_image'];
        $upload_dir = wp_upload_dir();
        $img_name = 'profile_picture_' . $user_id . '.jpg';
        $img_path = $upload_dir['path'] . '/' . $img_name;
        $img_url = $upload_dir['url'] . '/' . $img_name;

        // Convert base64 to image file
        $image_data = explode(',', $cropped_image);
        $decoded_image = base64_decode($image_data[1]);

        // Save file
        file_put_contents($img_path, $decoded_image);

        // Save profile picture URL in user meta
        update_user_meta($user_id, 'user_avatar', $img_url);

        wp_send_json_success(['message' => 'Profile picture updated!', 'image_url' => $img_url]);
    } else {
        wp_send_json_error(['message' => 'Invalid image data']);
    }
}
add_action('wp_ajax_upload_cropped_profile_picture', 'upload_cropped_profile_picture');
add_action('wp_ajax_nopriv_upload_cropped_profile_picture', 'upload_cropped_profile_picture'); // Allow non-logged users (optional)

function add_ajax_url() {
    ?>
    <script type="text/javascript">
        var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
    </script>
    <?php
}
add_action('wp_head', 'add_ajax_url');


function delete_user_photo() {
    // Verify user is logged in
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'User not logged in']);
    }

    $user_id = get_current_user_id();
    $photo_id = isset($_POST['photo_id']) ? intval($_POST['photo_id']) : 0;

    // Verify the attachment belongs to the user
    $photo_owner = get_post_field('post_author', $photo_id);
    if ($photo_owner != $user_id) {
        wp_send_json_error(['message' => 'You are not authorized to delete this photo']);
    }

    // Delete the attachment
    $deleted = wp_delete_attachment($photo_id, true);

    if ($deleted) {
        // Remove photo from user's saved photos (if stored as user meta)
        $user_photos = get_user_meta($user_id, 'user_photos', true);
        if (!empty($user_photos) && is_array($user_photos)) {
            $updated_photos = array_diff($user_photos, array($photo_id));
            update_user_meta($user_id, 'user_photos', $updated_photos);
        }

        wp_send_json_success(['message' => 'Photo deleted successfully']);
    } else {
        wp_send_json_error(['message' => 'Failed to delete the photo']);
    }
}
add_action('wp_ajax_delete_user_photo', 'delete_user_photo');






function custom_password_reset_email($message, $key, $user_login, $user) {
    $reset_url = site_url('/reset-password/?login=' . rawurlencode($user_login) . '&key=' . rawurlencode($key));
    
    $message = "Someone has requested a password reset for the following account:\n\n";
    $message .= "Site Name: " . get_bloginfo('name') . "\n\n";
    $message .= "Username: " . $user_login . "\n\n";
    $message .= "If this was a mistake, ignore this email and nothing will happen.\n\n";
    $message .= "To reset your password, visit the following address:\n\n";
    $message .= $reset_url . "\n\n";
    
    return $message;
}
add_filter('retrieve_password_message', 'custom_password_reset_email', 10, 4);







// Dynamic Tab Pane Section for Profile Browsing
function usabdlp_render_profile_tabs() {
    global $wpdb;

    // Helper function to generate tab HTML
    function generate_profile_tab($meta_key, $label) {
        global $wpdb;
        $values = $wpdb->get_col(
            $wpdb->prepare(
                "SELECT DISTINCT meta_value FROM {$wpdb->usermeta} WHERE meta_key = %s AND meta_value != ''",
                $meta_key
            )
        );

        echo '<div class="tab-pane" id="profile_' . esc_attr($meta_key) . '">';
        echo '<div class="profile1_inner">';
        echo '<ul class="mb-0 d-flex flex-wrap justify-content-center">';

        if ($values) {
            foreach ($values as $index => $value) {
                echo '<li><a href="' . esc_url(home_url('/search/?' . $meta_key . '=' . urlencode($value))) . '">' . esc_html($value) . '</a></li>';
                if ($index !== array_key_last($values)) {
                    echo '<li class="text-muted mx-3">|</li>';
                }
            }
        } else {
            echo '<li>No ' . esc_html($label) . ' found.</li>';
        }

        echo '</ul></div></div>';
    }

    // Fetch unique values for combined city field (division or city)
    $city_values = $wpdb->get_col("SELECT DISTINCT meta_value FROM {$wpdb->usermeta} WHERE meta_key IN ('division', 'city') AND meta_value != ''");

    ?>

    <section id="profile" class="pt-5 pb-5">
        <div class="container-xl">
            <div class="row exep_1 mb-4 text-center">
                <div class="col-md-12">
                    <span class="text-uppercase text-muted d-block">Browse</span>
                    <b class="d-block fs-3 mt-2">Profiles by <span class="theme-text-color">Matrimonials</span></b>
                </div>
            </div>
            <div class="row profile_1">
                <div class="col-md-12">
                    <ul class="nav nav-tabs mb-0 flex-wrap font_15 justify-content-center border-0 tab_click">
                        <li class="nav-item">
                            <a href="#profile_mother_tongue" data-bs-toggle="tab" class="nav-link active"><span>Mother Tongue</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="#profile_religion" data-bs-toggle="tab" class="nav-link"><span>Religion</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="#profile_city" data-bs-toggle="tab" class="nav-link"><span>City</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="#profile_profession" data-bs-toggle="tab" class="nav-link"><span>Occupation</span></a>
                        </li>
                    </ul>

                    <div class="tab-content mt-4">
                        <div class="tab-pane active" id="profile_mother_tongue">
                            <?php generate_profile_tab('mother_tongue', 'Mother Tongue'); ?>
                        </div>
                        <div class="tab-pane" id="profile_religion">
                            <?php generate_profile_tab('religion', 'Religion'); ?>
                        </div>
                        <div class="tab-pane" id="profile_city">
                            <div class="profile1_inner">
                                <ul class="mb-0 d-flex flex-wrap justify-content-center">
                                    <?php
                                    if ($city_values) {
                                        foreach ($city_values as $index => $city) {
                                            echo '<li><a href="' . esc_url(home_url('/search/?city=' . urlencode($city))) . '">' . esc_html($city) . '</a></li>';
                                            if ($index !== array_key_last($city_values)) {
                                                echo '<li class="text-muted mx-3">|</li>';
                                            }
                                        }
                                    } else {
                                        echo '<li>No cities found.</li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <div class="tab-pane" id="profile_profession">
                            <?php generate_profile_tab('profession', 'Profession'); ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <?php
}




////////////////
function usabdlp_create_custom_tables() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();

    $interests_table = $wpdb->prefix . 'interests';
    $notifications_table = $wpdb->prefix . 'notifications';

    $sql = "
    CREATE TABLE IF NOT EXISTS $interests_table (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        from_user_id BIGINT NOT NULL,
        to_user_id BIGINT NOT NULL,
        status VARCHAR(20) DEFAULT 'pending',
        sent_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        responded_at DATETIME DEFAULT NULL
    ) $charset_collate;

    CREATE TABLE IF NOT EXISTS $notifications_table (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        user_id BIGINT NOT NULL,
        message TEXT NOT NULL,
        read_status TINYINT(1) DEFAULT 0,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    ) $charset_collate;
    ";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
}
add_action('after_setup_theme', 'usabdlp_create_custom_tables');




add_action('wp_ajax_toggle_interest', 'handle_toggle_interest');

// function handle_toggle_interest() {
//     check_ajax_referer('interest_nonce', 'security');

//     global $wpdb;
//     $current_user = get_current_user_id();
//     $to_user_id = intval($_POST['to_user_id']);
//     $action_type = sanitize_text_field($_POST['type']);

//     $table = $wpdb->prefix . 'interests';
//     $existing = $wpdb->get_var($wpdb->prepare(
//         "SELECT COUNT(*) FROM $table WHERE from_user_id = %d AND to_user_id = %d",
//         $current_user, $to_user_id
//     ));

//     if ($action_type === 'send') {
//         if ($existing) {
//             wp_send_json_error(['message' => 'Already sent.']);
//         }

//         $wpdb->insert($table, [
//             'from_user_id' => $current_user,
//             'to_user_id'   => $to_user_id,
//             'status'       => 'pending',
//             'sent_at'      => current_time('mysql')
//         ]);

//         wp_send_json_success(['action' => 'sent']);
//     }

//     if ($action_type === 'cancel') {
//         $wpdb->delete($table, [
//             'from_user_id' => $current_user,
//             'to_user_id'   => $to_user_id
//         ]);
//         wp_send_json_success(['action' => 'cancelled']);
//     }

//     wp_send_json_error(['message' => 'Invalid action']);
// }


function handle_toggle_interest() {
    check_ajax_referer('interest_nonce', 'security');

    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'Not logged in']);
    }

    global $wpdb;
    $current_user = get_current_user_id();
    $to_user_id = intval($_POST['to_user_id']);
    $type = sanitize_text_field($_POST['type']);

    $interest_table = $wpdb->prefix . "interests";
    $notification_table = $wpdb->prefix . "notifications";
    $sender_id = get_current_user_id();
    $first_name = get_user_meta($sender_id, 'first_name', true);
    $last_name  = get_user_meta($sender_id, 'last_name', true);
    $full_name  = trim("$first_name $last_name");

    // Fallback if no first/last name is set
    if (empty($full_name)) {
        $user_info = get_userdata($sender_id);
        $full_name = $user_info->display_name;
    }

    // Generate profile link
    $profile_link = esc_url(home_url("/user-details/?user_id=$sender_id"));

    // Message with clickable name
    $notification_message = "<a href='$profile_link' style='color:#563d7c;font-weight:600;'>$full_name</a> sent you an interest.";
    $notification_cancel_massage= "<a href='$profile_link' style='color:#563d7c;font-weight:600;'>$full_name</a> has cancelled the interest.";

    // Cancel interest
    if ($type === 'cancel') {
        $wpdb->delete($interest_table, [
            'from_user_id' => $current_user,
            'to_user_id'   => $to_user_id
        ]);

        // Add cancel notification
        $wpdb->insert($notification_table, [
            'user_id'     => $to_user_id,
            'message'     => $notification_cancel_massage,
            'read_status' => 0,
            'created_at'  => current_time('mysql')
        ]);

        wp_send_json_success(['action' => 'cancelled']);
    }

    // Send interest
    if ($type === 'send') {
        // Prevent duplicate interest
        $exists = $wpdb->get_var($wpdb->prepare(
            "SELECT id FROM $interest_table WHERE from_user_id = %d AND to_user_id = %d",
            $current_user, $to_user_id
        ));

        if ($exists) {
            wp_send_json_error(['message' => 'Already sent']);
        }

        // Insert interest with all columns filled
        $wpdb->insert(
            $interest_table,
            [
                'from_user_id' => $current_user,
                'to_user_id'   => $to_user_id,
                'status'       => 'pending',
                'sent_at'      => current_time('mysql'),
                'responded_at' => null
            ],
            ['%d', '%d', '%s', '%s', 'NULL']
        );

        // Add notification
        $wpdb->insert($notification_table, [
            'user_id'     => $to_user_id,
            'message'     => $notification_message,
            'read_status' => 0,
            'created_at'  => current_time('mysql')
        ]);

        wp_send_json_success(['action' => 'sent']);
    }

    wp_send_json_error(['message' => 'Unknown action']);
}


function usabdlp_update_interest_table_schema() {
    global $wpdb;
    $table = $wpdb->prefix . 'interests';

    // Check if 'status' column exists
    $column = $wpdb->get_results("SHOW COLUMNS FROM $table LIKE 'status'");
    if (empty($column)) {
        // If not exists, add it
        $wpdb->query("ALTER TABLE $table ADD COLUMN status VARCHAR(20) DEFAULT 'pending'");
    }
}
add_action('after_setup_theme', 'usabdlp_update_interest_table_schema');

add_action('wp_ajax_respond_to_interest', 'usabdlp_respond_to_interest');

add_action('wp_ajax_respond_to_interest', 'usabdlp_respond_to_interest');

function usabdlp_respond_to_interest() {
    check_ajax_referer('interest_nonce', 'security');

    $interest_id = intval($_POST['interest_id']);
    $response = sanitize_text_field($_POST['response']);

    if (!in_array($response, ['accepted', 'rejected'])) {
        wp_send_json_error(['message' => 'Invalid response type.']);
    }

    global $wpdb;
    $table = $wpdb->prefix . 'interests';
    $notif_table = $wpdb->prefix . 'notifications';

    // Get interest row
    $interest = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE id = %d", $interest_id));
    if (!$interest) {
        wp_send_json_error(['message' => 'Interest not found.']);
    }

    // Update interest status
    $wpdb->update($table, [
        'status' => $response,
        'responded_at' => current_time('mysql')
    ], [
        'id' => $interest_id
    ]);

    // Only notify if accepted
    if ($response === 'accepted') {
        $sender_id = $interest->from_user_id;

        $first_name = get_user_meta(get_current_user_id(), 'first_name', true);
        $last_name = get_user_meta(get_current_user_id(), 'last_name', true);
        $receiver_name = trim($first_name . ' ' . $last_name);
        $receiver_link = home_url('/user-details/?user_id=' . get_current_user_id());

        $message = "<a href='{$receiver_link}'><strong>" . esc_html($receiver_name) . "</strong></a> has accepted your interest request.";

        $wpdb->insert($notif_table, [
            'user_id'    => $sender_id,
            'message'    => $message,
            'read_status' => 0,
            'created_at' => current_time('mysql')
        ]);
    }

    wp_send_json_success(['message' => 'Interest ' . $response . ' successfully.']);
}


add_action('wp', 'check_interest_access_status');
function check_interest_access_status() {
    global $wpdb;

    // Must use global to access in template
    global $access_granted;

    $interest_table = $wpdb->prefix . 'interests';

    $current_user = get_current_user_id();
    $profile_user = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

    // Store current user & profile user in global for debugging
    global $access_debug;
    $access_debug = [
        'logged_in' => is_user_logged_in(),
        'current_user_id' => $current_user,
        'profile_user_id' => $profile_user
    ];

    // Skip if not logged in
    if (!$current_user || !$profile_user) {
        $access_granted = false;
        return;
    }

    // Check accepted interests in both directions
    $sent_accepted = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM $interest_table WHERE from_user_id = %d AND to_user_id = %d AND status = 'accepted'",
        $current_user, $profile_user
    ));

    $received_accepted = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM $interest_table WHERE from_user_id = %d AND to_user_id = %d AND status = 'accepted'",
        $profile_user, $current_user
    ));

    $access_granted = ($sent_accepted || $received_accepted);
}


add_action('wp_ajax_toggle_shortlist', 'toggle_shortlist_user');

function create_shortlist_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'user_shortlists';

    // Check if the table already exists
    $table_exists = $wpdb->get_var(
        $wpdb->prepare(
            "SHOW TABLES LIKE %s",
            $table_name
        )
    );

    if ($table_exists === $table_name) {
        return; // Table already exists, do nothing
    }

    // Create the table
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        shortlisted_user_id INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY unique_shortlist (user_id, shortlisted_user_id)
    ) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
}


add_action('wp_ajax_toggle_shortlist', 'toggle_shortlist_user');

function toggle_shortlist_user() {
    if (!is_user_logged_in()) {
        wp_send_json_error('Unauthorized');
    }

    $current_user_id = get_current_user_id();
    $shortlisted_user_id = intval($_POST['shortlisted_user_id']);
    global $wpdb;
    $table = $wpdb->prefix . 'user_shortlists';

    // Check if already shortlisted
    $exists = $wpdb->get_var($wpdb->prepare(
        "SELECT id FROM $table WHERE user_id = %d AND shortlisted_user_id = %d",
        $current_user_id, $shortlisted_user_id
    ));

    if ($exists) {
        $wpdb->delete($table, [
            'user_id' => $current_user_id,
            'shortlisted_user_id' => $shortlisted_user_id
        ]);
        wp_send_json_success(['action' => 'removed']);
    } else {
        $wpdb->insert($table, [
            'user_id' => $current_user_id,
            'shortlisted_user_id' => $shortlisted_user_id
        ]);
        wp_send_json_success(['action' => 'added']);
    }
}


function usabdlp_render_shortlist_profiles() {
    // if (!is_user_logged_in()) {
    //     return '<p>Please log in to see your shortlisted profiles.</p>';
    // }
    return '<p>Login status: ' . (is_user_logged_in() ? 'YES' : 'NO') . '</p>' .
    '<p>Current user ID: ' . get_current_user_id() . '</p>';

    global $wpdb;
    $user_id = get_current_user_id();
    $shortlisted = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT shortlisted_user_id FROM {$wpdb->prefix}user_shortlists WHERE user_id = %d",
            $user_id
        )
    );

    if (empty($shortlisted)) {
        return '<p>You haven’t shortlisted anyone yet.</p>';
    }

    ob_start();
    echo '<div class="shortlisted-profiles row">';
    foreach ($shortlisted as $entry) {
        $shortlisted_id = $entry->shortlisted_user_id;
        $user_info = get_userdata($shortlisted_id);
        $profile_img = get_avatar_url($shortlisted_id);
        $name = esc_html($user_info->display_name);
        $location = get_user_meta($shortlisted_id, 'country', true); // Replace with your meta key

        echo '<div class="col-md-4 mb-4">';
        echo '<div class="card">';
        echo '<img class="card-img-top" src="' . esc_url($profile_img) . '" alt="' . $name . '">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . $name . '</h5>';
        echo '<p class="card-text">Location: ' . esc_html($location) . '</p>';
        echo '<a href="' . site_url('/profile/' . $shortlisted_id) . '" class="btn btn-primary btn-sm">View Profile</a>';
        echo '</div></div></div>';
    }
    echo '</div>';

    return ob_get_clean();
}
add_shortcode('usabdlp_shortlist', 'usabdlp_render_shortlist_profiles');
