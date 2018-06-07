<?
include "../config/config.php";
$staff_id=verifyAutho();
$op=$_REQUEST['op'];
$menu=$_REQUEST['menu'];
$account_no=$_REQUEST["account_no"];
$id=$_REQUEST['id'];

echo "<html>";
echo "<head>";
echo "<script language=\"JAVASCRIPT\">";
echo "function closeme() { close(); }";
echo "</script>";
echo "<title>".getName('link_tb',$id,'b_name','bank_bk_dtl')." bank's ".strtoupper($menu)." Account[$account_no]</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
$title='Saving Bank';
echo "<h3>".strtoupper($menu)." Account Statement [$account_no]";
echo "</h3><hr>";
$flag=getBankInfo($id);
$sql_statement="SELECT * FROM  loan_statement where account_no='$account_no' ORDER BY loan_serial_no,entry_time DESC";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4>New Account</h4>";
} else {
echo "<table valign=\"top\" width=\"100%\">";
$balance=total_loan_current_balance($account_no,$action_date);
echo "<tr><td bgcolor=\"green\" colspan=\"13\" align=\"center\"><font color=\"white\">Statement</font><font color=BLACK size=+1><b>[Current Balance:Rs.".amount2Rs($balance)."]</b></font>";
// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color Rowspan=\"2\">Tran. Id</th>";
echo "<th bgcolor=$color Rowspan=\"2\">Date</th>";
//echo "<th bgcolor=$color Rowspan=\"2\">Particulars</th>";
//echo "<th bgcolor=$color Rowspan=\"2\">Crop</th>";
echo "<th bgcolor=$color Rowspan=\"2\">Issued<br>(Rs.)</th>";
echo "<th bgcolor=$color colspan=\"3\">Repayment(Rs.)</th>";
echo "<th bgcolor=$color colspan=\"3\">Balance(Rs.)</th>";
echo "<th bgcolor=$color Rowspan=\"2\">Operator code</th>";
echo "<th bgcolor=$color Rowspan=\"2\">Entry time</th>";
echo "<tr><th bgcolor=$color>Due</th>";
echo "<th bgcolor=$color>Overdue</th>";
echo "<th bgcolor=$color>Principal</th>";
echo "<th bgcolor=$color>Due</th>";
echo "<th bgcolor=$color>Overdue</th>";
echo "<th bgcolor=$color>Principal</th>";
for($j=1; $j<=pg_NumRows($result); $j++){
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j-1));
echo "<tr>";
if($j==1){
	$ocrop=trim($row['loan_serial_no']);
	//echo "<h1>$ocrop</h1>";
}
if($ocrop!=trim($row['loan_serial_no'])){
	echo "<tr><td colspan=13 bgcolor=\"YELLOW\"></td></tr>";
	$ocrop=trim($row['loan_serial_no']);
	//echo "<h1>$ocrop</h1>";
}
echo "<td align=right bgcolor=$color><a href =\"../general/voucherdetails.php?tran_id=".$row['tran_id']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=700,height=500'); return false;\" >".$row['tran_id']."</a></td>";
echo "<td align=right bgcolor=$color>".$row['action_date']."</td>";
//echo "<td align=right bgcolor=$color>".$row['particulars']."</td>";
echo "<td align=right bgcolor=$color>".amount2Rs((float)$row['loan_amount'])."</td>";
echo "<td align=right bgcolor=$color>".amount2Rs((float)$row['r_due_int'])."</td>";
echo "<td align=right bgcolor=$color>".amount2Rs((float)$row['r_overdue_int'])."</td>";
echo "<td align=right bgcolor=$color>".amount2Rs((float)$row['r_principal'])."</td>";
echo "<td align=right bgcolor=$color>".amount2Rs((float)$row['b_due_int'])."</td>";
echo "<td align=right bgcolor=$color>".amount2Rs((float)$row['b_overdue_int'])."</td>";
echo "<td align=right bgcolor=$color>".amount2Rs((float)$row['b_principal'])."</td>";
echo "<td align=right bgcolor=$color>".$row['staff_id']."</td>";
echo "<td align=right bgcolor=$color>".$row['entry_time']."</td>";
   }
echo "</table>";
 }

if(!empty($op)){
echo "<DIV ID=\"date_time\" style=\"position:relative; left:5; top:5\">";
echo "<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> </DIV> ";
}

echo "</body>";
echo "</html>";
?>
