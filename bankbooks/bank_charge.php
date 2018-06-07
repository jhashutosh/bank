<?
include "../config/config.php";
$staff_id=verifyAutho();
$account_no=$_REQUEST["account_no"];
$op=$_REQUEST['op'];
$option=$_REQUEST['option'];
$t_id=$_REQUEST['t_id'];
$amount=$_REQUEST['amount'];
$ch_no=$_REQUEST['ch_no'];
$ch_dt=$_REQUEST['ch_dt'];
$bank_charge_pd=$_REQUEST['bank_charge_pd'];
$bank_charge_rc=$_REQUEST['bank_charge_rc'];
$b_ac=$_REQUEST['b_ac'];
$account_no=$_REQUEST['account_no'];
$action_date=$_REQUEST['action_date'];
//$t_id=$_REQUEST['t_id'];
//---------------------------------------INSERT INTO DATABASE --------------------------------
if($option=='i'){
echo "<h1>option:$op</h1>";
$fy=getFy($action_date);
if(empty($fy)){
echo "<h1><center><b>You Can't Insert any value Into database Because Financial Year already Locked by administrator !!!!!!!!!";
}
else{
	$gl_code=getGlCode4mCustomerAccount($account_no,$action_date);
	$bk_gl_code=getGlCode4mBank($b_ac);
	$charge_pd_gl='63904';
	if($op=='cleared'){
		//reverseJV($t_id,$action_date);
		//$sql_statement="INSERT INTO gl_ledger_hrd(tran_id,type,action_date,certificate_no, fy,remarks,cheque_no,cheque_dt,operator_code,entry_time) VALUES ('$t_id','sb', '$action_date','$status','$fy','$remarks','$ch_no','$ch_dt','$staff_id',CAST(('$action_date'||SUBSTR(now(),11,length(now()))) AS TIMESTAMP))";
		$sql_statement="INSERT INTO gl_ledger_hrd(tran_id,type,action_date,certificate_no, fy,remarks,cheque_no,cheque_dt,operator_code,entry_time) VALUES ('$t_id','sb', '$action_date','$status','$fy','$remarks','$ch_no','$ch_dt','$staff_id',CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','$b_ac','$bk_gl_code',$amount,'Dr','Cheque Cleared')";
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','$account_no','$gl_code',$amount,'Cr','Cheque Cleared')";
		 $sql_statement=$sql_statement.";UPDATE gl_ledger_dtl SET particulars='Cleared',cost_code='k' WHERE tran_id='$t_id'";
		}
	if($op=='bounced'){
		/*
		if(!reverseJV($t_id,$action_date)){
			echo "<h1><font color=RED>Error!!!!!!!!!!!!!</font></h1>";
			$sql_statement="hello";
		}
	
		$sql_statement.="UPDATE gl_ledger_dtl SET particulars='Bounced',cost_code='k' WHERE tran_id='$t_id'";
		//echo $sql_statement;
		*/
		$sql_statement="INSERT INTO gl_ledger_hrd(tran_id,type,action_date, fy,remarks,operator_code,entry_time) VALUES ('$t_id','sb', '$action_date','$fy','Cheque Bounced','$staff_id',CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
		 $sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','$b_ac','$bk_gl_code',$amount,'Cr','Cheque Bounced')";
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','$b_ac','$bk_gl_code',$amount,'Dr','Cheque Bounced')";
		 $sql_statement=$sql_statement.";UPDATE gl_ledger_dtl SET particulars='Bounced',cost_code='k' WHERE tran_id='$t_id'";
	}
	if($bank_charge_pd>0){
	$tran_id=getTranId();
	//$sql_statement.=";INSERT INTO gl_ledger_hrd(tran_id,type,action_date, fy,remarks,operator_code,entry_time) VALUES ('$tran_id','jv', '$action_date','$fy','Bank Charge','$staff_id',CAST(('$action_date'||SUBSTR(now(),11,length(now()))) AS TIMESTAMP))";
	$sql_statement.=";INSERT INTO gl_ledger_hrd(tran_id,type,action_date, fy,remarks,operator_code,entry_time) VALUES ('$tran_id','sb', '$action_date','$fy','Bank Charge','$staff_id',(CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP) + 2* interval '1 millisecond'))";
	 $sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars) VALUES('$tran_id','$charge_pd_gl',$bank_charge_pd,'Dr','bank charge')";
	 $sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES('$tran_id','$b_ac','$bk_gl_code',$bank_charge_pd,'Cr','bank charge')";
	}
	if(!empty($account_no) && $bank_charge_rc>0){
		
		$charge_rv_gl='57903';
		$tran_id=getTranId();
		//$sql_statement.=";INSERT INTO gl_ledger_hrd(tran_id,type,action_date, fy,remarks,operator_code,entry_time) VALUES ('$tran_id','jv', '$action_date','$fy','Bank Charge','$staff_id',CAST(('$action_date'||SUBSTR(now(),11,length(now()))) AS TIMESTAMP))";
		$sql_statement.=";INSERT INTO gl_ledger_hrd(tran_id,type,action_date, fy,remarks,operator_code,entry_time) VALUES ('$tran_id','sb', '$action_date','$fy','Bank Charge','$staff_id',(CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP) + 2* interval '1 millisecond'))";
	 $sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES('$tran_id','$account_no','$gl_code',$bank_charge_rc,'Dr','bank charge')";
	 $sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars) VALUES('$tran_id','$charge_rv_gl',$bank_charge_rc,'Cr','bank charge')";
		}
$sql_statement.=";UPDATE cheque_reg SET status='$op',clearing_dt='$action_date',bank_charge_paid=$bank_charge_pd,bank_charge_rcv=$bank_charge_rc WHERE tran_id='$t_id'";
echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_affected_rows($result)<1) {
	echo "<br><h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
	} 
else {
      header("location:../bankbooks/clearing_cheque_list.php?option=$op");
      }

   }
}
echo "<html>";
echo "</script>";
echo "<title>Statement";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"bank_charge_pd.focus();\">";
echo "<font size=+2><b>Bank Charge</b></font>";
echo "<hr>";
$sql_statement="SELECT * FROM  cheque_reg WHERE tran_id='$t_id'";
$result=dBConnect($sql_statement);
$ch_no=pg_result($result,'cheque_no');
$ch_dt=pg_result($result,'cheque_date');
$bank_name=pg_result($result,'bank_name');
$branch=pg_result($result,'branch');
$account_no=pg_result($result,'account_no');
$amount=pg_result($result,'amount');
if(empty($account_no)){$flag='d';}
else{$flag='s';}
$bank_account=pg_result($result,'forward_account');
echo "<form name=\"form1\" action=\"bank_charge.php?op=$op&option=i&t_id=$t_id\" method=POST>";
echo "<table align=center width=\"100%\" bgcolor=\"BLACK\">";
echo "<tr><th colspan=\"4\" bgcolor=#7B68EE>Bank Charge for $op cheque";
echo "<tr><td bgcolor=\"#48D1CC\">Cheque No:<td bgcolor=\"#48D1CC\"><input type=\"TEXT\" name=\"ch_no\" value=\"$ch_no\" size=\"10\" READONLY $HIGHLIGHT>";
echo "<td bgcolor=\"#48D1CC\">Cheque Date<td bgcolor=\"#48D1CC\"><input type=\"TEXT\" name=\"ch_dt\" value=\"$ch_dt\" size=\"12\" READONLY $HIGHLIGHT>";
echo "<tr><td bgcolor=\"#48D1CC\">Cheque Amount:<td bgcolor=\"#48D1CC\"><input type=\"TEXT\" name=\"amount\" value=\"$amount\" READONLY size=\"12\" $HIGHLIGHT>";
echo "<td bgcolor=\"#48D1CC\">Bank Name:<td bgcolor=\"#48D1CC\"><input type=\"TEXT\" name=\"b_name\" value=\"$bank_name\" READONLY $HIGHLIGHT>";
echo "<tr><td bgcolor=\"#48D1CC\">Branch Name<td bgcolor=\"#48D1CC\"><input type=\"TEXT\" name=\"branch\" value=\"$branch\" READONLY $HIGHLIGHT>";
echo "<td bgcolor=\"#48D1CC\">Action Date:<td bgcolor=\"#48D1CC\"><input type=\"TEXT\" name=\"action_date\" value=\"".date('d.m.Y')."\" size=\"12\" $HIGHLIGHT>";
echo "<tr><td bgcolor=\"#48D1CC\">Forward To A/C No:<td bgcolor=\"#48D1CC\"><input type=\"TEXT\" name=\"b_ac\" value=\"$bank_account\" READONLY size=\"10\" $HIGHLIGHT>";
echo "<td bgcolor=\"#48D1CC\">Bank Charge Paid<td bgcolor=\"#48D1CC\"><input type=\"TEXT\" name=\"bank_charge_pd\" id=\"bank_charge_pd\" value=\"\" size=\"5\" $HIGHLIGHT>";
if($flag=='s'){
echo "<tr><td bgcolor=\"#48D1CC\">From SB A/C No:<td bgcolor=\"#48D1CC\"><input type=\"TEXT\" name=\"account_no\" value=\"$account_no\" size=\"10\" READONLY $HIGHLIGHT>";
echo "<td bgcolor=\"#48D1CC\">Bank Charge Received<td bgcolor=\"#48D1CC\"><input type=\"TEXT\" name=\"bank_charge_rc\" value=\"\" size=\"5\" $HIGHLIGHT>";
}
echo "<tr><td colspan=\"4\" bgcolor=\"#48D1CC\" align=right><INPUT type=SUBMIT value=\"Enter\">";
echo "</table></form>";
if($flag=='s'){
?>
<script language="JavaScript" type="text/javascript">
 var frmvalidator  = new Validator("form1");
  frmvalidator.addValidation("bank_charge_rc","req","Please enter Bank Charge Received.");
  frmvalidator.addValidation("bank_charge_pd","req","Please enter Bank Charge Paid");
  frmvalidator.addValidation("action_date","req","Please enter Action Date");
  frmvalidator.addValidation("bank_charge_rc","dec","Bank Charge Received Should be Positive Number");
  frmvalidator.addValidation("bank_charge_pd","dec","Bank Charge paid Should be Positive Number");
  </script>
<?
}
else{
?>
<script language="JavaScript" type="text/javascript">
 var frmvalidator  = new Validator("form1");
  frmvalidator.addValidation("bank_charge_pd","req","Please enter Bank Charge Paid");
  frmvalidator.addValidation("action_date","req","Please enter Action Date");
  frmvalidator.addValidation("bank_charge_pd","dec","Bank Charge paid Should be Positive Number");
  </script>
<?
}
?>
