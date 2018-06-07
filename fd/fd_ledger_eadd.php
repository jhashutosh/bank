<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST["menu"];
$t_status=$_REQUEST['t_status'];
$bank_account_no=$_REQUEST['bank_ac_no'];
$ch_no=$_REQUEST['ch_no'];
//echo "<h1>==$bank_account_no==$ch_no==$menu==$t_status</h1>";
$account_no=$_SESSION["current_account_no"];
$certificate_no=$_REQUEST["certificate_no"];
$date_with_effect=$_REQUEST["date_with_effect"];
$scheme=$_REQUEST["scheme"];
$holder_sb_account_no=$_REQUEST["holder_sb_account_no"];
$period=$_REQUEST["period"];
$amount_deposit=$_REQUEST["amount_deposit"];
$rate_of_interest=$_REQUEST["rate_of_interest"];
$total_interest=$_REQUEST["total_interest"];
$maturity_amount=$_REQUEST["maturity_amount"];
$maturity_date=$_REQUEST["maturity_date"];
if(empty($amount_deposit)){$amount_deposit=$AMOUNT_DEPOSIT_DEFAULT;}
if(empty($rate_of_interest)){$rate_of_interest=$RATE_OF_INTEREST_DEFAULT;}
if(empty($total_interest)){$total_interest=$TOTAL_INTEREST_DEFAULT;}
if(empty($maturity_amount)){$maturity_amount=$MATURITY_AMOUNT_DEFAULT;}
if(empty($withdrawal_amount)){$withdrawal_amount=$WITHDRAWAL_AMOUNT_DEFAULT;}
$opening_date=$_REQUEST['op_date'];
if(trim($t_status)=='q')
{$cheque_dt=$opening_date;}
if(empty($maturity_date)){$maturity_date=date("d.m.y");}
if(empty($withdrawal_date)){$withdrawal_date="01/01/1970";}
$scheme=getIndex($scheme_array,$scheme);
//$fy=$getFy($opening_date);
$fy=$_SESSION['fy'];
echo $fy;
echo "<html>";
echo "<head>";
echo "<title>Fix Deposit - Entry Form";
echo "</title>";
?>
<link rel="stylesheet" href="../retail/css/retail.css">
<?php
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<h1>Fix Deposit - Entry Form";
echo "</h1>";
echo "<h3>Your submission has been accepted.";
echo "</h3>";
echo "<hr>";
if(empty($fy)){
echo "<h1><center><b>You Can't Insert any value Into database Because Financial Year already Locked by administrator !!!!!!!!!";
}
else{
	 $t_id=getTranId();
	//echo "fy=$fy";
	 $gl_code=getGlCode4mCustomerAccount($account_no);
   	// Modification required to suite data type

	//GL_ledger_Hrd
	$sql_statement="INSERT INTO gl_ledger_hrd (tran_id,type,action_date, certificate_no,fy,operator_code,entry_time,cheque_no,cheque_dt)VALUES ('$t_id','$menu','$opening_date', '$certificate_no','$fy','$staff_id',CAST('$opening_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP),'$ch_no','$cheque_dt');";
	//Deposit_info
	$sql_statement=$sql_statement."INSERT INTO deposit_info (account_no, certificate_no, account_type, scheme, action_date,date_with_effect ,principal ,period, interest_rate, maturity_amount, maturity_date, sb_account_no,interest_method,operator_code, entry_time) VALUES ('$account_no','$certificate_no', '$menu', '$scheme','$opening_date','$date_with_effect', $amount_deposit,$period,$rate_of_interest,     $maturity_amount,'$maturity_date','$holder_sb_account_no','sp','$staff_id',CAST('$opening_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP));";
	
if(trim($t_status)=='c')
{
	//GL_ledger_Dtl
	$sql_statement=$sql_statement."INSERT INTO gl_ledger_dtl (tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES ('$t_id','$account_no','$gl_code',$amount_deposit,'Cr','cash');";

	$sql_statement=$sql_statement."INSERT INTO gl_ledger_dtl (tran_id,gl_mas_code,amount,dr_cr, particulars) VALUES ('$t_id','28101',$amount_deposit,'Dr','cash');";
	
}

if(trim($t_status)=='y')
{
	$sb_ac=$_REQUEST['sb_account_no'];
	if(accountVarification($sb_ac))
	{
		$gl_code_s=getGlCode4mCustomerAccount($sb_ac);
		//GL_ledger_Dtl
		$sql_statement=$sql_statement."INSERT INTO gl_ledger_dtl (tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES ('$t_id','$account_no','$gl_code',$amount_deposit,'Cr','Transfer From $sb_ac');";

		$sql_statement=$sql_statement."INSERT INTO gl_ledger_dtl (tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES ('$t_id','$sb_ac','$gl_code_s',$amount_deposit,'Dr','Transfer To $account_no');";
		
	}
}

if(trim($t_status)=='q')
{
	$bk_gl_code=getGlCode4mBank($bank_account_no);
	//GL_ledger_Dtl
	$sql_statement=$sql_statement."INSERT INTO gl_ledger_dtl (tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES ('$t_id','$account_no','$gl_code',$amount_deposit,'Cr','Transfer To $bank_account_no');";

	$sql_statement=$sql_statement."INSERT INTO gl_ledger_dtl (tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES ('$t_id','$bank_account_no','$bk_gl_code',$amount_deposit,'Dr','Transfer From $account_no');";
	
}
$result=dBConnect($sql_statement);
echo $sql_statement;
if(pg_affected_rows($result)<1) {
	echo "<div class='failed'><h3><font color=\"white\">Failed to update database.</font></h3></div>";	
	} 
else {
       header("location:../main/set_account.php?menu=$menu&account_no=$account_no");
}
}
echo "</body>";
echo "</html>";

?>
