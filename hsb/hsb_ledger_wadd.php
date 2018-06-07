<?
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST["menu"];
$account_no=$_REQUEST["account_no"];//request form input box
$certificate_no=$_REQUEST["certificate_no"];//request form input box
$holder_sb_account_no=$_REQUEST["holder_sb_account_no"];
$total_interest=$_REQUEST["withdrawal_int"];
//$maturity_amount=$_REQUEST["maturity_amount"];
$maturity_date=$_REQUEST["maturity_date"];
$withdrawn_type=$_REQUEST["withdrawal_type"];
$principal=$_REQUEST['amount_deposit'];//request form input box
$withdrawal_date=$_REQUEST["withdrawal_date"];//request form input box
$with_val=$_REQUEST["withdrawal_amount"];
$with_pri=$with_val-$total_interest;
$remarks=$_REQUEST["remarks"];//request form input box
$operator_code=$staff_id;
if(empty($withdrawal_date)) { $withdrawal_date=date('d/m/Y'); }
echo "<html>";
echo "<head>";
echo "<title>Update Form - HSB";
echo "</title>";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<h1>Update Form - Reinvestment";
echo "</h1>";
echo "<h3>Your submission has been accepted.";
echo "</h3>";
echo "<hr>";
$fy=getFy();
if(empty($fy)){
echo "<h1><center><b>You Can't Insert any value Into database Because Financial Year already Locked by administrator !!!!!!!!!";
}
else{
	 $t_id=getTranId();
	//echo "fy=$fy";
	 $gl_code=getGlCode4mCustomerAccount($account_no);
	 $gl_code_int=getGlCodeInterest($gl_code,$menu);






/*$sql_statement="INSERT INTO gl_ledger_hrd (tran_id,type,action_date,certificate_no,fy,remarks, operator_code, entry_time) VALUES ('$t_id','rd','$withdrawal_date','$certificate_no','$fy','$remarks','$staff_id', CAST('$withdrawal_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
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
	}*/

	 $sql_statement="INSERT INTO gl_ledger_hrd (tran_id,type,action_date,certificate_no,fy,remarks, operator_code, entry_time) VALUES ('$t_id','hsb','$withdrawal_date','$certificate_no','$fy','$remarks','$staff_id', now())";
	$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars,account_no) VALUES('$t_id','$gl_code',$with_pri,'Dr','cash','$account_no')";//for principal
	$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars,account_no) VALUES
('$t_id','$gl_code_int',$total_interest,'Dr','cash','$account_no')";//for interest


if($_REQUEST['t_status']=='y'){
		$sb_ac=$_REQUEST['sb_account_no'];
		if(accountVarification($sb_ac)){
		$gl_code_s=getGlCode4mCustomerAccount($sb_ac);
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code, account_no,amount,dr_cr, particulars) VALUES
('$t_id','$gl_code_s',upper('$sb_ac'),$with_val,'Cr','transfer from HSB')";
		 $insert_flag=true;
		}
		else{

			 $insert_flag=false;
		}

 		
	}
	else{







       $sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars) VALUES
('$t_id','28101',$with_val,'Cr','cash')";// for credit
}
       $sql_statement=$sql_statement.";UPDATE deposit_info set  withdrawal_date= '$withdrawal_date',withdrawal_type='$withdrawn_type',withdrawal_amount=$with_val,withdrawal_interest=$total_interest where account_no='$account_no' AND certificate_no='$certificate_no'";

}
echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_affected_rows($result)<1) {
//	echo "<br><h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
	echo "<br><h3><font color=\"RED\">Failed to update database.</font></h3>";	
} 
else {
	//echo "<br><h5><font color=\"RED\">withdrawl has been completed.</font></h5>";
	header("location:../main/set_account.php?menu=hsb&account_no=$account_no");
}
echo "</body>";
echo "</html>";

?>
