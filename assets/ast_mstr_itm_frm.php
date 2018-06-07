<?
include "../config/config.php";
$asst_mstr=$_REQUEST['asst_mstr'];
$sub_typ=$_REQUEST['sub_typ'];
//echo $asst_mstr;
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo"<head>";
echo"<title>ast_mstr_itm_frm</title>";
echo"</head>";

echo"<body bgcolor='grey'>";

echo"<table valign=\"top\"width='110%' align='center'>";
$color="#F0E68C";
$sql="select asset_subtyp_rpt('$asst_mstr','refcursor')";
$sql.=";fetch all from refcursor";
//echo $sql;
$res=dBConnect($sql);
$a=pg_NumRows($res)-1;
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
echo "<tr>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width='15%'>".$row['SRL'];
if($j==$a){
	echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"25%\">".$row['ASSET SUB TYPE']."</td>";

}
else
{
$sub_typ=$row['ASSET SUB TYPE'];
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"35%\"><a href=\"asst_sub_typ.php?sub_typ=$sub_typ&asst_mstr=$asst_mstr\" onClick=\"window.open(this.href,'_child','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=250,left=350, width=1000,height=400'); return false;\">".$row['ASSET SUB TYPE']."</a></td>";
//<a href='asst_sub_typ.php?sub_typ=".$row['ASSET SUB TYPE']."' onClick=\"window.open(this.href,'_child','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=150,left=120, width=1100,height=650'); return false;\"> ".$row['ASSET SUB TYPE'];
}
echo"<td align='center' width='25%'bgcolor='$color'>".$row['NO. OF ITEM(S)'];
echo"<td align='center' width='25%'bgcolor='$color'>".$row['TOTAL CURRENT VALUE']."</td>";
echo"</tr>";
}//*/
echo"</table></form></body>";
?>

