<?
include "../config/config.php";
$status=$_REQUEST['status'];
$menu=$_REQUEST['menu'];
$cid=$_REQUEST['c_id'];
$csql="select * from customer_all where customer_id='$cid'";
$cres=dBConnect($csql);
$crow=pg_fetch_array($cres,0);
$sql="select * from emp_designation_mas";
$result=dBConnect($sql);
$psql="select * from emp_dept_mas";
$presult=dBConnect($psql);
$vsql="select * from emp_mas_designation_mas_supervisor_list_vw";
$vres=dBConnect($vsql);
echo "<head>";
echo "<title>EMPLOYEE DETAILS";
echo "</title>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
?>
<script LANGUAGE="JavaScript">

function dob_val(f){

var dob=document.getElementById('dob').value;
var dobl=document.getElementById('dob').value.length;
var dojl=document.getElementById('doj').value.length;
var lname=document.getElementById('pname').value.length;
var ladd=document.getElementById('add1').value.length;
var dobs=dob.split('.');
dobf=dobs[1]+'/'+dobs[0]+'/'+dobs[2];
DateofBirth=new Date(dobf);
//document.getElementById('qual').value=DateofBirth;
var doj=document.getElementById('doj').value;
var dojs=doj.split('.');
dojf=dojs[1]+'/'+dojs[0]+'/'+dojs[2];
DateofJoin=new Date(dojf);
var Diff=DateofJoin.getTime()-DateofBirth.getTime();
diffyr=Diff/(86400000*365);
var today=new Date();
var mm=today.getMonth()+1;
var dd=today.getDate();
var yyyy=today.getFullYear();
var todate=mm+'/'+dd+'/'+yyyy;
var Date_today=new Date(todate);
var diffjoin=Date_today.getTime()-DateofJoin.getTime();

//document.getElementById('qual').value=Date_today;
if(lname==0)
{
alert("You Must enter your name");
return false;
}
if(ladd==0)
{
alert("You Must enter your present address");
return false;
}
if(dobl==0)
{
alert("You Must enter your Date of Birth");
return false;
}
if(dojl==0)
{
alert("You Must enter your Date of Joining");
return false;
}
if(diffjoin<0)
{
alert("You are still not an Employee");
return false;
}
if(diffyr<18)
{
alert("Your Age is "+Math.round(diffyr)+"\n you can't join bank below 18 years");
return false;
}
}
</script>

<?
echo "<body bgcolor=\"CCCCFF\">";
echo"<form  name='f1' action='main.php' method='post' onSubmit=\"return dob_val(this.form);\" >";
echo"<table valign=\"top\"width='100%'>";//sas1
echo"<tr><th colspan='9' bgcolor='006666'><font color='white' size='2'>New Employee Creation</font></th></tr><tr><td  colspan='9'></td></tr><tr><td  colspan='9'></td></tr><tr><td  colspan='9'></td></tr>";
echo"<tr><th colspan='9' bgcolor='6666FF'><font color='darkblue'> * Demographical Details *</font></th></tr><tr><td  colspan='9'></td></tr><tr><td  colspan='9'></td></tr><tr><td  colspan='9'></td></tr>";
echo"<tr><td align='left'> Employee Name  </td><td width='1%'>:</td><td><input type='text' name='pname' id='pname' value='".ucwords($crow['name1'])."' size='25'$HIGHLIGHT><font color='red'>*</font>";
echo"<td align='left'>Father's Name   </td><td width='1%'>:</td><td>   <input type='text' name='fname' value='".ucwords($crow['father_name1'])."' size='25' $HIGHLIGHT>";
//echo"<td  align='left'>Present Address</td><td width='1%'>:</td><td><input type='text' name='add1' size='25' $HIGHLIGHT>


//echo"<td align='left'>caste   </td><td width='1%'>:</td><td>  <input type='text' name='name' size='5' $HIGHLIGHT></tr><tr><td  colspan='9'></td></tr>";
echo "<td align=\"left\">Caste</td><td width='1%'>:</td><td>";
makeSelect($caste_array,'Caste','');
echo"</td></tr>";


//sas
echo"<tr><td  align='left'>Present Address</td><td width='1%'>:</td><td><input type='text' name='add1' value='".ucwords($crow['address11'])."' id='add1' size='25' $HIGHLIGHT><font color='red'>*</font>";
echo"<td>Parmanent Address</td><td width='1%'>:</td><td>  <input type='text' name='add2' value='".ucwords($crow['address12'])."' size='25' $HIGHLIGHT>";
//sas
echo "<td align=\"left\">Religion</td><td width='1%'>:</td><td>";
makeSelect($rel_array,'rel','');
echo"</td></tr>";
//sas
echo"<tr><td >Sex  </td><td width='1%'>:</td><td><input type='radio' name='sex' value='m' onclick=\"hname.disabled=true\">Male<input type='radio' name='sex' value='f' onclick=\"hname.disabled=false\" >Female</td><td align='left'>Husband's Name </td><td width='1%'>:</td><td> <input type='text' name='hname' size='25' $HIGHLIGHT>";
//echo"<td >Sex   </td><td width='1%'>:</td><td><input type='radio' name='sex' value='m' onclick=\"hname.disabled=true\">Male<input type='radio' name='sex' value='f' onclick=\"hname.disabled=false\" >Female</td>";
echo"<td align='left'> Mobile No.</td><td width='1%'>:</td><td> <input type='text' name='ph1' size='10' $HIGHLIGHT></td></tr>";
echo"<tr><td> Date of Birth </td><td width='1%'>:</td><td> <input type=\"TEXT\" name=\"dob\" id=\"dob\" size=\"12\" value='".$crow['dob1']."' onclick=\"showCalendar(f1.dob,'dd.mm.yyyy','Choose Date')\" $HIGHLIGHT><font color='red'> *</font>";
echo "</td>";
echo"<td  > Date of Joining </td><td width='1%'>:</td><td> <input type=\"TEXT\" name=\"doj\" id=\"doj\" size=\"12\" onclick=\"showCalendar(f1.doj,'dd.mm.yyyy','Choose Date')\" $HIGHLIGHT><font color='red'> *</font>";
echo "</td>";
echo"<td align='left'> (Res.) Phone No.</td><td width='1%'>:</td><td> <input type='text' name='ph2' size='10' $HIGHLIGHT></td></tr><tr><td  colspan='9'></td></tr><tr><td  colspan='9'></td></tr><tr><td  colspan='9'></td></tr><tr><td  colspan='9'></td></tr>";//sas2
echo"<tr><th colspan='9' bgcolor='6666FF'><font color='darkblue'> * Organization Details *</font></th></tr>";
echo"<tr><td  >Select Designation</td><td width='1%'>:</td><td>  ";
echo"<select name='des'>";
for($j=0; $j<pg_NumRows($result); $j++) {
$row=pg_fetch_array($result,$j);
echo"<option value='".$row['id']."'>".$row['desg_desc']."</option>";
                                        }
echo"</select>";
echo"</td>";
//1
echo"<td  >Select Department</td><td width='1%'>:</td><td>  ";
echo"<select name='dep'>";
for($j=0; $j<pg_NumRows($presult); $j++) {
$row1=pg_fetch_array($presult,$j);
echo"<option value='".$row1['id']."'>".$row1['dept_desc']."</option>";
                                        }
echo"</select></td>";
//

echo"<td  >Select Immediate Boss</td><td width='1%'>:</td><td>  ";
echo"<select name='ib'><option value='0'>select</option>";
for($j=0; $j<pg_NumRows($vres); $j++) {
$row4=pg_fetch_array($vres,$j);
echo"<option value='".$row4['emp_id']."'>".$row4['name']."</option>";
                                        }
echo"</select>";
//
echo"</td></tr><tr><td  colspan='9'></td></tr><tr><td  colspan='9'></td></tr>";
//2
echo"<tr><td>Other Details</td><td width='1%'>:</td><td> <input type='text' name='oth_dtl' size='20' $HIGHLIGHT>";
echo"<td align='left'>Remarks</td><td width='1%'>:</td><td width='10%'> <input type='text' name='rem' size='20' $HIGHLIGHT>";
echo"</td>";
echo"<td>Customer Id:<input type='text' name='cid' value='".$crow['customer_id']."' size='5' $HIGHLIGHT></td><td colspan='2'>Membership Id:<input type='text' name='mid' size='5' $HIGHLIGHT></td></tr>";
echo"<td  colspan='9'></td></tr><tr><td  colspan='9'></td></tr>";

//sas3
echo"<tr><th colspan='9' bgcolor='6666FF'><font color='darkblue'> * Other Details *</font></th></tr>";
echo"<tr><td>Voter Id  </td><td width='1%'>:</td><td>  <input type='text' name='vid' size='15' $HIGHLIGHT>";
echo"<td   align='left'> Pan No.  </td><td width='1%'>:</td><td>  <input type='text' name='panno' size='15' $HIGHLIGHT>";
echo"<td align='left'>Qualification</td><td width='1%'>:</td><td> <input type='text' name='qual' id=\"qual\" value='".$crow['qualification1']."' size='8' value=\"\" $HIGHLIGHT></tr><tr><td  colspan='9'></td></tr>";
echo"<tr>";
echo"<td align='left'>Staff Loan Account No.</td><td width='1%'>:</td><td> <input type='text' name='lan' size='15' $HIGHLIGHT READONLY>";
echo"<td align='left'>Bank Account No.</td><td width='1%'>:</td><td> <input type='text' name='b_acc_no' size='10' $HIGHLIGHT>
<td align='right'>Bank Details</td><td>:</td><td><input type='text' name='b_dtl' size='15' $HIGHLIGHT></td></tr>
<tr><td colspan='9'></td></tr>";
echo"<tr><td colspan='7' align='center'> <input type='submit' value='Add Employee'></td><td  align='left' colspan='2'><a href='main.php'><font size='3'><blink> <<--Back </font></blink></td></tr></table>";

?>

