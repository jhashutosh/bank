<?php
include "../config/config.php";
registerSession();
$account=trim($_SESSION['current_account_no']);
$staff_id=verifyAutho();
$up=$_REQUEST["up"];
$menu=$_REQUEST["menu"];
$type=trim($_REQUEST["type"]);
echo "<html>";
echo "<head>";
echo "<title>Entry Form - Customer";
echo "</title>";
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
?>
<script language="javascript">

function checkAccount(){
	var str=document.getElementById('intro').value;
	if(str.length == 0){
		alert("Account No Should not be null!!!");
		//document.orderform.ac.focus();	
		return false;
	}
  	else{
		URL="../main/pop_up_account.php?menu=sb&account_no="+str;
	window.open(URL,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no, scrollbars=yes,top=100,left=150,width=950,height=450');
return false;
 }
}

function onLoadFocus(){
document.getElementById("name1").focus();
}
function onSubmits(f)
{
  f.submit();
}
function showaccounthints(e){
		//alert("okkkkk");return true;
		var name1=document.getElementById("name1").value;
		var father_name1=document.getElementById("father_name1").value;
		//alert(name1+father_name1)
		
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
				document.getElementById("hintspan").innerHTML="";
				document.getElementById("submit").disabled=false;
				return true;
				}else{
				//document.getElementById("submit").disabled=true;
				document.getElementById("hintspan").innerHTML=xmlhttp.responseText;
				return false;	
			}		
					
    				}
  			}
		
		
		xmlhttp.open("GET","checkname.php?name="+name1+"&father_name="+father_name1,true);
		xmlhttp.send();

	
}

</script>

<?php
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"onLoadFocus()\">";
$title='Customer';
if($up=='p'){
	$sql_statement="select * from customer_master where customer_id='$account'";
	//echo $sql_statement;
	$result=dBConnect($sql_statement);
	if(pg_NumRows($result)==0){     
                echo "<center>";
		echo "<h1><font color=red><blink>Before update any Account number you should open the Account</blink></font></h1>";
		echo "</center>";
		exit();
	}
	else
	{
		$row=pg_fetch_array($result);
		$type_of_customer=$row['type_of_customer'];
		$date_of_opening=$row['date_of_opening'];
		$name1=$row['name1'];
		$name2=$row['name2'];
		$name3=$row['name3'];
		$name4=$row['name4'];
		$father_name1=$row['father_name1'];
		$father_name2=$row['father_name2'];
		$father_name3=$row['father_name3'];
		$father_name4=$row['father_name4'];
		$sex1=$row['sex1'];
		$sex2=$row['sex2'];
		$sex3=$row['sex3'];
		$sex4=$row['sex4'];
		$dob1=$row['dob1'];
		$dob2=$row['dob2'];
		$dob3=$row['dob3'];
		$dob4=$row['dob4'];
		$telephone1=$row['telephone1'];
		$telephone2=$row['telephone2'];
		$telephone3=$row['telephone3'];
		$telephone4=$row['telephone4'];
		$email1=$row['email1'];
		$email2=$row['email2'];
		$email3=$row['email3'];
		$email4=$row['email4'];
		$voter_id_no1=$row['voter_id_no1'];
		$voter_id_no2=$row['voter_id_no2'];
		$voter_id_no3=$row['voter_id_no3'];
		$voter_id_no4=$row['voter_id_no4'];
		$pan_card_no1=$row['pan_card_no1'];
		$pan_card_no2=$row['pan_card_no2'];
		$pan_card_no3=$row['pan_card_no3'];
		$pan_card_no4=$row['pan_card_no4'];
		$introducer_id=$row['introducer_id'];
		//getSHGInfo($account,&$no_of_member,&$leader,&$group_id);
		if($_REQUEST["mo"]){
			 $type=trim($_REQUEST["type"]);
					
		}
		else
		{
			$type=getCustomerType($type_of_customer);
			
 		}

	}
}
echo "<font size=-1><B>";
if($up){echo "Update Form - $title ID is $account";}
else {echo "Entry Form - $title";}
echo "</font>";

echo "<form name=\"form2\" method=\"POST\" action=\"customer_account_ef.php?menu=$menu\">";
echo "<center><b>Type of Customer:</b>";
if(empty($type)){
makeSelectSubmit($type_of_account2_array,"type","Sole Account");
$type="Sole Account";
}
else
{
// makeSelectSubmit($type_of_account2_array,"type",$type);
  if($type=='Sole Account'||$type=='Joint Account'){
	makeSelectSubmit($type_of_change_array,"type",$type);
	}
  else{
       echo "<input type=\"TEXT\" name=\"type\" size=\"17\" value=\"$type\" $HIGHLIGHT readonly>";
    }
}
if($up)
	{
		echo "<input type=\"HIDDEN\" name=\"mo\" value=\"1\" id=\"type\">";
		echo "<input type=\"HIDDEN\" name=\"up\" value=\"p\" id=\"type\">";	
	}
echo "</form>";
echo "<hr>";
echo "<form name=\"form1\" method=\"POST\" action=\"customer_account_eadd.php?menu=$menu\">";
//echo "<form name=\"form1\" method=\"POST\" action=\"customer_account_eadd.php?menu=$menu\" onSubmit=\"return check(this.form);\">";
// --------------------------Sole account start here------------------------------------
if (($type=="Sole Account") or ($type=="NRGS")){
 
echo "<table align=center width=100% bgcolor=skyblue>";
echo "<tr><td bgcolor=\"red\" colspan=\"6\" align=\"center\"><font color=\"white\">First Holder</font>";
echo "<tr><td align=\"left\">Name:<td colspan=2 align=\"left\"><input type=\"TEXT\" name=\"name1\" id=\"name1\" size=\"20\" value=\"$name1\" $HIGHLIGHT><br>";
echo "<td align=\"left\">Father/Husband's name:<td colspan=2 align=\"left\"><input type=\"TEXT\" name=\"father_name1\" id=\"father_name1\" size=\"25\" value=\"$father_name1\" onkeyup=\"return showaccounthints(event);\" onblur=\"return showaccounthints(event);\" $HIGHLIGHT><span id=\"hintspan\"></span><br>";
if($up)
{
$VILL_DEFAULT=$row['address11'];
$POST_DEFAULT=$row['address12'];
$POLICESTATION_DEFAULT=$row['address13'];
$PIN_DEFAULT=$row['pin1'];
$caste1=RegetIndex($caste_array,$row['caste1']);
$sex1=RegetIndex($sex_array,$row['sex1']);
$qualification1=RegetIndex($customer_qualification_array,$row['qualification1']);
$occupation1=RegetIndex($customer_occupation_array,$row['occupation1']);
$identity_proof1=RegetIndex($identity_proof_array,trim($row['identity_proof1']));
$dob_proof1=RegetIndex($dob_proof_array,trim($row['dob_proof1']));
$address_proof1=RegetIndex($address_proof_array,trim($row['address_proof1']));
//$designation1=RegetIndex($designation_orga_array,$row['designation1']);

}

if(!$up){
$sex1="";
$qualification1="";
$caste1="";
$occupation1="";
//$designation1="";
$identity_proof1="";
$dob_proof1="";
$address_proof1="";
}

echo $row['address13'];
echo "<tr><td align=\"left\">Sex:<td>";
 makeSelect($sex_array,"sex1",$sex1);
echo "<td align=\"left\">Dob:<td><input type=\"TEXT\" name=\"dob1\" size=\"10\" value=\"$dob1\" $HIGHLIGHT >";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(form1.dob1,'dd/mm/yyyy','Choose Date')\">";
echo "<td align=\"left\">Caste:<td>";
 makeSelect($caste_array,"caste1",$caste1);
echo "<tr><td align=\"left\">Villege:<td><input type=\"TEXT\" name=\"address11\" size=\"15\" value=\"$VILL_DEFAULT\" $HIGHLIGHT><br>";
echo "<td align=\"left\">PO:<td><input type=\"TEXT\" name=\"address12\" size=\"15\"  value=\"$POST_DEFAULT\" $HIGHLIGHT><br>";
echo "<td align=\"left\">PS:<td><input type=\"TEXT\" name=\"address13\" size=\"15\" value=\"$POLICESTATION_DEFAULT\" $HIGHLIGHT><br>";
echo "<tr><td align=\"left\">Pin:<td><input type=\"TEXT\" name=\"pin1\" size=\"10\" value=\"$PIN_DEFAULT\" $HIGHLIGHT><br>";
echo "<td align=\"left\">Contact No:<td><input type=\"TEXT\" name=\"telephone1\" size=\"10\" value=\"$telephone1\" $HIGHLIGHT><br>";
echo "<td align=\"left\">Email:<td><input type=\"TEXT\" name=\"email1\" size=\"20\" 
value=\"$email1\" $HIGHLIGHT><br>";
echo "<tr><td align=\"left\">Qualification:<td colspan=2 align=\"left\">";
makeSelect($customer_qualification_array,"qualification1",$qualification1);
echo "<td align=\"left\">Occupation:<td colspan=2 align=\"left\">";
 makeSelect($customer_occupation_array,"occupation1",$occupation1);
echo "<tr><td align=\"left\">Voter Card No.:<td colspan=2 align=\"left\"><input type=\"TEXT\" name=\"voter_id_no1\" size=\"15\" value=\"$voter_id_no1\" $HIGHLIGHT><br>";
echo "<td align=\"left\">Pan Card No.:<td colspan=2 align=\"left\"><input type=\"TEXT\" name=\"pan_card_no1\" size=\"12\" value=\"$pan_card_no1\" maxlength=\"10\" $HIGHLIGHT>";
echo "<tr><td align=\"left\">Identity Proof:<td>";
 makeSelect($identity_proof_array,"identity_proof1",$identity_proof1);
echo "<td align=\"left\">Dob Proof:<td>";
 makeSelect($dob_proof_array,"dob_proof1",$dob_proof1);
echo "<td align=\"left\">Address Proof:<td>";
 makeSelect($address_proof_array,"address_proof1",$address_proof1);
}
//----------------------------------ORGANIZATION start here-------------------------------
elseif($type=="Organisational")
{
 echo "<table align=center width=100% bgcolor=#CCECFF;>";
 echo "<tr><td bgcolor=\"red\" colspan=\"6\" align=\"center\"><font color=\"white\">Organisation </font>";
echo "<tr><td align=\"RIGHT\" colspan=\"3\">Organisation Name:<td colspan=\"3\" align=\"left\"><input type=\"TEXT\" name=\"name1\" id=\"name1\" size=\"30\" value=\"$name1\" $HIGHLIGHT>";
if($up)
{
$VILL_DEFAULT=$row['address11'];
$POST_DEFAULT=$row['address12'];
$POLICESTATION_DEFAULT=$row['address13'];
$PIN_DEFAULT=$row['pin1'];
}
echo "<tr><td align=\"left\">Villege:<td><input type=\"TEXT\" name=\"address11\" size=\"15\" value=\"$VILL_DEFAULT\" $HIGHLIGHT>";
echo "<td align=\"Center\">PO:<td><input type=\"TEXT\" name=\"address12\" size=\"15\"  value=\"$POST_DEFAULT\" $HIGHLIGHT><br>";
echo "<td align=\"left\">PS:<td><input type=\"TEXT\" name=\"address13\" size=\"15\" value=\"$POLICESTATION_DEFAULT\" $HIGHLIGHT>";
echo "<tr><td align=\"left\">Pin:<td><input type=\"TEXT\" name=\"pin1\" size=\"15\" value=\"$PIN_DEFAULT\"><td colspan=\"2\" $HIGHLIGHT>";
echo "<td align=\"CENTER\">Pan Card No.:<td><input type=\"TEXT\" name=\"pan_card_no1\" size=\"12\" value=\"$pan_card_no1\" maxlength=\"10\" $HIGHLIGHT>";
echo "<tr><td align=\"left\">Contact No.:<td><input type=\"TEXT\" name=\"telephone1\" size=\"15\" value=\"$telephone1\"><td colspan=\"2\" $HIGHLIGHT>";
echo "<td align=\"CENTER\">Email:<td><input type=\"TEXT\" name=\"email1\" size=\"20\" value=\"$email1\" $HIGHLIGHT>";

//----------------------First organization person----------------------------------------------
echo "<tr><td bgcolor=\"green\" colspan=\"6\" align=\"center\"><font color=\"white\">First Authorised Person </font>";
echo "<tr><td align=\"left\">Name:<td colspan=2 align=\"left\"><input type=\"TEXT\" name=\"name2\" size=\"20\" value=\"$name2\" $HIGHLIGHT>";
echo "<td align=\"left\">Father/Husband's name:<td colspan=2 align=\"left\"><input type=\"TEXT\" name=\"father_name2\" size=\"25\" value=\"$father_name2\" $HIGHLIGHT><br>";
if($up)
{
$VILL_DEFAULT=$row['address21'];
$POST_DEFAULT=$row['address22'];
$POLICESTATION_DEFAULT=$row['address23'];
$PIN_DEFAULT=$row['pin2'];
$caste2=RegetIndex($caste_array,$row['caste2']);
$sex2=RegetIndex($sex_array,$row['sex2']);
$qualification2=RegetIndex($customer_qualification_array,$row['qualification2']);
$occupation2=RegetIndex($customer_occupation_array,$row['occupation2']);
$identity_proof2=RegetIndex($identity_proof_array,trim($row['identity_proof2']));
$dob_proof2=RegetIndex($dob_proof_array,trim($row['dob_proof2']));
$address_proof2=RegetIndex($address_proof_array,trim($row['address_proof2']));
$designation2=RegetIndex($designation_orga_array,$row['designation1']);

}
if(!$up){
$sex2="";
$qualification2="";
$caste2="General";
$occupation2="";
$designation1="";
$identity_proof2="";
$dob_proof2="";
$address_proof2="";
}
echo "<tr><td align=\"left\">Sex:<td>";
 makeSelect($sex_array,"sex2",$sex2);
echo "<td align=\"left\">Dob:<td><input type=\"TEXT\" name=\"dob2\" size=\"10\" value=\"$dob2\"  $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"date2\" value=\"...\" onclick=\"showCalendar(form1.dob2,'dd/mm/yyyy','Choose Date')\">";
echo "<td align=\"left\">Caste:<td>";
 makeSelect($caste_array,"caste2",$caste2);
echo "<tr><td align=\"left\">Villege:<td><input type=\"TEXT\" name=\"address21\" size=\"15\" value=\"$VILL_DEFAULT\" $HIGHLIGHT><br>";
echo "<td align=\"left\">PO:<td><input type=\"TEXT\" name=\"address22\" size=\"15\" value=\"$POST_DEFAULT\" $HIGHLIGHT><br>";
echo "<td align=\"left\">PS:<td><input type=\"TEXT\" name=\"address23\" size=\"15\" value=\"$POLICESTATION_DEFAULT\" $HIGHLIGHT><br>";
echo "<tr><td align=\"left\">Pin:<td><input type=\"TEXT\" name=\"pin2\" size=\"10\" value=\"$PIN_DEFAULT\" $HIGHLIGHT><br>";
echo "<td align=\"left\">Contact No.:<td><input type=\"TEXT\" name=\"telephone2\" size=\"10\" value=\"$telephone2\" $HIGHLIGHT>";
echo "<td align=\"left\">Email:<td><input type=\"TEXT\" name=\"email2\" size=\"20\" value=\"$email2\" $HIGHLIGHT><br>";
echo "<tr><td align=\"left\">Qualification:<td>";
makeSelect($customer_qualification_array,"qualification2",$qualification2);
echo "<td align=\"left\">Designation:<td>";
makeSelect($designation_orga_array,"designation1",$designation1);
echo "<td align=\"left\">Occupation:<td>";
makeSelect($customer_occupation_array,"occupation2",$occupation2);

echo "<tr><td align=\"left\">Voter Card No.:<td colspan=2 align=\"left\"><input type=\"TEXT\" name=\"voter_id_no2\" size=\"15\" value=\"\" $HIGHLIGHT><br>";
echo "<td align=\"left\">Pan Card No.:<td colspan=2 align=\"left\"><input type=\"TEXT\" name=\"pan_card_no2\" size=\"12\" value=\"$pan_card_no2\" maxlength=\"10\" $HIGHLIGHT><br>";
echo "<tr><td align=\"left\">Identity Proof:<td>";
 makeSelect($identity_proof_array,"identity_proof2",$identity_proof2);
echo "<td align=\"left\">Dob Proof:<td>";
 makeSelect($dob_proof_array,"dob_proof2",$dob_proof2);
echo "<td align=\"left\">Address Proof:<td>";
 makeSelect($address_proof_array,"address_proof2",$address_proof2);

//----------------------Second organization person---------------------------------------------
echo "<tr><td bgcolor=\"green\" colspan=\"6\" align=\"center\"><font color=\"white\">Second Authorised Person </font>";
echo "<tr><td align=\"left\">Name:<td colspan=2 align=\"left\"><input type=\"TEXT\" name=\"name3\" size=\"20\" value=\"$name3\" $HIGHLIGHT>";
echo "<td align=\"left\">Father/Husband's name:<td colspan=2 align=\"left\"><input type=\"TEXT\" name=\"father_name3\" size=\"25\" value=\"$father_name3\" $HIGHLIGHT><br>";
if($up)
{
$VILL_DEFAULT=$row['address31'];
$POST_DEFAULT=$row['address32'];
$POLICESTATION_DEFAULT=$row['address33'];
$PIN_DEFAULT=$row['pin3'];
$caste3=RegetIndex($caste_array,$row['caste3']);
$sex3=RegetIndex($sex_array,$row['sex3']);
$qualification3=RegetIndex($customer_qualification_array,$row['qualification3']);
$occupation3=RegetIndex($customer_occupation_array,$row['occupation3']);
$identity_proof3=RegetIndex($identity_proof_array,trim($row['identity_proof3']));
$dob_proof3=RegetIndex($dob_proof_array,trim($row['dob_proof3']));
$address_proof3=RegetIndex($address_proof_array,trim($row['address_proof3']));
$designation2=RegetIndex($designation_orga_array,$row['designation2']);

}
if(!$up){
$sex3="";
$qualification3="";
$caste3="General";
$occupation3="";
$designation2="";
$identity_proof3="";
$dob_proof3="";
$address_proof3="";
}
echo "<tr><td align=\"left\">Sex:<td>";
 makeSelect($sex_array,"sex3",$sex3);
echo "<td align=\"left\">Dob:<td><input type=\"TEXT\" name=\"dob3\" size=\"10\" value=\"$dob3\" $HIGHLIGHT >";
echo "&nbsp;<input type=\"button\" name=\"date3\" value=\"...\" onclick=\"showCalendar(form1.dob3,'dd/mm/yyyy','Choose Date')\">";
echo "<td align=\"left\">Caste:<td>";
 makeSelect($caste_array,"caste3",$caste3);
echo "<tr><td align=\"left\">Villege:<td><input type=\"TEXT\" name=\"address31\" size=\"15\" value=\"$VILL_DEFAULT\" $HIGHLIGHT><br>";
echo "<td align=\"left\">PO:<td><input type=\"TEXT\" name=\"address32\" size=\"15\" value=\"$POST_DEFAULT\" $HIGHLIGHT><br>";
echo "<td align=\"left\">PS:<td><input type=\"TEXT\" name=\"address33\" size=\"15\" value=\"$POLICESTATION_DEFAULT\" $HIGHLIGHT><br>";
echo "<tr><td align=\"left\">Pin:<td><input type=\"TEXT\" name=\"pin3\" size=\"10\" value=\"$PIN_DEFAULT\" $HIGHLIGHT><br>";
echo "<td align=\"left\">Contact No.:<td><input type=\"TEXT\" name=\"telephone3\" size=\"10\" value=\"\" $HIGHLIGHT>";
echo "<td align=\"left\">Email:<td><input type=\"TEXT\" name=\"email3\" size=\"20\" value=\"$email3\" $HIGHLIGHT><br>";
echo "<tr><td align=\"left\">Qualification:<td>";
makeSelect($customer_qualification_array,"qualification3",$qualification3);
echo "<td align=\"left\">Designation:<td>";
makeSelect($designation_orga_array,"designation2",$designation2);
echo "<td align=\"left\">Occupation:<td>";
 makeSelect($customer_occupation_array,"occupation3",$occupation3);

echo "<tr><td align=\"left\">Voter Card No.:<td colspan=2 align=\"left\"><input type=\"TEXT\" name=\"voter_id_no3\" size=\"15\" value=\"$voter_id_no3\" $HIGHLIGHT><br>";
echo "<td align=\"left\">Pan Card No.:<td colspan=2 align=\"left\"><input type=\"TEXT\" name=\"pan_card_no3\" size=\"12\" value=\"$pan_card_no3\" maxlength=\"10\" $HIGHLIGHT><br>";
echo "<tr><td align=\"left\">Identity Proof:<td>";
 makeSelect($identity_proof_array,"identity_proof3",$identity_proof3);
echo "<td align=\"left\">Dob Proof:<td>";
 makeSelect($dob_proof_array,"dob_proof3",$dob_proof3);
echo "<td align=\"left\">Address Proof:<td>";
 makeSelect($address_proof_array,"address_proof3",$address_proof3);
//----------------------Third organization person--------------------------------------------
echo "<tr><td bgcolor=\"green\" colspan=\"6\" align=\"center\"><font color=\"white\">Third Authorised Person </font>";
echo "<tr><td align=\"left\">Name:<td colspan=2 align=\"left\"><input type=\"TEXT\" name=\"name4\" size=\"20\" value=\"$name4\" $HIGHLIGHT>";
echo "<td align=\"left\">Father/Husband's name:<td colspan=2 align=\"left\"><input type=\"TEXT\" name=\"father_name4\" size=\"25\" value=\"$father_name4\" $HIGHLIGHT><br>";
if($up)
{
$VILL_DEFAULT=$row['address41'];
$POST_DEFAULT=$row['address42'];
$POLICESTATION_DEFAULT=$row['address43'];
$PIN_DEFAULT=$row['pin4'];
$caste4=RegetIndex($caste_array,$row['caste4']);
$sex4=RegetIndex($sex_array,$row['sex4']);
$qualification4=RegetIndex($customer_qualification_array,$row['qualification4']);
$occupation4=RegetIndex($customer_occupation_array,$row['occupation4']);
$identity_proof4=RegetIndex($identity_proof_array,trim($row['identity_proof4']));
$dob_proof4=RegetIndex($dob_proof_array,trim($row['dob_proof4']));
$address_proof4=RegetIndex($address_proof_array,trim($row['address_proof4']));
$designation3=RegetIndex($designation_orga_array,$row['designation3']);

}
if(!$up){
$sex4="";
$qualification4="";
$caste4="General";
$occupation4="";
$designation4="";
$identity_proof4="";
$dob_proof4="";
$address_proof4="";
}
echo "<tr><td align=\"left\">Sex:<td>";
 makeSelect($sex_array,"sex4",$sex4);
echo "<td align=\"left\">Dob:<td><input type=\"TEXT\" name=\"dob4\" size=\"10\" value=\"$dob4\" $HIGHLIGHT >";
echo "&nbsp;<input type=\"button\" name=\"date4\" value=\"...\" onclick=\"showCalendar(form1.dob4,'dd/mm/yyyy','Choose Date')\">";
echo "<td align=\"left\">Caste:<td>";
 makeSelect($caste_array,"caste4",$caste4);

echo "<tr><td align=\"left\">Villege:<td><input type=\"TEXT\" name=\"address41\" size=\"15\" value=\"$VILL_DEFAULT\" $HIGHLIGHT><br>";
echo "<td align=\"left\">PO:<td><input type=\"TEXT\" name=\"address42\" size=\"15\" value=\"$POST_DEFAULT\" $HIGHLIGHT><br>";
echo "<td align=\"left\">PS:<td><input type=\"TEXT\" name=\"address43\" size=\"15\" value=\"$POLICESTATION_DEFAULT\" $HIGHLIGHT><br>";
echo "<tr><td align=\"left\">Pin:<td><input type=\"TEXT\" name=\"pin4\" size=\"10\" value=\"$PIN_DEFAULT\" $HIGHLIGHT><br>";
echo "<td align=\"left\">Contact No.:<td><input type=\"TEXT\" name=\"telephone4\" size=\"10\" value=\"$telephone4\" $HIGHLIGHT>";
echo "<td align=\"left\">Email:<td><input type=\"TEXT\" name=\"email4\" size=\"20\" value=\"$email4\" $HIGHLIGHT><br>";
echo "<tr><td align=\"left\">Qualification:<td>";
makeSelect($customer_qualification_array,"qualification4",$qualification4);
echo "<td align=\"left\">Designation:<td>";
makeSelect($designation_orga_array,"designation3",$designation3);
echo "<td align=\"left\">Occupation:<td>";
makeSelect($customer_occupation_array,"occupation4",$occupation4);

echo "<tr><td align=\"left\">Voter Card No.:<td colspan=2 align=\"left\"><input type=\"TEXT\" name=\"voter_id_no4\" size=\"15\" value=\"$voter_id_no4\" $HIGHLIGHT><br>";
echo "<td align=\"left\">Pan Card No.:<td colspan=2 align=\"left\"><input type=\"TEXT\" name=\"pan_card_no4\" size=\"12\" value=\"$pan_card_no4\" maxlength=\"10\" $HIGHLIGHT><br>";
echo "<tr><td align=\"left\">Identity Proof:<td>";
 makeSelect($identity_proof_array,"identity_proof4",$identity_proof4);
echo "<td align=\"left\">Dob Proof:<td>";
 makeSelect($dob_proof_array,"dob_proof4",$dob_proof4);
echo "<td align=\"left\">Address Proof:<td>";
 makeSelect($address_proof_array,"address_proof4",$address_proof4);


}

//----------------------FOR JOINT ACCOUNT------------------------------------------
elseif($type=="Joint Account")
{
echo "<table align=center width=100% bgcolor=PINK>";
echo "<tr><td bgcolor=\"red\" colspan=\"6\" align=\"center\"><font color=\"white\">First Holder</font>";
echo "<tr><td align=\"left\">Name:<td colspan=2 align=\"left\"><input type=\"TEXT\" name=\"name1\" size=\"20\" value=\"$name1\" id=\"name1\" $HIGHLIGHT><br>";
echo "<td align=\"left\">Father/Husband's name:<td colspan=2 align=\"left\"><input type=\"TEXT\" name=\"father_name1\" size=\"25\" value=\"$father_name1\" $HIGHLIGHT><br>";
if($up)
{
$VILL_DEFAULT=$row['address11'];
$POST_DEFAULT=$row['address12'];
$POLICESTATION_DEFAULT=$row['address13'];
$PIN_DEFAULT=$row['pin1'];
$caste1=RegetIndex($caste_array,$row['caste1']);
$sex1=RegetIndex($sex_array,$row['sex1']);
$qualification1=RegetIndex($customer_qualification_array,$row['qualification1']);
$occupation1=RegetIndex($customer_occupation_array,$row['occupation1']);
$identity_proof1=RegetIndex($identity_proof_array,trim($row['identity_proof1']));
$dob_proof1=RegetIndex($dob_proof_array,trim($row['dob_proof1']));
$address_proof1=RegetIndex($address_proof_array,trim($row['address_proof1']));

}
if(!$up){
$sex1="";
$qualification1="";
$caste1="General";
$occupation1="";
$identity_proof1="";
$dob_proof1="";
$address_proof1="";
}
echo "<tr><td align=\"left\">Sex:<td>";
 makeSelect($sex_array,"sex1",$sex1);
echo "<td align=\"left\">Dob:<td><input type=\"TEXT\" name=\"dob1\" size=\"10\" value=\"$dob1\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(form1.dob1,'dd/mm/yyyy','Choose Date')\">";
echo "<td align=\"left\">Caste:<td>";
 makeSelect($caste_array,"caste1",$caste1);
echo "<tr><td align=\"left\">Villege:<td><input type=\"TEXT\" name=\"address11\" size=\"15\" value=\"$VILL_DEFAULT\" $HIGHLIGHT><br>";
echo "<td align=\"left\">PO:<td><input type=\"TEXT\" name=\"address21\" size=\"15\"  value=\"$POST_DEFAULT\" $HIGHLIGHT><br>";
echo "<td align=\"left\">PS:<td><input type=\"TEXT\" name=\"address31\" size=\"15\" value=\"$POLICESTATION_DEFAULT\" $HIGHLIGHT><br>";
echo "<tr><td align=\"left\">Pin:<td><input type=\"TEXT\" name=\"pin1\" size=\"10\" value=\"$PIN_DEFAULT\" $HIGHLIGHT><br>";
echo "<td align=\"left\">Contact No:<td><input type=\"TEXT\" name=\"telephone1\" size=\"10\" value=\"$telephone1\" $HIGHLIGHT><br>";
echo "<td align=\"left\">Email:<td><input type=\"TEXT\" name=\"email1\" size=\"20\" value=\"$email1\" $HIGHLIGHT><br>";
echo "<tr><td align=\"left\">Qualification:<td colspan=2 align=\"left\">";
makeSelect($customer_qualification_array,"qualification1",$qualification1);
echo "<td align=\"left\">Occupation:<td colspan=2 align=\"left\">";
 makeSelect($customer_occupation_array,"occupation1",$occupation1);
echo "<tr><td align=\"left\">Voter Card No.:<td colspan=2 align=\"left\"><input type=\"TEXT\" name=\"voter_id_no1\" size=\"15\" value=\"$voter_id_no1\" $HIGHLIGHT><br>";
echo "<td align=\"left\">Pan Card No.:<td colspan=2 align=\"left\"><input type=\"TEXT\" name=\"pan_card_no1\" size=\"12\" value=\"$pan_card_no1\" maxlength=\"10\" $HIGHLIGHT><br>";
echo "<tr><td align=\"left\">Identity Proof:<td>";
 makeSelect($identity_proof_array,"identity_proof1",$identity_proof1);
echo "<td align=\"left\">Dob Proof:<td>";
 makeSelect($dob_proof_array,"dob_proof1",$dob_proof1);
echo "<td align=\"left\">Address Proof:<td>";
 makeSelect($address_proof_array,"address_proof1",$address_proof1);

//---------------------------SECOND HOLDER FOR JOINT ACC---------------------------------
echo "<tr><td bgcolor=\"green\" colspan=\"6\" align=\"center\"><font color=\"white\">Second Holder </font>";
echo "<tr><td align=\"left\">Name:<td colspan=2 align=\"left\"><input type=\"TEXT\" name=\"name2\" size=\"20\" value=\"$name2\" $HIGHLIGHT>";
echo "<td align=\"left\">Father/Husband's name:<td colspan=2 align=\"left\"><input type=\"TEXT\" name=\"father_name2\" size=\"25\" value=\"$father_name2\" $HIGHLIGHT>";
echo "<tr><td align=\"left\">Sex:<td>";
if($up)
{
$VILL_DEFAULT=$row['address21'];
$POST_DEFAULT=$row['address22'];
$POLICESTATION_DEFAULT=$row['address23'];
$PIN_DEFAULT=$row['pin2'];
$caste2=RegetIndex($caste_array,$row['caste2']);
$sex2=RegetIndex($sex_array,$row['sex2']);
$qualification2=RegetIndex($customer_qualification_array,$row['qualification2']);
$occupation2=RegetIndex($customer_occupation_array,$row['occupation2']);
$identity_proof2=RegetIndex($identity_proof_array,trim($row['identity_proof2']));
$dob_proof2=RegetIndex($dob_proof_array,trim($row['dob_proof2']));
$address_proof2=RegetIndex($address_proof_array,trim($row['address_proof2']));

}
if(!$up){
$sex2="";
$qualification2="";
$caste2="General";
$occupation2="";
$identity_proof2="";
$dob_proof2="";
$address_proof2="";
}
 makeSelect($sex_array,"sex2",$sex2);
echo "<td align=\"left\">Dob:<td><input type=\"TEXT\" name=\"dob2\" size=\"10\" value=\"$dob2\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"date1\" value=\"...\" onclick=\"showCalendar(form1.dob2,'dd/mm/yyyy','Choose Date')\">";
echo "<td align=\"left\">Caste:<td>";
 makeSelect($caste_array,"caste2",$caste2);
echo "<tr><td align=\"left\">Villege:<td><input type=\"TEXT\" name=\"address12\" size=\"15\" value=\"$VILL_DEFAULT\" $HIGHLIGHT>";
echo "<td align=\"left\">PO:<td><input type=\"TEXT\" name=\"address22\" size=\"15\" value=\"$POST_DEFAULT\" $HIGHLIGHT><br>";
echo "<td align=\"left\">PS:<td><input type=\"TEXT\" name=\"address32\" size=\"15\" value=\"$POLICESTATION_DEFAULT\" $HIGHLIGHT><br>";
echo "<tr><td align=\"left\">Pin:<td><input type=\"TEXT\" name=\"pin2\" size=\"10\" value=\"$PIN_DEFAULT\" $HIGHLIGHT><br>";
echo "<td align=\"left\">Contact No.:<td><input type=\"TEXT\" name=\"telephone2\" size=\"10\" value=\"$telephone2\" $HIGHLIGHT>";
echo "<td align=\"left\">Email:<td><input type=\"TEXT\" name=\"email2\" size=\"20\" value=\"$email2\" $HIGHLIGHT>";
echo "<tr><td align=\"left\">Qualification:<td colspan=2 align=\"left\">";
makeSelect($customer_qualification_array,"qualification2",$qualification2);
echo "<td align=\"left\">Occupation:<td colspan=2 align=\"left\">";
 makeSelect($customer_occupation_array,"occupation2",$occupation2);
echo "<tr><td align=\"left\">Voter Card No.:<td colspan=2 align=\"left\"><input type=\"TEXT\" name=\"voter_id_no2\" size=\"15\" value=\"$voter_id_no2\" $HIGHLIGHT>";
echo "<td align=\"left\">Pan Card No.:<td colspan=2 align=\"left\"><input type=\"TEXT\" name=\"pan_card_no2\" size=\"12\" value=\"$pan_card_no2\" maxlength=\"10\" $HIGHLIGHT><br>";
echo "<tr><td align=\"left\">Identity Proof:<td>";
 makeSelect($identity_proof_array,"identity_proof2",$identity_proof2);
echo "<td align=\"left\">Dob Proof:<td>";
 makeSelect($dob_proof_array,"dob_proof2",$dob_proof2);
echo "<td align=\"left\">Address Proof:<td>";
 makeSelect($address_proof_array,"address_proof2",$address_proof2);

//---------------------------Third holder for joint account-------------------------------------
echo "<tr><td bgcolor=\"blue\" colspan=\"6\" align=\"center\"><font color=\"white\">Third Holder</font>";
echo "<tr><td align=\"left\">Name:<td colspan=2 align=\"left\"><input type=\"TEXT\" name=\"name3\" size=\"20\" value=\"$name3\" $HIGHLIGHT>";
echo "<td align=\"left\">Father/Husband's name:<td colspan=2 align=\"left\"><input type=\"TEXT\" name=\"father_name3\" size=\"25\" value=\"$father_name3\" $HIGHLIGHT>";
if($up)
{
$VILL_DEFAULT=$row['address31'];
$POST_DEFAULT=$row['address32'];
$POLICESTATION_DEFAULT=$row['address33'];
$PIN_DEFAULT=$row['pin3'];
$caste3=RegetIndex($caste_array,$row['caste3']);
$sex3=RegetIndex($sex_array,$row['sex3']);
$qualification3=RegetIndex($customer_qualification_array,$row['qualification3']);
$occupation3=RegetIndex($customer_occupation_array,$row['occupation3']);
$identity_proof3=RegetIndex($identity_proof_array,trim($row['identity_proof3']));
$dob_proof3=RegetIndex($dob_proof_array,trim($row['dob_proof3']));
$address_proof3=RegetIndex($address_proof_array,trim($row['address_proof3']));
}
if(!$up){
$sex3="";
$qualification3="";
$caste3="General";
$occupation3="";
$identity_proof3="";
$dob_proof3="";
$address_proof3="";
}
echo "<tr><td align=\"left\">Sex:<td>";
 makeSelect($sex_array,"sex3",$sex3);
echo "<td align=\"left\">Dob:<td><input type=\"TEXT\" name=\"dob3\" size=\"10\" value=\"$dob3\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"date3\" value=\"...\" onclick=\"showCalendar(form1.dob3,'dd/mm/yyyy','Choose Date')\">";
echo "<td align=\"left\">Caste:<td>";
 makeSelect($caste_array,"caste3",$caste3);
echo "<tr><td align=\"left\">Villege::<td><input type=\"TEXT\" name=\"address13\" size=\"15\" value=\"$VILL_DEFAULT\">";
echo "<td align=\"left\">PO:<td><input type=\"TEXT\" name=\"address23\" size=\"15\" value=\"$POST_DEFAULT\" $HIGHLIGHT>";
echo "<td align=\"left\">PS :<td><input type=\"TEXT\" name=\"address33\" size=\"15\" value=\"$DISTRIC_DEFAULT\" $HIGHLIGHT>";
echo "<tr><td align=\"left\">Pin:<td><input type=\"TEXT\" name=\"pin3\" size=\"10\" value=\"$PIN_DEFAULT\" $HIGHLIGHT>";
echo "<td align=\"left\">Contact No.:<td><input type=\"TEXT\" name=\"telephone3\" size=\"10\" value=\"$telephone3\" $HIGHLIGHT>";
echo "<td align=\"left\">Email:<td><input type=\"TEXT\" name=\"email3\" size=\"20\" value=\"$email3\" $HIGHLIGHT>";
echo "<tr><td align=\"left\">Qualification:<td colspan=2 align=\"left\">";
makeSelect($customer_qualification_array,"qualification3",$qualification3);
echo "<td align=\"left\">Occupation:<td colspan=2 align=\"left\">";
 makeSelect($customer_occupation_array,"occupation3",$occupation3);
echo "<tr><td align=\"left\">Voter Card No.:<td colspan=2 align=\"left\"><input type=\"TEXT\" name=\"voter_id_no3\" size=\"15\" value=\"$voter_id_no3\" $HIGHLIGHT>";
echo "<td align=\"left\">Pan:<td colspan=2 align=\"left\"><input type=\"TEXT\" name=\"pan_card_no3\" size=\"12\" value=\"$pan_card_no3\" maxlength=\"10\" $HIGHLIGHT>";
echo "<tr><td align=\"left\">Identity Proof:<td>";
 makeSelect($identity_proof_array,"identity_proof3",$identity_proof3);
echo "<td align=\"left\">Dob Proof:<td>";
 makeSelect($dob_proof_array,"dob_proof3",$dob_proof3);
echo "<td align=\"left\">Address Proof:<td>";
 makeSelect($address_proof_array,"address_proof3",$address_proof3);

}
elseif($type=='Staff'){
	header("location:staff_customer.php?type=$type");
}
//---------------------------------for SHG---------------------------------------------------
elseif(($type=="Self Help Group") or ($type=="Joint Library Group")){
if($up)
{
$VILL_DEFAULT=$row['address11'];
$POST_DEFAULT=$row['address12'];
$POLICESTATION_DEFAULT=$row['address13'];
$PIN_DEFAULT=$row['pin1'];
getSHGInfo($account,$no_of_member,$leader,$group_id);
$sex1=RegetIndex($sex_array,$row['sex1']);
}
else{
$no_of_member=5;
}

echo "<table align=center width=100% bgcolor=ORANGE>";
echo "<tr><td bgcolor=\"red\" colspan=\"6\" align=\"center\"><font color=\"white\">Group Account</font>";
echo "<tr><td align=\"left\"colspan=2>Group Name:<td><input type=\"TEXT\" name=\"name1\" id=\"name1\" size=\"30\" value=\"$name1\" $HIGHLIGHT>";
echo "<td align=\"RIGHT\"colspan=2>Type of group:<td>";
makeSelect($type_of_group_array,"sex1","$sex1");
echo "<tr><td align=\"left\" colspan=2>No. of member:<td><input type=\"TEXT\" name=\"no_of_member\" size=\"15\" value=\"$no_of_member\" $HIGHLIGHT>";
echo "<td align=\"RIGHT\" colspan=2>Name of the Leader:<td><input type=\"TEXT\" name=\"leader\" size=\"25\" value=\"$leader\" $HIGHLIGHT>";
echo "<tr><td align=\"left\" colspan=2>Village:<td><input type=\"TEXT\" name=\"address11\" size=\"20\" value=\"$VILL_DEFAULT\" $HIGHLIGHT>";
echo "<td align=\"Right\" colspan=2>PO :<td><input type=\"TEXT\" name=\"address12\" size=\"20\" value=\"$POST_DEFAULT\" $HIGHLIGHT>";
echo "<tr><td align=\"left\" colspan=2>PS:<td><input type=\"TEXT\" name=\"address13\" size=\"20\" value=\"$POLICESTATION_DEFAULT\" $HIGHLIGHT>";
echo "<td align=\"RIGHT\" colspan=2>Pin:<td><input type=\"TEXT\" name=\"pin1\" size=\"20\" value=\"$PIN_DEFAULT\" $HIGHLIGHT>";
}
else{
echo "<table align=center width=100% bgcolor=Black>";
echo "<tr><td bgcolor=\"red\" colspan=\"6\" align=\"center\"><font color=\"white\"><b>Customer</font>";
echo "<tr><td align=\"left\" bgcolor=#90EE90>Name:<td colspan=2 align=\"left\" bgcolor=#90EE90><input type=\"TEXT\" name=\"name1\" size=\"20\" id=\"name1\" value=\"\" id=\"name1\" $HIGHLIGHT><br>";
echo "<td align=\"left\" bgcolor=#90EE90>Father/Husband's name:<td colspan=2 align=\"left\" bgcolor=#90EE90><input type=\"TEXT\" name=\"father_name1\" size=\"25\" value=\"\" $HIGHLIGHT><br>";
echo "<tr><td align=\"left\" bgcolor=#90EE90>Sex:<td bgcolor=#90EE90>";
makeSelect($sex_array,"sex1","");
echo "<td align=\"left\" bgcolor=#90EE90>Dob:<td bgcolor=#90EE90><input type=\"TEXT\" name=\"dob1\" size=\"10\" value=\"\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(form1.dob1,'dd/mm/yyyy','Choose Date')\">";
echo "<td align=\"left\" bgcolor=#90EE90>Caste:<td bgcolor=#90EE90>";
 makeSelect($caste_array,"caste1","");
echo "<tr><td align=\"left\" bgcolor=#90EE90>Villege:<td bgcolor=#90EE90><input type=\"TEXT\" name=\"address11\" size=\"15\" value=\"$VILL_DEFAULT\" $HIGHLIGHT><br>";
echo "<td align=\"left\" bgcolor=#90EE90>PO:<td bgcolor=#90EE90><input type=\"TEXT\" name=\"address21\" size=\"15\"  value=\"$POST_DEFAULT\" $HIGHLIGHT><br>";
echo "<td align=\"left\" bgcolor=#90EE90>PS:<td bgcolor=#90EE90><input type=\"TEXT\" name=\"address31\" size=\"15\" value=\"$POLICESTATION_DEFAULT\" $HIGHLIGHT><br>";
echo "<tr><td align=\"left\" bgcolor=#90EE90>Pin:<td bgcolor=#90EE90><input type=\"TEXT\" name=\"pin1\" size=\"10\" value=\"$PIN_DEFAULT\" $HIGHLIGHT><br>";
echo "<td align=\"left\" bgcolor=#90EE90>Contact No:<td bgcolor=#90EE90><input type=\"TEXT\" name=\"telephone1\" size=\"10\" value=\"\" $HIGHLIGHT><br>";
echo "<td align=\"left\" bgcolor=#90EE90>Customer Catagory:<td bgcolor=#90EE90>";
makeSelect($party_category_array1,$c_cat);
}
echo "</table>";


//-------------------------office uses----------------------------------
echo "<hr>";
if($type!="Other"){
echo "<table width=100%>";
echo "<tr><td bgcolor=\"Brown\" colspan=\"6\" align=\"center\"><font color=\"white\"> Office Uses</font>";
echo "<tr><td align=\"left\">Date of opening:<td><input type=\"TEXT\" name=\"date_of_opening\" size=\"20\" value=\"";
//if ($up){echo $date_of_opening;} else { echo date('d/m/Y');}
echo"\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"date4\" value=\"...\" onclick=\"showCalendar(form1.date_of_opening,'dd/mm/yyyy','Choose Date')\"><br>";

echo "<td align=\"left\">Introducer Account No.:<td><input type=\"TEXT\" name=\"introducer_id\" size=\"20\" value=\"$introducer_id\" id=\"intro\"  $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"check\" value=\"Check\" onClick=\"checkAccount()\">";
echo "<tr><td valign=\"middle\" align=\"center\" colspan=2 >Remarks:<td  align=\"left\" colspan=2 ><textarea name=\"remarks\" rows=\"3\" cols=\"49\" $HIGHLIGHT>$remarks</textarea><br>";
}
echo "<input type=\"HIDDEN\" name=\"type\" value=\"$type\" id=\"type\">";
//echo "customer_id=$customer_id";

if($up)
{
	echo "<input type=\"HIDDEN\" name=\"customer_id\" value=\"$account\">";
	echo "<tr><td><td align=\"right\"><input type=\"SUBMIT\" name=\"update\" value=\"Update\">";
}
else{
	if($type=="Sole Account"){
		echo "<tr><td><td align=\"right\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" id=\"submit\" value=\"Submit\" disabled >";
		}
	else
	{
		echo "<tr><td><td align=\"right\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Submit\" >";
	}
echo "  <input type=\"RESET\" name=\"RESET_BUTTON\" value=\"Cancel\"><br>";
}

echo "</table>";
echo "</form>";
if(($type=="Sole Account") or ($type=="Joint Account") or ($type=="NREGS") or ($type=="Other")){
?>
<script language="JavaScript" type="text/javascript">
 var frmvalidator  = new Validator("form1");
 this.formtype=document.forms[type];
if(formtype =="Sole Account"){ alert ("Sole account");}
  frmvalidator.addValidation("name1","req","Please enter your First Holder Name");
  frmvalidator.addValidation("name1","maxlen=40","Max length for FirstName is 20");
  frmvalidator.addValidation("name1","alpha_s","Only Alphabetic Characters and Space Allow For First Holder");
  
  frmvalidator.addValidation("father_name1","req","Please enter Father Name For First Holder");
  frmvalidator.addValidation("father_name1","maxlen=40","Max length is 20");
  frmvalidator.addValidation("father_name1","alpha_s","Only Alphabetic Characters and Space Allow For First Holder Father Name");

  frmvalidator.addValidation("pin1","req","Pin number should not Blank");
  frmvalidator.addValidation("pin1","maxlen=6","Max Lenght is 6 only");
  frmvalidator.addValidation("pin1","numeric","Enter Number Only");

  frmvalidator.addValidation("email1","maxlen=50","Max length is 50");
  //frmvalidator.addValidation("email1","req","Email should not Blank");
  frmvalidator.addValidation("email1","email","Enter Valid Email");
     
  //frmvalidator.addValidation("telephone1","req","Contact number should not Blank");
  frmvalidator.addValidation("telephone1","maxlen=15","Max Lenght is 15 only");
  frmvalidator.addValidation("telephone1","numeric","Enter Number Only For Contact Field");

  //frmvalidator.addValidation("voter_id_no1","req","Voter Card Number Should not Blank");
  frmvalidator.addValidation("voter_id_no1","maxlen=20","Max Lenght is 20 only");
  frmvalidator.addValidation("voter_id_no1","alphanumeric","Enter Number Only");

  //frmvalidator.addValidation("pan_card_no1","req","Pan Number Should not Blank");
  frmvalidator.addValidation("pan_card_no1","maxlen=10","Max Lenght is 10 only");
  frmvalidator.addValidation("pan_card_no1","alphanumeric","Enter Number Only");

 // for second holder

  frmvalidator.addValidation("name2","req","Please enter your 2nd Holder Name");
  frmvalidator.addValidation("name2","maxlen=40","Max length for 2nd Holder Name is 40");
  frmvalidator.addValidation("name2","alpha_s","Only Alphabetic Characters and Space Allow For First Holder");
  
  frmvalidator.addValidation("father_name2","req","Please enter Father Name For 2nd Holder");
  frmvalidator.addValidation("father_name2","maxlen=40","Max length of 2nd Holder's Father Name is 40");
  frmvalidator.addValidation("father_name2","alpha_s","Only Alphabetic Characters and Space Allow For 2nd Holder's Father Name");

  frmvalidator.addValidation("pin2","req","Pin number should not Blank");
  frmvalidator.addValidation("pin2","maxlen=6","Max Lenght of pin code is 6 only");
  frmvalidator.addValidation("pin2","numeric","Enter the pin code Number Only");

  frmvalidator.addValidation("email2","maxlen=50","Max length of email id is 50");
  //frmvalidator.addValidation("email2","req","Email id should not Blank");
  frmvalidator.addValidation("email2","email","Enter Valid Email id");
     
  //frmvalidator.addValidation("telephone2","req","Contact number should not Blank");
  frmvalidator.addValidation("telephone2","maxlen=15","Max Lenght of contact no is 10 only");
  frmvalidator.addValidation("telephone2","numeric","Enter the contact No. Number Only");

  //frmvalidator.addValidation("voter_id_no2","req","Voter Card Number Should not Blank");
  frmvalidator.addValidation("voter_id_no2","maxlen=20","Max Lenght of Voter Id is 20 only");
  frmvalidator.addValidation("voter_id_no2","alphanumeric","Enter Voter id alphanumeric Only");

  //frmvalidator.addValidation("pan_card_no2","req","Pan Number Should not Blank");
  frmvalidator.addValidation("pan_card_no2","maxlen=10","Max Lenght of pin code is 6 only");
  frmvalidator.addValidation("pan_card_no2","alphanumeric","Enter the pin code Number Only");

  

  
  

</script>
<?php
}

if($type=="Organisational"){
?>
<script language="JavaScript" type="text/javascript">
//You should create the validator only after the definition of the HTML form
 
  var frmvalidator  = new Validator("form1");
 
  frmvalidator.addValidation("name1","req","Please enter Organisation Name");
  frmvalidator.addValidation("name1","maxlen=100","Max length for FirstName is 20");
  //frmvalidator.addValidation("name1","alpha_s","Only Alphabetic Characters and Space Allow For First Holder");
    
  frmvalidator.addValidation("pin1","req","Pin number should not Blank");
  frmvalidator.addValidation("pin1","maxlen=6","Max Lenght is 6 only");
  frmvalidator.addValidation("pin1","numeric","Enter Number Only");

  //frmvalidator.addValidation("email1","maxlen=50","Max length is 50");
  //frmvalidator.addValidation("email1","req","Email should not Blank");
  //frmvalidator.addValidation("email1","email","Enter Valid Email");
     
  //frmvalidator.addValidation("telephone1","req","Contact number should not Blank");
  //frmvalidator.addValidation("telephone1","maxlen=10","Max Lenght is 10 only");
  //frmvalidator.addValidation("telephone1","numeric","Enter Number Only For Contact Field");
  
  //frmvalidator.addValidation("pan_card_no1","req","Pan Number Should not Blank");
  //frmvalidator.addValidation("pan_card_no1","maxlen=10","Max Lenght is 10 only");
  //frmvalidator.addValidation("pan_card_no1","alphanumeric","Enter Number Only");

 // for second holder

  frmvalidator.addValidation("name2","req","Please Enter First Auoharised Name");
  frmvalidator.addValidation("name2","maxlen=100","Max length for First Auoharised Name is 20");
  //frmvalidator.addValidation("name2","alpha_s","Only Alphabetic Characters and Space Allow For First Auoharised Name Holder");
  
  //frmvalidator.addValidation("father_name2","req","Please enter Father Name For First Holder");
  //frmvalidator.addValidation("father_name2","maxlen=20","Max length is 20");
  //frmvalidator.addValidation("father_name2","alpha_s","Only Alphabetic Characters and Space Allow For First Holder Father Name");

  frmvalidator.addValidation("pin2","req","Pin number should not Blank");
  frmvalidator.addValidation("pin2","maxlen=6","Max Lenght is 6 only");
  frmvalidator.addValidation("pin2","numeric","Enter Number Only");

  //frmvalidator.addValidation("email2","maxlen=50","Max length is 50");
  //frmvalidator.addValidation("email2","req","Email should not Blank");
  //frmvalidator.addValidation("email2","email","Enter Valid Email");
     
  //frmvalidator.addValidation("telephone2","req","Contact number should not Blank");
  //frmvalidator.addValidation("telephone2","maxlen=10","Max Lenght is 10 only");
  //frmvalidator.addValidation("telephone2","numeric","Enter Number Only");

  //frmvalidator.addValidation("voter_id_no2","req","Voter Card Number Should not Blank");
  //frmvalidator.addValidation("voter_id_no2","maxlen=6","Max Lenght is 6 only");
  //frmvalidator.addValidation("voter_id_no2","alphanumeric","Enter Number Only");

  //frmvalidator.addValidation("pan_card_no2","req","Pan Number Should not Blank");
  //frmvalidator.addValidation("pan_card_no2","maxlen=10","Max Lenght is 10 only");
  //frmvalidator.addValidation("pan_card_no2","alphanumeric","Enter Number Only");


</script>
<?php
}

if($type=="Self Help Group"){
?>
<script language="JavaScript" type="text/javascript">
//You should create the validator only after the definition of the HTML form
 
  var frmvalidator  = new Validator("form1");
 
  frmvalidator.addValidation("name1","req","Please enter Group Name");
  frmvalidator.addValidation("name1","maxlen=100","Max length for Group Name is 20");
  frmvalidator.addValidation("name1","alpha_s","Only Alphabetic Characters and Space Allow For Group Name");
       
  frmvalidator.addValidation("leader","req","Leader Name Should not Blank");
  frmvalidator.addValidation("leader","maxlen=50","Max Lenght is 20 only");
  frmvalidator.addValidation("leader","alpha_s","Only Alphabetic Characters and Space Allow For Leader Name");

</script>
<?php
}
echo "</body>";
echo "</html>";

?>
