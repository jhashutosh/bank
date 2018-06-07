<?
include "../config/config.php";
$id=$_REQUEST['id'];
//$menu=$_REQUEST['menu'];
$date=$_REQUEST["date"];
$sql_statement="select ccb_dep('$date', 'x')";
$sql_statement.=";fetch all from x";
$result=dBConnect($sql_statement);
$color==$TCOLOR;
//echo $sql_statement;
echo "<HTML>";
echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo"<body bgcolor='skyblue'>";
echo"<table align=middle width='70%'>";
echo "<tr><b><td bgcolor=\"pink\" colspan=\"12\" align=\"center\" ><font color=\"red\" size='3'>DEPOSIT PART</font>";
echo"<tr><th rowspan=1 bgcolor=\"green\">Serial No.</th><th rowspan=1 bgcolor=\"green\">Type of A/C</th><th rowspan=1 bgcolor=\"green\">No of A/C</th><th rowspan=1 bgcolor=\"green\">Deposit Balance</th><th rowspan=1 bgcolor=\"green\">Int. Receivable</th></tr>";
for($j=0; $j<pg_NumRows($result); $j++) {
echo "<tr>";
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
echo"<td size=1 align=right bgcolor='$color'>".$row['SRL']."</td><td size=1 align=left bgcolor='$color'><a href=\"../bankbooks/ccb_dep_dtl.php?&date=$date&id=".$row['A/C TYPE']."\" target=\"_blank\">".$row['A/C TYPE']."</td><td bgcolor='$color' size=1 align=right>".$row['NO. OF A/CS']."</td><td size=1 align=right bgcolor='$color'>".$row['DEPOSIT BALANCE']."</td><td bgcolor='$color' size=1 align=right>".$row['INT. RECEIVABLE']."</td></tr>";

}
//$sql_statement.=";close e";
//echo$sql_statement;
echo"</table>";
echo"<table align=middle width='70%' size=5>";
echo"</table>";
$sql_statement1="select ccb_ln('$date', 'y')";
$sql_statement1.=";fetch all from y";
$result1=dBConnect($sql_statement1);
//echo $sql_statement1;
echo"<table align=middle width='70%'>";
echo "<tr><td bgcolor=\"pink\" colspan=\"12\" align=\"center\" ><font color=\"red\" size='3'>LOAN PART</font>";
echo"<tr><th rowspan=1 bgcolor=\"green\">Serial No.</th><th rowspan=1 bgcolor=\"green\">Type of A/C</th><th rowspan=1 bgcolor=\"green\">No of A/C</th><th rowspan=1 bgcolor=\"green\">Loan Balance</th><th rowspan=1 bgcolor=\"green\">Int. Payable</th></tr>";
for($j=0; $j<pg_NumRows($result); $j++) {
echo "<tr>";
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result1,$j);
echo"<td size=1 bgcolor='$color' align=right>".$row['SRL']."</td><td size=1 bgcolor='$color' align=left><a href=\"../bankbooks/ccb_ln_dtl.php?&date=$date&id=".$row['A/C TYPE']."\" target=\"_blank\">".$row['A/C TYPE']."</td><td bgcolor='$color' size=1 align=right>".$row['NO. OF ACCOUNTS']."</td><td size=1 bgcolor='$color' align=right>".$row['TOTAL LOAN OUTSTANDING']."</td><td bgcolor='$color' size=1 align=right>".$row['INT. RECEIVABLE']."</td></tr>";
}
//$sql_statement1.=";close e";
//$result=dBConnect($sql_statement);
echo"</table>";
echo"<table align=middle width='70%' size=5>";
echo"</table>";
$sql_statement2="select ccb_dep_ln_tot('$date', 'z')";
$sql_statement2.=";fetch all from z";
//echo $sql_statement2;
$result2=dBConnect($sql_statement2);
echo"<table align=center width='70%'>";
echo "<tr><td bgcolor=\"pink\" colspan=\"12\" align=\"center\" ><font color=\"red\" size='3'>SUMMARY</font>";
echo"<tr><th rowspan=1 bgcolor=\"green\">Total Deposit</th><th rowspan=1 bgcolor=\"green\">Total Receivable</th><th rowspan=1 bgcolor=\"green\">Total Outstanding</th><th rowspan=1 bgcolor=\"green\">Total Payable</th></tr>";
for($j=0; $j<pg_NumRows($result2); $j++) {
echo "<tr>";
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result2,$j);
echo"<td bgcolor='$color' size=1 align=right>".$row[0]."</td><td size=1 bgcolor='$color' align=right>".$row[1]."</td><td bgcolor='$color' size=1 align=right>".$row['x3']."</td><td bgcolor='$color' size=1 align=right>".$row['x4']."</td></tr>";
}
//$sql_statement1.=";close e";
//$result=dBConnect($sql_statement);
echo"</table></body></html>";

?>
