<?
include "../config/config.php";
$staff_id=verifyAutho();
$op=$_REQUEST['op'];
$id=$_REQUEST['id'];
$op_dt=$_REQUEST['op_dt'];
$yy=$_REQUEST['yy'];
$mnth=$_REQUEST['mm'];
$ym=$yy.$mnth;
$cas_lv=$_REQUEST['cas_lv'];
$med_lv=$_REQUEST['med_lv'];
$mat_lv=$_REQUEST['mat_lv'];//tpd
$oth_lv=$_REQUEST['tol'];//tad
$date=date('d/m/Y H:i:s');
$menu=$_REQUEST['menu'];
$a=0;
$type=trim($_REQUEST['type']);
echo "<HTML>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";
$s="select * from emp_leave_dtls where emp_id=$id order by year_month desc";
$r=dBConnect($s);
$lrow=pg_fetch_array($r,0);
$tcl=(empty($lrow['tot_casual_leave_till_today']))?$a:$lrow['tot_casual_leave_till_today'];
$tml=(empty($lrow['tot_medical_leave_till_today']))?$a:$lrow['tot_medical_leave_till_today'];
$tmtl=(empty($lrow['tot_maturnity_leave_till_today']))?$a:$lrow['tot_maturnity_leave_till_today'];
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<BODY bgcolor=\"silver\" onload=\"op_dt.focus();\">";
$sql_statement="INSERT INTO emp_leave_dtls  VALUES($id,'$ym',$cas_lv,$med_lv,$mat_lv,($cas_lv+$tcl),($med_lv+$tml),($mat_lv+$tmtl),$oth_lv,'$staff_id','$date')";
//$sql="update emp_leave_dtls set tot_casual_leave_till_today=tot_casual_leave_till_today+$cas_lv ,tot_medical_leave_till_today=tot_medical_leave_till_today+$mat_lv ,tot_maturnity_leave_till_today where emp_id=$id";

echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_affected_rows($result)<1)
{
echo "<h2><font color=RED>FAILED TO INSERT DATA INTO THE DATABASE</font></h2>";
}
else
{
echo "<h2 align=center><font color=green>You are Welcome</font></h2>";

}
echo "</body>";
echo "</HTML>";
?>
