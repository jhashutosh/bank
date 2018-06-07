<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$id=$_REQUEST['id'];
$desc=$_REQUEST['mark_desc'];
$op=$_REQUEST['op'];
echo "<html>";
echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<center><font color=yellow size=6><b>Land Information</b></font></center>";
if (empty($op)){
echo "<hr><br><br>";
echo "<form method=\"POST\" action=\"land_master_ef.php?op=i\">";
echo "<table bgcolor=AQUA align=center width=50%>";
$id=countRows('land_identification_mas');
echo "<tr><TH colspan=2 bgcolor=BLUE><font color=WHITE size=+2 align=\"center\"><b>LAND-ENTRY-FORM";
echo "<tr><td align=\"left\">Mark Id:<td><input type=\"TEXT\" name=\"id\" size=\"10\" value=\"$id\" $HIGHLIGHT READONLY><td>";
echo "<tr><td align=\"left\">Mark Description:<td><input type=\"TEXT\" name=\"mark_desc\" size=\"15\" value=\"$desc\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Enter\">";
echo "</table>";
echo "</form>";
}
if ($op=='up'){
$sql_statement="SELECT * from land_identification_mas where mark_id='$id'";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0) {
$desc=pg_result($result,1);
echo "<hr><br><br>";
echo "<form method=\"POST\" action=\"land_master_ef.php?op=u\">";
echo "<table bgcolor=AQUA align=center width=50%>";
echo "<tr><TH colspan=2 bgcolor=BLUE><font color=WHITE size=+2 align=\"center\"><b>LAND-ENTRY-FORM";
echo "<tr><td align=\"left\">Crop Id:<td><input type=\"TEXT\" name=\"id\" size=\"10\" value=\"$id\" $HIGHLIGHT READONLY><td>";
echo "<tr><td align=\"left\">Description:<td><input type=\"TEXT\" name=\"mark_desc\" size=\"15\" value=\"$desc\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Enter\">";
echo "</table>";
echo "</form>";
}
else{
echo 'Wrong Crop Id';
}
}
if ($op=='u'){
$sql_statement="UPDATE land_identification_mas set mark_desc='$desc' where mark_id='$id'";
echo $sql_statement;
$result=dBConnect($sql_statement);
if (pg_affected_rows($result)<1){
	echo "<br><h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
	}
else{
	header('location:general_master_view.php?op=l');
	}
}
if ($op=='i'){
$sql_statement="INSERT INTO land_identification_mas VALUES('$id', lower('$desc'))";
$result=dBConnect($sql_statement);
if (pg_affected_rows($result)<1){
	echo "<br><h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
	}
else{
	header('location:general_master_view.php?op=l');
	}
}
echo "</body>";
echo "</html>";

?>
