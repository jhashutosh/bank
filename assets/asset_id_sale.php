<?
include "../config/config.php";
$asset_id=$_REQUEST['aid'];
$sub_typ=$_REQUEST['sub_typ'];
$asst_mstr=$_REQUEST['asst_mstr'];
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo"<head>";
echo"<title>Asset Details</title>";
echo"</head>";
echo"<body bgcolor='#D8D8D8'>";
echo"<form  name='f1' action='ast_sub_typ_frm.php?op=i' method='post' >";
echo"<table valign=\"top\"width='100%' align='center'>";
echo"<tr><td colspan='7' bgcolor='black' align='center'><font color='white' size='2'>Sale details for <font size='4' color='#839EB8'>$asset_id</font></td></tr>";
echo"<tr>";
echo"<td  bgcolor='#839EB8' align='center' colspan=\"1\"  width='10%'><font color='silver' size='2'>TRANSACTION ID</font></td>";
echo"<td  bgcolor='#839EB8' align='center' colspan=\"1\"  width=\"25%\"><font color='silver'>TRANSACTION DATE</td>";
echo"<td  bgcolor='#839EB8' align='center' width='25%'><font color='000033'><font color='silver'>ASSET VALUE</font></td>";
echo"<td  bgcolor='#839EB8' align='center' width='25%'><font color='000033'><font color='silver'>SALE VALUE</font></td>";
echo"<td  bgcolor='#839EB8' align='center' width='25%'><font color='000033'><font color='silver'>DEPRECIATION AMOUNT</font></td>";
echo"<td  bgcolor='#839EB8' align='center' colspan=\"1\"  width=\"25%\"><font color='silver'>PROFIT / LOSS AMOUNT</td>";
echo"<td  bgcolor='#839EB8' align='center' colspan=\"1\"  width=\"25%\"><font color='silver'>PROFIT / LOSS</td>";
echo"</tr>";
$color="#F0E68C";
$sql="select asset_itm_sls_rpt('$asset_id','refcursor')";
$sql.=";fetch all from refcursor";
//echo $sql;
$res=dBConnect($sql);
$a=pg_NumRows($res);
if($a>0)
{for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
echo "<tr>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width='10%'><font color='black' size='2'>".$row['TRANSACTION ID']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"25%\">".$row['TRANSACTION DATE']."</td>";
echo"<td align='center' width='25%'bgcolor='$color'><font color='000033'>".$row['ASSET VALUE']."</font></td>";
echo"<td align='center' width='25%'bgcolor='$color'><font color='000033'>".$row['SALE VALUE']."</font></td>";
echo"<td align='center' width='25%'bgcolor='$color'><font color='000033'>".$row['DEPRECIATION AMOUNT']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"25%\">".$row['PROFIT / LOSS AMOUNT']."</td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"25%\">".$row['PROFIT / LOSS']."</td>";
echo"</tr>";
}}
else{
echo"<tr><td  align='center' colspan=\"7\"  width=\"25%\"><font color='red' size='4'>This Asset isn't sold yet</td></tr>";
}
echo"<tr><td colspan='7' align='right'><input type='button' value='Back' onclick=\"window.open('asset_id.php?aid=$asset_id&sub_typ=$sub_typ&asst_mstr=$asst_mstr','_parent','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=250,left=350, width=1000,height=400'); return false;\"></td></tr>";
echo"</table></form></body>";
?>
