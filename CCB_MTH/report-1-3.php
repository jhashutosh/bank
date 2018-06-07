<?
include "../config/config.php";
$staff_id=verifyAutho();
$fy=$_SESSION['fy'];
?>
<html>
<head>
<title>C.C.B Monthly REPORT(DEPOSIT)</title>
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
	<th width='15%'>BANK (BRANCH)</th>
	<th width='15%'>OP. BALANCE</th>
	<th width='15%'>DEPOSIT</th>
	<th width='15%'>WITHDRAW</th>
	<th width='15%'>INTEREST</th>
	<th width='15%'>CHARGES</th>
	<th width='15%'>CL. BALANCE</th>
	<th width='15%'>INT. RECEIVABLE</th>
</tr>
<?
//SRL  	|  A/C NO.	| BANK (BRANCH)	|  OP. BALANCE	|  DEPOSIT	|  WITHDRAW	| INTEREST	|  CHARGES	|  CL. BALANCE	|  INT. RECEIVABLE
$sql="select ccb_mth_dp_dtls('$lntype','$end','refcursor')";
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
			<td bgcolor="<?echo $color?>" width='5%'><?echo $row[2];?></td>
			<td bgcolor="<?echo $color?>" width='5%' align='right'><?echo $row[3];?></td>
			<td bgcolor="<?echo $color?>" width='5%' align='right'><?echo $row[4];?></td>
			<td bgcolor="<?echo $color?>" width='5%' align='right'><?echo $row[5];?></td>
			<td bgcolor="<?echo $color?>" width='5%' align='right'><?echo $row[6];?></td>
			<td bgcolor="<?echo $color?>" width='5%' align='right'><?echo $row[7];?></td>
			<td bgcolor="<?echo $color?>" width='5%' align='right'><?echo $row[8];?></td>
			<td bgcolor="<?echo $color?>" width='5%' align='right'><?echo $row[9];?></td>
		</tr>
<?}?>
</table>
<?}?>
</body>
</html>
