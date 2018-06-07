<?php
include "../config/config.php";
$staff_id=verifyAutho();
$fy=$_SESSION['fy'];
getDetailFy($fy,$f_start_dt,$f_end_dt);
$year=$_REQUEST['current_date'];
$months=trim($_REQUEST['months']);
//$end_dt=$_REQUEST['end_dt'];
$start_dt=$_REQUEST['start_dt'];
$days=$_REQUEST['days'];
//echo "<h1>".$days;
//$d=1;
//$m=4;
//$y=2013;
//echo date($k.'/'.$months.'/'.$year);
echo "<hr>";
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
echo "<html>";
echo "<head>";
echo "<title>$PROJECT_TITLE</title>";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "<script language=\"JAVASCRIPT\">";
echo "function closeme() { close(); }";
echo "</script>";
echo "<script src=\"../JS/date_validation.js\"></script>";
?>
<SCRIPT LANGUAGE="JavaScript">
function myFunc(m){

var y=document.f1.current_date.value;
if(y.length==0){
	alert("Enter the Year First");
	location.reload();
	return false;
}
else{
	var s=new Date(y,m-1,1);
	m=s.getMonth()+1;
	//var d=s.getDate();
	var strt_strng=s.getDate()+'/'+m+'/'+s.getFullYear();
	var e=new Date(y,m,0);
	m=e.getMonth()+1;
	var d=e.getDate();
	var end_strng=e.getDate()+'/'+m+'/'+e.getFullYear();
	document.f1.start_dt.value=strt_strng;
	//document.f1.end_dt.value=end_strng;
	document.f1.days.value=d;
	}
}

</script>
<?php
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"\" onload=\"cd.focus();\">";
echo "<center><font size=+3>$SYSTEM_TITLE</font><br>";
echo "<i>Monthly Return Forms as on". $month_array[$months].",$year</i></center>";
echo "<hr>";
echo "<form name=\"f1\" METHOD=\"POST\" ACTION=\"gl_ledger_mbook.php\" onsubmit=\"return check();\">";
echo "<table align=center bgcolor=\"#90EE90\">";
echo"<tr><td><b>Return Month as on :<td>";
echo"<input type=TEXT size=4 name=current_date id=cd Value=\"\" onclick=\"this.value=''\" $HIGHLIGHT>&nbsp;-&nbsp;";
makeSelectwithJS($month_array,'months',$m,'months','onChange=myFunc(this.value);');
echo "<input type=\"HIDDEN\" name=\"f_start_dt\" id=\"f_start_dt\" value=\"$f_start_dt\">";
echo "<input type=\"HIDDEN\" name=\"f_end_dt\" id=\"f_end_dt\" value=\"$f_end_dt\">";
echo "<input type=\"HIDDEN\" name=\"start_dt\" id=\"start_dt\" value=\"\">";
echo "<input type=\"HIDDEN\" name=\"end_dt\" id=\"end_dt\" value=\"\">";
echo "<input type=\"HIDDEN\" name=\"days\" id=\"days\" value=\"\">";

echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\">";
echo "</table></form>";
echo "<hr>";
//echo "<center>";

//---------------------------------------------------------------------------------------------
for($k=0,$l=1;$k<$days;$k++,$l++){
echo "<hr bgcolor=black>";
$sql_statement1="select sum(debit-credit) as opb from mas_gl_tran where action_date<date('$start_dt') +$k* INTERVAL '1 Days' and gl_mas_code='28101'";
//echo "<br>";
$result1=dBConnect($sql_statement1);
$row1=pg_fetch_array($result1,0);
$opbal=$row1['opb'];
$sql_statement= "select initcap(a.gl_mas_desc) AS gl_mas_desc, b.gl_mas_code, sum(b.cnt) as cnt, sum(b.received) as received, sum(b.transfer) as transfer from gl_master as a, ( select 'R' as typ, a.gl_mas_code, count(*) as cnt, sum(credit-debit) as received, 0.00 as transfer, 0.00 as Payment from mas_gl_tran as a where a.gl_mas_code not  like '28101' and tran_id in (select tran_id from mas_gl_tran where gl_mas_code like '28101' and debit-credit>0 and action_date=date('$start_dt')+$k* INTERVAL '1 Days') 
and tran_id not in(select tran_id from tran_id_pair_pre) 
and tran_id not in(select tran_id from tran_id_pair_curr) 

and tran_id not in(select tran_id from tran_id_pair_pre_provision) 
and tran_id not in(select tran_id from tran_id_pair_curr_provision) 
and tran_id not in(select tran_id from tran_id_pair_cl_provision)
and tran_id not in(select tran_id from tran_id_pair_op_stock_in_trade) 
and tran_id not in(select tran_id from tran_id_pair_cl_stock_in_trade)
group by a.gl_mas_code
union all
select 'P' as typ,a.gl_mas_code, count(*) as cnt, 0.00 as received, 0.00 as transfer, sum(debit-credit) as Payment from mas_gl_tran as a where  a.gl_mas_code not  like '28101' and tran_id in (select tran_id from mas_gl_tran where gl_mas_code like '28101' and debit-credit<0 and action_date=date('$start_dt')+$k* INTERVAL '1 Days') 
and tran_id not in(select tran_id from tran_id_pair_pre) 
and tran_id not in(select tran_id from tran_id_pair_curr) 

and tran_id not in(select tran_id from tran_id_pair_pre_provision) 
and tran_id not in(select tran_id from tran_id_pair_curr_provision) 
and tran_id not in(select tran_id from tran_id_pair_cl_provision)
and tran_id not in(select tran_id from tran_id_pair_op_stock_in_trade) 
and tran_id not in(select tran_id from tran_id_pair_cl_stock_in_trade)
group by a.gl_mas_code
union all
select 'P' as typ, a.gl_mas_code, count(*) as cnt, 0.00 as received, sum(credit-debit) as transfer, 0.00 as Payment from mas_gl_tran as a where  a.gl_mas_code not  like '28101' and  debit-credit<0 and action_date=date('$start_dt')+$k* INTERVAL '1 Days' and tran_id not in (select tran_id from mas_gl_tran where gl_mas_code like '28101'  and action_date=date('$start_dt')+$k* INTERVAL '1 Days') 
and tran_id not in(select tran_id from tran_id_pair_pre) 
and tran_id not in(select tran_id from tran_id_pair_curr) 

and tran_id not in(select tran_id from tran_id_pair_pre_provision) 
and tran_id not in(select tran_id from tran_id_pair_curr_provision) 
and tran_id not in(select tran_id from tran_id_pair_cl_provision)
and tran_id not in(select tran_id from tran_id_pair_op_stock_in_trade) 
and tran_id not in(select tran_id from tran_id_pair_cl_stock_in_trade)
group by a.gl_mas_code
union all
select 'R' as typ,a.gl_mas_code, count(*) as cnt, sum(credit-debit) as received, 0.00 as transfer, 0 as Payment from mas_gl_tran as a where  a.gl_mas_code not  like '28101' and tran_id in (select tran_id from mas_gl_tran where gl_mas_code like '28101' and debit-credit<0 and action_date=date('$start_dt')+$k* INTERVAL '1 Days')

and tran_id not in(select tran_id from tran_id_pair_pre) 

and tran_id not in(select tran_id from tran_id_pair_curr) 

and tran_id not in(select tran_id from tran_id_pair_pre_provision) 
and tran_id not in(select tran_id from tran_id_pair_curr_provision) 

and tran_id not in(select tran_id from tran_id_pair_cl_provision)
and tran_id not in(select tran_id from tran_id_pair_op_stock_in_trade) 
and tran_id not in(select tran_id from tran_id_pair_cl_stock_in_trade)
 group by a.gl_mas_code HAVING sum(debit-credit)<0
UNION ALL
select 'R' as typ, a.gl_mas_code, count(*) as cnt, 0.00 as received, sum(credit-debit) as transfer, 0.00 as Payment from mas_gl_tran as a where  a.gl_mas_code not  like '28101' and  debit-credit<0 and action_date=date('$start_dt')+$k* INTERVAL '1 Days' and tran_id not in (select tran_id from mas_gl_tran where gl_mas_code like '28101'  and action_date=date('$start_dt')+$k* INTERVAL '1 Days') 
and tran_id not in(select tran_id from tran_id_pair_pre) 
and tran_id not in(select tran_id from tran_id_pair_curr) 

and tran_id not in(select tran_id from tran_id_pair_pre_provision) 
and tran_id not in(select tran_id from tran_id_pair_curr_provision) 
and tran_id not in(select tran_id from tran_id_pair_cl_provision)
and tran_id not in(select tran_id from tran_id_pair_op_stock_in_trade) 
and tran_id not in(select tran_id from tran_id_pair_cl_stock_in_trade)
group by a.gl_mas_code
) as b where typ='R' and a.gl_mas_code=b.gl_mas_code group by b.gl_mas_code, a.gl_mas_desc";

$result=dBConnect($sql_statement);

//----------------------------------------------------------------------------------------------
echo "<table width=\"100%\" bgcolor=\"pink\" border='1'>";//boro table 
echo "<tr><th colspan=\"2\" bgcolor=\"Yellow\"><font size=\"+3\">Day Book as on ".date($l.'/'.$months.'/'.$year)."</font></th></tr>";
echo "<tr><td valign=\"top\" width=\"50%\">";
echo "<table width=\"100%\">";//choto table
echo "<tr><td bgcolor=\"green\" colspan=\"6\" align=\"center\"><font color=\"white\"><b>Receipts</b></font></td></tr>";
$color=$TCOLOR;
	echo "<tr>";
	echo "<th align=left bgcolor=$color width=10%>GL Code</th>";
	echo "<th align=left bgcolor=$color width=35%>Account Name</th>";
	echo "<th align=right bgcolor=$color width=8%>Count</th>";
	echo "<th align=right bgcolor=$color width=15%>Cash</th>";
	echo "<th align=right bgcolor=$color width=15%>Transfer</th>";
	echo "<th align=right bgcolor=$color width=17%>Total</th></tr>";
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	echo "<tr>";
	echo "<td align=left bgcolor=$color></td>";
	echo "<th align=left bgcolor=$color>Balance b/d</th>";
	echo "<td align=right bgcolor=$color></td>";
	echo "<td align=right bgcolor=$color></td>";
	echo "<td align=right bgcolor=$color></td>";
	echo "<tH align=right bgcolor=$color>".amount2Rs($opbal)."</th></tr>";
	$vreceived=0;$vrtransfer=0;
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
	echo "<td align=right bgcolor=$color>".amount2Rs($tot)."</td></tr>";
	$vreceived=$vreceived+$row['received'];
	$vrtransfer=$vrtransfer+$row['transfer'];

}
$color="cyan";
$tot_r=$vreceived+$vrtransfer+$opbal;
echo "</table></td>";
//---------------------------------------------------------------------------------------------
/*      payment part starts here */

$sql_statement= "select initcap(a.gl_mas_desc) AS gl_mas_desc, b.gl_mas_code, sum(b.cnt) as cnt, sum(b.payment) as payment, sum(b.transfer) as transfer from gl_master as a, ( select 'R' as typ, a.gl_mas_code, count(*) as cnt, sum(credit-debit) as received, 0.00 as transfer, 0.00 as Payment from mas_gl_tran as a where a.gl_mas_code not  like '28101' and tran_id in (select tran_id from mas_gl_tran where gl_mas_code like '28101' and debit-credit>0 and action_date=date('$start_dt')+$k* INTERVAL '1 Days') 
and tran_id not in(select tran_id from tran_id_pair_pre) 
and tran_id not in(select tran_id from tran_id_pair_curr) 

and tran_id not in(select tran_id from tran_id_pair_pre_provision) 
and tran_id not in(select tran_id from tran_id_pair_curr_provision) 
and tran_id not in(select tran_id from tran_id_pair_cl_provision)
and tran_id not in(select tran_id from tran_id_pair_op_stock_in_trade) 
and tran_id not in(select tran_id from tran_id_pair_cl_stock_in_trade)
group by a.gl_mas_code
union all
select 'P' as typ,a.gl_mas_code, count(*) as cnt, 0.00 as received, 0.00 as transfer, sum(debit-credit) as Payment from mas_gl_tran as a where  a.gl_mas_code not  like '28101' and tran_id in (select tran_id from mas_gl_tran where gl_mas_code like '28101' and debit-credit<0 and action_date=date('$start_dt')+$k* INTERVAL '1 Days')
and tran_id not in(select tran_id from tran_id_pair_pre) 
and tran_id not in(select tran_id from tran_id_pair_curr) 

and tran_id not in(select tran_id from tran_id_pair_pre_provision) 
and tran_id not in(select tran_id from tran_id_pair_curr_provision) 
and tran_id not in(select tran_id from tran_id_pair_cl_provision)
and tran_id not in(select tran_id from tran_id_pair_op_stock_in_trade) 
and tran_id not in(select tran_id from tran_id_pair_cl_stock_in_trade)
 group by a.gl_mas_code HAVING sum(debit-credit)>0
union all
select 'P' as typ, a.gl_mas_code, count(*) as cnt, 0.00 as received, sum(debit-credit) as transfer, 0.00 as Payment from mas_gl_tran as a where  a.gl_mas_code <> '28101'  and action_date=date('$start_dt')+$k* INTERVAL '1 Days' and  debit-credit>0 and tran_id not in (select tran_id from mas_gl_tran where gl_mas_code like '28101')
and tran_id not in(select tran_id from tran_id_pair_pre) 
and tran_id not in(select tran_id from tran_id_pair_curr) 

and tran_id not in(select tran_id from tran_id_pair_pre_provision) 
and tran_id not in(select tran_id from tran_id_pair_curr_provision) 
and tran_id not in(select tran_id from tran_id_pair_cl_provision)
and tran_id not in(select tran_id from tran_id_pair_op_stock_in_trade) 
and tran_id not in(select tran_id from tran_id_pair_cl_stock_in_trade)
 group by a.gl_mas_code
union all
select 'R' as typ, a.gl_mas_code, count(*) as cnt, 0.00 as received, sum(debit-credit) as transfer, 0.00 as Payment from mas_gl_tran as a where  a.gl_mas_code <> '28101'  and action_date=date('$start_dt')+$k* INTERVAL '1 Days' and  debit-credit>0 and tran_id not in (select tran_id from mas_gl_tran where gl_mas_code like '28101') 
and tran_id not in(select tran_id from tran_id_pair_pre) 
and tran_id not in(select tran_id from tran_id_pair_curr) 

and tran_id not in(select tran_id from tran_id_pair_pre_provision) 
and tran_id not in(select tran_id from tran_id_pair_curr_provision) 
and tran_id not in(select tran_id from tran_id_pair_cl_provision)
and tran_id not in(select tran_id from tran_id_pair_op_stock_in_trade) 
and tran_id not in(select tran_id from tran_id_pair_cl_stock_in_trade)
group by a.gl_mas_code
) as b where typ='P' and a.gl_mas_code=b.gl_mas_code group by b.gl_mas_code, a.gl_mas_desc";
//echo "<h1>$k:</h1>".$sql_statement;
$result=dBConnect($sql_statement);
echo "<td valign=\"top\" width=\"50%\">";
echo "<table width=\"100%\">";

echo "<tr><td bgcolor=\"green\" colspan=\"6\" align=\"center\"><font color=\"white\"><b>Payments</b></font></td></tr>";
$color=$TCOLOR;
	echo "<tr>";
	echo "<th align=left bgcolor=$color width=10%>GL Code</th>";
	echo "<th align=left bgcolor=$color width=35%>Account Name</th>";
	echo "<th align=right bgcolor=$color width=8%>Count</th>";
	echo "<th align=right bgcolor=$color width=15%>Cash</th>";
	echo "<th align=right bgcolor=$color width=15%>Transfer</th>";
	echo "<th align=right bgcolor=$color width=17%>Total</th></tr>";
	$vpaid=0;$vtransfer=0;
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
	echo "<td align=right bgcolor=$color>".amount2Rs($tot)."</td></tr>";
	$vpaid=$vpaid+$row['payment'];
	$vtransfer=$vtransfer+$row['transfer'];

}
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
echo "</table></td></tr>";
echo "<tr><td align=left><table width=\"100%\">";
echo "<tr>";
echo "<th bgcolor=$color width=10%></th>";
echo "<th bgcolor=$color width=35%>Total</th>";
echo "<th bgcolor=$color width=8%></th>";
echo "<th bgcolor=$color align=right width=15%>".amount2Rs($vreceived)."</th>";
echo "<th bgcolor=$color align=right width=15%>".amount2Rs($vrtransfer)."</th>";
echo "<th bgcolor=$color align=right width=17%>".amount2Rs($tot_r)."</th>";
echo "</tr>";
echo "</table></td>";
echo "<td align=left><table width=\"100%\">";
echo "<tr>";
echo "<th bgcolor=$color width=10%></th>";
echo "<th bgcolor=$color width=35%>Total</th>";
echo "<th bgcolor=$color width=8%></th>";
echo "<th bgcolor=$color align=right width=15%>".amount2Rs($vpaid)."</th>";
echo "<th bgcolor=$color align=right width=15%>".amount2Rs($vtransfer)."</th>";
echo "<th bgcolor=$color align=right width=17%>".amount2Rs($tot)."</th>";
echo "</table></td></tr>";
echo "</table>";

}
echo "</body>";
echo "</html>";
?>
