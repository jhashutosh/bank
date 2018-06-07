<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST["menu"];
$op=$_REQUEST['op'];
$t_status=$_REQUEST['t_status'];
$bank_account_no=$_REQUEST['bank_ac_no'];
$ch_no=$_REQUEST['ch_no'];
//echo "<h1>$bank_account_no==$ch_no==$menu==$t_status</h1>";
$account_no=$_REQUEST["account_no"];
$certificate_no=$_REQUEST["certificate_no"];
$holder_sb_account_no=$_REQUEST["holder_sb_account_no"];
$total_interest=$_REQUEST["withdrawal_int"];
//$maturity_amount=$_REQUEST["maturity_amount"];
$maturity_date=$_REQUEST["maturity_date"];
$withdrawn_type=$_REQUEST["withdrawal_type"];
$principal=$_REQUEST['amount_deposit'];
$withdrawal_date=$_REQUEST["withdrawal_date"];
if(trim($t_status)=='q')
{$cheque_dt=$withdrawal_date;}
$with_val=$_REQUEST["withdrawal_amount"];
$remarks=$_REQUEST["remarks"];
$operator_code=$staff_id;
if(empty($withdrawal_date)) { $withdrawal_date=date('d/m/Y'); }
echo "<html>";
echo "<head>";
echo "<title>Update Form - Reinvestment";
echo "</title>";
?>
<link rel="stylesheet" href="../retail/css/retail.css">
<?php
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<h1>Update Form - Reinvestment";
echo "</h1>";
echo "<h3>Your submission has been accepted.";
echo "</h3>";
echo "<hr>";
$fy=getFy($withdrawal_date);
if(empty($fy)){
echo "<h1><center><b>You Can't Insert any value Into database Because Financial Year already Locked by administrator !!!!!!!!!";
}
else{
	 $t_id=getTranId();
	//echo "fy=$fy";
	 $gl_code=getGlCode4mCustomerAccount($account_no);
	 $gl_code_int=getGlCodeInterest($gl_code,$menu);
	 $sql_statement="INSERT INTO gl_ledger_hrd(tran_id,type, action_date,certificate_no,fy,remarks, operator_code, entry_time,cheque_no,cheque_dt) VALUES ('$t_id','ri','$withdrawal_date','$certificate_no','$fy','$remarks','$staff_id', now(),'$ch_no','$cheque_dt')";
//gl_details for Principal withdrawal --Dr.
	$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr,particulars) VALUES('$t_id','$account_no','$gl_code',$principal,'Dr','cash')";
//gl_details for Interest withdrawal --Dr.
	$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,account_no,amount,dr_cr, particulars) VALUES('$t_id','$gl_code_int','$account_no',$total_interest,'Dr','cash')";


	if(trim($t_status)=='c')
	{
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','28101',$with_val,'Cr','cash')";// for credit
		$sql_statement=$sql_statement.";UPDATE deposit_info set  withdrawal_date= '$withdrawal_date',withdrawal_type=initcap('$withdrawn_type'),withdrawal_amount=$with_val,withdrawal_interest=$total_interest where account_no='$account_no' AND certificate_no='$certificate_no'";
	}
	if(trim($t_status)=='y')
	{
		$sb_ac=$_REQUEST['sb_account_no'];
		if(accountVarification($sb_ac)){
		$gl_code_s=getGlCode4mCustomerAccount($sb_ac);
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code, account_no,amount,dr_cr, particulars) VALUES
('$t_id','$gl_code_s',upper('$sb_ac'),$with_val,'Cr','Transfer From $account_no')";
		 $insert_flag=true;

		 $sql_statement=$sql_statement.";UPDATE deposit_info set  withdrawal_date= '$withdrawal_date',withdrawal_type=initcap('$withdrawn_type'),withdrawal_amount=$with_val,withdrawal_interest=$total_interest,sb_account_no='$sb_ac' where account_no='$account_no' AND certificate_no='$certificate_no'";
		}
		else{

			 $insert_flag=false;
		}		
	}
	if(trim($t_status)=='q')
	{
		$bk_gl_code=getGlCode4mBank($bank_account_no);
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code, account_no,amount,dr_cr, particulars) VALUES
('$t_id','$bk_gl_code','$bank_account_no',$with_val,'Cr','Paid To $account_no')";
		
		  $sql_statement=$sql_statement.";UPDATE deposit_info set  withdrawal_date= '$withdrawal_date',withdrawal_type=initcap('$withdrawn_type'),withdrawal_amount=$with_val,withdrawal_interest=$total_interest,sb_account_no='$bank_account_no' where account_no='$account_no' AND certificate_no='$certificate_no'";
	}
}

//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_affected_rows($result)<1) {
	echo "<div class='failed'><h3><font color=\"white\">Failed to update database.</font></h3></div>";	
	} 
else {
	header("location:../main/set_account.php?menu=ri&account_no=$account_no");
}
echo "</body>";
echo "</html>";

?>
