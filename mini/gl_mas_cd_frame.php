<?
include "../config/config.php";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo"<head>";
echo"<title>customer mini frame</title>";
echo "<script src=\"../JS/loading2.js\">";
echo "</script>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo"</head>";

echo"<body bgcolor='grey'>";

echo"<table valign=\"top\"width='110%' align='center'>";
$sql="select gl_mas_code,initcap(gl_mas_desc) as gl_mas_desc,gl_sub_header_code from LC_Mini_Gl_Master";
$res=dBConnect($sql);
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
echo "<tr>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width='30%'><font color='black' size='2'>".$row['gl_mas_code']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\" width='41%'><font color='black' size='2'>".$row['gl_mas_desc']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\" width='29%'><font color='black' size='2'>".$row['gl_sub_header_code']."</font></td>";
}
echo"</tr></table>";

echo"</body>";
