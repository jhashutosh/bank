<?php
include "../config/config.php";
$staff_id=verifyAutho();
//isPermissible($menu);
if(empty($_REQUEST['account_no'])){
	$group_no=$_SESSION["current_account_no"];
	}
else{
	$group_no=$_REQUEST['account_no'];
	$_SESSION["current_account_no"]=$group_no;
 }
$menu=$_REQUEST['menu'];
$loan_limit=$_REQUEST['loan_limit'];
$type=$_REQUEST['type'];
$a_amount=$_REQUEST['a_amount'];
$loan_amount=$_REQUEST['loan_amount'];
$o_d_r=$_REQUEST['o_d_r'];
$d_r=$_REQUEST['d_r'];
//$repay_date=$_REQUEST['repay_date'];
$payment_term=$_REQUEST['payment_term'];
$purpose=$_REQUEST['purpose'];
$op=$_REQUEST['op'];
$action_date=$_REQUEST['date_of_issue'];
$period=$_REQUEST['period'];
echo "<html>";
echo "<head>";
?>
<script language="JAVASCRIPT">
function beforeVarify(){
	if(document.form1.d_r.value.length==0||!(IsPNumeric(document.form1.d_r.value))){
	alert("Due Interest Rate Should not be Blank or\nshould not other than numeric value!!!!!");
	document.form1.d_r.value="";
	document.form1.d_r.focus();
	return false;
	}
	if(document.form1.o_d_r.value.length==0||!(IsPNumeric(document.form1.o_d_r.value))){
	alert("Over Due Interest Rate Should not be Blank or\nshould not other than numeric value!!!!!");
	document.form1.o_d_r.value="";
	document.form1.o_d_r.focus();
	return false;
	}
	if(document.form1.a_amount.value.length==0||!(IsPNumeric(document.form1.a_amount.value))){
	alert("Applied Amount Should not be Blank or\nshould not other than numeric value!!!!!");
	document.form1.a_amount.value="";
	document.form1.a_amount.focus();
	return false;
	}
	if(document.form1.loan_amount.value.length==0||!(IsPNumeric(document.form1.loan_amount.value))){
	alert("Loan Amount Should not be Blank or\nshould not other than numeric value!!!!!");
	document.form1.loan_amount.value="";
	document.form1.loan_amount.focus();
	return false;
	}
	if(document.form1.repay_date.value.length==0||!(IsPNumeric(document.form1.repay_date.value))){
	alert("Loan Repay Period Should not be Blank or\nshould not other than numeric value!!!!!");
	document.form1.repay_date.value="";
	document.form1.repay_date.focus();
	return false;
	}
	var ap_amount=parseFloat(document.form1.a_amount.value);
	var l_amount=parseFloat(document.form1.loan_amount.value);
	var l_limit=parseFloat(document.form1.loan_limit.value);
       	if(ap_amount>l_limit){
		alert("Loan Limit should not be less than Applied Amount!!!!");
		document.form1.a_amount.value="";
		document.form1.a_amount.focus();
		return false;
	}
	if(l_amount>ap_amount){
	alert("Loan Amount should not be more than Applied Amount!!!!! ");
	document.form1.loan_amount.value="";
	document.form1.loan_amount.focus();
	return false;
	}
	
}
</script>
<?php
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"a_amount.focus();\">";
$c_id=getCustomerIdFromGroupId($group_no);
$flag1=getGeneralInfo_Customer($c_id);
if($flag1==1){
	echo "<hr>";
/***********************************FIRST FORM *********************************************/
	if(empty($op)){
		$flag=checkloanEl($group_no,$loan_el_date);
		if($flag){
			echo "<form method=\"POST\" name=\"form1\" action=\"loan_ledger_ef.php?menu=$menu&op=v\" onSubmit=\"return beforeVarify();\">";
			echo "<table bgcolor=AQUA align=center width=80%>";
			echo "<tr><TH colspan=4 bgcolor=BLUE><font color=WHITE size=+2><b>SHG Loan Issue Form";
			
			echo "<tr><td align=\"left\">Group No:<td><input type=\"TEXT\" name=\"group_no\" size=\"8\" value=\"$group_no\" readonly $HIGHLIGHT>";
			echo "<td align=\"left\">Loan Type:<td>";
			makeSelect($shgl_type_array,'type','');//($shgl_type_array,'type');
			echo "<tr><td align=\"left\">Loan Limit:<td>Rs.&nbsp;<input type=\"TEXT\" name=\"loan_limit\" size=\"8\" value=\"".shg_loan_limit($group_no)."\"  $HIGHLIGHT>";
			echo "<td align=\"left\">Loan Issued Date:<td><input type=\"TEXT\" name=\"date_of_issue\" size=\"12\" value=\"".date('d/m/Y')."\"  $HIGHLIGHT><td>";
			echo "<tr><td align=\"left\">Interest Rate:<td>Rs.&nbsp;<input type=\"TEXT\" name=\"d_r\" size=\"5\" value=\"13\" $HIGHLIGHT>&nbsp;%";
			echo "<td align=\"left\">Over DueInterest Rate:<td>Rs.&nbsp;<input type=\"TEXT\" name=\"o_d_r\" size=\"5\" value=\"15\" $HIGHLIGHT>&nbsp;%";
			echo "<tr><td align=\"left\">Applied Amount:<td>Rs.&nbsp;<input type=\"TEXT\" name=\"a_amount\" size=\"8\" value=\"$a_amount\" id=\"a_amount\" $HIGHLIGHT>";
			echo "<td align=\"left\">Issued Amount:<td>Rs.&nbsp;<input type=\"TEXT\" name=\"loan_amount\" size=\"8\" value=\"$loan_amount\" $HIGHLIGHT>";
			echo "<tr><td align=\"left\">Loan Repayment Period :<td><input type=\"TEXT\" name=\"period\" size=\"3\"  $HIGHLIGHT>&nbsp;<font color=RED size=-1>Month</font>";
			echo "<td align=\"left\">Purpose :<td><input type=\"TEXT\" name=\"purpose\" size=\"15\" value=\"Animal Husbandry\" $HIGHLIGHT>";
			echo "<tr><td colspan=\"4\" align=\"right\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Enter\">";
			echo "  <input type=\"RESET\" name=\"RESET_BUTTON\" value=\"Reset\"><br>";		
			echo "</table>";
			echo "</form>";
 			}

//******************************* for not eligible for loan **********************************
	else{
	      echo "<h1><b><font color=Red><center><blink>You Are Not Eligible for loan</blink></b><center></font></h1>";
              echo "<h2><center><b>You Will come after :$loan_el_date</h2></center></b>";
	      echo "<a href=\"../main/nextaccount.php?menu=shg\">BACK</a>";
	   }
    }
//********************** verifying the the entry **********************************************
if ($op=='v'){
echo "<form name=\"orderform\" method=\"POST\" action=\"loan_ledger_ef.php?menu=$menu&op=i\" onSubmit=\"return varify();\">";
echo "<table bgcolor=PINK align=center width=95%>";
echo "<tr><TH colspan=6 bgcolor=BLUE><font color=WHITE><b>SHG Loan Issue Summary Form";
echo "<tr><td align=\"left\">Group No:<td><input type=\"TEXT\" name=\"group_no\" size=\"8\" value=\"$group_no\" readonly $HIGHLIGHT>";
echo "<td align=\"left\">Loan Type:<td><input type=\"TEXT\" name=\"type\" size=\"25\" value=\"".$type."\" readonly $HIGHLIGHT>";
echo "<td align=\"left\">Loan Issued Date:<td><input type=\"TEXT\" name=\"date_of_issue\" size=\"12\" value=\"$action_date\" readonly $HIGHLIGHT>";
echo "<tr><td align=\"left\">Interest Rate:<td>Rs.&nbsp;<input type=\"TEXT\" name=\"d_r\" size=\"5\" value=\"$d_r\" $HIGHLIGHT readonly>&nbsp;%";
echo "<td align=\"left\">Over DueInterest Rate:<td>Rs.&nbsp;<input type=\"TEXT\" name=\"o_d_r\" size=\"5\" value=\"$o_d_r\" $HIGHLIGHT readonly>&nbsp;%";
echo "<td align=\"left\">Purpose :<td><input type=\"TEXT\" name=\"purpose\" size=\"15\" value=\"$purpose\" $HIGHLIGHT readonly>";
echo "<input type=\"HIDDEN\" name=\"loan_limit\" size=\"8\" value=\"".$loan_limit."\" readonly $HIGHLIGHT>";
echo "<tr><td align=\"left\">Applied Amount:<td>Rs.&nbsp;<input type=\"TEXT\" name=\"a_amount\" size=\"8\" value=\"$a_amount\" id=\"applied_amount\" readonly $HIGHLIGHT>";
echo "<td align=\"left\">Issued Amount:<td>Rs.&nbsp;<input type=\"TEXT\" name=\"loan_amount\" size=\"8\" value=\"$loan_amount\" readonly $HIGHLIGHT>";
echo "<td align=\"left\">Loan Repayment Period :<td><input type=\"TEXT\" name=\"period\" size=\"12\" value=\"$period\" $HIGHLIGHT>&nbsp;Months";
//echo "<tr><td>Payment Term :";
//ech5o "<tr><td>Payment Term :<td><INPUT NAME=\"payment_term\" TYPE=\"TEXT\" VALUE=\"".$_REQUEST['payment_term']."\" size=\"4\" $HIGHLIGHT>";
echo "<tr><td colspan=\"6\" align=\"right\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Enter\">";
echo "</table>";
}
/************************************INSERTING INTO DATABASE *******************************/
if($op=='i'){
	$type=getIndex($shgl_type_array,$type);
$sql="select repayment_mode,installment_mode from loan_repayment where loan_type like 'sgl'";
echo $sql_statement;
$res=dBConnect($sql);
$row=pg_fetch_array($res,0);
$repayment_mode=$row['repayment_mode'];
$payment_term=$row['installment_mode'];
	$repay_date=maturity_date($action_date,$period,'m');
	$fy=getFy($action_date);
	if(empty($fy)){
		echo "<h1><center><b>You Can't Insert any value Into database Because Financial Year already Locked by administrator !!!!!!!!!";
}
	else{
		$t_id=getTranId();
		$loan_sl_no=nextValue('loan_sl_no');
		getAccountNo($c_id,'sgl',$account_no,$gl_code);
		if(empty($account_no) && empty($gl_code)){
			$account_no=getId('sgl');
			// Customer Account For loan account Opening
			$sql_statement="INSERT INTO customer_account(customer_id,account_type,opening_date, account_no,gl_mas_code,remarks, status,operator_code,entry_time) VALUES ('$c_id','sgl', '$action_date','$account_no','$type','$remarks','op','$staff_id', now())";
			}
			else{
				$type=$gl_code;
			}
//loan_ledger_hrd
		$sql_statement=$sql_statement.";INSERT INTO loan_ledger_hrd(loan_serial_no,loan_type,customer_id, account_no,fy,issue_date,int_due_rate,int_overdue_rate, applied_amount,repay_date,period,payment_term, max_limit,staff_id,status,entry_time,gl_code,gl_status,loan_compt_status)VALUES('$loan_sl_no','sgl','$c_id','$account_no','$fy','$action_date',$d_r,$o_d_r,$a_amount,'$repay_date','$period','$payment_term',$loan_limit,'$staff_id','op',CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP),'$type','d','$repayment_mode')";

//loan_issue_dtl
		$sql_statement.=";INSERT INTO loan_issue_dtl(tran_id,loan_serial_no,account_no,action_date,loan_amount,b_principal,staff_id,entry_time)VALUES('$t_id','$loan_sl_no','$account_no','$action_date',$loan_amount,$loan_amount,'$staff_id',CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";

//gl_ledger_hrd
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_hrd(tran_id,type,action_date,fy, remarks,operator_code,entry_time) VALUES ('$t_id','sgl','$action_date','$fy','$remarks', '$staff_id',CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";

//gl_ledger_dtl
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code, amount,dr_cr, particulars) VALUES('$t_id','$account_no','$type',$loan_amount,'Dr','loan issue')";
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','28101',$loan_amount,'Cr','loan issue')";

echo $sql_statement;
		$result=dBConnect($sql_statement);
		if(pg_affected_rows($result)<1) {
			echo "<br><font size=+3 color=\"RED\">Failed to insert data into database.</font></h5>";
			} 
		else {
			echo "<font size=-1 color=\"GREEN\"><B>Successfully inserted data into database.</font>";
			echo "<br><font size=+1>Transaction No.:<b>$t_id";
			echo "<br><font size=+1>Loan Account No.:<b>".$account_no;
			echo "<br><font size=+1>Loan Repayement Date:<b>$period";
			echo "<br><font size=+1>Loan Amount:Rs. ".amount2Rs($loan_amount)."/=";
			echo "<br><a href=\"shg_mem_detail.php\">Click</a> Here go to the statement";
			}
		}
	}

}
echo "</body>";
echo "</html>";
?>
