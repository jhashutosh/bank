<?php
include "../config/config.php";
$staff_id=verifyAutho();
$account_no=$_SESSION["current_account_no"];
$menu=$_REQUEST['menu'];

$withdrawal_date=$_REQUEST['withdrawal_date'];
// Make WHERE CLAUSE such that only one row retrive in actual case
echo "<html>";
echo "<head>";
echo "<title>Withdrawal Form - Recurring Deposit";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
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
function clearText(str){
if(str=='n'){
document.form1.sb_ac.value='';
document.form1.sb_ac.disabled=true;
document.form1.sb_bt.disabled=true;
}
else{
//alert('h')
document.form1.sb_ac.disabled=false;
document.form1.sb_ac.READONLY=false;
document.form1.sb_bt.disabled=false;
document.form1.sb_ac.focus();

}
}
function varify(){
/*var str=document.getElementById("r1").value;
alert(str)
if(str=='y'){
	if(document.form1.sb_ac.value.length<1){
	 alert("please enter Saving A/C No !!!!!")
	 document.form1.sb_ac.focus();
         return false;	
	}
 }*/
}

</script>

<?php
echo "</head>";
echo "<body bgcolor=\"silver\">";
$id=getCustomerId($account_no,$menu);
$flag=getGeneralInfo_Customer($id);
if($flag==1){
echo "<hr>";
// Make WHERE CLAUSE such that only one row retrive in actual case
$sql_statement="select * from deposit_info where account_no='$account_no'";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
  echo "<h4>Already withdrawn or record not found!!!</h4>";
} else {
  $account_no=pg_result($result,'account_no');
  $opening_date=pg_result($result,'action_date');
  $scheme=pg_result($result,'scheme');
  $period=pg_result($result,'period');
  $fd_compute_type=pg_result($result,'interest_method');
  $amount_deposit=pg_result($result,'principal');
  $rate_of_interest=pg_result($result,'interest_rate');
  $maturity_amount=pg_result($result,'maturity_amount');
  $maturity_date=pg_result($result,'maturity_date');
  $status=pg_result($result,'status');
  $sql_statement="SELECT  rd_withdrawal('$account_no','$withdrawal_date')";
  //echo  $sql_statement;
  $result1=dBConnect($sql_statement);
  $sql_statement="SELECT * FROM tmp_deposit_info WHERE account_no='$account_no' AND certificate_no='$account_no'";
  $result1=dBConnect($sql_statement);
  if(pg_NumRows($result1)>0){
  $days=pg_result($result1,'days');
  $interest=pg_result($result1,'interest_amount');
  $maturity_rate=pg_result($result1,'rate_of_interest');
  $withdral_amount=pg_result($result1,'maturity_amount');
  $maturity_type=pg_result($result1,'maturity_type');
  }
$sql_statement="SELECT (CASE WHEN SUM(amount) IS NULL THEN 0 ELSE SUM(amount) END ) as fine FROM rd_fine WHERE account_no='$account_no'";
$result=dBConnect($sql_statement);
$fine=pg_result($result,'fine');
echo "<form method=\"POST\" name=\"form1\" action=\"rd_ledger_wadd.php?menu=$menu\" onsubmit=\"return varify();\">";
 echo "<table bgcolor=BLACK align=center width=70%>";
 echo "<tr><th colspan=\"4\" bgcolor=Yellow>Withdrawal Form of ".strtoupper($menu)."[$account_no]</th></tr>";
echo "<tr><td align=\"left\" bgcolor=#F08080>Opening Date:<td bgcolor=#F08080><input type=\"TEXT\" name=\"op_date\" size=\"12\" value=\"".$opening_date."\" $HIGHLIGHT>";
echo "<td align=\"left\" bgcolor=#F08080>Withdrawal Status:<td bgcolor=#F08080><input type=\"TEXT\" name=\"status\" size=\"15\" value=\"".ucwords($maturity_type)."\" $HIGHLIGHT ><br>";
echo "<tr><td align=\"left\" bgcolor=#F08080>Monthly Deposits:<td bgcolor=#F08080><input type=\"TEXT\" name=\"m_d\" size=\"15\" value=\"$amount_deposit\" $HIGHLIGHT READONLY><br>";
echo "<td align=\"left\" bgcolor=#F08080>period :<td bgcolor=#F08080><input type=\"TEXT\" name=\"period\" size=\"12\" value=\"".$period."\" READONLY $HIGHLIGHT> Months";

echo "<tr><td align=\"left\" bgcolor=#F08080>Rate of Interest:<td bgcolor=#F08080><input type=\"TEXT\" name=\"rate\" size=\"15\" value=\"$rate_of_interest\" $HIGHLIGHT READONLY><br>";
echo "<td align=\"left\" bgcolor=#F08080>Maturity Amount :<td bgcolor=#F08080><input type=\"TEXT\" name=\"m_amount\" size=\"12\" value=\"$maturity_amount\"  $HIGHLIGHT>";

echo "<tr><td align=\"left\" bgcolor=#F08080>Maturity Interest:<td bgcolor=#F08080><input type=\"TEXT\" name=\"m_int\" size=\"15\" value=\"".($maturity_amount-($period*$amount_deposit))."\" $HIGHLIGHT ><br>";
echo "<td align=\"left\" bgcolor=#F08080>Maturity Date :<td bgcolor=#F08080><input type=\"TEXT\" name=\"m_date\" size=\"12\" value=\"$maturity_date\" READONLY $HIGHLIGHT>";

echo "<tr><td align=\"left\" bgcolor=#F08080>Withdrawal Amount:<td bgcolor=#F08080><input type=\"TEXT\" name=\"with_p\" size=\"15\" value=\"$withdral_amount\" $HIGHLIGHT ><br>";
echo "<td align=\"left\" bgcolor=#F08080>Withdrwal Interest :<td bgcolor=#F08080><input type=\"TEXT\" name=\"with_int\" size=\"12\" value=\"$interest\" $HIGHLIGHT>";
echo "<tr><td align=\"left\" bgcolor=#F08080>Withdrawal Interest Rate:<td bgcolor=#F08080><input type=\"TEXT\" name=\"m_int\" size=\"15\" value=\"$maturity_rate\" $HIGHLIGHT ><br>";
echo "<td align=\"left\" bgcolor=#F08080>Fine :<td bgcolor=#F08080><input type=\"TEXT\" name=\"fine\" size=\"12\" value=\"$fine\"  $HIGHLIGHT>";
echo "<tr><td align=\"left\" bgcolor=#F08080>Final Payment:<td bgcolor=#F08080><input type=\"TEXT\" name=\"with_amount\" size=\"15\" value=\"".($withdral_amount-$fine)."\" $HIGHLIGHT >";
echo "<td align=\"left\" bgcolor=#F08080>Withdrawal Date:<td bgcolor=#F08080><input type=\"TEXT\" name=\"withdrawal_date\" size=\"12\" id=\"withdrawal_date\" value=\"$withdrawal_date\" $HIGHLIGHT READONLY><br>";
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
 echo "<td align=\"right\" colspan=\"1\" bgcolor=#F08080><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\" Withdrawal\">";
echo "</table>";
echo "</form>";


echo "</table>";
echo "</form>";
}
}
echo "</body>";
echo "</html>";

?>
