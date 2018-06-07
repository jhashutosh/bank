<?
include "../config/config.php";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo"<head>";
echo"<title>customer frame</title>";
echo "<script src=\"../JS/loading2.js\">";
echo "</script>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo"</head>";
$color='lightgreen';
echo"<body bgcolor='grey'>";
echo"<table valign=\"top\"width='110%' align='center'>";
$sql="select * from LC_Customer_Payment_Details";
$res=dBConnect($sql);
//echo $sql;
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
echo "<tr>";
echo"<tr><td align='center' width='10%'bgcolor='$color' ><font color='000033'>".$row['bill_no']."</font></td>";
echo"<td align='center' width='10%'bgcolor='$color' ><font color='000033'>".$row['bill_date']."</font></td>";
echo"<td align='center' width='15%'bgcolor='$color' ><font color='000033'>".$row['tot_amt']."</font></td>";
echo"<td align='center' width='15%'bgcolor='$color'><font color='000033'>".$row['paid_amt']."</font></td>";
echo"<td align='center' width='10%'bgcolor='$color' ><font color='000033'>".$row['due_amt']."</font></td>";
echo"<td align='center' width='15%'bgcolor='$color' ><font color='000033'>".$row['overdue_amt']."</font></td>";
echo"<td align='center' width='15%'bgcolor='$color' ><font color='000033'>".$row['bal_amt']."</font></td>";
echo"<td align='center' width='15%'bgcolor='$color' ><font color='000033'>".$row['action_date']."</font></td>";
echo"</tr></table></body>";
}
?>
