<?
include "../config/config.php";
$id=$_REQUEST['id'];
$date=$_REQUEST["date"];
$sql_statement="select ccb_ln_ac_dtls('$id','$date', 'x')";
$sql_statement.=";fetch all from x";
$result=dBConnect($sql_statement);
$color==$TCOLOR;
//echo $sql_statement;
echo "<HTML>";
echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo"<body bgcolor='black'>";
echo"<table align=center width='70%'>";
echo "<tr><b><td bgcolor=\"pink\" colspan=\"12\" align=\"center\" ><font color=\"red\" size='3'>Account No : $id</font>";
echo"<tr><b><th rowspan=1 bgcolor=\"green\">Serial No.</th><th rowspan=1 bgcolor=\"green\">Action Date</th><th rowspan=1 bgcolor=\"green\">Tran Id</th><th rowspan=1 bgcolor=\"green\">Loan Issued</th><th rowspan=1 bgcolor=\"green\">Loan Repaid</th></tr>";
for($j=0; $j<pg_NumRows($result); $j++) {
echo "<tr>";
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
echo"<td size=1 bgcolor='$color' align=right>".$row['SRL']."</td><td size=1 bgcolor='$color' align=right>".$row['TRANSACTION DATE']."</td><td bgcolor='$color' size=1 align=right>".$row['TRANSACTION ID']."</td><td size=1 bgcolor='$color' align=right>".$row['LOAN ISSUED']."</td><td bgcolor='$color' size=1 align=right>".$row['LOAN REPAID']."</td></tr>";
}
//$sql_statement.=";close e";
//$result=dBConnect($sql_statement);
echo"</table></body></html>";

?>
