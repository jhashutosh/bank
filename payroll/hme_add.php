<?
include "../config/config.php";
$staff_id=verifyAutho();
$op=$_REQUEST['op'];
$customer_id=$_REQUEST['id'];
$op_dt=$_REQUEST['op_dt'];
$desc=$_REQUEST['Desc'];
$date=date('d/m/Y H:i:s');
$menu=$_REQUEST['menu'];
$type=trim($_REQUEST['type']);
echo "<HTML>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";

echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<BODY bgcolor=\"silver\" onload=\"op_dt.focus();\">";
$sql_statement="INSERT INTO emp_holiday_mas (holday_dt,holday_desc,operator_code,entry_time) VALUES('$op_dt','$desc','$staff_id','$date')";
$sql_statement.=";UPDATE month_working_days set working_days=working_days-1 ,holidays=holidays+1 where month=(select date_part('month',cast('$op_dt' as date)))";

echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_affected_rows($result)<1)
{
echo "<h2><font color=RED>FAILED TO INSERT DATA INTO THE DATABASE</font></h2>";
}
else
{
echo "<h2 align=center><font color=green> HAPPY HOLIDAY</font></h2>";

}
echo "</body>";
echo "</HTML>";
?>
