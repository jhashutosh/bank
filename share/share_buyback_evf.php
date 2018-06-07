<?php
include "config.php";
// PHP4 

$account_no=$_REQUEST["membership_no"];
$operation=$_REQUEST['operation'];
$menu=$_REQUEST['menu'];
//$current_no_share=$_REQUEST['cns'];
//$current_val_share=$_REQUEST['cvs'];
$action_date=$_REQUEST['action_date'];
//$no_of_share=$_REQUEST['no_of_share'];
//$val_per_share=$_REQUEST['val_per_share'];
$db=pg_pConnect("host=$HOST dbname=$DATABASE");
$result=pg_Exec($db,$DATESTYLE);
//Customization required for WHERE CLAUSE
$sql_statement="SELECT * FROM share_ledger WHERE member_id='$account_no' AND action_date=(SELECT MAX(action_date) from share_ledger where member_id='$account_no') order by entry_time DESC limit 1";
//echo $sql_statement;
$result=pg_Exec($db,$sql_statement);
$current_no_share=pg_result($result,"no_of_share_balance");
$current_val_share=pg_result($result,"value_of_balance");
$current_dividend=pg_result($result,"bal_dividend");
echo "<html>";
echo "<head>";
echo "<title>Statement";
echo "</title>";
echo "</head>";
echo "<body bgcolor=\"silver\">";
$title=$type_of_account1_array[trim($menu)];
echo "<h2>[Share] Withdrawal Ledger";
echo "</h2><hr>";
// Customization required for WHERE CLAUSE
echo "<form method=\"POST\" action=\"withdrawal_eadd.php\"><br>";
echo "<table>";
if($operation=="Share")
{
	if($current_no_share==0)
	{
		echo "<h1><b><font color=Red><center><blink>You have not Any share Currently !!!</blink></b></font></h1>";
		echo "<h3><b><font color=Blue><center>You are currently Holding :$current_no_share share</h3></b></font>";
         }
else{
echo "<tr><td align=\"left\">Membership no:<td><input type=\"TEXT\" name=\"membership_no\" size=\"50\" value=\"$account_no\" readonly><br>";
echo "<tr><td align=\"left\">Action Date:<td><input type=\"TEXT\" name=\"action_date\" size=\"50\" value=\"$action_date\" readonly><br>";
echo "<tr><td align=\"left\">Currently No of Share:<td><input type=\"TEXT\" name=\"cns\" size=\"50\" value=\"$current_no_share\" readonly><br>";
echo "<tr><td align=\"left\">Current balance of Share:<td><input type=\"TEXT\" name=\"cvs\" size=\"50\" value=\"$current_val_share\" readonly><br>";
echo "<tr><td align=\"left\">No of Share:<td><input type=\"TEXT\" name=\"no_of_share\" size=\"50\" value=\"\"> <br>";
echo "<tr><td align=\"left\">Value of per Share:<td><input type=\"TEXT\" name=\"val_per_share\" size=\"50\" value=\"10\" ><br>";
echo "<input type=\"HIDDEN\" name=\"operation\" value=\"$operation\">";
echo "<tr><td><td align=\"right\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Submit\">";
   }
}

else
 {
  echo "<tr><td align=\"left\">Membership no:<td><input type=\"TEXT\" name=\"membership_no\" size=\"50\" value=\"$account_no\" readonly><br>";
echo "<tr><td align=\"left\">Action Date:<td><input type=\"TEXT\" name=\"action_date\" size=\"50\" value=\"$action_date\" readonly><br>";
  echo "<tr><td align=\"left\">Current balance of Dividend:<td><input type=\"TEXT\" name=\"cur_div\" size=\"50\" value=\"$current_dividend\" readonly><br>";
  echo "<tr><td align=\"left\">Withdrawal Amount:<td><input type=\"TEXT\" name=\"with_div\" size=\"50\" value=\"0\" ><br>";
  echo "<input type=\"HIDDEN\" name=\"operation\" value=\"$operation\">";
 echo "<tr><td><td align=\"right\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Submit\">";
 }

//echo "  <input type=\"RESET\" name=\"RESET_BUTTON\" value=\"Cancel\"><br>";
echo "</table>";
echo "</form>";
footer();
echo "</body>";
echo "</html>";




?>
