<?
include "../config/config.php";
$staff_id=verifyAutho();
$account_no=$_SESSION["current_account_no"];
$menu=$_REQUEST['menu'];
//$group_no=$_REQUEST['group_no'];
$pay_term=$_REQUEST['pay_term'];
$loan_limit=$_REQUEST['loan_limit'];
$appl_amount=$_REQUEST['applied_amount'];
$loan_amount=$_REQUEST['loan_amount'];
$loan_date=$_REQUEST['date_of_issue'];
$rate_of_int=$_REQUEST['interest_rate'];
$over_rate_of_int=$_REQUEST['overdue_interest_rate'];
$repay_date=$_REQUEST['period'];
$purpose=$_REQUEST['purpose'];
$months=getIndex($payment_term_array,$pay_term);
$remarks=$_REQUEST["remarks"];
//echo "monthly term=$months";
//echo $loan_amount." > ".$loan_limit;
echo "<html>";
echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
$c_id=getCustomerId($account_no,$menu);
$flag1=getGeneralInfo_Customer($c_id);
if($flag1==1){
echo "<hr>";
if($loan_amount>$appl_amount){
//echo "<body bgcolor=\"silver\">";
echo "<h2><b><center><Blink><Font color=Blue>Sorry You Can't Issue the Amount Which is Higher Than loan Limit....... !!!</h2></b></center>";
//echo "<h2><center><b>You Will come after :$loan_el_date</h2></center></b>";
echo "<a href=\"../main/nextaccount.php?menu=mt\">BACK</a>";
}
else
{  
echo "<form method=\"POST\" action=\"mtloan_ledger_eadd.php?menu=$menu\">";
echo "<table bgcolor=#FFF0F5 align=center width=80%>";
echo "<tr bgcolor=black><TH colspan=5 bgcolor=BLUE><font color=WHITE size=+2><b>Loan Issue Conformation Form";
echo "<tr><td align=\"left\">Account No:<td><input type=\"TEXT\" name=\"account_no\" size=\"10\" value=\"$account_no\" readonly $HIGHLIGHT><br>";
echo "<td><td align=\"left\">Loan Issued Date:<td><input type=\"TEXT\" name=\"date_of_issue\" size=\"10\" value=\"$loan_date\" readonly $HIGHLIGHT>";
echo "<tr><td align=\"left\">Payment Terms:<td><input type=\"TEXT\" name=\"pay_term\" size=\"10\" value=\"$pay_term\" readonly $HIGHLIGHT>";
$repay_time=maturity_date($loan_date,$repay_date,'m');
echo "<td><td align=\"left\">Loan Repayment Date :<td><input type=\"TEXT\" name=\"repay_date\" size=\"10\" value=\"$repay_time\" readonly $HIGHLIGHT>";
echo "<tr><td align=\"left\">Interest Rate:<td><input type=\"TEXT\" name=\"interest_rate\" size=\"10\" value=\"$rate_of_int\" $HIGHLIGHT><td>";
echo "<td align=\"left\">Overdue Interest Rate:<td><input type=\"TEXT\" name=\"overdue_interest_rate\" size=\"10\" value=\"$over_rate_of_int\" $HIGHLIGHT>";
echo "<tr><td align=\"left\">Applied Amount:<td><input type=\"TEXT\" name=\"applied_amount\" size=\"10\" value=\"$appl_amount\" $HIGHLIGHT><br>";
echo "<td><td align=\"left\">Issued Amount:<td><input type=\"TEXT\" name=\"loan_amount\" size=\"10\" value=\"$loan_amount\" readonly $HIGHLIGHT>";
$months=(integer)$repay_date/$months;
//echo "month=$months";
$installment=$loan_amount/$months;
$emi=EMI_calculation($loan_amount,$rate_of_int,$months);
$int_installment=$emi-$installment;
$total_interest=sprintf("%-12.2f",($emi*$months)-$loan_amount);
echo "<tr><td align=\"left\">$pay_term Payment:<td><input type=\"TEXT\" name=\"emi\" size=\"10\" value=\"$installment\" $HIGHLIGHT><br>";
echo "<td><td align=\"left\">$pay_term Interest :<td><input type=\"TEXT\" name=\"int_receivable\" size=\"10\" value=\"$int_installment\" readonly $HIGHLIGHT>";
echo "<tr><td align=\"left\">$pay_term Total Payment:<td><input type=\"TEXT\" name=\"int_emi\" size=\"10\" value=\"$emi\" $HIGHLIGHT><br>";
echo "<td><td align=\"left\">Total Interest Receivable:<td><input type=\"TEXT\" name=\"int_receivable\" size=\"10\" value=\"$total_interest\" readonly $HIGHLIGHT>";
echo "<tr><td align=\"left\">Loan Repayment Period :<td><input type=\"TEXT\" name=\"period\" size=\"10\" value=\"$repay_date\" $HIGHLIGHT>&nbsp months<td>";
echo "<td align=\"left\">Purpose :<td><input type=\"TEXT\" name=\"purpose\" size=\"10\" value=\"$purpose\" $HIGHLIGHT readonly><br>";
echo "<tr><td valign=\"top\" align=\"left\">Remarks:<td><textarea name=\"remarks\" rows=\"1\" cols=\"25\" $HIGHLIGHT>$remarks</textarea>";

echo "<td align=\"right\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Submit\">";
//echo "  <input type=\"RESET\" name=\"RESET_BUTTON\" value=\"Reset\"><br>";
echo "</table>";
echo "</form>";
 }
}

echo "</body>";
echo "</html>";
?>
