<?
include "../config/config.php";

$staff_id=verifyAutho();
$menu=$_REQUEST["menu"];
$starting_date=$_REQUEST["starting_date"];
$ending_date=$_REQUEST["ending_date"];
$date1=date('l dS \of F Y h:i:s A');
if( empty($starting_date) ) { $starting_date=date("d/m/Y",time()-604600); }
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
echo "<form method=\"POST\" action=\"nregs_int_payable.php?menu=$menu\" method=\"POST\" name=f1>";
echo "<table align=center bgcolor=\"#90EE90\"><tr><td  align=\"\"><b>Between Date:<input type=\"TEXT\" name=\"starting_date\" size=\"9\" value=\"$starting_date\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.starting_date,'dd/mm/yyyy','Choose Date')\" >";
echo " And <input type=\"TEXT\" name=\"ending_date\" size=\"9\" value=\"$ending_date\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.ending_date,'dd/mm/yyyy','Choose Date')\">";
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "</form>";


echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> ";
echo "</table>";
echo "<hr>";

$db=pg_pConnect("host=$HOST dbname=$DATABASE");
$result=pg_Exec($db,$DATESTYLE);
$sql_statement="SELECT account_no, sum(amount) AS total_int FROM sb_detail_view WHERE particulars='int.' and gl_mas_code='14401' AND action_date BETWEEN '$starting_date' AND '$ending_date' GROUP BY account_no ORDER BY cast(substring(account_no,3) as int)";
$result=pg_Exec($db,$sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4>Not found!!!</h4>";
} else {
echo "<table valign=\"top\" width=\"69%\" align=center>";
echo "<tr><td bgcolor=\"red\" colspan=\"3\" align=center><font color=\"white\">Interest Summary between $starting_date &amp; $ending_date</font>";
// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color>Account No.</th>";
echo "<th bgcolor=$color>Total Interest (Rs.)</th>";
echo "<th bgcolor=$color>Current Balance (Rs.)</th>";
$total=0;
for($j=1; $j<=pg_NumRows($result); $j++) {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j-1));
echo "<tr>";
$account_no=$row['account_no'];
echo "<td align=right bgcolor=$color>".$account_no."</td>";
echo "<td align=right bgcolor=$color>".$row['total_int']."</td>";
$cur_val=sb_current_balance($account_no);
$total_cur_val=$total_cur_val+$cur_val;
echo "<td align=right bgcolor=$color>".$cur_val."</td>";
$total=$total+$row['total_int'];
}
echo "<tr>";
$color="cyan";
echo "<td align=center bgcolor=$color><B>Total</B></td>";
echo "<td align=right bgcolor=$color><B>".$total."</B></td>";
echo "<td align=right bgcolor=$color><B>".$total_cur_val."</B></td>";
echo "</table>";
}

footer();

echo "</body>";
echo "</html>";
?>
