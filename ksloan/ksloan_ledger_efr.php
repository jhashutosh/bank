<?
include "../config/config.php";
$staff_id=verifyAutho();
$account_no=$_SESSION["current_account_no"];
//$c_id=getCustomerIdFromGroupId($group_no);
$menu=$_REQUEST['menu'];
isPermissible($menu);
echo "<html>";
echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";


$c_id=getCustomerId($account_no,$menu);
$flag=getGeneralInfo_Customer($c_id);
if($flag==1){
echo "<hr>";
$db=pg_pConnect("host=$HOST dbname=$DATABASE");
$result=pg_Exec($db,$DATESTYLE);
$sql_statement="SELECT * FROM loan_issue_dtl";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0)
{
 echo "<h1><b><font color=Red><center><Blink>You Have not Any Loan At Present !!!!</blink></center></font></h1>";
  echo "<center>You Dont Applied any Loan....";
  }
else
{
echo "<form method=\"POST\" action=\"loan_ledger_evfr.php?menu=$menu\">";
echo "<table bgcolor=AQUA align=CENTER width=80%>";
echo "<tr><th colspan=5 bgcolor=BLUE><font size=+2><b>Loan Repayment Voucher";

echo "<tr><td align=\"left\">Transaction Date:<td><input type=\"TEXT\" name=\"action_date\" size=\"10\" value=\"".date('d.m.Y')."\"$HIGHLIGHT><br>";
echo "<td align=\"left\">Loan Account No:<td><Select name=\"loan_no\"><option>select</option>";
for($j=0;$j<pg_NumRows($result);$j++){
  $row=pg_fetch_array($result,$j);
  echo "<option>".$row['account_no'];
  echo "</option>";}
echo "</select>";  
echo "<td align=\"right\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Enter\">";
echo "</table>";
echo "</form>";
  }
}
echo "</body>";
echo "</html>";
?>
