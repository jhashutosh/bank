<?
include "../config/config.php";echo "<html>";
echo "<head>";
echo "<title>Entry Form - Table: Shg_member";
echo "</title>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<script src=\"../JS/validation.js\">";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<BODY bgcolor=\"silver\" onload=\"mname.focus();\">";
echo "<form name=\"f1\" method=\"POST\" action=\"1.php?op=i\">";
echo "<table bgcolor=BLACK width=100%>";
echo "<tr><td colspan=6 bgcolor=\"#8A2BE2\" align=center><b><font size=+2>Group Member Entry Form</b></font>";
echo "<tr bgcolor=\"#BDB76B\"><td align=\"left\">Member id:<td  colspan=2><input type=\"TEXT\" name=\"sl_no\" size=\"10\" value=\"\"  id=\"mname\" $HIGHLIGHT>";
echo "<td align=\"Right\" colspan=\"3\">";
echo "<tr bgcolor=\"#BDB76B\"><td align=\"left\" >Name of Member:<td colspan=2><input type=\"TEXT\" name=\"mname\"  size=\"20\" value=\"\" $HIGHLIGHT><br>";
echo "<td align=\"Right\" colspan=2 >Husband/Father's name:<td><input type=\"TEXT\" name=\"f_name\" size=\"20\" value=\"\" $HIGHLIGHT><br>";
echo "<tr bgcolor=\"#BDB76B\"><td align=\"left\">Sex:<td>";
makeSelect($sex_array,"sex","");
echo "<td align=\"left\">DOB:<td><input type=\"TEXT\" name=\"dob\" size=\"12\" value=\"\" $HIGHLIGHT>";
echo "<input type=\"BUTTON\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.dob,'dd/mm/yy','Choose Date')\">";
echo "<td align=\"left\">Caste:<td>";
 makeSelect($caste_array,"caste","");
echo "<tr bgcolor=\"#BDB76B\"><td align=\"left\">Village:<td><input type=\"TEXT\" name=\"address1\" size=\"15\" value=\"$VILL_DEFAULT\" $HIGHLIGHT><br>";
echo "<td align=\"left\">PO:<td><input type=\"TEXT\" name=\"address2\" size=\"15\" value=\"$POST_DEFAULT\" $HIGHLIGHT><br>";
echo "<td align=\"left\">PS:<td><input type=\"TEXT\" name=\"address3\" size=\"15\" value=\"$POLICESTATION_DEFAULT\" $HIGHLIGHT><br>";
echo "<tr bgcolor=\"#BDB76B\"><td align=\"left\">Pin:<td><input type=\"TEXT\" name=\"pin\" size=\"10\" value=\"$PIN_DEFAULT\" $HIGHLIGHT><br>";
echo "<td align=\"left\">Contact no:<td><input type=\"TEXT\" name=\"mobile\" size=\"10\" value=\"\" $HIGHLIGHT>";
echo "<td align=\"left\">Basic:<td><input type=\"TEXT\" name=\"mobile\" size=\"10\" value=\"\" $HIGHLIGHT>";
//echo "<td colspan=2>";echo "<tr bgcolor=\"#BDB76B\"><td align=\"right\" colspan=6><input type=\"RESET\" name=\"RESET_BUTTON\" value=\"Reset\" $HIGHLIGHT><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Submit\" $HIGHLIGHT>";
echo "</table>";
echo "</form>";
echo "<hr>";
if($_REQUEST['op']=='i'){
$sql_statement="INSERT INTO temp_member VALUES('".$_REQUEST['sl_no']."','".$_REQUEST['mname']."','".$_REQUEST['f_name']."','".$_REQUEST['sex']."','".$_REQUEST['caste']."','". $_REQUEST['address1']."','".$_REQUEST['address2']."','".$_REQUEST['address2']."','".$_REQUEST['pin']."','".$_REQUEST['mobile']."')";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_affected_rows($result)<1) 
	echo "<br><h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
}
//=============================================================================================
$sql_statement="SELECT * FROM temp_member";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4>Record Not Found !!!!!</h4>";
} else {
echo "<table valign=\"top\" bgcolor=BLACK width=\"100%\">";
echo "<tr><td bgcolor=\"green\" colspan=\"7\" align=\"center\"><font color=\"white\">Statement</font>";
// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color>Id</th>";
echo "<th bgcolor=$color>Name</th>";
echo "<th bgcolor=$color>Father's Name</th>";
echo "<th bgcolor=$color>Address</th>";
echo "<th bgcolor=$color>Sex</th>";
echo "<th bgcolor=$color>Caste</th>";
echo "<th bgcolor=$color>Contact No</th>";
for($j=1; $j<=pg_NumRows($result); $j++){
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j-1));
echo "<tr>";
echo "<td align=CENTER bgcolor=$color>".$row['id']."</td>";
echo "<td align=CENTER bgcolor=$color>".$row['name']."</td>";
echo "<td align=CENTER bgcolor=$color>".$row['fname']."</td>";
echo "<td align=CENTER bgcolor=$color>".$row['add1']." ".$row['add2']." ".$row['pin']."</td>";
echo "<td align=CENTER bgcolor=$color>".$row['sex']."</td>";
echo "<td align=CENTER bgcolor=$color>".$row['caste']."</td>";
echo "<td align=CENTER bgcolor=$color>".$row['ph']."</td>";
 }
}

echo "</body>";
echo "</html>";

?>
