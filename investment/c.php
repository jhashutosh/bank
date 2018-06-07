<?php
include "../config/config.php";
$staff_id=verifyAutho();
$op=$_REQUEST["op"];
//echo $int;
$menu=$_REQUEST['menu'];
$ch_dt=(empty($_REQUEST['ch_dt']))?$DOB_DEFAULT:$_REQUEST['ch_dt'];
$id=$_REQUEST['id'];
$rate=$_REQUEST['rate'];
$interest=$_REQUEST['interest'];
echo $interest;
$ac_no=$_REQUEST['sb_account_no'];
$mat_amt=$_REQUEST['$mat_amt'];
$renew_amount=$_REQUEST['$renew_amount'];
$radio=$_REQUEST['r1'];
$account_no=$_REQUEST['account_no'];
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
	function validator1(f)
	{	var msg='';//alert("msg");
		if(f.maturity_date.value==null || f.maturity_date.value=='')
		{
			msg+="Maturity Date can not be null..\n";//return false;
		}
		if(f.mat_amt.value==null || f.mat_amt.value=='') {
			msg+="Maturity Amount can not be null..\n";//return false;
		}
		if(f.rate.value==null || f.rate.value==''){
			msg+="Rate can not be null..\n";//return false;
		}
		if(f.period.value==null || f.period.value==''){
			msg+="period can not be null..";//return false;
			
		}
		if(msg==''){
			return true;
		}
		else{
			alert(msg);
			return false;
		}
	}
</script>
<?php
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"amount.focus();\">";
echo "<hr>";
$sql_statement="select * from deposit_info where account_no='$account_no' and withdrawal_date IS NULL";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
  echo "<h4>Already withdrawn or record not found!!!</h4>";
} else {
  $account_no=pg_result($result,'account_no'); 
  $int=$maturity_amount - $renew_amount;
  
  
  $maturity_amount=pg_result($result,'maturity_amount');
echo $maturity_amount;
  $principal=pg_result($result,'principal');
  $maturity_date=pg_result($result,'maturity_date');
  
  $result1=dBConnect($sql_statement);
  if(pg_NumRows($result1)>0){
  
  
  
  $certificate_no=$_REQUEST['certificate_no'];
  
  $certificate_no=pg_result($result1,'certificate_no');
$certificate_no.="/1";
  


$gl_code=getData(trim($_REQUEST['gl_code']));




  }
}

$balance=(float)ccb_deposits_current_balance($account_no,'');
$flag=getBankInfo($id);
echo "<form name=\"form1\" method=\"POST\" action=\"d.php?menu=$menu&id=$id&op=$op&o=i&account_no=$account_no&interest=$interest&ac_no=$ac_no\" onSubmit=\"return validator1(this);\">";
echo "<table bgcolor=#FAF0E6 width=100% align=center>";
//echo $menu;
echo "<tr><th colspan=4 bgcolor=Yellow>Re Investment Renewal Form of ".strtoupper($menu)."<font size=+2> [$account_no]</font> Current balance:Rs. <font size=+2>$balance/=</font></th></tr>";
echo "<tr><td align=\"left\">Account No:<td><input type=\"TEXT\" name=\"account_no\" size=\"10\" value=\"$account_no\" readonly $HIGHLIGHT><br>";
echo "<td align=\"left\">Certificate No.:<td><input type=\"TEXT\" name=\"certificate_no\" size=\"25\" value=\"$certificate_no\" $HIGHLIGHT><br>";
echo "<tr><td align=\"left\">Renewal Date:<td><input type=\"TEXT\" name=\"withdrawal_date\" size=\"10\" id=\"ch_dt\" value=\"".date('d.m.Y')."\" readonly $HIGHLIGHT>";
echo "<td align=\"left\">Effect Date:<td><input type=\"TEXT\" name=\"date_with_effect\" size=\"10\" id=\"ch_dt\" value=\"".date('d.m.Y')."\" $HIGHLIGHT>";
if(!empty($ac_no))
{
echo "<tr><td align=\"left\">Renewal Amount:<td><input type=\"TEXT\" name=\"renew_amount\" size=\"10\" value=\"$balance\"  $HIGHLIGHT><br>";
}
else
{
echo "<tr><td align=\"left\">Renewal Amount:<td><input type=\"TEXT\" name=\"renew_amount\" size=\"10\" value=\"$maturity_amount\"  $HIGHLIGHT><br>";
}


$withdrawn_type=$withdrawn_type_array[trim($withdrawn_type)];

//if($op=='r' and $menu=='ri'){
		//$int=$maturity_amount-$amount_deposit;
$int=$maturity_amount-$mat_amt;
	//echo "<tr><td align=\"left\">Maturity Amount:<td>&nbsp;Rs.<input type=\"TEXT\" name=\"mat_amt\" size=\"20\" value=\"\"  $HIGHLIGHT><br>";
echo "<tr><td align=\"left\">Maturity Date:<td><input type=\"TEXT\" name=\"maturity_date\" size=\"10\" value=\"\" onblur=\"return validator1();\" $HIGHLIGHT><br>";	
echo "<td align=\"left\">Maturity Amount   (Rs.)<td><input type=\"TEXT\" name=\"mat_amt\" size=\"10\" value=\"\"   onblur=\"return validator1();\"  $HIGHLIGHT><br>";

	

echo "<tr><td align=\"left\">Interest Rate<td><input type=\"TEXT\" name=\"rate\" size=\"10\" value=\"\"  onblur=\"return validator1(this);\"  $HIGHLIGHT><br>";
echo "<td align=\"left\">Period<td><input type=\"TEXT\" name=\"period\" size=\"10\" value=\"\"   onblur=\"return validator1(this);\"  $HIGHLIGHT><br>";	
//}
//echo "<tr bgcolor=$color><td align=\"left\">Transfer to Your SB A/C :<font color=\"RED\">*</font><td>";
///////////////////////
//echo "<td colspan=1 >Show:<td colspan=1 align=\"LEFT\"><input type=RADIO value=yes name=r1 onClick=enable_txt(this.value)>Yes&nbsp;&nbsp;&nbsp;&nbsp;";
//echo "<input type=RADIO value=no name=r1 CHECKED onClick=enable_txt(this.value)>No";

///////////////////////
if($radio=='yes'){
//makeSelectSubmit4mdb('account_no','account_no','bank_bk_dtl','sb_account_no');//makeSelectSubmit4mdb($id,$desc,$table,$name)
echo "<tr><td align=\"left\">SB Account No<td><input type=\"TEXT\" name=\"ac_no\" size=\"10\" value=\"$ac_no\"  $HIGHLIGHT><br>";

echo "<td align=\"left\">Interest Amount Transfer to SB<td><input type=\"TEXT\" name=\"interest\" size=\"10\" value=\"$interest\"  $HIGHLIGHT><br>";
}
if($op=='r' and $menu=='rd'){
	echo "<Select name=\"particulars\" id=\"p\" onChange=\"activeDiv(this.value);\">";
	echo "<option value=\"ch\">Cheque</option>";
	echo "<option value=\"c\">Charges</option></select>";
	$int=$maturity_amount-$amount_deposit;
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
function varify_sb(){
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

