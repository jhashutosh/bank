<?
include "../config/config.php";
$menu=$_REQUEST["menu"];
$staff_id=verifyAutho();
$account_no=$_SESSION["current_account_no"];
$action_date=$_REQUEST["action_date"];
$maturity_date=$_REQUEST["maturity_date"];
$particulars=$_REQUEST["particulars"];
$cheque_no=$_REQUEST["cheque_no"];
$deposits=$_REQUEST["deposits"];
$cheque_dt=$_REQUEST['cheque_dt'];
$branch=$_REQUEST['branch'];
$bank_name=$_REQUEST['bank_name'];
$remarks=$_REQUEST["remarks"];
if($particulars=='cheque'){$status='clearing';}
if( empty($cheque_dt) ) { $cheque_dt=$DOB_DEFAULT; }
//$particulars=getIndex($bank_withdrawal_particulars_array,$particulars);
if(empty($cheque_no) ) { $cheque_no=0; }
if(empty($action_date) ) { $action_date=date("d/m/Y"); }
echo "<html>";
echo "<head bgcolor=\"silver\">";
echo "<title>Entry Form - Saving Bank";
echo "</title>";
echo "</head>";
echo "<body bgcolor=\"silver\">";
$title='Saving Bank';
echo "<h1> $title Form ";
echo "</h1>";
echo "<h3>Your submission has been accepted.";
echo "</h3>";
echo "<hr>";
$fy=getFy($action_date);
//$fy='2012-2013';
if(empty($fy)){
echo "<h1><center><b>You Can't Insert any value Into database Because Financial Year already Locked by administrator !!!!!!!!!";
}
else{
	$t_id=getTranId();
	if($particulars=='cheque'){
	$bank_ac_no=$_REQUEST['bank_ac_no'];
			//$gl_code_bk=getGlCode4mBank($bank_ac_no);
			$sql_statement.=";INSERT INTO cheque_reg(tran_id,account_no,action_date, cheque_no,bank_name,branch,cheque_date,amount,forward_account,status,entry_time,operator_code) VALUES('$t_id','$account_no','$action_date','$cheque_no','$bank_name','$branch','$cheque_dt', $deposits,'$bank_ac_no','clearing',CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP),'$staff_id')";

	$result=dBConnect($sql_statement);
	if(pg_affected_rows($result)<1) {
		echo "<br><h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
	} else {
      		header("location:../bankbooks/clearing_cheque_list.php?option=clearing");
      		}
	}
	else{
	 
		$gl_code=getGlCode4mCustomerAccount($account_no,$action_date);
		// Modification required to suite data type
			$sql_statement="INSERT INTO gl_ledger_hrd(tran_id,type,action_date, certificate_no, fy,remarks,cheque_no,cheque_dt,operator_code,entry_time) VALUES ('$t_id','$menu', '$action_date','$status','$fy','$remarks','$cheque_no','$cheque_dt','$staff_id',CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
	if($_REQUEST['type']=='d'){
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','28101',$deposits,'Dr','$particulars')";
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','$account_no','$gl_code',$deposits,'Cr','$particulars')";
  		}
	if($_REQUEST['type']=='w'){
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','$account_no','$gl_code',".$_REQUEST["withdrawals"].",'Dr','$particulars')";
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','28101',".$_REQUEST["withdrawals"].",'Cr','$particulars')";
   		}
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_affected_rows($result)<1) {
	echo "<br><h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
	} 
else {
    		header("location:../main/set_account.php?menu=$menu&account_no=$account_no");
      	   }
	}
}
echo "</body>";
echo "</html>";

?>
