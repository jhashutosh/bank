<?
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$action_date=$_REQUEST['action_date'];
if(empty($action_date)){$action_date=date('d.m.Y');}
if(empty($_REQUEST['account_no'])){
	$account_no=$_SESSION["current_account_no"];
	}
else{
	$account_no=$_REQUEST['account_no'];
	$_SESSION["current_account_no"]=$account_no;
}
//getLoanInt('pl',date('d/m/Y'),$due,$over);
pl_document($account_no,&$loan_sl_no,&$sum_amount);
echo "<html>";
echo "<head>";
echo "<title> PL Main </title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";

echo "<script language=\"JavaScript\" src=\"../JS/varify.js\" type=\"text/javascript\"></script>";
?>
<SCRIPT LANGUAGE="JavaScript">
function openChild(file,window){
	var str=document.getElementById('action_date').value;
	file=file+"&l_date="+str;
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
echo "<FORM NAME=\"form1\" method=\"POST\" action=\"ccl_loan_issue_ef.php?menu=$menu&op=v\" onSubmit=\"return varify();\">";
echo "<table bgcolor=\"#BDB76B\" width=\"100%\" align=\"CENTER\">";
echo "<tr><th bgcolor=\"#FFD700\" colspan=\"6\"><font size=+2>Cash Credit Loan Issuing Form[$account_no]</font>";
//echo "<INPUT TYPE=\"button\" VALUE=\"  Add  \" onClick=\"openChild('addDocument.php?menu=ccl','win2')\">";
$sql_statement="SELECT * FROM loan_ledger_hrd where account_no='$account_no'AND status='op'";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$loan_sl_no=pg_result($result,'loan_serial_no');
echo "<tr><td>Issuing Date:<td><INPUT NAME=\"action_date\" id=\"ac_date\" TYPE=\"TEXT\" VALUE=\"".pg_result($result,'issue_date')."\" $HIGHLIGHT size=\"15\" READONLY>";
echo "<td>Re-Issuing Date:<td><INPUT NAME=\"action_date\" id=\"action_date\" TYPE=\"TEXT\" VALUE=\"".$action_date."\" $HIGHLIGHT size=\"15\">";
echo "<tr><td>Due Interest Rate:<td><INPUT NAME=\"due_int\" TYPE=\"TEXT\" VALUE=\"".pg_result($result,'int_due_rate')."\" $HIGHLIGHT size=3 readonly> &nbsp;%";
echo "<td>Over Due Interest Rate:<td><INPUT NAME=\"over_due_int\" TYPE=\"TEXT\" VALUE=\"".pg_result($result,'int_overdue_rate')."\" $HIGHLIGHT size=\"3\" readonly> &nbsp;%";
$sum_amount=pg_result($result,'max_limit');
$loan_status=getLoanBalance($loan_sl_no);
$sum_amount=$sum_amount-$loan_status;
echo "<tr><td>Credit Limit Amount:<td>Rs.&nbsp<INPUT NAME=\"cr_limit_amount\" id=\"pd\" TYPE=\"TEXT\" VALUE=\"$sum_amount\" size=\"10\" $HIGHLIGHT>";
echo "<td>Period:<td>Rs.&nbsp<INPUT NAME=\"period\" TYPE=\"TEXT\"  VALUE=\"".pg_result($result,'period')."\" size=\"4\" $HIGHLIGHT> &nbsp;Month";
echo "<tr><td>Applied Amount:<td>Rs.&nbsp<INPUT NAME=\"applied_amount\" TYPE=\"TEXT\" VALUE=\"\" size=\"10\" $HIGHLIGHT >";
echo "<td>Issuing Amount:<td>Rs.&nbsp<INPUT NAME=\"issue_amount\" id=\"amount\" TYPE=\"TEXT\" VALUE=\"\" size=\"10\" $HIGHLIGHT>";
echo "<tr><td colspan=\"3\" align=\"CENTER\">Transfer to Your SB A/C : <INPUT NAME=\"t_status\"  TYPE=\"radio\" VALUE=\"y\" $HIGHLIGHT >Yes &nbsp;&nbsp;<INPUT NAME=\"t_status\"  TYPE=\"radio\" VALUE=\"n\" CHECKED $HIGHLIGHT >No";
echo "<input type=\"HIDDEN\" name=\"loan_sl_no\" VALUE=\"$loan_sl_no\">";
echo "<td align=\"CENTER\"><input type=\"SUBMIT\" VALUE=\"    Go   \">";
	}
else{
echo "<tr><td>Issuing Date:<td><INPUT NAME=\"action_date\" id=\"action_date\" TYPE=\"TEXT\" VALUE=\"".$action_date."\" $HIGHLIGHT size=\"15\">";
echo "<td>Add Security:<td> <INPUT TYPE=\"button\" VALUE=\"  Add  \" onClick=\"openChild('addDocument.php?menu=ccl','win2')\">";
echo "<tr><td>Due Interest Rate:<td><INPUT NAME=\"due_int\" TYPE=\"TEXT\" VALUE=\"12\" $HIGHLIGHT size=3 > &nbsp;%";
echo "<td>Over Due Interest Rate:<td><INPUT NAME=\"over_due_int\" TYPE=\"TEXT\" VALUE=\"12\" $HIGHLIGHT size=\"3\" > &nbsp;%";
echo "<tr><td>Credit Limit Amount:<td>Rs.&nbsp<INPUT NAME=\"cr_limit_amount\" id=\"pd\" TYPE=\"TEXT\" VALUE=\"$sum_amount\" size=\"10\" $HIGHLIGHT>";
echo "<td>Period:<td>Rs.&nbsp<INPUT NAME=\"period\" TYPE=\"TEXT\"  VALUE=\"\" size=\"4\" $HIGHLIGHT> &nbsp;Month";
echo "<tr><td>Applied Amount:<td>Rs.&nbsp<INPUT NAME=\"applied_amount\" TYPE=\"TEXT\" VALUE=\"\" size=\"10\" $HIGHLIGHT >";
echo "<td>Issuing Amount:<td>Rs.&nbsp<INPUT NAME=\"issue_amount\" id=\"amount\" TYPE=\"TEXT\" VALUE=\"\" size=\"10\" $HIGHLIGHT>";
echo "<tr><td colspan=\"3\" align=\"CENTER\">Transfer to Your SB A/C : <INPUT NAME=\"t_status\"  TYPE=\"radio\" VALUE=\"y\" $HIGHLIGHT >Yes &nbsp;&nbsp;<INPUT NAME=\"t_status\"  TYPE=\"radio\" VALUE=\"n\" CHECKED $HIGHLIGHT >No";
echo "<td align=\"CENTER\"><input type=\"SUBMIT\" VALUE=\"    Go   \">";
}
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
	echo "<FORM NAME=\"parentForm\" method=\"POST\" action=\"ccl_loan_issue_ef.php?menu=$menu&op=i\">";
echo "<table bgcolor=\"#8FBC8F\" width=\"100%\" align=\"CENTER\">";
echo "<tr><th bgcolor=\"#FFD700\" colspan=\"6\"><font size=+2>Cash Credit Loan Issuing Form For verify[$account_no]</font>";
echo "<tr><td>Issuing Date:<td><INPUT NAME=\"action_date\" TYPE=\"TEXT\" VALUE=\"".$_REQUEST['action_date']."\" $HIGHLIGHT size=\"15\" readonly>";
echo "<tr><td>Due Interest Rate:<td><INPUT NAME=\"due_int\" TYPE=\"TEXT\" VALUE=\"".$_REQUEST['due_int']."\" $HIGHLIGHT size=3 > &nbsp;%";
echo "<td>Over Due Interest Rate:<td><INPUT NAME=\"over_due_int\" TYPE=\"TEXT\" VALUE=\"".$_REQUEST['over_due_int']."\" $HIGHLIGHT size=\"3\" > &nbsp;%";
echo "<tr><td>Credit Limit Amount:<td>Rs.&nbsp<INPUT NAME=\"cr_limit_amount\" TYPE=\"TEXT\" VALUE=\"".$_REQUEST['cr_limit_amount']."\" size=\"10\" $HIGHLIGHT READONLY>";
echo "<td>Repayment Date:<td>Rs.&nbsp<INPUT NAME=\"period\" TYPE=\"TEXT\" VALUE=\"".$_REQUEST['period']."\" size=\"10\" $HIGHLIGHT> &nbsp; Months";
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
$cr_amount=$_REQUEST['cr_limit_amount'];
$over_due_int=$_REQUEST['over_due_int'];
$applied_amount=$_REQUEST['applied_amount'];
$account_sb=$_REQUEST['account_sb'];
$period=$_REQUEST['period'];
$issue_amount=$_REQUEST['issue_amount'];
$loan_sl_no=$_REQUEST['loan_sl_no'];
$repay_date=maturity_date($_REQUEST['action_date'],$_REQUEST['period'],'m');
$gl_code=getGlCode4mCustomerAccount($account_no,$action_date);
$fy=getFy($action_date);

	if(empty($fy)){
		echo "<h1><center><b>You Can't Insert any value Into database Because Financial Year already Locked by administrator !!!!!!!!!</h1>";
			} 	
	else{
	 	$t_id=getTranId();
		if(empty($loan_sl_no)){
		//loan_ledger_hrd
		$loan_sl_no=nextValue('loan_sl_no');
		$sql_statement="INSERT INTO loan_ledger_hrd (loan_serial_no,loan_type, customer_id,account_no,fy,issue_date,repay_date,period,int_due_rate,int_overdue_rate, applied_amount,status,staff_id,entry_time,gl_code,gl_status,max_limit) VALUES ('$loan_sl_no','ccl','$id','$account_no', '$fy','$action_date','$repay_date',$period,$due_int,$over_due_int,$applied_amount,'op', '$staff_id',CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP),'$gl_code','d',$cr_amount)";
		}
		$balance=loan_current_balance($account_no,$loan_sl_no,$action_date);
		//loan_issue_dtl
		$sql_statement=$sql_statement.";INSERT INTO loan_issue_dtl(tran_id, loan_serial_no,account_no,action_date,loan_amount,b_principal,staff_id,entry_time)VALUES('$t_id','$loan_sl_no','$account_no','$action_date',$issue_amount,($issue_amount+$balance),'$staff_id',CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
		//gl_ledger_hrd
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_hrd(tran_id,type, action_date,fy,remarks,operator_code, entry_time) VALUES ('$t_id','ccl','$action_date','$fy','$remarks','$staff_id', CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
		//gl_ledger_dtl ===== Dr.
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','$account_no','$gl_code',$issue_amount,'Dr','ccl issue')";
//gl_ledger_dtl ===== Cr.
	//For Cash 
		if(empty($account_sb)){
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','28101',$issue_amount,'Cr','ccl issue')";
		}
	//For Transfer to SB A/C.
		else{
		$gl_code=getGlCode4mCustomerAccount($account_sb,$action_date);
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars,account_no) VALUES('$t_id','$gl_code',$issue_amount,'Cr','ccl issue','$account_sb')";
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

?>
