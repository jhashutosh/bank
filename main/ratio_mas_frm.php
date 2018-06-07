<?php
include "../config/config.php";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo"<head>";
echo"<title></title>";
echo"</head>";

echo"<body bgcolor='grey'>";

echo"<form  name='f1' action='ratio_mas_frm.php?op=i' method='post' >";
echo"<table valign=\"top\"width='110%' align='center'>";
$TBGCOLOR="#D1FDF7";
$TCOLOR="white";
$sql="Select * From ratio_level";
//echo $sql;
$res=dBConnect($sql);
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
if($row['amt_prcnt']==0)
{
	$amt_prcnt='Amount';
}
else
{
	$amt_prcnt='Percent';
}
if($row['derived']==0)
{
	$derived='No';
}
else
{
	$derived='Yes';
}
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
echo "<tr>";
echo"<td align='center' width='10%'bgcolor='$color'>".$row['id']."</td>";
echo"<td align='center' width='20%'bgcolor='$color'>".$row['ratio_name']."</td>";
echo"<td align='center' width='20%'bgcolor='$color'>$amt_prcnt</td>";
echo"<td align='center' width='10%'bgcolor='$color'>$derived</td>";
echo"</tr>";
}
echo"</table></form></body>";
?>

