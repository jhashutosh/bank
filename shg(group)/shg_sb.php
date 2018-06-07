<?
include "../config/config.php";
$staff_id=verifyAutho();
echo "<html>";
echo "<head>";
echo "<title>Sb List";
echo "</title>";
echo "</head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<body bgcolor=\"silver\">";
echo "<h1>Saving Deposit Information Of SHG</h1>";
echo "<hr>";
$sql_statement="select * FROM customer_shg_ac where account_type='sb'";

//echo $sql_statement;

$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4><font color=\"red\">Data Not Found</font></h4>";
} 
else 
{
echo "<table  bgcolor=\"black\" align=\"center\" width=\"80%\">";
echo "<tr><th bgcolor=\"green\" colspan=\"6\"><font color=\"white\">SB list of SHG</font>";
// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color >Customr Id</th>";
echo "<th bgcolor=$color >Group No</th>";
echo "<th bgcolor=$color >Group Name</th>";
echo "<th bgcolor=$color >Account no.</th>";
echo "<th bgcolor=$color >Opening Date</th>";
echo "<th bgcolor=$color >Current Balance</th>";
 echo "</tr>";
$i=0;
for($j=1;$j<=pg_NumRows($result);$j++){
$i++;
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,($j-1));
	echo "<tr>";
echo "<td align=right bgcolor=$color><a href=\"../main/set_account.php?menu=cust&account_no=".$row['customer_id']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes,top=100,left=150, width=1050,height=500'); return false;\">".$row['customer_id']."</a></td>";
echo "<td align=right bgcolor=$color>".$row['shg_no']."</td>";
echo "<td align=center bgcolor=$color>".ucwords($row['name1'])."</td>";
echo "<td align=right bgcolor=$color><a href=\"../main/pop_up_account.php?menu=sb&account_no=".$row['account_no']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes,top=100,left=150, width=1050,height=500'); return false;\">".$row['account_no']."</a></td>";
echo "<td align=right bgcolor=$color>".$row['account_opening_date']."</td>";
$temp=sb_current_balance($row['account_no']);
echo "<td align=right bgcolor=$color>".amount2Rs($temp)."</td>";
$total_amt=$total_amt+$temp;
}
echo "<tr>";
$color="cyan";
echo "<td align=center bgcolor=$color colspan=\"5\"><B>Total Account:$i </B></td>";
//echo "<td align=right bgcolor=$color><B></B></td>";
//echo "<td align=right bgcolor=$color><B></B></td>";
//echo "<td align=right bgcolor=$color><B></B></td>";
echo "<td align=right bgcolor=$color><B>".amount2Rs($total_amt)."</B></td>";
echo "<br>";
echo "</table>";
}

echo "</body>";
echo "</html>";
?>
