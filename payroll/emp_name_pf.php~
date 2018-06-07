<?
include "../config/config.php";
$q=$_REQUEST['q'];
$main=$_REQUEST['main'];
$sql="select name from emp_master where emp_id=$q";
$result=dBConnect($sql);
$row=pg_fetch_array($result);
echo ucwords($row['name'])."<input type='hidden' name='name' value='".ucwords($row['name'])."' size='20' READONLY $HIGHLIGHT>";
echo $main;
?>
