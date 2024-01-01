<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Awesome Stripe Payment</title>
    <style>
        body {
            background-color: #121212; 
            font-family: 'Arial', sans-serif;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        #payment-form {
            background-color: #1e1e1e; 
            border-radius: 15px; 
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5); 
            padding: 40px;
            max-width: 500px;
            width: 100%;
            box-sizing: border-box;
            position: relative; /* To position loader relative to this container */
        }
        #amountInput {
            height: 30px;
            width: 100%; 
            padding: 20px; 
            margin-bottom: 20px;
            border: 7px solid white;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 16px;
        }

        button {
            background-color: #4CAF50;
            color: #fff;
            padding: 15px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3); 
            transition: background-color 0.3s ease;
            width: 100%;
        }

        button:hover {
            background-color: #45a049;
        }

        #captureBtn {
            background-color: #3498db;
            margin-top: 10px;
        }

        #loader {
            display: none;
            width: 30px; /* Adjusted width */
            height: 30px; /* Adjusted height */
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            position: absolute;
            top: 50%;
            left: 50%;
            margin-top: -15px; /* Half of the height */
            margin-left: -15px; /* Half of the width */
        }

        #notification {
            margin-top: 20px;
            padding: 15px;
            background-color: #2ecc71;
            color: #fff;
            border-radius: 8px;
            display: none;
            text-align: center;
            font-size: 16px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>

<div id="payment-form">
    <label for="amount">Enter Amount:</label>
    <input type="number" id="amountInput" placeholder="Enter amount in cents">

    <button id="processBtn" onclick="processPayment()">Process PaymentIntent</button>
    <button id="captureBtn" onclick="capturePayment()" style="display: none;">Capture Payment</button>
    <div id="loader"></div>

    <div id="notification"></div>
</div>

<script>
     let paymentIntentId;

     async function processPayment() {
        const amountInput = document.getElementById('amountInput');
        const amount = amountInput.value;

        if (!amount || isNaN(amount) || amount <= 0) {
            showAlert('Please enter a valid amount.');
            return;
        }

        // Hide input box and display loader
        document.getElementById('amountInput').style.display = 'none';
        document.getElementById('processBtn').style.display = 'none';
        document.getElementById('loader').style.display = 'block';

        const response = await fetch('create_payment_intent.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ amount }),
        });

        const data = await response.json();
        paymentIntentId = data.paymentIntentId;

        // Hide loader and display Capture button
        document.getElementById('loader').style.display = 'none';
        document.getElementById('captureBtn').style.display = 'block';

        showAlert('PaymentIntent created! Payment Method is also created.', true);
    }

    // Inside the capturePayment function in index.php

        async function capturePayment() {
    try {
        // Display loader and hide Capture button
        document.getElementById('loader').style.display = 'block';
        document.getElementById('captureBtn').style.display = 'none';

        const response = await fetch('capture_payment.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ paymentIntentId }),
        });

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const data = await response.json();

        if (data.success) {
            console.log(data)
            // Uncomment the next line if you want to redirect after capturing the payment
            // window.location.href = 'success_page.php?data=' + encodeURIComponent(JSON.stringify(data));
            showSuccessPage(data);   
        } else {
            showAlert('Payment capture failed. Please try again.', false);
            console.error('Payment capture failed:', data.error);
        }
    } catch (error) {
        showAlert('An error occurred during payment capture. Please try again.');
        console.error('Error during payment capture:', error.message);
    } finally {
        // Hide loader after capturing payment
        document.getElementById('loader').style.display = 'none';
    }
}

        function showSuccessPage(data) {
            console.log('here',data)
            let amount = data.data.amount

            const queryString = `?amount=${amount}&totalamount=${amount}&amount_received=${data.data.amount_received}&transactionId=${data.data.id}&status=${data.data.status}&currency=${data.data.currency} `;
            window.location.href = 'success_page.php' + queryString;
        }

         function showAlert(message, isSuccess) {
            const notification = document.getElementById('notification');
            notification.innerText = message;
            notification.style.backgroundColor = isSuccess ? '#2ecc71' : '#e74c3c';
            notification.style.display = 'block';

            setTimeout(() => {
                notification.style.display = 'none';
            }, 5000);
        }
</script>

</body>
</html>
