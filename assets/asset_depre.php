<?
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$liab=$_REQUEST['liab_l'];
$type_of=$_REQUEST['type_of'];
//$dep=$_REQUEST['depri'];
$code=$_REQUEST['code'];
$gl_code=$_REQUEST['gl_code'];
$sub_hdr=$_REQUEST['sub_hdr'];
function getIndex2($element_array,$element){
	//print  $element_array;
	//print $element;
	while(list($key,$val)=each($element_array)){
		if(!strcmp($element,$key)) { return $key; }
	}
}
//echo $furniture_machinery_asset_array[$gl_code];
//echo $sub_hdr;
//echo $asset_type_code_array[$sub_hdr];
echo "<html>";
echo "<head>";
echo "<script src=\"../JS/loading2.js\"></script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\"/>";
echo "<script src=\"../JS/calendar.js\">";
echo "<title>Asset Management";
echo "</title>";
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";
//-------------------INSERT------------------------------------------------------------------
if($_REQUEST['op']=='i'){
//echo $gl_code;
$gl_code=getIndex2($all_assets_array,$gl_code);
$link_id=getNExtVal("link_id");
//$depreciation_method=getIndex($depreciation_method_array,$depreciation_method);
$fy=getFy($action_date);
if(empty($fy)){
echo "<h1><center><b>You Can't Insert any value Into database Because Financial Year already Locked by administrator !!!!!!!!!";
}
else{
$sql_statement="INSERT INTO asset_depreciation_link(id,gl_sub_header_code,asset_gl_code,dep_app_gl_code,liab_gl_code) VALUES('$link_id','$sub_hdr','$gl_code','$code','$liab')";
//echo $sql_statement;
}
$result=dBConnect($sql_statement);
if(pg_affected_rows($result)<1) 
	{
		echo "<h3><font color=\"RED\">Failed to insert data into database.</font></h3>";
	} 
}


echo "</head>";
echo "<body bgcolor=\"\" onload=\"f1();\">";
echo "<hr>";
//========================Entry Form ====================================
echo "<form name=\"form1\" method=\"post\" action=\"asset_depre.php?menu=ast&op=i&gl_code=$gl_code&sub_hdr=$sub_hdr\">";
$sql="select * from gl_master where gl_sub_header_code ='19700'";//saswata
$result=dBConnect($sql);
echo "<table align=center width=100% bgcolor=\"\">";
echo "<tr><th colspan=\"4\" bgcolor=\"#01A9DB\"><font color=white size=5>Bank Assets Management</font></th>";
echo "<tr>";
echo "<td bgcolor=\"#CEECF5\"> <font color='#0B2161' size='3'>Asset Master:</td><td bgcolor=\"#A9E2F3\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo $asset_type_code_array[$sub_hdr];
echo "</td><td bgcolor=\"#CEECF5\"><font color='#0B2161' size='3'>Asset Sub Type:</td><td bgcolor=\"#A9E2F3\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
if($sub_hdr=='21100')
{echo$immovable_asset_array[$gl_code];
}
if($sub_hdr=='21200')
{echo $furniture_machinery_asset_array[$gl_code];}
if($sub_hdr=='21300')
{echo $vehicles_utilities_array[$gl_code];}
 if($sub_hdr=='21400' )
{echo $livestock_array[$gl_code];}
if($sub_hdr=='21900')
{echo $miscellaneous_fixed_array[$gl_code];}
echo "</td><tr>";
echo "<td bgcolor=\"#CEECF5\" colspan= align='center'><font color='#0B2161' size='3'>Depreciation Ledger:</td><td bgcolor=\"#A9E2F3\">";
makeSelectFromDBWithCodeAsset('gl_mas_code','gl_mas_desc','gl_master','code');
echo"</td>";
echo"<td bgcolor=\"#CEECF5\" align='left'><font color='#0B2161' size='3'>Liability Ledger:</td><td bgcolor=\"#A9E2F3\"><select name='liab_l' onchange=\"onSubmits(this.form);\">";
echo "<option value=\"\" >select</option>";
for($j=0; $j<pg_NumRows($result); $j++) {
$row=pg_fetch_array($result,$j);

echo"<option value='".$row['gl_mas_code']."'>".$row['gl_mas_desc']."[".$row['gl_mas_code']."]</option>";
                                        }
echo"</select>";
echo"</td></tr><tr>";

echo "<td bgcolor=\"#5F9EA0\" align=\"center\" colspan='4'><input type=\"RESET\" name=\"RESET_BUTTON\" value=\"Reset\" $HIGHLIGHT><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Submit\" $HIGHLIGHT>";
echo "</table>";
echo "</form>";

//--------------------------display------------------------------

echo "<table valign=\"top\" width=\"100%\">";
echo "<tr><td bgcolor=\"green\" colspan=\"4\" align=\"center\"><font color=\"white\">Bank Asset Details</font>";
// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor='#A9F5BC' width=\"25%\">Asset Type</th>";
echo "<th bgcolor='#A9F5BC' width=\"25%\">Asset Sub Type</th>";
echo "<th bgcolor='#A9F5BC' width=\"25%\">Depreciation Ledger</th>";
echo "<th bgcolor='#A9F5BC' width=\"25%\">Liability Ledger</th>";
echo "<tr><td colspan=\"6\" align=center><iframe src=\"depre_db.php?status=$op&menu=$menu&liab=$liab\" width=\"100%\" height=\"300\" ></iframe>";

?>
<script language="JavaScript" type="text/javascript">
 var frmvalidator  = new Validator("form1");
  frmvalidator.addValidation("type_of","req","Please enter Asset Master");
  </script>
