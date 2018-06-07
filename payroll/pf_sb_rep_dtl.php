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
<body bgcolor=#CDCDCD>
<table id="matTable" style="width:60%;" cellspacing="0" cellpadding="0" align=center>
<tr>
<td>Name : </td>
<td><?echo $name ;?></td>
<td>Employee Id</td>
<td><?echo $emp_id?></td>
<td>Account No : </td>
<td><?echo $dep_no?></td>
</tr>
<th colspan=6 align=center>Current Balance   : Rs.  <?echo $amt?></th>
</table>
<?$sql="select * from (
	select dt_of_issue,entry_time,'Opening' as particulars,opening_amount as dep_amt,0 as withd_amt 
	from emp_pforgratuity_sb_hdr 		
	where deposit_no='$dep_no'

	union 

	select action_date,entry_time,'cash deposit' as particulars,dep_amount,0 as withd_amt 
	from emp_pforgratuity_sb_dtl
	where deposit_no='$dep_no'
	and dep_amount>0

	union 

	select action_date,entry_time,'int deposit' as particulars,int_amt as dep_amt,0 as  withd_amt
	from emp_pforgratuity_sb_dtl 
	where deposit_no='$dep_no'
	and int_amt >0
	
	union

	select action_date,entry_time,'cash withdrawl' as particulars,0 as dep_amt,dep_amount as  withd_amt
	from emp_pforgratuity_sb_dtl 
	where deposit_no='$dep_no'
	and dep_amount< 0



)as a


order by a.entry_time desc;
	  ";
	$res=dBConnect($sql);
	//echo $sql;
	if(pg_NumRows($res)==0){
		echo "Not found!!!";
	}
	else {?>		<div align=center> <font size=+1>Statement</font><br>
		<table id="matTable" style="width:100%;" cellspacing="0" cellpadding="0" >

		<tr>
			<th>Date</th>
			<th>Particulars</th>
			<th>Deposit</th>
			<th>Withdrawl</th>
			<th>Balance</th>
			
	
		</tr>
		
		<?php 
		for($j=0;$j<pg_NumRows($res);$j++){
			$row=pg_fetch_array($res,$j);?>
			<tr>
				
				
				<td align='center'>
					<?php echo $row['dt_of_issue'] ;?>
				</td>


				<td align='center'>
					<?php echo $row['particulars'];?>
				</td>


				<td align='center'>
					<?php echo amount2Rs($row['dep_amt']);?>
				</td>


				<td align='center'>
					<?php echo amount2Rs(abs($row['withd_amt']));?>
				</td>


				<td align='center'>
					<?php   echo amount2Rs($amt)?>
				</td>
				
			</tr>
		<?
		if ( $row['dep_amt']>0) $amt=$amt- $row['dep_amt'];
		if ( abs($row['withd_amt'])>0) $amt=$amt+ abs($row['withd_amt']);
		
		}?>
		</table>
<?	}?>
</body>
</html>
