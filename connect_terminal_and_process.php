<?php
require 'vendor/autoload.php';

\Stripe\Stripe::setApiKey('sk_test_51I6nlCEI9kfffDKAR3KOEmslSinEpQqYIBZklxgWblObeco9HVCFT9uEC7Van4Hz9fxHN6clzuHL2FqHuniOFhUR00Yvihxmhb');

$paymentIntentId = $_POST['paymentIntentId'];

$stripe = new \Stripe\StripeClient('sk_test_51I6nlCEI9kfffDKAR3KOEmslSinEpQqYIBZklxgWblObeco9HVCFT9uEC7Van4Hz9fxHN6clzuHL2FqHuniOFhUR00Yvihxmhb');

// Correct terminal reader ID
$terminal = $stripe->terminal->readers->processPaymentIntent(
    'tmr_FYjToAzn9WAFdP',
    ['payment_intent' => $paymentIntentId]
);

// If necessary, perform additional processing here

http_response_code(200);
?>
