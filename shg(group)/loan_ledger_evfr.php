<?
include "../config/config.php";
$staff_id=verifyAutho();
$group_no=$_REQUEST["group_no"];
$loan_no=$_REQUEST["loan_no"];
$tran_dt=date('d/m/Y');
$c_id=getCustomerIdFromGroupId($group_no);
$gl_code=getGlCode4mCustomerAccount($loan_no);
echo "<html>";
echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"amount.focus();\">";
$sql_statement="SELECT * FROM gl_ledger_hrd h,gl_ledger_dtl d WHERE account_no='$loan_no' AND h.tran_id=d.tran_id AND gl_mas_code='$gl_code' ORDER BY entry_time LIMIT 1";  
//echo $sql_statement;
$flag=getGeneralInfo_Customer($c_id);
if($flag==1){
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0)
{
 echo "<h1><b><font color=Red><center><Blink>Record Not Found!!!!</blink></center></font></h1>";
  }
else
{
/*echo "<font size=+2><b>Entry Form :Loan_Payment<br>";
echo "</font>";
echo "<font size=-1>Please fill-up this form";
echo "</font>";*/
echo "<hr>";
echo "<form method=\"POST\" action=\"shg_ledger_eaddr.php?menu=$menu\">";
echo "<table bgcolor=AQUA align=CENTER width=80%>";
echo "<tr><th colspan=4 bgcolor=BLUE><font size=+1><b>Loan Repayment Voucher";
echo "<tr><td align=\"left\">Loan Account No:<td><input type=\"TEXT\" name=\"loan_no\" size=\"15\" value=\"$loan_no\" readonly><br>";
echo "<td align=\"left\">Group No:<td><input type=\"TEXT\" name=\"group_no\" size=\"15\" value=\"$group_no\" readonly><br>";
echo "<tr><td align=\"left\">Loan Amount:<td><input type=\"TEXT\" name=\"loan_amount\" size=\"15\" value=\"".pg_result($result,"amount")."\" readonly><br>";
$current_bal=loan_current_balance($loan_no);
echo "<td align=\"left\">Loan Current Balance:<td><input type=\"TEXT\" name=\"loan_curr\" size=\"10\" value=\"".$current_bal."\" readonly><br>";
//$date_of_repayment=pg_result($result,"date_of_repayment");
echo "<tr><td align=\"left\">Loan Repayment Date:<td><input type=\"TEXT\" name=\"repay_date\" size=\"12\" value=\"".$date_of_repayment."\" readonly><br>";
echo "<td align=\"left\">Action Date:<td><input type=\"TEXT\" name=\"action_date\" size=\"15\" value=\"$tran_dt\">";
echo "<tr><td align=\"left\">Due Interest Rate:<td><input type=\"TEXT\" name=\"\" size=\"10\" value=\"".pg_result($result,"rate_of_interest")."\" readonly><br>";
echo "<td align=\"left\">Overdue Interest Rate:<td><input type=\"TEXT\" name=\"\" size=\"10\" value=\"".pg_result($result,"rate_of_overdue_int")."\" readonly><br>";
/*$sql_statement="SELECT * from shg_loan_simple_int('".pg_result($result,"loan_account_no")."')";
$result1=pg_Exec($db,$sql_statement);
$sql_statement="SELECT * FROM shg_tmp where account_no='$loan_no'";
$result1=pg_Exec($db,$sql_statement);
$due_days=pg_result($result1,"due_days");
$overdue_days=pg_result($result1,"overdue_days");
$due_interest=pg_result($result1,"due_interest");
$overdue_interest=pg_result($result1,"overdue_interest");*/
echo "<tr><td align=\"left\">Days for Due:<td><input type=\"TEXT\" name=\"\" size=\"10\" value=\"$due_days\" readonly><br>";
echo "<td align=\"left\">Days for Overdue:<td><input type=\"TEXT\" name=\"\" size=\"10\" value=\"$overdue_days\" readonly><br>";
echo "<tr><td align=\"left\">Interest for Due:<td><input type=\"TEXT\" name=\"due_int\" size=\"10\" value=\"$due_interest\" readonly><br>";
echo "<td align=\"left\">Interest for Overdue:<td><input type=\"TEXT\" name=\"over_due_int\" size=\"10\" value=\"$overdue_interest\" readonly><br>";
echo "<tr><td align=\"left\">Total Payable Amount:<td><input type=\"TEXT\" name=\"tpa\" size=\"10\" value=\"".($current_bal+$overdue_interest+$due_interest)."\" readonly><br>";
echo "<td align=\"left\">Amount:<td><input type=\"TEXT\" name=\"amount\" id=\"amount\" size=\"10\" value=\"\"><br>";
echo "<tr><td valign=\"top\" align=\"left\">Remarks:<td colspan=2 align=left><textarea name=\"remarks\" rows=\"2\" cols=\"20\"></textarea>";
echo "<td align=\"right\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Enter\">";
echo "  <input type=\"RESET\" name=\"RESET_BUTTON\" value=\"Reset\">";
echo "</table>";
echo "</form>";
  }
echo "</body>";
echo "</html>";
}
?>
