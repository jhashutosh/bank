<?php
include "../config/config.php";
registerSession(); 
$staff_id=verifyAutho();
//$login_timestamp=$_REQUEST["login_time"];
$login_timef=date('l dS \of F Y h:i:s A',$_COOKIE["login_time"]);
$fy=$_SESSION["fy"];
echo "<HTML>";
echo "<TITLE>my zone";
echo "</TITLE>";
echo "<body bgcolor=\"white\">";
echo "<H1><i><font color=red>$PROJECT_TITLE</font></i></H1>";
echo "<I>Banking made simpler.</I>";
echo "<HR>";
echo "<br>Welcome to Common Accounting System (CAS). <br><br><table width=\"60%\"><tr><td><p>";
echo "Your present login id is <b>$staff_id</b>.</br>";
echo "You have logged in at <b>".$login_timef."</b></br> ";
echo "The current financial year selected is <b>$fy</b></P></table>";
echo "</body></html>";
?>
