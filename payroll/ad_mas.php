<?
include "../config/config.php";
$staff_id==verifyAutho();
$op=$_REQUEST['op'];
?>
<script LANGUAGE="JavaScript">
function val(f)
{
var grnl=document.getElementById('agr_no').value.length;
var sandl=document.getElementById('san_date').value.length;
var amtl=document.getElementById('agr_amt').value.length;
if(grnl==0)
{
alert("You Must enter Adhoc Grant Id");
return false;
}
if(sandl==0)
{
alert("You Must enter Sanction Date");
return false;
}
if(amtl==0)
{
alert("You Must enter Grant Amount");
return false;
}
}
</script>
<?
if($op=='i'){
$TCOLOR='#FFFCD3';
$TBGCOLOR='#D3FFFD';
$gran_id=$_REQUEST['agr_no'];
$san_date=$_REQUEST['san_date'];
$rec_date=$_REQUEST['rec_date'];
$gran_amt=$_REQUEST['agr_amt'];
$rem=$_REQUEST['rem'];
$entry_time=date('d/m/Y H:i:s ');
$sql="select emp_adhoc_grant_mas_save_fnc('$gran_id','$san_date','$rec_date',$gran_amt,'Govt.','$rem','1','$staff_id','$entry_time')";
$result=dBConnect($sql);

//echo $sql;
}
echo "<html>";
echo "<head>";
echo "<title>Adhoc Master</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<script src=\"../JS/loading2.js\"></script>";
echo "</head>";
echo "<body bgcolor=\"#E1FFEF\">";
echo "<form name=\"f1\" METHOD=\"POST\" ACTION=\"ad_mas.php?op=i\" onSubmit=\"return val(this.form);\">";
echo "<CENTER><br><br>";
echo"<input type='hidden' name='blnc' id='blnc' value=''>";
echo "<table width=\"100%\" bgcolor='#D2E9F2'>";
echo "<tr><td bgcolor=\"006666\" colspan=\"6\" align=\"center\"><b><font color=\"WHITE\">Adhoc Grant Master</font>";
echo "<tr>";
echo "<td bgcolor=\"#D2E9F2\">Grant Id";
echo"<td bgcolor=\"#D2E9F2\">:</td><td bgcolor=\"#D2E9F2\"><input type='text' name='agr_no' id='agr_no' size='5' $HIGHLIGHT><font color=\"red\">*</font></td>";
echo"</td><td bgcolor=\"#D2E9F2\" width='12%'> Sanction Date";
echo"<td bgcolor=\"#D2E9F2\">:</td><td bgcolor=\"#D2E9F2\"><input type='text' name='san_date' id='san_date' size='10' $HIGHLIGHT><font color=\"red\">*</font>";
echo"&nbsp<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.san_date,'dd/mm/yyyy','Choose Date')\"></td></tr>";
echo "<tr><td bgcolor=\"#D2E9F2\">Grant Amount</td><td bgcolor=\"#D2E9F2\">:</td><td bgcolor=\"#D2E9F2\"><input type='text' name='agr_amt' id='agr_amt' size='7' $HIGHLIGHT><font color=\"red\">*</font></td>";
echo "<td bgcolor=\"#D2E9F2\"  width='12%'>Receive Date</td><td bgcolor=\"#D2E9F2\">:</td><td bgcolor=\"#D2E9F2\"><input type='text' name='rec_date' id='rec_date' size='10' $HIGHLIGHT><font color=\"red\">*</font>";
echo"&nbsp<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.rec_date,'dd/mm/yyyy','Choose Date')\"></td></tr>";
echo"<tr><td bgcolor=\"#D2E9F2\" align='right' colspan='3'>Remarks:</td><td bgcolor=\"#D2E9F2\" colspan='3'><input type='text' name='rem'></td></tr>";
echo "<tr><td bgcolor=\"#D2E9F2\" colspan='6' align='center'><input type=\"submit\" value=\"Submit\"></td></tr>";
echo "<tr><td colspan=\"6\" align=center><iframe src=\"mas_db.php\" width=\"100%\" height=\"200\" ></iframe>";
echo "</table>";
echo "</body>";
echo "</html>";
?>
