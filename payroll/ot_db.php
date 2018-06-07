<?
include "../config/config.php";
echo "<HTML>";
echo"<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo"</head>";
echo "<BODY bgcolor=\"white\">";
$sql_statement="select a.name,b.emp_id,substr(b.year_month,1,4) as year,replace(substr(b.year_month,5),'0','') as month,b.ot_days,b.ot_per_day,b.ot_payment from emp_overtime_dtl b,emp_master a where a.emp_id=b.emp_id";
//echo $sql_statement;
$TBGCOLOR="WHITE";
$TCOLOR="#6FACC9";
$FCOLOR="WHITE";
$FBCOLOR="#839EB8";
echo"<table width='100%' align='center'>";
$result=dBConnect($sql_statement);
for($j=0;$j<pg_NumRows($result);$j++){
$row=pg_fetch_array($result,$j);
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$fcolor=($fcolor==$FCOLOR)?$FBCOLOR:$FCOLOR;
echo"<tr>";
echo"<td width='10%' bgcolor='$color' align='center'><font color='$fcolor'>".$row['emp_id'];
echo"<td width='12%' bgcolor='$color'><font color='$fcolor'>".$row['name'];
echo"<td width='13%' align='center' bgcolor='$color'><font color='$fcolor'>".$row['year'].",".$month_array[$row['month']];
echo"<td width='13%' align='center' bgcolor='$color'><font color='$fcolor'>".$row['ot_days'];
echo"<td width='15%' align='center' bgcolor='$color'><font color='$fcolor'>".$row['ot_per_day'];
echo"<td width='15%' align='center' bgcolor='$color'><font color='$fcolor'>".$row['ot_payment'];
echo"</tr>";
}
echo"</table>";
echo "</body>";
echo "</HTML>";
?>
