<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST["menu"];
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
$opening_date=$_REQUEST['op_date'];
$ac_no=$account_no;
//-----------------------------------------------------------------
$ren_type=$_REQUEST['ren_type'];
$ren_certificate_no=$_REQUEST['ren_certificate_no'];
$ren_int=$_REQUEST['ren_int'];
$prin=$_REQUEST['prin'];
//-----------------------------------------------------------------
$with_val=$prin+$ren_int;
$scheme=getIndex($scheme_array,$scheme);
$fy=$_SESSION['fy'];

echo "<html>";
echo "<head>";
echo "<title>Fix Deposit - Entry Form";
echo "</title>";
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


	 $gl_code=getGlCode4mCustomerAccount($account_no);

 	 $t_id=getTranId();
	 $gl_code_int=getGlCodeInterest($gl_code,$menu);

	 $sql_statement="INSERT INTO gl_ledger_hrd 
(tran_id,type,action_date,certificate_no,fy,remarks, operator_code, entry_time) 
VALUES 
('$t_id','fd','$opening_date','$certificate_no','$fy','$remarks','$staff_id',now())";

	$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl
(tran_id,gl_mas_code,amount,dr_cr, particulars,account_no) 
VALUES
('$t_id','$gl_code',$prin,'Dr','renew','$account_no')";//for principal

$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl
(tran_id,gl_mas_code,amount,dr_cr, particulars,account_no) 
VALUES
('$t_id','$gl_code',$prin,'Cr','renew','$account_no')";//for principal

if ($ren_int>0)
{

		 $t_id=getTranId();

	$sql_statement=$sql_statement.";INSERT INTO gl_ledger_hrd 
	(tran_id,type,action_date, certificate_no,fy,operator_code,entry_time)
	VALUES 
	('$t_id','$menu','$opening_date', '$certificate_no','$fy','$staff_id',now());";

	$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl
	(tran_id,gl_mas_code,amount,dr_cr, particulars,account_no) 
	VALUES
	('$t_id','$gl_code_int',$ren_int,'Dr','interest','$account_no')";//for interest

	if ($ren_type=='ca_with') 
	{
		$int_cr="28101"; 
		$account_no=null;
	}
	if ($ren_type=='tot') 
	{
		$int_cr=$gl_code; 
		$particular="renew";
	}
	if ($ren_type=='tr_sb') 
	{
		$int_cr=getGlCode4mCustomerAccount($holder_sb_account_no);
		$account_no=$holder_sb_account_no;
		$particular="From FD Renew";
	}

	       $sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr,account_no,particulars) VALUES
	('$t_id','$int_cr',$ren_int,'Cr','$account_no','$particular')";// for credit

}

$sql_statement.=";UPDATE deposit_info set 
withdrawal_date='$opening_date',
withdrawal_type='Mature',
withdrawal_amount=coalesce(withdrawal_interest,0)+$with_val,
withdrawal_interest=coalesce(withdrawal_interest,0)+$ren_int
where account_no='$ac_no' 
AND certificate_no='$ren_certificate_no'";


//Deposit_info
$sql_statement.=";INSERT INTO deposit_info 
	(account_no, 
	certificate_no, 
	account_type, 
	scheme, 
	action_date,
	date_with_effect ,
	principal ,
	period, 
	interest_rate, 
	maturity_amount, 
	maturity_date, 
	sb_account_no,
	interest_method,
	operator_code, 
	entry_time) 
VALUES 
	('$ac_no',
	'$certificate_no', 
	'$menu', 
	'$scheme',
	'$opening_date',
	'$date_with_effect', 
	 $amount_deposit,
	 $period,
	 $rate_of_interest,     
	 $maturity_amount,
	'$maturity_date',
	'$holder_sb_account_no',
	'sp',
	'$staff_id',
	now())";

$result=dBConnect($sql_statement);
//echo $sql_statement;
if(pg_affected_rows($result)<1) {
	echo "<br><h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
	} 
else {
       header("location:../main/set_account.php?menu=$menu&account_no=$account_no");

echo $t_id;
}
}
echo "</body>";
echo "</html>";

?>
