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
$fy=$_SESSION["fy"];
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
$id=getCustomerId($account_no,$menu);
//echo "<h1>Loan_sl_no=$loan_sl_no";
echo "<html>";
echo "<head>";
echo "<title> KCC Main </title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
?>
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
<?php

$flag=getGeneralInfo_Customer($id);
if($flag==1){
echo "<hr>";
//echo "<script src=\"../JS/validation.js\"></script>";
echo "</head>";
echo "<body bgcolor=\"silver\"\" onload=\"amount.focus();\">";
//==========================here Inserting Data into Database==================================
if($_REQUEST['op']=='i'){
	$gl_code=getGlCode4mCustomerAccount($account_no,$action_date);
	$fy=getFy($action_date);
	if(empty($fy)){
		echo "<h1><center><b>You Can't Insert any value Into database Because Financial Year already Locked by administrator !!!!!!!!!</h1>";
			} 	
	else{


//added share
$share_certificate_no=$_REQUEST['share_certificate_no'];

//ADDED share
$sql_statement="SELECT membership_no FROM membership_info WHERE customer_id=(SELECT customer_id FROM customer_account WHERE account_no='$account_no')";
$result=dBConnect($sql_statement);
$m_id=pg_result($result,'membership_no');
$sql_statement="SELECT sum(amount) as sh_amount 
FROM gl_ledger_dtl WHERE dr_cr='Cr' and account_no=(SELECT membership_no FROM membership_info WHERE customer_id=(SELECT customer_id FROM customer_account WHERE account_no='$account_no'))";
//echo $$sql_statement;
$result=dBConnect($sql_statement);
$sh_amount=pg_result($result,'sh_amount');
$limit_sh_amount=round(($amount*5)/100);


if ($sh_amount>=$limit_sh_amount)
{
echo "NO REQUIRED TO BUY SHARE FURTHER-->";
$sh_value=0.00;
echo "You Have Share Value Rs.$sh_amount-->";
}
else
{
$sh_value=round($limit_sh_amount-$sh_amount);
echo "Excess Requirement Of share Value For This Loan Rs.$sh_value-->";
} 





	 	$t_id=getTranId();
		$sql_statement="";
		if($issued_amount==0){
			$due_date=getKccDueDate($fy,$crop_id);
	 		$sql_statement="UPDATE loan_ledger_hrd SET issue_date='$action_date', repay_date='$due_date',self_insurance=$s_insurance,status='op',staff_id='$staff_id',entry_time= CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP) WHERE loan_serial_no='$loan_sl_no' AND account_no='$account_no'";
			$sql_statement=$sql_statement.";UPDATE loan_security SET status='l' WHERE loan_serial_no='$loan_sl_no' AND account_no='$account_no'";
			$upFlag=true;
			}
		else{$s_insurance=0;}
			
		$balance=loan_current_balance($account_no,$loan_sl_no,$action_date);
		if($upFlag){$sql_statement=$sql_statement.';';}
		$sql_statement=$sql_statement."INSERT INTO loan_issue_dtl(tran_id, loan_serial_no,account_no,action_date,loan_amount,b_principal,crop_insurance,staff_id,entry_time)VALUES('$t_id','$loan_sl_no','$account_no','$action_date',$amount,($balance+$amount),$c_insurance,'$staff_id',CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_hrd(tran_id,type, action_date,fy,remarks, operator_code, entry_time) VALUES ('$t_id','kcc','$action_date','$fy','$remarks', '$staff_id', CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','$account_no','$gl_code',$amount,'Dr','kcc issue')";
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','$account_no','57997',$c_insurance,'Cr','crop Insurance')";


//added share
if($sh_value>0)
{
//$t_id=getTranId();
$gl_code1=getGlCode4mMember($m_id);
	//$sql_statement=$sql_statement.";INSERT INTO gl_ledger_hrd(tran_id,type, action_date,certificate_no,fy,remarks, operator_code, entry_time) VALUES ('$t_id','sh','$action_date','$share_certificate_no','$fy','$remarks','$staff_id',now())";
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,account_no,amount,qty,dr_cr, particulars) VALUES('$t_id','$gl_code1','$m_id',$sh_value,1,'Cr','share_issue_kcc')";
}


		if($upFlag){
			if($s_insurance>0){
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','$account_no','57998',$s_insurance,'Cr','farmar self Insurance')";
			}
		}
		if(empty($_REQUEST['account_sb'])){
//ADDED share
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','28101',($amount-$c_insurance-$s_insurance-$sh_value),'Cr','kcc issue')";
		}
		else{
		$gl_code=getGlCode4mCustomerAccount($_REQUEST['account_sb'],$action_date);
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars,account_no) VALUES('$t_id','$gl_code',($amount-$c_insurance-$s_insurance-$sh_value),'Cr','kcc issue',trim('".$_REQUEST['account_sb']."'))";
		}
		//echo $sql_statement;
		$result=dBConnect($sql_statement);
		if(pg_affected_rows($result)<1){
		echo "<br><h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
			} 
		else{

//added share
$issue_amount1=round($amount-$sh_value);

			echo "<h4><font color=\"Green\">Sucessfully inserted data into database.</font><br>Your Transaction Id:$t_id</h4>";
			echo "<pre><font size=\"+2\"><b>Your Loan Amount:                       Rs. $amount<br>";
			if($upFlag){
			echo "<br>Less:Self Insurance: Rs.&nbsp;$s_insurance";}
			echo "<br>Less:Crop Insurance: Rs.&nbsp;$c_insurance";
			echo "<br>	             _______	  	 Rs.".($c_insurance+$s_insurance);
//added share
                        echo "<br>Share Value Added :Rs. $sh_value<br></h4>";
			echo "<br>		      		  	 _________";
			echo "<br>You Paid to the farmar:			 Rs.".($amount-($c_insurance+$s_insurance+$sh_value));


			echo "</font></pre>";
			echo "<font size=+1><a href=\"../main/set_account.php?menu=kcc&account_no=$account_no\">Click</a> here to go Statement"; 
	     	
           		 }
	
  	}
     
}
//==================================FOR VERIFYING ===========================================
else if($_REQUEST['op']=='v'){
	$account_sb=findSBAccount($account_no);
	if(trim($_REQUEST['t_status'])=='y'&& (empty($account_sb))){
	echo "<font color=red size=+3 align=center><b>Dont have any Savings Account</font>";
		}
	else{
	$karbanama_value=getKarbanamaValue($loan_sl_no,$account_no);
	//if($karbanama_value>=($amount+$issued_amount)){
	if($max_limit>=($amount)){
//echo $max_limit;
//echo $amount;
echo "<table bgcolor=\"BLACK\" width=\"80%\" align=\"CENTER\">";
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


echo "<tr><td bgcolor=\"#90EE90\" colspan=\"3\">Share Certificate No:<td bgcolor=\"#90EE90\"><INPUT NAME=\"share_certificate_no\" id=\"share_certificate_no\" TYPE=\"TEXT\" VALUE=\"".$_REQUEST['share_certificate_no']."\" size=\"10\" $HIGHLIGHT READONLY>";



//added share
//echo "<td bgcolor=\"#90EE90\">Share Certificate No:<td bgcolor=\"#90EE90\"><INPUT NAME=\"share_certificate_no\" id=\"amount\" TYPE=\"TEXT\" VALUE=\"".$_REQUEST['share_certificate_no']."\" size=\"10\" $HIGHLIGHT >";

echo "<input type=\"hidden\" name=\"crop_id\" id=\"crop_id\" value=\"$crop_id\" >";
echo "<input type=\"hidden\" name=\"loan_sl_no\" id=\"loan_sl_no\" value=\"$loan_sl_no\" >";
if(trim($_REQUEST['t_status'])=='y'){
echo "<tr><td bgcolor=\"#90EE90\">Transfer to Your SB A/C : <INPUT NAME=\"t_status\"  TYPE=\"TEXT\" VALUE=\"y\" SIZE=\"1\" READONLY $HIGHLIGHT >";
//$account_sb=findSBAccount($account_no);
echo "<td bgcolor=\"#90EE90\">Your SB A/C No. :<td bgcolor=\"#90EE90\"><INPUT NAME=\"account_sb\" id=\"ac\" TYPE=\"TEXT\" VALUE=\"$account_sb\" size=\"10\" $HIGHLIGHT READONLY>";
echo "&nbsp;<INPUT TYPE=\"button\" name=\"s1\" VALUE=\"Search\" onClick=\"sbChild();\">";
}
else{
 echo "<tr><td colspan=\"3\" bgcolor=\"#90EE90\">";
}
echo "<td align=\"RIGHT\" bgcolor=\"#90EE90\"><input type=\"SUBMIT\" VALUE=\"   Final  \" >";
	}
	/*else{
		echo "<h1><center><b>You Can't Insert any value Into database Because your loan amount is more than from your karbanama bond Value </h1>";
		echo "<h3><b>You have Taken KCC Loan is: Rs. $issued_amount /=</h3>";
		echo "<h3><b>You Demand for KCC Loan again is: Rs. $amount /=</h3>";
		echo "<h3><b>But your Karbanama bond Value is: Rs. $karbanama_value /=</h3>";
	}*/




else{
		echo "<h1><center><b>You Can't Insert any value Into database Because your loan amount is more than from your Credit Limit </h1>";
		echo "<h3><b>You have Taken KCC Loan is: Rs. $amount /=</h3>";
		//echo "<h3><b>You Demand for KCC Loan again is: Rs. $amount /=</h3>";
		echo "<h3><b>But your Credit Limit is: Rs. $max_limit /=</h3>";








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
	$sql_statement="SELECT * FROM loan_ledger_hrd where account_no='$account_no' AND crop_id='$crop_id' AND fy='$fy'";
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
echo "<table bgcolor=\"BLACK\" width=\"80%\" align=\"CENTER\">";
echo "<tr><th bgcolor=\"#9400D3\" colspan=\"4\"><font size=+2>KCC Issuing Form of [$account_no]</font>";
if($cflag==1){
echo "<FORM NAME=\"Form1\" method=\"POST\" action=\"kcc_loan_issue.php?menu=$menu\">";
echo "<tr><td bgcolor=\"#90EE90\"> Select Crop:<td bgcolor=\"#90EE90\">";
cropSelection('crop_id');
echo "<td bgcolor=\"#90EE90\" colspan=\"2\">";
echo "</form>";
}
echo "<FORM NAME=\"parentForm\" method=\"POST\" action=\"kcc_loan_issue.php?menu=$menu&op=v\" onSubmit=\"return checkKccIssue(this.form);\">";
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

//added share
echo "<tr><td bgcolor=\"#90EE90\" colspan=\"4\">Share Certificate No : <INPUT NAME=\"share_certificate_no\" id=\"amount\" TYPE=\"TEXT\" VALUE=\"$share_certificate_no\" size=\"10\" $HIGHLIGHT>";

echo "<tr><td colspan=\"3\" align=\"CENTER\" bgcolor=\"#90EE90\">Transfer to Your SB A/C : <INPUT NAME=\"t_status\"  TYPE=\"radio\" VALUE=\"y\" $HIGHLIGHT >Yes &nbsp;&nbsp;<INPUT NAME=\"t_status\"  TYPE=\"radio\" VALUE=\"n\" CHECKED $HIGHLIGHT >No";
echo "<td align=\"CENTER\" bgcolor=\"#90EE90\"><input type=\"SUBMIT\" VALUE=\"    Go   \" >";
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
