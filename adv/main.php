<?php
include "../config/config.php";
function cust_ven_name($id)
	{
	$id_p=explode('-',$id);
	if($id_p[0] =='C')
		{
		$field='name1';
		$table='customer_master';
		$filter='customer_id';
		}
	if($id_p[0] =='V')
		{
		$field='name';
		$table='retail_master';
		$filter='id';
		}
	$sql_statement="select $field from $table where $filter='$id'";
	//echo $sql_statement;	
	$result=dBConnect($sql_statement);
	$name=pg_result($result,$field);
	return ucwords($name);
	}
if(!empty($name)){$and=" and lower(c.name) like lower('$name%')";} 
$sql_statement="SELECT a.id,a.adv_desc,account_no,sum(debit) debit,sum(credit) credit,sum(debit-credit) as blnc from mas_gl_tran m,customer_vw c,advance_link a where particulars='adv' and m.account_no=c.id and (account_no is not null and account_no <> '') and lower(c.name) like lower('%%')

and (m.gl_mas_code=a.ast_code or m.gl_mas_code=a.liab_code)
group by account_no,a.id,a.adv_desc
order by cast(substr(account_no,3) as integer)";
$result=dBConnect($sql_statement);
//echo $sql_statement;
?>
<HTML>
<head>
<link rel="stylesheet" type="text/css" href="../css/test.css" />
</head>
<body>
<style>
table{
//border-collapse:collapse;
//border-spacing:0;

}
td{
//border:solid 1px black;
background-color:white;
}
thead td{
//border:solid 1px black;
background-color:#00A7A0;
}
.red{color:#FF3B65;}
.green{color:#00A7A0;}
</style>
<table align='center' width='100%' bgcolor='' cellspacing=2>
<caption style='background-color:#00A7A0;height:25px;border-left:solid 2px #4D4D4D;border-right:solid 2px #4D4D4D'><font size=+1 color=white>ADVANCE MAIN</caption>
<thead>
	<tr>
		<td rowspan='2' align='center' width='15%'>Customer/Vendor<br>Id</td>
		<td rowspan='2' align='center' width='25%'>Name</td>
		<td rowspan='2' align='center' width='25%'>Purpose</td>
		<td colspan='2' align='center'>Advance</td>
		<td colspan='2' align='center'>Balance</td>
		<td rowspan='2' align='center'>Operation</td>
	</tr>
<tr>
<td align='center'>Debit</td>
<td align='center'>Credit</td>
<td align='center'>Debit</td>
<td align='center'>Credit</td>
</tr>
</thead>
<?php for($j=0;$j<pg_NumRows($result);$j++){ $row=pg_fetch_array($result,$j);?>
<tr>
<td><?echo "<a href=\"rep_dtl.php?id=".$row['account_no']."&name=".cust_ven_name($row['account_no'])."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=150,left=350, width=800,height=400'); return false;\"><font color=black>".$row['account_no']."</a>"?></td>
<td><?echo cust_ven_name($row['account_no'])?></td>
<td><?echo ucwords($row['adv_desc'])?></td>
<td align=right><?echo $row['debit']?></td>
<td align=right><?echo $row['credit']?></td>
<td align=right <?if($row['blnc'] > 0){ echo "class='green'>"; echo $row['blnc'];}?></td>
<td align=right <?if($row['blnc'] < 0){ echo "class='red'>"; echo abs($row['blnc']);}?></td>
<td><?echo "<a href=\"transaction.php?id=".$row['account_no']."&name=".cust_ven_name($row['account_no'])."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=150,left=350, width=800,height=400'); return false;\"><font color=black>Transaction</a>"?></td>
</tr>
<?php
}
?>
</table>
</body>
</HTML>
