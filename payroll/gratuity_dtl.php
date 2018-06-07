<script language="JAVASCRIPT">
function closeme() { 
	close(); 
}
function myRefresh(URL){
	window.opener.location.href =URL;
    	self.close();
    	}

</script>
<?
include "../config/config.php";
$status=$_REQUEST['status'];
$id=$_REQUEST['id'];
$name=$_REQUEST['name'];
$acno=$_REQUEST['acno'];
$opr=$_REQUEST['opr'];
if($opr=='i'){
$poperator_code=verifyAutho();
$pentry_time=date('d/m/Y H:i:s ');
$date=$_REQUEST['date'];
$amount=$_REQUEST['amount'];
$sql="insert into emp_gratuity_dtl (emp_id,action_date ,amount,operator_code ,entry_time) 
			values ($id,'$date',$amount,'$poperator_code','$pentry_time')";
$res=dBConnect($sql);
//echo $sql;
if(pg_affected_rows($res)>0)
echo "<div align='center'><b>Gratuity Information Entered Successfully!!!</b><br>";
echo"<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme(),myRefresh('../payroll/emp_db.php')\"></div>";


}
$s="select * from customer_account a,emp_master b where b.emp_id=$id and a.customer_id=b.customer_id and a.account_no like 'PFSB%'";
$r=dBConnect($s);
$pfr=pg_fetch_array($r,0);
$sql="select * from emp_master where emp_id=$id";
$sql1="select * from emp_pf_dtl where emp_id=$id";
$result=dBConnect($sql);
$result1=dBConnect($sql1);
$row=pg_fetch_array($result,0);
echo"<input type='hidden' name=\"dob\" id=\"dob\" value=\"".$row['dob']."\">";
$row1=pg_fetch_array($result1,0);
echo "<head>";
echo "<title>PF DETAILS";
echo "</title>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<script src=\"../JS/loading2.js\"></script>";
//echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
?>
<script LANGUAGE="JavaScript">
function f2(str)
  {
//alert("str"+str);
showHint_subemp_pf(str);
  }
function doj_val(f)
    {
var dob=document.getElementById('dob').value;
var dobs=dob.split('.');
dobf=dobs[1]+'/'+dobs[0]+'/'+dobs[2];
DateofBirth=new Date(dobf);
datebf=DateofBirth.getTime();
//alert(dob);
var opd=document.getElementById('pf_acc_dt').value;
var opds=opd.split('/');
opdf=opds[1]+'/'+opds[0]+'/'+opds[2];
Dateofopen=new Date(opdf);
dateof=Dateofopen.getTime();
if(dateof<datebf)
 {
alert("Your Date of Birth is :"+dob+"\nPlease enter correct Account Opening Date");
return false;
 } 
  } 
</script>
<?if(empty($opr)){
echo "<body bgcolor=\"#90AACC\">";
echo"<form  name='f1' action='gratuity_dtl.php?opr=i' method='post' onsubmit='return doj_val(this.form);' >";
echo"<table valign=\"top\"width='100%' align='center'>";//sas1
echo"<tr><th colspan='3' bgcolor='#A9A9A9'><font color='white' size='2'>Staff Gratuity Entry </font></th></tr><tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr>";
echo"<tr><td align='left'> Employee Id</td><td width='1%'>:</td><td>";
echo"<input type='hidden' name='id' size='2' value=$id $HIGHLIGHT>$id</td></tr>";
echo"<tr><td align='left'>Name </td><td width='1%'>:</td><td>";
echo"<input type='hidden' name='name' size='15' value='".ucwords($row['name'])."'  $HIGHLIGHT>".ucwords($row['name'])."</td></tr>";

echo"<tr><td align='left'>Amount</td><td width='1%'>:</td><td> Rs. ";
echo"<input type='text' name='amount' size='8' $HIGHLIGHT></td></tr>";

echo"<tr><td align='left'>Date </td><td width='1%'>:</td><td>";
echo"<input type='text' name='date' size='10' value=".date('d/m/Y')." $HIGHLIGHT></td></tr>";

echo"<tr><td align='center' colspan='3'><input type='submit' value='Submit'></td></tr>";
echo"</table></form></body></html>";
}
?>
