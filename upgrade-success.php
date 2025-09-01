<?php

/**
 * Template Name: Upgrade Success
 */

if (!headers_sent()) {
    ob_start();
}

get_header();

use Stripe\Stripe;
use Stripe\Checkout\Session;

require_once get_template_directory() . '/inc/stripe/vendor/autoload.php';

$stripe_secret_key = get_option('usabdlp_payment_client_secret', '');
Stripe::setApiKey($stripe_secret_key);

if (!isset($_GET['session_id'])) {
    echo "<p>Error: Session ID missing.</p>";
    get_footer();
    exit;
}

$session_id = sanitize_text_field($_GET['session_id']);

try {
    $session  = Session::retrieve($session_id);
    $metadata = $session->metadata;

    $user_id  = intval($metadata->user_id);
    $plan_id  = intval($metadata->plan_id);
    $duration = intval($metadata->duration);

    global $wpdb;

    // Expire previous active memberships
    $wpdb->update(
        "{$wpdb->prefix}memberships",
        ['status' => 'expired'],
        ['user_id' => $user_id, 'status' => 'active']
    );

    $start_date = current_time('mysql', true); // Use GMT
    $end_date   = date('Y-m-d H:i:s', strtotime("+$duration months"));
    
    // Insert new upgraded membership
    $wpdb->insert("{$wpdb->prefix}memberships", [
        'user_id'         => $user_id,
        'membership_type' => $plan_id,
        'start_date'      => $start_date,
        'end_date'        => $end_date,
        'status'          => 'active',
        'created_at'      => current_time('mysql', true), // Use GMT
    ]);
    

    $user_info = get_userdata($user_id);
    $plan = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}membership_plans WHERE id = %d", $plan_id));
    $plan_name = $plan ? $plan->name : 'Membership Plan';
    $expiry_date = date('F j, Y', strtotime("+$duration months"));
    $total_paid = floatval($metadata->total_paid ?? 0);

    // Send billing invoice email
    $invoice_html = "
        <h2>Invoice for Your Payment</h2>
        <p><strong>User:</strong> {$user_info->display_name}</p>
        <p><strong>Plan:</strong> {$plan_name}</p>
        <p><strong>Duration:</strong> {$duration} month(s)</p>
        <p><strong>Amount Paid:</strong> $" . number_format($total_paid, 2) . "</p>
        <p><strong>Expiry Date:</strong> {$expiry_date}</p>
    ";

    wp_mail(
        $user_info->user_email,
        "Your Billing Invoice - {$plan_name}",
        $invoice_html,
        ['Content-Type: text/html; charset=UTF-8']
    );

// Send upgrade confirmation email
if (function_exists('usabdlp_send_template_email')) {
    usabdlp_send_template_email(
        $user_info->user_email,
        'Membership Upgrade Confirmation',
        'usabdlp_email_template_upgrade_success',
        [
            'user' => $user_info->display_name,
            'plan' => $plan_name,
            'expiry_date' => $expiry_date,
        ]
    );
}
?>
    <section id="center" class="search_form pt-5 pb-5">
        <div class="container-xl">
            <div class="row search_form1 p-4 w-50 mx-auto">
                <div class="col-md-12 text-center">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/image/7efs.gif'); ?>" alt="Loading..." class="img-fluid mb-3" width="100" height="100">
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
} catch (Exception $e) {
    echo "<p>Error verifying payment: " . esc_html($e->getMessage()) . "</p>";
}

get_footer();
ob_end_flush();
