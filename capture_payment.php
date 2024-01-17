<?php
require 'vendor/autoload.php';
include_once "config.php";

try {
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);
    $paymentIntentId = $data['paymentIntentId'];

    $stripe = new \Stripe\StripeClient(STRIPE_KEY);
    $terminal = $stripe->terminal->readers->processPaymentIntent(
        TERMINAL_ID,
        ['payment_intent' => $paymentIntentId]
    );

    $paymentIntent = $stripe->paymentIntents->retrieve($paymentIntentId, []);
    $maxAttempts = 5;
    $attempts = 0;
        $stripe->testHelpers->terminal->readers->presentPaymentMethod(TERMINAL_ID, []);
    while ($paymentIntent->status !== 'requires_capture' && $attempts < $maxAttempts) {
        // Add a delay to avoid making too many API requests in a short time
        sleep(10);

        // Retrieve the PaymentIntent again to check its status
        $paymentIntent = $stripe->paymentIntents->retrieve($paymentIntentId, []);

        $attempts++;

        if ($attempts >= $maxAttempts) {
            // If the maximum number of attempts is reached, terminate the script
            $paymentIntent->cancel();
            $stripe->terminal->readers->cancelAction(TERMINAL_ID, []);
            http_response_code(500);
            echo json_encode(['status' => 'failed', 'redirectUrl' => $domain.'/Stripe.php']);
            exit;
        }
    }

    // Capture the payment
    $data =  $stripe->paymentIntents->capture($paymentIntentId, []);

    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'paymentIntentId' => $paymentIntentId, 'data' => $data]);
} catch (\Exception $e) {
    // Respond with a JSON-encoded error message
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

?>
