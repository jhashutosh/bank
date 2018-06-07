<?
include "../config/config.php";
$id=$_REQUEST['c'];
$staff_id=verifyAutho();
$lo_id=$_REQUEST['lo_id'];
$min_name=$_REQUEST['min_name'];
$op_name=$_REQUEST['op_name'];
$sql="select * from LC_Operator_salary_Details where id=$lo_id";
$res=dBConnect($sql);
//echo $sql;
$row=pg_fetch_array($res,0);
$tot_sal_amt=$row['tot_sal_amt'];
$bl_no=$row['bill_no'];
//echo $tot_sal_amt;
//echo $bl_no;
echo "<head>";
echo "<title>Personal statement";
echo "</title>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<script src=\"../JS/loading.js\"></script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"lightblue\">";
$color='#66CCFF';
echo"<form name='f1' action='paymnt_lo_dis.php?op=i&bl_no=$bl_no&lo_id=$lo_id&min_name=$min_name&op_name=$op_name' method='post'>";
if($op=='i')
{$time=date('d/m/Y H:i:s');
$updt_sal_amnt=$_REQUEST['updt_sal_amnt'];
$pay_dt=$_REQUEST['pay_dt'];
$bil_no=$_REQUEST['bl_no'];
$sql="select lc_operator_salary_details_upd_fnc($updt_sal_amnt,'$pay_dt','$bil_no','$staff_id','$time','$pay_dt')";
$res=dBConnect($sql);
echo $sql;
}
echo"<table valign=\"top\" align='center' width='100%' bgcolor='000033'>"; 
echo"<tr><th colspan='6' bgcolor='000033' align='center'><font color='white'>*Payment*</font></th></td></tr>";
echo"<tr><th align='center' width='20%'bgcolor='$color' ><font color='000033'>Operator Name</font></td>";
echo"<td align='center' width='10%'bgcolor='$color' ><font color='000033'>Mini Name</font></td>";
echo"<td align='center' width='20%'bgcolor='$color' ><font color='000033'>Bill No.</font></td>";
echo"<td align='center' width='20%'bgcolor='$color'><font color='000033'>Bill Date</font></td>";
echo"<td align='center' width='10%'bgcolor='$color' ><font color='000033'>Total Crop Area</font></td>";
echo"<td align='center' width='20%'bgcolor='$color' ><font color='000033'>Total Salary Amount</font></td></tr>";
echo "<tr><td colspan=\"6\" align=center><iframe src=\"pay_lo_dis_frm.php?c=$id&lo_id=$lo_id&min_name=$min_name&op_name=$op_name\" width=\"100%\" height=\"200\" ></iframe></td></tr>";
echo"<tr><td align='right' bgcolor='000033' colspan='2'><font color='white'>Total Salary Amount</font></td><td align='left' bgcolor='000033' colspan='1'>";
echo"<input type='text' name='updt_sal_amnt' size='15'$HIGHLIGHT value='$tot_sal_amt'></td>";
echo "<td align='right' bgcolor='000033' colspan='1'><font color='white'size='2' align='left'>Payment Date&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td align='left' bgcolor='000033' colspan='2'>";
echo"<input type=\"TEXT\" name=\"pay_dt\" size=\"12\" value=\"\" id=\"pay_dt\"  value=\"".date('d.m.Y')."\"  $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.pay_dt,'dd/mm/yyyy','Choose Date')\" ></td></tr></table>";
echo"<table bgcolor='lightblue'><tr ><td  colspan='6' bgcolor='lightblue'></td></tr><tr><td  colspan='6'</td></tr><tr><td  colspan='6' bgcolor='lightblue'></td></tr></table>";
echo"<table bgcolor='lightblue' width='100%'><tr><td  bgcolor='000033' colspan=\"6\" height='10%'></td></tr>";
echo"<tr><td align='center' bgcolor='000033' colspan='6'><input type='submit' value='Update'></td></tr>";
echo"</table>";

echo"</body>";
?>
