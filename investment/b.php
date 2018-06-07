<?
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST["menu"];
$account_no=$_REQUEST["account_no"];//request form input box
$certificate_no=$_REQUEST["certificate_no"];//request form input box
$holder_sb_account_no=$_REQUEST["holder_sb_account_no"];
$total_interest=$_REQUEST["withdrawal_int"];

//$int=$maturity_amount-$amount_deposit;
$total_interest1=$_REQUEST["$maturity_amount"];
//$int=$maturity_amount-$amount_deposit;
$int=$_REQUEST["withdrawal_int"];
//echo $int;
//$maturity_amount=$_REQUEST["maturity_amount"];
$maturity_date=$_REQUEST["maturity_date"];
//$withdrawn_type=$_REQUEST["withdrawal_type"];
$withdrawn_type=$_REQUEST["withdrawn_type"];
$amount_deposit=$_REQUEST["principal"];//request form input box
//echo $amount_deposit;
$withdrawal_date=$_REQUEST["withdrawal_date"];//request form input box
$withdrawal_amount=$_REQUEST["withdrawal_amount"];
//$int1=$maturity_amount-$withdral_amount;
//echo $withdrawal_amount;
$remarks=$_REQUEST["remarks"];//request form input box
$operator_code=$staff_id;
if(empty($withdrawal_date)) { $withdrawal_date=date('d/m/Y'); }
$op=$_REQUEST["op"];
$particulars=$_REQUEST['particulars'];
$operation=$_REQUEST['o'];
$ch_no=$_REQUEST['ch_no'];
$ch_dt=(empty($_REQUEST['ch_dt']))?$DOB_DEFAULT:$_REQUEST['ch_dt'];
$id=$_REQUEST['id'];


echo "<html>";
echo "<head>";
echo "<title>Update Form - Reinvestment";
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


if($menu=='ri'){

	 	$sql_statement="INSERT INTO gl_ledger_hrd(tran_id,type,action_date,fy,remarks, cheque_no,cheque_dt,operator_code,entry_time) VALUES ('$t_id','c".trim($menu)."','$withdrawal_date','$fy', '$remarks','$ch_no','$ch_dt','$staff_id',NOW())";

$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr,particulars,cost_code) VALUES('$t_id','28101',$withdrawal_amount,'Dr','cash','cl')";

	$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars,cost_code,account_no) VALUES
('$t_id','51403','$int','Cr','cash','cl','$account_no')";//for interest
       
$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars,account_no) VALUES
('$t_id','22403',$withdrawal_amount - $int,'Cr','cash','$account_no')";// for credit
       $sql_statement=$sql_statement.";

UPDATE deposit_info set  withdrawal_date= '$withdrawal_date',withdrawal_type='$withdrawn_type',withdrawal_amount='$withdrawal_amount',withdrawal_interest='$int' where account_no='$account_no'";

$sql_statement=$sql_statement.";
UPDATE bank_bk_dtl set  status= 'cl' where account_no='$account_no'";



} else{
	 	$sql_statement="INSERT INTO gl_ledger_hrd(tran_id,type,action_date,fy,remarks, cheque_no,cheque_dt,operator_code,entry_time) VALUES ('$t_id','c".trim($menu)."','$withdrawal_date','$fy', '$remarks','$ch_no','$ch_dt','$staff_id',NOW())";

$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr,particulars,cost_code) VALUES('$t_id','28101',$withdrawal_amount,'Dr','cash','cl')";

	$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars,cost_code) VALUES
('$t_id','51401','$int','Cr','cash','cl')";//for interest
      
 $sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars,account_no) VALUES
('$t_id','22401',$withdrawal_amount - $int,'Cr','cash','$account_no')";// for credit
       
$sql_statement=$sql_statement.";UPDATE deposit_info set  withdrawal_date= '$withdrawal_date',withdrawal_type='$withdrawn_type',withdrawal_amount='$withdrawal_amount',withdrawal_interest='$int' where account_no='$account_no'";
       
$sql_statement=$sql_statement.";
UPDATE bank_bk_dtl set  status= 'cl' where account_no='$account_no'";
      
}


}

//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_affected_rows($result)<1) {
//	echo "<br><h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
	echo "<br><h3><font color=\"RED\">Failed to update database.</font></h3>";	
} 
else {
	//echo "<br><h5><font color=\"RED\">withdrawl has been completed.</font></h5>";
	header("location:../investment/bk_investment.php?menu=fd&account_no=$account_no");
}
$sql_statement1="UPDATE gl_ledger_dtl set account_no='$account_no' where tran_id in(select tran_id from gl_ledger_dtl where account_no='$account_no' and dr_cr='Dr') and gl_mas_code='28101'";
$result=dBConnect($sql_statement1);
echo "</body>";
echo "</html>";

?>
