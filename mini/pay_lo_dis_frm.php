<?
include "../config/config.php";
$lo_id=$_REQUEST['lo_id'];
$min_name=$_REQUEST['min_name'];
$op_name=$_REQUEST['op_name'];
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo"<head>";
echo"<title>framer frame</title>";
echo "<script src=\"../JS/loading2.js\">";
echo "</script>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo"</head>";
$color='lightgreen';
echo"<body bgcolor='grey'>";
echo"<table valign=\"top\"width='100%' align='center'>";
$sql="select * from LC_Operator_salary_Details where id=$lo_id";
$res=dBConnect($sql);
//echo $sql;
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
echo "<tr>";
echo"<tr><td align='center' width='20%'bgcolor='$color' ><font color='000033'>$op_name</font></td>";
echo"<td align='center' width='10%'bgcolor='$color' ><font color='000033'>$min_name</font></td>";
echo"<td align='center' width='20%'bgcolor='$color' ><font color='000033'>".$row['bill_no']."</font></td>";
echo"<td align='center' width='20%'bgcolor='$color'><font color='000033'>".$row['bill_date']."</font></td>";
echo"<td align='center' width='10%'bgcolor='$color' ><font color='000033'>".$row['tot_crop_area']."</font></td>";
echo"<td align='center' width='20%'bgcolor='$color' ><font color='000033'>".$row['tot_sal_amt']."</font></td>";
echo"</tr>";
}
echo"</table></form></body>";
?>

