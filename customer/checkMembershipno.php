<?php
include "../config/config.php";
$staff_id=verifyAutho();
//$op=$_REQUEST['op'];
//$customer_id=$_REQUEST['id'];
$menu=$_REQUEST['menu'];
$membership_no=$_REQUEST['membership_no'];

$sql="select * from  membership_info where  membership_no='$membership_no'";
$result=dBConnect($sql);
if(pg_NumRows($result)==0) {
 echo 1;
}
else{
	$row=pg_fetch_array($result);
	echo "<blink><font color=\"darkred\" size='2' ><em>Membership already given to:".$row['customer_id']."</em></font></blink>";
}
?>
