<?php
include "../config/config.php";
$staff_id=verifyAutho();
$account_no=$_SESSION["current_account_no"];
$menu=$_REQUEST['menu'];
$withdrawn_type=$_REQUEST["status"];
$withdrawal_date=$_REQUEST["withdrawal_date"];
$fine=$_REQUEST["fine"];
$with_amount=$_REQUEST["with_amount"];
$principal=$_REQUEST['with_p'];
$total_interest=$_REQUEST['with_int'];
$principal-=$total_interest;
//if(empty($withdrawal_date)) { $withdrawal_date=date('d/m/Y'); }
$fy=getFy($withdrawal_date);
echo "<html>";
echo "<head>";
echo "<title>Fix Deposit - Entry Form";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<h1>Recurring Deposit Withdrawal - Entry Form";
echo "</h1>";
echo "<h3>Your submission has been accepted.";
echo "</h3>";
$id=getCustomerId($account_no,$menu);
$flag=getGeneralInfo_Customer($id);
if($flag==1){
echo "<hr>";
if(empty($fy)){
echo "<h1><center><b>You Can't Insert any value Into database Because Financial Year already Locked by administrator !!!!!!!!!";
}
else{
	 $t_id=getTranId();
	 $gl_code=getGlCode4mCustomerAccount($account_no);
	 $gl_code_int=getGlCodeInterest($gl_code,$menu);
	 $sql_statement="INSERT INTO gl_ledger_hrd (tran_id,type,action_date,certificate_no,fy,remarks, operator_code, entry_time) VALUES ('$t_id','rd','$withdrawal_date','$certificate_no','$fy','$remarks','$staff_id', CAST('$withdrawal_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
	$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars,account_no) VALUES('$t_id','$gl_code',$principal,'Dr','cash','$account_no')";//for principal
	$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars,account_no) VALUES
('$t_id','$gl_code_int',$total_interest,'Dr','cash','$account_no')";//for interest
       if($_REQUEST['t_status']=='y'){
		$sb_ac=$_REQUEST['sb_account_no'];
		if(accountVarification($sb_ac)){
		$gl_code_s=getGlCode4mCustomerAccount($sb_ac);
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code, account_no,amount,dr_cr, particulars) VALUES
('$t_id','$gl_code_s',upper('$sb_ac'),$with_amount,'Cr','transfer from RD')";
		 $insert_flag=true;
		}
		else{

			 $insert_flag=false;
		}

 		
	}
	else{
	$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars) VALUES
('$t_id','28101',$with_amount,'Cr','cash')";// for credit
        $insert_flag=true;
	}
        if($fine>0){
	$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code, account_no,amount,dr_cr, particulars) VALUES ('$t_id','57903','$account_no',$fine,'Cr','RD fine collection')";
	
	}
	$with_val+=$fine;
        $sql_statement=$sql_statement.";UPDATE deposit_info set  withdrawal_date= '$withdrawal_date',withdrawal_type=initcap('$withdrawn_type'),withdrawal_amount=$with_amount,withdrawal_interest=$total_interest,sb_account_no='$sb_ac' where account_no='$account_no' AND certificate_no='$account_no'";
        $sql_statement=$sql_statement.";UPDATE customer_account SET status='cl',closing_date= '$withdrawal_date' WHERE account_no='$account_no' AND status='op'";
}
echo $sql_statement;
if($insert_flag){
$result=dBConnect($sql_statement);
if(pg_affected_rows($result)<1) {
//	echo "<br><h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
	echo "<br><h3><font color=\"RED\">Failed to update database.</font></h3>";	
} 
else {
	//echo "<br><h5><font color=\"RED\">withdrawl has been completed.</font></h5>";
	header("location:../main/set_account.php?menu=rd&account_no=$account_no");
}
}
else{
	echo "<br><h3><font color=\"RED\">Please varify your Saving Account No Before Submit.</font></h3>";
}
}
echo "</body>";
echo "</html>";
?>
