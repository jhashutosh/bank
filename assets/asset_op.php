<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$asset_desc=$_REQUEST['asset_description'];
$face_value=$_REQUEST['face_value'];
$type_of=$_REQUEST['type_of'];
$current_value=$_REQUEST['current_value'];
$depreciation_method=$_REQUEST['depreciation_method'];
$rate_of_depreciation=$_REQUEST['rate_of_depreciation'];
$action_date=$_REQUEST['current_date'];
$remarks=$_REQUEST['remarks'];
$gl_code=$_REQUEST['gl_code'];
$fy=$_SESSION['fy'];
getDetailFy($fy,$f_start_dt,$f_end_dt);
$x=$_SESSION['fy'];
$x=explode('-',$x);
$f_start_dt="31/03/".$x[0];
//echo $f_start_dt;
echo "<html>";
echo "<head>";
echo "<script src='../../bank/JS/loading2.js'></script>";
echo "<script src='../../bank/JS/calendar.js'></script>";
echo "<title>Asset Management";
echo "</title>";
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";
?>
<SCRIPT LANGUAGE="JavaScript">
function f2(str){
//alert(str)
showHintop(str);
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
function validator1(f)
	{	//alert("ok");
		var msg='';//alert("msg");
		if(f.type_of.value==null || f.type_of.value=='')
		{
			msg+="Please Select Asset Master..\n";//return false;
		}
		if(f.asset_description.value==null || f.asset_description.value=='')
		{
			msg+="Please Give Asset Description..\n";//return false;
		}
		if(f.face_value.value==null || f.face_value.value=='')
		{
			msg+="Please Give Face Value..\n";//return false;
		}
		if(f.current_value.value==null || f.current_value.value=='')
		{
			msg+="Please Give Current Value..\n";//return false;
		}
		if(f.depreciation_method.value==null || f.depreciation_method.value=='')
		{
			msg+="Please Select Depreciation..\n";//return false;
		}
		if(f.rate_of_depreciation.value==null || f.rate_of_depreciation.value=='')
		{
			msg+="Please Give Rate of Depreciation..\n";//return false;
		}
		if(msg==''){
			return true;
		}
		else{
			alert(msg);
			return false;
		}
	}
</script>
<?php
//-------------------INSERT------------------------------------------------------------------

if($_REQUEST['op']=='i'){
$asset_id="AID-".getNExtVal("asset_id");
//echo $gl_code;
if($depreciation_method=='no'){$rate_of_depreciation=0;}
//$fy=getFy($action_date);
$fy='2013-2014';
if(empty($fy)){
echo "<h1><center><b>You Can't Insert any value Into database Because Financial Year already Locked by administrator !!!!!!!!!";
}
else{
$sql_statement="INSERT INTO asset_master (asset_id,asset_type,asset_desc,gl_code, face_value,current_value,dep_method,dep_rate,action_date,entry_time,depreciation_amount, original_value,posting_date) VALUES('$asset_id','$type_of',lower('$asset_desc'),'$gl_code',$face_value,$current_value,'$depreciation_method',$rate_of_depreciation,'$action_date',CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP),".($face_value-$current_value).",$current_value,'$action_date')";
//echo $sql_statement;
$t_id=getTranId();

$sql_statement.=";INSERT INTO gl_ledger_hrd (tran_id,type,action_date,fy,operator_code,entry_time)VALUES ('$t_id','$menu','$action_date','$fy','$staff_id', CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
//echo $sql_statement;
//gl_ledger_dtl
echo $gl_code;
$sql_statement.=";INSERT INTO gl_ledger_dtl (tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES ('$t_id','$asset_id', '$gl_code',$current_value,'Dr','Opening')";
// change on 15-11-2013
$gl_code=getIndex($all_assets_array,$gl_code);
$rate_id=getNExtVal("rate_id");
//$depreciation_method=getIndex($depreciation_method_array,$depreciation_method);

if($depreciation_method=='no'){$rate_of_depreciation=0;}

	
$sql_statement.=";INSERT INTO yearly_dep_app_rate_setting (id,asset_id,at_the_rate,dep_method,charge_from) VALUES('$rate_id','$asset_id','-$rate_of_depreciation','$depreciation_method','$action_date')";


//Change upto

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
echo "<form name=\"form1\" method=\"post\" action=\"asset_op.php?menu=ast&op=i\" onSubmit=\"return validator1(this);\">";
echo "<table align=center width=100% bgcolor=\"\" class='border'>";
echo "<tr><th colspan=\"6\" bgcolor=\"#A52A2A\"><font color=white size=5>Bank Assets Management</font></th>";
echo "<tr>";
echo "<td bgcolor=\"#5F9EA0\"> Asset Master:<td bgcolor=\"#5F9EA0\">";
makeSelectwithJS($asset_type_array,'type_of',"","type_of","onChange=\"f2(this.value);\" onblur=\"return validator1(this);\"");
echo "<td bgcolor=\"#5F9EA0\">Asset Sub Type:<td bgcolor=\"#5F9EA0\">";
//makeSelect($test_array,'gl_code',"");
?>
<span id="txtHint"></span>
<?php
echo "<td bgcolor=\"#5F9EA0\">Asset Description:<td bgcolor=\"#5F9EA0\"><input type=TEXT name=\"asset_description\" id=\"asset_description\" size=\"20\" onblur=\"return validator1(this);\" $HIGHLIGHT></td>";
echo "<tr>";
echo "<td bgcolor=\"#5F9EA0\" >Face Value:<td bgcolor=\"#5F9EA0\" colspan=2><input type=TEXT name=\"face_value\" id=\"face_value\" size=\"12\" onblur=\"return validator1(this);\" $HIGHLIGHT>";
echo "<td bgcolor=\"#5F9EA0\">Current Value:<td bgcolor=\"#5F9EA0\"colspan=2><input type=TEXT name=\"current_value\" id=\"current_value\" size=\"12\" onblur=\"return validator1(this);\" $HIGHLIGHT>";
echo "</tr><tr>";
echo "<td bgcolor=\"#5F9EA0\" >Current Value As On:<td bgcolor=\"#5F9EA0\"colspan=2> <font size=\"3\" ><input type=\"hidden\" name=\"current_date\" size=\"12\" VALUE=\"$f_start_dt\"> &nbsp;&nbsp;&nbsp;".$f_start_dt;

//echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(form1.current_date,'dd/mm/yyyy','Choose Date')\">";
echo "<td bgcolor=\"#5F9EA0\" >Depreciation Method:<td bgcolor=\"#5F9EA0\"colspan=2>";
makeSelectwithJS($depreciation_method_array,'depreciation_method',"",'depreciation_method',"onchange=\"f4(this.value);\" onblur=\"return validator1(this);\"");
echo "<tr>";
echo "<td bgcolor=\"#5F9EA0\">Rate Of Depreciation :<td  bgcolor=\"#5F9EA0\"colspan=2><input type=TEXT name=\"rate_of_depreciation\" id=\"rate_of_depreciation\" size=\"2\" VALUE=\" \"  onblur=\"return validator1(this);\" $HIGHLIGHT> %";
//echo"<tr>";
echo $gl_code;
echo "<td bgcolor=\"#5F9EA0\" align=\"center\" colspan=3><input type=\"RESET\" name=\"RESET_BUTTON\" value=\"Reset\" $HIGHLIGHT>";
echo"<input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Submit\" $HIGHLIGHT>";
/*
$sql_statment="select liab_gl_code from asset_depreciation_link where asset_gl_code='$q1'";
		//echo $sql_statment;
		$result=dBConnect($sql_statment);
		$liab_code=pg_fetch_result($result,liab_gl_code);
		//echo $liab_code;
		if(empty($liab_code))
			{
		$sql_statement="SELECT asset_id from asset_master where gl_code='$q1' order by asset_id";
		//echo $sql_statement;
 		$result=dBConnect($sql_statement);
		 echo "<select name=\"asset_id\" id=\"asset_id\" onchange=\"window.open('asset_depre.php?gl_code=$q1&sub_hdr=$q','_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=150,left=350, width=900,height=400');\">";
		 if(pg_NumRows($result)==0) {
		 echo "<option>Null</option>";
		}
*/
echo "</table>";
echo "</form>";

//-------------Display-----------------------------------------------------------------------
echo "<hr>";
/*
$sql_statement="SELECT SUM(current_value-round((dep_rate* current_value*(CASE WHEN (current_date-action_date)>1 THEN current_date-action_date ELSE 0 END))/36500)) as current_value from asset_master";
//echo "$sql_statement";
$result=dBConnect($sql_statement);
$row=pg_fetch_array($result);
*/

//if(pg_NumRows($result)==0) {
//echo "<h4>Record Not Found !!!!!</h4>";
//} else {
echo "<table valign=\"top\" width=\"100%\" class='border'>";
echo "<tr><td bgcolor=\"green\" colspan=\"8\" align=\"center\"><font color=\"white\">Bank Asset Details</font>";
// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color width=\"10%\">Asset Id</th>";
echo "<th bgcolor=$color width=\"20%\">Asset Type</th>";
echo "<th bgcolor=$color width=\"15%\">Asset Description</th>";
echo "<th bgcolor=$color width=\"10%\">Purchase Value</th>";
echo "<th bgcolor=$color width=\"10%\">Opening Value</th>";
echo "<th bgcolor=$color width=\"10%\">Depriciation (recent)</th>";
echo "<th bgcolor=$color width=\"15%\">Current Value</th>";
echo "<th bgcolor=$color width=\"8%\">Operation</th>";

echo "<tr><td colspan=\"8\" align=center><iframe src=\"asset_db.php?status=$op&menu=$menu\" width=\"100%\" height=\"250\" ></iframe>";
//total-------------------------------------------------------------------------------

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
