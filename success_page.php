<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
    <style>
        body {
            background-color: #f0f0f0;
            font-family: 'Arial', sans-serif;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .card {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 500px;
            width: 100%;
            box-sizing: border-box;
            text-align: center;
        }

        h1, h2, p {
            margin: 0;
        }

        h1 {
            color: #2ecc71; /* Green color for heading */
        }

        h2 {
            color: #333; /* Dark gray color for subheading */
            margin-top: 20px;
        }

        p {
            color: #555; /* Medium gray color for text */
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <div class="card">
        <h1>Payment Successful!</h1>
        <p>Thank you for your payment.</p>

        <?php
            $amount = $_GET['amount'];
            $totalamount = $_GET['totalamount'];
            $amount_received = $_GET['amount_received'];
            $transactionId = $_GET['transactionId'];
            $status = $_GET['status'];
            $currency = $_GET['currency'];
        ?>

        <div>
            <h2>Transaction Details:</h2>
            <p>Amount: $<?php echo number_format($amount / 100, 2); ?></p>
            <p>Total Amount: $<?php echo number_format($totalamount / 100, 2); ?></p>
            <p>Amount Received: $<?php echo number_format($amount_received / 100, 2); ?></p>
            <p>Transaction ID: <?php echo $transactionId; ?></p>
            <p>Status: <?php echo $status; ?></p>
            <p>Currency: <?php echo $currency; ?></p>
        </div>
    </div>

</body>
</html>
