<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];

//$current_date=$_REQUEST["current_date"];
//if(empty($current_date) ) { $current_date=date("d/m/Y"); }
if(isset($_REQUEST['starting_date']))
{
$starting_date=$_REQUEST["starting_date"];
}
else
{
$starting_date='';
}
if(isset($_REQUEST['ending_date']))
{
$ending_date=$_REQUEST["ending_date"];
}
else
{
$ending_date='';
}
$date1=date('l dS \of F Y h:i:s A');
if( empty($starting_date) ) { $starting_date=date("d/m/Y",time()-604600); }
if( empty($ending_date) ) { $ending_date=date("d/m/Y"); }

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
echo "<i>Welcome to scrolling System of $NAME</i>";
echo "<hr>";
echo "<form name=\"f1\" action=\"scroll_sh.php?menu=$menu\" method=\"POST\">";
echo "<table align=center bgcolor=\"#90EE90\"><tr><td  align=\"\"><b>Between Date:<input type=\"TEXT\" name=\"starting_date\" size=\"9\" value=\"$starting_date\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.starting_date,'dd/mm/yyyy','Choose Date')\" >";
echo " And <input type=\"TEXT\" name=\"ending_date\" size=\"9\" value=\"$ending_date\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.ending_date,'dd/mm/yyyy','Choose Date')\">";
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> ";
echo "</table></form>";
echo "<hr>";
$sql_statement="SELECT tran_id,account_no,action_date,type,gl_mas_code,dr_cr,qty,amount,operator_code,entry_time FROM share_detail_view WHERE action_date BETWEEN '$starting_date' AND '$ending_date' GROUP BY tran_id,account_no,action_date,type,gl_mas_code,dr_cr,qty,amount,operator_code,entry_time ORDER BY cast(substring(account_no,3) as int)";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
echo "<table valign=\"top\" width=\"100%\">";
echo "<tr><td bgcolor=\"#BA55D3\" colspan=\"12\" align=\"center\"><b>Share Scroll Between $starting_date And $ending_date";
echo "<tr>";
$color="#FFDEAD";
echo "<th bgcolor=$color rowspan=2>Member Id</th>";
echo "<th bgcolor=$color rowspan=2>Customer Id</th>";
echo "<th bgcolor=$color rowspan=2>Transction Id</th>";
echo "<th bgcolor=$color colspan=2>Deposits</th>";
echo "<th bgcolor=$color colspan=2>Withdrawals</th>";
echo "<th bgcolor=$color colspan=2>Balance</th>";
echo "<th bgcolor=$color rowspan=2>Operator code</th>";
echo "<th bgcolor=$color rowspan=2>Entry time</th><tr>";
echo "<th bgcolor=$color>No.";
echo "<th bgcolor=$color>Value";
echo "<th bgcolor=$color>No.";
echo "<th bgcolor=$color>Value";
echo "<th bgcolor=$color>No.";
echo "<th bgcolor=$color>Value";
$color=$TSCOLOR;
for($j=0; $j<pg_NumRows($result); $j++) {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
echo "<tr>";
echo "<td bgcolor=$color >".$row['account_no']."</td>";
$c_id=$id=getCustomerIdFromMember($row['account_no']);
echo "<td bgcolor=$color >".$c_id."</td>";
//echo "<td bgcolor=$color >$status</td>";
if(trim($row['dr_cr'])=='Cr'){
       $deposits=(float)$row['amount'];
	$d_no=(float)$row['qty'];
       $withdrawals=0;
	$w_no=0;
}
else {
       $deposits=0;
	$d_no=0;
       $withdrawals=(float)$row['amount'];
     	$w_no=(float)$row['qty'];
}
echo "<td bgcolor=$color >".$row['tran_id']."</td>";
echo "<td bgcolor=$color align=RIGHT>$d_no</td>";
echo "<td bgcolor=$color align=RIGHT>$deposits</td>";
echo "<td bgcolor=$color align=RIGHT>$w_no</td>";
echo "<td bgcolor=$color align=RIGHT>$withdrawals</td>";
share_current_balance($row['account_no'],$c_no,$c_val,$current_date);
echo "<td bgcolor=$color align=RIGHT>$c_no</td>";
echo "<td bgcolor=$color align=RIGHT>$c_val</td>";
$total_deposit+=$deposits;
$t_d_no+=$d_no;
$total_withdrawal+=$withdrawals;
$t_w_no+=$w_no;
//$total_current_blalnce+=$c_val;
$t_c_no+=$c_no;
//echo "<td bgcolor=$color align=RIGHT>".$current_balance."</td>";
echo "<td bgcolor=$color >".$row['operator_code']."</td>";
echo "<td bgcolor=$color >".$row['entry_time']."</td>";

}
$color="#BA55D3";
echo "<tr><td colspan=3 bgcolor=$color align=center><b>Total :$j Records enter on this date !!!!</b>";
echo "<td bgcolor=$color align=RIGHT><b>$t_d_no</td>";
echo "<td bgcolor=$color align=RIGHT><b>$total_deposit</td>";
echo "<td bgcolor=$color align=RIGHT><b>$t_w_no</td>";
echo "<td bgcolor=$color align=RIGHT><b>$total_withdrawal</td>";
echo "<td bgcolor=$color align=RIGHT><b>".($t_d_no-$t_w_no)."</td>";
echo "<td bgcolor=$color align=RIGHT><b>".($total_deposit-$total_withdrawal)."</td>";
echo "<td bgcolor=$color align=RIGHT>";
echo "<td bgcolor=$color align=RIGHT>";

echo "</table>";

}
?>
