<?php
include "../config/config.php";
$staff_id=verifyAutho();
$account_no=$_SESSION["current_account_no"];
$menu=$_REQUEST['menu'];
$op=$_REQUEST['op'];
$certificate_no=$_REQUEST['certificate_no'];
$withdrawal_date=$_REQUEST['withdrawal_date'];
$t_status=$_REQUEST['pmood'];
// Make WHERE CLAUSE such that only one row retrive in actual case
echo "<html>";
echo "<head>";
echo "<title>Withdrawal Form - Reinvestment";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
?>
<script language="javascript">
function checking(){
if(document.form.withdrawal_int.value.length==0){
	alert("Please enter your withdrawal Interest")
	document.form.withdrawal_int.focus();
	return false;
}
if(document.form.withdrawal_amount.value.length==0){
	alert("Please enter your withdrawal Amount")
	document.form.withdrawal_amount.focus();
	return false;
}
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
</script>
<?php
echo "</head>";
echo "<body bgcolor=\"silver\">";
$id=getCustomerId($account_no,$menu);
$flag=getGeneralInfo_Customer($id);
if($flag==1){
echo "<hr>";
$sql_statement="select * from deposit_info where account_no='$account_no' AND certificate_no ='$certificate_no'";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
  echo "<h4>Already withdrawn or record not found!!!</h4>";
} else {
  $account_no=pg_result($result,'account_no');
  $certificate_no=pg_result($result,'certificate_no');
  $opening_date=pg_result($result,'action_date');
  $scheme=pg_result($result,'scheme');
  $holder_sb_account_no=pg_result($result,'holder_sb_account_no');
  $period=pg_result($result,'period');
  $fd_compute_type=pg_result($result,'interest_method');
  $amount_deposit=pg_result($result,'principal');
  $rate_of_interest=pg_result($result,'interest_rate');
  $maturity_amount=pg_result($result,'maturity_amount');
  $maturity_date=pg_result($result,'maturity_date');
  $status=pg_result($result,'status');
  $sql_statement="SELECT withdrawal_ri('$account_no','$certificate_no','$withdrawal_date');";
  $sql_statement=$sql_statement."SELECT * FROM tmp_deposit_info WHERE account_no='$account_no' AND certificate_no='$certificate_no'";
  $result1=dBConnect($sql_statement);
  if(pg_NumRows($result1)>0){
  $days=pg_result($result1,'days');
  $interest=pg_result($result1,'interest_amount');
  $maturity_rate=pg_result($result1,'rate_of_interest');
  $withdral_amount=pg_result($result1,'maturity_amount');
  $maturity_type=pg_result($result1,'maturity_type');
  }

$account_sb=findSBAccount($account_no);
if(trim($_REQUEST['t_status'])=='y'&& (empty($account_sb))){
	echo "<font color=red size=+3 align=center><b>Dont have any Savings Account</font>";
		}
else{
echo "<form method=\"POST\" name=\"form\" action=\"ri_ledger_wadd.php?menu=$menu\">";
echo "<table bgcolor=#7FFFD4 align=center width=90%>";
echo "<tr><th colspan=\"4\" bgcolor=Yellow>Withdrawal Form of ".strtoupper($menu)."[$account_no($certificate_no)]</th></tr>";
echo "<tr><td align=\"left\">Account No:<td><input type=\"TEXT\" name=\"account_no\" size=\"15\" value=\"$account_no\" readonly $HIGHLIGHT><br>";
echo "<td align=\"left\">Certificate No:<td><input type=\"TEXT\" name=\"certificate_no\" size=\"15\" value=\"$certificate_no\" readonly $HIGHLIGHT>";
echo "<tr><td align=\"left\">Opening Date:<td><input type=\"TEXT\" name=\"opening_date\" size=\"12\" value=\"$opening_date\" readonly $HIGHLIGHT>";
//echo "<tr><td align=\"left\">Holder sb account no:<td><input type=\"TEXT\" name=\"holder_sb_account_no\" size=\"50\" value=\"$holder_sb_account_no\" readonly><br>";
echo "<td align=\"left\">Period:<td><input type=\"TEXT\" name=\"period\" size=\"5\" value=\"$period\" readonly $HIGHLIGHT>&nbsp Days";
//echo "<SELECT name=\"period\"><OPTION>$period</SELECT>";
echo "<tr><td align=\"left\">Amount Deposit:<td><input type=\"TEXT\" name=\"amount_deposit\" size=\"10\" value=\"$amount_deposit\" readonly $HIGHLIGHT><br>";
echo "<td align=\"left\">Rate of Interest:<td><input type=\"TEXT\" name=\"rate_of_interest\" size=\"5\" value=\"$rate_of_interest\" readonly $HIGHLIGHT>&nbsp % p.a.";
//echo "<tr><td align=\"left\">Total interest:<td><input type=\"TEXT\" name=\"total_interest\" size=\"50\" value=\"$total_interest\" readonly><br>";
echo "<tr><td align=\"left\">Maturity Amount:<td><input type=\"TEXT\" name=\"maturity_amount\" size=\"10\" value=\"$maturity_amount\" readonly $HIGHLIGHT><br>";
echo "<td align=\"left\">Maturity Date:<td><input type=\"TEXT\" name=\"maturity_date\" size=\"12\" value=\"$maturity_date\" readonly $HIGHLIGHT><br>";
echo "<tr><td align=\"left\">Withdrawal Interest Rate:<td><input type=\"TEXT\" name=\"withdrawal_int_rate\" size=\"15\" value=\"$maturity_rate\" readonly $HIGHLIGHT><br>";
echo "<td align=\"left\">Total Days:<td><input type=\"TEXT\" name=\"days\" size=\"12\" value=\"$days\"  readonly $HIGHLIGHT><br>";
echo "<tr><td align=\"left\">Withdrawn Type:<td><input type=\"TEXT\" name=\"withdrawal_type\" size=\"15\" value=\"$maturity_type\" $HIGHLIGHT><br>";
echo "<td align=\"left\">Withdrawal Date:<td><input type=\"TEXT\" name=\"withdrawal_date\" size=\"12\" value=\"$withdrawal_date\"  readonly $HIGHLIGHT><br>";
echo "<tr><td align=\"left\">Withdrawal Interest:<td><input type=\"TEXT\" name=\"withdrawal_int\" size=\"15\" value=\"$interest\" $HIGHLIGHT><br>";
echo "<td align=\"left\">Withdrawal Amount:<td><input type=\"TEXT\" name=\"withdrawal_amount\" size=\"12\" value=\"$withdral_amount\" $HIGHLIGHT><br>";

//********************************************************************************

if(trim($t_status)=='q'){
echo "<tr>";
echo "<td>Cheque No:<td><input type=TEXT name=\"ch_no\" size=\"12\" id=\"ch_no\" value=\"0\" $HIGHLIGHT>";
echo "<td>Transfer From:<td>";
selectBankAccount('bank_ac_no','ENABLE');
echo "<input type=HIDDEN name=\"t_status\" size=\"12\" id=\"t_status\" value=\"q\" $HIGHLIGHT>";
echo "</tr>";
}
if (trim($t_status)=='y'){
if(trim($t_status)=='y'){
$sb_account_no=customerAccountNo($id,'sb');
//if(!empty($sb_account_no)){$READONLY='READONLY';}
$CHECK_Y='CHECKED';
}
else{
$CHECK_N='CHECKED';
$DISABLED='DISABLED';
}
echo "<tr><td colspan=\"3\" align=\"CENTER\">Transfer to Your SB A/C : <INPUT NAME=\"t_status\" id=\"r1\" TYPE=\"HIDDEN\" VALUE=\"y\" >";
echo "&nbsp<input type=\"TEXT\" id=\"sb_ac\" size=\"8\" value=\"$sb_account_no\" name=\"sb_account_no\" READONLY><input type=\"BUTTON\" id=\"sb_bt\" name=\"BUTTON\" value=\"Search\" onClick=\"findAccount();\">";
}
if (trim($t_status)=='c'){
echo "<input type=HIDDEN name=\"t_status\" size=\"2\" id=\"t_status\" value=\"c\" $HIGHLIGHT>";
}
//*********************************************************************************
echo "<tr><td valign=\"top\" align=\"left\">Remarks:<td colspan=2><textarea name=\"remarks\" rows=\"2\" cols=\"49\" $HIGHLIGHT>$remarks</textarea><br>";

echo "<td align=\"CENTER\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Final\">";

echo "</table>";
echo "</form>";
	}
   }
}
echo "</body>";
echo "</html>";
?>

