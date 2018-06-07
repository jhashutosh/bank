<?
include "../config/config.php";
$staff_id=verifyAutho();
$op=$_REQUEST['op'];
$customer_id=$_REQUEST['id'];
$menu=$_REQUEST['menu'];
$type=trim($_REQUEST['type']);
echo "<HTML>";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "<script src=\"../JS/loading2.js\"></script>";
?><script LANGUAGE="JavaScript">
function f2(str){
//alert("str"+str);
showHint_subemp_pf(str);

}
</script>
<?
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<BODY bgcolor=\"silver\" onload=\"op_dt.focus();\">";
echo"<hr>";
echo "<table width=\"75%\" bgcolor=\"#F5F5DC\" align=\"CENTER\">";
echo"<center>";
echo"<font color=\"GREEN\"><H1>Employee Leave Details </H1></font></center>";
echo "<tr><th colspan=\"4\" bgcolor=green><b><font color=White>".$type_of_account1_array[trim($type)]." Employee Leave Form</font></b></th>";
echo "<form name=\"f1\" method=\"POST\" action=\"eld_add.php?menu=$menu&op=$op\">";
echo"<tr><td> Employee Id &nbsp;:&nbsp;";
makeselectemp('id',"onChange=\"f2(this.value);\"");
echo"</td><td colspan='2'> Name :";
?>
<span id="txtHint"></span>
<?
echo"</tr><tr><td>Select Year&nbsp;:&nbsp;<select name='yy'>
<option value='2013'>2013</option><option value='2014'>2014</option><option value='2015'>2015</option>
<option value='2016'>2016</option><option value='2017'>2017</option><option value='2018'>2018</option><option value='2019'>2019</option><option value='2020'>2020</option><option value='2021'>2021</option>
<option value='2022'>2022</option><option value='2023'>2023</option><option value='2024'>2024</option><option value='2025'>2025</option>
</select></td>";
echo"<td>Select Month&nbsp;:&nbsp;</select>
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
echo "<tr><td>Total Casual Leave&nbsp;:&nbsp;<input type=\"TEXT\" name=\"cas_lv\" size=10 value=\"0\" $HIGHLIGHT>";
echo "<td>Total Medical Leave&nbsp;:&nbsp;<input type=\"TEXT\" name=\"med_lv\" size=10 value=\"0\" $HIGHLIGHT>";
echo "<tr><td>Total Meternity Leave&nbsp;:&nbsp;<input type=\"TEXT\" name=\"mat_lv\" size=10 value=\"0\" $HIGHLIGHT>";
echo "<td>Total Other Leave&nbsp;:&nbsp;<input type=\"TEXT\" name=\"tol\" size=10 value=\"0\" $HIGHLIGHT>";
echo "<tr><td><td align=RIGHT colspan=3><input type=submit value=Submit>&nbsp;";
echo "<input type=\"RESET\" name=\"RESET_BUTTON\" value=\"Reset\"><br>";
//echo "<input type=Button value=Return onClick=\"Location.href='customer_statement.php?id=$customer_id'\"> ";
echo "</form>";
echo "</table>";
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
echo "</HTML>";
?>
