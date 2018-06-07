<?php
include "../config/config.php";
$staff_id=verifyAutho();
$fy=$_SESSION['fy'];
$date=$_REQUEST['date'];
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo"<head>";
echo"<title>Risk Weighted Report</title>";
echo"</head>";
echo"<body bgcolor='silver'>";
echo"<table valign=\"top\"width='100%' align='center'>";
echo"<tr><th colspan='5' bgcolor='#EAE7E7'><font color='black' size='3'><b>Risk Weighted Report(General Ledger Wise) As On " .$date."</th></tr>";
echo"<tr><th bgcolor='grey' align='center'><font color='black' size='3'><b>Serial No.</th>";
//echo"<th bgcolor='grey' align='left'>GL Sub-Header Code</th>";
echo"<th bgcolor='grey' align='left'><font color='black' size='3'><b>Name OF Assets</th>";
echo"<th bgcolor='grey' align='right'><font color='black' size='3'><b>Balance</th>";
echo"<th bgcolor='grey' align='right'><font color='black' size='3'><b>% Of Risk Weight</th>";
echo"<th bgcolor='grey' align='right'><font color='black' size='3'><b>Risk Adjusted Value </th></tr>";
$sql="select risk_wht_gl_rpt(current_date,'refcursor')";
$sql.=";fetch all from refcursor";
//echo $sql;
$TCOLOR='#CACACA';
$TBGCOLOR='white';
$res=dBConnect($sql);
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
if($j<pg_NumRows($res)-1)
{
echo "<tr> ";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  ><font color='black' size='3'><b>".$row['srl']."</font></td>";
echo "<td  bgcolor='$color' align='left' colspan=\"1\" ><font color='black' size='3'><b>".$row['gl_dsc']."</b></font></td>";
echo"<td align='right' bgcolor='$color'><font color='black' size='3'><b>".$row['gl_bal']."</b></font></td>";
echo"<td align='right' bgcolor='$color'><font color='black' size='3'><b>".$row['prcnt']."</b></font></td>";
echo"<td align='right' bgcolor='$color'><font color='black' size='3'><b>".$row['rav']."</b></font></td>";
echo"</tr>";
}
else
{
echo "<tr> ";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  ><font color='black' size='3'><b>".$row['srl']."</b></font></td>";
echo "<td  bgcolor='$color' align='left' colspan=\"1\" ><font color='black' size='3'><b>".$row['gl_dsc']."</b></font></td>";
echo"<td align='right' bgcolor='$color'><font color='black' size='4'><b>".$row['gl_bal']."</b></font></td>";
echo"<td align='right' bgcolor='$color'><font color='black' size='3'><b>".$row['prcnt']."</b></font></td>";
echo"<td align='right' bgcolor='$color'><font color='black' size='4'><b>".$row['rav']."</b></font></td>";
echo"</tr>";
}
}
echo"</table></body>";
?>
