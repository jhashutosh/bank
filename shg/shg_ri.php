<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
echo "<html>";
echo "<head>";
echo "<title>Ri List";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<body bgcolor=\"silver\">";
echo "<h1>Re Investment Deposit Information Of SHG</h1>";
echo "<hr>";
$sql_statement="select * from deposit_info di,customer_shg_ac sa where sa.account_no=di.account_no and sa.account_type='ri'";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4><font color=\"red\">Data Not Found !!!!!!!!</font></h4>";
} 
else {
echo "<table  bgcolor=\"black\" align=\"center\" width=\"100%\">";
echo "<tr><td bgcolor=\"green\" colspan=\"7\" align=\"center\"><font color=\"white\">List Of Re-Investment Of SHG</font>";
// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color >Customer Id</th>";
echo "<th bgcolor=$color >Group No</th>";
echo "<th bgcolor=$color >Account no.</th>";
echo "<th bgcolor=$color >Opening Date</th>";
echo "<th bgcolor=$color >Deposited Amount</th>";
echo "<th bgcolor=$color >Maturity Date</th>";
echo "<th bgcolor=$color >Maturity Amount</th>";
echo "</tr>";
for($j=1;$j<=pg_NumRows($result);$j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,($j-1));
echo "<tr>";
echo "<td align=right bgcolor=$color><a href=\"../main/set_account.php?menu=cust&account_no=".$row['customer_id']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes,top=100,left=150, width=1050,height=500'); return false;\">".$row['customer_id']."</a></td>";
echo "<td align=right bgcolor=$color>".$row['shg_no']."</td>";
echo "<td align=right bgcolor=$color><a href=\"../main/pop_up_account.php?menu=ri&account_no=".$row['account_no']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes,top=100,left=150, width=1050,height=500'); return false;\">".$row['account_no']."</a></td>";
echo "<td align=right bgcolor=$color>".$row['account_opening_date']."</td>";
echo "<td align=right bgcolor=$color>".amount2Rs($row['principal'])."</td>";
echo "<td align=right bgcolor=$color>".$row['maturity_date']."</td>";
echo "<td align=right bgcolor=$color>".amount2Rs($row['maturity_amount'])."</td>";
$total_amt=$total_amt+$row['principal'];
$total_amt1=$total_amt1+$row['maturity_amount'];
}
echo "<tr>";
$color="cyan";
echo "<td align=center bgcolor=$color colspan=\"4\"><B>Total Account:$i </B></td>";
//echo "<td align=right bgcolor=$color><B></B></td>";
//echo "<td align=right bgcolor=$color><B></B></td>";
echo "<td align=right bgcolor=$color><B>".amount2Rs($total_amt)."</B></td>";
echo "<td align=right bgcolor=$color><B></B></td>";
echo "<td align=right bgcolor=$color><B>".amount2Rs($total_amt1)."</B></td>";
echo "<br>";
echo "</table>";
}

echo "</body>";
echo "</html>";
?>
