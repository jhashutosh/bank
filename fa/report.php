<?
include "../config/config.php";
$staff_id=verifyAutho();
$value=$_REQUEST['value'];
$heading=$_REQUEST['heading'];
echo "<head>";
echo "<title>$heading";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo"<table valign=\"top\" width='100%' align=\"center\" bgcolor='#839EB8'>"; 
echo"<tr><th colspan='4' bgcolor='grey' align='center'><font color='black'><font size='5'>STANDRAD HEAD OF $heading FOR PACS</font></td></tr><tr>";
echo"<th align='center' bgcolor='white' width='10%'><font color='black' size='4'>CODE</font></th>";
echo"<th align='left' bgcolor='white' width='50%'><font color='black' size='4'>HEAD OF ACCOUNT</font></th>";
echo"<th align='right' bgcolor='white' width='20%'><font color='black' size='4'>CURRENT YEAR AMOUNT(Rs)</font></th>";
echo"<th align='right' bgcolor='white' width='20%'><font color='black' size='4'>PREVIOUS YEAR AMOUNT(Rs)</font></th></tr>";
$sql=" select coding_rpt('$value','refcursor')";
$sql.=";fetch all from refcursor";
//echo $sql;
$color='grey';
$res=dBConnect($sql);
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
$uni=$row['lvl'];
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
if($uni=='top'){
echo "<tr> ";
echo "<td  bgcolor='$color' align='center' colspan=\"1\" width='10%'><font color='Blue' size='5'><b>".$row['code']."</b></font></td>";
echo"<td align='left' bgcolor='$color' width='50%'><font color='Blue'size='5' ><b>".$row['nm']."</b></font></td>";
echo"<td align='right' bgcolor='$color' width='20%'><font color='Blue' size='5'><b>".$row['amt_cr']."</b></font></td>";
echo"<td align='right' bgcolor='$color' width='20%'><font color='Blue' size='5'><b>".$row['amt_pv']."</b></font></td>";
echo"</tr>";
}
}
echo "<tr><td colspan=\"4\" align=center><iframe src=\"liabilities_new.php?value=$value&heading=$heading\" width=\"100%\" height=\"520\" ></iframe></td></tr>";
echo"</table>";
echo"</body>";
?>

