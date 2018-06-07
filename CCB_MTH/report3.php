<?
include "../config/config.php";
$staff_id=verifyAutho();
$fy=$_SESSION['fy'];
?>
<html>
<head>
<title>C.C.B Monthly REPORT(Loan)</title>
<style>
.rptTable caption{
	font-size:1.4em;
	color:#efefef;
	background-color:#4f4f4f;
}
.rptTable th{
	text-transform:uppercase;
	font-size:1.2em;
	color:#efefef;
	background-color:#4f4f4f;
	border:solid 1px #303030;
}
.rptTable{
	width:100%;
}
.rptTable td{
	word-warp:break-line;
	border:solid 1px #303030;
}
a{
text-decoration:none;
}
</style>
</head>
<body>
<?if(!empty($_REQUEST['lntype']) || !empty($_REQUEST['end'])){
$lntype=$_REQUEST['lntype'];
$from=$_REQUEST['from'];
$end=$_REQUEST['end'];
?>
<table valign="top" width='80%' align='center' class='rptTable' cellspacing=0>
<caption>
<B>Details of all <?echo $lntype?> type A/Cs from <?echo$from?> to <?echo$end?></B>
<button style='float:right' onclick='print()'>Print</button>
</caption>
<tr>
	<th width='10%'>SRL</th>
	<th width='15%'>A/C NO.</th>
	<th width='15%'>LOAN SRL. NO.</th>
	<th width='15%'>DAYS</th>
	<th width='15%'>DUE INT.</th>
	<th width='15%'>OD INT.</th>
	<th width='15%'>MONTH'S BALANCE</th>
</tr>
<?
$sql="select ccb_mth_ln_dtls('$lntype','$end','refcursor')";
$sql.=";fetch all from refcursor";
$TCOLOR='#dadada';
$TBGCOLOR='white';
$res=dBConnect($sql);
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
?>
		<tr>
			<td bgcolor="<?echo $color?>" width='5%' align='center'><?echo $row[0];?></td>
			<td bgcolor="<?echo $color?>" width='5%'><?echo $row[1];?></td>
			<td bgcolor="<?echo $color?>" width='5%' align='right'><?echo $row[2];?></td>
			<td bgcolor="<?echo $color?>" width='5%' align='right'><?echo $row[3];?></td>
			<td bgcolor="<?echo $color?>" width='5%' align='right'><?echo $row[4];?></td>
			<td bgcolor="<?echo $color?>" width='5%' align='right'><?echo $row[5];?></td>
			<td bgcolor="<?echo $color?>" width='5%' align='right'><?echo $row[6];?></td>
		</tr>
<?}?>
</table>

<?}?>
</body>
</html>
