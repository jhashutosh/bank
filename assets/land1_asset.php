<?
include "../config/config.php";
//$staff_id=verifyAutho();
$asset_id=$_REQUEST['asset_id'];
$dag_no=$_REQUEST['dag_no'];
$mauja_no=$_REQUEST['mauja_no'];
$jl_no=$_REQUEST['jl_no'];
$gp=$_REQUEST['gp'];
$size=$_REQUEST['size'];
$reg_no=$_REQUEST['reg_no'];
$khatiyan_no=$_REQUEST['khatiyan_no'];
$str=$_REQUEST['str'];
echo "<html>";
echo "<head>";
echo "<script src=\"../JS/loading.js\"></script>";
echo "<title> Land Asset Management";
echo "</title>";

echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";
echo "<script language=\"JAVASCRIPT\">";
	echo "function closeme() { close(); }";
	echo "</script>";

//--------------------------------------------------------------------------------------------
//-------------------INSERT

if($_REQUEST['op']=='i'||$_REQUEST['op']=='u'){
if($_REQUEST['op']=='i'){
 $str="Insert Successfull";
$sql_statement="INSERT INTO land_asset (asset_id,dag_no,mauja_name,jl_no,gp_name,size,registration_no,khatin_no) VALUES('$asset_id','$dag_no','$mauja_no','$jl_no','$gp',$size,'$reg_no','$khatiyan_no')";
}
else{
 $str="Update Successfull";
$sql_statement="UPDATE land_asset SET dag_no='$dag_no',mauja_name='$mauja_no', jl_no='$jl_no',gp_name='$gp',size='$size',registration_no='$reg_no',khatin_no='$khatiyan_no' WHERE asset_id='$asset_id'";
}
echo $sql_statement;
$result=dBConnect($sql_statement);

if(pg_affected_rows($result)<1) {echo "<h3><font color=\"RED\">Failed to insert data into database.</font></h3>";
	}
else{

 header("location:land1_asset.php?asset_id=$asset_id&str=$str");
} 
}

echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\"/>";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"f1();\">";
//========================Entry Form ====================================


$sql_statement="SELECT * FROM land_asset WHERE asset_id=trim('$asset_id')";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
$val="Submit";
$op='i';
} else {
$dag_no=pg_result($result,'dag_no');
$mauja_no=pg_result($result,'mauja_name');
$jl_no=pg_result($result,'jl_no');
$gp=pg_result($result,'gp_name');
$size=pg_result($result,'size');
$reg_no=pg_result($result,'registration_no');
$khatiyan_no=pg_result($result,'khatin_no');
$op='u';
$val="Update";
}
echo "<font size=+1>$SYSTEM_TITLE</font><hr>";
echo "<form name=\"form2\" method=\"post\" action=\"land1_asset.php?menu=ast&op=$op&asset_id=$asset_id\">";
echo "<table align=center width=70% bgcolor=\"BLACK\">";
echo "<tr><th colspan=\"3\" bgcolor=\"#A52A2A\"><font color=white>Information About Land</font></th>";

echo "<tr bgcolor=\"#5F9EA0\"><td bgcolor=\"#5F9EA0\">Dag No:<td bgcolor=\"#5F9EA0\"><input type=TEXT name=\"dag_no\" value=\"$dag_no\" size=\"12\" $HIGHLIGHT>";
echo "<tr>";
echo "<tr bgcolor=\"#5F9EA0\"><td bgcolor=\"#5F9EA0\">Mouja No:<td bgcolor=\"#5F9EA0\"><input type=TEXT name=\"mauja_no\" value=\"$mauja_no\" size=\"12\" $HIGHLIGHT>";
echo "<tr bgcolor=\"#5F9EA0\"><td bgcolor=\"#5F9EA0\">Jl No:<td bgcolor=\"#5F9EA0\"><input type=TEXT name=\"jl_no\" value=\"$jl_no\" size=\"12\" $HIGHLIGHT>";
echo "<tr bgcolor=\"#5F9EA0\"><td bgcolor=\"#5F9EA0\">GP:<td bgcolor=\"#5F9EA0\"><input type=TEXT name=\"gp\" value=\"$gp\" size=\"12\" $HIGHLIGHT>";
echo "<tr bgcolor=\"#5F9EA0\"><td bgcolor=\"#5F9EA0\">Size:<td bgcolor=\"#5F9EA0\"><input type=TEXT name=\"size\" value=\"$size\" size=\"5\" $HIGHLIGHT> satak";
echo "<tr bgcolor=\"#5F9EA0\"><td bgcolor=\"#5F9EA0\">Registration no:<td bgcolor=\"#5F9EA0\"><input type=TEXT name=\"reg_no\" value=\"$reg_no\" size=\"12\" $HIGHLIGHT>";
echo "<tr bgcolor=\"#5F9EA0\"><td bgcolor=\"#5F9EA0\">Khatiyan No:<td bgcolor=\"#5F9EA0\"><input type=TEXT name=\"khatiyan_no\" value=\"$khatiyan_no\" size=\"12\" $HIGHLIGHT>";
echo"<tr>";
echo "<tr bgcolor=\"#5F9EA0\"><td align=\"center\" colspan=2><input type=\"BUTTON\" name=\"RESET_BUTTON\" value=\"close\" onclick=\"closeme()\" $HIGHLIGHT> $nbsp<input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"$val\" $HIGHLIGHT>";
echo "</table>";
echo "</form>";
echo "<hr><font size=+1 color=green>$str</font>";
?>
<script language="JavaScript" type="text/javascript">
 var frmvalidator  = new Validator("form2");
  frmvalidator.addValidation("dag_no","req","Please enter dag no");
  frmvalidator.addValidation("mauja_no","req","Please enter mouja no");
  frmvalidator.addValidation("jl_no","req","Please enter the jl no");
  frmvalidator.addValidation("gp","req","Please enter the gp");
  frmvalidator.addValidation("size","dec","Land Size should be decimal ");
  frmvalidator.addValidation("reg_no","req","Please enter the registration no");
  frmvalidator.addValidation("khatiyan_no","req","Please enter the khatiyan no");
  
</script>
