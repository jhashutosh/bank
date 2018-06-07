<?
include "../config/config.php";
$id=$_REQUEST['id'];
//$menu=$_REQUEST['menu'];
$date=$_REQUEST["date"];
$sql_statement="select ccb_ln_dtls_fnl(lower('$id'),'$date', 'x')";
$sql_statement.=";fetch all from x";
$result=dBConnect($sql_statement);
$color==$TCOLOR;
//echo $sql_statement;
echo "<HTML>";
echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
//echo"<body bgcolor='#A52A2A'>";
echo"<body bgcolor='#F9B4BE'>";
echo"<br><br>";
echo"<table align=center width='80%' bgcolor='black'>";
echo "<tr><b><td bgcolor=\"silver\" colspan=\"10\" align=\"center\" ><font color=\"darkblue\" size='3'><b>Loan Type : ".substr(strtoupper($id),1)."</b></font>";

echo"<tr><b><th rowspan=2 bgcolor=\"green\">Serial No.</th><th rowspan=2 bgcolor=\"green\">Account No.</th><th rowspan=2 bgcolor=\"green\">Bank/Branch</th><th rowspan=2 bgcolor=\"green\">Loan Issued</th><th rowspan=1 bgcolor=\"green\" colspan='3'>Repaid</th><th rowspan=1 bgcolor=\"green\"  colspan='3'>Balance</th></tr>";
echo"<tr bgcolor=\"green\"><td align='center'>Principal</td><td align='center'>Due Int</td><td align='center'>Overdue Int</td><td align='center'>Principal</td><td align='center'>Due Int</td><td align='center'>Overdue Int</td></tr>";
if (pg_NumRows($result)>0){
	for($j=0; $j<pg_NumRows($result); $j++) {
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);

	$color='#839EB8';
	echo"<tr BGCOLOR='#839EB8'><td size=1 bgcolor='$color' align=center colspan='1' ><b>".($j+1)."<td size=1 bgcolor='$color' align=center colspan='1' ><b><a href=\"loan_statement.php?menu=".$row['account_sub_type']."&op=1&id=".$row['link_tb']."&account_no=".$row['account_no']."\" target=\"child\">".$row['account_no']."</a></td><td bgcolor='$color' size=1 align=right><b>".$row['bank_name']."</td><td bgcolor='$color' size=1 align=right><b>".$row['issue_amount']."</td><td size=1 bgcolor='$color' align=right><b>".$row['r_principal']."</td><td bgcolor='$color' size=1 align=right><b>".$row['r_due_int']."</td><td bgcolor='$color' size=1 align=right><b>".$row['r_overdue_int']."</td><td bgcolor='$color' size=1 align=right><b>".$row['bal_principal']."</td><td bgcolor='$color' size=1 align=right><b>".$row['bal_due_int']."</td><td bgcolor='$color' size=1 align=right><b>".$row['bal_overdue_int']."</td></tr>";
$lo_isu+=$row['issue_amount'];
$prin+=$row['r_principal'];
$r_due_int+=$row['r_due_int'];
$r_od_int+=$row['r_overdue_int'];
$b_prin+=$row['bal_principal'];
$b_due_int+=$row['bal_due_int'];
$b_od_int+=$row['bal_overdue_int'];
	}
echo "<tr bgcolor=\"AQUA\"><th colspan=\"2\">Total:  ".$j." Account Found!!!!!</th><th></th><th align=\"right\">$lo_isu </th><th align=\"right\">$prin</th><th align=\"right\">$r_due_int</th><th align=\"right\">".$r_od_int."</th><th align=\"right\">".$b_prin."</th><th align=\"right\">".$b_due_int."</th><th align=\"right\">".$b_od_int."</th>";

}
$sql_statement="close x";
$result=dBConnect($sql_statement);
echo"</table></body></html>";

?>
