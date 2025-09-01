<?php
require_once('../../../wp-load.php');
$enable_payment = intval(get_option('enable_payment', 1));
if (!$enable_payment) {
    wp_die('Membership upgrade is currently disabled.');
}
if (!is_user_logged_in() || !isset($_POST['upgrade_plan'])) {
    wp_die('Unauthorized access.');
}

$current_user = wp_get_current_user();

// Fetch settings for tax, currency, etc.
$tax_percent = floatval(get_option('usabdlp_tax_percent', 5));
$tax_inclusive = intval(get_option('usabdlp_tax_inclusive', 0));
$currency_code = get_option('usabdlp_currency_code', 'usd');

// Gather posted data
$selected_plan_id   = intval($_POST['selected_plan_id'] ?? 0);
$new_price          = floatval($_POST['selected_plan_price'] ?? 0);
$new_duration       = intval($_POST['plan_duration'] ?? 1);
$current_plan_paid  = floatval($_POST['current_plan_paid_amount'] ?? 0);
$current_plan_start = strtotime($_POST['current_plan_start_date'] ?? '');

if (!$selected_plan_id || !$new_price || !$new_duration) {
    wp_die('Invalid upgrade plan data.');
}

// Calculate months already used, capped by new_duration
$months_used = floor((time() - $current_plan_start) / (30 * 24 * 60 * 60));
$months_used = max(0, min($months_used, $new_duration));

// Calculate new plan subtotal and tax
if ($tax_inclusive) {
    $new_subtotal = $new_price * $new_duration;
    $new_tax = $new_subtotal * $tax_percent / (100 + $tax_percent);
    $new_total = $new_subtotal;
} else {
    $new_subtotal = $new_price * $new_duration;
    $new_tax = $new_subtotal * $tax_percent / 100;
    $new_total = $new_subtotal + $new_tax;
}

// Calculate used value of old plan (assuming 12 months standard for old plan)
$monthly_old_value = $current_plan_paid / 12;
$used_value = $monthly_old_value * $months_used;

// Calculate final amount to pay (no negative)
$amount_to_pay = round(max(0, $new_total - $used_value), 2);

// Convert to cents
$plan_price_in_cents = round($amount_to_pay * 100);

// Include Stripe
require_once get_template_directory() . '/inc/stripe/vendor/autoload.php';
$stripe_secret_key = get_option('usabdlp_payment_client_secret', '');
\Stripe\Stripe::setApiKey($stripe_secret_key);

// Get plan name for product info
global $wpdb;
$plan = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}membership_plans WHERE id = %d", $selected_plan_id));
$plan_name = $plan ? $plan->name : 'Upgraded Membership Plan';

try {
    $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => strtolower($currency_code),
                'product_data' => [
                    'name' => 'Upgrade to ' . $plan_name,
                ],
                'unit_amount' => $plan_price_in_cents,
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'metadata' => [
            'user_id'      => $current_user->ID,
            'plan_id'      => $selected_plan_id,
            'duration'     => $new_duration,
            'upgrade_type' => 'membership_upgrade',
            'total_paid'   => $amount_to_pay,
        ],
        'customer_email' => $current_user->user_email,
        'success_url'    => get_site_url() . '/upgrade-success/?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url'     => get_site_url() . '/upgrade-cancel/?session_id={CHECKOUT_SESSION_ID}',
    ]);

    wp_redirect($session->url);
    exit;

} catch (Exception $e) {
    wp_die('Error creating payment session: ' . esc_html($e->getMessage()));
}
