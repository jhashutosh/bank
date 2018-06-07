
<?
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$fy=$_SESSION['fy'];
getDetailFy($fy,&$f_start_dt,&$f_end_dt);
$start_date=$_REQUEST["start_date"];
if(empty($start_date) ) { $start_date=$f_start_dt; }
$end_date=$_REQUEST["end_date"];
if(empty($end_date) ) { $end_date=$f_end_dt;}
echo "<html>";
echo "<head>";
echo "<title>  Trial Balance After Adjestment";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "<script src=\"../JS/date_validation.js\"></script>";
//echo "<script src=\"../JS/dateValidation.js\"></script>";
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
<?
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<font size=+3>$SYSTEM_TITLE</font> <br><font size=+1><b>Report Date:".date('d.m.Y')."::".getPrintTime()."</b></font><hr>";
echo "<form name=\"f1\" action=\"trial_balance.php\" method=\"POST\" onsubmit=\"return check();\">";

echo "<table align=center bgcolor=\"#90EE90\"><tr><td  align=\"\"><b>Date Between (DD/MM/YYYY) :<td><input type=TEXT size=12 name=\"start_date\" id=\"start_date\" value=\"$start_date\"  maxlength=\"10\" onFocus=\"javascript:vDateType='1'\" onKeyUp=\"DateFormat(this,this.value,event,false,'3')\" onBlur=\"DateFormat(this,this.value,event,true,'3')\" $HIGHLIGHT>&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.start_date,'dd/mm/yyyy','Choose Date')\"> AND <input type=TEXT size=12 name=\"end_date\" id =\"end_date\" value=\"$end_date\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.end_date,'dd/mm/yyyy','Choose Date')\">";
echo "<input type=\"HIDDEN\" name=\"f_start_dt\" id=\"f_start_dt\" value=\"$f_start_dt\">";
echo "<input type=\"HIDDEN\" name=\"f_end_dt\" id=\"f_end_dt\" value=\"$f_end_dt\">";
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> ";

echo "</table></form>";

//--------------------------------------------------------------------------------------------
$sql_statement="
SELECT a.gl_mas_code,initcap(a.gl_mas_code), a.gl_mas_desc, a.op_bal,a.curr_debit,a.curr_credit,a.curr_bal,
case when a.cl_bal_debit>a.cl_bal_credit then (a.cl_bal_debit - a.cl_bal_credit)  else 0 end as cl_bal_debit,
case when a.cl_bal_credit>a.cl_bal_debit then (a.cl_bal_credit - a.cl_bal_debit)  else 0 end as cl_bal_credit

from
(
SELECT a.gl_mas_code,initcap(a.gl_mas_code), b.gl_mas_desc, SUM(op_bal) as op_bal, SUM(curr_debit) as  curr_debit, SUM(curr_credit) as curr_credit, SUM(curr_bal) as curr_bal, SUM(cl_bal_debit) as cl_bal_debit, SUM(cl_bal_credit) as cl_bal_credit FROM ( 

SELECT a.gl_mas_code, 0.00 as op_bal, SUM(debit) as curr_debit, SUM(credit) as curr_credit, SUM(debit-credit) as curr_bal,0.00 as cl_bal_debit, 0.00 as cl_bal_credit FROM mas_gl_tran as a WHERE action_date BETWEEN '$start_date' and '$end_date' 
and tran_id not in(select tran_id from tran_id_pair_pre_provision1) 
and tran_id not in(select tran_id from tran_id_pair_curr_provision1) 
GROUP BY a.gl_mas_code
UNION ALL

SELECT a.gl_mas_code, 0.00 as op_bal, 0.00 as curr_debit, 0.00 as curr_credit, 0.00 as curr_bal,SUM(debit-credit) as cl_bal_debit, 0.00 as cl_bal_credit FROM mas_gl_tran as a WHERE action_date <= '$end_date' and action_date>='$f_start_dt'
and tran_id not in(select tran_id from tran_id_pair_pre_provision1) 
and tran_id not in(select tran_id from tran_id_pair_curr_provision1) 
GROUP BY a.gl_mas_code  HAVING SUM(debit-credit)>0
UNION ALL

SELECT a.gl_mas_code, 0.00 as op_bal, 0.00 as curr_debit, 0.00 as curr_credit, 0.00 as curr_bal, 0.00 as cl_bal_debit, SUM(credit-debit) as cl_bal_credit FROM mas_gl_tran as a WHERE action_date <= '$end_date' and action_date>='$f_start_dt'
and tran_id not in(select tran_id from tran_id_pair_pre_provision1) 
and tran_id not in(select tran_id from tran_id_pair_curr_provision1) 
GROUP BY a.gl_mas_code HAVING SUM(debit-credit)<=0 
UNION ALL

select gl_mas_code,op_bal,curr_debit,curr_credit,curr_bal,CASE WHEN SUM(op_bal)>0 THEN SUM(op_bal) ELSE 0 END AS cl_bal_debit, CASE WHEN SUM(op_bal)<0 THEN ABS(SUM(op_bal)) ELSE 0 END AS cl_bal_credit from(
SELECT a.gl_mas_code, SUM(debit-credit) as op_bal, 0.00 as curr_debit, 0.00 as curr_credit, 0.00 as curr_bal, 0.00 as cl_bal_debit, 0.00 as cl_bal_credit FROM mas_gl_tran as a WHERE action_date < '$start_date' 
--and tran_id not in(select tran_id from tran_id_pair_pre_provision1) 
--and tran_id not in(select tran_id from tran_id_pair_curr_provision1) 
GROUP BY a.gl_mas_code  HAVING CAST(gl_mas_code AS INT)<30000
--UNION ALL
) foo group by gl_mas_code,op_bal,curr_debit,curr_credit,curr_bal having op_bal<>0

UNION ALL 
SELECT a.gl_mas_code, SUM(debit-credit) as op_bal, 0.00 as curr_debit, 0.00 as curr_credit, 0.00 as curr_bal, 0.00 as cl_bal_debit, 0.00 as cl_bal_credit FROM mas_gl_tran as a WHERE action_date>='$f_start_dt' AND action_date<'$start_date' 
and tran_id not in(select tran_id from tran_id_pair_pre_provision1) 
and tran_id not in(select tran_id from tran_id_pair_curr_provision1) 
GROUP BY a.gl_mas_code  HAVING CAST(gl_mas_code AS INT)>30000

union all
select gl_mas_code::text,op_bal,curr_debit,curr_credit,curr_bal,CASE WHEN SUM(op_bal)>0 THEN SUM(op_bal) ELSE 0 END AS cl_bal_debit, CASE WHEN SUM(op_bal)<0 THEN ABS(SUM(op_bal)) ELSE 0 END AS cl_bal_credit 
from (
select gl_mas_code::text,sum(op_bal) as op_bal,curr_debit,curr_credit,curr_bal,cl_bal_debit,cl_bal_credit from(
SELECT '12301' as gl_mas_code,SUM(debit-credit) as op_bal,0.00 as curr_debit,0.00 as curr_credit,0.00 as curr_bal, 0.00 as cl_bal_debit, 0.00 as cl_bal_credit from mas_gl_tran a,gl_master_vw b WHERE action_date<'$f_start_dt'  AND a.gl_mas_code=b.gl_mas_code group by bs_pl HAVING bs_pl='S' OR bs_pl='I' OR bs_pl='P' OR bs_pl='E' OR bs_pl='Z'
) a group by gl_mas_code::text,curr_debit,curr_credit,curr_bal,cl_bal_debit,cl_bal_credit)
 a group by gl_mas_code::text,op_bal,curr_debit,curr_credit,curr_bal having op_bal<>0

) as a, gl_master as b WHERE a.gl_mas_code=b.gl_mas_code GROUP BY a.gl_mas_code, b.gl_mas_desc ORDER BY a.gl_mas_code


) a";

//echo "<h2>$sql_statement</h2>";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4> No Transactions entered yet!!!</h4>";
} else {
echo "<table width=\"100%\">";

echo "<tr><td bgcolor=\"green\" colspan=\"7\" align=\"center\"><font color=\"white\"><b>Trial Balance</b></font></td>";

// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";

echo "<th bgcolor=$color colspan=\"1\">Code</th>";
echo "<th bgcolor=$color colspan=\"1\">Account Name</th>";
echo "<th bgcolor=$color colspan=\"1\">Op Balance</th>";
echo "<th bgcolor=$color colspan=\"1\">Debit</th>";
echo "<th bgcolor=$color colspan=\"1\">Credit</th>";
echo "<th bgcolor=$color colspan=\"1\">Balance-Dr</th>";
echo "<th bgcolor=$color colspan=\"1\">Balance-Cr</th>";
echo "<tr><td colspan=\"7\" align=center><iframe src=\"trial_blnc_frm.php?end_date=$end_date&start_date=$start_date&f_start_dt=$f_start_dt\" width=\"100%\" height=\"400\" ></iframe></td></tr>";
/*for($j=0; $j<pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	echo "<tr>";
	echo "<td align=left bgcolor=$color><a href=\"gl_ledger.php?glc=".$row['gl_mas_code']."&edt=$end_date&sdt=$start_date\">".$row['gl_mas_code']."</a></td>";
	echo "<td align=left bgcolor=$color>".ucwords($row['gl_mas_desc'])."</td>";
	$op_bal=trim($row['op_bal']);
	if($op_bal<0){$op_bal=amount2Rs(abs($op_bal))." <b>Cr.</b>";}
	else{$op_bal=amount2Rs(abs($op_bal))." <b>Dr.</b>";}
	echo "<td align=right bgcolor=$color>".$op_bal."</td>";
	echo "<td align=right bgcolor=$color>".amount2Rs($row['curr_debit'])."</td>";
	echo "<td align=right bgcolor=$color>".amount2Rs($row['curr_credit'])."</td>";
	echo "<td align=right bgcolor=$color>".amount2Rs($row['cl_bal_debit'])."</td>";
	echo "<td align=right bgcolor=$color>".amount2Rs($row['cl_bal_credit'])."</td>";
	$vop+=$row['op_bal'];
	$vdebit+=$row['curr_debit'];
	$vcredit+=$row['curr_credit'];
	$cldebit+=$row['cl_bal_debit'];
	$clcredit+=$row['cl_bal_credit'];
	
	
} // for closed
/*
$sql_statement=
"SELECT SUM(op_bal) as op_bal,SUM(curr_debit) as t_debit,SUM(curr_credit) as t_credit,SUM(cl_bal_debit) as debit,SUM(cl_bal_credit) as credit FROM (
SELECT a.gl_mas_code, 0.00 as op_bal, SUM(debit) as curr_debit, SUM(credit) as curr_credit, SUM(debit-credit) as curr_bal,0.00 as cl_bal_debit, 0.00 as cl_bal_credit FROM mas_gl_tran as a WHERE action_date BETWEEN '$start_date' and '$end_date' GROUP BY a.gl_mas_code
UNION ALL
SELECT a.gl_mas_code, 0.00 as op_bal, 0.00 as curr_debit, 0.00 as curr_credit, 0.00 as curr_bal,SUM(debit-credit) as cl_bal_debit, 0.00 as cl_bal_credit FROM mas_gl_tran as a WHERE action_date <= '$end_date' GROUP BY a.gl_mas_code  HAVING SUM(debit-credit)>0
UNION ALL
SELECT a.gl_mas_code, 0.00 as op_bal, 0.00 as curr_debit, 0.00 as curr_credit, 0.00 as curr_bal, 0.00 as cl_bal_debit, SUM(credit-debit) as cl_bal_credit FROM mas_gl_tran as a WHERE action_date <= '$end_date' GROUP BY a.gl_mas_code HAVING SUM(debit-credit)<=0 
UNION ALL
SELECT a.gl_mas_code, SUM(debit-credit) as op_bal, 0.00 as curr_debit, 0.00 as curr_credit, 0.00 as curr_bal, 0.00 as cl_bal_debit, 0.00 as cl_bal_credit FROM mas_gl_tran as a WHERE action_date < '$start_date' GROUP BY a.gl_mas_code  HAVING CAST(gl_mas_code AS INT)<30000
UNION ALL 
SELECT a.gl_mas_code, SUM(debit-credit) as op_bal, 0.00 as curr_debit, 0.00 as curr_credit, 0.00 as curr_bal, 0.00 as cl_bal_debit, 0.00 as cl_bal_credit FROM mas_gl_tran as a WHERE action_date>='$f_start_dt' AND action_date<'$start_date' GROUP BY a.gl_mas_code  HAVING CAST(gl_mas_code AS INT)>30000
) as a";*/
//echo $sql_statement;
//$result=dBConnect($sql_statement);*/
/*if(pg_NumRows($result)>0){
	echo "<tr>";
	echo "<th align=left bgcolor=$color> </td>";
	echo "<th align=centre bgcolor=$color>Total</td>";
	echo "<th align=right bgcolor=$color></td>";
	//echo "<th align=right bgcolor=$color></td>";
	echo "<th align=right bgcolor=$color>".amount2Rs($vdebit)."</td>";
	echo "<th align=right bgcolor=$color>".amount2Rs($vcredit)."</td>";
	echo "<th align=right bgcolor=$color>".amount2Rs($cldebit)."</td>";
	echo "<th align=right bgcolor=$color>".amount2Rs($clcredit)."</td>";
	 
}
echo "<tr>";*/
echo "</table>";

}
echo "<br>";
echo "</body>";
echo "</html>";
?>
