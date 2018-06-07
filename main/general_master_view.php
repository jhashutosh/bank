<?php
include "../config/config.php";
$staff_id=verifyAutho();
$op=$_REQUEST['op'];
$id=$_REQUEST['id'];
if($op=='c'){$table='crop_mas';$name='Crop'; $id_name='crop_id';$cols=3;}
if($op=='l'){$table='land_identification_mas';$name='Land'; $id_name='mark_id';$cols=3;}
if($op=='p'){$table='panchayat_mas';$name='Panchayat';$id_name='panchayat_id'; $cols=3;}
if($op=='m'){$table='mini_mas';$name='Mini';$id_name='mini_id'; $cols=4;}
if(!empty($id)){
	$arr=explode(",",$id); // Multiple entry seperated by ,
	$n=count($arr);
	$WHERE_CONDITIONS=""; 
	for($i=0; $i<($n-1);$i++){
		$WHERE_CONDITIONS="$WHERE_CONDITIONS $id_name='$arr[$i]' OR ";
	}
 
	$WHERE_CONDITIONS="WHERE $WHERE_CONDITIONS $id_name='$arr[$i]'"; 
	
} else {
	$WHERE_CONDITIONS=""; 
}
echo "<html>";
echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"st_dt.focus();\">";
$sql_statement="SELECT * from $table $WHERE_CONDITIONS  ORDER BY $id_name";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_num_rows($result)<1) {
if($op=='c')
{
echo "<center>";
echo "<font color=green size=4><blink><b>!!! Please Enter Crop Details !!!</b></blink></font>";
echo "</center>";
}
if($op=='l')
{
echo "<center>";
echo "<font color=green size=4><blink><b>!!! Please Enter Land Mark Details !!!</b></blink></font>";
echo "</center>";

}
if($op=='p')
{
echo "<center>";
echo "<font color=green size=4><blink><b>!!! Please Enter Panchayat Details !!!</b></blink></font>";
echo "</center>";

}
if($op=='m')
{
echo "<center>";
echo "<font color=green size=4><blink><b>!!! Please Enter Mini Details !!!</b></blink></font>";
echo "</center>";

}
} else {
echo "<H2><font color=#965897><I>Specify the searching criteria: </I></font></H2>";
echo "<form method=\"POST\" action=\"general_master_view.php?op=$op\">";

echo "<tr><td align=\"right\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

 ID: <input type=\"TEXT\" name=\"id\" size=\"15\" value=\"$id\" $HIGHLIGHT>";

echo "&nbsp<input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"   go   \">";
echo "<tr><td align=\"right\"><FONT SIZE=\"-2\">";
echo "</FONT>";
echo "</table>";
echo "</form>";
echo "<hr>";
echo "<table>";
}
echo "<table valign=\"top\" width=\"50%\" align=\"center\">";
$color=$TCOLOR;
echo "<tr><td bgcolor=\"red\" colspan=\"$cols\" align=\"center\"><font color=\"white\" size=5><b>$name details</b></font>";
echo "<tr>";
echo "<th bgcolor=$color>$name Id</th>";
echo "<th bgcolor=$color>$name Description</th>";
if($op=='m'){echo "<th bgcolor=$color>$name Operator Name</th>";}
echo "<th bgcolor=$color>$name Operation</th>";
for($j=1; $j<=pg_NumRows($result); $j++) {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j-1));
echo "<tr>";
echo "<td align=center bgcolor=$color>".$row[0]."</td>";
echo "<td  bgcolor=$color>".ucwords($row[1])."</td>";
if($op=='c'){
echo "<td align=center bgcolor=$color><A HREF=\"crop_master_ef.php\">New</a> || &nbsp;<A HREF=\"crop_master_ef.php?op=up&id=".$row[0]."\" $HIDERESORCE>Alter</a></td>";
}
if($op=='l'){
echo "<td align=center bgcolor=$color><A HREF=\"land_master_ef.php\">New</a> || &nbsp;<A HREF=\"land_master_ef.php?op=up&id=".$row[0]."\" $HIDERESORCE>Alter</a></td>";
}
if($op=='p'){
echo "<td align=center bgcolor=$color><A HREF=\"panchayat_ledger_ef.php\">New</a> || &nbsp;<A HREF=\"panchayat_ledger_ef.php?op=up&id=".$row[0]."\" $HIDERESORCE>Alter</a></td>";
}
if($op=='m'){
echo "<td  bgcolor=$color>".ucwords($row[2])."</td>";
echo "<td align=center bgcolor=$color><A HREF=\"mini_master_ef.php\">New</a> || &nbsp;<A HREF=\"mini_master_ef.php?op=up&id=".$row[0]."\" $HIDERESORCE>Alter</a></td>";
}
}
echo "<tr>";
$color="cyan";
echo "<td align=center bgcolor=$color colspan=\"$cols\"><B>Total:".($j-1)."</B></td>";
if($op=='c')
{
echo "<tr>";
echo "<th align=\"center\" colspan=\"$cols\"></th>";
}
echo "</table>";
echo "</body>";
echo "</html>";
?>
