<?php

require 'vendor/autoload.php';
include_once "config.php";

try {
    // Get the amount from the POST request
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);
    $amount = $data['amount'];

    $stripe = new \Stripe\StripeClient(STRIPE_KEY);

    $intent = $stripe->paymentIntents->create([
        'currency' => 'usd',
        'payment_method_types' => ['card_present'],
        'capture_method' => 'manual',
        'amount' => $amount,
    ]);

    // Respond with a JSON-encoded success message
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'paymentIntentId' => $intent->id]);
} catch (\Exception $e) {
    // Respond with a JSON-encoded error message
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}


?>





