<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$id=$_REQUEST['id'];
$desc=$_REQUEST['mini_desc'];
$time=date('d/m/Y H:i:s ');
$op_dt=$_REQUEST['op_dt'];
$op_name=$_REQUEST['op_name'];
$op_add=$_REQUEST['address'];
$op=$_REQUEST['op'];
$link_dt=$_REQUEST['lnk_date'];
echo "<html>";
echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"desc.focus();\">";
echo "<center><font color=yellow size=6><b>Mini Information</b></font></center>";
if (empty($op)){
echo "<hr><br><br>";
echo "<form name='f1' method=\"POST\" action=\"mini_master_ef.php?op=i\">";
echo "<table bgcolor=AQUA align=center width=80%>";
$id=countRows('mini_mas');
echo "<tr><TH colspan=4 bgcolor=BLUE><font color=WHITE size=+2 align=\"center\"><b>MINI-ENTRY-FORM";
echo "<tr><td align=\"left\">Mini Id:<td><input type=\"TEXT\" name=\"id\" size=\"2\" value=\"$id\" $HIGHLIGHT READONLY><td>";
echo "<tr><td align=\"left\">Mini Description:<td><input type=\"TEXT\" name=\"mini_desc\" size=\"15\" id=\"desc\" $HIGHLIGHT>";
echo "<td align=\"left\"><font color=red size=\"2\">*</font>Mini Installation date:</td><td><input type=\"TEXT\" name=\"op_dt\" id=\"op_dt\" size=\"10\" value=\"".date('d/m/Y')."\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"date1\" value=\"...\" onclick=\"showCalendar(f1.op_dt,'dd/mm/yyyy','Choose Date')\"></td></tr>";
echo "<tr><td align=\"left\">Operator Name:<td><input type=\"TEXT\" name=\"op_name\" size=\"15\"  $HIGHLIGHT>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
echo"<td align=\"left\"><font color=red size=\"2\">*</font>Operator address <br> & Ph No.:</td><td><input type=\"TEXT\" name=\"address\" size=30 value=\"\" $HIGHLIGHT>";
echo"<tr><td align=\"left\">Link Date:<font color=\"RED\">*</font><td colspan='2'><input type=\"TEXT\" VALUE=\"".date('d/m/Y')."\" name=\"lnk_date\" size=\"15\"  $HIGHLIGHT>&nbsp;(DD/MM/YYYY)";
echo"<td colspan='1' align='right'><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Enter\">";
echo "</table>";
echo "</form>";
}
/*
if ($op=='up')
{
$sql_statement="SELECT * from mini_mas where mini_id='$id'";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0) {
$desc=pg_result($result,1);
$op_name=pg_result($result,2);
echo "<hr><br><br>";
echo "<form method=\"POST\" action=\"mini_master_ef.php?op=u\">";
echo "<table bgcolor=AQUA align=center width=80%>";
echo "<tr><TH colspan=4 bgcolor=BLUE><font color=WHITE size=+2 align=\"center\"><b>MINI-ENTRY-FORM";
echo "<tr><td align=\"left\">Mini Id:<td><input type=\"TEXT\" name=\"id\" size=\"10\" value=\"$id\" $HIGHLIGHT READONLY><td>";
echo "<tr><td align=\"left\">Mini Description:<td><input type=\"TEXT\" name=\"mini_desc\" size=\"15\" value=\"$desc\" $HIGHLIGHT>";
echo "<td align=\"left\"><font color=red size=\"2\">*</font>Mini Installation date:</td><td><input type=\"TEXT\" name=\"op_dt\" id=\"op_dt\" size=\"10\" value=\"".date('d/m/Y')."\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"date1\" value=\"...\" onclick=\"showCalendar(f1.op_dt,'dd/mm/yyyy','Choose Date')\"></td></tr>";

echo "<tr><td align=\"left\">Mini Operator Nmae:<td><input type=\"TEXT\" name=\"op_name\" size=\"15\" value=\"$op_name\" $HIGHLIGHT>";
echo "&nbsp;</td>";
echo"<td align=\"left\"><font color=red size=\"2\">*</font>Operator address <br> & Ph No.:</td><td><input type=\"TEXT\" name=\"address\" size=30 value=\"\" $HIGHLIGHT>";
echo"<tr><td align=\"left\">Link Date:<font color=\"RED\">*</font><td colspan='2'><input type=\"TEXT\" VALUE=\"".date('d/m/Y')."\" name=\"lnk_date\" size=\"15\"  $HIGHLIGHT>&nbsp;(DD/MM/YYYY)";
echo"<td colspan='1' align='right'><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Enter\">";
echo "</table>";
echo "</form>";
}
else{
echo 'Wrong mini Id';
}

}
if ($op=='u'){
$sql_statement="UPDATE mini_mas set mini_desc='$desc',mini_operator_name='$op_name' where mini_id='$id'";
echo $sql_statement;
$result=dBConnect($sql_statement);
if (pg_affected_rows($result)<1){
	echo "<br><h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
	}
else{
	header('location:general_master_view.php?op=m');
	}
}*/
if ($op=='i'){
//====================================//change for land & crop wise mini module//========================================
$sql_statement="select LC_Mini_Master_Vld_Fnc('$desc') as vld";
		//echo $sql_statement;
		$result=dBConnect($sql_statement);
		$return=pg_result($result,'vld');
		if($return==1)
			{
			$sql_statement="SELECT LC_Mini_Master_Save_Fnc('$desc','$op_dt','$staff_id','$time')";
			$result=dBConnect($sql_statement);
			
					if(pg_NumRows($result)>0)
			
						echo "<h4><font color=GREEN>Data inserted successfully.</font></h4>";
			
					else
			
						echo "<h4><font color=RED><blink> Entry failure</blink></font></h4>";
			
$sql_statement="SELECT LC_Operator_Master_Save_Fnc('$op_name','$op_add',current_date,'$staff_id','$time') as integer";
$result=dBConnect($sql_statement);			
//echo $sql_statement;
$sql_mini_id="select id from lc_mini_master where mini_name='$desc'";
$res_id_mini=dBConnect($sql_mini_id);
$mini_id=pg_result($res_id_mini,'id');

$sql_id_op="select id from lc_operator_master where operator_name='$op_name' and address='$op_add'";
$res_id_op=dBConnect($sql_id_op);

$op_id=pg_result($res_id_op,'id');

$sql_statement="SELECT LC_Mini_Operator_Link_Save_Fnc($mini_id,$op_id,'$link_dt',null,'$staff_id','$time')";
//echo $sql_statement;
$result=dBConnect($sql_statement);


$sql_statement="INSERT INTO mini_mas VALUES('$id', lower('$desc'),lower('$op_name'))";
$result1=dBConnect($sql_statement);
}
else
			
			echo "<h4><font color=RED><blink>Duplicate entry.</blink></font></h4>";
//====================================//change for land & crop wise mini module//========================================

if (pg_affected_rows($result1)<1)
	echo "<br><h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
	
else{
	header('location:general_master_view.php?op=m');
	}
}
echo "</body>";
echo "</html>";

?>
