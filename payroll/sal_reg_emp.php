<?
include "../config/config.php";
$id=$_REQUEST['id'];
$s="select * from emp_master where emp_id=$id";
$r=dBConnect($s);
$row1=pg_fetch_array($r,0);
$TCOLOR='#B3C2C9';
echo "<HTML>";
echo "<HEAD>";
echo "<title>Salary Register Detail";
echo "</title>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</HEAD>";
echo "<body bgcolor='#B1B1B1'>";
echo "<table bgcolor=\"#262A2B\" WIDTH=\"100%\" ALIGN=\"CENTER\">";
echo"<tr><td align='center' colspan='8'><font color='lightyellow'>Salary Register Details for :<font size=+1 color='white'> ".ucwords($row1['name'])."</td><td align='right' colspan='8'><font color='lightyellow'>Date of Retirement : ".$row1['dor']."</td></tr>";
echo "<tr>";
$color="#039EC5";
//echo "<h5><td bgcolor=$color  align='center' width='3%'>Id</td></h5>";
//echo "<h5><td bgcolor=$color  align='center' width='12%'>Name</td></h5>";  
echo "<h5><td bgcolor=$color  align='center' width='12%'>Year Month</td></h5>";                                            
echo "<h5><td bgcolor=$color  align='center' width='7%'>Basic</td></h5>";
//
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
echo "<h5><td bgcolor=$color  align='center' width='6%'>Gross Sal</td></h5>";
echo "<h5><td bgcolor=$color align='center' width='6%'>Total Deduction</td></h5>";

echo "<h5><td bgcolor=$color  align='center'  width='6%'>Net Sal</td></h5>";
echo "</tr>";
$sql_statement="select esr.emp_id, substr(esr.year_month,1,4) as yr,ltrim(substr(esr.year_month,5),'0') as mn,em.name,
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
		gross_sal ,
                puja_bonus,
                incentive,
                bnk_allowance,
		net_sal from emp_sal_reg esr, emp_master em
where em.emp_id=$id and esr.emp_id=em.emp_id order by esr.emp_id,year_month";
$result=dBConnect($sql_statement);
//echo $sql_statement;
for($j=0; $j<pg_NumRows($result); $j++)
 {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
echo "<tr>";
$tot_ded=$row['tot_deductions']+$loan_row['r_principal']+$loan_row['r_due_int'];
$gross=$row['basic']+$row['da']+$row['ma']+$row['incentive']+$row['tot_ot_payment']+$row['puja_bonus']+$row['bnk_allowance'];
$net=$gross-$tot_ded;
//echo "<td bgcolor=$color width='12%'>".$row['name']."</td>";
echo "<td bgcolor=$color width='5%'>".$month_array[$row['mn']].",".$row['yr']."</td>";
echo "<td bgcolor=$color width='7%'>".$row['basic']."</td>";
//echo "<td bgcolor=$color width='6%'>".$row['hra']."</td>";
echo "<td bgcolor=$color width='6%'>".$row['da']."</td>";
echo "<td bgcolor=$color width='6%'>".$row['hra']."</td>";
//echo "<td bgcolor=$color width='6%'>".$row['ca']."</td>";
echo "<td bgcolor=$color width='6%'>".$row['ma']."</td>";
//echo "<td bgcolor=$color width='6%'>".$row['bnk_allowance']."</td>";
//echo "<td bgcolor=$color width='6%'>".$row['incentive']."</td>";
echo "<td bgcolor=$color width='6%'>".$row['puja_bonus']."</td>";
//echo "<td bgcolor='green' width='6%'><font color='white'>".$row['tot_earnings']."</td>";
echo "<td bgcolor=$color width='7%'>".$row['empl_cont_pf']."</td>";
echo "<td bgcolor=$color width='7%'>".$row['emplee_cont_pf']."</td>";
//echo "<td bgcolor=$color width='6%'>".$row['ptax']."</td>";
//echo "<td bgcolor=$color width='6%'>".$row['itax']."</td>";

//echo "<td bgcolor=$color width='6%'>".$row['tot_deductions']."</td>";
echo "<td bgcolor=$color width='6%'>$gross</td>";
echo "<td bgcolor='#FD284A' width='6%'><font color='white'>".$row['tot_deductions']."</td>";
echo "<td bgcolor='#3594C5' width='6%'><font color='white'>$net</td>";
echo "</tr>";
}
echo "</table>";
echo "</body>";
echo "</html>";
?>

