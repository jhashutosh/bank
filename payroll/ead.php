<?
include "../config/config.php";
$wd=$_REQUEST['wd'];
$q=$_REQUEST['q'];
?>
<script LANGUAGE="JavaScript">
function work_days(){
var wd=parseInt(document.getElementById('working_days').value);
var pd=parseInt(document.getElementById('tpd').value);
//alert (pd+"<-pd  wd->"+wd)
var ad=0;
var otd=0;
if(wd>pd){
//alert (pd+"<-pd  wd->"+wd)
ad=wd-pd;
//alert ("1"+ad);
document.getElementById('tad').value=ad;
document.getElementById('otd').value=0;
}
if(pd>wd){
otd=pd-wd;
//alert ("2"+ad);
document.getElementById('otd').value=otd;
document.getElementById('tad').value=0;
}
if(pd==wd){
otd=pd-wd;
//alert ("3"+ad);
document.getElementById('otd').value=0;
document.getElementById('tad').value=0;
}


document.getElementById('pd').value=(pd);

document.getElementById('wd').value=wd;


}
</script>
<?
//echo $q;
//echo $wd;
if ($wd==1){
$q=$_REQUEST['q'];
//getWorkingDays("working_days",$q);
//$sql="select working_days from month_working_days where month=$mn";
$sql="select working_days('$yr','$q','y')";
//echo $sql;
$result=dBConnect($sql);
$row=pg_fetch_array($result);
echo $row['working_days']."<input type='hidden' name='working_days' id='working_days' value='".$row['working_days']."' size='3'>";
}
else{
$staff_id=verifyAutho();
$op=$_REQUEST['op'];
$customer_id=$_REQUEST['id'];
$menu=$_REQUEST['menu'];
$type=trim($_REQUEST['type']);
echo "<HTML>";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "<script src=\"../JS/loading2.js\"></script>";
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";
?><script LANGUAGE="JavaScript">
function f2(str){
//alert("str"+str);
showHint_subemp_pf(str);

}
function f3(str){

var yr=document.getElementById('yy').value;
//alert("str"+str);
alert(yr)
showHint_wd(str,yr);
}

</script>
<?
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<BODY bgcolor=\"silver\" onload=\"op_dt.focus();\">";
echo"<hr>";
echo"<h1>$working_days</h1>";
echo "<table width=\"70%\" bgcolor=\"#EFEFEF\" align=\"CENTER\" >";
echo"<center>";
echo"<font color=\"#262A2B\"><H1>Employee Attendance Details </H1></font></center>";
echo "<tr><th colspan=\"4\" bgcolor=#262A2B><b><font color=White>Employee Attendance Form</font></b></th>";
echo "<form name=\"f1\" method=\"POST\" action=\"ead_add.php?menu=$menu&op=$op\">";
echo"<tr><td>Employee Id : ";
makeselectemp('id',"onChange=\"f2(this.value);\"");
echo"</td><td colspan='2'> Name :";
?>
<span id="txtHint"></span>
<?
echo"</tr><tr><td>Select Year&nbsp;:&nbsp;<select name='yy' id='yy'>";
$dd_sql=" select substr(fy,1,4) yr from fy_list union select substr(fy,6) yr from fy_list order by yr";
$dd_res=dBConnect($dd_sql);
for($j=0; $j<pg_NumRows($dd_res); $j++){
$r=pg_fetch_array($dd_res,$j);
echo"<option value='".$r['yr']."'>".$r['yr']."</option>";}
echo"</select></td>";
echo"<td colspan='2'>Select Month :</select>
<select name='mm' onChange=\"f3(this.value);\">
<option value='0'>Select</option>
<option value='01'>JAN</option>
<option value='02'>FEB</option>
<option value='03'>MAR</option>
<option value='04'>APR</option>
<option value='05'>MAY</option>
<option value='06'>JUN</option>
<option value='07'>JUL</option>
<option value='08'>AUG</option>
<option value='09'>SEP</option>
<option value='10'>OCT</option>
<option value='11'>NOV</option>
<option value='12'>DEC</option>
</select></td></tr>";
echo"<tr><td colspan='3'></td></tr><tr><td  colspan='3'></td></tr>";
echo "<tr><td align='right'>Total month working days</td><td width='4%' align='center'> : </td><td align='left'>";
//<input type=\"TEXT\" name=\"twd\" size=5 value=\"\" $HIGHLIGHT>";
?>
<span id="textHint"></span>
<?
echo"<input type='hidden' name='wd' id='wd' value=''>";
echo "<tr><td align='right'>Total Present Days </td><td width='4%' align='center'> : </td><td align='left'><input type=\"TEXT\" id=\"tpd\" name=\"tpd\" size=5 value=\"\" onChange=\"work_days()\" onKeyup=\"work_days()\" $HIGHLIGHT>";

echo "<tr><td align='right'>Over Time Days </td><td width='4%' align='center'> : </td><td align='left'><input type=\"TEXT\" id=\"otd\" name=\"otd\" size=5 value=\"\"onChange=\"work_days()\" onKeyup=\"work_days()\" $HIGHLIGHT>";


echo "<tr><td align='right'>Over Time Payment </td><td width='4%' align='center'> : </td><td align='left'><input type=\"TEXT\" id=\"ot_pay\" name=\"ot_pay\" size=5 value=\"\" $HIGHLIGHT>";



echo "<tr><td align='right'>Present Days </td><td width='4%' align='center'> : </td><td align='left'><input type=\"TEXT\" id=\"pd\" name=\"pd\" size=5 value=\"\" onChange=\"work_days()\" onKeyup=\"work_days()\" $HIGHLIGHT>";
echo "<tr><td align='right'>Total Absent Days</td><td width='4%' align='center'> : </td><td align='left'><input type=\"TEXT\" id=\"tad\" name=\"tad\" size=5 value=\"\" onChange=\"work_days()\" onKeyup=\"work_days()\" READONLY $HIGHLIGHT>";
echo"<tr><td colspan='3'></td></tr><tr><td  colspan='3'></td></tr>";
echo "<tr><td><td colspan='3' align='center'><input type=submit value=Submit>&nbsp;";
echo "<input type=\"RESET\" name=\"RESET_BUTTON\" value=\"Reset\"><br>";
echo "</form>";
echo "</table>";
echo"<table width='99%' align='center'><tr BGCOLOR='#839EB8'><th width='10%'><font color='#043C70'>Employee Id</th><th width='12%'><font color='#043C70'>Name</th><th width='13%'><font color='#043C70'>Year,Month</th><th width='13%'><font color='#043C70'>Working Days</th><th width='15%'><font color='#043C70'>Present Day</th><th width='15%'><font color='#043C70'>Absent Day</th></tr></table>";
echo"<tr><td colspan='6'><iframe src=\"ead_db.php\" width=\"100%\" height=\"300\" ></iframe></td></tr></table>";
?>
 <script language="JavaScript" type="text/javascript">
 var frmvalidator  = new Validator("f1");
 frmvalidator.addValidation("op_dt","req","Please enter date");
   
  //frmvalidator.addValidation("telephone1","req","Contact number should not Blank");
  frmvalidator.addValidation("Desc","maxlen=30","Max Length is 30 only");
  frmvalidator.addValidation("Desc","req","Enter character Only For Rate Field");

</script>
<?
echo "</body>";
echo "</HTML>";}
?>
