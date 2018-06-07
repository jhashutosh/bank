<?
include "../config/config.php";
$staff_id=verifyAutho();
// PHP4 
$group_no=$_SESSION['current_account_no'];
$sl_no=$_REQUEST["sl_no"];
$designation=$_REQUEST["designation_type"];
$first_name=$_REQUEST["first_name"];
$sex=$_REQUEST["sex"];
$dob=$_REQUEST["dob"];
$husband_father_name=$_REQUEST["husband_father_name"];
$address1=$_REQUEST["address1"];
$address2=$_REQUEST["address2"];
$address3=$_REQUEST["address3"];
$pin=$_REQUEST["pin"];
$pan=$_REQUEST["pan"];
$mobile=$_REQUEST["mobile"];
$email=$_REQUEST["email"];
$identity_proof=$_REQUEST["identity_proof"];
$address_proof=$_REQUEST["address_proof"];
$dob_proof=$_REQUEST["dob_proof"];
$minor=$_REQUEST["minor"];
$nomination=$_REQUEST["nomination"];
$signature=$_REQUEST["signature"];
$photo=$_REQUEST["photo"];
$caste=$_REQUEST["caste"];
$remarks=$_REQUEST["remarks"];
$operator_code=$_REQUEST["operator_code"];
$entry_time=$_REQUEST["entry_time"];
$qualification=$_REQUEST["qualify"];
$pan=$_REQUEST["pan"];
$vcn=$_REQUEST["vcn"];
$mobile=$_REQUEST["mobile"];
$email=$_REQUEST["email"];
$identity_proof=$_REQUEST["identity_proof"];
$address_proof=$_REQUEST["address_proof"];
$dob_proof=$_REQUEST["dob_proof"];
$nomination=$_REQUEST["nomination"];
$caste=$_REQUEST["caste"];
$occupation=$_REQUEST['occupation'];
$sex=getIndex($sex_array,$_REQUEST["sex"]);
//-------------------------------------------------------------
$identity_proof=getIndex($identity_proof_array,$identity_proof);
$address_proof=getIndex($address_proof_array,$address_proof);
$dob_proof=getIndex($dob_proof_array,$dob_proof);
$occupation=getIndex($customer_occupation_array,$occupation);
$qualification=getIndex($customer_qualification_array,$qualification);
$caste=getIndex($caste_array,$caste);
if(empty($dob)){$dob=date("d.m.y");}
if(empty($dob)){$dob=date("d.m.y");}
echo "<html>";
echo "<head>";
echo "<title>Update Form - Table: Shg_member";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\"	>";
echo "<h1>Update Form - Table: Shg_member";
echo "</h1>";
echo "<h3>Your submission has been accepted.";
echo "</h3>";
echo "<hr>";
$sl_no=trim($sl_no);
// Modification required for WHERE CLAUSE
$sql_statement="UPDATE customer_master SET  pan_card_no1='$pan',name1=lower('$first_name'),sex1='$sex',dob1='$dob',father_name1=lower('$husband_father_name'), address11=lower('$address1'),address12=lower('$address2'), address13=lower('$address3'),pin1='$pin', telephone1='$mobile',caste1='$caste',operator_code='$staff_id', entry_time=now() WHERE customer_id='$sl_no'";
$result=dBConnect($sql_statement);
//echo $sql_statement;
if(pg_affected_rows($result)<1) {
	echo "<br><h5><font color=\"RED\">Failed to update data into database.</font></h5>";
} else {
	echo "<br><h5><font color=\"GREEN\">Data entered into database.</font></h5>";
}

footer();
echo "</body>";
echo "</html>";

?>
