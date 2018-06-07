<?php
include "../config/config.php";
$staff_id=verifyAutho();
//$op=$_REQUEST['op'];
//$customer_id=$_REQUEST['id'];
$menu=$_REQUEST['menu'];
$accno=$_REQUEST['account_no'];
$sql="select * from customer_account where account_no='$accno'";
$result=dBConnect($sql);
if(pg_NumRows($result)==0) {
 echo 1;
}
else{
	$row=pg_fetch_array($result);
	echo "<blink><font color=\"red\">KCC Account Exist With:".$row['customer_id']."</font></blink>";
}
?>
