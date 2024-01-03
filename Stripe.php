<?php

/***************************************************************************
 *   copyright            : (C) 2019 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/


require 'stripe/vendor/autoload.php';


if (array_key_exists('func',$_REQUEST)) {
    $func = $_REQUEST['func'];
} else {
    $func = "";
}


function nothing() {
    require_once("header.php");


    require_once("footer.php");

}


function add() {

    if (array_key_exists('currenttotal',$_REQUEST)) {
        $currenttotal =  $_REQUEST['currenttotal'];
    } else {
        $currenttotal = "";
    }

    if (array_key_exists('isdeposit',$_REQUEST)) {
        $isdeposit =  $_REQUEST['isdeposit'];
    } else {
        $isdeposit = "0";
    }

    if (array_key_exists('woid',$_REQUEST)) {
        $woid =  $_REQUEST['woid'];
    } else {
        $woid = "0";
    }

    if (array_key_exists('invoiceid',$_REQUEST)) {
        $invoiceid =  $_REQUEST['invoiceid'];
    } else {
        $invoiceid = "0";
    }

    if (array_key_exists('cfirstname',$_REQUEST)) {
        $cfirstname = $_REQUEST['cfirstname'];
    } else {
        $cfirstname = "";
    }
    if (array_key_exists('ccompany',$_REQUEST)) {
        $ccompany = $_REQUEST['ccompany'];
    } else {
        $ccompany = "";
    }
    if (array_key_exists('caddress',$_REQUEST)) {
        $caddress = $_REQUEST['caddress'];
    } else {
        $caddress = "";
    }
    if (array_key_exists('caddress2',$_REQUEST)) {
        $caddress2 = $_REQUEST['caddress2'];
    } else {
        $caddress2 = "";
    }
    if (array_key_exists('ccity',$_REQUEST)) {
        $ccity = $_REQUEST['ccity'];
    } else {
        $ccity = "";
    }
    if (array_key_exists('cstate',$_REQUEST)) {
        $cstate = $_REQUEST['cstate'];
    } else {
        $cstate = "";
    }
    if (array_key_exists('czip',$_REQUEST)) {
        $czip = $_REQUEST['czip'];
    } else {
        $czip = "";
    }

    if (array_key_exists('cphone',$_REQUEST)) {
        $cphone = $_REQUEST['cphone'];
    } else {
        $cphone = "";
    }

    if (array_key_exists('cemail',$_REQUEST)) {
        $cemail = $_REQUEST['cemail'];
    } else {
        $cemail = "";
    }


    require("header.php");


    start_box();
    echo "<h4>".pcrtlang("Start Payment Intent")."! (Stripe)</h4>";

    echo "<form name=c action=$securedomain/Stripe.php?func=add2 method=post>";

    echo "<input type=hidden name=swipedata value=\"$currenttotal\">";
    echo "<input type=hidden name=cfirstname value=\"$cfirstname\">";
    echo "<input type=hidden name=ccompany value=\"$ccompany\">";
    echo "<input type=hidden name=caddress value=\"$caddress\">";
    echo "<input type=hidden name=caddress2 value=\"$caddress2\">";
    echo "<input type=hidden name=ccity value=\"$ccity\">";
    echo "<input type=hidden name=cstate value=\"$cstate\">";
    echo "<input type=hidden name=czip value=\"$czip\">";
    echo "<input type=hidden name=cphone value=\"$cphone\">";
    echo "<input type=hidden name=cemail value=\"$cemail\">";

    echo "<input type=hidden name=isdeposit value=\"$isdeposit\">";
    echo "<input type=hidden name=woid value=\"$woid\">";
    echo "<input type=hidden name=invoiceid value=\"$invoiceid\">";

    echo "<input type=hidden name=currenttotal value=\"$currenttotal\">";

    echo "<input type=submit class=button value=\"".pcrtlang("Proceed")."\"></form>";

    require("footer.php");


}


function add2() {
    try {


        $currenttotal =  $_REQUEST['currenttotal'];

        $cfirstname = $_REQUEST['cfirstname'];
        $ccompany = $_REQUEST['ccompany'];
        $caddress = $_REQUEST['caddress'];
        $caddress2 = $_REQUEST['caddress2'];
        $ccity = $_REQUEST['ccity'];
        $cstate = $_REQUEST['cstate'];
        $czip = $_REQUEST['czip'];
        $cphone = $_REQUEST['cphone'];
        $cemail = $_REQUEST['cemail'];

        $isdeposit = $_REQUEST['isdeposit'];
        $woid = $_REQUEST['woid'];
        $invoiceid = $_REQUEST['invoiceid'];

        if (array_key_exists('swipedata', $_REQUEST)) {
            $swipedata = $_REQUEST['swipedata'];
        } else {
            $swipedata = "";
        }
        $stripe = new \Stripe\StripeClient('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');
        $intent = $stripe->paymentIntents->create([
            'amount' => $currenttotal*100, // Amount in cents
            'currency' => 'usd',
            'payment_method_types' => ['card_present'],
            'capture_method' => 'automatic',
        ]);

        $terminal  =  $stripe->terminal->readers->processPaymentIntent(
            'tmr_E9jPLQWQRPgmyD',
            ['payment_intent' => $intent->id]
        );

//    $stripe->testHelpers->terminal->readers->presentPaymentMethod('tmr_E9jPLQWQRPgmyD', []);

        $cardnumber = "";
        $ccname = "";
        $ccname2 = "";
        $ccexpyear = "";
        $ccexpmonth = "";


        require("header.php");

        start_blue_box(pcrtlang("Add Credit Card Payment")." (Stripe)");
        if($isdeposit != 1) {
            echo "<span class=\"sizemelarge\">".pcrtlang("Balance").": $money".mf("$currenttotal")."</span><br><br>";
        }
        echo "<form action=\"Stripe.php?func=add3\" method=\"POST\" id=\"payment-form\">";
        echo pcrtlang("Amount to Pay").": $money <input type=text class=textboxw name=cardamount value=\"".mf("$currenttotal")."\" size=15>";

    } catch (\Exception $e) {
        // Respond with a JSON-encoded error message
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
    ?>

    <span class="payment-errors"></span>

    <div style="padding:3px;">
        <label>
            <span><?php echo pcrtlang("Name"); ?></span>
            <input type="text" class=textbox size="20" name="cardname" value="<?php echo "$ccname $ccname2"; ?>">
        </label>
    </div>


    <!--    <div style="padding:3px;">-->
    <!--      <label>-->
    <!--        <span>--><?php //echo pcrtlang("Card Number"); ?><!--</span>-->
    <!--        <input type="text" class=textbox size="20" data-stripe="number" value="--><?php //echo "$cardnumber"; ?><!--">-->
    <!--      </label>-->
    <!--    </div>-->
    <!---->
    <!--    <div style="padding:3px;">-->
    <!--      <label>-->
    <!--        <span>--><?php //echo pcrtlang("CVC"); ?><!--</span>-->
    <!--        <input type="text" class=textbox size="4" data-stripe="cvc"/>-->
    <!--      </label>-->
    <!--    </div>-->

    <!--    <div style="padding:3px;">-->
    <!--      <label>-->
    <!--        <span>--><?php //echo pcrtlang("Expiration (MM/YYYY)"); ?><!--</span>-->
    <!--        <input type="text" class=textbox size="2" data-stripe="exp-month" value="--><?php //echo "$ccexpmonth"; ?><!--">-->
    <!--      </label>-->
    <!--      <span> / </span>-->
    <!--      <input type="text" class=textbox size="4" data-stripe="exp-year" value="--><?php //echo "$ccexpyear"; ?><!--">-->
    <!--    </div>-->


    <?php


    echo "<table><tr><td>";
    echo "<tr><td>".pcrtlang("Company").": </td>";
    echo "<td><input type=text class=textboxw name=ccompany value=\"$ccompany\" size=25></td></tr>";

    echo "<tr><td>$pcrt_address1: </td>";
    echo "<td><input type=text class=textboxw name=caddress value=\"$caddress\" size=25></td></tr>";

    echo "<tr><td>$pcrt_address2: </td>";
    echo "<td><input type=text class=textboxw name=caddress2 value=\"$caddress2\" size=25></td></tr>";

    echo "<tr><td>$pcrt_city, $pcrt_state $pcrt_zip </td>";
    echo "<td><input type=text class=textboxw name=ccity value=\"$ccity\" size=15>";

    echo "<input type=text class=textboxw name=cstate value=\"$cstate\" size=6>";

    echo "<input type=text class=textboxw name=czip value=\"$czip\" size=10>";

    echo "<input type=hidden name=isdeposit value=\"$isdeposit\">";
    echo "<input type=hidden name=woid value=\"$woid\">";
    echo "<input type=hidden name=paymentIntentId value=\"$intent->id\">";
    echo "<input type=hidden name=invoiceid value=\"$invoiceid\">";


    echo "</td></tr>";
    echo "<tr><td>".pcrtlang("Phone").": </td><td><input type=text class=textboxw name=cphone value=\"$cphone\" size=20></td></tr>";

    echo "<tr><td>".pcrtlang("Email").": </td><td><input type=text class=textboxw name=cemail value=\"$cemail\" size=20></td></tr>";

    echo "<tr><td></td><td><input type=submit class=button value=\"".pcrtlang("Capture Amount")."\"></form></td></tr></table>";

    ?>

    <?php

    stop_blue_box();


    require("footer.php");
}



function add3() {
    require("header.php");
    $paymentIntentId = $_REQUEST['paymentIntentId'];
    $stripe = new \Stripe\StripeClient('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');
    $transaction_data = $stripe->paymentIntents->capture($paymentIntentId, []);
    $html = '
        <style>
           
            .card {
                background-color: #fff;
                border-radius: 15px;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
                padding: 30px;
                max-width: 500px;
                width: 80%;
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
                margin-top: 10px;
            }

            p {
                color: #555; /* Medium gray color for text */
                margin-top: 10px;
            }
        </style>

        <div class="card">
            <h1>Payment Successful!</h1>
            <p>Thank you for your payment.</p>';

    $amount = $transaction_data->amount;
    $totalamount = $transaction_data->amount;
    $amount_received = $transaction_data->amount;
    $transactionId = $paymentIntentId;
    $status = $transaction_data->status;
    $currency = $transaction_data->currency;

    $html .= '
            <div>
                <h2>Transaction Details:</h2>
                <p>Amount: $' . number_format($amount / 100, 2) . '</p>
                <p>Total Amount: $' . number_format($totalamount / 100, 2) . '</p>
                <p>Amount Received: $' . number_format($amount_received / 100, 2) . '</p>
                <p>Transaction ID: ' . $transactionId . '</p>
                <p>Status: ' . $status . '</p>
                <p>Currency: ' . $currency . '</p>
            </div>
        </div>';

    echo $html;
    stop_blue_box();
    require("footer.php");
}



function void() {
    require_once("validate.php");

    require("deps.php");
    require_once("common.php");

    $payid = $_REQUEST['payid'];
    $cc_transid = $_REQUEST['cc_transid'];

    if (array_key_exists('depositid',$_REQUEST)) {
        $depositid = $_REQUEST['depositid'];
    } else {
        $depositid = 0;
    }

    if (array_key_exists('isdeposit',$_REQUEST)) {
        $isdeposit = $_REQUEST['isdeposit'];
    } else {
        $isdeposit = 0;
    }

    if ($demo == "yes") {
        die("Sorry this feature is disabled in demo mode");
    }


######
    require_once('stripe/init.php');

    $isapproved = 1;

    try {
        \Stripe\Stripe::setApiKey("$stripe_api_key");
        $ch = \Stripe\Charge::retrieve("$cc_transid");
        $ch->refund();

    }
    catch (Exception $e) {
        $chargeerror = $e->getMessage();
        $isapproved = 0;
    }



    if ($isapproved == 0) {
        require_once("common.php");
        echo "<span style=\"font-size:20px;\">".pcrtlang("Refund Failed")."</span><br><br>";
        $thereason = $chargeerror;
        echo "Reason:<br><br><span style=\"font-size:16px;font-color:red\">$thereason</span>";


        echo "<a href=Stripe.php?func=voidoverride&payid=$payid&isdeposit=$isdeposit&depositid=$depositid>".pcrtlang("Override and Remove this Credit Card Payment")."</a><br><br>".pcrtlang("Note: If you do this it will not release the hold on funds for your customers credit card, you must manually login to your control panel and void this charge.");

    } else {







        if ($isdeposit != 1) {
            $rs_void_cc = "DELETE FROM currentpayments WHERE paymentid = '$payid'";
            @mysqli_query($rs_connect, $rs_void_cc);

            header("Location: cart.php");
        } else {
            $rs_void_cc = "DELETE FROM deposits WHERE depositid = '$depositid'";
            @mysqli_query($rs_connect, $rs_void_cc);
            header("Location: deposits.php");
        }
    }
}


function voidoverride() {
    require_once("validate.php");

    require("deps.php");
    require_once("common.php");

    $payid = $_REQUEST['payid'];

    if (array_key_exists('depositid',$_REQUEST)) {
        $depositid = $_REQUEST['depositid'];
    } else {
        $depositid = 0;
    }

    if (array_key_exists('isdeposit',$_REQUEST)) {
        $isdeposit = $_REQUEST['isdeposit'];
    } else {
        $isdeposit = 0;
    }

    if ($demo == "yes") {
        die("Sorry this feature is disabled in demo mode");
    }





    if ($isdeposit != 1) {
        $rs_void_cc = "DELETE FROM currentpayments WHERE paymentid = '$payid'";
        @mysqli_query($rs_connect, $rs_void_cc);
        header("Location: cart.php");
    } else {
        $rs_void_cc = "DELETE FROM deposits WHERE depositid = '$depositid'";
        @mysqli_query($rs_connect, $rs_void_cc);
        header("Location: deposits.php");
    }

}


switch($func) {

    default:
        nothing();
        break;

    case "add":
        add();
        break;

    case "add2":
        add2();
        break;

    case "add3":
        add3();
        break;


    case "void":
        void();
        break;

    case "voidoverride":
        voidoverride();
        break;


}

?>
