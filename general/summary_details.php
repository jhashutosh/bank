<?
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST["menu"];
$dt=$_REQUEST['dt'];
$starting_date=$_REQUEST["st_dt"];
$ending_date=$_REQUEST["en_dt"];
//echo "Menu".$menu;
if(trim($menu)=='ri'){$sql_statement="SELECT account_no,certificate_no,amount_deposit as deposit, amount_withdraw as withdrawal from ri_ledger where action_date='$dt' order by action_date";
$title="Reinvestment Deopsit";
$f=1;}
if($menu=='fd'){$sql_statement="SELECT account_no,certificate_no,amount_deposit as deposit, withdrawal_amount as withdrawal from fd_ledger where opening_date='$dt' order by opening_date";
 $title="Fixed Deopsit";
$f=1;}
if($menu=='rd'){$sql_statement="SELECT * from rd_summary3 where action_date='$dt' order by action_date";$title="Recurring Deopsit";
//$f=0;
//echo $sql_statement;
}
echo "<html>";
echo "<head>";
echo "<title>";
echo "</title>";
echo "<body bgcolor=pink>";
echo "<h1> <center>Details of $title on $dt";
echo "</h1>";
echo "<hr color=RED>";
//echo "<form method=\"post\" action= \"sb_summary.php\">";
//echo "<h3>SB DETAILS STATEMENT ACCORDING TO ACCOUNT NUMBER";
//echo "</h3>";
//
//echo " and <input type=\"TEXT\" name=\"ending_date\" size=\"15\" value=\"$ending_date\">";
//echo  "<input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Submit\">";
$db=pg_pConnect("host=$HOST dbname=$DATABASE");
$result=pg_Exec($db,$DATESTYLE);
//$sql_statement="SELECT * FROM sb_detail_summary WHERE action_date BETWEEN '$starting_date' AND '$ending_date' ORDER BY action_date LIMIT $limit_entry OFFSET $off_set";
$result=pg_Exec($db,$sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4>Not found!!!</h4>";
} else {
echo "<table cellspacing=\"0\" border=\"solid\" align=\"center\">";
if($f==1){
echo "<tr><td bgcolor=\"green\" colspan=\"4\" align=\"center\"><font color=\"white\">Detail statement on $dt</font>";}
else
{
 echo "<tr><td bgcolor=\"green\" colspan=\"3\" align=\"center\"><font color=\"white\">Detail statement on $dt</font>";
}

// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
//echo "<th bgcolor=$color>Date</th>";
echo "<th bgcolor=$color>Account no</th>";
if($f==1){echo "<th bgcolor=$color>Certificate no</th>";}
echo "<th bgcolor=$color>Withdrawals (Rs.)</th>";
echo "<th bgcolor=$color>Deposits (Rs.)</th>";
//echo "<th bgcolor=$color>Balance (Rs.)</th>";
for($j=1; $j<=pg_NumRows($result); $j++) {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j-1));
echo "<tr>";
//cho "<td align=right bgcolor=$color>".$row['action_date']."</td>";
echo "<td align=right bgcolor=$color>".$row['account_no']."</td>";
if($f==1){echo "<td align=right bgcolor=$color>".$row['certificate_no']."</td>";}
if($row['withdrawal']==$WITHDRAWALS_DEFAULT){$row['withdrawal']=0;}
echo "<td align=right bgcolor=$color>".$row['withdrawal']."</td>";
if($row['deposit']==$DEPOSITS_DEFAULT){$row['deposit']=0;}
echo "<td align=right bgcolor=$color>".$row['deposit']."</td>";
//echo "<td align=right bgcolor=$color>".$row['balance']."</td>";

$total_withdrawals=$total_withdrawals+$row['withdrawal'];
$total_deposits=$total_deposits+$row['deposit'];
//$total_balance=$total_balance+$row['balance'];

}
echo "<tr>";
$color="cyan";
if($f==1){echo "<td align=center bgcolor=$color colspan=2><B>Total :".($j-1)."</B></td>";}
else{echo "<td align=center bgcolor=$color><B>Total :".($j-1)."</B></td>";}
//echo "<td align=right bgcolor=$color></td>";
echo "<td align=right bgcolor=$color><B>$total_withdrawals</B></td>";
echo "<td align=right bgcolor=$color><B>$total_deposits</B></td>";
//echo "<td align=right bgcolor=$color><B>$total_balance</B></td>";

echo "</table>";
}
echo "<A HREF=\"date_between_details.php?starting_date=$starting_date&ending_date=$ending_date&menu=$menu\"><font size=+2>Pevious Page</a></font>";
echo "</form>";
echo "</body>";
echo "</html>";
?>
