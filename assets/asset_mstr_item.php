<?
include "../config/config.php";
$asst_mstr=$_REQUEST['asst_mstr'];
$sub_typ=$_REQUEST['sub_typ'];
echo "<head>";
echo "<title>Asset Master Items ";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"table.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo"<table valign=\"top\" width='100%' align=\"center\" bgcolor='#839EB8' class='thead'>"; 
echo"<caption>Details Of &nbsp;<font size='2'>$asst_mstr</font></font></caption>";
echo"<th align='center' width='15%'bgcolor='66CCFF' ><font color='000033'>Serial No.</font></th>";
echo"<th align='center' width='35%'bgcolor='66CCFF' ><font color='000033'>Asset Sub Type</font></th>";
echo"<th align='center' width='25%'bgcolor='66CCFF' ><font color='000033'>Number Of Items</font></th>";
echo"<th align='center' width='25%'bgcolor='66CCFF' ><font color='000033'>Current Value</font></th>";
echo "</tr><tr><td colspan=\"4\" align=center>";
		echo "<div style=\"overflow-y:auto;max-height:450px\">";
		echo"<table valign=\"top\"width='100%' align='center' class='report'>";
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

if($j==$a){
	echo "<th  bgcolor='$color' align='center' colspan=\"1\"  width='15%'>".$row['SRL'];
	echo "<th  bgcolor='$color' align='center' colspan=\"1\"  width=\"25%\">".$row['ASSET SUB TYPE']."</th>";
	echo"<th align='center' width='25%'bgcolor='$color'>".$row['NO. OF ITEM(S)'];
	echo"<th align='center' width='25%'bgcolor='$color'>".$row['TOTAL CURRENT VALUE']."</th>";

}
else
{
$sub_typ=$row['ASSET SUB TYPE'];
	echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width='15%'>".$row['SRL'];
	echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"35%\"><a href=\"asst_sub_typ.php?sub_typ=$sub_typ&asst_mstr=$asst_mstr\" onClick=\"window.open(this.href,'_child','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=250,left=350, width=1000,height=400'); return false;\">".$row['ASSET SUB TYPE']."</a></td>";
	echo"<td align='center' width='25%'bgcolor='$color'>".$row['NO. OF ITEM(S)'];
	echo"<td align='center' width='25%'bgcolor='$color'>".$row['TOTAL CURRENT VALUE']."</td>";
}


echo"</tr>";
		}
		echo"</table></div>";

echo"</td></tr></table>";
echo"</body>";
?>
