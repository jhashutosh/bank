<?php
include "../config/config.php";
$staff_id=verifyAutho();
echo "<html>";
echo "<head>";
echo "<title>Table: staff";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body>";
echo "<h1>Staff Details";
echo "<hr>";
$sql_statement="SELECT * FROM staff where Id<>'netware'";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4>Not found!!!</h4>";
} else {
echo "<table BGCOLOR=\"BLACK\" WIDTH=\"100%\" ALIGN=\"CENTER\">";

// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th colspan=\"8\" BGCOLOR=\"Yellow\">Staff Information</th>";
echo "<tr>";
$color="GREEN";
echo "<th bgcolor=$color>Id</th>";
echo "<th bgcolor=$color>Name</th>";
echo "<th bgcolor=$color>Address</th>";
echo "<th bgcolor=$color>Designation</th>";
echo "<th bgcolor=$color>Role</th>";
echo "<th bgcolor=$color>Boss</th>";
echo "<th bgcolor=$color>Last login</th>";
echo "<th bgcolor=$color>Actions</th>";

for($j=1; $j<=pg_NumRows($result); $j++) {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j-1));
echo "<tr>";
echo "<td  bgcolor=$color>".$row['id']."</td>";
echo "<td  bgcolor=$color>".ucwords($row['name'])."</td>";
echo "<td  bgcolor=$color>".ucwords($row['address'])."</td>";
echo "<td bgcolor=$color>".$designation_orga_array[$row['designation']]."</td>";
echo "<td bgcolor=$color>".$row['role']."</td>";
echo "<td bgcolor=$color>".$row['boss']."</td>";
echo "<td bgcolor=$color>".$row['last_login']."</td>";
echo "<td align=center bgcolor=$color><a href=\"staff_ef.php?op=m&id=".$row['id']."\">Modify</a> || ";
echo "<a href=\"staff_ef.php?op=d&id=".$row['id']."\">Del</a></td>";
}
echo "</table>";
}

footer();

echo "</body>";
echo "</html>";
?>
