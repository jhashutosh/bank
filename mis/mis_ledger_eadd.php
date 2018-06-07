 <?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST["menu"];
$account_no=$_REQUEST["account_no"];
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
$opening_date=$date_with_effect;
if(empty($maturity_date)){$maturity_date=date("d.m.y");}
if(empty($withdrawal_date)){$withdrawal_date="01/01/1970";}
$scheme=getIndex($scheme_array,$scheme);
$fy=getFy($opening_date);
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
	 $t_id=getTranId();
	//echo "fy=$fy";
	 $gl_code=getGlCode4mCustomerAccount($account_no);
// Modification required to suite data type
$sql_statement="INSERT INTO deposit_info (account_no, certificate_no, account_type, scheme, action_date,date_with_effect ,principal ,period, interest_rate, maturity_amount, maturity_date, sb_account_no,operator_code, entry_time) VALUES ('$account_no','$account_no', '$menu', '$scheme','$opening_date','$date_with_effect', $amount_deposit,$period,$rate_of_interest,     $maturity_amount,'$maturity_date','$holder_sb_account_no','$staff_id',CAST('$opening_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";

$sql_statement=$sql_statement.";INSERT INTO gl_ledger_hrd (tran_id,type,action_date, certificate_no,fy,operator_code,entry_time)VALUES ('$t_id','$menu','$opening_date', '$certificate_no','$fy','$staff_id',CAST('$opening_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP));";
$sql_statement=$sql_statement."INSERT INTO gl_ledger_dtl (tran_id,gl_mas_code,amount,dr_cr, particulars) VALUES ('$t_id','28101',$amount_deposit,'Dr','cash');";
$sql_statement=$sql_statement."INSERT INTO gl_ledger_dtl (tran_id,account_no,gl_mas_code, amount,dr_cr, particulars) VALUES ('$t_id','$account_no','$gl_code',$amount_deposit,'Cr','cash')";
$result=dBConnect($sql_statement);
echo $sql_statement;
if(pg_affected_rows($result)<1) {
	echo "<br><h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
	} 
else {
       header("location:../main/set_account.php?menu=$menu&account_no=$account_no");
}
}
echo "</body>";
echo "</html>";

?>
