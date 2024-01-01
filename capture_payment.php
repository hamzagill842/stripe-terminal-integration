<?php
require 'vendor/autoload.php';
include_once "config.php";

try {
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);
    $paymentIntentId = $data['paymentIntentId'];

    $stripe = new \Stripe\StripeClient(STRIPE_KEY);

    // Correct terminal reader ID
    $terminal = $stripe->terminal->readers->processPaymentIntent(
        TERMINAL_ID,
        ['payment_intent' => $paymentIntentId]
    );

    // Present the payment method to the reader
    $stripe->testHelpers->terminal->readers->presentPaymentMethod(TERMINAL_ID, []);

    // Capture the payment
    $data =  $stripe->paymentIntents->capture($paymentIntentId, []);

    // Respond with a JSON-encoded success message  
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'paymentIntentId' => $paymentIntentId, 'data' => $data]);
} catch (\Exception $e) {
    // Respond with a JSON-encoded error message
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}



?>
