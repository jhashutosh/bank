<?
include "../config/config.php";
$staff_id=verifyAutho();
$fy=$_SESSION['fy'];
$rat_nm=$_REQUEST['ratio_name'];
$amount=$_REQUEST['amount'];
$new=$rat_nm;
//echo $fy;
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo"<head>";
echo"<title>$rat_nm Report</title>";
echo"</head>";
echo"<body bgcolor='silver'>";
//echo "<div style=\"height:700px;overflow-y:auto\">";
echo"<table valign=\"top\"width='80%' align='center'>";
echo"<tr><th colspan='3' bgcolor='#EAE7E7'><font color='black' size='3'><B>Ratio Report of $rat_nm ($amount)For The Year(".$fy.")</B></font><button style='float:right'  value='Print' onclick='print()'>Print<button></th></th></tr>";
echo"<tr><th bgcolor='grey' align='left'><font color='black' size='3'><B>Header Desciption</B></th>";
echo"<th bgcolor='grey' align='right'><font color='black' size='3'><B>Total</B></th>";
echo"<th bgcolor='grey' align='right'><font color='black' size='3'><B>Airthmatic Operation</B></th></tr>";
$sql="select ratio_dtls_rpt('$rat_nm','refcursor')";
$sql.=";fetch all from refcursor";
echo $sql;
$TCOLOR='#CACACA';
$TBGCOLOR='white';
$res=dBConnect($sql);
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
echo "<tr> ";
if($row['drv']=='d')
{

echo "<td  bgcolor='$color' align='left' colspan=\"1\"  ><font color='black' size='3'><B><a href=\"ratio_dtl_rpt.php?amount=".$row['h_tot']."&ratio_name=".$row['h_dsc']."\" >".$row['h_dsc']."</a></B></font></td>";
echo "<td  bgcolor='$color' align='right' colspan=\"1\" ><font color='black' size='3'><B>".$row['h_tot']."</B></font></td>";
echo"<td align='right' bgcolor='$color'><font color='black' size='3'><B>".$row['asmd']."</B></font></td>";
}
else
{
$amp=$row['h_dsc'];
$amp=str_replace('&','|',$amp);
echo "<td  bgcolor='$color' align='left' colspan=\"1\"  ><font color='black' size='3'><B>
<a style='color:black' href=\"ratio_ldg_dtls.php?amount=".$row['h_tot']."&ratnm=$rat_nm&ratio_name=".$amp."\" >".$row['h_dsc']."</a></B></font></td>";
//echo "<td  bgcolor='$color' align='left' colspan=\"1\"  ><font color='black' size='3'><B><a style='color:black' href=\"ratio_ldg_dtls.php?ratio_name=".$row['h_dsc']."\" >".$row['h_dsc']."</a></B></font></td>";
echo "<td  bgcolor='$color' align='right' colspan=\"1\" ><font color='black' size='3'><B>".$row['h_tot']."</B></font></td>";
echo"<td align='right' bgcolor='$color'>		<font color='black' size='3'><B>".$row['asmd']."</B></font></td>";
}
echo"</tr>";


}
//echo"<tr><td colspan='3' align='right' ><a href=\"ratio_rpt.php?ratio_name=$rat_nm\" ><input type='button' value='Back'></td></tr>";

echo"</table>";
?>
<div align='center' style="display:block;margin-top:40px;background-color:transparent;height:40px;" valign=middle>
<center>
<a href="javascript:window.history.back();" style="background-color:#efefef;padding:7px;color:silver;float:both;border:solid 1px #000000"><font color='Black'>Backward</font></a>
<a href="javascript:window.history.forward();" style="background-color:#efefef;padding:7px;color:Silver;float:both;border:solid 1px #000000"><font color='Black'>Forward</font></a>
</center>
</div>
<?

echo "</body>";
?>
