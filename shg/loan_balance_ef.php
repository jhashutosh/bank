<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$group_no=$_SESSION["current_account_no"];
$fy=$_SESSION["fy"];
$amount=$_REQUEST['amount'];
$balance_p=$_REQUEST['b_prin_amount'];
$r_d_prin=$_REQUEST['r_d_prin'];
$r_od_prin=$_REQUEST['r_od_prin'];
$b_d_int=$_REQUEST['b_d_int'];
$b_od_int=$_REQUEST['b_od_int'];
//$change_adva=$_REQUEST['b_d_prin'];
$b_d_prin=$_REQUEST['b_d_prin'];
$b_od_prin=$_REQUEST['b_od_prin'];
$rec_d_prin=$_REQUEST['rec_d_prin'];	
$rec_od_prin=$_REQUEST['rec_od_prin'];
$b_d_principal=$_REQUEST['b_d_principal'];
$b_od_prin=$_REQUEST['b_od_prin'];
$curr_date=date('d/m/y');
echo "<html>";
echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
?>
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
<?php 
echo "</head>";
$c_id=getCustomerIdFromGroupId($group_no);
$flag1=getGeneralInfo_Customer($c_id);
if($flag1==1){
echo "<hr>";
echo "<body bgcolor=\"silver\"\" onload=\"account_no.focus();\">";
//==========================here Inserting Data into Database==================================

if($_REQUEST['op']=='i'){
	$account_no=$_REQUEST['account_no'];
	$repay_period=$_REQUEST['repay_date'];
	$action_date=$_REQUEST['action_date'];
	$due_int=$_REQUEST['d_int_r'];
	$overdue_int=$_REQUEST['od_int_r'];
	$issued_amount=$_REQUEST['issued_amount'];
	$loan_status=$_REQUEST['loan_status'];
	$repayment_mode=$_REQUEST['repayment_mode'];
	$installment_mode=$_REQUEST['installment_mode'];
	$type=getIndex($shgl_type_array,$type);
	if($loan_status=='d'){
	$loan_status=$type;
	$gl_status='d';
	}
	else{
	$gl_status='o';
	$loan_status=$type+1;
	}
	
	$r_principal=$issued_amount-$balance_p;
	$loan_sl_no=$_REQUEST['loan_sl_no'];
	if(empty($loan_sl_no)){	$loan_sl_no=nextValue('loan_sl_no');}
	$t_id=getTranId();
	$last_repay_date=maturity_date($action_date,$repay_period ,'m');
	//customer Account Creation
	$sql_statement.="INSERT INTO customer_account(customer_id,account_type,opening_date, account_no,gl_mas_code,status,operator_code,entry_time) VALUES ('$c_id','sgl', '$action_date','$account_no','$type','op','$staff_id', CAST('$curr_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";

// Loan_Ledger_Hrdb_d_prin_abs
	$sql_statement.=";INSERT INTO loan_ledger_hrd(loan_serial_no,loan_type,customer_id,account_no,issue_date,repay_date,period,int_due_rate, int_overdue_rate,payment_term,status,gl_code,gl_status,staff_id,entry_time,loan_compt_status) VALUES ('$loan_sl_no','sgl','$c_id','$account_no','$action_date', '$last_repay_date','$repay_period',$due_int,$overdue_int,'$installment_mode','op','$loan_status','$gl_status','$staff_id',CAST('$curr_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP),'in')";
	// loan_return_dtl
$sql_statement=$sql_statement.";INSERT INTO loan_return_dtl(tran_id, loan_serial_no,account_no,action_date,r_total_amount,r_due_int,r_overdue_int,r_principal, b_due_int,b_overdue_int,b_principal,b_due_principal,b_overdue_principal,r_overdue_principal,r_due_principal,staff_id,entry_time)VALUES('$t_id','$loan_sl_no','$account_no','$curr_date',$r_principal,0,0,$r_principal,$b_d_int,$b_od_int,$balance_p,$b_d_prin,$b_od_prin,$rec_od_prin,$rec_d_prin,'$staff_id',CAST('$curr_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
// loan_issue_dtl
$sql_statement=$sql_statement.";INSERT INTO loan_issue_dtl(tran_id, loan_serial_no,account_no, action_date,loan_amount,b_principal,staff_id,entry_time)VALUES('$t_id','$loan_sl_no','$account_no','$action_date',$issued_amount,$issued_amount,'$staff_id',(CAST('$curr_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP)-INTERVAL '1 days'))";
//general ledger posting
$sql_statement=$sql_statement.";INSERT INTO gl_ledger_hrd(tran_id,type, action_date,fy,operator_code, entry_time) VALUES ('$t_id','sgl','$curr_date','$fy', '$staff_id', CAST('$curr_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
if($b_d_principal>0)
$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','$account_no','$loan_status',$b_d_principal,'Dr','opening SGL')";
if($b_od_prin>0)
{
	if($gl_status=='d')
	{
		$loan_status=$loan_status+1;
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','$account_no','$loan_status',$b_od_prin,'Dr','opening SGL')";
	}
	if($gl_status=='o')
	{
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','$account_no','$loan_status',$b_od_prin,'Dr','opening SGL')";
	}
}
	//echo $sql_statement;
   	$result=dBConnect($sql_statement);
	if(pg_affected_rows($result)<1){
		echo "<h5><font color=\"RED\">Failed to insert data into databab_d_prin_absse.</font></h5>";
	} 
	else{
		echo "<font size=+4><b>Transaction Id:$t_id";
		//echo "<br>Your Loan Amount:Rs. $issue_amount<br></h4>";
		echo "<br><font size=+2><a href=\"../main/set_account.php?menu=shg&account_no=$group_no\">Click</a> here to go Statement"; 
	}
	
 }
//==================================FOR FIRST ISSUING FORM===========================================================

if(empty($_REQUEST['op'])){
echo "<table bgcolor=\"BLACK\" width=\"80%\" align=\"CENTER\">";
echo "<tr><th bgcolor=\"#006400\" colspan=\"4\"><font size=+2>SHG Loan Balance Entry Form</font>";
echo "<FORM NAME=\"f1\" method=\"POST\" action=\"loan_balance_ef.php?menu=sgl&op=v&account_no=$account_no&type=$type&repay_period=$repay_period&d_int_r=$due_int&od_int_r=$overdue_int&issued_amount=$issued_amount\">";
echo "<TR><td bgcolor=\"#E6E6FA\">Loan Account No:<td bgcolor=\"#E6E6FA\"><INPUT NAME=\"account_no\" TYPE=\"TEXT\" VALUE=\"SGL-\" $HIGHLIGHT size=\"12\" id=\"account_no\" >";
echo "<td bgcolor=\"#E6E6FA\">Issuing Date:<td bgcolor=\"#E6E6FA\"><INPUT NAME=\"action_date\" TYPE=\"TEXT\" VALUE=\"\" $HIGHLIGHT size=\"12\" id=\"action_date\" >";
echo "<tr><td align=\"left\" bgcolor=\"#E6E6FA\">Loan Type:<td bgcolor=\"#E6E6FA\">";
makeSelect($shgl_type_array,'type','');
echo "<td bgcolor=\"#E6E6FA\">Repay Period:<td bgcolor=\"#E6E6FA\"><INPUT NAME=\"repay_date\" TYPE=\"TEXT\" VALUE=\"\" $HIGHLIGHT size=\"3\"> &nbsp; Months";
echo "<tr><td bgcolor=\"#E6E6FA\">Due Interest Rate:<td bgcolor=\"#E6E6FA\">Rs.&nbsp;<INPUT NAME=\"d_int_r\" TYPE=\"TEXT\" VALUE=\"13\" $HIGHLIGHT maxlength=\"5\" size=3>&nbsp;%";
echo "<td bgcolor=\"#E6E6FA\">Over Due Interest Rate:<td bgcolor=\"#E6E6FA\">Rs.&nbsp;<INPUT NAME=\"od_int_r\" TYPE=\"TEXT\" VALUE=\"15\" $HIGHLIGHT size=\"3\" maxlength=\"5\">&nbsp;%";
echo "<tr><td bgcolor=\"#E6E6FA\">Issue Amount:<td bgcolor=\"#E6E6FA\">Rs.&nbsp;<INPUT NAME=\"issued_amount\" TYPE=\"TEXT\" VALUE=\"\" $HIGHLIGHT size=10>";
echo "<td align=\"RIGHT\" bgcolor=\"#E6E6FA\" colspan=\"2\"><input type=\"SUBMIT\" VALUE=\"    Go   \" >";
echo "</FORM>";
    }
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

$row=pg_fetch_array($result,0);
$installment_mode=$row['installment_mode'];
$comp_method=$row['repayment_mode'];

$sql_statement="SELECT getLoanDtl_existing('$action_date', $issued_amount,'$installment_mode', $repay_period,'$curr_date','$account_no')";
$result=dBConnect($sql_statement);

$sql_statement="select * FROM loan_cal_int where account_no='$account_no'";
$result=dBConnect($sql_statement);
$row=pg_fetch_array($result,0);
$due_principal=$row['due_principal'];
$overdue_principal=$row['overdue_principal'];


//=========================================SQL PART=========================================================================================

echo "<FORM NAME=\"parentForm\" method=\"POST\" action=\"loan_balance_ef.php?menu=$menu&op=i&account_no=$account_no&type=$type&repay_date=$repay_period&action_date=$action_date&d_int_r=$due_int&od_int_r=$overdue_int&issued_amount=$issued_amount&loan_status=$loan_status&repayment_mode=$comp_method&installment_mode=$installment_mode\">";
echo "<table bgcolor=\"black\" width=\"80%\" align=\"CENTER\">";
echo "<tr><th bgcolor=\"#FFD700\" colspan=\"5\"><font size=+2>SHG Loan Balance Entry Form[$account_no]</font></tr>";
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
?>
