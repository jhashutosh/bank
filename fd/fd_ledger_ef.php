<?php
include "../config/config.php";
$staff_id=verifyAutho();
$account_no=$_SESSION["current_account_no"];
$certificate_no=$account_no."/".date("dmy");
$menu=$_REQUEST['menu'];
$new_certificate_no="FD/";
isPermissible($menu);
echo "<html>";
echo "<head>";
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";
echo "<title>Entry Form - Fix Deposit";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"c.focus();\">";
$id=getCustomerId($account_no,$menu);
$flag=getGeneralInfo_Customer($id);
if($flag==1){
echo "<hr>";
echo "<form method=\"POST\" name=\"f1\" action=\"fd_ledger_evf.php?menu=fd\">";
echo "<table bgcolor=skyblue align=center width=90% border=\"1\">";
echo "<tr><th colspan=\"4\" bgcolor=Yellow>Entry Form of New ".strtoupper($menu)."[$account_no]</th></tr>";
//echo "<tr><td align=\"left\">Account no:<td><input type=\"TEXT\" name=\"account_no\" size=\"10\" value=\"$account_no\" readonly $HIGHLIGHT><br>";
echo "<td align=\"left\">Opening Date:<td><input type=\"TEXT\" name=\"op_date\" size=\"12\" value=\"".date("d/m/Y")."\" $HIGHLIGHT>";
echo "<td align=\"left\">Date With Effect:<td><input type=\"TEXT\" name=\"date_with_effect\" size=\"12\" value=\"".date("d/m/Y")."\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.date_with_effect,'dd/mm/yyyy','Choose Date')\">";
echo "<tr><td align=\"left\">Certificate no:<td><input type=\"TEXT\" name=\"certificate_no\" size=\"25\" value=\"$certificate_no\" id=\"c\" $HIGHLIGHT><br>";
echo "<td align=\"left\">Scheme:<td>";
makeSelect($scheme_array,"scheme","Normal Deposit");
echo "<tr><td align=\"left\">Amount deposit:<td><input type=\"TEXT\" name=\"amount_deposit\" size=\"15\" value=\"\" id=\"amount\" $HIGHLIGHT>";
echo "<td align=\"left\">Period:<td><input type=\"TEXT\" name=\"period\" size=\"5\" id=\"days\" value=\"\" $HIGHLIGHT >&nbsp;Days";
//echo "<tr><td align=\"left\">After maturity Transfer to SB a/c.<td><input type=\"RADIO\" name=\"r1\" value=\"y\">Yes <input type=\"RADIO\" name=\"r1\" value=\"n\" checked>No";
//echo "<td align=\"left\">SB A/C No.:<td><input type=\"TEXT\" name=\"holder_sb_account_no\" size=\"25\" value=\"\" $HIGHLIGHT  disabled>";
//*******************************************PAYMENT MOOD *************************************************/
echo "<tr><td align=\"left\">Payment Mood : </td>";
echo "<td><SELECT name=\"pmood\"><option value=\"c\">CASH</option><option value=\"q\">CHEQUE</option><option value=\"y\">Trf to SB</option>";
//********************************************************************************************************/

echo "<td><td align=\"right\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"<<<Process>>>\">";
echo "</table>";
echo "</form>";
	
}
?>
<script type="text/javascript">
	var frmvalidator  = new Validator("f1");
 	frmvalidator.addValidation("amount_deposit","req","Please enter the Amount");
	frmvalidator.addValidation("amount_deposit","decimal","Amount Should Be Positive Value");
	frmvalidator.addValidation("date_with_effect","req","Please enter the Date of FD");
 	frmvalidator.addValidation("period","req","Please enter the Period");
	frmvalidator.addValidation("period","numeric","Period Should be numeric Value");

</script>
<?php
echo "</body>";
echo "</html>";

?>
