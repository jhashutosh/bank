<?
include "../config/config.php";
$id=$_REQUEST['id'];
//$menu=$_REQUEST['menu'];
$date=$_REQUEST["date"];
$sql_statement="select ccb_dp_dtls('$id','$date', 'x')";
$sql_statement.=";fetch all from x";

//echo $$sql_statement;
//$sql_statement.="select * from provissional_interest";

$result=dBConnect($sql_statement);
$color==$TCOLOR;
echo $sql_statement;
echo "<HTML>";
echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo"<body bgcolor='black'>";
echo"<table align=center width='60%'>";
echo "<tr><b><td bgcolor=\"pink\" colspan=\"12\" align=\"center\" ><font color=\"red\" size='3'>Deposit Type : $id</font>";
echo"<tr><b><th rowspan=1 bgcolor=\"green\">Serial No.</th><th rowspan=1 bgcolor=\"green\">Account No.</th><th rowspan=1 bgcolor=\"green\">Opening Balance</th><th rowspan=1 bgcolor=\"green\">Deposit</th><th rowspan=1 bgcolor=\"green\">Withdrawal</th><th rowspan=1 bgcolor=\"green\">Int.Received</th><th rowspan=1 bgcolor=\"green\">Charges</th><th rowspan=1 bgcolor=\"green\">Closing Balance</th><th rowspan=1 bgcolor=\"green\">Int.Receivable</th></tr>";
for($j=0; $j<pg_NumRows($result); $j++) {
echo "<tr>";
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
echo"<td size=1 bgcolor='$color' align=right>".$row['SRL']."</td><td size=1 bgcolor='$color' align=right><a href=\"../bankbooks/ccb_dep_acc_dtl.php?&date=$date&id=".$row['ACCOUNT NO.']."\" target=\"_blank\">".$row['ACCOUNT NO.']."</td><td bgcolor='$color' size=1 align=right>".$row['OP. BALANCE']."</td><td size=1 bgcolor='$color' align=right>".$row['DEPOSIT']."</td><td bgcolor='$color' size=1 align=right>".$row['WITHDRAWAL']."</td><td size=1 bgcolor='$color' align=right>".$row['INT. RECEIVED']."</td><td bgcolor='$color' size=1 align=right>".$row['CHARGES']."</td><td size=1 bgcolor='$color' align=right>".$row['CL. BALANCE']."</td><td bgcolor='$color' size=1 align=right>".$row['INT. RECEIVABLE']."</td></tr>";
}
$sql_statement.=";close e";
//$result=dBConnect($sql_statement);
echo"</table></body></html>";

?>
