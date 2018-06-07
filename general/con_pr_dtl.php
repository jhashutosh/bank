<?php
include "../config/config.php";
$months=$_REQUEST['months'];
$current_date=$_REQUEST["current_date"];
$menu=$_REQUEST['menu'];
if($menu=='all'){
$sql_statement="select con_loan_pr_int_all('$months', '$current_date', 'x')";}
else 
{$sql_statement="select con_loan_pr_int_typ('$menu','$months', '$current_date', 'x')";}

$sql_statement.=";fetch all from x";
$result=dBConnect($sql_statement);
//echo $sql_statement;
$color==$TCOLOR;
echo "<HTML>";
echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo"<body bgcolor='silver'>";
echo"<h3><center>Yearly Report For Repayment(Principal+Due Int.+Overdue Int.) for  <font color='darkblue'><b>".$loan_type_array[$menu]."</font> on $months<b></font></h3><br>";
echo"<table width='100%'  bgcolor='black'>";
echo"<tr><td size=1 bgcolor=green>Serial No.</td><td bgcolor=green size=1>Customer ID.</td><td bgcolor=green size=1>Membership No.</td><td size=1 bgcolor=green>Loan A/C No</td><td bgcolor=green size=1>Name</td><td bgcolor=green size=1>Principal</td><td bgcolor=green size=1>Due Interest</td><td bgcolor=green size=1>Overdue Interest</td>
<td bgcolor=green size=1>Total Repaid</td></tr>";
for($j=0; $j<pg_NumRows($result); $j++) {
echo "<tr>";
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
if($j==pg_NumRows($result)-1){
$color="#FFDEAD";
echo"<td size=1 bgcolor='$color'>".$row[' ']."</td><td size=1 bgcolor='$color'>".$row['CST. ID']."</td><td bgcolor='$color' size=1>".$row['MEM. NO.']."</td><td size=1 bgcolor='$color'>".$row['LOAN A/C NO.']."</td><td bgcolor='$color' size=1>".$row['NAME']."</td><td bgcolor='$color' size=1>".$row['PRINCIPAL']."</td><td bgcolor='$color' size=1>".$row['DUE INTEREST']."</td><td bgcolor='$color' size=1>".$row['OD. INTEREST']."</td><td bgcolor='$color' size=1>".$row['TOTAL REPAID']."</td></tr>";
}
else{
echo"<td size=1 bgcolor='$color'>".$row['SRL']."</td><td size=1 bgcolor='$color'>".$row['CST. ID']."</td><td bgcolor='$color' size=1>".$row['MEM. NO.']."</td><td size=1 bgcolor='$color'>".$row['LOAN A/C NO.']."</td><td bgcolor='$color' size=1>".$row['NAME']."</td><td bgcolor='$color' size=1>".$row['PRINCIPAL']."</td><td bgcolor='$color' size=1>".$row['DUE INTEREST']."</td><td bgcolor='$color' size=1>".$row['OD. INTEREST']."</td><td bgcolor='$color' size=1>".$row['TOTAL REPAID']."</td></tr>";}
}
$sql_statement.=";close e";
//$result=dBConnect($sql_statement);
echo"</table></body></html>";

?>
