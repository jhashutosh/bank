<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$asset_desc=$_REQUEST['asset_description'];
$face_value=$_REQUEST['face_value'];
$type_of=$_REQUEST['type_of'];
$purchases_date=$_REQUEST['purchases_date'];
$purchases_value=$_REQUEST['purchases_value'];
$depreciation_method=$_REQUEST['depreciation_method'];
$rate_of_depreciation=$_REQUEST['rate_of_depreciation'];
$p_mode=$_REQUEST['p_mode'];
$vname=$_REQUEST['vname'];
$cheque_date=$_REQUEST['cheque_date'];
$ch_no=$_REQUEST['ch_no'];
$bank_ac_no=$_REQUEST['bank_ac_no'];
$remarks=$_REQUEST['remarks'];
$ref_no=$_REQUEST['ref_no'];
$action_date=$_REQUEST['purchases_date'];
$gl_code=$_REQUEST['gl_code'];
echo "<html>";
echo "<head>";
echo "<script src=\"../JS/loading2.js\"></script>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<link rel=\"stylesheet\" href=\"../css/autosuggest_inquisitor.css\" type=\"text/css\" media=\"screen\" charset=\"utf-8\" />";
echo "<title>Asset Purchase Management";
echo "</title>";
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";
echo "<script type=\"text/javascript\" src=\"../JS/bsn.AutoSuggest_c_2.0.js\"></script>";
?>
<SCRIPT LANGUAGE="JavaScript">

function f2(str){
//alert(str)
//document.form1.gl_code.disabled=true;
showHintop(str);
}
function onCheck(){
	if(str.length==0){
		alert("You Should select First")
	}
	else{
		if(str=="ln"){
			alert(str)
			document.form1.gl_code.disabled=false;
		
			}
		
	}
}
function f1(){
showHint(str);
}
function f3(str){

if(str=='cash'){
//document.form1.vname.disabled=true;
//alert(str)
document.form1.cheque_date.disabled=true;
document.form1.ch_no.value=0;
document.form1.ch_no.disabled=true;
//document.form1.bank_ac_no.disabled=true;
document.form1.rm.focus();
}
if(str=='ch'){
document.form1.vname.disabled=true;
document.form1.cheque_date.disabled=false;
document.form1.ch_no.disabled=false;
document.form1.bank_ac_no.disabled=false;
document.form1.ch_no.value='';
document.form1.ch_no.focus();
}

if(str.length==0){
document.form1.ch_no.value=0;
document.form1.ch_no.disabled=true;
document.form1.bank_ac_no.disabled=true;
}
}
function f4(str){
	if(str=='no'){
		document.form1.d_rate.value=0;
		document.form1.d_rate.disabled=true;
		}
	
	else if (str.length==0){
		document.form1.d_rate.value="";
		document.form1.d_rate.disabled=true;
	}
	else{
		document.form1.d_rate.value="";
		document.form1.d_rate.disabled=false;
		document.form1.d_rate.focus();
		}
	}
</script>
<?php


//-------------------INSERT------------------------------------------------------------------
if($_REQUEST['op']=='i'){
//$gl_code=getIndex($all_assets_array,$gl_code);
/*$sql_statment="select liab_gl_code from asset_depreciation_link where asset_gl_code='$gl_code'";
		//echo $sql_statment;
		$result=dBConnect($sql_statment);
		$liab_code=pg_fetch_result($result,liab_gl_code);
		//echo $liab_code;
if(empty($liab_code)){
echo"<body onload=\"window.open('asset_depre.php?gl_code=$gl_code&sub_hdr=$type_of','_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=150,left=350, width=1000,height=400');\">";
echo"</body>";}*/
$asset_id="AID-".getNExtVal("asset_id");
$mk_lk="MK-".getNExtVal("mkl_lk");
$t_id=getTranId();
if($depreciation_method=='no'){$rate_of_depreciation=0;}
//echo $action_date;
$fy=getFy($action_date);
if(empty($fy)){
echo "<h1><center><b>You Can't Insert any value Into database Because Financial Year already Locked by administrator !!!!!!!!!";
}
else{
// ASSET MASTER
$sql_statement="INSERT INTO asset_master (asset_id,asset_type,face_value, current_value,asset_desc,gl_code,dep_method,dep_rate, action_date, entry_time, depreciation_amount, original_value,posting_date) VALUES( '$asset_id','$type_of',$purchases_value,$purchases_value,lower('$asset_desc'),'$gl_code', '$depreciation_method',$rate_of_depreciation,'$purchases_date',CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP),0,$purchases_value,'$action_date')";
//ASSET PURCHASE DTL
if($p_mode=='cr'){
$sql_statement.=";INSERT INTO asset_purchase_dtl (tran_id,asset_id,mk_lk,ref_no,tran_type,action_date,vendor_id,asset_value,current_bill_amount, operator_code,entry_time) VALUES('$t_id','$asset_id','$mk_lk','$ref_no','$p_mode', '$purchases_date','$vname',$purchases_value,'','$purchases_value','$staff_id',CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
}
else{
$sql_statement.=";INSERT INTO asset_purchase_dtl (tran_id,asset_id,mk_lk,ref_no,tran_type,action_date,asset_value,current_bill_amount,operator_code,entry_time) VALUES('$t_id','$asset_id','$mk_lk','$ref_no','$p_mode','$purchases_date',$purchases_value,0,'$staff_id',CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
}
//

if($p_mode=='cash'){
$sql_statement.=";INSERT INTO gl_ledger_hrd (tran_id,type,action_date,fy,operator_code,entry_time)VALUES ('$t_id','$menu','$purchases_date','$fy','$staff_id', CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
//gl_ledger_dtl
$sql_statement.=";INSERT INTO gl_ledger_dtl (tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES ('$t_id','$asset_id','$gl_code',$purchases_value,'Dr','Purchase')";
$sql_statement.=";INSERT INTO gl_ledger_dtl (tran_id,gl_mas_code,amount,dr_cr, particulars) VALUES ('$t_id','28101',$purchases_value,'Cr','Cash')";
}elseif($p_mode=='credit'){
$sql_statement.=";INSERT INTO gl_ledger_dtl (tran_id,gl_mas_code,amount,dr_cr, particulars) VALUES ('$t_id','28101',$purchases_value,'Cr','$p_mode')";}
else{
$bk_gl_code=getGlCode4mBank($bank_ac_no);
//gl_ledger_hrd.................
$sql_statement.=";INSERT INTO gl_ledger_hrd (tran_id,type,cheque_no,cheque_dt,action_date,fy,operator_code,entry_time)VALUES ('$t_id','$menu','$ch_no','$cheque_date','$purchases_date','$fy','$staff_id', CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
//gl_ledger_dtl.................
$sql_statement.=";INSERT INTO gl_ledger_dtl (tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES ('$t_id','$asset_id', '$gl_code',$purchases_value,'Dr','Purchase')";
$sql_statement.=";INSERT INTO gl_ledger_dtl (tran_id,gl_mas_code,account_no,amount,dr_cr, particulars)VALUES ('$t_id','$bk_gl_code','$bank_ac_no',$purchases_value,'Cr','cheque')";
}
}
$rate_id=getNExtVal("rate_id");
$sql_statement.=";INSERT INTO yearly_dep_app_rate_setting (id,asset_id,at_the_rate,dep_method,charge_from) VALUES('$rate_id','$asset_id','-$rate_of_depreciation','$depreciation_method','$action_date')";

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
//echo "<hr>";

//========================Entry Form ====================================
echo "<form name=\"form1\" method=\"post\" action=\"asset_purchases.php?menu=ast&op=i\">";
echo "<table align=center width=100% bgcolor=\"BLACK\" class=\"border\">";
echo "<tr><th colspan=\"6\" bgcolor=\"#4B0082\"><font color=white size=5>Assets Purchases</font></th>";
echo "<tr>";
echo "<td bgcolor=\"#4ED174\"> Asset Master:<td bgcolor=\"#4ED174\">";
makeSelectwithJS($asset_type_array,'type_of',"","type_of","onChange=\"f2(this.value);\"");
echo "<td bgcolor=\"#4ED174\">Asset Sub Type:<td bgcolor=\"#4ED174\" colspan=1>";
//makeSelect($test_array,'gl_code',"");
?>
<span id="txtHint"></span>
<?php
echo "<td bgcolor=\"#4ED174\">Asset Description:<td bgcolor=\"#4ED174\"><input type=TEXT name=\"asset_description\" size=\"20\" $HIGHLIGHT></td>";
echo "<tr>";
echo "<td bgcolor=\"#4ED174\" >Purchases Date:<td bgcolor=\"#4ED174\"><input type=TEXT name=\"purchases_date\" size=\"12\" VALUE=\"".date('d.m.Y')."\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(form1.purchases_date,'dd/mm/yyyy','Choose Date')\">";
echo "<td bgcolor=\"#4ED174\">Purchases Value:<td bgcolor=\"#4ED174\"><input type=TEXT name=\"purchases_value\" size=\"12\" $HIGHLIGHT>";
echo "<td bgcolor=\"#4ED174\">Reference No:<td bgcolor=\"#4ED174\"><input type=TEXT name=\"ref_no\" size=\"12\" $HIGHLIGHT>";
echo "<tr>";
echo "<td bgcolor=\"#4ED174\" >Depreciation Method:<td bgcolor=\"#4ED174\" colspan=1>";
makeSelectwithJS($depreciation_method_array,'depreciation_method',"",'depreciation_method',"onchange=\"f4(this.value);\"");
echo "<td bgcolor=\"#4ED174\">Rate Of Depreciation :<td  bgcolor=\"#4ED174\"colspan=1><input type=TEXT name=\"rate_of_depreciation\" id=\"d_rate\" size=\"2\" VALUE=\" \" $HIGHLIGHT> %</td><td bgcolor=\"#4ED174\" colspan='2'></td>";
echo "<tr>";
echo "<td bgcolor=\"#4ED174\">Payment Mode:<td bgcolor=\"#4ED174\">";
makeSelectwithJS($purchase_mode_array,'p_mode',"","p_mode","onchange=\"f3(this.value);\"");


echo "<td bgcolor=\"#4ED174\" align=\"left\" colspan=1>Vendor Name:<td bgcolor=\"#4ED174\" colspan=\"3\"><input type=\"TEXT\" name=\"vname\" size=\"35\" value=\"0\" disabled id=\"vname\" $HIGHLIGHT>";



echo "<tr>";
echo "<td bgcolor=\"#4ED174\">Cheque Date:<td bgcolor=\"#4ED174\"><input type=TEXT name=\"cheque_date\" size=\"12\" id=\"cheque_date\" value=\"".date('d.m.Y')."\" disabled $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" disabled onclick=\"showCalendar(form1.cheque_date,'dd/mm/yyyy','Choose Date')\">";
echo "<td bgcolor=\"#4ED174\">Cheque No:<td bgcolor=\"#4ED174\"><input type=TEXT name=\"ch_no\" size=\"12\" id=\"ch_no\" value=\"0\" disabled $HIGHLIGHT>";
echo "<td bgcolor=\"#4ED174\">Transfer From<td bgcolor=\"#4ED174\">";
selectBankAccount('bank_ac_no','DISABLED','');
echo "<tr>";
echo "<td bgcolor=\"#4ED174\">Remarks:<td colspan=\"5\" bgcolor=\"#4ED174\" valign=\"center\"><textarea name=\"remarks\" rows=\"2\" cols=\"80\" id=\"rm\" $HIGHLIGHT></textarea>";
echo "&nbsp;<input type=\"submit\" value=\"submit\"></tr>";
echo "</table>";
echo "</form>";

//-------------Display-----------------------------------------------------------------------
//echo "<hr>";

echo "<table valign=\"top\" width=\"100%\" class='border'>";
echo "<tr><td bgcolor=\"#8B0000\" colspan=\"8\" align=\"center\"><font color=\"white\">Asset Details</font>";
// Place line comments if you do not need column header.
$color="WHITE";
echo "<tr>";
echo "<th bgcolor=$color width=\"10%\">Asset Id</th>";
echo "<th bgcolor=$color width=\"20%\">Asset Type</th>";
echo "<th bgcolor=$color width=\"15%\">Asset Description</th>";
echo "<th bgcolor=$color width=\"10%\">Purchase Value</th>";
echo "<th bgcolor=$color width=\"10%\">Opening Value</th>";
echo "<th bgcolor=$color width=\"10%\">Depriciation (recent)</th>";
echo "<th bgcolor=$color width=\"15%\">Actual Value</th>";
echo "<th bgcolor=$color width=\"8%\">Operation</th>";
echo "<tr><td colspan=\"8\" align=center><iframe src=\"asset_db.php?status=$op&menu=$menu\" width=\"100%\" height=\"350\" ></iframe>";
//total-------------------------------------------------------------------------------


//---------------------------------------------------------------------------------------------
?>
<script language="JavaScript" type="text/javascript">
 var frmvalidator  = new Validator("form1");
  frmvalidator.addValidation("type_of","req","Please select asset type");
  frmvalidator.addValidation("purchases_date","req","Please enter purchase date Of assets");
  frmvalidator.addValidation("asset_description","req","Please enter the description of assets");
  frmvalidator.addValidation("purchases_value","req","Please enter the purchase Value of assets");
  frmvalidator.addValidation("depreciation_method","req","Please enter depreciation method");
  frmvalidator.addValidation("rate_of_depreciation","req","Please enter the rate of depreciation");
   frmvalidator.addValidation("p_mode","req","Please select payment mode");
  frmvalidator.addValidation("current_value","dec","Enter DECIMAL or number only");
  frmvalidator.addValidation("face_value","dec","Enter DECIMAL or number only");
  frmvalidator.addValidation("asset_description","alpha_s","Only Alphabetic characters and space allow for description of assets");


var options = {
		script:"autoComplete.php?json=true&op=v&",
		varname:"input",
		json:true,
	};
	var as_json1 = new AutoSuggest('vname', options);
</script>
