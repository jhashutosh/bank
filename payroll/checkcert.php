<?
include "../config/config.php";
$staff_id=verifyAutho();
$cert=$_REQUEST['cert'];
if(empty($cert))
{ echo"<font color='red'>Please Enter Your Certificate no.</font>";}
else{
$sql_statement="select * from emp_pforgratuity_po_hdr where saving_regno='$cert'";
//echo "$sql_statement";
$result=dBConnect($sql_statement);
$row=pg_fetch_array($result,0);
if(pg_NumRows($result)>0)
{
echo "<font color='red'> Certificate No. is exist for Account-".$row['ac_no']."</font>";
}
else
{
echo 1;
}
}

?>
