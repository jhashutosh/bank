<?
include "../config/config.php";
$staff_id=verifyAutho();
$fy=$_SESSION['fy'];
getDetailFy($fy,&$f_start_dt,&$f_end_dt);
if(empty($start_date) ) { $start_date=$f_start_dt; }
$end_date=$_REQUEST["end_date"];
if(empty($end_date) ) { $end_date=$f_end_dt;}
echo "<html>";
echo "<head>";
echo "<title>Day Book";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "<script src=\"../JS/date_validation.js\"></script>";
?>
<SCRIPT LANGUAGE="JavaScript">
function check(){
if(document.f1.end_date.value.length==0){
	alert("Please enter the Date before processing")
	document.f1.month.focus();
	return false;
	}
f_s_dt=document.f1.f_start_dt.value;
f_e_dt=document.f1.f_end_dt.value;
end_dt=document.f1.end_date.value;
if(!IsDateLess(f_s_dt,end_dt)){
	alert("Ending Date beyond of starting date of Financial Year")
	document.f1.end_date.focus();
	return false;
	}

if(!IsDateLess(end_dt,f_e_dt)){
	alert("Ending Date beyond of ending date of Financial Year")
	document.f1.end_date.focus();
	return false;
	}

}

</script>
<?
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<font size=+3>$SYSTEM_TITLE</font> <br><font size=+1><b>Report Date:".date('d.m.Y')."::".getPrintTime()."</b></font><hr>";
echo "<form name=\"f1\" action=\"yearly_cash_ac.php\" method=\"POST\" onsubmit=\"return check();\">";

echo "<table align=center bgcolor=\"#90EE90\"><tr><td  align=\"\"><b>Cash A/C as on Dated (DD/MM/YYYY) :<td><input type=TEXT size=12 name=\"end_date\" id =\"end_date\" value=\"$end_date\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.end_date,'dd/mm/yyyy','Choose Date')\">";
echo "<input type=\"HIDDEN\" name=\"f_start_dt\" id=\"f_start_dt\" value=\"$f_start_dt\">";
echo "<input type=\"HIDDEN\" name=\"f_end_dt\" id=\"f_end_dt\" value=\"$f_end_dt\">";
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> ";
echo "</table></form>";
//---------------------------------------------------------------------------------------------
echo "<hr>";
$sql_statement1="select sum(debit-credit) as opb from mas_gl_tran where action_date<'$start_date' and gl_mas_code='28101'";
$result1=dBConnect($sql_statement1);
$row1=pg_fetch_array($result1,0);
$opbal=$row1['opb'];
//receipt side
$sql_statement="SELECT gl_sub_header_desc,gl_sub_header_code, sum(b.received) as received, sum(b.transfer) as transfer from gl_sub_header_vw as a, ( 
SELECT 'R' as typ, a.gl_mas_code, count(*) as cnt, sum(credit-debit) as received, 0.00 as transfer, 0.00 as Payment from mas_gl_tran as a where a.gl_mas_code not  like '28101' and tran_id in (select tran_id from mas_gl_tran where gl_mas_code like '28101' and debit-credit>0 and action_date>='$start_date' AND action_date<='$end_date') group by a.gl_mas_code
UNION ALL
SELECT 'R' as typ, a.gl_mas_code, count(*) as cnt, 0.00 as received, sum(credit-debit) as transfer, 0.00 as Payment FROM mas_gl_tran as a where credit-debit> 0 and action_date>='$start_date' AND action_date<='$end_date' AND tran_id IN (select tran_id from mas_gl_tran where gl_mas_code IN (SELECT gl_mas_code FROM gl_sub_header_vw WHERE  gl_sub_header_code IN ('28100','28200')) AND tran_id NOT IN (SELECT tran_id FROM mas_gl_tran WHERE gl_mas_code LIKE '28101')) AND a.gl_mas_code NOT IN (SELECT gl_mas_code FROM gl_sub_header_vw WHERE  gl_sub_header_code IN ('28100','28200')) GROUP BY a.gl_mas_code
UNION ALL
SELECT 'R' as typ, a.gl_mas_code, count(*) as cnt, 0.00 as received, sum(debit-credit) as transfer, 0.00 as Payment from mas_gl_tran as a where  tran_id IN (select tran_id from mas_gl_tran where gl_mas_code IN (SELECT gl_mas_code FROM gl_sub_header_vw WHERE  gl_sub_header_code IN ('28100','28200')) AND tran_id NOT IN (SELECT tran_id FROM mas_gl_tran WHERE gl_mas_code LIKE '28101')) AND debit-credit> 0 AND action_date>='$start_date' AND action_date<='$end_date' AND a.gl_mas_code IN (SELECT gl_mas_code FROM gl_sub_header_vw WHERE  gl_sub_header_code IN ('28100','28200')) GROUP BY a.gl_mas_code
) as b where typ='R' and a.gl_mas_code=b.gl_mas_code 
group by gl_sub_header_desc,gl_sub_header_code
ORDER BY gl_sub_header_code";
//echo $sql_statement;
$result=dBConnect($sql_statement);
//----------------------------------------------------------------------------------------------
echo "<table width=\"100%\" bgcolor=\"\"><tr>";
echo "<th colspan=\"2\" bgcolor=\"Yellow\">Cash Account for the Year end date $end_date<tr>";
echo "<td valign=\"top\" width=\"50%\">";
echo "<table width=\"100%\" border=\"1\" cellspacing=\"0\" bordercolor=\"#000000\">";
echo "<tr><td bgcolor=\"green\" colspan=\"6\" align=\"center\"><font color=\"white\"><b>Receipts</b></font>";
$color=$TCOLOR;
	echo "<tr>";
	echo "<th align=left bgcolor=$color width=10%>GL Code</th>";
	echo "<th align=left bgcolor=$color width=35%>Account Name</th>";
	echo "<th align=right bgcolor=$color width=12%>BreakUp</th>";
	echo "<th align=right bgcolor=$color width=15%>Received</th>";
	echo "<th align=right bgcolor=$color width=15%>Transfer</th>";
	echo "<th align=right bgcolor=$color width=17%>Total</th>";
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	echo "<tr>";
	echo "<td align=left bgcolor=$color>&nbsp</td>";
	echo "<th align=left bgcolor=$color>Balance b/d</th>";
	echo "<td align=right bgcolor=$color>&nbsp</td>";
	echo "<td align=right bgcolor=$color>&nbsp</td>";
	echo "<td align=right bgcolor=$color>&nbsp</td>";
	echo "<tH align=right bgcolor=$color>".amount2Rs($opbal)."</th>";
	for($j=0; $j<pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	$tot=$row['received']+$row['transfer'];
        //$clbal=$clbal+$tot;
	echo "<tr>";
	echo "<td align=left bgcolor=$color><b>".$row['gl_sub_header_code']."</td>";
	echo "<td align=left bgcolor=$color><b>".$row['gl_sub_header_desc']."</td>";
	echo "<td align=right bgcolor=$color>&nbsp</td>";
	echo "<td align=right bgcolor=$color><b>".amount2Rs($row['received'])."</td>";
	echo "<td align=right bgcolor=$color><b>".amount2Rs($row['transfer'])."</td>";
	echo "<td align=right bgcolor=$color><b>".amount2Rs($tot)."</td>";
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
$sql_statement="SELECT gl_sub_header_desc,gl_sub_header_code, sum(b.payment) as payment, sum(b.transfer) as transfer from gl_sub_header_vw as a,( 
select 'P' as typ,a.gl_mas_code, count(*) as cnt, 0.00 as received, 0.00 as transfer, sum(debit-credit) as Payment from mas_gl_tran as a where  a.gl_mas_code not  like '28101' and tran_id in (select tran_id from mas_gl_tran where gl_mas_code like '28101' and debit-credit<0 and action_date>='$start_date' AND action_date<='$end_date') group by a.gl_mas_code
union all
SELECT 'P' as typ, a.gl_mas_code, count(*) as cnt, 0.00 as received, sum(credit-debit) as transfer, 0.00 as Payment from mas_gl_tran as a where credit-debit> 0 and action_date>='$start_date' AND action_date<='$end_date' AND tran_id IN (select tran_id from mas_gl_tran where gl_mas_code IN (SELECT gl_mas_code FROM gl_sub_header_vw WHERE  gl_sub_header_code IN ('28100','28200')) AND tran_id NOT IN (SELECT tran_id FROM mas_gl_tran WHERE gl_mas_code LIKE '28101')) AND a.gl_mas_code IN (SELECT gl_mas_code FROM gl_sub_header_vw WHERE  gl_sub_header_code IN ('28100','28200')) GROUP BY a.gl_mas_code
UNION ALL
SELECT 'P' as typ, a.gl_mas_code, count(*) as cnt, 0.00 as received, sum(debit-credit) as transfer, 0.00 as Payment from mas_gl_tran as a where  tran_id IN (select tran_id from mas_gl_tran where gl_mas_code IN (SELECT gl_mas_code FROM gl_sub_header_vw WHERE  gl_sub_header_code IN ('28100','28200')) AND tran_id NOT IN (SELECT tran_id FROM mas_gl_tran WHERE gl_mas_code LIKE '28101')) AND debit-credit> 0 AND action_date>='$start_date' AND action_date<='$end_date' AND a.gl_mas_code NOT IN (SELECT gl_mas_code FROM gl_sub_header_vw WHERE  gl_sub_header_code IN ('28100','28200')) GROUP BY a.gl_mas_code
) as b where typ='P' and a.gl_mas_code=b.gl_mas_code 
group by gl_sub_header_desc,gl_sub_header_code
ORDER BY gl_sub_header_code";
//echo $sql_statement;
$result=dBConnect($sql_statement);
echo "<td valign=\"top\" width=\"50%\">";
echo "<table width=\"100%\" border=\"1\" cellspacing=\"0\" bordercolor=\"#000000\" >";
echo "<tr><td bgcolor=\"green\" colspan=\"6\" align=\"center\"><font color=\"white\"><b>Payments</b></font>";
$color=$TCOLOR;
	echo "<tr>";
	echo "<th align=left bgcolor=$color width=10%>GL Code</th>";
	echo "<th align=left bgcolor=$color width=35%>Account Name</th>";
	echo "<th align=right bgcolor=$color width=12%>BreakUp</th>";
	echo "<th align=right bgcolor=$color width=15%>Payment</th>";
	echo "<th align=right bgcolor=$color width=15%>Transfer</th>";
	echo "<th align=right bgcolor=$color width=17%>Total</th>";
	
for($j=0; $j<pg_NumRows($result); $j++) {
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	$tot=$row['payment']+$row['transfer'];
	echo "<tr>";
	echo "<td align=left bgcolor=$color><b>".$row['gl_sub_header_code']."</td>";
	echo "<td align=left bgcolor=$color><b>".$row['gl_sub_header_desc']."</td>";
	echo "<td align=right bgcolor=$color>&nbsp</td>";
	echo "<td align=right bgcolor=$color><b>".amount2Rs($row['payment'])."</td>";
	echo "<td align=right bgcolor=$color><b>".amount2Rs($row['transfer'])."</td>";
	echo "<td align=right bgcolor=$color><b>".amount2Rs($tot)."</td>";
	//echo "<td align=right bgcolor=$color>".$tot."</td>";
	$vpaid=$vpaid+$row['payment'];
	$vtransfer=$vtransfer+$row['transfer'];

}
echo "</tr><tr>";
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
echo "<th bgcolor=$color >&nbsp</th>";
echo "<th bgcolor=$color align=left>Balance c/d</th>";
echo "<th bgcolor=$color >&nbsp</th>";
echo "<th bgcolor=$color align=right>&nbsp</th>";
echo "<th bgcolor=$color align=right>&nbsp</th>";
$t_pay=($vpaid+$vtransfer);
echo "<h1>Total_R:$tot_r AND Total_P:$t_pay</h1>";
$cl_bal=round($tot_r-$t_pay,2);

echo "<th bgcolor=$color align=right>".amount2Rs($cl_bal)."</th>";
echo "</tr>";
$color="cyan";
$tot=$vtransfer+$vpaid+($tot_r-($vtransfer+$vpaid));
echo "</table>";
echo "<tr><td align=left><table width=\"100%\" border=\"1\">";
echo "<tr>";
echo "<th bgcolor=$color width=10%></th>";
echo "<th bgcolor=$color width=35%>Total</th>";
echo "<th bgcolor=$color width=8%></th>";
echo "<th bgcolor=$color align=right width=15%>".amount2Rs($vreceived)."</th>";
echo "<th bgcolor=$color align=right width=15%>".amount2Rs($vrtransfer)."</th>";
echo "<th bgcolor=$color align=right width=17%>".amount2Rs($tot_r)."</th>";
echo "</tr>";
echo "</table>";
echo "<td align=left><table width=\"100%\" border=\"1\">";
echo "<tr>";
echo "<th bgcolor=$color width=10%></th>";
echo "<th bgcolor=$color width=35%>Total</th>";
echo "<th bgcolor=$color width=8%></th>";
echo "<th bgcolor=$color align=right width=15%>".amount2Rs($vpaid)."</th>";
echo "<th bgcolor=$color align=right width=15%>".amount2Rs($vtransfer)."</th>";
echo "<th bgcolor=$color align=right width=17%>".amount2Rs($tot)."</th>";
echo "</table>";
echo "</body>";
echo "</html>";
?>
