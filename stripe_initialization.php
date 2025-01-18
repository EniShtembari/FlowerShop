<?php
// Check if the required Stripe PHP SDK exists
if (!file_exists('stripe-php/init.php')) {
    die("Error: Stripe PHP SDK is not installed. Please install the Stripe PHP library.");
}

require_once 'stripe-php/init.php';

// Configuration
$private_key = "sk_test_51QdZaOIA6j8Agjdo5GJTLy0SpIDPNae1bPpzug7GTqcDIUlNR7CKK1ojTH9gGYRe0uEHUjbnpIDGSKukUVTONETg00wfXvfRpk";
$public_key = "pk_test_51QdZaOIA6j8AgjdoONN2YmHKTojcogE82ZcF8ntm0l1YwdZNUKNnlDgxb62vZ7IBVbS1NfyGQoRNxjWn6o0bvJxE00alHhiENc";
$stripe_account = "Test";
$businessName = "Test";
$company_name = "Test";

try {
    // Initialize Stripe with the private key
    \Stripe\Stripe::setApiKey($private_key);

    // Optional: Set network retries for better reliability
    // \Stripe\Stripe::setMaxNetworkRetries(2);

    // Initialize Stripe client
    $stripe = new \Stripe\StripeClient($private_key);

    // Verify the connection by making a simple API call
    $stripe->accounts->retrieve();

} catch (\Stripe\Exception\AuthenticationException $e) {
    error_log("Stripe Authentication Error: " . $e->getMessage());
    die("Error: Invalid API key provided.");
} catch (\Stripe\Exception\ApiConnectionException $e) {
    error_log("Stripe Connection Error: " . $e->getMessage());
    die("Error: Could not connect to Stripe. Please check your internet connection.");
} catch (\Exception $e) {
    error_log("Stripe Initialization Error: " . $e->getMessage());
    die("Error: Unable to initialize Stripe payment system.");
}
?>