<?php
include "../config/config.php";
$staff_id=verifyAutho();
$op=$_REQUEST['member_id'];
$menu=$_REQUEST['member_id'];
$c_id=$_REQUEST['customer_id'];
$loan_sl_no=$_REQUEST['loan_serial_no'];
if(empty($op)){
	$account_no=$_SESSION['member_id'];
	isPermissible($menu);
}
else{
	$account_no=$_REQUEST['member_id'];
	$loan_sl_no=$_REQUEST['loan_serial_no'];
}
echo "<html>";
echo "<head>";
echo "<script language=\"JAVASCRIPT\">";
echo "function closeme() { close(); }";
echo "</script>";
echo "<title>Statement";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
//echo "<center><h1>Account Statement [$account_no]</center>";

//echo "</h1><hr>";



$sql_statement="SELECT * from customer_master cm,shg_loan_ledger_hrd lh where customer_id='$account_no' and cm.customer_id=lh.member_id and loan_sl_no=$loan_sl_no";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<center><h2>No Repament</h2></center>";
} else {

echo "<table valign=\"top\" width=\"100%\" align=center>";

echo "<tr><td bgcolor=\"pink\" colspan=\"7\" align=\"center\"><b><font color=\"black\" size=5>Individual Details Loan Information</b></font>";
$COLOR=$TCOLOR;
echo "<tr bgcolor=$COLOR>";
echo "<th bgcolor=\"yellow\" colspan=\"1\">Account No";
echo "<th bgcolor=\"yellow\" colspan=\"1\">Name";
echo "<th bgcolor=\"yellow\" colspan=\"1\">Father's Name";
echo "<th bgcolor=\"yellow\" colspan=\"1\">Address";
echo "<th bgcolor=\"yellow\" colspan=\"1\">Due Int Rate";
echo "<th bgcolor=\"yellow\" colspan=\"1\">Overdue Int Rate";
echo "<th bgcolor=\"yellow\" colspan=\"1\">Repayment Date";
$color=$TCOLOR;
for($j=0; $j<pg_NumRows($result); $j++) {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
echo "<tr>";

if($j==0){
	$ocrop=trim($row['loan_serial_no']);
	
}
if($ocrop!=trim($row['loan_serial_no'])){
	echo "<tr><td colspan=13 bgcolor=\"YELLOW\"></td></tr>";
	$ocrop=trim($row['loan_serial_no']);
	//echo "<h1>$ocrop</h1>";
}

echo "<td align=right bgcolor=orange><a href =\"../general/voucherdetails.php?tran_id=".$row['tran_id']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=700,height=500'); return false;\" >".$row['member_id']."</td>";
echo "<td align=right bgcolor=orange>".$row['name1']."</td>";
echo "<td align=right bgcolor=orange>".$row['father_name1']."</td>";
echo "<td align=right bgcolor=orange>".$row['address11']."</td>";
echo "<td align=right bgcolor=orange>".$row['d_int_r']."</td>";
echo "<td align=right bgcolor=orange>".$row['od_int_r']."</td>";
echo "<td align=right bgcolor=orange>".$row['repay_date']."</td>";
	}
}
echo"</table>";
echo "<hr>";
$sql_statement="SELECT * FROM shg_loan_ledger_dtl where loan_sl_no=$loan_sl_no and member_id='$account_no' AND action_date<=current_date ORDER BY entry_time DESC";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<center><h2>No Repament</h2></center>";
} else {

echo "<table valign=\"top\" width=\"100%\" align=center>";

echo "<tr><td bgcolor=\"#8A2BE2\" colspan=\"11\" align=\"center\"><b><font color=\"WHITE\">Loan Details of Account No.: [<b>$account_no</b>]</font>";
$COLOR=$TCOLOR;
echo "<tr bgcolor=$COLOR>";
echo "<th bgcolor=\"#8AABEC\" rowspan=\"2\">Tran Id";
echo "<th bgcolor=\"#8AABEC\" rowspan=\"2\">Action Date";

echo "<th bgcolor=\"#8AABEC\" rowspan=\"2\">Issue(Rs.)";
echo "<th bgcolor=\"#8AABEC\" colspan=\"3\">Recovery(Rs.)";
echo "<th bgcolor=\"#8AABEC\" colspan=\"3\">Balance(Rs.)";

echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"#8AABEC\">principal";
echo "<th colspan=\"1\" bgcolor=\"#8AABEC\">Interest";
echo "<th colspan=\"1\" bgcolor=\"#8AABEC\">Overdue";

echo "<th colspan=\"1\" bgcolor=\"#8AABEC\">principal";
echo "<th colspan=\"1\" bgcolor=\"#8AABEC\">Interest";
echo "<th colspan=\"1\" bgcolor=\"#8AABEC\">Overdue";


$color=$TCOLOR;
for($j=0; $j<pg_NumRows($result); $j++) {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
echo "<tr>";

if($j==0){
	$ocrop=trim($row['loan_serial_no']);
	//echo "<h1>$ocrop</h1>";
}
if($ocrop!=trim($row['loan_serial_no'])){
	echo "<tr><td colspan=13 bgcolor=\"YELLOW\"></td></tr>";
	$ocrop=trim($row['loan_serial_no']);
	//echo "<h1>$ocrop</h1>";
}

echo "<td align=right bgcolor=$color><a href =\"../general/voucherdetails.php?tran_id=".$row['tran_id']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=700,height=500'); return false;\" >".$row['tran_id']."</td>";
echo "<td align=right bgcolor=$color>".$row['action_date']."</td>";
echo "<td align=right bgcolor=$color>".(float)$row['loan_amount']."</td>";
echo "<td align=right bgcolor=$color>".$row['r_principal']."</td>";
echo "<td align=right bgcolor=$color>".$row['r_d_int']."</td>";
echo "<td align=right bgcolor=$color>".$row['r_od_int']."</td>";

echo "<td align=right bgcolor=$color>".(float)$row['b_principal']."</td>";
echo "<td align=right bgcolor=$color>".$row['b_due_int']."</td>";
echo "<td align=right bgcolor=$color>".$row['b_overdue_int']."</td>";

	}
}
echo"</table>";

if(!empty($op)){
echo "<center><DIV ID=\"date_time\" style=\"position:relative; left:5; top:5\">";
echo "<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> </DIV></center> ";
}
echo "</body>";
echo "</html>";
?>
