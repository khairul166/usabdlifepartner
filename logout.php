<?php
/**
 * Template Name: Force Logout
 */

session_start(); // Start session to clear session data
wp_logout(); // Log out the user
wp_destroy_current_session(); // Destroy any active session
wp_clear_auth_cookie(); // Clear authentication cookies
wp_set_current_user(0); // Reset user session
session_destroy(); // Destroy PHP session

// Redirect to homepage after logout
wp_redirect(home_url('/'));
exit();
?>
