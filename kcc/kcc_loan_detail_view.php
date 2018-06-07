<?php
include "../config/config.php";
$staff_id=verifyAutho();
echo "<html>";
echo "<head>";
echo "<title> KCC Main </title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
$sql_statement="SELECT * from member_view ";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4>Not found!!!</h4>";
} else {
echo "<table border=\"1\">";
 echo "<tr><td bgcolor=\"green\" colspan=\"8\" align=\"center\"><font color=\"yellow\" size=\"6\">LIST OF MEMBERS</font>";
// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color colspan=\"1\">membership no</th>";
for($j=1; $j<=pg_NumRows($result); $j++) {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j-1));
echo "<tr>";
echo "<a href=\"member_del.php?membership_no=".$row['membership_no']."\" target=\"_self\">D</a></td>";
}
$color="cyan";
echo "<td align=\"right\" bgcolor=$color><B>&nbsp;</B></td>";
echo "</table>";
}
echo "</body>";
echo "</html>";
?>
