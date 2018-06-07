<?php
include "../config/config.php";
$staff_id=verifyAutho();
if(empty($op)){
	$account_no=$_SESSION["current_account_no"];
	isPermissible($menu);
}
else{
	$account_no=$_REQUEST["account_no"];
}
$menu=$_REQUEST['menu'];
echo "<html>";
echo "<head>";
echo "<title>Loan account statement";
echo "</title>";
echo "<script language=\"JAVASCRIPT\">";
echo "function closeme() { close(); }";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<h3>Account Statement [$account_no]";
echo "</h3><hr>";
$id=getCustomerId($account_no,$menu);
$flag=getGeneralInfo_Customer($id);
if($flag==1){
$sql_statement="SELECT * FROM  loan_statement where account_no='$account_no' AND action_date<=current_date ORDER BY entry_time DESC";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4>Not found!!!</h4>";
} else {
$balance=total_loan_current_balance($account_no,$action_date);
echo "<table valign=\"top\" width=\"100%\" align=center>";
echo "<tr><td bgcolor=\"green\" colspan=\"13\" align=\"center\"><font color=\"white\">Statement</font><font color=BLACK size=+1><b>[Current Balance:Rs.".$balance."]</b></font>";
//echo "<tr><td bgcolor=\"GREEN\" colspan=\"11\" align=\"center\"><b><font color=\"WHITE\">Loan Details of Account No.: [<b>$account_no</b>]</font>";
$COLOR=$TCOLOR;
echo "<tr bgcolor=$COLOR>";
echo "<th rowspan=\"2\">Tran Id";
echo "<th rowspan=\"2\">Action Date";
//echo "<th rowspan=\"2\">Particulars";
echo "<th rowspan=\"2\">Issue(Rs.)";
echo "<th colspan=\"3\">Recovery(Rs.)";
echo "<th colspan=\"3\">Balance(Rs.)";
echo "<th Rowspan=\"2\">Operator code</th>";
echo "<th Rowspan=\"2\">Entry time</th>";
echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$COLOR\">principal";
echo "<th colspan=\"1\" bgcolor=\"$COLOR\">Interest";
echo "<th colspan=\"1\" bgcolor=\"$COLOR\">Overdue";
//echo "<th colspan=\"1\" bgcolor=\"#9ACD32\">Total";
echo "<th colspan=\"1\" bgcolor=\"$COLOR\">principal";
echo "<th colspan=\"1\" bgcolor=\"$COLOR\">Interest";
echo "<th colspan=\"1\" bgcolor=\"$COLOR\">Overdue";
//echo "<th colspan=\"1\" bgcolor=\"#808000\">Total";
$color=$TCOLOR;
for($j=0; $j<pg_NumRows($result); $j++) {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
echo "<tr>";
$loan_sl_no=$row['loan_serial_no'];
echo "<td align=right bgcolor=$color>".$row['tran_id']."</td>";
echo "<td align=right bgcolor=$color>".$row['action_date']."</td>";
echo "<td align=right bgcolor=$color>".(float)$row['loan_amount']."</td>";
echo "<td align=right bgcolor=$color>".$row['r_principal']."</td>";
echo "<td align=right bgcolor=$color>".$row['r_due_int']."</td>";
echo "<td align=right bgcolor=$color>".$row['r_overdue_int']."</td>";
//$r_total=$row['r_principal']+$row['r_due_int']+$row['r_overdue_int'];
//echo "<td align=right bgcolor=$color>".$r_total."</td>";
echo "<td align=right bgcolor=$color>".(float)$row['b_principal']."</td>";
echo "<td align=right bgcolor=$color>".$row['b_due_int']."</td>";
echo "<td align=right bgcolor=$color>".$row['b_overdue_int']."</td>";
//$b_total=$row['b_principal']+$row['b_due_int']+$row['b_overdue_int'];
//echo "<td align=right bgcolor=$color>".$b_total."</td>";
echo "<td align=right bgcolor=$color>".$row['staff_id']."</td>";
echo "<td align=right bgcolor=$color>".$row['entry_time']."</td>";
	}
}
echo"</table>";
//echo "<hr>";
$sql_statement="SELECT * FROM shg_loan_ledger_hrd WHERE account_no='$account_no' AND status='op'";
//echo $sql_statement;
$COLOR="GREEN";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4>Not found!!!</h4>";
} else {
echo "<table valign=\"top\" width=\"100%\" align=center>";
echo "<tr><td bgcolor=\"#8A2BE2\" colspan=\"13\" align=\"center\"><font color=\"white\">Membership Statement</font><tr bgcolor=\"$COLOR\">";
echo "<th rowspan=\"2\">Serial No.";
echo "<th rowspan=\"2\">Name";
echo "<th rowspan=\"2\">Last Action Date";
echo "<th rowspan=\"2\">Issue(Rs.)";
echo "<th colspan=\"3\">Recovery(Rs.)";
echo "<th colspan=\"3\">Balance(Rs.)";
echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$COLOR\">principal";
echo "<th colspan=\"1\" bgcolor=\"$COLOR\">Interest";
echo "<th colspan=\"1\" bgcolor=\"$COLOR\">Overdue";
echo "<th colspan=\"1\" bgcolor=\"$COLOR\">principal";
echo "<th colspan=\"1\" bgcolor=\"$COLOR\">Interest";
echo "<th colspan=\"1\" bgcolor=\"$COLOR\">Overdue";
$color=$TCOLOR;
for($j=0; $j<pg_NumRows($result); $j++) {
$row=pg_fetch_array($result,$j);
$sql_statement1="SELECT SUM(loan_amount) as l,SUM(r_principal) as p,SUM(r_d_int) as d,SUM(r_od_int) as o FROM shg_loan_ledger_dtl WHERE loan_sl_no='$loan_sl_no' AND member_id='".$row['member_id']."'";
//echo $sql_statement1;
$sql_statement2="SELECT * FROM shg_loan_ledger_dtl WHERE loan_sl_no='$loan_sl_no' AND member_id='".$row['member_id']."' ORDER BY entry_time DESC LIMIT 1";
//echo $sql_statement2;
$result1=dBConnect($sql_statement1);
$result2=dBConnect($sql_statement2);
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
echo "<tr>";
echo "<td align=center bgcolor=$color>".($j+1)."</td>";
echo "<td align=center bgcolor=$color><a href=\"../jlg/individual_statement.php?loan_serial_no='$loan_sl_no'&member_id=".$row['member_id']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes,top=100,left=150, width=1050,height=500'); return false;\">".getName('customer_id',trim($row['member_id']),'name1','customer_master')."</A></td>";
echo "<td align=center bgcolor=$color>".pg_result($result2,'action_date')."</td>";
echo "<td align=center bgcolor=$color>".pg_result($result1,'l')."</td>";
echo "<td align=center bgcolor=$color>".pg_result($result1,'p')."</td>";
echo "<td align=center bgcolor=$color>".pg_result($result1,'d')."</td>";
echo "<td align=center bgcolor=$color>".pg_result($result1,'o')."</td>";
echo "<td align=center bgcolor=$color>".pg_result($result2,'b_principal')."</td>";
echo "<td align=center bgcolor=$color>".pg_result($result2,'b_d_int')."</td>";
echo "<td align=center bgcolor=$color>".pg_result($result2,'b_od_int')."</td>";
}

}

}
echo "</table>";
if(!empty($op)){
echo "<center><DIV ID=\"date_time\" style=\"position:relative; left:5; top:25\">";
echo "<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\" $HIGHLIGHT> </DIV></center> ";
}
echo "</body>";
echo "</html>";
?>
