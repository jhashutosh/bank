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
$gr=pg_fetch_array($res,0);
$sql_statement="select * from emp_adhoc_grant_dtl where emp_id=$q";
$result=dBConnect($sql_statement);
echo"<table align='center' width='100%'>";
echo"<th bgcolor='#1773D0' align='center'><font color='white'>Grant Number</th><th bgcolor='#1773D0' align='center'><font color='white'>From Date</th><th bgcolor='#1773D0' align='center'><font color='white'>Monthly Amount</th><th bgcolor='#1773D0' align='center'><font color='white'>To Date</th><th bgcolor='#1773D0' align='center'><font color='white'>Total Amount</th><th bgcolor='#1773D0' align='center'><font color='white'>Pay Date</th>";
for($j=0;$j<pg_NumRows($result);$j++){
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$fcolor=($fcolor==$TFCOLOR)?$TBFCOLOR:$TFCOLOR;
$row=pg_fetch_array($result,$j);
echo"<tr><td align='center' bgcolor=$color><font color=$fcolor>".$row['grant_no']."</td>";
echo"<td align='center' bgcolor=$color><font color=$fcolor>".$row['from_dt']."</td>";
echo"<td align='center' bgcolor=$color><font color=$fcolor>".$row['monthly_amount']."</td>";
echo"<td align='center' bgcolor=$color><font color=$fcolor>".$row['to_dt']."</td>";
echo"<td align='center' bgcolor=$color><font color=$fcolor>".$row['amount']."</td>";
echo"<td align='center' bgcolor=$color><font color=$fcolor>".$row['pay_dt']."</td></tr>";
}
echo"</table>";
?>
