<?
include "../config/config.php";
$staff_id=verifyAutho();
$op=$_REQUEST['op'];
$account_no=$_REQUEST["account_no"];
$menu=$_REQUEST["menu"];
if($menu=='ccl');
if($menu=='kpl');
if($menu=='pl');
if($menu=='bdl');
if($menu=='spl');
if($menu=='mt');
if($menu=='ser');
echo "<html>";
echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script language=\"JAVASCRIPT\">";
echo "function closeme() 
{ 
close(); 
}";
echo "</script>";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"id.focus();\">";
echo "<h3><center>Security Statement Of Account No -[$account_no]</center>";
echo "</h3><hr>";
//$sql_statement="select * from morgedge where account_no='$account_no'";
$sql_statement="select * from (select c.account_no,a.name1,a.address12,b.security_type,
b.security_info,b.security_value,c.issue_date,b.max_date,
d.loan_amount,c.customer_id
from customer_master a,loan_security b,loan_ledger_hrd c,loan_issue_dtl d
where a.customer_id=c.customer_id
and b.account_no=c.account_no
and b.loan_serial_no=c.loan_serial_no 
and c.loan_serial_no=d.loan_serial_no
and c.status='op'
and c.loan_type in('$menu') ) x where account_no='$account_no'" ;
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_num_rows($result)<0) {
echo "<h4>No Record or ERROR!!!</h4>";
} else
{
echo "<table valign=\"top\" width=\"60%\" align=\"center\">";
$color=$TCOLOR;
echo "<tr><td bgcolor=\"GREEN\" colspan=\"16\" align=\"center\"><font color=\"white\" size=5><b>Certificate Morgate Register</b></font>";
echo "<tr>";

echo "<th bgcolor=$color >Account No</th>";
echo "<th bgcolor=$color >Certificate Holder's Name</th>";
echo "<th bgcolor=$color >Address</th>";
echo "<th bgcolor=$color >Type of Certificate</th>";
echo "<th bgcolor=$color >Certificate No.</th>";
echo "<th bgcolor=$color >Value of Certificate</th>";
echo "<th bgcolor=$color >Date of Issue</th>";
echo "<th bgcolor=$color >Date of Maturity</th>";
echo "<th bgcolor=$color >Loan Amount</th>";
echo "<th bgcolor=$color >Customer No</th>";


for($j=0; $j<pg_num_rows($result); $j++){
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
echo "<tr>";
echo "<td align=CENTER bgcolor=$color>".$row['account_no']."</td>";
echo "<td align=CENTER bgcolor=$color>".$row['name1']."</td>";
echo "<td align=CENTER bgcolor=$color>".$row['address12']."</td>";
echo "<td align=CENTER bgcolor=$color>".$row['security_type']."</td>";
echo "<td align=CENTER bgcolor=$color>".$row['security_info']."</td>";
echo "<td align=CENTER bgcolor=$color>".$row['security_value']."</td>";
echo "<td align=CENTER bgcolor=$color>".$row['issue_date']."</td>";
echo "<td align=CENTER bgcolor=$color>".$row['max_date']."</td>";
echo "<td align=CENTER bgcolor=$color>".$row['loan_amount']."</td>";
echo "<td align=CENTER bgcolor=$color>".$row['customer_id']."</td>";
}
echo "<tr>";
$color="cyan";
echo "<td align=center bgcolor=$color colspan=\"13\"><B>Total:".($j)." Certificates Found !!!!!!!!</B></td>";
}
echo "</table>";

echo "<table align=center bgcolor=\"RED\" width=\"20%\">";
echo "<tr>";
echo "<td align=\"right\">";
echo "</td>";
echo "<td align=center>";
echo "<input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print me\" onclick=\"print()\"> ";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "</body>";
echo "</html>";
?>
