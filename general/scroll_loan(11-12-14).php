<?
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$current_date=$_REQUEST["current_date"];
if(empty($current_date) ) { $current_date=date("d/m/Y"); }
if($menu=='pl'){$name='Pledge Loan';$span=9;$WHERE_CONDITION="WHERE type='$menu' AND";}
if($menu=='kcc'){ $name='KCC Loan';$span=10; $WHERE_CONDITION="WHERE type='$menu' AND";}
if($menu=='kpl'){ $name='KVP Loan';$span=9; $WHERE_CONDITION="WHERE type='$menu' AND";}
if($menu=='bdl'){ $name='Bond Loan'; $span=10; $WHERE_CONDITION="WHERE type='$menu' AND";}
if($menu=='spl'){ $name='SMP Loan'; $span=10; $WHERE_CONDITION="WHERE type='$menu' AND";}
if($menu=='ccl'){$name='Cash Credit Loan';$span=9;$WHERE_CONDITION="WHERE type='$menu' AND";}
if($menu=='sfl'){$name='Staff Loan';$span=9;$WHERE_CONDITION="WHERE type='$menu' AND";}
if($menu=='sgl'){$name='SHG Loan';$span=9;$WHERE_CONDITION="WHERE type='$menu' AND";}
if($menu=='all'){$name='All Deposits';$span=9; $WHERE_CONDITION="WHERE";}
$print_time=getPrintTime();
echo "<html>";
echo "<head>";
echo "<title>$PROJECT_TITLE</title>";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "<script language=\"JAVASCRIPT\">";
echo "function closeme() { close(); }";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"\" onload=\"cd.focus();\">";
echo "<font size=+2>$SYSTEM_TITLE</font><br>";
echo "<i>Welcome to scrolling System of $name</i>";
echo "<hr>";
echo "<form name=\"f1\" action=\"scroll_loan.php?menu=$menu\" method=\"POST\">";
echo "<table align=center bgcolor=\"#90EE90\"><tr><td  align=\"\"><b>Scroll Date as on :<td><input type=TEXT size=12 name=current_date id=cd value=$current_date $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.current_date,'dd/mm/yyyy','Choose Date')\">";
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> ";
echo "</table></form>";
echo "<hr>";
$sql_statement="SELECT tran_id,account_no,particulars,action_date,type,gl_mas_code,dr_cr,amount,operator_code, substring(CAST(entry_time AS VARCHAR),12,8) as entry_time FROM loan_details_view $WHERE_CONDITION action_date='$current_date' order by type";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
echo "<table valign=\"top\" width=\"100%\">";
echo "<tr><td bgcolor=\"green\" colspan=\"$span\" align=\"center\">$name Scroll As On $current_date";
echo "<tr>";
$color="#FFDEAD";
echo "<th bgcolor=$color>Name</th>";
echo "<th bgcolor=$color>Entry time</th>";
echo "<th bgcolor=$color>Account No</th>";
echo "<th bgcolor=$color>Issue</th>";
echo "<th bgcolor=$color>Recovery</th>";
echo "<th bgcolor=$color>Balance</th>";
echo "<th bgcolor=$color>Status</th>";
//echo "<th bgcolor=$color>Customer Id</th>";
echo "<th bgcolor=$color>Transction Id</th>";
echo "<th bgcolor=$color>Operator code</th>";

$color=$TSCOLOR;
for($j=0; $j<pg_NumRows($result); $j++) {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
echo "<tr>";
$c_id=$id=getCustomerId($row['account_no'],$row['type']);
echo "<td bgcolor=$color >".getName('customer_id',$c_id,'name1','customer_master')."</td>";
echo "<td bgcolor=$color >".$row['entry_time']."</td>";
echo "<td bgcolor=$color >".$row['account_no']."[".$row['particulars']."]</td>";
$m_id=getMemberId($c_id);
if(!empty($m_id)){
$status='Member';
}
else{
$status='Nonmember';
}
if(trim($row['dr_cr'])=='Cr'){
       $deposits=(float)$row['amount'];
       $withdrawals=0;
}
else {
       $deposits=0;
       $withdrawals=(float)$row['amount'];
}
echo "<td bgcolor=$color align=RIGHT>".amount2Rs($withdrawals)."</td>";
echo "<td bgcolor=$color align=RIGHT>".amount2Rs($deposits)."</td>";


$current_balance=total_loan_current_balance($row['account_no'],$current_date);;
$total_deposit+=$deposits;
$total_withdrawal+=$withdrawals;
$total_current_blalnce+=$current_balance;
echo "<td bgcolor=$color align=RIGHT>".amount2Rs($current_balance)."</td>";
echo "<td bgcolor=$color >$status</td>";
//echo "<td bgcolor=$color >".$c_id."</td>";
echo "<td align=right bgcolor=$color><a href =\"../general/voucherdetails.php?tran_id=".$row['tran_id']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=700,height=500'); return false;\" >".$row['tran_id']."</a></td>";
echo "<td bgcolor=$color >".$row['operator_code']."</td>";
}
$color="#BA55D3";
echo "<tr><td colspan=3 bgcolor=$color align=center><b>Total :$j Records enter on this date !!!!</b>";
echo "<td bgcolor=$color align=RIGHT><b>".amount2Rs($total_withdrawal)."</td>";
echo "<td bgcolor=$color align=RIGHT><b>".amount2Rs($total_deposit)."</td>";
echo "<td bgcolor=$color align=RIGHT><b>".amount2Rs($total_current_blalnce)."</td>";
echo "<td bgcolor=$color align=RIGHT>";
echo "<td bgcolor=$color align=RIGHT>";
echo "<td bgcolor=$color align=RIGHT>";
//echo "<td bgcolor=$color align=RIGHT>";

echo "</table>";

}
?>
