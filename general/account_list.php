<?php
include "../config/config.php";
$staff_id=verifyAutho();
$op=$_REQUEST['op'];
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
//echo "<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close me\" onclick=\"closeme()\">";
echo "</td>";
echo "<td>";
echo "<input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print me\" onclick=\"print()\"> ";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "</form>";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"id.focus();\">";
$sql_statement="select account_no,name1,father_name1,address11,address12,address13,pin1,telephone1 
from customer_master a,customer_account b where a.customer_id=b.customer_id
and b.account_type='kcc' and status='op' ORDER BY cast(substring(account_no,4) as int) desc";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_num_rows($result)<1) {
echo "<h4>No Record or ERROR!!!</h4>";
} else {
//echo "<font color=#000080 size=+2><I><b>Material Master Details</b></I></font>";
echo "<hr>";
echo "<table>";
}
echo "<table valign=\"top\" width=\"60%\" align=\"center\">";
$color=$TCOLOR;
echo "<tr><td bgcolor=\"GREEN\" colspan=\"4\" align=\"center\"><font color=\"white\" size=5><b>Account List</b></font>";
echo "<tr>";
echo "<th bgcolor=$color>Account No.</th>";
echo "<th bgcolor=$color>Name</th>";
echo "<th bgcolor=$color>Address</th>";
echo "<th bgcolor=$color>Gardian's Name</th>";
for($j=1; $j<=pg_NumRows($result); $j++) {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j-1));
echo "<tr>";
echo "<td align=center bgcolor=$color>".$row[0]."</td>";
echo "<td align=center bgcolor=$color>".ucwords($row[1])."</td>";

//echo "<td align=center bgcolor=$color>".ucwords($row[2])."</td>";
echo "<td align=\"right\" bgcolor=$color>".ucwords($row['address11'])." ".ucwords($row['address12'])." ".ucwords($row['address13'])."</td>";

echo "<td align=center bgcolor=$color>".ucwords($row[2])."</td>";
$t_amount+=$row[4];
}
echo "<tr>";
$color="cyan";
echo "<td align=center bgcolor=$color colspan=\"2\"><B>Total:".($j-1)." Items Found !!!!!!!!</B></td>";
echo "<td align=center bgcolor=$color colspan=\"1\"></td>";
echo "<td align=center bgcolor=$color colspan=\"1\"><B></B></td>";
echo "</table>";
echo "</body>";
echo "</html>";
?>
