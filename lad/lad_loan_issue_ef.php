<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$bank_account_no=$_REQUEST['bank_ac_no'];
$ch_no=$_REQUEST['ch_no'];
if(empty($_REQUEST['account_no'])){
	$account_no=$_SESSION["current_account_no"];
	}
else{
	$account_no=$_REQUEST['account_no'];
	$_SESSION["current_account_no"]=$account_no;
}
$fy1=$_SESSION["fy"];

//getLoanInt('pl',date('d/m/Y'),$due,$over);
pl_document($account_no,$loan_sl_no,$sum_amount);
echo "<html>";
echo "<head>";
echo "<title> LAD Main </title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script language=\"JavaScript\" src=\"../JS/varify.js\" type=\"text/javascript\"></script>";
?>
<link rel="stylesheet" href="../retail/css/retail.css">

<SCRIPT LANGUAGE="JavaScript">
function openChild(file,window){
	var str=document.getElementById('action_date').value;
	file=file+"&l_date="+str;
       	childWindow=open(file,window, 'toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=300,left=250, width=600,height=300');
    if(childWindow.opener == null) childWindow.opener = self;
    }

function findAccount(){
var str=document.getElementById("sb_ac").value;
if(str.length==0)
{
alert("Please enter introducer account no.")
document.form.sb_ac.disabled=false;
document.form.sb_ac.readonly=false;
document.form.sb_ac.focus();
}
else
{
url="../main/pop_up_account.php?menu=sb&account_no="+str;
window.open(url,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150,width=1050,height=500');
return false;
}
}

function numbersonly(e){
	var unicode=e.charCode? e.charCode : e.keyCode;
	//alert(unicode)
	if (unicode!=8){ 
		if (unicode<46||unicode>57||unicode==47) {
			return false;		
		}
	}
	
}

function varify()
{
	var security_amount=parseInt(document.getElementById("security_amount").value);
	var app_amount=parseInt(document.getElementById("applied_amount").value);
	var iss_amount=parseInt(document.getElementById("issue_amount").value);
	var applied_amount=document.getElementById("applied_amount").value.length;
	var issu_amount=document.getElementById("issue_amount").value.length;
	var rep_period=document.getElementById("period").value;
	
	if(rep_period=='')
	{
		alert("Repayment Date Should Not Be Blank !!!!");
		document.getElementById("period").value='';
		document.getElementById("period").focus();
		return false;
	}
	if(app_amount>security_amount)
	{

		alert("Applied Amount Must Be Less Than Security Amount !!!!");
		document.getElementById("applied_amount").value='';
		document.getElementById("applied_amount").focus();
		return false;
	}
	if(iss_amount>app_amount)
	{

		alert("Issue Amount Must Be Less Than Applied Amount !!!!");
		document.getElementById("issue_amount").value='';
		document.getElementById("issue_amount").focus();
		return false;
	}
	if(applied_amount=='0')
	{
		alert("Aplied Amount Should Not Be Blank !!!!");
		document.getElementById("applied_amount").value='';
		document.getElementById("applied_amount").focus();
		return false;
	}
	if(issu_amount=='0')
	{
		alert("Issue Amount Should Not Be Blank !!!!");
		document.getElementById("issue_amount").value='';
		document.getElementById("issue_amount").focus();
		return false;
	}
	
}


function Result(str)
{
//alert(str)
if (str=='q')
	{
		document.getElementById("q").style.display='';
	}
	else
	{
		document.getElementById("q").style.display='none';
	}
if (str=='y')
	{
		document.getElementById("y").style.display='';
	}
	else
	{
		document.getElementById("y").style.display='none';
	}
}
</SCRIPT>
<?php
$id=getCustomerId($account_no,$menu);
$flag=getGeneralInfo_Customer($id);
if($flag==1){
echo "<hr>";
echo "</head>";
echo "<body bgcolor=\"silver\">";
//=======================================First Form ===========================================
if(empty($_REQUEST['op'])){
echo "<FORM NAME=\"form1\" method=\"POST\" action=\"lad_loan_issue_ef.php?menu=$menu&op=v\" onSubmit=\"return varify(this.form);\">";
echo "<table bgcolor=\"#ADD8E6\" width=\"80%\" align=\"CENTER\">";
echo "<tr><th bgcolor=\"#FFD700\" colspan=\"6\"><font size=+2>LAD Issuing Form[$account_no]</font>";
echo "<tr><td>Issuing Date:<td><INPUT NAME=\"action_date\" TYPE=\"TEXT\" VALUE=\"".date('d/m/Y')."\" $HIGHLIGHT size=\"15\" id=\"action_date\">";
echo "<td>Add Security Amount:<td>";
if(empty($loan_sl_no)){
echo "<INPUT TYPE=\"button\" VALUE=\"  Add  \" onClick=\"openChild('addDocument.php?menu=lad','win2')\">";

echo "<tr><td align=\"\" colspan=\"3\"><td align=\"CENTER\"><input type=\"SUBMIT\" VALUE=\"    Go   \" DISABLED>";

}
else{
echo "<INPUT TYPE=\"button\" VALUE=\"  Add  \" onClick=\"openChild('addDocument.php?menu=lad','win2')\" DISABLED>";
echo "<tr><td>Due Interest Rate:<td><INPUT NAME=\"due_int\" TYPE=\"TEXT\" VALUE=\"12.5\" $HIGHLIGHT size=3> &nbsp;%";
echo "<td>Over Due Interest Rate:<td><INPUT NAME=\"over_due_int\" TYPE=\"TEXT\" VALUE=\"14.5\" $HIGHLIGHT size=\"3\" > &nbsp;%";
echo "<tr><td>Security Amount:<td>Rs.&nbsp<INPUT NAME=\"security_amount\" id=\"security_amount\" TYPE=\"TEXT\" VALUE=\"$sum_amount\" size=\"10\" $HIGHLIGHT READONLY> <a href=../general/security_document.php?menu=lad&account_no=$account_no>View</a>";
echo "<td>Repay Date:<td><INPUT NAME=\"period\" id=\"period\" TYPE=\"TEXT\" VALUE=\"\" size=\"13\" $HIGHLIGHT >";
echo "<tr><td>Applied Amount:<td>Rs.&nbsp<INPUT NAME=\"applied_amount\" id=\"applied_amount\" TYPE=\"TEXT\" VALUE=\"\" size=\"10\" $HIGHLIGHT onkeypress=\"return numbersonly(event);\">";
echo "<td>Issuing Amount:<td>Rs.&nbsp<INPUT NAME=\"issue_amount\" id=\"issue_amount\" TYPE=\"TEXT\" VALUE=\"\" size=\"10\" $HIGHLIGHT onkeypress=\"return numbersonly(event);\">";

//****************************************rajesh*************************************************

echo "<tr><td align=\"left\">Payment Mood : </td>";
echo "<td><SELECT name=\"t_status\"><option value=\"c\" onclick=\"Result(this.value)\">CASH</option><option value=\"q\" onclick=\"Result(this.value)\">CHEQUE</option><option value=\"y\" onclick=\"Result(this.value)\">Trf to SB</option></td>";

$sb_account_no=customerAccountNo($id,'sb');
//if(!empty($sb_account_no)){$READONLY='READONLY';}

$CHECK_Y='CHECKED';


echo "<tr ID='q' style='display:none'>";
echo "<td>Cheque No:</td><td><input type=TEXT name=\"ch_no\" size=\"12\" id=\"ch_no\" value=\"0\" $HIGHLIGHT></td>";
echo "<td>Transfer From:<td>";
selectBankAccount('bank_ac_no','ENABLE');
echo "</td></tr>";


echo "<tr ID='y' style='display:none'><td>Transfer to SB A/C :</td>";
echo "<td><input type=\"TEXT\" id=\"sb_ac\" size=\"8\" value=\"$sb_account_no\" name=\"sb_account_no\" $READONLY $HIGHLIGHT $DISABLED>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" id=\"sb_bt\" name=\"BUTTON\" value=\"Search\" $DISABLED onClick=\"findAccount();\"></tr>";

//****************************************************************************


echo "<input type=\"HIDDEN\" name=\"loan_sl_no\" VALUE=\"$loan_sl_no\">";
echo "</td></tr><tr><td colspan=\"3\" align=\"right\"></td><td align=\"left\"><input type=\"SUBMIT\" VALUE=\"    Go   \" $HIGHLIGHT>";
}
echo "</FORM>";

}

//========================================VIEW====================================================
if($_REQUEST['op']=='v'){
	$account_sb=findSBAccount($account_no);
	if(trim($_REQUEST['t_status'])=='y'&& (empty($account_sb))){
	echo "<font color=red size=+3 align=center><b>Dont have any Savings Account</font>";
		}
	else{
	echo "<FORM NAME=\"parentForm\" method=\"POST\" action=\"lad_loan_issue_ef.php?menu=$menu&op=i\">";
echo "<table bgcolor=\"#8FBC8F\" width=\"80%\" align=\"CENTER\">";
echo "<tr><th bgcolor=\"#FFD700\" colspan=\"6\"><font size=+2>LAD Issuing Form For verify[$account_no]</font>";
echo "<tr><td>Issuing Date:<td><INPUT NAME=\"action_date\" TYPE=\"TEXT\" VALUE=\"".$_REQUEST['action_date']."\" $HIGHLIGHT size=\"15\" readonly>";
echo "<td>Add Security Amount:<td>";
echo "<INPUT TYPE=\"button\" VALUE=\"  Add  \" onClick=\"openChild('addDocument.php?menu=lad','win2')\" DISABLED>";
echo "<tr><td>Due Interest Rate:<td><INPUT NAME=\"due_int\" TYPE=\"TEXT\" VALUE=\"".$_REQUEST['due_int']."\" $HIGHLIGHT size=3 > &nbsp;%";
echo "<td>Over Due Interest Rate:<td><INPUT NAME=\"over_due_int\" TYPE=\"TEXT\" VALUE=\"".$_REQUEST['over_due_int']."\" $HIGHLIGHT size=\"3\" > &nbsp;%";
echo "<tr><td>Security Amount:<td>Rs.&nbsp<INPUT NAME=\"security_amount\" TYPE=\"TEXT\" VALUE=\"".$_REQUEST['security_amount']."\" size=\"10\" $HIGHLIGHT READONLY> <a href=../general/security_document.php?menu=lad&account_no=$account_no>View</a>";

echo "<td>Repayment Period:<td><INPUT NAME=\"period\" TYPE=\"TEXT\" VALUE=\"".$_REQUEST['period']."\" size=\"3\" $HIGHLIGHT> &nbsp; Months";
echo "<tr><td>Applied Amount:<td>Rs.&nbsp<INPUT NAME=\"applied_amount\" TYPE=\"TEXT\" VALUE=\"".$_REQUEST['applied_amount']."\" size=\"10\" $HIGHLIGHT >";
echo "<td>Issuing Amount:<td>Rs.&nbsp<INPUT NAME=\"issue_amount\" id=\"amount\" TYPE=\"TEXT\" VALUE=\"".$_REQUEST['issue_amount']."\" size=\"10\" $HIGHLIGHT>";


	$col='4';
	if(trim($_REQUEST['t_status'])=='q')
	{
		
		echo "<tr>";
		echo "<td>Cheque No:<td><input type=TEXT name=\"ch_no\" size=\"13\" id=\"ch_no\" value=\"$ch_no\" $HIGHLIGHT READONLY>";
		echo "<td>Transfer From:<td><input type=TEXT name=\"bank_ac_no\" size=\"13\" id=\"ch_no\" value=\"$bank_account_no\" $HIGHLIGHT READONLY>";
		echo "</tr>";
	}

	if(trim($_REQUEST['t_status'])=='y')
	{
		
		echo "<tr><td>Your SB A/C No. :<td><INPUT NAME=\"account_sb\" id=\"ac\" TYPE=\"TEXT\" VALUE=\"$account_sb\" size=\"10\" $HIGHLIGHT READONLY>";
	}
echo "<input name='t_status'  TYPE=\"hidden\" value=\"".$_REQUEST['t_status']."\"/>";
echo "<input type=\"HIDDEN\" name=\"loan_sl_no\" VALUE=\"".$_REQUEST['loan_sl_no']."\">";
echo "<tr><td colspan=\"4\" align=\"right\"><input type=\"SUBMIT\" VALUE=\"    Final  \">";
	}

 }

//+++++++++++++++++++++++++++++++++++++++++INSERT+++++++++++++++++++++++++++++++++++++++++++++

if($_REQUEST['op']=='i'){
echo "<form name=\"parentForm\"></form>";
$action_date=$_REQUEST['action_date'];
$due_int=$_REQUEST['due_int'];
$over_due_int=$_REQUEST['over_due_int'];
$applied_amount=$_REQUEST['applied_amount'];
$account_sb=$_REQUEST['account_sb'];
$repay_date=$_REQUEST['period'];
$issue_amount=$_REQUEST['issue_amount'];
$loan_sl_no=$_REQUEST['loan_sl_no'];
$t_status=$_REQUEST['t_status'];
if(trim($t_status)=='q')
{$cheque_dt=$action_date;}
//$repay_date=maturity_date($_REQUEST['action_date'],$_REQUEST['period'],'m');
$gl_code=getGlCode4mCustomerAccount($account_no,$action_date);
	//$fy=getFy($action_date);
	$fy1=$_SESSION["fy"];
	if(empty($fy1)){
		echo "<h1><center><b>You Can't Insert any value Into database Because Financial Year already Locked by administrator !!!!!!!!!</h1>";
			} 	
	else{
	 	$t_id=getTranId();
//loan_ledger_hrd
		$sql_statement="INSERT INTO loan_ledger_hrd (loan_serial_no,loan_type, customer_id,account_no,fy,issue_date,repay_date,int_due_rate,int_overdue_rate, applied_amount,status,staff_id,entry_time,gl_code,gl_status,payment_term) VALUES ('$loan_sl_no','lad','$id','$account_no', '$fy1','$action_date','$repay_date',$due_int,$over_due_int,$applied_amount,'op', '$staff_id',CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP),'$gl_code','d','c')";
//loan_security 
		$sql_statement=$sql_statement.";UPDATE loan_security SET status='l' WHERE loan_serial_no='$loan_sl_no' AND account_no='$account_no'";
//loan_issue_dtl
		$sql_statement=$sql_statement.";INSERT INTO loan_issue_dtl(tran_id, loan_serial_no,account_no,action_date,loan_amount,b_principal,staff_id,entry_time)VALUES('$t_id','$loan_sl_no','$account_no','$action_date',$issue_amount,$issue_amount,'$staff_id',CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
//gl_ledger_hrd
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_hrd(tran_id,type, action_date,fy,remarks,operator_code, entry_time,cheque_no,cheque_dt) VALUES ('$t_id','lad','$action_date','$fy1','$remarks','$staff_id', CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP),'$ch_no','$cheque_dt')";
//gl_ledger_dtl ===== Dr.
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','$account_no','$gl_code',$issue_amount,'Dr','lad issue')";
//gl_ledger_dtl ===== Cr.

		if($t_status=='c')
		{
			$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','28101',$issue_amount,'Cr','lad issue')";
		}
		if($t_status=='y')
		{
			$gl_code=getGlCode4mCustomerAccount($account_sb,$action_date);
			$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,account_no,amount,dr_cr, particulars) VALUES('$t_id','$gl_code','$account_sb',$issue_amount,'Cr','Transfer From $account_no')";
		}
		if($t_status=='q')
		{
			$bk_gl_code=getGlCode4mBank($bank_account_no);
			$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,account_no,amount,dr_cr, particulars) VALUES('$t_id','$bk_gl_code','$bank_account_no',$issue_amount,'Cr','Issue To $account_no')";
		}
		//echo $sql_statement;
		$result=dBConnect($sql_statement);
		if(pg_affected_rows($result)<1){
		echo "<div class='failed'><h3><font color=\"white\">Failed to update database.</font></h3></div>";	
			} 
		else{
			echo "<div class='success'><h4><font color=\"Green\">Sucessfully inserted data into database.</font><br>Your Transaction Id:$t_id";
			echo "<br>Your Loan Amount:Rs. $issue_amount<br></h4>";
			echo "<font size=+1><a href=\"../main/set_account.php?menu=lad&account_no=$account_no\">Click</a> here to go Statement</div>"; 
		}

	}

 }
}

?>
