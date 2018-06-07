<?php
include "../config/config.php";
$staff_id=verifyAutho();
echo "<html>";
echo "<head>";
echo "<title> KCC Main </title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<table bgcolor=\"silver\" width=\"130%\" align=\"CENTER\">";
echo "<tr><th bgcolor=\"green\" colspan=\"8\"><font size=\"3\" color=\"white\">Select Month:";
makeSelect($month_array,'months',$m);
echo"&nbsp;-&nbsp;<input type=TEXT size=4 name=current_date id=cd Value=\"$year\" onclick=\"this.value=''\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "</font></th>";
echo "<tr><th bgcolor=\"green\" colspan=\"8\"><font size=+2 color=\"white\">Details Of Top 20 Defaulters</font></th>";

$color="#EEEE5533";
echo "<tr>";
echo "<th width=\"5%\" rowspan=\"2\" bgcolor=\"$color\">Sr. No.</th>";
echo "<th width=\"20%\" rowspan=\"2\" bgcolor=\"$color\">Name of the borrower</th>";
echo "<th width=\"10%\" rowspan=\"2\" bgcolor=\"$color\">Purpose</th>";
echo "<th width=\"10%\" rowspan=\"2\" bgcolor=\"$color\">Date of Loan</th>";
echo "<th width=\"45%\" colspan=\"3\" bgcolor=\"$color\">Overdue Amount</th>";
echo "<th width=\"40%\" rowspan=\"2\" bgcolor=\"$color\">Details of action taken against defaulters</th>";
echo "<tr>";
echo "<th width=\"15%\" rowspan=\"1\" bgcolor=\"$color\">Principal</th>";
echo "<th width=\"15%\" rowspan=\"1\" bgcolor=\"$color\">Interest</th>";
echo "<th width=\"15%\" rowspan=\"1\" bgcolor=\"$color\">Total</th>";

echo "<table>";
echo "</body>";
echo "</html>";
?>
