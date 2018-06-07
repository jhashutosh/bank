<?php
include "../config/config.php";
$staff_id=verifyAutho();
$group_no=$_REQUEST["group_no"];
$sl_no=$_REQUEST["sl_no"];
$designation_type=$_REQUEST["designation"];
$mname=$_REQUEST["mname"];
$sex=$_REQUEST["sex"];
$dob=$_REQUEST["dob"];
$f_name=$_REQUEST["husband_father_name"];
$address1=$_REQUEST["address1"];
$address2=$_REQUEST["address2"];
$address3=$_REQUEST["address3"];
$pin=$_REQUEST["pin"];
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
echo "<html>";
echo "<head>";
echo "<title>Entry Form - Table: Shg_member";
echo "</title>";
echo "</head>";
echo "<body bgcolor=\"silver\" >";
echo "<h1>Entry Form - Table: Shg_member";
echo "</h1>";
echo "<h3>Your submission has been accepted.";
echo "</h3>";
echo "<hr>";
// Modification required to suite data type
$sql_statement="INSERT INTO customer_master (customer_id,type_of_customer,name1,designation1,sex1,dob1, caste1,father_name1,address11, address12,address13,pin1,telephone1,email1,pan_card_no1, voter_id_no1,occupation1, qualification1,identity_proof1,address_proof1,dob_proof1,operator_code,entry_time) VALUES('$sl_no','$group_no',lower('$mname'),'$designation_type','$sex','$dob','$caste',lower('$f_name'),lower('$address1'),lower('$address2'),lower('$address3'),'$pin','$mobile',lower('$email'),'$pan','$vcn', '$occupation','$qualification','$identity_proof','$dob_proof', '$address_proof','$staff_id',now())";
if($designation_type=='l'){
$sql_statement.=";UPDATE shg_info SET leader_name=lower('$mname') WHERE shg_no='$group_no'";
}
if($designation_type=='s'){
$sql_statement.=";UPDATE shg_info SET sub_leader_name=lower('$mname') WHERE shg_no='$group_no'";
}
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_affected_rows($result)<1) {
	echo "<br><h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
} else {	
        header("Location:../main/set_account.php?menu=shg&account_no=$group_no");
}

echo "</body>";
echo "</html>";

?>
