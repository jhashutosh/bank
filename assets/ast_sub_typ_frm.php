<?
include "../config/config.php";
$sub_typ=$_REQUEST['sub_typ'];
$asst_mstr=$_REQUEST['asst_mstr'];
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo"<head>";
echo"<title>ast_mstr_itm_frm</title>";
echo "<script src=\"../JS/loading2.js\">";
echo "</script>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo"</head>";

echo"<body bgcolor='grey'>";

echo"<form  name='f1' action='ast_sub_typ_frm.php?op=i' method='post' >";
echo"<table valign=\"top\"width='110%' align='center'>";
$color="#F0E68C";
$sql="select asset_ast_rpt('$sub_typ','refcursor')";
$sql.=";fetch all from refcursor";
//echo $sql;
$res=dBConnect($sql);
$a=pg_NumRows($res)-1;
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
$aid=$row['ASSET ID'];
//echo $a;
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
echo "<tr>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width='10%'><font color='black' size='2'>".$row['SRL']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width='15%'><font color='black' size='2'><a href=\"asset_id.php?aid=$aid&sub_typ=$sub_typ&asst_mstr=$asst_mstr\" onClick=\"window.open(this.href,'_child','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=250,left=350, width=1000,height=200'); return false;\">".$row['ASSET ID']."</a></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"25%\">".$row['initcap']."</td>";
echo"<td align='center' width='25%'bgcolor='$color'><font color='000033'>".$row['FACE VALUE']."</font></td>";
echo"<td align='center' width='25%'bgcolor='$color'><font color='000033'>".$row['CURRENT VALUE']."</font></td>";
echo"</tr>";
}
echo"</table></form></body>";
?>
