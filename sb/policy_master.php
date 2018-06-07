<?
include "../config/config.php";

$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$operator_code=$staff_id;
$starting_date=$_REQUEST["starting_date"];
$ending_date=$_REQUEST["ending_date"];
if( empty($starting_date) ) { $starting_date=date("d/m/Y",time()-604800); }
if( empty($ending_date) ) { $ending_date=date("d/m/Y"); }
echo "<html>";
echo "<head>";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "<script language=\"JAVASCRIPT\">";
echo "function closeme() { close(); }";
echo "</script>";

echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<font color=\"blue\"><b>$SYSTEM_TITLE</font>";
echo "<font color=\"green\">$date1</font></center><br>";
echo "<hr>";
echo "<br><hr>";
echo "<form name=\"form1\" method=\"POST\" action=\"pl_st_ef.php?menu=$menu\">";
echo "<table bgcolor=#FFF0F5 width=90% align=center>";
echo "<tr><td align=\"left\">NAME:<td><input type=\"TEXT\" name=\"account_no\" size=\"15\" value=\"\" $HIGHLIGHT>";
echo "<br>";
echo "<td align=\"\">Starting Date:<td><input type=\"TEXT\" name=\"starting_date\" size=\"8\" value=\"$starting_date\" $HIGHLIGHT>";
echo "&nbsp;&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(form1.starting_date,'dd/mm/yyyy','Choose Date')\"><br>";

echo "<td align=\"\">Ending Date:<td><input type=\"TEXT\" name=\"ending_date\" size=\"8\" value=\"$ending_date\" $HIGHLIGHT>";
echo "&nbsp;&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(form1.ending_date,'dd/mm/yyyy','Choose Date')\"><br>";
echo "<tr><td align=\"left\">Due Interest:<td><input type=text name=\"interest\" value=\"\" size=10 $HIGHLIGHT>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Submit\">";
echo "</table>";
echo "</form>";
echo "</table>";


echo "</body>";
echo "</html>";
?>

