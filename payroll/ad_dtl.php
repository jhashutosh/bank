<?
include "../config/config.php";
echo "<head>";
echo "<title>ADHOC DETAILS";
echo "</title>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
?>
<script LANGUAGE="JavaScript">
function tot_cal()
{
//var total=Number(document.getElementById('tot').value);
var amt=document.getElementById('amount').value;
var todate=document.getElementById('tod').value;
var frdate=document.getElementById('fromd').value;
var tos=todate.split('/');
var a=Number(tos[1]);
var fros=frdate.split('/');
var b=Number(fros[1]);
if(a<b)
var diff=(12-b)+1+a;
else 
var diff=(a-b)+1;
var totf=Number(amt*diff);
//var total_amount=total+totf;
document.getElementById('total').value=totf;
}
</script>
<?
echo"<input type='hidden' name='tot' id='tot' value=".$rw['total'].">";
echo "<body bgcolor=\"#DFF1FF\">";
echo"<form  name='f1' action=\"ad_dtl.php?op=i\" method='post'>";
echo"<table valign=\"top\"width='100%'>";
echo"<tr><th colspan='9' bgcolor='#028DFE'><font color='white' size='2'>Adhoc Grant Disbursement</font></th></tr><tr><td  colspan='9'></td></tr><tr><td  colspan='9'></td></tr><tr><td  colspan='9'></td></tr>";
echo"<tr><td align='left'>Grant Id</td><td width='1%'>:</td><td><select name='gr_id'>
<option value='null'>select</option>";
$grid="select grant_no from emp_adhoc_grant_mas";
$grres=dBConnect($grid);
                  for($j=1; $j<=pg_NumRows($grres); $j++){
                   $rgr=pg_fetch_array($grres,($j-1));
                   echo "<option value=".$rgr['grant_no'].">".$rgr['grant_no']."</option>";
                                        }
echo"</select>";
echo"<td align='left'>Employee Name</td><td width='1%'>:</td><td>";
makeselectempname('gre_id','emp_id','name');
echo"</td><td align='left'>Monthly Amount</td><td width='1%'>:</td><td><input type='text' name='amount' id=\"amount\" size='5' $HIGHLIGHT><font color='red'> *</font></tr><tr><td colspan='9'></td></tr>";
echo"<tr><td>From Date</td><td width='1%'>:</td><td> <input type=\"TEXT\" name=\"fromd\" id=\"fromd\" size=\"12\" ><input type='button' onclick=\"showCalendar(f1.fromd,'dd/mm/yyyy','Choose Date')\" $HIGHLIGHT ><font color='red'> *</font>";
echo "</td>";
echo"<td>To Date</td><td width='1%'>:</td><td> <input type=\"TEXT\" name=\"tod\" id=\"tod\" size=\"12\" ><input type='button'  onclick=\"showCalendar(f1.tod,'dd/mm/yyyy','Choose Date')\"    $HIGHLIGHT ><font color='red'> *</font>";
echo "</td>";
echo"<td>Payment Date</td><td width='1%'>:</td><td> <input type=\"TEXT\" name=\"payd\" id=\"payd\" size=\"12\" onfocus=\"tot_cal();\" onChange=\"tot_cal(); \" onKeyup=\"tot_cal();\"><input type='button'  onclick=\"showCalendar(f1.payd,'dd/mm/yyyy','Choose Date')\"  $HIGHLIGHT><font color='red'>*</font></td></tr><tr><td  colspan='9'></td>";
echo"<tr><td colspan='4' align='right'>Total</td><td>:</td><td colspan='4'><input type='text' name='total' id='total' value=''  size='5' $HIGHLIGHT></td></tr></tr><tr><td colspan='9'></td></tr></tr><tr><td colspan='9' align='center'><input type='submit' value='ok'></td></tr>";
echo"</table></form></body>";
if($op=='i')
{$del=$_REQUEST['del'];
if($del=='y'){
$did=$_REQUEST['did'];
$del="delete from adhoc_temp where id=$did";
$del_res=dBConnect($del);
}
$TCOLOR='#FFFCD3';
$TBGCOLOR='#D3FFFD';
$sum=0;
$id=$_REQUEST['gre_id'];
$total=$_REQUEST['total'];
$grid=$_REQUEST['gr_id'];
$amount=$_REQUEST['amount'];
$tdate=$_REQUEST['tod'];
$frdate=$_REQUEST['fromd'];
$payd=$_REQUEST['payd'];
$staff_id==verifyAutho();
$entry_time=date('d/m/Y H:i:s ');
$sql="insert into adhoc_temp (grant_id , grant_emp_id , grant_amount , from_date , upto_date , pay_date , operator_code , entry_time , total ) values ('$grid',$id,$amount,'$frdate','$tdate','$payd','$staff_id','$entry_time',$total)";
$result=dBConnect($sql);
//echo $sql;
$dis_sql="select * from adhoc_temp a,emp_master b where a.grant_emp_id=b.emp_id";
$dis_res=dBConnect($dis_sql);
//echo $dis_sql;
echo"<table width='100%'>";
echo"<tr><th width='10%' bgcolor='FFE0D7'><font color='640000'>Grant No.</th>";
echo"<th width='15%' bgcolor='FFE0D7'><font color='640000'>Staff Name</th>";
echo"<th width='10%' bgcolor='FFE0D7'><font color='640000'>Monthly Grant Amount</th>";
echo"<th width='15%' bgcolor='FFE0D7'><font color='640000'>From Date</th>";
echo"<th width='15%' bgcolor='FFE0D7'><font color='640000'>To Date</th>";
echo"<th width='15%' bgcolor='FFE0D7'><font color='640000'>Grant Amount</th>";
echo"<th width='15%' bgcolor='FFE0D7'><font color='640000'>Payment date</th>";
echo"<th width='5%' bgcolor='FFE0D7'><font color='640000'>Operation</th></tr>";
//$row=pg_fetch_array($dis_res,0);
//echo $row['grant_id'];
for($j=0; $j<pg_NumRows($dis_res); $j++)
{$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($dis_res,$j);
$sum=$sum+$row['total'];
echo "<tr><td align='center' width='10%' bgcolor=$color><font color='3D648E'>".$row['grant_id']."</td>";
echo "<td width='15%' align='center' bgcolor=$color><font color='3D648E'>".$row['name']."</td>";
echo "<td width='10%' align='center' bgcolor=$color><font color='3D648E'>".$row['grant_amount']."</td>";
echo "<td width='15%' align='center' bgcolor=$color><font color='3D648E'>".$row['from_date']."</td>";
echo "<td width='15%' align='center' bgcolor=$color><font color='3D648E'>".$row['upto_date']."</td>";
echo "<td width='15%' align='center' bgcolor=$color><font color='3D648E'>".$row['total']."</td>";
echo "<td width='15%' align='center' bgcolor=$color><font color='3D648E'>".$row['pay_date']."</td>";
echo "<td width='5%' align='center' bgcolor=$color><font color='3D648E'>";
echo "<a href=\"ad_dtl.php?op=i&del=y&did=".$row['id']."\">Del</a></td></tr>";
}
echo"<tr><td colspan='7'><br></td></tr>";
echo"<tr><td colspan='7'><br></td></tr>";
echo"<tr><th colspan='3'>Total Grant Amount </th><th>:</th><td><input type='text' name='grt' size='6' id='grt' value='$sum'></td></tr><tr><td colspan='7'><br></td></tr><tr><td colspan='7'><br></td></tr></table>";
echo"<form name='f2' method='post' action=ad_dtl.php?op=s> ";
echo"<div align='center'><input type='submit' name='submit' value='Submit'></div>";
echo"</form>";
}
if($op=='s'){

$func="select emp_adhoc_grant_dtl_save_fnc()";
$fres=dBConnect($func);
//echo $func;

}
?>
