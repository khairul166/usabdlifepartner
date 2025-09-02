<?php
// functions.php

require_once get_template_directory() . '/inc/enqueue.php';
require_once get_template_directory() . '/inc/wp-bootstrap-navwalker/class-wp-bootstrap-navwalker.php';
require_once get_template_directory() . '/inc/custom-post.php';
require_once get_template_directory() . '/inc/user_features.php';
require_once get_template_directory() . '/inc/custom_metabox.php';
require_once get_template_directory() . '/inc/widget.php';
// require_once get_template_directory() . '/inc/theme_settings.php';
require_once get_template_directory() . '/inc/admin-controls.php';
// require_once get_template_directory() . '/inc/kirki-master/kirki.php';
// require_once get_template_directory() . '/inc/codestar-framework/cs-framework.php';
require_once get_template_directory() . '/inc/theme-settings.php';
// // Include Composer's autoloader
require_once get_template_directory() . '/inc/stripe/vendor/autoload.php';




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





function redirect_to_custom_login_page()
{
    wp_redirect(home_url());
    exit;
}
add_action('wp_logout', 'redirect_to_custom_login_page');

function fn_redirect_wp_admin()
{
    global $pagenow;
    if ($pagenow == 'wp-login.php' && $_GET['action'] != 'logout') {
        wp_redirect(home_url() . '/login');
    }
}
add_action('init', 'fn_redirect_wp_admin');





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
        foreach ($users as $index => $user) {
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
            $delay = ($index * 0.1) . 's'; // Increase delay by 0.1s for each item
?>
            <div class="list_1_right2_inner row <?php if ($index > 0) {
                                                    echo 'border-top';
                                                } ?> mt-4 pt-4 mx-0 animate__animated animate__fadeInUp" style="animation-delay: <?php echo esc_attr($delay); ?>">
                <div class="col-md-4 ps-0 col-sm-4">
                    <div class="list_1_right2_inner_left" style="position: relative;">
                        <?php if (is_user_logged_in()) : ?>
                            <a href="<?php echo get_permalink(get_page_by_path('user-details')); ?>?user_id=<?php echo $user->ID; ?>">
                                <img src="<?php echo esc_url($profile_pic); ?>" class="img-fluid" alt="abc">
                                <!-- Membership Badge -->
                                <?php
                global $wpdb;
                // Get membership info for the current user in the loop
                $saved_default_package = intval(get_option('usabdlp_default_package', 0));
                $membership_info = $wpdb->get_row(
                    $wpdb->prepare("SELECT * FROM {$wpdb->prefix}memberships WHERE user_id = %d AND status = 'active'", $user->ID)
                );
                
                if ($membership_info) {
                    $plan = $wpdb->get_row(
                        $wpdb->prepare("SELECT * FROM {$wpdb->prefix}membership_plans WHERE id = %d", $membership_info->membership_type)
                    );
                    
                    if ($plan->id > $saved_default_package) {
                        echo '<span class="membership-badge">' . esc_html($plan->name) . '</span>';
                    }
                } 
                // else {
                //     echo '<span class="membership-badge">Free</span>';
                // }
                ?>
                            </a>
                        <?php else : ?>
                            <a href="<?php echo wp_login_url(); ?>">
                                <img src="<?php echo esc_url($profile_pic); ?>" class="img-fluid" alt="abc">
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-8 col-sm-8">
                    <div
                        class="row row-cols-1 row-cols-lg-2 row-cols-md-1 list_1_right2_inner_right_inner">
                        <div class="col">
                            <div class="list_1_right2_inner_right">
                                <b class="d-block mb-3 fs-5"><?php if (is_user_logged_in()) : ?>
                                        <a href="<?php echo get_permalink(get_page_by_path('user-details')); ?>?user_id=<?php echo $user->ID; ?>">
                                            <?php echo esc_html($name); ?>
                                        </a>
                                    <?php else : ?>
                                        <a href="<?php echo wp_login_url(); ?>"> <!-- WordPress login URL -->
                                            <?php echo esc_html($name); ?>
                                        </a>
                                    <?php endif; ?>
                                </b>
                                <ul class="font_15 mb-0">
                                    <li class="d-flex"><b class="me-2"> Age:</b>
                                        <span><?php echo esc_html($age); ?> Yrs</span>
                                    </li>
                                    <li class="d-flex mt-2"><b class="me-2"> Religion:</b><span>
                                            <?php echo esc_html($religion); ?></span></li>
                                    <li class="d-flex mt-2"><b class="me-2"> Height:</b><span>
                                            <?php echo esc_html($height); ?></span></li>
                                    <li class="d-flex mt-2"><b class="me-2"> Location:</b><span>
                                            <?php echo esc_html($location); ?></span></li>
                                    <li class="d-flex mt-2"><b class="me-2"> Education:</b><span>
                                            <?php echo esc_html($education); ?></span></li>
                                    <li class="d-flex mt-2"><b class="me-2"> Profession:</b><span>
                                            <?php echo esc_html($profession); ?></span></li>

                                </ul>
                                <span class="d-block mt-3">
                                    <a class="button"
                                        href="<?php echo is_user_logged_in() ? get_permalink(get_page_by_path('user-details')) . '?user_id=' . $user->ID : wp_login_url(); ?>">
                                        <i class="bi bi-person-fill me-1 align-middle"></i> View Full Profile
                                    </a>

                                </span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="list_1_right2_inner_right">
                                <p class="mt-1"><?php echo $about_yourself; ?></p>
                                <ul class="mb-0 d-flex social_brands">
                                    <?php if ($facebook) { ?>
                                        <li>
                                            <a class="bg-primary d-inline-block text-white text-center"
                                                href="https://www.facebook.com/<?php echo esc_attr($facebook); ?>"
                                                target="_blank">
                                                <i class="bi bi-facebook"></i>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <?php if ($instagram) { ?>
                                        <!-- Instagram -->
                                        <li class="ms-2">
                                            <a class="bg-success d-inline-block text-white text-center"
                                                href="https://www.instagram.com/<?php echo esc_attr($instagram); ?>"
                                                target="_blank">
                                                <i class="bi bi-instagram"></i>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <?php if ($linkedin) { ?>
                                        <!-- LinkedIn -->
                                        <li class="ms-2">
                                            <a class="bg-warning d-inline-block text-white text-center"
                                                href="https://www.linkedin.com/in/<?php echo esc_attr($linkedin); ?>"
                                                target="_blank">
                                                <i class="bi bi-linkedin"></i>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <?php if ($x) { ?>
                                        <!-- X (Twitter) -->
                                        <li class="ms-2">
                                            <a class="bg-dark d-inline-block text-white text-center"
                                                href="https://twitter.com/<?php echo esc_attr($x); ?>"
                                                target="_blank">
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



function upload_cropped_profile_picture()
{
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

function add_ajax_url()
{
    ?>
    <script type="text/javascript">
        var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
    </script>
<?php
}
add_action('wp_head', 'add_ajax_url');


function delete_user_photo()
{
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






function custom_password_reset_email($message, $key, $user_login, $user)
{
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
function usabdlp_render_profile_tabs()
{
    global $wpdb;

    // Helper function to generate tab HTML
    function generate_profile_tab($meta_key, $label)
    {
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

    <section id="profile" class="pt-5 pb-5 animate__animated animate__fadeInUp" style="animation-delay: 1.6s;">
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
function usabdlp_create_custom_tables()
{
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


function handle_toggle_interest()
{
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
    $notification_cancel_massage = "<a href='$profile_link' style='color:#563d7c;font-weight:600;'>$full_name</a> has cancelled the interest.";

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
            $current_user,
            $to_user_id
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


function usabdlp_update_interest_table_schema()
{
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

function usabdlp_respond_to_interest()
{
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
function check_interest_access_status()
{
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
        $current_user,
        $profile_user
    ));

    $received_accepted = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM $interest_table WHERE from_user_id = %d AND to_user_id = %d AND status = 'accepted'",
        $profile_user,
        $current_user
    ));

    $access_granted = ($sent_accepted || $received_accepted);
}


<<<<<<< HEAD
add_action('wp_ajax_toggle_shortlist', 'toggle_shortlist_user');

function create_shortlist_table()
{
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

function toggle_shortlist_user()
{
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
        $current_user_id,
        $shortlisted_user_id
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


function usabdlp_render_shortlist_profiles()
{
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


function humanTimeAgo($datetime, $fallbackFormat = 'd M Y')
{
    $time = is_numeric($datetime) ? $datetime : strtotime($datetime);
    $now = time();
    $diff = $now - $time;

    // Correct logic: future timestamps
    if ($diff < 0) {
        $diff = abs($diff);

        if ($diff < 60) return 'in a few seconds';
        if ($diff < 3600) return floor($diff / 60) . ' minutes from now';
        if ($diff < 86400) return floor($diff / 3600) . ' hours from now';
        if ($diff < 604800) return floor($diff / 86400) . ' days from now';
        return date($fallbackFormat, $time); // fallback for far future
    }

    // Past time
    if ($diff < 60) return 'just now';

    $units = [
        'year'   => 365 * 24 * 60 * 60,
        'month'  => 30 * 24 * 60 * 60,
        'week'   => 7 * 24 * 60 * 60,
        'day'    => 24 * 60 * 60,
        'hour'   => 60 * 60,
        'minute' => 60,
    ];

    foreach ($units as $unit => $seconds) {
        if ($diff >= $seconds) {
            $value = floor($diff / $seconds);
            return $value . ' ' . $unit . ($value > 1 ? 's' : '') . ' ago';
        }
    }

    return date($fallbackFormat, $time);
}

//codes for wp Membership
function create_membership_tables_if_not_exists()
{
    global $wpdb;

    $prefix = $wpdb->prefix;
    $membership_table = $prefix . 'memberships';
    $plans_table = $prefix . 'membership_plans';

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    // Create wp_memberships table if it doesn't exist
    if ($wpdb->get_var("SHOW TABLES LIKE '$membership_table'") !== $membership_table) {
        $sql1 = "CREATE TABLE $membership_table (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id BIGINT(20) UNSIGNED NOT NULL,
            membership_type VARCHAR(50) NOT NULL,
            start_date DATE,
            end_date DATE,
            status ENUM('active','expired','pending') DEFAULT 'pending',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX (user_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        dbDelta($sql1);
    }

    // Create wp_membership_plans table if it doesn't exist
    if ($wpdb->get_var("SHOW TABLES LIKE '$plans_table'") !== $plans_table) {
        $sql2 = "CREATE TABLE $plans_table (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            price DECIMAL(10,2) NOT NULL,
            duration_days INT NOT NULL,
            description TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        dbDelta($sql2);
    }
}
add_action('after_setup_theme', 'create_membership_tables_if_not_exists');
function add_membership_feature_columns_if_not_exist()
{
    global $wpdb;
    $table = $wpdb->prefix . 'membership_plans';

    $columns = $wpdb->get_col("DESC $table", 0);

    $alter_queries = [];

    if (!in_array('premium_views', $columns)) {
        $alter_queries[] = "ADD COLUMN premium_views INT DEFAULT 0";
    }
    if (!in_array('can_view_contact', $columns)) {
        $alter_queries[] = "ADD COLUMN can_view_contact TINYINT(1) DEFAULT 0";
    }
    if (!in_array('can_send_interest', $columns)) {
        $alter_queries[] = "ADD COLUMN can_send_interest TINYINT(1) DEFAULT 0";
    }
    if (!in_array('can_start_chat', $columns)) {
        $alter_queries[] = "ADD COLUMN can_start_chat TINYINT(1) DEFAULT 0";
    }
    if (!in_array('can_view_profiles', $columns)) {
        $alter_queries[] = "ADD COLUMN can_view_profiles TINYINT(1) DEFAULT 1";
    }
    if (!in_array('can_shortlist', $columns)) {
        $alter_queries[] = "ADD COLUMN can_shortlist TINYINT(1) DEFAULT 0";
    }

    if (!empty($alter_queries)) {
        $sql = "ALTER TABLE $table " . implode(', ', $alter_queries);
        $wpdb->query($sql);
    }
}
add_action('after_setup_theme', 'add_membership_feature_columns_if_not_exist');




add_action('template_redirect', 'usabdlp_handle_plan_activation');
function usabdlp_handle_plan_activation()
{
    if (!is_user_logged_in() || !isset($_GET['activate_plan'])) {
        return;
    }

    $user_id = get_current_user_id();
    $plan_id = intval($_GET['activate_plan']);
    global $wpdb;

    // Check plan exists
    $plan = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}membership_plans WHERE id = %d",
        $plan_id
    ));

    if (!$plan || $plan->price > 0) {
        wp_redirect(home_url('/pricing?error=invalid'));
        exit;
    }

    // Set start and end dates
    $start_date = current_time('Y-m-d');
    $end_date = date('Y-m-d', strtotime("+{$plan->duration_days} days"));

    // Remove any existing active memberships
    $wpdb->delete("{$wpdb->prefix}memberships", ['user_id' => $user_id]);

    // Insert new membership
    $wpdb->insert("{$wpdb->prefix}memberships", [
        'user_id' => $user_id,
        'membership_type' => $plan->id,
        'start_date' => $start_date,
        'end_date' => $end_date,
        'status' => 'active',
    ]);

    wp_redirect(home_url('/my-account?success=plan_activated'));
    exit;
}


add_action('wp_ajax_check_duplicate', 'usabdlp_check_duplicate');
add_action('wp_ajax_nopriv_check_duplicate', 'usabdlp_check_duplicate');

function usabdlp_check_duplicate()
{
    global $wpdb;

    $field = sanitize_key($_GET['field'] ?? '');
    $value = sanitize_text_field($_GET['value'] ?? '');

    $allowed_fields = ['username', 'email', 'user_phone', 'user_g_phone'];
    if (!in_array($field, $allowed_fields)) {
        wp_send_json_error(['message' => 'Invalid field']);
    }

    $exists = false;

    if ($field === 'username') {
        $user = get_user_by('login', $value);
        $exists = $user ? true : false;
    } elseif ($field === 'email') {
        $exists = email_exists($value);
    } else {
        $exists = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM {$wpdb->usermeta} WHERE meta_key = %s AND meta_value = %s",
            $field,
            $value
        ));
    }

    wp_send_json_success(['exists' => $exists ? true : false]);
}


// function create_stripe_session($selected_plan_id, $duration, $plan_price) {
//     // Example: Create a Stripe session for the selected plan
// $stripe_secret_key = get_option('usabdlp_payment_client_secret', '');
//     \Stripe\Stripe::setApiKey($stripe_secret_key);

//     $session = \Stripe\Checkout\Session::create([
//         'payment_method_types' => ['card'],
//         'line_items' => [
//             [
//                 'price_data' => [
//                     'currency' => 'usd',
//                     'product_data' => [
//                         'name' => 'Membership Upgrade',
//                     ],
//                     'unit_amount' => $plan_price * 100, // Amount in cents
//                 ],
//                 'quantity' => 1,
//             ],
//         ],
//         'mode' => 'payment',
//         'success_url' => home_url('/payment-success/?session_id={CHECKOUT_SESSION_ID}'),
//         'cancel_url' => home_url('/payment-failed/'),
//     ]);

//     return $session->id;
// }


function activate_default_package_after_premium_expiry()
{
    global $wpdb;

    $current_date = current_time('mysql');
    $default_package_id = intval(get_option('usabdlp_default_package', 0));
    $default_duration_days = intval(get_option('usabdlp_default_duration_days', 365)); // fallback 1 year
    $default_role = get_option('usabdlp_default_role', 'subscriber'); // get role from settings

    if ($default_package_id <= 0) {
        // No default package set, abort
        return;
    }

    // Get expired premium memberships (exclude default package)
    $expired_memberships = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}memberships 
             WHERE status = 'active' 
             AND end_date < %s 
             AND membership_type != %d",
            $current_date,
            $default_package_id
        )
    );

    foreach ($expired_memberships as $membership) {
        // Check if user already has active default package
        $has_default = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT COUNT(*) FROM {$wpdb->prefix}memberships 
                 WHERE user_id = %d 
                 AND membership_type = %d
                 AND status = 'active'",
                $membership->user_id,
                $default_package_id
            )
        );

        if ($has_default) {
            // Already has active default package, skip
            continue;
        }

        // Calculate new end date for default package
        $new_end_date = date('Y-m-d H:i:s', strtotime("+{$default_duration_days} days"));

        // Insert new default membership record
        $wpdb->insert(
            "{$wpdb->prefix}memberships",
            [
                'user_id' => $membership->user_id,
                'membership_type' => $default_package_id,
                'start_date' => current_time('mysql'),
                'end_date' => $new_end_date,
                'status' => 'active',
            ]
        );

        // Update old expired membership status to inactive
        $wpdb->update(
            "{$wpdb->prefix}memberships",
            ['status' => 'expired'],
            ['id' => $membership->id]
        );

        // Assign WordPress role to user
        $user = new WP_User($membership->user_id);
        $user->set_role($default_role);

        // Send notification email to user
        $user_info = get_userdata($membership->user_id);
        if ($user_info && $user_info->user_email) {
            wp_mail(
                $user_info->user_email,
                'Your Membership Has Expired and Downgraded',
                'Your premium membership has expired. You have been downgraded to the default membership plan.'
            );
        }
    }
}

// Schedule daily event if not scheduled
if (!wp_next_scheduled('check_premium_plan_expiry')) {
    wp_schedule_event(time(), 'daily', 'check_premium_plan_expiry');
}

// Hook the function to that event
add_action('check_premium_plan_expiry', 'activate_default_package_after_premium_expiry');

function usabdlp_send_template_email($to_email, $subject, $template_option_key, $placeholders = [])
{
    // Get email template text from settings (default fallback)
    $template = get_option($template_option_key, 'Hello {user}, your membership status has changed.');

    // Replace placeholders in template
    foreach ($placeholders as $key => $value) {
        $template = str_replace('{' . $key . '}', $value, $template);
    }

    // Send HTML email
    wp_mail(
        $to_email,
        $subject,
        $template,
        ['Content-Type: text/html; charset=UTF-8']
    );
}




// Schedule daily event if not scheduled yet
if (!wp_next_scheduled('usabdlp_send_expiry_reminders')) {
    wp_schedule_event(time(), 'daily', 'usabdlp_send_expiry_reminders');
}

add_action('usabdlp_send_expiry_reminders', function () {
    global $wpdb;

    $reminder_days = intval(get_option('usabdlp_expiry_reminder_days', 7));
    $today = current_time('Y-m-d');
    $reminder_date = date('Y-m-d', strtotime("+$reminder_days days", strtotime($today)));

    // Get users with memberships expiring exactly $reminder_days days later
    $users_expiring = $wpdb->get_results($wpdb->prepare(
        "SELECT m.user_id, p.name AS plan_name, m.end_date, u.user_email, u.display_name
         FROM {$wpdb->prefix}memberships m
         JOIN {$wpdb->prefix}membership_plans p ON m.membership_type = p.id
         JOIN {$wpdb->users} u ON m.user_id = u.ID
         WHERE m.status = 'active' AND DATE(m.end_date) = %s",
        $reminder_date
    ));

    foreach ($users_expiring as $user) {
        // Check if reminder already sent today to avoid duplicate emails
        $last_sent = get_user_meta($user->user_id, 'usabdlp_last_expiry_reminder_sent', true);
        if ($last_sent === $today) {
            continue; // Skip if already sent today
        }

        if (function_exists('usabdlp_send_template_email')) {
            usabdlp_send_template_email(
                $user->user_email,
                'Membership Expiry Notice',
                'usabdlp_email_template_expiry_notice',
                [
                    'user' => $user->display_name,
                    'plan' => $user->plan_name,
                    'expiry_date' => date('F j, Y', strtotime($user->end_date)),
                ]
            );

            // Mark reminder as sent for today
            update_user_meta($user->user_id, 'usabdlp_last_expiry_reminder_sent', $today);
        }
    }
});

function usabdlp_send_membership_email($template_option_name, $to_email, $subject, $placeholders = [])
{
    $template = get_option($template_option_name, '');
    if (empty($template)) return false;

    foreach ($placeholders as $key => $value) {
        $template = str_replace("{" . $key . "}", esc_html($value), $template);
    }

    $headers = ['Content-Type: text/html; charset=UTF-8'];
    return wp_mail($to_email, $subject, $template, $headers);
}



// Include TGM in your theme
require_once get_template_directory() . '/inc/TGM-Plugin-Activation/class-tgm-plugin-activation.php';
add_action('tgmpa_register', 'your_theme_register_required_plugins');
function your_theme_register_required_plugins()
{
    $plugins = array(
        array(
            'name' => 'Redux Framework',
            'slug' => 'redux-framework',
            'required' => true,
        ),
    );
    tgmpa($plugins);
}
=======


>>>>>>> 523a812 (Initial commit after system restore)
