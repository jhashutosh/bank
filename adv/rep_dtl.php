<?php
include "../config/config.php";
$sql_statement="SELECT action_date,account_no,gl_mas_code,sum(debit) dr,sum(credit) cr from mas_gl_tran where (type='adv' or particulars='adv') and (account_no is not null and account_no <> '')   group by account_no,gl_mas_code,action_date having account_no='$id' order by action_date";
$result=dBConnect($sql_statement);
?>
<HTML>
<head>
<link rel="stylesheet" type="text/css" href="../css/test.css" />
<link rel="stylesheet" type="text/css" href="adv.css" />
<style>
table.border-tr th{
	font-size:0.8em;
	font-weight:normal;
}
</style>
</head>
<body bgcolor='black'>
<table align='center' width='100%' bgcolor='' class=border-tr cellspacing=0 >
<caption>
<font size=+2>Advance Details for <?echo $name ?> &nbsp;&nbsp;&nbsp;&nbsp;<?echo $id?>
</caption>
<tr><th>Action Date</th>
<th align=left>Particulars</th>
<th align=right>Payment</th>
<th align=right>Receive</th></tr>
<?php
for($j=0;$j<pg_NumRows($result);$j++){
$row=pg_fetch_array($result,$j);?>
<tr><td><?echo $row['action_date']?></td>
<td><?echo getName('gl_mas_code',$row['gl_mas_code'],'gl_mas_desc','gl_master');?></td>
<td align=right><?echo amount2Rs($row['dr']);$dr+=$row['dr'];?></td>
<td align=right><?echo amount2Rs($row['cr']);$cr+=$row['cr'];?></td>
</tr>
<?php
}?>
<tr><th style=height:30px colspan='2'>Total</th>
<th align=right><?echo amount2Rs($dr)?></th>
<th align=right><?echo amount2Rs($cr)?></th></tr>
<tr style=height:20px><th colspan='2' style=height:30px>Balance</th>
<th align=right><?if(($dr-$cr)>0) echo amount2Rs($dr-$cr);?></th>
<th align=right><?if(($dr-$cr)<0) echo amount2Rs(abs($cr-$dr));?></th></tr>
</table>
</body>
</HTML>
