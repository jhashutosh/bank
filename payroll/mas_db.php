<?
include "../config/config.php";
$TCOLOR='white';
$TBGCOLOR='#80ADF6';
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<body bgcolor=\"#E1FFEF\">";
echo"<table width='100%'>";
echo"<th bgcolor='#1773D0' align='center'><font color='white'>Grant Number</th>";
echo"<th bgcolor='#1773D0' align='center'><font color='white'>Sanction Date</th>";
echo"<th bgcolor='#1773D0' align='center'><font color='white'>Grant Amount</th>";
$s="select * from emp_adhoc_grant_mas";
$r=dBConnect($s);
for($j=0;$j<pg_NumRows($r);$j++)
{$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($r,$j);
echo"<tr><td align='center' bgcolor=$color>".$row['grant_no']."</td>";
echo"<td align='center' bgcolor=$color>".$row['sanction_date']."</td>";
echo"<td align='center' bgcolor=$color>".$row['amount']."</td></tr>";
}
echo"</table>";
echo"</body>";
?>
