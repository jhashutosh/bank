<?
include "../config/config.php";
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
echo "<script src=\"../JS/loading2.js\"></script>";
echo "<title>Asset Management";
echo "</title>";
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";
?>
<SCRIPT LANGUAGE="JavaScript">
function f2(str){
//alert(str)
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
//$depreciation_method=getIndex($depreciation_method_array,$depreciation_method);
$asset_id="AID-".getNExtVal("asset_id");

if($depreciation_method=='no'){$rate_of_depreciation=0;}
$fy=getFy($action_date);
if(empty($fy)){
echo "<h1><center><b>You Can't Insert any value Into database Because Financial Year already Locked by administrator !!!!!!!!!";
}
else{
$sql_statement="INSERT INTO asset_master (asset_id,asset_type,asset_desc,gl_code, face_value,current_value,dep_method,dep_rate,action_date,entry_time,depreciation_amount, original_value,posting_date) VALUES('$asset_id','$type_of',lower('$asset_desc'),'$gl_code',$face_value,$current_value,'$depreciation_method',$rate_of_depreciation,'$action_date',CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP),".($face_value-$current_value).",$current_value,'$action_date')";
//
$t_id=getTranId();

$sql_statement.=";INSERT INTO gl_ledger_hrd (tran_id,type,action_date,fy,operator_code,entry_time)VALUES ('$t_id','$menu','$action_date','$fy','$staff_id', CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
//gl_ledger_dtl
$sql_statement.=";INSERT INTO gl_ledger_dtl (tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES ('$t_id','$asset_id', '$gl_code',$current_value,'Dr','Opening')";

}
//echo $sql_statement;
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
echo "<form name=\"form1\" method=\"post\" action=\"asset_op.php?menu=ast&op=i\">";
echo "<table align=center width=100% bgcolor=\"BLACK\">";
echo "<tr><th colspan=\"6\" bgcolor=\"#A52A2A\"><font color=white size=5>Bank Assets Management</font></th>";
echo "<tr>";
echo "<td bgcolor=\"#5F9EA0\"> Asset Master:<td bgcolor=\"#5F9EA0\">";
makeSelectwithJS($asset_type_array,'type_of',"","type_of","onChange=\"f2(this.value);\"");
echo "<td bgcolor=\"#5F9EA0\">Asset Sub Type:<td bgcolor=\"#5F9EA0\">";
//makeSelect($test_array,'gl_code',"");
?>
<span id="txtHint"></span>
<?
echo "<td bgcolor=\"#5F9EA0\">Asset Description:<td bgcolor=\"#5F9EA0\"><input type=TEXT name=\"asset_description\" size=\"20\" $HIGHLIGHT><td>";
echo "<tr>";
echo "<td bgcolor=\"#5F9EA0\" >Face Value:<td bgcolor=\"#5F9EA0\" colspan=2><input type=TEXT name=\"face_value\" size=\"12\" $HIGHLIGHT>";
echo "<td bgcolor=\"#5F9EA0\">Current Value:<td bgcolor=\"#5F9EA0\"colspan=2><input type=TEXT name=\"current_value\" size=\"12\" $HIGHLIGHT>";
echo "<tr>";
echo "<td bgcolor=\"#5F9EA0\" >Depreciation Method:<td bgcolor=\"#5F9EA0\"colspan=2>";
makeSelectwithJS($depreciation_method_array,'depreciation_method',"",'depreciation_method',"onchange=\"f4(this.value);\"");
echo "<td bgcolor=\"#5F9EA0\">Rate Of Depreciation :<td  bgcolor=\"#5F9EA0\"colspan=2><input type=TEXT name=\"rate_of_depreciation\" size=\"2\" VALUE=\" \" $HIGHLIGHT> %";
echo"<tr>";
echo "<tr bgcolor=\"#5F9EA0\"><td align=\"center\" colspan=6><input type=\"RESET\" name=\"RESET_BUTTON\" value=\"Reset\" $HIGHLIGHT><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Submit\" $HIGHLIGHT>";
echo "</table>";
echo "</form>";

//-------------Display-----------------------------------------------------------------------
echo "<hr>";
$sql_statement="SELECT SUM(current_value-round((dep_rate* current_value*(CASE WHEN (current_date-action_date)>1 THEN current_date-action_date ELSE 0 END))/36500)) as current_value from asset_master";
//echo "$sql_statement";
$result=dBConnect($sql_statement);
$row=pg_fetch_array($result);

//if(pg_NumRows($result)==0) {
//echo "<h4>Record Not Found !!!!!</h4>";
//} else {
echo "<table valign=\"top\" width=\"100%\">";
echo "<tr><td bgcolor=\"green\" colspan=\"5\" align=\"center\"><font color=\"white\">Bank Asset Details</font>";
// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color width=\"10%\">Asset Id</th>";
echo "<th bgcolor=$color width=\"23%\">Asset Type</th>";
echo "<th bgcolor=$color width=\"25%\">Asset Description</th>";
echo "<th bgcolor=$color width=\"15%\">Current Value</th>";
echo "<th bgcolor=$color width=\"25%\">Operation</th>";
echo "<tr><td colspan=\"6\" align=center><iframe src=\"asset_db.php?status=$op&menu=$menu\" width=\"100%\" height=\"200\" ></iframe>";
//total-------------------------------------------------------------------------------
echo "<tr><th bgcolor=\"AQUA\" colspan=\"3\">Total:<th bgcolor=\"AQUA\" align=\"RIGHT\">".amount2Rs($row['current_value'])."<th bgcolor=\"AQUA\">";
//}
//---------------------------------------------------------------------------------------------
?>
<script language="JavaScript" type="text/javascript">
 var frmvalidator  = new Validator("form1");
  frmvalidator.addValidation("type_of","req","Please enter Asset Master");
  frmvalidator.addValidation("face_value","req","Please enter Face Value Of Assets");
  frmvalidator.addValidation("asset_description","req","Please enter the description of Assets");
  frmvalidator.addValidation("current_value","req","Please enter the Current Value of Assets");
  frmvalidator.addValidation("depreciation_method","req","Please enter depreciation Method");
  frmvalidator.addValidation("rate_of_depreciation","req","Please enter the rate of depreciation");
  //frmvalidator.addValidation("rate_of_depreciation","maxlen=2","Max length for rate of depreciation is 2");
  //frmvalidator.addValidation("rate_of_depreciation","dec","Enter Decimal or Number Only");
  frmvalidator.addValidation("current_value","dec","Enter Decimal or Number Only");
  frmvalidator.addValidation("face_value","dec","Enter Decimal or Number Only");
  frmvalidator.addValidation("asset_description","alpha_s","Only Alphabetic Characters and Space Allow for description of assets");
</script>
