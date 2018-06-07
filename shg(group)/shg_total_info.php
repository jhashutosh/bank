<?
include "../config/config.php";
$staff_id=verifyAutho();
echo "<head>";
echo "<title>Shg group List";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<h1>Total Deposit Information Of SHG</h1>";
echo "<hr>";
//----------------------------------------------------------------------
$sql_statement1="SELECT account_no FROM customer_shg_ac WHERE account_type='sb'";
//echo $sql_statement1;
$result=dBConnect($sql_statement1);
if(pg_NumRows($result)==0) {
	echo "<h4><font color=\"red\">Not found!!!</font></h4>";
} else {
echo "<table align=CENTER bgcolor=BLACK width=\"60%\">";
echo "<tr><th bgcolor=\"green\" colspan=\"3\" align=\"\"><font color=\"white\"align=\"center\">Total information of SHG groups</font>";

// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color >Deposit</th>";
echo "<th bgcolor=$color >Amount</th>";
echo "<th bgcolor=$color >No. of Account</th>";
$count1=pg_NumRows($result);
for($j=1; $j<=$count1; $j++) {
$row=pg_fetch_array($result,($j-1));
$total=$total+sb_current_balance($row['account_no']);
}
echo "<tr>";
echo "<td bgcolor=$color>Savings</a></td>";
echo "<td align=right bgcolor= $color>".amount2Rs($total)."</td>";
echo "<td align=right bgcolor=$color>".amount2Rs($count1)."</td>";
}
//------------------------------------------------------------------
$sql_statement2="SELECT account_no FROM customer_shg_ac WHERE account_type='fd'";
$result=dBConnect($sql_statement2);
$count2=pg_NumRows($result);
for($j=1; $j<=$count2; $j++) {
$row=pg_fetch_array($result,($j-1));
$total1+=sb_current_balance($row['account_no']);
}
if(empty($total1)){$total1=0;}
 echo "<tr>";
echo "<td bgcolor=$color>Fixed Deposit</td>";
echo "<td align=right bgcolor= $color>".amount2Rs($total1)."</td>";
echo "<td align=right bgcolor= $color>".amount2Rs($count2)."</td>";
//----------------------------------------------------------------------
$sql_statement3="SELECT account_no FROM customer_shg_ac WHERE account_type='rd'";
//echo $sql_statement3;
$result=dBConnect($sql_statement3);
$count3=pg_NumRows($result);
for($j=1; $j<=$count3; $j++) {
$row=pg_fetch_array($result,($j-1));
$total2+=sb_current_balance($row['account_no']);
}
if(empty($total2)){$total2=0;}
 echo "<tr>";
echo "<td bgcolor=$color>Recurring</a></td>";
echo "<td align=right bgcolor=$color>".amount2Rs($total2)."</td>";
echo "<td align=right bgcolor=$color>".amount2Rs($count3)."</td>";
//---------------------------------------------
$sql_statement4="SELECT account_no FROM customer_shg_ac WHERE account_type='ri'";
$result=dBConnect($sql_statement4);
$count4=pg_NumRows($result);
for($j=1; $j<=$count4; $j++) {
$row=pg_fetch_array($result,($j-1));
$total3=$total3+sb_current_balance($row['account_no']);
}
if(empty($total3)){$total3=0;}
echo "<tr>";
echo  "<td bgcolor=$color>Reinvestment</a></td>";
echo "<td align=right bgcolor=$color>".amount2Rs($total3)."</td>";
echo "<td align=right bgcolor=$color>".amount2Rs($count4)."</td>";
echo "<tr>";
$sum=$total+$total1+$total2+$total3;
$no=$count1+$count2+$count3+$count4;
echo  "<td bgcolor=Aqua>Total:</td>";
echo "<td align=right bgcolor=Aqua>".amount2Rs($sum)."</td>";
echo "<td align=right bgcolor=Aqua>".amount2Rs($no)."</td>";
echo "</table>";
echo "</body>";
echo "</html>";
?>
