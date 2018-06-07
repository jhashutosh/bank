<?php
include "../config/config.php";
$status=$_REQUEST['status'];
$menu=$_REQUEST['menu'];
$sql_statement="select asset_id,asset_desc,asset_type,current_value,current_value-round((dep_rate* current_value*(CASE WHEN (current_date-action_date)>1 THEN current_date-action_date ELSE 0 END))/36500) as cur_val,current_date-action_date as days from asset_master where current_value>0 order by cast(substr(asset_id,5) as integer)";
$result=dBConnect($sql_statement);
//echo $sql_statement;
echo "<head>";
echo "<title>List of accounts";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";


if(pg_NumRows($result)==0) {
echo "<h4>RECORD Not found!!!</h4>";
} else {
echo "<table width=\"100%\" class='border'>";
$color==$TCOLOR;
for($j=0; $j<pg_NumRows($result); $j++) {
echo "<tr>";
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
echo "<td bgcolor=$color width=\"9%\"><a href=\"asset_detail.php?asset_id=".$row['asset_id']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=350,left=275, width=550,height=500'); return false;\">".$row['asset_id']."</a></td>";
echo "<td bgcolor=$color width=\"23%\">".$asset_type_array[$row['asset_type']]."</td>";
echo "<td bgcolor=$color width=\"26%\">".ucwords($row['asset_desc'])."</td>";
echo "<td bgcolor=$color width=\"15%\" align=right>".amount2RS($row['current_value'])."</td>";
echo "<td bgcolor=$color width=\"20%\" align=right>".amount2RS($row['cur_val'])."</td>";
echo "<td align=center bgcolor=$color width=\"16%\"><a href=\"asset_sales_new.php?asset_id=".$row['asset_id']."\" target=\"_parent\"> Sales </a></td>";

}
echo "</table>";
}

?>
