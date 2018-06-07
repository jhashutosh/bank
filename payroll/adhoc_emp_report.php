 <?
include "../config/config.php";
$grant_no=$_REQUEST['gr_no'];
$TCOLOR='#FFD6C8';
$TBGCOLOR='#FFBFDE';
$id=$_REQUEST['id'];
$name_des="select a.name,b.desg_desc from emp_master a,emp_designation_mas b where a.emp_id=$id and a.id_emp_designation_mas=b.id";
$res=dBConnect($name_des);
$name=pg_fetch_array($res,0);
echo"<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo"</head>";
//echo $grant_no;
echo"<body bgcolor='#FFEBF3'>";
echo"<table width='100%'  bgcolor='FFFFCB' align='center'>";
echo"<tr><td  width='15%' bgcolor='FFFFCB'></td><td bgcolor='FFFFCB' align='right' colspan='2'><font color='0B2D61'>ADHOC Grant Details of </td><th bgcolor='FFFFCB' width='20%'><font color='#7C002C'>".$name['name']."</th><th align='left'  bgcolor='FFFFCB' width='15%'><font color='#7C002C'>".$name['desg_desc']."</th><td align='right'  bgcolor='FFFFCB' width='10%'><font color='0B2D61'>for GRANT NO.</td><th  bgcolor='FFFFCB'><font color='#7C002C'>$grant_no</th><td  width='15%'  bgcolor='FFFFCB'></td></tr></table><br><br>";
echo"<table align='center' width='100%'><tr>";
echo"<td align='center' bgcolor='#F54663'><font color='white'>From Date</td>";
echo"<td align='center' bgcolor='#F54663'><font color='white'>Monthly Amount</td>";
echo"<td align='center' bgcolor='#F54663'><font color='white'>To Date</td>";
echo"<td align='center' bgcolor='#F54663'><font color='white'>Total Amount</td>";
echo"<td align='center' bgcolor='#F54663'><font color='white'>Payment Date</td></tr>";
$sql="Select * from emp_adhoc_grant_dtl where emp_id=$id and grant_no='$grant_no'";
$result=dBConnect($sql);
for($j=0;$j<pg_NumRows($result);$j++)
{$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
echo"<td align='center' bgcolor=$color><font color='#C91246'>".$row['from_dt']."</td>";
echo"<td align='center' bgcolor=$color><font color='#C91246'>".$row['monthly_amount']."</td>";
echo"<td align='center' bgcolor=$color><font color='#C91246'>".$row['to_dt']."</td>";
echo"<td align='center' bgcolor=$color><font color='#C91246'>".$row['amount']."</td>";
echo"<td align='center' bgcolor=$color><font color='#C91246'>".$row['pay_dt']."</td></tr>";
}
echo"<tr><td colspan='5'></td></tr><tr><td colspan='5'></td></tr><tr><td align='center' colspan='5'><a href='ad_report.php'><font size='2'> <<| Back </font></td></tr>";
echo"</table>";
echo"</body>";
?>
