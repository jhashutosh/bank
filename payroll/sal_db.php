<?
include "../config/config.php";
echo "<HTML>";
echo"<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo"</head>";
echo "<BODY bgcolor=\"#B1B1B1\">";
$sql_statement="select * from emp_sal_param";
//echo $sql_statement;
$TBGCOLOR="WHITE";
$TCOLOR="grey";
$FCOLOR="WHITE";
$FBCOLOR="grey";
echo"<table width='100%' align='center'>";
$result=dBConnect($sql_statement);
for($j=0;$j<pg_NumRows($result);$j++){
$row=pg_fetch_array($result,$j);
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$fcolor=($fcolor==$FCOLOR)?$FBCOLOR:$FCOLOR;
echo"<tr>";
echo"<td width='10%' bgcolor='$color' align='center'><font color='$fcolor'>".$row['da1']."%";
echo"<td width='9%' bgcolor='$color'><font color='$fcolor'>".$row['hra1']."%";
echo"<td width='9%' bgcolor='$color'><font color='$fcolor'>".$row['ma1']." Rs";
echo"<td width='14%' align='center' bgcolor='$color'><font color='$fcolor'>".$row['emplee_cont_pf1']."%";
echo"<td width='14%' align='center' bgcolor='$color'><font color='$fcolor'>".$row['empl_cont_pf1']."%";
echo"<td width='15%' align='center' bgcolor='$color'><font color='$fcolor'>".$row['puja_bonus']."%";
echo"<td width='10%' align='center' bgcolor='$color'><font color='$fcolor'>".$month_array[$row['puja_bonus_month']];
echo"<td width='15%' align='center' bgcolor='$color'><font color='$fcolor'>".$row['effected_from'];
echo"</tr>";
}
echo"</table>";
echo "</body>";
echo "</HTML>";
?>
