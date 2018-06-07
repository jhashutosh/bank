<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$op=$_REQUEST['op'];
$starting_date=$_REQUEST["starting_date"];
$ending_date=$_REQUEST["ending_date"];
if( empty($starting_date) ) { $starting_date=date("d/m/Y",time()-604800); }
if( empty($ending_date) ) { $ending_date=date("d/m/Y"); }
if ($menu=='fd'){$table='customer_fd';$name='Fixed Deposit';}
if ($menu=='rd'){$table='customer_rd';$name='Recurring Deposit';}
if ($menu=='hsb'){$table='customer_hsb';$name='HSB Deposit';}
if ($menu=='ri'){$table='customer_ri';$name='Re-Investment Deposit';}
if ($menu=='mis'){$table='customer_mis';$name='MIS Deposit';}
if ($menu=='hsb'){$table='customer_hsb';$name='HSB Deposit';}
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
if($op=='m'||$op=='p'||$op=='mbt'){
echo "<form method=\"POST\" action=\"all_deposit.php?menu=$menu&op=$op\" method=\"POST\" name=f1>";
echo "<table align=center bgcolor=\"#90EE90\"><tr><td  align=\"\"><b>Between Date:<input type=\"TEXT\" name=\"starting_date\" size=\"9\" value=\"$starting_date\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.starting_date,'dd/mm/yyyy','Choose Date')\" >";
echo " And <input type=\"TEXT\" name=\"ending_date\" size=\"9\" value=\"$ending_date\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.ending_date,'dd/mm/yyyy','Choose Date')\">";
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "</table>";
echo "</form>";
}
$sql_statement="SELECT * FROM $table";
if($op=='m'){$sql_statement=$sql_statement." WHERE withdrawal_type='Mature' AND action_date BETWEEN '$starting_date' AND '$ending_date'";
$sub="Maturity List";}
if($op=='p'){$sql_statement=$sql_statement." WHERE withdrawal_type='Premature' AND withdrawal_date BETWEEN '$starting_date' AND '$ending_date'";
$sub="Prematurity List";}
if($op=='2t'){$sql_statement=$sql_statement." WHERE maturity_date=current_date";
$sub="Today Maturity List ";}
if($op=='2m'){$sql_statement=$sql_statement." WHERE maturity_date=current_date+1";
$sub="Tomorrow Maturity List ";}
if($op=='d2m'){$sql_statement=$sql_statement." WHERE maturity_date=current_date+2";
$sub="Day after Tomorrow Maturity List ";}
if($op=='mbt'){$sql_statement=$sql_statement." WHERE withdrawal_type IS NULL AND maturity_date< current_date AND action_date BETWEEN '$starting_date' AND '$ending_date'";
$sub="Mature but not Withdrawal List ";}



//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4>Not found!!!</h4>";
} else {
echo "<table width=\"100%\" align=center>";

echo "<tr><td bgcolor=\"green\" colspan=\"12\" align=\"center\"><font color=\"white\">$name $sub Date in Between $starting_date and $ending_date</font>";
$color=$TCOLOR;
echo "<tr bgcolor=\"pink\">";
echo "<th>Account No.</th>";
if($menu=='fd'||$menu=='ri'){
echo "<th>Certificate No.</th>";}
echo "<th  colspan=\"1\">Name</th>";
echo "<th colspan=\"1\">Address</th>";
echo "<th  colspan=\"1\">Opening Date</th>";
echo "<th  colspan=\"1\">Principal</th>";
echo "<th  colspan=\"1\">Period</th>";
echo "<th  colspan=\"1\">Interest Rate</th>";
echo "<th  colspan=\"1\">Maturity Date</th>";
if($op=='m'||$op=='p'||$op=='mbt'){
echo "<th  colspan=\"1\">Withdrawal Date</th>";
echo "<th  colspan=\"1\">Withdrawal Type</th>";
echo "<th  colspan=\"1\">Withdrawal Amount</th>";}
for($j=0; $j<pg_NumRows($result); $j++) 
{
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	echo "<tr>";
	echo "<td align=right bgcolor=$color><a href=\"account_sb_detail.php?account_no=".$row['account_no']."\" target=\"_blank\">".$row['account_no']."</a></td>";
	if($menu=='fd'||$menu=='ri'){
	echo "<td align=right bgcolor=$color>".$row['certificate_no']."</td>";
	}
	echo "<td align=right bgcolor=$color>".ucwords($row['name1'])."</td>";
	echo "<td align=right bgcolor=$color>".$row['address']."</td>";
	echo "<td align=right bgcolor=$color>".ucwords($row['opening_date'])."</td>";
	echo "<td align=right bgcolor=$color>".$row['principal']."</td>";
	echo "<td align=right bgcolor=$color>".$row['period']."</td>";
	echo "<td align=right bgcolor=$color>".ucwords($row['interest_rate'])."</td>";
	echo "<td align=right bgcolor=$color>".$row['maturity_date']."</td>";

	if($op=='m'||$op=='p'||$op=='mbt'){
	
	echo "<td align=right bgcolor=$color>".$row['withdrawal_date']."</td>";
	echo "<td align=right bgcolor=$color>".ucwords($row['withdrawal_type'])."</td>";
	echo "<td align=right bgcolor=$color>".$row['withdrawal_amount']."</td>";
}
}
echo "<tr bgcolor=cyan>";
echo "<td colspan=\"12\"><center>Total : <b>$j</b> Records Found!!!!!!!!!!!!!</center></td>";
echo "</table>";
}

echo "<br>";

echo "</body>";
echo "</html>";
?>
