<?php
include "../config/config.php";
$staff_id=verifyAutho();
$account_no=$_SESSION["current_account_no"];
$menu=$_REQUEST['menu'];
isPermissible($menu);
echo "<html>";
echo "<head>";
echo "<title>Update Form - Reinvestment";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"withdrawal_date.focus();\">";
$id=getCustomerId($account_no,$menu);
$flag=getGeneralInfo_Customer($id);
if($flag==1){
echo "<hr>";
$sql_statement="select * from deposit_info where account_no='$account_no' and  withdrawal_date  is null AND action_date<=current_date";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0){
  echo "<h1><font color=RED align=CENTER><b>Your Account no is Wrong or You don't have any RI !!!!!!!!!</b></h1></font>";
 }
else{
 echo "<form method=\"POST\" action=\"fd_ledger_wvf.php?menu=$menu\">";
 echo "<table bgcolor=#F08080 align=center width=70%>";
 echo "<tr><th colspan=\"4\" bgcolor=Yellow>Withdrawal Form of ".strtoupper($menu)."[$account_no]</th></tr>";
 echo "<tr><td align=\"left\">Account no:<td><input type=\"TEXT\" name=\"account_no\" size=\"15\" value=\"$account_no\" $HIGHLIGHT READONLY><br>";
echo "<td align=\"left\">Withdrawal Date:<td><input type=\"TEXT\" name=\"withdrawal_date\" size=\"12\" id=\"withdrawal_date\" value=\"".date('d.m.Y')."\" $HIGHLIGHT><br>";
 echo "<tr><td align=\"left\">Certificate no:<td><select name=\"certificate_no\"><br>"; 
 for($i=0;$i<pg_NumRows($result);$i++){
  $row=pg_fetch_array($result,$i);
  echo "<option>".$row['certificate_no']."</option>";
  }
  echo "</select>";
//*******************************************PAYMENT MOOD *************************************************/
echo "<td align=\"left\" bgcolor=#F08080>Payment Mood : </td>";
echo "<td><SELECT name=\"pmood\"><option value=\"c\">CASH</option><option value=\"q\">CHEQUE</option><option value=\"y\">Trf to SB</option>";
//********************************************************************************************************/
 echo "<tr><td><td align=\"right\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\" Withdrawal\">";
echo "</table>";
echo "</form>";
 }
}
echo "</body>";
echo "</html>";

?>
