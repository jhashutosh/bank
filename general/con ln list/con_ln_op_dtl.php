<?
include "../config/config.php";
$months=$_REQUEST['months'];
$sql_statement="select con_loan_due_all('$months', 'x')";
$sql_statement.=";fetch all from x";
$result=dBConnect($sql_statement);
//echo $sql_statement;
$color==$TCOLOR;
echo "<HTML>";
echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo"<body>";
echo"<table width='100%'>";
echo"<tr><td size=1 bgcolor=green> </td><td size=1 bgcolor=green>Serial No.</td><td bgcolor=green size=1>Customer ID.</td><td bgcolor=green size=1>Membership No.</td><td size=1 bgcolor=green>Loan A/C No</td><td bgcolor=green size=1>Name</td><td bgcolor=green size=1>Loan Issued</td><td bgcolor=green size=1>Loan Repaid</td><td bgcolor=green size=1>Loan Due</td></tr>";
for($j=0; $j<pg_NumRows($result); $j++) {
echo "<tr>";
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
echo"<td size=1 bgcolor='$color'>".$row['TOTAL ']."</td><td size=1 bgcolor='$color'>".$row['SRL']."</td><td size=1 bgcolor='$color'>".$row['CUSTOMER ID']."</td><td bgcolor='$color' size=1>".$row['MEMBERSHIP NO.']."</td><td size=1 bgcolor='$color'>".$row['LOAN A/C NO.']."</td><td bgcolor='$color' size=1>".$row['NAME']."</td><td bgcolor='$color' size=1>".$row['LOAN ISSUED']."</td><td bgcolor='$color' size=1>".$row['LOAN REPAID']."</td><td bgcolor='$color' size=1>".$row['LOAN DUE']."</td></tr>";
}
$sql_statement.=";close e";
//$result=dBConnect($sql_statement);
echo"</table></body></html>";

?>
