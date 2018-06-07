<?php
include "../config/config.php";
$staff_id=verifyAutho();
$did=$_REQUEST['a'];
echo "$did";
$sql_statement="SELECT 'a' FROM crop_mas WHERE crop_desc='$did'";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0)
{
header('location:general_master_view.php?po=c');
}
else
{
echo "<h1>Existing in database!!!</h1>";

}
?>
