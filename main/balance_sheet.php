<?php
include "../config/config.php";
$staff_id=verifyAutho();
echo "<html>";
echo "<head>";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<table align=center bgcolor=white width=1400%>";
echo "<tr><th colspan=10 bgcolor=GREEN><font size=\"5\">Balance Sheet of Primary Agricultural Credit Society(PACS)</font></th>";
$color="F2CV62";
echo "<tr>";
echo "<th rowspan=\"2\" bgcolor=$color>Sr.NO</th>";
echo "<th rowspan=\"2\" bgcolor=$color>Liabilities</th>";
echo "<th rowspan=\"2\" bgcolor=$color>Breakup</th>";
echo "<th colspan=\"1\" bgcolor=$color>31.03.of the year</th>";
echo "<th colspan=\"1\" bgcolor=$color>31.03.of the year</th>";
echo "<th rowspan=\"2\" bgcolor=$color>Sr.NO</th>";
echo "<th rowspan=\"2\" bgcolor=$color>Assets</th>";
echo "<th rowspan=\"2\" bgcolor=$color>Breakup</th>";
echo "<th colspan=\"1\" bgcolor=$color>31.03.of the year</th>";
echo "<th colspan=\"1\" bgcolor=$color>31.03.of the year</th>";
echo "<tr>";
echo "<th rowspan=\"1\" bgcolor=$color>Current Year</th>";
echo "<th rowspan=\"1\" bgcolor=$color>Previous Year</th>";
echo "<th rowspan=\"1\" bgcolor=$color>Current Year</th>";
echo "<th rowspan=\"1\" bgcolor=$color>Previous Year</th>";
echo "<tr>";
echo "<th rowspan=\"7\" bgcolor=$color>1</th>";
echo "<th rowspan=\"1\" bgcolor=$color>Capital</th>";
echo "<th rowspan=\"1\" bgcolor=$color>0</th>";
echo "<th rowspan=\"1\" bgcolor=$color>0</th>";
echo "<th rowspan=\"1\" bgcolor=$color>0</th>";
echo "<th rowspan=\"1\" bgcolor=$color>1</th>";
echo "<th rowspan=\"1\" bgcolor=$color>Cash on Hand</th>";
echo "<th rowspan=\"1\" bgcolor=$color>0</th>";
echo "<th rowspan=\"1\" bgcolor=$color>0</th>";
echo "<th rowspan=\"1\" bgcolor=$color>0</th>";
echo "<tr>";
echo "<th rowspan=\"1\" bgcolor=$color>I. Authorised</th>";
echo "<th rowspan=\"1\" bgcolor=$color>0</th>";
echo "<th rowspan=\"1\" bgcolor=$color>0</th>";
echo "<th rowspan=\"1\" bgcolor=$color>0</th>";
echo "<th rowspan=\"3\" bgcolor=$color>2</th>";

echo "</table>";

echo "</body>";
echo "</html>";
?>
