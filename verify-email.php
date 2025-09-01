<?php
/**
 * Template Name: Verify Email
 */
get_header();
?>
<style>
/* Animation Styles */
@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {transform: translateY(0);}
    40% {transform: translateY(-20px);}
    60% {transform: translateY(-10px);}
}

@keyframes shake {
    0%, 100% {transform: translateX(0);}
    10%, 30%, 50%, 70%, 90% {transform: translateX(-5px);}
    20%, 40%, 60%, 80% {transform: translateX(5px);}
}

@keyframes pulse {
    0% {transform: scale(1); opacity: 1;}
    50% {transform: scale(1.1); opacity: 0.7;}
    100% {transform: scale(1); opacity: 1;}
}

.icon-container {
    margin: 20px auto;
    text-align: center;
}

.success-icon {
    animation: bounce 1s ease;
}

.error-icon {
    animation: shake 0.5s ease;
}

.warning-icon {
    animation: pulse 1.5s infinite;
}
</style>

<?php
$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
$token = isset($_GET['token']) ? sanitize_text_field($_GET['token']) : '';

if ($user_id && $token) {
    $saved_token = get_user_meta($user_id, 'email_verification_token', true);
    if ($token === $saved_token) {
        update_user_meta($user_id, 'email_verified', true);
        delete_user_meta($user_id, 'email_verification_token');
        ?>
        <div style="padding: 100px; text-align: center;">
            <div class="icon-container">
                <svg class="success-icon" width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12" cy="12" r="10" stroke="#4CAF50" stroke-width="2"/>
                    <path d="M8 12l3 3 5-6" stroke="#4CAF50" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h2>Email Verified Successfully</h2>
            <p>Your email has been confirmed. Please wait for admin approval to access your account.</p>
        </div>
        <?php
    } else {
        ?>
        <div style="padding: 100px; text-align: center;">
            <div class="icon-container">
                <svg class="error-icon" width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12" cy="12" r="10" stroke="#F44336" stroke-width="2"/>
                    <path d="M15 9l-6 6M9 9l6 6" stroke="#F44336" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>
            <h2>Invalid Token</h2>
            <p>The verification link is invalid or has already been used.</p>
        </div>
        <?php
    }
} else {
    ?>
    <div style="padding: 100px; text-align: center;">
        <div class="icon-container">
            <svg class="warning-icon" width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="12" cy="12" r="10" stroke="#FF9800" stroke-width="2"/>
                <path d="M12 8v4M12 16h.01" stroke="#FF9800" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </div>
        <h2>Missing Information</h2>
        <p>Invalid verification link.</p>
    </div>
    <?php
}
get_footer();