<?php
include "../config/config.php";
$staff_id=verifyAutho();
echo "<html>";
echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../../css/test.css\" />";

echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<table width=\"100%\">";
echo "<tr><td bgcolor=\"green\" colspan=\"5\" align=\"center\"><font color=\"white\"><b>Customer Details</b></font>";
$color="#F0E68C";
echo "<tr>";
echo "<th bgcolor=$color width=\"12%\">Sl No.</th>";
echo "<th bgcolor=$color width=\"13%\">Customer Id.</th>";
echo "<th bgcolor=$color width=\"15%\">Name.</th>";
echo "<th bgcolor=$color width=\"30%\">Address.</th>";
echo "<th bgcolor=$color width=\"10%\">Voter Card No.</th>";
echo "<tr><td colspan=\"5\" align=center><iframe src=\"customer_info_db.php\" width=\"100%\" height=\"350\" ></iframe>";
echo "<tr bgcolor=cyan><td colspan=5 align=center>Total : Account Holder";

echo "</table>";

?>
