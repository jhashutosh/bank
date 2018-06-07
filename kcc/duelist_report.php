<?php 
include "../config/config.php";
$menu=$_REQUEST['menu']; 
$staff_id=verifyAutho();
$statement=$_REQUEST['state'];
$fy=$_SESSION['fy'];
//$op=$_REQUEST['op'];
echo "<html>";
echo "<head>";
echo "<title>List of accounts";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
if($statement==d)
{
echo "<table bgcolor=\"silver\" width=100% align=center>";
$color="#CCCC00";
echo "<tr>";
echo "<th colspan=\"12\" bgcolor=\"green\"><font color=WHITE size=\"4\" align=\"center\">Due List Of KCC Loan";
echo "<tr>";
echo "<th bgcolor=$color width=\"15%\" rowspan=\"2\">KCC A/C NO.</th>";
echo "<th bgcolor=$color width=\"30%\" rowspan=\"2\">FARMER NAME</th>";
echo "<th bgcolor=$color width=\"40%\" colspan=\"3\">DUE</th>";

//echo "<th bgcolor=$color width=\"15%\" rowspan=\"2\">DAYS COUNT</th>";
echo "<th bgcolor=$color width=\"40%\" colspan=\"2\">LOAN ISSUE</th>";
echo "<th bgcolor=$color width=\"15%\" rowspan=\"2\">LOAN Repayment(Rs.)</th>";
echo "<th bgcolor=$color width=\"15%\" rowspan=\"2\">LAST Repayment DATE</th>";
//echo "<th bgcolor=$color width=\"15%\" rowspan=\"2\">DUE DATE</th>";
//echo "<th bgcolor=$color width=\"15%\" rowspan=\"2\">DUE interest RATE(%)</th>";
//echo "<th bgcolor=$color width=\"20%\" rowspan=\"2\">CROP</th>";
//echo "<th bgcolor=$color width=\"100%\" rowspan=\"2\">YEAR</th>";
echo "<tr><th bgcolor=$color>Principal</th><th bgcolor=$color>Interest</th><th bgcolor=$color>Total</th><th bgcolor=$color>DATE</th><th bgcolor=$color>Rs.</th></tr>";
$sql_statement="SELECT account_no,sum(loan_amount) as principal, sum(due_interest-r_due_int) as due_int, sum(od_interest-r_od_int) as od_int FROM get_mas_bal_dt(current_date) GROUP BY account_no HAVING sum(due_interest-r_due_int)>0 and sum(od_interest-r_od_int)<=0";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0){
echo "<tr>";
echo "<th colspan=\"14\"><font color=green size=5><blink>!!! There is no Customer in Due List !!!</blink></font></th>";
}
else
{
$color=$TCOLOR;
for($j=0; $j<=pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
$kcc_account_no=trim($row['account_no']);
$principal=trim($row['principal']);
$due_int=trim($row['due_int']);
$total=$principal+$due_int;
echo "<tr>";
echo "<th bgcolor=$color width=\"15%\">$kcc_account_no</a></th>";
$customer_id=getCustomerNameFromKCCAccount($kcc_account_no);
$name=getCustomerName($customer_id);
echo "<th bgcolor=$color width=\"30%\">$name</th>";
echo "<th bgcolor=$color>$principal</th>";
echo "<th bgcolor=$color>$due_int</th>";
echo "<th bgcolor=$color>$total</th>";
//echo "<th bgcolor=$color>0</th>";
$action_date=getActionDate($kcc_account_no);
echo "<th bgcolor=$color>$action_date</th>";
$amount=getLoanAmount($kcc_account_no);
//$action_date=getLoanAmount($kcc_account_no);
echo "<th bgcolor=$color>$amount</th>";
$return_amount=getLoanRepaymentAmount($kcc_account_no);
echo "<th bgcolor=$color>$return_amount</th>";
$rep_date=getRepaymentDate($kcc_account_no);
echo "<th bgcolor=$color>$rep_date</th>";
//echo "<th bgcolor=$color>0</th>";
//echo "<th bgcolor=$color>0</th>";
//echo "<th bgcolor=$color>0</th>";
//echo "<th bgcolor=$color>$fy</th>";
}
}
echo "</table>";
}
//---------------------------------personal statement------------------------------
if($statement==p)
{
$op=$_REQUEST['op'];
$account_no=$_REQUEST['account_no'];
//$name=$_REQUEST['name'];
//echo "sujoy";
echo "<table bgcolor=\"silver\" width=100% align=center>";
$color="#CCCC5555";
echo "<tr>";
echo "<th colspan=\"12\" bgcolor=\"green\"><font color=WHITE size=\"4\" align=\"center\">Personal Statement Of KCC -- KALNA II CADP";
echo "<form name=\"form1\" method=\"post\" action=\"../kcc/duelist_report.php?state=p&op=s&account_no=$account_no\">";
echo "<th colspan=\"12\" bgcolor=\"green\"><font color=WHITE size=\"4\" align=\"center\">Account No:<input type=\"text\" name=\"txt1\" value=\"KCC-\">&nbsp;&nbsp;<input type=\"submit\" value=\"Enter\" name=\"button1\">";
$account_no=$_REQUEST['txt1'];
echo "</form>";
echo "<tr><th rowspan=\"3\" bgcolor=\"$color\">Tran Id</th>";
echo "<th rowspan=\"3\" bgcolor=\"$color\">Crop Name</th>";
echo "<th rowspan=\"3\" bgcolor=\"$color\">Issue date</th>";
echo "<th rowspan=\"3\" bgcolor=\"$color\">Amount Issued</th>";
echo "<th colspan=\"4\" bgcolor=\"$color\">Rey-Rayment(Rs.)</th>";
echo "<th colspan=\"3\" bgcolor=\"$color\">Balance(Rs.)</th>";
echo "<th rowspan=\"3\" bgcolor=\"$color\">Due date</th>";
echo "<th colspan=\"6\" bgcolor=\"$color\">Due Interset Calculation</th>";
echo "<th colspan=\"6\" bgcolor=\"$color\">Overdue Interest Calculation</th>";
echo "<tr>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">Due</th>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">Overdue</th>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">Principal</th>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">Total</th>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">Due</th>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">Overdue</th>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">Principal</th>";
echo "<th colspan=\"2\" bgcolor=\"$color\">Between Date</th>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">Days</th>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">Against amount</th>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">Interest(Rs.)</th>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">Interest Rate(%)</th>";
echo "<th colspan=\"2\" bgcolor=\"$color\">Between Date</th>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">Days</th>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">Against amount</th>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">Interest(Rs.)</th>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">Interest Rate(%)</th>";
echo "<tr>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">From</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">To</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">From</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">To</th>";
if($op==s)
{
$customer_id=getCustomerNameFromKCCAccount($account_no);
$customer_name=getCustomerName($customer_id);
$land=getLand($customer_id);
$member_id=getMemberId($customer_id);
$value=getTotalShareValue($customer_id);
echo "<font size=4 >Name:&nbsp;&nbsp;$customer_name&nbsp;&nbsp;</font>";
echo "<font size=4 >||&nbsp;&nbsp;Total Land Area:&nbsp;&nbsp;$land&nbsp;satak&nbsp;&nbsp;</font>";
echo "<font size=4 >||&nbsp;&nbsp;Membership Id:&nbsp;&nbsp;&nbsp;$member_id&nbsp;&nbsp;||</font>";
echo "<font size=4 >&nbsp;&nbsp;Total Share Value:&nbsp;&nbsp;$value&nbsp;&nbsp;&nbsp||</font>";
$sql_statement="SELECT * FROM loan_statement WHERE account_no='$account_no'";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0){
echo "<tr>";
echo "<th colspan=\"14\"><font color=green size=5><blink>!!! There is no Customer in Due List !!!</blink></font></th>";
}
else
{
$color=$TCOLOR;
for($j=0; $j<=pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
$r_due_int=trim($row['r_due_int']);
$r_overdue_int=trim($row['r_overdue_int']);
$r_principal=trim($row['r_principal']);
$r_total=$r_due_int+$r_overdue_int+$r_principal;
$crop_id=trim($row['crop_id']);

//echo "$crop_id";
echo "<tr>";
echo "<th bgcolor=$color>".$row['tran_id']."</th>";
$crop_name=cropname($crop_id);
echo "<th bgcolor=$color>$crop_name</th>";
echo "<th bgcolor=$color>".$row['action_date']."</th>";
echo "<th bgcolor=$color>".$row['loan_amount']."</th>";
echo "<th bgcolor=$color>".$row['r_due_int']."</th>";
echo "<th bgcolor=$color>".$row['r_overdue_int']."</th>";
echo "<th bgcolor=$color>".$row['r_principal']."</th>";
echo "<th bgcolor=$color>$r_total</th>";
echo "<th bgcolor=$color>".$row['b_due_int']."</th>";
echo "<th bgcolor=$color>".$row['b_overdue_int']."</th>";
echo "<th bgcolor=$color>".$row['b_principal']."</th>";

 }
}
echo "</table>";
 }
}
//--------------------------Daily KCC loan repayment List---------------------------
if($statement==dr)
{
//echo "sujoy";
echo "<table bgcolor=\"silver\" width=\"100%\" align=\"center\">";
$color="#CCCC0000";
echo "<tr>";
echo "<th colspan=\"13\" bgcolor=\"green\"><font color=WHITE size=\"4\" align=\"center\">Daily KCC Loan Repayment List--Date:";
echo "<tr>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">Time</th>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">KCC A/C No.</th>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">Name</th>";
echo "<th colspan=\"2\" bgcolor=\"$color\">Rey-Payment</th>";
echo "<th colspan=\"3\" bgcolor=\"$color\">Current Balance of after Rey-Payment</th>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">Total Balance</th>";
echo "<th colspan=\"2\" bgcolor=\"$color\">Interest has taken against how many days</th>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">Operator Name</th>";
echo "<tr>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Crop</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Amount(Rs.)</th>";
//echo "<th rowspan=\"1\" bgcolor=\"$color\">Principal</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Due</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Overdue</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Principal</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Due days</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Overdue days</th>";
$sql_statement="SELECT * FROM loan_return_dtl WHERE action_date=current_date";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0){
echo "<tr>";
echo "<th colspan=\"12\"><font color=green size=5><blink>!!! Today No Customer did Repayment !!!</blink></font></th>";
}
else
{
$color=$TCOLOR;
for($j=0; $j<=pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
$account_no=trim($row['account_no']);
$b_due_int=trim($row['b_due_int']);
$b_overdue_int=trim($row['b_overdue_int']);
$b_principal=trim($row['b_principal']);
$total=$b_due_int+$b_overdue_int+$b_principal;
echo "<tr>";
echo "<th bgcolor=$color>".$row['entry_time']."</th>";
echo "<th bgcolor=$color>".$row['account_no']."</th>";
$customer_id=getCustomerNameFromKCCAccount($account_no);
$name=getCustomerName($customer_id);
echo "<th bgcolor=$color>$name</th>";
echo "<th bgcolor=$color>0</th>";
echo "<th bgcolor=$color>".$row['r_total_amount']."</th>";
echo "<th bgcolor=$color>".$row['b_due_int']."</th>";
echo "<th bgcolor=$color>".$row['b_overdue_int']."</th>";
echo "<th bgcolor=$color>".$row['b_principal']."</th>";
echo "<th bgcolor=$color>$total</th>";
echo "<th bgcolor=$color>0</th>";
echo "<th bgcolor=$color>0</th>";
echo "<th bgcolor=$color>".$row['staff_id']."</th>";

}
}

echo "</table>";


}
//--------------------daily kcc loan issued list---------------------
if($statement==di)
{
echo "<table bgcolor=\"silver\" width=\"120%\" align=\"center\">";
$color="#CCCC0000";
echo "<tr>";
echo "<th colspan=\"12\" bgcolor=\"green\"><font color=WHITE size=\"4\" align=\"center\">Daily KCC Loan Issued List--Date:";
echo "<tr>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">Time</th>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">KCC A/C No.</th>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">Name</th>";
echo "<th colspan=\"2\" bgcolor=\"$color\">ISSUE</th>";
echo "<th colspan=\"3\" bgcolor=\"$color\">Previous Balance</th>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">Total Balance</th>";
//echo "<th rowspan=\"2\" bgcolor=\"$color\">Total Balance</th>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">Area of Land/Satak</th>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">Due Days</th>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">Operator Name</th>";
echo "<tr>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Crop</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Amount(Rs.)</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Due</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Overdue</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Principal</th>";
$sql_statement="SELECT * FROM loan_issue_dtl WHERE action_date=current_date";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0){
echo "<tr>";
echo "<th colspan=\"14\"><font color=green size=5><blink>!!! Today there is no New Customer !!!</blink></font></th>";
}
else
{
$color=$TCOLOR;
for($j=0; $j<=pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
$account_no=trim($row['account_no']);
echo "<tr>";
echo "<th bgcolor=$color>".$row['entry_time']."</th>";
echo "<th bgcolor=$color>".$row['account_no']."</th>";
$customer_id=getCustomerNameFromKCCAccount($account_no);
$name=getCustomerName($customer_id);
echo "<th bgcolor=$color>$name</th>";
echo "<th bgcolor=$color>0</th>";
echo "<th bgcolor=$color>".$row['loan_amount']."</th>";
$sql_statement2="SELECT * FROM loan_return_dtl WHERE account_no='$account_no'";
$result2=dBConnect($sql_statement2);
if(pg_NumRows($result2)>0){
$b_due_int=pg_result($result2,'b_due_int');
$b_overdue_int=pg_result($result2,'b_overdue_int');
$b_principal=pg_result($result2,'b_principal');
$b_total=$b_due_int+$b_overdue_int+$b_principal;
echo "<th bgcolor=$color>$b_due_int</th>";
echo "<th bgcolor=$color>$b_overdue_int</th>";
echo "<th bgcolor=$color>$b_principal</th>";
echo "<th bgcolor=$color>$b_total</th>";
}
echo "<th bgcolor=$color>0</th>";
echo "<th bgcolor=$color>0</th>";
echo "<th bgcolor=$color>".$row['staff_id']."</th>";

 }
}
echo "</table>";


}
//----------------------------------yearly report of farmer and ccb--------------------------
if($statement==yearlyreport)
{
//echo "sujoy";

//-------------------------from ccb-----------------------
echo "<table bgcolor=\"white\" width=40% align=left>";
$color="#CCCC0000";
echo "<tr>";
echo "<th colspan=\"4\" bgcolor=\"green\"><font color=WHITE size=\"4\" align=\"center\">Previous Year Due From CCB";
echo "<tr>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">Principal</th>";
echo "<th colspan=\"2\" bgcolor=\"$color\">Interest</th>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">Total Due</th>";
echo "<tr>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Due</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Overdue</th>";
echo "</table>";
//-------------------------from farmer--------------------------
echo "<table bgcolor=\"white\" width=40% align=right>";
$color="#CCCC0000";
echo "<tr>";
echo "<th colspan=\"6\" bgcolor=\"green\"><font color=WHITE size=\"4\" align=\"center\">Previous Year Due Balance From Farmer";
echo "<tr>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">Principal</th>";
echo "<th colspan=\"2\" bgcolor=\"$color\">Due</th>";
echo "<th colspan=\"2\" bgcolor=\"$color\">Overdue</th>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">Total Due</th>";
echo "<tr>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Interest(Rs.)</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">No of Farmer</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Interest(Rs.)</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">No of Farmer</th>";
echo "</table>";
//--------------------------yearly report---------------------


echo "<table bgcolor=\"white\" width=140% align=left>";
$color="#CCCC0000";
echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"green\"><font color=WHITE size=\"4\" align=\"center\">Year</font></th>";
echo "<th colspan=\"7\" bgcolor=\"green\"><font color=WHITE size=\"4\" align=\"center\">KCC Loan Relatation, Society with Central Co-operative Bank</font></th>";
echo "<th rowspan=\"2\" bgcolor=\"green\"><font color=WHITE size=\"4\" align=\"center\">Own Fund</font></th>";
echo "<th colspan=\"8\" bgcolor=\"green\"><font color=WHITE size=\"4\" align=\"center\">KCC Loan Relatation,Society with Farmer</font></th>";
echo "<tr>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">yearly</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Society taken from CCB(Rs.)</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Interested Calculated(%)</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Society Paid Principal to CCB(Rs.)</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Society Paid due interest to CCB(Rs.)</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Society Paid Overdue interest to CCB(Rs.)</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Total Deposit to CCB(Rs.)</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Balance(Rs.)</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">No of Farmer Taken Loan</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Total Loan given to Farmer</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Interest Calculated(%)</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Received Principal from Farmer</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Received due interest from farmer</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Received overdue interest from farmer</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Total collection from farmer</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Balance(Rs.)</th>";
$color="silver";
echo "<tr>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">April</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">0</th>";
echo "<tr>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">May</th>";
echo "</table>";
}
if($statement==dcbs)
{
echo "sujoy";
echo "<table bgcolor=\"white\" width=\"140%\" align=\"center\">";
$color="#CCCC0000";
echo "<tr>";
echo "<th colspan=\"15\" bgcolor=\"green\"><font color=WHITE size=\"4\" align=\"center\">Demand Collection and Balance Statement";
echo "<tr>";
echo "<th rowspan=\"3\" bgcolor=\"$color\">Serial No.</th>";
echo "<th rowspan=\"3\" bgcolor=\"$color\">Type of Loan</th>";
echo "<th colspan=\"6\" bgcolor=\"$color\">Principal</th>";
echo "<th rowspan=\"3\" bgcolor=\"$color\">Percentage of collection to Demand under principal</th>";
echo "<th colspan=\"6\" bgcolor=\"$color\">Interest</th>";
echo "<tr>";
echo "<th colspan=\"3\" bgcolor=\"$color\">Demand</th>";
echo "<th colspan=\"2\" bgcolor=\"$color\">Collection</th>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">Balance</th>";
echo "<th colspan=\"3\" bgcolor=\"$color\">Demand</th>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">Total Collection</th>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">Of which repaid<br> in advance</th>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">Balance</th>";
echo "<tr>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Arrears</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Current(including)<br>advance repayment)</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Total</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Total</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Of which repaid <br>in advance</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Arrears</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Current</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Total</th>";


echo "</table>";
}
echo "</body>";
echo "</html>";
?>
