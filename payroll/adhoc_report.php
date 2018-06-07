<?
include "../config/config.php";
$q=$_REQUEST['q'];
$TCOLOR='white';
$TBGCOLOR='#80ADF6';
$TFCOLOR='#036D9B';
$TBFCOLOR='white';
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<body bgcolor=\"#E1FFEF\">";
//echo $q;
$sql="select * from emp_adhoc_grant_mas where grant_no='$q'";
$res=dBConnect($sql);
$gr=pg_fetch_array($res,0);
$sql_statement="select b.name,a.emp_id,a.pay_dt,sum(a.amount) from emp_adhoc_grant_dtl a,emp_master b  where a.grant_no='$q' and a.emp_id=b.emp_id  group by a.emp_id,a.pay_dt,b.name ";
$result=dBConnect($sql_statement);
echo"<table align='center' width='100%'>";
echo"<tr><th colspan='6'>ADHOC GRANT FROM GOVT.</th></tr>";
echo"<tr><th align='right' colspan='2'>Grant Number :</th><td>$q</td><th align='right' colspan='2'>Sanction Date :</th><td>".$gr['sanction_date']."</td></tr>";
echo"<th colspan='2' bgcolor='#1773D0' align='center'><font color='white'>Employee Name</th><th colspan='2' bgcolor='#1773D0' align='center'><font color='white'>Payment Date</th><th colspan='2' bgcolor='#1773D0' align='center'><font color='white'>Amount</th>";
for($j=0;$j<pg_NumRows($result);$j++){
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$fcolor=($fcolor==$TFCOLOR)?$TBFCOLOR:$TFCOLOR;
$row=pg_fetch_array($result,$j);
echo"<tr><td colspan='2' align='center' bgcolor=$color><font color=$fcolor><font color=$fcolor><a href=\"../payroll/adhoc_emp_report.php?id=".$row['emp_id']."&gr_no=$q\" target= >".$row['name']."</td>";
echo"<td colspan='2' align='center' bgcolor=$color><font color=$fcolor>".$row['pay_dt']."</td>";
echo"<td colspan='2' align='center' bgcolor=$color><font color=$fcolor>".$row['sum']."</td></tr>";
}
echo"</table>";
?>
