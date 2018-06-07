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
echo "<title>  Trial Balance";
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
echo "<table align=center width=\"100%\">";
echo "<tr><font size=+3>$SYSTEM_TITLE</font> <br><font size=+1><b>Report Date:".date('d.m.Y')."::".getPrintTime()."</b></font><hr></tr>";
echo "</table>";

//--------------------------------------------------------------------------------------------
$sql_statement="
SELECT gl_mas_code,gl_mas_desc,op_bal,curr_debit,curr_credit, cl_bal_debit from (
SELECT a.gl_mas_code,INITCAP(gl_mas_desc) as gl_mas_desc,SUM(op_bal) as op_bal, SUM(curr_debit) as curr_debit, SUM(curr_credit) as curr_credit, CASE WHEN SUM(op_bal+curr_debit-curr_credit)>0 THEN SUM(op_bal+curr_debit-curr_credit) ELSE 0 END AS cl_bal_debit, CASE WHEN SUM(op_bal+curr_debit-curr_credit)<0 THEN ABS(SUM(op_bal+curr_debit-curr_credit)) ELSE 0 END AS cl_bal_credit FROM ( 
-- opening balance asset/liability
SELECT a.gl_mas_code, SUM(debit-credit) as op_bal, 0.00 as curr_debit, 0.00 as curr_credit FROM mas_gl_tran as a WHERE action_date < '$start_date'  GROUP BY a.gl_mas_code HAVING CAST(gl_mas_code AS INT)<30000
UNION ALL
--current year transaction
SELECT a.gl_mas_code, 0.00 as op_bal, SUM(debit) as curr_debit, SUM(credit) as curr_credit FROM mas_gl_tran as a WHERE action_date BETWEEN '$start_date' and '$end_date'  

and tran_id not in(select tran_id from tran_id_pair_pre) 
and tran_id not in(select tran_id from tran_id_pair_curr) 
and tran_id not in(select tran_id from tran_id_pair_pre_provision) 
and tran_id not in(select tran_id from tran_id_pair_curr_provision) 
and tran_id not in(select tran_id from tran_id_pair_cl_provision)
and tran_id not in(select tran_id from tran_id_pair_op_stock_in_trade) 
and tran_id not in(select tran_id from tran_id_pair_cl_stock_in_trade) 
and tran_id not in(select tran_id from tran_id_pair_cl_provision2) 
GROUP BY a.gl_mas_code   
) as a, gl_master as b WHERE a.gl_mas_code=b.gl_mas_code GROUP BY a.gl_mas_code, b.gl_mas_desc ORDER BY a.gl_mas_code) foo";
echo "<table align=center width=\"100%\">";
echo "<tr><td bgcolor=\"green\" colspan=\"14\" align=\"center\"><font color=\"white\"><b>Trial Balance Before Adjustment</b></font></td></tr>";
echo "<table width=\"50%\" border=\"1\"  align=\"left\"cellspacing=\"0\" bordercolor=\"BLACK\" bordercolorlight=\"BLACK\" bordercolordark=\"BLACK\">";

echo "<tr>";
$color=$TCOLOR;
echo "<th bgcolor=$color colspan=\"1\">Code</th>";
echo "<th bgcolor=$color colspan=\"1\">Account Name</th>";

echo "<th bgcolor=$color colspan=\"1\">Balance-Dr</th>";

echo "</tr>";


$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4> No Transactions entered yet!!!</h4>";
} 
///////////////////////////////////////////////////////////////first loop
else {
for($j=0; $j<pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	if($row['cl_bal_debit']>0||$row['cl_bal_credit']){
	echo "<tr>";
	echo "<td align=left bgcolor=$color>".$row['gl_mas_code']."</td>";
	echo "<td align=left bgcolor=$color>".ucwords($row['gl_mas_desc'])."</td>";
	//echo "<td align=right bgcolor=$color>".amount2Rs($row['curr_debit'])."</td>";
	//echo "<td align=right bgcolor=$color>".amount2Rs($row['curr_credit'])."</td>";
	echo "<td align=right bgcolor=$color>".amount2Rs($row['cl_bal_debit'])."</td>";
	//echo "<td align=right bgcolor=$color>".amount2Rs($row['cl_bal_credit'])."</td>";
	$cldebit+=$row['cl_bal_debit'];
	$clcredit+=$row['cl_bal_credit'];
	}
	
} // for closed

	echo "<tr>";
	echo "<th align=left bgcolor=$color> </td>";
	echo "<th align=centre bgcolor=$color>Total</td>";
	//echo "<th align=right bgcolor=$color></td>";
	echo "<th align=right bgcolor=$color>".amount2Rs($cldebit)."</td>";
	//echo "<th align=right bgcolor=$color>".amount2Rs($clcredit)."</td>";
echo "<tr>";
echo "</table>";
}
echo "<table width=\"50%\" border=\"1\"  align=\"right\"cellspacing=\"0\" bordercolor=\"BLACK\" bordercolorlight=\"BLACK\" bordercolordark=\"BLACK\">";

echo "<tr>";
$color=$TCOLOR;
echo "<th bgcolor=$color colspan=\"1\">Code</th>";
echo "<th bgcolor=$color colspan=\"1\">Account Name</th>";

//echo "<th bgcolor=$color colspan=\"1\">Balance-Dr</th>";
echo "<th bgcolor=$color colspan=\"1\">Balance-Cr</th>";
echo "</tr>";
$sql_statement="
SELECT a.gl_mas_code,INITCAP(gl_mas_desc) as gl_mas_desc,SUM(op_bal) as op_bal, SUM(curr_debit) as curr_debit, SUM(curr_credit) as curr_credit, CASE WHEN SUM(op_bal+curr_debit-curr_credit)>0 THEN SUM(op_bal+curr_debit-curr_credit) ELSE 0 END AS cl_bal_debit, CASE WHEN SUM(op_bal+curr_debit-curr_credit)<0 THEN ABS(SUM(op_bal+curr_debit-curr_credit)) ELSE 0 END AS cl_bal_credit FROM ( 
-- opening balance asset/liability
SELECT a.gl_mas_code, SUM(debit-credit) as op_bal, 0.00 as curr_debit, 0.00 as curr_credit FROM mas_gl_tran as a WHERE action_date < '$start_date'  GROUP BY a.gl_mas_code HAVING CAST(gl_mas_code AS INT)<30000
UNION ALL
--current year transaction
SELECT a.gl_mas_code, 0.00 as op_bal, SUM(debit) as curr_debit, SUM(credit) as curr_credit FROM mas_gl_tran as a WHERE action_date BETWEEN '$start_date' and '$end_date'  
and tran_id not in(select tran_id from tran_id_pair_pre) 
and tran_id not in(select tran_id from tran_id_pair_curr) 
and tran_id not in(select tran_id from tran_id_pair_pre_provision) 
and tran_id not in(select tran_id from tran_id_pair_curr_provision) 
and tran_id not in(select tran_id from tran_id_pair_cl_provision) 
and tran_id not in(select tran_id from tran_id_pair_op_stock_in_trade) 
and tran_id not in(select tran_id from tran_id_pair_cl_stock_in_trade) 
and tran_id not in(select tran_id from tran_id_pair_cl_provision2) 
GROUP BY a.gl_mas_code 

union all
select gl_mas_code::text,op_bal,curr_debit,curr_credit
from (
select gl_mas_code::text,sum(op_bal) as op_bal,curr_debit,curr_credit,curr_bal,cl_bal_debit,cl_bal_credit from(
SELECT '12301' as gl_mas_code,SUM(debit-credit) as op_bal,0.00 as curr_debit,0.00 as curr_credit,0.00 as curr_bal, 0.00 as cl_bal_debit, 0.00 as cl_bal_credit from mas_gl_tran a,gl_master_vw b WHERE action_date<'$f_start_dt'  AND a.gl_mas_code=b.gl_mas_code group by bs_pl HAVING bs_pl='S' OR bs_pl='I' OR bs_pl='P' OR bs_pl='E' OR bs_pl='Z'
) a group by gl_mas_code::text,curr_debit,curr_credit,curr_bal,cl_bal_debit,cl_bal_credit)
 a 
  
) as a, gl_master as b WHERE a.gl_mas_code=b.gl_mas_code GROUP BY a.gl_mas_code, b.gl_mas_desc ORDER BY a.gl_mas_code ";

//echo "<h2>$sql_statement</h2>";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4> No Transactions entered yet!!!</h4>";
} else {
//echo "<table width=\"100%\" border=\"1\" cellspacing=\"0\" bordercolor=\"BLACK\" bordercolorlight=\"BLACK\" bordercolordark=\"BLACK\">";

//echo "<tr><td bgcolor=\"green\" colspan=\"7\" align=\"center\"><font color=\"white\"><b>Trial Balance Before Adjustment</b></font></td></tr>";

// Place line comments if you do not need column header.
$color=$TCOLOR;
/*
echo "<tr>";

echo "<th bgcolor=$color colspan=\"1\">Code</th>";
echo "<th bgcolor=$color colspan=\"1\">Account Name</th>";

echo "<th bgcolor=$color colspan=\"1\">Balance-Dr</th>";
echo "<th bgcolor=$color colspan=\"1\">Balance-Cr</th>";
echo "</tr>"; */
for($j=0; $j<pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	if($row['cl_bal_debit']>0||$row['cl_bal_credit']){
	echo "<tr>";
	echo "<td align=left bgcolor=$color>".$row['gl_mas_code']."</td>";
	echo "<td align=left bgcolor=$color>".ucwords($row['gl_mas_desc'])."</td>";
	//echo "<td align=right bgcolor=$color>".amount2Rs($row['curr_debit'])."</td>";
	//echo "<td align=right bgcolor=$color>".amount2Rs($row['curr_credit'])."</td>";
	//echo "<td align=right bgcolor=$color>".amount2Rs($row['cl_bal_debit'])."</td>";
	echo "<td align=right bgcolor=$color>".amount2Rs($row['cl_bal_credit'])."</td>";
	$cldebit1+=$row['cl_bal_debit'];
	$clcredit1+=$row['cl_bal_credit'];
	}
	
} // for closed

	echo "<tr>";
	echo "<th align=left bgcolor=$color> </td>";
	echo "<th align=centre bgcolor=$color>Total</td>";
	//echo "<th align=right bgcolor=$color></td>";
	//echo "<th align=right bgcolor=$color>".amount2Rs($cldebit)."</td>";
	echo "<th align=right bgcolor=$color>".amount2Rs($clcredit1)."</td>";
echo "<tr>";
echo "</table>";
}
echo "</table>";
echo "<br>";
echo "</body>";
echo "</html>";
?>
