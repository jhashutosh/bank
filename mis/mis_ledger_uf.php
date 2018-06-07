<?php
include "../config/config.php";
$staff_id=verifyAutho();
$account_no=$_SESSION["current_account_no"];
$menu=$_REQUEST['menu'];
$operation=$_REQUEST['operation'];
$action_dt=$_REQUEST['action_date'];
// Make WHERE CLAUSE such that only one row retrive in actual case
echo "<html>";
echo "<head>";
echo "<title>Update Form - MIS";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
?>
<SCRIPT LANGUAGE="JavaScript">
function IsPInteger(strString){
   //alert(hi)
   var strValidChars = "0123456789";
   var strChar;
   var blnResult = true;
   if (strString.length == 0) return false;
   //  test strString consists of valid characters listed above
   for (i = 0; i < strString.length && blnResult == true; i++){
      strChar = strString.charAt(i);
      if (strValidChars.indexOf(strChar) == -1){
         blnResult = false;
         }
      }
   return blnResult;
   }


function checkValidation(){
var op=document.getElementById("op").value;
if(op=='i'){
	var d_i=document.getElementById("d_i").value;
	var p_i=document.getElementById("p_i").value;
	if(IsPInteger(p_i)){
	p_i=parseInt(p_i);
	d_i=parseInt(d_i);
	if(p_i>d_i || p_i<1){
		alert("Pay Installment should not greater than due Installment Or should greater than 0")
		return false;
	}}
	else{
	alert("Amount Must Be Positive Numeric Value")
	return false;
	}
}

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
<?
echo "</head>";
echo "<body bgcolor=\"silver\">";
$id=getCustomerId($account_no,$menu);
$flag=getGeneralInfo_Customer($id);
if($flag==1){
echo "<hr>";
$sql_statement="select account_no,action_date,principal,period,interest_rate,maturity_amount,maturity_date,round(principal*interest_rate/1200) as monthly_int FROM deposit_info where account_no='$account_no'";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
  echo "<h4>Record Not found or already withdrawn!!!</h4>";
} else{
  $account_no=pg_result($result,'account_no');
  $opening_date=pg_result($result,'action_date');
  $principal=pg_result($result,'principal');
  $period=pg_result($result,'period');
  $monthly_installment=pg_result($result,'monthly_int');
  $rate_of_interest=pg_result($result,'interest_rate');
  $maturity_amount=pg_result($result,'maturity_amount');
  $maturity_date=pg_result($result,'maturity_date');
  }
$account_sb=findSBAccount($account_no);
if(trim($_REQUEST['t_status'])=='y'&& (empty($account_sb))){
	echo "<font color=red size=+3 align=center><b>Dont have any Savings Account</font>";
		}
else{
echo "<form method=\"POST\" action=\"mis_ledger_ufa.php?menu=$menu\" onsubmit=\"return checkValidation();\">";
echo "<table align=\"center\" bgcolor=\"skyblue\" width=\"70%\">";
echo "<tr><th colspan=\"4\" bgcolor=\"#20B2AA\"><font size=+3>MIS Withdrawal</font>";
if($operation=="i"){
echo "<tr><td align=\"left\" bgcolor=\"#90EE90\">Account no:<td bgcolor=\"#90EE90\"><input type=\"TEXT\" name=\"account_no\" size=\"10\" value=\"$account_no\" readonly $HIGHLIGHT>";
echo "<td align=\"left\" bgcolor=\"#90EE90\">Action Date:<td bgcolor=\"#90EE90\"><input type=\"TEXT\" name=\"withdrawal_date\" size=\"12\" value=\"$action_dt\" readonly $HIGHLIGHT>";
echo "<tr><td align=\"left\" bgcolor=\"#90EE90\">Monthly Installment:<td bgcolor=\"#90EE90\"><input type=\"TEXT\" name=\"monthly_int\" size=\"10\" value=\"$monthly_installment\" $HIGHLIGHT>";
$sql_statement="SELECT * FROM mis_int('$account_no','$action_dt')";
//echo $sql_statement;
$result=dBConnect($sql_statement);
$interest=pg_result($result,"mis_int");
$inst_due=$interest/$monthly_installment;
echo "<td bgcolor=\"#90EE90\">Due Interest :<td bgcolor=\"#90EE90\"><input type=\"TEXT\" name=\"due_int\" size=\"10\" value=\"$interest\"  $HIGHLIGHT><br>";
echo "<tr><td bgcolor=\"#90EE90\">Due Installment :<td bgcolor=\"#90EE90\"><input type=\"TEXT\" name=\"due_inst\" id=\"d_i\" size=\"10\" value=\"$inst_due\"  $HIGHLIGHT><br>";
echo "<td bgcolor=\"#90EE90\">No. of Month :<td bgcolor=\"#90EE90\"><input type=\"TEXT\" name=\"no_month\" size=\"5\" id=\"p_i\" value=\"$inst_due\" $HIGHLIGHT><br>";
echo "<input type=\"Hidden\" name=\"operation\" id=\"op\" value=\"$operation\">";
 }
else{
echo "<tr><td align=\"left\">Account no:<td><input type=\"TEXT\" name=\"account_no\" size=\"12\" value=\"$account_no\"><br>";
echo "<tr><td align=\"left\">Opening date:<td><input type=\"TEXT\" name=\"opening_date\" size=\"50\" value=\"$opening_date\"><br>";
echo "<tr><td align=\"left\">Period:<td><input type=\"TEXT\" name=\"period\" size=\"50\" value=\"$period\"><br>";
//echo "<tr><td align=\"left\">Due date :<td><input type=\"TEXT\" name=\"due_date\" size=\"50\" value=\"$due_date\"><br>";
echo "<tr><td align=\"left\">Monthly Interest:<td><input type=\"TEXT\" name=\"monthly_installment\" size=\"50\" value=\"$monthly_installment\"><br>";
echo "<tr><td align=\"left\">Principal:<td><input type=\"TEXT\" name=\"principal\" size=\"50\" value=\"$principal\"><br>";
echo "<tr><td align=\"left\">Rate of interest:<td><input type=\"TEXT\" name=\"rate_of_interest\" size=\"50\" value=\"$rate_of_interest\"><br>";
echo "<tr><td align=\"left\">Maturity amount:<td><input type=\"TEXT\" name=\"maturity_amount\" size=\"50\" value=\"$maturity_amount\"><br>";
echo "<tr><td align=\"left\">Maturity date:<td><input type=\"TEXT\" name=\"maturity_date\" size=\"50\" value=\"$maturity_date\"><br>";
$withdrawn_type=$withdrawn_type_array[trim($withdrawn_type)];
echo "<tr><td align=\"left\">Withdrawn type:<td>";
makeSelect($withdrawn_type_array,"withdrawn_type",$withdrawn_type);
echo "<tr><td align=\"left\">Withdrawal date:<td><input type=\"TEXT\" name=\"withdrawal_date\" size=\"50\" value=\"$withdrawal_date\"><br>";
echo "<tr><td align=\"left\">Withdrawal amount:<td><input type=\"TEXT\" name=\"withdrawal_amount\" size=\"50\" value=\"$principal\"><br>";
echo "<input type=\"Hidden\" name=\"operation\" value=\"$operation\">";
}
echo "<tr>";
if(trim($_REQUEST['t_status'])=='y'){
echo "<td bgcolor=\"#90EE90\">Transfer to Your SB A/C : <INPUT NAME=\"t_status\"  TYPE=\"TEXT\" VALUE=\"y\" SIZE=\"1\" READONLY $HIGHLIGHT >";
echo "<td bgcolor=\"#90EE90\">Your SB A/C No. :<td bgcolor=\"#90EE90\"><INPUT NAME=\"account_sb\" id=\"ac\" TYPE=\"TEXT\" VALUE=\"$account_sb\" size=\"10\" $HIGHLIGHT READONLY>";
echo "&nbsp;<INPUT TYPE=\"button\" name=\"s1\" VALUE=\"Search\" onClick=\"sbChild();\">";
echo "<td align=\"right\" bgcolor=\"#90EE90\" colspan=\"\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Withdrawn\">";
}else{
echo "<td align=\"right\" bgcolor=\"#90EE90\" colspan=\"4\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Withdrawn\">";
}


echo "</table>";
echo "</form>";
  }
}
echo "</body>";
echo "</html>";
?>
