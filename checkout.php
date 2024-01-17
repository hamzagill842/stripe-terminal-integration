<?php
require 'vendor/autoload.php';

include_once 'config.php';

use Stripe\StripeClient;

$stripe = new StripeClient([
    "api_key" => STRIPE_KEY
]);

// Check if it's a POST request to create a Checkout Session
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $checkout_session = $stripe->checkout->sessions->create([
        'line_items' => [[
            'price_data' => [
                'currency' => 'usd',
                'product_data' => [
                    'name' => 'T-shirt',
                ],
                'unit_amount' => 2000,
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'ui_mode' => 'embedded',
        'payment_method_types' => ['card'],
        'return_url' => 'https://example.com/checkout/success?session_id={CHECKOUT_SESSION_ID}',
    ]);

    echo json_encode(array('clientSecret' => $checkout_session->client_secret));
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stripe Checkout</title>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
<div id="checkout">
    <!-- Checkout will insert the payment form here -->
</div>

<script>
    const stripe = Stripe('<?php echo STRIPE_PUBLIC_KEY; ?>');

    initialize();

    // Fetch Checkout Session and retrieve the client secret
    async function initialize() {
        const response = await fetch("", { method: "POST" }); // Update with the correct endpoint

        const { clientSecret } = await response.json();

        const checkout = await stripe.initEmbeddedCheckout({
            clientSecret,
        });

        // Mount Checkout
        checkout.mount('#checkout');
    }
</script>
</body>
</html>
