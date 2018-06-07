<?
include "../config/config.php";
$staff_id==verifyAutho();
$dis=$_REQUEST['ei'];
if($dis==1)
{
$sql="select a.name,b.pf_loan_ac_no from emp_master a,emp_pf_loan_hrd b where a.emp_id=$q and a.emp_id=b.emp_id";
$result=dBConnect($sql);
//echo $sql;
//$s="select pf_loan_ac_no from emp_pf_loan_dtl where emp_id=$q";
//$r=dBConnect($s);
$row=pg_fetch_array($result,0);
echo"<input type='text' name='name' value='".$row['name']."' size='20' READONLY $HIGHLIGHT></td></tr>
<tr><td bgcolor=\"#9ACD32\">PF Loan Account Number :<input type='text' name='pf_ln_ac_no' value='".$row['pf_loan_ac_no']."' size='6' READONLY $HIGHLIGHT></td></tr>";
}
else
{
echo "<html>";
echo "<head>";
echo "<title>PF Loan detail</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script src=\"../JS/loading2.js\"></script>";
?><script LANGUAGE="JavaScript">

function f2(str)
{
//alert("str"+str);
showHint_subemp_pfid(str);

}

</script>
<?
echo "</head>";
echo "<body bgcolor=\"\">";
echo "<form name=\"f1\" METHOD=\"POST\" ACTION=\"pf_loan_dtl.php\">";
echo "<center><br><br><br>";
echo"<input type='hidden' name='blnc' id='blnc' value=''>";
echo "<table width=\"50%\" bgcolor='black'>";
echo "<tr><td bgcolor=\"#0000CD\" colspan=\"19\" align=\"center\"><b><font color=\"WHITE\">PF Loan Detail</font>";
echo "<tr";
echo "<td bgcolor=\"#9ACD32\">Employee Id : ";
makeselectemp('id',"onChange=\"f2(this.value);\"");
echo"</td><td bgcolor=\"#9ACD32\" width='50%'> Name :";
?>
<span id="txtHint"></span>
<?
//echo"</td></tr>";
echo "<tr><td bgcolor=\"#9ACD32\">Year&nbsp;:&nbsp;&nbsp;
<select name='yy'>
<option>Select</option>
<option value='2013'>2013</option>
<option value='2014'>2014</option>
</select>
&nbsp;&nbsp;</td>";
echo"<td bgcolor=\"#9ACD32\">Month&nbsp;:&nbsp;&nbsp;
<select name='mm'>
<option>Select</option>
<option value='01'>Jan</option>
<option value='02'>Feb</option>
<option value='03'>Mar</option>
<option value='04'>Apr</option>
<option value='05'>May</option>
<option value='06'>Jun</option>
<option value='07'>Jul</option>
<option value='08'>Aug</option>
<option value='09'>Sep</option>
<option value='10'>Oct</option>
<option value='11'>Nov</option>
<option value='12'>Dec</option>
</select> </td> ";
echo "<tr><td bgcolor=\"#9ACD32\" colspan='2' align='center'><input type=\"submit\" value=\"Enter Information\"></td></tr>";
/*echo "<tr><td bgcolor=\"#9ACD32\">Return Due Interest</td><td bgcolor=\"#9ACD32\"><input type=\"text\" name=\"rdi\"size=\"10\" $HIGHLIGHT></td></tr>";
echo "<tr><td bgcolor=\"#9ACD32\">Return Principal</td><td bgcolor=\"#9ACD32\"><input type=\"text\" name=\"rp\"size=\"10\" $HIGHLIGHT></td>";
echo "<tr><td bgcolor=\"#9ACD32\">Balance Due Interest</td><td bgcolor=\"#9ACD32\"><input type=\"text\" name=\"bdi\"size=\"10\" $HIGHLIGHT></td>";
echo "<tr><td  bgcolor=\"#9ACD32\">Balance Principal</td><td bgcolor=\"#9ACD32\"><input type=\"text\" name=\"bp\"size=\"10\" $HIGHLIGHT></td>";
echo "<tr><td  bgcolor=\"#9ACD32\" align=\"center\" colspan=\"2\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Submit\">";*/

echo "</table>";
echo "</body>";
echo "</html>";
}
?>
