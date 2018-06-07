<?
include "../config/config.php";
$status=$_REQUEST['status'];
$menu=$_REQUEST['menu'];
$sql="select start_dt, close_dt from fy_list where entry_time is null";
$result1=dbConnect($sql);
$row1=pg_fetch_array($result1,0);

//$dt1=$row1['start_dt'];
//$dt2=$row1['close_dt'];
//echo $dt1."to".$dt2;

$sql_statement="select a.asset_id,initcap(c.gl_mas_desc) as asset_type,abs(a.at_the_rate) as rate,case when a.at_the_rate < 0 then 'Depreciation' when a.at_the_rate>0 then 'Appreciation' end as dep_app,case a.dep_method when 're' then 'Reducing' when 'st' then 'Straight' end as dep_type from yearly_dep_app_rate_setting a,asset_master b,gl_master c where a.asset_id=b.asset_id and b.gl_code=c.gl_mas_code order by a.id desc";
 

//and a.charge_from=to_date('$dt1','dd.mm.yyyy') and a.charge_on=to_date('$dt2','dd.mm.yyyy') order by a.id desc";;

$result=dBConnect($sql_statement);
//echo $sql_statement;
echo "<head>";
echo "<title>Fixed Asset dep-app";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";

if(pg_NumRows($result)==0) {
echo "<h4>RECORD Not found!!!</h4>";

} else {
//echo pg_NumRows($result);
echo "<table width=\"100%\">";
$color==$TCOLOR;
for($j=0; $j<pg_NumRows($result); $j++) {
echo "<tr>";
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
///////////////////////////////////////// insert code here


//echo "<tr>";
echo "<td align=left bgcolor=$color width=\"9%\">".$row['asset_id']."</td>";
echo "<td align=left bgcolor=$color width=\"25%\">".$row['asset_type']."</td>";
echo "<td align=left bgcolor=$color width=\"27%\">".$row['rate']."</td>";
echo "<td align=left bgcolor=$color width=\"16%\">".$row['dep_app']."</td>";
echo "<td align=left bgcolor=$color align=left width=\"25%\">".$row['dep_type']."</td></tr>";
}
echo "</table>";}
?>
