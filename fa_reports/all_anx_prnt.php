<?php 
include "../config/config.php";
$staff_id=verifyAutho();
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Register</title>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	<style type="text/css">
		table{border-collapse:collapse;border-spacing:0;}
		.border-td,
		.border-tr{
			width:100%;
			border-left: solid 1px #dcdcdc;
			border-right: solid 1px #dcdcdc;
			margin-bottom: 10px;
			margin-top: 10px;
		}
		.border-td caption,
		.border-tr caption{
			background-color: #909090;
			color:#efefef;
			font-size: 150%;
		}
		.border-tr tr{
			border-top: solid 1px #dcdcdc;
			border-bottom: solid 1px #dcdcdc;
			background-color: white;	
		}
		.border-td th,
		.border-td td{
			border: solid 1px #dcdcdc;
		}
		.border-td tfoot td,
		.border-tr tfoot td,
		.border-td thead td,
		.border-tr thead td,
		.border-td th,
		.border-tr th{
			font-size: 1.2em;
			background-color: #efefef;
			font-weight: bold;
		}
		.border-td tfoot td,
		.border-tr tfoot td,
		.border-td thead td,
		.border-tr thead td,
		{
			text-align: center;	
		}
		.border-td td,
		.border-tr td{
			height: 40px;
		}
		.border-td tr:hover,
		.border-tr tr:hover{
			background-color: #efefef;
		}
		.border-td tr.big{
			color: red;
			font-size: 1.2em;
			font-weight: bolder;
		}
	</style>
</head>
<body>
	<button onclick="print()">Print</button>
<div class='regReportDiv'>
	<?$sql_statement="select * from all_anx_prnt('ref'); fetch all from ref;";
	$result=dBConnect($sql_statement);?>
	<table class='border-td' align='center'>
		<caption><?echo $reportHead?></caption>
		<thead><tr>
			<td>Gl Code</td>
			<td>Gl Desc</td>
			<td align="right">Op Bal</td>
			<td align="right">Dr</td>
			<td align="right">Cr</td>
			<td align="right">Cl Bal</td>
		</tr></thead>
		<tbody>
	<?php for($i=0; $i<pg_NumRows($result)-1; $i++){
	$row=pg_fetch_array($result,$i);
	if($row[7]=='anx'){echo "<tr class='big'>";}else{echo "<tr>";}?>
			<td><?php echo $row[1];?></td>
			<td><?php echo $row[2];?></td>
			<td align="right"><?php echo $row[3];?></td>
			<td align="right"><?php echo $row[4];?></td>
			<td align="right"><?php echo $row[5];?></td>
			<td align="right"><?php echo $row[6];?></td>
		</tr>
	<?php
	}
	?>
	</table>
</div>
</body>
<html>