<?php
include "../config/config.php";
$staff_id=verifyAutho();
//$menu=$_REQUEST['menu'];
$op=$_REQUEST['op'];//what is the function of op(request from node.js)
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\">";
echo "<font size=+2><b>General Ledger</font><br>";
echo "<i>Welcome to banking coding System";
echo "<HR>";
echo "<TABLE Align=Center width=100%>";
if($op=='c')
{
echo "<TR><TH BGCOLOR=#8A2BE2><font size=+2>General Ledger Creation</font></TH><TR>";
echo "<Td><ul type=disc>";
echo "<li><a href=gl_header.php?op=c>Creating Master Header </a> -For Master Ledger Header";
echo "<li><a href=gl_sub_header.php?op=c>Creating Sub Header </a> -For Sub Ledger Header";
echo "<li><a href=gl_master_header.php?op=c>Creating Basic Header </a> -For Basic Ledger Header";
}
if($op=='u')
{
echo "<TR><TH BGCOLOR=#8A2BE2><font size=+2>General Ledger Updation</font></TH><TR>";
echo "<Td><ul type=disc>";
echo "<li><a href=#>Updating Master Header </a> -For Master Ledger Header";
echo "<li><a href=#>Updating Sub Header </a> -For Sub Ledger Header";
echo "<li><a href=#>Updating Basic Header </a> -For Basic Ledger Header";
}
if($op=='v')
{
echo "<TR><TH BGCOLOR=#8A2BE2><font size=+2>General Ledger View</font></TH><TR>";
echo "<Td><ul type=disc>";
echo "<li><a href=gl_header.php?op=v>Viewing Master Header </a> -For Master Ledger Header";
echo "<li><a href=gl_sub_header.php?op=v>Viewing Sub Header </a> -For Sub Ledger Header";
echo "<li><a href=gl_master_header.php?op=v>Viewing Basic Header </a> -For Basic Ledger Header";
}
?>
