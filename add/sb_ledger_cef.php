<?
include "../config/config.php";

$menu=$_REQUEST['menu'];
isPermissible($menu);
$account_no=$_SESSION["current_account_no"];
$action_date=date('d/m/Y');
$balance=sb_current_balance($account_no,"");
$flag=isActive_sb_account($account_no);
$sql_func="select sb_indv_int1('$account_no','$action_date')";

$sql_res=dBConnect($sql_func);
$row_func=pg_fetch_array($sql_res,0);
echo $sql_func;
$interest=$row_func['sb_indv_int'];
echo "<html>";
echo "<head>";
echo "<title>Entry Form - Saving Bank";
echo "</title>";
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
//$flag='op';
?>
<script type="text/javascript">
function changeVal(str)
{
 if(str=='draft' || str=='bcheque')
  {
   document.getElementById("ch_no").disabled=false;
   document.getElementById("ch_no").focus();
  }
 if(str=='cash')
 {
  document.getElementById("ch_no").disabled=true;
   
 }
}
</script>
<?
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"int.focus();\">";
$title='Saving Bank';
if($flag=='op'){
$id=getCustomerId($account_no,$menu);

$flag=getGeneralInfo_Customer($id);
echo "<hr>";
echo "<form name=\"form1\" method=\"POST\" action=\"sb_ledger_ceadd.php?menu=$menu\">";
echo "<table bgcolor=#FFF0F5 width=90% align=center>";
echo "<tr><th colspan=4 bgcolor=#228B22>Closing Form of ".strtoupper($menu)."<font size=+3> [$account_no]</font> Current balance:Rs. <font size=+3>$balance/=</font></th></tr>";
echo "<tr><td align=\"left\">Account no:<td><input type=\"TEXT\" name=\"account_no\" size=\"15\" value=\"$account_no\" disabled $HIGHLIGHT><br>";
echo "<td align=\"\">Action date:<td><input type=\"TEXT\" name=\"action_date\" size=\"12\" value=\"$action_date\" $HIGHLIGHT>";
echo "&nbsp;&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(form1.action_date,'dd/mm/yyyy','Choose Date')\"><br>";
echo "<tr><td>Interest:<td><input type=text name=\"interest\" value=\"$interest\" id=\"int\" size=10 $HIGHLIGHT>";
echo "<td align=\"\">Closing Balance:<td><input type=\"TEXT\" name=\"closing_bal\" size=\"10\" value=\"".sb_current_balance($account_no)."\" $HIGHLIGHT>
<br>";
echo "<tr><td valign=\"top\" align=\"left\">Particulars:<td>";
echo "<select name=\"particulars\" onChange=\"changeVal(this.value)\">";
echo "<option value=cash>Cash</option>";
echo "<option value=draft>Draft</option>";
echo "<option value=bcheque>Banker Cheque</option>";
echo "</select>";

/*echo "<tr><td valign=\"top\" align=\"left\">Particulars:<td>";
makeSelect($bank_withdrawal_particulars_array,"particulars","");
*/
echo "<td>Bank Charge : <td><input type=text name=\"bank_charge\"  $HIGHLIGHT >"; 
echo "<tr><td valign=\"top\" align=\"left\">Closing Reason:<td colspan=3><textarea name=\"remarks\" rows=\"3\" cols=\"50\" $HIGHLIGHT></textarea>";
echo "<input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Submit\">";
echo "</table>";
echo "</form>";
}
else {
 echo "<h1><font color=red><center><blink>This Account is already Closed !!!!!!!!!!";
}
?>
<script language="JavaScript" type="text/javascript">
//You should create the validator only after the definition of the HTML form
   var frmvalidator  = new Validator("form1");
   frmvalidator.addValidation("action_date","req","Please enter the Action Date");
  frmvalidator.addValidation("interest","req","Please enter the Interest Amount or amount should not be less than 0");
  frmvalidator.addValidation("interest","dec","Interest Amount should be positive Numeric value");
         
  frmvalidator.addValidation("closing_bal","req","Please enter the closing Amount");
   frmvalidator.addValidation("closing_bal","dec","Closing Amount should be positive Numeric value");
frmvalidator.addValidation("bank_charge","req","Please enter the Service Charge");
   frmvalidator.addValidation("bank_charge","dec","Service Charge  should be positive Numeric value");
</script>
<?
echo "</body>";
echo "</html>";

?>
