<?php
include "../config/config.php";
$staff_id=verifyAutho();
$group_no=$_REQUEST['group_no'];

//echo "GPN->$group_no";
/*$sl_no=$_REQUEST['sl_no'];
$designation_type=$_REQUEST['designation_type'];
$first_name=$_REQUEST['first_name'];
$leader=$_REQUEST['leader'];
$sex=$_REQUEST['sex'];
$type_of_group=$_REQUEST['type_of_group'];*/
$sql_statement="SELECT count(*) from customer_master where type_of_customer='$group_no'";
$result=dBConnect($sql_statement);
$count=pg_result($result,"count");
$c_id=getCustomerIdFromGroupId($group_no);
$sql_statement="SELECT * from customer_master where customer_id='$c_id'";
$result=dBConnect($sql_statement);
$sex=pg_result($result,"sex1");
//$c_id=getCustomerIdFromGoupId($group_no);
if($count==0){getSHGInfo($c_id,$no_of_member,$leader,$group_id);}
echo "<html>";
echo "<head>";
echo "<title>Entry Form - Table: Shg_member";
echo "</title>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<script src=\"../JS/validation.js\">";
echo "</script>";
echo "</head>";

echo "<BODY bgcolor=\"silver\" onload=\"mname.focus();\">";

$id=getCustomerId($account_no,$menu);
$flag=getGeneralInfo_Customer($id);


echo "<form name=\"f1\" method=\"POST\" action=\"shg_member_eadd.php\">";
echo "<table bgcolor=BLACK width=100%>";
echo "<tr><td colspan=6 bgcolor=\"yellow\" align=center><b><font color=\"red\" size=+2>Self Help Group Member Entry Form</b></font>";
echo "<tr bgcolor=\"skyblue\"><td align=\"left\">SHG Member id:<td  colspan=2><input type=\"TEXT\" name=\"sl_no\" size=\"10\" value=\"".$group_no."-".($count+1)."\" readonly $HIGHLIGHT>";
echo "<td align=\"Right\" colspan=2>Group no:<td><input type=\"TEXT\" name=\"group_no\" size=\"10\" value=\"$group_no\" readonly $HIGHLIGHT><br>";
if ($count==0){
echo "<tr bgcolor=\"skyblue\"><td align=\"left\" >Name of Member:<td colspan=2><input type=\"TEXT\" name=\"mname\" id=\"mname\" size=\"20\" value=\"$leader\" readonly $HIGHLIGHT><br>";
echo "<input type=\"HIDDEN\" name=\"designation\"  value=\"l\">";
}
else{
   echo "<tr bgcolor=\"skyblue\"><td align=\"left\">Name of Member:<td colspan=2><input type=\"TEXT\" name=\"mname\" size=\"20\" value=\"\" id=\"mname\" $HIGHLIGHT><br>";
 echo "<input type=\"HIDDEN\" name=\"designation\"  value=\"m\">";
 }
echo "<td align=\"Right\" colspan=2 >Husband/Father's name:<td><input type=\"TEXT\" name=\"husband_father_name\" size=\"20\" value=\"\" $HIGHLIGHT><br>";
if(trim($sex)=="m"){
 echo "<tr bgcolor=\"skyblue\"><td align=\"left\">Sex:<td><input type=\"TEXT\" name=\"sex\" size=\"10\" value=\"Male\"readonly $HIGHLIGHT><br>";
}
elseif(trim($sex)=='f'){
echo "<tr bgcolor=\"skyblue\"><td align=\"left\">Sex:<td><input type=\"TEXT\" name=\"sex\" size=\"10\" value=\"Female\"readonly $HIGHLIGHT><br>";
}
else{
    echo "<tr bgcolor=\"skyblue\"><td align=\"left\">Sex:<td>";
    makeSelect($sex_array,"sex","");
    }
echo "<td align=\"left\">DOB:<td><input type=\"TEXT\" name=\"dob\" size=\"12\" value=\"\" $HIGHLIGHT>";
echo "<input type=\"BUTTON\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.dob,'dd/mm/yy','Choose Date')\">";
echo "<td align=\"left\">Caste:<td>";
 makeSelect($caste_array,"caste","");
echo "<tr bgcolor=\"skyblue\"><td align=\"left\">Village:<td><input type=\"TEXT\" name=\"address1\" size=\"15\" value=\"$VILL_DEFAULT\" $HIGHLIGHT><br>";
echo "<td align=\"left\">PO:<td><input type=\"TEXT\" name=\"address2\" size=\"15\" value=\"$POST_DEFAULT\" $HIGHLIGHT><br>";
echo "<td align=\"left\">PS:<td><input type=\"TEXT\" name=\"address3\" size=\"15\" value=\"$POLICESTATION_DEFAULT\" $HIGHLIGHT><br>";
echo "<tr bgcolor=\"skyblue\"><td align=\"left\">Pin:<td><input type=\"TEXT\" name=\"pin\" size=\"10\" value=\"$PIN_DEFAULT\" $HIGHLIGHT><br>";
echo "<td align=\"left\">Contact no:<td><input type=\"TEXT\" name=\"mobile\" size=\"10\" value=\"\" $HIGHLIGHT>";
echo "<td align=\"left\">Email:<td><input type=\"TEXT\" name=\"email\" size=\"25\" value=\"\" $HIGHLIGHT>";
echo "<tr bgcolor=\"skyblue\"><td align=\"left\">Qualification:<td colspan=2 align=\"left\">";
makeSelect($customer_qualification_array,"qualify","");
echo "<td align=\"left\">Occupation:<td colspan=2 align=\"left\">";
 makeSelect($customer_occupation_array,"occupation","");
echo "<tr bgcolor=\"skyblue\"><td align=\"left\">Voter Id. No.:<td colspan=2 align=\"left\"><input type=\"TEXT\" name=\"vcn\" size=\"15\" value=\"\" $HIGHLIGHT><br>";
echo "<td align=\"left\">Pan Card No.:<td colspan=2 align=\"left\"><input type=\"TEXT\" name=\"pan\" size=\"15\" value=\"\" $HIGHLIGHT>";
echo "<tr bgcolor=\"skyblue\"><td align=\"left\">Id Proof:<td>";
 makeSelect($identity_proof_array,"identity_proof","");
echo "<td align=\"left\">Address Proof:<td>";
 makeSelect($address_proof_array,"address_proof","");
echo "<td align=\"left\">Dob Proof:<td>";
 makeSelect($dob_proof_array,"dob_proof","");
/*echo "<tr bgcolor=\"skyblue\"><td>Nomination :<td> <input type=RADIO value=yes name=r1 onClick=enable_txt(this.value)>Yes&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<input type=RADIO value=no name=r1 CHECKED onClick=enable_txt(this.value)>No<td> &nbsp<td> &nbsp<td> &nbsp<td> &nbsp";
echo "<tr bgcolor=\"skyblue\"><td align=\"Right\" colspan=2>Name of Nominee:<td><input type=TEXT name=n_name size=22 $HIGHLIGHT disabled>";
echo "<td align=\"Right\" colspan=2>Address:<td><input type=TEXT name=n_add size=25 $HIGHLIGHT disabled>";
echo "<tr bgcolor=\"skyblue\"><td>Age:<td><input type=TEXT name=n_age size=10 $HIGHLIGHT disabled>";
echo "<td>Relation:<td>";
echo "<td> &nbsp<td> &nbsp";
makeSelectDisabled($relation_array,'relation');
echo "<tr bgcolor=\"skyblue\"><td>If Nominee is minor:<td>";
echo "<input type=RADIO value=yes name=r2 onClick=enable_button(this.value);> Yes&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<input type=RADIO value=no name=r2 CHECKED onClick=enable_button(this.value);>No<td> &nbsp<td> &nbsp<td> &nbsp<td> &nbsp";
echo "<tr bgcolor=\"skyblue\"><td>Date of Birth:<td><input type=\"TEXT\" name=\"ndob\" size=\"15\" value=\"\" readonly $HIGHLIGHT>";*/
echo "<input type=\"BUTTON\" name=\"caldate\" value=\"...\" disabled onclick=\"showCalendar(f1.ndob,'dd/mm/yy','Choose Date')\">";
echo "<tr bgcolor=\"skyblue\"><td align=\"right\" colspan=6><input type=\"RESET\" name=\"RESET_BUTTON\" value=\"Reset\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Submit\">";

echo "</table>";
echo "</form>";
echo "</body>";
echo "</html>";

?>
