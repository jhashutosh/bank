<?php
include "../config/config.php";
$status=$_REQUEST['status'];
$menu=$_REQUEST['menu'];
$date=$_REQUEST['date'];
$sql="select calculateyearlydepreciation_final('$date')";
//echo $sql;
$result=dBConnect($sql);
//if(pg_NumRows($result)>0){echo"sorry";}
echo"<html>";
echo "<head>";
echo "<title>Periodical dep-app charging";
echo "</title>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo"<body bgcolor=''>";
echo"<form name='f1' action='period_dep_charging_rep.php'>";
echo"<table width='100%'><tr>";
echo"<th bgcolor='yellow' colspan='2' ><font color='red' size='3'>Periodical Depreciation / Appreciation Charging</font></th></tr>";
echo"<tr><td align='right' bgcolor='lightgreen'><font size='2' color='darkblue'>Depreciation/Appreciation as on :&nbsp&nbsp&nbsp</font></td>";
echo"<td bgcolor='lightgreen'><input type=\"TEXT\" name=\"date\" size=\"12\" value='$date' $HIGHLIGHT>";
echo "&nbsp<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.date,'dd/mm/yyyy','Choose Date')\"></td></tr>";
echo"<tr><td colspan='2' align='center'><input type='submit' value='Enter'></td></tr>";
echo "<tr><td colspan=\"6\" align=center><iframe src=\"report.php?status=$op&menu=$menu\" width=\"110%\" height=\"400\" ></iframe>";

echo"</table>";
echo"</form>";
echo"</body>";
echo"</html>";
?>

