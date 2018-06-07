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
echo "<title>Yearly Cash Account";
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
$sql_statement= "select gl_sub_header_code,gl_sub_header_desc, sum(b.cnt) as cnt, sum(b.received) as received, sum(b.transfer) as transfer,a.numbering from gl_sub_header_vw1 as a, ( 
SELECT initcap(a.gl_mas_desc) AS gl_mas_desc, b.gl_mas_code, sum(b.cnt) as cnt, sum(b.received) as received, sum(b.transfer) as transfer from gl_master as a, ( 
SELECT 'R' as typ, a.gl_mas_code, count(*) as cnt, sum(credit-debit) as received, 0.00 as transfer, 0.00 as Payment from mas_gl_tran as a where a.gl_mas_code not like '28101' and tran_id in (SELECT tran_id from mas_gl_tran where gl_mas_code LIKE '28101' and debit-credit>0 and action_date>='$start_date' AND action_date<='$end_date') group by a.gl_mas_code 
UNION ALL 
SELECT 'R' as typ, a.gl_mas_code, count(*) as cnt, 0.00 as received, sum(credit-debit) as transfer, 0.00 as Payment from mas_gl_tran as a where debit-credit<0 and  action_date>='$start_date' AND action_date<='$end_date'

and tran_id not in(select tran_id from tran_id_pair_pre) 
and tran_id not in(select tran_id from tran_id_pair_curr) 
and a.gl_mas_code not in('28101')

and tran_id not in(select tran_id from tran_id_pair_pre_provision) 
and tran_id not in(select tran_id from tran_id_pair_curr_provision)
and tran_id not in(select tran_id from tran_id_pair_cl_provision) 

and tran_id not in(select tran_id from tran_id_pair_op_stock_in_trade)
and tran_id not in(select tran_id from tran_id_pair_cl_stock_in_trade) 

and tran_id  IN (SELECT tran_id FROM mas_gl_tran where tran_id NOT IN (SELECT tran_id FROM mas_gl_tran where action_date>='$start_date' AND action_date<='$end_date' and gl_mas_code<>'28101' GROUP BY tran_id HAVING COUNT(*)<2)) group by a.gl_mas_code 
) as b where typ='R' and a.gl_mas_code=b.gl_mas_code group by b.gl_mas_code, a.gl_mas_desc ORDER BY CAST(b.gl_mas_code AS NUMERIC) 
) as b where  a.gl_mas_code=b.gl_mas_code 
GROUP BY  gl_sub_header_code,gl_sub_header_desc,a.numbering
ORDER BY a.numbering";
//echo $sql_statement;
$result=dBConnect($sql_statement);
//----------------------------------------------------------------------------------------------
echo "<table width=\"100%\" bgcolor=\"\" border=\"1\" cellspacing=\"0\" bordercolor=\"BLACK\" bordercolorlight=\"BLACK\" bordercolordark=\"BLACK\"><tr>";
echo "<th colspan=\"2\" bgcolor=\"Yellow\">Cash Account as on $end_date<tr>";
echo "<td valign=\"top\" width=\"50%\">";
echo "<table width=\"100%\" border=\"1\" cellspacing=\"0\" bordercolor=\"BLACK\" bordercolorlight=\"BLACK\" bordercolordark=\"BLACK\">";
echo "<tr><td bgcolor=\"green\" colspan=\"6\" align=\"center\"><font color=\"white\"><b>Receipts</b></font>";
$color=$TCOLOR;
	echo "<tr>";
	echo "<th align=left bgcolor=$color width=10%>GL Code</th>";
	echo "<th align=left bgcolor=$color width=35%>Account Name</th>";
	echo "<th align=right bgcolor=$color width=15%>BreakUp</th>";
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
	//$tot=sprintf("%-12.00f",$tot);
        //$clbal=$clbal+$tot;
	echo "<tr>";
	$gl_code=$row['gl_sub_header_code'];
	echo "<td align=left bgcolor=$color><b>".$gl_code."</td>";
	echo "<td align=left bgcolor=$color><b>".$row['gl_sub_header_desc']."</td>";
	echo "<td align=right bgcolor=$color><b>&nbsp</td>";
	echo "<td align=right bgcolor=$color><b>".amount2Rs($row['received'])."</td>";
	echo "<td align=right bgcolor=$color><b>".amount2Rs($row['transfer'])."</td>";
	echo "<td align=right bgcolor=$color><b>".amount2Rs($tot)."</td>";
	//echo "<td align=right bgcolor=$color>".$tot."</td>";
	$vreceived=$vreceived+$row['received'];
	$vrtransfer=$vrtransfer+$row['transfer'];
	$sql_statement1="SELECT b.gl_mas_code,initcap(gl_mas_desc) AS gl_mas_desc, sum(b.received) as balance from gl_sub_header_vw1 as a, ( 
select 'R' as typ, a.gl_mas_code, count(*) as cnt, sum(credit-debit) as received, 0.00 as transfer, 0.00 as Payment from mas_gl_tran as a where a.gl_mas_code not  like '28101' and tran_id in (select tran_id from mas_gl_tran where gl_mas_code like '28101' and debit-credit>0 and action_date>='$start_date' AND action_date<='$end_date') group by a.gl_mas_code
) as b where  a.gl_mas_code=b.gl_mas_code AND gl_sub_header_code='$gl_code'
GROUP BY  b.gl_mas_code,gl_mas_desc
ORDER BY b.gl_mas_code";
//echo '$gl_code';
	$result1=dBConnect($sql_statement1);
	for($i=0; $i<pg_NumRows($result1); $i++){
	echo "<tr>";
	$row1=pg_fetch_array($result1,$i);
	echo "<td align=left bgcolor=$color><a href=\"gl_ledger.php?glc=".$row1['gl_mas_code']."&edt=$end_date&sdt=$start_date\">".$row1['gl_mas_code']."</a></td>";
	echo "<td align=left bgcolor=$color>".$row1['gl_mas_desc']."</td>";
	echo "<td align=right bgcolor=$color>".amount2Rs((float)$row1['balance'])."</td><td bgcolor=$color align=cente>&nbsp<td bgcolor=$color align=cente>&nbsp<td bgcolor=$color align=cente>&nbsp";

		}

}
echo "</tr><tr>";
$color="cyan";
$tot_r=$vreceived+$vrtransfer+$opbal;
echo "</table>";
//---------------------------------------------------------------------------------------------
/*      payment part starts here */
$sql_statement= "select gl_sub_header_code,gl_sub_header_desc, sum(b.cnt) as cnt, sum(b.payment) as payment, sum(b.transfer) as transfer,a.numbering from gl_sub_header_vw1 as a, ( 
SELECT initcap(a.gl_mas_desc) AS gl_mas_desc, b.gl_mas_code, sum(b.cnt) as cnt, sum(b.payment) as payment, sum(b.transfer) as transfer from gl_master as a,( 
SELECT 'P' as typ,a.gl_mas_code, count(*) as cnt, 0.00 as received, 0.00 as transfer, sum(debit-credit) as Payment from mas_gl_tran as a where a.gl_mas_code not like '28101' and tran_id in (SELECT tran_id from mas_gl_tran where gl_mas_code like '28101' and debit-credit<0 and action_date>='$start_date' AND action_date<='$end_date') group by a.gl_mas_code
UNION ALL 
SELECT 'P' as typ, a.gl_mas_code, count(*) as cnt, 0.00 as received, sum(debit-credit) as transfer, 0.00 as Payment from mas_gl_tran as a where  action_date>='$start_date' AND action_date<='$end_date' and debit-credit>0  

and tran_id not in(select tran_id from tran_id_pair_pre) 
and tran_id not in(select tran_id from tran_id_pair_curr) 

and tran_id not in(select tran_id from tran_id_pair_pre_provision) 
and tran_id not in(select tran_id from tran_id_pair_curr_provision)
and tran_id not in(select tran_id from tran_id_pair_cl_provision) 

and tran_id not in(select tran_id from tran_id_pair_op_stock_in_trade) 
and tran_id not in(select tran_id from tran_id_pair_cl_stock_in_trade)

and tran_id not in (SELECT tran_id from mas_gl_tran where gl_mas_code like '28101' and debit-credit<0 and action_date>='$start_date' AND action_date<='$end_date')
and a.gl_mas_code not like '28101'
and tran_id  IN 
(SELECT tran_id FROM mas_gl_tran where  tran_id NOT IN (SELECT tran_id FROM mas_gl_tran where action_date>='$start_date' AND action_date<='$end_date' GROUP BY tran_id HAVING COUNT(*)<2)) group by a.gl_mas_code 
) as b where typ='P' and a.gl_mas_code=b.gl_mas_code group by b.gl_mas_code, a.gl_mas_desc ORDER BY CAST(b.gl_mas_code AS NUMERIC)
) as b where a.gl_mas_code=b.gl_mas_code 
GROUP BY  gl_sub_header_code,gl_sub_header_desc,a.numbering
ORDER BY a.numbering ";
//echo $sql_statement;
$result=dBConnect($sql_statement);
echo "<td valign=\"top\" width=\"50%\">";
echo "<table width=\"100%\" border=\"1\"  cellspacing=\"0\" bordercolor=\"BLACK\" bordercolorlight=\"BLACK\" bordercolordark=\"BLACK\">";

echo "<tr><td bgcolor=\"green\" colspan=\"6\" align=\"center\"><font color=\"white\"><b>Payments</b></font>";
$color=$TCOLOR;
	echo "<tr>";
	echo "<th align=left bgcolor=$color width=10%>GL Code</th>";
	echo "<th align=left bgcolor=$color width=35%>Account Name</th>";
	echo "<th align=right bgcolor=$color width=15%>BreakUp</th>";
	echo "<th align=right bgcolor=$color width=15%>Payment</th>";
	echo "<th align=right bgcolor=$color width=15%>Transfer</th>";
	echo "<th align=right bgcolor=$color width=17%>Total</th>";
	
for($j=0; $j<pg_NumRows($result); $j++) {
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	$tot=$row['payment']+$row['transfer'];
	echo "<tr>";
	$gl_code=$row['gl_sub_header_code'];
	echo "<td align=left bgcolor=$color><b>".$gl_code."</td>";
	echo "<td align=left bgcolor=$color><b>".$row['gl_sub_header_desc']."</td>";
	echo "<td align=right bgcolor=$color><b>&nbsp</td>";
	echo "<td align=right bgcolor=$color><b>".amount2Rs($row['payment'])."</td>";
	echo "<td align=right bgcolor=$color><b>".amount2Rs($row['transfer'])."</td>";
	echo "<td align=right bgcolor=$color><b>".amount2Rs($tot)."</td>";
	//echo "<td align=right bgcolor=$color>".$tot."</td>";
	$vpaid=$vpaid+$row['payment'];
	$vtransfer=$vtransfer+$row['transfer'];
	$sql_statement1="select b.gl_mas_code,initcap(gl_mas_desc) AS gl_mas_desc, sum(b.payment) as balance, sum(b.transfer) as transfer from gl_sub_header_vw1 as a, ( 
select 'P' as typ,a.gl_mas_code, count(*) as cnt, 0.00 as received, 0.00 as transfer, sum(debit-credit) as Payment from mas_gl_tran as a where a.gl_mas_code not like '28101' and tran_id in (select tran_id from mas_gl_tran where gl_mas_code like '28101' and debit-credit<0 and action_date>='$start_date' AND action_date<='$end_date') group by a.gl_mas_code HAVING sum(debit-credit)>0 
) as b where  a.gl_mas_code=b.gl_mas_code AND gl_sub_header_code='$gl_code'
GROUP BY  b.gl_mas_code,gl_mas_desc
ORDER BY b.gl_mas_code";
	$result1=dBConnect($sql_statement1);
	for($i=0; $i<pg_NumRows($result1); $i++){
	echo "<tr>";
	$row1=pg_fetch_array($result1,$i);
	echo "<td align=left bgcolor=$color><a href=\"gl_ledger.php?glc=".$row1['gl_mas_code']."&edt=$end_date&sdt=$start_date\">".$row1['gl_mas_code']."</a></td>";
	echo "<td align=left bgcolor=$color>".$row1['gl_mas_desc']."</td>";
	echo "<td align=right bgcolor=$color>".amount2Rs((float)$row1['balance'])."</td><td bgcolor=$color align=cente>&nbsp<td bgcolor=$color align=cente>&nbsp<td bgcolor=$color align=cente>&nbsp";

		}

}
echo "</tr><tr>";
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
echo "<th bgcolor=$color >&nbsp</th>";
echo "<th bgcolor=$color align=left>Balance c/d</th>";
echo "<th bgcolor=$color >&nbsp</th>";
echo "<th bgcolor=$color align=right>&nbsp</th>";
echo "<th bgcolor=$color align=right>&nbsp</th>";
$t_pay=($vpaid+$vtransfer);
$cl_bal=round($tot_r-$t_pay,2);
//$cl_bal=sprintf("%-12.00f",$cl_bal);
echo "<th bgcolor=$color align=right>".amount2Rs($cl_bal)."</th>";
echo "</tr>";
$color="cyan";
$tot=$vtransfer+$vpaid+($tot_r-($vtransfer+$vpaid));
echo "</table>";
echo "<tr><td align=left><table width=\"100%\" border=\"1\" cellspacing=\"0\" bordercolor=\"BLACK\" bordercolorlight=\"BLACK\" bordercolordark=\"BLACK\">";
echo "<tr>";
echo "<th bgcolor=$color width=10%>&nbsp</th>";
echo "<th bgcolor=$color width=35%>Total</th>";
echo "<th bgcolor=$color width=12%>&nbsp</th>";
echo "<th bgcolor=$color align=right width=15%>".amount2Rs($vreceived)."</th>";
echo "<th bgcolor=$color align=right width=15%>".amount2Rs($vrtransfer)."</th>";
echo "<th bgcolor=$color align=right width=17%>".amount2Rs($tot_r)."</th>";
echo "</tr>";
echo "</table>";
echo "<td align=left><table width=\"100%\" border=\"1\" cellspacing=\"0\" bordercolor=\"BLACK\" bordercolorlight=\"BLACK\" bordercolordark=\"BLACK\">";
echo "<tr>";
echo "<th bgcolor=$color width=10%>&nbsp</th>";
echo "<th bgcolor=$color width=35%>Total</th>";
echo "<th bgcolor=$color width=12%>&nbsp</th>";
echo "<th bgcolor=$color align=right width=15%>".amount2Rs($vpaid)."</th>";
echo "<th bgcolor=$color align=right width=15%>".amount2Rs($vtransfer)."</th>";
echo "<th bgcolor=$color align=right width=17%>".amount2Rs($tot)."</th>";
echo "</table>";
echo "</body>";
echo "</html>";
?>
