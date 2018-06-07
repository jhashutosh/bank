<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$account_no=$_SESSION["current_account_no"];
$gl_code_loan=$_REQUEST['gl_code_loan'];
$loan_sl_no=$_REQUEST['loan_sl_no'];
$due_int=$_REQUEST['d_int_r'];
$overdue_int=$_REQUEST['od_int_r'];
$crop_id=$_REQUEST['crop_id'];
$action_date=$_REQUEST['action_date'];
$repay_date=$_REQUEST['repay_date'];
$amount=$_REQUEST['amount'];
$issued_amount=$_REQUEST['issued_amount'];
$balance_p=$_REQUEST['bal_p'];
$b_d_int=$_REQUEST['bal_d_int'];
$b_od_int=$_REQUEST['bal_od_int'];
//$curr_date='31.03.2013';
$x=explode('-',$_SESSION['fy']);
$curr_date="31/03/".$x[0];
$fy1=($x[0]-1);
$fy1.='-'.$x[0];
$r_d_int=$_REQUEST['r_d_int'];
$r_od_int=$_REQUEST['r_od_int'];
$id=getCustomerId($account_no,$menu);

echo "<html>";
echo "<head>";
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";
echo "<title> KCC Main </title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
$flag=getGeneralInfo_Customer($id);
if($flag==1){
echo "<hr>";
echo "<script src=\"../JS/validation.js\"></script>";
echo "</head>";
echo "<body bgcolor=\"silver\"\" onload=\"action_date.focus();\">";
//==========================here Inserting Data into Database==================================
if($_REQUEST['op']=='i'){
        echo "<form name=\"f1\">";
	//echo "<h1>$gl_code_loan</h1>";
	if($gl_code_loan=='d'){
	$gl_code_loan=getGlCode4mCustomerAccount($account_no,"");
	$gl_status='d';
	}
	else{
	$gl_status='o';
	$gl_code_loan=getGlCode4mCustomerAccount($account_no,"")+1;
	}
	$r_principal=$issued_amount-$balance_p;
	$loan_sl_no=nextValue('loan_sl_no');
	$t_id=getTranId();
	$sql_statement="INSERT INTO loan_ledger_hrd(loan_serial_no,loan_type,customer_id,fy,account_no,issue_date,repay_date,crop_id,max_limit, int_due_rate, int_overdue_rate,status,gl_code,gl_status) VALUES ('$loan_sl_no','kcc','$id','$fy1','$account_no','$action_date','$repay_date','$crop_id',$issued_amount,$due_int,$overdue_int,'op','$gl_code_loan','$gl_status')";
	$sql_statement=$sql_statement.";INSERT INTO loan_issue_dtl(tran_id, loan_serial_no,account_no, action_date,loan_amount,b_principal,staff_id,entry_time)VALUES('$t_id','$loan_sl_no','$account_no','$action_date',$issued_amount,$issued_amount,'$staff_id',CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
	$sql_statement=$sql_statement.";INSERT INTO loan_return_dtl(tran_id, loan_serial_no,account_no,action_date,r_total_amount,r_due_int,r_overdue_int,r_principal, b_due_int,b_overdue_int,b_principal,staff_id,entry_time)VALUES('$t_id','$loan_sl_no', '$account_no','$curr_date',($r_d_int+$r_od_int+$r_principal),$r_d_int,$r_od_int,$r_principal,$b_d_int,$b_od_int,$balance_p,'$staff_id',CAST('$curr_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
       $sql_statement=$sql_statement.";INSERT INTO gl_ledger_hrd(tran_id,type, action_date,fy,remarks, operator_code, entry_time) VALUES ('$t_id','kcc','$curr_date','$fy1','$remarks', '$staff_id', CAST('$curr_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
		//$gl_code=getGlCode4mCustomerAccount($account_no,$curr_date);
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','$account_no','$gl_code_loan',$balance_p,'Dr','opening kcc')";
	//echo $sql_statement;
   	$result=dBConnect($sql_statement);
	if(pg_affected_rows($result)<1){
		echo "<br><h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
	} else{
		echo "<h4><font color=\"Green\">Sucessfully inserted data into database.</font><br>Your Transaction Id:$t_id</h4>";
		//header('Location:../main/set_account.php?menu=kcc&account_no=$account_no');
				     	
           	   }
	
 }
//==================================FOR ISSUING FORM=========================================
else{
echo "<table bgcolor=\"BLACK\" width=\"80%\" align=\"CENTER\">";
echo "<tr><th bgcolor=\"#9400D3\" colspan=\"4\"><font size=+2>KCC Issuing Form of [$account_no]</font>";
echo "<FORM NAME=\"f1\" method=\"POST\" action=\"kcc_loan_balance_ef.php?menu=$menu&op=i\">";
echo "<tr><td bgcolor=\"#90EE90\"> Select Crop:<td bgcolor=\"#90EE90\">";
makeSelectFromDBWithCode('crop_id','crop_desc','crop_mas','crop_id');
echo "<td bgcolor=\"#90EE90\">Status of Loan<td bgcolor=\"#90EE90\">";
echo "<SELECT name=\"gl_code_loan\">";
echo "<option value=\"d\">Due";
echo "<option value=\"o\">Overdue";
echo "</select>";
echo "<TR><td bgcolor=\"#90EE90\">Issuing Date:<td bgcolor=\"#90EE90\"><INPUT NAME=\"action_date\" TYPE=\"TEXT\" VALUE=\"\" $HIGHLIGHT size=\"12\" id=\"action_date\">";
echo "<td bgcolor=\"#90EE90\">Repay Date:<td bgcolor=\"#90EE90\"><INPUT NAME=\"repay_date\" TYPE=\"TEXT\" VALUE=\"\" $HIGHLIGHT size=\"12\">";
echo "<tr><td bgcolor=\"#90EE90\">Due Interest Rate:<td bgcolor=\"#90EE90\">Rs.&nbsp;<INPUT NAME=\"d_int_r\" TYPE=\"TEXT\" VALUE=\"7\" $HIGHLIGHT maxlength=\"2\" size=3>&nbsp;%";
echo "<td bgcolor=\"#90EE90\">Over Due Interest Rate:<td bgcolor=\"#90EE90\">Rs.&nbsp;<INPUT NAME=\"od_int_r\" TYPE=\"TEXT\" VALUE=\"11\" $HIGHLIGHT size=\"3\" maxlength=\"6\">&nbsp;%";
echo "<tr><td bgcolor=\"#90EE90\">Issue Amount:<td bgcolor=\"#90EE90\">Rs.&nbsp;<INPUT NAME=\"issued_amount\" TYPE=\"TEXT\" VALUE=\"\" $HIGHLIGHT size=10>";
echo "<td bgcolor=\"#90EE90\">Balance Principal Amount:<td bgcolor=\"#90EE90\">Rs.&nbsp;<INPUT NAME=\"bal_p\" TYPE=\"TEXT\" VALUE=\"\" id=\"issued_amount\" $HIGHLIGHT size=\"10\">";
echo "<tr><td bgcolor=\"#90EE90\">Upto Due Interest Received:<td bgcolor=\"#90EE90\">Rs.&nbsp<INPUT NAME=\"r_d_int\" TYPE=\"TEXT\" VALUE=\"\" size=\"10\" $HIGHLIGHT >";
echo "<td bgcolor=\"#90EE90\">Upto OverDue Interest Received:<td bgcolor=\"#90EE90\">Rs.&nbsp<INPUT NAME=\"r_od_int\" TYPE=\"TEXT\" VALUE=\"\" size=\"10\" $HIGHLIGHT >";;
echo "<tr><td bgcolor=\"#90EE90\">Balance Due Interest:<td bgcolor=\"#90EE90\">Rs.&nbsp<INPUT NAME=\"bal_d_int\" TYPE=\"TEXT\" VALUE=\"\" size=\"10\" $HIGHLIGHT >";
echo "<td bgcolor=\"#90EE90\">Balance OverDue Interest:<td bgcolor=\"#90EE90\">Rs.&nbsp<INPUT NAME=\"bal_od_int\" TYPE=\"TEXT\" VALUE=\"\" size=\"10\" $HIGHLIGHT >";

echo "<tr><td colspan=\"2\" bgcolor=\"#90EE90\"><td bgcolor=\"#90EE90\" align=\"RIGHT\" colspan=\"2\"><input type=\"SUBMIT\" VALUE=\"    Go   \" >";
echo "</FORM>";
 }
}
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
