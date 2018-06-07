<?
include "../config/config.php";
$q=$_REQUEST['q'];
$op=$_REQUEST['op'];
if($op=='i'){
$otd=$_REQUEST['otd'];
$emp_id=$_REQUEST['id'];
$pay=$_REQUEST['pay'];
$t_ot_p=$_REQUEST['t_ot_p'];
$staff_id=verifyAutho();
$yy=$_REQUEST['yy'];
$mnth=$_REQUEST['mm'];
$ym=$yy.$mnth;
$entry_time=date('d/m/Y h:i:s');
$sql="select case when max(id) is null then 1 else max(id)+1 end as id from emp_overtime_dtl";
$res=dBConnect($sql);
$id=pg_fetch_result($res,'id');
$sql_statement="insert into emp_overtime_dtl (id,emp_id,year_month,ot_days,ot_per_day,ot_payment,operator_code,entry_time) values ($id,$emp_id,'$ym',$otd,$pay,$t_ot_p,'$staff_id','$entry_time')";
$result=dBConnect($sql_statement);
//echo $sql_statement;


}
?>
<script LANGUAGE="JavaScript">
function ot_pay(){
var pay=document.getElementById('pay').value;
var otd=document.getElementById('otd').value;
var payment=pay*otd;
document.getElementById('t_ot_p').value=payment;
}
</script>
<?

$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$type=trim($_REQUEST['type']);
echo "<HTML>";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "<script src=\"../JS/loading2.js\"></script>";
?>
<script LANGUAGE="JavaScript">
function f2(str){
//alert("str"+str);
showHint_subemp_pf(str);

}
</script>
<?
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<BODY bgcolor=\"#D8D8D8\" onload=\"op_dt.focus();\">";
//echo"<hr>";
echo "<table width=\"70%\" bgcolor=\"#F2F2F2\" align=\"CENTER\">";
echo"<center>";
echo"<font color=\"darkblue\"><H3>Employee Overtime Details </H3></font></center>";
echo "<tr><th colspan=\"4\" bgcolor='#0489B1'><b><font color=White>Employee Overtime Payment</font></b></th>";
echo "<form name=\"f1\" method=\"POST\" action=\"ot.php?op=i\">";
echo"<tr><td align='center'>Employee Id : ";
makeselectemp('id',"onChange=\"f2(this.value);\"");
echo"</td><td colspan='2' align='center'> Name :";
?>
<span id="txtHint"></span>
<?
echo"</tr><tr><td align='center'>Select Year&nbsp;:&nbsp;<select name='yy'><option value='2013'>2013</option><option value='2014'>2014</option><option value='2015'>2015</option>
<option value='2016'>2016</option><option value='2017'>2017</option><option value='2018'>2018</option><option value='2019'>2019</option><option value='2020'>2020</option><option value='2021'>2021</option><option value='2022'>2022</option><option value='2023'>2023</option><option value='2024'>2024</option><option value='2025'>2025</option>
</select></td>";
echo"<td colspan='2' align='center'>Select Month :</select>
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
//echo "<tr><td align='right'>Total Present Days </td><td width='4%' align='center'> : </td><td align='left'><input type=\"TEXT\" id=\"tpd\" name=\"tpd\" size=5 value=\"\" onfocus=\"ot_pay()\"onChange=\"ot_pay()\" onKeyup=\"ot_pay()\" $HIGHLIGHT>";

echo "<tr><td align='right'>Over Time Days </td><td width='4%' align='center'> : </td><td align='left'><input type=\"TEXT\" id=\"otd\" name=\"otd\" size=5 value=\"\" onfocus=\"ot_pay()\"onChange=\"ot_pay()\" onKeyup=\"ot_pay()\" $HIGHLIGHT>";

echo "<tr><td align='right'>Payment </td><td width='4%' align='center'> : </td><td align='left'><input type=\"TEXT\" id=\"pay\" name=\"pay\" size=5 value=\"\" onfocus=\"ot_pay()\"onChange=\"ot_pay()\" onKeyup=\"ot_pay()\" $HIGHLIGHT>";

echo "<tr><td align='right'>Total Overtime Payment </td><td width='4%' align='center'> : </td><td align='left'><input type=\"TEXT\" id=\"t_ot_p\" name=\"t_ot_p\" size=5 value=\"\" onfocus=\"ot_pay()\"onChange=\"ot_pay()\" onKeyup=\"ot_pay()\" READONLY $HIGHLIGHT>";
echo"<tr><td colspan='3'></td></tr><tr><td  colspan='3'></td></tr>";
echo "<tr><td><td colspan='3' align='center'><input type=submit value=Submit>&nbsp;";
echo "<input type=\"RESET\" name=\"RESET_BUTTON\" value=\"Reset\"><br>";
echo "</form>";
echo "</table><br>";
echo"<table width='99%' align='center'><tr BGCOLOR='#839EB8'><th width='10%'><font color='#043C70'>Employee Id</th><th width='12%'><font color='#043C70'>Name</th><th width='13%'><font color='#043C70'>Year,Month</th><th width='13%'><font color='#043C70'>Overtime Days</th><th width='15%'><font color='#043C70'>Payment/day</th><th width='15%'><font color='#043C70'>Overtime Pyament</th></tr></table>";
echo"<tr><td colspan='6'><iframe src=\"ot_db.php\" width=\"100%\" height=\"300\" ></iframe></td></tr></table>";
echo "</body>";
echo "</HTML>";
?>
