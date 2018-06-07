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
echo"<table valign=\"top\"width='100%' align='center'>";
echo"<tr><td colspan='6' bgcolor='black' align='center'><font color='white' size='2'>Depreciation details for <font size='4' color='#839EB8'>$asset_id</font></td></tr>";
echo"<tr>";
echo"<td  bgcolor='#839EB8' align='center' colspan=\"1\"  width='33%'><font color='silver' size='2'>TRANSACTION ID</font></td>";
echo"<td  bgcolor='#839EB8' align='center' colspan=\"1\"  width=\"32%\"><font color='silver'>TRANSACTION DATE</td>";
echo"<td  bgcolor='#839EB8' align='center' colspan=\"1\"  width=\"34%\"><font color='silver'>DEPRECIATION AMOUNT</td>";
echo"</tr>";
//$color="#F0E68C";
$color="lightgreen";
$sql="select asset_itm_dep_rpt('$asset_id','refcursor')";
$sql.=";fetch all from refcursor";
//echo $sql;
$res=dBConnect($sql);
$a=pg_NumRows($res);
if($a>0)
{for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
echo "<tr>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width='33%'><font color='black' size='2'>".$row['TRANSACTION ID']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"32%\">".$row['TRANSACTION DATE']."</td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"34%\">".$row['DEPRECIATION AMOUNT']."</td>";
echo"</tr>";
}}
else{
echo"<tr><td  align='center' colspan=\"6\"><font color='red' size='4'><blink>This Asset doesn't have any Depreciation posted</blink></td></tr>";
}
echo"<tr><td colspan='6' align='right'><input type='button' value='Back' onclick=\"window.open('asset_id.php?aid=$asset_id&sub_typ=$sub_typ&asst_mstr=$asst_mstr','_parent','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=250,left=350, width=1000,height=400'); return false;\"></td></tr>";
echo"</table></body>";
?>
