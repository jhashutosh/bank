<?
include "../config/config.php";

$sql_statement="select * from emp_holiday_mas order by holday_dt";
$result=dBConnect($sql_statement);
$color==$TCOLOR;
echo "<HTML>";
echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo"<body>";
echo"<table width='100%'>";
for($j=0; $j<pg_NumRows($result); $j++) {
echo "<tr>";
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
echo"<td width='30%' bgcolor='$color'>".$row['holday_dt']."</td><td bgcolor='$color' width='70%'>".$row['holday_desc']."</td></tr>";
}
echo"</table></body></html>";

?>
