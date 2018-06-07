<?
include "../config/config.php";
$staff_id=verifyAutho();
$aid=$_REQUEST['aid'];
$sub_typ=$_REQUEST['sub_typ'];
$asst_mstr=$_REQUEST['asst_mstr'];
$sql="select asset_itm_rpt('$aid','refcursor')";
$sql.=";fetch all from refcursor";
//echo $sql;
$res=dBConnect($sql);
$row=pg_fetch_array($res,0);
$op=$row['DEPRECIATION BEFORE OPENING'];
echo "<head>";
echo "<title>Asset Register";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"table.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo"<table valign=\"top\" width='100%' align=\"center\" bgcolor='#839EB8' class='report'>"; 

echo"<caption>";
echo"<font color='white'>Details for &nbsp;<font size='3'>$sub_typ [$aid] </font></caption>";
echo"<tr><th align='center' width='15%'bgcolor='66CCFF' ><font color='000033'>ASSET DESCRIPTION</font></th>";
if($op>0)
echo"<th align='center' width='15%'bgcolor='66CCFF' ><font color='000033'>OPENING DATE</font></th>";
else 
echo"<th align='center' width='15%'bgcolor='66CCFF' ><font color='000033'>PURCHASE DATE</font></th>";
echo"<th align='center' width='15%'bgcolor='66CCFF' ><font color='000033'>PURCHASE VALUE </font></th>";
if($op!='0')
echo"<th align='center' width='15%'bgcolor='66CCFF' ><font color='000033'>OPENING VALUE</font></th>";
echo"<th align='center' width='15%'bgcolor='66CCFF' ><font color='000033'>TOTAL SALES</font></th>";
if($op!='0')
echo"<th align='center' width='15%'bgcolor='66CCFF' ><font color='000033'>DEPRECIATION BEFORE OPENING</font></th>";
echo"<th align='center' width='15%'bgcolor='66CCFF' ><font color='000033'>CURRENT DEPRECIATION</font></th>";
echo"<th align='center' width='10%'bgcolor='66CCFF' ><font color='000033'>CURRENT VALUE</font></th></tr>";
echo "<tr>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width='15%'><font color='black' size='2'>".$row['ASSET DESCRIPTION']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"15%\">".$row['PURCHASE DATE']."</td>";
echo"<td align='center' width='15%'bgcolor='$color'><font color='000033'>".$row['PURCHASE VALUE']."</font></td>";
if($op!='0')
echo"<td align='center' width='15%'bgcolor='$color'><font color='000033'>".$row['OPENING VALUE']."</font></td>";
if($row['TOTAL SALES']!=0)
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width='15%'><font color='black' size='2'><a href=\"asset_id_sale.php?aid=$aid&sub_typ=$sub_typ&asst_mstr=$asst_mstr\" onClick=\"window.open(this.href,'_child','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=250,left=350, width=1000,height=400'); return false;\">".$row['TOTAL SALES']."</a></td>";
else
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width='15%'>".$row['TOTAL SALES']."</a></td>";
if($op!='0')
echo"<td align='center' width='15%'bgcolor='$color'><font color='000033'>".$row['DEPRECIATION BEFORE OPENING']."</font></td>";
if($row['CURRENT DEPRECIATION']!=0)
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width='15%'><font color='black' size='2'><a href=\"asset_id_dep.php?aid=$aid&sub_typ=$sub_typ&asst_mstr=$asst_mstr\" onClick=\"window.open(this.href,'_child','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=250,left=350, width=1000,height=400'); return false;\">".$row['CURRENT DEPRECIATION']."</a></td>";
else
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width='15%'>".$row['CURRENT DEPRECIATION']."</a></td>";

echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"10%\">".$row['CURRENT VALUE']."</td>";
echo"</tr></table>";

///////////////////////////////////////////
echo"<table width=\"100%\" ><tr><td align='right' bgcolor='silver'>
<input type='button' value='Back' onclick=\"window.open('asst_sub_typ.php?sub_typ=$sub_typ&asst_mstr=$asst_mstr ','_parent','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=250,left=350, width=1000,height=400'); return false;\"></td></tr>";

echo"</table>";
echo"</body>";
?>

