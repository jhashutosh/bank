<?
include "../config/config.php";
$staff_id=verifyAutho();
//$start_date=$_REQUEST['start_date'];
//echo $start_date;
$end_date=$_REQUEST['end_date'];
//echo $end_date;
$f_start_dt=$_REQUEST['f_start_dt'];
$TBGCOLOR='white';
$TCOLOR='lightyellow';
//echo $f_start_dt;
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo"<head>";
echo"<title></title>";
echo"</head>";
echo"<body bgcolor='silver'>";
echo"<table valign=\"top\"width='100%' align='center'>";
$sql_statement="SELECT a.gl_mas_code,initcap(a.gl_mas_code), a.gl_mas_desc, a.op_bal,a.curr_debit,a.curr_credit,a.curr_bal,
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
for($j=0; $j<pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	echo "<tr>";
	echo "<td align=left bgcolor=$color width='7%' ><a href=\"gl_ledger.php?glc=".$row['gl_mas_code']."&edt=$end_date&sdt=$start_date\">".$row['gl_mas_code']."</a></td>";
	echo "<td align=left bgcolor=$color width='23%'>".ucwords($row['gl_mas_desc'])."</td>";
	$op_bal=trim($row['op_bal']);
	if($op_bal<0){$op_bal=amount2Rs(abs($op_bal))." <b>Cr.</b>";}
	else{$op_bal=amount2Rs(abs($op_bal))." <b>Dr.</b>";}
	echo "<td align=right bgcolor=$color style=\"height:29px;\" width='18%'>".$op_bal."</td>";
	echo "<td align=right bgcolor=$color width='9%'>".amount2Rs($row['curr_debit'])."</td>";
	echo "<td align=right bgcolor=$color width='10%'>".amount2Rs($row['curr_credit'])."</td>";
	echo "<td align=right bgcolor=$color  width='18%'>".amount2Rs($row['cl_bal_debit'])."</td>";
	echo "<td align=right bgcolor=$color  width='15%'>".amount2Rs($row['cl_bal_credit'])."</td></tr>";
	$vop+=$row['op_bal'];
	$vdebit+=$row['curr_debit'];
	$vcredit+=$row['curr_credit'];
	$cldebit+=$row['cl_bal_debit'];
	$clcredit+=$row['cl_bal_credit'];
	
	
} // for closed
if(pg_NumRows($result)>0){
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
echo "</tr>";
echo "</table></body>";
?>
