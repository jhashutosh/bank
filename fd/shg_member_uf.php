<?php
include "../config/config.php";
$group_no=$_REQUEST['group_no'];
$sl_no=$_REQUEST['sl_no'];
$db=pg_pConnect("host=$HOST dbname=$DATABASE");
$result=pg_Exec($db,$DATESTYLE);
$sql_statement="SELECT * FROM customer_master where customer_id='$sl_no';";
$result=pg_Exec($db,$sql_statement);
echo "<html>";
echo "<head>";
echo "<title>
echo "</title>";
echo "</head>";
echo "<body bgcolor=\"silver\"	>";
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
  $pan=pg_result($result,'pan1');
  $mobile=pg_result($result,'contact_no');
  //$fax=pg_result($result,'fax1');
  $identity_proof=pg_result($result,'identity_proof');
  $address_proof=pg_result($result,'address_proof');
  $dob_proof=pg_result($result,'dob_proof');
  //$minor=pg_result($result,'minor');
  $nomination=pg_result($result,'nomination');
  $signature=pg_result($result,'signature');
  $photo=pg_result($result,'photo');
  $caste=pg_result($result,'caste1');
  $remarks=pg_result($result,'remarks');
  $operator_code=pg_result($result,'operator_code');
  $entry_time=pg_result($result,'entry_time');
echo "<form name=\"f1\" method=\"POST\" action=\"shg_member_ufa.php\">";
echo "<table bgcolor=BLACK width=100%>";
echo "<tr><td colspan=6 bgcolor=\"yellow\" align=center><b><font color=\"red\" size=+2>Self Help Group Member Update Form</b></font>";
echo "<tr><td align=\"left\">Sl no:<td><input type=\"TEXT\" name=\"sl_no\" size=\"50\" value=\"$sl_no\" readonly><br>";
echo "<tr><td align=\"left\">Designation type:<td><input type=\"TEXT\" name=\"designation1\" size=\"50\" value=\"$designation_type\" readonly><br>";

echo "<tr><td align=\"left\">Name:<td><input type=\"TEXT\" name=\"first_name\" size=\"50\" value=\"$name1\"><br>";
echo "<tr><td align=\"left\">Sex:<td><input type=\"TEXT\" name=\"sex\" size=\"50\" value=\"$sex\"><br>";
echo "<tr><td align=\"left\">Dob:<td><input type=\"TEXT\" name=\"dob\" size=\"50\" value=\"$dob\"><br>";
echo "<tr><td align=\"left\">Husband/Father's name:<td><input type=\"TEXT\" name=\"husband_father_name\" size=\"50\" value=\"$husband_father_name\"><br>";
echo "<tr><td align=\"left\">Address1:<td><input type=\"TEXT\" name=\"address1\" size=\"50\" value=\"$address1\"><br>";
echo "<tr><td align=\"left\">Address2:<td><input type=\"TEXT\" name=\"address2\" size=\"50\" value=\"$address2\"><br>";
echo "<tr><td align=\"left\">Address3:<td><input type=\"TEXT\" name=\"address3\" size=\"50\" value=\"$address3\"><br>";
echo "<tr><td align=\"left\">Pin:<td><input type=\"TEXT\" name=\"pin\" size=\"50\" value=\"$pin\"><br>";
echo "<tr><td align=\"left\">Pan:<td><input type=\"TEXT\" name=\"pan\" size=\"50\" value=\"$pan\"><br>";
echo "<tr><td align=\"left\">Contact_no:<td><input type=\"TEXT\" name=\"mobile\" size=\"50\" value=\"$mobile\"><br>";
$identity_proof=$identity_proof_array[trim($identity_proof)];
echo "<tr><td align=\"left\">Identity proof:<td>";
 makeSelect($identity_proof_array,"identity_proof",$identity_proof);
$address_proof=$address_proof_array[trim($address_proof)];
echo "<tr><td align=\"left\">Address Proof:<td>";
 makeSelect($address_proof_array,"address_proof",$address_proof);
$dob_proof=$dob_proof_array[trim($dob_proof)];
echo "<tr><td align=\"left\">Dob Proof:<td>";
 makeSelect($dob_proof_array,"dob_proof",$dob_proof);
echo "<tr><td>Nomination:<td><input type=\"text\" name=\"nomination\" value=\"$nomination\"><br>";
$caste=$caste_array[trim($caste)];
echo "<tr><td align=\"left\">Caste:<td>";
 makeSelect($caste_array,"caste",$caste);
echo "<tr><td valign=\"top\" align=\"left\">Remarks:<td><textarea name=\"remarks\" rows=\"3\" cols=\"49\">$remarks</textarea><br>";
echo "<tr><td><td align=\"right\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Update my values\">";
echo "</table>";
echo "</form>";
}

footer();
echo "</body>";
echo "</html>";

?>
