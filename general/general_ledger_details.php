<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$code=$_REQUEST['gl_code'];
$op=$_REQUEST['op'];
$print_time=getPrintTime();
$end_date=$_REQUEST["end_date"];
getDetailFy($fy,$f_start_dt,$f_end_dt);
$start_date=$_REQUEST["start_date"];
if(empty($start_date) ) { $start_date=$f_start_dt; }
$end_date=$_REQUEST["end_date"];
if(empty($end_date) ) { $end_date=$f_end_dt;}
echo "<html>";
echo "<head>";
echo "<title>$PROJECT_TITLE</title>";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "<script language=\"JAVASCRIPT\">";
echo "function closeme() { close(); }";
echo "</script>";
//echo "<script src=\"../JS/date_validation.js\"></script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
?>
<SCRIPT LANGUAGE="JavaScript">
function check(){
f_s_dt=document.f1.f_start_dt.value;
f_e_dt=document.f1.f_end_dt.value;
start_dt=document.f1.start_date.value;
end_dt=document.f1.end_date.value;

if(!IsDateLess(f_s_dt,start_dt)){
	alert("Starting Date beyond of starting date of Financial Year")
	document.f1.start_date.focus();
	return false;
}
if(!IsDateLess(start_dt,f_e_dt)){
	alert("Starting Date beyond of ending date of Financial Year")
	document.f1.start_date.focus();
	return false;
}
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
<?php
echo "</head>";
echo "<body bgcolor=\"\">";
echo "<font size=+3>$SYSTEM_TITLE</font> <br><font size=+1><b>Report Date:".date('d.m.Y')."::".getPrintTime()."</b></font><hr>";
echo "<form name=\"f1\" action=\"general_ledger_details.php?gl_code=$code\" method=\"POST\" onsubmit=\"return check();\">";

echo "<table align=center bgcolor=\"#90EE90\"><tr><td  align=\"\"><b>Date Between (DD/MM/YYYY) :<td><input type=TEXT size=12 name=\"start_date\" id=\"start_date\" value=\"$start_date\"  maxlength=\"10\" onFocus=\"javascript:vDateType='1'\" onKeyUp=\"DateFormat(this,this.value,event,false,'3')\" onBlur=\"DateFormat(this,this.value,event,true,'3')\" $HIGHLIGHT>&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.start_date,'dd/mm/yyyy','Choose Date')\"> AND <input type=TEXT size=12 name=\"end_date\" id =\"end_date\" value=\"$end_date\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.end_date,'dd/mm/yyyy','Choose Date')\">";
echo "<input type=\"HIDDEN\" name=\"f_start_dt\" id=\"f_start_dt\" value=\"$f_start_dt\">";
echo "<input type=\"HIDDEN\" name=\"f_end_dt\" id=\"f_end_dt\" value=\"$f_end_dt\">";
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> ";
echo "</table></form>";

echo "<hr>";
$tdate="'".$start_date."'";
$op_bal=glBalanceFromDetails($tdate,$code,'Dr');
echo "<table valign=\"top\" width=\"100%\" class=\"border\">";
echo "<tr><td bgcolor=\"green\" colspan=\"5\" align=\"center\"><b>".ucwords(findGlDesc($code))."[$code] As On $end_date";
echo "<tr>";
$color="#FFDEAD";
echo "<th bgcolor=$color rowspan=\"2\">Date</th>";
echo "<th bgcolor=$color rowspan=\"2\">Particulars</th>";
echo "<th bgcolor=$color rowspan=\"2\">Transction Id</th>";
echo "<th bgcolor=$color colspan=\"2\">Amount</th><tr>";
echo "<th bgcolor=$color>Dr.(Rs.)</th>";
echo "<th bgcolor=$color>Cr.(Rs.)</th>";
$color=$TSCOLOR;
echo "<tr><td bgcolor=$color>$start_date</td>";
echo "<td bgcolor=$color><b>Balance b/d </b></td>";
echo "<td bgcolor=$color>";
if($op_bal<0){
echo "<td bgcolor=$color><td align=right bgcolor=$color><b>".amount2Rs(abs($op_bal))."</b></td>";
$c_amount+=abs($op_bal);
}
else{
$d_amount+=$op_bal;
echo "<td align=right bgcolor=$color><b>".amount2Rs($op_bal)."</b></td><td bgcolor=$color>";
}
$sql_statement="SELECT h.tran_id, h.type, h.action_date, d.gl_mas_code, d.account_no, h.certificate_no, d.amount, d.qty, d.particulars, d.dr_cr, h.fy, h.remarks
FROM gl_ledger_hrd h, gl_ledger_dtl d WHERE h.tran_id= d.tran_id AND d.gl_mas_code <> '$code' AND h.tran_id IN ( SELECT gl_ledger_dtl.tran_id FROM gl_ledger_dtl WHERE gl_ledger_dtl.gl_mas_code = '$code') AND h.action_date BETWEEN '$start_date' AND '$end_date' ORDER BY action_date";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
for($j=0; $j<pg_NumRows($result); $j++) {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
echo "<tr>";
echo "<td bgcolor=$color>".$row['action_date'];
echo "<td bgcolor=$color>".ucwords(findGlDesc($row['gl_mas_code']))."[".$row['account_no']."]";
echo "<td align=right bgcolor=$color><a href =\"../general/voucherdetails.php?tran_id=".$row['tran_id']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=700,height=500'); return false;\" >".$row['tran_id']."</a></td>";
	if(trim($row['dr_cr'])=='Cr'){
	$d_amount+=(float)$row['amount'];
	echo "<td bgcolor=$color align=right>".amount2Rs($row['amount']);
	echo "<td bgcolor=$color>";
 	} else{
	echo "<td bgcolor=$color>";
	$c_amount+=(float)$row['amount'];
	echo "<td bgcolor=$color align=right>".amount2Rs($row['amount']);
		}

 	}
}
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$edate="date('$end_date')+INTERVAL '1 days'";
$cl_bal=glBalanceFromDetails($edate,$code,'Dr');
echo "<tr><td bgcolor=$color>$end_date</td>";
echo "<td bgcolor=$color><b>Balance c/d </b></td>";
echo "<td bgcolor=$color>";
if($cl_bal>0){
$c_amount+=$cl_bal;
echo "<td bgcolor=$color><td align=right bgcolor=$color><b>".amount2Rs($cl_bal)."</b></td>";
}
else{
$d_amount+=abs($cl_bal);
echo "<td align=right bgcolor=$color><b>".amount2Rs(abs($cl_bal))."</b></td><td bgcolor=$color>";
}
echo "<tr bgcolor=AQUA>";
echo "<th colspan=\"3\">Total:$j Ledger Entry Found!!!!!!!!!";
echo "<th align=\"RIGHT\">".amount2Rs($d_amount);
echo "<th align=\"RIGHT\">".amount2Rs($c_amount);
echo "</table>";
?>
