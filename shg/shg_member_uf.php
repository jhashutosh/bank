<?php
include "../config/config.php";
$staff_id=verifyAutho();
$group_no=$_SESSION['current_account_no'];
$sl_no=$_REQUEST['sl_no'];
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
$sql_statement="SELECT * FROM customer_master where customer_id='$sl_no';";
$result=dBConnect($sql_statement);
echo "<html>";
echo "<head>";
//echo "Update Form---------------: Shg Members[$group_no]";
echo "</title>";
echo "</head>";
echo "<body bgcolor=\"silver\"	>";
$c_id=getCustomerIdFromGroupId($group_no);
$flag=getGeneralInfo_Customer($c_id);
if($flag==1){
if(pg_NumRows($result)==0) {
  echo "<h4>Record Not found!!!</h4>";
} else {
  $designation_type=pg_result($result,'designation1');
  $name1=pg_result($result,'name1');
  $sex=pg_result($result,'sex1');
  $dob=pg_result($result,'dob1');
  $husband_father_name=pg_result($result,'father_name1');
  $address1=pg_result($result,'address11');
  $address2=pg_result($result,'address12');
  $address3=pg_result($result,'address13');
  $pin=pg_result($result,'pin1');
  $pan=pg_result($result,'pan_card_no1');
  $mobile=pg_result($result,'telephone1');
  $identity_proof=pg_result($result,'identity_proof');
  $address_proof=pg_result($result,'address_proof');
  $dob_proof=pg_result($result,'dob_proof');
  $caste=pg_result($result,'caste1');
  $remarks=pg_result($result,'remarks');
  $operator_code=pg_result($result,'operator_code');
  $entry_time=pg_result($result,'entry_time');
echo "<form name=\"f1\" method=\"POST\" action=\"shg_member_ufa.php\">";
echo "<table bgcolor=BLACK width=100%>";
echo "<tr><td colspan=6 bgcolor=\"yellow\" align=center><b><font color=\"red\" size=+2>Self Help Group Member Update Form</b></font>";
echo "<tr bgcolor=\"#E6E6FA\"><td align=\"left\">Sl no:<td colspan=2><input type=\"TEXT\" name=\"sl_no\" size=\"10\" value=\"$sl_no\" readonly $HIGHLIGHT>";
if($designation_type=='l')
	echo "<td align=\"right\" colspan=2>Designation type:<td><input type=\"TEXT\"  size=\"6\" value=\"Leader\" readonly $HIGHLIGHT>";
else 
	echo "<td align=\"right\" colspan=2>Designation type:<td><input type=\"TEXT\"  size=\"6\" value=\"Member\" readonly $HIGHLIGHT>";
echo "<input type=\"HIDDEN\" name=\"designation1\" size=\"5\" value=\"$designation_type\">";
echo "<tr bgcolor=\"#E6E6FA\"><td align=\"left\">Name:<td colspan=2><input type=\"TEXT\" name=\"first_name\" size=\"25\" value=\"$name1\" $HIGHLIGHT><br>";
$sex=$sex_array[trim($sex)];
echo "<td align=\"right\" colspan=2>Sex:<td>";
makeSelect($sex_array,"sex",$sex);
echo "<tr bgcolor=\"#E6E6FA\"><td align=\"left\">Dob:<td colspan=2><input type=\"TEXT\" name=\"dob\" size=\"10\" value=\"$dob\" $HIGHLIGHT>";
echo "<td align=\"right\" colspan=2>Husband/Father's name:<td><input type=\"TEXT\" name=\"husband_father_name\" size=\"25\" value=\"$husband_father_name\" $HIGHLIGHT>";
echo "<tr bgcolor=\"#E6E6FA\"><td align=\"left\">Villege:<td colspan=2><input type=\"TEXT\" name=\"address1\" size=\"10\" value=\"$address1\" $HIGHLIGHT>";
echo "<td align=\"right\" colspan=2>PO:<td><input type=\"TEXT\" name=\"address2\" size=\"10\" value=\"$address2\" $HIGHLIGHT>";

echo "<tr bgcolor=\"#E6E6FA\"><td align=\"left\">PS:<td colspan=2><input type=\"TEXT\" name=\"address3\" size=\"10\" value=\"$address3\" $HIGHLIGHT>";
echo "<td align=\"right\" colspan=2>Pin:<td><input type=\"TEXT\" name=\"pin\" size=\"10\" value=\"$pin\" $HIGHLIGHT>";
echo "<tr bgcolor=\"#E6E6FA\"><td align=\"left\">Pan:<td colspan=2><input type=\"TEXT\" name=\"pan\" size=\"10\" value=\"$pan\" $HIGHLIGHT><br>";
echo "<td align=\"right\" colspan=2>Contact_no:<td><input type=\"TEXT\" name=\"mobile\" size=\"10\" value=\"$mobile\" $HIGHLIGHT><br>";
$identity_proof=$identity_proof_array[trim($identity_proof)];
echo "<tr bgcolor=\"#E6E6FA\"><td align=\"left\">Identity proof:<td colspan=2>";
 makeSelect($identity_proof_array,"identity_proof",$identity_proof);
$address_proof=$address_proof_array[trim($address_proof)];
echo "<td align=\"right\" colspan=2>Address Proof:<td>";
 makeSelect($address_proof_array,"address_proof",$address_proof);
$dob_proof=$dob_proof_array[trim($dob_proof)];
echo "<tr bgcolor=\"#E6E6FA\"><td align=\"left\">Dob Proof:<td colspan=2>";
 makeSelect($dob_proof_array,"dob_proof",$dob_proof);
$caste=$caste_array[trim($caste)];
echo "<td align=\"right\" colspan=2>Caste:<td>";
 makeSelect($caste_array,"caste",$caste);
echo "<tr bgcolor=\"#E6E6FA\"><td valign=\"top\" align=\"left\">Remarks:<td colspan=2><textarea name=\"remarks\" rows=\"1\" cols=\"40\" $HIGHLIGHT>$remarks</textarea><br>";
if($_REQUEST['o']=='e'){
echo "<td><td align=\"right\" bgcolor=\"#E6E6FA\" colspan=2><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Update my values\">";
}
else{
echo "<td><td align=\"right\" bgcolor=\"#E6E6FA\" colspan=2>";
}
echo "</table>";
echo "</form>";
 }
}
echo "</body>";
echo "</html>";

?>
