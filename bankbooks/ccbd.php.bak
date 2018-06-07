<?
include "../config/config.php";
$status=$_REQUEST['status'];
$menu=$_REQUEST['menu'];
echo"<html>";
echo "<head>";
echo "<title>Periodical dep-app charging";
echo "</title>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo"<body bgcolor='black'>";
echo"<form name='f1' action='ccb1.php' method='post'>";
echo"<table width='100%'><tr>";
echo"<th bgcolor='yellow' colspan='2' ><font color='red' size='3'>C.C.B. MODULE</font></th></tr>";
echo"<tr><td align='right' bgcolor='lightgreen'><font size='2' color='darkblue'>Particular In a Date :&nbsp&nbsp&nbsp</font></td>";
echo"<td bgcolor='lightgreen'><input type=\"TEXT\" name=\"date\" size=\"12\" value='".date('d/m/Y')."' $HIGHLIGHT>";
echo "&nbsp<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.date,'dd/mm/yyyy','Choose Date')\"></td></tr>";
echo"<tr><td colspan='2' align='center'><input type='submit' value='Enter'></td></tr>";
//echo "<tr><td colspan=\"6\" align=center><iframe src=\"report.php?status=$op&menu=$menu\" width=\"100%\" height=\"300\" ></iframe>";

echo"</table>";
echo"</form>";
echo"</body>";
echo"</html>";
?>

