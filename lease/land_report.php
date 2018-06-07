<?
include "../config/config.php";
$staff_id=verifyAutho();
echo "<html>";
echo "<head>";
echo "<script language=\"JAVASCRIPT\">";
echo "function closeme() { close(); }";
echo "</script>";
echo "<title>Statement";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
//echo "sujoy";
echo "<table align=\"center\" width=\"100%\">";
echo "<tr>";
echo "<th bgcolor=GREEN colspan=8><font size=5 color=white>Land Report Of Customer</font></th>";
$color="#CCCCC5555";
echo "<tr>";
echo "<th bgcolor=$color Rowspan=\"1\">Sl No.</th>";
echo "<th bgcolor=$color Rowspan=\"1\">Customer No</th>";
echo "<th bgcolor=$color Rowspan=\"1\">Membership No</th>";
echo "<th bgcolor=$color Rowspan=\"1\">KCC A/C No</th>";
echo "<th bgcolor=$color Rowspan=\"1\">Name</th>";
echo "<th bgcolor=$color Rowspan=\"1\">Land Area</th>";
echo "<th bgcolor=$color Rowspan=\"1\">Karbanama Bond Value</th>";
echo "<th bgcolor=$color Rowspan=\"1\">Share Value</th>";
$sql_statement=" select m.customer_id as customer_id,m.membership_no as membership_no,s.value_of_share as share_value from membership_info m,share_details s where m.customer_id=s.customer_id";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0){
echo "<tr>";
echo "<th colspan=\"15\"><font color=green size=5><blink>!!! There is no Customer in Overdue List !!!</blink></font></th>";
}
else
{

$color=$TCOLOR;
for($j=1; $j<=pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j-1);
$customer_id=trim($row['customer_id']);
echo "<tr>";
echo "<th bgcolor=$color width=\"15%\">$j</th>";
echo "<th bgcolor=$color width=\"15%\">".$row['customer_id']."</th>";
echo "<th bgcolor=$color width=\"15%\">".$row['membership_no']."</th>";
echo "<th bgcolor=$color width=\"15%\"></th>";
echo "<th bgcolor=$color width=\"15%\"></th>";
$sql_statement2="select sum(land_area) as land_area,sum(karbanama_bond_value) as karbanama_value from land_info group by customer_id='$customer_id';
";
$result2=dBConnect($sql_statement2);
if(pg_NumRows($result2)>0){
$land_area=pg_result($result2,'land_area');
$karbanama_value=pg_result($result2,'karbanama_value');
echo "<th bgcolor=$color width=\"15%\">$land_area</th>";
echo "<th bgcolor=$color width=\"15%\">$karbanama_value</th>";
}
echo "<th bgcolor=$color width=\"15%\">".$row['share_value']."</th>";

 }
}
echo "</table>";
echo "</body>";
echo "</html>";

?>
