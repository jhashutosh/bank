<?php
include "../config/config.php";
$staff_id=verifyAutho();
$account_no=$_REQUEST["account_no"];
$certificate_no=$_REQUEST["certificate_no"];
$date_with_effect=$_REQUEST["date_with_effect"];
$scheme=$_REQUEST["scheme"];
$holder_sb_account_no=$_REQUEST["holder_sb_account_no"];
$period=$_REQUEST["period"];
$amount_deposit=$_REQUEST["amount_deposit"];
$remarks=$_REQUEST["remarks"];
$menu=$_REQUEST['menu'];
//$opening_date=date('d.m.y'); // after running
$opening_date=$date_with_effect; //for date entry purpose
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
echo "<form method=\"POST\" action=\"mis_ledger_eadd.php?menu=$menu\">";
echo "<table bgcolor=Orange align=center width=90%>";
echo "<tr><th colspan=\"4\" bgcolor=GREEN>Varify Entry Form of New ".strtoupper($menu)."</th></tr>";
echo "<tr><td align=\"left\">Account no:<td><input type=\"TEXT\" name=\"account_no\" size=\"10\" value=\"$account_no\" $HIGHLIGHT><br>";
echo "<td align=\"left\">Opening Date:<td><input type=\"TEXT\" name=\"date_with_effect\" size=\"12\" value=\"$date_with_effect\" readonly $HIGHLIGHT><br>";
echo "<tr><td align=\"left\">Scheme:<td><input type=\"TEXT\" name=\"scheme\" size=\"25\" value=\"$scheme\" readonly $HIGHLIGHT>";
$scheme=getIndex($scheme_array,$scheme);
compute_deposit($scheme,$amount_deposit,$period,$rate_of_interest,$total_interest,$maturity_amount,$opening_date,$menu);
$monthly_interest=sprintf("%-12.0f",($total_interest/(12*$period)));
echo "<td align=\"left\">Monthly Interest:<td><input type=\"TEXT\" name=\"total_interest\" size=\"10\" value=\"".$monthly_interest."\" readonly $HIGHLIGHT>";
echo "<tr><td align=\"left\">Amount Deposit:<td><input type=\"TEXT\" name=\"amount_deposit\" size=\"15\" value=\"$amount_deposit\" $HIGHLIGHT><br>";
echo "<td align=\"left\">Period:<td> <input type=\"TEXT\" name=\"period\" size=\"5\" value=\"$period\" readonly $HIGHLIGHT>&nbsp;Years";

//echo $maturity_amount;
echo "<tr><td align=\"left\">Rate of interest:<td><input type=\"TEXT\" name=\"rate_of_interest\" size=\"5\" value=\"$rate_of_interest\" $HIGHLIGHT readonly><a href=\"../main/dev_page.html\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes,top=100,left=150, width=1000,height=300'); return false;\">View Rate</a>";
echo "<td align=\"left\">Interest Amount:<td><input type=\"TEXT\" name=\"interest\" size=\"15\" value=\"".($monthly_interest*$period*12)."\" $HIGHLIGHT readonly><br>";
echo "<tr><td align=\"left\">Maturity amount:<td><input type=\"TEXT\" name=\"maturity_amount\" size=\"15\" value=\"$amount_deposit\" $HIGHLIGHT readonly><br>";
$maturity_date=maturity_date($opening_date,$period,'y');
echo "<td align=\"left\">Maturity date:<td><input type=\"TEXT\" name=\"maturity_date\" size=\"12\" value=\"$maturity_date\" readonly $HIGHLIGHT><br>";
if ($_REQUEST['r1']=='y'){
echo "<tr><td align=\"left\">Holder sb account no:<td><input type=\"TEXT\" name=\"holder_sb_account_no\" size=\"25\" value=\"$holder_sb_account_no\" readonly $HIGHLIGHT><br>";
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
