<?php

include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
echo "<html>";
echo "<head>";
echo "<title>  Customer List Between Date";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
//echo "sujoy";
$sql_statement="SELECT customer_kcc.customer_id, customer_kcc.ACCOUNT_NO, customer_kcc.NAME1,address,sum(kcc_op_bal_entry.due_principal) FROM CUSTOMER_KCC  LEFT OUTER JOIN KCC_op_bal_entry on customer_kcc.account_no=kcc_op_bal_entry.account_no group by customer_kcc.customer_id, customer_kcc.ACCOUNT_NO, customer_kcc.NAME1,address";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<center>";
echo "<h4><font size=5 color=green><blink> Please Enter KCC Details!!!</blink></font></h4>";
echo "</center>";
} 
else
{
echo "<table width=\"100%\">";

echo "<tr><td bgcolor=\"green\" colspan=\"5\" align=\"center\"><font color=\"white\"><b>KCC ACCOUNT LIST</b></font>";
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color>KCC Id</th>";
echo "<th bgcolor=$color rowspan=\"1\">Customer Id</th>";
echo "<th bgcolor=$color rowspan=\"1\">Due Principal</th>";
echo "<th bgcolor=$color rowspan=\"1\">Name</th>";
echo "<th bgcolor=$color rowspan=\"1\">Address</th>";
for($j=0; $j<pg_NumRows($result); $j++) 
{
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	echo "<tr>";
	echo "<td align=right bgcolor=$color><a href=\"../kcc/due_overdue.php?menu=kcc&account_no=".$row['account_no']."\" target=\"_blank\">".$row['account_no']."</a></td>";
	echo "<td align=right bgcolor=$color>".$row['customer_id']."</td>";
	
	echo "<td align=right bgcolor=$color>".$row['sum']."</td>";
	echo "<td align=right bgcolor=$color>".$row['name1']."</td>";
	echo "<td align=right bgcolor=$color>".$row['address']."</td>";
	
}
echo "<tr>";
$color="cyan";
echo "<td align=center bgcolor=$color colspan=\"9\"><b>Total:  $j Account  !!!!!!</b></td>";
echo "</table>";
}
echo "</body>";
echo "</html>";


?>
