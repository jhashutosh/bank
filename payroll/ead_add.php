<?
include "../config/config.php";
$staff_id=verifyAutho();
$op=$_REQUEST['op'];
$id=$_REQUEST['id'];
$op_dt=$_REQUEST['op_dt'];
$yy=$_REQUEST['yy'];
$mnth=$_REQUEST['mm'];
$ym=$yy.$mnth;
$wrk=$_REQUEST['wd'];
$otd=$_REQUEST['otd'];
$prsnt=$_REQUEST['pd'];//tpd
$absnt=$_REQUEST['tad'];//tad
$date=date('d/m/Y H:i:s');
$menu=$_REQUEST['menu'];
$otd=$_REQUEST['otd'];
$ot_pay=$_REQUEST['ot_pay'];
$type=trim($_REQUEST['type']);
echo "<HTML>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";

echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<BODY bgcolor=\"silver\" onload=\"op_dt.focus();\">";
$sql_statement="INSERT INTO emp_attendance_dtls (emp_id,year_month,tot_month_working_days,tot_present_days,tot_absent_days,operator_code,entry_time) VALUES($id,'$ym','$wrk','$prsnt','$absnt','$staff_id','$date')";
if($otd>0 or $ot_pay>0 ){
$sql="select case when max(id) is null then 1 else max(id)+1 end as id from emp_overtime_dtl";
$res=dBConnect($sql);
$id_t=pg_fetch_result($res,'id');
$sql_statement.=";insert into emp_overtime_dtl (id,emp_id,year_month,ot_days,ot_payment,operator_code,entry_time) values ($id_t,$id,'$ym',$otd,$ot_pay,'$staff_id','$date')";

}

//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_affected_rows($result)<1)
{
echo "<h2><font color=RED>FAILED TO INSERT DATA INTO THE DATABASE</font></h2>";
}
else
{
echo "<h2 align=center><font color=green>Your Attendance is submitted</font></h2>";
header("location:../payroll/ead.php?menu=pr");

}
echo "</body>";
echo "</HTML>";
?>
