<?php
include "../config/config.php";
$menu=$_REQUEST['menu'];
$staff_id=verifyAutho();
echo "<html>";
echo "<head>";
echo "<title>List of accounts";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<table width=\"140%\" align=\"center\">";
echo "<center><tr><th bgcolor=green colspan=15><font color=white size=5>Statement of SAO Loan Ledger</font></center>";
$color="#F0E68C";
echo "<tr>";
echo "<th bgcolor=$color width=\"15%\" rowspan=\"2\">Tran Id</th>";
echo "<th bgcolor=$color width=\"15%\" rowspan=\"2\">Action Date</th>";
echo "<th bgcolor=$color width=\"15%\" rowspan=\"2\">Account No</th>";
echo "<th bgcolor=$color width=\"15%\" rowspan=\"2\">Loan Reference</th>";
echo "<th bgcolor=$color width=\"15%\" rowspan=\"2\">Principal</th>";
echo "<th bgcolor=$color width=\"15%\" rowspan=\"2\">Days</th>";
echo "<th bgcolor=$color width=\"15%\" colspan=\"2\">Interest</th>";
echo "<th bgcolor=$color width=\"15%\" colspan=\"3\">Repayment</th>";
echo "<th bgcolor=$color width=\"15%\" colspan=\"3\">Balance</th>";
echo "<tr>";
echo "<th bgcolor=$color width=\"15%\" rowspan=\"1\">Due</th>";
echo "<th bgcolor=$color width=\"15%\" rowspan=\"1\">Overdue</th>";
echo "<th bgcolor=$color width=\"15%\" rowspan=\"1\">Principal</th>";
echo "<th bgcolor=$color width=\"15%\" rowspan=\"1\">Due</th>";
echo "<th bgcolor=$color width=\"15%\" rowspan=\"1\">Overdue</th>";
echo "<th bgcolor=$color width=\"15%\" rowspan=\"1\">Principal</th>";
echo "<th bgcolor=$color width=\"15%\" rowspan=\"1\">Due</th>";
echo "<th bgcolor=$color width=\"15%\" rowspan=\"1\">Overdue</th>";
$sql_statement="SELECT * FROM sao_loan_ledger ORDER BY account_no,loan_ref,action_date,tran_id";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0){
echo "<tr>";
echo "<th colspan=\"15\"><font color=green size=5><blink>!!! There is no Customer in Overdue List !!!</blink></font></th>";
}
else
{
$b_principal=0.00;
$b_due_int=0.00;
$b_overdue_int=0.00;
$color=$TCOLOR;
$currcd='Sujoy';
for($j=0; $j<=pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
if($currcd!=$row['account_no']){
	$currcd=$row['account_no'];
	$b_principal=0.00;
	$b_due_int=0.00;
	$b_overdue_int=0.00;
	echo "<tr>";
	echo "<th bgcolor=$color width=\"15%\" colspan=\"2\">".$currcd."</th>";
	echo "<th bgcolor=$color width=\"15%\" colspan=\"12\">".$currcd."</th>";
	echo "<\tr>";
}
$principal=($row['principal']);
$due_int=($row['due_interest']);
$overdue_int=($row['od_interest']);
$r_principal=($row['r_principal']);
$r_due_int=($row['r_due_int']);
$r_overdue_int=($row['r_od_int']);
$b_principal=$b_principal+$principal-$r_principal;
$b_due_int=$b_due_int+$due_int-$r_due_int;
$b_overdue_int=$b_overdue_int+$overdue_int-$r_overdue_int;

echo "<tr>";
echo "<td bgcolor=$color width=\"15%\">".$row['tran_id']."</td>";
echo "<td bgcolor=$color width=\"15%\">".$row['action_date']."</td>";
echo "<td bgcolor=$color width=\"15%\">".$row['account_no']."</td>";
echo "<td bgcolor=$color width=\"15%\">".$row['loan_ref']."</td>";
echo "<td bgcolor=$color align=\"right\" width=\"15%\">".$row['principal']."</td>";
echo "<td bgcolor=$color align=\"right\" width=\"15%\">".$row['int_days']."</td>";
echo "<td bgcolor=$color align=\"right\" width=\"15%\">".$row['due_interest']."</td>";
echo "<td bgcolor=$color align=\"right\" width=\"15%\">".$row['od_interest']."</td>";
echo "<td bgcolor=$color align=\"right\" width=\"15%\">".$row['r_principal']."</td>";
echo "<td bgcolor=$color align=\"right\" width=\"15%\">".$row['r_due_int']."</td>";
echo "<td bgcolor=$color align=\"right\" width=\"15%\">".$row['r_od_int']."</td>";
echo "<td bgcolor=$color align=\"right\" width=\"15%\">$b_principal</td>";
echo "<td bgcolor=$color align=\"right\" width=\"15%\">$b_due_int</td>";
echo "<td bgcolor=$color align=\"right\" width=\"15%\">$b_overdue_int</td>";
echo "</tr>";
}
}
echo "</table>";
?>
