<?php
include "../config/config.php";
$staff_id=verifyAutho();
echo "<HTML>";
echo"<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo"</head>";
echo"<body bgcolor=\"silver\">";
echo"<div align=\"center\">";
echo"<h1><font color=\"darkred\">** LOAN SETUP **</font></h1>";
echo"<ul>";
echo"<li><a href=\"kccconfig.php\"><font size=\"+1\">KCC Loan</font></li>";
echo"<li><a href=\"loan_configuration.php\"><font size=\"+1\">All Other Loan</font></li>";
echo"</ul></div>";
?>
