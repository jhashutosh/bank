<?
include "../config/config.php";
$staff_id=verifyAutho();
$fy=$_SESSION['fy'];
$amp=$_REQUEST['ratio_name'];
$rat_nm=str_replace('|','&',$amp);
$ratnm=$_REQUEST['ratnm'];
$amount=$_REQUEST['amount'];
//echo $rat_nm;
//echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo"<head>";
echo"<title></title>";
?>
<style>
.subTable th{
	font-size:1.4em;
	color:#efefef;
	background-color:#4f4f4f;
}
.subTable{
	width:100%;
}
.subTable td{
	word-warp:break-line;
}
.subTable tr.tr1{
	font-size:1.1em;
	color:green;
	background-color:#dfdfdf;
}
.subTable tr.tr2{
	font-size:1.3em;
	font-weight:bold;
	color:red;
	background-color:#cfcfcf;
}
.subTable tr.tr3{
	font-size:1em;
	color:black;
	background-color:#bfbfbf;
}
a{
text-decoration:none;
}
</style>
<?
echo"</head>";
echo"<body bgcolor='silver'>";
echo"<table valign=\"top\"width='80%' align='center' class='subTable'>";
echo"<tr><th colspan='5' bgcolor='#EAE7E7'><font color='#efefef' size='5'><B>Details of GL Header : $rat_nm </B>(Rs.$amount)</font><button style='float:right' onclick='print()'>Print<button></th></tr>";
?>
<tr>
	<th width='10%'>CODE</th>
	<th width='45%'>HEAD OF ACCOUNT</th>
	<th width='15%'>DR (Rs.)</th>
	<th width='15%'>CR (Rs.)</th>
	<th width='15%'>BALANCE (Rs.)</th>
</tr>
<?
$sql="select ratio_rpt_gl_dtls('$rat_nm','$ratnm','refcursor')";
$sql.=";fetch all from refcursor";
//echo $sql;
$TCOLOR='#CACACA';
$TBGCOLOR='white';
$res=dBConnect($sql);
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
?>

		<?if($row['gl_lvl']=='SUBHEADER'){?>
			<tr  class='tr2'>
				<td width='10%'><?echo $row['gl_cd'];?></td>
				<td width='45%'><?echo $row['gl_dsc'];?></td>
				<td width='15%' align='right'><?echo amount2Rs($row['dr']);?></td>
				<td width='15%' align='right'><?echo amount2Rs($row['cr']);?></td>
				<td width='15%' align='right'><?echo amount2Rs($row['lvl_bal']);?></td>
			</tr>
		<?}if($row['gl_lvl']=='ledger'){?>
			<tr class='tr3'>
				<td width='10%'><?echo $row['gl_cd'];?></td>
				<td width='45%'><?echo $row['gl_dsc'];?></td>
				<td width='15%' align='right'><?echo amount2Rs($row['dr']);?></td>
				<td width='15%' align='right'><?echo amount2Rs($row['cr']);?></td>
				<td width='15%' align='right'><?echo amount2Rs($row['lvl_bal']);?></td>
			</tr>

		<?}}?>
</table>
<div align='center' style="display:block;margin-top:40px;background-color:transparent;height:40px;" valign=middle>
<center>
<a href="javascript:window.history.back();" style="background-color:#efefef;padding:7px;color:silver;float:both;border:solid 1px #000000"><font color='Black'>Backward</font></a>
<a href="javascript:window.history.forward();" style="background-color:#efefef;padding:7px;color:Silver;float:both;border:solid 1px #000000"><font color='Black'>Forward</font></a>
</center>
</div>





