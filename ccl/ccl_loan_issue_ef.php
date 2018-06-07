<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$action_date=$_REQUEST['action_date'];
$bank_account_no=$_REQUEST['bank_ac_no'];
$ch_no=$_REQUEST['ch_no'];
if(empty($action_date)){$action_date=date('d.m.Y');}
if(empty($_REQUEST['account_no'])){
	$account_no=$_SESSION["current_account_no"];
	}
else{
	$account_no=$_REQUEST['account_no'];
	$_SESSION["current_account_no"]=$account_no;
}
//getLoanInt('pl',date('d/m/Y'),$due,$over);
pl_document($account_no,$loan_sl_no,$sum_amount);
echo "<html>";
echo "<head>";
echo "<title> PL Main </title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script src=\"../JS/loading2.js\"></script>";
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

function cr_chk()
{
	
	var cr_limit=parseInt(document.getElementById('pd').value);
	var ap_amount=parseInt(document.getElementById('app_amount').value);
	var iss_amount=parseInt(document.getElementById('amount').value);
	var cr_limit_len=document.getElementById('pd').value.length;
	var ap_amount_len=document.getElementById('app_amount').value.length;
	var iss_amount_len=document.getElementById('amount').value.length;
	var period_len=document.getElementById('per').value.length;
	//alert('Amount Exceeds Credit'+cr_limit)
	//alert('Amount Exceeds'+ap_amount)
	//alert('Amount'+period_len)
	if(cr_limit_len=='0')
	{
		alert("Credit Limit Amount Should Not Be Blank !!!!");
		document.getElementById("pd").value='';
		document.getElementById("pd").focus();
		return false;
	}
	if(parseInt(document.getElementById('pd').value)<parseInt(document.getElementById('amount').value))
	{
		alert('Amount Exceeds Credit Limit')
		document.getElementById("amount").value='';
		document.getElementById("amount").focus();
		return false;
	}
	if(cr_limit<ap_amount)
	{
		alert('Applied Amount Exceeds Credit Limit')
		document.getElementById("app_amount").value='';
		document.getElementById("app_amount").focus();
		return false;
	}
	if(ap_amount<iss_amount)
	{
		alert('Issuing Amount Exceeds Applied Amount')
		document.getElementById("amount").value='';
		document.getElementById("amount").focus();
		return false;
	}
	if(period_len=='0')
	{
		alert("Period Should Not Be Blank !!!!");
		document.getElementById("per").focus();
		return false;
	}
	if(ap_amount_len=='0')
	{
		alert("Applied Amount Should Not Be Blank !!!!");
		document.getElementById("app_amount").focus();
		return false;
	}
	if(iss_amount_len=='0')
	{
		alert("Issuing Amount Should Not Be Blank !!!!");
		document.getElementById("amount").focus();
		return false;
	}
	
}

function numbersonly(e){
	var unicode=e.charCode? e.charCode : e.keyCode;
	//alert(unicode)
	if (unicode!=8){ 
		if (unicode<=46||unicode>57||unicode==47) {
			return false;		
		}
	}
	else{
if(document.getElementById("ac_ty").value==document.getElementById("ac_no").value){return false;}else{return true;}
	
	}
}
</SCRIPT>
<?php
if(empty($_REQUEST['im'])){

	$id=getCustomerId($account_no,$menu);
	$flag=getGeneralInfo_Customer($id);
}
else {
	$flag='1';
	}
if($flag==1){
	if(empty($_REQUEST['im']))
	{
		echo "<hr>";
	}
echo "</head>";
echo "<body bgcolor=\"silver\">";
//=======================================First Form ===========================================
if(empty($_REQUEST['op'])){

	if(empty($_REQUEST['im'])){
		echo "<FORM NAME=\"form1\" method=\"POST\" action=\"ccl_loan_issue_ef.php?menu=$menu&op=v\" onSubmit=\"return cr_chk();\">";

		echo "<table bgcolor=\"#BDB76B\" width=\"80%\" align=\"CENTER\">";
		echo "<tr><th bgcolor=\"#FFD700\" colspan=\"4\"><font size=+2>Cash Credit Loan Issuing Form[$account_no]</font>";
		//echo "<INPUT TYPE=\"button\" VALUE=\"  Add  \" onClick=\"openChild('addDocument.php?menu=ccl','win2')\">";
		$sql_statement="SELECT * FROM loan_ledger_hrd where account_no='$account_no'AND status='op'";
		$result=dBConnect($sql_statement);

		if(pg_NumRows($result)>0){
			$loan_sl_no=pg_result($result,'loan_serial_no');

			echo "<tr><td>Issuing Date:<td><INPUT NAME=\"action_date\" id=\"ac_date\" TYPE=\"TEXT\" VALUE=\"".pg_result($result,'issue_date')."\" $HIGHLIGHT size=\"15\" READONLY>";

			echo "<td>Re-Issuing Date:<td><INPUT NAME=\"action_date\" id=\"action_date\" TYPE=\"TEXT\" VALUE=\"".$action_date."\" $HIGHLIGHT size=\"10\">";
			echo "<INPUT TYPE=\"button\" VALUE=\"  Add  \" onClick=\"openChild('addDocument.php?menu=ccl','win2')\">";
			echo "<tr><td>Due Interest Rate:<td><INPUT NAME=\"due_int\" TYPE=\"TEXT\" VALUE=\"".pg_result($result,'int_due_rate')."\" $HIGHLIGHT size=3 readonly> &nbsp;%";
			echo "<td>Over Due Interest Rate:<td><INPUT NAME=\"over_due_int\" TYPE=\"TEXT\" VALUE=\"".pg_result($result,'int_overdue_rate')."\" $HIGHLIGHT size=\"3\" readonly> &nbsp;%";

			$sum_amount=pg_result($result,'max_limit');

			$loan_status=getLoanBalance($loan_sl_no);

			$sum_amount=$sum_amount-$loan_status;

			echo "<tr><td>Credit Limit Amount:<td>Rs.&nbsp<INPUT NAME=\"cr_limit_amount\" id=\"pd\" TYPE=\"TEXT\" VALUE=\"$sum_amount\" size=\"10\" $HIGHLIGHT READONLY>";
			echo "<td>Period:<td>Rs.&nbsp<INPUT NAME=\"period\" id=\"per\" TYPE=\"TEXT\"  VALUE=\"".pg_result($result,'period')."\" size=\"4\" onkeypress=\"return numbersonly(event);\" $HIGHLIGHT> &nbsp;Month";
			echo "<tr><td>Applied Amount:<td>Rs.&nbsp<INPUT NAME=\"applied_amount\" id=\"app_amount\" TYPE=\"TEXT\" VALUE=\"\" size=\"10\" $HIGHLIGHT >";
			echo "<td>Issuing Amount:<td>Rs.&nbsp<INPUT NAME=\"issue_amount\" id=\"amount\" TYPE=\"TEXT\" VALUE=\"\" size=\"10\" $HIGHLIGHT>";
			echo "<input type=\"HIDDEN\" name=\"loan_sl_no\" VALUE=\"$loan_sl_no\">";
			
			}
		else{
		echo "<tr><td>Issuing Date:<td><INPUT NAME=\"action_date\" id=\"action_date\" TYPE=\"TEXT\" VALUE=\"".$action_date."\" $HIGHLIGHT size=\"15\" READONLY>";
		echo "<td>Add Security:<td> <INPUT TYPE=\"button\" VALUE=\"  Add  \" onClick=\"openChild('addDocument.php?menu=ccl','win2')\">";
		echo "<tr><td>Due Interest Rate:<td><INPUT NAME=\"due_int\" TYPE=\"TEXT\" VALUE=\"12\" $HIGHLIGHT size=3 > &nbsp;%";
		echo "<td>Over Due Interest Rate:<td><INPUT NAME=\"over_due_int\" TYPE=\"TEXT\" VALUE=\"12\" $HIGHLIGHT size=\"3\" > &nbsp;%";
		echo "<tr><td>Credit Limit Amount:<td>Rs.&nbsp<INPUT NAME=\"cr_limit_amount\" id=\"pd\" TYPE=\"TEXT\" VALUE=\"$sum_amount\" size=\"10\" $HIGHLIGHT READONLY>";
		echo "<td>Period:<td><INPUT NAME=\"period\" id=\"per\" TYPE=\"TEXT\"  VALUE=\"\" size=\"4\" $HIGHLIGHT> &nbsp;Month";
		echo "<tr><td>Applied Amount:<td>Rs.&nbsp<INPUT NAME=\"applied_amount\" id=\"app_amount\" TYPE=\"TEXT\" VALUE=\"\" size=\"10\" $HIGHLIGHT >";
		echo "<td>Issuing Amount:<td>Rs.&nbsp<INPUT NAME=\"issue_amount\" id=\"amount\" TYPE=\"TEXT\" VALUE=\"\" size=\"10\" $HIGHLIGHT>";

		}
		
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

echo "</td></tr><tr><td colspan=\"3\" align=\"right\"></td><td align=\"left\"><input type=\"SUBMIT\" VALUE=\"    Go   \" $HIGHLIGHT>";
	echo "</FORM>";
	}

}

//========================================VIEW ===========================================================
if($_REQUEST['op']=='v'){
	$account_sb=findSBAccount($account_no);
	if(trim($_REQUEST['t_status'])=='y'&& (empty($account_sb))){
	echo "<font color=red size=+3 align=center><b>Dont have any Savings Account</font>";
		}
	else{
$repay_date=maturity_date($_REQUEST['action_date'],$_REQUEST['period'],'m');
	echo "<FORM NAME=\"parentForm\" method=\"POST\" action=\"ccl_loan_issue_ef.php?menu=$menu&op=i\">";
echo "<table bgcolor=\"#8FBC8F\" width=\"80%\" align=\"CENTER\" BORDER=\"1\">";
echo "<tr><th bgcolor=\"#FFD700\" colspan=\"6\"><font size=+2>Cash Credit Loan Issuing Form For verify[$account_no]</font>";
echo "<tr><td>Issuing Date:<td><INPUT NAME=\"action_date\" TYPE=\"TEXT\" VALUE=\"".$_REQUEST['action_date']."\" $HIGHLIGHT size=\"15\" readonly>";
echo "<tr><td>Due Interest Rate:<td><INPUT NAME=\"due_int\" TYPE=\"TEXT\" VALUE=\"".$_REQUEST['due_int']."\" $HIGHLIGHT size=3 > &nbsp;%";
echo "<td>Over Due Interest Rate:<td><INPUT NAME=\"over_due_int\" TYPE=\"TEXT\" VALUE=\"".$_REQUEST['over_due_int']."\" $HIGHLIGHT size=\"3\" > &nbsp;%";
echo "<tr><td>Credit Limit Amount:<td>Rs.&nbsp<INPUT NAME=\"cr_limit_amount\" TYPE=\"TEXT\" VALUE=\"".$_REQUEST['cr_limit_amount']."\" size=\"10\" $HIGHLIGHT READONLY>";
echo "<td>Repayment Date:<td><INPUT NAME=\"repay_date\" TYPE=\"TEXT\" VALUE=\"$repay_date\" size=\"10\" $HIGHLIGHT>";
echo"<input name='period' type='hidden' value='".$_REQUEST['period']."'>";
echo "<tr><td>Applied Amount:<td>Rs.&nbsp<INPUT NAME=\"applied_amount\" TYPE=\"TEXT\" VALUE=\"".$_REQUEST['applied_amount']."\" size=\"10\" $HIGHLIGHT READONLY>";
echo "<td>Issuing Amount:<td>Rs.&nbsp<INPUT NAME=\"issue_amount\" id=\"amount\" TYPE=\"TEXT\" VALUE=\"".$_REQUEST['issue_amount']."\" size=\"10\" $HIGHLIGHT READONLY>";

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
echo "<input type=\"HIDDEN\" name=\"issue\" VALUE=\"".$_REQUEST['issue']."\">";

	if(trim($_REQUEST['t_status'])=='c')
	{
		echo "<tr><td colspan=\"$col\" align=\"right\"><input type=\"SUBMIT\" VALUE=\"    Final  \">";
	}
	else
	{
		echo "<td colspan=\"$col\" align=\"right\"><input type=\"SUBMIT\" VALUE=\"    Final  \">";
	}
	}
 }

//+++++++++++++++++++++++++++++++++++++++++INSERT+++++++++++++++++++++++++++++++++++++++++++++
if($_REQUEST['op']=='i'){
echo "<form name=\"parentForm\"></form>";
$action_date=$_REQUEST['action_date'];
$t_status=$_REQUEST['t_status'];
if(trim($t_status)=='q')
{$cheque_dt=$action_date;}
$issue=$_REQUEST['issue'];
$ac=explode('-',$ac_num);
$ac_num=$ac[0];
$ac_typ=strtolower($ac[1]);
$account_sb=$_REQUEST['account_sb'];
//echo "<h1>$account_sb==$ac_typ==$ac_num==$bank_account_no==$ch_no==$menu==$t_status</h1>";
$chq_no=$_REQUEST['chq_no'];
$due_int=$_REQUEST['due_int'];
$cr_amount=$_REQUEST['cr_limit_amount'];
$over_due_int=$_REQUEST['over_due_int'];
$applied_amount=$_REQUEST['applied_amount'];
$period=$_REQUEST['period'];
$issue_amount=$_REQUEST['issue_amount'];
$loan_sl_no=$_REQUEST['loan_sl_no'];
$repay_date=$_REQUEST['repay_date'];
$gl_code=getGlCode4mCustomerAccount($account_no,$action_date);
//$fy=getFy($action_date);
$fy1=$_SESSION["fy"];
	if(empty($fy1)){
		echo "<h1><center><b>You Can't Insert any value Into database Because Financial Year already Locked by administrator !!!!!!!!!</h1>";
			} 	
	else{
	 	$t_id=getTranId();
		if(empty($loan_sl_no)){
		//loan_ledger_hrd
		$loan_sl_no=nextValue('loan_sl_no');
		$sql_statement="INSERT INTO loan_ledger_hrd (loan_serial_no,loan_type, customer_id,account_no,fy,issue_date,repay_date,period,int_due_rate,int_overdue_rate, applied_amount,status,staff_id,entry_time,gl_code,gl_status,max_limit,payment_term) VALUES ('$loan_sl_no','ccl','$id','$account_no', '$fy1','$action_date','$repay_date',$period,$due_int,$over_due_int,$applied_amount,'op', '$staff_id',CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP),'$gl_code','d',$cr_amount,'c')";
		}
		$balance=loan_current_balance($account_no,$loan_sl_no,$action_date);
		//loan_issue_dtl
		$sql_statement=$sql_statement.";INSERT INTO loan_issue_dtl(tran_id, loan_serial_no,account_no,action_date,loan_amount,b_principal,staff_id,entry_time)VALUES('$t_id','$loan_sl_no','$account_no','$action_date',$issue_amount,($issue_amount+$balance),'$staff_id',CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";

//gl_ledger_hrd
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_hrd(tran_id,type, action_date,fy,remarks,operator_code, entry_time,cheque_no,cheque_dt) VALUES ('$t_id','ccl','$action_date','$fy','$remarks','$staff_id', CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP),'$ch_no','$cheque_dt')";
//gl_ledger_dtl ===== Dr.
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','$account_no','$gl_code',$issue_amount,'Dr','ccl issue')";
//gl_ledger_dtl ===== Cr.

			if($t_status=='c')
			{
				$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','28101',$issue_amount,'Cr','ccl issue')";
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
			echo "Your Loan Amount:Rs. $issue_amount<br></h4>";
			echo "<font size=+1><a href=\"../main/set_account.php?menu=$menu&account_no=$account_no\">Click</a> here to go Statement</div>"; 
		}

	}

 }
}

?>
