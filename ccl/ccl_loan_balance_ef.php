<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$account_no=$_SESSION["current_account_no"];
//$fy=$_SESSION["fy"];
?>
<SCRIPT LANGUAGE="JavaScript">
function openChild(file,window){
       	var str=document.getElementById('action_date').value;
	if(str.length>0){
	file=file+"&l_date="+str;
       	childWindow=open(file,window, 'toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=300,left=250, width=600,height=300');
    if(childWindow.opener == null) childWindow.opener = self;
	}
	else{
	alert("First enter the Issue date then add the document");
	document.f1.action_date.focus();
	}
    }
</SCRIPT>
<?php
//$fy=$_REQUEST['crop_id'];
$gl_code_loan=$_REQUEST['gl_code_loan'];
$due_int=$_REQUEST['d_int_r'];
$overdue_int=$_REQUEST['od_int_r'];
$action_date=$_REQUEST['action_date'];
$repay_date=$_REQUEST['repay_date'];
$amount=$_REQUEST['amount'];
$issued_amount=$_REQUEST['issued_amount'];
$balance_p=$_REQUEST['bal_p'];
$b_d_int=$_REQUEST['bal_d_int'];
$b_od_int=$_REQUEST['bal_od_int'];
$cr_limit_amount=$_REQUEST['cr_limit_amount'];
$x=explode('-',$_SESSION['fy']);
$curr_date="31/03/".$x[0];
$fy1=($x[0]-1);
$fy1.='-'.$x[0];
$r_d_int=$_REQUEST['r_d_int'];
$r_od_int=$_REQUEST['r_od_int'];
$id=getCustomerId($account_no,$menu);
pl_document($account_no,$loan_sl_no,$sum_amount);
echo "<html>";
echo "<head>";
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";
echo "<title></title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
$flag=getGeneralInfo_Customer($id);
if($flag==1){
echo "<hr>";
echo "<script src=\"../JS/validation.js\"></script>";
echo "</head>";
echo "<body bgcolor=\"silver\"\" onload=\"action_date.focus();\">";
//==========================here Inserting Data into Database==================================
if($_REQUEST['op']=='i'){
        if($gl_code_loan=='d'){
	$gl_code_loan=getGlCode4mCustomerAccount($account_no,$curr_date);
	$gl_status='d';
	}
	else{
	$gl_status='o';
	$gl_code_loan=getGlCode4mCustomerAccount($account_no,$curr_date)+1;
	}
	$r_principal=$issued_amount-$balance_p;
	$loan_sl_no=$_REQUEST['loan_sl_no'];
	if(empty($loan_sl_no)){	$loan_sl_no=nextValue('loan_sl_no');}
	$t_id=getTranId();
	$repay_date=maturity_date($action_date,$repay_date,'m');
	$repay_date=$_REQUEST['repay_date'];
// Loan_Ledger_Hrd
	$sql_statement="INSERT INTO loan_ledger_hrd(loan_serial_no,loan_type,customer_id,fy,account_no,issue_date,repay_date,int_due_rate, int_overdue_rate,status,gl_code,gl_status,max_limit,payment_term) VALUES ('$loan_sl_no','ccl','$id','$fy1','$account_no','$action_date', '$repay_date',$due_int,$overdue_int,'op','$gl_code_loan','$gl_status','$cr_limit_amount','c')";
//loan_security Updation 
echo $sql_statement;
	$sql_statement.=";UPDATE loan_security SET status='l' WHERE loan_serial_no='$loan_sl_no'";

// loan_return_dtl
	$sql_statement=$sql_statement.";INSERT INTO loan_return_dtl(tran_id, loan_serial_no,account_no,action_date,r_total_amount,r_due_int,r_overdue_int,r_principal, b_due_int,b_overdue_int,b_principal,staff_id,entry_time)VALUES('$t_id','$loan_sl_no','$account_no','$curr_date',($r_d_int+$r_od_int+$r_principal),$r_d_int,$r_od_int,$r_principal,$b_d_int,$b_od_int,$balance_p,'$staff_id',CAST('$curr_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";

// loan_issue_dtl
	$sql_statement=$sql_statement.";INSERT INTO loan_issue_dtl(tran_id, loan_serial_no,account_no, action_date,loan_amount,b_principal,staff_id,entry_time)VALUES('$t_id','$loan_sl_no','$account_no','$action_date',$issued_amount,$issued_amount,'$staff_id',(CAST('$curr_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP)-INTERVAL '1 days'))";
//general ledger posting
	$sql_statement=$sql_statement.";INSERT INTO gl_ledger_hrd(tran_id,type, action_date,fy,remarks, operator_code, entry_time) VALUES ('$t_id','ccl','$curr_date','$fy1','$remarks', '$staff_id', CAST('$curr_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
	$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','$account_no','$gl_code_loan',$balance_p,'Dr','opening CCL')";
	//echo $sql_statement;
   	$result=dBConnect($sql_statement);
	if(pg_affected_rows($result)<1){
		echo "<br><h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
	} else{
		echo "<font size=+4><b>Transaction Id:$t_id";
		//echo "<br>Your Loan Amount:Rs. $issue_amount<br></h4>";
		echo "<br><font size=+2><a href=\"../main/set_account.php?menu=$menu&account_no=$account_no\">Click</a> here to go Statement"; 
				     	
           	   }
	
 }
//==================================FOR ISSUING FORM=========================================
else{
	if(!isOpenLoan($account_no)){
echo "<table bgcolor=\"#E6E6FA\" width=\"80%\" align=\"CENTER\">";
echo "<tr><th bgcolor=\"#006400\" colspan=\"4\"><font size=+2>Cash Credit Loan Issuing Form of [$account_no]</font>";
echo "<FORM NAME=\"f1\" method=\"POST\" action=\"ccl_loan_balance_ef.php?menu=$menu&op=i\">";
echo "<TR><td>Issuing Date:<td><INPUT NAME=\"action_date\" TYPE=\"TEXT\" VALUE=\"$action_date\" $HIGHLIGHT size=\"12\" id=\"action_date\">";
echo "<td>Add Security Amount:<td>";
if(empty($loan_sl_no)){
echo "<INPUT TYPE=\"button\" VALUE=\"  Add  \" onClick=\"openChild('addDocument.php?menu=ccl&ls=o','win2')\">";
}
else{
echo "<INPUT TYPE=\"button\" VALUE=\"  Add  \" onClick=\"openChild('addDocument.php?menu=ccl','win2')\" DISABLED>";
}
echo "<tr><td>Status of Loan<td>";
echo "<SELECT name=\"gl_code_loan\">";
echo "<option value=\"d\">Due";
echo "<option value=\"o\">Overdue";
echo "</select>";

echo "<td>Repay Date:<td><INPUT NAME=\"repay_date\" TYPE=\"TEXT\" VALUE=\"\" $HIGHLIGHT size=\"10\">";
echo "<tr><td>Due Interest Rate:<td>Rs.&nbsp;<INPUT NAME=\"d_int_r\" TYPE=\"TEXT\" VALUE=\"12\" $HIGHLIGHT maxlength=\"5\" size=3>&nbsp;%";
echo "<td>Over Due Interest Rate:<td>Rs.&nbsp;<INPUT NAME=\"od_int_r\" TYPE=\"TEXT\" VALUE=\"14\" $HIGHLIGHT size=\"3\" maxlength=\"5\">&nbsp;%";
echo "<tr><td>Issue Amount:<td>Rs.&nbsp;<INPUT NAME=\"issued_amount\" TYPE=\"TEXT\" VALUE=\"\" $HIGHLIGHT size=10>";
echo "<td>Balance Principal Amount:<td>Rs.&nbsp;<INPUT NAME=\"bal_p\" TYPE=\"TEXT\" VALUE=\"\" id=\"issued_amount\" $HIGHLIGHT size=\"10\">";
echo "<tr><td>Upto Due Interest Received:<td>Rs.&nbsp<INPUT NAME=\"r_d_int\" TYPE=\"TEXT\" VALUE=\"0\" size=\"10\" $HIGHLIGHT >";
echo "<td>Upto OverDue Interest Received:<td>Rs.&nbsp<INPUT NAME=\"r_od_int\" TYPE=\"TEXT\" VALUE=\"0\" size=\"10\" $HIGHLIGHT >";;
echo "<tr><td>Balance Due Interest:<td>Rs.&nbsp<INPUT NAME=\"bal_d_int\" TYPE=\"TEXT\" VALUE=\"0\" size=\"10\" $HIGHLIGHT >";
echo "<td>Balance OverDue Interest:<td>Rs.&nbsp<INPUT NAME=\"bal_od_int\" TYPE=\"TEXT\" VALUE=\"0\" size=\"10\" $HIGHLIGHT >";
echo "<input type=\"HIDDEN\" name=\"loan_sl_no\" VALUE=\"$loan_sl_no\">";
echo "<tr><td>Credit Limit Amount:<td>Rs.&nbsp<INPUT NAME=\"cr_limit_amount\" id=\"pd\" TYPE=\"TEXT\" VALUE=\"$sum_amount\" size=\"10\" $HIGHLIGHT>";
echo "<td colspan=\"1\"><td align=\"RIGHT\"><input type=\"SUBMIT\" VALUE=\"  Go  \" >";
echo "</FORM>";
	}
else{
	echo "<h1><font color=RED><CENTER>$account_no Already Issued just <a href=\"../main/set_account.php?menu=$menu&account_no=$account_no\">Click</a> Here to go the Statement!!!!!!!!!!</font></h1>";
}
	
 }
}
if(empty($_REQUEST['op'])&&$flag==1){
?>
<script language="JavaScript" type="text/javascript">
 var frmvalidator  = new Validator("f1");
 frmvalidator.addValidation("action_date","req","Please enter Issuing Date");
 frmvalidator.addValidation("repay_date","req","Please enter Repay Date");
 frmvalidator.addValidation("d_int_r","req","Please enter Due Interest Rate");
 frmvalidator.addValidation("od_int_r","req","Please enter Due Interest Rate");
 frmvalidator.addValidation("issued_amount","req","Please enter Issuing Amount");
 frmvalidator.addValidation("bal_p","req","Please enter Balance Principal");
 frmvalidator.addValidation("bal_d_int","req","Please enter Due Interest Amount If There are no due int then just put 0");
 frmvalidator.addValidation("bal_od_int","req","Please enter Over Due Interest Amount If There are no due int then just put 0");
 frmvalidator.addValidation("r_d_int","req","Please enter Recovery Due Interest Amount If There are no due int then just put 0");
 frmvalidator.addValidation("r_od_int","req","Please enter Recovery Over Due Interest Amount If There are no due int then just put 0");
 frmvalidator.addValidation("d_int_r","decimal","Due Interest Rate should be positive number");
 frmvalidator.addValidation("od_int_r","decimal","Overue Interest Rate should be positive number");
 frmvalidator.addValidation("issued_amount","decimal","Issue Amount should be positive number");
 frmvalidator.addValidation("bal_p","decimal","Balance Principal amount should be positive number");
 frmvalidator.addValidation("bal_d_int","decimal","Balance Due Interest Amount should be positive number");
 frmvalidator.addValidation("bal_od_int","decimal","Balance Over Due Interest amount should be positive number");
frmvalidator.addValidation("r_d_int","decimal","Received Due Interest Amount should be positive number");
 frmvalidator.addValidation("r_od_int","decimal","Received Over Due Interest amount should be positive number");
</script>
<?php
}
?>
