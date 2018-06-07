<?
include "../../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
echo "<html>";
echo "<head>";
echo "<title>  Customer List Between Date";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../../css/test.css\" />";

echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<hr>";
$sql_statement="SELECT * FROM customer_master WHERE customer_id like '%C-%'  order by cast(substr(customer_id,2,length(customer_id)) as int) DESC";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<center>";
echo "<h4><font size=5 color=green><blink> Please Enter Customer Details!!!</blink></font></h4>";
echo "</center>";
} else {
echo "<table width=\"100%\">";
echo "<tr><td bgcolor=\"green\" colspan=\"10\" align=\"center\"><font color=\"white\"><b>CUSTOMER ACCOUNT LIST</b></font>";
// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color>Customer Id.</th>";
echo "<th bgcolor=$color colspan=\"1\">Name</th>";
echo "<th bgcolor=$color colspan=\"1\">Father Name</th>";
echo "<th bgcolor=$color colspan=\"3\">Address</th>";
echo "<th bgcolor=$color colspan=\"1\">Contact No</th>";
echo "<th bgcolor=$color colspan=\"1\">Opening Date</th>";
echo "<th bgcolor=$color colspan=\"1\">Voter Id</th>";
echo "<th bgcolor=$color colspan=\"1\">Operator code</th>";
echo "<th bgcolor=$color colspan=\"1\">Details</th>";

for($j=0; $j<pg_NumRows($result); $j++) 
{
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	echo "<tr>";
	echo "<td bgcolor=$color><a href=\"../customer_statement.php?menu=$menu&id=".$row['customer_id']."\" target=\"_blank\">".$row['customer_id']."</a></td>";
	echo "<td bgcolor=$color>".ucwords($row['name1'])."</td>";
	echo "<td bgcolor=$color>".ucwords($row['father_name1'])."</td>";
	echo "<td bgcolor=$color>".ucwords($row['address11'])."</td>";
	echo "<td bgcolor=$color>".ucwords($row['address12'])."</td>";
	echo "<td bgcolor=$color>".ucwords($row['address13'])."</td>";
	echo "<td bgcolor=$color>".$row['telephone1']."</td>";
	echo "<td align=Center bgcolor=$color>".$row['date_of_opening']."</td>";
	echo "<td align=center bgcolor=$color>".$row['voter_id_no1']."</td>";
	echo "<td align=center bgcolor=$color>".$row['operator_code']."</td>";
	echo "<td align=center bgcolor=$color><a href=\"../../main/set_account.php?menu=cust&account_no=".$row['customer_id']."\" target=\"parent\">Show</td>";
}
echo "<tr>";
$color="cyan";
echo "<td align=center bgcolor=$color colspan=\"10\"><b>Total:  $j Account  !!!!!!</b></td>";
echo "</table>";
}
echo "</body>";
echo "</html>";
?>
