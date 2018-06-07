<?
include "../config/config.php";
$status=$_REQUEST['status'];
$TCOLOR='#A9E2F3';
$menu=$_REQUEST['menu'];
$glc=$_REQUEST['liab'];
$sql_statement="select initcap(b.gl_sub_header_desc) as am,initcap(a.gl_mas_desc) as as from gl_master a,gl_sub_header b,asset_depreciation_link c where a.gl_mas_code=c.asset_gl_code and b.gl_sub_header_code=c.gl_sub_header_code";
$result=dbConnect($sql_statement);
$sql="select initcap(a.gl_mas_desc) as dl from gl_master a,asset_depreciation_link c where a.gl_mas_code=c.dep_app_gl_code";
$result1=dbConnect($sql);
$sql1="select gl_mas_desc from gl_master a,asset_depreciation_link b where a.gl_mas_code=cast(b.liab_gl_code as character varying)";
$res=dbConnect($sql1); 
//echo $sql_statement;
//echo"<br>";
//echo $sql;
///echo"<br>";
//echo $sql1;

echo "<head>";
echo "<title>Fixed Asset dep-app";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"\">";
if(pg_NumRows($result)==0 ||pg_NumRows($result1)==0)
{
echo "<h4>RECORD Not found!!!</h4>";
} else
{
//echo pg_NumRows($result);
echo "<table width=\"100%\">";
$color==$TCOLOR;
for($j=0; $j<pg_NumRows($result); $j++) {
echo "<tr>";
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
$row1=pg_fetch_array($result1,$j);
$row2=pg_fetch_array($res,$j);
///////////////////////////////////////// insert code here
//echo "<tr>";
echo "<td align=left bgcolor=$color width=\"25%\">".$row['am']."</td>";
echo "<td align=left bgcolor=$color width=\"25%\">".$row['as']."</td>";
echo "<td align=left bgcolor=$color width=\"25%\">".$row1['dl']."</td>";
echo "<td align=left bgcolor=$color width=\"25%\">".$row2['gl_mas_desc']."</td></tr>";
}
echo "</table>";}
?>
