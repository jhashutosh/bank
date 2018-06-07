<?
include "../config/config.php";
$ratio_name=$_REQUEST['rt_nm'];
$gl_sub_hdr_cde=$_REQUEST['gl_s_h'];
$gl_ledgr=$_REQUEST['gl_ledgr'];

$ratio_name=(!empty($ratio_name))?$ratio_name:'null';
$gl_sub_hdr_cde=(!empty($gl_sub_hdr_cde))?"'".$gl_sub_hdr_cde."'":'null';
$gl_ledgr=(!empty($gl_ledgr))?"'".$gl_ledgr."'":'null';
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
echo"<form  name='f1' action='ratio_spec_srch_frm.php' method='post' >";
echo"<table valign=\"top\"width='100%' align='center'>";
$sql="select ratio_mast1_src($ratio_name, $gl_sub_hdr_cde, $gl_ledgr,'refcursor')";
$sql.=";fetch all from refcursor";
//echo $sql;
$TCOLOR='#B7C2CF';
$TBGCOLOR='white';
$res=dBConnect($sql);
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
echo "<tr rowspan='2'> ";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width='5%'><font color='black' size='2'>".$row['0']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\" width='20%'><font color='black' size='2'>".$row['1']."</font></td>";
echo"<td align='center' width='15%'bgcolor='$color'><font color='000033'>".$row['2']."</font></td>";
echo"<td align='center' width='25%'bgcolor='$color'><font color='000033'>".$row['3']."</font></td>";
echo"<td align='center' width='25%'bgcolor='$color'><font color='000033'>".$row['4']."</font></td>";
echo"<td align='center' width='10%'bgcolor='$color'><font color='000033'>".$row['5']."</font></td>";
echo"</tr>";
}
