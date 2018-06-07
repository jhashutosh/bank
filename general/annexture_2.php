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
echo "<title>Annexture</title>";
?>
<script language="javascript">
function onLoadFocus(){
var x=document.getElementById("D_id").value;

if(x.length==0){
  alert("Please enter the crop description");
  return false;
 
	}
}
</script>
<?php
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<h1><center>INFORMATION OF ANNEXTURE</center></h1>";
if (empty($op)){
echo "<hr><br><br>";
echo "<form method=\"POST\" action=\"annexture_2.php?op=i\">";
echo "<table bgcolor=AQUA align=center width=50%>";
$id=countRows('annexture_mas');
echo "<tr><TH colspan=2 bgcolor=#9ACD32>Annexture Master</th>";
echo "<tr><td align=\"left\">Id:<td><input type=\"TEXT\" name=\"id\" size=\"10\" value=\"$id\" $HIGHLIGHT><td>";
echo "<tr><td align=\"left\">Annexture Description:<td><input type=\"TEXT\" id=\"D_id\" name=\"annexture_desc\" size=\"25\" value=\"$annexture_desc\" $HIGHLIGHT>";
echo "<tr><td>Annexture No  :<td><input type=TEXT name=\"annexture_no\" size=10 value=\"$annexture_no\" $HIGHLIGHT>";
echo "<tr><td><td align=CENTER><input type=submit value=ok><input type=RESET value=Reset>";
echo "</table>";
echo "</form>";
}
if ($op=='up'){
$sql_statement="SELECT * from annexture_mas where id='$id'";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0) {
$desc=pg_result($result,1);
echo "<hr><br><br>";
echo "<form method=\"POST\" action=\"annexture_2.php?op=u\">";

echo "<table bgcolor=AQUA align=center width=50%>";
echo "<tr><TH colspan=2 bgcolor=BLUE><font color=WHITE size=+2 align=\"center\"><b>ANNEXTURE DETAILS";
echo "<tr><td align=\"left\">Id:<td><input type=\"TEXT\" name=\"id\" size=\"10\" value=\"$id\" $HIGHLIGHT><td>";
echo "<tr><td align=\"left\">Annexture Description:<td><input type=\"TEXT\" id=\"D_id\" name=\"annexture_desc\" size=\"25\" value=\"$annexture_desc\" $HIGHLIGHT>";
echo "<tr><td>Annexture No  :<td><input type=TEXT name=\"annexture_no\" size=10 value=\"$annexture_no\" $HIGHLIGHT>";
echo "<tr><td><td align=CENTER><input type=submit value=ok><input type=RESET value=Reset>";
echo "</table>";
echo "</form>";
}
else{
echo 'ZZZZZ';
}
}
if ($op=='u'){
$sql_statement="UPDATE annexture_mas set annexture_desc=lower('$annexture_desc'),annexture_no=lower('$annexture_no') where id='$id'";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if (pg_affected_rows($result)<1){
	echo "<br><h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
	}
else{
	header('location:annexture_general_view.php?op=c');
	}
}
if ($op=='i'){
$sql_statement="INSERT INTO annexture_mas(id, annexture_desc, annexture_no) VALUES('$id', lower('$annexture_desc'),lower('$annexture_no'))";
$result=dBConnect($sql_statement);
if (pg_affected_rows($result)<1){
	echo "<br><h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
	}
else{
	header('location:annexture_general_view.php?op=c');
	}
}
echo "</body>";
echo "</html>";

?>
