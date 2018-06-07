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
	<title>Mini Wise</title>
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
<?$sql="select * from 	
		(select m.mini_name,l.id_mini_master,count(distinct l.id_customer_master) tot_cust,count(distinct l.id_land_info) no_land 
		from lc_mini_customer_link l,lc_mini_master m 
		where l.id_mini_master=m.id
		group by l.id_mini_master,m.mini_name) as a 
		left outer join 

		(select a.id_mini_master,a.tot_op,b.paid_op from 
							(
							select mcl.id_mini_master,sum(opb.amount) as tot_op
							from  lc_mini_customer_link mcl,lc_customerwise_miniwise_opening_balance opb 
							where  opb.id_mini_customer_link=mcl.id 
							and opb.balance_as_on=(select start_dt - interval '1 DAY' from fy_list where fy='$fy')
							group by mcl.id_mini_master ) as a

							left outer join 

							(select mcl.id_mini_master,coalesce(sum(opb.amount),0) as paid_op 
							from  lc_mini_customer_link mcl,lc_customerwise_miniwise_opening_balance opb 
							where  opb.id_mini_customer_link=mcl.id 
							and opb.balance_as_on=(select start_dt - interval '1 DAY' from fy_list where fy='$fy')
							and opb.paid_date is not null 

							group by mcl.id_mini_master) as b
							on a.id_mini_master=b.id_mini_master) as b
		on a.id_mini_master=b.id_mini_master

		left outer join 
		
		(select mcl.id_mini_master,sum(cpd.tot_amt) tot_cur,sum(cpd.paid_amt) paid_cur,sum(cpd.due_amt) bal_cur

		from lc_customer_land_crop_info clci,
		lc_customer_payment_details cpd,
		lc_mini_customer_link mcl
		
		where clci.id_mini_customer_link=mcl.id
		and clci.id=cpd.id_lc_customer_land_crop_info
		and cpd.bill_date between (select start_dt from fy_list where fy='$fy') and  (select close_dt from fy_list where fy='$fy') 
		
		group by mcl.id_mini_master ) as c

		on a.id_mini_master=c.id_mini_master

		left outer  join

		(select mol.id_mini_master,sum(osd.tot_sal_amt) op_sal, sum(osd.paid_amt) sal_pd,sum(osd.tot_sal_amt)-sum(osd.paid_amt) bal_sal
		from lc_operator_salary_details osd,
		lc_mini_operator_link mol

		where  mol.id=osd.id_mini_operator_link
		and osd.bill_date between  (select start_dt from fy_list where fy='2014-2015') and  (select close_dt from fy_list where fy='$fy')
		group by mol.id_mini_master)as d

		on a.id_mini_master=d.id_mini_master

		order by cast(substr(a.mini_name,3) as integer)";
	$res=dBConnect($sql);
	//echo $sql;
	if(pg_NumRows($res)==0){
		echo "Not found!!!";
	}
	else {?>		<div align=center> <font size=+1>MINI WISE REPORT </font><br>
		<table id="matTable" style="width:100%;" cellspacing="0" cellpadding="0" >

		<tr>
			<th rowspan=2>Mini Name</th>
			<th rowspan=2>No of Cust</th>
			<th rowspan=2>No of land</th>
			<th colspan=3>Opening/OD</th>
			<th colspan=3>Current Year</th>
	
		</tr>
		<tr>
			<th>Total</th>
			<th>Paid</th>
			<th>Balance</th>
			<th>Total</th>
			<th>Paid</th>
			<th>Balance</th>
		</tr>
		<?php 
		for($j=0;$j<pg_NumRows($res);$j++){
			$row=pg_fetch_array($res,$j);?>
			<tr>
				
				<td align='center'>
				<a href='mini_brk_up.php?id=<?echo $row['id_mini_master']?>&name=<?echo $row['mini_name'] ?>' target='_blank'>
					<?php echo $row['mini_name'];?></a>
				</td>
				<td align='center'>
					<?php echo $row['tot_cust'];?>
				</td>
				<td align='center'>
					<?php echo $row['no_land'];?>
				</td>
				<td>
					<?php echo $row['tot_op'];?>
				</td>
				<td align='center'>
					<?php  $amt=(empty($row['paid_op']))?'0.00':$row['paid_op']; echo $amt ;?>
				</td>
				<td align='center'>
					<?php echo $row['tot_op']-$amt; ?>
				</td>
				<td align='center'>
					<?php echo $row['tot_cur'];?>
				</td>
				<td align='center'>
					<?php echo $row['paid_cur'];?>
				</td>
				<td align='center'>
					<?php echo $row['bal_cur'];?>
				</td>
			</tr>
		<?
		}?>
		</table>
<?	}?>
</body>
</html>
