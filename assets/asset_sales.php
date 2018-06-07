<?php 
include "../config/config.php";
$status=$_REQUEST['status'];
$menu=$_REQUEST["menu"];
$op=$status;
echo "<html>";
echo "<head>";
echo "<title>List of Assets";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\"	>";
echo "<table width=\"100%\" class=\"border\">";
echo "<tr><td bgcolor=\"green\" colspan=\"6\" align=\"center\"><font color=\"white\">Asset Sales Details</font>";
// Place line comments if you do not need column header.
$color="#F0E68C";
echo "<tr>";
echo "<th bgcolor=$color width=\"10%\">Asset Id</th>";
echo "<th bgcolor=$color width=\"23%\">Asset Type</th>";
echo "<th bgcolor=$color width=\"25%\">Asset Description</th>";
echo "<th bgcolor=$color width=\"15%\">Original Value</th>";
echo "<th bgcolor=$color width=\"20%\">Current Value After Dep/App</th>";
echo "<th bgcolor=$color width=\"17%\">View</th>";

echo "<tr><td colspan=\"6\" align=center><iframe src=\"asset_sales_db.php?status=$op&menu=$menu\" width=\"100%\" height=\"350\"></iframe>";
echo "<tr bgcolor=cyan><td colspan=6 align=center>Total : <font color=red><b>$row </b></font>Asset Holder";
echo "</table>";
//}
echo "</body>";
echo "</html>";
?>
