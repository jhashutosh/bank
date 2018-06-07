<?
include "../config/config.php";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo"<head>";
echo"<title>framer frame</title>";
echo "<script src=\"../JS/loading2.js\">";
echo "</script>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo"</head>";
$TBGCOLOR="WHITE";
$TCOLOR="#839EB8'";
echo"<body bgcolor='lightyellow'>";
echo"<table valign=\"top\"width='100%' align='center'>";
$sql="SELECT foo.paid ,foo.due,initcap(om.operator_name) as name,om.address,om.id FROM(
select sum(osd.paid_amt) as paid ,sum(osd.due_amt) as due,osd.id_mini_operator_link,mol.id_operator_master/*,om.operator_name,om.address,om.id */
from LC_Mini_Operator_Link mol,lc_operator_salary_details osd
where osd.id_mini_operator_link=mol.id
group by osd.id_mini_operator_link,mol.id_operator_master) as foo,LC_Operator_Master om
WHERE foo.id_operator_master=om.id
order by om.id;
";
$res=dBConnect($sql);
//echo $sql;
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$id=$row['id'];
echo "<tr>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width='10%'><font color='black' size='2'>".$row['id']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\" width='25%'><font color='black' size='2'>".$row['name']."</font></td>";
echo"<td align='center' width='25%'bgcolor='$color'><font color='000033'>".$row['address']."</font></td>";
echo"<td align='center' width='15%'bgcolor='$color'><font color='000033'>".$row['paid']."</font></td>";
if($row['due']>0)
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"25%\"><a href=\"paymnt_link.php?c=".$row['id']."&name=".$row['name']."&mini_id=".$row['id_mini_master']."\" target=_parent onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=150,left=120, width=1100,height=650'); color='red' return false;\">".$row['due']."</td>";
else
echo"<td align='center' width='25%'bgcolor='$color'><font color='green'>Fully Paid</font></td>";
echo"</tr>";
}
echo"</table></form></body>";
?>

