<?php
include "../config/config.php";

$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$operator_code=$staff_id;
$starting_date=$_REQUEST["starting_date"];
$ending_date=$_REQUEST["ending_date"];
if( empty($starting_date) ) { $starting_date=date("d/m/Y",time()-604800); }
if( empty($ending_date) ) { $ending_date=date("d/m/Y"); }
echo "<html>";
echo "<head>";
echo "<title>$PROJECT_TITLE</title>";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "<script language=\"JAVASCRIPT\">";
echo "function closeme() { close(); }";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"cd.focus();\">";
echo "<font size=+2>$SYSTEM_TITLE</font><br>";
echo "<hr>";
echo "<form method=\"POST\" action=\"fd_premature_list.php?menu=$menu\" method=\"POST\" name=f1>";
echo "<table align=center bgcolor=\"#90EE90\"><tr><td  align=\"\"><b>Between Date:<input type=\"TEXT\" name=\"starting_date\" size=\"9\" value=\"$starting_date\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.starting_date,'dd/mm/yyyy','Choose Date')\" >";
echo " And <input type=\"TEXT\" name=\"ending_date\" size=\"9\" value=\"$ending_date\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.ending_date,'dd/mm/yyyy','Choose Date')\">";
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "</table>";
echo "</form>";
$sql_statement="SELECT * FROM customer_fd WHERE withdrawal_type='Premature' and action_date BETWEEN '$starting_date' AND '$ending_date'";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)==0) {
echo "<h4>Not found!!!</h4>";
} else {
echo "<table width=\"100%\" align=center>";

echo "<tr><td bgcolor=\"green\" colspan=\"11\" align=\"center\"><font color=\"white\">Fixed Deposit Pre-Mature Account List Date in Between $starting_date and $ending_date</font>";


$color=$TCOLOR;
echo "<tr bgcolor=\"pink\">";
echo "<th>Account No.</th>";
echo "<th>Certificate No.</th>";
echo "<th  colspan=\"1\">Name</th>";
echo "<th colspan=\"1\">Address</th>";
echo "<th  colspan=\"1\">Opening Date</th>";
echo "<th  colspan=\"1\">Principal</th>";
echo "<th  colspan=\"1\">Period</th>";
echo "<th  colspan=\"1\">Interest Rate</th>";
echo "<th  colspan=\"1\">Withdrawal Date</th>";
echo "<th  colspan=\"1\">Withdrawal Type</th>";
echo "<th  colspan=\"1\">Withdrawal Amount</th>";

for($j=0; $j<pg_NumRows($result); $j++) 
{
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	echo "<tr>";
	echo "<td align=right bgcolor=$color><a href=\"account_sb_detail.php?account_no=".$row['account_no']."\" target=\"_blank\">".$row['account_no']."</a></td>";
	echo "<td align=right bgcolor=$color>".$row['certificate_no']."</td>";
	echo "<td align=right bgcolor=$color>".ucwords($row['name1'])."</td>";
	echo "<td align=right bgcolor=$color>".$row['address']."</td>";
	echo "<td align=right bgcolor=$color>".ucwords($row['opening_date'])."</td>";
	echo "<td align=right bgcolor=$color>".$row['principal']."</td>";
	echo "<td align=right bgcolor=$color>".$row['period']."</td>";
	echo "<td align=right bgcolor=$color>".ucwords($row['interest_rate'])."</td>";
	echo "<td align=right bgcolor=$color>".$row['withdrawal_date']."</td>";
	echo "<td align=right bgcolor=$color>".ucwords($row['withdrawal_type'])."</td>";
	echo "<td align=right bgcolor=$color>".$row['withdrawal_amount']."</td>";
}
echo "<tr bgcolor=cyan>";
echo "<td colspan=\"11\"><center>Total : <b>$j</b> Records Found!!!!!!!!!!!!!</center></td>";
echo "</table>";
}

echo "<br>";

echo "</body>";
echo "</html>";
?>
