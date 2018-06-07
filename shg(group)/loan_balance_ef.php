<?
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$account_no=$_REQUEST['account_no'];
$group_no=$_SESSION["current_account_no"];
$fy=$_SESSION["fy"];
$type=$_REQUEST['type'];
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
//$curr_date='31.03.2013';
$x=explode('-',$_SESSION['fy']);
$curr_date="31/03/".$x[0];
$r_d_int=$_REQUEST['r_d_int'];
$r_od_int=$_REQUEST['r_od_int'];
/*$member_info=$_REQUEST['member_info'];
$m_loan_amount=$_REQUEST['m_loan_amount'];
$m_r_d_i=$_REQUEST['m_r_d_i'];
$m_r_od_i=$_REQUEST['m_r_od_i'];
$m_b_p=$_REQUEST['m_b_p'];
$m_b_d_i=$_REQUEST['m_b_d_i'];
$m_b_od_i=$_REQUEST['m_b_od_i'];
*/

echo "<html>";
echo "<head>";
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";
echo "<script src=\"../JS/validation.js\"></script>";
echo "<title></title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
$c_id=getCustomerIdFromGroupId($group_no);
$flag1=getGeneralInfo_Customer($c_id);
if($flag1==1){
echo "<hr>";
echo "<body bgcolor=\"silver\"\" onload=\"account_no.focus();\">";
//==========================here Inserting Data into Database==================================
if($_REQUEST['op']=='i'){
	$type=getIndex($shgl_type_array,$type);
       if($gl_code_loan=='d'){
	$gl_code_loan=$type;
	$gl_status='d';
	}
	else{
	$gl_status='o';
	$gl_code_loan=$type+1;
	}
	$r_principal=$issued_amount-$balance_p;
	$loan_sl_no=$_REQUEST['loan_sl_no'];
	if(empty($loan_sl_no)){	$loan_sl_no=nextValue('loan_sl_no');}
	$t_id=getTranId();
	//$repay_date=maturity_date($action_date,$repay_date,'m');
	//customer Account Creation
	$sql_statement.="INSERT INTO customer_account(customer_id,account_type,opening_date, account_no,gl_mas_code,remarks, status,operator_code,entry_time) VALUES ('$c_id','sgl', '$action_date','$account_no','$type','$remarks','op','$staff_id', CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";

// Loan_Ledger_Hrd
	$sql_statement.=";INSERT INTO loan_ledger_hrd(loan_serial_no,loan_type,customer_id,account_no,issue_date,repay_date,int_due_rate, int_overdue_rate,status,gl_code,gl_status) VALUES ('$loan_sl_no','sgl','$c_id','$account_no','$action_date', '$repay_date',$due_int,$overdue_int,'op','$gl_code_loan','$gl_status')";
// loan_return_dtl
$sql_statement=$sql_statement.";INSERT INTO loan_return_dtl(tran_id, loan_serial_no,account_no,action_date,r_total_amount,r_due_int,r_overdue_int,r_principal, b_due_int,b_overdue_int,b_principal,staff_id,entry_time)VALUES('$t_id','$loan_sl_no','$account_no','$curr_date',($r_d_int+$r_od_int+$r_principal),$r_d_int,$r_od_int,$r_principal,$b_d_int,$b_od_int,$balance_p,'$staff_id',CAST('$curr_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
// loan_issue_dtl
$sql_statement=$sql_statement.";INSERT INTO loan_issue_dtl(tran_id, loan_serial_no,account_no, action_date,loan_amount,b_principal,staff_id,entry_time)VALUES('$t_id','$loan_sl_no','$account_no','$action_date',$issued_amount,$issued_amount,'$staff_id',(CAST('$curr_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP)-INTERVAL '1 days'))";
//general ledger posting
$sql_statement=$sql_statement.";INSERT INTO gl_ledger_hrd(tran_id,type, action_date,fy,remarks, operator_code, entry_time) VALUES ('$t_id','sgl','$curr_date','$fy','$remarks', '$staff_id', CAST('$curr_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','$account_no','$gl_code_loan',$balance_p,'Dr','opening SGL')";

	//echo $sql_statement;

   	$result=dBConnect($sql_statement);
	if(pg_affected_rows($result)<1){
		echo "<h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
	} else{
		echo "<font size=+4><b>Transaction Id:$t_id";
		//echo "<br>Your Loan Amount:Rs. $issue_amount<br></h4>";
		echo "<br><font size=+2><a href=\"../main/set_account.php?menu=$menu&account_no=$group_no\">Click</a> here to go Statement"; 
				     	
           	   }
	
 }
//==================================FOR ISSUING FORM=========================================
if(empty($_REQUEST['op'])){
echo "<table bgcolor=\"BLACK\" width=\"80%\" align=\"CENTER\">";
echo "<tr><th bgcolor=\"#006400\" colspan=\"4\"><font size=+2>SHG Loan Balance Entry Form</font>";
echo "<FORM NAME=\"f1\" method=\"POST\" action=\"loan_balance_ef.php?menu=$menu&op=i\">";
echo "<TR><td bgcolor=\"#E6E6FA\">Loan Account No:<td bgcolor=\"#E6E6FA\"><INPUT NAME=\"account_no\" TYPE=\"TEXT\" VALUE=\"SGL-\" $HIGHLIGHT size=\"12\" id=\"account_no\" >";
echo "<td bgcolor=\"#E6E6FA\">Issuing Date:<td bgcolor=\"#E6E6FA\"><INPUT NAME=\"action_date\" TYPE=\"TEXT\" VALUE=\"\" $HIGHLIGHT size=\"12\" id=\"action_date\" >";
echo "<tr><td align=\"left\" bgcolor=\"#E6E6FA\">Loan Type:<td bgcolor=\"#E6E6FA\">";
makeSelect($shgl_type_array,'type','');
echo "<td bgcolor=\"#E6E6FA\">Status of Loan<td bgcolor=\"#E6E6FA\">";
echo "<SELECT name=\"gl_code_loan\">";
echo "<option value=\"d\">Due";
echo "<option value=\"o\">Overdue";
echo "</select>";
echo "<tr><td bgcolor=\"#E6E6FA\">Due Interest Rate:<td bgcolor=\"#E6E6FA\">Rs.&nbsp;<INPUT NAME=\"d_int_r\" TYPE=\"TEXT\" VALUE=\"10\" $HIGHLIGHT maxlength=\"2\" size=3>&nbsp;%";
echo "<td bgcolor=\"#E6E6FA\">Over Due Interest Rate:<td bgcolor=\"#E6E6FA\">Rs.&nbsp;<INPUT NAME=\"od_int_r\" TYPE=\"TEXT\" VALUE=\"10\" $HIGHLIGHT size=\"3\" maxlength=\"2\">&nbsp;%";
echo "<tr><td bgcolor=\"#E6E6FA\">Issue Amount:<td bgcolor=\"#E6E6FA\">Rs.&nbsp;<INPUT NAME=\"issued_amount\" TYPE=\"TEXT\" VALUE=\"\" $HIGHLIGHT size=10>";
echo "<td bgcolor=\"#E6E6FA\">Balance Principal Amount:<td bgcolor=\"#E6E6FA\">Rs.&nbsp;<INPUT NAME=\"bal_p\" TYPE=\"TEXT\" VALUE=\"\" id=\"issued_amount\" $HIGHLIGHT size=\"10\">";
echo "<tr><td bgcolor=\"#E6E6FA\">Upto Due Interest Received:<td bgcolor=\"#E6E6FA\">Rs.&nbsp<INPUT NAME=\"r_d_int\" TYPE=\"TEXT\" VALUE=\"0\" size=\"10\" $HIGHLIGHT >";
echo "<td bgcolor=\"#E6E6FA\">Upto OverDue Interest Received:<td bgcolor=\"#E6E6FA\">Rs.&nbsp<INPUT NAME=\"r_od_int\" TYPE=\"TEXT\" VALUE=\"0\" size=\"10\" $HIGHLIGHT >";;
echo "<tr><td bgcolor=\"#E6E6FA\">Balance Due Interest:<td bgcolor=\"#E6E6FA\">Rs.&nbsp<INPUT NAME=\"bal_d_int\" TYPE=\"TEXT\" VALUE=\"0\" size=\"10\" $HIGHLIGHT >";
echo "<td bgcolor=\"#E6E6FA\">Balance OverDue Interest:<td bgcolor=\"#E6E6FA\">Rs.&nbsp<INPUT NAME=\"bal_od_int\" TYPE=\"TEXT\" VALUE=\"0\" size=\"10\" $HIGHLIGHT >";
echo "<tr><td bgcolor=\"#E6E6FA\">Repay Date:<td bgcolor=\"#E6E6FA\"><INPUT NAME=\"repay_date\" TYPE=\"TEXT\" VALUE=\"\" $HIGHLIGHT size=\"12\"> ";
echo "<td align=\"RIGHT\" bgcolor=\"#E6E6FA\" colspan=\"2\"><input type=\"SUBMIT\" VALUE=\"    Go   \" >";
echo "</FORM>";
    }
}
if(empty($_REQUEST['op'])&&$flag1==1){
?>
<script language="JavaScript" type="text/javascript">
 var frmvalidator  = new Validator("f1");
 frmvalidator.addValidation("account_no","req","Please enter Account No");
  frmvalidator.addValidation("account_no","minlen=5","Please enter the Correct Account No Like SGL-123");
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
<?
}
?>
