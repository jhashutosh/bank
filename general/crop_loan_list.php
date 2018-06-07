<?php
include "../config/config.php";
?>
<HTML>
<HEAD>
<TITLE>Crop Wise Loan Statement</TITLE>
<SCRIPT LANGUAGE="JavaScript">
function closeme() { close(); }
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
</HEAD>
<?php

$staff_id=verifyAutho();
$fy=$_REQUEST['fy'];
getDetailFy($fy,$f_start_dt,$f_end_dt);
if(empty($start_date) ) { $start_date=$f_start_dt; }
$end_date=$_REQUEST["end_date"];
if(empty($end_date) ) { $end_date=$f_end_dt;}
$menu=$_REQUEST['menu'];
$crop_id=$_REQUEST['crop_id'];
if(empty($crop_id)){
$link="crop_loan_list.php?menu=kcc&fy=$fy&crop_id=";
}
else{
$str="(".getName('crop_id',trim($crop_id),'crop_desc','crop_mas').")";
$link="../kcc/kcc_loan_statement.php?menu=kcc&op=i&account_no=";
}
echo "<body bgcolor=\"silver\">";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<font size=+3>$SYSTEM_TITLE</font> <br><font size=+1><b>Report Date:".date('d.m.Y')."::".getPrintTime()."</b></font><hr>";
echo "<form name=\"f1\" action=\"crop_loan_list.php?menu=$menu\" method=\"POST\" onsubmit=\"return check();\">";
echo "<table align=center bgcolor=\"#90EE90\"><tr><td  align=\"\"><b>Financial Year :<td>";
makeSelectFromDB("fy_list","fy","fy");
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> ";
echo "</table></form>";
echo "<hr>";
//-------------------------------------------------------------------------------------------
if(!empty($fy)){
if(empty($crop_id)){
$sql_statement="SELECT crop_id, round(SUM(op_balance)) as op_balance,round(SUM(loan_amount)) AS loan_amount,round(SUM(insurance)) AS insurance,round(SUM(p_due_int)) AS p_due_int,round(SUM(p_odue_int)) AS p_odue_int,round(SUM(p_r_principal)) AS p_r_principal,round(SUM(p_balance)) AS p_balance,round(SUM(c_due_int)) AS c_due_int,round(SUM(c_odue_int)) AS c_odue_int,round(SUM(c_r_principal)) AS c_r_principal,round(SUM(c_balance)) AS c_balance FROM(
SELECT crop_id,SUM(loan_amount-r_principal) as op_balance,0 as loan_amount, 0 as insurance,0 as p_due_int,0 as p_odue_int,0 as p_r_principal,SUM(loan_amount-r_principal) as p_balance,0 as c_due_int,0 as c_odue_int,0 as c_r_principal,0 as c_balance FROM loan_statement_dtl where loan_type='kcc' and fy<'$fy' AND action_date<='$f_start_dt' GROUP BY crop_id
UNION ALL
SELECT crop_id,0 as op_balance,0 as loan_amount,0 as insurance,SUM(r_due_int) as p_due_int,SUM(r_overdue_int) as p_odue_int,SUM(r_principal) as p_r_principal,SUM(loan_amount-r_principal) as p_balance,0 as c_due_int,0 as c_odue_int,0 as c_r_principal,0 as c_balance FROM loan_statement_dtl where loan_type='kcc' and fy<'$fy' AND action_date BETWEEN '$f_start_dt' AND '$f_end_dt' GROUP BY crop_id
UNION ALL
SELECT crop_id,0 as op_balance,SUM(loan_amount) as loan_amount,SUM(insurance) AS insurance,0 as p_due_int,0 as p_odue_int,0 as p_r_principal,0 as p_balance,SUM(r_due_int) as r_due_int,SUM(r_overdue_int) as r_odue_int,SUM(r_principal) as r_r_principal,SUM(loan_amount-r_principal) as r_balance FROM loan_statement_dtl where loan_type='kcc' and fy='$fy' AND action_date<='$f_end_dt' GROUP BY crop_id
) AS foo GROUP BY crop_id ORDER BY crop_id";
}
else
{
$sql_statement="SELECT account_no, round(SUM(op_balance)) as op_balance,round(SUM(loan_amount)) AS loan_amount,round(SUM(insurance)) AS insurance,round(SUM(p_due_int)) AS p_due_int,round(SUM(p_odue_int)) AS p_odue_int,round(SUM(p_r_principal)) AS p_r_principal,round(SUM(p_balance)) AS p_balance,round(SUM(c_due_int)) AS c_due_int,round(SUM(c_odue_int)) AS c_odue_int,round(SUM(c_r_principal)) AS c_r_principal,round(SUM(c_balance)) AS c_balance FROM(
SELECT account_no,SUM(loan_amount-r_principal) as op_balance,0 as loan_amount, 0 as insurance,0 as p_due_int,0 as p_odue_int,0 as p_r_principal,SUM(loan_amount-r_principal) as p_balance,0 as c_due_int,0 as c_odue_int,0 as c_r_principal,0 as c_balance FROM loan_statement_dtl where crop_id='$crop_id' AND loan_type='kcc' and fy<'$fy' AND action_date<='$f_start_dt' GROUP BY account_no
UNION ALL
SELECT account_no,0 as op_balance,0 as loan_amount,0 as insurance,SUM(r_due_int) as p_due_int,SUM(r_overdue_int) as p_odue_int,SUM(r_principal) as p_r_principal,SUM(loan_amount-r_principal) as p_balance,0 as c_due_int,0 as c_odue_int,0 as c_r_principal,0 as c_balance FROM loan_statement_dtl where crop_id='$crop_id' AND loan_type='kcc' and fy<'$fy' AND action_date BETWEEN '$f_start_dt' AND '$f_end_dt' GROUP BY account_no
UNION ALL
SELECT account_no,0 as op_balance,SUM(loan_amount) as loan_amount,SUM(insurance) AS insurance,0 as p_due_int,0 as p_odue_int,0 as p_r_principal,0 as p_balance,SUM(r_due_int) as r_due_int,SUM(r_overdue_int) as r_odue_int,SUM(r_principal) as r_r_principal,SUM(loan_amount-r_principal) as r_balance FROM loan_statement_dtl where crop_id='$crop_id' AND loan_type='kcc' and fy='$fy' AND action_date<='$f_end_dt' GROUP BY account_no
) AS foo GROUP BY account_no ORDER BY account_no";
}
//echo $sql_statement; 
$result=dBConnect($sql_statement);
echo "<Table bgcolor=\"Black\" width=\"100%\" >";
echo "<tr><th bgcolor=\"Yello\" colspan=\"15\" align=center><font color=\"white\">Crop Wise Loan Statement on $fy $str</font>";
$color="GREEN";
if(empty($crop_id)){
echo "<tr><th bgcolor=$color Rowspan=\"3\">Crop</th>";
}
else{
echo "<tr><th bgcolor=$color Rowspan=\"3\">A/C No.</th>";
}
echo "<th bgcolor=$color Rowspan=\"3\">Opening<br>Balance</th>";
echo "<th bgcolor=$color Colspan=\"2\">Current Year</th>";
echo "<th bgcolor=$color Colspan=\"9\">Recovery</th>";
echo "<th bgcolor=$color Colspan=\"3\">Balance</th>";
echo "<tr>";
echo "<th bgcolor=$color Rowspan=\"2\">Insurance<br>Collection</th>";
echo "<th bgcolor=$color Rowspan=\"2\">Loan<br>Issue</th>";
echo "<th bgcolor=$color Colspan=\"3\">Principal</th>";
echo "<th bgcolor=$color Colspan=\"3\">Due Interest</th>";
echo "<th bgcolor=$color Colspan=\"3\">Over Due Int.</th>";
echo "<th bgcolor=$color Rowspan=\"2\">Previous<br>year</th>";
echo "<th bgcolor=$color Rowspan=\"2\">Current<br>year</th>";
echo "<th bgcolor=$color Rowspan=\"2\">Total</th>";
echo "<tr>";
echo "<th bgcolor=$color>Previous</th>";
echo "<th bgcolor=$color >Current</th>";
echo "<th bgcolor=$color >Total</th>";
echo "<th bgcolor=$color >Previous</th>";
echo "<th bgcolor=$color >Current</th>";
echo "<th bgcolor=$color >Total</th>";
echo "<th bgcolor=$color >Previous</th>";
echo "<th bgcolor=$color >Current</th>";
echo "<th bgcolor=$color >Total</th>";
if(pg_NumRows($result)>0){
for($j=1; $j<=pg_NumRows($result); $j++){
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j-1));
echo "<tr>";
//echo "<table valign=\"top\" width=\"100%\" align=center>";
if(empty($crop_id)){
echo "<td align=CENTER bgcolor=$color width =\"68\"><a href=\"$link".$row['crop_id']."\">".getName('crop_id',trim($row['crop_id']),'crop_desc','crop_mas')."</a></td>";
}
else{
echo "<td align=CENTER bgcolor=$color width =\"68\"><a href=\"$link".$row['account_no']."\">".$row['account_no']."</a></td>";
}
$t_op_bal+=$row['op_balance'];
echo "<td bgcolor=$color align=right>".amount2Rs($row['op_balance'])."</td>";
$t_insurance+=$row['insurance'];
echo "<td align=right bgcolor=$color width=\"80\">".amount2Rs($row['insurance'])."</td>";
$t_ln_amount+=$row['loan_amount'];
echo "<td align=right bgcolor=$color width=\"80\">".amount2Rs($row['loan_amount'])."</td>";

$t_p_p+=$row['p_r_principal'];
echo "<td align=right bgcolor=$color width =\"75\">".amount2Rs($row['p_r_principal'])."</td>";
$t_c_p+=$row['c_r_principal'];
echo "<td align=right bgcolor=$color width =\"75\">".amount2Rs($row['c_r_principal'])."</td>";
echo "<td align=right bgcolor=$color width =\"75\">".amount2Rs($row['c_r_principal']+$row['p_r_principal'])."</td>";
$t_p_d+=$row['p_due_int'];
echo "<td align=right bgcolor=$color width =\"75\">".amount2Rs($row['p_due_int'])."</td>";
$t_c_d+=$row['c_due_int'];
echo "<td align=right bgcolor=$color width =\"75\">".amount2Rs($row['c_due_int'])."</td>";
echo "<td align=right bgcolor=$color width =\"75\">".amount2Rs($row['c_due_int']+$row['p_due_int'])."</td>";
$t_p_od+=$row['p_odue_int'];
echo "<td align=right bgcolor=$color width =\"75\">".amount2Rs($row['p_odue_int'])."</td>";
$t_c_od+=$row['c_odue_int'];
echo "<td align=right bgcolor=$color width =\"75\">".amount2Rs($row['c_odue_int'])."</td>";
echo "<td align=right bgcolor=$color width =\"75\">".amount2Rs($row['c_odue_int']+$row['p_odue_int'])."</td>";
$t_p_bal+=$row['p_balance'];
echo "<td align=right bgcolor=$color width =\"75\">".amount2Rs($row['p_balance'])."</td>";
$t_c_bal+=$row['c_balance'];
echo "<td align=right bgcolor=$color width =\"75\">".amount2Rs($row['c_balance'])."</td>";
echo "<td align=right bgcolor=$color width =\"75\">".amount2Rs($row['c_balance']+$row['p_balance'])."</td>";
  }
echo "<tr bgcolor=\"AQUA\"><th colspan=\"1\">Total:<th align=\"right\">".amount2Rs($t_op_bal)."<th align=\"right\">".amount2Rs($t_insurance)."<th align=\"right\">".amount2Rs($t_ln_amount)."<th align=\"right\">".amount2Rs($t_p_p)."<th align=\"right\">".amount2Rs($t_c_p)."<th align=\"right\">".amount2Rs(($t_c_p+$t_p_p))."<th align=\"right\">".amount2Rs($t_p_d)."<th align=\"right\">".amount2Rs($t_c_d)."<th align=\"right\">".amount2Rs(($t_c_d+$t_p_d))."<th align=\"right\">".amount2Rs($t_p_od)."<th align=\"right\">".amount2Rs($t_c_od)."<th align=\"right\">".amount2Rs(($t_c_od+$t_p_od))."<th align=\"right\">".amount2Rs($t_p_bal)."<th align=\"right\">".amount2Rs($t_c_bal)."<th align=\"right\">".amount2Rs(($t_p_bal+$t_c_bal));
}
}
echo "</body>";
echo "</html>";

?>
