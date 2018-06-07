<?php
include "../sovan/config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$asset_desc=$_REQUEST['asset_description'];
$face_value=$_REQUEST['face_value'];
$type_of=$_REQUEST['type_of'];
$current_value=$_REQUEST['current_value'];
$depreciation_method=$_REQUEST['depreciation_method'];
$rate_of_depreciation=$_REQUEST['rate_of_depreciation'];
$remarks=$_REQUEST['remarks'];
$action_date='31.03.2010';
echo "<html>";
echo "<head>";
echo "<script src=\"../JS/loading.js\"></script>";
echo "<title>Asset Management";
echo "</title>";
?>
<SCRIPT LANGUAGE="JavaScript">
function onCheck(){
	if(str.length==0){
		alert("You Should select First");
	}
	else{
		if(str=="ln"){
			alert(str)
			document.form1.gl_code.disabled=false;
		
			}
		//
	}
}
function f1(){
}
function f2(str){
//document.form1.gl_code.disabled=true;
showHint(str);
}
</script>
<?php
//--------------------------------------------------------------------------------------------
//-------------------INSERT
if($_REQUEST['op']=='i'){
$gl_code=getIndex($all_assets_array,$gl_code);
$depreciation_method=getIndex($depreciation_method_array,$depreciation_method);
$asset_id="AID-".getNExtVal("asset_id");
$sql_statement="INSERT INTO asset_master (asset_id,asset_type,asset_desc,gl_code, face_value,current_value,dep_method,dep_rate,action_date,entry_time) VALUES( '$asset_id','$type_of',lower('$asset_desc'),'$gl_code',$face_value,$current_value,'$depreciation_method',$rate_of_depreciation,'$action_date',CAST('$action_date'||SUBSTR(now(),11,LENGTH(now()))AS TIMESTAMP))";

//echo $sql_statement;
$result=dBConnect($sql_statement);

if(pg_affected_rows($result)<1) {echo "<h3><font color=\"RED\">Failed to insert data into database.</font></h3>";
	} 
}

echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\"/>";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"f1();\">";
echo "<hr>";
//========================Entry Form ====================================
echo "<form name=\"form1\" method=\"post\" action=\"asset_book_new.php?menu=ast&op=i\">";
echo "<table align=center width=100% bgcolor=\"BLACK\">";
echo "<tr><th colspan=\"6\" bgcolor=\"#A52A2A\"><font color=white size=5>Bank Asset Management</font></th>";
echo "<tr>";
echo "<td bgcolor=\"#5F9EA0\"> Asset Masterd:<td bgcolor=\"#5F9EA0\">";
makeSelectwithJS($asset_type_array,'type_of',"","type_of","onChange=\"f2(this.value);\"");
echo "<td bgcolor=\"#5F9EA0\">Asset Sub Type:<td bgcolor=\"#5F9EA0\">";
makeSelect($test_array,'gl_code',"");

//echo "</td>";
echo "<td bgcolor=\"#5F9EA0\">Asset Description:<td bgcolor=\"#5F9EA0\"><input type=TEXT name=\"asset_description\" size=\"12\" $HIGHLIGHT>";
//makeSelectDisabled($ccb_loan_array,'gl_code',"");

//<span id="txtHint"></span>

echo "<tr>";
echo "<td bgcolor=\"#5F9EA0\" >Face Value:<td bgcolor=\"#5F9EA0\" colspan=2><input type=TEXT name=\"face_value\" size=\"12\" $HIGHLIGHT>";

echo "<td bgcolor=\"#5F9EA0\">Current Value:<td bgcolor=\"#5F9EA0\"colspan=2><input type=TEXT name=\"current_value\" size=\"12\" $HIGHLIGHT>";

echo "<tr>";

echo "<td bgcolor=\"#5F9EA0\">Depreciation Method:<td bgcolor=\"#5F9EA0\">";
makeSelect($depreciation_method_array,'depreciation_method',"");

echo "<td bgcolor=\"#5F9EA0\">Rate Of Depreciation :<td  bgcolor=\"#5F9EA0\"colspan=2><input type=TEXT name=\"rate_of_depreciation\" size=\"2\" VALUE=\" \" $HIGHLIGHT> %";
echo"<tr>";
echo "<tr bgcolor=\"#5F9EA0\"><td align=\"center\" colspan=6><input type=\"RESET\" name=\"RESET_BUTTON\" value=\"Reset\" $HIGHLIGHT><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Submit\" $HIGHLIGHT>";
echo "</table>";
echo "</form>";

//-------------------------------------------------

echo "<hr>";

//--------------------Display--------------------------

$sql_statement="SELECT asset_id,asset_type,initcap(asset_desc) as asset_desc,round((dep_rate* current_value*(current_date-action_date))/36500) as current_value from asset_master  ORDER BY entry_time DESC";
//echo "$sql_statement";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)==0) {
echo "<h4>Record Not Found !!!!!</h4>";
} else {
echo "<table valign=\"top\" bgcolor=BLACK width=\"60%\" align=center>";
echo "<tr><td bgcolor=\"green\" colspan=\"5\" align=\"center\"><font color=\"white\">Bank Asset Details</font>";
// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color>Asset Id</th>";
echo "<th bgcolor=$color>Asset Type</th>";
echo "<th bgcolor=$color>Asset Description</th>";
echo "<th bgcolor=$color>Current Value</th>";
echo "<th bgcolor=$color>Operation</th>";
for($j=1; $j<=pg_NumRows($result); $j++){
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j-1));
echo "<tr>";
echo "<td align=CENTER bgcolor=$color>".$row['asset_id']."</td>";
echo "<td align=CENTER bgcolor=$color>".$asset_type_array[$row['asset_type']]."</td>";
echo "<td align=CENTER bgcolor=$color>".$row['asset_desc']."</td>";
echo "<td align=CENTER bgcolor=$color>".amount2Rs($row['current_value'])."</td>";
echo "<td bgcolor=$color align=center><a href=\"asset_detail.php?op=P&asset_id=".$row['asset_id']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=700,height=500'); return false;\" >SHOW</a>";
if(trim($row['asset_type'])=='ia'){
echo "&nbsp||<a href=\"land1_asset.php?op=P&asset_id=".$row['asset_id']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=700,height=500'); return false;\" >LAND_DETAIL</a>";
//echo"<a href=\"land1_asset.php\"op=P&asset_id=".$row['asset_id']."\">LAND_DETAIL</a>";
}

 }
}
//---------------------------------------------------------------------------------------------
?>
