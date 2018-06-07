<?php
include "../config/config.php";
$staff_id=verifyAutho();
$account_no=$_SESSION["current_account_no"];
$menu=$_REQUEST["menu"];
$pay_term=getIndex($payment_term_array,$_REQUEST['pay_term']);
$group_no=$_REQUEST['group_no'];
$applied_amount=$_REQUEST['applied_amount'];
$loan_amount=$_REQUEST['loan_amount'];
$loan_date=$_REQUEST['date_of_issue'];
$due_interest_rate=$_REQUEST['interest_rate'];
$overdue_interest_rate=$_REQUEST['overdue_interest_rate'];
$repay_date=$_REQUEST['repay_date'];
$period=$_REQUEST['period'];
$purpose=$_REQUEST['purpose'];
echo "<html>";
echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
$c_id=getCustomerId($account_no,$menu);
$flag1=getGeneralInfo_Customer($c_id);
if($flag1==1){
echo "<hr>";
$fy=getFy();
if(empty($fy)){
echo "<h1><center><b>You Can't Insert any value Into database Because Financial Year already Locked by administrator !!!!!!!!!";
}
else{
$t_id=getTranId();
$loan_sl_no=nextValue('loan_sl_no');
$c_id=getCustomerId($account_no,$menu);
$gl_code=getGlCode4mCustomerAccount($account_no);




//loan_ledger_hrd
$sql_statement="INSERT INTO loan_ledger_hrd (loan_serial_no,loan_type,customer_id,account_no,fy, issue_date,repay_date,period,int_due_rate,int_overdue_rate,applied_amount,payment_term,status,staff_id,gl_code,entry_time)VALUES('$loan_sl_no','$menu','$c_id','$account_no','$fy','$loan_date', '$repay_date',$period,$due_interest_rate,$overdue_interest_rate,$applied_amount,'$pay_term','op','$staff_id','$gl_code',now())";
//loan_issue_dtl
$sql_statement=$sql_statement.";INSERT INTO loan_issue_dtl (tran_id,loan_serial_no, account_no,action_date,loan_amount,b_principal,remarks,staff_id,entry_time) VALUES ('$t_id','$loan_sl_no','$account_no','$loan_date',$loan_amount,$loan_amount,'$remarks', '$staff_id',now())";
//office_detail
//$sql_statement=$sql_statement.";INSERT INTO office_detail(acc_no,off_name,addres,off_desi,dept,ph_no,boss_name,boss_mob_no,present_sal_hand) VALUES ('$account_no','$office','$addr','$desg','$depart', '$ph','$bname','$bph','$bmn','$psih'now())";


//gl_ledger_hrd
$sql_statement=$sql_statement.";INSERT INTO gl_ledger_hrd(tran_id,type,action_date,certificate_no,fy,operator_code,entry_time)VALUES('$t_id','$menu','$loan_date','$account_no','$fy','$staff_id',now())";
//gl_ledger_dtl
$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,account_no,amount,dr_cr, particulars) VALUES('$t_id','$gl_code','$account_no',$loan_amount,'Dr','loan issue')";
$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','28101',$loan_amount,'Cr','loan issue')";

echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_affected_rows($result)<1){
  echo "<br><h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
 }
else{
  echo "<h3><font color=\"Green\">Sucessfully inserted data into database.</font><br>Your Transaction Id:$t_id";
 echo "<br>Your Loan Amount:Rs. $loan_amount<br></h3>";
 echo "<font size=+2><a href=\"../main/set_account.php?menu=$menu&account_no=$account_no\">Click</a> here to go Statement"; 
	 }
    }
}

echo "</body>";
echo "</html>";
?>
