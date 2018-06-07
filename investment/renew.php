<?php
include "../config/config.php";
$staff_id=verifyAutho();
$op=$_REQUEST["op"];
//echo $int;
$menu=$_REQUEST['menu'];
$ch_dt=(empty($_REQUEST['ch_dt']))?$DOB_DEFAULT:$_REQUEST['ch_dt'];
$id=$_REQUEST['id'];
$rate=$_REQUEST['rate'];
$mat_amt=$_REQUEST['$mat_amt'];
$account_no=$_REQUEST['account_no'];
$renew_amount=$_REQUEST['$renew_amount'];
echo "<html>";
echo "<head>";
echo "<title>".getName('link_tb',$id,'b_name','bank_bk_dtl')." bank's ".strtoupper($menu)." Account[$account_no]";
echo "</title>";
echo "<script src=\"../JS/validation.js\">";
echo "</script>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"amount.focus();\">";
echo "<hr>";

$balance=(float)ccb_deposits_current_balance($account_no,'');
$flag=getBankInfo($id);

echo "<form name=\"form1\" method=\"POST\" action=\"c.php?menu=$menu&id=$id&op=$op&o=i&account_no=$account_no\" onSubmit=\"return varify_sb(this.form);\" >";
echo "<table bgcolor=#FAF0E6 width=100% align=center>";
//echo $menu;
echo "<tr><th colspan=5 bgcolor=Yellow>Re Investment Renewal Form of ".strtoupper($menu)."<font size=+2> [$account_no]</font> Current balance:Rs. <font size=+2>$balance/=</font></th></tr>";
echo "<tr><td align=\"left\">Account No:<td><input type=\"TEXT\" name=\"account_no\" size=\"10\" value=\"$account_no\" readonly $HIGHLIGHT><br>";
echo "<td colspan=1 >Transfer to Your SB A/C :<td colspan=1 align=\"LEFT\"><input type=RADIO value=yes name=r1 id=r1 onclick=\"check(this.value);\">Yes&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<input type=RADIO value=no name=r1 id=r1 CHECKED onclick=\"check(this.value);\">No";
//echo "<tr bgcolor=$color><td align=\"left\">Transfer to Your SB A/C :<font color=\"RED\">*</font><td>";
///////////////////////
//echo "<td colspan=1 >Show:<td colspan=1 align=\"LEFT\"><input type=RADIO value=yes name=r1 onClick=enable_txt(this.value)>Yes&nbsp;&nbsp;&nbsp;&nbsp;";
//echo "<input type=RADIO value=no name=r1 CHECKED onClick=enable_txt(this.value)>No";

///////////////////////

echo "<tr bgcolor=#FAF0E6 id=\"d\" style=\"display:none\"><td align=\"left\" >Transfer to Your SB A/C :<font color=\"RED\">*</font><td>";
makeSelectSubmit4mdbbank('account_no','account_no','bank_bk_dtl','sb_account_no');
echo "<td align=\"left\">Interest Amount<td><input type=\"TEXT\" name=\"interest\" id=\"interest\"size=\"10\" value=\"".findCCBInt($account_no)."\"  $HIGHLIGHT><br>";

//echo "<input type=TEXT name=n_name size=10 disabled $HIGHLIGHT>";
echo "<tr><td colspan='4' align=\"right\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Submit\">";
echo "</table>";
echo "</form>";
echo "</body>";
echo "</html>";
//--------------------------------------------------------------------------------------------------------------------
function findCCBInt($account_no){
$sql_statement="SELECT (maturity_amount-principal) as interest FROM deposit_info where account_no='$account_no' and withdrawal_date IS NULL";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
  $gl_code=pg_result($result,'interest');
   }

  return $gl_code;
//return 0;
}


?>
<script language=javascript>
function check(x){
	//alert(x)
	if(x=='yes'){
		
		document.getElementById('d').style.display='';
		//alert("hi")
		//alert(document.getElementById('sb_account_no').value);
	}
	else{
		document.getElementById('d').style.display='none';

	}
}
function varify_sb(x){
	//alert(document.getElementById('r1').value)
	if(document.getElementById('r1').checked){
		
		if(document.getElementById('sb_account_no').value.length==0){
		alert("Select Account No before submit");
		return false;
		}
		if(document.getElementById('interest').value.length==0){
		alert("Please Enter the valid Interest");
		document.getElementById('interest').focus();
		return false;
		}


	}



}
</script>
