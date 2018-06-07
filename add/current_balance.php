<?
include "../config/config.php";

$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$operator_code=$staff_id;
$starting_date=$_REQUEST["starting_date"];
$ending_date=$_REQUEST["ending_date"];
if( empty($starting_date) ) { $starting_date=date("d/m/Y",time()-604800); }
if( empty($ending_date) ) { $ending_date=date("d/m/Y"); }
echo "<html>";
echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script language=\"JAVASCRIPT\">";
echo "function closeme() 
{ 
close(); 
}";
echo "</script>";
echo "<form>";
echo "<table align=center bgcolor=\"#90EE90\" width=\"20%\">";
echo "<tr>";
echo "<td align=\"right\">";
echo "<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close me\" onclick=\"closeme()\">";
echo "</td>";
echo "<td>";
echo "<input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print me\" onclick=\"window.print()\"> ";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "</form>";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"id.focus();\">";
$sql_statement="SELECT m.customer_id,m.name1,m.address11||' '||m.address12||' '||m.address13 as address,f.* FROM customer_master m,customer_account a, (SELECT account_no,SUM(given)as given,SUM(back)as back,SUM(given-back) as balance, CASE WHEN SUM(given-back)>0 THEN 'Dr.' ELSE 'Cr.' END AS DR_CR FROM advance_ledger where action_date <=CURRENT_DATE GROUP BY account_no) as f
WHERE m.customer_id=a.customer_id AND f.account_no=a.account_no";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_num_rows($result)<1) {
echo "<h4>No Record or ERROR!!!</h4>";
} else {
//echo "<font color=#000080 size=+2><I><b>Material Master Details</b></I></font>";
echo "<hr>";
echo "<table>";
}
echo "<table valign=\"top\" width=\"100%\" BGCOLOR=\"BLACK\" align=\"center\">";
$color=$TCOLOR;
echo "<tr><td bgcolor=\"GREEN\" colspan=\"7\" align=\"center\"><font color=\"white\" size=5><b>Advance Module Balance</b></font>";
echo "<tr>";
echo "<th bgcolor=$color>Customer Id</th>";
echo "<th bgcolor=$color>Account No</th>";
echo "<th bgcolor=$color>Name</th>";
echo "<th bgcolor=$color>Address</th>";
echo "<th bgcolor=$color>Given</th>";
echo "<th bgcolor=$color>Back</th>";
echo "<th bgcolor=$color>Balance</th>";
//echo "<th bgcolor=$color>Oeration</th>";

for($j=1; $j<=pg_NumRows($result); $j++) {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j-1));
echo "<tr>";

echo "<td align=center bgcolor=$color>".$row['customer_id']."</td>";
echo "<td align=center bgcolor=$color>".$row['account_no']."</td>";
echo "<td align=center bgcolor=$color>".ucwords($row['name1'])."</td>";
echo "<td align=center bgcolor=$color>".ucwords($row['address'])."</td>";
echo "<td align=right bgcolor=$color>".amount2Rs($row['given'])."</td>";
echo "<td align=right bgcolor=$color>".amount2Rs($row['back'])."</td>";
if($row['balance']>0){$DR_CR='Cr.';}
else{$DR_CR='Dr.';}
echo "<td align=right bgcolor=$color>".amount2Rs($row['balance'])."</td>";
$t_amount+=$row[2];
$total=$total+$row['balance'];
//echo "<td align=center bgcolor=$color><A HREF=\"payment.php?id=".$row[0]."&name=".$row[1]."&p=".$row[2]."\">payment</a> </td>";
}
echo "<tr>";
$color="cyan";
echo "<td align=center bgcolor=$color colspan=\"2\"><B>Total:".($j-1)." Items Found !!!!!!!!</B></td>";
echo "<td align=center bgcolor=$color colspan=\"1\"></td>";
echo "<td align=center bgcolor=$color colspan=\"1\"></td>";
echo "<td align=center bgcolor=$color colspan=\"1\"></td>";
echo "<td align=center bgcolor=$color colspan=\"1\"><B></B>$t_amount</td>";
echo "<td align=center bgcolor=$color colspan=\"1\">$total</td>";
echo "</table>";
echo "</body>";
echo "</html>";
?>
