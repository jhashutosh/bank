<?
include "../config/config.php";
$op=$_REQUEST['op'];
$optr_nm=$_REQUEST['optr_nm'];
echo "<head>";
echo "<title>Operator statement";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
?>
<SCRIPT>
function select(){
var frm_id=document.getElementById('optr_nm').value.length;
if(frm_id==0)
{
alert("You must select Operator's name")
return false;
}
}	
</SCRIPT>
<?
echo "<body bgcolor=\"lightblue\">";
echo"<form action='oprtr_wise_wtr_bil_dtl.php?op=v' method='post' onsubmit=\"return select();\">";
echo"<table valign=\"top\" align='center' width='70%' bgcolor='#AB6DA5'>"; 
echo"<tr><th colspan='3' bgcolor='#AB6DA5' align='center'><font color='white'>*Operator Wise Water Bill Payment Details*</font></td></tr>";
echo"<tr bgcolor='#AB6DA5'><td colspan='1' bgcolor='#AB6DA5' align='right'><font color='white'>Select Operator Name</font></td>";
echo "<td align='left' colspan='1'><select name=\"optr_nm\" id='optr_nm'onChange=\"select()\" onKeyup=\"select()\"><option value=''> Select</option>";
$sql="select distinct(initcap(operator_name)) as operator_name,id from lc_operator_master where id in (select id_mini_operator_link from LC_operator_salary_details)";
$res=dBConnect($sql);
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
//echo $sql;
echo"<option value=".$row['id'].">".$row['operator_name']."</option>";
}
echo"</select></td><td  colspan='1' align='left'><input type='submit' name='submit' id='submit' value='ok' onChange=\"select()\" onKeyup=\"select()\" ></td></tr></table>";
echo"</form></table></body>";
if(!empty($optr_nm)){
$opt_id=$_REQUEST['optr_nm'];
$sql="select distinct(initcap(operator_name)) as operator_name from lc_operator_master where id='$opt_id'";
$res=dBConnect($sql);
$row=pg_fetch_array($res,0);
$name=$row['operator_name'];
echo"<table width='90%' align='center'><tr><td  colspan='1' align='center'bgcolor='#AB6DA5'><font color='white'>Customer Name:</td><td  colspan='1' align='center'bgcolor='#AB6DA5'><font color='white'>$name</td><td  colspan='1' align='center'bgcolor='#AB6DA5'><font color='white'>Customer Id:<td  colspan='1' align='center'bgcolor='#AB6DA5'><font color='white'>$opt_id</td>";
echo"<table width='90%' align='center'>";
//echo"<tr><td align='center' bgcolor='#AB6DA5' width='10%'><font color='000033'>Operator Id</font></td>";
//echo"<td align='center' bgcolor='#AB6DA5'  width='20%'><font color='000033'>Operator Name</font></td>";
echo"<td align='center' bgcolor='#AB6DA5'  width='10%'><font color='000033'>Mini Name</font></td>";
echo"<td align='center' bgcolor='#AB6DA5'  width='5%'><font color='000033'>Bill No.</font></td>";
echo"<td align='center' bgcolor='#AB6DA5'  width='15%'><font color='000033'>Bill Date</font></td>";
echo"<td align='center' bgcolor='#AB6DA5'  width='10%'><font color='000033'>Total Crop Area</font></td>";
echo"<td align='center' bgcolor='#AB6DA5'  width='25%'><font color='000033'>Total Salary Amount</font></td>";
echo"<td align='center' bgcolor='#AB6DA5'  width='15%'><font color='000033'>Paid Amount</font></td>";
echo"<td align='center' bgcolor='#AB6DA5'  width='10%'><font color='000033'>Due Amount</font></td>";
echo "<tr><td colspan=\"9\" align=center><iframe src=\"oprtr_wise_frm.php?optr_nm=$optr_nm\" width=\"100%\" height=\"200\" ></iframe></td></tr>";
echo "<tr><td align='center' colspan='3'bgcolor='#AB6DA5' ><font color='000033'>Total</td>";
echo "<td align='center' bgcolor='#AB6DA5' ><font color='000033'></td>";
echo "<td align='center' bgcolor='#AB6DA5' ><font color='000033'></td>";
echo "<td align='center' bgcolor='#AB6DA5' ><font color='000033'></td>";
echo "<td align='center' bgcolor='#AB6DA5' ><font color='000033'></td></tr>";
}
echo"</form></table></body>";
?>

