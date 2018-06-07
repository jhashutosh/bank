<?
include "../config/config.php";
$staff_id=verifyAutho();
$fy=$_SESSION['fy'];
$rat_nm=$_REQUEST['ratio_name'];
$new=$_REQUEST['new'];

echo $n;
//echo $new;
//echo $fy;
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo"<head>";
echo"<title>$rat_nm Report</title>";
echo"</head>";
echo"<body bgcolor='silver'>";
echo"<table valign=\"top\"width='80%' align='center'>";
echo"<tr><th colspan='3' bgcolor='#EAE7E7'><font color='black' size='3'><B>Ratio Report Of $rat_nm For The Year(".$fy.")</B></font></th></tr>";
echo"<tr><th bgcolor='grey' align='left'><font color='black' size='3'><B>Header Desciption</B></th>";
echo"<th bgcolor='grey' align='right'><font color='black' size='3'><B>Total</B></th>";
echo"<th bgcolor='grey' align='right'><font color='black' size='3'><B>Airthmatic Operation</B></th></tr>";


$sql="select ratio_dtls_rpt('$rat_nm','refcursor')";
$sql.=";fetch all from refcursor";




//echo $sql;
$TCOLOR='#CACACA';
$TBGCOLOR='white';
$res=dBConnect($sql);
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
echo "<tr> ";
$n=$row['h_dsc'];
if($row['drv']=='d')
{

echo "<td  bgcolor='$color' align='left' colspan=\"1\"  ><font color='black' size='3'><B><a href=\"ratio_dtl_rpt_nxt.php?ratio_name=".$row['h_dsc']."&new=$new\" >".$row['h_dsc']."</a></B></font></td>";
echo "<td  bgcolor='$color' align='right' colspan=\"1\" ><font color='black' size='3'><B>".$row['h_tot']."</B></font></td>";
echo"<td align='right' bgcolor='$color'><font color='black' size='3'><B>".$row['asmd']."</B></font></td>";
}
else
{
echo "<td  bgcolor='$color' align='left' colspan=\"1\"  ><font color='black' size='3'><B>".$row['h_dsc']."</B></font></td>";
echo "<td  bgcolor='$color' align='right' colspan=\"1\" ><font color='black' size='3'><B>".$row['h_tot']."</B></font></td>";
echo"<td align='right' bgcolor='$color'><font color='black' size='3'><B>".$row['asmd']."</B></font></td>";
}
echo"</tr>";


}

echo"<tr><td colspan='3' align='right' ><a href=\"ratio_dtl_rpt.php?ratio_name=$new\" ><input type='button' value='Back'></a></td></tr>";

echo"</table></body>";
?>
