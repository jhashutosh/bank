<?php
include "../config/config.php";
$staff_id=verifyAutho();
$op=$_REQUEST['op'];
$customer_id=$_REQUEST['id'];
$id=$customer_id;
$menu=$_REQUEST['menu'];
$type=trim($_REQUEST['type']);
$ac_date=(empty($BALANCE_POSTING_DATE))?date('d/m/Y'):$BALANCE_POSTING_DATE;
echo "<HTML>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";

echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
?>
<script type="text/javascript">
/*function showSignature(e){
	var unicode=e.charCode? e.charCode : e.keyCode;
	//alert(unicode)
	
	if(unicode==114){
	
	 	var c_no=document.f1.c_id.value;
		var file="../customer/signature.php?A="+c_no;
			
		childWindow=open(file,window, 'addressbar=no,toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=300,left=150, width=900,height=550');
    		if(childWindow.opener == null) childWindow.opener = self;	
		}
	
	return numbersonly(e);
	
}*/
//****************************************************************************************************************
function alert1(node){
	node.value="";
	node.value=document.getElementById("ac_ty").value;
	document.getElementById("hintspan").innerHTML="";
	//node.focus
	//alert("You can't select.");
	return false;
}
function click1(node){
	var a=document.getElementById("ac_no").value;	
	node.value="";node.value=a;
//node.focus();
}
function numbersonly(e){
	var unicode=e.charCode? e.charCode : e.keyCode;
	//alert(unicode)
	if (unicode!=8){ 
		if (unicode<=46||unicode>57||unicode==47) {
			return false;		
		}
	}
	else{
if(document.getElementById("ac_ty").value==document.getElementById("ac_no").value){return false;}else{return true;}
	
	}
}
function showaccounthints(e){
		//alert("okkkkk");return true;
		var a1=document.getElementById("ac_no").value;
		var a2=document.getElementById("ac_ty").value;
		if(a1!=a2){
		
		var accountno=a1;
			if (window.XMLHttpRequest) // code for IE7+, Firefox, Chrome, Opera, Safari
 			{
  				xmlhttp=new XMLHttpRequest();
  			}
		else		// code for IE6, IE5
  			{
  				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
 			 }

		xmlhttp.onreadystatechange=function() {
  			if (xmlhttp.readyState==4 && xmlhttp.status==200)
    				{
				if(xmlhttp.responseText==1){
				document.getElementById("hintspan").innerHTML="<blink><font color=\"green\">OK</font></blink>";
document.getElementById("submit1").disabled=false;		
return true;
				}else{
				document.getElementById("hintspan").innerHTML=xmlhttp.responseText;
	document.getElementById("submit1").disabled=true;return true;	
			}		
					
    				}
  			}
		
		xmlhttp.open("GET","checkAccountNo1.php?accno="+ accountno+"&menu=sb",true);
		xmlhttp.send();
		//alert()
	}
	else{document.getElementById("hintspan").innerHTML="";}
}
</script>

<?php

echo "<BODY bgcolor=\"silver\" onload=\"op_dt.focus();\">";
if(empty($op)){
$name="Customer Id :";
$flag=getGeneralInfo_Customer($id);
echo $flag;
}
else{
$name="Bank Id :";
$flag=$flag=getBankInfo($id,$menu);
}
if($flag==1){
echo"<hr>";
$RCOLOR="#F5F5DC";
echo "<table width=\"95%\" bgcolor=\"BLACK\" align=\"CENTER\">";
echo "<tr><th colspan=\"4\" bgcolor=green><b><font color=White>".$type_of_account1_array[trim($type)]." A/C. open Form</font></b></th>";
echo "<form name=\"f1\" method=\"POST\" action=\"customer_ac_open_eadd.php?menu=$menu&op=$op\" >";
echo "<tr><td bgcolor=\"$RCOLOR\">$name  <td bgcolor=\"$RCOLOR\"><input type=\"TEXT\" name=\"id\" size=10 value=\"$customer_id\" readonly $HIGHLIGHT>";
echo "<td bgcolor=\"$RCOLOR\">Opening Date:<td bgcolor=\"$RCOLOR\"><input type=\"TEXT\" name=\"op_dt\" id=\"op_dt\" size=\"10\"
 value=\"$ac_date\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"date1\" value=\"...\" onclick=\"showCalendar(f1.op_dt,'dd/mm/yyyy','Choose Date')\">";
if(empty($op)){
if($type=='ds'){$COL=1;}
else{$COL=3;}

$account_sql="select case when  MAX(cast(substr(account_no,position ('-' in account_no)+1) as integer)) is null then 1 else  (MAX(cast(substr(account_no,position ('-' in account_no)+1) as integer))+1) end id from customer_account where account_no like '".strtoupper($type)."-%'";
$account_res=dBConnect($account_sql);
//echo $account_sql;
$acc_no=pg_fetch_array($account_res,0);
$member_id=strtoupper($type)."-".$acc_no['id'];

//if ($type!='sb'){
if (true){
echo "<tr><td bgcolor=\"$RCOLOR\">Account No. : <td bgcolor=\"$RCOLOR\" colspan=\"$COL\"><input type=\"HIDDEN\" name=\"ac_ty\" id=\"ac_ty\" size=5 value=\"".strtoupper($type)."-\" readonly><input type=\"TEXT\" name=\"ac_no\" id=\"ac_no\" size=15 value=\"$member_id\" $HIGHLIGHT onkeypress=\"return numbersonly(event);\" onkeyup=\"return showaccounthints(event);\" onselect=\"return alert1(this);\" onclick=\"return click1(this);\"><span id=\"hintspan\"></span>";
}
if($type=='ds'){
echo "<td bgcolor=\"$RCOLOR\">Agent:<td bgcolor=\"$RCOLOR\">";
makeSelectFromDBWithCode('v_code','v_name','vendor_master','agent','');
}
if($type=='pfsb'){
echo "<tr><td bgcolor=\"$RCOLOR\">Account Type : <td bgcolor=\"$RCOLOR\" colspan='3' ><input type=\"TEXT\" name=\"type\" size=15 value=\"".$type_of_account1_array[trim($type)]."\" readonly $HIGHLIGHT>";}
else{echo "<tr><td bgcolor=\"$RCOLOR\">Account Type : <td bgcolor=\"$RCOLOR\" ><input type=\"TEXT\" name=\"type\" size=15 value=\"".$type_of_account1_array[trim($type)]."\" readonly $HIGHLIGHT>";
}

if($type=='ln'){
$source_type=getSourceType($id);
if ($source_type=='ccb'){$header=$ccb_loan_array;}
if ($source_type=='cm'){$header=$comercial_loan_array;}
//if ($source_type=='po'){}
if ($source_type=='gvt'){$header=$govt_loan_array;}
if ($source_type=='ot'){$header=$other_loan_array;}
echo "<td>Account Head : <td>";
makeSelect($header,'code','');
}
echo "<input type=\"HIDDEN\" name=\"type\" size=15 value=\"".$type_of_account1_array[trim($type)]."\" readonly $HIGHLIGHT>";
}
else{
echo "<tr><td bgcolor=\"$RCOLOR\">Account Type : <td bgcolor=\"$RCOLOR\"><input type=\"TEXT\" name=\"type\" size=15 value=\"".$type_of_account1_array[trim($type)]."\" readonly $HIGHLIGHT>";
}
if($type=='mt'){
echo "<td bgcolor=\"$RCOLOR\">MT Loan Type:<td bgcolor=\"$RCOLOR\">";
makeSelect($mtloan_type_array,'code','');
}
if($type=='pl'){
echo "<td bgcolor=\"$RCOLOR\">Pledge Loan Type:<td bgcolor=\"$RCOLOR\">";
makeSelect($pledge_type_array,'code','');
}
if($type=='kpl'){
echo "<td bgcolor=\"$RCOLOR\">KVP Loan Type:<td bgcolor=\"$RCOLOR\">";
makeSelect($kpl_type_array,'code','');
}
if($type=='ccl'){
echo "<td bgcolor=\"$RCOLOR\">Cash Credit Loan Type:<td bgcolor=\"$RCOLOR\">";
makeSelect($ccl_type_array,'code','');
}
if($type=='bdl'){
echo "<td bgcolor=\"$RCOLOR\">Bond Loan Type:<td bgcolor=\"$RCOLOR\">";
makeSelect($bdl_type_array,'code','');
}
if($type=='sfl'){
echo "<td bgcolor=\"$RCOLOR\">Staff Loan Type:<td bgcolor=\"$RCOLOR\">";
makeSelect($sfl_type_array,'code','');
}
if($type=='spl'){
echo "<td bgcolor=\"$RCOLOR\">SMP Loan Type:<td bgcolor=\"$RCOLOR\">";
makeSelect($spl_type_array,'code','');
}
if($type=='ser'){
echo "<td bgcolor=\"$RCOLOR\">Service Loan Type:<td bgcolor=\"$RCOLOR\">";
makeSelect($serloan_type_array,'code','');
}

if($type=='hbl'){
echo "<td bgcolor=\"$RCOLOR\">House Loan Type:<td bgcolor=\"$RCOLOR\">";
makeSelect($hbl_type_array,'code','');
}
if($type=='car'){
echo "<td bgcolor=\"$RCOLOR\">Car Loan Type:<td bgcolor=\"$RCOLOR\">";
makeSelect($carloan_type_array,'code','');
}


if($type=='lad'){
echo "<td bgcolor=\"$RCOLOR\">LAD Loan Type:<td bgcolor=\"$RCOLOR\">";
makeSelect($lad_type_array,'code','');
}
//
if($type=='hpl'){
echo "<td bgcolor=\"$RCOLOR\">Car Loan Type:<td bgcolor=\"$RCOLOR\">";
makeSelect($hplloan_type_array,'code','');
}
if($type=='mtb'){
echo "<td bgcolor=\"$RCOLOR\">MT Betal Loan Type:<td bgcolor=\"$RCOLOR\">";
makeSelect($mtbloan_type_array,'code','');
}
if($type=='ofl'){
echo "<td bgcolor=\"$RCOLOR\">Own Fund Loan Type:<td bgcolor=\"$RCOLOR\">";
makeSelect($ofl_type_array,'code','');
}

if($type=='ks'){
echo "<td bgcolor=\"$RCOLOR\">KS Loan Type:<td bgcolor=\"$RCOLOR\">";
makeSelect($ksloan_type_array,'code','');
}

if($type=='fis'){
echo "<td bgcolor=\"$RCOLOR\">Fisary Loan Type:<td bgcolor=\"$RCOLOR\">";
makeSelect($fisloan_type_array,'code','');
}


if($type=='nf'){
echo "<td bgcolor=\"$RCOLOR\">nf Loan Type:<td bgcolor=\"$RCOLOR\">";
makeSelect($nf_type_array,'code','');
}


if($type=='sao'){
echo "<td bgcolor=\"$RCOLOR\">SAO Loan Type:<td bgcolor=\"$RCOLOR\">";
makeSelect($sao_type_array,'code','');
}



if($type=='add'){
echo "<td bgcolor=\"$RCOLOR\">GL Code:<td bgcolor=\"$RCOLOR\">";
makeSelect($add_type_array,'code','');
}
//echo "<h1>$type</h1>";
if($type=='sb'||$type=='ds'||$type=='fd'||$type=='ri'||$type=='rd'||$type=='mis'||$type=='ca'||$type=='hsb'){
echo "<td bgcolor=\"$RCOLOR\">Operation Mode:<td bgcolor=\"$RCOLOR\">";
makeSelect($account_operation_array,'mode','');

//$code=searchMember($customer_id);
if($type=='sb'){
	echo "<tr><td bgcolor=\"$RCOLOR\">Cheque Facility :<td bgcolor=\"$RCOLOR\" colspan=\"1\"><select name=\"m_fee\"><option></option><option VALUE=\"y\">Yes </option><option VALUE=\"n\">No</option></select>";
	
	}
else{
		echo "<tr><td bgcolor=\"$RCOLOR\"><td bgcolor=\"$RCOLOR\" colspan=\"1\"> <input type=\"HIDDEN\"  name=\"m_fee\" value=\"0\" $HIGHLIGHT>";
	}
	echo "<td bgcolor=\"$RCOLOR\">Opening Balance: <td bgcolor=\"$RCOLOR\" colspan=\"1\"> Rs. &nbsp;<input type=\"TEXT\"  Size=\"7\" name=\"op_bal\" value=\"0\" $HIGHLIGHT>";

	

echo "<tr><td bgcolor=\"$RCOLOR\">Nomination :<td bgcolor=\"$RCOLOR\" colspan=\"3\"> <input type=RADIO value=yes name=r1 onClick=showDiv('yy',this.checked);>Yes&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<input type=RADIO value=no name=r1 CHECKED onClick=hideDiv('yy',this.checked);>No";
echo "<div id=\"yy\" style=\"display:none;\">";
echo "<tr><td bgcolor=\"$RCOLOR\">Name of Nominee:<td bgcolor=\"$RCOLOR\"><input type=TEXT name=n_name size=15 $HIGHLIGHT>";
echo "<td bgcolor=\"$RCOLOR\">Address:<td bgcolor=\"$RCOLOR\"><input type=TEXT name=n_add size=25 $HIGHLIGHT>";
echo "<tr><td bgcolor=\"$RCOLOR\">Age:<td bgcolor=\"$RCOLOR\"><input type=TEXT name=n_age size=10 $HIGHLIGHT>";
echo "<td bgcolor=\"$RCOLOR\">Relation:<td bgcolor=\"$RCOLOR\">";
makeSelect($relation_array,'relation','');
echo "</div>";
echo "<tr><td bgcolor=\"$RCOLOR\">If Nominee is minor:<td bgcolor=\"$RCOLOR\" colspan=3>";
echo "<input type=RADIO value=yes name=r2 onClick=enable_button(this.value);> Yes&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<input type=RADIO value=no name=r2 CHECKED onClick=enable_button(this.value);>No";
echo "<tr><td bgcolor=\"$RCOLOR\">Date of Birth:<td bgcolor=\"$RCOLOR\" colspan=3><input type=\"TEXT\" name=\"ndob\" size=\"25\"  value=\"\" >";
echo "&nbsp;<input type=\"button\" name=\"b1\" value=\"...\"  onclick=\"showCalendar(f1.ndob,'dd/mm/yyyy','Choose Date')\">";
}
echo "<tr><td align=RIGHT colspan=4 bgcolor=\"$RCOLOR\"><input type=\"submit\" value=\"Submit\" id=\"submit1\" >&nbsp;";
//echo "<input type=Button value=Return onClick=\"Location.href='customer_statement.php?id=$customer_id'\"> ";
echo "</form>";
echo "</table>";
}
?>
 <script language="JavaScript" type="text/javascript">
 var frmvalidator  = new Validator("f1");
 frmvalidator.addValidation("ac_no","req","Please enter Account No.");
 frmvalidator.addValidation("m_fee","req","Please Select Cheque Facility!!!");
 frmvalidator.addValidation("op_dt","minlen=10","Please enter collect format Like dd/mm/yyyy");
 frmvalidator.addValidation("ac_no","minlen=4","Please enter the Correct Account No Like SB-123");
 frmvalidator.addValidation("op_bal","req","Opening Balance Should Not be Null!!!!!!!!!!!\n New Account just put 0 as opening Balance");
 frmvalidator.addValidation("op_bal","req","Amount Should be Numeric Number !!!!!!!!!");

</script>
<?php
echo "</body>";
echo "</HTML>";
?>
