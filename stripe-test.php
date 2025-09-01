<?php
// Include the Stripe PHP SDK
require_once get_template_directory() . '/inc/stripe/lib/Stripe.php'; // Adjust path if needed
$stripe_secret_key = get_option('usabdlp_payment_client_secret', '');
\Stripe\Stripe::setApiKey($stripe_secret_key); // Replace with your actual secret key

// Test the connection to Stripe
try {
    // Fetch balance from Stripe as a test
    $balance = \Stripe\Balance::retrieve();
    echo 'Stripe connection successful: ' . $balance->available[0]->amount;
} catch (\Stripe\Exception\ApiErrorException $e) {
    // If there's an error, display the error message
    echo 'Error connecting to Stripe: ' . $e->getMessage();
}
