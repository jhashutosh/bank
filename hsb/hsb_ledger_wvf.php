<?
include "../config/config.php";
$staff_id=verifyAutho();
$account_no=$_SESSION["current_account_no"];
$menu=$_REQUEST['menu'];
$certificate_no=$_REQUEST['certificate_no'];
$withdrawal_date=$_REQUEST['withdrawal_date'];
?>
<script language="javascript">
function findAccount(){
var str=document.getElementById("sb_ac").value;
if(str.length==0)
{
alert("Please enter introducer account no.")
document.form1.sb_ac.disabled=false;
document.form1.sb_ac.readonly=false;
document.form1.sb_ac.focus();
}
else
{
url="../main/pop_up_account.php?menu=sb&account_no="+str;
window.open(url,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150,width=1050,height=500');
return false;
}
}
</script>
<?
// Make WHERE CLAUSE such that only one row retrive in actual case
echo "<html>";
echo "<head>";
echo "<title>Withdrawal Form - Reinvestment";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
$id=getCustomerId($account_no,$menu);
$flag=getGeneralInfo_Customer($id);
if($flag==1){
echo "<hr>";
$sql_statement="select d.*,case when '$withdrawal_date'< maturity_date then 'Premature' else 'Mature' end as with_type from deposit_info d where account_no='$account_no' AND certificate_no ='$certificate_no'";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
  echo "<h4>Already withdrawn or record not found!!!</h4>";
} else {
  $account_no=pg_result($result,'account_no');
  $certificate_no=pg_result($result,'certificate_no');
  $opening_date=pg_result($result,'action_date');
  $maturity_type=pg_result($result,'with_type');
  $scheme=pg_result($result,'scheme');
  $holder_sb_account_no=pg_result($result,'holder_sb_account_no');
  $period=pg_result($result,'period');
  $fd_compute_type=pg_result($result,'interest_method');
  $amount_deposit=pg_result($result,'principal');
  $rate_of_interest=pg_result($result,'interest_rate');
  $maturity_amount=pg_result($result,'maturity_amount');
  $maturity_date=pg_result($result,'maturity_date');
  $status=pg_result($result,'status');
  $sql_int="SELECT hsb_with('$account_no','$certificate_no','$withdrawal_date')";
  //echo $sql_int;
  $int_res=dBConnect($sql_int);
  $interest=pg_result($int_res,'hsb_with');
  $sql_pri="select sum(credit-debit) bal from mas_gl_tran where account_no='$account_no' /*and certificate_no='$certificate_no'*/ ";
 //echo $sql_pri;
	$res_pri=dBConnect($sql_pri);
	$amount_deposit=pg_result($res_pri,'bal');
	$maturity_amount=$amount_deposit+$interest;




echo "<form method=\"POST\" action=\"hsb_ledger_wadd.php?menu=$menu\">";
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
echo "<tr><td align=\"left\">Maturity Amount:<td><input type=\"TEXT\" name=\"maturity_amount\" size=\"10\" value=\"$maturity_amount\"  $HIGHLIGHT><br>";
echo "<td align=\"left\">Maturity Date:<td><input type=\"TEXT\" name=\"maturity_date\" size=\"12\" value=\"$maturity_date\" readonly $HIGHLIGHT><br>";
//echo "<tr><td align=\"left\">Withdrawal Interest Rate:<td><input type=\"TEXT\" name=\"withdrawal_int_rate\" size=\"15\" value=\"$maturity_rate\"  $HIGHLIGHT><br>";
//echo "<td align=\"left\">Total Days:<td><input type=\"TEXT\" name=\"days\" size=\"12\" value=\"$days\"  readonly $HIGHLIGHT><br>";
echo "<tr><td align=\"left\">Withdrawn Type:<td><input type=\"TEXT\" name=\"withdrawal_type\" size=\"15\" value=\"$maturity_type\"  $HIGHLIGHT><br>";
echo "<td align=\"left\">Withdrawal Date:<td><input type=\"TEXT\" name=\"withdrawal_date\" size=\"12\" value=\"$withdrawal_date\"  readonly $HIGHLIGHT><br>";
echo "<tr><td align=\"left\">Withdrawal Interest:<td><input type=\"TEXT\" name=\"withdrawal_int\" size=\"15\" value=\"$interest\"  $HIGHLIGHT><br>";
$withdral_amount=$interest+$amount_deposit;
echo "<td align=\"left\">Withdrawal Amount:<td><input type=\"TEXT\" name=\"withdrawal_amount\" size=\"12\" value=\"$withdral_amount\"   $HIGHLIGHT><br>";

echo "<tr><td valign=\"top\" align=\"left\">Remarks:<td colspan=2><textarea name=\"remarks\" rows=\"2\" cols=\"49\" $HIGHLIGHT>$remarks</textarea><br>";









$t_status=$_REQUEST['t_status'];
if(trim($t_status)=='y'){
$sb_account_no=customerAccountNo($id,'sb');
//if(!empty($sb_account_no)){$READONLY='READONLY';}
$CHECK_Y='CHECKED';
}
else{
$CHECK_N='CHECKED';
$DISABLED='DISABLED';
}
echo "<tr><td colspan=\"3\" align=\"CENTER\" bgcolor=#F08080>Transfer to Your SB A/C : <INPUT NAME=\"t_status\" id=\"r1\" TYPE=\"radio\" VALUE=\"y\" $CHECK_Y $HIGHLIGHT onClick=\"clearText(this.value);\">Yes &nbsp;&nbsp;<INPUT NAME=\"t_status\"  TYPE=\"radio\" VALUE=\"n\" $CHECK_N $HIGHLIGHT onClick=\"clearText(this.value);\">No";
echo "&nbsp<input type=\"TEXT\" id=\"sb_ac\" size=\"8\" value=\"$sb_account_no\" name=\"sb_account_no\" $READONLY $HIGHLIGHT $DISABLED><input type=\"BUTTON\" id=\"sb_bt\" name=\"BUTTON\" value=\"Search\" $DISABLED onClick=\"findAccount();\">";
echo "<td align=\"CENTER\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Final\">";
//echo "  <input type=\"RESET\" name=\"RESET_BUTTON\" value=\"Cancel\"><br>";
echo "</table>";
echo "</form>";
   }
}
echo "</body>";
echo "</html>";

?>
