<?php
include "../config/config.php";
$year=$_REQUEST['yy'];
$mnth=$_REQUEST['mm'];
$ym=$year.$mnth;
$sql1="select to_char(to_timestamp(to_char(cast(substr(year_month,5)as integer),'99999'),'MM'),'MONTH') as month from emp_sal_reg where year_month like '$ym' "; 
$result2=dBConnect($sql1);
$row2=pg_fetch_array($result2,0);
$mon=$row2['month'];
echo "<HTML>";
echo "<HEAD>";
echo "<title>Salary Register Statement";
echo "</title>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</HEAD>";
echo "<body bgcolor='silver'>";
echo"<form name='f1' action='sal_reg_report.php' metdod='post'>";
echo"<table width='100%' align='center' bgcolor='black'>";
echo "<td colspan=\"16\" BGCOLOR=\"#cc6633\" ALIGN=\"Center\">Salary Register Details</td>";
echo "<tr>";
echo"<tr><td colspan='4' align='right' bgcolor='black'><font color='white'>Select Year</td><td><font color='white'>:</td><td colspan='3' bgcolor='black'><select name='yy'>";
$dd_sql=" select substr(fy,1,4) yr from fy_list union select substr(fy,6) yr from fy_list";
$dd_res=dBConnect($dd_sql);
for($j=0; $j<pg_NumRows($dd_res); $j++){
$r=pg_fetch_array($dd_res,$j);
echo"<option value='".$r['yr']."'>".$r['yr']."</option>";}
echo"</select></td>";
echo"<td colspan='4' align='right' bgcolor='black'><font color='white'>Select Month</font></td><td bgcolor='black'><font color='white'>:</td><td colspan='3' bgcolor='black'></select>
<select name='mm'>
<option value='01'>JAN</option>
<option value='02'>FEB</option>
<option value='03'>MAR</option>
<option value='04'>APR</option>
<option value='05'>MAY</option>
<option value='06'>JUN</option>
<option value='07'>JUL</option>
<option value='08'>AUG</option>
<option value='09'>SEP</option>
<option value='10'>OCT</option>
<option value='11'>NOV</option>
<option value='12'>DEC</option>
</select></td></tr>";
//echo"<tr><td align='center' colspan='16'></td></tr>";
//echo"<tr><td align='center' colspan='16'></td></tr>";
echo"<tr><td align='center' colspan='16'></td></tr>";
echo"<tr><td align='center' colspan='16'></td></tr>";
echo"<tr><td align='center' colspan='16'><input type='submit' value='confirm'></td></tr>";
//echo"<tr><td align='center' colspan='16'><font color='lightyellow'>Salary Register Details for &nbsp;&nbsp; $mon &nbsp;&nbsp;&nbsp;$year</td></tr>";
/*echo "<tr>";
$color="lightgreen";
echo "<h5><td bgcolor=$color  align='center' width='3%'>Id</td></h5>";
echo "<h5><td bgcolor=$color  align='center' width='12%'>Name</td></h5>";                       
echo "<h5><td bgcolor=$color  align='center' width='7%'>Basic</td></h5>";
echo "<h5><td bgcolor=$color  align='center' width='6%'>HRA</td></h5>";
echo "<h5><td bgcolor=$color  align='center' width='6%'>DA</td></h5>";
echo "<h5><td bgcolor=$color  align='center' width='6%'>CA</td></h5>";
echo "<h5><td bgcolor=$color  align='center' width='6%'>MA</td></h5>";
echo "<h5><td bgcolor=$color  align='center' width='6%'>Total Earning</td></h5>";
echo "<h5><td bgcolor=$color  align='center' width='7%'>Employer Cont PF</td></h5>";
echo "<h5><td bgcolor=$color  align='center' width='7%'>Employee Cont PF</td></h5>";
echo "<h5><td bgcolor=$color align='center'  width='6%'>Ptax</td></h5>";
echo "<h5><td bgcolor=$color  align='center' width='6%'>Itax</td></h5>";
echo "<h5><td bgcolor=$color  align='center' width='6%'>Total Deduction</td></h5>";
echo "<h5><td bgcolor=$color  align='center' width='6%'>Gross Sal</td></h5>";
echo "<h5><td bgcolor=$color  align='center'  width='6%'>Net Sal</td></h5>";
echo "</tr>";
echo "<tr><td colspan=\"16\" align=center><iframe src=\"sal_reg_report.php?ym=$ym\" width=\"100%\" height=\"200\" ></iframe>";
*/
echo"</table></form></body></html>";
?>
