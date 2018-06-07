<?
include "../config/config.php";

$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$operator_code=$staff_id;
$starting_date=$_REQUEST["starting_date"];
$ending_date=$_REQUEST["ending_date"];
if( empty($starting_date) ) { $starting_date=date("d/m/Y",time()-604800); }
if( empty($ending_date) ) { $ending_date=date("d/m/Y"); }
echo "<html>";
echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<font color=\"blue\"><b>$SYSTEM_TITLE</font>";
echo "<font color=\"green\">$date1</font></center><br>";
echo "<font size=+2>Sb Closing A/C Statement";
echo "</font>";
echo "<hr>";
echo "<form method=\"POST\" action=\"sb_current_balance.php?menu=$menu\">";
//echo "Savings Deposit closed account list between <input type=\"TEXT\" name=\"starting_date\" size=\"15\" value=\"$starting_date\" $HIGHLIGHT>";
//echo " and <input type=\"TEXT\" name=\"ending_date\" size=\"15\" value=\"$ending_date\" $HIGHLIGHT>";
//echo " <input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Submit\">";
echo "<br><hr>";

//$db=pg_pConnect("host=$HOST dbname=$DATABASE");
//$result=pg_Exec($db,$DATESTYLE);

$sql_statement1="SELECT master.gl_mas_code,initcap(b.gl_mas_desc) as gl_mas_desc, sum(credit-debit) as bal 
FROM 
( SELECT gl_mas_code,sum(debit) as debit, sum(credit) as credit, sum(credit-debit) as bal from mas_gl_tran as a WHERE action_date<=$ending_date and gl_mas_code::text >= '10000'::text AND gl_mas_code::text <= '19999'::text GROUP BY gl_mas_code ) 
as master,
gl_master_vw as b 
WHERE master.gl_mas_code= b.gl_mas_code and bs_pl='L' GROUP BY master.gl_mas_code,b.gl_mas_desc HAVING master.gl_mas_code<>'12302' and master.gl_mas_code in('14101','14201','14301','14401')";
//$result=pg_Exec($db,$sql_statement);
$result1=dBConnect($sql_statement1);
echo $sql_statement1;
//if(pg_NumRows($result)==0) {
//echo "<h4>Not found!!!</h4>";
//} else {
echo "<table width=\"100%\" align=center>";

echo "<tr><td bgcolor=\"green\" colspan=\"3\" align=\"center\"><font color=\"white\">Saving current balance</font>";


$color=$TCOLOR;

echo "<th  colspan=\"1\">Gl Mas Code</th>";
echo "<th colspan=\"1\">Gl Mas Desc</th>";
echo "<th  colspan=\"1\">Balance</th>";


for($j=0; $j<pg_NumRows($result1); $j++) 
{
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result1,$j);
	echo "<tr>";
	echo "<td align=right bgcolor=$color>".$row[0]."</td>";
	echo "<td align=right bgcolor=$color>".ucwords($row[1])."</td>";
	echo "<td align=right bgcolor=$color>".ucwords($row[2])."</td>";
}
echo "<tr bgcolor=cyan>";
echo "<td colspan=\"6\"><center>Total : <b>$j</b> Records Found!!!!!!!!!!!!!</center></td>";
echo "</table>";
//}

echo "<br>";

echo "</body>";
echo "</html>";
?>
