<?
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
echo "<html>";
echo "<head>";
echo "<title>SHG List";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<body bgcolor=\"silver\">";
echo "<h1>Member Information Of SHG</h1>";
echo "<hr>";
$sql_statement="SELECT * FROM customer_master WHERE type_of_customer like 'SHG-%' order by name1";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4><font color=\"red\">Data Not Found !!!!!!!!</font></h4>";
} 
else {
echo "<table  bgcolor=\"black\" align=\"center\" width=\"100%\">";
echo "<tr><td bgcolor=\"green\" colspan=\"5\" align=\"center\"><font color=\"white\">SHG Member List</font>";
// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color >Customer Id</th>";
echo "<th bgcolor=$color >Customer Type</th>";
echo "<th bgcolor=$color >Name</th>";
echo "<th bgcolor=$color >Sex</th>";
echo "<th bgcolor=$color >Father Name</th>";
echo "</tr>";
for($j=1;$j<=pg_NumRows($result);$j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,($j-1));
echo "<tr>";
echo "<td align=right bgcolor=$color>".$row['customer_id']."</td>";
echo "<td align=right bgcolor=$color>".$row['type_of_customer']."</td>";
echo "<td align=right bgcolor=$color>".$row['name1']."</td>";
echo "<td align=right bgcolor=$color>".$row['sex1']."</td>";
echo "<td align=right bgcolor=$color>".$row['father_name1']."</td>";

}
echo "<tr>";
$color="cyan";
echo "<td align=center bgcolor=$color colspan=\"5\"><B>Total Account:".($j-1)." </B></td>";

echo "<br>";
echo "</table>";
}

echo "</body>";
echo "</html>";
?>
