<?
include "../config/config.php";
$asset_id=$_REQUEST['aid'];
$sub_typ=$_REQUEST['sub_typ'];
$asst_mstr=$_REQUEST['asst_mstr'];
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo"<head>";
echo"<title>Asset Details</title>";
echo"</head>";
echo"<body bgcolor='grey'>";
echo"<form  name='f1' action='ast_sub_typ_frm.php?op=i' method='post' >";
echo"<table valign=\"top\"width='100%' align='center'>";
$color="#F0E68C";
$sql="select asset_itm_rpt('$asset_id','refcursor')";
$sql.=";fetch all from refcursor";
//echo $sql;
$res=dBConnect($sql);
$a=pg_NumRows($res)-1;
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
//echo $a;
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
echo "<tr>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width='15%'><font color='black' size='2'>".$row['ASSET DESCRIPTION']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"15%\">".$row['PURCHASE DATE']."</td>";
echo"<td align='center' width='15%'bgcolor='$color'><font color='000033'>".$row['PURCHASE VALUE']."</font></td>";
echo"<td align='center' width='15%'bgcolor='$color'><font color='000033'>".$row['OPENING VALUE']."</font></td>";
if($row['TOTAL SALES']!=0)
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width='15%'><font color='black' size='2'><a href=\"asset_id_sale.php?aid=$asset_id&sub_typ=$sub_typ&asst_mstr=$asst_mstr\" onClick=\"window.open(this.href,'_child','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=250,left=350, width=1000,height=400'); return false;\">".$row['TOTAL SALES']."</a></td>";
else
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width='15%'>".$row['TOTAL SALES']."</a></td>";
if($row['TOTAL DEPRECIATION']!=0)
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width='15%'><font color='black' size='2'><a href=\"asset_id_dep.php?aid=$asset_id&sub_typ=$sub_typ&asst_mstr=$asst_mstr\" onClick=\"window.open(this.href,'_child','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=250,left=350, width=1000,height=400'); return false;\">".$row['TOTAL DEPRECIATION']."</a></td>";
else
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width='15%'>".$row['TOTAL DEPRECIATION']."</a></td>";

echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"10%\">".$row['CURRENT VALUE']."</td>";
echo"</tr>";
}
echo"</table></form></body>";
?>
