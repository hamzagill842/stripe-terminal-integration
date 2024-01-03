<?php

/***************************************************************************
 *   copyright            : (C) 2019 PCRepairTracker.com
 *   email                : info@pcrepairtracker.com
 *   This program is a copyrighted work.
 *   Please see the license.txt file for details
 *
 ***************************************************************************/

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
echo "<input autofocus class=textbox type=hidden name=swipedata autocomplete=off>";

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

if ("$swipedata" != "") {
$mainpiece = explode("^", $swipedata);
$mainpiece1 = $mainpiece['1'];
$mainpiece3 = explode("/", $mainpiece1);

$cardnumberpiece = $mainpiece['0'];
$cardnumber = str_replace(" ", "", substr($cardnumberpiece, 2));

$ccname = $mainpiece3['1'];
$ccname2 = $mainpiece3['0'];
$ccexpyear =  substr($mainpiece['2'], 0,2);
$ccexpmonth =  substr($mainpiece['2'], 2,2);
} else {
$cardnumber = "";
$ccname = "";
$ccname2 = "";
$ccexpyear = "";
$ccexpmonth = "";

    $stripe = new \Stripe\StripeClient('sk_test_51ORJZdFdM2sLxT8hNnzcn5eWu9VjhnBs0loBi0wzUhEJjnmu0uRCuEiY8zondXHqGRZ4smENnGfLNjkh6JPS9E7f00m2yMC6ts');
    $intent = $stripe->paymentIntents->create([
        'amount' => $currenttotal*100, // Amount in cents
        'currency' => 'usd',
        'payment_method_types' => ['card_present'],
        'capture_method' => 'manual',
    ]);

    $terminal  =  $stripe->terminal->readers->processPaymentIntent(
        'tmr_FYjToAzn9WAFdP',
        ['payment_intent' => $intent->id]
    );
}
                                                                                                                                               
require("header.php");

start_blue_box(pcrtlang("Capture Payment in BBPOS Terminal")." (Stripe)");
if($isdeposit != 1) {
echo "<span class=\"sizemelarge\">".pcrtlang("Balance").": $money".mf("$currenttotal")."</span><br><br>";
}
echo "<form action=\"Stripe.php?func=add3\" method=\"POST\" id=\"payment-form\">";
echo pcrtlang("Amount to Pay").": $money <input type=text class=textboxw name=cardamount value=\"".mf("$currenttotal")."\" size=15>";

?>

    <span class="payment-errors"></span>

    <div style="padding:3px;">
      <label>
        <span><?php echo pcrtlang("Name"); ?></span>
        <input type="text" class=textbox size="20" name="cardname" value="<?php echo "$ccname $ccname2"; ?>">
      </label>
    </div>

        <input type="hidden" class=textbox size="20" data-stripe="number" value="<?php echo "$cardnumber"; ?>">
        <input type="hidden" class=textbox size="4" data-stripe="cvc"/>
        <input type="hidden" class=textbox size="2" data-stripe="exp-month" value="<?php echo "$ccexpmonth"; ?>">
        <input type="hidden" class=textbox size="4" data-stripe="exp-year" value="<?php echo "$ccexpyear"; ?>">


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
echo "<input type=hidden name=invoiceid value=\"$invoiceid\">";
echo "<input type=hidden name=paymentIntentId value=\"$intent->id\">";

echo "</td></tr>";
echo "<tr><td>".pcrtlang("Phone").": </td><td><input type=text class=textboxw name=cphone value=\"$cphone\" size=20></td></tr>";

echo "<tr><td>".pcrtlang("Email").": </td><td><input type=text class=textboxw name=cemail value=\"$cemail\" size=20></td></tr>";

echo "<tr><td></td><td><input type=submit class=button value=\"".pcrtlang("Capture Payment In Terminal")."\"></form></td></tr></table>";

?>

<?php

stop_blue_box();

require("footer.php");
}


function add3() {

require_once("validate.php");
require("deps.php");
require_once("common.php");
require_once('stripe/init.php');

$token = '';
$cardname = $_REQUEST['cardname'];
$splitthename = explode(' ', "$cardname", 2);
$cfirstname = $splitthename[0];

if (array_key_exists('1',$splitthename)) {
   $clastname = $splitthename[1];
} else {
$clastname = "";
}

$amounttopay = $_REQUEST['cardamount'];

$ccompany = pv($_REQUEST['ccompany']);
$custaddy1 = pv($_REQUEST['caddress']);
$custaddy2 = pv($_REQUEST['caddress2']);
$custcity = pv($_REQUEST['ccity']);
$custstate = pv($_REQUEST['cstate']);
$custzip = pv($_REQUEST['czip']);
$custphone = pv($_REQUEST['cphone']);
$custemail = pv($_REQUEST['cemail']);
$custname = trim("$cfirstname")." ".trim("$clastname");
$isdeposit = pv($_REQUEST['isdeposit']);
$woid = pv($_REQUEST['woid']);
$invoiceid = pv($_REQUEST['invoiceid']);

    $paymentIntentId = $_REQUEST['paymentIntentId'];
    $stripe = new \Stripe\StripeClient('sk_test_51ORJZdFdM2sLxT8hNnzcn5eWu9VjhnBs0loBi0wzUhEJjnmu0uRCuEiY8zondXHqGRZ4smENnGfLNjkh6JPS9E7f00m2yMC6ts');
    $transaction_data = $stripe->paymentIntents->capture($paymentIntentId, []);
if ($isdeposit != 1) {

    if($custname != "") {

        $chkcustnamesqlex = "SELECT * FROM currentcustomer WHERE byuser = '$ipofpc'";
        $chkcustnamesqlexq = @mysqli_query($rs_connect, $chkcustnamesqlex);
        $custnamecountex = mysqli_num_rows($chkcustnamesqlexq);

        if ($custnamecountex == 0) {
            $custins = "INSERT INTO currentcustomer (cfirstname,byuser) VALUES ('$custname','$ipofpc')";
            @mysqli_query($rs_connect, $custins);
        } else {
                $custins = "UPDATE currentcustomer SET cfirstname = '$custname' WHERE byuser = '$ipofpc' AND cfirstname = ''";
                @mysqli_query($rs_connect, $custins);
        }
    }

    if($ccompany != "") {

        $chkcompanysqlex = "SELECT * FROM currentcustomer WHERE byuser = '$ipofpc'";
        $chkcompanysqlexq = @mysqli_query($rs_connect, $chkcompanysqlex);
        $companycountex = mysqli_num_rows($chkcompanysqlexq);

        if ($companycountex == 0) {
            $companyins = "INSERT INTO currentcustomer (ccompany,byuser) VALUES ('$ccompany','$ipofpc')";
            @mysqli_query($rs_connect, $companyins);
        } else {
            $companyins = "UPDATE currentcustomer SET ccompany = '$ccompany' WHERE byuser = '$ipofpc' AND ccompany = ''";
            @mysqli_query($rs_connect, $companyins);
        }
    }


    if($custaddy1 != "") {

        $chkcustaddy1sqlex = "SELECT * FROM currentcustomer WHERE byuser = '$ipofpc'";
        $chkcustaddy1sqlexq = @mysqli_query($rs_connect, $chkcustaddy1sqlex);
        $custaddy1countex = mysqli_num_rows($chkcustaddy1sqlexq);

        if ($custaddy1countex == 0) {

            $addy1ins = "INSERT INTO currentcustomer (caddress,byuser) VALUES ('$custaddy1','$ipofpc')";
            @mysqli_query($rs_connect, $addy1ins);
        } else {
            $addy1ins = "UPDATE currentcustomer SET caddress = '$custaddy1' WHERE byuser = '$ipofpc' AND caddress = ''";
            @mysqli_query($rs_connect, $addy1ins);
        }
    }

    if($custaddy2 != "") {

        $chkcustaddy2sqlex = "SELECT * FROM currentcustomer WHERE byuser = '$ipofpc'";
        $chkcustaddy2sqlexq = @mysqli_query($rs_connect, $chkcustaddy2sqlex);
        $custaddy2countex = mysqli_num_rows($chkcustaddy2sqlexq);

        if ($custaddy2countex == 0) {
            $addy2ins = "INSERT INTO currentcustomer (caddress2,byuser) VALUES ('$custaddy2','$ipofpc')";
            @mysqli_query($rs_connect, $addy2ins);
        } else {
            $addy2ins = "UPDATE currentcustomer SET caddress2 = '$custaddy2' WHERE byuser = '$ipofpc' AND caddress2 = ''";
            @mysqli_query($rs_connect, $addy2ins);
        }
    }

    if($custcity != "") {

        $chkcustcitysqlex = "SELECT * FROM currentcustomer WHERE byuser = '$ipofpc'";
        $chkcustcitysqlexq = @mysqli_query($rs_connect, $chkcustcitysqlex);
        $custcitycountex = mysqli_num_rows($chkcustcitysqlexq);

        if ($custcitycountex == 0) {

            $cityins = "INSERT INTO currentcustomer (ccity,byuser) VALUES ('$custcity','$ipofpc')";
            @mysqli_query($rs_connect, $cityins);
        } else {

            $cityins = "UPDATE currentcustomer SET ccity = '$custcity' WHERE byuser = '$ipofpc' AND ccity = ''";
            @mysqli_query($rs_connect, $cityins);
        }
    }

    if($custstate != "") {

        $chkcuststatesqlex = "SELECT * FROM currentcustomer WHERE byuser = '$ipofpc'";
        $chkcuststatesqlexq = @mysqli_query($rs_connect, $chkcuststatesqlex);
        $custstatecountex = mysqli_num_rows($chkcuststatesqlexq);

        if ($custstatecountex == 0) {

            $stateins = "INSERT INTO currentcustomer (cstate,byuser) VALUES ('$custstate','$ipofpc')";
            @mysqli_query($rs_connect, $stateins);
        } else {

            $stateins = "UPDATE currentcustomer SET cstate = '$custstate' WHERE byuser = '$ipofpc' AND cstate = ''";
            @mysqli_query($rs_connect, $stateins);
        }
    }

    if($custzip != "") {
        $chkcustzipsqlex = "SELECT * FROM currentcustomer WHERE byuser = '$ipofpc'";
        $chkcustzipsqlexq = @mysqli_query($rs_connect, $chkcustzipsqlex);
        $custzipcountex = mysqli_num_rows($chkcustzipsqlexq);

        if ($custzipcountex == 0) {

            $zipins = "INSERT INTO currentcustomer (czip,byuser) VALUES ('$custzip','$ipofpc')";
            @mysqli_query($rs_connect, $zipins);
        } else {
            $zipins = "UPDATE currentcustomer SET czip = '$custzip' WHERE byuser = '$ipofpc' AND czip = ''";
            @mysqli_query($rs_connect, $zipins);
        }
    }

    if($custphone != "") {

        $chkcustphonesqlex = "SELECT * FROM currentcustomer WHERE byuser = '$ipofpc'";
        $chkcustphonesqlexq = @mysqli_query($rs_connect, $chkcustphonesqlex);
        $custphonecountex = mysqli_num_rows($chkcustphonesqlexq);

        if ($custphonecountex == 0) {
            $phoneins = "INSERT INTO currentcustomer (cphone,byuser) VALUES ('$custphone','$ipofpc')";
            @mysqli_query($rs_connect, $phoneins);
        } else {
            $phoneins = "UPDATE currentcustomer SET cphone = '$custphone' WHERE byuser = '$ipofpc' AND cphone = ''";
            @mysqli_query($rs_connect, $phoneins);
        }
    }

    if($custemail != "") {

        $chkcustemailsqlex = "SELECT * FROM currentcustomer WHERE byuser = '$ipofpc'";
        $chkcustemailsqlexq = @mysqli_query($rs_connect, $chkcustemailsqlex);
        $custemailcountex = mysqli_num_rows($chkcustemailsqlexq);
        if ($custemailcountex == 0) {

            $emailins = "INSERT INTO currentcustomer (cemail,byuser) VALUES ('$custemail','$ipofpc')";
            @mysqli_query($rs_connect, $emailins);
        } else {
            $emailins = "UPDATE currentcustomer SET cemail = '$custemail' WHERE byuser = '$ipofpc' AND cemail = ''";
            @mysqli_query($rs_connect, $emailins);
        }
    }

}



$storeinfoarray = getstoreinfo($defaultuserstore);

$amounttopaycents = number_format($amounttopay, 2, '', ''); 

require_once('stripe/init.php');

try {
    $ch = $stripe->charges->retrieve($transaction_data->latest_charge);

    $cc_transid = $transaction_data->id;
    $ccmonth = $ch->source->exp_month;
    $ccyear = $ch->source->exp_year;
    $ccnumber2 = $ch->source->last4 ;
    $cccardtype = $ch->source->brand;

} catch (\Stripe\Exception\InvalidRequestException $e) {

    $cc_transid = $transaction_data->id;
    $ccmonth = '';
    $ccyear = '';
    $ccnumber2 = '';
    $cccardtype = '';
}

if (function_exists('date_default_timezone_set')) {
date_default_timezone_set("$pcrt_timezone");
}
$currentdatetime = date('Y-m-d H:i:s');

if ($isdeposit == 1) {
$registerid = getcurrentregister();
$rs_insert_gcc = "INSERT INTO deposits (pfirstname,pcompany,byuser,amount,paymentplugin,paymentstatus,paymenttype,paddress,paddress2,pcity,pstate,pzip,pphone,cc_number,cc_expmonth,cc_expyear,cc_transid,cc_cardtype,woid,invoiceid,dstatus,depdate,storeid,registerid) VALUES  ('$custname','$ccompany','$ipofpc','$amounttopay','Stripe','ready','credit','$custaddy1','$custaddy2','$custcity','$custstate','$custzip','$custphone','$ccnumber2','$ccmonth','$ccyear','$cc_transid','$cccardtype','$woid','$invoiceid','open','$currentdatetime','$defaultuserstore','$registerid')";
@mysqli_query($rs_connect, $rs_insert_gcc);

$depositid = mysqli_insert_id($rs_connect);
header("Location: deposits.php?func=deposit_receipt&depositid=$depositid&woid=$woid");
} else {

$rs_insert_gcc = "INSERT INTO currentpayments (pfirstname,pcompany,byuser,amount,paymentplugin,paymentstatus,paymenttype,paddress,paddress2,pcity,pstate,pzip,pphone,cc_number,cc_expmonth,cc_expyear,cc_transid,cc_cardtype) VALUES  ('$custname','$ccompany','$ipofpc','$amounttopay','Stripe','ready','credit','$custaddy1','$custaddy2','$custcity','$custstate','$custzip','$custphone','$ccnumber2','$ccmonth','$ccyear','$cc_transid','$cccardtype')";
@mysqli_query($rs_connect, $rs_insert_gcc);

header("Location: $domain/cart.php");
}

                                                                                                                                               
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
