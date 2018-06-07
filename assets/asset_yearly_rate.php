<?
include "../config/config.php";
$staff_id=verifyAutho();
$fy=$_SESSION['fy'];
getDetailFy($fy,&$f_start_dt,&$f_end_dt);
$menu=$_REQUEST['menu'];
$type_of=$_REQUEST['type_of'];
$charge_on=$_REQUEST['charge_on'];
$charge_from=$_REQUEST['charge_from'];
$dep_app_method=$_REQUEST['dep_app_method'];
$depreciation_method=$_REQUEST['depreciation_method'];
$rate_of_depreciation=$_REQUEST['rate_of_depreciation'];
echo "<html>";
echo "<head>";
echo "<script src=\"../JS/loading2.js\"></script>";
//echo "<script src=\"../JS/calendar.js\">";
echo "<title>Asset Management";
echo "</title>";
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";
?>
<script language="javascript">
function varify(){
//alert(document.parent.loan_no.value.length)
if(document.parent.id.value.length==0){
 alert('You Dont Select any Loan Account')
 document.parent.id.focus();
 return false;
  }
}
</script>
<SCRIPT LANGUAGE="JavaScript">
function f2(str){
//alert(str);
//document.form1.gl_code.disabled=true;
showHint_sub(str);
}
function f3(str,q){
//alert(str);
//document.form1.gl_code.disabled=true;
showHint_id(str,q);
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
$rate_id=getNExtVal("rate_id");
if($depreciation_method=='no'){$rate_of_depreciation=0;}
$fy=getFy($action_date);
if(empty($fy)){
echo "<h1><center><b>You Can't Insert any value Into database Because Financial Year already Locked by administrator !!!!!!!!!";
}
else{
	if($dep_app_method=='da'){
$sql_statement="INSERT INTO yearly_dep_app_rate_setting (id,asset_id,charge_on,at_the_rate,dep_method,charge_from) VALUES('$rate_id','$asset_id','$charge_on','-$rate_of_depreciation','$depreciation_method','$charge_from')";
echo $sql_statement;
	}
	else{
$sql_statement="INSERT INTO yearly_dep_app_rate_setting (id,asset_id,charge_on,at_the_rate,dep_method,charge_from) VALUES('$rate_id','$asset_id','$charge_on','$rate_of_depreciation','$depreciation_method','$charge_from')";
echo $sql_statement;
	}
}
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
echo "<form name=\"form1\" method=\"post\" action=\"asset_yearly_rate.php?menu=ast&op=i&gl_code=$gl_code\">";
echo "<table align=center width=100% bgcolor=\"BLACK\">";
echo "<tr><th colspan=\"7\" bgcolor=\"#A52A2A\"><font color=white size=5>Yearly Rate Setting</font></th>";
echo "<tr>";
echo "<td bgcolor=\"#5F9EA0\"> Asset Master:<td bgcolor=\"#5F9EA0\">";
makeSelectwithJS($asset_type_code_array,'type_of',"","type_of","onChange=\"f2(this.value);\"");
echo "<td bgcolor=\"#5F9EA0\">Asset Sub Type:<td bgcolor=\"#5F9EA0\"colspan=4>"; 
?>
<span id="txtHint"></span>
<?
echo "<tr>";
echo "<td bgcolor=\"#5F9EA0\" >Charge From:<td bgcolor=\"#5F9EA0\"colspan=1><input type=TEXT name=\"charge_from\" size=\"12\" VALUE=\"$f_start_dt\" $HIGHLIGHT>";
echo "<td bgcolor=\"#5F9EA0\" >Charge As On:<td bgcolor=\"#5F9EA0\"colspan=1><input type=TEXT name=\"charge_on\" size=\"12\" VALUE=\"$f_end_dt\" $HIGHLIGHT>";
echo "<td bgcolor=\"#5F9EA0\" >Depreciation Method:<td bgcolor=\"#5F9EA0\"colspan=2>";
makeSelectwithJS($depreciation_method_array,'depreciation_method',"",'depreciation_method',"onchange=\"f4(this.value);\"");
echo "<tr>";
echo "<td bgcolor=\"#5F9EA0\" >Depreciation/Appreciation:<td bgcolor=\"#5F9EA0\"colspan=1>";
//$depreciation=makeSelectDepreMethod($dep_app_method_array,'dep_app_method',"onchange=\"f4(this.value);\"");
makeSelectwithJS($dep_app_method_array,'dep_app_method',"",'dep_app_method',"");
echo "<td bgcolor=\"#5F9EA0\">Rate Of Depreciation :<td  bgcolor=\"#5F9EA0\"colspan=1><input type=TEXT name=\"rate_of_depreciation\" size=\"3\" VALUE=\" \" $HIGHLIGHT> %";
//echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(form1.current_date,'dd/mm/yyyy','Choose Date')\">";
echo "<td bgcolor=\"#5F9EA0\" align=\"center\" colspan=4><input type=\"RESET\" name=\"RESET_BUTTON\" value=\"Reset\" $HIGHLIGHT><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Submit\" $HIGHLIGHT>";
echo "</table>";
echo "</form>";
//--------------------------------------------Display---------------------------------------
echo "<hr>";
//$sql_statement="SELECT SUM(current_value-round((dep_rate* current_value*(CASE WHEN (current_date-action_date)>1 THEN current_date-action_date ELSE 0 END))/36500)) as current_value from asset_master";
//echo "$sql_statement";
//$result=dBConnect($sql_statement);
//$row=pg_fetch_array($result);

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
echo "<th bgcolor=$color width=\"25%\">Rate</th>";
echo "<th bgcolor=$color width=\"15%\">Dep/App</th>";
echo "<th bgcolor=$color width=\"25%\">Dep Type</th>";
echo "<tr><td colspan=\"6\" align=center><iframe src=\"yearly_db.php?status=$op&menu=$menu\" width=\"100%\" height=\"300\" ></iframe>";
//total-------------------------------------------------------------------------------
//echo "<tr><th bgcolor=\"AQUA\" colspan=\"3\">Total:<th bgcolor=\"AQUA\" align=\"RIGHT\">".amount2Rs($row['current_value'])."<th bgcolor=\"AQUA\">";
//}
//

?>
<script language="JavaScript" type="text/javascript">
 var frmvalidator  = new Validator("form1");
  frmvalidator.addValidation("type_of","req","Please enter Asset Master");
 // frmvalidator.addValidation("face_value","req","Please enter Face Value Of Assets");
 // frmvalidator.addValidation("asset_description","req","Please enter the description of Assets");
 // frmvalidator.addValidation("current_value","req","Please enter the Current Value of Assets");
  frmvalidator.addValidation("depreciation_method","req","Please enter depreciation Method");
  frmvalidator.addValidation("rate_of_depreciation","req","Please enter the rate of depreciation");
  //frmvalidator.addValidation("rate_of_depreciation","maxlen=2","Max length for rate of depreciation is 2");
  //frmvalidator.addValidation("rate_of_depreciation","dec","Enter Decimal or Number Only");
  frmvalidator.addValidation("current_value","dec","Enter Decimal or Number Only");
  frmvalidator.addValidation("face_value","dec","Enter Decimal or Number Only");
  frmvalidator.addValidation("asset_description","alpha_s","Only Alphabetic Characters and Space Allow for description of assets");
</script>
