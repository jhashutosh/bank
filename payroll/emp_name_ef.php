<?
include "../config/config.php";
$q=$_REQUEST['q'];
//echo $q;
$sql="select name from emp_master where emp_id=$q";
$result=dBConnect($sql);
$row=pg_fetch_array($result);
echo"<input type='text' name='name' value='".$row['name']."' size='15' READONLY $HIGHLIGHT>";
?>
