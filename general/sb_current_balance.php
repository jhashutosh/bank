<?
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
/*$current_date=$_REQUEST["current_date"];
if(empty($current_date) ) { $current_date=date("d/m/Y"); }
echo "<html>";
echo "<head>";*/
echo "</head>";
echo "<body bgcolor=\"silver\">";
//$sql_statement="SELECT current_balance('$current_date') as balance";
//echo $sql_statement;
/*echo "<h4><center><font color=blue>Current Balance :</font><font Color=RED><b>Rs. $balance</b></font></center></h4>";
echo "<hr>";
echo "<table align=CENTER width=100%>";
echo "<tr bgcolor=red><th colspan=>Current Balance as on $current_date";
echo "<tr bgcolor=GREEN><th>Particulars<th>Balance(Rs)";*/
/*echo "<tr bgcolor=$TBGCOLOR><td><a href=\"sb_current_balance_tabular.php?current_date=$current_date&code=14101&balance=$member_balance\">Member[14101]</a><td align=right><b>".global_sb_current_balance('14101');
echo "<tr bgcolor=$TCOLOR><td><a href=\"sb_current_balance_tabular.php?current_date=$current_date&code=14301&balance=$non_balance\">Non-Member[14301]</a><td align=right><b>".global_sb_current_balance('14301');
echo "<tr bgcolor=$TBGCOLOR><td><a href=\"sb_current_balance_tabular.php?current_date=$current_date&code=14201&balance=$shg_balance\">SHG[14201]<td align=right><b>" .global_sb_current_balance('14201');
echo "<tr bgcolor=$TBGCOLOR><td><a href=\"sb_current_balance_tabular.php?current_date=$current_date&code=14401&balance=$nrgs_balance\">NRGS[14401]<td align=right><b>".global_sb_current_balance('14401');*/
/*echo "<tr bgcolor=cyan><td align=CENTER><a href=\"sb_current_balance_tabular.php?current_date=$current_date&status=all&balance=$balance\">Total:<td align=RIGHT><b>$balance";*/
echo "</table>";
echo "</body>";
echo "</html>";

?>
