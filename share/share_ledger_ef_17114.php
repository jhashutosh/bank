<?php
include "../config/config.php";
$staff_id=verifyAutho();
$account_no=$_SESSION["current_account_no"];
$menu=$_REQUEST['menu'];
isPermissible($menu);
if($_REQUEST['issue']==1){$tbgcolor="#40E0D0";$name="Issuing Share";}
if($_REQUEST['buyback']==1){$tbgcolor="#D8BFD8"; $name="Buybacking Share";}
echo "<html>";
echo "<head>";
echo "<title>SHARE";
echo "</title>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"unit.focus();\">";
$id=getCustomerIdFromMember($account_no);
$flag=getGeneralInfo_Customer($id);
if($flag==1){
echo "<hr>";
share_current_balance($account_no,$no,$val);
echo "<form method=\"POST\" name=\"form1\" action=\"share_ledger_evf.php?menu=$menu\">";
echo "<table bgcolor=$tbgcolor width=90% align=center>";
echo "<tr><th colspan=4 bgcolor=Yellow>Entry Form of $name<font size=+1>[$account_no]</font> Current balance:Value of Share:Rs. <font size=+2>$val/=</font> And No.of share:<font size=+2>$no</th></tr>";
echo "<tr><td align=\"left\">Membership no:<td><input type=\"TEXT\" name=\"membership_no\" size=\"20\" value=\"$account_no\" readonly $HIGHLIGHT>";
echo "<td align=\"left\">Action date:<td><input type=\"TEXT\" name=\"action_date\" size=\"12\" value=\"".date('d.m.Y')."\" $HIGHLIGHT>";
echo "&nbsp;&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(form1.action_date,'dd/mm/yyyy','Choose Date')\">";
if($_REQUEST['issue']==1){
	echo "<tr><td align=\"left\">Issuing Unit:<td><input type=\"TEXT\" name=\"unit\" size=\"20\" id=\"unit\" value=\"\" $HIGHLIGHT><br>";
	echo "<input type=\"hidden\" name=\"issue\" value=\"1\" >";
}
if($_REQUEST['buyback']==1){
	echo "<tr><td align=\"left\">Buybacking Unit:<td><input type=\"TEXT\" name=\"unit\" size=\"20\" id=\"unit\" value=\"\" $HIGHLIGHT><br>";
	echo "<input type=\"hidden\" name=\"buyback\" value=\"1\" >";
}
echo "<td align=\"left\">Value of per Share:<td><input type=\"TEXT\" name=\"val_per_share\" size=\"10\" value=\"10\" $HIGHLIGHT><br>";
echo "<tr><td valign=\"top\" align=\"left\">Remarks:<td colspan=2><textarea name=\"remarks\" rows=\"3\" cols=\"49\" $HIGHLIGHT></textarea><br>";
echo "<td align=\"right\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Process\">";

//echo "  <input type=\"RESET\" name=\"RESET_BUTTON\" value=\"Cancel\"><br>";
echo "</table>";
echo "</form>";
}
echo "</body>";
echo "</html>";
?>
