<?php
include "../config/config.php";
$staff_id=verifyAutho();
$aid=$_REQUEST['aid'];
$sub_typ=$_REQUEST['sub_typ'];
$asst_mstr=$_REQUEST['asst_mstr'];
$sql="select ast_sold_rpt('refcursor')";
$sql.=";fetch all from refcursor";
$res=dBConnect($sql);
echo "<head>";
echo "<title>Asset Register";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"table.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo"<table valign=\"top\" width='100%' align=\"center\" bgcolor='#839EB8' class='report'>"; 

echo"<caption>";

echo"<font color='white'><font size='3'>Sold Asset Report</font></caption>";

echo"<th align='center' bgcolor='66CCFF' ><font color='000033'>ASSET ID</font></th>";

echo"<th align='center' bgcolor='66CCFF' ><font color='000033'>ASSET DESCRIPTION</font></th>";


echo"<th align='center' bgcolor='66CCFF' ><font color='000033'>OPENING/PURCHASE DATE</font></th>";

echo"<th align='center' bgcolor='66CCFF' ><font color='000033'>PURCHASE VALUE </font></th>";

echo"<th align='center' bgcolor='66CCFF' ><font color='000033'>OPENING VALUE</font></th>";
echo"<th align='center' bgcolor='66CCFF' ><font color='000033'>DEPRECIATION BEFORE OPENING</font></th>";

echo"<th align='center' bgcolor='66CCFF' ><font color='000033'>CURRENT DEPRECIATION</font></th>";
echo"<th align='center' bgcolor='66CCFF' ><font color='000033'>TOTAL SALES</font></th>";

echo"<th align='center' bgcolor='66CCFF' ><font color='000033'>PROFIT/LOSS AMT</font></th>";
echo"<th align='center' bgcolor='66CCFF' ><font color='000033'>PROFIT/LOSS</font></th>";

echo"<th align='center' bgcolor='66CCFF' ><font color='000033'>SALE DATE</font></th></tr>";
//echo "</tr><tr><td colspan=11><table class='report'>";
$TBGCOLOR="WHITE";
$TCOLOR="#839EB8";
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
echo "<tr>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  ><font color='black' size='2'>".$row['ast_id']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\">".$row['dsc']."</td>";
$op=($row['dpr_amt']>0)?'op':'pu';
echo"<td align='center' bgcolor='$color'><font color='000033'>".$row['pu_dt']." [$op]</font></td>";
echo"<td align='center' bgcolor='$color'><font color='000033'>".$row['ast_val']."</font></td>";
echo"<td align='center' bgcolor='$color'><font color='000033'>".$row['face_value']."</font></td>";
echo"<td align='center' bgcolor='$color'><font color='000033'>".$row['dpr_amt']."</font></td>";
echo"<td align='center' bgcolor='$color'><font color='000033'>".$row['tot_dep']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  ><font color='black' size='2'>".$row['tot_sls']."</td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  ><font color='black' size='2'>".$row['pr_ls']."</td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\">".$row['pr_ls_sts']."</td>";
echo"<td align='center' bgcolor='$color'><font color='000033'>".$row['sale_dt']."</font></td>";
echo"</tr>";}

echo"</table>";

///////////////////////////////////////////
//echo"<table width=\"100%\" ><tr><td align='right' bgcolor='silver'><input type='button' value='Back' onclick=\"window.open('asst_sub_typ.php?sub_typ=$sub_typ&asst_mstr=$asst_mstr ','_parent','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=250,left=350, width=1000,height=400'); return false;\"></td></tr>";

//echo"</td></tr></table>";
echo"</body>";
?>

