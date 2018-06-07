<?
include "../config/config.php";
$staff_id=verifyAutho();
$fy=$_SESSION['fy'];
?>
<html>
<head>
<title>C.C.B Monthly Report(DEPOSIT)</title>
<link rel="stylesheet" href="../JS/themes/base/jquery.ui.all.css">
	<script src="../JS/jquery-1.9.1.js"></script>
	<script src="../JS/ui/jquery.ui.core.js"></script>
	<script src="../JS/ui/jquery.ui.widget.js"></script>
	<script src="../JS/ui/jquery-ui-1.10.3.custom.min.js"></script>
<script type="text/javascript">
$(function(){
		$("#reportDate").datepicker({dateFormat :'dd/mm/yy'});
});
</script>
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
<div id="header" align="center" >
<form action="report-1-1.php">
<table align='center' width='60%' bgcolor='silver'>
<tr><th align="center" colspan=1 bgcolor='#F4F4F4'>CCB DEPOSIT Monthly Report</th></td>
<tr><td align="center" colspan=1 bgcolor='silver'>Show Report on Date:
<input type="text" value="" id="reportDate" name="reportDate"></td></tr>
<tr><td bgcolor='silver' align='right'><input type="submit" value="Show" id="showReport" name="showReport"></td></tr>
</table>
</form>
</div>
<?if(!empty($_REQUEST['reportDate'])){
$reportDate=$_REQUEST['reportDate'];
?>
<table valign="top" width='80%' align='center' class='rptTable' cellspacing=0>
<caption>
<B>CCB DEPOSIT Monthly Report as on <?echo$reportDate?></B>
<button style='float:right' onclick='print()'>Print</button>
</caption>
<tr>
	<th width='5%'>SRL</th>
	<th width='10%'>Date From</th>
	<th width='10%'>Date To</th>
	<th width='15%'>MONTH'YEAR</th>
	<th width='10%'>NO. OF ACCOUNT(S)</th>
	<th width='15%'>MONTH'S BALANCE</th>
	<th width='15%'>INT. RECEIVABLE</th>
	<th width='5%'>Action</th>
</tr>
<?
//SRL	|  DATE FROM	|  DATE TO	|  MONTH'YEAR	|  NO. OF ACCOUNT(S)	|  MONTH'S BALANCE	|  INT. RECEIVABLE	|
$sql="select ccb_mth_dp('$reportDate','refcursor')";
$sql.=";fetch all from refcursor";
//echo $sql;
//$sql="select * from customer_master";
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
			<td bgcolor="<?echo $color?>" width='5%'><?echo $row[3];?></td>
			<td bgcolor="<?echo $color?>" width='5%' align='right'><?echo $row[4];?></td>
			<td bgcolor="<?echo $color?>" width='5%' align='right'><?echo $row[5];?></td>
			<td bgcolor="<?echo $color?>" width='5%' align='right'><?echo $row[6];?></td>
			<td bgcolor="<?echo $color?>" width='5%' align='right'>
			<a href="report-1-2.php?from=<?echo $row[1];?>&to=<?echo $row[2];?>" target='_blank'>Details</a>
			</td>
		</tr>
<?}?>
</table>
<?}?>
</body>
</html>
