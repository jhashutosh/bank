<?
include "../config/config.php";
$staff_id=verifyAutho();
$pol=$_REQUEST['pol'];
if(empty($pol))
{ echo"<font color='red'>Please Enter Your Policy no.</font>";}
else{
$sql_statement="select * from emp_pforgratuity_lic_hdr where pol_no='$pol'";
//echo "$sql_statement";
$result=dBConnect($sql_statement);
$row=pg_fetch_array($result,0);
if(pg_NumRows($result)>0)
{
echo "<font color='red'>Policy No. is exist for Account-".$row['ac_no']."</font>";
}
else
{
echo 1;
}
}

?>
