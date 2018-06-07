<?
include "../config/config.php";
$menu=$_REQUEST['menu'];
$account_no=strtoupper($_REQUEST["account_no"]);
$starting_date=$_REQUEST["starting_date"];
$ending_date=$_REQUEST["ending_date"];
$date1=date('l dS \of F Y h:i:s A');
if( empty($starting_date) ) { $starting_date=date("d/m/Y",time()-604800); }
if( empty($ending_date) ) { $ending_date=date("d/m/Y"); }

echo "<html>";
echo "<head>";
echo "<title>$PROJECT_TITLE</title>";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "<script language=\"JAVASCRIPT\">";
echo "function closeme() { close(); }";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"cd.focus();\">";
echo "<font size=+2>$SYSTEM_TITLE</font><br>";
//echo "<i><font color=blue>Welcome to scrolling System of $name</i>";
echo "<hr>";
echo "<form method=\"POST\" action=\"sb_statement_datewise.php?menu=$menu\" method=\"POST\" name=f1>";
echo "<table align=center bgcolor=\"#90EE90\"><tr><td  align=\"\"><b>A/C No:<td><input type=TEXT size=12 name=account_no id=cd value=\"$account_no\" $HIGHLIGHT>";
echo "&nbsp<b>Between Date:<input type=\"TEXT\" name=\"starting_date\" size=\"9\" value=\"$starting_date\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.starting_date,'dd/mm/yyyy','Choose Date')\">";
echo " And <input type=\"TEXT\" name=\"ending_date\" size=\"9\" value=\"$ending_date\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.ending_date,'dd/mm/yyyy','Choose Date')\">";
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "</form>";


echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> ";
echo "</table>";
echo "<hr>";
if(!empty($account_no)){
$id=getCustomerId($account_no,$menu);
$flag=getGeneralInfo_Customer($id);
if($flag==1)
{
//$gl_code=getGlCode4mCustomerAccount($account_no);
$sql_statement="SELECT * FROM sb_detail_view WHERE account_no='$account_no' AND action_date BETWEEN '$starting_date' AND '$ending_date' ORDER BY entry_time DESC";
//echo $sql_statement;
// ledger

$result=dBConnect($sql_statement);
if (pg_NumRows($result)>0){
$balance=sb_current_balance($account_no,$ending_date);
echo "<table valign=\"top\" width=\"100%\">";
echo "<tr><td bgcolor=\"green\" colspan=\"13\" align=\"center\"><font color=\"white\">Statement</font>";
// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color>Transaction Id</th>";
echo "<th bgcolor=$color>Date</th>";
echo "<th bgcolor=$color>Particulars</th>";
echo "<th bgcolor=$color>Withdrawals (Rs.)</th>";
echo "<th bgcolor=$color>Deposits (Rs.)</th>";
echo "<th bgcolor=$color>Balance (Rs.)</th>";
echo "<th bgcolor=$color>Remarks</th>";
echo "<th bgcolor=$color>Operator code</th>";
echo "<th bgcolor=$color>Entry time</th>";
for($j=1; $j<=pg_NumRows($result); $j++){
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j-1));
if(trim($row['dr_cr'])=='Cr'){
       $deposits=(float)$row['amount'];
       $withdrawals=0;
}
else {
       $deposits=0;
       $withdrawals=(float)$row['amount'];
}
echo "<tr>";
echo "<td align=right bgcolor=$color>".$row['tran_id']."</td>";
echo "<td align=right bgcolor=$color>".$row['action_date']."</td>";
echo "<td align=right bgcolor=$color>".$row['particulars']."</td>";
echo "<td align=right bgcolor=$color>".$withdrawals."</td>";
echo "<td align=right bgcolor=$color>".$deposits."</td>";
echo "<td align=right bgcolor=$color>".$balance."</td>";
echo "<td align=right bgcolor=$color>".$row['remarks']."</td>";
echo "<td align=right bgcolor=$color>".$row['operator_code']."</td>";
echo "<td align=right bgcolor=$color>".$row['entry_time']."</td>";
$balance=$balance-$deposits+$withdrawals;
       }
}
else{
echo "new account";
  }
 }
}
echo "</table>";
echo "</body>";
echo "</html>";

?>
