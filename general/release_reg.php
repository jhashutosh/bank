<?php
include "../config/config.php";
$staff_id=verifyAutho();
$op=$_REQUEST['op'];
echo "<html>";
echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script language=\"JAVASCRIPT\">";
echo "function closeme() 
{ 
close(); 
}";
echo "</script>";
echo "<form>";
echo "<table align=center bgcolor=\"#90EE90\" width=\"20%\">";
//echo "<tr><td colspan=\"6\" align=center><iframe src=\"morgate_reg.php?status=$op&menu=$menu\" width=\"100%\" height=\"350\" ></iframe>";
echo "<tr>";
echo "<td align=\"right\">";
//echo "<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close me\" onclick=\"closeme()\">";
echo "</td>";
echo "<td>";
echo "<input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print me\" onclick=\"print()\"> ";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "</form>";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"id.focus();\">";
$sql_statement="select c.account_no,b.entry_date,a.name1,a.address12,b.security_type,
b.security_info,b.security_value,d.loan_amount,
c.customer_id,e.action_date,e.b_principal,sum(e.b_due_int+e.b_overdue_int),sum(e.b_principal+
e.b_due_int+e.b_overdue_int)
from customer_master a,loan_security b,loan_ledger_hrd c,loan_issue_dtl d,loan_return_dtl e
where a.customer_id=c.customer_id
and b.account_no=c.account_no
and c.account_no=d.account_no
and d.account_no=e.account_no
and c.status='cl'
and c.loan_type in('kpl','pl')
group by b.loan_serial_no,b.entry_date,a.name1,a.address12,b.security_type,
b.security_info,b.security_value,d.loan_amount,
c.int_due_rate,c.customer_id,e.action_date,e.b_principal,c.account_no 
order by cast(substring(c.account_no,4) as int)desc";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_num_rows($result)<1) {
echo "<h4>No Record or ERROR!!!</h4>";
} else {
echo "<hr>";
echo "<table>";
}
echo "<table valign=\"top\" width=\"60%\" align=\"center\">";
$color=$TCOLOR;
echo "<tr><td bgcolor=\"GREEN\" colspan=\"16\" align=\"center\"><font color=\"white\" size=5><b>Certificate Released Register Details</b></font>";
echo "<tr>";
//echo "<th bgcolor=$color >Sl.No</th>";
echo "<th bgcolor=$color >Account No</th>";
echo "<th bgcolor=$color >Date</th>";
echo "<th bgcolor=$color >Certificate Holder's Name</th>";
echo "<th bgcolor=$color >Address</th>";
//echo "<th bgcolor=$color >Postal Charges</th>";
echo "<th bgcolor=$color >Type of Certificate</th>";
echo "<th bgcolor=$color >Certificate No.</th>";
echo "<th bgcolor=$color >Value of Certificate</th>";
echo "<th bgcolor=$color >Loan Amount</th>";
//echo "<th bgcolor=$color >Rate of Interest</th>";
echo "<th bgcolor=$color >Customer No</th>";
echo "<th bgcolor=$color >Date of Released</th>";
echo "<th bgcolor=$color >Received Principal</th>";
echo "<th bgcolor=$color >Received Interest</th>";
echo "<th bgcolor=$color >Total Amount Received</th>";
//echo "<tr><td colspan=\"6\" align=center><iframe src=\"morgate_reg.php?status=$op&menu=$menu\" width=\"100%\" height=\"350\" ></iframe>";
for($j=1; $j<=pg_NumRows($result); $j++) {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j-1));
echo "<tr>";
//echo "<td align=center bgcolor=$color>". $row[0] ."</td>";
echo "<td align=center bgcolor=$color>". $row[0] ."</td>";
echo "<td align=center bgcolor=$color>". $row[1] ."</td>";
echo "<td align=center bgcolor=$color>". $row[2] ."</td>";
echo "<td align=center bgcolor=$color>". $row[3] ."</td>";
echo "<td align=center bgcolor=$color>". $row[4] ."</td>";
echo "<td align=center bgcolor=$color>". $row[5] ."</td>";
echo "<td align=center bgcolor=$color>". $row[6] ."</td>";
//echo "<td align=center bgcolor=$color>". $row[8] ."</td>";
echo "<td align=center bgcolor=$color>". $row[7] ."</td>";
echo "<td align=center bgcolor=$color>". $row[8] ."</td>";
echo "<td align=center bgcolor=$color>". $row[9] ."</td>";
echo "<td align=center bgcolor=$color>". $row[10] ."</td>";
echo "<td align=center bgcolor=$color>". $row[11] ."</td>";
echo "<td align=center bgcolor=$color>". $row[12] ."</td>";
$t_amount+=$row[10];
}
//echo "<tr><td colspan=\"6\" align=center><iframe src=\"morgate_reg.php?status=$op&menu=$menu\" width=\"100%\" height=\"350\" ></iframe>";
echo "<tr>";
$color="cyan";
echo "<td align=center bgcolor=$color colspan=\"15\"><B>Total:".($j-1)." certificates Found !!!!!!!!</B></td>";
//echo "<td align=center bgcolor=$color colspan=\"1\"></td>";
//echo "<td align=center bgcolor=$color colspan=\"4\"><B>$t_amount</B></td>";
echo "</table>";
echo "</body>";
echo "</html>";
?>
