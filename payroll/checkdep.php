<?
include "../config/config.php";
$staff_id=verifyAutho();
$dep=$_REQUEST['dep'];
if(empty($dep))
{ echo"<font color='red'>Please Enter Your Deposit no.</font>";}
else{
$sql_statement="select * from  emp_pforgratuity_sb_dtl where deposit_no='$dep'";
//echo "$sql_statement";
$result=dBConnect($sql_statement);
$row=pg_fetch_array($result,0);
if(pg_NumRows($result)>0)
{
echo "<font color='red'>The Deposit No. is exist for Account No.-".$row['ac_no']."</font>";
}
else
{
echo 1;
}
}

?>
