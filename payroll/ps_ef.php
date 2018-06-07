<?
include "../config/config.php";
$status=$_REQUEST['status'];
$menu=$_REQUEST['menu'];
$time=date('d/m/Y H:i:s ');
$staff_id=verifyAutho();
$id=$_REQUEST['id'];
$name=$_REQUEST['name'];
$doj=$_REQUEST['doj'];
$mm=$_REQUEST['mm'];
$m=ltrim($mm,'0');
$yy=$_REQUEST['yy'];
$ym=$yy.$mm;
$b="<font size=+1  color='darkblue'>You have selected ".$month_array[$m].",$yy</font>";
$a="Please enter Year and Month";
$display=(empty($mm)||empty($mm))?$a:$b;
echo "<head>";
echo "<title>Basic Pay entry";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
?>
<script language="JAVASCRIPT">
function closeme() { 
	close(); 
}

</script>
<?
echo "</head>";
echo"<body bgcolor='#B1B1B1'>";
echo"<form name='f1' action='ps_ef.php?menu=ast&id=$id&name=$name' method='post'>";
echo"<table align='center' width='100%'>";
echo"<tr><th colspan='3' bgcolor='grey' align='center'><font color='#CDCDCD'>Get Pay Slip for selected Year & Month</font> </th></tr>";
echo"<tr><th colspan='2' bgcolor='336699' align='center'><font color='white'> ".ucwords($name)."</font> </th><th align='center' bgcolor='336699' ><font color='white'>Employee ID </font>:<font color='white' size+1> $id</font></th></tr><tr><td colspan='3'></td></tr>";
echo"<tr><td>Select Year</td><td>:</td><td><select name='yy'>
<option value='2013'>2013</option><option value='2014'>2014</option><option value='2015'>2015</option>
<option value='2016'>2016</option><option value='2017'>2017</option><option value='2018'>2018</option><option value='2019'>2019</option><option value='2020'>2020</option><option value='2021'>2021</option>
<option value='2022'>2022</option><option value='2023'>2023</option><option value='2024'>2024</option><option value='2025'>2025</option>
</select></td></tr>";
echo"<tr><td>Select Month</td><td>:</td><td></select>
<select name='mm'>
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
echo"<tr><td align='right' colspan='3'><input type='submit' value='confirm'></td></tr>";
echo"<tr><td colspan='3' align='center'>$display</td></tr>";
if(!empty($yy) and !empty($mm))
echo"<tr><td align='center' colspan='3'>To get Pay slip click on the image below</td></tr><tr><td align='center' colspan='3'><a href=\"payslip.php?menu=ast&id=$id&name=$name&mm=$mm&yy=$yy&ym=$ym\"  onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=200, width=900,height=700'); return false,closeme()\"><img src='10.png'> </a></td></tr>";
echo"</form>";
//echo $ym;
echo"</body>";
?>
