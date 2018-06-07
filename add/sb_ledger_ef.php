<?
include "../config/config.php";
$staff_id=verifyAutho();
isPermissible($menu);
$withdrawal=$_REQUEST["withdrawal"];
$deposit=$_REQUEST["deposit"];
$limits=$_REQUEST["limits"];
$menu=$_REQUEST['menu'];
$account_no=$_SESSION["current_account_no"];
if($withdrawal==1){$status="Withdrawal";}
if($deposit==1){$status="Deposit";}
$balance=sb_current_balance($account_no,"");
if($balance>0){$dr_cr="Cr.";}
else{$dr_cr="Dr.";}

$action_date=date('d/m/Y');
$flag=isActive_sb_account($account_no);
echo "<html>";
echo "<head>";
echo "<title>Entry Form - Saving Bank";
echo "</title>";
echo "<script src=\"../JS/validation.js\">";
echo "</script>";
?>
<script language="JAVASCRIPT">
/*function varify_sb(f){
var amount=document.getElementById("amount").value;
var op=document.getElementById("op").value;
var bal=document.getElementById("bal").value;
if (IsPNumeric(amount)){
    if(op=='w'){
		var ctype=document.getElementById("ctype").value;
 		amount=parseFloat(amount);
		bal=parseFloat(bal);
		if(ctype=='nr'){
			if(amount>bal){
			alert("Amount Must Be lower than or equal to current Balance\nYou Curren Balance is: Rs. "+bal+"\nYour Maximum Withdrawal amount is: Rs. "+bal)
			return false;

			}
		}
		else{
		if(amount>(bal-10)){
			if((bal-10)>0)
				max_w=bal-10;
			else 
				max_w=0;
		alert("Amount Must Be lower than from current Balance\nYou Curren Balance is: Rs. "+bal+"\nYour Maximum Withdrawal amount is: Rs. "+max_w)
		return false;
		}
	   }
  	}
}
else{
	alert("Amount Must Be Positive Numeric Value")
	return false;
		
	}
}*/
</script>
<?
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"amount.focus();\">";
$title='Advance';
if($flag=='op'){
$id=getCustomerId($account_no,$menu);
$flag=getGeneralInfo_Customer($id);
if($flag==1){
echo "<hr>";
echo "<form name=\"f1\" method=\"POST\" action=\"sb_ledger_evf.php?menu=$menu\" onSubmit=\"return varify_sb(this.form);\">";
echo "<table bgcolor=BLACK width=90% align=center>";
echo "<tr><th colspan=4 bgcolor=#62B6EF>Entry Form of ".strtoupper($menu)."<font size=+3> [$account_no]</font> Current balance:Rs. <font size=+3>".amount2Rs(abs($balance))."/= $dr_cr</font></th></tr>";
echo "<tr bgcolor=\"#DF9FEB\"><td align=\"left\">Account no:<td><input type=\"TEXT\" name=\"account_no\" size=\"15\" value=\"$account_no\" disabled $HIGHLIGHT><br>";
echo "<td align=\"left\">Action date:<td><input type=\"TEXT\" name=\"action_date\" size=\"12\" value=\"$action_date\" $HIGHLIGHT>";
echo "&nbsp;&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(form1.action_date,'dd/mm/yyyy','Choose Date')\"><br>";
echo "<tr bgcolor=\"#DF9FEB\"><td valign=\"top\" align=\"left\">Particulars:<td>";

if($withdrawal==1){
	makeSelect($bank_withdrawal_particulars_array,"particulars","");
	echo "<td align=\"left\">Given:<td><input type=\"TEXT\" name=\"withdrawals\" size=\"20\" id=\"amount\" value=\"\" $HIGHLIGHT><br>";
	echo "<input type=\"hidden\" name=\"withdrawal\" value=\"1\">";
	echo "<input type=\"hidden\" name=\"op\" value=\"w\" id=\"op\">";
	echo "<input type=\"hidden\" name=\"ctype\" value=\"".trim(getCustType($id))."\" id=\"ctype\">";
}
if($deposit==1){
	makeSelect($bank_deposit_particulars_array,"particulars","");
	echo "<td align=\"left\">Back:<td><input type=\"TEXT\" name=\"deposits\" size=\"20\" id=\"amount\" value=\"\" $HIGHLIGHT><br>";
	echo "<input type=\"hidden\" name=\"deposit\"  value=\"1\" >";
	echo "<input type=\"hidden\" name=\"op\" value=\"d\" id=\"op\">";
}
echo "<input type=\"hidden\" name=\"balance\"  value=\"$balance\" id=\"bal\">";
echo "<tr bgcolor=\"#DF9FEB\"><td valign=\"top\" align=\"left\">Remarks:<td colspan=2><textarea name=\"remarks\" rows=\"3\" cols=\"49\" $HIGHLIGHT></textarea><br>";
echo "<td align=\"right\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Submit\">";
echo "</table>";
echo "</form>";
   }
}
else {
 echo "<h1><font color=red><center><blink>This Account is already Closed !!!!!!!!!!";
}
echo "</body>";
echo "</html>";
?>
