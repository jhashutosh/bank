<?php
include "../config/config.php";
$staff_id=verifyAutho();
if(isset($_REQUEST['menu']))
{
$menu=$_REQUEST['menu'];
}
else
{
	$menu='';
}

if(isset($_REQUEST['current_date']))
{
$current_date=$_REQUEST["current_date"];
}
else
{
$current_date='';
}
if(empty($current_date) ) { $current_date=date("d/m/Y"); }
echo "<html>";
echo "<head>";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"cd.focus();\">";
echo "<hr>";
echo "<form name=\"f1\" action=\"share_current_balance.php?menu=$menu\" method=\"POST\">";
echo "<table align=center bgcolor=\"BLUE\"><tr><td  align=\"center\"><b>Current Balance as on :<td><input type=TEXT size=12 name=current_date id=cd value= $current_date $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.current_date,'dd/mm/yyyy','Choose Date')\">";
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "</table></form>";
echo "<hr><hr>";
$balance=global_sb_current_balance('11100,11200,11300,11900',$current_date);
echo "<center><font color=blue size=+3>Current Balance :</font><font size=+4><b>Rs. ".amount2Rs($balance)."/=</font>(".money_int2string($balance).")</b></center>";
echo "<table align=CENTER width=85%>";
echo "<tr bgcolor=YELLOW><th colspan=2>Current Balance as on $current_date";
echo "<tr bgcolor=SKYBLUE><th>Particulars<th>Balance(Rs)";
$member_balance=global_sb_current_balance('11100',$current_date);
echo "<tr bgcolor=$TBGCOLOR><td><a href=\"../sb/sb_current_balance_tabular.php?menu=sh&current_date=$current_date&code=11100&balance=$member_balance\">Share(State Government) [11100]</a><td align=right><b>".amount2Rs($member_balance);
$shg_balance=global_sb_current_balance('11200',$current_date);
echo "<tr bgcolor=$TCOLOR><td><a href=\"../sb/sb_current_balance_tabular.php?menu=sh&current_date=$current_date&code=11200&balance=$shg_balance\">Share(Individual)[11200]<td align=right><b>".amount2Rs($shg_balance);
$non_balance=global_sb_current_balance('11300',$current_date);
echo "<tr bgcolor=$TBGCOLOR><td><a href=\"../sb/sb_current_balance_tabular.php?menu=sh&current_date=$current_date&code=11300&balance=$non_balance\">Share(SHG)[11300]</a><td align=right><b>".amount2Rs($non_balance);
$nrgs_balance=global_sb_current_balance('11900',$current_date);
echo "<tr bgcolor=$TCOLOR><td><a href=\"../sb/sb_current_balance_tabular.php?menu=sh&current_date=$current_date&code=11900&balance=$nrgs_balance\">NRGS<td align=right><b>".amount2Rs($nrgs_balance);
echo "<tr bgcolor=cyan><td align=CENTER><a href=\"../sb/sb_current_balance_tabular.php?menu=sh&current_date=$current_date&code=all&balance=$balance\">Total:<td align=RIGHT><b>".amount2Rs($balance);
echo "</table>";
echo "</body>";
echo "</html>";

?>
