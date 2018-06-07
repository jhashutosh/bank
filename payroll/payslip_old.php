<? 
include "../config/config.php";
$menu=$_REQUEST["menu"]; 
$staff_id=verifyAutho();
$id=$_REQUEST['id'];
$mm=$_REQUEST['mm'];
$yy=$_REQUEST['yy'];
$ym=$_REQUEST['ym'];
$time=date('d/m/Y H:i:s ');
//$sql_func="select emp_update_sal_reg($id,'$yy','$mm','$staff_id','$time')";
//$func=dBConnect($sql_func);
$sql="select * from emp_master a, emp_designation_mas b where a.emp_id=$id and a.id_emp_designation_mas=b.id ;";
$result=dBConnect($sql);
$row=pg_fetch_array($result,0);
$sql_statement="select * from emp_sal_reg where emp_id=$id and year_month like '$ym'";
$result1=dBConnect($sql_statement);
$row1=pg_fetch_array($result1,0);
$sql1="select to_char(to_timestamp(to_char(cast(substr(year_month,5)as integer),'99999'),'MM'),'MONTH') as month from emp_sal_reg where emp_id =$id
and year_month like '$ym' "; 
$result2=dBConnect($sql1);
$row2=pg_fetch_array($result2,0);
$mon=$row2['month'];
$lsql="select * from emp_staff_loan_dtl a,emp_master b where a.emp_id=$id and a.year_month like '$ym' and a.emp_id=b.emp_id";
$lres=dBConnect($lsql);
$lrow=pg_fetch_array($lres,0);
//echo $lsql;
$pfsql="select * from emp_pf_loan_dtl a,emp_pf_loan_hrd b where a.emp_id=$id and a.year_month like '$ym' and a.emp_id=b.emp_id";
$pfres=dBConnect($pfsql);
$pfrow=pg_fetch_array($pfres,0);
$pfsql1="select * from emp_pf_dtl where emp_id=$id";
$pfres1=dBConnect($pfsql1);
$pfrow1=pg_fetch_array($pfres1,0);
$DIPOSIT=$pfrow1['op_bal']+$pfrow1['total_empl_cont_pf_amt']+$pfrow1['total_emplee_cont_pf_amt'];
$loan="select * from emp_staff_loan_dtl where year_month='$ym' and emp_id=$id";
$loan_res=dBConnect($loan);
$loan_row=pg_fetch_array($loan_res,0);
echo"<HTML>";
echo"<head>";
//echo $psql;
echo"<TITLE>PAY SLIP</TITLE>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
//echo $row1['itax'];
echo"</head>";

echo"<BODY bgcolor='lightyellow'><table align='right'><tr><th><font color='darkblue'>$SYSTEM_TITLE</font></th></tr></table><br><center><H3> PAY SLIP</H3>
</center>";
echo"<table width=\"100%\">";
echo"<tr><td bgcolor='darkred' align='center'><font color='white' size='2'><b>Salary For Month : &nbsp;";
echo" $mon </font>of <font color='white' size='2'><b> $yy </td></table>";


echo"<table width=\"100%\" bgcolor='black'>
<tr>
<td bgcolor='white'>NAME:</td>
<td bgcolor='white'>".$row['name']."</td>
<td bgcolor='white'>FATHER's Name:</td>
<td bgcolor='white'>".$row['father_name']."</td>
<td bgcolor='white'>Designation:</td>
<td bgcolor='white'>".$row['desg_desc']."</td>
</tr>";
echo"<tr>
<td bgcolor='white'>Date of Birth:</td>
<td bgcolor='white'>".$row['dob']."</td>
<td bgcolor='white'>Joing Date:</td>
<td bgcolor='white'>".$row['doj']."</td>
<td bgcolor='white'>Retirement Date:</td>
<td bgcolor='white'>".$row['dor']."</td>
</tr>";
echo"<tr>
<td bgcolor='white'>Address:</td>
<td bgcolor='white'>".$row['address1']."</td>
<td bgcolor='white'>PF A/c no:</td>
<td bgcolor='white'>".$pfrow1['pf_ac_no']."</td>
<td bgcolor='white'>Total PF Deposit still now:</td>
<td bgcolor='white'>$DIPOSIT</td>
</tr>";
/*echo"<tr>
<td bgcolor='white'>Staff Loan Due:</td>
<td bgcolor='white'></td>
<td bgcolor='white'>Puja Advance due:</td>
<td bgcolor='white'></td>
<td bgcolor='white'>Consumer Store loan Due:</td>
<td bgcolor='white'></td>
</tr>";*/
echo"<tr>
<td bgcolor='white'>Present days:</td>
<td bgcolor='white'>".$row1['tot_present_days']."</td>
<td bgcolor='white'>Over time days</td>
<td bgcolor='white'>".$row1['tot_ot_days']."</td>
<td bgcolor='white'>Absent Days:</td>
<td bgcolor='white'>".$row1['tot_absent_days']."</td>
</tr>";
/*echo"<tr><td bgcolor='white'>Total CL till today:</td>
<td bgcolor='white'>".$row1['tot_casual_leave_till_today']."</td>
<td bgcolor='white'>Medical Leave till today:</td>
<td bgcolor='white'>".$row1['tot_medical_leave_till_today']."</td>
<td bgcolor='white'>Maturnity:</td>
<td bgcolor='white'>".$row1['tot_maturnity_leave_till_today']."</td>
</tr>*/
echo"</table>";
echo"<br>";

echo"<table width=\"80%\" bgcolor='black' align=\"center\">
<tr>
<th bgcolor='lightgreen' colspan='2' align=\"center\"><font color='white' size='2'><b>Earning</b></font></th>
<th bgcolor='orange' colspan='2' align=\"center\"><font color='white' size='2'><b>Deduction</b></font></th>
</tr><tr>
<td bgcolor='white' width=\"30%\" align=\"right\"></td>
<td bgcolor='white' width=\"10%\" align=\"center\">Rs.</td>
<td bgcolor='white' width=\"30%\" align=\"right\"></td>
<td bgcolor='white' width=\"10%\" align=\"center\">Rs.</td>
</tr>
<tr>
<td bgcolor='white' width=\"30%\" align=\"right\">Basic :</td>
<td bgcolor='white' width=\"10%\" align=\"right\">".$row1['basic']."</td>
<td bgcolor='white' width=\"30%\" align=\"right\">PF :</td>
<td bgcolor='white' width=\"10%\" align=\"right\">".$row1['emplee_cont_pf']."</td>
</tr>
<tr>
<td bgcolor='white' width=\"30%\" align=\"right\">DA :</td>
<td bgcolor='white' width=\"10%\" align=\"right\">".$row1['da']."</td>
<td bgcolor='white' width=\"30%\" align=\"right\">Service Bond Loan(Principal):</td>
<td bgcolor='white' width=\"10%\" align=\"right\">".$loan_row['r_principal']."</td>
</tr>
<tr>
<td bgcolor='white' width=\"30%\" align=\"right\">Medical(Fixed) :</td>
<td bgcolor='white' width=\"10%\" align=\"right\">".$row1['ma']."</td>
<td bgcolor='white' width=\"30%\" align=\"right\">Service Bond Loan(Interest):</td>
<td bgcolor='white' width=\"10%\" align=\"right\">".$loan_row['r_due_int']."</td>
</tr>
<tr>
<td bgcolor='white' width=\"30%\" align=\"right\">Incentive :</td>
<td bgcolor='white' width=\"10%\" align=\"right\"> ".$row1['incentive']."</td>
<td bgcolor='white' colspan='2' align=\"right\" ></td>
</tr>
<tr>
<td bgcolor='white' width=\"30%\" align=\"right\">Banking Allowance:</td>
<td bgcolor='white' width=\"10%\" align=\"right\"> ".$row1['bnk_allowance']."</td>
<td bgcolor='white' colspan='2' align=\"right\" ></td>
</tr>
<tr>
<td bgcolor='white' width=\"30%\" align=\"right\">Puja Bonus :</td>
<td bgcolor='white' width=\"10%\" align=\"right\"> ".$row1['puja_bonus']."</td>
<td bgcolor='white' colspan='2' align=\"right\" ></td>
</tr>
<tr>
<td bgcolor='white' width=\"30%\" align=\"right\">Overtime Payment</td>
<td bgcolor='white' width=\"10%\" align=\"right\" > ".$row1['tot_ot_payment']."</td>
<td bgcolor='white' colspan='2' align=\"right\" ></td>
</tr>";
$tot_ded=$row1['tot_deductions']+$loan_row['r_principal']+$loan_row['r_due_int'];
$gross=$row1['basic']+$row1['da']+$row1['ma']+$row1['incentive']+$row1['tot_ot_payment']+$row1['puja_bonus']+$row1['bnk_allowance'];
$net=$gross-$tot_ded;
echo"<tr>
<td bgcolor='white' align=\"right\"><font color='green' >GROSS</font></td>
<td bgcolor='white' align=\"right\">$gross</td>
<td bgcolor='white' align=\"right\"><font color='red'>TOTAL DEDUCTION</font></td>
<td bgcolor='white' align=\"right\">$tot_ded</td>
</tr>
<tr>";
$net_salary=$row1['net_sal']-$loan_row['r_principal']-$loan_row['r_due_int'];
echo"<td bgcolor='white' colspan='4' align=\"center\"><font color='blue'><b>NET PAY: Rs.$net</b></td>
</tr>
</table>
<table width=\"100%\">
<tr align=center>
<td><font color='GREEN'>LOAN INFORMATION</font></td>
</tr></table>";
echo"<table width=\"100%\" bgcolor='black'>
<tr align=center>
<td bgcolor='white' width=\"12%\" align=\"center\">Loan Type</td>
<td bgcolor='white' bgcolor='white' width=\"12%\" align=\"center\">Loan Date</td>
<td bgcolor='white' width=\"12%\" align=\"center\">Loan Amount</td>";
//echo"<td bgcolor='white' width=\"8%\"  align=\"center\">int. Rate</td>";
echo"<td bgcolor='white' width=\"12%\" align=\"center\">Received Principal</td>
<td bgcolor='white' width=\"12%\" align=\"center\">Due Principal</td>
<td bgcolor='white' width=\"12%\" align=\"center\">Received int.</td>";
//echo"<td bgcolor='white' width=\"12%\" align=\"center\">Due int.</td>";
echo"</tr>
<tr align=center>
<td bgcolor='white'width=\"12%\" align=\"center\">Service Bond Loan</td>
<td bgcolor='white'width=\"12%\" align=\"center\">".$lrow['loan_date']."</td>
<td bgcolor='white'width=\"12%\" align=\"center\">".$lrow['actual_amt']."</td>";
//echo"<td bgcolor='white' width=\"8%\"  align=\"center\">".$lrow['int_due_rate']."</td>";
echo"<td bgcolor='white'width=\"12%\" align=\"center\">".$lrow['r_principal']."</td>
<td bgcolor='white' width=\"12%\" align=\"center\">".$lrow['b_principal']."</td>
<td bgcolor='white' width=\"12%\" align=\"center\">".$lrow['r_due_int']."</td>";
//echo"<td bgcolor='white' width=\"12%\" align=\"center\">".$lrow['b_due_int']."</td>";
echo"</tr>";
/*echo"<tr align=center>
<td  bgcolor='white'width=\"12%\" align=\"center\">Puja Advance</td>
<td  bgcolor='white'width=\"12%\" align=\"center\"></td>
<td  bgcolor='white'width=\"12%\" align=\"center\"></td>
<td  bgcolor='white'width=\"8%\"  align=\"center\"></td>
<td  bgcolor='white'width=\"12%\" align=\"center\"></td>
<td bgcolor='white' width=\"12%\" align=\"center\"></td>
<td  bgcolor='white'width=\"12%\" align=\"center\"></td>
<td bgcolor='white' width=\"12%\" align=\"center\"></td>
</tr>
<tr align=center>
<td bgcolor='white' width=\"12%\" align=\"center\">Consumer Store Loan</td>
<td  bgcolor='white'width=\"12%\" align=\"center\"></td>
<td  bgcolor='white'width=\"12%\" align=\"center\"></td>
<td  bgcolor='white'width=\"8%\"  align=\"center\"></td>
<td bgcolor='white' width=\"12%\" align=\"center\"></td>
<td  bgcolor='white'width=\"12%\" align=\"center\"></td>
<td bgcolor='white' width=\"12%\" align=\"center\"></td>
<td  bgcolor='white'width=\"12%\" align=\"center\"></td>
</tr>
<tr align=center>
<td  bgcolor='white' width=\"12%\" align=\"center\">PF Loan</td>
<td  bgcolor='white' width=\"12%\" align=\"center\">".$pfrow['loan_date']."</td>
<td  bgcolor='white' width=\"12%\" align=\"center\">".$pfrow['actual_amt']."</td>
<td  bgcolor='white' width=\"8%\"  align=\"center\">".$pfrow['int_due_rate']."</td>
<td  bgcolor='white' width=\"12%\" align=\"center\">".$pfrow['r_principal']."</td>
<td  bgcolor='white' width=\"12%\" align=\"center\">".$pfrow['b_principal']."</td>
<td  bgcolor='white' width=\"12%\" align=\"center\">".$pfrow['r_due_int']."</td>
<td  bgcolor='white' width=\"12%\" align=\"center\">".$pfrow['b_due_int']."</td>
</tr>";*/
echo "<tr><td colspan='8' bgcolor='white' align='right'><input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"></td></tr> ";
echo"</table><br><br><br><br><br>";
echo"<table>";
echo"<tr><td>Signature of Accountant _________________________</td><td align='center'>Signature of Manager _________________________</td><td align='right'>Signature of Secretary _________________________</td></tr>";
echo"</table>
</BODY>
</HTML>";
?>
