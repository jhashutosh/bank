<?
include "../config/config.php";
$staff_id=verifyAutho();
$op=$_REQUEST['op'];
$entry_time=date('d/m/Y H:i:s ');
$mdate=$_REQUEST['mdate'];
$da=$_REQUEST['da'];
$ma=$_REQUEST['ma'];
$hra=$_REQUEST['hra'];
$ecrpf=$_REQUEST['ecrpf'];
$ecpf=$_REQUEST['ecpf'];
$pbonus=$_REQUEST['pbonus'];
$pbonusm=$_REQUEST['pbonusm'];
$eff_from=$_REQUEST['eff_from'];
$menu=$_REQUEST['menu'];
$type=trim($_REQUEST['type']);
echo "<HTML>";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";

echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<BODY bgcolor=\"silver\" onload=\"op_dt.focus();\">";
//$sql_statement=select nextval('emp_sal_param_id_seq')into $emp_id;
$sql_statement="INSERT INTO emp_sal_param (id ,hra1, da1 , ma1 , empl_cont_pf1 , emplee_cont_pf1, puja_bonus, puja_bonus_month, effected_from, operator_code , entry_time) values (nextval('emp_sal_param_id_seq'),$hra,$da,'$ma','$ecrpf','$ecpf','$pbonus','$pbonusm','$eff_from','$staff_id','$entry_time')";

echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_affected_rows($result)<1)
{
echo "<h2><font color=RED>FAILED TO INSERT DATA INTO THE DATABASE</font></h2>";
}
else
{
//echo "<h2 align=center><font color=green>Salary Parameter Processing</font></h2>";
header('location:sal_param.php?');
}
echo "</body>";
echo "</HTML>";
?>
