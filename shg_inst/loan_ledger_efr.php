<?
include "../config/config.php";
$staff_id=verifyAutho();
$group_no=$_SESSION["current_account_no"];
$c_id=getCustomerIdFromGroupId($group_no);
$menu=$_REQUEST['menu'];
isPermissible($menu);
echo "<html>";
echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
?>
<script language="javascript">
function varify(){
//alert(document.parent.loan_no.value.length)
if(document.parent.action_date.value.length==0){
 alert('You must select Repayment Date')
 document.parent.action_date.focus();
 return false;
  }
if(document.parent.loan_no.value.length==0){
 alert('You Dont Select any Loan Account')
 document.parent.loan_no.focus();
 return false;
  }
}
</script>
<?
echo "</head>";
echo "<body bgcolor=\"silver\">";
$sql_statement="SELECT account_no FROM shg_account WHERE shg_no='$group_no' AND account_type='sgl' AND status='op' AND account_opening_date <=current_date";  
//echo $sql_statement;
$flag=getGeneralInfo_Customer($c_id);
if($flag==1){
echo "<hr>";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0)
{
 echo "<h1><b><font color=Red><center><Blink>You Have not Any Loan At Present !!!!</blink></center></font></h1>";
  echo "<center>You Dont Applied any Loan....";
  }
else{
echo "<form method=\"POST\" name=\"parent\" action=\"loan_repayment.php?menu=$menu\" onSubmit=\"return varify();\">";
echo "<table bgcolor=AQUA align=CENTER width=80%>";
echo "<tr><th colspan=5 bgcolor=orange><font size=+2><b>Loan Repayment Voucher";
echo "<tr><td align=\"left\"><b>Action Date:<td><input type=\"TEXT\" name=\"action_date\" size=\"10\" value=\"".date('d/m/Y')."\" $HIGHLIGHT><br>";
echo "<td align=\"left\"><b>Loan Account No:<td><Select name=\"loan_no\" id=\"s1\"><option></option>";
for($j=0;$j<pg_NumRows($result);$j++){
  $row=pg_fetch_array($result,$j);
  echo "<b><option value=\"".$row['account_no']."\">".$row['account_no'];
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
