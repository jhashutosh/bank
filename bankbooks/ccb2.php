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
echo"<body bgcolor='silver'>";

echo"<table align=center width='90%' bgcolor='black'>";
echo "<tr><b><td bgcolor=\"#0489B1\" colspan=\"12\" align=\"center\" ><font color=\"white\" size='3'>DEPOSIT PART</font>";
echo"<tr><th rowspan=1 bgcolor=\"lightgreen\">Serial No.</th><th rowspan=1 bgcolor=\"lightgreen\">Type of A/C</th><th rowspan=1 bgcolor=\"lightgreen\">No of A/C</th><th rowspan=1 bgcolor=\"lightgreen\">Deposit Balance</th><th rowspan=1 bgcolor=\"lightgreen\">Int. Receivable</th></tr>";
$tot_receive=0;
for($j=0; $j<pg_NumRows($result); $j++) {
//echo "<tr>";
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
if ($j==pg_NumRows($result)-1){
//echo $j;
$color='#839EB8';
echo"<tr><td size=1 align=center bgcolor='$color' colspan='2'><b>".$row['A/C TYPE']."</td><td bgcolor='$color' size=1 align=right><b>".$row['NO. OF A/CS']."</td><td size=1 align=right bgcolor='$color'><b>".amount2Rs($row['DEPOSIT BALANCE'])."</td><td bgcolor='$color' size=1 align=right><b>".amount2Rs($tot_receive)."</td></tr>";
}
else{
//echo $j;
$tot_receive+=$row['INT. RECEIVABLE'];
echo"<tr><td size=1 align=right bgcolor='$color'>".$row['SRL']."</td><td size=1 align=left bgcolor='$color'><a href=\"../bankbooks/ccb_dep_dtl.php?&date=$date&id=".$row['A/C TYPE']."\" target=\"_blank\">".$row['A/C TYPE']."</td><td bgcolor='$color' size=1 align=right>".$row['NO. OF A/CS']."</td><td size=1 align=right bgcolor='$color'>".amount2Rs($row['DEPOSIT BALANCE'])."</td><td bgcolor='$color' size=1 align=right>".amount2Rs($row['INT. RECEIVABLE'])."</td></tr>";

}
}
/*$sql_statement.=";close x";
$result=dBConnect($sql_statement);
echo"</table>";
echo"<br>";
$sql_statement1="select ccb_ln('$date', 'y')";
$sql_statement1.=";fetch all from y";
$result1=dBConnect($sql_statement1);
//echo $sql_statement1;
echo"<table align=center width='90%' bgcolor='black'>";
echo "<tr><td bgcolor=\"#0489B1\" colspan=\"5\" align=\"center\" ><font color=\"white\" size='3'>LOAN PART</font>";
echo"<tr><th rowspan=1 bgcolor=\"lightgreen\">Serial No.</th>
<th rowspan=1 bgcolor=\"lightgreen\">Type of A/C</th>
<th rowspan=1 bgcolor=\"lightgreen\">No of A/C</th>
<th rowspan=1 bgcolor=\"lightgreen\">Loan Balance</th>
<th rowspan=1 bgcolor=\"lightgreen\">Int. Payable</th></tr>";
//echo pg_NumRows($result1);
for($j=0; $j<pg_NumRows($result1); $j++) {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result1,$j);

echo"<tr><td size=1 bgcolor='$color' align=right>".$row['SRL']."</td>
<td size=1 bgcolor='$color' align=left><a href=\"../bankbooks/ccb_ln_dtl.php?&date=$date&id=".$row['loan_type']."\" target=\"_blank\">".$row['A/C TYPE']."</td>
<td bgcolor='$color' size=1 align=right>".$row['NO. OF ACCOUNTS']."</td>";
$no_ac=$no_ac+$row['NO. OF ACCOUNTS'];
echo"<td size=1 bgcolor='$color' align=right>".amount2Rs($row['TOTAL LOAN OUTSTANDING'])."</td>";
$ln_os=$ln_os+$row['TOTAL LOAN OUTSTANDING'];
echo"
<td bgcolor='$color' size=1 align=right>".amount2Rs($row['INT. RECEIVABLE'])."</td></tr>";
$in_rc=$in_rc+$row['INT. RECEIVABLE'];
				
}
$sql_statement1.=";close y";
$result1=dBConnect($sql_statement1);
$color='#839EB8';
echo"<tr><td size=1 bgcolor='$color' align=center colspan='2'><b>Total !!</td><td bgcolor='$color' size=1 align=right><b>".amount2Rs($no_ac)."</td><td size=1 bgcolor='$color' align=right><b>".amount2Rs($ln_os)."</td><td bgcolor='$color' size=1 align=right><b>".amount2Rs($in_rc)."</td></tr>";

echo"</table>";*/

/*$sql_statement2="select ccb_dep_ln_tot('$date', 'z')";
$sql_statement2.=";fetch all from z";
//echo $sql_statement2;
$result2=dBConnect($sql_statement2);
echo"<br>";
echo"<table align=center width='90%' bgcolor='black'>";
echo "<tr><td bgcolor=\"#0489B1\" colspan=\"12\" align=\"center\" ><font color=\"white\" size='3'>SUMMARY</font>";
echo"<tr><th rowspan=1 bgcolor=\"lightgreen\">Total Deposit</th><th rowspan=1 bgcolor=\"lightgreen\">Total Receivable</th><th rowspan=1 bgcolor=\"lightgreen\">Total Outstanding</th><th rowspan=1 bgcolor=\"lightgreen\">Total Payable</th></tr>";
for($j=0; $j<pg_NumRows($result2); $j++) {
echo "<tr>";
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result2,$j);
echo"<td bgcolor='$color' size=1 align=right>".$row[0]."</td><td size=1 bgcolor='$color' align=right>".$tot_receive."</td><td bgcolor='$color' size=1 align=right>".$row['x3']."</td><td bgcolor='$color' size=1 align=right>".amount2Rs($in_rc)."</td></tr>";
}
$sql_statement2.=";close z";

$result2=dBConnect($sql_statement2);*/
echo"</table></body></html>";

?>
