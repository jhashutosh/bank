<?php
include "../config/config.php";
$ym=$_REQUEST['ym'];
$year=$_REQUEST['yy'];
$mnth=$_REQUEST['mm'];
$ym=$year.$mnth;
$sql1="select to_char(to_timestamp(to_char(cast(substr(year_month,5)as integer),'99999'),'MM'),'MONTH') as month from emp_sal_reg where year_month like '$ym' "; 
$result2=dBConnect($sql1);
$row2=pg_fetch_array($result2,0);
$mon=$row2['month'];
echo "<HTML>";
echo "<HEAD>";
echo "<title>Salary Register Detail";
echo "</title>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</HEAD>";
echo "<body bgcolor='#C8C8C8'>";
echo "<table bgcolor=\"black\" WIDTH=\"100%\" ALIGN=\"CENTER\">";
echo"<tr><td align='center' colspan='16'><font color='lightyellow'>Salary Register Details for &nbsp;&nbsp; $mon &nbsp;&nbsp;&nbsp;$year</td></tr>";
echo"<tr><td align='center' colspan='16'><br></td></tr>";
//
echo "<tr>";
$color="lightgreen";
echo "<h5><td bgcolor=$color  align='center' width='3%'>Id</td></h5>";
echo "<h5><td bgcolor=$color  align='center' width='12%'>Name</td></h5>";                       
echo "<h5><td bgcolor=$color  align='center' width='7%'>Basic</td></h5>";
echo "<h5><td bgcolor=$color  align='center' width='6%'>DA</td></h5>";
echo "<h5><td bgcolor=$color  align='center' width='6%'>HRA</td></h5>";
//echo "<h5><td bgcolor=$color  align='center' width='6%'>CA</td></h5>";
echo "<h5><td bgcolor=$color  align='center' width='6%'>MA</td></h5>";
//echo "<h5><td bgcolor=$color  align='center' width='6%'>Banking Allowance</td></h5>";
//echo "<h5><td bgcolor=$color  align='center' width='6%'>Incentive</td></h5>";
echo "<h5><td bgcolor=$color  align='center' width='6%'>Puja Bonus</td></h5>";
//echo "<h5><td bgcolor=$color  align='center' width='6%'>Total Earning</td></h5>";
echo "<h5><td bgcolor=$color  align='center' width='7%'>Employer Cont PF</td></h5>";
echo "<h5><td bgcolor=$color  align='center' width='7%'>Employee Cont PF</td></h5>";
//echo "<h5><td bgcolor=$color align='center'  width='6%'>Ptax</td></h5>";
//echo "<h5><td bgcolor=$color  align='center' width='6%'>Itax</td></h5>";
echo "<h5><td bgcolor=$color  align='center' width='6%'>PF Deduction</td></h5>";
echo "<h5><td bgcolor=$color  align='center' width='6%'>PF Loan Deduction</td></h5>";
echo "<h5><td bgcolor=$color  align='center' width='6%'>Gross Sal</td></h5>";
echo "<h5><td bgcolor=$color  align='center'  width='6%'>Net Sal</td></h5>";
echo "</tr>";
//
$sql_statement="select esr.*,coalesce(epl.r_due_int,0) as r_due_int,coalesce(epl.r_principal,0) as r_principal  from (select esr.emp_id, em.name,esr.year_month,
                basic, 
		hra ,
		da ,
		ca ,
		ma,
		tot_earnings ,
		empl_cont_pf ,
		emplee_cont_pf ,
		ptax ,
		itax ,
		tot_deductions,
		gross_sal,
		net_sal,bnk_allowance,incentive,puja_bonus
from emp_sal_reg esr, emp_master em 
where  esr.emp_id=em.emp_id
and esr.year_month='$ym' order by esr.emp_id,esr.year_month) as esr

left outer join emp_pf_loan_dtl epl

on esr.year_month=epl.year_month
and esr.emp_id=epl.emp_id ";
$result=dBConnect($sql_statement);
//echo $sql_statement;
for($j=0; $j<pg_NumRows($result); $j++) {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
echo "<tr>";
//$tot_ded=$row['tot_deductions']+$loan_row['r_principal']+$loan_row['r_due_int'];
//$gross=$row['basic']+$row['da']+$row['ma']+$row['incentive']+$row['tot_ot_payment']+$row['puja_bonus']+$row['bnk_allowance'];
$net=$gross-$tot_ded;
echo "<td bgcolor=$color  width='3%'><a href=\"sal_reg_emp.php?id=".$row['emp_id']."\">".$row['emp_id']."</td>";
echo "<td bgcolor=$color width='12%'>".$row['name']."</td>";
echo "<td bgcolor=$color width='7%'>".$row['basic']."</td>";
//echo "<td bgcolor=$color width='6%'>".$row['hra']."</td>";
echo "<td bgcolor=$color width='6%'>".$row['da']."</td>";
echo "<td bgcolor=$color width='6%'>".$row['hra']."</td>";
//echo "<td bgcolor=$color width='6%'>".$row['ca']."</td>";
echo "<td bgcolor=$color width='6%'>".$row['ma']."</td>";
//echo "<td bgcolor=$color width='6%'>".$row['bnk_allowance']."</td>";
//echo "<td bgcolor=$color width='6%'>".$row['incentive']."</td>";
echo "<td bgcolor=$color width='6%'>".$row['puja_bonus']."</td>";
//echo "<td bgcolor=$color width='6%'>".$row['tot_earnings']."</td>";
echo "<td bgcolor=$color width='7%'>".$row['empl_cont_pf']."</td>";
echo "<td bgcolor=$color width='7%'>".$row['emplee_cont_pf']."</td>";
//echo "<td bgcolor=$color width='6%'>".$row['ptax']."</td>";
//echo "<td bgcolor=$color width='6%'>".$row['itax']."</td>";
echo "<td bgcolor=$color width='6%'>".$row['tot_deductions']."</td>";
echo "<td bgcolor=$color width='6%'>".($row['r_principal']+$row['r_due_int'])."</td>";
echo "<td bgcolor=$color width='6%'>".$row['gross_sal']."</td>";
echo "<td bgcolor=$color width='6%'>".($row['net_sal']-($row['r_principal']+$row['r_due_int']))."</td>";
echo "</tr>";}
echo "</table>";
echo "</body>";
echo "</html>";
?>

