<?
include "../config/config.php";
$id=$_REQUEST['id'];
$date=$_REQUEST["date"];
$sql_statement="select ccb_dp_ac_stmt('$id','$date', 'x')";
$sql_statement.=";fetch all from x";
$result=dBConnect($sql_statement);
$color==$TCOLOR;
//echo $sql_statement;
echo "<HTML>";
echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo"<body bgcolor='silver'>";
echo"<table align=center width='70%' bgcolor='black'>";
echo "<tr><b><td bgcolor=\"grey\" colspan=\"12\" align=\"center\" ><font color=\"white\" size='3'>Account No : $id</font>";
echo"<tr><b><th rowspan=1 bgcolor=\"green\">Action Date</th><th rowspan=1 bgcolor=\"green\">Tran Id</th><th rowspan=1 bgcolor=\"green\">Deposit</th><th rowspan=1 bgcolor=\"green\">Withdrawal</th><th rowspan=1 bgcolor=\"green\">Particulars</th></tr>";
for($j=0; $j<pg_NumRows($result); $j++) {
echo "<tr>";
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
echo"<td size=1 bgcolor='$color' align=right>".$row['ACTION DATE']."</td><td size=1 bgcolor='$color' align=right>".$row['TRANSACTION ID']."</td><td bgcolor='$color' size=1 align=right>".$row['DEPOSIT']."</td><td size=1 bgcolor='$color' align=left>".$row['WITHDRAWAL']."</td><td bgcolor='$color' size=1 align=left>".$row['PARTICULARS']."</td></tr>";
}
$sql_statement.=";close e";
//$result=dBConnect($sql_statement);
echo"</table></body></html>";

?>
