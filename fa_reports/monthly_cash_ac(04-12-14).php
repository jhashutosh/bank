<?
include "../config/config.php";
$staff_id=verifyAutho();
$fy=$_SESSION['fy'];
$month=$_REQUEST['month'];
if(empty($month)){$month=" ";}
$numeric_month=getIndex($month_array,$month);
$fy_list=explode("-",$fy);
if($numeric_month>3){
		$start_date="01/".$numeric_month."/".$fy_list[0];
		$numeric_month+=1;
		$year=$fy_list[0];
		if($numeric_month>12){
		$end_date="01/01/".$fy_list[1];	
		}
		else{
		$end_date="01/".$numeric_month."/".$fy_list[0];
		}
	}
else{
		$year=$fy_list[1];
		$start_date="01/".$numeric_month."/".$fy_list[1];
		$numeric_month+=1;
		$end_date="01/".$numeric_month."/".$fy_list[1];
		
}
//getDetailFy($fy,&$f_start_dt,&$f_end_dt);
//$start_date=$_REQUEST["start_date"];
//if(empty($start_date) ) { $start_date=date('d/m/Y'); }
echo "<html>";
echo "<head>";
echo "<title>Monthly Cash Account";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
?>
<SCRIPT LANGUAGE="JavaScript">
function check(){
if(document.f1.month.value.length==0){
	alert("Please Select the month before processing")
	document.f1.month.focus();
	return false;
	}

}
</script>
<?
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<font size=+3>$SYSTEM_TITLE</font> <br><font size=+1><b>Report Date:".date('d.m.Y')."::".getPrintTime()."</b></font><hr>";
echo "<form name=\"f1\" action=\"monthly_cash_ac.php\" method=\"POST\" onsubmit=\"return check();\">";
echo "<table align=center bgcolor=\"#90EE90\"><tr><td  align=\"\"><b>Cash Account For the Month of :<td>";
makeSelect($month_array,'month',"$month");
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> ";
echo "</table></form>";
//---------------------------------------------------------------------------------------------
echo "<hr>";
if(!empty($month)||!($month==" ")){
$sql_statement1="select sum(debit-credit) as opb from mas_gl_tran where action_date<'$start_date' and gl_mas_code='28101'";
$result1=dBConnect($sql_statement1);
$row1=pg_fetch_array($result1,0);
$opbal=$row1['opb'];
$sql_statement= "SELECT initcap(a.gl_mas_desc) AS gl_mas_desc, b.gl_mas_code, sum(b.cnt) as cnt, sum(b.received) as received, sum(b.transfer) as transfer from gl_master as a, 
(select 'R' as typ, a.gl_mas_code, count(*) as cnt, sum(credit-debit) as received, 0.00 as transfer, 0.00 as Payment from mas_gl_tran as a where a.gl_mas_code not like '28101' and tran_id in (select tran_id from mas_gl_tran where gl_mas_code like '28101' and debit-credit>0 and action_date between '$start_date' and '$end_date') group by a.gl_mas_code HAVING sum(credit-debit)>0
union all 
SELECT 'R' as typ,a.gl_mas_code, count(*) as cnt, sum(credit-debit) as received,0.00 as Payment, 0.00 as transfer from mas_gl_tran as a where a.gl_mas_code not like '28101' and tran_id in (select tran_id from mas_gl_tran where gl_mas_code like '28101' and debit-credit<0 and action_date between '$start_date' and '$end_date') group by a.gl_mas_code HAVING sum(debit-credit)< 0
union all 
select 'R' as typ, a.gl_mas_code, count(*) as cnt, 0.00 as received, sum(credit-debit) as transfer, 0.00 as Payment from mas_gl_tran as a where a.gl_mas_code not like '28101' and debit-credit<0 and action_date between '$start_date' and '$end_date' and tran_id not in (select tran_id from mas_gl_tran where gl_mas_code like '28101' and action_date between '$start_date' and '$end_date') group by a.gl_mas_code ) as b where typ='R' and a.gl_mas_code=b.gl_mas_code group by b.gl_mas_code, a.gl_mas_desc ORDER BY CAST (b.gl_mas_code as INT)";
//echo $sql_statement;
$result=dBConnect($sql_statement);
//----------------------------------------------------------------------------------------------
echo "<table width=\"100%\" class=\"border\"><tr>";
echo "<th colspan=\"2\" bgcolor=\"Yellow\">Cash Account for the Month of $month,$year<tr>";
echo "<td valign=\"top\" width=\"50%\">";
echo "<table width=\"100%\" class=\"border\">";
echo "<tr><td bgcolor=\"green\" colspan=\"6\" align=\"center\"><font color=\"white\"><b>Receipts</b></font>";
$color=$TCOLOR;
	echo "<tr>";
	echo "<th align=left bgcolor=$color width=10%>GL Code</th>";
	echo "<th align=left bgcolor=$color width=35%>Account Name</th>";
	echo "<th align=right bgcolor=$color width=8%>Count</th>";
	echo "<th align=right bgcolor=$color width=15%>Received</th>";
	echo "<th align=right bgcolor=$color width=15%>Transfer</th>";
	echo "<th align=right bgcolor=$color width=17%>Total</th>";
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	echo "<tr>";
	echo "<td align=left bgcolor=$color></td>";
	echo "<th align=left bgcolor=$color>Balance b/d</th>";
	echo "<td align=right bgcolor=$color></td>";
	echo "<td align=right bgcolor=$color></td>";
	echo "<td align=right bgcolor=$color></td>";
	echo "<tH align=right bgcolor=$color>".amount2Rs($opbal)."</th>";
	for($j=0; $j<pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	$tot=$row['received']+$row['transfer'];
        //$clbal=$clbal+$tot;
	echo "<tr>";
	echo "<td align=left bgcolor=$color>".$row['gl_mas_code']."</td>";
	echo "<td align=left bgcolor=$color>".$row['gl_mas_desc']."</td>";
	echo "<td align=right bgcolor=$color>".$row['cnt']."</td>";
	echo "<td align=right bgcolor=$color>".amount2Rs($row['received'])."</td>";
	echo "<td align=right bgcolor=$color>".amount2Rs($row['transfer'])."</td>";
	echo "<td align=right bgcolor=$color>".amount2Rs($tot)."</td>";
	//echo "<td align=right bgcolor=$color>".$tot."</td>";
	$vreceived=$vreceived+$row['received'];
	$vrtransfer=$vrtransfer+$row['transfer'];

}
echo "</tr><tr>";
$color="cyan";
$tot_r=$vreceived+$vrtransfer+$opbal;
echo "</table>";
//---------------------------------------------------------------------------------------------
/*      payment part starts here */
$sql_statement= "SELECT initcap(a.gl_mas_desc) AS gl_mas_desc, b.gl_mas_code, sum(b.cnt) as cnt, sum(b.payment) as payment, sum(b.transfer) as transfer from gl_master as a, ( 
select 'P' as typ, a.gl_mas_code, count(*) as cnt, 0 as received, 0.00 as transfer, sum(debit-credit) as Payment from mas_gl_tran as a where a.gl_mas_code not like '28101' and tran_id in (select tran_id from mas_gl_tran where gl_mas_code like '28101' and debit-credit>0 and action_date between '$start_date' and '$end_date') group by a.gl_mas_code HAVING sum(debit-credit)>0
UNION ALL 
select 'P' as typ,a.gl_mas_code, count(*) as cnt, 0.00 as received, 0.00 as transfer, sum(debit-credit) as Payment from mas_gl_tran as a where a.gl_mas_code not like '28101' and tran_id in (select tran_id from mas_gl_tran where gl_mas_code like '28101' and debit-credit<0 and action_date between '$start_date' and '$end_date') group by a.gl_mas_code HAVING sum(debit-credit)> 0
UNION ALL 
select 'P' as typ, a.gl_mas_code, count(*) as cnt, 0.00 as received, sum(debit-credit) as transfer, 0.00 as Payment from mas_gl_tran as a where a.gl_mas_code <> '28101' and action_date between '$start_date' and '$end_date' and debit-credit>0 and tran_id not in (select tran_id from mas_gl_tran where gl_mas_code like '28101') group by a.gl_mas_code 
) as b where typ='P' and a.gl_mas_code=b.gl_mas_code group by b.gl_mas_code, a.gl_mas_desc ORDER BY CAST (b.gl_mas_code as INT)";
//echo $sql_statement;
$result=dBConnect($sql_statement);
echo "<td valign=\"top\" width=\"50%\">";
echo "<table width=\"100%\" border=\"1\" class=\"border\">";

echo "<tr><td bgcolor=\"green\" colspan=\"6\" align=\"center\"><font color=\"white\"><b>Payments</b></font>";
$color=$TCOLOR;
	echo "<tr>";
	echo "<th align=left bgcolor=$color width=10%>GL Code</th>";
	echo "<th align=left bgcolor=$color width=35%>Account Name</th>";
	echo "<th align=right bgcolor=$color width=8%>Count</th>";
	echo "<th align=right bgcolor=$color width=15%>Payment</th>";
	echo "<th align=right bgcolor=$color width=15%>Transfer</th>";
	echo "<th align=right bgcolor=$color width=17%>Total</th>";
	
for($j=0; $j<pg_NumRows($result); $j++) {
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	$tot=$row['payment']+$row['transfer'];
	echo "<tr>";
	echo "<td align=left bgcolor=$color>".$row['gl_mas_code']."</td>";
	echo "<td align=left bgcolor=$color>".$row['gl_mas_desc']."</td>";
	echo "<td align=right bgcolor=$color>".$row['cnt']."</td>";
	echo "<td align=right bgcolor=$color>".amount2Rs($row['payment'])."</td>";
	echo "<td align=right bgcolor=$color>".amount2Rs($row['transfer'])."</td>";
	echo "<td align=right bgcolor=$color>".amount2Rs($tot)."</td>";
	//echo "<td align=right bgcolor=$color>".$tot."</td>";
	$vpaid=$vpaid+$row['payment'];
	$vtransfer=$vtransfer+$row['transfer'];

}
echo "</tr><tr>";
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
echo "<th bgcolor=$color ></th>";
echo "<th bgcolor=$color align=left>Balance c/d</th>";
echo "<th bgcolor=$color ></th>";
echo "<th bgcolor=$color align=right></th>";
echo "<th bgcolor=$color align=right></th>";
$t_pay=($vpaid+$vtransfer);
$cl_bal=round($tot_r-$t_pay,2);
//$cl_bal=sprintf("%-12.00f",$cl_bal);
echo "<th bgcolor=$color align=right>".amount2Rs($cl_bal)."</th>";
echo "</tr>";
$color="cyan";
$tot=$vtransfer+$vpaid+($tot_r-($vtransfer+$vpaid));
echo "</table>";
echo "<tr><td align=left><table width=\"100%\" class=\"border\">";
echo "<tr>";
echo "<th bgcolor=$color width=10%></th>";
echo "<th bgcolor=$color width=35%>Total</th>";
echo "<th bgcolor=$color width=8%></th>";
echo "<th bgcolor=$color align=right width=15%>".amount2Rs($vreceived)."</th>";
echo "<th bgcolor=$color align=right width=15%>".amount2Rs($vrtransfer)."</th>";
echo "<th bgcolor=$color align=right width=17%>".amount2Rs($tot_r)."</th>";
echo "</tr>";
echo "</table>";
echo "<td align=left><table width=\"100%\" class=\"border\">";
echo "<tr>";
echo "<th bgcolor=$color width=10%></th>";
echo "<th bgcolor=$color width=35%>Total</th>";
echo "<th bgcolor=$color width=8%></th>";
echo "<th bgcolor=$color align=right width=15%>".amount2Rs($vpaid)."</th>";
echo "<th bgcolor=$color align=right width=15%>".amount2Rs($vtransfer)."</th>";
echo "<th bgcolor=$color align=right width=17%>".amount2Rs($tot)."</th>";
}
echo "</table>";
echo "</body>";
echo "</html>";
?>
