<?php
include "../config/config.php";
$HIGHLIGHT1="onFocus=\"this.style.backgroundColor='#E9F2FA';this.style.color:#E9F2FA \"  onBlur=\"this.style.backgroundColor='#E9F2FA'\"style=\"font-size:10pt;BACKGROUND-COLOR:#E9F2FA; BORDER-BOTTOM: #111111 1px solid; BORDER-top: #E9F2FA 0px solid; BORDER-left: #E9F2FA 0px solid; BORDER-right: #E9F2FA 0px solid; BORDER-COLLAPSE: collapse;\"";
$staff_id=verifyAutho();
$account_no=$_SESSION["current_account_no"];
$menu=$_REQUEST['menu'];
$new_certificate_no="RI/".date("d",time()).date("m",time()).date("y",time())."/";
//isPermissible($menu);
echo "<html>";
echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
?>
<STYLE>
select
{
background-color:#E9F2FA;
border:none;
outline:none;
color:#5F7AC1;

}
select:focus{
outline:solid 1px #E9F2FA;
border:solid 1px #E9F2FA;
}
input{
color:#5F7AC1;
}
</STYLE>
<?php
echo "</head>";
echo "<body bgcolor=\"silver\">";
$id=getCustomerId($account_no,$menu);
$flag=getGeneralInfo_Customer($id);
if($flag==1){
echo "<hr>";
echo "<form method=\"POST\" action=\"mis_ledger_evf.php?menu=$menu\">";
echo "<table bgcolor=#E9F2FA align=center width=90% border=1>";
echo "<tr style=height:25px><td colspan=\"4\" bgcolor=#5F7AC1 align=center><font size=+1 color='white'>Entry Form of New ".strtoupper($menu)."</td></tr>";
echo "<tr><td align=\"left\">Your Account no is:<td><input type=\"TEXT\" name=\"account_no\" size=\"10\" value=\"$account_no\" readonly $HIGHLIGHT1><br>";
echo "<td align=\"left\">Opening Date:<td><input type=\"TEXT\" name=\"date_with_effect\" size=\"12\" value=\"".date("d.m.Y")."\" $HIGHLIGHT1>";
echo "<tr><td align=\"left\">Scheme:<td>";
makeSelect($scheme_array,"scheme","Normal Deposit");
echo "<tr><td align=\"left\">Amount deposit:<td><input type=\"TEXT\" name=\"amount_deposit\" size=\"15\" value=\"\" $HIGHLIGHT1>";
echo "<td align=\"left\">Period:<td><input type=\"TEXT\" name=\"period\" size=\"5\" value=\"\" $HIGHLIGHT1>&nbsp;Years";
echo "<tr><td align=\"left\">After maturity Transfer to SB a/c.<td><input type=\"RADIO\" name=\"r1\" value=\"y\">Yes <input type=\"RADIO\" name=\"r1\" value=\"n\" checked>No";
echo "<td align=\"left\">SB A/C No.:<td><input type=\"TEXT\" name=\"holder_sb_account_no\" size=\"25\" value=\"\" $HIGHLIGHT1  disabled>";
echo "<tr><td><td><td><td align=\"right\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Process\">";
echo "</table>";
echo "</form>";

}
echo "</body>";
echo "</html>";

?>
