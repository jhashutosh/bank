<?
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$account_no=$_SESSION["current_account_no"];
$fy=$_SESSION["fy"];
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

<script LANGUAGE="JavaScript">
function cal_ln(){
var iss_amt=document.getElementById('issue_amount').value;
var b_prin=document.getElementById('b_prin_amount').value;
var r_d_prin=document.getElementById('r_d_prin').value;
var r_od_prin=document.getElementById('r_od_prin').value;
var rec_prin=iss_amt-b_prin;
var rec_od_prin=0;
var rec_d_prin=0;
//alert ("total recovery principal"+rec_prin)

if (rec_prin >= r_od_prin)
{
rec_od_prin=r_od_prin;
rec_d_prin=rec_prin-r_od_prin;
//alert (rec_d_prin)
}
else
{
//alert (r_od_prin)
rec_od_prin=rec_prin;
//alert (rec_od_prin)
rec_d_prin=0;
}

var b_od_prin=r_od_prin-rec_od_prin;
var b_d_prin=r_d_prin-rec_d_prin;
//alert(b_d_prin)
document.getElementById('rec_d_prin').value=rec_d_prin;
document.getElementById('rec_od_prin').value=rec_od_prin;
document.getElementById('b_d_prin').value=b_d_prin;
document.getElementById('b_od_prin').value=b_od_prin;
var b_d_i;
if (b_d_prin<0){
b_d_i=Math.abs(b_d_prin);
var v=document.getElementById('b_d_prin_txt');
v.type="text";
var str="Advance";
document.getElementById('b_d_prin_txt').value=str;
document.getElementById('b_d_prin_txt').focus();
document.getElementById('b_prin_amount').focus();
}
else
{
b_d_i=b_d_prin;
var v=document.getElementById('b_d_prin_txt');
v.type="hidden";
}
document.getElementById('b_d_prin_abs').value=b_d_i;
var b_d_princip=b_prin-b_od_prin;
document.getElementById('b_d_principal').value=b_d_princip;

}
</script>
<?

$due_int=$_REQUEST['d_int_r'];
$overdue_int=$_REQUEST['od_int_r'];
$action_date=$_REQUEST['action_date'];
$repay_period=$_REQUEST['repay_date'];
$amount=$_REQUEST['amount'];
$issued_amount=$_REQUEST['issued_amount'];
$balance_p=$_REQUEST['b_prin_amount'];
$b_d_prin=$_REQUEST['b_d_prin'];
$b_od_prin=$_REQUEST['b_od_prin'];
$b_d_int=$_REQUEST['b_d_int'];
$b_od_int=$_REQUEST['b_od_int'];
$loan_status=$_REQUEST['loan_status'];
$b_d_principal=$_REQUEST['b_d_principal'];
$curr_date=date('d/m/y');
if(!empty($action_date)){$ON='READONLY';}
$id=getCustomerId($account_no,$menu);
pl_document($account_no,&$loan_sl_no,&$sum_amount);
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
	
       if($loan_status=='d'){
	$gl_code_loan=getGlCode4mCustomerAccount($account_no,'');
	$gl_status='d';
	}
	else{
	$gl_status='o';
	$gl_code_loan=getGlCode4mCustomerAccount($account_no,'')+1;
	}
	$r_principal=$issued_amount-$balance_p;
	$loan_sl_no=$_REQUEST['loan_sl_no'];
	if(empty($loan_sl_no)){	$loan_sl_no=nextValue('loan_sl_no');}
	$t_id=getTranId();
	$repay_date=maturity_date($action_date,$repay_period,'m');

$sql_statement="INSERT INTO loan_ledger_hrd(loan_serial_no,loan_type,customer_id,account_no,issue_date,repay_date,period,int_due_rate, int_overdue_rate,payment_term,status,gl_code,gl_status,staff_id,entry_time,loan_compt_status) VALUES ('$loan_sl_no','$menu','$id','$account_no','$action_date', '$repay_date','$repay_period',$due_int,$overdue_int,'$installment_mode','op','$gl_code_loan','$gl_status','$staff_id',CAST('$curr_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP),'in')";

//loan_security Updation 
//	$sql_statement.=";UPDATE loan_security SET status='l' WHERE loan_serial_no='$loan_sl_no'";

$sql_statement=$sql_statement.";INSERT INTO loan_return_dtl(tran_id, loan_serial_no,account_no,action_date,r_total_amount,r_due_int,r_overdue_int,r_principal, b_due_int,b_overdue_int,b_principal,b_due_principal,b_overdue_principal,r_overdue_principal,r_due_principal,staff_id,entry_time)VALUES('$t_id','$loan_sl_no','$account_no','$curr_date',$r_principal,0,0,$r_principal,$b_d_int,$b_od_int,$balance_p,$b_d_prin,$b_od_prin,$rec_od_prin,$rec_d_prin,'$staff_id',CAST('$curr_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";

// loan_issue_dtl

$sql_statement=$sql_statement.";INSERT INTO loan_issue_dtl(tran_id, loan_serial_no,account_no, action_date,loan_amount,b_principal,staff_id,entry_time)VALUES('$t_id','$loan_sl_no','$account_no','$action_date',$issued_amount,$issued_amount,'$staff_id',(CAST('$curr_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP)-INTERVAL '1 days'))";

//general ledger posting
$sql_statement=$sql_statement.";INSERT INTO gl_ledger_hrd(tran_id,type, action_date,fy,remarks, operator_code, entry_time) VALUES ('$t_id','$menu','$curr_date','$fy','$remarks', '$staff_id', CAST('$curr_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";

if($b_d_principal>0)
$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','$account_no','$gl_code_loan',$b_d_principal,'Dr','Opening Staff')";
if($b_od_prin>0)
{
	if($loan_status<>'o')
	{
		$gl_code_loan=$gl_code_loan+1;
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','$account_no','$gl_code_loan',$b_od_prin,'Dr','Opening Staff')";
	}
	else
	$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','$account_no','$gl_code_loan',$b_od_prin,'Dr','Opening Staff')";
}

	//echo $sql_statement;
   	$result=dBConnect($sql_statement);
	if(pg_affected_rows($result)<1){
		echo "<h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
	} else{
		echo "<font size=+4><b>Transaction Id:$t_id";
		//echo "<br>Your Loan Amount:Rs. $issue_amount<br></h4>";
		echo "<br><font size=+2><a href=\"../main/set_account.php?menu=$menu&account_no=$account_no\">Click</a> here to go Statement"; 
				     	
           	   }
}
//==================================FOR FIRST ISSUING FORM==================================================================================================
else{
	if(!isOpenLoan($account_no)){

if(empty($_REQUEST['op'])){
$colour='#E6E6FA';
echo "<table bgcolor=\"black\" width=\"80%\" align=\"CENTER\" border=1>";
echo "<tr><th bgcolor=\"#006400\" colspan=\"4\"><font size=+2>Staff Loan Issue Form of [$account_no]</font>";
echo "<FORM NAME=\"f1\" method=\"POST\" action=\"sfl_loan_balance_ef.php?menu=$menu&op=v&account_no=$account_no&type=$type&repay_period=$repay_period&d_int_r=$due_int&od_int_r=$overdue_int&issued_amount=$issued_amount\">";
echo "<TR bgcolor=$colour><td>Issuing Date:<td><INPUT NAME=\"action_date\" TYPE=\"TEXT\" VALUE=\"$action_date\" $HIGHLIGHT size=\"12\" id=\"action_date\" $ON>";
echo "<td>Repay Period:<td bgcolor=\"#E6E6FA\"><INPUT NAME=\"repay_date\" TYPE=\"TEXT\" VALUE=\"\" $HIGHLIGHT size=\"3\"> &nbsp; Months";
echo "<tr bgcolor=$colour><td>Due Interest Rate:<td bgcolor=\"#E6E6FA\">Rs.&nbsp;<INPUT NAME=\"d_int_r\" TYPE=\"TEXT\" VALUE=\"10\" $HIGHLIGHT maxlength=\"5\" size=3>&nbsp;%";
echo "<td>Over Due Interest Rate:<td bgcolor=\"#E6E6FA\">Rs.&nbsp;<INPUT NAME=\"od_int_r\" TYPE=\"TEXT\" VALUE=\"10\" $HIGHLIGHT size=\"3\" maxlength=\"5\">&nbsp;%";
echo "<tr bgcolor=$colour><td>Issue Amount:<td bgcolor=\"#E6E6FA\">Rs.&nbsp;<INPUT NAME=\"issued_amount\" TYPE=\"TEXT\" VALUE=\"\" $HIGHLIGHT size=10>";
echo "<input type=\"HIDDEN\" name=\"loan_sl_no\" VALUE=\"$loan_sl_no\">";
echo "<td colspan=\"2\" align=\"RIGHT\"><input type=\"SUBMIT\" VALUE=\"    Go   \" >";
echo "</FORM>";
}
//========================================FOR SECOND ISSUING FORM ==========================================================
$colour='#8FBC8F';
if($_REQUEST['op']=='v'){
$account_no=$_REQUEST['account_no'];
$type=$_REQUEST['type'];
$repay_period=$_REQUEST['repay_date'];
$action_date=$_REQUEST['action_date'];
$due_int=$_REQUEST['d_int_r'];
$overdue_int=$_REQUEST['od_int_r'];
$issued_amount=$_REQUEST['issued_amount'];
$loan_status=$_REQUEST['loan_status'];
$sql_statement="SELECT repayment_mode,installment_mode FROM loan_repayment where loan_type='$menu'";
$result=dBConnect($sql_statement);
//echo $sql_statement;
$row=pg_fetch_array($result,0);
$installment_mode=$row['installment_mode'];
$comp_method=$row['repayment_mode'];

$sql_statement="SELECT getLoanDtl_existing('$action_date', $issued_amount,'$installment_mode', $repay_period,'$curr_date','$account_no')";
$result=dBConnect($sql_statement);
//echo $sql_statement;

$sql_statement="select * FROM loan_cal_int where account_no='$account_no'";
$result=dBConnect($sql_statement);
$row=pg_fetch_array($result,0);
$due_principal=$row['due_principal'];
$overdue_principal=$row['overdue_principal'];

//=========================================SQL PART=========================================================================

echo "<FORM NAME=\"f1\" method=\"POST\" action=\"sfl_loan_balance_ef.php?menu=$menu&op=i&account_no=$account_no&type=$type&repay_date=$repay_period&action_date=$action_date&d_int_r=$due_int&od_int_r=$overdue_int&issued_amount=$issued_amount&loan_status=$loan_status&repayment_mode=$comp_method&installment_mode=$installment_mode\">";
echo "<table bgcolor=\"black\" width=\"80%\" align=\"CENTER\">";
echo "<tr><th bgcolor=\"#FFD700\" colspan=\"5\"><font size=+2>Staff Issue Form of [$account_no]</font></tr>";
echo "<tr bgcolor=\"$colour\"><td colspan=\"2\">Due Installment Principal:<td>Rs.&nbsp<INPUT NAME=\"r_d_prin\" id=\"r_d_prin\" TYPE=\"TEXT\" VALUE=\"$due_principal\" size=\"10\" $HIGHLIGHT readonly>";
echo "<td colspan=\"1\">Issuing Amount:<td>Rs.&nbsp<INPUT NAME=\"issue_amount\" id=\"issue_amount\" TYPE=\"TEXT\" VALUE=\"$issued_amount\" size=\"10\" $HIGHLIGHT readonly></tr>";
echo "<tr bgcolor=\"$colour\"><td colspan=\"2\">OverDue Principal:<td>Rs.&nbsp<INPUT NAME=\"r_od_prin\" id=\"r_od_prin\" TYPE=\"TEXT\" VALUE=\"$overdue_principal\" size=\"10\" $HIGHLIGHT readonly>";
echo "<td bgcolor=\"$colour\">Issuing Date:<td>Rs.&nbsp<INPUT NAME=\"action_date\" TYPE=\"TEXT\" VALUE=\"$action_date\" $HIGHLIGHT size=\"10\" id=\"action_date\" readonly>";
echo "<tr bgcolor=\"$colour\"><td colspan=\"2\">Balance Principal Amount:<td>Rs.&nbsp<INPUT NAME=\"b_prin_amount\" id=\"b_prin_amount\" TYPE=\"TEXT\" VALUE=\"\" size=\"10\" onChange=\"cal_ln()\" onKeyup=\"cal_ln()\" $HIGHLIGHT >";
echo "<td>Status of Loan";
echo "<td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<SELECT name=\"loan_status\">";
echo "<option value=\"d\">Due";
echo "<option value=\"o\">Overdue";
echo "</select></td>";
echo "<tr><td colspan='5' align='center' bgcolor='#B0E0E6'><font color='black'><b>Loan Balance Entry</b></td></tr>";
//echo "<tr bgcolor=\"$colour\"><td colspan=\"2\">Recovery Installment Principal:<td>Rs.&nbsp";
echo"<INPUT NAME=\"rec_d_prin\"  id=\"rec_d_prin\" TYPE=\"hidden\" VALUE=\"\" size=\"10\" $HIGHLIGHT >";
//echo "<td colspan=\"1\">Recovery OverDue Principal:<td>Rs.&nbsp";
echo"<INPUT NAME=\"rec_od_prin\" id=\"rec_od_prin\" TYPE=\"hidden\" VALUE=\"\" size=\"10\" $HIGHLIGHT >";
echo"</tr>";
//echo "";
echo "<tr bgcolor=\"$colour\"><td colspan=\"2\">Balance Due Principal:<td>Rs.&nbsp<INPUT NAME=\"b_d_principal\" id=\"b_d_principal\" TYPE=\"TEXT\" VALUE=\"\" size=\"10\" $HIGHLIGHT >";
echo"<INPUT NAME=\"b_d_prin_abs\" id=\"b_d_prin_abs\" TYPE=\"hidden\" VALUE=\"\" size=\"10\" $HIGHLIGHT readonly>";
echo"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT NAME=\"b_d_prin_txt\"  id=\"b_d_prin_txt\" TYPE=\"hidden\" VALUE=\"\" size=\"7\" $HIGHLIGHTS >";
echo"<INPUT NAME=\"b_d_prin\"  id=\"b_d_prin\" TYPE=\"hidden\" VALUE=\"\" size=\"10\">";
echo "<td colspan=\"1\">Balance OverDue Principal:<td>Rs.&nbsp<INPUT NAME=\"b_od_prin\" id=\"b_od_prin\" TYPE=\"TEXT\" VALUE=\"\" size=\"10\" $HIGHLIGHT ></tr>";
echo "<tr bgcolor=\"$colour\"><td colspan=\"2\">Balance Due Intarest:<td>Rs.&nbsp<INPUT NAME=\"b_d_int\" TYPE=\"TEXT\" VALUE=\"0\" size=\"10\" $HIGHLIGHT >";
echo "<td>Balance OverDue Intarest:<td>Rs.&nbsp<INPUT NAME=\"b_od_int\" TYPE=\"TEXT\" VALUE=\"0\" size=\"10\" $HIGHLIGHT ></tr>";
echo "<tr bgcolor=\"$colour\"><td align=\"right\" colspan=\"5\"><input type=\"SUBMIT\" VALUE=\"   Final  \"></tr>";
}

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
 frmvalidator.addValidation("repay_date","req","Please enter Repay Period");
 frmvalidator.addValidation("d_int_r","req","Please enter Due Interest Rate");
 frmvalidator.addValidation("od_int_r","req","Please enter Due Interest Rate");
 frmvalidator.addValidation("issued_amount","req","Please enter Issuing Amount");
 frmvalidator.addValidation("b_prin_amount","req","Please enter Balance Principal");
 frmvalidator.addValidation("b_d_int","req","Please enter Due Interest Amount If There are no due int then just put 0");
 frmvalidator.addValidation("b_od_int","req","Please enter Over Due Interest Amount If There are no due int then just put 0");
 frmvalidator.addValidation("r_d_int","req","Please enter Recovery Due Interest Amount If There are no due int then just put 0");
 frmvalidator.addValidation("r_od_int","req","Please enter Recovery Over Due Interest Amount If There are no due int then just put 0");
 frmvalidator.addValidation("d_int_r","decimal","Due Interest Rate should be positive number");
 frmvalidator.addValidation("od_int_r","decimal","Overue Interest Rate should be positive number");
 frmvalidator.addValidation("issued_amount","decimal","Issue Amount should be positive number");
 frmvalidator.addValidation("bal_p","decimal","Balance Principal amount should be positive number");
 frmvalidator.addValidation("b_d_int","decimal","Balance Due Interest Amount should be positive number");
 frmvalidator.addValidation("b_od_int","decimal","Balance Over Due Interest amount should be positive number");
frmvalidator.addValidation("r_d_int","decimal","Received Due Interest Amount should be positive number");
 frmvalidator.addValidation("r_od_int","decimal","Received Over Due Interest amount should be positive number");
</script>
<?
}
?>
