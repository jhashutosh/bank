<?php
include "../config/config.php";
$menu=$_REQUEST['menu'];
$staff_id=verifyAutho();
$account_no=$_REQUEST["account_no"];
$id=$_REQUEST['id'];
echo "<HTML>";
echo "<HEAD>";
echo "<TITLE>Statement</TITLE>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script language=\"JAVASCRIPT\">";
echo "function closeme() { close(); }";
echo "</script>";
echo "</HEAD>";
echo "<BODY bgcolor=\"SILVER\">";
echo "<h3>".$type_of_account1_array[$menu]." Account Statement[$account_no]</h3>";
$flag=getBankInfo($id);
if($flag==1){
$sql_statement="SELECT * FROM ccb_sb_detail_view WHERE account_no='$account_no' AND action_date<=current_date ORDER BY entry_time DESC";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h1><center><font color=Green>New Account!!!!!</center></font></h1>";
} 
else {
echo "<table valign=\"top\" width=\"100%\">";
$balance=(float)ccb_deposits_current_balance($account_no);
echo "<tr><td bgcolor=\"BLUE\" colspan=\"9\" align=\"center\"><font color=\"white\">Statement</font><font size=+1 color=\"white\"><b>[Current Balance:Rs.".$balance."]</b></font>";
// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color width=\"100\">Transcation Id</th>";
echo "<th bgcolor=$color width=\"90\">Action Date</th>";
echo "<th bgcolor=$color  width=\"100\">Particulars</th>";
echo "<th bgcolor=$color width=\"75\">Deposit</th>";
echo "<th bgcolor=$color width=\"75\">Withdrawal</th>";
echo "<th bgcolor=$color width=\"75\">Balance</th>";
echo "<th bgcolor=$color width=\"75\">Remarks</th>";
echo "<th bgcolor=$color width=\"75\">Operator</th>";
echo "<th bgcolor=$color>Time</th>";
for($j=1; $j<=pg_NumRows($result); $j++){
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j-1));
echo "<tr>";
if(empty($row['cheque_no'])){$par=$row['particulars'];}
else{$par=$row['particulars']."[".$row['cheque_no']."]";}
echo "<td align=right bgcolor=$color  width=\"88\"><a href =\"../general/voucherdetails.php?tran_id=".$row['tran_id']."$t_id\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=700,height=500'); return false;\" >".$row['tran_id']."</a></td>";
echo "<td align=right bgcolor=$color  width=\"90\">".$row['action_date']."</td>";
echo "<td align=right bgcolor=$color width=\"100\">".$par."</td>";
echo "<td align=right bgcolor=$color width=\"75\">".amount2Rs($row['deposits'])."</td>";
echo "<td align=right bgcolor=$color width=\"75\">".amount2Rs($row['withdrawals'])."</td>";
echo "<td align=right bgcolor=$color width=\"75\">".amount2Rs($balance)."</td>";
echo "<td align=right bgcolor=$color width=\"75\">".$row['remarks']."</td>";
echo "<td align=right bgcolor=$color width=\"75\">".$row['operator_code']."</td>";
echo "<td align=right bgcolor=$color>".$row['entry_time']."</td>";
if ($row['deposits']== 0 && $row['withdrawals']> 0) $balance+=$row['withdrawals'];
if ($row['withdrawals']== 0 && $row['deposits']> 0) $balance-=$row['deposits'];
   }
	
echo "</table>";
 	}
}
else{
echo "Invalid Input !!!!!!!!!!!!!!";
}

if(!empty($op)){
echo "<DIV ID=\"date_time\" style=\"position:relative; left:5; top:5\">";
echo "<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> </DIV> ";
}
?>
