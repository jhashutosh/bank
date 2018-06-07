<?
include "../config/config.php";
$staff_id==verifyAutho();
$mdate=$_REQUEST['mdate'];
if(empty($mdate)){$mdate=date('d.m.Y');}
$sql_statement1="SELECT substr(fy,6) as close,substr(fy,1,4) as start from fy_list order by fy desc ";
$result1=dBConnect($sql_statement1);
$name1=pg_fetch_array($result1,0);
$total=0;
//echo $name1['start'];
echo "<html>";
echo "<head>";
echo "<title>$PROJECT_TITLE</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"black\" onload=\"cd.focus();\">";
echo"<h3 align=center><font color=\"white\">YEARLY SALARY PAID</font></h3>";
echo "<table align=center bgcolor='silver' width='40%'>";
echo "<tr><td bgcolor=\"#0000CD\" colspan=\"3\" align=\"center\"><b><font color=\"WHITE\">Total Salary Paid For The Month OF April ".$name1['start']." to March".$name1['close']."  </font>";
echo "<tr>";
echo "<th bgcolor=\"#9ACD32\">MONTH</th>";
echo "<th bgcolor=\"#9ACD32\" >TOTAL SALARY PAID</th></tr>";
$sql_statement="select substr(year_month,1,4) as year ,substr(year_month,5,2) as month, initcap(to_char(to_timestamp(substr(year_month,5,2),'mm'),'month')) as monthname,sum(gross_sal) from emp_sal_reg
 group by substr(year_month,1,4),substr(year_month,5,2),initcap(to_char(to_timestamp(substr(year_month,5,2),'mm'),'month')) 
  order by substr(year_month,1,4),substr(year_month,5,2),initcap(to_char(to_timestamp(substr(year_month,5,2),'mm'),'month'))";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
for($j=0;$j<pg_NumRows($result); $j++){
$row=pg_fetch_array($result,$j);
$total=$total+$row['sum'];
echo "<tr>";
echo "<td bgcolor='white'>".$row['monthname']."&nbsp; ".$row['year']."</td><td align=center bgcolor='white'><A HREF=\"salary_payment.php?yr=".$row['year']."&month=".$row['month']."&mname=".$row['monthname']."\">".$row['sum']."</A></td></tr>";

   }
}
echo "<tr><td bgcolor=\"66CCFF\">Total</td>";
echo "<td bgcolor=\"66CCFF\" align='center' >$total</td></tr>";
echo "</table>";
echo "</body>";
echo "</html>";
?>
