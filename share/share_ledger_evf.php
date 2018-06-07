<?php
include "../config/config.php";
$staff_id=verifyAutho();
$account_no=$_REQUEST["membership_no"];
$menu=$_REQUEST['menu'];
$account_no=$_SESSION["current_account_no"];
$action_date=$_REQUEST['action_date'];
$unit=$_REQUEST['unit'];
$val_per_share=$_REQUEST['val_per_share'];
$remarks=$_REQUEST['remarks'];
share_current_balance($account_no,$no,$val);
if($_REQUEST['issue']==1){$tbgcolor="#B0E0E6";$name="Issuing Share";}
if($_REQUEST['buyback']==1){$tbgcolor="#DDA0DD"; $name="Buybacking Share";}
echo "<html>";
echo "<head>";
echo "<title>Statement";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
$id=getCustomerIdFromMember($account_no);
$flag=getGeneralInfo_Customer($id);
if($flag==1){
echo "<hr>";
// Customization required for WHERE CLAUSE
echo "<form method=\"POST\" name=\"form1\" action=\"share_ledger_eadd.php?menu=$menu\">";
echo "<table bgcolor=$tbgcolor width=90% align=center>";
echo "<tr><th colspan=4 bgcolor=Yellow>Entry Form of $name<font size=+1>[$account_no]</font> Current balance:Value of Share:Rs. <font size=+2>$val/=</font> And No.of share:<font size=+2>$no</th></tr>";
echo "<tr><td align=\"left\">Membership no:<td><input type=\"TEXT\" name=\"membership_no\" size=\"20\" value=\"$account_no\" readonly $HIGHLIGHT>";
echo "<td align=\"left\">Action date:<td><input type=\"TEXT\" name=\"action_date\" size=\"15\" value=\"$action_date\" $HIGHLIGHT>";
if($_REQUEST['issue']==1){
	echo "<tr><td align=\"left\">Issuing Unit:<td><input type=\"TEXT\" name=\"unit\" size=\"20\" id=\"unit\" value=\"$unit\" $HIGHLIGHT readonly><br>";
	echo "<input type=\"hidden\" name=\"issue\" value=\"1\" >";
}
if($_REQUEST['buyback']==1){
	echo "<tr><td align=\"left\">Buybacking Unit:<td><input type=\"TEXT\" name=\"unit\" size=\"20\" id=\"unit\" value=\"$unit\" $HIGHLIGHT readonly ><br>";
	echo "<input type=\"hidden\" name=\"buyback\" value=\"1\" >";
}
echo "<td align=\"left\">Total Value of Share:<td>Rs.&nbsp;<input type=\"TEXT\" name=\"total_val_share\" size=\"12\" value=\"".($unit*$val_per_share)."\" $HIGHLIGHT readonly><br>";
echo "<tr><td valign=\"top\" align=\"left\">Remarks:<td colspan=2><textarea name=\"remarks\" rows=\"3\" cols=\"49\" $HIGHLIGHT>$remarks</textarea><br>";
echo "<td align=\"right\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Submit\">";
echo "</table>";
echo "</form>";
}
echo "</body>";
echo "</html>";




?>
