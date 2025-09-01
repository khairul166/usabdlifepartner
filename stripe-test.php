<?php
// Include the Stripe PHP SDK
require_once get_template_directory() . '/inc/stripe/lib/Stripe.php'; // Adjust path if needed
\Stripe\Stripe::setApiKey('sk_test_51RD9q2Qq0KZUzGNUcMChuivZRD2oXsKZxvN7ps6B6DkaOqXLvhY3BN9RROFxUKe1HFNZkjN0IZaSsc0yZf6d78ha00mpguVCol'); // Replace with your actual secret key

// Test the connection to Stripe
try {
    // Fetch balance from Stripe as a test
    $balance = \Stripe\Balance::retrieve();
    echo 'Stripe connection successful: ' . $balance->available[0]->amount;
} catch (\Stripe\Exception\ApiErrorException $e) {
    // If there's an error, display the error message
    echo 'Error connecting to Stripe: ' . $e->getMessage();
}
