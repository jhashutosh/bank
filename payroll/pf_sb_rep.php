<?
include "../config/config.php";
$staff_id=verifyAutho();
$action_date=date('d.m.Y');
$fy=$_SESSION['fy'];
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>INVESTMENT</title>
	<link rel="stylesheet" href="../JS/themes/base/jquery.ui.all.css">
	<script src="../JS/jquery-1.9.1.js"></script>
	<script src="../JS/ui/jquery.ui.core.js"></script>
	<script src="../JS/ui/jquery.ui.widget.js"></script>
	<script src="../JS/ui/jquery.ui.tabs.js"></script>
	<script src="../JS/ui/jquery.ui.autocomplete.js"></script>
	<script src="../JS/ui/jquery-ui-1.10.3.custom.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/test.css" />
	<link rel="stylesheet" href="../JS/sandi-theme.css">
<script>
</script>
<style>
	input[type=submit]{
		padding:4px;
		border:solid 1px #a0a0a0;
	}
	input[type=submit]:hover{
		cursor: pointer; 
		border:solid 1px rgba(0,162,232,0.7);
		box-shadow: 0 1px 3px rgba(0, 0, 0, 0.4) inset;
		-moz-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.4) inset;
		-webkit-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.4) inset; 
		transition: border 0.15s linear 0s, box-shadow 0.15s linear 0s, color 0.15s linear 0s;
		-webkit-transition: border 0.15s linear 0s, box-shadow 0.15s linear 0s, color 0.15s linear 0s;
		-moz-transition: border 0.15s linear 0s, box-shadow 0.15s linear 0s, color 0.15s linear 0s;
		-o-transition: border 0.15s linear 0s, box-shadow 0.15s linear 0s, color 0.15s linear 0s;
	}
	#matTable{
		border-collapse: collapse;
		border-spacing: 0px;
		margin-top: 40px;
	}
	#matTable tr{
		border-top: solid 1px #dcdcdc;
		border-bottom: solid 1px #dcdcdc;	
	}
	#matTable th{
		font-size: 1.2em;
		background-color: #efefef;
		padding: 3px;
	}
	#matTable td{
		padding: 3px;
		height: 50px;
	}
</style>
</head>
<body>
<?$sql="select a.*,b.dep,b.wit from (select s.*,initcap(e.name) as name,m.invst_desc,m.gl_mas_code,case when  dt_of_maturity-current_date <= 0 then 0 
when  dt_of_maturity-current_date < 3 then 1 
else 2 end as cl ,
case when withdrawl_amount is null then 0 else 1 end as mt
from emp_pforgratuity_sb_hdr s,emp_investment_mas m,emp_master e 
where s.id_emp_investment_mas=m.id
and s.emp_id=e.emp_id
and m.invst_desc='sb'
order by e.emp_id) as a

left outer join 


(select a.deposit_no,dep,wit from (
	(select sum(dep_amount) as dep,deposit_no from emp_pforgratuity_sb_dtl where dep_amount >0 group by deposit_no) as a
full outer  join 
	 (select sum(dep_amount) as wit,deposit_no from emp_pforgratuity_sb_dtl where dep_amount <0 group by deposit_no) as b
on a.deposit_no=b.deposit_no)) as b


on a.deposit_no=b.deposit_no ";
	$res=dBConnect($sql);
	//echo $sql;
	if(pg_NumRows($res)==0){
		echo "Not found!!!";
	}
	else {?>		<div align=center> <font size=+1>Employee SB Investment</font><br>
		<table id="matTable" style="width:100%;" cellspacing="0" cellpadding="0" >

		<tr>
			<th>Employee Name</th>
			<th>Account No</th>
			<th>Bank Name</th>
			<th>Opening Date</th>
			<th>Deposit</th>
			<th>Withdrawl</th>
			<th>Balance</th>
	
		</tr>
		
		<?php 
		for($j=0;$j<pg_NumRows($res);$j++){
			$row=pg_fetch_array($res,$j);?>
			<tr>
				
				<td align='center'>
				<a href='pf_sb_rep_dtl.php?dep_no=<?echo $row['deposit_no']?>&amt=<?echo $row['deposit_amount']?>&emp_id=<?echo $row['emp_id']?>&name=<?echo $row['name'] ?>' target='_blank'>
					<?php echo $row['name'];?></a>
				</td>
				<td align='center'>
					<?php echo strtoupper($row['invst_desc'])."[".$row['deposit_no']."]";?>
				</td>
				<td align='center'>
					<?php echo $row['bank_dtl'];?>
				</td>
				<td align='center'>
					<?php echo $row['dt_of_issue'];?>
				</td>
				<td align='center'>
					<?php echo $row['opening_amount']+$row['dep']+$row['int_amt'];?>
				</td>
				<td align='center'>
					<?php echo abs($row['wit']); ?>
				</td>
				<td align='center'>
					<?php echo $row['deposit_amount'];?>
				</td>
				
			</tr>
		<?
		}?>
		</table>
<?	}?>
</body>
</html>
