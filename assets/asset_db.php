<?php
include "../config/config.php";
$status=$_REQUEST['status'];
$menu=$_REQUEST['menu'];
$sql="select calculateyearlydepreciation_final(current_date)"; 
$res=dBConnect($sql);
$sql_statement="SELECT a.face_value,a.asset_id,a.current_value,a.asset_type,a.gl_code,initcap(a.asset_desc) as asset_desc,
a.current_value-abs(coalesce(d.cur_dep_amount,0)) as curr_value,abs(coalesce(d.cur_dep_amount,0)) as dep from asset_master a,yearly_dep_app_charging d where a.current_value>0 and d.asset_id=a.asset_id ORDER BY entry_time DESC";
//echo $sql_statement;
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
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
echo "<tr>";
echo "<td align=CENTER bgcolor=$color width=\"9%\">".$row['asset_id']."</td>";
echo "<td  bgcolor=$color width=\"20%\">".$all_assets_array[$row['gl_code']]."</td>";
echo "<td  bgcolor=$color width=\"15%\">".$row['asset_desc']."</td>";
echo "<td  bgcolor=$color width=\"10%\">".$row['face_value']."</td>";
echo "<td  bgcolor=$color width=\"10%\">".$row['current_value']."</td>";
$currval+=$row['current_value'];
echo "<td  bgcolor=$color width=\"10%\">".$row['dep']."</td>";
$tot_dep+=$row['dep'];
echo "<td align=right bgcolor=$color width=\"12%\">".amount2Rs($row['curr_value'])."</td>";
$tot_val+=$row['curr_value'];
echo "<td bgcolor=$color align=center width=\"8%\"><a href=\"asset_detail.php?op=P&asset_id=".$row['asset_id']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=350,left=275, width=550,height=500'); return false;\" >SHOW</a>&nbsp;&nbsp;";
//echo"||&nbsp;&nbsp;<a href=\"asset_detail.php?op=P&asset_id=".$row['asset_id']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=350,left=275, width=550,height=500'); return false;\" >Change rate</a>";
if(trim($row['asset_type'])=='ia'){
echo "&nbsp||<a href=\"land1_asset.php?op=P&asset_id=".$row['asset_id']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=350,left=900, width=400,height=400'); return false;\" >LAND DETAIL</a>";
 		}
}
echo "<tr></tr><tr></tr><tr></tr><tr></tr><tr bgcolor=\"AQUA\"><th colspan=\"4\">Total: ".($j)."<th align=\"RIGHT\">".amount2Rs($currval)."</th><th align=\"RIGHT\">".amount2Rs($tot_dep)."</th><th>".amount2Rs($tot_val)."</th><th></th>";
}

echo "</table>";

?>
