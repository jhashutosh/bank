<?php
include "../config/config.php";
$staff_id=verifyAutho();
$account_no=$_SESSION["current_account_no"];
$renew_certificate=$_REQUEST["certificate_no_new"];
$date_with_effect=$_REQUEST["date_with_effect"];
$scheme=$_REQUEST["scheme"];
$holder_sb_account_no=$_REQUEST["sb_account_no"];
$period=$_REQUEST["period"];
$amount_deposit=$_REQUEST["renew_amt"];
$remarks=$_REQUEST["remarks"];
$menu=$_REQUEST['menu'];
$op_date=$_REQUEST['withdrawal_date'];
$prin=$_REQUEST['prin'];


$ren_type=$_REQUEST['ren_type'];
$ren_certificate_no=$_REQUEST["certificate_no"];
$ren_int=$_REQUEST['int_with_amt'];

echo "<html>";
echo "<head>";
echo "<title>Entry Form - Fix Deposit";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
$id=getCustomerId($account_no,$menu);
$flag=getGeneralInfo_Customer($id);
if($flag==1){
echo "<hr>";
echo "<form method=\"POST\" action=\"renew_eadd.php?menu=$menu&ren_type=$ren_type&ren_certificate_no=$ren_certificate_no&ren_int=$ren_int&prin=$prin\">";
echo "<table bgcolor=Orange align=center width=90%>";
echo "<tr><th colspan=\"4\" bgcolor=GREEN>Varification of Renewal for $account_no </th></tr>";
echo "<td align=\"left\">Opening Date:<td><input type=\"TEXT\" name=\"op_date\" size=\"10\" value=\"$op_date\" readonly $HIGHLIGHT>";
echo "<td align=\"left\">Date With Effect:<td><input type=\"TEXT\" name=\"date_with_effect\" size=\"7\" value=\"$date_with_effect\" readonly $HIGHLIGHT><br>";
echo "<tr><td align=\"left\">Certificate no:<td><input type=\"TEXT\" name=\"certificate_no\" size=\"12\" value=\"$renew_certificate\" readonly $HIGHLIGHT><br>";
echo "<td align=\"left\">Scheme:<td><input type=\"TEXT\" name=\"scheme\" size=\"15\" value=\"$scheme\" readonly $HIGHLIGHT>";
echo "<tr><td align=\"left\">Amount deposit:<td><input type=\"TEXT\" name=\"amount_deposit\" size=\"6\" value=\"$amount_deposit\" readonly $HIGHLIGHT><br>";
echo "<td align=\"left\">Period:<td> <input type=\"TEXT\" name=\"period\" size=\"5\" value=\"$period\" readonly $HIGHLIGHT>&nbsp;Days";
$scheme=getIndex($scheme_array,$scheme);
compute_deposit($scheme,$amount_deposit,$period,$rate_of_interest,$total_interest,$maturity_amount,$op_date,$menu);
echo "<tr><td align=\"left\">Rate of interest:<td><input type=\"TEXT\" name=\"rate_of_interest\" size=\"5\" value=\"$rate_of_interest\" $HIGHLIGHT readonly><a href=\"../main/dev_page.html\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes,top=100,left=150, width=1000,height=300'); return false;\">View Rate</a>";
echo "<td align=\"left\">Interest Amount:<td><input type=\"TEXT\" name=\"total_interest\" size=\"5\" value=\"$total_interest\" readonly $HIGHLIGHT><br>";
echo "<tr><td align=\"left\">Maturity amount:<td><input type=\"TEXT\" name=\"maturity_amount\" size=\"6\" value=\"$maturity_amount\" readonly $HIGHLIGHT><br>";
$maturity_date=maturity_date($date_with_effect,$period,'d');
echo "<td align=\"left\">Maturity date:<td><input type=\"TEXT\" name=\"maturity_date\" size=\"7\" value=\"$maturity_date\"  readonly $HIGHLIGHT><br>";
if ($ren_type=='tr_sb'){
echo "<tr><td align=\"left\">Holder sb account no:<td><input type=\"TEXT\" name=\"holder_sb_account_no\" size=\"5\" value=\"$holder_sb_account_no\" readonly $HIGHLIGHT><br>";
echo "<td><td align=\"right\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"<<<Conform>>>\">";
}
else{
echo "<tr><td><td><td><td align=\"right\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"<<<Conform>>>\">";
}
echo "</table>";
}
echo "</form>";
echo "</body>";
echo "</html>";
?>
