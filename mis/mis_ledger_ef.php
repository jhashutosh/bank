<?php
include "../config/config.php";
$staff_id=verifyAutho();
$account_no=$_SESSION["current_account_no"];
$menu=$_REQUEST['menu'];
$new_certificate_no="RI/".date("d",time()).date("m",time()).date("y",time())."/";
//isPermissible($menu);
echo "<html>";
echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
$id=getCustomerId($account_no,$menu);
$flag=getGeneralInfo_Customer($id);
if($flag==1){
echo "<hr>";
echo "<form method=\"POST\" action=\"mis_ledger_evf.php?menu=$menu\">";
echo "<table bgcolor=#D87093 align=center width=90%>";
echo "<tr><th colspan=\"4\" bgcolor=YELLOW>Entry Form of New ".strtoupper($menu)."</th></tr>";
echo "<tr><td align=\"left\">Account no:<td><input type=\"TEXT\" name=\"account_no\" size=\"10\" value=\"$account_no\" readonly $HIGHLIGHT><br>";
echo "<td align=\"left\">Opening Date:<td><input type=\"TEXT\" name=\"date_with_effect\" size=\"12\" value=\"".date("d.m.Y")."\" $HIGHLIGHT>";
//echo "<tr><td align=\"left\">Certificate no:<td><input type=\"TEXT\" name=\"certificate_no\" size=\"25\" value=\"$new_certificate_no\" $HIGHLIGHT><br>";
echo "<tr><td align=\"left\">Scheme:<td>";
makeSelect($scheme_array,"scheme","Normal Deposit");
echo "<tr><td align=\"left\">Amount deposit:<td><input type=\"TEXT\" name=\"amount_deposit\" size=\"15\" value=\"\" $HIGHLIGHT>";
echo "<td align=\"left\">Period:<td><input type=\"TEXT\" name=\"period\" size=\"5\" value=\"\" $HIGHLIGHT>&nbsp;Years";
echo "<tr><td align=\"left\">After maturity Transfer to SB a/c.<td><input type=\"RADIO\" name=\"r1\" value=\"y\">Yes <input type=\"RADIO\" name=\"r1\" value=\"n\" checked>No";
echo "<td align=\"left\">SB A/C No.:<td><input type=\"TEXT\" name=\"holder_sb_account_no\" size=\"25\" value=\"\" $HIGHLIGHT  disabled>";
echo "<tr><td><td><td><td align=\"right\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"<<<Process>>>\">";
echo "</table>";
echo "</form>";

}
echo "</body>";
echo "</html>";

?>
