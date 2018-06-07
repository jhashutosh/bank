<?
include "../config/config.php";
$staff_id=verifyAutho();
$value=$_REQUEST['value'];
$heading=$_REQUEST['heading'];
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo"<head>";
echo"<title>$heading</title>";
echo"</head>";
echo"<body bgcolor='silver'>";
echo"<table valign=\"top\"width='100%' align='center'>";
$sql=" select coding_rpt('$value','refcursor')";
$sql.=";fetch all from refcursor";
//echo $sql;
$TCOLOR='#D5E9EC';
$TBGCOLOR='white';
$res=dBConnect($sql);
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
$uni=$row['lvl'];
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
if($uni=='top')
{}
 else if($uni=='header'){
echo "<tr> ";
echo "<td  bgcolor='$color' align='center' colspan=\"1\" width='9%'><font color='green' size='4'><b>".$row['code']."</b></font></td>";
echo"<td align='left' bgcolor='$color' width='52%'><font color='green'size='4'><b>".$row['nm']."</b></font></td>";
echo"<td align='right' bgcolor='$color' width='21%'><font color='green' size='4'><b>".$row['amt_cr']."</b></font></td>";
echo"<td align='right' bgcolor='$color' width='19%'><font color='green' size='4'><b>".$row['amt_pv']."</b></font></td>";
echo"</tr>";
}
else if($uni=='sub header'){
echo "<tr> ";
echo "<td  bgcolor='$color' align='center' colspan=\"1\" width='9%'><font color='red' size='3'><b>".$row['code']."</b></font></td>";
echo"<td align='left' bgcolor='$color' width='52%'><font color='red'size='3'><b>".$row['nm']."</b></font></td>";
echo"<td align='right' bgcolor='$color' width='21%'><font color='red' size='3'><b>".$row['amt_cr']."</b></font></td>";
echo"<td align='right' bgcolor='$color' width='19%'><font color='red' size='3'><b>".$row['amt_pv']."</b></font></td>";
echo"</tr>";
}
else
{
echo "<tr> ";
echo "<td  bgcolor='$color' align='center' colspan=\"1\" width='9%'><font color='black' size='2'><b>".$row['code']."</b></font></td>";
echo"<td align='left' bgcolor='$color' width='52%'><font color='black'><b>".$row['nm']."</b></font></td>";
echo"<td align='right' bgcolor='$color' width='21%'><font color='black'><b>".$row['amt_cr']."</b></font></td>";
echo"<td align='right' bgcolor='$color' width='19%'><font color='black'><b>".$row['amt_pv']."</b></font></td>";
echo"</tr>";
}
}
echo"</table></body>";
?>
