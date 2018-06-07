<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$op=$_REQUEST['op'];
$share_percent=$_REQUEST['share_percent'];
$fy=$_REQUEST['fy'];
$action_date=$_REQUEST['action_date'];
$pentry_time=date('d/m/Y H:i:s ');
echo "<html>";
echo "<head>";
?>
<script LANGUAGE="JavaScript">
function val(){
var div=document.getElementById('share_percent').value;
if(div>12){
alert("Maximum 12 % of share can be given as dividend");
return false;
}

}
</script>
<?php
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script type=\"text/javascript\" src=\"../JS/bsn.AutoSuggest_c_2.0.js\"></script>";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "</head>";
if($op=='d'){
echo "<body bgcolor=\"#FFF0F5\" onload=\"bill.focus();\"><br><br>";
echo "<form name=\"f1\" method=\"POST\" action=\"dividend.php?op=v\" onsubmit=\"return val();\">";
echo "<table bgcolor='lightgreen' align=center width=70%>";
echo "<tr><th colspan='3' bgcolor=#4B0082><font color=WHITE>Percentage Of Share to be Distributed as DIVIDEND</th></tr>";
echo"<tr><td colspan='3'></td></tr>";
echo"<tr><td align='right'>Financial Year</td><td>:</td><td><select name='fy'>";
$sql="select fy from fy_list";
$result=dBConnect($sql);
for($j=0; $j<pg_NumRows($result); $j++){
$row=pg_fetch_array($result,$j);
echo"<option>".$row['fy']."</option>";
                                        }
echo"</select>";
echo"</td></tr>";
echo "<tr>";
echo "<td align=\"right\">Date</td><td>:</td><td><input type=\"TEXT\" name=\"action_date\" size=\"12\" value=\"".date('d.m.Y')."\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.action_date,'dd/mm/yyyy','Choose Date')\"></td></tr>";
echo "<td align=\"right\">Percentage of Share</td><td>:</td>";
echo "<td><input type=\"TEXT\" name=\"share_percent\" size=\"4\" id=\"share_percent\" $HIGHLIGHT>";
echo "</td></tr><tr>";
echo "<td colspan='3' align=\"right\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Enter\"></td></tr>";
echo "</table>";
echo "</form>";
}
if($op=='v'){
echo "<body bgcolor=\"#FFF0F5\" onsubmit=\"return val();\"><br><br>";
echo "<form name=\"f1\" method=\"POST\" action=\"dividend.php?op=i\" onsubmit=\"return val();\">";
echo "<table bgcolor='orange' align=center width=70%>";
echo "<tr><th colspan='3' bgcolor='yellow'><font color='darkblue'>Percentage Of Share to be Distributed as DIVIDEND</th></tr>";
echo"<tr><td colspan='3'></td></tr>";
echo"<tr><td align='right'>Financial Year</td><td>:</td><td><input type=\"TEXT\" name=\"fy\" size=\"10\" id=\"fy\" value=\"$fy\" $HIGHLIGHT>";
echo"</td></tr>";
echo "<tr>";
echo "<td align=\"right\">Date</td><td>:</td><td><input type=\"TEXT\" name=\"action_date\" size=\"12\" value=\"$action_date\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.action_date,'dd/mm/yyyy','Choose Date')\"></td></tr>";
echo "<td align=\"right\">Percentage of Share</td><td>:</td>";
echo "<td><input type=\"TEXT\" name=\"share_percent\" size=\"4\" id=\"share_percent\" value=\"$share_percent\" $HIGHLIGHT>";
echo "</td></tr><tr>";
echo "<td colspan='3' align=\"right\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Enter\"></td></tr>";
echo "</table>";
echo "</form>";
}
echo"<table width='100%'>";
echo"<tr><td align='center'><iframe src=\"div_db.php\" width=\"100%\" height=\"200\" ></iframe>";
echo"</table>";
if($op=='i'){
$sql_statement="INSERT INTO dividend_mas VALUES('$fy',$share_percent,'$action_date','$staff_id','$pentry_time')";
$result=dBConnect($sql_statement);
if(pg_affected_rows($result)<1) {
	echo "<br><h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
	} 
else {
            header("Location:dividend.php?op=d");
      }
   

}
echo "</body>";
echo "</html>";
?>
