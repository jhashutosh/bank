<?
include "../config/config.php";
$sub_typ=$_REQUEST['sub_typ'];
$asst_mstr=$_REQUEST['asst_mstr'];
echo "<head>";
echo "<title>Asset Sub Type";
echo "</title>";;
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"table.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo"<table valign=\"top\" width='100%' align=\"center\" bgcolor='#839EB8' class='thead'>"; 
echo"<caption><font color='white' >Details Of $sub_typ</font></caption>";
//echo"<tr><th colspan='5' bgcolor='#0000CD' align='center' height='10%'><font color='white'></font></th></tr>";
echo"<tr><th align='center' width='10%'bgcolor='66CCFF' ><font color='000033'>Serial No.</font></th>";
echo"<th align='center' width='15%'bgcolor='66CCFF' ><font color='000033'>Asset Id</font></th>";
echo"<th align='center' width='30%'bgcolor='66CCFF' ><font color='000033'>Asset Description</font></th>";
echo"<th align='center' width='25%'bgcolor='66CCFF' ><font color='000033'>Face Value</font></th>";
echo"<th align='center' width='25%'bgcolor='66CCFF' ><font color='000033'>Current Value</font></th></tr>";
echo "<tr><td colspan=\"5\" align=center>";
//<iframe src=\"ast_sub_typ_frm.php?sub_typ=$sub_typ&asst_mstr=$asst_mstr\" width=\"100%\" height=\"200\" ></iframe>
//$sub_typ=$_REQUEST['sub_typ'];
//$asst_mstr=$_REQUEST['asst_mstr'];

echo"<table valign=\"top\"width='110%' align='center' class='report'>";
$color="#F0E68C";
$sql="select asset_ast_rpt('$sub_typ','refcursor')";
$sql.=";fetch all from refcursor";
echo $sql;
$res=dBConnect($sql);
$a=pg_NumRows($res)-1;
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
$aid=$row['ASSET ID'];
//echo $a;
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
if($j!=$a){
echo "<tr>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width='10%'><font color='black' size='2'>".$row['SRL']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width='15%'><font color='black' size='2'><a href=\"asset_id.php?aid=$aid&sub_typ=$sub_typ&asst_mstr=$asst_mstr\" onClick=\"window.open(this.href,'_child','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=250,left=150, width=1200,height=200'); return false;\">".$row['ASSET ID']."</a></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"25%\">".$row['initcap']."</td>";
echo"<td align='center' width='25%'bgcolor='$color'><font color='000033'>".$row['FACE VALUE']."</font></td>";
echo"<td align='center' width='25%'bgcolor='$color'><font color='000033'>".$row['CURRENT VALUE']."</font></td>";
echo"</tr>";
}
else{
echo "<tr>";
echo "<th  bgcolor='$color' align='center' colspan=\"1\"  width='10%'><font color='black' size='2'>".$row['SRL']."</font></th>";
//echo "<th  bgcolor='$color' align='center' colspan=\"1\"  width='15%'><font color='black' size='2'><a href=\"asset_id.php?aid=$aid&sub_typ=$sub_typ&asst_mstr=$asst_mstr\" onClick=\"window.open(this.href,'_child','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=250,left=180, width=1000,height=150'); return false;\">".$row['ASSET ID']."</a></th>";
echo "<th  bgcolor='$color' align='center' colspan=\"2\"  width=\"25%\">".$row['initcap']."</th>";
echo"<th align='center' width='25%'bgcolor='$color'><font color='000033'>".$row['FACE VALUE']."</font></th>";
echo"<th align='center' width='25%'bgcolor='$color'><font color='000033'>".$row['CURRENT VALUE']."</font></th>";
echo"</tr>";
}
}
echo"</table>";



echo "</td></tr>";
echo"<tr><td colspan='5' align='right'>
<input type='button' value='Back' onclick=\"window.open('asset_mstr_item.php?asst_mstr=$asst_mstr ','_parent','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=250,left=350, width=1000,height=400'); return false;\"></td></tr>";

echo"</table>";
echo"</body>";
?>
