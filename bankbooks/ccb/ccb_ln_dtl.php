<?
include "../config/config.php";
$id=$_REQUEST['id'];
//$menu=$_REQUEST['menu'];
$date=$_REQUEST["date"];
$sql_statement="select ccb_ln_dtls_fnl('$id','$date', 'x')";
$sql_statement.=";fetch all from x";
$result=dBConnect($sql_statement);
$color==$TCOLOR;
//echo $sql_statement;
echo "<HTML>";
echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo"<body bgcolor='black'>";
echo"<table align=center width='60%'>";
echo "<tr><b><td bgcolor=\"pink\" colspan=\"12\" align=\"center\" ><font color=\"red\" size='3'>Loan Type : $id</font>";
echo"<tr><b><th rowspan=1 bgcolor=\"green\">Serial No.</th><th rowspan=1 bgcolor=\"green\">Account No.</th><th rowspan=1 bgcolor=\"green\">Loan Issued</th><th rowspan=1 bgcolor=\"green\">Repaid</th><th rowspan=1 bgcolor=\"green\">Balance</th><th rowspan=1 bgcolor=\"green\">Due Int.</th></tr>";
for($j=0; $j<pg_NumRows($result); $j++) {
echo "<tr>";
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
echo"<td size=1 bgcolor='$color' align=right>".$row['SRL']."</td><td size=1 bgcolor='$color' align=right><a href=\"../bankbooks/ccb_ln_acc_dtl.php?&date=$date&id=".$row['A/C NO.']."\" target=\"_blank\">".$row['A/C NO.']."</td><td bgcolor='$color' size=1 align=right>".$row['AMOUNT ISSUED']."</td><td size=1 bgcolor='$color' align=right>".$row['AMOUNT REPAID']."</td><td bgcolor='$color' size=1 align=right>".$row['LOAN OUTSTANDING']."</td><td bgcolor='$color' size=1 align=right>".$row['DUE INTEREST']."</td></tr>";
}
$sql_statement.=";close e";
//$result=dBConnect($sql_statement);
echo"</table></body></html>";

?>
