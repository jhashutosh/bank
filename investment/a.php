<?
include "../config/config.php";
$staff_id=verifyAutho();
$op=$_REQUEST["op"];
echo $int;
$menu=$_REQUEST['menu'];
$ch_dt=(empty($_REQUEST['ch_dt']))?$DOB_DEFAULT:$_REQUEST['ch_dt'];
$id=$_REQUEST['id'];
echo "<html>";
echo "<head>";
echo "<title>".getName('link_tb',$id,'b_name','bank_bk_dtl')." bank's ".strtoupper($menu)." Account[$account_no]";
echo "</title>";
echo "<script src=\"../JS/validation.js\">";
echo "</script>";
?>
<script>
  function myRefresh(URL){
    window.opener.location.href =URL;
    self.close();
    }
  function activeDiv(str){
  	var t_type=document.form1.op.value;
	if(t_type=='w'){
		if(str=='c'){
alert(str)
		document.form1.ch_no.disabled=true;
		document.form1.ch_dt.disabled=true;
		document.form1.amount.focus();
		}
		else{
		document.form1.ch_no.disabled=false;
		document.form1.ch_dt.disabled=false;
		document.form1.amount.focus();
		}
	}

    }
</script>
<?
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"amount.focus();\">";
echo "<hr>";
$sql_statement="select * from deposit_info where account_no='$account_no'";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
  echo "<h4>Already withdrawn or record not found!!!</h4>";
} else {
  $account_no=pg_result($result,'account_no'); 
  $int=$maturity_amount-$amount_deposit;
//echo $int;
  $holder_sb_account_no=pg_result($result,'holder_sb_account_no');
  $amount_deposit=pg_result($result,'principal');
  $maturity_amount=pg_result($result,'maturity_amount');
  $maturity_date=pg_result($result,'maturity_date');
  $status=pg_result($result,'status');
  $result1=dBConnect($sql_statement);
  if(pg_NumRows($result1)>0){
  $interest=pg_result($result1,'interest_amount');
  $withdral_amount=pg_result($result1,'maturity_amount');
  $rate_of_interest=pg_result($result,'interest_rate');
  $withdral_date=pg_result($result1,'withdrawal_date');
  $withdrawal_date=$_REQUEST['withdrawal_date'];
  $certificate_no=$_REQUEST['certificate_no'];
  $maturity_type=pg_result($result1,'maturity_type');
  }
}
//echo $sql_statement;
$balance=(float)ccb_deposits_current_balance($account_no);
$flag=getBankInfo($id);
if($balance>0){
echo "<form name=\"form1\" method=\"POST\" action=\"b.php?menu=$menu&id=$id&op=$op&o=i&account_no=$account_no\" onSubmit=\"return varify_sb(this.form);\">";
}
else
	echo "<font color=red size=5><b>Withdrawn not Possible</b></font>";
echo "<table bgcolor=#FAF0E6 width=100% align=center>";
echo $menu;
echo "<tr><th colspan=4 bgcolor=Yellow>Entry Form of ".strtoupper($menu)."<font size=+2> [$account_no]</font> Current balance:Rs. <font size=+2>$balance/=</font></th></tr>";
echo "<tr><td align=\"left\">Account No:<td><input type=\"TEXT\" name=\"account_no\" size=\"20\" value=\"$account_no\" readonly $HIGHLIGHT><br>";
echo "<td align=\"left\">Withdrawal Date:<td><input type=\"TEXT\" name=\"withdrawal_date\" size=\"20\" id=\"withdrawal_date\" value=\"".date('d.m.Y')."\" $HIGHLIGHT>";
echo "&nbsp;&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(form1.action_date,'dd/mm/yyyy','Choose Date')\"><br>";
$withdrawn_type=$withdrawn_type_array[trim($withdrawn_type)];
echo "<tr><td align=\"left\">Withdrawn type:<td>";
makeSelect($withdrawn_type_array,"withdrawn_type",$withdrawn_type);
echo "<td valign=\"top\" align=\"left\">Particulars:<td>";
if($op=='w' and $menu=='ri'){
	echo "<Select name=\"particulars\" id=\"p\" onChange=\"activeDiv(this.value);\">";
	echo "<option value=\"ch\">Cheque</option>";
	echo "<option value=\"c\">Charges</option></select>";

	echo "<tr><td align=\"left\">Amount Deposit:<td><input type=\"TEXT\" name=\"amount_deposit\" size=\"20\" value=\"$balance\" readonly $HIGHLIGHT><br>";
$int=$maturity_amount-$amount_deposit;
//echo '$int';
	echo "<td align=\"left\">Withdrawal Interest:<td><input type=\"TEXT\" name=\"withdrawal_int\" size=\"20\" value=\"$int\"  $HIGHLIGHT><br>";	
	echo "<tr><td align=\"left\">Maturity Amount:<td><input type=\"TEXT\" name=\"maturity_amount\" size=\"20\" value=\"$maturity_amount\"  $HIGHLIGHT><br>";	
	echo "<td align=\"left\">Withdrawal Amount:<td><input type=\"TEXT\" name=\"withdrawal_amount\" size=\"20\" value=\"$withdral_amount\"   $HIGHLIGHT><br>";
	echo "<tr><td align=\"left\">Cheque No.:<td><input type=\"TEXT\" name=\"ch_no\" size=\"20\" id=\"ch_no\" value=\"\" $HIGHLIGHT>";
	echo "<td align=\"left\">Cheque Date:<td><input type=\"TEXT\" name=\"ch_dt\" size=\"20\" id=\"ch_dt\" value=\"".date('d.m.Y')."\" $HIGHLIGHT>";
echo "<tr><td align=\"left\">Maturity Date:<td><input type=\"TEXT\" name=\"maturity_date\" size=\"20\" value=\"$maturity_date\" readonly $HIGHLIGHT><br>";
}

if($op=='w' and $menu=='rd'){
//$balance=$balance+$deposits-$withdrawals;
	echo "<Select name=\"particulars\" id=\"p\" onChange=\"activeDiv(this.value);\">";
	echo "<option value=\"ch\">Cheque</option>";
	echo "<option value=\"c\">Charges</option></select>";

	echo "<tr><td align=\"left\">Total Amount Deposit:<td><input type=\"TEXT\" name=\"amount_deposit\" size=\"20\" value=\"$balance\"  $HIGHLIGHT><br>";
$int=$maturity_amount-$amount_deposit;
//echo '$int';
	echo "<td align=\"left\">Withdrawal Interest:<td><input type=\"TEXT\" name=\"withdrawal_int\" size=\"20\" value=\"$int\"  $HIGHLIGHT><br>";	
	//echo "<tr><td align=\"left\">Total Withdrawl Amount:<td><input type=\"TEXT\" name=\"maturity_amount\" size=\"20\" value=\"$maturity_amount\"  $HIGHLIGHT><br>";	
	echo "<tr><td align=\"left\">Withdrawal Amount:<td><input type=\"TEXT\" name=\"withdrawal_amount\" size=\"20\" value=\"$withdral_amount\"   $HIGHLIGHT><br>";
	echo "<tr><td align=\"left\">Cheque No.:<td><input type=\"TEXT\" name=\"ch_no\" size=\"20\" id=\"ch_no\" value=\"\" $HIGHLIGHT>";
	echo "<td align=\"left\">Cheque Date:<td><input type=\"TEXT\" name=\"ch_dt\" size=\"20\" id=\"ch_dt\" value=\"".date('d.m.Y')."\" $HIGHLIGHT>";
echo "<tr><td align=\"left\">Maturity Date:<td><input type=\"TEXT\" name=\"maturity_date\" size=\"20\" value=\"$maturity_date\" readonly $HIGHLIGHT><br>";
}


if($op=='d'){
	echo "<Select name=\"particulars\" id=\"p\" onChange=\"activeDiv(this.value);\">";
	echo "<option value=\"ca\">cash</option>";
	echo "<option value=\"i\">int.</option>";
	echo "<td align=\"left\">Deposits:<td><input type=\"TEXT\" name=\"deposit\" size=\"20\" id=\"amount\" value=\"\" $HIGHLIGHT><br>";
	}
echo "<input type=\"hidden\" name=\"balance\"  value=\"$balance\" id=\"bal\">";
echo "<input type=\"hidden\" name=\"op\"  id=\"op\" value=\"$op\" >";
echo "<tr><td valign=\"middle\" align=\"left\" colspan=3>Remarks:&nbsp<textarea name=\"remarks\" rows=\"2\" cols=\"60\" $HIGHLIGHT></textarea>";
echo "<td valign=\"middle\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Submit\">";
echo "</table>";
echo "</form>";
echo "</body>";
echo "</html>";
?>
<script language="JAVASCRIPT">
function varify_sb(f){
if((document.getElementById("action_date").value).length==0){
	alert("Date Should not be Null !!!!!")
	document.getElementById("action_date").focus();
	return false;
}
var amount=document.getElementById("amount").value;
var op=document.getElementById("op").value;
var bal=document.getElementById("bal").value;

if (IsPNumeric(amount)){
    if(op=='w'){
 		amount=parseFloat(amount);
		bal=parseFloat(bal);
		if(amount>bal){
		alert("Amount Must Be lower than from current Balance\nYou Curren Balance is: Rs. "+bal)
		document.getElementById("amount").focus();
		return false;
		}
		
	 
  	}
}
else{
	alert("Amount Must Be Positive Numeric Value")
	document.getElementById("amount").focus();
	return false;
		
	}

}
</script>

