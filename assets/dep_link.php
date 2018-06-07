<?php
include "../config/config.php";
//$staff_id=verifyAutho();
$time=date('d/m/Y H:i:s ');
$menu=$_REQUEST['menu'];
$op=$_REQUEST['op'];
$asset_id=$_REQUEST['asset_id'];
echo "<html>";
echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
$sql_statement="select as_on, abs(at_the_rate) rate, case when dep_method='re' then 'Reducing' when dep_method='st' then 'Straight' end dep_method, face_value, current_value cut_off_val, prev_dep_amount, case when (at_the_rate<0) then current_value-abs(prev_dep_amount) else current_value+abs(prev_dep_amount) end val_before_dep, abs(cur_dep_amount) cur_dep_val, case when (at_the_rate<0) then (current_value-abs(prev_dep_amount))-abs(cur_dep_amount) else (current_value+abs(prev_dep_amount))+abs(cur_dep_amount) end val_after_dep, cast(days as integer) days from yearly_dep_app_charging where asset_id='$asset_id' order by as_on desc";
$result=dBConnect($sql_statement);
//echo $sql_statement;
echo"</head><body bgcolor='black'>";
//echo "<Table bgcolor=\"Black\" width=\"100%\" >";
  if(pg_NumRows($result)>0)
	{
echo "<table width=\"100%\">
<tr>";
//$color='lightblue';
echo"<th bgcolor='aqua' align='center' width =\"75\" colspan=\"11\"><font color='red'>INDIVIDUAL ASSET DEPRECIATION/APPRECIATION REPORT of     ".$asset_id." </th></tr><tr>
<td bgcolor=$color width =\"50\" Rowspan=\"1\"><font color=$fcolor>SL.No.</td>
<td bgcolor=$color width =\"75\" Rowspan=\"1\"><font color=$fcolor>As on</td>
<td bgcolor=$color width =\"75\" Rowspan=\"1\"><font color=$fcolor>Rate in %</td>
<td bgcolor=$color width =\"75\" Rowspan=\"1\"><font color=$fcolor>Depreciation/Appreciation Method</td>
<td bgcolor=$color width =\"75\" Rowspan=\"1\"><font color=$fcolor>Face Value</td>
<td bgcolor=$color width =\"75\" Rowspan=\"1\"><font color=$fcolor>Cut off Value</td>
<td bgcolor=$color width =\"75\" Rowspan=\"1\"><font color=$fcolor>Prev Depreciation/Appreciation Amount</td>
<td bgcolor=$color width =\"75\" Rowspan=\"1\"><font color=$fcolor>Value Before Dep/App</td>
<td bgcolor=$color width =\"75\" Rowspan=\"1\"><font color=$fcolor>Current Dep/App Value</td>
<td bgcolor=$color width =\"75\" Rowspan=\"1\"><font color=$fcolor>Value After Dep/App</td>
<td bgcolor=$color width =\"75\" Rowspan=\"1\"><font color=$fcolor>Days</td>
</tr>";
for($j=0; $j<pg_NumRows($result); $j++) {
echo "<tr>";
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
echo "<td bgcolor=$color width =\"75\" Rowspan=\"1\"><font color=$fcolor>".($j+1)."</td>";
echo "<td bgcolor=$color width =\"75\" Rowspan=\"1\"><font color=$fcolor>".$row['as_on']."</td>";
echo "<td bgcolor=$color width =\"75\" Rowspan=\"1\"><font color=$fcolor>".$row['rate']."</td>";
echo "<td bgcolor=$color width =\"75\" Rowspan=\"1\"><font color=$fcolor>".$row['dep_method']."</td>";
echo "<td bgcolor=$color width =\"75\" Rowspan=\"1\"><font color=$fcolor>".$row['face_value']."</td>";
echo "<td bgcolor=$color width =\"75\" Rowspan=\"1\"><font color=$fcolor>".$row['cut_off_val']."</td>";
echo "<td bgcolor=$color width =\"75\" Rowspan=\"1\"><font color=$fcolor>".$row['prev_dep_amount']."</td>";
echo "<td bgcolor=$color width =\"75\" Rowspan=\"1\"><font color=$fcolor>".$row['val_before_dep']."</td>";
echo "<td bgcolor=$color width =\"75\" Rowspan=\"1\"><font color=$fcolor>".$row['cur_dep_val']."</td>";
echo "<td bgcolor=$color width =\"75\" Rowspan=\"1\"><font color=$fcolor>".$row['val_after_dep']."</td>";
echo "<td bgcolor=$color width =\"75\" Rowspan=\"1\"><font color=$fcolor>".$row['days']."</td> </tr>";
}
echo"<tr><form action='report.php' method='post'><td colspan='11' align='right'><input type='submit' value='go back'><form></tr>";
echo"</table>";
}
echo "</body>";
echo "</html>";
?>

