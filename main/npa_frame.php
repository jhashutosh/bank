<?php
include "../config/config.php";

echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo"<head>";
echo"<title>framer frame</title>";
echo "<script src=\"../JS/loading2.js\">";
echo "</script>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo"</head>";

echo"<body bgcolor='grey'>";
echo"<table valign=\"top\"width='110%' align='center' bgcolor=''>";
$sql=
"select * from npa_mas;
";
$res=dBConnect($sql);
$color='#FFDEAD';
//echo $sql;
for($j=0;$j<pg_NumRows($res);$j++){
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($res,$j);
echo "<tr>";
echo "<td   align='center'  width='15%' bgcolor='$color'><font color='black'>".$row['sub']."</font></td>";
echo "<td   align='center'  width='15%' bgcolor='$color'><font color='black'>".$row['d1']."</font></td>";
echo"<td align='center' width='15%' bgcolor='$color'><font color='black'>".$row['d2']."</font></td>";
echo"<td align='center' width='15%' bgcolor='$color'><font color='black'>".$row['d3']."</font></td>";
echo"<td align='center' width='15%' bgcolor='$color'><font color='black'>".$row['unsec']."</font></td>";
echo"<td align='center' width='15%' bgcolor='$color'><font color='black'>".$row['lst_ast']."</font></td>";
echo"<td align='center' width='10%' bgcolor='$color'><font color='black'>".$row['action_date']."</font></td>";
echo"</tr>";
}
echo"</table></body>";
?>

