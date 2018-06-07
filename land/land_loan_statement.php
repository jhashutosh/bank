<?
include "../config/config.php";
$staff_id=verifyAutho();
$op=$_REQUEST['op'];
$menu=$_REQUEST['menu'];
if(empty($op)){
	$account_no=$_SESSION["current_account_no"];
	isPermissible($menu);
}
else{
	$account_no=$_REQUEST["account_no"];

}
echo "<html>";
echo "<head>";
echo "<title>Statement";
echo "</title>";
echo "<script language=\"JAVASCRIPT\">";
echo "function closeme() { close(); }";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
//$title=$type_of_account1_array[trim($menu)];
echo "<h3>Land Account Statement [$account_no]";
echo "</h3><hr>";

$id=getCustomerIdLand($account_no,$menu);
$flag=getGeneralInfo_Customer($id);
echo $id;
// Customization required for WHERE CLAUSE
// Info section start
if($flag==1){
echo "<hr>";

//$sql_statement="SELECT * FROM customer_ri WHERE account_no='$account_no'";
$sql_statement="SELECT * FROM land_info WHERE land_id='$account_no' AND status<>'s'";
$result=dBConnect($sql_statement);
//echo $sql_statement;
if(pg_NumRows($result)==0) {
echo "<h4>Not found!!!</h4>";
} else {
echo "<table valign=\"top\" width=\"100%\">";
// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=GREEN colspan=13>Land Statement[$account_no]</th>";
echo "<tr>";
echo "<th bgcolor=$color Rowspan=\"2\">Land Id</th>";
echo "<th bgcolor=$color Rowspan=\"2\">Date</th>";
echo "<th bgcolor=$color Rowspan=\"2\">LandType</th>";
echo "<th bgcolor=$color Rowspan=\"2\">Dag No.</th>";
echo "<th bgcolor=$color Rowspan=\"2\">Mouja No.</th>";
echo "<th bgcolor=$color Rowspan=\"2\">Khatian No.</th>";
echo "<th bgcolor=$color Rowspan=\"2\">GP</th>";
echo "<th bgcolor=$color Rowspan=\"2\">Mark</th>";
echo "<th bgcolor=$color Rowspan=\"2\">Mini No.</th>";
echo "<th colspan=\"3\" bgcolor=$color>Karbanama</th>";
echo "<th bgcolor=$color Rowspan=\"2\">Operation</th>";
echo "<tr bgcolor=$color><th>Bond No.</th>";
echo "<th bgcolor=$color>Area</th>";
echo "<th bgcolor=$color>Value</th>";

for($j=0; $j<pg_NumRows($result); $j++){
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
echo "<tr>";
echo "<td align=CENTER bgcolor=$color>".$row['land_id']."</td>";
echo "<td bgcolor=$color>".$row['action_date']."</td>";
echo "<td  bgcolor=$color>".$crop_master_array[$row['crop_header']]."</td>";
echo "<td align=right bgcolor=$color>".$row['dag_no']."</td>";
echo "<td bgcolor=$color>".ucwords($row['mouja_no'])."</td>";
echo "<td align=right bgcolor=$color>".$row['jl_no']."</td>";
echo "<td  bgcolor=$color>".getName('panchayat_id',trim($row['gp']),'panchayat_desc
','panchayat_mas'). "</td>";
echo "<td  bgcolor=$color>".getName('mark_id',trim($row['land_identity']),'mark_desc','land_identification_mas')."</td>";
echo "<td  bgcolor=$color>".getName('mini_id',trim($row['mini_no']),'mini_desc','mini_mas')."</td>";
//$t_karbanama+=$row['karbanama_bond_value'];
echo "<td  bgcolor=$color>".$row['karbanama_bond_value']."</td>";
$t_area+=$row['land_area'];
echo "<td align=right bgcolor=$color>".getAcer($row['land_area'])."</td>";
$t_value+=$row['land_value'];
echo "<td align=right bgcolor=$color>".(float)$row['land_value']."</td>";
echo "<td align=center bgcolor=$color><a href=\"land_ledger_ef.php?menu=ln\">New </a>&nbsp||&nbsp<a href=\"land_ledger_ef.php?menu=ln&op=up&land_id=".$row['land_id']."\">Alter </a>&nbsp||&nbsp<a href=\"land_statement.php?menu=ln&op=s&land_id=".$row['land_id']."\">Less </a></td>";
   }
echo "<tr bgcolor=AQUA>";
echo "<th colspan=9>Total : $j Land Infomation Found!!!!!!";

echo "<th align=right colspan=1><b></b></th>";
echo "<th  align=right colspan=1><b>".getAcer($t_area);
echo "<th align=right colspan=1><b>$t_value </b></th>";
echo "<th align=right colspan=1></th>";
echo "</table>";
 }
}
echo "</body>";
echo "</html>";
?>
