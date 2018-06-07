<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$operator_code=$staff_id;
echo "<html>";
echo "<head>";
echo "<title>Due loan list";
echo "</title>";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<h3><u><font color =\"red\">Report No.7</h3></u></font>";
echo "<h1> Due loan list for Shg groups";
echo "</h1>";

echo "<hr>";
echo "<form method=\"POST\" action=\"shg_due_list.php\">";
echo "<hr>";
$db=pg_pConnect("host=$HOST dbname=$DATABASE");
$sql_statement1="SELECT * FROM shg_main_int()";
$result=pg_Exec($db,$sql_statement1);
if(pg_NumRows($result)==0) {
echo "<h4><font color=\"red\">NotFound!!!</font></h4>";
} 
else
{
 $sql_statement="SELECT * FROM loan_due";
 $result=pg_Exec($db,$sql_statement);
 if(pg_NumRows($result)==0) {
 echo "<h4><font color=\"red\">Not Found!!!</font></h4>";
  } 
 else
 {
  echo "<table  border=\"1\" width=\"80%\">";

echo "<tr><td bgcolor=\"green\" colspan=\"11\" align=\"center\">Shg due loan list<font color=\"white\"></font>";

// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color rowspan=\"2\">Group No.</th>";
echo "<th bgcolor=$color rowspan=\"2\">Group Name</th>";
echo "<th bgcolor=$color rowspan=\"2\">Leader Name</th>";
echo "<th bgcolor=$color rowspan=\"2\">Loan Account No</th>";
echo "<th bgcolor=$color rowspan=\"2\">Loan issue Date</th>";
echo "<th bgcolor=$color rowspan=\"2\">Loan Repayment Date</th>";
echo "<th bgcolor=$color colspan=\"3\">Loan amountTaken</th>";
echo"<tr>";
echo "<th bgcolor=$color colspan=\"1\">Principal</th>";
echo "<th bgcolor=$color colspan=\"1\">Interest</th>";
echo "<th bgcolor=$color colspan=\"1\">Total</th>";
echo "</tr>";
$i=0;
for($j=1; $j<=pg_NumRows($result); $j++) 
{
echo "<tr>";
$i++;
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,($j-1));


	echo "<td align=right bgcolor=$color>".$row['group_no']."</td>";
	echo "<td align=right bgcolor=$color>".$row['title']."</td>";
	echo "<td align=right bgcolor=$color>".$row['leader']."</td>";
	echo "<td align=center bgcolor=$color><a href=\"shg_loan_ledger.php?account_no=".$row['loan_account_no']."\" targer=_display>".$row['loan_account_no']."</a></td>";
	echo "<td align=right bgcolor=$color>".$row['date_of_issue']."</td>";
  	echo "<td align=right bgcolor=$color>".$row['date_of_repayment']."</td>";
	echo "<td align=right bgcolor=$color>".$row['principal']."</td>";
  echo "<td align=right bgcolor=$color>".$row['int_simple']."</td>";
$total =$row['principal']+$row['int_simple'];
  echo "<td align=right bgcolor=$color>$total</td>";
echo "</tr>";
}
  echo "<tr>";

	
echo "<td align=right bgcolor=$color></td>";
	echo "<td align=right bgcolor=$color></td>";
echo "<td align=right bgcolor=$color></td>";
echo "<td align=right bgcolor=$color></td>";
echo "<td align=right bgcolor=$color></td>";
echo "<td align=right bgcolor=$color></td>";
echo "<td align=right bgcolor=$color></td>";
echo "<td align=right bgcolor=$color></td>";
echo "<td align=right bgcolor=$color></td>";
 echo "</tr>";
echo"</table>";
 }
}
echo "<br>";

footer();
echo "</body>";
echo "</html>";
?>

