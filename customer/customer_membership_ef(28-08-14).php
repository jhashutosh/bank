<?
include "../config/config.php";
$customer_id=$_REQUEST['id'];
$type=$_REQUEST['type'];
$status="Membership";
//$m_id=getId($type);
echo "<HTML>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<script src=\"../JS/validation.js\">";
echo "</script>";
?>
<script>
function validator1(f)
	{	//alert("ok");
		var msg='';//alert("msg");
		if(f.no_of_share.value.length==0)
		{
			f.no_of_share.focus();
			msg+="Please Give No. of Shares...\n";//return false;
		}
		if(f.val_of_share.value.length==0)
		{
			msg+="Please Give Amount Per Shares...\n";//return false;
			f.no_of_share.focus();
		}
		if(msg==''){
			return true;
		}
		else{
			alert(msg);
			return false;
		}
	}
function alert1(node){
	node.value="";
	node.value=document.getElementById("ac_ty").value;
	document.getElementById("hintspan").innerHTML="";
	//node.focus
	//alert("You can't select.");
	return false;
}
function click1(node){
	var a=document.getElementById("m_no").value;	
	node.value="";node.value=a;
//node.focus();
}
function numbersonly(e){
	var unicode=e.charCode? e.charCode : e.keyCode;
	//alert(unicode)
	if (unicode!=8){ 
		if (unicode<46||unicode>57||unicode==47) {
			return false;		
		}
	}
	else{
if(document.getElementById("ac_ty").value==document.getElementById("m_no").value){return false;}else{return true;}
	
	}
}
function showaccounthints(e){
		if(e.type=='blur'){
		document.getElementById("m_no").style.backgroundColor='white';

		}
		
		//alert("okkkkk");return true;
		var a1=document.getElementById("m_no").value;
		var a2=document.getElementById("ac_ty").value;
		if(a1!=a2){
		
		var membership_no=a1;
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
				document.getElementById("hintspan").innerHTML="<blink><font color=\"dark green\"><em>OK</em></font></blink>";
				document.getElementById("submit").disabled=false;		
				return true;
				}
				else{
				document.getElementById("hintspan").innerHTML=xmlhttp.responseText;
				document.getElementById("submit").disabled=true;return true;	
				}		
					
    				}
  			}
		
		xmlhttp.open("GET","checkMembershipno.php?membership_no="+membership_no,true);
		xmlhttp.send();
		//alert()
	}
	else{document.getElementById("hintspan").innerHTML="";}
}
</script>

<?
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<BODY bgcolor=\"silver\" onload=\"no_of_share.focus();\">";

$flag=getGeneralInfo_Customer($id);
if($flag==1){
echo "<hr>";
echo "<table width=\"100%\" bgcolor=#66CDAA>";
echo "<tr><th colspan=\"4\" bgcolor=green><b><font color=White>Membership Form</font></b></th>";
echo "<form name=\"f1\" method=\"POST\" action=\"customer_membership_eadd.php\" onSubmit=\"return validator1(this);\">";
echo "<tr><td>Customer No. : <td><input type=\"TEXT\" name=\"id\" size=10 value=\"$customer_id\" readonly $HIGHLIGHT>";

echo "<td>Membership No. : <td><input type=\"HIDDEN\" name=\"ac_ty\" id=\"ac_ty\" size=5 value=\"".strtoupper($type)."-\" readonly><input type=\"TEXT\" name=\"m_no\" id=\"m_no\" size=15 value=\"".strtoupper($type)."-\"onkeypress=\"return numbersonly(event);\"  onkeyup=\"return showaccounthints(event);\" onblur=\"return showaccounthints(event);\" onselect=\"return alert1(this);\" onclick=\"return click1(this);\" $HIGHLIGHT><span id=\"hintspan\"></span>";


echo "<tr><td>Opening Date:<td><input type=\"TEXT\" name=\"op_dt\" size=\"10\" value=\"".date('d/m/Y')."\" $HIGHLIGHT>";


echo "&nbsp;<input type=\"button\" name=\"date1\" value=\"...\" onclick=\"showCalendar(f1.op_dt,'dd/mm/yyyy','Choose Date')\">";
echo "<td>Age as on opening date. : <td><input type=\"TEXT\" name=\"op_age\" size=10 value=\"\" $HIGHLIGHT>";

//echo "<td>Membership No. : <td><input type=\"TEXT\" name=\"m_no\" size=10 value=\"$m_id\" readonly $HIGHLIGHT>";
echo "<tr><td>Status of Customer: <td><input type=\"RADIO\" name=\"type\" size=50 value=\"G\" >Govt.";
echo "&nbsp;<input type=\"RADIO\" name=\"type\"  value=\"I\" CHECKED>Individual";
echo "&nbsp;<input type=\"RADIO\" name=\"type\"  value=\"S\" >SHG";
echo "&nbsp;<input type=\"RADIO\" name=\"type\"  value=\"O\" >Other";

echo "<td colspan=1 >Member Status :<td colspan=1 align=\"LEFT\"><input type=\"RADIO\" value=\"l\" name=\"l1\" CHECKED >Live&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<input type=\"RADIO\" value=\"d\" name=\"l1\">Dead";

//echo "<td>Opening Date:<td><input type=\"TEXT\" name=\"op_dt\" size=\"10\" value=\"".date('d/m/Y')."\" $HIGHLIGHT>";
//echo "&nbsp;<input type=\"button\" name=\"date1\" value=\"...\" onclick=\"showCalendar(f1.op_dt,'dd/mm/yyyy','Choose Date')\">";
echo "<tr><td>No.of Share :<td><input type=text size=10 name=\"no_of_share\" id=\"no_of_share\" value=\"\"onkeypress=\"return numbersonly(event);\"   $HIGHLIGHT>";
echo "<td>Per Share :<td> Rs. &nbsp; <input type=text size=10 name=val_of_share id=val_of_share value=1   $HIGHLIGHT>";
echo "<tr><td>Admission Fees: <td><input type=\"TEXT\" name=\"adm\" size=10 value=\"0\" $HIGHLIGHT>";
echo "<td><b>Govt. Share :</b><td><input type=TEXT name=\"gov_sh\" size=10 id=\"gov_sh\" value=\"0\" $HIGHLIGHT>";
echo "<tr><td><b>Share Suspense :</b><td><input type=TEXT name=\"sh_sus\" size=10 id=\"sh_sus\" value=\"0\" $HIGHLIGHT>";
echo "<td>Ledger Folio No. : <td><input type=\"TEXT\" name=\"ldgr_folio\" id=\"ldgr_folio\" size=15 value=\"\" $HIGHLIGHT>";
echo "<tr><td colspan=1 >Nomination :<td colspan=1 align=\"LEFT\"><input type=RADIO value=yes name=r1 onClick=enable_txt(this.value)>Yes&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<input type=RADIO value=no name=r1 CHECKED onClick=enable_txt(this.value)>No";
echo "<td>Name of Nominee:<td><input type=TEXT name=n_name size=15 disabled $HIGHLIGHT>";
echo "<tr><td>Address:<td><input type=TEXT name=n_add size=35 disabled $HIGHLIGHT>";
echo "<td>Age:<td><input type=TEXT name=n_age size=7 value=\"0\" disabled $HIGHLIGHT>";
echo "<tr><td>Relation:<td>";
makeSelectDisabled($relation_array,'relation');
echo "<td>If Nominee is minor:<td>";
echo "<input type=RADIO value=yes name=r2 onClick=enable_button(this.value);> Yes&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<input type=RADIO value=no name=r2 CHECKED onClick=enable_button(this.value);>No";
echo "<tr><td>Date of Birth:<td><input type=\"TEXT\" name=\"ndob\" size=\"10\" value=\"\" disabled $HIGHLIGHT>";

//echo "&nbsp;<input type=\"button\" name=\"b1\" value=\"...\" onclick=\"showCalendar(f1.ndob,'dd/mm/yyyy','Choose Date')\" disabled>";
echo "<td><td><input type=submit value=Submit id=\"submit\" disabled>&nbsp;";
echo "</form>";
echo "</table>";
}
echo "</body>";
echo "</HTML>";
?>
