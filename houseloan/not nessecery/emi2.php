<?
include "../config/config.php";
$staff_id=verifyAutho();
$account_no=$_SESSION["current_account_no"];
//$flag=checkLoanAccount($account_no);
$menu=$_REQUEST['menu'];
isPermissible($menu);
echo "<html>";
echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"applied_amount.focus();\">";
$c_id=getCustomerId($account_no,$menu);
$flag=getGeneralInfo_Customer($c_id);
if($flag==1){
echo "<hr>";
//if(!isOpenLoan($account_no)){
echo "<form method=\"POST\" name=\"parentForm\" action=\"emi1.php?menu=$menu\">";
//echo "<table bgcolor=AQUA align=center width=80%>";
echo "<table bgcolor=PINK align=center width=80%>";
echo "<tr><TH colspan=5 bgcolor=GREEN><font color=WHITE size=+2><b>EMI calculation Form[$account_no]";
echo "<tr><td align=\"left\">Loan Issued Date:<td><input type=\"TEXT\" name=\"date_of_issue\" size=\"10\" value=\"".date('d/m/Y')."\"  $HIGHLIGHT><td>";
//echo "<td align=\"left\">Payment Terms:<td>";
//makeSelect($payment_term_array,'pay_term',"");
echo "<tr><td align=\"left\">Rate:<td><input type=\"TEXT\" name=\"interest_rate\" size=\"10\" value=\"\" $HIGHLIGHT><td>";
echo "<td align=\"left\">Interest Rate:<td><input type=\"TEXT\" name=\"overdue_interest_rate\" size=\"10\" value=\"\" $HIGHLIGHT><td>";
echo "<tr><td align=\"left\">Applied Amount:<td><input type=\"TEXT\" name=\"applied_amount\" size=\"10\" value=\"\" id=\"applied_amount\" $HIGHLIGHT>";
echo "<td><td align=\"left\">Issued Amount:<td><input type=\"TEXT\" name=\"loan_amount\" size=\"10\" value=\"\" $HIGHLIGHT><br>";
echo "<tr><td align=\"left\">Loan Period:<td><input type=\"TEXT\" name=\"period\" size=\"5\" value=\"\" $HIGHLIGHT>&nbsp months";
//echo "<td><td align=\"left\">Purpose :<td><input type=\"TEXT\" name=\"purpose\" size=\"10\" value=\"Business\" $HIGHLIGHT><br>";
//echo "<tr><td valign=\"top\" align=\"left\">Remarks:<td colspan=2><textarea name=\"remarks\" rows=\"2\" cols=\"40\" $HIGHLIGHT></textarea>";
echo "<td><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Enter\">";
echo "  <input type=\"RESET\" name=\"RESET_BUTTON\" value=\"Reset\">";
echo "</table>";
echo "</form>";

}
if(!isOpenLoan($account_no)&&$flag==1){
?>
<script language="JavaScript" type="text/javascript">
var frmvalidator  = new Validator("parentForm");
frmvalidator.addValidation("loan_amount","req","Please enter Issuing Amount");
frmvalidator.addValidation("loan_amount","dec","Please enter Numeric Value.");
frmvalidator.addValidation("applied_amount","req","Please enter Applied Amount");
frmvalidator.addValidation("applied_amount","dec","Please enter Numeric Value.");
frmvalidator.addValidation("action_date","req","Please enter Issuing Date.");
frmvalidator.addValidation("interest_rate","req","Please enter Due Interest Rate");
frmvalidator.addValidation("overdue_interest_rate","req","Please enter overdue interest rate");
frmvalidator.addValidation("interest_rate","dec","Please enter Numeric Value.");
frmvalidator.addValidation("overdue_interest_rate","dec","Please enter Numeric Value.");
frmvalidator.addValidation("repay_date","dec","Please enter Numeric Value.");
frmvalidator.addValidation("period","req","Please enter Applied Amount");
//frmvalidator.addValidation("repay_date","lt<60","PLoan Repay Period Should not be greater than 60 months");
//frmvalidator.addValidation("repay_date","gt>12","PLoan Repay Period Should not be lessthan than 60 months");
//frmvalidator.addValidation("applied_amount","lessthan","issue_amount","Please enter Loan Repay Period");
</script>
<?
}
echo "</body>";
echo "</html>";
?>
