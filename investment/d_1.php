<?
include "../config/config.php";

$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$account_no=$_REQUEST['account_no'];
$account_type=$_REQUEST['account_type'];
$type_of=$_REQUEST['type_of'];
$bank_name=$_REQUEST['bank_name'];
$branch_name=$_REQUEST['branch_name'];
$certifiacate_no=$_REQUEST['certificate_no'];
$op_date=$_REQUEST['op_date'];
$remarks=$_REQUEST['remarks'];
$interest=$_REQUEST['interest'];
$ac_no=$_REQUEST['ac_no'];
$maturity_date=$_REQUEST['mat_dt'];
$maturity_amount=$_REQUEST['mat_amt'];
$renew_amount=$_REQUEST['renew_amount'];
$interest_rate=$_REQUEST['int_rate'];
$principal=$_REQUEST['principal'];
$ch_no=$_REQUEST['ch_no'];
$rate=$_REQUEST['rate'];
$period=$_REQUEST['period'];
$effect=$_REQUEST['date_with_effect'];
$payment_term=$_REQUEST['p_mode'];
$bank_account_no=$_REQUEST['bank_ac_no'];

$gl_code=getData(trim($_REQUEST['gl_code']));

//$mat_amt=$_REQUEST['$mat_amt'];

$int1=$withdrawal_amount-$principal;
$int=$maturity_amount - $renew_amount;

$maturity_date=$_REQUEST["maturity_date"];

$withdrawn_type=$_REQUEST["withdrawn_type"];

$withdrawal_date=$_REQUEST["withdrawal_date"];//request form input box
$withdrawal_amount=$_REQUEST["renew_amount"];

$remarks=$_REQUEST["remarks"];//request form input box
$operator_code=$staff_id;
if(empty($withdrawal_date)) { $withdrawal_date=date('d/m/Y'); }
$op=$_REQUEST["op"];
$particulars=$_REQUEST['particulars'];
$operation=$_REQUEST['o'];
$ch_no=$_REQUEST['ch_no'];
$ch_dt=(empty($_REQUEST['ch_dt']))?$DOB_DEFAULT:$_REQUEST['ch_dt'];
$id=$_REQUEST['id'];
$interest=$_REQUEST['interest'];
$sql_statement="select * from deposit_info where account_no='$account_no'";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
  echo "<h4>Already withdrawn or record not found!!!</h4>";
} else {
 $principal=pg_result($result,'principal');
$with_amt=pg_result($result,'maturity_amount');
 $result1=dBConnect($sql_statement);
$gl_code=getData(trim($_REQUEST['gl_code']));
}
$int=$with_amt-$principal;
$principal=pg_result($result,'principal');
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
$fy1=$_SESSION["fy"];
//$fy=getFy();
//echo $fy1;
if(empty($fy)){
echo "<h1><center><b>You Can't Insert any value Into database Because Financial Year already Locked by administrator !!!!!!!!!";
}
else{//1
//echo "hi";
	 $t_id=getTranId();

	$gl_code=getGlCode4mbankAccount($account_no);
	$gl_code_int=getGlCodeInterest($gl_code,$menu);
	$gl_code1=getGlCode4mbankAccount($ac_no);

//echo $gl_code_int;
if(!empty($ac_no))
{

	 	$sql_statement="INSERT INTO gl_ledger_hrd(tran_id,type,action_date,fy,remarks, cheque_no,cheque_dt,operator_code,entry_time) VALUES ('$t_id','c".trim($menu)."','$withdrawal_date','$fy1', '$remarks','$ch_no','$ch_dt','$staff_id',NOW())";

		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr,particulars,cost_code) VALUES('$t_id','$account_no','$gl_code',$withdrawal_amount,'Dr','cash','cl')";
		
       		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES
('$t_id','$account_no','$gl_code',$principal,'Cr','cash')";// for credit



$t_id=getTranId();

$sql_statement=$sql_statement.";INSERT INTO gl_ledger_hrd(tran_id,type,action_date,fy,remarks, cheque_no,cheque_dt,operator_code,entry_time) VALUES ('$t_id','csb','$withdrawal_date','$fy1', '$remarks','$ch_no','$ch_dt','$staff_id',NOW())";
	$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr,particulars)VALUES('$t_id','$ac_no','$gl_code1',$interest,'Dr','cash')";

$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr,particulars,cost_code) VALUES('$t_id','$account_no','$gl_code_int',$interest,'Cr','cash','cl')";


		$sql_statement=$sql_statement.";UPDATE deposit_info set  withdrawal_date= '$withdrawal_date',withdrawal_type='Mature',withdrawal_amount='$with_amt',withdrawal_interest='$interest' where account_no='$account_no'";
      
		$sql_statement=$sql_statement.";INSERT INTO deposit_info(account_no,certificate_no,account_type,action_date,date_with_effect, principal,interest_rate,maturity_date,maturity_amount,operator_code,entry_time) VALUES('$account_no','$certifiacate_no','$menu','$withdrawal_date','$effect',$renew_amount,$rate, '$maturity_date',$maturity_amount,'$staff_id',CAST('$maturity_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))"; 
}
else
{
$sql_statement="INSERT INTO gl_ledger_hrd(tran_id,type,action_date,fy,remarks, cheque_no,cheque_dt,operator_code,entry_time) VALUES ('$t_id','c".trim($menu)."','$withdrawal_date','$fy1', '$remarks','$ch_no','$ch_dt','$staff_id',NOW())";

		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr,particulars,cost_code,account_no) VALUES('$t_id','$gl_code',$withdrawal_amount,'Dr','cash','cl','$account_no')";
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr,particulars,cost_code,account_no) VALUES('$t_id','$gl_code_int',$int,'Cr','cash','cl','$account_no')";
	
       		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES
('$t_id','$account_no','$gl_code',$principal,'Cr','cash')";

// for credit
$sql_statement=$sql_statement.";UPDATE deposit_info set  withdrawal_date= '$withdrawal_date',withdrawal_type='Mature',withdrawal_amount='$with_amt',withdrawal_interest='$int' where account_no='$account_no'";
      
		$sql_statement=$sql_statement.";INSERT INTO deposit_info(account_no,certificate_no,account_type,action_date,date_with_effect, principal,interest_rate,maturity_date,maturity_amount,operator_code,entry_time) VALUES('$account_no','$certifiacate_no','$menu','$withdrawal_date','$effect',$renew_amount,$rate, '$maturity_date',$maturity_amount,'$staff_id',CAST('$maturity_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))"; 
}

echo $sql_statement;
$result=dBConnect($sql_statement);


}

if(pg_affected_rows($result)<1) {
//	echo "<br><h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
	echo "<br><h3><font color=\"RED\">Failed to update database.</font></h3>";	
} 
else {
	//echo "<br><h5><font color=\"RED\">withdrawl has been completed.</font></h5>";
	header("location:../investment/bk_investment.php?menu=fd&account_no=$account_no");
}

echo "</body>";
echo "</html>";

?>
