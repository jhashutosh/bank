<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$type=$_REQUEST['type'];
$id=$_REQUEST['id'];
$op=$_REQUEST['op'];
echo "<html>";
echo "<head>";
echo "<title>Entry Form - Table: Staff";
echo "</title>";
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body onload=\"s_id.focus();\">";
echo "<table align=center width=100%>";
echo "<th bgcolor=GREEN><h3>Entry Form for New Customer(Staff)</h3>";
echo "</th>";
echo "</table>";
echo "<hr>";
if(!empty($id)){$id=existStaffId($id);}
if(empty($id)){
echo "<form name=\"form1\" action=\"staff_customer.php?type=$type\" method=\"post\">";
echo "<table>";
echo "<tr><td align=\"left\">Check Id:&nbsp;&nbsp;&nbsp; &nbsp; <td><input type=\"TEXT\" name=\"id\" size=\"25\" id=\"s_id\" $HIGHLIGHT>";
echo "<td><input type=\"SUBMIT\" value=\"Check\">";
echo "</table>";
echo "</form>";
   }
else{
$sql_statement="SELECT * FROM staff WHERE id='$id'";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0) {
	$name=pg_result($result,'name');
 	$c_id=pg_result($result,'customer_id');
	$ph=pg_result($result,'contact_no');
	$sex=trim(pg_result($result,'sex'));
	$sex=$sex_array[$sex];
  	$qualify=trim(pg_result($result,'qualification'));
	$qualify=$customer_qualification_array[$qualify];
	}
if(empty($c_id)){
echo "<form name=\"form1\" method=\"POST\" action=\"customer_account_eadd.php?type=$type\">";
echo "<table align=center width=100% bgcolor=skyblue>";
echo "<tr><td bgcolor=\"red\" colspan=\"6\" align=\"center\"><font color=\"white\">Details of Staff</font>";
echo "<tr><td align=\"left\">Name:<td colspan=2 align=\"left\"><input type=\"TEXT\" name=\"name1\" size=\"20\" value=\"$name\" readonly $HIGHLIGHT>";
echo "<td align=\"left\">Father/Husband's name:<td colspan=2 align=\"left\"><input type=\"TEXT\" name=\"father_name1\" size=\"25\" value=\"\"  id=\"s_id\" $HIGHLIGHT><br>";
echo "<tr><td align=\"left\">Sex:<td>";
 makeSelect($sex_array,"sex1",$sex);
echo "<td align=\"left\">Dob:<td><input type=\"TEXT\" name=\"dob1\" size=\"10\" value=\"$dob1\" $HIGHLIGHT >";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(form1.dob1,'dd/mm/yyyy','Choose Date')\">";
echo "<td align=\"left\">Caste:<td>";
 makeSelect($caste_array,"caste1",$caste1);
echo "<tr><td align=\"left\">Villege:<td><input type=\"TEXT\" name=\"address11\" size=\"15\" value=\"$VILL_DEFAULT\" $HIGHLIGHT><br>";
echo "<td align=\"left\">PO:<td><input type=\"TEXT\" name=\"address12\" size=\"15\"  value=\"$POST_DEFAULT\" $HIGHLIGHT><br>";
echo "<td align=\"left\">PS:<td><input type=\"TEXT\" name=\"address13\" size=\"15\" value=\"$POLICESTATION_DEFAULT\" $HIGHLIGHT><br>";
echo "<tr><td align=\"left\">Pin:<td><input type=\"TEXT\" name=\"pin1\" size=\"10\" value=\"$PIN_DEFAULT\" $HIGHLIGHT><br>";
echo "<td align=\"left\">Contact No:<td><input type=\"TEXT\" name=\"telephone1\" size=\"10\" value=\"$ph\" $HIGHLIGHT><br>";
echo "<td align=\"left\">Email:<td><input type=\"TEXT\" name=\"email1\" size=\"20\" 
value=\"$email1\" $HIGHLIGHT><br>";
echo "<tr><td align=\"left\">Qualification:<td colspan=2 align=\"left\">";
makeSelect($customer_qualification_array,"qualification1",$qualify);
echo "<td align=\"left\">Occupation:<td colspan=2 align=\"left\">";
 makeSelect($customer_occupation_array,"occupation1","Service");
echo "<tr><td align=\"left\">Voter Card No.:<td colspan=2 align=\"left\"><input type=\"TEXT\" name=\"voter_id_no1\" size=\"15\" value=\"$voter_id_no1\" $HIGHLIGHT><br>";
echo "<td align=\"left\">Pan Card No.:<td colspan=2 align=\"left\"><input type=\"TEXT\" name=\"pan_card_no1\" size=\"12\" value=\"$pan_card_no1\" maxlength=\"10\" $HIGHLIGHT>";
echo "<tr><td align=\"left\">Identity Proof:<td>";
 makeSelect($identity_proof_array,"identity_proof1","");
echo "<td align=\"left\">Dob Proof:<td>";
 makeSelect($dob_proof_array,"dob_proof1","");
echo "<td align=\"left\">Address Proof:<td>";
 makeSelect($address_proof_array,"address_proof1","");
echo "<input type=\"HIDDEN\" name=\"s_id\" value=\"$id\">";
echo "<tr><td align=\"right\" colspan=\"4\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Submit\">";
echo "  <input type=\"RESET\" name=\"RESET_BUTTON\" value=\"Cancel\">";
echo "</table>";
echo "</form>";
}
 else{
 	echo "<h1><center>You are already our bank customer !!!!!!!!!</h1>";
	echo "<h2><center>Your customer Id: $c_id</h2>";
 }
}
?>
<script language="JavaScript" type="text/javascript">
  var frmvalidator  = new Validator("form1");
  frmvalidator.addValidation("father_name1","req","Please enter the father's Name);
  frmvalidator.addValidation("father_name1","maxlen=25","Max length for father's Name is 25");
  frmvalidator.addValidation("pin1","req","Pin number should not Blank");
  frmvalidator.addValidation("pin1","maxlen=6","Max Lenght is 6 only");
  frmvalidator.addValidation("pin1","numeric","Enter Number Only");

  frmvalidator.addValidation("email1","maxlen=50","Max length is 50");
  //frmvalidator.addValidation("email1","req","Email should not Blank");
  frmvalidator.addValidation("email1","email","Enter Valid Email");
     
  //frmvalidator.addValidation("telephone1","req","Contact number should not Blank");
  frmvalidator.addValidation("telephone1","maxlen=10","Max Lenght is 10 only");
  frmvalidator.addValidation("telephone1","numeric","Enter Number Only For Contact Field");

  //frmvalidator.addValidation("voter_id_no1","req","Voter Card Number Should not Blank");
  frmvalidator.addValidation("voter_id_no1","maxlen=20","Max Lenght is 6 only");
  frmvalidator.addValidation("voter_id_no1","alphanumeric","Enter Number Only");

  //frmvalidator.addValidation("pan_card_no1","req","Pan Number Should not Blank");
  frmvalidator.addValidation("pan_card_no1","maxlen=10","Max Lenght is 10 only");
  frmvalidator.addValidation("pan_card_no1","alphanumeric","Enter Number Only");
  
</script>
<?php
echo "</body>";
echo "</html>";

?>
