<?php
include "../config/config.php";
$status=$_REQUEST['status'];
$menu=$_REQUEST['menu'];
echo"<html>";
echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
$sql_statement="select as_on, asset_id, abs(at_the_rate) as rate, case when dep_method='re' then 'Reducing' when dep_method='st' then 'Straight' end dep_method, face_value, current_value cut_off_val, prev_dep_amount, case when (at_the_rate<0) then current_value-abs(prev_dep_amount) else current_value+abs(prev_dep_amount) end val_before_dep, abs(cur_dep_amount) cur_dep_val, case when (at_the_rate<0) then (current_value-abs(prev_dep_amount))-abs(cur_dep_amount) else (current_value+abs(prev_dep_amount))+abs(cur_dep_amount) end val_after_dep, cast(days as integer) days from yearly_dep_app_charging where as_on=(select max(as_on) from yearly_dep_app_charging )";
$result=dBConnect($sql_statement);
$row1=pg_fetch_array($result,0);
echo"<body bgcolor='silver'>";
echo "<table width=\"100%\">
<tr>";
//$color='lightblue';
echo"<th bgcolor='aqua' align='center' width =\"75\" colspan=\"11\"><font color='red'>DEPRECIATION/APPRECIATION REPORT AS ON ".$row1['as_on']." </th></tr><tr>
<td bgcolor=$color width =\"50\" Rowspan=\"1\"><font color=$fcolor>SL.No.</td>
<td bgcolor=$color width =\"75\" Rowspan=\"1\"><font color=$fcolor>Asset Id</td>
<td bgcolor=$color width =\"75\" Rowspan=\"1\"><font color=$fcolor>Rate in %</td>
<td bgcolor=$color width =\"75\" Rowspan=\"1\"><font color=$fcolor>Depreciation<br>/Appreciation Method</td>
<td bgcolor=$color width =\"75\" Rowspan=\"1\"><font color=$fcolor>Face Value</td>
<td bgcolor=$color width =\"75\" Rowspan=\"1\"><font color=$fcolor>Cut off Value</td>
<td bgcolor=$color width =\"75\" Rowspan=\"1\"><font color=$fcolor>Prev Depreciation<br>/Appreciation Amount</td>
<td bgcolor=$color width =\"75\" Rowspan=\"1\"><font color=$fcolor>Value Before Dep/App</td>
<td bgcolor=$color width =\"75\" Rowspan=\"1\"><font color=$fcolor>Current Dep/App Value</td>
<td bgcolor=$color width =\"75\" Rowspan=\"1\"><font color=$fcolor>Value After Dep/App</td>
<td bgcolor=$color width =\"75\" Rowspan=\"1\"><font color=$fcolor>Days</td>
</tr>";
//</table>";
echo"</body>";
echo"</html>";
if(pg_NumRows($result)==0) {
echo "<h4>RECORD Not found!!!</h4>";

} else {
$color==$TCOLOR;
for($j=0; $j<pg_NumRows($result); $j++) {
echo "<tr>";
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
echo "<td bgcolor=$color width =\"75\" Rowspan=\"1\"><font color=$fcolor>".($j+1)."</td>";
echo "<td bgcolor=$color width =\"75\" Rowspan=\"1\"><font color=$fcolor><a href=\"../assets/dep_link.php?menu=ast&asset_id=".$row['asset_id']."\" target= >".$row['asset_id']."</td>";
echo "<td bgcolor=$color width =\"75\" Rowspan=\"1\"><font color=$fcolor>".$row['rate']."</td>";
echo "<td bgcolor=$color width =\"75\" Rowspan=\"1\"><font color=$fcolor>".$row['dep_method']."</td>";
echo "<td bgcolor=$color width =\"75\" Rowspan=\"1\"><font color=$fcolor>".$row['face_value']."</td>";
echo "<td bgcolor=$color width =\"75\" Rowspan=\"1\"><font color=$fcolor>".$row['cut_off_val']."</td>";
echo "<td bgcolor=$color width =\"75\" Rowspan=\"1\"><font color=$fcolor>".$row['prev_dep_amount']."</td>";
echo "<td bgcolor=$color width =\"75\" Rowspan=\"1\"><font color=$fcolor>".$row['val_before_dep']."</td>";
echo "<td bgcolor=$color width =\"75\" Rowspan=\"1\"><font color=$fcolor>".$row['cur_dep_val']."</td>";
echo "<td bgcolor=$color width =\"75\" Rowspan=\"1\"><font color=$fcolor>".$row['val_after_dep']."</td>";
echo "<td bgcolor=$color width =\"75\" Rowspan=\"1\"><font color=$fcolor>".$row['days']."</td> </tr>";
$face_value+=$row['face_value'];
$cut_off_val+=$row['cut_off_val'];
$prev_dep_amount+=$row['prev_dep_amount'];
$val_before_dep+=$row['val_before_dep'];
$cur_dep_val+=$row['cur_dep_val'];
$val_after_dep+=$row['val_after_dep'];

}
echo "<tr bgcolor=\"AQUA\"><th colspan=\"4\">Total:  ".$j." Asset Item Found!!!!!<th align=\"left\">".amount2Rs($face_value)."<th align=\"left\">".amount2Rs($cut_off_val)."<th align=\"left\">".amount2Rs($prev_dep_amount)."<th align=\"left\">".amount2Rs($val_before_dep)."<th align=\"left\">".amount2Rs($cur_dep_val)."<th align=\"left\">".amount2Rs($val_after_dep)."<th align=\"left\">";

echo "</table>";}
?>
