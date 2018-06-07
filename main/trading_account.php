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
echo "<tr><th bgcolor=\"#CCCC5555\" colspan=\"8\"><font size=\"3\" color=\"black\">Select Month:";
makeSelect($month_array,'months',$m);
echo"&nbsp;-&nbsp;<input type=TEXT size=4 name=current_date id=cd Value=\"$year\" onclick=\"this.value=''\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "</font></th>";
echo "<tr><th bgcolor=\"green\" colspan=\"8\"><font size=+2 color=\"white\">Monthly Trading Account</font></th>";
echo "<tr>";
$color="aqua";
echo "<th width=\"30%\" rowspan=\"2\" bgcolor=\"$color\">Particulars</th>";
echo "<th width=\"20%\" colspan=\"2\" bgcolor=\"$color\">Amount(Rs.)</th>";
echo "<th width=\"30%\" rowspan=\"2\" bgcolor=\"$color\">Particulars</th>";
echo "<th width=\"20%\" colspan=\"2\" bgcolor=\"$color\">Amount(Rs.)</th>";
echo "<tr>";
echo "<th width=\"10%\" rowspan=\"1\" bgcolor=\"$color\">Current Year</th>";
echo "<th width=\"10%\" rowspan=\"1\" bgcolor=\"$color\">Previous Year</th>";
echo "<th width=\"10%\" rowspan=\"1\" bgcolor=\"$color\">Current Year</th>";
echo "<th width=\"10%\" rowspan=\"1\" bgcolor=\"$color\">Previous Year</th>";

echo "<table>";
echo "</body>";
echo "</html>";
?>
