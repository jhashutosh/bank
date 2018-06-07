<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$account_no=$_REQUEST['account_no'];
echo "<html>";
echo "<head>";
echo "<title>";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<h1><font color=\"red\">Shg Loan Details of group no : $group_no</font>";
echo "</h1>";
//echo "<form method=\"POST\" action=\"shg_loan_detail.php\">";

$sql_statement="SELECT * FROM loan_statement where account_no='$account_no'";
if(pg_NumRows($result)==0){
echo "<h4>Not found!!!</h4>";
}
 else {
 echo "<table width=\"100%\">";
  echo "<tr><td bgcolor=\"green\" colspan=\"8\" align=\"center\"><font color=\"red\">Loan details</font>";

// Place line comments if you do not need column header
 $color=$TCOLOR;
echo "<tr>";
 echo "<th bgcolor=$color colspan=\"1\">Loan account no.</th>";
echo "<th bgcolor=$color colspan=\"1\">Loan amount issued</th>";
echo "<th bgcolor=$color colspan=\"1\"> Loan Issue Date</th>";
echo "<th bgcolor=$color colspan=\"1\"> Loan Repayment Date</th>";
echo "<th bgcolor=$color colspan=\"1\">Balance Prinical</th>";
 echo "<th bgcolor=$color colspan=\"1\">Interest</th>";
 echo "<th bgcolor=$color colspan=\"1\">Overdue Interest</th>";
echo "<th bgcolor=$color colspan=\"1\">Total amount due</th>";
echo "</tr>";
for($j=1; $j<=pg_NumRows($result); $j++) 
{
     	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,($j-1));
        $loan_account_no= $row['loan_account_no'];
	echo "<tr>";
	echo "<td align=right bgcolor=$color>".$loan_account_no."</td>";
	echo "<td align=right bgcolor=$color>".$row['principal_amount']."</td>";
	echo "<td align=right bgcolor=$color>".$row['date_of_issue']."</td>";
        echo "<td align=right bgcolor=$color>".$row['date_of_repayment']."</td>";

        //echo "hi".$loan_account_no;

	$curr_bal=loan_cuurent_balance($loan_account_no);
	$total_bal=$total_bal+$curr_bal;
	echo "<td align=right bgcolor=$color>$curr_bal</td>";
	$sql_statement="SELECT * from shg_loan_simple_int('$loan_account_no')";
	$result1=pg_Exec($db,$sql_statement);
        $sql_statement="SELECT * FROM shg_tmp where account_no='$loan_account_no'";
	$result1=pg_Exec($db,$sql_statement);
	$due_interest=pg_result($result1,"due_interest");
	$overdue_interest=pg_result($result1,"overdue_interest");
	$total_bal=$total_bal+$due_interest+$overdue_interest;
        echo "<td align=right bgcolor=$color>".$due_interest."</td>";
	$total_over=$total_over+$over;
        echo "<td align=right bgcolor=$color>".$overdue_interest."</td>";
	$total_amount=$curr_bal+$interest+$over;
        echo "<td align=right bgcolor=$color>".$total_amount."</td>";
	}
  echo "<tr>";
  $color="cyan";
  echo "<td align=center bgcolor=$color colspan=\"2\"><B>Total account &nbsp;&nbsp; $i</B></td>";
  echo "<td align=right bgcolor=$color><B></B></td>";
  echo "<td align=right bgcolor=$color><B></B></td>";
  echo "<td align=right bgcolor=$color><B>".$total_bal."</B></td>";
  echo "<td align=right bgcolor=$color><B>$total_int</B></td>";
  echo "<td align=right bgcolor=$color><B>$total_over</B></td>";
  $amount=$total_bal+ $total_int+$total_over;
 echo "<td align=right bgcolor=$color><B>$amount</B></td>";
echo "</table>";
}
echo "<br>";

footer();
echo "</body>";
echo "</html>";
?>
