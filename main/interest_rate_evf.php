<?php
include "../config/config.php";
$staff_id=verifyAutho();
// PHP4 
$status=$_REQUEST['status'];
$id=$_REQUEST["id"];
$period=$_REQUEST["period"];
$rate=$_REQUEST["rate"];
$effective_date=$_REQUEST["effective_date"];
$remarks=$_REQUEST["remarks"];
$menu=$_REQUEST['menu'];
echo "<html>";
echo "<head>";
echo "<title>Table:interest_rate";
echo "</title>";
echo "</head>";
$bgcolor=empty($status)?"YELLOW":"AQUA";
echo "<body bgcolor=$bgcolor>";
$fName=empty($status)?"Entry":"Update";

echo "<h1>$fName Form -".strtoupper($menu)." interest rate";
echo "</h1>";
echo "<h3>Please verify this form before submission";
echo "</h3>";
echo "<hr>";

echo "<form method=\"POST\" action=\"interest_rate_eadd.php?menu=$menu\"><br>";
echo "<table>";
echo "<tr><td align=\"left\">Id:<td><input type=\"TEXT\" name=\"id\" size=\"25\" value=\"$id\" readonly  $HIGHLIGHT> <br>";
if ($menu!='sb'){
echo "<tr><td align=\"left\">Period:<td><input type=\"TEXT\" name=\"period\" size=\"\" value=\"$period\" $HIGHLIGHT>&nbsp;".$_REQUEST['method'];
}
echo "<tr><td align=\"left\">Rate:<td>Rs.<input type=\"TEXT\" name=\"rate\" size=\"22\" value=\"$rate\" $HIGHLIGHT>% p.a.<br>";
echo "<tr><td align=\"left\">Year With Effect:<td><input type=\"TEXT\" name=\"effective_date\" size=\"50\" value=\"$effective_date\" $HIGHLIGHT><br>";
echo "<tr><td align=\"left\">Scheme:<td><input type=\"TEXT\" name=\"scheme\" size=\"50\" value=\"".$_REQUEST['scheme']."\" $HIGHLIGHT>";
echo "<tr><td valign=\"top\" align=\"left\">Remarks:<td><textarea name=\"remarks\" rows=\"3\" cols=\"49\" $HIGHLIGHT>$remarks</textarea><br>";
echo "<input type=\"HIDDEN\" name=\"status\"  value=\"$status\">";
echo "<tr><td><td align=\"right\"><input type=\"SUBMIT\" value=\"Submit\">";
echo "</table>";
echo "</form>";
echo "</body>";
echo "</html>";

?>
