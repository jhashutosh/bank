<?
include "../config/config.php";
$q=$_REQUEST['q'];
//echo $q;
$sql="select name  from emp_master where emp_id=$q";
$result=dBConnect($sql);
$row=pg_fetch_array($result);
echo"<table>";
echo"<td  align='left'> Name </td><td width='1%'>:</td><td><input type='text' name='name' value='".$row['name']."' size='20' READONLY $HIGHLIGHT>";
//echo "<td align=\"left\">PF a/c No</td><td width='1%'>:</td><input type='text' name='pf_ac_no' value='".$row['pf_ac_no']."' size='6' READONLY $HIGHLIGHT><td>";
echo"</td></tr>";
?>
