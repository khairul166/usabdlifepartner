<?php
/**
 * Template Name: Verify Email
 */

get_header();

$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
$token = isset($_GET['token']) ? sanitize_text_field($_GET['token']) : '';

if ($user_id && $token) {
    $saved_token = get_user_meta($user_id, 'email_verification_token', true);

    if ($token === $saved_token) {
        update_user_meta($user_id, 'email_verified', true);
        delete_user_meta($user_id, 'email_verification_token');

        echo "<div style='padding: 20px; text-align: center;'>
                <h2>✅ Email Verified Successfully</h2>
                <p>Your email has been confirmed. Please wait for admin approval to access your account.</p>
              </div>";
    } else {
        echo "<div style='padding: 20px; text-align: center;'>
                <h2>❌ Invalid Token</h2>
                <p>The verification link is invalid or has already been used.</p>
              </div>";
    }
} else {
    echo "<div style='padding: 20px; text-align: center;'>
            <h2>❌ Missing Information</h2>
            <p>Invalid verification link.</p>
          </div>";
}

get_footer();
