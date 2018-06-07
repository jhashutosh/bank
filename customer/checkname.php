<?php
include "../config/config.php";
$staff_id=verifyAutho();
//$op=$_REQUEST['op'];
//$customer_id=$_REQUEST['id'];
$name=$_REQUEST['name'];
$father_name=$_REQUEST['father_name'];

$sql="select * from  customer_master where  lower(name1)=lower('$name') and lower(father_name1)=lower('$father_name')";
$result=dBConnect($sql);
//echo $sql;
if(pg_NumRows($result)==0) {
 echo 1;
}
else{
	$row=pg_fetch_array($result);
	echo "<blink><font color=\"red\" size='1' ><i><b>Customer exist & Id:".$row['customer_id']."</i></font></blink>";
}
?>
