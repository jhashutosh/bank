<?
include "../config/config.php";
$staff_id=verifyAutho();
$op=$_REQUEST['op'];
$menu=$_REQUEST['menu'];
$land_id=$_REQUEST['land_id'];
$account_no=$_SESSION["current_account_no"];
//isPermissible($menu);
echo "<html>";
echo "<head>";
echo "<title>Statement";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<h3>Land Subtraction[$account_no]";
echo "</h3><hr>";
$flag=getGeneralInfo_Customer($account_no);
if($flag==1){
echo "<hr>";
$sql_statement="SELECT * FROM land_info WHERE customer_id='$account_no' AND status<>'s'";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4>New Account</h4>";
} else {
echo "<table valign=\"top\" width=\"100%\">";
// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=#8A2BE2 colspan=10>Land Information[$account_no]</th>";
echo "<tr>";
echo "<th bgcolor=$color>Land Id</th>";
echo "<th bgcolor=$color>Date</th>";
echo "<th bgcolor=$color>Dag No.</th>";
echo "<th bgcolor=$color>Mouja No.</th>";
echo "<th bgcolor=$color>Khatian No.</th>";
echo "<th bgcolor=$color>GP</th>";
echo "<th bgcolor=$color>Mark</th>";
echo "<th bgcolor=$color>Mini No.</th>";
echo "<th bgcolor=$color>Area(acer)</th>";
echo "<th bgcolor=$color>Value(Rs)</th>";
//echo "<th bgcolor=$color>Operation</th>";
for($j=0; $j<pg_NumRows($result); $j++){
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
echo "<tr>";
echo "<td align=right bgcolor=$color>".$row['land_id']."</td>";
$land_id[$j]=$row['land_id'];
echo "<td align=right bgcolor=$color>".$row['action_date']."</td>";
echo "<td align=right bgcolor=$color>".$row['dag_no']."</td>";
echo "<td align=right bgcolor=$color>".$row['mouja_no']."</td>";
echo "<td align=right bgcolor=$color>".$row['jl_no']."</td>";
echo "<td align=right bgcolor=$color>".getName('panchayat_id',trim($row['gp']),'panchayat_desc
','panchayat_mas'). "</td>";
echo "<td align=right bgcolor=$color>".getName('mark_id',trim($row['land_identity']),'mark_desc','land_identification_mas')."</td>";
echo "<td align=right bgcolor=$color>".getName('mini_id',trim($row['mini_no']),'mini_desc','mini_mas')."</td>";

$t_area+=($row['land_area']/100);
echo "<td align=right bgcolor=$color>".($row['land_area']/100)."</td>";
$t_value+=$row['land_value'];
echo "<td align=right bgcolor=$color>".$row['land_value']."</td>";
//echo "<td align=center bgcolor=$color><a href=\"land_ledger_ef.php?menu=ln\">New </a>&nbsp||&nbsp<a href=\"land_ledger_ef.php?menu=ln&op=up&land_id=".$row['land_id']."\">Alter </a>&nbsp||&nbsp<a href=\"land_statement.php?menu=ln&op=s&land_id=".$row['land_id']."\">Less </a></td>";
   }
echo "<tr bgcolor=AQUA>";
echo "<th colspan=8>Total : $j Land Infomation Found!!!!!!";
echo "<td  align=right><b>$t_area";
echo "<td align=right><b>$t_value";
echo "</table>";
 }
echo "<hr>";
echo "<form name=\"form1\" method=\"POST\" action=\"land_statement.php?menu=$menu&op=s\">";
echo "<table align=center><th>Select Land Id :<td>";
makeSelect($land_id,'land_id','');
echo "&nbsp<input type=SUBMIT value=Submit>";

echo "</table></form><hr>";
}
echo "</body>";
echo "</html>";
?>
