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
$lsql="select a.actual_amt,a.loan_date,d.* from emp_pf_loan_hrd a,emp_pf_loan_dtl d,emp_master b where a.emp_id=$id and a.pf_loan_ac_no=d.pf_loan_ac_no and d.year_month like '$ym' and a.emp_id=b.emp_id";
$lres=dBConnect($lsql);
$lrow=pg_fetch_array($lres,0);
//echo $lsql;
$pfsql="select * from emp_pf_loan_dtl a,emp_pf_loan_hrd b where a.emp_id=$id and a.year_month like '$ym' and a.emp_id=b.emp_id";
$pfres=dBConnect($pfsql);
$pfrow=pg_fetch_array($pfres,0);
$pfsql1="select * from emp_pf_dtl where emp_id=$id";
$pfres1=dBConnect($pfsql1);
$pfrow1=pg_fetch_array($pfres1,0);
$DIPOSIT=$pfrow1['op_bal'];

$loan="select * from emp_pf_loan_dtl where year_month='$ym' and emp_id=$id";
$loan_res=dBConnect($loan);
$loan_row=pg_fetch_array($loan_res,0);
echo"<HTML>";
echo"<head>";
//echo $psql;
echo"<TITLE>PAY SLIP</TITLE>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
//echo $row1['itax'];
echo"</head>";

echo"<BODY bgcolor='#BABCBD'><table align='right' class='border'><tr><th><font color='darkblue'>$SYSTEM_TITLE</font></th></tr></table><br><center><H3> PAY SLIP</H3>
</center>";
echo"<table width=\"100%\" class='border'>";
echo"<tr><td bgcolor='#0079FF' align='center'><font color='white' size='2'><b>Salary For Month : &nbsp;";
echo" $mon </font>of <font color='white' size='2'><b> $yy </td></table>";


echo"<table width=\"100%\" bgcolor='#A1A1A1' class='border'>
<tr><td bgcolor='#656565'><font color='white'size='+1'>NAME:</td>
<td bgcolor='#A1A1A1'>".ucwords($row['name'])."</td>
<td bgcolor='#656565'><font color='white'size='+1'>FATHER's Name:</td>
<td bgcolor='#A1A1A1'>".ucwords($row['father_name'])."</td>
<td bgcolor='#656565'><font color='white'size='+1'>Designation:</td>
<td bgcolor='#A1A1A1'>".$row['desg_desc']."</td></tr><tr></tr>";

echo"<tr><td bgcolor='#656565'><font color='white'size='+1'>Date of Birth:</td>
<td bgcolor='#A1A1A1'>".$row['dob']."</td>
<td bgcolor='#656565'><font color='white'size='+1'>Joing Date:</td>
<td bgcolor='#A1A1A1'>".$row['doj']."</td>
<td bgcolor='#656565'><font color='white'size='+1'>Retirement Date:</td>
<td bgcolor='#A1A1A1'>".$row['dor']."</td></tr><tr></tr>";

echo"<tr><td bgcolor='#656565'><font color='white'size='+1'>Address:</td>
<td bgcolor='#A1A1A1'>".ucwords($row['address1'])."</td>
<td bgcolor='#656565'><font color='white'size='+1'>PF A/c no:</td>
<td bgcolor='#A1A1A1'>".$pfrow1['pf_ac_no']."</td>
<td bgcolor='#656565'><font color='white'size='+1'>Total PF Deposit still now:</td>";
$DEPOSIT=$DIPOSIT+$row1['empl_cont_pf_till_today']+$row1['empl_cont_pf_till_today'];
echo"<td bgcolor='#A1A1A1'>$DEPOSIT</td>
</tr>";
/*echo"<tr>
<td bgcolor='white'>Staff Loan Due:</td>
<td bgcolor='white'></td>
<td bgcolor='white'>Puja Advance due:</td>
<td bgcolor='white'></td>
<td bgcolor='white'>Consumer Store loan Due:</td>
<td bgcolor='white'></td>
</tr>";*/
$ot_s="select a.*,o.ot_days from emp_attendance_dtls a left outer join emp_overtime_dtl o on  a.year_month=o.year_month and o.emp_id=a.emp_id 
where a.year_month='$ym' and a.emp_id=$id";
$ot_r=dBConnect($ot_s);

$p_d=pg_result($ot_r,'tot_present_days');
$a_d=pg_result($ot_r,'tot_absent_days');
$o_d=pg_result($ot_r,'ot_days');


echo"<tr>
<td bgcolor='white'>Present days:</td>
<td bgcolor='white'>$p_d</td>
<td bgcolor='white'>Over time days</td>
<td bgcolor='white'>$o_d</td>
<td bgcolor='white'>Absent Days:</td>
<td bgcolor='white'>$a_d</td>
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

echo"<table width=\"80%\" bgcolor='black' align=\"center\" CLASS='border'>
<tr>
<th bgcolor='#118F55' colspan='2' align=\"center\"><font color='white' size='2'><b>Earning</b></font></th>
<th bgcolor='#FF003F' colspan='2' align=\"center\"><font color='white' size='2'><b>Deduction</b></font></th>
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
<td bgcolor='white' width=\"30%\" align=\"right\">PF Loan :</td>
<td bgcolor='white' width=\"10%\" align=\"right\">".$loan_row['r_principal']."</td>
</tr>
<tr>
<td bgcolor='white' width=\"30%\" align=\"right\">HRA :</td>
<td bgcolor='white' width=\"10%\" align=\"right\">".$row1['hra']."</td>
<td bgcolor='white' width=\"30%\" align=\"right\">PF Loan(Interest):</td>
<td bgcolor='white' width=\"10%\" align=\"right\">".$loan_row['r_due_int']."</td>
</tr>
<tr>
<td bgcolor='white' width=\"30%\" align=\"right\">Medical(Fixed) :</td>
<td bgcolor='white' width=\"10%\" align=\"right\"> ".$row1['ma']."</td>
<td bgcolor='white' colspan='2' align=\"right\" ></td>
</tr>
<tr>
<td bgcolor='white' width=\"30%\" align=\"right\">Special Allowance:</td>
<td bgcolor='white' width=\"10%\" align=\"right\"> ".$row1['bnk_allowance']."</td>
<td bgcolor='white' colspan='2' align=\"right\"></td>
</tr>

<tr>
<td bgcolor='white' width=\"30%\" align=\"right\">Key Allowance:</td>
<td bgcolor='white' width=\"10%\" align=\"right\"> ".$row1['incentive']."</td>
<td bgcolor='white' colspan='2' align=\"right\"></td>
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
echo"<tr>
<td bgcolor='white' align=\"right\"><font color='green' >GROSS</font></td>
<td bgcolor='white' align=\"right\">".$row1['gross_sal']."</td>
<td bgcolor='white' align=\"right\"><font color='red'>TOTAL DEDUCTION</font></td>
<td bgcolor='white' align=\"right\">$tot_ded</td>
</tr>
<tr>";
$net_salary=$row1['net_sal']-$loan_row['r_principal']-$loan_row['r_due_int'];
echo"<td bgcolor='white' colspan='4' align=\"center\"><font color='blue'><b>NET PAY: Rs.$net_salary</b></td>
</tr>
</table>
<table width=\"100%\">
<tr align=center>
<td><font color='GREEN'>LOAN INFORMATION</font></td>
</tr></table>";
echo"<table width=\"100%\" bgcolor='black' class='border'>
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
<td bgcolor='white'width=\"12%\" align=\"center\">PF Loan</td>
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
