<?
include "../config/config.php";
$staff_id=verifyAutho();
$account_no=$_REQUEST['customer_id'];
echo "<html>";
echo "<head>";
echo "<title>Statement";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<center><h3>Land Statement[$account_no]";
echo "</center></h3><hr>";
$sql_statement="SELECT * FROM land_info WHERE customer_id=$account_no";
//echo "$sql_statement";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<center><h1>Information Not Found !!!!!!!!</h1></center>";
}
else {
echo "<table valign=\"top\" width=\"100%\">";
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=GREEN colspan=12>Land Statement[$account_no]</th>";
echo "<tr>";
echo "<th bgcolor=$color Rowspan=\"2\">Land Id</th>";
echo "<th bgcolor=$color Rowspan=\"2\">Action Date</th>";
echo "<th bgcolor=$color Rowspan=\"2\">Dag No.</th>";
echo "<th bgcolor=$color Rowspan=\"2\">Mouja No.</th>";
echo "<th bgcolor=$color Rowspan=\"2\">Khatian No.</th>";
echo "<th bgcolor=$color Rowspan=\"2\">GP</th>";
echo "<th bgcolor=$color Rowspan=\"2\">Mark</th>";
echo "<th bgcolor=$color Rowspan=\"2\">Mini No.</th>";
echo "<th colspan=\"3\" bgcolor=$color>Karbanama</th>";
//echo "<th bgcolor=$color Rowspan=\"2\">Operation</th>";
echo "<tr bgcolor=$color><th>Bond No.</th>";
echo "<th bgcolor=$color>Area</th>";
echo "<th bgcolor=$color>Value</th>";

for($j=0; $j<pg_NumRows($result); $j++){
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
echo "<tr>";
echo "<td align=CENTER bgcolor=$color>".$row['land_id']."</td>";
echo "<td bgcolor=$color>".$row['action_date']."</td>";
echo "<td align=right bgcolor=$color>".$row['dag_no']."</td>";
echo "<td bgcolor=$color>".ucwords($row['mouja_no'])."</td>";
echo "<td align=right bgcolor=$color>".$row['jl_no']."</td>";
echo "<td  bgcolor=$color>".getName('panchayat_id',trim($row['gp']),'panchayat_desc
','panchayat_mas'). "</td>";
echo "<td  bgcolor=$color>".getName('mark_id',trim($row['land_identity']),'mark_desc','land_identification_mas')."</td>";
echo "<td  bgcolor=$color>".getName('mini_id',trim($row['mini_no']),'mini_desc','mini_mas')."</td>";
echo "<td  bgcolor=$color>".$row['karbanama_bond_no']."</td>";
$t_area+=$row['land_area'];
echo "<td align=right bgcolor=$color>".getAcer($row['land_area'])."</td>";
$t_value+=$row['land_value'];
echo "<td align=right bgcolor=$color>".(float)$row['land_value']."</td>";
//echo "<td align=center bgcolor=$color><a href=\"land_ledger_ef.php?menu=ln\">New </a>&nbsp||&nbsp<a href=\"land_ledger_ef.php?menu=ln&op=up&land_id=".$row['land_id']."\">Alter </a>&nbsp||&nbsp<a href=\"land_statement.php?menu=ln&op=s&land_id=".$row['land_id']."\">Less </a></td>";
   }
echo "<tr bgcolor=AQUA>";
echo "<th colspan=9>Total : $j Land Infomation Found!!!!!!";
echo "<th><b>".getAcer($t_area);
echo "<th><b>$t_value <td>";
echo "</table>";
}
echo "</body>";
echo "</html>";
?>
