<?
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$fy=$_SESSION['fy'];
getDetailFy($fy,&$f_start_dt,&$f_end_dt);
$asset_id=$_REQUEST['asset_id'];
$asset_desc=$_REQUEST['asset_description'];
$face_value=$_REQUEST['face_value'];
$type_of=$_REQUEST['type_of'];
$current_value=$_REQUEST['current_value'];
$depreciation_method=$_REQUEST['depreciation_method'];
$rate_of_depreciation=$_REQUEST['rate_of_depreciation'];
$p_mode=$_REQUEST['p_mode'];
$sales_code=$_REQUEST['sales_code'];
$remarks=$_REQUEST['remarks'];
$bank_name=$_REQUEST['bank_name'];
$branch_name=$_REQUEST['branch_name'];
$op=$_REQUEST['op'];
$cv=$_REQUEST['cv'];
$cheque_date=$_REQUEST['cheque_date'];
$ch_no=$_REQUEST['ch_no'];
$gl_code=$_REQUEST['gl_code'];
$bank_account_no=$_REQUEST['bank_ac_no'];
$tot_dep=$_REQUEST['tot_dep'];
$depreciation=$_REQUEST['depreciation'];
$partly_asset_value=$_REQUEST['partly_asset_value'];
$fully_asset_value=$_REQUEST['fully_asset_value'];
$ast_vl=$_REQUEST['ast_vl'];
$part=$_REQUEST['part'];
$part_dep=$_REQUEST['part_dep'];
$ast_val=$_REQUEST['ast_val'];

//==========================for insert=================================================
//fully
$cur_dep=$_REQUEST['cur_dep'];
$astvl=$_REQUEST['astvl'];
$sales_amount=$_REQUEST['sales_amount'];
//echo "<h1>-dep-$cur_dep-</h1>";
//echo "<h1>-Ac-$astvl-</h1>";
//partlly
$ipart=$_REQUEST['ipart'];
$partdep=$_REQUEST['partdep'];
$astval=$_REQUEST['astval'];
//echo "<h1>-Pa-$ipart-</h1>";
//echo "<h1>-Pad-$partdep-</h1>";
//echo "<h1>-Ac-$astval-</h1>";

function makeSelectwithJSfuction($element_array,$element,$id,$JSfunc){

	echo "<SELECT name=\"".$element."\" id=\"$id\" $JSfunc>";

		echo "<option value=''>Select</option>";

	while(list($key,$val)=each($element_array)){
		if($val!=$default){
			echo "<option Value=\"$key\">".$val."</option>";
		}
	}
	echo "</select>";
}

echo "<html>";
echo "<head>";
echo "<script src=\"../JS/loading2.js\"></script>";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "<script src=\"../JS/varify.js\"></script>";
?>
<SCRIPT LANGUAGE="JavaScript">
function sale_type(str){
var type=str;
//alert(type);
if (type==''){
document.getElementById("A1").style.display = "none";
document.getElementById("A2").style.display = "none";}
if (type=='fu'){
document.getElementById("A1").style.display = "none";
document.getElementById("A2").style.display = "";
var a=document.getElementById("total_depriciation").value;
document.getElementById("ast_vl").value=document.getElementById("current_value").value-a;
document.getElementById("tot_dep").value=a;

//alert (a)
}
if (type=='pa'){
document.getElementById("A2").style.display = "none";
document.getElementById("A1").style.display = "";}
}

function dep_cal(){
var dep_rate=document.getElementById("rate_of_depreciation").value;
var sale_amt=document.getElementById("part").value;
//alert(sale_amt);
var days=document.getElementById("days").value;
var dep=Math.round(sale_amt*dep_rate*days/(100*365));
document.getElementById("part_dep").value=dep;
document.getElementById("ast_val").value=sale_amt-dep;

}

</SCRIPT>
<?
echo "<link rel=\"stylesheet\" href=\"../css/autosuggest_inquisitor.css\" type=\"text/css\" media=\"screen\" charset=\"utf-8\" />";
echo "<title>Asset Sales Management";
echo "</title>";
echo "<script type=\"text/javascript\" src=\"../JS/bsn.AutoSuggest_c_2.0.js\"></script>";

//-------------------INSERT------------------------------------------------------------------
if($_REQUEST['op']=='i'){
//============================================================

$p_mode=getIndex($purchase_mode_array,$p_mode);
//$depreciation_method=getIndex($depreciation_method_array,$depreciation_method);
$mk_lk="MK-".getNExtVal("mkl_lk");
if($depreciation_method=='no'){$rate_of_depreciation=0;}
$fy=getFy($sales_date);
if(empty($fy)){
echo "<h1><center><b>You Can't Insert any value Into database Because Financial Year already Locked by administrator !!!!!!!!!";
}
else{
//Update Asset Master Table...
$sales_code=getIndex($sales_type_array,$sales_code);
//echo $sales_code;
if($sales_code=='fu'){
$sql_statement="UPDATE asset_master SET current_value=0 WHERE asset_id='$asset_id'";
}
else{
$sql_statement="UPDATE asset_master SET current_value=(current_value-".$ipart.") WHERE asset_id='$asset_id'";
}

$t_id=getTranId();
//------------------------------------FOR GL_HEADER
if($p_mode=='ch'){
$sql_statement.=";INSERT INTO gl_ledger_hrd (tran_id,type,action_date,fy,operator_code, entry_time,cheque_no,cheque_dt)VALUES ('$t_id','$menu','$sales_date','$fy','$staff_id',CAST('$sales_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP),'$ch_no','$cheque_date')";

//cheque_reg
}
else{
$sql_statement.=";INSERT INTO gl_ledger_hrd (tran_id,type,action_date, fy,operator_code, entry_time)VALUES ('$t_id','$menu','$sales_date','$fy','$staff_id', CAST('$sales_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
}
//-----------------------------------END GL_HEADER
//echo $sales_code."type<br>";
//$sales_code=getIndex($sales_type_array,$sales_code);
//echo $sales_code."type<br>";

$liab_sql="select gl_code from asset_master where asset_id='$asset_id'";
$liab_res=dBConnect($liab_sql);
$liab=pg_fetch_array($liab_res);
$gl=$liab['gl_code'];
echo $gl;
if($sales_code=='fu'){
$p_l=$sales_amount-$astvl;
$sql_statement.=";INSERT INTO gl_ledger_dtl (tran_id,account_no,gl_mas_code, amount,dr_cr, particulars) VALUES ('$t_id','$asset_id', '$gl',$cv,'Cr','sales')";
}
else{
$p_l=$sales_amount-$astval;
$sql_statement.=";INSERT INTO gl_ledger_dtl (tran_id,account_no,gl_mas_code, amount,dr_cr, particulars) VALUES ('$t_id','$asset_id', '$gl',$ipart,'Cr','sales')";

}
//$sales_code=getIndex($sales_type_array,$sales_code);
echo $p_l."=Profit/loss <br>";
echo $sales_amount."sale <br>";

//---------------------------For Profit on sales
if($p_l>0){
	$flag=1;
	$p_l_code='57999';
	$sql=";INSERT INTO gl_ledger_dtl (tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES ('$t_id','$asset_id','$p_l_code',$p_l,'Cr','profit on sales')";
}
//---------------------------For Loss on sales
else{
	$flag=2;
        $p_l_code='63999';
	$p_l=abs($p_l);
	$sql=";INSERT INTO gl_ledger_dtl (tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES ('$t_id','$asset_id','$p_l_code',$p_l,'Dr','loss on sales')";
}

//--------------------------- gl_ledger_dtl
	if($p_mode=='cash'){
	$sql_statement.=";INSERT INTO gl_ledger_dtl (tran_id, gl_mas_code,amount, dr_cr, particulars) VALUES ('$t_id','28101',$sales_amount,'Dr','cash sale')";
  			}
	else if($p_mode=='credit'){
	// For credit sales	
	
				}
	else{
	$customer_id=getData($_REQUEST['cname']);
		$bk_gl_code=getGlCode4mBank($bank_account_no);
		//for cheque
$sql_statement.=";INSERT INTO gl_ledger_dtl (tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES ('$t_id','$bank_account_no','$bk_gl_code',$sales_amount,'Dr','Cheque sale')";

// ---------------------------------insert in cheque register

$sql_statement.=";INSERT INTO cheque_reg (tran_id,action_date,entry_time,cheque_no, cheque_date,account_no,bank_name,branch,amount,status,forward_account)VALUES ('$t_id','$sales_date', CAST('$sales_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP),'$ch_no','$cheque_date', '$customer_id', '$bank_name','$branch_name',$sales_amount,'clearing','$bank_account_no')";

	}
// -------------------------------------for asset depreciation
		

if($partdep>0)
		$sql_statement.=";INSERT INTO gl_ledger_dtl (tran_id,account_no,gl_mas_code, amount,dr_cr, particulars) VALUES ('$t_id','$asset_id','64101',$partdep,'Dr','depreciation')";
		
  elseif($cur_dep>0)
$sql_statement.=";INSERT INTO gl_ledger_dtl (tran_id,account_no,gl_mas_code, amount,dr_cr, particulars) VALUES ('$t_id','$asset_id','64101',$cur_dep,'Dr','depreciation')";
		$sql_statement.=$sql;

//------------------------------for asset sales	    
		//$sql_statement.=";INSERT INTO gl_ledger_dtl (tran_id,account_no,gl_mas_code, amount,dr_cr,particulars) VALUES ('$t_id','$asset_id', '$gl_code',".($asset_sales+$dp_amount).",'Cr','Sales')";
		if($flag==2){
if($sales_code=='fu'){
//-----------------for profit of assest_sales_dtl
	$sql_statement.=";INSERT INTO asset_sale_dtl (tran_id,asset_id,mk_lk, ref_no, tran_type, action_date,asset_value, sale_value, loss_amount, profit_amount,operator_code,entry_time) VALUES('$t_id','$asset_id','$mk_lk','c-1', '$p_mode','$sales_date',$cv,$sales_amount,$p_l,0,'$staff_id',now())";
	//secho $sql_statement;

		      }
else{
$sql_statement.=";INSERT INTO asset_sale_dtl (tran_id,asset_id,mk_lk, ref_no, tran_type, action_date,asset_value, sale_value, loss_amount, profit_amount,operator_code,entry_time) VALUES('$t_id','$asset_id','$mk_lk','c-1', '$p_mode','$sales_date',$ipart,$sales_amount,$p_l,0,'$staff_id',now())";
    }			   
			    }
//-----------------for profit of assest_sales_dtl
	else{
if($sales_code=='fu'){
	$sql_statement.=";INSERT INTO asset_sale_dtl (tran_id,asset_id,mk_lk, ref_no, tran_type, action_date,asset_value,sale_value,profit_amount,	loss_amount,operator_code,
entry_time) VALUES('$t_id','$asset_id','$mk_lk','c-1','$p_mode','$sales_date',$cv,$sales_amount,$p_l,0,'$staff_id',now())";
		     }

else{
$sql_statement.=";INSERT INTO asset_sale_dtl (tran_id,asset_id,mk_lk, ref_no, tran_type, action_date,asset_value,sale_value,profit_amount,	loss_amount,operator_code,
entry_time) VALUES('$t_id','$asset_id','$mk_lk','c-1','$p_mode','$sales_date',$ipart,$sales_amount,$p_l,0,'$staff_id',now())";
}
	     }



//echo $sql_statement;
//echo $sql;
$result=dBConnect($sql_statement);
	if(pg_affected_rows($result)<1) 
	{
		echo "<h3><font color=\"RED\">Failed to insert data into database.</font></h3>";
		}
		else{

		header('location:asset_sales.php?menu=ast');
			} 

		}




//add here//===================================================
}
//----------------------------------------------------------------------------------------------
$sql_statement="select asset_id,current_value as cv,asset_desc,asset_type,action_date,dep_method,gl_code,dep_rate,face_value,depreciation_amount,case when 
case when '$f_start_dt'-action_date >0 then round(current_value*dep_rate*(current_date-'$f_start_dt')/36500,2) else round(current_value*dep_rate*(current_date-action_date)/36500,2) end 
> current_value then current_value else 
case when '$f_start_dt'-action_date >0 then round(current_value*dep_rate*(current_date-'$f_start_dt')/36500,2) else round(current_value*dep_rate*(current_date-action_date)/36500,2) end  end as cur_dep,case when '$f_start_dt'-action_date >0 then current_date-'$f_start_dt' else current_date-action_date end as days from asset_master where asset_id='$asset_id'";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
  echo "<h4>Already withdrawn or record not found!!!</h4>";
} else {
  $asset_id=pg_result($result,'asset_id');
  $gl_code=pg_result($result,'gl_code');
  $action_date=pg_result($result,'action_date');
  $asset_desc=pg_result($result,'asset_desc');
  $dep_method=pg_result($result,'dep_method');
  $dep_rate=pg_result($result,'dep_rate');
  $prev_dep=pg_result($result,'depreciation_amount');
  $face_value=pg_result($result,'face_value');
  $days=pg_result($result,'days');
  $cv=pg_result($result,'cv');
  $cur_dep=pg_result($result,'cur_dep');

  }
$sql_statement="select sum(amount) from gl_ledger_dtl where gl_mas_code ='64101' and account_no= '$asset_id' AND tran_id not in(select tran_id from asset_sale_dtl)";
$result=dBConnect($sql_statement);
$dep=pg_result($result,'sum');
//$total_dep=$prev_dep+$dep+$cur_dep;
$total_dep=$dep+$cur_dep;

echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\"/>";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"f1();\">";
echo "<hr>";

//==================================================================Entry Form =======================================================================

echo "<form name=\"form1\" method=\"post\" action=\"asset_sales_new.php?menu=ast&cv=$cv&gl_code=$gl_code\" onsubmit=\"return check();\">";
echo "<table align=center width=100% border='1'>";
echo "<tr><th colspan=\"8\" bgcolor=\"#4B0082\"><font color=white size=5>Assets Sales Form</font></th>";
echo "<tr>";
//echo $total_dep;
echo "<td bgcolor=\"#5F9EA0\"> Asset Id:<td bgcolor=\"#5F9EA0\" colspan=4><input type=TEXT name=\"asset_id\" size=\"12\" value=\"$asset_id\" readonly $HIGHLIGHT>";
echo "<td bgcolor=\"#5F9EA0\">Sales Date:<td bgcolor=\"#5F9EA0\" colspan=2><input type=TEXT name=\"sales_date\" size=\"12\" id=\"sales_date\" value=\"".date('d/m/Y')."\" readonly $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\"onclick=\"showCalendar(form1.sales_date,'dd/mm/yyyy','Choose Date')\">";
echo "<tr>";
echo "<td bgcolor=\"#5F9EA0\">Asset Description:<td bgcolor=\"#5F9EA0\" colspan=4><input type=TEXT name=\"asset_description\" size=\"30\" value=\"$asset_desc\" readonly $HIGHLIGHT>";
echo "<td bgcolor=\"#5F9EA0\" >Depreciation Method:<td bgcolor=\"#5F9EA0\" colspan=2><input type=TEXT name=\"description_method\" size=\"12\" value=\"".$depreciation_method_array[$dep_method]."\" readonly $HIGHLIGHT>";

echo "<tr>";
echo "<td bgcolor=\"#5F9EA0\">Rate Of Depreciation :<td  bgcolor=\"#5F9EA0\" colspan=3><input type=TEXT name=\"rate_of_depreciation\"  id=\"rate_of_depreciation\" size=\"4\" VALUE=\"$dep_rate\" readonly $HIGHLIGHT> %";

if(!empty($op)){
	if($sales_code!='fu'){
echo "<td bgcolor=\"#5F9EA0\" >Current Value:<td bgcolor=\"#5F9EA0\"><input type=TEXT name=\"current_value\" id=\"current_value\" size=\"12\" value=\"$cv\" readonly $HIGHLIGHT>";
		echo "<td bgcolor=\"#5F9EA0\" >Depreciation Amount:<td bgcolor=\"#5F9EA0\"><input type=TEXT name=\"depreciation\" id=\"depreciation\" size=\"12\" value=\"$part_dep\" readonly $HIGHLIGHT>";
	}else{
		echo "<td bgcolor=\"#5F9EA0\" >Depreciation Amount:<td bgcolor=\"#5F9EA0\" colspan='3'><input type=TEXT name=\"depreciation\" id=\"depreciation\" size=\"12\" value=\"$tot_dep\" readonly $HIGHLIGHT>";
		}

}
else {
echo "<td bgcolor=\"#5F9EA0\" >Current Value:<td bgcolor=\"#5F9EA0\" colspan='3'><input type=TEXT name=\"current_value\" id=\"current_value\" size=\"12\" value=\"$cv\" readonly $HIGHLIGHT>";
}
echo"<input type='hidden' name=\"total_depriciation\"  id=\"total_depriciation\" size=\"12\" value=\"$total_dep\" readonly $HIGHLIGHT>";
echo"<input type='hidden' name=\"days\"  id=\"days\" size=\"12\" value=\"$days\" readonly $HIGHLIGHT>";
if(!empty($op)){
	echo "<tr>";
 	echo "<td bgcolor=\"#5F9EA0\" >Transaction Type:<td bgcolor=\"#5F9EA0\" colspan=2><input type=TEXT name=\"p_mode\" size=\"12\" id=\"p_mode\" value=\"".$purchase_mode_array[$p_mode]."\" readonly $HIGHLIGHT>";

	if($p_mode=='ch')
	{
		echo "<td bgcolor=\"#5F9EA0\">Cheque Date:<td bgcolor=\"#5F9EA0\" colspan=2> <input type=TEXT name=\"cheque_date\" size=\"12\" id=\"cheque_date\" value=\"".date('d.m.Y')."\" $HIGHLIGHT>";
	echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" disabled onclick=\"showCalendar(form1.cheque_date,'dd/mm/yyyy','Choose Date')\">";
	echo "<td bgcolor=\"#5F9EA0\">Cheque No:<td bgcolor=\"#5F9EA0\"><input type=TEXT name=\"ch_no\" size=\"12\" id=\"ch_no\" value=\"\"  $HIGHLIGHT>";
	echo "<tr>";
	echo "<td bgcolor=\"#5F9EA0\">Bank Name:<td bgcolor=\"#5F9EA0\"><input type=TEXT name=\"bank_name\" size=\"12\" id=\" \" value=\"\"  $HIGHLIGHT>";
	echo "<td bgcolor=\"#5F9EA0\">Branch Name:<td bgcolor=\"#5F9EA0\"><input type=TEXT name=\"branch_name\" size=\"12\" id=\"\" value=\"$customer_id\"  $HIGHLIGHT>";
	echo "<td bgcolor=\"#5F9EA0\">Transfer To<td bgcolor=\"#5F9EA0\">";
selectBankAccount('bank_ac_no','');
	echo "<td bgcolor=\"#5F9EA0\">Customer Id:<td bgcolor=\"#5F9EA0\"><input type=TEXT name=\"cname\" size=\"12\" id=\"cname\" value=\"\"  $HIGHLIGHT>";
	}
	else{
echo "<td bgcolor=\"#5F9EA0\"colspan='5'>";

}
	echo "<tr>";
	echo "<td bgcolor=\"#5F9EA0\">Sales Type:<td bgcolor=\"#5F9EA0\"><input type=TEXT name=\"sales_code\" size=\"12\" value=\"".$sales_type_array[$sales_code]."\" readonly $HIGHLIGHT>";
 

	if($sales_code!='fu'){
		echo "<td bgcolor=\"#5F9EA0\">Partly Asset Value:<td bgcolor=\"#5F9EA0\"><input type=TEXT name=\"partly_asset_value\" value='$ast_val' size=\"12\" id=\" \" $HIGHLIGHT>";
	}else{
		echo "<td bgcolor=\"#5F9EA0\">Fully Asset Value:<td bgcolor=\"#5F9EA0\"><input type=TEXT name=\"fully_asset_value\" size=\"12\" value=\"$ast_vl\" readonly $HIGHLIGHT>";
		}
$sales_code=getIndex($sales_type_array,$sales_code);
	echo "<td bgcolor=\"#5F9EA0\">Sales Amount:<td bgcolor=\"#5F9EA0\" colspan=4><input type=TEXT name=\"sales_amount\" size=\"12\" id=\"sales_amount\" $HIGHLIGHT>";
}
else{
echo "<tr>";
echo "<td bgcolor=\"#5F9EA0\">Transaction Type:<td bgcolor=\"#5F9EA0\" colspan=2>";
makeSelectwithJS($purchase_mode_array,'p_mode',"","p_mode","onchange=\"f3(this.value);\"");

echo "<td bgcolor=\"#5F9EA0\">Sales Type:<td bgcolor=\"#5F9EA0\" colspan=2>";
makeSelectwithJSfuction($sales_type_array,'sales_code','sales_code',"onChange=sale_type(this.value);");
echo "<td bgcolor=\"#5F9EA0\" colspan=\"2\">";
}
if(empty($op)){$op='v';}
else{$op='i';}
//asset sale modification
echo"<tr ID='A1' style='display:none'>
<td bgcolor=\"#5F9EA0\">Partly Asset Value :</td><td bgcolor=\"#5F9EA0\"><input type='text' name='part' id='part' value='' onChange=\"dep_cal()\" onKeyup=\"dep_cal()\" $HIGHLIGHT ></td>
<td bgcolor=\"#5F9EA0\">Depreciation :</td><td bgcolor=\"#5F9EA0\"><input type='text' name='part_dep' id='part_dep' value='' $HIGHLIGHT></td>
<td bgcolor=\"#5F9EA0\">Actual Asset Value :</td><td bgcolor=\"#5F9EA0\" ><input type='text' name='ast_val' id='ast_val' value='' $HIGHLIGHT></td>
<td bgcolor=\"#5F9EA0\" colspan='2'></td></tr>


<tr ID='A2' style='display:none'>
<td colspan='2' bgcolor=\"#5F9EA0\">Total Depreciation :</td><td colspan='2' bgcolor=\"#5F9EA0\"><input type='text' name='tot_dep' id='tot_dep' value='' $HIGHLIGHT></td>
<td colspan='2' bgcolor=\"#5F9EA0\">Actual Asset Value :</td><td colspan='2' bgcolor=\"#5F9EA0\"><input type='text' name='ast_vl' id='ast_vl' value='' $HIGHLIGHT></td>
</tr>";
//end of asset sale modification
echo "<input type=\"HIDDEN\" name=\"cur_dep\" value=\"$cur_dep\">";
echo "<input type=\"HIDDEN\" name=\"curent_value\" value=\"$cv\">";
echo "<input type=\"HIDDEN\" name=\"astvl\" value=\"$ast_vl\">";
echo "<input type=\"HIDDEN\" name=\"ipart\" value=\"$part\">";
echo "<input type=\"HIDDEN\" name=\"partdep\" value=\"$part_dep\">";
echo "<input type=\"HIDDEN\" name=\"astval\" value=\"$ast_val\">";
echo "<input type=\"HIDDEN\" name=\"op\" value=\"$op\">";
echo "<tr bgcolor=\"#5F9EA0\"><td align=\"center\" colspan=8><input type=\"RESET\" name=\"RESET_BUTTON\" value=\"Reset\" $HIGHLIGHT><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Submit\" $HIGHLIGHT>";
echo "</table>";
echo "</form>";
//=================================================================================================================================================================
?>
<script language="JavaScript" type="text/javascript">
 	//var frmvalidator  = new Validator("form1");
 	//frmvalidator.addValidation("p_mode","req","Please enter the Transaction Type");
	function check(){
	if(document.form1.p_mode.value.length==0){
	alert("Please Select transaction Type !!!!!!");
	document.form1.p_mode.focus();
	return false;
	}
	if(document.form1.sales_amount.value.length==0 || !IsPNumeric(document.form1.sales_amount.value)){

		alert("sales amount should no be null and must be numeric number !!!!!!");
	document.form1.sales_amount.focus();
	return false;
	}
				
	}
	//AJAX CODE
	var options = {
		script:"autoComplete.php?json=true&op=c&",
		varname:"input",
		json:true,
	};
	var as_json1 = new AutoSuggest('cname', options);
 </script> 
