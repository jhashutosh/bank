<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
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
echo "<th bgcolor=GREEN><font color=white size=4>Entry Form for New Staff</font></th>";
echo "</table>";
//echo "<h>Please fill-up this form";
//echo "</h3>";
echo "<hr>";
if(empty($op)){
$id=checkStaffId($id);
if(empty($id)){
echo "<form name=\"form1\" action=\"staff_ef.php\" method=\"post\">";
echo "<table>";
echo "<tr><td align=\"left\">Check Id:&nbsp;&nbsp;&nbsp; &nbsp; <td><input type=\"TEXT\" name=\"id\" size=\"25\" id=\"s_id\" $HIGHLIGHT>";
echo "<td><input type=\"SUBMIT\" value=\"Check\">";
echo "</table>";
echo "</form>";
}
else{
echo "<form name=\"form2\" method=\"POST\" action=\"staff_eadd.php?op=i\">";
echo "<table bgcolor=pink align=center width=100%>";
echo "<tr><td align=\"left\">LoginId:<td><input type=\"TEXT\" name=\"user_id\" size=\"15\" value=\"$id\" readonly $HIGHLIGHT>";
echo "<tr><td align=\"left\">Password:<td><input type=\"PASSWORD\" id=\"s_id\" name=\"pass\" size=\"15\" value=\"\" $HIGHLIGHT>";
echo "<tr><td align=\"left\">Repassword:<td><input type=\"PASSWORD\" name=\"repassword\" size=\"15\" value=\"\" $HIGHLIGHT>";
echo "<tr><td align=\"left\">Name:<td><input type=\"TEXT\" name=\"name\" size=\"20\" value=\"\" $HIGHLIGHT>";
echo "<tr><td align=\"left\">Address:<td><input type=\"TEXT\" name=\"add\" size=\"35\" value=\"\" $HIGHLIGHT>";
echo "<tr><td align=\"left\">Sex:<td>";
 makeSelect($sex_array,"sex","");
echo "<tr><td align=\"left\">Contact No.:<td><input type=\"TEXT\" name=\"ph\" size=\"11\" value=\"\" $HIGHLIGHT><br>";
echo "<tr><td align=\"left\">Qualification:<td>";
makeSelect($customer_qualification_array,"qualify","Higher Secondary");
echo "<tr><td align=\"left\">Designation:<td>";
makeSelect($designation_orga_array,"designation","Staff");
echo "<tr><td align=\"left\">Date Of Joining:<td><input type=\"TEXT\" name=\"doj\" size=\"11\" value=\"\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"Choose Date\" onclick=\"showCalendar(form2.doj,'dd/mm/yyyy','Choose Date')\"><br></tr>";
echo "<tr><td align=\"left\">Role:<td>";
makeSelect($role_of_array,"role","");
echo "<tr><td align=\"left\">Reporting Boss:<td>";
getReportingBoss();
echo "<tr><td><td align=\"\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Submit\">";
echo "  <input type=\"RESET\" name=\"RESET_BUTTON\" value=\"Cancel\"><br>";
echo "</table>";
echo "</form>";
  }
}
if($op=='m'){
$sql_statement="SELECT * FROM staff WHERE id='$id'";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0) {
	$name=pg_result($result,'name');
 	$password=pg_result($result,'password');
	$address=pg_result($result,'address');
	$ph=pg_result($result,'contact_no');
	$sex=trim(pg_result($result,'sex'));
	$sex=$sex_array[$sex];
  	$qualify=trim(pg_result($result,'qualification'));
	$qualify=$customer_qualification_array[$qualify];
	$doj=pg_result($result,'date_of_join');
  	$designation=trim(pg_result($result,'designation'));
	$designation=$designation_orga_array[$designation];
	$role=trim(pg_result($result,'role'));
	$role=$role_of_array[$role];
  	$boss=pg_result($result,'boss');
        }
echo "<form name=\"f2\" method=\"POST\" action=\"staff_eadd.php?op=u\">";
echo "<table bgcolor=pink align=center width=100%>";
echo "<tr><td align=\"left\">LoginId:<td><input type=\"TEXT\" name=\"user_id\" size=\"15\" value=\"$id\" readonly $HIGHLIGHT>";
echo "<tr><td align=\"left\">Password:<td><input type=\"PASSWORD\" id=\"s_id\" name=\"pass\" size=\"15\" value=\"$password\" $HIGHLIGHT>";
echo "<tr><td align=\"left\">Repassword:<td><input type=\"PASSWORD\" name=\"repassword\" size=\"15\" value=\"\" $HIGHLIGHT>";
echo "<tr><td align=\"left\">Name:<td><input type=\"TEXT\" name=\"name\" size=\"20\" value=\"$name\" $HIGHLIGHT>";
echo "<tr><td align=\"left\">Address:<td><input type=\"TEXT\" name=\"add\" size=\"35\" value=\"$address\" $HIGHLIGHT>";
echo "<tr><td align=\"left\">Sex:<td>";
 makeSelect($sex_array,"sex",$sex);
echo "<tr><td align=\"left\">Contact No.:<td><input type=\"TEXT\" name=\"ph\" size=\"11\" value=\"$ph\" $HIGHLIGHT><br>";
echo "<tr><td align=\"left\">Qualification:<td>";
makeSelect($customer_qualification_array,"qualify",$qualify);
echo "<tr><td align=\"left\">Designation:<td>";
makeSelect($designation_orga_array,"designation",$designation);
echo "<tr><td align=\"left\">Date Of Joining:<td><input type=\"TEXT\" name=\"doj\" size=\"11\" value=\"$doj\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"Choose Date\" onclick=\"showCalendar(form2.doj,'dd/mm/yyyy','Choose Date')\"><br></tr>";
echo "<tr><td align=\"left\">Role:<td>";
makeSelect($role_of_array,"role",$role);
echo "<tr><td align=\"left\">Reporting Boss:<td>";
getReportingBoss();
echo "<tr><td><td align=\"\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Update\">";
echo "  <input type=\"RESET\" name=\"RESET_BUTTON\" value=\"Cancel\"><br>";
echo "</table>";
echo "</form>";
}
if($op=='d'){
$sql_statement="DELETE FROM staff WHERE id='$id'";
echo $sql_statement; 
$result=dBConnect($sql_statement);
if(pg_affected_rows($result)<1) {
	echo "<br><h5><font color=\"RED\">Failed to Update data into database.</font></h5>";
} else {
	header("Location:staff_tabular.php");
 	}
}
?>
<script language="JavaScript" type="text/javascript">
  var frmvalidator  = new Validator("form2");
  frmvalidator.addValidation("password","req","Please enter the Password);
  frmvalidator.addValidation("password","maxlen=10","Max length for Password is 10");
  frmvalidator.addValidation("repassword","req","Please Re-Type the Password");
  frmvalidator.addValidation("repassword","maxlen=10","Max length for Repassword is 10");
  frmvalidator.addValidation("name","req","Please Enter the Name of Employee");
  frmvalidator.addValidation("add","req","Please Enter the Address of Employee");
  frmvalidator.addValidation("ph","req","Please Enter the Phone No. of Employee");
  frmvalidator.addValidation("ph","maxlen=15","Maximum Length of Phone No. is 15");
  frmvalidator.addValidation("ph","numeric","Phone No. should be Number Only");
 </script>
<?php
echo "</body>";
echo "</html>";

?>
