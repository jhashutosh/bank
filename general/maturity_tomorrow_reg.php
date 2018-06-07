<?
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
/*$sql_statement="select c.account_no,a.name1,a.address12,b.security_type,
b.security_info,b.security_value,c.issue_date,b.max_date,
d.loan_amount,c.customer_id
from customer_master a,loan_security b,loan_ledger_hrd c,loan_issue_dtl d
where a.customer_id=c.customer_id
and b.account_no=c.account_no
and c.account_no=d.account_no
and c.status='op'
and c.loan_type in('kpl','pl') order by cast(substring(c.account_no,4) as int)desc";*/

$sql_statement="select * from loan_security where max_date=current_date+1";

//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_num_rows($result)<1) {
echo "<h4>No Record or ERROR!!!</h4>";
} else {
echo "<hr>";
echo "<table>";
}
echo "<table valign=\"top\" width=\"100%\" align=\"center\">";
$color=$TCOLOR;
echo "<tr><td bgcolor=\"GREEN\" colspan=\"6\" align=\"center\"><font color=\"white\" size=5><b>Certificate Maturity Register Details</b></font>";
echo "<tr>";
echo "<th bgcolor=$color >Account No</th>";
echo "<th bgcolor=$color >Type of Certificate</th>";
echo "<th bgcolor=$color >Certificate No.</th>";
echo "<th bgcolor=$color >Value of Certificate</th>";
echo "<th bgcolor=$color >Date of Issue</th>";
echo "<th bgcolor=$color >Date of Maturity</th>";

for($j=1; $j<=pg_NumRows($result); $j++) {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j-1));
echo "<tr>";
echo "<td align=center bgcolor=$color>". $row['account_no'] ."</td>";
echo "<td align=center bgcolor=$color>". $row['security_type'] ."</td>";
echo "<td align=center bgcolor=$color>". $row['security_info'] ."</td>";
echo "<td align=center bgcolor=$color>". $row['security_value'] ."</td>";
echo "<td align=center bgcolor=$color>". $row['entry_date'] ."</td>";
echo "<td align=center bgcolor=$color>". $row['max_date'] ."</td>";

}
echo "<tr>";
$color="cyan";
echo "<td align=center bgcolor=$color colspan=\"6\"><B>Total:".($j-1)." Certificates Found !!!!!!!!</B></td>";

echo "</table>";
echo "</body>";
echo "</html>";
?>
