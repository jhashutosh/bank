<?
include "../config/config.php";
$staff_id=verifyAutho();
$account_no=$_SESSION["current_account_no"];
$menu=$_REQUEST['menu'];

echo "<html>";
echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"amount.focus();\">";
$id=getCustomerId($account_no,$menu);
$flag=getGeneralInfo_Customer($id);
if($flag==1){
echo "<hr>";
if(accountVarification($account_no)){
$monthly=(float)checkRD($account_no);
if(empty($monthly)){
echo "<form  method=\"POST\" name=\"f1\" action=\"rd_opening_evf.php?menu=$menu\" >";
echo "<table bgcolor=PINK align=center width=90%>";
echo "<tr><th colspan=\"4\" bgcolor=YELLOW>Entry Form of Opening ".strtoupper($menu)."</th></tr>";
echo "<tr><td align=\"left\">Account no:<td><input type=\"TEXT\" name=\"account_no\" size=\"10\" value=\"$account_no\" readonly $HIGHLIGHT><br>";
echo "<td align=\"left\">Date With Effect:<td><input type=\"TEXT\" name=\"date_with_effect\" size=\"12\" value=\"".date("d.m.Y")."\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.date_with_effect,'dd/mm/yyyy','Choose Date')\">";
echo "<tr><td align=\"\" colspan=1>Scheme:<td>";
makeSelect($scheme_array,"scheme","Normal Deposit");
echo "<tr><td align=\"left\">Amount deposit:<td><input type=\"TEXT\" name=\"amount_deposit\" size=\"15\" value=\"\" $HIGHLIGHT>";
echo "<td align=\"left\">Period:<td><input type=\"TEXT\" name=\"period\" size=\"5\" value=\"\" $HIGHLIGHT>&nbsp;Months";
echo "<tr><td align=\"left\">After maturity Transfer to SB a/c.<td><input type=\"RADIO\" name=\"r1\" value=\"y\">Yes <input type=\"RADIO\" name=\"r1\" value=\"n\" checked>No";
echo "<td align=\"left\">SB A/C No.:<td><input type=\"TEXT\" name=\"holder_sb_account_no\" size=\"25\" value=\"\" $HIGHLIGHT  disabled>";
	}
 else{
echo "<form method=\"POST\" name=\"f1\" action=\"rd_ledger_evf.php?menu=$menu&op=m\" onsubmit=\"checkAmount(this.form);\">";
echo "<table bgcolor=PINK align=center width=90%>";
echo "<tr><th colspan=\"4\" bgcolor=YELLOW>Monthly ".strtoupper($menu)." Deposits[$account_no]</th></tr>";
echo "<tr><td align=\"left\">Account no:<td><input type=\"TEXT\" name=\"account_no\" size=\"10\" value=\"$account_no\" readonly $HIGHLIGHT><br>";
echo "<td align=\"left\">Date :<td><input type=\"TEXT\" name=\"date_with_effect\" size=\"12\" value=\"".date("d.m.Y")."\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.date_with_effect,'dd/mm/yyyy','Choose Date')\">";
echo "<tr><td align=\"left\">Monthly Amount:<td><input type=\"TEXT\" name=\"mamount\" size=\"15\" value=\"$monthly\" id=\"mamount\" readonly $HIGHLIGHT>";
$sql_statement="SELECT rd_penalty('$account_no',current_date,$PENALTY_PERCENTAGE,$monthly) as penalty";
$result=dBConnect($sql_statement);
if(pg_numRows($result)>0){
$penalty=pg_result($result,'penalty');
	}
echo "<td align=\"left\">Penalty Amount:<td><input type=\"TEXT\" name=\"p\" size=\"15\" value=\"$penalty\" $HIGHLIGHT>";
$due=$penalty>0?((100*$penalty)/($monthly*$PENALTY_PERCENTAGE)):0;
$due=($due+1)*$monthly;
echo "<tr><td align=\"left\">Due Amount:<td><input type=\"TEXT\" name=\"due\" size=\"15\" value=\"$due\"  readonly $HIGHLIGHT>";

echo "<td align=\"left\">Amount Deposit:<td><input type=\"TEXT\" name=\"amount_deposit\" size=\"15\" value=\"$amount_deposit\" id=\"amount\" $HIGHLIGHT>";
 }
echo "<tr><td><td><td align=\"right\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"<<<Process>>>\">";
echo "</table>";
echo "</form>";
}
else{
echo "<form  method=\"POST\" name=\"f1\">";
echo "<h4><FONT color=RED>Account Already Closed !!!!!!!!!!!!!</font></h5>";
}


}

?>
<script language="JavaScript" type="text/javascript">
var frmvalidator  = new Validator("f1");
frmvalidator.addValidation("date_with_effect","req","Please enter Date");
frmvalidator.addValidation("amount_deposit","req","Please Enter the Amount");
frmvalidator.addValidation("amount_deposit","decimal","Amount Should be Positive value");
frmvalidator.addValidation("period","numeric","Period Should be numeric value");
frmvalidator.addValidation("period","req","Please Enter the period");
</script>
<?
echo "</body>";
echo "</html>";

?>
