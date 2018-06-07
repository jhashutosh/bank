<?
include "../config/config.php";
$status=$_REQUEST['status'];
$staff_id=verifyAutho();
$emp_id=$_REQUEST['id'];
$c_id=$_REQUEST['c_id'];
$inst_amt=$_REQUEST['inst_amt'];
$loan_ac_no=$_REQUEST['loan_ac_no'];
$loan_dt=$_REQUEST['ln_dt'];
$parts=explode('/',$loan_dt);
$loan_date=$parts[1].'/'.$parts[0].'/'.$parts[2];
$rpay_date=$_REQUEST['ln_rp_dt'];
$applied_amt=$_REQUEST['ap_am'];
$bal_amt=$_REQUEST['bal_am'];
echo $applied_amt;
$loan_amount=$_REQUEST['ac_am'];
$due_interest_rate=$_REQUEST['d_int'];
$tot_due_int_amt=$_REQUEST['d_int_am'];
$period=$_REQUEST['mnth'];
$s="select cast(substr('$rpay_date',5,11) as date)";
//echo $s;
$r=dBConnect($s);
$row=pg_fetch_array($r,0);
$repay_date=$row['substr'];
$days=round($_REQUEST['years']*365);
$fy=getFy();
if(empty($fy)){
echo "<h1><center><b>You Can't Insert any value Into database Because Financial Year already Locked by administrator !!!!!!!!!";
}
else{
$t_id=getTranId();
$gl_code='23610';
//$gl_code=getGlCode4mCustomerAccount($loan_ac_no);

//emp_pf_loan_hrd
$sql_statement="INSERT INTO emp_pf_loan_hrd (emp_id,pf_loan_ac_no,loan_date,repay_date,fy,applied_amt,actual_amt,b_principal,int_due_rate,tot_due_int_amt, period,operator_code ,entry_time,instalment_amt)VALUES
					   ($emp_id,'$loan_ac_no','$loan_date','$repay_date','$fy',$applied_amt,$loan_amount,$bal_amt,$due_interest_rate,$tot_due_int_amt,$period,'$staff_id',now(),$inst_amt)";
//gl_ledger_hrd
$sql_statement=$sql_statement.";INSERT INTO gl_ledger_hrd(tran_id,type,action_date,certificate_no,fy,operator_code,entry_time)VALUES('$t_id','op','$loan_date','$loan_ac_no','$fy','$staff_id',now())";
//gl_ledger_dtl
$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,account_no,amount,dr_cr, particulars) VALUES('$t_id','$gl_code','$loan_ac_no',$bal_amt,'Dr','pf loan')";
//$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','28101',$loan_amount,'Cr','pf loan')";

//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_affected_rows($result)<1){
  echo "<br><h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
 }
else{
  echo "<h3><font color=\"Green\">Sucessfully inserted data into database.</font><br>Your Transaction Id:$t_id";
 echo "<br>Your Loan Amount:Rs. $loan_amount<br></h3>";
}
}

echo "</body>";
echo "</html>";
?>

