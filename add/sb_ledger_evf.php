<?
include "../config/config.php";
$staff_id=verifyAutho();
// PHP4 
//$account_no=$_REQUEST["account_no"];
$account_no=$_SESSION["current_account_no"];
$menu=$_REQUEST["menu"];
$action_date=$_REQUEST["action_date"];
$particulars=$_REQUEST["particulars"];
//$cheque_no=$_REQUEST["cheque_no"];
$withdrawals=$_REQUEST["withdrawals"];
$deposits=$_REQUEST["deposits"];
$remarks=$_REQUEST["remarks"];
$balance=sb_current_balance($account_no,"");
$withdrawal=$_REQUEST["withdrawal"];
$deposit=$_REQUEST["deposit"];
$limits=$_REQUEST["limits"];
$menu=$_REQUEST["menu"];
echo "<html>";
echo "<head>";
echo "<title>Entry Form -  Saving Bank";
echo "</title>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"bank_name.focus();\">";
;
$id=getCustomerId($account_no,$menu);
$flag=getGeneralInfo_Customer($id);
if($flag==1){
echo "<hr>";
echo "<form name=\"form1\" action=\"sb_ledger_eadd.php?menu=$menu\" method=\"POST\">";
echo "<table bgcolor=BLACK width=90% align=center>";
echo "<tr><th colspan=4 bgcolor=Yellow>Entry Form of ".strtoupper($menu)."<font size=+3> [$account_no]</font> Current balance:Rs. <font size=+3>$balance/=</font></th></tr>";
if($withdrawal==1){
	echo "<tr bgcolor=\"#B6ABB8\"><td align=\"left\">Account no:<td><input type=\"TEXT\" name=\"account_no\" size=\"15\" value=\"$account_no\" disabled $HIGHLIGHT><br>";
	echo "<td align=\"left\">Action date:<td><input type=\"TEXT\" name=\"action_date\" size=\"12\" value=\"$action_date\" $HIGHLIGHT><br>";
	echo "<input type=\"hidden\" name=\"type\" value=\"w\" >";
	echo "<tr bgcolor=\"#B6ABB8\"><td valign=\"top\" align=\"left\">Particulars:<td><input type=text name=\"particulars\" value=\"$particulars\" size=\"15\"readonly $HIGHLIGHT><br>";
	echo "<td align=\"left\">Given:<td><input type=\"TEXT\" name=\"withdrawals\" size=\"20\" value=\"$withdrawals\" $HIGHLIGHT><br>";
	echo "<tr bgcolor=\"#B6ABB8\"><td valign=\"top\" align=\"left\" $HIGHLIGHT>Remarks:<td colspan=2><textarea name=\"remarks\" rows=\"3\" cols=\"49\">$remarks</textarea><br>";
    echo "<td align=\"right\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Submit\">";
     
}
else{
	echo "<tr bgcolor=\"#B6ABB8\"><td align=\"left\">Account no:<td><input type=\"TEXT\" name=\"account_no\" size=\"15\" value=\"$account_no\" $HIGHLIGHT disabled><br>";
	echo "<td align=\"left\">Action date:<td><input type=\"TEXT\" name=\"action_date\" size=\"12\" value=\"$action_date\" $HIGHLIGHT><br>";
	echo "<tr bgcolor=\"#B6ABB8\"><td valign=\"top\" align=\"left\">Particulars:<td><input type=text name=particulars value=$particulars size=\"15\" readonly $HIGHLIGHT><br>";
	echo "<input type=\"hidden\" name=\"type\" value=\"d\" >";
    echo "<td align=\"left\">Deposits:<td><input type=\"TEXT\" name=\"deposits\" size=\"20\" value=\"$deposits\" $HIGHLIGHT><br>";
	echo "<tr bgcolor=\"#B6ABB8\"><td valign=\"top\" align=\"left\">Remarks:<td colspan=2><textarea name=\"remarks\" rows=\"3\" cols=\"49\" $HIGHLIGHT>$remarks</textarea>";
    echo "<td align=\"right\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Submit\">";
	}  
}  
echo "</table>";
echo "</form>";
echo "</body>";
echo "</html>";
if($particulars=="cheque" && $deposit==1){
?>
<script language="JavaScript" type="text/javascript">
 var frmvalidator  = new Validator("form1");
  frmvalidator.addValidation("bank_name","req","Please enter Bank Name");
  frmvalidator.addValidation("branch","req","Please enter Branch Name");
  frmvalidator.addValidation("cheque_no","req","Please enter Cheque No");
  frmvalidator.addValidation("cheque_dt","req","Please enter cheque date");
  frmvalidator.addValidation("deposits","req","Please enter Deposit Amount");
  frmvalidator.addValidation("deposits","dec","Deposit Amount Should be Positive Number");
  </script>
<?
}
?>
