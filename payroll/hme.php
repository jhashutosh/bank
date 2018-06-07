<?
include "../config/config.php";
$staff_id=verifyAutho();
$customer_id=$_REQUEST['id'];
$menu=$_REQUEST['menu'];
$type=trim($_REQUEST['type']);
$op=$_REQUEST['op'];
$op_dt=$_REQUEST['op_dt'];
$desc=$_REQUEST['Desc'];
$date=date('d/m/Y H:i:s');
if($op==1){
$sql_statement="INSERT INTO emp_holiday_mas (holday_dt,holday_desc,operator_code,entry_time) VALUES('$op_dt','$desc','$staff_id','$date')";
//$sql_statement.=";UPDATE month_working_days set working_days=working_days-1 ,holidays=holidays+1 where month=(select date_part('month',cast('$op_dt' as date)))";

//echo $sql_statement;
$result=dBConnect($sql_statement);


}
echo "<HTML>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";

echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<BODY bgcolor=\"silver\" onload=\"op_dt.focus();\">";
echo"<hr>";
echo "<table width=\"100%\" bgcolor=\"#F5F5DC\" align=\"CENTER\">";
echo"<center>";
echo"<font color=\"GREEN\"><H3>Holiday Master</H3></font></center>";
echo "<tr><th colspan=\"4\" bgcolor=green><b><font color=White>".$type_of_account1_array[trim($type)]." Holiday Master Form</font></b></th>";
echo "<form name=\"f1\" method=\"POST\" action=\"hme.php?op=1\">";
echo "<tr><td>Date :<td><input type=\"TEXT\" name=\"op_dt\" id=\"op_dt\" size=\"10\" onclick=\"showCalendar(f1.op_dt,'dd/mm/yyyy','Choose Date')\" $HIGHLIGHT>";
//echo "&nbsp;<input type=\"button\" name=\"date1\" value=\"...\" onclick=\"showCalendar(f1.op_dt,'dd/mm/yyyy','Choose Date')\">";
echo "<td>Description : <input type=\"TEXT\" name=\"Desc\" size=30 value=\"\" $HIGHLIGHT>";
echo "<tr><td><td align=RIGHT colspan=3><input type=submit value=Submit>&nbsp;";
echo "<input type=\"RESET\" name=\"RESET_BUTTON\" value=\"Reset\"><br>";
echo"<tr><td colspan='2' bgcolor='lightgreen' width='30%'>Holiday Date</td><td colspan='2' bgcolor='lightgreen' width='70%'>Holiday Description</td></tr>";
echo "<tr><td colspan=\"4\" align=center><iframe src=\"holiday.php\" width=\"100%\" height=\"300\" ></iframe>";
//echo "<input type=Button value=Return onClick=\"Location.href='customer_statement.php?id=$customer_id'\"> ";
echo "</form>";
echo "</table>";
?>
 <script language="JavaScript" type="text/javascript">
 var frmvalidator  = new Validator("f1");
 frmvalidator.addValidation("op_dt","req","Please enter date");
   
  frmvalidator.addValidation("Desc","req","Description should not Blank");
  frmvalidator.addValidation("Desc","alpha_s","Enter character Only For Description Field");
  frmvalidator.addValidation("Desc","maxlen=30","Max Length is 30 only");
  

</script>
<?
echo "</body>";
echo "</HTML>";
?>
