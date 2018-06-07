<?
include "../config/config.php";
$q=$_REQUEST['q'];
//echo $q;
$sql="select name,p.pf_ac_no from emp_master e,emp_pf_dtl p where e.emp_id=p.emp_id and e.emp_id=$q";
//echo $sql;
$result=dBConnect($sql);
$row=pg_fetch_array($result);
echo"<table>";
echo"<td  align='left'> Name </td><td width='1%'>:</td><td><input type='text' name='name' value='".ucwords($row['name'])."' size='20' READONLY $HIGHLIGHT>";
echo "<td align=\"left\">PF Account No</td><td width='1%'>:</td><input type='text' name='c_id' value='".$row['pf_ac_no']."' size='6' READONLY $HIGHLIGHT><td>";
echo"</td></tr><tr>";
if(!empty($row['pf_ac_no']))	{
$s="select count(*) from emp_pf_loan_hrd group by emp_id having emp_id=$q";
$re=dBConnect($s);
$r=pg_fetch_array($re);
if(empty($r['count'])){$ac_no=$row['pf_ac_no'].'/1';}
else{$ac_no=$row['pf_ac_no'].'/'.$r['count']+1;}
		}
echo"<td  align='left'>Loan a/c No </td><td width='1%'>:</td><td colspan='7' align='left'><input type='text' value='$ac_no' name='loan_ac_no' id=\"loan_ac_no\" size='10'  $HIGHLIGHT>";
echo"</tr>";
?>
