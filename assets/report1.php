<?php
include "../config/config.php";
$status=$_REQUEST['status'];
$menu=$_REQUEST['menu'];
echo"<html>";
echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo"<body bgcolor='silver'>";
echo "<table width=\"100%\" bgcolor='#00BFFF'>
<tr>";
echo"<th bgcolor='#00BFFF' align='center' width =\"75\" colspan=\"2\"><font color='darkblue'> REPORT FOR DEPRECIATION/APPRECIATION AND ASSET DETAILS </th></tr></table>";
echo"<table width='100%'><tr bgcolor='silver'>";
echo"<td ></td><td></td></tr><tr bgcolor='silver'><td ></td><td></td></tr><tr bgcolor='silver'><td ></td><td></td></tr>";
echo"<tr><th bgcolor='silver' align='center' width =\"75\" colspan=\"2\"><font color='darkblue' size='5'>SELECT REPORT TO SEE RELEVANT DETAILS!!!</th></tr>";
echo "<tr bgcolor='silver'><td align=left ><ul>
<li><a href=\"asset_reg.php?menu=$menu&status=$status\">Asset Details</li>
<li><a href=\"dep_dtl.php?menu=$menu&status=$status\" >Depreciation/Appreciation Details</li>
<li><a href=\"sold_dtl.php?menu=$menu&status=$status\" >Completely Sold Items</li>
<li><a href=\"pur_dtl.php?menu=$menu&status=$status\" >Purchase Items</li>
</td></tr><tr bgcolor='silver'><td ></td><td></td></tr><tr bgcolor='silver'><td ></td><td></td></tr>
<tr bgcolor='silver'><td ></td><td></td></tr><tr bgcolor='silver'><td ></td><td></td></tr>";
echo"</table>";
echo"</body>";
echo"</html>";

?>
