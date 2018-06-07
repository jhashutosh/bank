<?
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$group_no=$_REQUEST['group_no'];
$loan_account=$_REQUEST['loan_acc'];
$pay_term=$_REQUEST['pay_term'];
$loan_limit=$_REQUEST['loan_limit'];
$appl_amount=$_REQUEST['applied_amount'];
$loan_amount=$_REQUEST['loan_amount'];
$loan_date=$_REQUEST['date_of_issue'];
$rate_of_int=$_REQUEST['interest_rate'];
$over_rate_of_int=$_REQUEST['overdue_interest_rate'];
$repay_date=$_REQUEST['repay_date'];
$purpose=$_REQUEST['purpose'];
$months=getIndex($payment_term_array,$pay_term);
//echo "monthly term=$months";
//echo $loan_amount." > ".$loan_limit;
echo "<html>";
echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
$c_id=getCustomerIdFromGroupId($group_no);
$flag1=getGeneralInfo_Customer($c_id);
if($flag1==1){
echo "<hr>";
if($loan_amount>$loan_limit)
{
//echo "<body bgcolor=\"silver\">";
echo "<h2><b><center><Blink><Font color=Blue>Sorry You Can't Issue the Amount Which is Higher Than loan Limit....... !!!</h2></b></center>";
//echo "<h2><center><b>You Will come after :$loan_el_date</h2></center></b>";
echo "<a href=\"../main/nextaccount.php?menu=shg\">BACK</a>";
}
else
{  
echo "<form method=\"POST\" action=\"loan_ledger_eadd.php?menu=$menu\">";
echo "<table bgcolor=PINK align=center width=100%>";
echo "<tr bgcolor=black><TH colspan=6 bgcolor=BLUE><font color=WHITE size=+3><b>SHG Loan Issue Conformation Form";
echo "<tr><td align=\"left\">Group No:<td><input type=\"TEXT\" name=\"group_no\" size=\"15\" value=\"$group_no\" readonly $HIGHLIGHT><td>";
echo "<td align=\"left\">Loan A/C No:<td><input type=\"TEXT\" name=\"loan_acc\" size=\"15\" value=\"$loan_account\" id=\"loan_acc\" $HIGHLIGHT><td>";

echo "<tr><td align=\"left\">Loan Limit:<td><input type=\"TEXT\" name=\"loan_limit\" size=\"15\" value=\"".shg_loan_limit($group_no)."\" readonly $HIGHLIGHT><td>";

echo "<td><td align=\"left\">Loan Issued Date:<td><input type=\"TEXT\" name=\"date_of_issue\" size=\"15\" value=\"".date('d/m/Y')."\" readonly $HIGHLIGHT><td>";
///echo "<td align=\"left\">Payment Terms:<td>";
//makeSelect($payment_term_array,'pay_term',"");
echo "<tr><td align=\"left\">Interest Rate:<td><input type=\"TEXT\" name=\"interest_rate\" size=\"15\" value=\"11\" $HIGHLIGHT><td>";
echo "<td align=\"left\">Over DueInterest Rate:<td><input type=\"TEXT\" name=\"overdue_interest_rate\" size=\"15\" value=\"12\" $HIGHLIGHT><td>";
echo "<tr><td align=\"left\">Applied Amount:<td><input type=\"TEXT\" name=\"applied_amount\" size=\"15\" value=\"$appl_amount\" id=\"applied_amount\" $HIGHLIGHT>";
echo "<td><td align=\"left\">Issued Amount:<td><input type=\"TEXT\" name=\"loan_amount\" size=\"15\" value=\"$loan_amount\" $HIGHLIGHT><br>";
echo "<tr><td align=\"left\">Loan Repayment Period :<td><input type=\"TEXT\" name=\"repay_date\" size=\"15\" value=\"1\" $HIGHLIGHT><td><font color=RED size=-1>Month&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>";
echo "<td align=\"left\">Purpose :<td><input type=\"TEXT\" name=\"purpose\" size=\"15\" value=\"Business\" $HIGHLIGHT><br>";
echo "<tr><td><td><td><td><td align=\"right\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Submit\">";
//echo "  <input type=\"RESET\" name=\"RESET_BUTTON\" value=\"Reset\"><br>";
echo "</table>";
echo "</form>";
 }
}

echo "</body>";
echo "</html>";
?>
