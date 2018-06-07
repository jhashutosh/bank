<?
include "../config/config.php";
$staff_id=verifyAutho();
//$menu=$_REQUEST['menu'];
$start_date=$_REQUEST["start_date"];
if(empty($start_date) ) { $start_date='01.04.2010'; }
$end_date=$_REQUEST["end_date"];
if(empty($end_date) ) { $end_date='31.03.2011'; }
$vop=0.00;
$vdebit="0";
$vcredit="0";
$cldebit="0";
$clcredit="0";
echo "<html>";
echo "<head>";
echo "<title>  Trial Balance";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";

echo "</head>";
echo "<body bgcolor=\"silver\">";

echo "<form name=\"f1\" action=\"trial_balance_dt.php\" method=\"POST\">";
echo "<table align=center bgcolor=\"#90EE90\"><tr><td  align=\"\"><b>Date Between :<td><input type=TEXT size=12 name=start_date id=cd value=\"$start_date\" $HIGHLIGHT>&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.start_date,'dd/mm/yyyy','Choose Date')\"> AND <input type=TEXT size=12 name=end_date value=\"$end_date\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.end_date,'dd/mm/yyyy','Choose Date')\">";
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> ";
echo "</table></form>";
//$sql_statement="select a.gl_mas_code, b.gl_mas_desc, sum(debit) as debit, sum(credit) as credit, sum(debit-credit) as bal from mas_gl_tran as a , gl_master as b where a.gl_mas_code= b.gl_mas_code group by a.gl_mas_code, b.gl_mas_desc order by a.gl_mas_code ";

$sql_statement="select a.gl_mas_code, b.gl_mas_desc, sum(op_bal) as op_bal, sum(curr_debit) as  curr_debit, sum(curr_credit) as curr_credit, sum(curr_bal) as curr_bal, sum(cl_bal_debit) as cl_bal_debit, sum(cl_bal_credit) as cl_bal_credit from 
(select a.gl_mas_code, 0.00 as op_bal, sum(debit) as curr_debit, sum(credit) as curr_credit, sum(debit-credit) as curr_bal,0.00 as cl_bal_debit, 0.00 as cl_bal_credit from mas_gl_tran as a where action_date between '$start_date' and '$end_date' group by a.gl_mas_code
union all
select a.gl_mas_code, 0.00 as op_bal, 0.00 as curr_debit, 0.00 as curr_credit, 0.00 as curr_bal,sum(debit-credit) as cl_bal_debit, 0.00 as cl_bal_credit from mas_gl_tran as a where action_date <= '$end_date' group by a.gl_mas_code  having sum(debit-credit)>0
union all
select a.gl_mas_code, 0.00 as op_bal, 0.00 as curr_debit, 0.00 as curr_credit, 0.00 as curr_bal, 0.00 as cl_bal_debit, sum(credit-debit) as cl_bal_credit from mas_gl_tran as a where action_date <= '$end_date' group by a.gl_mas_code having sum(debit-credit)<=0 
union all
select a.gl_mas_code, sum(debit-credit) as op_bal, 0.00 as curr_debit, 0.00 as curr_credit, 0.00 as curr_bal, 0.00 as cl_bal_debit, 0.00 as cl_bal_credit from mas_gl_tran as a where action_date < '$start_date' group by a.gl_mas_code 
) as a, gl_master as b
where a.gl_mas_code=b.gl_mas_code group by a.gl_mas_code, b.gl_mas_desc order by a.gl_mas_code
";

//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4> No Transactions entered yet!!!</h4>";
} else {
echo "<table width=\"100%\">";

echo "<tr><td bgcolor=\"green\" colspan=\"7\" align=\"center\"><font color=\"white\"><b>Trial Balance</b></font></td>";

// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";

echo "<th bgcolor=$color colspan=\"1\">Code</th>";
echo "<th bgcolor=$color colspan=\"1\">Account Name</th>";
echo "<th bgcolor=$color colspan=\"1\">Op Balance</th>";
echo "<th bgcolor=$color colspan=\"1\">Debit</th>";
echo "<th bgcolor=$color colspan=\"1\">Credit</th>";
echo "<th bgcolor=$color colspan=\"1\">Balance-Dr</th>";
echo "<th bgcolor=$color colspan=\"1\">Balance-Cr</th>";

for($j=0; $j<pg_NumRows($result); $j++) 
{
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	echo "<tr>";
	echo "<td align=left bgcolor=$color><a href=\"gl_ledger.php?glc=".$row['gl_mas_code']."&edt=$end_date&sdt=$start_date\">".$row['gl_mas_code']."</a></td>";
	echo "<td align=left bgcolor=$color>".$row['gl_mas_desc']."</td>";
	echo "<td align=right bgcolor=$color>".$row['op_bal']."</td>";
	echo "<td align=right bgcolor=$color>".$row['curr_debit']."</td>";
	echo "<td align=right bgcolor=$color>".$row['curr_credit']."</td>";
	echo "<td align=right bgcolor=$color>".$row['cl_bal_debit']."</td>";
	echo "<td align=right bgcolor=$color>".$row['cl_bal_credit']."</td>";
	$vop=$vop+$row['op_bal'];
	$vdebit=$vdebit+$row['curr_debit'];
	$vcredit=$vcredit+$row['curr_credit'];
	$cldebit=$cldebit+$row['cl_bal_debit'];
	$clcredit=$clcredit -$row['cl_bal_credit'];

} // for closed
	echo "<tr>";
	echo "<td align=left bgcolor=$color> </td>";
	echo "<td align=centre bgcolor=$color>Total</td>";
	echo "<td align=right bgcolor=$color>".$vop."</td>";
	echo "<td align=right bgcolor=$color>".$vdebit."</td>";
	echo "<td align=right bgcolor=$color>".$vcredit."</td>";
		echo "<td align=right bgcolor=$color>".$cldebit."</td>";
		echo "<td align=right bgcolor=$color>".$clcredit."</td>"; 
echo "<tr>";
echo "</table>";

}

echo "<br>";
//footer();
echo "</body>";
echo "</html>";
?>
