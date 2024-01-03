<?php
                                                                                                    
/***************************************************************************
 *   copyright            : (C) 2016 PCRepairTracker.com
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

                                                                                                    
function deposits() {
require_once("header.php");
require("deps.php");

echo "<script type=\"text/javascript\">document.title = \"".pcrtlang("Deposits")."\";</script>";

if ($gomodal == 1) {
$therel = "rel=facebox";
} else {
$therel = "";
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

if (array_key_exists('woid',$_REQUEST)) {
$woid = $_REQUEST['woid'];
} else {
$woid = "0";
}

if (array_key_exists('invoiceid',$_REQUEST)) {
$invoiceid = $_REQUEST['invoiceid'];
} else {
$invoiceid = "0";
}

if (array_key_exists('depamount',$_REQUEST)) {
$depamount = $_REQUEST['depamount'];
} else {
$depamount = "0";
}



start_moneybox();
echo "<span class=\"colormemoney sizemelarger\">&nbsp;".pcrtlang("Take a Deposit").":&nbsp;</span><br><br>";
echo "<table><tr>";
reset($paymentplugins);
foreach($paymentplugins as $key => $plugin) {

echo "<td><form action=$plugin.php?func=add method=post>";

echo "<input type=hidden name=cfirstname value=\"$cfirstname\">";
echo "<input type=hidden name=ccompany value=\"$ccompany\">";
echo "<input type=hidden name=caddress value=\"$caddress\">";
echo "<input type=hidden name=caddress2 value=\"$caddress2\">";
echo "<input type=hidden name=ccity value=\"$ccity\">";
echo "<input type=hidden name=cstate value=\"$cstate\">";
echo "<input type=hidden name=czip value=\"$czip\">";
echo "<input type=hidden name=cphone value=\"$cphone\">";
echo "<input type=hidden name=cemail value=\"$cemail\">";
echo "<input type=hidden name=woid value=\"$woid\">";
echo "<input type=hidden name=invoiceid value=\"$invoiceid\">";
echo "<input type=hidden name=currenttotal value=\"$depamount\">";
echo "<input type=hidden name=isdeposit value=\"1\">";
echo "<button type=submit class=button>".paymentlogo("$plugin")."<br>".pcrtlang("$plugin")."</form></td>";

}
echo "</tr></table><br><br>";

echo "<table><tr>";

if(($woid == 0) && ($invoiceid == 0)) {
echo "<td>";
echo "<form action=cart.php?func=pickcustomer method=post>";
echo "<input type=text class=textboxw name=searchtext size=12><input type=hidden value=deposits name=pickfor>";
echo "<input type=submit class=button value=\"".pcrtlang("Search &amp; Pick Customer")."\"></form>";
echo "</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
}

if ("$cfirstname" != "") {
echo "<td>";

echo "<span class=\"linkbuttongraylabel linkbuttonmedium radiusall\">".pcrtlang("Current Pick")."</span><br>";

echo "<table class=standard><tr><td><span class=boldme>$cfirstname</span></td>";
if($ccompany != "") {
echo "<tr><td>$ccompany</td></tr>";
}
echo "<tr><td>$caddress</td></tr>";
if ($caddress2 != "") {
echo "<tr><td>$caddress2</td></tr>";
}

echo "<tr><td>";

if ($ccity != "") {
echo "$ccity,";
}
if ($cstate != "") {
echo "$cstate,";
}
if ($czip != "") {
echo "$czip";
}

echo "</td></tr><tr><td></td></tr>";

if($invoiceid != 0) {
echo "<tr><td>".pcrtlang("Invoice").": <span class=boldme>#$invoiceid</span></td></tr>";
}

if($woid != 0) {
echo "<tr><td>".pcrtlang("Work Order").": <span class=boldme>#$woid</span></td></tr>";
}

echo "</table>";

echo "</td>";
}
echo "</tr></table>";





stop_box();
echo "<br><br>";

start_box();
echo "<span class=\"linkbuttongraylabel linkbuttonmedium radiusleft\">".pcrtlang("Show").": </span><span class=\"linkbuttongraydisabled linkbuttonmedium\">".pcrtlang("Open Deposits")."</span><a href=deposits.php?func=alldeposits class=\"linkbuttongray linkbuttonmedium radiusright\">".pcrtlang("Applied Deposits")."</a><br>";
stop_box();
echo "<br>";

$rs_invoices = "SELECT * FROM deposits WHERE dstatus = 'open'";
$rs_find_deposits = @mysqli_query($rs_connect, $rs_invoices);
$totaldep = mysqli_num_rows($rs_find_deposits);
if ($totaldep != "0") {

start_color_box("51",pcrtlang("Open Deposits"));
echo "<table class=standard>";
echo "<tr><th>".pcrtlang("Deposit")."#&nbsp;&nbsp;</th><th>".pcrtlang("Customer Name")."&nbsp;&nbsp;</th><th>".pcrtlang("Attached To")."&nbsp;&nbsp;</th><th>".pcrtlang("Deposit Date")."&nbsp;&nbsp;</th>";
echo "<th> ".pcrtlang("Total")." &nbsp;&nbsp;</th><th>".pcrtlang("Actions")."&nbsp;&nbsp;</th></tr>";
while($rs_find_deposits_q = mysqli_fetch_object($rs_find_deposits)) {
$depositid = "$rs_find_deposits_q->depositid";
$depfirstname = "$rs_find_deposits_q->pfirstname";
$deplastname = "$rs_find_deposits_q->plastname";
$depname = "$depfirstname $deplastname";
$depcompany = "$rs_find_deposits_q->pcompany";
$depamount2 = "$rs_find_deposits_q->amount";
$depamount = number_format($depamount2, 2, '.', '');
$depwoid = "$rs_find_deposits_q->woid";
$depinvoiceid = "$rs_find_deposits_q->invoiceid";
$depemail = "$rs_find_deposits_q->pemail";
$paymentplugin = "$rs_find_deposits_q->paymentplugin";
$cc_transid = "$rs_find_deposits_q->cc_transid";
$depdate = "$rs_find_deposits_q->depdate";
$depdate2 = pcrtdate("$pcrt_longdate", "$depdate");
echo "<tr><td>$depositid</td><td>$depname";
if("$depcompany" != "") {
echo " - $depcompany";
}
echo "</td><td>";

if($depinvoiceid != 0) {
echo pcrtlang("Invoice").": #$depinvoiceid";
}

if(($depwoid != 0) && ($depinvoiceid != 0)) {
echo "<br>";
}

if($depwoid != 0) {
echo pcrtlang("Work Order").": #$depwoid";
}



echo "</td><td>$depdate2</td><td>$money".mf("$depamount")."</td>";
echo "<td>";

echo "&nbsp;&nbsp;&nbsp;<a href=\"javascript:void(0);\" class=\"linkbuttonsmall linkbuttongray radiusall\" style=\"float:right;\" 
id=depchange$depositid><i class=\"fa fa-chevron-down\"></i></a>";

echo "<div id=depbox$depositid style=\"display:none;\"><br>";

echo "<a href=deposits.php?func=deposit_receipt&depositid=$depositid&depemail=$depemail&woid=$depwoid class=\"linkbuttongray linkbuttonmedium\" style=\"display:block;text-align:center;\"><i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("Print Deposit Receipt")."</a>";
echo "<a href=deposits.php?func=adddep&depositid=$depositid class=\"linkbuttongray linkbuttonmedium\" style=\"display:block;text-align:center;\"><i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Add Deposit to Cart")."</a>";
echo "<a href=deposits.php?func=editdeposit&depositid=$depositid $therel class=\"linkbuttongray linkbuttonmedium\" style=\"display:block;text-align:center;\"><i class=\"fa fa-edit fa-lg\"></i> ".pcrtlang("Edit")."</a>";

echo "<a href=$paymentplugin.php?func=void&depositid=$depositid&isdeposit=1&cc_transid=$cc_transid&refundamount=$depamount class=\"linkbuttongray linkbuttonmedium\"  style=\"display:block;text-align:center;\" onClick=\"return confirm('".pcrtlang("Are you sure you wish to delete this deposit?")."');\"><i class=\"fa fa-ban fa-lg\"></i> ".pcrtlang("Void & Delete")."</a>";
if($depwoid != "0") {
echo "<a href=../repair/index.php?pcwo=$depwoid class=\"linkbuttongray linkbuttonmedium\" style=\"display:block;text-align:center;\"><i class=\"fa fa-clipboard fa-lg\"></i> ".pcrtlang("View Work Order")." #$depwoid</a>";
}

if(($depwoid == "0") && ($depinvoiceid != 0)) {
echo "<a href=deposits.php?func=removefrominvoice&depositid=$depositid class=\"linkbuttongray linkbuttonmedium\" style=\"display:block;text-align:center;\"><i class=\"fa fa-times fa-lg\"></i> ".pcrtlang("Remove from Invoice")." #$depinvoiceid</a>";
}

if(($depwoid == "0") && ($depinvoiceid == 0) && ($woid != 0)) {
echo "<a href=../repair/pc.php?func=adddeposittowo&depositid=$depositid&woid=$woid class=\"linkbuttongray linkbuttonmedium\" style=\"display:block;text-align:center;\">
<i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Add to Work Order")." #$woid</a>";
}



if($depinvoiceid != 0) {
echo "<a href=invoice.php?func=printinv&invoice_id=$depinvoiceid class=\"linkbuttongray linkbuttonmedium\" style=\"display:block;text-align:center;\">
<i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("Print Invoice")." #$depinvoiceid</a>";
} else {
if(($invoiceid != 0) && ($woid == 0)) {
echo "<a href=deposits.php?func=adddeptoinv&invoiceid=$invoiceid&depositid=$depositid class=\"linkbuttongray linkbuttonmedium\" style=\"display:block;text-align:center;\">
<i class=\"fa fa-plus fa-lg\"></i> ".pcrtlang("Add to Invoice")." #$invoiceid</a>";
}
}




echo "</div>";

?>
<script type='text/javascript'>
$('#depchange<?php echo "$depositid"; ?>').click(function(){
  $('#depbox<?php echo "$depositid"; ?>').toggle('1000');
  $("i",this).toggleClass("fa-chevron-up fa-chevron-down");
});
</script>
<?php


echo "</td></tr>";
}
echo "</table>";
stop_color_box();
}






require_once("footer.php");
                                                                                                    
}

##########

function alldeposits() {

require("deps.php");
require_once("common.php");

require_once("header.php");

if (array_key_exists("pageNumber", $_REQUEST)) {
$pageNumber = $_REQUEST['pageNumber'];
} else {
$pageNumber = 1;
}

if (array_key_exists("sortby", $_REQUEST)) {
$sortby = $_REQUEST['sortby'];
} else {
$sortby = "date_asc";
}

if (array_key_exists("search", $_REQUEST)) {
$search = $_REQUEST['search'];
} else {
$search = "";
}

$search_ue = urlencode($search);

start_color_box("51",pcrtlang("Applied Deposits"));

echo "<table style=\"width:100%\"><tr><td>";
echo "<span class=\"linkbuttongraylabel linkbuttonmedium radiusleft\">".pcrtlang("Show").": </span><a href=deposits.php class=\"linkbuttongray linkbuttonmedium\">".pcrtlang("Open Deposits")."</a><span class=\"linkbuttongraydisabled linkbuttonmedium radiusright\">".pcrtlang("Applied Deposits")."</span>";

echo "</td><td style=\"text-align:right\"><i class=\"fa fa-search fa-lg\"></i> ";
echo "<input type=text class=\"textbox\" id=searchbox placeholder=\"".pcrtlang("Enter Search Text")."\" value=\"$search\">";
echo "</td></tr></table>";


echo "<div id=themain>";

echo "</div>";

?>
<script type="text/javascript">
$(document).ready(function () {
     $.get('deposits.php?func=alldepositsajax&pageNumber=<?php echo $pageNumber; ?>&sortby=<?php echo $sortby; ?>&search=<?php echo $search_ue; ?>', function(data) {
     $('#themain').html(data);
     });
});
</script>


<script type="text/javascript">
$(document).ready(function(){
  var globalTimeoutrs = null;
  $("input#searchbox").keyup(function(){
                        if (globalTimeoutrs != null) {
                        clearTimeout(globalTimeoutrs);
                        }
                        var encodedinv = encodeURIComponent(this.value);
                        var searchlength = this.value.length;
                        globalTimeoutrs = setTimeout(function() {
                        globalTimeoutrs = null;
                                if(searchlength<3) {
                                        $('div#themain').load('deposits.php?func=alldepositsajax&pageNumber=<?php echo $pageNumber; ?>&sortby=<?php echo $sortby; ?>').slideDown(200,function(){
                                        return false;
                                        });
                                }else{
                                        $('div#themain').load('deposits.php?func=alldepositsajax&pageNumber=<?php echo $pageNumber; ?>&sortby=<?php echo $sortby; ?>&search='+encodedinv).slideDown(200);
                                }
                        }, 500);
  });
});
</script>


<?php

stop_blue_box();

require("footer.php");

}




function alldepositsajax() {
require("deps.php");

require("common.php");

if (array_key_exists('pageNumber',$_REQUEST)) {
$pageNumber = $_REQUEST['pageNumber'];
} else {
$pageNumber = 1;
}

$results_per_page = 40;

if ($pageNumber == "") {
$offset = "0";
} else {
$offset = ($pageNumber * $results_per_page) - $results_per_page;
}

if (array_key_exists("search", $_REQUEST)) {
$search = $_REQUEST['search'];
if($search != "") {
$searchsql = "AND (depositid LIKE '%$search%' OR pfirstname LIKE '%$search%' OR pemail LIKE '%$search%' OR plastname LIKE '%$search%' OR pcompany LIKE '%$search%' OR pphone LIKE '%$search%' OR cc_number LIKE '%$search%' OR chk_number LIKE '%$search%' OR chk_dl LIKE '%$search%' OR cc_transid LIKE '%$search%' OR cc_confirmation LIKE '%$search%' OR custompaymentinfo LIKE '%$search%')";
} else {
$searchsql = "";
$search = "";
}
} else {
$searchsql = "";
$search = "";
}


$search_ue = urlencode($search);

$rs_depositst = "SELECT * FROM deposits WHERE dstatus = 'applied' $searchsql";
$rs_find_depositst = @mysqli_query($rs_connect, $rs_depositst);


$totalentries = mysqli_num_rows($rs_find_depositst);
$lastpage = $totalentries / $results_per_page;
if($lastpage != floor($lastpage)) {
$lastpage = floor($lastpage) + 1;
}

if($pageNumber > $lastpage) {
$pageNumber = 1;
$offset = 0;
}


echo "<br>";

echo "<table class=standard>";
echo "<tr><th>".pcrtlang("Dep")."#&nbsp;&nbsp;</th><th>".pcrtlang("Customer Name")."&nbsp;&nbsp;</th><th>".pcrtlang("Deposit Date")."&nbsp;&nbsp;</th><th>".pcrtlang("Applied Date")."</th>";
echo "<th> ".pcrtlang("Total")." &nbsp;&nbsp;</th><th>".pcrtlang("Actions")."&nbsp;&nbsp;</th></tr>";



$rs_deposits = "SELECT * FROM deposits WHERE dstatus = 'applied' $searchsql ORDER BY depdate DESC LIMIT $offset,$results_per_page";
$rs_find_deposits = @mysqli_query($rs_connect, $rs_deposits);
while($rs_find_deposits_q = mysqli_fetch_object($rs_find_deposits)) {
$depositid = "$rs_find_deposits_q->depositid";
$depfirstname = "$rs_find_deposits_q->pfirstname";
$deplastname = "$rs_find_deposits_q->plastname";
$depname = "$depfirstname $deplastname";
$depcompany = "$rs_find_deposits_q->pcompany";
$depamount2 = "$rs_find_deposits_q->amount";
$depamount = number_format($depamount2, 2, '.', '');
$depwoid = "$rs_find_deposits_q->woid";
$depemail = "$rs_find_deposits_q->pemail";
$paymentplugin = "$rs_find_deposits_q->paymentplugin";
$depdate = "$rs_find_deposits_q->depdate";
$depdate2 = pcrtdate("$pcrt_longdate", "$depdate");
$deprec = "$rs_find_deposits_q->receipt_id";
$applieddate = "$rs_find_deposits_q->applieddate";
$applieddate2 = pcrtdate("$pcrt_longdate", "$applieddate");

echo "<tr><td>$depositid</td><td>$depfirstname";
if("$depcompany" != "") {
echo " - $depcompany";
}
echo "</td><td>$depdate2</td><td>$applieddate2</td><td>$money".mf("$depamount")."</td>";
echo "<td>";

echo "&nbsp;&nbsp;&nbsp;<a href=\"javascript:void(0);\" class=\"linkbuttongray linkbuttonsmall radiusall\" style=\"float:right;\" id=depchange$depositid><i class=\"fa fa-chevron-down\"></i></a>";

echo "<div id=depbox$depositid style=\"display:none;\"><br>";

echo "<a href=deposits.php?func=deposit_receipt&depositid=$depositid&depemail=$depemail&woid=$depwoid class=\"linkbuttongray linkbuttonmedium\" style=\"display:block;text-align:center;\"><i class=\"fa fa-print fa-lg\"></i> ".pcrtlang("Print Deposit Receipt")."</a>";

if($depwoid != "0") {
echo "<a href=../repair/pc.php?func=view&woid=$depwoid class=\"linkbuttongray linkbuttonmedium\" style=\"display:block;text-align:center;\">".pcrtlang("View Work Order")." #$depwoid</a>";
}

echo "</div>";
?>
<script type='text/javascript'>
$('#depchange<?php echo "$depositid"; ?>').click(function(){
  $('#depbox<?php echo "$depositid"; ?>').toggle('1000');
  $("i",this).toggleClass("fa-chevron-up fa-chevron-down");
});
</script>
<?php




echo "</td></tr>";
}
echo "</table>";

echo "<br>";

#browse here

echo "<center>";

if($pageNumber != 1) {
$prevpage = $pageNumber - 1;
echo "<a href=deposits.php?func=alldeposits&pageNumber=$prevpage class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-left fa-lg\"></i></a>&nbsp;";
}

$html = get_paged_nav($totalentries, $results_per_page, false);
$html = str_replace("alldepositsajax", "alldeposits", "$html");
echo "$html";

if($lastpage != $pageNumber) {
$nextpage = $pageNumber + 1;
echo "<a href=deposits.php?func=alldeposits&pageNumber=$nextpage class=\"linkbuttonmedium linkbuttongray radiusall\"><i class=\"fa fa-chevron-right fa-lg\"></i></a>";
}

echo "</center>";


}



#######

function deposit_receipt() {
require_once("validate.php");
$depositid = $_REQUEST['depositid'];

include("deps.php");
include("common.php");


$narrow = $receiptsnarrow;

?>
<!DOCTYPE html>

<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php


echo "<title>".pcrtlang("Deposit Receipt").": #$depositid</title>";

echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../repair/printstyle.css\">";
echo "<link rel=\"stylesheet\" href=\"../repair/fa/css/font-awesome.min.css\">";


if (!isset($enablesignaturepad_deposits)) {
$enablesignaturepad_deposit = "no";
}

if ($enablesignaturepad_deposits == "yes") {
?>
 <link rel="stylesheet" href="../repair/jq/signature/jquery.signaturepad.css">
  <!--[if lt IE 9]><script src="../repair/jq/signature/flashcanvas.js"></script><![endif]-->
  <script src="../repair/jq/jquery.js"></script>

<?php

}

if ($enablesignaturepad_deposits == "topaz") {
require("../repair/jq/topaz.js");
}


echo "</head>";


$rs_find_name = "SELECT * FROM deposits WHERE depositid = '$depositid'";
$rs_result_name = mysqli_query($rs_connect, $rs_find_name);

$rs_result_name_q = mysqli_fetch_object($rs_result_name);
$rs_soldto = "$rs_result_name_q->pfirstname";
$rs_ad1 = "$rs_result_name_q->paddress";
$rs_company = "$rs_result_name_q->pcompany";
$rs_ad2 = "$rs_result_name_q->paddress2";
$rs_ph = "$rs_result_name_q->pphone";
$rs_cn = "$rs_result_name_q->chk_number";
$rs_ccn = "$rs_result_name_q->cc_number";
$rs_datesold = "$rs_result_name_q->depdate";
$rs_pw = "$rs_result_name_q->paymenttype";
$rs_byuser = "$rs_result_name_q->byuser";
$rs_city = "$rs_result_name_q->pcity";
$rs_state = "$rs_result_name_q->pstate";
$rs_zip = "$rs_result_name_q->pzip";
$rs_email = "$rs_result_name_q->pemail";
$rs_email2 = urlencode($rs_email);
$rs_storeid = "$rs_result_name_q->storeid";
$thesig = "$rs_result_name_q->thesig";
$showsigdep = "$rs_result_name_q->showsigdep";
$thesigtopaz = "$rs_result_name_q->thesigtopaz";
$showsigdeptopaz = "$rs_result_name_q->showsigdeptopaz";



if($autoprint == 1) {
if(($enablesignaturepad_deposits == "yes") || ($enablesignaturepad_deposits == "topaz")) {
if($thesig != "") {
echo "<body class=printpagebg onLoad=\"window.print()\">";
} else {
echo "<body class=printpagebg>";
}
} else {
echo "<body class=printpagebg onLoad=\"window.print()\">";
}
} else {
echo "<body class=printpagebg>";
}


if(array_key_exists('woid', $_REQUEST)) {
$pcwoid = $_REQUEST['woid'];
} else {
$pcwoid = 0;
}

if(array_key_exists('invoiceid', $_REQUEST)) {
$invoiceid = $_REQUEST['invoiceid'];
} else {
$invoiceid = 0;
}


if(($pcwoid == 0) && ($invoiceid == 0)) {
$returnurl = "deposits.php";
} elseif($pcwoid != 0) {
$returnurl = "../repair/index.php?pcwo=$pcwoid";
} elseif(($pcwoid == 0) && ($invoiceid != 0)) {
$returnurl = "invoice.php?func=printinv&invoice_id=$invoiceid";
} else {
$returnurl = "deposits.php";
}


echo "<div class=printbar>";
echo "<button onClick=\"parent.location='$returnurl'\" class=bigbutton><img src=images/left.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Return")."</button>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<button onClick=\"print();\" class=bigbutton><img src=images/print.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Print")."</button>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<button onClick=\"parent.location='deposits.php?func=email_deposit_receipt&depositid=$depositid&depemail=$rs_email2&returnurl=$returnurl'\" class=bigbutton><img src=images/email.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Email")."</button>";

echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";


echo "<button onClick=\"parent.location='deposits.php?func=deposit_gift&depositid=$depositid&pcwoid=$pcwoid&invoiceid=$invoiceid'\" class=bigbutton><i class=\"fa fa-gift fa-lg\"></i> ".pcrtlang("Gift Certificate")."</button>";

echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

$returnreceipt = urlencode("../store/deposits.php?func=deposit_receipt&depositid=$depositid&pcwoid=$pcwoid&invoiceid=$invoiceid");
if($receiptsnarrow == 0) {
echo "<button onClick=\"parent.location='../repair/admin.php?func=switch_receipt&receipt=$returnreceipt&switch=1'\" class=bigbutton><img src=../repair/images/narrowreceipts.png style=\"
vertical-align:middle;margin-bottom: .25em;\"></button>";
} else {
echo "<button onClick=\"parent.location='../repair/admin.php?func=switch_receipt&receipt=$returnreceipt&switch=0'\" class=bigbutton><img src=../repair/images/widereceipts.png style=\" 
vertical-align:middle;margin-bottom: .25em;\"></button>";
}


echo "</div>";

require("deps.php");




if(!$narrow) {
echo "<div class=printpage>";
} else {
echo "<div class=printpage80>";
}

if(!$narrow) {
echo "<table width=100%><tr><td width=55%>";
}




$storeinfoarray = getstoreinfo($rs_storeid);

$woid = "$rs_result_name_q->woid";

$paymentamount2 = "$rs_result_name_q->amount";
$paymentamount = number_format($paymentamount2, 2, '.', '');
$pfirstname = "$rs_result_name_q->pfirstname";
$pcompany = "$rs_result_name_q->pcompany";
$paymenttype = "$rs_result_name_q->paymenttype";
$paymentplugin = "$rs_result_name_q->paymentplugin";
$checknumber = "$rs_result_name_q->chk_number";
$ccnumber2 = "$rs_result_name_q->cc_number";
$ccexpmonth = "$rs_result_name_q->cc_expmonth";
$ccexpyear = "$rs_result_name_q->cc_expyear";
$cc_transid = "$rs_result_name_q->cc_transid";
$cc_cardtype = "$rs_result_name_q->cc_cardtype";
$custompaymentinfo2 = "$rs_result_name_q->custompaymentinfo";

$custompaymentinfo = unserialize("$custompaymentinfo2");

$ccnumber = substr("$ccnumber2", -4, 4);

if(!$narrow) {
echo "<img src=$printablelogo><br><span class=italme>$servicebyline</span><br><br>";
echo "$storeinfoarray[storename]<br>$storeinfoarray[storeaddy1]";
if ("$storeinfoarray[storeaddy2]" != "") {
echo "<br>$storeinfoarray[storeaddy2]";
}
echo "<br>$storeinfoarray[storecity], $storeinfoarray[storestate] $storeinfoarray[storezip]";
echo "<br><br>Phone: $storeinfoarray[storephone]<br><br>";



echo "<table cellpadding=3 cellspacing=0 border=0><tr><td valign=top>".pcrtlang("Received From").":</td><td>";

if("$rs_company" != "") {
echo "$rs_company";
} else {
echo "$rs_soldto";
}

echo "<br>$rs_ad1";
if ($rs_ad2 != "") {
echo "<br>$rs_ad2";
}

echo "<br>";
if ($rs_city != "") {
echo "$rs_city, ";
}
echo "$rs_state $rs_zip<br>";

echo pcrtlang("Email").": $rs_email";


echo "</td></tr></table>";


echo "<br></td><td align=right width=45% valign=top>";
echo "<span class=textidnumber>".pcrtlang("Deposit Receipt")." #$depositid<br></span>";


$rs_datesold2 = pcrtdate("$pcrt_longdate", "$rs_datesold").", ".pcrtdate("$pcrt_time", "$rs_datesold");

echo "<br>".pcrtlang("Deposit Date").": $rs_datesold2<br>";


if ($rs_byuser != "") {
echo "<br>".pcrtlang("Received By").": $rs_byuser";
}


echo "<br><img src=\"barcode.php?barcode=$depositid&width=220&height=40&text=0\">";


echo "</td></tr></table>";

} else {
#start narrow
echo "<center>";
echo "".pcrtlang("Deposit Receipt")." #$depositid<br>";

$rs_datesold2 = pcrtdate("$pcrt_longdate", "$rs_datesold");
echo "<br>".pcrtlang("Deposit Date").": $rs_datesold2<br>";

echo "<br><img src=\"barcode.php?barcode=$depositid&width=220&height=20&text=0\">";

echo "<br><br><img src=$printablelogo width=200><br><span class=\"sizemesmaller italme\">$servicebyline</span><br><br>";
echo "$storeinfoarray[storename]<br>$storeinfoarray[storeaddy1]";
if ("$storeinfoarray[storeaddy2]" != "") {
echo "<br>$storeinfoarray[storeaddy2]";
}
echo "<br>$storeinfoarray[storecity], $storeinfoarray[storestate] $storeinfoarray[storezip]";
echo "<br><br>Phone: $storeinfoarray[storephone]<br><br>";


echo "<span class=\"sizemesmaller boldme\">".pcrtlang("Received From").":</span><br>";

if("$rs_company" != "") {
echo "$rs_company";
} else {
echo "$rs_soldto";
}

echo "<br>$rs_ad1";
if ($rs_ad2 != "") {
echo "<br>$rs_ad2";
}

echo "<br>";
if ($rs_city != "") {
echo "$rs_city, ";
}
echo "$rs_state $rs_zip<br>";
if($rs_email != "") {
echo "".pcrtlang("Email").": $rs_email";
}

echo "<br>";


#end narrow
}


echo "<table><tr>";

if ($paymenttype == "cash") {
echo "<td valign=top style=\"padding:5px 30px 0px 5px;border: 2px solid #000000;border-radius:3px;\">";
echo "<i class=\"fa fa-money fa-lg\"></i><strong> &nbsp;".pcrtlang("Cash")."&nbsp;</strong><br><br>";
echo "<span style=\"sizemelarge\">$pfirstname";
if("$pcompany" != "") {
echo " - $pcompany";
}
echo " - $money".mf("$paymentamount")."</span></td>";

} elseif ($paymenttype == "check") {
echo "<td valign=top style=\"padding:5px 30px 0px 5px;border: 2px solid #000000;border-radius:3px;\">";
echo "<i class=\"fa fa-list-alt fa-lg\"></i><strong> ".pcrtlang("Check")." #$checknumber&nbsp;</strong><br><br>";
echo "<span class=\"sizemalarger\">$pfirstname"; 
if("$pcompany" != "") {
echo " - $pcompany";
}
echo " - $money".mf("$paymentamount")."</span></td>";

} elseif ($paymenttype == "credit") {
echo "<td valign=top style=\"padding:5px 30px 0px 5px;border: 2px solid #000000;border-radius:3px;\">";
echo "<i class=\"fa fa-credit-card fa-lg\"></i><strong> ".pcrtlang("Credit Card")."&nbsp;</strong>";
echo "<br><span class=\"sizemelarger\">XXXX-$ccnumber</span><br><br>";
echo "<span class=\"sizemelarger\">$pfirstname"; 
if("$pcompany" != "") {
echo " - $pcompany";
}
echo " - $money".mf("$paymentamount")."</span><br>$paymentplugin $cc_cardtype<br>".pcrtlang("Trans ID").": $cc_transid</td>";

} elseif ($paymenttype == "custompayment") {
echo "<td valign=top style=\"padding:5px 30px 0px 5px;border: 2px solid #000000;border-radius:3px;\">";
echo "<i class=\"fa fa-product-hunt fa-lg\"></i><strong>&nbsp;$paymentplugin&nbsp;</strong><br><br>";
echo "<span class=\"sizemelarger\">$pfirstname"; 
if("$pcompany" != "") {
echo " - $pcompany";
}
echo " - $money".mf("$paymentamount")."</span></td>";

reset($custompaymentinfo);
foreach($custompaymentinfo as $key => $val) {
if(!in_array("$key", $CustomPaymentPrintExclude)) {
echo "<span class=\"sizemesmaller\">$key: $val</span><br>";
}
}

echo "</td>";

} else {
echo "<td valign=top style=\"padding:5px 30px 0px 5px;border: 2px solid #000000;border-radius:3px;\">";
echo "Error! Undefined Payment Type in database</td>";
}

echo "</tr></table>";

echo "<br><br>";

echo nl2br($storeinfoarray['depositfooter']);

if($narrow) {
echo "<br><br><br><br><span class=\"colormewhite\">.</span>";
}




######

if (($enablesignaturepad_deposits == "yes") && ($showsigdep == "0") && (!$narrow)) {
echo "<a href=deposits.php?func=hidesigdep&depositid=$depositid&hidesig=1 class=hideprintedlink><br><br>(".pcrtlang("show signature pad").")</a>";
}

if (($enablesignaturepad_deposits == "yes") && ($showsigdep == "1") && (!$narrow)) {

if ($showsigdep == "1") {
echo "<a href=deposits.php?func=hidesigdep&depositid=$depositid&hidesig=0 class=hideprintedlink><br><br>(hide signature pad)</a>";
}


if($thesig == "") {

?>
<blockquote>
  <form method="post" action="deposits.php?func=savesig" class="sigPad"><input type=hidden name=depositid value=<?php echo $depositid; ?>>
    <p class="drawItDesc"><?php echo pcrtlang("Use Stylus to write your signature"); ?></p>
    <ul class="sigNav">
      <li class="clearButton"><a href="#clear"><?php echo pcrtlang("Clear Signature"); ?></a></li>
    </ul>
    <div class="sig sigWrapper">
      <div class="typed"></div>
      <canvas class="pad" width="446" height="75"></canvas>
      <input type="hidden" name="output" class="output">
    </div>
    <button type="submit"><?php echo pcrtlang("I accept the terms of this agreement"); ?>.</button>
  </form>

  <script src="../repair/jq/signature/jquery.signaturepad.min.js"></script>
  <script>
    $(document).ready(function() {
      $('.sigPad').signaturePad({drawOnly:true,lineTop:60});
    });
  </script>
  <script src="../repair/jq/signature/json2.min.js"></script>
</blockquote>
<?php
} else {
echo "<br><br><span class=\"sizemelarge boldme\">".pcrtlang("Signed").":</span> <a href=deposits.php?func=clearsig&depositid=$depositid class=hideprintedlink>(".pcrtlang("remove signature").")</a><br>";
?>

<div class="sigPad signed">
  <div class="sigWrapper">
    <canvas class="pad" width="450" height="75"></canvas>
  </div>
</div>

<script type="text/javascript" src="../repair/jq/signature/jquery.signaturepad.min.js"></script>
<script>
$(document).ready(function () {
  $('.sigPad').signaturePad({displayOnly:true}).regenerate(<?php echo $thesig ?>)
})
</script>
<script type="text/javascript" src="../repair/jq/signature/json2.min.js"></script>
<?php
}

}


######





#start topaz

if ($enablesignaturepad_deposits == "topaz") {

if ($showsigdeptopaz == "0") {
echo "<a href=deposits.php?func=hidesigdeptopaz&depositid=$depositid&hidesig=1 class=hideprintedlink><br><br>(".pcrtlang("show signature pad").")</a>";
}

if ($showsigdeptopaz == "1") {
echo "<a href=deposits.php?func=hidesigdeptopaz&depositid=$depositid&hidesig=0 class=hideprintedlink><br><br>(".pcrtlang("hide signature pad").")</a>";
}

if ($showsigdeptopaz == "1") {
if ($thesigtopaz == "") {


?>

<br>
<canvas id="cnv" name="cnv" width="500" height="100"></canvas>

<form action="deposits.php?func=savesigtopaz" name=FORM1 method=post>
<input id="SignBtn" name="SignBtn" type="button" value="<?php echo pcrtlang("Activate Sig Pad"); ?>"  class=button onclick="javascript:onSign()"/>&nbsp;&nbsp;&nbsp;&nbsp;
<input id="button1" name="ClearBtn" type="button" class=button value="Clear" onclick="javascript:onClear()"/>&nbsp;&nbsp;&nbsp;&nbsp;
<input id="button2" name="DoneBtn" type="button" class=button value="Done" onclick="javascript:onDone()"/>&nbsp;&nbsp;&nbsp;&nbsp;

<input type="submit" class=button value="Save">&nbsp;&nbsp;&nbsp;&nbsp

<INPUT TYPE=HIDDEN NAME="bioSigData">
<INPUT TYPE=HIDDEN NAME="sigImgData">

<input type=hidden name=depositid value=<?php echo $depositid; ?>>

<input type=hidden NAME="sigImageData" value="">
</form>



<?php

} else {
echo "<br><br><span class=\"sizemelarge boldme\">".pcrtlang("Signed").":</span><a href=deposits.php?func=clearsigtopaz&depositid=$depositid class=hideprintedlink>(".pcrtlang("remove signature").")</a><br>";

if(!$narrow) {
echo '<br><img src="data:image/png;base64,' . $thesigtopaz . '" />';
} else {
echo '<br><img src="data:image/png;base64,' . $thesigtopaz . '" width=260/>';
}


}

#end hide
}

}
#end topaz






echo "</div>";


echo "</div>";
echo "</body></html>";

}

#######

function email_deposit_receipt() {
require_once("validate.php");
require_once("header.php");
require("deps.php");

$depositid = $_REQUEST['depositid'];
$depemail = $_REQUEST['depemail'];
$returnurl = $_REQUEST['returnurl'];

start_blue_box(pcrtlang("Email Deposit Receipt")." #$depositid");

echo "<br>".pcrtlang("Enter Email Address").":<br><form action=deposits.php?func=email_deposit_receipt2 method=POST>";
echo "<input type=text value=\"$depemail\" name=depemail class=textbox size=25><input type=hidden value=$depositid name=depositid><input type=hidden value=$returnurl name=returnurl>";
echo "<input type=submit class=button value=\"".pcrtlang("Email Deposit Receipt")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Sending Email")."...'; this.form.submit();\"></form><br><br>";


stop_blue_box();

require_once("footer.php");


}




function email_deposit_receipt2() {
require_once("validate.php");
$depositid = $_REQUEST['depositid'];
$depemail = $_REQUEST['depemail'];
$returnurl = $_REQUEST['returnurl'];

include("deps.php");
include("common.php");

if (($demo == "yes") && ($ipofpc != "admin")) {
die("Sorry this feature is disabled in demo mode");
}

require("deps.php");



$rs_find_name = "SELECT * FROM deposits WHERE depositid = '$depositid'";
$rs_result_name = mysqli_query($rs_connect, $rs_find_name);

while($rs_result_name_q = mysqli_fetch_object($rs_result_name)) {
$rs_soldto = "$rs_result_name_q->pfirstname";
$rs_company = "$rs_result_name_q->pcompany";
$rs_ad1 = "$rs_result_name_q->paddress";
$rs_ad2 = "$rs_result_name_q->paddress2";
$rs_ph = "$rs_result_name_q->pphone";
$rs_cn = "$rs_result_name_q->chk_number";
$rs_ccn = "$rs_result_name_q->cc_number";
$rs_datesold = "$rs_result_name_q->depdate";
$rs_pw = "$rs_result_name_q->paymenttype";
$rs_byuser = "$rs_result_name_q->byuser";
$rs_city = "$rs_result_name_q->pcity";
$rs_state = "$rs_result_name_q->pstate";
$rs_zip = "$rs_result_name_q->pzip";
$rs_email = "$rs_result_name_q->pemail";
$woid = "$rs_result_name_q->woid";
$rs_storeid = "$rs_result_name_q->storeid";

$paymentamount = "$rs_result_name_q->amount";
$pfirstname = "$rs_result_name_q->pfirstname";
$pcompany = "$rs_result_name_q->pcompany";
$paymenttype = "$rs_result_name_q->paymenttype";
$paymentplugin = "$rs_result_name_q->paymentplugin";
$checknumber = "$rs_result_name_q->chk_number";
$ccnumber2 = "$rs_result_name_q->cc_number";
$ccexpmonth = "$rs_result_name_q->cc_expmonth";
$ccexpyear = "$rs_result_name_q->cc_expyear";
$cc_transid = "$rs_result_name_q->cc_transid";
$cc_cardtype = "$rs_result_name_q->cc_cardtype";
$custompaymentinfo2 = "$rs_result_name_q->custompaymentinfo";

$custompaymentinfo = unserialize("$custompaymentinfo2");

$ccnumber = substr("$ccnumber2", -4, 4);

$storeinfoarray = getstoreinfo($rs_storeid);

$to = "$depemail";

if($storeinfoarray['storeccemail'] != "")	{
$to .= ",$storeinfoarray[storeccemail]";
}

$subject = "$storeinfoarray[storename] - ".pcrtlang("Deposit Receipt")." #$depositid";
$random_hash = md5(date('r', time()));
$headers = "From: $storeinfoarray[storeemail]\r\nReply-To: $storeinfoarray[storeemail]\r\nX-Mailer: PHP/".phpversion();
$headers .= "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
$headers .= "\r\nMIME-Version: 1.0";

$message = "--PHP-alt-$random_hash\r";
$message .= "Content-Type: text/plain; charset=\"iso-8859-1\"\r";
$message .= "Content-Transfer-Encoding: 7bit\r";

$message .= "Sorry, Your email client does not support html email.\n";
$peartext = "Sorry, Your email client does not support html email.\n";

$message .= "--PHP-alt-$random_hash\n";
$message .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
$message .= "Content-Transfer-Encoding: 7bit\n\n";

$message .= "<html><head><title>".pcrtlang("Deposit Receipt").": #$depositid</title></head><body>";
$message .= "<table width=100%><tr><td width=55%>";

$pearhtml = "<html><head><title>".pcrtlang("Deposit Receipt").": #$depositid</title></head><body>";
$pearhtml .= "<table width=100%><tr><td width=55%>";


$message .= "<font face=Arial size=4><b>$storeinfoarray[storename]</b><br></font>\n<font face=arial size=3><i>$servicebyline</i><br>\n";
$pearhtml .= "<img src=$logo>\n<br><font face=arial size=3><i>$servicebyline</i><br>\n";

$message .= "<br>$storeinfoarray[storeaddy1]<br>";
if ("$storeinfoarray[storeaddy2]" != "") {
$message .="<br>$storeinfoarray[storeaddy2]\n";
}
$message .= "$storeinfoarray[storecity], $storeinfoarray[storestate] $storeinfoarray[storezip]\n";
$message .= "</font><br><br>".pcrtlang("Phone").": $storeinfoarray[storephone]</font></font><br><br>\n";


$pearhtml .= "<br>$storeinfoarray[storeaddy1]<br>";
if ("$storeinfoarray[storeaddy2]" != "") {
$pearhtml .="<br>$storeinfoarray[storeaddy2]\n";
}
$pearhtml .= "$storeinfoarray[storecity], $storeinfoarray[storestate] $storeinfoarray[storezip]\n";
$pearhtml .= "</font><br><br>".pcrtlang("Phone").": $storeinfoarray[storephone]</font></font><br><br>\n";



$message .= "<table cellpadding=3 cellspacing=0 border=0><tr><td valign=top><b>".pcrtlang("Received From").":</b></td><td>$rs_soldto";
if("$rs_company" != "") {
$message .= "<br>$rs_company";
}
$message .= "<br>$rs_ad1";
$pearhtml .= "<table cellpadding=3 cellspacing=0 border=0><tr><td valign=top><b>".pcrtlang("Received From").":</b></td><td>$rs_soldto";
if("$rs_company" != "") {
$pearhtml .= "<br>$rs_company";
}
$pearhtml .= "<br>$rs_ad1";
if ($rs_ad2 != "") {
$message .= "<br>$rs_ad2";
$pearhtml .= "<br>$rs_ad2";
}

$message .= "<br>";
$pearhtml .= "<br>";
if ($rs_city != "") {
$message .= "$rs_city,";
$pearhtml .= "$rs_city,";
}
$message .= "$rs_state $rs_zip<br>";
$pearhtml .= "$rs_state $rs_zip<br>";

$message .= "</td></tr></table>";
$message .= "</font><br></td><td align=right width=45% valign=top>";
$message .= "<font color=888888 face=arial size=6>".pcrtlang("Deposit Receipt")." #$depositid<br></font>";

$pearhtml .= "</td></tr></table>";
$pearhtml .= "</font><br></td><td align=right width=45% valign=top>";
$pearhtml .= "<font color=888888 face=arial size=6>".pcrtlang("Deposit Receipt")." #$depositid<br></font>";

$rs_datesold2 = pcrtdate("$pcrt_longdate", "$rs_datesold").", ".pcrtdate("$pcrt_time", "$rs_datesold");

$message .= "<br>".pcrtlang("Deposit Date").":<font color=888888> $rs_datesold2</font><br>";
$pearhtml .= "<br>".pcrtlang("Deposit Date").":<font color=888888> $rs_datesold2</font><br>";

if ($rs_byuser != "") {
$message .= "<br>".pcrtlang("Received By").":<font color=#888888> $rs_byuser</font>";
$pearhtml .= "<br>".pcrtlang("Received By").":<font color=#888888> $rs_byuser</font>";
}


$message .= "</td></tr></table>";
$pearhtml .= "</td></tr></table>";

$message .= "<table><tr>";
$pearhtml .= "<table><tr>";

if ($paymenttype == "cash") {
$message .= "<td valign=top style=\"padding:0px 30px 0px 5px;border: 2px solid #000000;border-radius:10px;\">";
$message .= "<font style=\"border: 2px solid #000000;padding5px;border-radius:7px;font-size:28px;\">&nbsp;".pcrtlang("Cash")."&nbsp;</font><br>";
$message .= "<font style=\"font-size:20px;\">$pfirstname"; 
if("$pcompany" != "") {
$message .= " - $pcompany";
}
$message .= " - $money".mf("$paymentamount")."</font></td>";

$pearhtml .= "<td valign=top style=\"padding:0px 30px 0px 5px;border: 2px solid #000000;border-radius:10px;\">";
$pearhtml .= "<font style=\"border: 2px solid #000000;padding5px;border-radius:7px;font-size:28px;\">&nbsp;".pcrtlang("Cash")."&nbsp;</font><br>";
$pearhtml .= "<font style=\"font-size:20px;\">$pfirstname";
if("$pcompany" != "") {
$pearhtml .= " - $pcompany";
}
$pearhtml .= " - $money".mf("$paymentamount")."</font></td>";


} elseif ($paymenttype == "check") {
$message .= "<td valign=top style=\"padding:0px 30px 0px 5px;border: 2px solid #000000;border-radius:10px;\">";
$message .= "<font style=\"border: 2px solid #000000;padding3px;border-radius:7px;font-size:28px;\">&nbsp;".pcrtlang("Check")." #$checknumber&nbsp;</font><br>";
$message .= "<font style=\"font-size:20px;\">$pfirstname";
if("$pcompany" != "") {
$message .= " - $pcompany";
}
$message .= " - $money".mf("$paymentamount")."</font></td>";


$pearhtml .= "<td valign=top style=\"padding:0px 30px 0px 5px;border: 2px solid #000000;border-radius:10px;\">";
$pearhtml .= "<font style=\"border: 2px solid #000000;padding3px;border-radius:7px;font-size:28px;\">&nbsp;".pcrtlang("Check")." #$checknumber&nbsp;</font><br>";
$pearhtml .= "<font style=\"font-size:20px;\">$pfirstname";
if("$pcompany" != "") {
$pearhtml .= " - $pcompany";
}
$pearhtml .= " - $money".mf("$paymentamount")."</font></td>";



} elseif ($paymenttype == "credit") {
$message .= "<td valign=top style=\"padding:0px 30px 0px 5px;border: 2px solid #000000;border-radius:10px;\">";
$message .= "<font style=\"border: 2px solid #000000;padding3px;border-radius:7px;font-size:28px;\">&nbsp;".pcrtlang("Credit Card")."&nbsp;</font>";
$message .= "<br><font style=\"font-size:20px;\">XXXX-$ccnumber<br>";
$message .= "<font style=\"font-size:20px;\">$pfirstname";
if("$pcompany" != "") {
$message .= " - $pcompany";
}
$message .= " - $money".mf("$paymentamount")."<br>$paymentplugin $cc_cardtype</font></td>";


$pearhtml .= "<td valign=top style=\"padding:0px 30px 0px 5px;border: 2px solid #000000;border-radius:10px;\">";
$pearhtml .= "<font style=\"border: 2px solid #000000;padding3px;border-radius:7px;font-size:28px;\">&nbsp;".pcrtlang("Credit Card")."&nbsp;</font>";
$pearhtml .= "<br><font style=\"font-size:20px;\">XXXX-$ccnumber<br>";
$pearhtml .= "<font style=\"font-size:20px;\">$pfirstname";
if("$pcompany" != "") {
$pearhtml .= " - $pcompany";
}
$pearhtml .= " - $money".mf("$paymentamount")."<br>$paymentplugin $cc_cardtype</font></td>";

} elseif ($paymenttype == "custompayment") {
$message .= "<td valign=top style=\"padding:0px 30px 0px 5px;border: 2px solid #000000;border-radius:10px;\">";
$message .= "<font style=\"border: 2px solid #000000;padding3px;border-radius:7px;font-size:28px;\">&nbsp;$paymentplugin&nbsp;</font><br>";
$message .= "<font style=\"font-size:20px;\">$pfirstname";
if("$pcompany" != "") {
$message .= " - $pcompany";
}
$message .= " - $money".mf("$paymentamount")."</font></td>";



$pearhtml .= "<td valign=top style=\"padding:0px 30px 0px 5px;border: 2px solid #000000;border-radius:10px;\">";
$pearhtml .= "<font style=\"border: 2px solid #000000;padding3px;border-radius:7px;font-size:28px;\">&nbsp;$paymentplugin&nbsp;</font><br>";
$pearhtml .= "<font style=\"font-size:20px;\">$pfirstname";
if("$pcompany" != "") {
$pearhtml .= " - $pcompany";
}
$pearhtml .= " - $money".mf("$paymentamount")."</font></td>";


reset($custompaymentinfo);
foreach($custompaymentinfo as $key => $val) {
if(!in_array("$key", $CustomPaymentPrintExclude)) {
$message .= "<font style=\"font-size:10px;\">$key: $val</font><br>";
$pearhtml .= "<font style=\"font-size:10px;\">$key: $val</font><br>";
}
}

$message .= "</td>";
$pearhtml .= "</td>";

} else {
$message .= "<td colspan=2 style=\"padding:0px 30px 0px 5px;border: 2px solid #000000;border-radius:10px;font-size:28px;\">";
$message .= "Error! Undefined Payment Type in database</font></td>";

$pearhtml .= "<td colspan=2 style=\"padding:0px 30px 0px 5px;border: 2px solid #000000;border-radius:10px;font-size:28px;\">";
$pearhtml .= "Error! Undefined Payment Type in database</font></td>";
}

$message .= "</tr></table>";
$pearhtml .= "</tr></table>";

}

$message .= "<br><br><br>";
$pearhtml .= "<br><br><br>";

$message .= nl2br($storeinfoarray['depositfooter']);
$message .= "\n</body></html>\n\r";
$pearhtml .= nl2br($storeinfoarray['depositfooter']);
$pearhtml .= "\n</body></html>\n\r";

$message .= "--PHP-alt-$random_hash--\n\n";

if($woid == 0) {
$gotourl = "deposits.php";
} else {
$gotourl = "../repair/index.php?pcwo=$woid";
}

if (!isset($pcrt_mailer)) {
$pcrt_mailer = "mail";
}

if ($pcrt_mailer == "mail") {
$mail_sent = @mail( $to, $subject, $message, $headers );
echo $mail_sent ? "<html><head><meta http-equiv=\"refresh\" content=\"2;url=$gotourl\"></head><body>".pcrtlang("Mail sent")."<br><br><a href=$gotourl>".pcrtlang("Return")."</a></body></html>" : pcrtlang("Mail failed");
} elseif (($pcrt_mailer == "pearsmtp") || ($pcrt_mailer == "pearsmtpauth") || ($pcrt_mailer == "pearphpmailer")) {

if (!@include('Mail.php'))  {
echo "<div style=\"border: #ff0000 2px solid; background:#FFBCBC; color:#ff0000; margin: 20px; padding:20px;\">";
echo "Sorry you server does not have support for the Pear Mail and Pear Mail-Mime library. Check with your host to see if it is supported, or visit go-pear.com to download the pear installer
that can be run from your website to install your own local copy of Pear and the Pear Mail and Pear Mail-Mime modules.<br><br>If you choose to install your own copy, after installing, you
will need to also add the Mail and Mail-Mime packages. You will need to use your host control panel to password protect the directory. You will also need to add a setting to a
php.ini or php5.ini file to specify the runtime path of pear for your server. Quite often you can google your hosting provider name and pear to find a howto for your host.
if you are running your own linux server, quite often your distribution provides ready to install Pear packages.";
echo "</div>";
die();
}


#include('Mail.php');
    include('Mail/mime.php');

    $pearmessage2 = new Mail_mime();

    $pearmessage2->setTXTBody($peartext);
    $pearmessage2->setHTMLBody($pearhtml);

$imagetype = substr("$logo", -3);
if ($imagetype == "gif") {
$pearmessage2->addHTMLImage("$logo", 'image/gif');
} elseif ($imagetype == "jpg") {
$pearmessage2->addHTMLImage("$logo", 'image/jpeg');
} elseif ($imagetype == "png") {
$pearmessage2->addHTMLImage("$logo", 'image/png');
} else {
}

$mime_params = array(
  'text_encoding' => '7bit',
  'text_charset'  => 'UTF-8',
  'html_charset'  => 'UTF-8',
  'head_charset'  => 'UTF-8'
);

    $body = $pearmessage2->get($mime_params);
    $extraheaders = array("To"=>"$to","From"=>"$storeinfoarray[storeemail]", "Subject"=>"$subject", "Content-Type"  => "text/html; charset=UTF-8");
    $pearheaders = $pearmessage2->headers($extraheaders);

if ("$pcrt_mailer" == "pearsmtpauth") {
$smtp = Mail::factory('smtp',
   array ('host' => $pcrt_pear_host,
     'auth' => true,
     'port' => $pcrt_pear_port,
     'username' => $pcrt_pear_username,
     'password' => $pcrt_pear_password));
} elseif ("$pcrt_mailer" == "pearphpmailer") {
$smtp = Mail::factory('mail');
} elseif ("$pcrt_mailer" == "pearsmtp")  {
$smtp = Mail::factory('smtp');
} else {
die("Invalid Mailer Chosen");
}


$mailresult = $smtp->send("$to", $pearheaders, $body);

if (PEAR::isError($mailresult)) {
   echo("<p>" . $mailresult->getMessage() . "</p>");
  } else {
   echo "<html><head><meta http-equiv=\"refresh\" content=\"2;url=$returnurl\"></head><body>".pcrtlang("Mail sent")."<br>";
   echo "<br><a href=$returnurl>".pcrtlang("Return")."</a></body></html>";
  }

} else {
echo "Error: invalid mailer specified in the deps.php config file";
}

}


####################


function adddep() {
require_once("validate.php");
require("deps.php");
require("common.php");

$depositid = $_REQUEST['depositid'];

$rs_finddeposits_sql = "SELECT * FROM deposits WHERE depositid = '$depositid'";
$rs_find_deposits = @mysqli_query($rs_connect, $rs_finddeposits_sql);
while($rs_find_payments_q = mysqli_fetch_object($rs_find_deposits)) {
$pfirstname = pv($rs_find_payments_q->pfirstname);
$plastname = pv($rs_find_payments_q->plastname);
$pcompany = pv($rs_find_payments_q->pcompany);
$paddress = pv($rs_find_payments_q->paddress);
$paddress2 = pv($rs_find_payments_q->paddress2);
$pcity = pv($rs_find_payments_q->pcity);
$pstate = pv($rs_find_payments_q->pstate);
$pzip = pv($rs_find_payments_q->pzip);
$pphone = pv($rs_find_payments_q->pphone);
$pemail = pv($rs_find_payments_q->pemail);
$amount = pv($rs_find_payments_q->amount);
$paymentplugin = pv($rs_find_payments_q->paymentplugin);
$cc_number = "$rs_find_payments_q->cc_number";
$cc_expmonth = pv($rs_find_payments_q->cc_expmonth);
$cc_expyear = pv($rs_find_payments_q->cc_expyear);
$cc_transid = pv($rs_find_payments_q->cc_transid);
$cc_confirmation = pv($rs_find_payments_q->cc_confirmation);
$cc_cid = pv($rs_find_payments_q->cc_cid);
$cc_track1 = pv($rs_find_payments_q->cc_track1);
$cc_track2 = pv($rs_find_payments_q->cc_track2);
$chk_dl = pv($rs_find_payments_q->chk_dl);
$chk_number = pv($rs_find_payments_q->chk_number);
$paymentstatus = pv($rs_find_payments_q->paymentstatus);
$paymenttype = pv($rs_find_payments_q->paymenttype);
$ccnumber2 = substr("$cc_number", -4);
$cc_cardtype = pv($rs_find_payments_q->cc_cardtype);
$dstatus = pv($rs_find_payments_q->dstatus);
$depdate = pv($rs_find_payments_q->depdate);
$storeid = pv($rs_find_payments_q->storeid);
$pcompany = pv($rs_find_payments_q->pcompany);
$parentdeposit = pv($rs_find_payments_q->parentdeposit);
$registerid = pv($rs_find_payments_q->registerid);
$aregisterid = pv($rs_find_payments_q->aregisterid);

if($parentdeposit == 0) {
$parentdepositid = $depositid;
} else {
$parentdepositid = $parentdeposit;
}

$custompaymentinfo = pv($rs_find_payments_q->custompaymentinfo);
$cashchange = pv($rs_find_payments_q->cashchange);
$cashchange2 = pv($rs_find_payments_q->cashchange2);

#wip
if (!array_key_exists('balance', $_REQUEST)) {
$insertpaymentssql = "INSERT INTO currentpayments (pfirstname,plastname,pcompany,paddress,paddress2,pcity,pstate,pzip,pphone,pemail,byuser,amount,paymentplugin,
cc_number,cc_expmonth,cc_expyear,cc_transid,cc_confirmation,chk_dl,chk_number,paymentstatus,paymenttype,cc_cardtype,custompaymentinfo,isdeposit,depositid,cashchange) 
VALUES ('$pfirstname', '$plastname', '$pcompany', '$paddress', '$paddress2', '$pcity', '$pstate', '$pzip', '$pphone', '$pemail', '$ipofpc','$amount','$paymentplugin',
'$ccnumber2', '$cc_expmonth', '$cc_expyear', '$cc_transid', '$cc_confirmation', '$chk_dl', '$chk_number','$paymentstatus', '$paymenttype','$cc_cardtype',
'$custompaymentinfo','1','$depositid','$cashchange')";
@mysqli_query($rs_connect, $insertpaymentssql);

} else {
$balance = $_REQUEST['balance'];
$amountextra = $_REQUEST['amountextra'];
$insertpaymentssql = "INSERT INTO currentpayments (pfirstname,plastname,pcompany,paddress,paddress2,pcity,pstate,pzip,pphone,pemail,byuser,amount,paymentplugin,
cc_number,cc_expmonth,cc_expyear,cc_transid,cc_confirmation,chk_dl,chk_number,paymentstatus,paymenttype,cc_cardtype,custompaymentinfo,isdeposit,depositid,cashchange)
VALUES ('$pfirstname', '$plastname', '$pcompany', '$paddress', '$paddress2', '$pcity', '$pstate', '$pzip', '$pphone', '$pemail', '$ipofpc','$balance','$paymentplugin',
'$ccnumber2', '$cc_expmonth', '$cc_expyear', '$cc_transid', '$cc_confirmation', '$chk_dl', '$chk_number','$paymentstatus', '$paymenttype','$cc_cardtype',
'$custompaymentinfo','1','$depositid','$cashchange')";
@mysqli_query($rs_connect, $insertpaymentssql);

$editdepositsql = "UPDATE deposits SET amount = '$balance', cashchange = '', cashchange2 = '' WHERE depositid = '$depositid'";
@mysqli_query($rs_connect, $editdepositsql);


$insertnewdepositsql = "INSERT INTO deposits (pfirstname,plastname,pcompany,paddress,paddress2,pcity,pstate,pzip,pphone,pemail,byuser,amount,paymentplugin,
cc_number,cc_expmonth,cc_expyear,cc_transid,cc_confirmation,cc_cid,cc_track1,cc_track2,chk_dl,chk_number,paymentstatus,paymenttype,cc_cardtype,custompaymentinfo,
dstatus,depdate,storeid,parentdeposit,registerid,aregisterid)
VALUES ('$pfirstname', '$plastname', '$pcompany', '$paddress', '$paddress2', '$pcity', '$pstate', '$pzip', '$pphone', '$pemail', '$ipofpc','$amountextra',
'$paymentplugin',
'$ccnumber2', '$cc_expmonth', '$cc_expyear', '$cc_transid', '$cc_confirmation', '$cc_cid', '$cc_track1', '$cc_track2', '$chk_dl', '$chk_number','$paymentstatus',
'$paymenttype','$cc_cardtype',
'$custompaymentinfo','$dstatus','$depdate','$storeid','$parentdepositid','$registerid','$aregisterid')";


@mysqli_query($rs_connect, $insertnewdepositsql);




}


}


header("Location: cart.php");
}

###########


function editdeposit() {

require_once("common.php");
if(($gomodal != "1") || array_key_exists('modaloff', $_REQUEST)) {
require("header.php");
} else {
require_once("validate.php");
}


$depositid = $_REQUEST['depositid'];


if(($gomodal != "1") || array_key_exists("modaloff", $_REQUEST)) {
start_blue_box(pcrtlang("Edit Deposit"));
} else {
echo "<h4>".pcrtlang("Edit Deposit")."</h4>";
}




$rs_find_name = "SELECT * FROM deposits WHERE depositid = '$depositid'";
$rs_result_name = mysqli_query($rs_connect, $rs_find_name);

$rs_result_name_q = mysqli_fetch_object($rs_result_name);
$rs_soldto = "$rs_result_name_q->pfirstname";
$rs_company = "$rs_result_name_q->pcompany";
$rs_ad1 = "$rs_result_name_q->paddress";
$rs_ad2 = "$rs_result_name_q->paddress2";
$rs_city = "$rs_result_name_q->pcity";
$rs_state = "$rs_result_name_q->pstate";
$rs_zip = "$rs_result_name_q->pzip";
$rs_ph = "$rs_result_name_q->pphone";
$rs_email = "$rs_result_name_q->pemail";
$registerid = "$rs_result_name_q->registerid";


echo "<form action=deposits.php?func=editdeposit2 method=post>";
echo "<table width=100%>";
echo "<tr><td>".pcrtlang("Customer Name").":</td><td><input size=35 class=textbox type=text name=depname value=\"$rs_soldto\"></td></tr>";
echo "<tr><td>".pcrtlang("Company").":</td><td><input size=35 class=textbox type=text name=depcompany value=\"$rs_company\"></td></tr>";
echo "<tr><td>$pcrt_address1:</td><td><input size=35 type=text class=textbox name=depaddy1 value=\"$rs_ad1\"></td></tr>";
echo "<tr><td>$pcrt_address2:</td><td><input size=35 type=text class=textbox name=depaddy2 value=\"$rs_ad2\"></td></tr>";
echo "<tr><td>$pcrt_city:</td><td><input size=35 type=text class=textbox name=depcity value=\"$rs_city\"></td></tr>";
echo "<tr><td>$pcrt_state:</td><td><input size=35 type=text class=textbox name=depstate value=\"$rs_state\"></td></tr>";
echo "<tr><td>$pcrt_zip:</td><td><input size=35 type=text class=textbox name=depzip value=\"$rs_zip\"></td></tr>";
echo "<tr><td>".pcrtlang("Customer Phone").":</td><td><input size=35 type=text class=textbox name=depphone value=\"$rs_ph\"></td></tr>";
echo "<tr><td>".pcrtlang("Customer Email").":</td><td><input size=35 type=text class=textbox name=depemail value=\"$rs_email\"></td></tr>";

echo "<tr><td>".pcrtlang("Register").":</td><td>";


$rs_find_registers = "SELECT * FROM registers WHERE registerstoreid = '$defaultuserstore' ORDER BY registername ASC";
$rs_result_registers = mysqli_query($rs_connect, $rs_find_registers);

$rs_find_register = "SELECT * FROM registers WHERE registerid = '$registerid'";
$rs_result_register = mysqli_query($rs_connect, $rs_find_register);
$registerexists = mysqli_num_rows($rs_result_register);

echo "<select name=setregisterid>";

if (($registerexists == 0) && ($registerid != 0)) {
echo "<option value=$registerid selected>".pcrtlang("Deleted Register")."</option>";
}
if ($registerid == 0) {
echo "<option value=0 selected>".pcrtlang("Unset")."</option>";
} else {
echo "<option value=0>".pcrtlang("Unset")."</option>";
}

while($rs_result_registerq = mysqli_fetch_object($rs_result_registers)) {
$rs_registername = "$rs_result_registerq->registername";
$rs_registerid = "$rs_result_registerq->registerid";

if ($rs_registerid == $registerid) {
echo "<option selected value=$rs_registerid>$rs_registername</option>";
} else {
echo "<option value=$rs_registerid>$rs_registername</option>";
}

}
echo "</select></td></tr>";

echo "<tr><td></td><td><input type=hidden name=depositid value=\"$depositid\"><input type=submit class=ibutton value=\"".pcrtlang("Save Deposit")."\" onclick=\"this.disabled=true;this.value='".pcrtlang("Saving Deposit")."...'; this.form.submit();\"></td></tr>";
echo "</table>";

if(($gomodal != "1") || array_key_exists('modaloff', $_REQUEST)) {
stop_blue_box();
require_once("footer.php");
}


}


function editdeposit2() {
require_once("validate.php");
require("deps.php");
require("common.php");

$depositid = $_REQUEST['depositid'];
$depname = pv($_REQUEST['depname']);
$depcompany = pv($_REQUEST['depcompany']);
$depaddy1 = pv($_REQUEST['depaddy1']);
$depaddy2 = pv($_REQUEST['depaddy2']);
$depphone = pv($_REQUEST['depphone']);
$depemail = pv($_REQUEST['depemail']);
$depcity = pv($_REQUEST['depcity']);
$depstate = pv($_REQUEST['depstate']);
$depzip = pv($_REQUEST['depzip']);
$setregisterid = pv($_REQUEST['setregisterid']);




$rs_update_deposit = "UPDATE deposits SET pfirstname = '$depname', pcompany = '$depcompany', paddress = '$depaddy1', paddress2 = '$depaddy2', pphone = '$depphone', pcity = '$depcity', pstate = '$depstate', pzip = '$depzip', pemail = '$depemail', registerid = '$setregisterid' WHERE depositid = '$depositid'";
@mysqli_query($rs_connect, $rs_update_deposit);

header("Location: deposits.php");

}


function savesig() {

require("deps.php");
require("common.php");

$output = pv($_REQUEST['output']);
$depositid = $_REQUEST['depositid'];

require_once("validate.php");




$rs_savesig = "UPDATE deposits SET thesig = '$output' WHERE depositid = '$depositid'";
@mysqli_query($rs_connect, $rs_savesig);

header("Location: deposits.php?func=deposit_receipt&depositid=$depositid");

}

function savesigtopaz() {

require("deps.php");
require("common.php");

$output = pv($_REQUEST['sigImageData']);
$depositid = $_REQUEST['depositid'];

require_once("validate.php");




$rs_savesig = "UPDATE deposits SET thesigtopaz = '$output' WHERE depositid = '$depositid'";
@mysqli_query($rs_connect, $rs_savesig);

header("Location: deposits.php?func=deposit_receipt&depositid=$depositid");

}


function clearsig() {

require("deps.php");
require("common.php");

$depositid = $_REQUEST['depositid'];

require_once("validate.php");




$rs_savesig = "UPDATE deposits SET thesig = '' WHERE depositid = '$depositid'";
@mysqli_query($rs_connect, $rs_savesig);

header("Location: deposits.php?func=deposit_receipt&depositid=$depositid");

}


function clearsigtopaz() {

require("deps.php");
require("common.php");

$depositid = $_REQUEST['depositid'];

require_once("validate.php");




$rs_savesig = "UPDATE deposits SET thesigtopaz = '' WHERE depositid = '$depositid'";
@mysqli_query($rs_connect, $rs_savesig);

header("Location: deposits.php?func=deposit_receipt&depositid=$depositid");

}


function hidesigdep() {

require("deps.php");
require("common.php");

$hidesig = pv($_REQUEST['hidesig']);
$depositid = $_REQUEST['depositid'];

require_once("validate.php");




$rs_hidesig = "UPDATE deposits SET showsigdep = '$hidesig' WHERE depositid = '$depositid'";
@mysqli_query($rs_connect, $rs_hidesig);

header("Location: deposits.php?func=deposit_receipt&depositid=$depositid");

}


function hidesigdeptopaz() {

require("deps.php");
require("common.php");

$hidesig = pv($_REQUEST['hidesig']);
$depositid = $_REQUEST['depositid'];

require_once("validate.php");




$rs_hidesig = "UPDATE deposits SET showsigdeptopaz = '$hidesig' WHERE depositid = '$depositid'";
@mysqli_query($rs_connect, $rs_hidesig);

header("Location: deposits.php?func=deposit_receipt&depositid=$depositid");

}



function searchdeposits() {
require_once("header.php");
require("deps.php");

$searchterm = $_REQUEST['searchterm'];





start_box();
echo "<form action=deposits.php?func=searchdeposits method=POST>";
echo "<input type=text value=\"$searchterm\" name=searchterm class=textbox size=25>";
echo "<input type=submit class=button value=\"".pcrtlang("Search Again")."\"></form>";
stop_box();

echo "<br>";

start_color_box("51",pcrtlang("Deposit Search Results"));
echo "<table class=standard>";
echo "<tr><th>".pcrtlang("Dep")."#</th><th>".pcrtlang("Customer Name")."</th><th>".pcrtlang("Deposit Date")."</th><th>".pcrtlang("Applied Date")."</th>";
echo "<th>".pcrtlang("Total")."</th><th>".pcrtlang("Actions")."</th></tr>";


$rs_deposits = "SELECT * FROM deposits WHERE pfirstname LIKE '%$searchterm%' OR plastname LIKE '%$searchterm%' OR pphone LIKE '%$searchterm%' OR pemail LIKE '%$searchterm%' OR pcompany LIKE '%$searchterm%' ORDER BY depdate DESC";
$rs_find_deposits = @mysqli_query($rs_connect, $rs_deposits);
while($rs_find_deposits_q = mysqli_fetch_object($rs_find_deposits)) {
$depositid = "$rs_find_deposits_q->depositid";
$depfirstname = "$rs_find_deposits_q->pfirstname";
$deplastname = "$rs_find_deposits_q->plastname";
$depname = "$depfirstname $deplastname";
$depcompany = "$rs_find_deposits_q->pcompany";
$depamount2 = "$rs_find_deposits_q->amount";
$depamount = number_format($depamount2, 2, '.', '');
$depwoid = "$rs_find_deposits_q->woid";
$depemail = "$rs_find_deposits_q->pemail";
$paymentplugin = "$rs_find_deposits_q->paymentplugin";
$depdate = "$rs_find_deposits_q->depdate";
$depdate2 = pcrtdate("$pcrt_longdate", "$depdate");
$deprec = "$rs_find_deposits_q->receipt_id";
$applieddate = "$rs_find_deposits_q->applieddate";
$applieddate2 = pcrtdate("$pcrt_longdate", "$applieddate");

echo "<tr><td>$depositid</td><td><span class=boldme>$depfirstname</span>";
if("$depcompany" != "") {
echo "<br><span class=sizeme10>$depcompany</span>";
}
echo "</td><td>$depdate2</td><td>$applieddate2</td>
<td>$money".mf("$depamount")."</td>";
echo "<td><a href=deposits.php?func=deposit_receipt&depositid=$depositid&depemail=$depemail&woid=$depwoid class=\"linkbuttonsmall linkbuttongray radiusall\"><i class=\"fa fa-print\"></i> ".pcrtlang("Print")."</a> ";
if($depwoid != "0") {
echo "<a href=../repair/index.php?pcwo=$depwoid class=\"linkbuttonsmall linkbuttongray radiusall\">".pcrtlang("View Work Order")." #$depwoid</a> ";
}
if($deprec != "0") {
echo " <a href=receipt.php?func=show_receipt&receipt=$deprec class=\"linkbuttonsmall linkbuttongray radiusall\">".pcrtlang("View Receipt")." #$deprec</a>";
}
echo "</td></tr>";
}
echo "</table>";
stop_color_box();

echo "<br>";



require_once("footer.php");

}





function deposit_gift() {
require_once("validate.php");
$depositid = $_REQUEST['depositid'];

include("deps.php");
include("common.php");


$narrow = $receiptsnarrow;

?>
<!DOCTYPE html>

<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php


echo "<title>".pcrtlang("Print Gift Certificate").": #$depositid</title>";

echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../repair/printstyle.css\">";
echo "<link rel=\"stylesheet\" href=\"../repair/fa/css/font-awesome.min.css\">";


if (!isset($enablesignaturepad_deposits)) {
$enablesignaturepad_deposit = "no";
}

echo "</head>";

if($autoprint == 1) {
echo "<body class=printpagebg onLoad=\"window.print()\">";
} else {
echo "<body class=printpagebg>";
}




if(!array_key_exists('woid', $_REQUEST)) {
$returnurl = "deposits.php";
} else {
$pcwoid = $_REQUEST['woid'];
if ($pcwoid == 0) {
$returnurl = "deposits.php";
} else {
$returnurl = "../repair/index.php?pcwo=$pcwoid";
}
}


echo "<div class=printbar>";
echo "<button onClick=\"parent.location='$returnurl'\" class=bigbutton><img src=images/left.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Return")."</button>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<button onClick=\"print();\" class=bigbutton><img src=images/print.png style=\"vertical-align:middle;margin-bottom: .25em;\"> ".pcrtlang("Print")."</button>";

echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
$returnreceipt = urlencode("../store/deposits.php?func=deposit_receipt&depositid=$depositid");

echo "</div>";

require("deps.php");




echo "<div class=printpage>";




$rs_find_name = "SELECT * FROM deposits WHERE depositid = '$depositid'";
$rs_result_name = mysqli_query($rs_connect, $rs_find_name);

$rs_result_name_q = mysqli_fetch_object($rs_result_name);
$rs_soldto = "$rs_result_name_q->pfirstname";
$rs_ad1 = "$rs_result_name_q->paddress";
$rs_company = "$rs_result_name_q->pcompany";
$rs_ad2 = "$rs_result_name_q->paddress2";
$rs_ph = "$rs_result_name_q->pphone";
$rs_cn = "$rs_result_name_q->chk_number";
$rs_ccn = "$rs_result_name_q->cc_number";
$rs_datesold = "$rs_result_name_q->depdate";
$rs_pw = "$rs_result_name_q->paymenttype";
$rs_byuser = "$rs_result_name_q->byuser";
$rs_city = "$rs_result_name_q->pcity";
$rs_state = "$rs_result_name_q->pstate";
$rs_zip = "$rs_result_name_q->pzip";
$rs_email = "$rs_result_name_q->pemail";
$rs_email2 = urlencode($rs_email);
$rs_storeid = "$rs_result_name_q->storeid";
$thesig = "$rs_result_name_q->thesig";
$showsigdep = "$rs_result_name_q->showsigdep";
$thesigtopaz = "$rs_result_name_q->thesigtopaz";
$showsigdeptopaz = "$rs_result_name_q->showsigdeptopaz";

$storeinfoarray = getstoreinfo($rs_storeid);

$woid = "$rs_result_name_q->woid";

$paymentamount2 = "$rs_result_name_q->amount";
$paymentamount = number_format($paymentamount2, 2, '.', '');
$pfirstname = "$rs_result_name_q->pfirstname";
$pcompany = "$rs_result_name_q->pcompany";
$paymenttype = "$rs_result_name_q->paymenttype";
$paymentplugin = "$rs_result_name_q->paymentplugin";
$checknumber = "$rs_result_name_q->chk_number";
$ccnumber2 = "$rs_result_name_q->cc_number";
$ccexpmonth = "$rs_result_name_q->cc_expmonth";
$ccexpyear = "$rs_result_name_q->cc_expyear";
$cc_transid = "$rs_result_name_q->cc_transid";
$cc_cardtype = "$rs_result_name_q->cc_cardtype";
$custompaymentinfo2 = "$rs_result_name_q->custompaymentinfo";

$custompaymentinfo = unserialize("$custompaymentinfo2");

$ccnumber = substr("$ccnumber2", -4, 4);


echo "<div style=\"width:100%;border: #000000 20px double;padding: 0px 20px 0px 20px;box-sizing:border-box;\">";
echo "<link href='http://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>";
echo "<h3 style=\"text-align:center;font: 400 50px/1.0 'Pacifico', Helvetica, sans-serif;\"><i class=\"fa fa-gift fa-lg\"></i> ".pcrtlang("Gift Certificate")." <i class=\"fa fa-gift fa-lg\"></i></h3>";

echo "<table style=\"width:100%;\">";
echo "<tr><td style=\"width:25%;text-align:right;padding:10px 0px 10px 0px\"><span class=\"text14b\">".pcrtlang("To").":</span></td><td style=\"border-bottom:#000000 2px solid;\"></td></tr>";
echo "<tr><td style=\"width:25%;text-align:right;padding:10px 0px 10px 0px\"><span class=\"text14b\">".pcrtlang("From").":</span></td><td style=\"border-bottom:#000000 2px solid;\"></td></tr>";
echo "</table><br>";

echo "<table style=\"width:100%;\">";
echo "<tr><td style=\"width:40%;text-align:right;\" rowspan=3><img src=$printablelogo style=\"width:200px;\">";

echo "<br>$servicebyline";

echo "</td>";

echo "<td style=\"width:20%;text-align:right;padding:5px 0px 5px 0px\"><span class=\"text12b\">".pcrtlang("Amount").":</span></td>
<td style=\"border-bottom:#000000 2px solid;\">$money$paymentamount</td></tr>";

echo "<td style=\"width:20%;text-align:right;padding:5px 0px 5px 0px\"><span class=\"text12b\">".pcrtlang("Approved By").":</span></td>
<td style=\"border-bottom:#000000 2px solid;\"></td></tr>";

echo "<tr><td style=\"width:20%;text-align:right;padding:5px 0px 5px 0px\"><span class=\"text12b\">".pcrtlang("Date").":</span></td>
<td style=\"border-bottom:#000000 2px solid;\"></td></tr>";


echo "</table><br>";

echo "<div style=\"text-align:center;\">";
echo " <i class=\"fa fa-building fa-lg\"></i>$storeinfoarray[storename]&nbsp;&nbsp;&nbsp;";
echo "<i class=\"fa fa-map-marker fa-lg\"></i>$storeinfoarray[storeaddy1],";
if ("$storeinfoarray[storeaddy2]" != "") {
echo "$storeinfoarray[storeaddy2], ";
}
echo "$storeinfoarray[storecity], $storeinfoarray[storestate] $storeinfoarray[storezip]&nbsp;&nbsp;&nbsp;";
echo "<i class=\"fa fa-phone fa-lg\"></i>$storeinfoarray[storephone]";


echo "<br><br><img src=\"barcode.php?barcode=$depositid&width=220&height=20&text=0\"><br>$depositid";


echo "</div>";
echo "<br>";
echo "</div>";



echo "</div>";
echo "</body></html>";

}



function removefrominvoice() {

require("deps.php");
require("common.php");

$depositid = pv($_REQUEST['depositid']);

require_once("validate.php");

$switchdep = "UPDATE deposits SET invoiceid = '0' WHERE depositid = '$depositid'";
@mysqli_query($rs_connect, $switchdep);

header("Location: deposits.php");
}



function adddeptoinv() {

require("deps.php");
require("common.php");

$depositid = pv($_REQUEST['depositid']);
$invoiceid = pv($_REQUEST['invoiceid']);

require_once("validate.php");

$switchdep = "UPDATE deposits SET invoiceid = '$invoiceid' WHERE depositid = '$depositid'";
@mysqli_query($rs_connect, $switchdep);

header("Location: invoice.php?func=printinv&invoice_id=$invoiceid");
}


switch($func) {
                                                                                                    
    default:
    deposits();
    break;
                                
    case "adddep":
    adddep();
    break;

    case "alldeposits":
    alldeposits();
    break;

    case "alldepositsajax":
    alldepositsajax();
    break;

case "editdeposit":
    editdeposit();
    break;

case "editdeposit2":
    editdeposit2();
    break;

case "deposit_receipt":
    deposit_receipt();
    break;

case "email_deposit_receipt":
    email_deposit_receipt();
    break;

case "email_deposit_receipt2":
    email_deposit_receipt2();
    break;

case "savesig":
    savesig();
    break;

case "clearsig":
    clearsig();
    break;

case "hidesigdep":
    hidesigdep();
    break;

case "savesigtopaz":
    savesigtopaz();
    break;

case "clearsigtopaz":
    clearsigtopaz();
    break;

case "hidesigdeptopaz":
    hidesigdeptopaz();
    break;


case "searchdeposits":
    searchdeposits();
    break;

case "deposit_gift":
    deposit_gift();
    break;

case "removefrominvoice":
   removefrominvoice();
    break;

case "adddeptoinv":
   adddeptoinv();
    break;


}
