<?php
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
$fy1=$_SESSION["fy"];
$loan_sl_no=$_REQUEST['loan_sl_no'];
$due_int=$_REQUEST['d_int_r'];
$overdue_int=$_REQUEST['od_int_r'];
$crop_id=$_REQUEST['crop_id'];
$action_date=$_REQUEST['action_date'];
$amount=$_REQUEST['amount'];
$issued_amount=$_REQUEST['issued_amount'];
$balance_limit=$_REQUEST['bal_limit'];
$max_limit=$_REQUEST['credit_limit'];
$c_insurance=$_REQUEST['c_insurance'];
$s_insurance=$_REQUEST['s_insurance'];
$bank_account_no=$_REQUEST['bank_ac_no'];
$ch_no=$_REQUEST['ch_no'];
$id=getCustomerId($account_no,$menu);
//echo "<h1>Loan_sl_no=$loan_sl_no";
echo "<html>";
echo "<head>";
echo "<title> KCC Main </title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
?>
<link rel="stylesheet" href="../retail/css/retail.css">
<SCRIPT LANGUAGE="JavaScript">
function openChild(file,window){
        var crop_id=document.getElementById("crop_id").value;
	file=file+'&crop_id='+crop_id;
	
	childWindow=open(file,window, 'toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=300,left=150, width=800,height=300');
    if(childWindow.opener == null) childWindow.opener = self;
    }
function onSubmits(f){
  f.submit();
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

function varify()
{
	var balen_limit=parseInt(document.getElementById("bal_limit").value);
	var iss_amount=parseInt(document.getElementById("amount").value);
	var issu_amount=document.getElementById("amount").value.length;
		
	if(iss_amount>balen_limit)
	{

		alert("Issue Amount Must Be Less Than Remaining Limit !!!!");
		document.getElementById("amount").value='';
		document.getElementById("amount").focus();
		return false;
	}
	if(issu_amount=='0')
	{
		alert("Issue Amount Should Not Be Blank !!!!");
		document.getElementById("amount").value='';
		document.getElementById("amount").focus();
		return false;
	}
}
</SCRIPT>
<?php

$flag=getGeneralInfo_Customer($id);
if($flag==1){
echo "<hr>";
//echo "<script src=\"../JS/validation.js\"></script>";
echo "</head>";
echo "<body bgcolor=\"silver\"\" onload=\"amount.focus();\">";
//==========================here Inserting Data into Database==================================
if($_REQUEST['op']=='i'){
$t_status=$_REQUEST['t_status'];
if(trim($t_status)=='q')
{$cheque_dt=$action_date;}
//echo "<h1>$account_sb==$ac_typ==$ac_num==$bank_account_no==$ch_no==$menu==$t_status</h1>";
	$gl_code=getGlCode4mCustomerAccount($account_no,$action_date);
	$fy1=$_SESSION["fy"];
	//$fy=getFy($action_date);
	if(empty($fy1)){
		echo "<h1><center><b>You Can't Insert any value Into database Because Financial Year already Locked by administrator !!!!!!!!!</h1>";
			} 	
	else{
	 	$t_id=getTranId();
		$sql_statement="";
		if($issued_amount==0){
			$due_date=getKccDueDate($fy1,$crop_id);
	 		$sql_statement="UPDATE loan_ledger_hrd SET issue_date='$action_date', repay_date='$due_date',self_insurance=$s_insurance,status='op',staff_id='$staff_id',entry_time= CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP) WHERE loan_serial_no='$loan_sl_no' AND account_no='$account_no'";
			$sql_statement=$sql_statement.";UPDATE loan_security SET status='l' WHERE loan_serial_no='$loan_sl_no' AND account_no='$account_no'";
			$upFlag=true;
			}
		else{$s_insurance=0;}
			
		$balance=loan_current_balance($account_no,$loan_sl_no,$action_date);
		if($upFlag){$sql_statement=$sql_statement.';';}
		$sql_statement=$sql_statement."INSERT INTO loan_issue_dtl(tran_id, loan_serial_no,account_no,action_date,loan_amount,b_principal,crop_insurance,staff_id,entry_time)VALUES('$t_id','$loan_sl_no','$account_no','$action_date',$amount,($balance+$amount),$c_insurance,'$staff_id',CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
//gl_ledger_hrd
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_hrd(tran_id,type, action_date,fy,remarks, operator_code, entry_time,cheque_no,cheque_dt) VALUES ('$t_id','kcc','$action_date','$fy1','$remarks', '$staff_id', CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP),'$ch_no','$cheque_dt')";
//gl_ledger_dtl ===== Dr.
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','$account_no','$gl_code',$amount,'Dr','kcc issue')";
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','$account_no','57997',$c_insurance,'Cr','crop Insurance')";
		if($upFlag){
			if($s_insurance>0){
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','$account_no','57998',$s_insurance,'Cr','farmar self Insurance')";
			}
		}
//gl_ledger_dtl ===== Cr.
			if($t_status=='c')
			{
				$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','28101',($amount-$c_insurance-$s_insurance),'Cr','kcc issue')";
			}
			if($t_status=='y')
			{
				$gl_code=getGlCode4mCustomerAccount($account_sb,$action_date);
				$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,account_no,amount,dr_cr, particulars) VALUES('$t_id','$gl_code','$account_sb',($amount-$c_insurance-$s_insurance),'Cr','Transfer From $account_no')";
			}
			if($t_status=='q')
			{
				$bk_gl_code=getGlCode4mBank($bank_account_no);
				$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,account_no,amount,dr_cr, particulars) VALUES('$t_id','$bk_gl_code','$bank_account_no',($amount-$c_insurance-$s_insurance),'Cr','Issue To $account_no')";
			}

		//echo $sql_statement;
		$result=dBConnect($sql_statement);
		if(pg_affected_rows($result)<1){
		echo "<div class='failed'><h3><font color=\"white\">Failed to update database.</font></h3></div>";
			} 
		else{
			echo "<div class='success'><h4><font color=\"Green\">Sucessfully inserted data into database.</font><br>Your Transaction Id:$t_id</h4>";
			echo "<pre><font size=\"+1\"><b>Your Loan Amount: Rs. $amount<br>";
			if($upFlag){
			echo "<br>Less:Self Insurance:   Rs.&nbsp;$s_insurance";}
			echo "<br>Less:Crop Insurance:   Rs.&nbsp;$c_insurance";
			echo "<br>____________________   Rs.".($c_insurance+$s_insurance);
			echo "<br>You Paid to the farmar:Rs.".($amount-($c_insurance+$s_insurance));
			echo "</font></pre>";
			echo "<font size=+1><a href=\"../main/set_account.php?menu=kcc&account_no=$account_no\">Click</a> here to go Statement</div>"; 
	     	
           		 }
	
  	}
     
}
//==================================FOR VERIFYING ===========================================
else if($_REQUEST['op']=='v'){
	//$account_sb=findSBAccount($account_no);
	$account_sb=$_REQUEST['sb_account_no'];
	if(trim($_REQUEST['t_status'])=='y'&& (empty($account_sb))){
	echo "<font color=red size=+3 align=center><b>Dont have any Savings Account</font>";
		}
	else{
	$karbanama_value=getKarbanamaValue($loan_sl_no,$account_no);
	if($karbanama_value>=($amount+$issued_amount)){
echo "<table bgcolor=\"BLACK\" width=\"80%\" align=\"CENTER\" border=\"class\">";
echo "<tr><th bgcolor=\"#9400D3\" colspan=\"4\"><font size=+2>KCC Issuing Varify Form of [$account_no]</font>";
echo "<FORM NAME=\"parentForm\" method=\"POST\" action=\"kcc_loan_issue.php?menu=$menu&op=i\">";
echo "<tr><td colspan=\"2\" align=\"right\" bgcolor=\"#90EE90\"> Crop:<td bgcolor=\"#90EE90\"><INPUT TYPE=\"TEXT\" VALUE=\"".getName('crop_id',$crop_id,'crop_desc','crop_mas')."\" $HIGHLIGHT size=\"15\" readonly><td bgcolor=\"#90EE90\">";
echo "<tr>";
echo "<td bgcolor=\"#90EE90\">Issuing Date:<td bgcolor=\"#90EE90\"><INPUT NAME=\"action_date\" TYPE=\"TEXT\" VALUE=\"$action_date\" $HIGHLIGHT size=\"12\" readonly>";
echo "<td bgcolor=\"#90EE90\">Add Credit Limit:<td bgcolor=\"#90EE90\"><INPUT TYPE=\"button\" VALUE=\"Add Land\" DISABLED>";
echo "<tr><td bgcolor=\"#90EE90\">Due Interest Rate:<td bgcolor=\"#90EE90\">Rs.&nbsp;<INPUT NAME=\"d_int_r\" TYPE=\"TEXT\" VALUE=\"$due_int\" $HIGHLIGHT size=6 READONLY>&nbsp;%";
echo "<td bgcolor=\"#90EE90\">Over Due Interest Rate:<td bgcolor=\"#90EE90\">Rs.&nbsp;<INPUT NAME=\"od_int_r\" TYPE=\"TEXT\" VALUE=\"$overdue_int\" $HIGHLIGHT size=\"6\" readonly>&nbsp;%";
echo "<tr><td bgcolor=\"#90EE90\">Credit Limit:<td bgcolor=\"#90EE90\">Rs.&nbsp;<INPUT NAME=\"credit_limit\" TYPE=\"TEXT\" VALUE=\"$max_limit\" $HIGHLIGHT size=10 READONLY>";
echo "<td bgcolor=\"#90EE90\">Already Issued Amount:<td bgcolor=\"#90EE90\">Rs.&nbsp;<INPUT NAME=\"issued_amount\" TYPE=\"TEXT\" VALUE=\"$issued_amount\" id=\"issued_amount\" $HIGHLIGHT size=\"10\" readonly>";
$insurance=crop_insurance($loan_sl_no,$crop_id,$action_date,$amount);
echo "<tr><td bgcolor=\"#90EE90\">Crop Insurance:<td bgcolor=\"#90EE90\">Rs.&nbsp<INPUT NAME=\"c_insurance\" id=\"c_insurance\" TYPE=\"TEXT\" VALUE=\"".$insurance."\" size=\"8\" $HIGHLIGHT >";
if($FURMAR_SELF_INSURANCE && $issued_amount==0){
echo "<td bgcolor=\"#90EE90\">Farmar self Insurance:<td bgcolor=\"#90EE90\">Rs.&nbsp<INPUT NAME=\"s_insurance\" id=\"amount\" TYPE=\"TEXT\" VALUE=\"0\" size=\"7\" READONLY $HIGHLIGHT >";
}
else{
echo "<td colspan=\"2\" bgcolor=\"#90EE90\">";
}
echo "<tr><td bgcolor=\"#90EE90\">Remaining Limit:<td bgcolor=\"#90EE90\">Rs.&nbsp<INPUT NAME=\"bal_limit\" id=\"bal_limit\" TYPE=\"TEXT\" VALUE=\"".($balance_limit-$amount)."\" size=\"10\" $HIGHLIGHT READONLY>";
echo "<td bgcolor=\"#90EE90\">Issuing Amount:<td bgcolor=\"#90EE90\">Rs.&nbsp<INPUT NAME=\"amount\" TYPE=\"TEXT\" VALUE=\"".($amount)."\" size=\"10\" $HIGHLIGHT READONLY>";




	$col='4';
	if(trim($_REQUEST['t_status'])=='q')
	{
		
		echo "<tr bgcolor=\"#90EE90\">";
		echo "<td>Cheque No:<td><input type=TEXT name=\"ch_no\" size=\"13\" id=\"ch_no\" value=\"$ch_no\" $HIGHLIGHT READONLY>";
		echo "<td>Transfer From:<td><input type=TEXT name=\"bank_ac_no\" size=\"13\" id=\"ch_no\" value=\"$bank_account_no\" $HIGHLIGHT READONLY>";
		echo "</tr>";
	}

	if(trim($_REQUEST['t_status'])=='y')
	{
		
		echo "<tr bgcolor=\"#90EE90\"><td>Your SB A/C No. :<td><INPUT NAME=\"account_sb\" id=\"ac\" TYPE=\"TEXT\" VALUE=\"$account_sb\" size=\"10\" $HIGHLIGHT READONLY>";
	}

echo "<INPUT NAME=\"t_status\"  TYPE=\"hidden\" VALUE=\"$t_status\">";
echo "<input type=\"hidden\" name=\"crop_id\" id=\"crop_id\" value=\"$crop_id\" >";
echo "<input type=\"hidden\" name=\"loan_sl_no\" id=\"loan_sl_no\" value=\"$loan_sl_no\" >";
if(trim($_REQUEST['t_status'])=='c')
	{
		echo "<tr><td colspan=\"$col\" align=\"right\" bgcolor=\"#90EE90\"><input type=\"SUBMIT\" VALUE=\"    Final  \">";
	}
	else
	{
		echo "<td colspan=\"$col\" align=\"right\" bgcolor=\"#90EE90\"><input type=\"SUBMIT\" VALUE=\"    Final  \">";
	}
	}
	else{
		echo "<h1><center><b>You Can't Insert any value Into database Because your loan amount is more than from your karbanama bond Value </h1>";
		echo "<h3><b>You have Taken KCC Loan is: Rs. $issued_amount /=</h3>";
		echo "<h3><b>You Demand for KCC Loan again is: Rs. $amount /=</h3>";
		echo "<h3><b>But your Karbanama bond Value is: Rs. $karbanama_value /=</h3>";
	}
    }	
}
//==================================FOR ISSUING FORM=========================================
else{
if(empty($crop_id)){
//echo "<h1>Hi:$crop_id</h1>";
$cflag=1;
}
else{
	$sql_statement="SELECT * FROM loan_ledger_hrd where account_no='$account_no' AND crop_id='$crop_id' AND fy='$fy1'";
	//echo "<h1>Hi:$sql_statement</h1>";
	$result=dBConnect($sql_statement);
	if(pg_NumRows($result)>0){
	$loan_sl_no=pg_result($result,'loan_serial_no');
	$max_limit=(float)pg_result($result,'max_limit');	
	$due_int=pg_result($result,'int_due_rate');	
	$overdue_int=pg_result($result,'int_overdue_rate');
	$already_paid=(float)pg_result($result,'already_paid');
	$already_return =(float)pg_result($result,'already_return');
	$balance_limit=$max_limit-$already_paid+$already_return;
	$fflag=1;
	$m_id=getMemberId($id);
	share_current_balance($m_id,$no_share,$val_share);
	}
}
echo "<table bgcolor=\"BLACK\" width=\"80%\" align=\"CENTER\" border=\"class\">";
echo "<tr><th bgcolor=\"#9400D3\" colspan=\"4\"><font size=+2>KCC Issuing Form of [$account_no]</font>";
if($cflag==1){
echo "<FORM NAME=\"Form1\" method=\"POST\" action=\"kcc_loan_issue.php?menu=$menu\">";
echo "<tr><td bgcolor=\"#90EE90\"> Select Crop:<td bgcolor=\"#90EE90\">";
cropSelection('crop_id');
echo "<td bgcolor=\"#90EE90\" colspan=\"2\">";
echo "</form>";
}
echo "<FORM NAME=\"parentForm\" method=\"POST\" action=\"kcc_loan_issue.php?menu=$menu&op=v\" onSubmit=\"return varify();\">";
if(!empty($crop_id)){
echo "<tr><td colspan=\"2\" align=\"right\" bgcolor=\"#90EE90\"> Crop:<td bgcolor=\"#90EE90\"><INPUT TYPE=\"TEXT\" VALUE=\"".getName('crop_id',$crop_id,'crop_desc','crop_mas')."\" $HIGHLIGHT size=\"15\" readonly>";
echo "<td bgcolor=\"#90EE90\">";
}
echo "<tr>";
echo "<td bgcolor=\"#90EE90\">Issuing Date:<td bgcolor=\"#90EE90\"><INPUT NAME=\"action_date\" TYPE=\"TEXT\" VALUE=\"".date('d/m/Y')."\" $HIGHLIGHT size=\"12\">";
if($fflag==1||$cflag==1){
echo "<td bgcolor=\"#90EE90\">Credit Limit:<td bgcolor=\"#90EE90\">Rs.&nbsp;<INPUT NAME=\"credit_limit\" TYPE=\"TEXT\" VALUE=\"$max_limit\" $HIGHLIGHT size=10 READONLY> ";
}
else{
echo "<td bgcolor=\"#90EE90\">Add Credit Limit:<td bgcolor=\"#90EE90\"><INPUT TYPE=\"button\" VALUE=\"Add Land\" onClick=\"openChild('addLand.php?menu=kcc','win2')\">";
}
if($fflag==1){
echo "<tr><td bgcolor=\"#90EE90\">Due Interest Rate:<td bgcolor=\"#90EE90\">Rs.&nbsp;<INPUT NAME=\"d_int_r\" TYPE=\"TEXT\" VALUE=\"$due_int\" $HIGHLIGHT size=6 READONLY>&nbsp;%";
echo "<td bgcolor=\"#90EE90\">Over Due Interest Rate:<td bgcolor=\"#90EE90\">Rs.&nbsp;<INPUT NAME=\"od_int_r\" TYPE=\"TEXT\" VALUE=\"$overdue_int\" $HIGHLIGHT size=\"6\" readonly>&nbsp;%";
echo "<tr>";
echo "<td bgcolor=\"#90EE90\">Already Issued Amount:<td bgcolor=\"#90EE90\">Rs.&nbsp;<INPUT NAME=\"issued_amount\" TYPE=\"TEXT\" VALUE=\"$already_paid\" id=\"issued_amount\" $HIGHLIGHT size=\"10\" readonly>";
echo "<td bgcolor=\"#90EE90\">Already Return Amount:<td bgcolor=\"#90EE90\">Rs.&nbsp;<INPUT NAME=\"return_amount\" TYPE=\"TEXT\" VALUE=\"$already_return\" id=\"return_amount\" $HIGHLIGHT size=\"10\" readonly>";
}
echo "<tr><td bgcolor=\"#90EE90\">Remaining Limit:<td bgcolor=\"#90EE90\">Rs.&nbsp<INPUT NAME=\"bal_limit\" id=\"bal_limit\" TYPE=\"TEXT\" VALUE=\"$balance_limit\" size=\"10\" $HIGHLIGHT READONLY>";
if($fflag==1){
echo "<td bgcolor=\"#90EE90\">Issuing Amount:<td bgcolor=\"#90EE90\">Rs.&nbsp<INPUT NAME=\"amount\" id=\"amount\" TYPE=\"TEXT\" VALUE=\"\" size=\"10\" $HIGHLIGHT onClick=\"amount.value=''\">";

//****************************************rajesh*************************************************

echo "<tr bgcolor=\"#90EE90\"><td colspan=\"2\" align=\"right\" >Payment Mood : </td>";
echo "<td colspan=\"2\"><SELECT name=\"t_status\"><option value=\"y\" onclick=\"Result(this.value)\">Trf to SB</option><option value=\"c\" onclick=\"Result(this.value)\">CASH</option><option value=\"q\" onclick=\"Result(this.value)\">CHEQUE</option></td>";

$sb_account_no=customerAccountNo($id,'sb');
//if(!empty($sb_account_no)){$READONLY='READONLY';}

$CHECK_Y='CHECKED';

echo "<tr ID='q' style='display:none' bgcolor=\"#90EE90\">";
echo "<td>Cheque No:</td><td><input type=TEXT name=\"ch_no\" size=\"12\" id=\"ch_no\" value=\"0\" $HIGHLIGHT></td>";
echo "<td>Transfer From:<td>";
selectBankAccount('bank_ac_no','ENABLE');
echo "</td></tr>";

echo "<tr ID='y' style='display:none' bgcolor=\"#90EE90\"><td>Transfer to SB A/C :</td>";
echo "<td><input type=\"TEXT\" id=\"sb_ac\" size=\"8\" value=\"$sb_account_no\" name=\"sb_account_no\" $READONLY $HIGHLIGHT $DISABLED>";
echo "<td colspan=\"2\"><input type=\"BUTTON\" id=\"sb_bt\" name=\"BUTTON\" value=\"Search\" $DISABLED onClick=\"findAccount();\"></tr>";

//****************************************************************************

echo "<td colspan=\"4\" align=\"right\" bgcolor=\"#90EE90\"><input type=\"SUBMIT\" VALUE=\"    Go   \" >";
}
else{
echo "<td bgcolor=\"#90EE90\">Issuing Amount:<td bgcolor=\"#90EE90\">Rs.&nbsp<INPUT NAME=\"amount\" id=\"amount\" TYPE=\"TEXT\" VALUE=\"\" size=\"10\" $HIGHLIGHT disabled>";

echo "<tr><td colspan=\"3\" bgcolor=\"#90EE90\"><td align=\"RIGHT\" bgcolor=\"#90EE90\"><input type=\"SUBMIT\" VALUE=\"    Go   \" disabled>";
}

echo "<input type=\"hidden\" name=\"crop_id\" id=\"crop_id\" value=\"$crop_id\" >";
echo "<input type=\"hidden\" name=\"sh_val\" id=\"sh_val\" value=\"$val_share\" >";
echo "<input type=\"hidden\" name=\"loan_sl_no\" id=\"loan_sl_no\" value=\"$loan_sl_no\" >";
echo "<input type=\"hidden\" name=\"min_sh_cap\" id=\"min_sh_cap\" value=\"$MINIMUM_SHARE_VALUE\" >";
echo "</FORM>";
 }
}
