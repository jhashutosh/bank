<?php
include "../config/config.php";
$staff_id=verifyAutho();
$account_no=$_SESSION["current_account_no"];
$certificate_no=$account_no."/".date("dmy");
$menu=$_REQUEST['menu'];
$new_certificate_no="RI/".date("d",time()).date("m",time()).date("y",time())."/";
//isPermissible($menu);
echo "<html>";
echo "<head>";
echo "<script src=\"../JS/validation.js\">";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
?>
<script language="JAVASCRIPT">
function varify_ri(f){
var amount=document.getElementById("amount").value;
var month=document.getElementById("month").value;
if (!IsPNumeric(amount)){
    	alert("Amount Must Be Positive Numeric Value")
	return false;
	}
if (!IsPNumeric(month)){
    	alert("Month Must Be Positive Integer Value")
	return false;
	}
}
</script>
<?php
echo "</head>";
echo "<body bgcolor=\"silver\">";
$id=getCustomerId($account_no,$menu);
$flag=getGeneralInfo_Customer($id);
if($flag==1){
echo "<hr>";
echo "<form method=\"POST\" action=\"ri_ledger_evf.php?menu=$menu\" onSubmit=\"return varify_ri(this.form);\">";
echo "<table bgcolor=#6495ED align=center width=90%>";
echo "<tr><th colspan=\"4\" bgcolor=YELLOW>Entry Form of New ".strtoupper($menu)."[$account_no]</th></tr>";
//echo "<tr><td align=\"left\">Account no:<td><input type=\"TEXT\" name=\"account_no\" size=\"10\" value=\"$account_no\" readonly $HIGHLIGHT><br>";
echo "<tr><td align=\"left\">Opening Date:<td><input type=\"TEXT\" name=\"op_date\" size=\"12\" value=\"".date("d.m.Y")."\" $HIGHLIGHT>";
echo "<td align=\"left\">Date With Effect:<td><input type=\"TEXT\" name=\"date_with_effect\" size=\"12\" value=\"".date("d.m.Y")."\" $HIGHLIGHT>";
echo "<tr><td align=\"left\">Certificate no:<td><input type=\"TEXT\" name=\"certificate_no\" size=\"25\" value=\"$certificate_no\" $HIGHLIGHT><br>";
echo "<td align=\"left\">Scheme:<td>";
makeSelect($scheme_array,"scheme","Normal Deposit");
echo "<tr><td align=\"left\">Amount deposit:<td><input type=\"TEXT\" name=\"amount_deposit\" size=\"15\" id=\"amount\" value=\"\" $HIGHLIGHT>";
echo "<td align=\"left\">Period:<td><input type=\"TEXT\" name=\"period\" size=\"5\" id=\"month\" value=\"\" $HIGHLIGHT>&nbsp;Months";
//echo "<tr><td align=\"left\">After maturity Transfer to SB a/c.<td><input type=\"RADIO\" name=\"r1\" value=\"y\">Yes <input type=\"RADIO\" name=\"r1\" value=\"n\" checked>No";
//echo "<td align=\"left\">SB A/C No.:<td><input type=\"TEXT\" name=\"holder_sb_account_no\" size=\"25\" value=\"\" $HIGHLIGHT  disabled>";
//*******************************************PAYMENT MOOD *************************************************/
echo "<tr><td align=\"left\">Payment Mood : </td>";
echo "<td><SELECT name=\"pmood\"><option value=\"c\">CASH</option><option value=\"q\">CHEQUE</option><option value=\"y\">Trf to SB</option>";
//********************************************************************************************************/

echo "<tr><td><td><td><td align=\"right\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"<<<Process>>>\">";
echo "</table>";
echo "</form>";

}
echo "</body>";
echo "</html>";

?>
