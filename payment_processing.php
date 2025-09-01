<?php

// Load WordPress environment (adjust path as needed)
require_once('../../../wp-blog-header.php');

$enable_payment = intval(get_option('enable_payment', 1));
if ($enable_payment) {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        wp_die('Invalid request.');
    }

    // Load Stripe
    require_once get_template_directory() . '/inc/stripe/vendor/autoload.php';

    $stripe_secret_key = get_option('usabdlp_payment_client_secret', '');
    \Stripe\Stripe::setApiKey($stripe_secret_key);

    // Get posted form data safely
    $plan_id = intval($_POST['hidden_selected_plan_id'] ?? 0);
    $plan_price = floatval($_POST['selected_plan_price'] ?? 0);
    $plan_duration = intval($_POST['select_plan_duration'] ?? 1);

    if (!$plan_id || !$plan_price || !$plan_duration) {
        wp_die('Invalid plan or pricing data.');
    }

    // Tax and currency from settings
    $tax_percent = floatval(get_option('usabdlp_tax_percent', 5));
    $tax_inclusive = intval(get_option('usabdlp_tax_inclusive', 0));
    $currency_code = get_option('usabdlp_currency_code', 'usd');

    // Calculate subtotal, tax, and total
    if ($tax_inclusive) {
        $subtotal = $plan_price * $plan_duration;
        $tax = $subtotal * $tax_percent / (100 + $tax_percent);
        $total = $subtotal;
    } else {
        $subtotal = $plan_price * $plan_duration;
        $tax = $subtotal * $tax_percent / 100;
        $total = $subtotal + $tax;
    }

    // Amount in cents for Stripe
    $amount_in_cents = round($total * 100);

    // Prepare metadata fields to store user info (sanitize as needed)
    $metadata_fields = [
        'username',
        'email',
        'password',
        'repassword',
        'profileby',
        'lookingfor',
        'fname',
        'lname',
        'religion',
        'dob',
        'maritalstatus',
        'user_gender',
        'education',
        'user_profession',
        'country',
        'division',
        'district',
        'upazila',
        'village',
        'landmark',
        'guardian_country_code',
        'user_phone',
        'user_g_phone',
        'candidate_country_code',
        'state',
        'city',
        'usaLandmark',
        'hidden_selected_plan_id',
        'select_plan_duration'
    ];

    $metadata = [];
    foreach ($metadata_fields as $field) {
        $metadata[$field] = isset($_POST[$field]) ? sanitize_text_field($_POST[$field]) : '';
    }

    // Add total_paid to metadata
    $metadata['total_paid'] = $total;

    try {
        $plan = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}membership_plans WHERE id = %d", $plan_id));
        $plan_name = $plan ? $plan->name : 'Membership Plan';

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => strtolower($currency_code),
                    'product_data' => [
                        'name' => $plan_name,
                    ],
                    'unit_amount' => $amount_in_cents,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'metadata' => $metadata,
            'customer_email' => sanitize_email($_POST['email'] ?? ''),
            'success_url' => get_site_url() . '/payment-success/?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => get_site_url() . '/payment-cancel/?session_id={CHECKOUT_SESSION_ID}',
        ]);

        wp_redirect($session->url);
        exit;
    } catch (Exception $e) {
        wp_die('Error creating payment session: ' . esc_html($e->getMessage()));
    }
}
