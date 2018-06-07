<?
include "../config/config.php";

$start_date=$_REQUEST["start_date"];
if(empty($start_date) ) { $start_date='01.04.2010'; }
$end_date=$_REQUEST["end_date"];
if(empty($end_date) ) { $end_date='31.03.2011'; }

$v_L_prv_bal="0";
$v_A_prv_bal="0";
$v_L_curr_bal="0";
$v_A_curr_bal="0";
echo "<html>";
echo "<head>";
echo "<title>  Balance Sheet as on: $end_date";
echo "</title>";

echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<form name=\"f1\" action=\"balance_sheet_prv.php\" method=\"POST\">";
echo "<table align=center bgcolor=\"#90EE90\"><tr><td  align=\"\"><b><td>As on<input type=TEXT size=12 name=end_date value=\"$end_date\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.end_date,'dd/mm/yyyy','Choose Date')\">";
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> ";
echo "</table></form>";



$sql_statement="select a.gl_mas_code, b.gl_mas_desc, sum(case when '$end_date'-action_date<365 then credit-debit else 0.00 end) as prv_bal, sum(credit-debit) as curr_bal from mas_gl_tran as a , gl_master as b where a.action_date<= '$end_date' and a.gl_mas_code= b.gl_mas_code and acc_type='L' group by a.gl_mas_code, b.gl_mas_desc order by a.gl_mas_code";
//echo $sql_statement;
$result=dBConnect($sql_statement);

echo "<table width=\"100%\" valign=\"top\"><tr><td valign=\"top\" width=\"50%\">";
echo "<table width=\"100%\">";

echo "<tr><td bgcolor=\"green\" colspan=\"9\" align=\"center\"><font color=\"white\"><b>Liabilities</b></font>";

// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";

echo "<th bgcolor=$color colspan=\"1\" width=\"10%\">Code</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"46%\">Account Name</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"22%\">Prev Yr</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"22%\">Current Yr</th>";

for($j=0; $j<pg_NumRows($result); $j++) 
{
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	echo "<tr>";
	echo "<td align=left bgcolor=$color>".$row['gl_mas_code']."</td>";
	echo "<td align=left bgcolor=$color>".$row['gl_mas_desc']."</td>";
	echo "<td align=right bgcolor=$color>".number_format($row['prv_bal'],0)."</td>";
	echo "<td align=right bgcolor=$color>".number_format($row['curr_bal'],0)."</td>";
		$v_L_prv_bal=$v_L_prv_bal+$row['prv_bal'];
		$v_L_curr_bal=$v_L_curr_bal+$row['curr_bal'];
}
	echo "<tr>";
	echo "<td align=left bgcolor=$color> </td>";
	echo "<td align=centre bgcolor=$color>Total :</td>";
	echo "<td align=right bgcolor=$color>".number_format($v_L_prv_bal,0)."</td>";
	echo "<td align=right bgcolor=$color>".number_format($v_L_curr_bal,0)."</td>";
echo "</tr>";
$color="cyan";

echo "</table>";
echo "</td><td valign=\"top\" width=\"50%\">";
//$sql_statement="select a.gl_mas_code, b.gl_mas_desc, sum(debit) as debit, sum(credit) as credit, sum(debit-credit) as bal from mas_gl_tran as a , gl_master as b where a.gl_mas_code= b.gl_mas_code and acc_type='A' group by a.gl_mas_code, b.gl_mas_desc order by a.gl_mas_code";

$sql_statement="select a.gl_mas_code, b.gl_mas_desc, sum(case when '$end_date'-action_date<365 then debit-credit else 0.00 end) as prv_bal, sum(debit-credit) as curr_bal from mas_gl_tran as a , gl_master as b where a.action_date<= '$end_date' and a.gl_mas_code= b.gl_mas_code and acc_type='A' group by a.gl_mas_code, b.gl_mas_desc order by a.gl_mas_code";

//echo $sql_statement;
$result=dBConnect($sql_statement);

echo "<table width=\"100%\">";

echo "<tr><td bgcolor=\"green\" colspan=\"4\" align=\"center\"><font color=\"white\"><b>Assets</b></font>";

$color=$TCOLOR;
echo "<tr>";

echo "<th bgcolor=$color colspan=\"1\" width=\"10%\">Code</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"46%\">Account Name</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"22%\">Prev Yr</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"22%\">Current Yr</th>";

for($j=0; $j<pg_NumRows($result); $j++) 
{
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	$vdebit1=$vdebit1+$row['debit'];
	$vcredit1=$vcredit1+$row['credit'];
	echo "<tr>";
	echo "<td align=left bgcolor=$color>".$row['gl_mas_code']."</td>";
	echo "<td align=left bgcolor=$color>".$row['gl_mas_desc']."</td>";
	echo "<td align=right bgcolor=$color>".number_format($row['prv_bal'],0)."</td>";
	echo "<td align=right bgcolor=$color>".number_format($row['curr_bal'],0)."</td>";
		$v_A_prv_bal=$v_A_prv_bal+$row['prv_bal'];
		$v_A_curr_bal=$v_A_curr_bal+$row['curr_bal'];

}
	echo "<tr>";
	echo "<td align=left bgcolor=$color> </td>";
	echo "<td align=centre bgcolor=$color>Total -</td>";
	echo "<td align=right bgcolor=$color>".number_format($v_A_prv_bal,0)."</td>";
	echo "<td align=right bgcolor=$color>".number_format($v_A_curr_bal,0)."</td>"; 

echo "</tr>";

echo "</table>";
$Pl_prv=$v_A_prv_bal-$v_L_prv_bal;
$Pl_curr=$v_A_curr_bal-$v_L_curr_bal;
echo "</td></tr>";
echo "<tr><td align=left width=\"50%\"><table width=\"100%\">";
echo "<tr> ";
echo "<th bgcolor=$color colspan=\"2\" >Unadjusted Profit</th>";
echo "<th align=right bgcolor=$color colspan=\"1\" width=\"22%\">".number_format($Pl_prv,0)."</th>";
echo "<th align=right bgcolor=$color colspan=\"1\" width=\"22%\" align=left>".number_format($Pl_curr,0)."</th>";
echo "</tr>";

echo "<tr> ";
echo "<th bgcolor=$color colspan=\"1\" width=\"10%\"></th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"46%\">Total</th>";
echo "<th align=right bgcolor=$color colspan=\"1\" width=\"22%\">".number_format($v_A_prv_bal,0)."</th>";
echo "<th align=right bgcolor=$color colspan=\"1\" width=\"22%\">".number_format($v_A_curr_bal,0)."</th>";
echo "</tr>";
echo "</table>";
echo "</td><td align=left width=\"50%\"><table  width=\"100%\" ><tr>";
echo "<th bgcolor=$color colspan=\"1\" width=\"10%\">.</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"46%\"></th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"22%\"></th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"22%\"></th>";
echo "</tr><tr>";
echo "<th bgcolor=$color colspan=\"1\" width=\"10%\"></th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"46%\">Total</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"22%\">".number_format($v_A_prv_bal,0)."</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"22%\">".number_format($v_A_curr_bal,0)."</th>";
echo "</tr></table>";




echo "</td></tr></table>";


echo "<br>";
footer();
echo "</body>";
echo "</html>";
?>
