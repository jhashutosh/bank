<?
include "../config/config.php";
$dat_frm=$_REQUEST['dat_frm'];
$gl_sub_hdr_cde=$_REQUEST['gl_sub_hdr_cde'];
$asset_ledgr=$_REQUEST['asset_ledgr'];

$dat_frm=(!empty($dat_frm))?"'".$dat_frm."'":'null';
$gl_sub_hdr_cde=(!empty($gl_sub_hdr_cde))?"'".$gl_sub_hdr_cde."'":'null';
$asset_ledgr=(!empty($asset_ledgr))?"'".$asset_ledgr."'":'null';
//echo $frmr_id;
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo"<head>";
echo"<title>framer frame</title>";
echo "<script src=\"../JS/loading2.js\">";
echo "</script>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo"</head>";
echo"<body bgcolor='grey'>";
echo"<form  name='f1' action='frmr_frame.php?op=i' method='post' >";
echo"<table valign=\"top\"width='100%' align='center'>";
$sql="select risk_wght_prcnt_src($dat_frm, $gl_sub_hdr_cde, $asset_ledgr,'refcursor')";
$sql.=";fetch all from refcursor";
//echo $sql;
$TCOLOR='#B7C2CF';
$TBGCOLOR='white';
$res=dBConnect($sql);
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
echo "<tr rowspan='2'> ";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width='5%'><font color='black' size='2'>".$row['srl']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\" width='10%'><font color='black' size='2'>".$row['dt_frm']."</font></td>";
echo"<td align='center' width='10%'bgcolor='$color'><font color='000033'>".$row['dt_to']."</font></td>";
echo"<td align='center' width='15%'bgcolor='$color'><font color='000033'>".$row['gl_sh']."</font></td>";
echo"<td align='center' width='20%'bgcolor='$color'><font color='000033'>".$row['gl_sh_dsc']."</font></td>";
echo"<td align='center' width='15%'bgcolor='$color'><font color='000033'>".$row['gl_ms_cd']."</font></td>";
echo"<td align='center' width='20%'bgcolor='$color'><font color='000033'>".$row['gl_ms_dsc']."</font></td>";
echo"<td align='center' width='10%'bgcolor='$color'><font color='000033'>".$row['prcnt']."</font></td>";
echo"</tr>";
}

echo"</table></form></body>";
?>
