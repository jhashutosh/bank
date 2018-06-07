<?php
include "../config/config.php";
$staff_id=verifyAutho();
$op=$_REQUEST['op'];
$menu=$_REQUEST['menu'];
if(empty($op)){
	$account_no=$_SESSION["current_account_no"];
	isPermissible($menu);
}
else{
	$account_no=$_REQUEST["account_no"];

}
echo "<html>";
echo "<head>";
echo "<title>Statement";
echo "</title>";
echo "<script language=\"JAVASCRIPT\">";
echo "function closeme() { close(); }";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<h3>Account Statement of MIS Deposit [$account_no]";
echo "</h3><hr>";
$id=getCustomerId($account_no,$menu);
$flag=getGeneralInfo_Customer($id);
if($flag==1){
echo "<hr>";
$sql_statement="SELECT * FROM customer_mis WHERE account_no='$account_no'";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4>Not found!!!</h4>";
} else {
echo "<table valign=\"top\" width=\"100%\">";
echo "<tr><td bgcolor=\"#228B22\" colspan=\"14\" align=\"center\"><font color=\"BLACK\"><b>Statement [$account_no] </font>";
// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color>Opening date</th>";
echo "<th bgcolor=$color>Scheme</th>";
echo "<th bgcolor=$color>Period</th>";
echo "<th bgcolor=$color>Principal</th>";
echo "<th bgcolor=$color>Rate of interest</th>";
echo "<th bgcolor=$color>Monthly interest</th>";
echo "<th bgcolor=$color>Maturity amount</th>";
echo "<th bgcolor=$color>Maturity date</th>";
echo "<th bgcolor=$color>Withdrawn type</th>";
echo "<th bgcolor=$color>Withdrawal date</th>";
echo "<th bgcolor=$color>Withdrawal amount</th>";
echo "<th bgcolor=$color>Operator code</th>";
echo "<th bgcolor=$color>Entry time</th>";
for($j=0;$j<pg_NumRows($result);$j++){
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
echo "<tr>";
if($row['opening_date']==$opening_date_DEFAULT){$row['opening_date']="";}
echo "<td align=right bgcolor=$color>".$row['action_date']."</td>";
echo "<td align=left bgcolor=$color>".$scheme_array[trim($row['scheme'])]."</td>";
if($row['period']==$period_DEFAULT){$row['period']="";}
echo "<td align=left bgcolor=$color>".$row['period']." Years</td>";
if($row['principal']==$amount_deposit_DEFAULT){$row['principal']="";}
echo "<td align=right bgcolor=$color>".$row['principal']."</td>";
if($row['interest_rate']==$rate_of_interest_DEFAULT){$row['interest_rate']="";}
echo "<td align=right bgcolor=$color>".$row['interest_rate']."%</td>";
echo "<td align=right bgcolor=$color>".sprintf("%-12.0f",((compute_mis($row['principal'],$row['interest_rate'],$row['period'])-$row['principal'])/(12*$row['period'])))."</td>";
if($row['maturity_amount']==$maturity_amount_DEFAULT){$row['maturity_amount']="";}
echo "<td align=right bgcolor=$color>".$row['maturity_amount']."</td>";
if($row['maturity_date']==$maturity_date_DEFAULT){$row['maturity_date']="";}
echo "<td align=right bgcolor=$color>".$row['maturity_date']."</td>";
if($row['withdrawn_type']==$withdrawn_type_DEFAULT){$row['withdrawn_type']="";}
echo "<td align=right bgcolor=$color>".$row['withdrawn_type']."</td>";
if($row['withdrawal_date']==$withdrawal_date_DEFAULT){$row['withdrawal_date']="";}
echo "<td align=right bgcolor=$color>".$row['withdrawal_date']."</td>";
if($row['withdrawal_amount']==$withdrawal_amount_DEFAULT){$row['withdrawal_amount']="";}
echo "<td align=right bgcolor=$color>".$row['withdrawal_amount']."</td>";
echo "<td align=right bgcolor=$color>".$row['operator_code']."</td>";
echo "<td align=right bgcolor=$color>".$row['entry_time']."</td>";
}
echo "</table>";
}
//---------------------------------------------------------------------------------------------

$sql_statement="SELECT * FROM mis_detail_view where account_no='$account_no' AND gl_mas_code LIKE '62%'and action_date<=current_date ORDER BY entry_time";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4>New Account</h4>";
} else {
echo "<table valign=\"top\" width=\"100%\">";
$balance=sb_current_balance($account_no);
echo "<tr><td bgcolor=\"#8A2BE2\" colspan=\"9\" align=\"center\"><font color=\"white\"><b>Detail Statement [$account_no]</font><font color=BLACK size=+1><b>[Current Balance:Rs.".$balance."]</b></font>";
// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color>Tranction Id</th>";
echo "<th bgcolor=$color>Date</th>";
echo "<th bgcolor=$color>Particulars</th>";
echo "<th bgcolor=$color>Withdrawals (Rs.)</th>";
//echo "<th bgcolor=$color>Deposits (Rs.)</th>";
echo "<th bgcolor=$color>Balance (Rs.)</th>";
echo "<th bgcolor=$color>Remarks</th>";
echo "<th bgcolor=$color>Operator code</th>";
echo "<th bgcolor=$color>Entry time</th>";
for($j=1; $j<=pg_NumRows($result); $j++){
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j-1));
echo "<tr>";
echo "<td align=right bgcolor=$color>".$row['tran_id']."</td>";
echo "<td align=right bgcolor=$color>".$row['action_date']."</td>";
echo "<td align=right bgcolor=$color>".$row['particulars']."</td>";

echo "<td align=right bgcolor=$color>".$row['amount']."</td>";
$Wbalance+=$row['amount'];
echo "<td align=right bgcolor=$color>".$Wbalance."</td>";

echo "<td align=right bgcolor=$color>".$row['remarks']."</td>";
echo "<td align=right bgcolor=$color>".$row['operator_code']."</td>";
echo "<td align=right bgcolor=$color>".$row['entry_time']."</td>";
//$balance=$balance+$withdrawals;
   }
echo "</table>";
 }
}
if(!empty($op)){
echo "<DIV ID=\"date_time\" style=\"position:relative; left:5; top:5\">";
echo "<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> </DIV> ";
}
echo "</body>";
echo "</html>";
?>
