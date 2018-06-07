<?
include "../config/config.php";
$status=$_REQUEST['status'];
$menu=$_REQUEST['menu'];
$id=$_REQUEST['id'];
$psql="select * from emp_dept_mas";
$pres=dBConnect($psql);
$sql="select * from emp_designation_mas";
$vsql="select * from emp_mas_designation_mas_supervisor_list_vw";
$vres=dBConnect($vsql);
$result=dBConnect($sql);
$sql_statement="select * from emp_master where emp_id=$id";
$result1=dBConnect($sql_statement);
$row1=pg_fetch_array($result1,0);
$a="";
$pname=$row1['name'];
$paddress1=$row1['address1'];
$paddress2=(empty($row1['address2']))?$a:$row1['address2'];
$pfather_name=(empty($row1['father_name']))?$a:$row1['father_name'];
$phusband_name=(empty($row1['husband_name']))?$a:$row1['husband_name'];
$psex=$row1['sex'];
$page=$row1['age'];//int
$pphone1=(empty($row1['phone1']))?$a:$row1['phone1'];
$pphone2=(empty($row1['phone2']))?$a:$row1['phone2'];
$pdob=$row1['dob'];
$pblood_group='b+';
$pcaste=$row1['caste'];
$preligion=$row1['religion'];
$pdoj=$row1['doj'];
$pdor=$row1['dor'];
$pvotid=(empty($row1['votid']))?$a:$row1['votid'];
$ppanno=(empty($row1['panno']))?$a:$row1['panno'];
$pqualification=(empty($row1['qualification']))?$a:$row1['qualification'];
$ppf_ac_no=(empty($row1['pf_ac_no']))?$a:$row1['pf_ac_no'];
$pbank_ac_no=(empty($row1['bank_ac_no']))?$a:$row1['bank_ac_no'];
$pbank_details=(empty($row1['bank_details']))?$a:$row1['bank_details'];
$pid_emp_designation_mas=$row1['id_emp_designation_mas'];
$pid_emp_dept_mas=$row1['id_emp_dept_mas'];//int
$ploan_ac_no=(empty($row1['staff_loan_ac_no']))?"":$row1['staff_loan_ac_no'];
$pother_details=(empty($row1['other_details']))?$a:$row1['other_details'];
$premarks=(empty($row1['remarks']))?$a:$row1['remarks'];
$cid=(empty($row1['customer_id']))?$a:$row1['customer_id'];
$mid=(empty($row1['membership_no']))?$a:$row1['membership_no'];
$sql1="select * from emp_designation_mas where id=$pid_emp_designation_mas";
$result2=dBConnect($sql1);
$row2=pg_fetch_array($result2,0);
$sql2="select * from emp_dept_mas where id=$pid_emp_dept_mas";
$result3=dBConnect($sql2);
$row3=pg_fetch_array($result3,0);
echo "<head>";
echo "<title>EMPLOYEE DETAILS";
echo "</title>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
//echo $pname;
echo "<body bgcolor=\"lightyellow\">";
echo"<form  name='f1' action='edit_db.php?id=$id' method='post'>";
echo"<table valign=\"top\"width='100%'>";//sas1
echo"<tr><th colspan='9' bgcolor='663399'><font color='white'>Edit Employee Information</font></th></tr><tr><td colspan='9'></td></tr><tr><td colspan='9'></td></tr><tr><td colspan='9'></td></tr>";
echo"<tr><th colspan='9' bgcolor='663300'><font color='white'> * Demographical Details *</font></th></tr><tr><td colspan='9'></td></tr><tr><td colspan='9'></td></tr><tr><td colspan='9'></td></tr>";
echo"<tr><td bgcolor='0033CC' align='center' colspan='3'><font color='yellow'><b>Your Employee ID is   $id </font></td></tr><tr><td colspan='9'></td></tr>";
echo"<tr><td align='left'> Employee Name  </td><td>:</td><td> <input type='text' name='pname' size='25' value='".$row1['name']."'  $HIGHLIGHT><font color='red'> *</font></td>";
echo"<td > Address  </td><td>:</td><td>  <input type='text' name='add1' size='25' value=$paddress1 $HIGHLIGHT><font color='red'>*</font>";//sas

//echo"<td align='left'>caste   </td><td>:</td><td>  <input type='text' name='name' size='5' $HIGHLIGHT></tr><tr><td colspan='9'></td></tr>";
echo "<td align=\"left\">Caste</td><td>:</td><td>";
makeSelect($caste_array,'Caste','');
echo"</td></tr>";


//sas
echo"<tr><td align='left'>Father's Name   </td><td>:</td><td>   <input type='text' name='fname' size='25' value='".$row1['father_name']."' $HIGHLIGHT>";
echo"<td > Address  </td><td>:</td><td>  <input type='text' name='add2' size='25' value='$paddress2' $HIGHLIGHT>";
//sas
echo "<td align=\"left\">Religion</td><td>:</td><td>";
makeSelect($rel_array,'rel','');
echo"</td></tr>";
//sas
echo"<tr><td >Sex  </td><td width='1%'>:</td><td><input type='radio' name='sex' value='m' onclick=\"hname.disabled=true\">Male<input type='radio' name='sex' value='f' onclick=\"hname.disabled=false\" >Female</td><td align='left'>Husband's Name </td><td width='1%'>:</td><td> <input type='text' name='hname' size='25' $HIGHLIGHT>";
echo"<td align='left'> Mobile No.  </td><td>:</td><td> <input type='text' name='ph1' size='10' value='$pphone1' $HIGHLIGHT></td></tr>";
echo"<tr><td> Date of Birth </td><td>:</td><td> <input type=\"TEXT\" name=\"dob\" size=\"12\" value=$pdob $HIGHLIGHT><font color='red'> *</font>";
echo "&nbsp<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.dob,'dd/mm/yyyy','Choose Date')\"></td>";
echo"<td > Date of Joining </td><td>:</td><td> <input type=\"TEXT\" name=\"doj\" size=\"12\" value=$pdoj $HIGHLIGHT><font color='red'> *</font>";
echo "&nbsp<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.doj,'dd/mm/yyyy','Choose Date')\"></td>";
echo"<td> (Res.) Phone No.  </td><td>:</td><td> <input type='text' name='ph2' size='10' value='$pphone2' $HIGHLIGHT></td></tr><tr><td colspan='9'></td></tr><tr><td colspan='9'></td></tr><tr><td colspan='9'></td></tr><tr><td colspan='9'></td></tr>";//sas2
echo"<tr><th colspan='9' bgcolor='663300'><font color='white'> * Organization Details *</font></th></tr>";
echo"<tr><td>Select Designation</td><td>:</td><td>  ";
echo"<select name='des'> <option value=$pid_emp_designation_mas>".$row2['desg_desc']."</option>";
for($j=0; $j<pg_NumRows($result); $j++) {
$row=pg_fetch_array($result,$j);
echo"<option value='".$row['id']."'>".$row['desg_desc']."</option>";
                                        }
echo"</select>";
echo"</td>";
echo"<td>Select Department</td><td>:</td><td>  ";
echo"<select name='dep'> <option value=$pid_emp_dept_mas>".$row3['dept_desc']."</option>";
for($j=0; $j<pg_NumRows($pres); $j++) {
$row4=pg_fetch_array($result,$j);
echo"<option value='".$row4['id']."'>".$row4['desg_desc']."</option>";
                                        }
echo"</select>";
echo"</td>";
echo"<td  >Select Immediate Boss</td><td width='2%'>:</td><td>  ";
echo"<select name='ib'><option value='0'>none</option>";
for($j=0; $j<pg_NumRows($vres); $j++) {
$row5=pg_fetch_array($vres,$j);
echo"<option value='".$row5['emp_id']."'>".$row5['name']."</option>";
                                        }
echo"</select></td></tr>";


echo"<tr><td>Other Details</td><td width='1%'>:</td><td> <input type='text' name='oth_dtl' size='20' $HIGHLIGHT>";
echo"<td align='left'>Remarks</td><td width='1%'>:</td><td width='10%'> <input type='text' name='rem' size='20' $HIGHLIGHT>";
echo"</td>";
echo"<td>Customer Id:<input type='text' name='cid' size='5' value='$cid' $HIGHLIGHT></td><td colspan='2'>Membership Id:<input type='text' name='mid' value='$mid' size='5' $HIGHLIGHT></td></tr>";
echo"</td></tr><tr><td colspan='9'></td></tr>";

//sas3
echo"<tr><th colspan='9' bgcolor='663300'><font color='white'> * Other Details *</font></th></tr>";
echo"<tr><td>Voter Id  </td><td>:</td><td>  <input type='text' name='vid' size='15' value='$pvotid' $HIGHLIGHT>";
echo"<td  align='left'> Pan No.  </td><td>:</td><td>  <input type='text' name='panno' size='15' value='$ppanno' $HIGHLIGHT>";
echo"<td align='right'>Qualification</td><td>:</td><td> <input type='text' name='qual' size='8' value='$pqualification' $HIGHLIGHT></tr><tr><td colspan='9'></td></tr>";
echo"<tr>";
echo"<td align='left'>Bank Account Number </td><td>:</td><td> <input type='text' name='b_acc_no' size='15' value='$pbank_ac_no' $HIGHLIGHT>";
echo"<td align='right'  >Staff Loan Account No.</td><td>:</td><td> <input type='text' name='lan' size='10' value='$ploan_ac_no' $HIGHLIGHT><td align='right'>Bank Details</td><td>:</td><td><input type='text' name='b_dtl' size='15' value='$pbank_details' $HIGHLIGHT></td></tr><tr><td colspan='9'></td></tr><tr><td colspan='9'></td></tr><tr><td colspan='9'></td></tr><tr>";
echo"<tr><td colspan='9' align='center'> <input type='submit' value='Done'></td></tr>
</table>";

?>
<script language="JavaScript" type="text/javascript">
 var frmvalidator  = new Validator("f1");
 //this.formtype=document.forms[type];
frmvalidator.addValidation("pname","req","Please enter your Name");
frmvalidator.addValidation("add1","req","Please enter your Address");
frmvalidator.addValidation("dob","req","Please enter your Date of Birth");
frmvalidator.addValidation("doj","req","Please enter your Date of Joining");
</script>

