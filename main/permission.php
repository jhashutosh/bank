<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$user_id=$_REQUEST['user_id'];
$v_dt_fr=$_REQUEST['v_dt_fr'];
$v_dt_to=$_REQUEST['v_dt_to'];
$time_fr=$_REQUEST['time_fr'];
$time_to=$_REQUEST['time_to'];
$a_dt_fr=$_REQUEST['a_dt_fr'];
$a_dt_to=$_REQUEST['a_dt_to'];
$op=$_REQUEST['op'];
echo "<html>";
echo "<head>";
?>
<script>
function validator1(f)
	{	//alert("ok");
		var msg='';//alert("msg");
		if(f.a_dt_fr.value.length==0)
		{
			msg+="Please Give After Date From..\n";//return false;
		}
		if(f.a_dt_to.value.length==0)
		{
			msg+="Please Give After Date To..\n";//return false;
		}
		if(msg==''){
			return true;
		}
		else{
			alert(msg);
			return false;
		}
	}




</script>
<?php
echo "<title>Entry Permission";
echo "</title>";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
if(empty($op)){
echo "<form method=\"POST\" action=\"permission.php?op=e\" name=\"f1\" onSubmit=\"return validator1(this);\">";
echo "<table bgcolor=#E6E6FA align=center width=90%>";
echo "<tr><th colspan=\"4\" bgcolor=green><font color=white size=4>Entry Permission Form</font></th></tr>";
echo "<tr><td align=\"left\">Staff Id:<td>";
makeSelectFromDB('staff','id','user_id');
echo "<tr><td align=\"left\">Valid Date From:<td><input type=\"TEXT\" name=\"v_dt_fr\" size=\"12\" value=\"".date("d.m.Y")."\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.v_dt_fr,'dd/mm/yyyy','Choose Date')\" >";
echo "<td align=\"left\">Valid Date To:<td><input type=\"TEXT\" name=\"v_dt_to\" size=\"12\" value=\"".date("d.m.Y")."\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.v_dt_to,'dd/mm/yyyy','Choose Date')\" >";
echo "<tr><td align=\"left\">Time From:<td><input type=\"TEXT\" name=\"time_fr\" size=\"7\" value=\"00:00\" $HIGHLIGHT>";
echo "<td align=\"left\">Time To:<td><input type=\"TEXT\" name=\"time_to\" size=\"7\" value=\"24:00\" $HIGHLIGHT>";
echo "<tr><td align=\"left\">Allow Date From:<td><input type=\"TEXT\" name=\"a_dt_fr\" id=\"a_dt_fr\" size=\"12\" value=\"\" onblur=\"return validator1(this);\" onkeypress=\"return $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.a_dt_fr,'dd/mm/yyyy','Choose Date')\" >";
echo "<td align=\"left\">Allow Date To:<td><input type=\"TEXT\" name=\"a_dt_to\" id=\"a_dt_to\" size=\"12\" value=\"\" onblur=\"return validator1(this);\" onkeypress=\"return $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.v_dt_to,'dd/mm/yyyy','Choose Date')\" >";
echo "<tr><td><td align=RIGHT><INPUT TYPE=\"SUBMIT\" VALUE=\"Enter\">";
echo "</table>";
echo"<HR>";
$sql_statement="SELECT * FROM allow ORDER BY entry_time DESC";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
echo "<table align=center bgcolor=#FFE4B5 width=100%>";
echo "<tr><th colspan=9 bgcolor=GREEN>Entry Permission</th>";
echo "<tr bgcolor=#FF00FF><th rowspan=\"2\">User Id<th colspan=\"2\">Valid Date<th colspan=\"2\" >Time<th colspan=\"2\">Allow Date<th rowspan=\"2\">Granter <th rowspan=\"2\">Entry Time";
echo "<tr bgcolor=#FF00FF><th>From<th>To<th>From<th>To<th>From<th>To";
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
		echo "<tr>";
		echo "<td bgcolor=$color>".$row["user_id"];
		echo "<td bgcolor=$color>".$row["valid_date_from"];
		echo "<td bgcolor=$color>".$row["valid_date_to"];
		echo "<td bgcolor=$color>".$row["time_from"];
		echo "<td bgcolor=$color>".$row["time_to"];
		echo "<td bgcolor=$color>".$row["allow_date_from"];
		echo "<td bgcolor=$color>".$row["allow_date_to"];
		echo "<td bgcolor=$color>".$row["staff_id"];
		echo "<td bgcolor=$color>".$row["entry_time"];
		}
		
 }
}
if($op=='e'){
$sql_statement="INSERT INTO allow VALUES('$user_id','$v_dt_fr','$v_dt_to','$time_fr','$time_to', '$a_dt_fr','$a_dt_to','$staff_id',now())";
echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_affected_rows($result)<1)
  {
   echo "<h1><blink>sorry database not updated due to some reason!!!!!!!!!!!!!!!!!!</h1>";
  }
 else{
	header('Location:permission.php');
     }

}
