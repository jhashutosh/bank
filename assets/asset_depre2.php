<?
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$liab=$_REQUEST['liab_l'];
$type_of=$_REQUEST['type_of'];
//$dep=$_REQUEST['depri'];
$code=$_REQUEST['code'];
echo "<html>";
echo "<head>";
echo "<script src=\"../JS/loading2.js\"></script>";
echo "<script src=\"../JS/calendar.js\">";
echo "<title>Asset Management";
echo "</title>";
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";
?>
<SCRIPT LANGUAGE="JavaScript">
function f2(str){
//alert(str);
//document.form1.gl_code.disabled=true;
showHint(str);
}
function f4(str){
	if(str=='no'){
		document.form1.rate_of_depreciation.value=0;
		document.form1.rate_of_depreciation.disabled=true;
		}
	
	else if (str.length==0){
		document.form1.rate_of_depreciation.value="";
		document.form1.rate_of_depreciation.disabled=true;
	}
	else{
		document.form1.rate_of_depreciation.value="";
		document.form1.rate_of_depreciation.disabled=false;
		document.form1.rate_of_depreciation.focus();
		}
	}
</script>
<?
//-------------------INSERT------------------------------------------------------------------
if($_REQUEST['op']=='i'){
$gl_code=getIndex($all_assets_array,$gl_code);
$link_id=getNExtVal("link_id");
//$depreciation_method=getIndex($depreciation_method_array,$depreciation_method);
$fy=getFy($action_date);
if(empty($fy)){
echo "<h1><center><b>You Can't Insert any value Into database Because Financial Year already Locked by administrator !!!!!!!!!";
}
else{
$sql_statement="INSERT INTO asset_depreciation_link(id,gl_sub_header_code,asset_gl_code,dep_app_gl_code,liab_gl_code) VALUES('$link_id','$type_of','$gl_code','$code','$liab')";
//echo $sql_statement;
}$sql="select * from EMP_master";
$result=dBConnect($sql);
$result=dBConnect($sql_statement);
if(pg_affected_rows($result)<1) 
	{
		echo "<h3><font color=\"RED\">Failed to insert data into database.</font></h3>";
	} 
}

echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\"/>";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"f1();\">";
echo "<hr>";
//========================Entry Form ====================================
echo "<form name=\"form1\" method=\"post\" action=\"asset_depre.php?menu=ast&op=i\">";
$sql="select * from gl_master where gl_sub_header_code ='19700'";//saswata
$result=dBConnect($sql);
echo "<table align=center width=100% bgcolor=\"BLACK\">";
echo "<tr><th colspan=\"6\" bgcolor=\"#A52A2A\"><font color=white size=5>Bank Assets Management</font></th>";
echo "<tr>";
echo "<td bgcolor=\"#5F9EA0\" colspan='2'> Asset Master:<td bgcolor=\"#5F9EA0\">";
makeSelectwithJS($asset_type_array,'type_of',"","type_of","onChange=\"f2(this.value);\"");
echo "<td bgcolor=\"#5F9EA0\" colspan='2'>Asset Sub Type:<td bgcolor=\"#5F9EA0\">";
//makeSelect($test_array,'gl_code',"");
?>
<span id="txtHint"></span>
<?
echo "<tr>";
echo "<td bgcolor=\"#5F9EA0\" colspan='2' align='center'>Depreciation Ledger:<td bgcolor=\"#5F9EA0\"colspan=2>";
makeSelectFromDBWithCodeAsset('gl_mas_code','gl_mas_desc','gl_master','code');
echo"</td>";
echo"<td bgcolor=\"#5F9EA0\" align='left'>Liability Ledger:</td><td bgcolor=\"#5F9EA0\"><select name='liab_l' onchange=\"onSubmits(this.form);\">";
for($j=0; $j<pg_NumRows($result); $j++) {
$row=pg_fetch_array($result,$j);
//echo $row['eid'];
echo"<option value='".$row['gl_mas_code']."'>".$row['gl_mas_desc']."[".$row['gl_mas_code']."]</option>";
                                        }
echo"</select>";
echo"</td></tr><tr>";

echo "<td bgcolor=\"#5F9EA0\" align=\"center\" colspan='6'><input type=\"RESET\" name=\"RESET_BUTTON\" value=\"Reset\" $HIGHLIGHT><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Submit\" $HIGHLIGHT>";
echo "</table>";
echo "</form>";

///////////display------------------------------

echo "<table valign=\"top\" width=\"100%\">";
echo "<tr><td bgcolor=\"green\" colspan=\"4\" align=\"center\"><font color=\"white\">Bank Asset Details</font>";
// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor='yellow' width=\"25%\">Asset Master</th>";
echo "<th bgcolor='yellow' width=\"25%\">Asset Sub Type</th>";
echo "<th bgcolor='yellow' width=\"25%\">Depreciation Ledger</th>";
echo "<th bgcolor='yellow' width=\"25%\">Liability Ledger</th>";
echo "<tr><td colspan=\"6\" align=center><iframe src=\"depre_db.php?status=$op&menu=$menu&liab=$liab\" width=\"100%\" height=\"300\" ></iframe>";

?>
<script language="JavaScript" type="text/javascript">
 var frmvalidator  = new Validator("form1");
  frmvalidator.addValidation("type_of","req","Please enter Asset Master");
  </script>
