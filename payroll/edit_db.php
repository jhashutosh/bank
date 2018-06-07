<?
include "../config/config.php";
$status=$_REQUEST['status'];
$menu=$_REQUEST['menu'];
$ei=$_REQUEST['ei'];
$name=$_REQUEST['name'];
$id=$_REQUEST['id'];
//int
$pentry_time=date('d/m/Y H:i:s ');
$sysdate=date("d",time())."/".date("m",time())."/".date("Y",time());
//$staff_id=verifyAutho();
//--
$pname=$_REQUEST['pname'];
$paddress1=$_REQUEST['add1'];
$paddress2=$_REQUEST['add2'];
$pfather_name=$_REQUEST['fname'];
$phusband_name=$_REQUEST['hname'];
$psex=$_REQUEST['sex'];
$page=$_REQUEST['age'];//int
$pphone1=$_REQUEST['ph1'];
$pphone2=$_REQUEST['ph2'];
$pdob=$_REQUEST['dob'];
$pblood_group='b+';
$pcaste=$_REQUEST['Caste'];
$preligion=$_REQUEST['rel'];
$pdoj=$_REQUEST['doj'];
$pvotid=$_REQUEST['vid'];
$ppanno=$_REQUEST['panno'];
$pqualification=$_REQUEST['qual'];
$ppf_ac_no=$_REQUEST['pfno'];
$pbank_ac_no=$_REQUEST['b_acc_no'];
$pbank_details=$_REQUEST['b_dtl'];
$pid_emp_designation_mas=$_REQUEST['des'];//int
$pid_emp_dept_mas=$_REQUEST['dep'];
$pmgr_emp_id=$_REQUEST['ib'];
$ploan_ac_no=$_REQUEST['lan'];
$pother_details=$_REQUEST['oth_dtl'];
$premarks=$_REQUEST['rem'];
$cid=$_REQUEST['cid'];
$mid=$_REQUEST['mid'];
$poperator_code=verifyAutho();
$pentry_time=date('d/m/Y H:i:s ');

$sql= "select emp_master_save_fnc($id,'$pname','$paddress1','$paddress2','$pfather_name','$phusband_name','$psex','$pphone1','$pphone2','$pdob','$pblood_group','$pcaste','$preligion','$pdoj',
'$pvotid','$ppanno','$pqualification','$ppf_ac_no','$pbank_ac_no','$ploan_ac_no','$pbank_details',$pid_emp_designation_mas,$pid_emp_dept_mas,$pmgr_emp_id,'$pother_details','$premarks','$cid','$mid','$poperator_code','$pentry_time')";
$result=dBConnect($sql);
//echo $sql;
//echo $ploan_ac_no;
echo "<head>";
echo "<title>EMPLOYEE DETAILS";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";

echo "<body bgcolor=\"#97B3C6\">";
echo"<form action='emp_new.php' method='post'>";
echo"<table valign=\"top\" width='100%' bgcolor='#97B3C6'>"; 
echo"<tr><th colspan='9' bgcolor='black' align='center'><font color='white'>*EMPLOYEE INFORMATION*</font></td></tr>";
echo"<td align='center' width='10%'bgcolor='#D1D1D1' rowspan='2'><font color='black'>Customer Id</font></td>";
echo"<td align='center' width='10%'bgcolor='#D1D1D1' rowspan='2'><font color='black'>Employee Id</font></td>";
echo"<td align='center' width='13%'bgcolor='#D1D1D1' rowspan='2'><font color='black'>Name</font></td>";
echo"<td align='center' width='12%'bgcolor='#D1D1D1' rowspan='2'><font color='black'>Designation</font></td>";
echo"<td align='center' width='9%'bgcolor='#D1D1D1' rowspan='2'><font color='black'>Gratuitys</font></td>";
echo"<td align='center' width='16%'bgcolor='#D1D1D1' colspan='2'><font color='black'>PF</font></td>";
echo"<td align='center' width='12%'bgcolor='#D1D1D1' rowspan='2'><font color='black'>Basic Pay</font></td>";
//echo"<td align='center' width='12%'bgcolor='#D1D1D1' rowspan='2'><font color='black'>Savings Acc No.</font></td>";
echo"<td align='center' width='8%'bgcolor='#D1D1D1' rowspan='2'><font color='black'>Pay Slip</font></td>";
echo"<td align='center' width='9%'bgcolor='#D1D1D1' rowspan='2'><font color='black'>operation</font></td>";
echo"<tr><td bgcolor='#D1D1D1' align='center'><font color='black'>Acc no.</td><td bgcolor='#D1D1D1' align='center'><font color='black'>Deposit</td></tr>";
echo "<tr><td colspan=\"9\" align=center><iframe src=\"emp_db.php?\" width=\"100%\" height=\"200\" ></iframe>";
echo"<br><br><input type='submit' value='Add New Employee'><input type='button' name='sal_process' value='Salary Processing' onclick=\"window.open('sal_reg.php','_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=150,left=350, width=350,height=200'); return false;\"><input type='button' name='sal_posting' value='Salary Posting' onclick=\"window.open('sal_post.php','_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=150,left=350, width=350,height=200'); return false;\">";
echo"</form>";
echo"<table width='100%' style='margin-top:20%;'><tr><td colspan='12'>Salary Payment Done For : </td></tr><tr>";
$sql_p="select  distinct year_month, ltrim(substr(year_month,5),'0') mon ,substr(year_month,1,4) yr from emp_sal_reg where status='Y' order by year_month";
$res_p=dBConnect($sql_p);
for($j=0;$j<pg_NumRows($res_p);$j++){
$row_p=pg_fetch_array($res_p,$j);
echo"<td>".$month_array[$row_p['mon']].",".$row_p['yr']."</td>";}
echo"</tr></table>";
echo"</body>";
?>
