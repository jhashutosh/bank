<?php
include "../config/config.php";
$TCOLOR='white';
$TBGCOLOR='#80ADF6';
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<body bgcolor=\"#E1FFEF\">";
echo"<table width='100%'>";
echo"<th bgcolor='#1773D0' align='center' width='40%'><font color='white'>Financial Year</th>";
echo"<th bgcolor='#1773D0' align='center' width='20%'><font color='white'>Percentage of Share</th>";
echo"<th bgcolor='#1773D0' align='center' width='40%'><font color='white'>Date</th>";
$s="select * from dividend_mas";
$r=dBConnect($s);
for($j=0;$j<pg_NumRows($r);$j++)
{$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($r,$j);
echo"<tr><td align='center' bgcolor=$color>".$row['fy']."</td>";
echo"<td align='center' bgcolor=$color>".$row['share_percentage']."</td>";
echo"<td align='center' bgcolor=$color>".$row['action_date']."</td></tr>";
}
echo"</table>";
echo"</body>";
?>
