<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST["menu"];
// PHP4 
$account_no=$_SESSION["current_account_no"];
$action_date=$_REQUEST["action_date"];
$particulars=$_REQUEST["particulars"];
$bank_charge=$_REQUEST['bank_charge'];
//$deposits=$_REQUEST["deposits"];
$set_balance=$_REQUEST["closing_bal"];
$remarks=$_REQUEST["remarks"];
//$particulars=getIndex($bank_withdrawal_particulars_array,$particulars);
$balance=sb_current_balance($account_no);
$interest=$_REQUEST["interest"];
$set_balance=$interest+$balance-$bank_charge;
$id=getCustomerId($account_no,$menu);
echo "<html>";
echo "<head bgcolor=\"silver\">";
echo "<title>Entry Form - Saving Bank";
echo "</title>";
echo "</head>";
echo "<body bgcolor=\"silver\">";
$title='Saving Bank';
echo "<h1>Update Form - $title";
echo "</h1>";
echo "<h3>Your submission has been accepted.";
echo "</h3>";
echo "<hr>";
$fy=getFy();
if(empty($fy)){
echo "<h1><center><b>You Can't Insert any value Into database Because Financial Year already Locked by administrator !!!!!!!!!";
}
else{
	 
	//echo "fy=$fy";
	 $gl_code=getGlCode4mCustomerAccount($account_no);
//If Interest Given By bank on closing date
	 if($interest>0){
	 $t_id=getTranId();
	 $gl_int=getGlCode4interestPaid($gl_code,$menu);
	$sql_statement="INSERT INTO gl_ledger_hrd(tran_id,type, action_date,fy,remarks, operator_code, entry_time) VALUES ('$t_id','sb','$action_date','$fy','', '$staff_id', now())";
	$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','$gl_int',$interest,'Dr','$particulars')";
	$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars,account_no) VALUES('$t_id','$gl_code',$interest,'Cr','int.','$account_no')";
$result=dBConnect($sql_statement);
//echo $sql_statement;
if(pg_affected_rows($result)<1) {
	echo "<br><h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
	} 
}
//===============================================================================================
//If bank charge reducted from a/c for closing
 if($bank_charge>0){
	 $t_id=getTranId();
	 $gl_int=getGlCode4interestPaid($gl_code,$menu);
	$sql_statement="INSERT INTO gl_ledger_hrd(tran_id,type, action_date,fy,remarks, operator_code, entry_time) VALUES ('$t_id','sb','$action_date','$fy','service Charge', '$staff_id', now())";
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars,account_no) VALUES('$t_id','$gl_code',$bank_charge,'Dr','bank charge','$account_no')";
$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','57903',$bank_charge,'Cr','service charge')";
$result=dBConnect($sql_statement);
//echo $sql_statement;
if(pg_affected_rows($result)<1) {
	echo "<br><h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
	} 
}
//-----------------------------------------------------------------------------------------------
	$t_id=getTranId();
	$sql_statement="INSERT INTO gl_ledger_hrd(tran_id,type, action_date,fy,remarks, operator_code, entry_time) VALUES ('$t_id','sb','$action_date','$fy','$remarks', '$staff_id', now())";
	$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars,account_no) VALUES('$t_id','$gl_code',$set_balance,'Dr','$particulars','$account_no')";
	$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','28101',$set_balance,'Cr','$particulars')";
       $sql_statement=$sql_statement.";UPDATE customer_account SET  closing_date='$action_date',status='cl' where account_no='$account_no'";
	if(isSHG($id)){
	  	$sql_statement.=";UPDATE shg_info SET status='cl' WHERE customer_id='$id'";  
	}
// Modification required to suite data type

$result=dBConnect($sql_statement);
echo $sql_statement;
if(pg_affected_rows($result)<1) {
	echo "<br><h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
} else {
	  header("location:../main/set_account.php?menu=sb&account_no=$account_no");
       }
}

echo "</body>";
echo "</html>";
?>
