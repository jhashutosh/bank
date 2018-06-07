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
pl_document($account_no,&$loan_sl_no,&$sum_amount);
echo "<html>";
echo "<head>";
echo "<title> HOUSE LOAN Main </title>";
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
echo "<body bgcolor=\"silver\">";
//=======================================First Form ===========================================
if(empty($_REQUEST['op'])){
echo "<FORM NAME=\"form1\" method=\"POST\" action=\"houseloan_ledger_ef.php?menu=$menu&op=v\" onSubmit=\"return varify();\">";
echo "<table bgcolor=\"#ADD8E6\" width=\"80%\" align=\"CENTER\">";
echo "<tr><th bgcolor=\"#FFD700\" colspan=\"6\"><font size=+2>House Loan Issuing Form[$account_no]</font>";
echo "<tr><td>Issuing Date:<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT NAME=\"action_date\" TYPE=\"TEXT\" VALUE=\"".date('d/m/Y')."\" $HIGHLIGHT size=\"15\" id=\"action_date\">";
echo "<td>Add Security Amount:<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
if(empty($loan_sl_no)){
echo "<INPUT TYPE=\"button\" VALUE=\"  Add  \" onClick=\"openChild('addDocument.php?menu=house','win2')\">";
//echo "<tr><td>Applied Amount:<td>Rs.&nbsp<INPUT NAME=\"credit_limit\" TYPE=\"TEXT\" VALUE=\"$sum_amount\" size=\"10\" $HIGHLIGHT DISABLED>";
//echo "<td>Issuing Amount:<td>Rs.&nbsp<INPUT NAME=\"amount\" id=\"amount\" TYPE=\"TEXT\" VALUE=\"\" size=\"10\" $HIGHLIGHT DISABLED>";
echo "<tr><td align=\"\" colspan=\"3\"><td align=\"CENTER\"><input type=\"SUBMIT\" VALUE=\"    Go   \" DISABLED>";

}
else{
echo "<INPUT TYPE=\"button\" VALUE=\"  Add  \" onClick=\"openChild('addDocument.php?menu=house','win2')\" DISABLED>";
//echo "<tr><td>Due Interest Rate:<td><INPUT NAME=\"due_int\" TYPE=\"TEXT\" VALUE=\"10\" $HIGHLIGHT size=3 > &nbsp;%";
echo "<tr><td><td><td>EMI Rate / Month:<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT NAME=\"emi_rate\" TYPE=\"TEXT\" VALUE=\"40\" $HIGHLIGHT size=\"3\" > &nbsp;%";
echo "<tr><td>Security Amount:<td>Rs.&nbsp<INPUT NAME=\"security_amount\" TYPE=\"TEXT\" VALUE=\"$sum_amount\" size=\"10\" $HIGHLIGHT READONLY> <a href=document_view.php?menu=house&account_no=$account_no>View</a>";
echo "<td>Period:<td>Rs.&nbsp;&nbsp;<INPUT NAME=\"period\" TYPE=\"TEXT\" VALUE=\"\" size=\"4\" $HIGHLIGHT> &nbsp;Month";
echo "<tr><td>Net Salary / Month<td>Rs.&nbsp;<INPUT NAME=\"applied_amount\" TYPE=\"TEXT\" VALUE=\"\" size=\"10\" $HIGHLIGHT >";
//echo "<td>Issuing Amount:<td>Rs.&nbsp<INPUT NAME=\"issue_amount\" id=\"amount\" TYPE=\"TEXT\" VALUE=\"\" size=\"10\" $HIGHLIGHT>";
echo "<td>Due Interest Rate:<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT NAME=\"due_int\" TYPE=\"TEXT\" VALUE=\"10\" $HIGHLIGHT size=3 > &nbsp;%";
echo "<tr><td colspan=\"3\" align=\"CENTER\">Transfer to Your SB A/C : <INPUT NAME=\"t_status\"  TYPE=\"radio\" VALUE=\"y\" $HIGHLIGHT >Yes &nbsp;&nbsp;<INPUT NAME=\"t_status\"  TYPE=\"radio\" VALUE=\"n\" CHECKED $HIGHLIGHT >No";
echo "<input type=\"HIDDEN\" name=\"loan_sl_no\" VALUE=\"$loan_sl_no\">";
echo "<td align=\"CENTER\"><input type=\"SUBMIT\" VALUE=\"    Go   \" $HIGHLIGHT>";
}
echo "</FORM>";

}
//=============================================================================================
//========================================VIEW ++++++++++++++++++++++++++++++++++++++++++++++++
$applied_amount=$_REQUEST['applied_amount'];
$emi_rate=$_REQUEST['emi_rate'];
$due_rate=$_REQUEST['due_int'];
$period=$_REQUEST['period'];
//echo "<h1>$applied_amount==$emi_rate==$period==$due_rate</h1>";
$emi=round(($applied_amount*$emi_rate)/100);
$emi_calcu=round(EMI_calculation_ram($emi,$due_rate,$period));
//echo "<h1>$emi</h1>";
//echo "<h1>$emi_calcu</h1>";

if($_REQUEST['op']=='v'){
	$account_sb=findSBAccount($account_no);
	if(trim($_REQUEST['t_status'])=='y'&& (empty($account_sb))){
	echo "<font color=red size=+3 align=center><b>Dont have any Savings Account</font>";
		}
	else{
	echo "<FORM NAME=\"parentForm\" method=\"POST\" action=\"houseloan_ledger_ef.php?menu=$menu&op=i\">";
echo "<table bgcolor=\"#8FBC8F\" width=\"80%\" align=\"CENTER\">";
echo "<tr><th bgcolor=\"#FFD700\" colspan=\"6\"><font size=+2>House Loan Issuing Form For Verify [$account_no]</font>";
echo "<tr><td>Issuing Date:<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT NAME=\"action_date\" TYPE=\"TEXT\" VALUE=\"".$_REQUEST['action_date']."\" $HIGHLIGHT size=\"15\" readonly>";
echo "<td>Add Security Amount:<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<INPUT TYPE=\"button\" VALUE=\"  Add  \" onClick=\"openChild('addDocument.php?menu=house','win2')\" DISABLED>";
echo "<tr><td>Due Interest Rate:<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT NAME=\"due_int\" TYPE=\"TEXT\" VALUE=\"".$_REQUEST['due_int']."\" $HIGHLIGHT size=3 > &nbsp;%";
echo "<td>Over Due Interest Rate:<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT NAME=\"over_due_int\" TYPE=\"TEXT\" VALUE=\"12\"".$_REQUEST['over_due_int']."\" $HIGHLIGHT size=\"3\" > &nbsp;%";
echo "<tr><td>Security Amount:<td>Rs.&nbsp<INPUT NAME=\"security_amount\" TYPE=\"TEXT\" VALUE=\"".$_REQUEST['security_amount']."\" size=\"10\" $HIGHLIGHT READONLY> <a href=document_view.php?menu=house&account_no=$account_no>View</a>";

echo "<td>Period:<td>Rs.&nbsp<INPUT NAME=\"period\" TYPE=\"TEXT\" VALUE=\"".$_REQUEST['period']."\" size=\"10\" $HIGHLIGHT> &nbsp; Months";
echo "<tr><td>Applied Amount:<td>Rs.&nbsp<INPUT NAME=\"applied_amount\" TYPE=\"TEXT\" VALUE=\"$emi_calcu\" size=\"10\" $HIGHLIGHT  READONLY>";
echo "<td>Issuing Amount:<td>Rs.&nbsp<INPUT NAME=\"issue_amount\" id=\"amount\" TYPE=\"TEXT\" VALUE=\"$emi_calcu\" size=\"10\" $HIGHLIGHT>";
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
$loan_sl_no=$_REQUEST['loan_sl_no'];
$repay_date=maturity_date($_REQUEST['action_date'],$_REQUEST['period'],'m');
$gl_code=getGlCode4mCustomerAccount($account_no,$action_date);
	$fy=getFy($action_date);
	if(empty($fy)){
		echo "<h1><center><b>You Can't Insert any value Into database Because Financial Year already Locked by administrator !!!!!!!!!</h1>";
			} 	
	else{

		if($issue_amount>$applied_amount)
		{
			echo "<h1><center><blink><font color=\"RED\">You Can't Issue $issue_amount because your issue amount is more than your applied amount $applied_amount</h1>";
		}
		else
		{
	 	$t_id=getTranId();
//loan_ledger_hrd
		$sql_statement="INSERT INTO loan_ledger_hrd (loan_serial_no,loan_type, customer_id,account_no,fy,issue_date,repay_date,period,int_due_rate,int_overdue_rate, applied_amount,status,staff_id,entry_time,gl_code,gl_status) VALUES ('$loan_sl_no','hb','$id','$account_no', '$fy','$action_date','$repay_date',$period,$due_int,$over_due_int,$applied_amount,'op', '$staff_id',CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP),'$gl_code','d')";
//loan_security 
		$sql_statement=$sql_statement.";UPDATE loan_security SET status='l' WHERE loan_serial_no='$loan_sl_no' AND account_no='$account_no'";
//loan_issue_dtl
		$sql_statement=$sql_statement.";INSERT INTO loan_issue_dtl(tran_id, loan_serial_no,account_no,action_date,loan_amount,b_principal,staff_id,entry_time)VALUES('$t_id','$loan_sl_no','$account_no','$action_date',$issue_amount,$issue_amount,'$staff_id',CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
//gl_ledger_hrd
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_hrd(tran_id,type, action_date,fy,remarks,operator_code, entry_time) VALUES ('$t_id','hb','$action_date','$fy','$remarks','$staff_id', CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
//gl_ledger_dtl ===== Dr.
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','$account_no','$gl_code',$issue_amount,'Dr','house issue')";
//gl_ledger_dtl ===== Cr.
	//For Cash 
		if(empty($account_sb)){
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','28101',$issue_amount,'Cr','house issue')";
		}
	//For Transfer to SB A/C.
		else{
		$gl_code=getGlCode4mCustomerAccount($account_sb,$action_date);
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars,account_no) VALUES('$t_id','$gl_code',$issue_amount,'Cr','house issue','$account_sb')";
		}
		//echo $sql_statement;
		$result=dBConnect($sql_statement);
		if(pg_affected_rows($result)<1){
		echo "<br><h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
			} 
		else{
			echo "<h4><font color=\"Green\">Sucessfully inserted data into database.</font><br>Your Transaction Id:$t_id";
			echo "<br>Your Loan Amount:Rs. $issue_amount<br></h4>";
			echo "<font size=+1><a href=\"../main/set_account.php?menu=house&account_no=$account_no\">Click</a> here to go Statement"; 
		    }
		}

	}

 }
}

?>
