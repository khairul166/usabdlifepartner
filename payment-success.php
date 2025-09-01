<?php 
if (!headers_sent()) {
    ob_start();
}

get_header();

require_once get_template_directory() . '/inc/stripe/vendor/autoload.php';

// Get Stripe secret key from settings
$stripe_secret_key = get_option('usabdlp_payment_client_secret', '');
\Stripe\Stripe::setApiKey($stripe_secret_key);

$sessionId = isset($_GET['session_id']) ? sanitize_text_field($_GET['session_id']) : '';

try {
    if (!$sessionId) {
        throw new Exception('Missing session ID.');
    }

    $session = \Stripe\Checkout\Session::retrieve($sessionId);

    if ($session->payment_status === 'paid') {
        $metadata = $session->metadata;
        $email = sanitize_email($session->customer_email);
        $username = sanitize_user($metadata->username ?? '');
        $password = $metadata->password ?? '';
        $confirm_password = $metadata->repassword ?? '';

        if (email_exists($email)) {
            echo "<p style='color:red;'>User already exists with this email.</p>";
            get_footer();
            exit;
        }

        if ($password !== $confirm_password) {
            echo "<p style='color:red;'>Passwords do not match.</p>";
            get_footer();
            exit;
        }

        $user_id = wp_create_user($username, $password, $email);

        if (is_wp_error($user_id)) {
            echo "<p style='color:red;'>Error: " . esc_html($user_id->get_error_message()) . "</p>";
            get_footer();
            exit;
        }

        // Log the user in immediately
        wp_clear_auth_cookie();
        wp_set_current_user($user_id);
        wp_set_auth_cookie($user_id, true, is_ssl());
        do_action('wp_login', $username, get_user_by('id', $user_id));

        // Save membership info
        global $wpdb;
        $wpdb->insert("{$wpdb->prefix}memberships", [
            'user_id' => $user_id,
            'membership_type' => intval($metadata->hidden_selected_plan_id),
            'start_date' => current_time('mysql', true),  // Use GMT
            'end_date' => date('Y-m-d H:i:s', strtotime("+" . intval($metadata->select_plan_duration) . " months")),
            'status' => 'active',
            'created_at' => current_time('mysql', true)  // Use GMT
        ]);
        

        // Assign default user role
        $default_role = get_option('usabdlp_default_role', 'subscriber');
        $user = new WP_User($user_id);
        $user->set_role($default_role);

        // Prepare billing invoice email
        $plan_name = $wpdb->get_var($wpdb->prepare("SELECT name FROM {$wpdb->prefix}membership_plans WHERE id = %d", intval($metadata->hidden_selected_plan_id)));
        $duration = intval($metadata->select_plan_duration);
        $expiry_date = date('F j, Y', strtotime("+" . $duration . " months"));
        $total_paid = floatval($metadata->total_paid ?? 0);

        $invoice_html = "
            <h2>Invoice for Your Payment</h2>
            <p><strong>User:</strong> {$username}</p>
            <p><strong>Plan:</strong> {$plan_name}</p>
            <p><strong>Duration:</strong> {$duration} month(s)</p>
            <p><strong>Amount Paid:</strong> $" . number_format($total_paid, 2) . "</p>
            <p><strong>Expiry Date:</strong> {$expiry_date}</p>
        ";

        wp_mail(
            $email,
            "Your Billing Invoice - {$plan_name}",
            $invoice_html,
            ['Content-Type: text/html; charset=UTF-8']
        );

        // Send payment success email template
        if (function_exists('usabdlp_send_membership_email')) {
            usabdlp_send_membership_email(
                'usabdlp_email_template_payment_success',
                $email,
                'Welcome to Our Membership',
                [
                    'user' => $username,
                    'plan' => $plan_name,
                    'expiry_date' => $expiry_date,
                ]
            );
        }

        // Email verification token and mail
        $token = bin2hex(random_bytes(16));
        update_user_meta($user_id, 'email_verification_token', $token);
        update_user_meta($user_id, 'email_verified', 0);

        $verification_url = home_url("/verify-email/?token=$token&user_id=$user_id");

        wp_mail(
            $email,
            'Verify Your Email',
            "Please verify your email by clicking here: <a href='$verification_url'>$verification_url</a>",
            ['Content-Type: text/html']
        );

        ?>
        <section id="center" class="search_form pt-5 pb-5">
            <div class="container-xl">
                <div class="row search_form1 p-4 w-50 mx-auto">
                    <div class="col-md-12 text-center">
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/image/7efs.gif'); ?>" alt="Loading..." class="img-fluid mb-3" width="100" height="100" />
                        <h2>Payment Successful!</h2>
                        <p>Redirecting to your account...</p>
                        <?php if (!is_user_logged_in()) : ?>
                            <p class="text-danger">Warning: Login session not detected.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

        <script>
            setTimeout(function() {
                window.location.href = "<?php echo esc_url(home_url('/my-account')); ?>";
            }, 5000);
        </script>
        <?php
    } else {
        echo "<p style='color:red;'>Payment not completed. Status: " . esc_html($session->payment_status) . "</p>";
    }
} catch (Exception $e) {
    echo "<p style='color:red;'>Stripe Error: " . esc_html($e->getMessage()) . "</p>";
    error_log("Stripe Error: " . $e->getMessage());
}

get_footer();
ob_end_flush();
