<?
include "../config/config.php";
$staff_id==verifyAutho();
$menu=$_REQUEST['menu'];
$title=strtoupper($menu);

echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
$sql_statement="SELECT * FROM provissional_interest WHERE trim(deposit_type)='$menu'";
$result=dBConnect($sql_statement);
//echo $sql_statement; 
if(pg_NumRows($result)==0){
   echo "<br><font size=+3 color=\"RED\"><b>Account Not available at Present</font>";
} else {
$color=$TCOLOR;
for($j=0; $j<pg_NumRows($result); $j++){
	echo "<table width=\"100%\">";
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
        echo "<tr>";
	$account=$row['account_no'];
	echo "<td align=right bgcolor=$color width=\"63\" align=\"center\">".$account."</td>";
	
	echo "<td bgcolor=$color width=\"98\">".$row['cetificate_no']."</td>";
	
	echo "<td bgcolor=$color width=\"452\" align=\"\">".ucwords($row['name'])."</td>";
	//echo "<td align=right bgcolor=$color width=\"108\">".amount2Rs($row['principal'])."</td>";
	//echo "<td align=right bgcolor=$color width=\"108\">".$row['principal']."</td>";
	//echo "<td align=right bgcolor=$color width=\"145\">".$row['maturity_date']."</td>";
	echo "<td align=right bgcolor=$color width=\"100\">".amount2Rs($row['interest'])."</td>";
	}
}
echo "</table>";
echo "</body>";
echo "</html>";
?>
