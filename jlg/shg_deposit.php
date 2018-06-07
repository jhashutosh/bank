<?php
//fd_date wise matured list
include "../config/config.php";
echo "<head>";
echo "<title>Shg group List";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<h3><u><font color =\"red\">Report No.3</h3></u></font>";
echo "<h1> Deposits of SHG groups ";
echo "</h1>";
echo "<hr>";
echo "<form method=\"POST\" action=\"shg_deposit.php\">";
$sql_statement="SELECT account_no FROM shg_accounts_t WHERE account_type='sb'";
//echo $sql_statement;
$result=pg_Exec($db,$sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4><font color=\"red\">Record Not Found!!!!!!</font></h4>";
}
else 
{
	echo "<table  border=\"1\" width=\"80%\">";

echo "<tr><td bgcolor=\"green\" colspan=\"6\" align=\"center\"><font color=\"white\">Deposits of Shg groups</font>";

// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color >Deposit</th>";
echo "<th bgcolor=$color >Amount</th>";
echo "<th bgcolor=$color >No. of group</th>";
$result=pg_Exec($db,$sql_statement);
$count=pg_NumRows($result);
//echo"count=". $count;
for($j=1; $j<=$count; $j++) {
$d=$count;
$row=pg_fetch_array($result,($j-1));
$total=$total+sb_current_balance($row['account_no']);
}
	echo "<tr>";
	echo "<td bgcolor=$color>Savings</a></td>";
	echo "<td align=right bgcolor= $color>$total</td>";
	echo "<td align=right bgcolor=$color>$count</td>";
$sql_statement1="SELECT account_no FROM shg_accounts_t WHERE account_type='fd'";
$result=pg_Exec($db,$sql_statement1);
$count=pg_NumRows($result);
for($j=1; $j<=$count; $j++) {
$row=pg_fetch_array($result,($j-1));
$total1=$total1+fd_deposit_amount($row['account_no']);
}
$d1=$count;
 echo "<tr>";
	echo "<td bgcolor=$color>Fixed Deposit</td>";
	echo "<td align=right bgcolor=$color>$total1</td>";
	echo "<td align=right bgcolor=$color>$count</td>";
$sql_statement2="SELECT account_no FROM shg_accounts_t WHERE account_type='rd'";
$result=pg_Exec($db,$sql_statement2);
$count=pg_NumRows($result);
for($j=1; $j<=$count; $j++) {
$row=pg_fetch_array($result,($j-1));
$total2=$total2+rd_current_balance($row['account_no']);
}
$d2=$count;
  echo "<tr>";
	echo "<td bgcolor=$color>Recurring</a></td>";
	echo "<td align=right bgcolor=$color>$total2</td>";
	echo "<td align=right bgcolor=$color>$count</td>";
$sql_statement3="SELECT account_no FROM shg_accounts_t WHERE account_type='ri'";
$result=pg_Exec($db,$sql_statement3);
$count=pg_NumRows($result);
for($j=1; $j<=$count; $j++) {
$row=pg_fetch_array($result,($j-1));
$total3=$total3+ri_deposit_amount($row['account_no']);
}
$d3=$count;
echo "<tr>";
	echo "<td bgcolor=$color>Reinvestment</a></td>";
	echo "<td align=right bgcolor=$color>$total3</td>";
	echo "<td align=right bgcolor=$color>$count</td>";
echo "<tr>";
echo "<tr>";
$sum=$total+$total1+$total2+$total3;
$color="cyan";
echo "<td align=right bgcolor=$color><B>Total </B></td>";
echo "<td align=right bgcolor=$color><B>$sum </B></td>";
echo "<td align=right bgcolor=$color><B></B></td>";
}
echo "<br>";
echo "</table>";
footor();
echo "</body>";
echo "</html>";
?>
