<?
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
if(empty($_REQUEST['account_no'])){
	$account_no=$_SESSION["current_account_no"];
	}
else{
	$account_no=$_REQUEST['account_no'];
	$_SESSION["current_account_no"]=$account_no;
}
echo "<html>";
echo "<head>";
echo "<title> PL Main </title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";

echo "<script language=\"JavaScript\" src=\"../JS/varify.js\" type=\"text/javascript\"></script>";
?>
<SCRIPT LANGUAGE="JavaScript">
function openChild(file,window){
       	childWindow=open(file,window, 'toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=300,left=250, width=600,height=300');
    if(childWindow.opener == null) childWindow.opener = self;
    }

function sbChild(){
	var str=document.getElementById('ac').value;
	if(str.length == 0){
		alert("Account No Should not be null!!!");
		//document.orderform.ac.focus();	
		return false;
	}
  	else{
		URL="../main/pop_up_account.php?menu=sb&account_no="+str;
	window.open(URL,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no, scrollbars=yes,top=100,left=150,width=950,height=450');
return false;
 }
}

</SCRIPT>
<?
$id=getCustomerId($account_no,$menu);
$flag=getGeneralInfo_Customer($id);
if($flag==1){
echo "<hr>";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"pd.focus();\">";
//=======================================First Form ===========================================
if(empty($_REQUEST['op'])){
	
echo "<FORM NAME=\"form1\" method=\"POST\" action=\"ksloan_ledger_ef.php?menu=$menu&op=v\" onSubmit=\"return varify1();\">";
echo "<table bgcolor=\"#FAEBD7\" width=\"80%\" align=\"CENTER\">";
echo "<tr><th bgcolor=\"#FF00FF\" colspan=\"6\"><font size=+2>KS Loan Issuing Form[$account_no]</font>";
echo "<tr><td>Due Interest Rate:<td><INPUT NAME=\"due_int\" TYPE=\"TEXT\" VALUE=\"12\" $HIGHLIGHT size=3 > &nbsp;%";
echo "<td>Over Due Interest Rate:<td><INPUT NAME=\"over_due_int\" TYPE=\"TEXT\" VALUE=\"14\" $HIGHLIGHT size=\"3\" > &nbsp;%";
echo "<tr><td>Issuing Date:<td><INPUT NAME=\"action_date\" TYPE=\"TEXT\" VALUE=\"".date('d/m/Y')."\" $HIGHLIGHT size=\"15\">";
echo "<td>Period:<td>Rs.&nbsp<INPUT NAME=\"period\" TYPE=\"TEXT\" id=\"pd\" VALUE=\"\" size=\"4\" $HIGHLIGHT> &nbsp;Month";
echo "<tr><td>Applied Amount:<td>Rs.&nbsp<INPUT NAME=\"applied_amount\" TYPE=\"TEXT\" VALUE=\"\" size=\"10\" $HIGHLIGHT >";
echo "<td>Issuing Amount:<td>Rs.&nbsp<INPUT NAME=\"issue_amount\" id=\"amount\" TYPE=\"TEXT\" VALUE=\"\" size=\"10\" $HIGHLIGHT>";
echo "<tr><td colspan=\"3\" align=\"CENTER\">Transfer to Your SB A/C : <INPUT NAME=\"t_status\"  TYPE=\"radio\" VALUE=\"y\" $HIGHLIGHT >Yes &nbsp;&nbsp;<INPUT NAME=\"t_status\"  TYPE=\"radio\" VALUE=\"n\" CHECKED $HIGHLIGHT >No";
echo "<input type=\"HIDDEN\" name=\"loan_sl_no\" VALUE=\"$loan_sl_no\">";
echo "<td align=\"CENTER\"><input type=\"SUBMIT\" VALUE=\"    Go   \">";
echo "</FORM>";

}
//=============================================================================================
//========================================VIEW ++++++++++++++++++++++++++++++++++++++++++++++++
if($_REQUEST['op']=='v'){
	$account_sb=findSBAccount($account_no);
	if(trim($_REQUEST['t_status'])=='y'&& (empty($account_sb))){
	echo "<font color=red size=+3 align=center><b>Dont have any Savings Account</font>";
		}
	else{
	echo "<FORM NAME=\"parentForm\" method=\"POST\" action=\"ksloan_ledger_ef.php?menu=$menu&op=i\">";
echo "<table bgcolor=\"#FAEBD7\" width=\"80%\" align=\"CENTER\">";
echo "<tr><th bgcolor=\"#FF00FF\" colspan=\"6\"><font size=+2>Ks Loan Issuing Form For verify[$account_no]</font>";
echo "<tr><td>Due Interest Rate:<td><INPUT NAME=\"due_int\" TYPE=\"TEXT\" VALUE=\"".$_REQUEST['due_int']."\" $HIGHLIGHT size=3 > &nbsp;%";
echo "<td>Over Due Interest Rate:<td><INPUT NAME=\"over_due_int\" TYPE=\"TEXT\" VALUE=\"".$_REQUEST['over_due_int']."\" $HIGHLIGHT size=\"3\" > &nbsp;%";
echo "<tr><td>Issuing Date:<td><INPUT NAME=\"action_date\" TYPE=\"TEXT\" VALUE=\"".$_REQUEST['action_date']."\" $HIGHLIGHT size=\"15\" readonly>";
echo "<td>Repayment Period:<td>Rs.&nbsp<INPUT NAME=\"period\" TYPE=\"TEXT\" VALUE=\"".$_REQUEST['period']."\" size=\"10\" $HIGHLIGHT> &nbsp; Months";
echo "<tr><td>Applied Amount:<td>Rs.&nbsp<INPUT NAME=\"applied_amount\" TYPE=\"TEXT\" VALUE=\"".$_REQUEST['applied_amount']."\" size=\"10\" $HIGHLIGHT >";
echo "<td>Issuing Amount:<td>Rs.&nbsp<INPUT NAME=\"issue_amount\" id=\"amount\" TYPE=\"TEXT\" VALUE=\"".$_REQUEST['issue_amount']."\" size=\"10\" $HIGHLIGHT>";
if(trim($_REQUEST['t_status'])=='y'){
echo "<tr><td >Transfer to Your SB A/C : <INPUT NAME=\"t_status\"  TYPE=\"TEXT\" VALUE=\"y\" SIZE=\"1\" READONLY $HIGHLIGHT >";
echo "<td>Your SB A/C No. :<td><INPUT NAME=\"account_sb\" id=\"ac\" TYPE=\"TEXT\" VALUE=\"$account_sb\" size=\"10\" $HIGHLIGHT READONLY>";
echo "&nbsp;<INPUT TYPE=\"button\" name=\"s1\" VALUE=\"Search\" onClick=\"sbChild();\">";
	}
echo "<input type=\"HIDDEN\" name=\"loan_sl_no\" VALUE=\"".$_REQUEST['loan_sl_no']."\">";
echo "<td align=\"CENTER\"><input type=\"SUBMIT\" VALUE=\"    Final  \">";
	}
 }
//============================================================================================
//+++++++++++++++++++++++++++++++++++++++++INSERT+++++++++++++++++++++++++++++++++++++++++++++
if($_REQUEST['op']=='i'){
echo "<form name=\"parentForm\"></form>";
$action_date=$_REQUEST['action_date'];
$due_int=$_REQUEST['due_int'];
$over_due_int=$_REQUEST['over_due_int'];
$applied_amount=$_REQUEST['applied_amount'];
$account_sb=$_REQUEST['account_sb'];
$period=$_REQUEST['period'];
$issue_amount=$_REQUEST['issue_amount'];
$loan_sl_no=nextValue('loan_sl_no');
$repay_date=maturity_date($_REQUEST['action_date'],$_REQUEST['period'],'m');
$gl_code=getGlCode4mCustomerAccount($account_no,$action_date);
	$fy=getFy($action_date);
	if(empty($fy)){
		echo "<h1><center><b>You Can't Insert any value Into database Because Financial Year already Locked by administrator !!!!!!!!!</h1>";
			} 	
	else{
	 	$t_id=getTranId();
//loan_ledger_hrd
		$sql_statement="INSERT INTO loan_ledger_hrd (loan_serial_no,loan_type, customer_id,account_no,fy,issue_date,repay_date,period,int_due_rate,int_overdue_rate, applied_amount,status,staff_id,entry_time,gl_code,gl_status) VALUES ('$loan_sl_no','ks','$id','$account_no', '$fy','$action_date','$repay_date',$period,$due_int,$over_due_int,$applied_amount,'op', '$staff_id',CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP),'$gl_code','d')";
//loan_security 
		//$sql_statement=$sql_statement.";UPDATE loan_security SET status='l' WHERE loan_serial_no='$loan_sl_no' AND account_no='$account_no'";
//loan_issue_dtl
		$sql_statement=$sql_statement.";INSERT INTO loan_issue_dtl(tran_id, loan_serial_no,account_no,action_date,loan_amount,b_principal,staff_id,entry_time)VALUES('$t_id','$loan_sl_no','$account_no','$action_date',$issue_amount,$issue_amount,'$staff_id',CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
//gl_ledger_hrd
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_hrd(tran_id,type, action_date,fy,remarks,operator_code, entry_time) VALUES ('$t_id','ks','$action_date','$fy','$remarks','$staff_id', CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
//gl_ledger_dtl ===== Dr.
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','$account_no','$gl_code',$issue_amount,'Dr','ks issue')";
//gl_ledger_dtl ===== Cr.
	//For Cash 
		if(empty($account_sb)){
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','28101',$issue_amount,'Cr','ks issue')";
		}
	//For Transfer to SB A/C.
		else{
		$gl_code=getGlCode4mCustomerAccount($account_sb,$action_date);
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars,account_no) VALUES('$t_id','$gl_code',$issue_amount,'Cr','ks issue','$account_sb')";
		}
		//echo $sql_statement;
		$result=dBConnect($sql_statement);
		if(pg_affected_rows($result)<1){
		echo "<br><h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
			} 
		else{
			echo "<h4><font color=\"Green\">Sucessfully inserted data into database.</font><br>Your Transaction Id:$t_id";
			echo "Your Loan Amount:Rs. $issue_amount<br></h4>";
			echo "<font size=+1><a href=\"../main/set_account.php?menu=$menu&account_no=$account_no\">Click</a> here to go Statement"; 
		}

	}

 }
}
if(empty($_REQUEST['op']) && (!isOpenLoan($account_no))&&$flag==1){
?>
<script language="JavaScript" type="text/javascript">
var frmvalidator  = new Validator("parentForm");
frmvalidator.addValidation("issue_amount","req","Please enter Issuing Amount");
frmvalidator.addValidation("issue_amount","dec","Please enter Numeric Value.");
frmvalidator.addValidation("applied_amount","req","Please enter Applied Amount");
frmvalidator.addValidation("applied_amount","dec","Please enter Numeric Value.");
frmvalidator.addValidation("action_date","req","Please enter Issuing Date.");
frmvalidator.addValidation("due_int","req","Please enter Certificate No.");
frmvalidator.addValidation("over_due_int","req","Please enter Maturity Value.");
frmvalidator.addValidation("due_int","dec","Please enter Numeric Value.");
frmvalidator.addValidation("over_due_int","dec","Please enter Numeric Value.");
frmvalidator.addValidation("period","dec","Please enter Numeric Value.");
frmvalidator.addValidation("period","req","Please enter Loan Repay Period");
//frmvalidator.addValidation("applied_amount","lessthan","Please enter Loan Repay Period");
</script>
<?
}
?>
