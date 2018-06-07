<?
include "../config/config.php";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo"<head>";
echo"<title>customer mini frame</title>";
echo "<script src=\"../JS/loading2.js\">";
echo "</script>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo"</head>";

echo"<body bgcolor='grey'>";
$TCOLOR='#FFDEAD';
echo"<form  name='f1' action='sundry_ex_frm.php' method='post' >";
echo"<table valign=\"top\"width='110%' align='center'>";
$sql="select * from gl_ledger_dtl  where gl_mas_code in (select gl_mas_code from lc_mini_gl_master)";
$res=dBConnect($sql);
for($j=0;$j<pg_NumRows($res);$j++)
{
$row=pg_fetch_array($res,$j);
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
echo "<tr>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width='25%'><font color='black' size='2'>".$row['tran_id']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\" width='15%'><font color='black' size='2'>".$row['gl_mas_code']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\" width='21%'><font color='black' size='2'>".$row['amount']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\" width='15.9999999999%'><font color='black' size='2'>".$row['dr_cr']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width='26%'><font color='black' size='2'>".$row['particulars']."</font></td>";
echo"</tr>";
}
echo"</table></form></body>";
?>
