<?
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$op=$_REQUEST['op'];
$remarks=$_REQUEST['remarks'];
$pass=$_REQUEST['pass'];
$TCOLOR='silver';
if($op=='i'){
$sql_statement="INSERT INTO passing_remarks (passing_status,remarks) VALUES($pass,'$remarks')";
$result=dBConnect($sql_statement);
echo $sql_statement;
if(pg_affected_rows($result)<1) {
	echo "<br><h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
	} 
else {
            header("Location:remark.php?op=d");
      }
   

}
echo "<html>";
echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script type=\"text/javascript\" src=\"../JS/bsn.AutoSuggest_c_2.0.js\"></script>";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "</head>";
if($op=='d'){
echo "<body bgcolor=\"#FFF0F5\" onload=\"bill.focus();\"><br><br>";
echo "<form name=\"f1\" method=\"POST\" action=\"remark.php?op=i\">";
echo "<table bgcolor='lightyellow' align=center width=70%>";
echo "<tr><th colspan='6' bgcolor=#4B0082><font color=WHITE>Remarks by Passing Authority</th></tr>";
echo"<tr><td colspan='6'></td></tr>";
echo"<tr><td>Passing Status</td><td>:</td><td>";
makeSelectpass($passing_array,"pass");
echo"</td>";
echo "<td align=\"right\">Remarks</td><td>:</td>";
echo "<td><input type=\"TEXT\" name=\"remarks\" size=\"15\" id=\"remarks\" $HIGHLIGHT>";
echo "</td></tr><tr>";
echo "<td colspan='6' align=\"right\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Enter\"></td></tr>";
echo"<tr><th colspan='3' bgcolor='Darkgreen'><font color='white'>Passing Status</th><th  bgcolor='Darkgreen' colspan='3'><font color='white'>Remarks</th></tr><tr>";
$sql="select remarks,case when passing_status=1 then 'Yes' when passing_status=-1 then 'No' else 'Pending' end from passing_remarks";
$res=dBConnect($sql);
for($j=0; $j<pg_NumRows($res); $j++){
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($res,$j);
if($row['case']=='Yes')$font='Green';
if($row['case']=='No')$font='Red';
if($row['case']=='Pending')$font='Darkblue';
echo"<td colspan='3' bgcolor=$color align='center'><font color=$font>".$row['case'];
echo"<td colspan='3' bgcolor=$color align='center'><font color=$font>".$row['remarks'];
echo "</tr>";

}
echo "</table>";
echo "</form>";
}

echo "</body>";
echo "</html>";
?>
