<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Dynamic Title -->
    <title><?php wp_title('|', true, 'right'); ?></title>

    <!-- Add Favicon Dynamically -->
    <?php if (get_site_icon_url()): ?>
        <link rel="icon" href="<?php echo esc_url(get_site_icon_url()); ?>" sizes="any">
    <?php endif; ?>

    <!-- Pingback URL -->
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?php wp_title('|', true, 'right'); ?>">
    <meta property="og:description" content="<?php echo esc_attr(get_bloginfo('description')); ?>">
    <meta property="og:url" content="<?php echo esc_url(home_url($wp->request)); ?>">
    <meta property="og:image" content="<?php echo esc_url(get_the_post_thumbnail_url()); ?>">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?php echo esc_attr(get_bloginfo('name')); ?>">

    <!-- SEO Meta Description -->
    <meta name="description" content="<?php echo esc_attr(get_bloginfo('description')); ?>">

    <!-- Canonical URL -->
    <link rel="canonical" href="<?php echo esc_url(home_url($wp->request)); ?>">

    <!-- Output WordPress Head Hook -->
    <?php wp_head(); ?>
</head>

<body>

    <section id="header">


        <div class="topbar theme-bg py-2">
            <div class="container d-flex justify-content-between align-items-center flex-wrap">
                <!-- Left Side: Phone and Email -->
                <div class="topbar-left d-lg-flex align-items-center d-none">
                    <?php
                    $phone = get_theme_mod('contact_phone', '+1 234 567 890');
                    $email = get_theme_mod('contact_email', 'info@yourdomain.com');
                    ?>

                    <a href="tel:<?php echo esc_attr($phone); ?>" class="me-3 text-white">
                        <i class="bi bi-telephone"></i> <?php echo esc_html($phone); ?>
                    </a>
                    <span class="text-white me-3">|</span> <!-- Divider -->
                    <a href="mailto:<?php echo esc_attr($email); ?>" class="text-white">
                        <i class="bi bi-envelope"></i> <?php echo esc_html($email); ?>
                    </a>
                </div>

                <!-- Right Side: Social Icons -->
                <div
                    class="topbar-right d-flex align-items-center w-auto flex-grow-1 justify-content-lg-end justify-content-center">
                    <span class="text-white me-3">Follow Us</span>

                    <?php
                    $social_icons = array(
                        'facebook' => 'bi-facebook',
                        'twitter' => 'bi-twitter',
                        'instagram' => 'bi-instagram',
                        'linkedin' => 'bi-linkedin',
                    );

                    foreach ($social_icons as $platform => $icon) {
                        $url = get_theme_mod("social_$platform");
                        if (!empty($url)) {
                            echo '<a href="' . esc_url($url) . '" class="text-white me-3" target="_blank"><i class="bi ' . esc_attr($icon) . '"></i></a>';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>




        <nav class="navbar navbar-expand-lg navbar-light w-100 shadow bg-white">
            <div class="container-xl">
                <a class="d-flex text-white" href="<?php echo esc_url(home_url('/')); ?>">
                    <?php
                    $logo = get_theme_mod('site_logo');
                    if ($logo): ?>
                        <img src="<?php echo esc_url($logo); ?>" alt="Logo" class="site-logo">
                    <?php else: ?>
                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/image/Logo.png" alt="Logo"
                            class="site-logo">
                    <?php endif; ?>
                </a>

                <button class="navbar-toggler offcanvas-nav-btn  ms-auto me-3" type="button">
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/image/icons-svg/list.svg" width="40"
                        height="40" alt="Open TemplateOnweb website menu" />
                </button>
                <div class="offcanvas offcanvas-start offcanvas-nav" style="width: 20rem">
                    <div class="offcanvas-header shadow">
                        <a class="d-flex text-white" href="<?php echo esc_url(home_url('/')); ?>">
                            <?php
                            $logo = get_theme_mod('site_logo');
                            if ($logo): ?>
                                <img src="<?php echo esc_url($logo); ?>" alt="Logo" class="site-logo">
                            <?php else: ?>
                                <img src="<?php echo esc_attr(get_bloginfo('name')); ?>?>/image//Logo.png" alt="Logo"
                                    class="site-logo">
                            <?php endif; ?>
                        </a>

                        <i class="bi bi-x-lg" data-bs-dismiss="offcanvas" aria-label="Close"
                            alt="Close TemplateOnweb website menu"></i>

                    </div>
                    <div class="offcanvas-body pt-0 align-items-center">
                        <ul class="navbar-nav align-items-lg-center ms-auto">
                            <?php
                            wp_nav_menu(array(
                                'theme_location' => 'primary-menu',
                                'container' => false,
                                'items_wrap' => '%3$s', // Removes the default wrapper <ul>
                                'depth' => 2, // Allows for dropdowns
                                'walker' => new WP_Bootstrap_Navwalker(), // For Bootstrap compatibility
                            ));
                            ?>
                        </ul>

                        <ul class="navbar-nav align-items-lg-center ms-auto">
                        <?php if (is_user_logged_in()): ?>
    <?php 
    $current_user = wp_get_current_user();
    $avatar = get_avatar($current_user->ID, 40, '', '', ['class' => 'rounded-profile']); // Add custom class
    $profile_url = home_url('my-account');
    $logout_url = wp_logout_url(home_url('/')); // Redirect to homepage after logout

    // Get the current user ID
$user_id = get_current_user_id();

// Fetch the profile picture URL (assuming it's stored in user_meta)
$profile_picture = get_user_meta($user_id, 'user_avatar', true);

//If no profile picture is set, use a default placeholder
if (empty($profile_picture)) {
    $profile_picture = get_template_directory_uri() . '/image/avater.webp'; // Path to your default avatar
}
    ?>



    <li class="nav-item dropdown drop_border">
        <a class="nav-link dropdown-toggle fs-4" href="#" id="userDropdown" role="button"
            data-bs-toggle="dropdown" aria-expanded="false">
            <img alt="" src="<?php echo $profile_picture;?>" class="avatar avatar-40 photo rounded-profile" height="40" width="40" decoding="async">
        </a>
        <ul class="dropdown-menu drop_1 drop_log shadow" aria-labelledby="userDropdown">
            <li><a class="dropdown-item" href="<?php echo esc_url($profile_url); ?>">My Profile</a></li>
            <li><a class="dropdown-item border-0" href="<?php echo esc_url(home_url('/logout')); ?>">Logout</a></li>

        </ul>
    </li>
<?php else: ?>
    <li class="nav-item dropdown drop_border">
        <a class="nav-link dropdown-toggle fs-4" href="#" id="navbarDropdown" role="button"
            data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person"></i>
        </a>
        <ul class="dropdown-menu drop_1 drop_log shadow" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="<?php echo esc_url(wp_login_url()); ?>">Login</a></li>
            <li><a class="dropdown-item border-0" href="<?php echo esc_url(home_url('/signup')); ?>">Register</a></li>
        </ul>
    </li>
<?php endif; ?>



    <li class="nav-item dropdown drop_border">
    <?php if (is_user_logged_in()): ?>
    <?php
    global $wpdb;
    $user_id = get_current_user_id();
    $notifications = $wpdb->get_results($wpdb->prepare("
        SELECT * FROM {$wpdb->prefix}notifications 
        WHERE user_id = %d AND read_status = 0 
        ORDER BY created_at DESC LIMIT 5
    ", $user_id));
    $count = count($notifications);
    ?>
    <div class="notification-bell">
        <a href="<?php echo esc_url(home_url('/notifications')); ?>">
            🔔
            <?php if ($count > 0): ?>
                <span class="badge"><?php echo esc_html($count); ?></span>
            <?php endif; ?>
        </a>
    </div>
<?php endif; ?>

    </li>
</ul>

                    </div>
                </div>
            </div>
            </div>
        </nav>
    </section>