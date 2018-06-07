<?
include "../config/config.php";
$staff_id=verifyAutho();
$op=$_REQUEST['op'];
$id=$_REQUEST['id'];
$op_dt=$_REQUEST['op_dt'];
$yy=$_REQUEST['yy'];
$mnth=$_REQUEST['mm'];
$ym=$yy.$mnth;
$wrk=$_REQUEST['pla'];
$prsnt=$_REQUEST['rdi'];//tpd
$absnt=$_REQUEST['rp'];//tad
$bdue=$_REQUEST['bdi'];
$bp=$_REQUEST['bp'];
$date=date('d/m/Y H:i:s');
$menu=$_REQUEST['menu'];
$type=trim($_REQUEST['type']);
echo "<HTML>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";

echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<BODY bgcolor=\"silver\" onload=\"op_dt.focus();\">";
$sql_statement="INSERT INTO emp_pf_loan_dtl (emp_id,year_month,pf_loan_ac_no,r_due_int,r_principal,b_due_int, b_principal,operator_code,entry_time) VALUES($id,'$ym','$wrk','$prsnt','$absnt','$bdue','$bp','$staff_id','$date')";

//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_affected_rows($result)<1)
{
echo "<h2><font color=RED>FAILED TO INSERT DATA INTO THE DATABASE</font></h2>";
}
else
{
echo "<h2 align=center><font color=green>Your PF Loan under Process</font></h2>";

}
echo "</body>";
echo "</HTML>";
?>
