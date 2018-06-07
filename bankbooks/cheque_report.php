<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
echo "<html>";
echo "</script>";
echo "<title>Statement";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<font size=+4 color=GREEN><b>List Of Clearing Cheque Reports:</b></font>";
echo "<hr>";
echo "<li><A HREF=\"clearing_cheque_list.php?option=clearing\">Clearing Cheque </A>";
echo "<li><A HREF=\"clearing_cheque_list.php?option=cleared\">Cleared Cheque</A>";
echo "<li><A HREF=\"clearing_cheque_list.php?option=bounced\">Bounced Cheque</A>";
echo "<br><br><br><br><br><br><br><br><br>";

?>
