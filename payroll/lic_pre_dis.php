<?
include "../config/config.php";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
$emp_id=$_REQUEST['emp_id'];
$pol_id=$_REQUEST['pol_id'];
//echo $type;
echo"<head>";
echo"<title>pf_dis</title>";
echo "<script src=\"../JS/loading2.js\">";
echo "</script>";
echo "<script src=\"../JS/calendar.js\">";

echo"</head>";
echo"<body bgcolor='grey'>";
$TBGCOLOR="white";
$TCOLOR="lightgreen";
echo"<form  name='f1' action='pf_dis.php' method='post' >";
echo"<table valign=\"top\"width='110%' align='center'>";
$sql="select * from emp_pforgratuity_lic_dtl";
$res=dBConnect($sql);
//echo $sql;
$color==$TCOLOR;
for($j=0;$j<pg_NumRows($res);$j++){
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($res,$j);
echo "<tr>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"6%\"><font color='black' size='2'>".$row['premium_sl_no']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"20%\"><font color='black' size='2'>".$row['premium_start_dt']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"20%\"><font color='black' size='2'>".$row['premium_end_dt']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"28%\"><font color='black' size='2'>".$row['tot_amt']."</font></td>";
$amt+=$row['tot_amt'];
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"6%\"><font color='black' size='2'>".$row['rcpt_no']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"20%\"><font color='black' size='2'>".$row['rcpt_date']."</font></td>";
echo"</tr>";
}
echo"</table>";
echo"</div>";
echo"</td></tr><tr bgcolor='silver'><td colspan=5 align='center'><b>Total Amount !!!</td><td colspan=5 width=\"14%\" align='right'><b>$amt";
echo"</td></tr></table>";
echo"</form></body>";



