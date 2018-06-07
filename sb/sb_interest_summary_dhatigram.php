<?
include "config.php";

$staff_id=verifyAutho();
$menu=$_REQUEST["menu"];
$starting_date=$_REQUEST["starting_date"];
$ending_date=$_REQUEST["ending_date"];
if( empty($starting_date) ) { $starting_date=date("d/m/Y",time()-604600); }
if( empty($ending_date) ) { $ending_date=date("d/m/Y"); }
echo "<html>";
echo "<head>";
echo "<title>Summary Statement for saving bank interest";
echo "</title>";
echo "</head>";
echo "<body bgcolor=\"silver\">";
$title=trim($menu);
echo "<font size=+2 color=GREEN><b>Summary Statement - Interest on savings";
echo "</font><br>";
echo "<i>Here you get all summarised information";
echo "</i><hr>";
echo "<form method=\"POST\" action=\"sb_interest_summary.php\">";
echo "Summary statement of bank between <input type=\"TEXT\" name=\"starting_date\" size=\"15\" value=\"$starting_date\">";
echo " and <input type=\"TEXT\" name=\"ending_date\" size=\"15\" value=\"$ending_date\">";
echo " <input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Show\">";
echo "<br><hr>";
$db=pg_pConnect("host=$HOST dbname=$DATABASE");
$result=pg_Exec($db,$DATESTYLE);
//$sql_statement="SELECT account_no, sum(deposits) AS total_int FROM sb_ledger WHERE 
//particulars='int.' and action_date BETWEEN '$starting_date' AND '$ending_date' and account_no like '%SB%' GROUP BY account_no ORDER BY cast(substring(account_no,3) as int)";
$sql_statement="SELECT account_no,total_int FROM
(
SELECT account_no, sum(deposits) AS total_int FROM sb_ledger WHERE 
particulars='int.' and account_no like '%SB%' and action_date BETWEEN '$starting_date' AND '$ending_date' GROUP BY account_no
union all
select distinct account_no as account_no, 0 as total_int from sb_ledger where account_no 
   not in (SELECT  account_no FROM sb_ledger WHERE 
            particulars='int.'  and account_no like '%SB%' and action_date BETWEEN '$starting_date' AND '$ending_date')
and account_no like '%SB%' and action_date BETWEEN '$starting_date' AND '$ending_date' 
) a ORDER BY cast(substring(account_no,3) as int)";


$result=pg_Exec($db,$sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4>Not found!!!</h4>";
} else {
echo "<table valign=\"top\" width=\"50%\">";
echo "<tr><td bgcolor=\"red\" colspan=\"3\" align=\"center\"><font color=\"white\">Summary statement between $starting_date &amp; $ending_date</font>";
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
echo "<td align=center bgcolor=$color><B>Total: ".($j-1)."</B></td>";
echo "<td align=right bgcolor=$color><B>".$total."</B></td>";
echo "<td align=right bgcolor=$color><B>".$total_cur_val."</B></td>";
echo "</table>";
}

footer();

echo "</body>";
echo "</html>";
?>
