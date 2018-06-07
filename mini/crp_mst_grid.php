<?
include "../config/config.php";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
$id_crop_mas=$_REQUEST['id_crop_mas'];

//echo $type;
echo"<head>";
echo"<title>crop_mst_grid</title>";
echo "<script src=\"../JS/loading2.js\">";
echo "</script>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo"</head>";
echo"<body bgcolor='white'>";
$TBGCOLOR="silver";
$TCOLOR="#FFDEAD";
echo"<form  name='f1' action='crp_mst_grid.php' method='post' >";
echo"<table valign=\"top\"width='100%' align='center'>";
$sql="select * from LC_Crop_Rate_Master l,lc_season_master s,crop_mas c where l.id_season_master=s.id and l.id_crop_mas=cast(c.crop_id as integer)";
$res=dBConnect($sql);
//echo $sql;
$color==$TCOLOR;
for($j=0;$j<pg_NumRows($res);$j++){
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($res,$j);
echo "<tr>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"15%\"><font color='black' size='2'>".ucwords($row['crop_desc'])."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"15%\"><font color='black' size='2'>".$row['season_desc']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"15%\"><font color='black' size='2'>".$row['crop_rate']." Rs./ Satak</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"15%\"><font color='black' size='2'>".$row['overdue_rate']." Rs./ Satak</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"   width=\"20%\"><font color='black' size='2'>".$row['overdue_date']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"20%\"><font color='black' size='2'>".$row['with_effect_from']."</font></td>";
echo"</tr>";
}
echo"</table></form></body>";
?>
