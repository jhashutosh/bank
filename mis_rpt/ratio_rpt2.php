<?
include "../config/config.php";
$staff_id=verifyAutho();
$fy=$_SESSION['fy'];
//echo $fy;
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo"<head>";
echo"<title>Ratio Report</title>";
echo"</head>";
echo"<body bgcolor='silver'>";
echo"<table valign=\"top\"width='80%' align='center'>";
echo"<tr><th colspan='3' bgcolor='#EAE7E7'><font color='black' size='3'><B>Ratio Report For The Year(".$fy.")</B></font></th></tr>";
echo"<tr><th bgcolor='grey' align='center'><font color='black' size='3'><B>Serial No.</B></th>";
echo"<th bgcolor='grey' align='left'><font color='black' size='3'><B>Ratio Name</B></th>";
echo"<th bgcolor='grey' align='right'><font color='black' size='3'><B>Ratio Amount</B></th></tr>";
$sql="select ratio_rpt('refcursor')";
$sql.=";fetch all from refcursor";
//echo $sql;
$TCOLOR='#CACACA';
$TBGCOLOR='white';
$res=dBConnect($sql);
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
if($j<pg_NumRows($res)-1){
echo "<tr> ";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  ><font color='black' size='3'><B>".$row['srl']."</B></font></td>";
echo "<td  bgcolor='$color' align='left' colspan=\"1\" ><font color='black' size='3'><B>".$row['ratio_name']."</B></font></td>";
echo"<td align='right' bgcolor='$color'><font color='black' size='3'><B>".$row['ratio_amt']."</B></font></td>";
echo"</tr>";
}
else
{
echo "<tr> ";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  ><font color='black' size='3'><B>".$row['srl']."</B></font></td>";
echo "<td  bgcolor='$color' align='left' colspan=\"1\" ><font color='black' size='3'><b>".$row['ratio_name']."</b></font></td>";
echo"<td align='right' bgcolor='$color'><font color='black' size='3'><b>".$row['ratio_amt']."</b></font></td>";
echo"</tr>";
}
}

echo"</table></body>";
?>
