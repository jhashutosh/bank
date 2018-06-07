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
.hide{display:none;}
</style>
</head>
<body>
<?if(!empty($_REQUEST['to'])){
$from=$_REQUEST['from'];
$to=$_REQUEST['to'];
?>
<table valign="top" width='80%' align='center' class='rptTable' cellspacing=0>
<caption>
<B>CCB Report Monthly ( DEPOSIT ) type wise from <?echo$from?> to <?echo$to?></B>
<button style='float:right' onclick='print()'>Print</button>
</caption>
<tr>
	<th width='10%'>SRL</th>
	<th width='15%'>A/C TYPE</th>
	<th width='0%' class='hide'></th>
	<th width='15%'>NO. OF ACCOUNT(S)</th>
	<th width='15%'>CL. BALANCE</th>
	<th width='15%'>INT. RECEIVABLE</th>
	<th width='15%'>Action</th>
</tr>
<?
$sql="select ccb_mth_dp_typ('$to','refcursor')";
$sql.=";fetch all from refcursor";
//SRL  	|  A/C TYPE	|  		| NO. OF ACCOUNT(S)	|  CL. BALANCE	|  INT. RECEIVABLE
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
			<td bgcolor="<?echo $color?>" width='5%' class='hide'><?echo $row[2];?></td>
			<td bgcolor="<?echo $color?>" width='5%' align='right'><?echo $row[3];?></td>
			<td bgcolor="<?echo $color?>" width='5%' align='right'><?echo $row[4];?></td>
			<td bgcolor="<?echo $color?>" width='5%' align='right'><?echo $row[5];?></td>
			<td bgcolor="<?echo $color?>" width='5%' align='right'>
			<a href="report-1-3.php?lntype=<?echo $row[1];?>&from=<?echo $from;?>&end=<?echo $row[2];?>" target='_blank'>Details</a>
			</td>
		</tr>
<?}?>
</table>
<?}?>
</body>
</html>
