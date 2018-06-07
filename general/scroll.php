<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$current_date=$_REQUEST["current_date"];
if(empty($current_date) ) { $current_date=date("d/m/Y"); }
if($menu=='sb'){$myView='sb_detail_view';$name='Saving Deposits';$span=9;}
if($menu=='fd'){$myView='fd_detail_view'; $name='Fixed Deposits';$span=10;}
if($menu=='hsb'){$myView='hsb_detail_view'; $name='HSB Deposits';$span=10;}
if($menu=='rd'){$myView='rd_detail_view'; $name='Recurring Deposits';$span=9;}
if($menu=='ri'){$myView='ri_detail_view'; $name='Reinvestment Deposits'; $span=10;}
if($menu=='mis'){$myView='mis_detail_view';$name='MIS Deposits';$span=9;}
if($menu=='sh'){$myView='share_detail_view';$name='Share';$span=9;}
if($menu=='all'){$myView='deposit_detail_view';$name='All Deposits';$span=9;}
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
echo "<form name=\"f1\" action=\"scroll.php?menu=$menu\" method=\"POST\">";
echo "<table align=center bgcolor=\"#90EE90\"><tr><td  align=\"\"><b>Scroll Date as on :<td><input type=TEXT size=12 name=current_date id=cd value=$current_date $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.current_date,'dd/mm/yyyy','Choose Date')\">";
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> ";
echo "</table></form>";
echo "<hr>";
$sql_statement="SELECT tran_id,account_no,action_date,type,gl_mas_code,dr_cr,amount,operator_code, entry_time  as entry_time FROM $myView WHERE action_date='$current_date' order by type";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
echo "<table valign=\"top\" width=\"100%\">";
echo "<tr><td bgcolor=\"green\" colspan=\"$span\" align=\"center\">$name Scroll As On $current_date";
echo "<tr>";
$color="#FFDEAD";
//echo "<th bgcolor=$color>Name</th>";
echo "<th bgcolor=$color>Account No</th>";
//echo "<th bgcolor=$color>Customer Id</th>";
echo "<th bgcolor=$color>Status</th>";
echo "<th bgcolor=$color>Transction Id</th>";
echo "<th bgcolor=$color>Deposits</th>";
echo "<th bgcolor=$color>Withdrawals</th>";
echo "<th bgcolor=$color>Balance</th>";
echo "<th bgcolor=$color>Operator code</th>";
echo "<th bgcolor=$color>Entry time</th>";
$color="#DDFFAD";
$total_deposit=0;
$total_withdrawal=0;
$total_current_blalnce=0;
for($j=0; $j<pg_NumRows($result); $j++) {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
echo "<tr>";
$c_id=$id=getCustomerId($row['account_no'],$row['type']);
//echo "<td bgcolor=$color >".getName('customer_id',$c_id,'name1','customer_master')."</td>";
echo "<td bgcolor=$color >".$row['account_no']."</td>";

//echo "<td bgcolor=$color >".$c_id."</td>";
$gl=$row['gl_mas_code'];
if($gl=='14101'||$gl=='14102'||$gl=='14103'||$gl=='14104'||$gl=='14106'){$status='Member';}
if($gl=='14201'||$gl=='14202'||$gl=='14203'||$gl=='14204'||$gl=='14206'){$status='SHG';}
if($gl=='14301'||$gl=='14302'||$gl=='14303'||$gl=='14304'||$gl=='14306'){$status='Nonmember';}
if($gl=='14401'||$gl=='14402'||$gl=='14403'||$gl=='14404'||$gl=='14406'){$status='NRGS';}
echo "<td bgcolor=$color >$status</td>";
if(trim($row['dr_cr'])=='Cr'){
       $deposits=(float)$row['amount'];
       $withdrawals=0;
}
else {
       $deposits=0;
       $withdrawals=(float)$row['amount'];
}

echo "<td bgcolor=$color> <a href =\"../general/voucherdetails.php?tran_id=".$row['tran_id']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=700,height=500'); return false;\" >".$row['tran_id']."</a></td>";
echo "<td bgcolor=$color align=RIGHT>".amount2Rs($deposits)."</td>";
echo "<td bgcolor=$color align=RIGHT>".amount2Rs($withdrawals)."</td>";
$current_balance=sb_current_balance($row['account_no'],$current_date);
$total_deposit+=$deposits;
$total_withdrawal+=$withdrawals;
$total_current_blalnce+=$current_balance;
echo "<td bgcolor=$color align=RIGHT>".amount2Rs($current_balance)."</td>";
echo "<td ALIGN=\"RIGHT\" bgcolor=$color >".$row['operator_code']."</td>";
echo "<td ALIGN=\"RIGHT\" bgcolor=$color >".$row['entry_time']."</td>";

}
$color="#BA55D3";
echo "<tr><td colspan=3 bgcolor=$color align=center><b>Total :$j Records enter on this date !!!!</b>";
echo "<td bgcolor=$color align=RIGHT><b>".amount2Rs($total_deposit)."</td>";
echo "<td bgcolor=$color align=RIGHT><b>".amount2Rs($total_withdrawal)."</td>";
echo "<td bgcolor=$color align=RIGHT><b>".amount2Rs($total_current_blalnce)."</td>";
echo "<td bgcolor=$color align=RIGHT>";
echo "<td bgcolor=$color align=RIGHT>";

echo "</table>";

}
?>
