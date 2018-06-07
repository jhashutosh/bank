<?
include "../config/config.php";
$op_id=$_REQUEST['c'];
$staff_id=verifyAutho();
$operator=$_REQUEST['name'];
$mini=$_REQUEST['mini_id'];
$op=$_REQUEST['op'];
//echo "<h1>hi:$op</h1>";
$time=date('d/m/Y H:i:s');
if($op=='i')
{
$time=date('d/m/Y H:i:s');
$updt_sal_amnt=$_REQUEST['updt_sal_amnt'];
$pay_dt=$_REQUEST['pay_dt'];
$bil_no=$_REQUEST['bl_no'];
$sql="select lc_operator_salary_details_upd_fnc($updt_sal_amnt,'$pay_dt','$bil_no','$staff_id','$time','$pay_dt')";
$res=dBConnect($sql);
//echo $sql;

}

echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo"<head>";
echo"<title>framer frame</title>";
echo "<script src=\"../JS/loading2.js\">";
echo "</script>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo"</head>";
echo"<body bgcolor='silver'>";
echo"<table valign=\"top\"width='100%' align='center'>";
$sql="select osd.bill_no,osd.Id as lo_id,om.Id,om.Operator_name,mol.Id_mini_master,mm.Mini_name,sum(osd.Tot_Sal_amt) as tot_sal_amt,sum(osd.Due_amt) as due_amt
from LC_Operator_Salary_Details osd,LC_Mini_Operator_Link mol,LC_Operator_Master om,LC_Mini_Master mm 
where osd.Id_mini_operator_link=mol.Id
and mol.Id_Operator_Master=om.Id
and mol.Id_Mini_Master=mm.Id
and om.Id=$op_id
and osd.Paid_amt=0
/*and osd.Paid_date >=(select start_dt from fy_list where fy=(select max(fy) from fy_list)) 
and osd.Paid_date <=(select close_dt from fy_list where fy=(select max(fy) from fy_list))*/
group by osd.Id,om.Id,om.Operator_name,mol.Id_mini_master,mm.Mini_name,osd.bill_no
";
$res=dBConnect($sql);
//echo $sql;
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
$lo_id=$row['lo_id'];
$op_name=$row['operator_name'];
$min_name=$row['mini_name'];
echo "<tr>";
echo "<td  bgcolor='#628784' align='center' colspan=\"1\" width='15%'><font color='black' size='2'>".$row['bill_no']."</font></td>";
echo "<td  bgcolor='#628784' align='center' colspan=\"1\" width='15%'><font color='black' size='2'>".$row['mini_name']."</font></td>";
echo"<td  bgcolor='#628784' align='center' colspan=\"1\" width='15%'><font color='black' size='2'>".$row['tot_sal_amt']."</font></td>";
echo"<td  bgcolor='#628784' align='center' colspan=\"1\" width='15%'><font color='black' size='2'>".$row['due_amt']."</font></td>";
echo"<form name='f1' action='paymnt_dtls.php?c=$op_id&op=i&updt_sal_amnt=".$row['tot_sal_amt']."&bl_no=".$row['bill_no']."' method=\"post\">";
echo "<td align='center' bgcolor='#628784' colspan='1' width='25%'><font color='black'size='2' >Payment Date : ";
echo"<input type=\"TEXT\" name=\"pay_dt\" size=\"10\" id=\"pay_dt\"  value=\"".date('d.m.Y')."\"  $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.pay_dt,'dd/mm/yyyy','Choose Date')\" >";
echo"<input type='submit' value='pay'></form></td>";
echo"</tr>";
}
echo"</table></body>";
?>
