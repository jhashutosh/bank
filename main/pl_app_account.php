<?
include "../config/config.php";
$staff_id=verifyAutho();
echo "<html>";
echo "<head>";
echo "<title> KCC Main </title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<table bgcolor=\"silver\" width=\"100%\" align=\"CENTER\">";
echo "<tr><th bgcolor=\"green\" colspan=\"6\"><font size=\"6\" color=\"white\">Profit & Loss Appropriation Account";
echo "<tr><th width=\"30%\" bgcolor=\"aqua\" rowspan=\"2\"> Expenditure</th>";
echo "<th width=\"20%\" bgcolor=\"aqua\" colspan=\"2\"> Amount(Rs.)</th>";
echo "<th width=\"30%\" bgcolor=\"aqua\" rowspan=\"2\"> Expenditure</th>";
echo "<th width=\"20%\" bgcolor=\"aqua\" colspan=\"2\"> Amount(Rs.)</th>";
echo "<tr>";
echo "<th width=\"10%\" bgcolor=\"aqua\" rowspan=\"1\"> Current Year</th>";
echo "<th width=\"10%\" bgcolor=\"aqua\" rowspan=\"1\"> Previous Year</th>";
echo "<th width=\"10%\" bgcolor=\"aqua\" rowspan=\"1\"> Current Year</th>";
echo "<th width=\"10%\" bgcolor=\"aqua\" rowspan=\"1\"> Previous Year</th>";
echo "</table>";
echo "</body>";
echo "</html>";

?>
