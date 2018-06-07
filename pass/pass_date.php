<?
include "../config/config.php";
echo "<html>";
echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script type=\"text/javascript\" src=\"../JS/bsn.AutoSuggest_c_2.0.js\"></script>";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "</head>";
echo "<body bgcolor=\"#FFF0F5\"><br><br>";
echo "<form name=\"f1\" method=\"POST\" action=\"pass.php\">";
echo "<table bgcolor='lightgreen' align=center width=70%>";
echo "<tr><th colspan='3' bgcolor=#4B0082><font color=WHITE>Date wise Passing</th></tr>";
echo"<tr><td colspan='3'></td></tr>";
echo "<td align=\"right\">Select Date</td><td>:</td>";
echo "<td><input type=\"TEXT\" name=\"tran_date\" size=\"12\" value=".date('d/m/Y')." $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"date\" value=\"...\" onclick=\"showCalendar(f1.tran_date,'dd/mm/yyyy','Choose Date')\">";
echo "</td></tr><tr>";
echo "<td colspan='3' align=\"right\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Enter\"></td></tr>";
echo "</table>";
echo "</form>";
echo "</body>";
echo "</html>";
?>
