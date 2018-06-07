<?php
include "../config/config.php";
$customer_id=$_REQUEST["A"];
//$account_no=$_REQUEST['account_no'];
$path=$SIGNATURE_PATH."/".$customer_id.".jpg";
echo "<h1>path:$path</h1>";
echo "<html>";
echo "<title> Photo</title>";
echo "<body bgcolor=\"Silver\">";
echo "<center>";
echo "<font size=+3 color=blue><B>Customer Id: $customer_id<br>";
echo "<img src=\"$path\" width=650 height=400>";
echo "</center>";
echo "</body>";
echo "</html>";
?>
