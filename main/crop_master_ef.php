<?php

include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$id=$_REQUEST['id'];
$desc=$_REQUEST['crop_desc'];
$op=$_REQUEST['op'];
$season=$_REQUEST['season'];
//$season=getIndex($crop_master_header,$season);
echo "<html>";
echo "<head>";
echo "<title>cropentrydetails</title>";
?>

<script language="javascript">
function onLoadFocus(){
var x=document.getElementById("D_id").value;

if(x.length==0){
  alert("Please enter the crop description");
  return false;
 
	}
//else
//{
//url="crop_details_check.php?a="+x;
//window.open(url,'crop_details_check');
//return false;

//}
}
</script>
<?php
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
//echo "<script type=\"text/javascript\" src=\"../JS/validationnext.js\"></script>";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "$season";
echo "<h1><center>INFORMATION OF CROP</center></h1>";
if (empty($op)){
echo "<hr><br><br>";
echo "<form method=\"POST\" action=\"crop_master_ef.php?op=i\">";
echo "<table bgcolor=AQUA align=center width=50%>";
$id=countRows('crop_mas');
echo "<tr><TH colspan=2 bgcolor=BLUE><font color=WHITE size=+2 align=\"center\"><b>CROP-ENTRY-FORM";
echo "<tr><td align=\"left\">Crop Id:<td><input type=\"TEXT\" name=\"id\" size=\"10\" value=\"$id\" $HIGHLIGHT READONLY><td>";
echo "<tr><td align=\"left\">Description:<td><input type=\"TEXT\" id=\"D_id\" name=\"crop_desc\" size=\"15\" value=\"$desc\" $HIGHLIGHT>";
echo "<tr><td align=\"left\">Season:<td>";
makeSelect($crop_master_array,'season','');
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Enter\" onclick=\"return onLoadFocus(this.value);\">";
echo "</table>";
echo "</form>";
}
if ($op=='up'){
$sql_statement="SELECT * from crop_mas where crop_id='$id'";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0) {
$desc=pg_result($result,1);
echo "<hr><br><br>";
echo "<form method=\"POST\" action=\"crop_master_ef.php?op=u\">";

echo "<table bgcolor=AQUA align=center width=50%>";
echo "<tr><TH colspan=2 bgcolor=BLUE><font color=WHITE size=+2 align=\"center\"><b>CROP-ENTRY-FORM";
echo "<tr><td align=\"left\">Crop Id:<td><input type=\"TEXT\" name=\"id\" size=\"10\" value=\"$id\" $HIGHLIGHT READONLY><td>";
echo "<tr><td align=\"left\">Description:<td><input type=\"TEXT\" name=\"crop_desc\" size=\"15\" value=\"$desc\" $HIGHLIGHT>";
$type=pg_result($result,2);
$type=$crop_master_array[$type];
echo "<tr><td align=\"left\">Season:<td>";

makeSelect($crop_master_array,'season',$types);
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Enter\" onclick=\"return onLoadFocus(this.value);\">";
echo "</table>";
echo "</form>";
}
else{
echo 'Wrong Crop Id';
}
}
if ($op=='u'){
$sql_statement="UPDATE crop_mas set crop_desc=lower('$desc'),season=lower('$season') where crop_id='$id'";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if (pg_affected_rows($result)<1){
	echo "<br><h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
	}
else{
	header('location:general_master_view.php?op=c');
	}
}
if ($op=='i'){
$sql_statement="INSERT INTO crop_mas(crop_id, crop_desc, season) VALUES('$id', lower('$desc'),lower('$season'))";
$result=dBConnect($sql_statement);
if (pg_affected_rows($result)<1){
	echo "<br><h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
	}
else{
	header('location:general_master_view.php?op=c');
	}
}
echo "</body>";
echo "</html>";

?>
