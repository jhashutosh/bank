<?php
include "../config/config.php";
$menu=$_REQUEST['menu'];
$staff_id=verifyAutho();
$statement=$_REQUEST['state'];
echo "<html>";
echo "<head>";
echo "<title>List of accounts";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<table width=\"140%\" align=\"center\">";
if($statement==ac){
echo "<center><tr><th bgcolor=green colspan=11><font color=white size=5>List Of SAO Loan According to Accending Order On A/C No</font></center>";
}
if($statement==amount){
echo "<center><tr><th bgcolor=green colspan=11><font color=white size=5>List Of SAO Loan According to Accending Order On Amount</font></center>";
}

$color="#F0E68C";
echo "<tr>";
echo "<th bgcolor=$color width=\"10%\" rowspan=\"2\">SAO A/C NO.</th>";
echo "<th bgcolor=$color width=\"25%\" rowspan=\"2\">Farmer Name</th>";
//echo "<th bgcolor=$color width=\"10%\" rowspan=\"2\">Issue Date</th>";
//echo "<th bgcolor=$color width=\"10%\" rowspan=\"2\">Reapyment Date</th>";
echo "<th bgcolor=$color width=\"10%\" rowspan=\"2\">Issued Amount</th>";
echo "<th bgcolor=$color width=\"40%\" colspan=\"4\">Repayment Details</th>";
echo "<th bgcolor=$color width=\"40%\" colspan=\"4\">Due Details</th>";
echo "<tr>";
echo "<th bgcolor=$color width=\"10%\" rowspan=\"1\">Due</th>";
echo "<th bgcolor=$color width=\"10%\" rowspan=\"1\">Overdue</th>";
echo "<th bgcolor=$color width=\"10%\" rowspan=\"1\">Principal</th>";
echo "<th bgcolor=$color width=\"10%\" rowspan=\"1\">Total</th>";
echo "<th bgcolor=$color width=\"10%\" rowspan=\"1\">Due</th>";
echo "<th bgcolor=$color width=\"10%\" rowspan=\"1\">Overdue</th>";
echo "<th bgcolor=$color width=\"10%\" rowspan=\"1\">Principal</th>";
echo "<th bgcolor=$color width=\"10%\" rowspan=\"1\">Total</th>";

if($statement==ac){
$sql_statement="SELECT account_no, sum(loan_amount) as amount FROM loan_issue_dtl GROUP BY account_no ORDER BY account_no";
}

if($statement==amount)
{
$sql_statement="SELECT account_no, sum(loan_amount) as amount FROM loan_issue_dtl GROUP BY account_no ORDER BY amount";
}

//echo "$sql_statement";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0){
echo "<tr>";
echo "<th colspan=\"14\"><font color=green size=5><blink>!!! There is no Customer !!!</blink></font></th>";
}
else
{

$color=$TCOLOR;
for($j=0; $j<=pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
$account_no=trim($row['account_no']);
echo "<tr>";
echo "<th bgcolor=$color>".$row['account_no']."</th>";
$customer_id=getCustomerNameFromSAOAccount($account_no);
$name=getCustomerName($customer_id);
echo "<th bgcolor=$color>$name</th>";
echo "<th bgcolor=$color>".$row['amount']."</th>";
$sql_statement2="SELECT * FROM loan_return_dtl WHERE account_no='$account_no'";
$result2=dBConnect($sql_statement2);
if(pg_NumRows($result2)>0){
$r_due_int=pg_result($result2,'r_due_int');
$r_overdue_int=pg_result($result2,'r_overdue_int');
$r_principal=pg_result($result2,'r_principal');
$r_total_amount=pg_result($result2,'r_total_amount');
$b_due_int=pg_result($result2,'b_due_int');
$b_overdue_int=pg_result($result2,'b_overdue_int');
$b_principal=pg_result($result2,'b_principal');
$b_total=$b_due_int+$b_overdue_int+$b_principal;
echo "<th bgcolor=$color>$r_due_int</th>";
echo "<th bgcolor=$color>$r_overdue_int</th>";
echo "<th bgcolor=$color>$r_principal</th>";
echo "<th bgcolor=$color>$r_total_amount</th>";
echo "<th bgcolor=$color>$b_due_int</th>";
echo "<th bgcolor=$color>$b_overdue_int</th>";
echo "<th bgcolor=$color>$b_principal</th>";
echo "<th bgcolor=$color>$b_total</th>";
  }

  }
 }


echo "</table>";
echo "</body>";
echo "</html>";

?>
