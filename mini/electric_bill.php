<?
include "../config/config.php";
$staff_id=verifyAutho();
$fy=$_SESSION['fy'];
function link_mnth($mnth,$mini,$id,$x){
if(empty($mnth))
echo"<a href=\"electric_bill_pay.php?mnth=$x&mini=$mini&id=$id\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=150,left=350, width=450,height=180'); return false;\">Amount ?</a>";
		}
echo "<head>";
echo "<title>Electric Bill</title>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo"<table width='100%' align='center'>";
echo"<tr><th bgcolor='#3B4444' colspan='14'><font color='white' size='4'>Electric Bill</font></th></tr>";
echo"<tr>";
echo "<th bgcolor='#3B4444' width=\"6%\"><font color='white' size='2'>Mini Name</font></th>";
echo "<th bgcolor='#3B4444' width=\"7%\"><font color='white' size='2'>April</font></th>";
echo "<th bgcolor='#3B4444' width=\"7%\"><font color='white' size='2'>May</font></th>";
echo "<th bgcolor='#3B4444' width=\"7%\"><font color='white' size='2'>June</font></th>";
echo "<th bgcolor='#3B4444' width=\"7%\"><font color='white' size='2'>July</font></th>";
echo "<th bgcolor='#3B4444' width=\"7%\"><font color='white' size='2'>August</font></th>";
echo "<th bgcolor='#3B4444' width=\"7%\"><font color='white' size='2'>September</font></th>";
echo "<th bgcolor='#3B4444' width=\"7%\"><font color='white' size='2'>October</font></th>";
echo "<th bgcolor='#3B4444' width=\"7%\"><font color='white' size='2'>November</font></th>";
echo "<th bgcolor='#3B4444' width=\"7%\"><font color='white' size='2'>December</font></th>";
echo "<th bgcolor='#3B4444' width=\"7%\"><font color='white' size='2'>January</font></th>";
echo "<th bgcolor='#3B4444' width=\"7%\"><font color='white' size='2'>February</font></th>";
echo "<th bgcolor='#3B4444' width=\"7%\"><font color='white' size='2'>March</font></th>";
echo "<th bgcolor='#3B4444' width=\"10%\"><font color='white' size='2'>Total</font></th></tr>";
echo"<tr><td colspan=\"14\" align=center>";
echo "<div style=\"overflow-y:auto;height:400px\"><table width='100%'>";
$sql="select lm.mini_name,lm.id,eb.* from lc_mini_master lm left outer join electric_bill eb on lm.id=eb.mini_id";
//echo $sql;
$TCOLOR='#B7C2CF';
$TBGCOLOR='white';
$res=dBConnect($sql);
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
echo "<tr> ";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width='5%'><font color='black' size='2'>".$row['mini_name']."</font></td>";

echo"<td align='center' width='7%' bgcolor='$color'><font color='000033'>";
link_mnth($row['apr'],$row['mini_name'],$row['id'],"apr");
echo $row['apr']."</font></td>";

$apr_amt+=$row['apr'];

echo"<td align='center' width='7%' bgcolor='$color'><font color='000033'>";
link_mnth($row['may'],$row['mini_name'],$row['id'],"may");
echo $row['may']."</font></td>";

$may_amt+=$row['may'];

echo"<td align='center' width='7%' bgcolor='$color'><font color='000033'>";
link_mnth($row['june'],$row['mini_name'],$row['id'],"june");
echo $row['june']."</font></td>";

$june_amt+=$row['june'];

echo"<td align='center' width='7%'bgcolor='$color'><font color='000033'>";
link_mnth($row['july'],$row['mini_name'],$row['id'],"july");
echo $row['july']."</font></td>";

$july_amt+=$row['july'];

echo"<td align='center' width='7%'bgcolor='$color'><font color='000033'>";
link_mnth($row['aug'],$row['mini_name'],$row['id'],"aug");
echo $row['aug']."</font></td>";


$aug_amt+=$row['aug'];

echo"<td align='center' width='7%'bgcolor='$color'><font color='000033'>";
link_mnth($row['sept'],$row['mini_name'],$row['id'],"sept");
echo $row['sept']."</font></td>";

$sept_amt+=$row['sept'];

echo"<td align='center' width='7%'bgcolor='$color'><font color='000033'>";
link_mnth($row['oct'],$row['mini_name'],$row['id'],"oct");
echo $row['oct']."</font></td>";

$oct_amt+=$row['oct'];

echo"<td align='center' width='7%'bgcolor='$color'><font color='000033'>";
link_mnth($row['nov'],$row['mini_name'],$row['id'],"nov");
echo $row['nov']."</font></td>";

$nov_amt+=$row['nov'];

echo"<td align='center' width='7%'bgcolor='$color'><font color='000033'>";
link_mnth($row['dec'],$row['mini_name'],$row['id'],"dec");
echo $row['dec']."</font></td>";

$dec_amt+=$row['dec'];

echo "<td  bgcolor='$color' align='center' colspan=\"1\" width='6%'><font color='000033'>";
link_mnth($row['jan'],$row['mini_name'],$row['id'],"jan");
echo $row['jan']."</font></td>";
$jan_amt+=$row['jan'];
echo"<td align='center' width='7%'bgcolor='$color' style='height:30px;'><font color='000033'>";
link_mnth($row['feb'],$row['mini_name'],$row['id'],"feb");
echo $row['feb']."</font></td>";

$feb_amt+=$row['feb'];

echo"<td align='center' width='7%' bgcolor='$color'><font color='000033'>";
link_mnth($row['mar'],$row['mini_name'],$row['id'],"mar");
echo $row['mar']."</font></td>";

$mar_amt+=$row['mar'];

$total=$row['jan']+$row['feb']+$row['mar']+$row['apr']+$row['may']+$row['july']+$row['aug']+$row['oct']+$row['nov']+$row['dec'];
$total1+=$total;

echo"<td align='center' width='10%'bgcolor='$color'><font color='000033'>".amount2Rs($total)."</font></td>";
echo"</tr>";}
echo"</table></div>";
echo"</td></tr>";
echo"<tr bgcolor='white'><td>Total</td><td align='right'>".amount2Rs($jan_amt)."</td><td align='right'>".amount2Rs($feb_amt)."</td><td align='right'>".amount2Rs($mar_amt)."</td><td align='right'>".amount2Rs($apr_amt)."</td><td align='right'>".amount2Rs($may_amt)."</td><td align='right'>".amount2Rs($june_amt)."</td><td align='right'>".amount2Rs($july_amt)."</td><td align='right'>".amount2Rs($aug_amt)."</td><td align='right'>".amount2Rs($sept_amt)."</td><td align='right'>".amount2Rs($oct_amt)."</td><td align='right'>".amount2Rs($nov_amt)."</td><td align='right'>".amount2Rs($dec_amt)."</td><td align='right'>".amount2Rs($total1)."</td></tr>";
echo"</table>";
echo "</form>";
echo "</body>";
?>

