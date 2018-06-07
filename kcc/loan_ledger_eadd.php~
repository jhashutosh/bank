<?
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST["menu"];
$group_no=$_REQUEST['group_no'];
$c_id=$_REQUEST['customer_id'];

$loan_sl_no=$_REQUEST['loan_sl_no'];
$loan_account=$_REQUEST['loan_acc'];
$loan_limit=$_REQUEST['loan_limit'];
$appl_amount=$_REQUEST['applied_amount'];
$loan_amount=$_REQUEST['loan_amount'];
$loan_date=$_REQUEST['date_of_issue'];
$rate_of_int=$_REQUEST['interest_rate'];
$over_rate_of_int=$_REQUEST['overdue_interest_rate'];
$period=$_REQUEST['period'];
$purpose=$_REQUEST['purpose'];
echo "<html>";
echo "<head>";
echo "</head>";
echo "<body bgcolor=\"silver\">";

if ($menu=='shg'){
$c_id=getCustomerIdFromGroupId($group_no);
}

$fy=getFy();
if(empty($fy)){
echo "<h1><center><b>You Can't Insert any value Into database Because Financial Year already Locked by administrator !!!!!!!!!";
}
else{

$t_id=getTranId();
if($period>1){
$typeIn='mt';
$gl_code=getGlCode4LN($typeIn,$menu);
$account_no=getId($typeIn);
}
else{
$typeIn='st';
$gl_code=getGlCode4LN($typeIn,$menu);
$account_no=getId($typeIn);
}
$sql_statement="INSERT INTO loan_issue_dtl(tran_id, loan_serial_no,account_no,action_date,loan_amount,staff_id,entry_time)VALUES('$t_id','$loan_sl_no','$loan_account','$loan_date',$loan_amount,'$staff_id',now())";

$sql_statement=$sql_statement.";INSERT INTO gl_ledger_hrd(tran_id,type,action_date,fy,remarks, operator_code, entry_time) VALUES ('$t_id','shg','$action_date','$fy','$remarks', '$staff_id', now())";
$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','$gl_code',$loan_amount,'Dr','loan issue')";
$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','28101',$loan_amount,'Cr','loan issue')";
$sql_statement=$sql_statement.";INSERT INTO loan_ledger_hrd(loan_serial_no,customer_id,account_no,fy,issue_date,period,int_due_rate,int_overdue_rate,applied_amount,staff_id,entry_time)VALUES('$loan_sl_no','$c_id','$loan_account','$fy','$loan_date','$period','$rate_of_int','$over_rate_of_int','$appl_amount','$staff_id',now())";

echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_affected_rows($result)<1)
{
  echo "<br><h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
 
 }
else
 {
  echo "<br><h5><font color=\"GREEN\">Data entered into database.</font></h5>";
  header("Location:../main/set_account.php?menu=$menu&account_no=$group_no");
 }

}

echo "</body>";
echo "</html>";
?>
