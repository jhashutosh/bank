<?php
include "../config/config.php";

$staff_id=verifyAutho();
$annexture_no=$_REQUEST['annexture_no'];
$annexture_desc=$_REQUEST['annexture_desc'];
$status=$_REQUEST['status'];
$op=$_REQUEST['op'];
$id=$_REQUEST['id'];

echo "<html>";
echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"st_dt.focus();\">";
$sql_statement="SELECT * from annexture_mas";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_num_rows($result)<1) {

echo "<H2><font color=#965897><I>Specify the searching criteria: </I></font></H2>";
echo "<form method=\"POST\" action=\"annexture_general_view.php?op=$op\">";

echo "<tr><td align=\"right\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

 ID: <input type=\"TEXT\" name=\"id\" size=\"15\" value=\"$id\" $HIGHLIGHT>";

echo "&nbsp<input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"   go   \">";
echo "<tr><td align=\"right\"><FONT SIZE=\"-2\">";
echo "</FONT>";
echo "</table>";
echo "</form>";
echo "<hr>";
echo "<table>";
}
echo "<table valign=\"top\" width=\"80%\" align=\"center\">";
$color=$TCOLOR;
echo "<tr><td bgcolor=\"red\" colspan=\"4\" align=\"center\"><font color=\"white\" size=5><b>Annexture details</b></font>";
echo "<tr>";
echo "<th bgcolor=$color>Id</th>";
echo "<th bgcolor=$color>Annexture Description</th>";
echo "<th bgcolor=$color>Annexture No</th>";
echo "<th bgcolor=$color>Operation</th>";
for($j=1; $j<=pg_NumRows($result); $j++) {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j-1));
echo "<tr>";
echo "<td align=center bgcolor=$color>".$row[0]."</td>";
echo "<td  bgcolor=$color>".ucwords($row[1])."</td>";
echo "<td  bgcolor=$color>".ucwords($row[2])."</td>";
echo "<td align=center bgcolor=$color><A HREF=\"annexture_2.php\">New</a> || &nbsp;<A HREF=\"annexture_2.php?op=up&id=".$row[0]."\" $HIDERESORCE>Alter</a></td>";

}
echo "<tr>";
$color="cyan";
echo "<td align=center bgcolor=$color colspan=\"4\"><B>Total:".($j-1)."</B></td>";

echo "</table>";
echo "</body>";
echo "</html>";
?>
