<!doctype html>
<?
include "../config/config.php";
$staff_id=verifyAutho();
?>
<html>
<head>
	<meta charset="utf-8">
	<title>SHG Report</title>
	<link rel="stylesheet" href="../JS/sandi-theme.css">
	<style type="text/css">
		*, *:after, *:before {
			box-sizing: border-box;
		}
		a{
			color: #303030;
			text-decoration: none;
		}
		input[type='submit']{
			outline: none;
			background-color: #f5f5f5;
			color: #505050;
			border: solid 1px #505050;
			padding: 7px;
			cursor: pointer;
		}
		input[type='submit']:hover{
			background-color: #505050;
			color: #f5f5f5;
		}
		.tradAccountDiv{
			margin-bottom: 60px;
		}
		.tradAccountTable{
			border-collapse: collapse;
			border-spacing: 0px;
			width: 100%;
			border: solid 1px #dcdcdc;
		}
		.tradAccountTable caption{
			background-color: #dcdcdc;	
			border: solid 1px #dcdcdc;		
			font-size: 1.4em;
			color: #404040;
			padding: 5px;
		}
		.tradAccountTable tbody .fieldHead{
			background-color: #f5f5f5;	
			font-size: 1.2em;
			color: #909090;
			padding: 5px;		
		}
		.tradAccountTable td,
		.tradAccountTable tbody td{
			border: solid 1px #000000;
			padding: 2px;	
		}
		.tradAccountTable tbody td:first-child{
			background-color: #f5f5f5;	
		}
		.tradAccountTable tbody td:hover:first-child{
			background-color: #dcdcdc;	
		}
		.tradAccountTable tbody tr:hover{
			background-color: #dcdcdc;	
		}
		.tradAccountTable tfoot td,		
		.tradAccountTable thead td{
			font-size: 1.2em;
			background-color: #e9e9e9;
			border: solid 1px #000000;
			text-align: center;	
		}
		.tradAccountTable tfoot td{
			text-align: right;
		}
		.error{
			background-color: rgba(255,0,0,0.4);
			border: solid 1px rgba(255,0,0,0.8);
			-moz-border-radius: 10px;
			-webkit-border-radius: 10px;
			-o-border-radius: 10px;
			border-radius: 10px;
			margin: 20px;
			margin-right: 25%;
			margin-left: 25%;
			width: 50%;
			height: 150px;
			padding: 10px;
		}
		.error center{
			font-size: 120%;
			font-weight: bolder;
		}
		.error:before{
			content:url();
		}
	</style> 
</head>
<body>
	<h2><?echo $SYSTEM_TITLE?></h2>
	<h4>SHG Loan Subsidy Report</h4>
	<hr/>
<form action="subsidy_shg.php">
<table align="center">
	<tr>
		<td>Subsidy (%):</td>
		<td>
		<input type="text" name="subsidy" class="s-text">
		</td>
		<td>Select Month:</td>
		<td>
		<select name="month">
			<option value="mar">Mar</option>
			<option value="sep">Sep</option>
		</select>
		</td>
		<td><INPUT TYPE="submit" value="Submit"></td>
	</tr>
</table>
<hr/>
</form>
<?if(!empty($_REQUEST["month"])){
$subsidy=($_REQUEST["subsidy"])/100;
$nonsubsidy=(1-$subsidy);//echo "$subsidy::::$nonsubsidy";
	if($_REQUEST["month"]=='mar'){
		$fy1=$_SESSION["fy"];
		$year=explode("-", $fy1);
		$year1=$year[0];
		$year2=$year[1];
		$fromDate="01/10/$year1";
		$toDate="31/03/$year2";
	}
	if($_REQUEST["month"]=='sep'){
		$fy1=$_SESSION["fy"];
		$year=explode("-", $fy1);
		$year=$year[0];
		$fromDate="01/04/$year";
		$toDate="30/09/$year";
	}
?>
		<div class='tradAccountDiv'>
			<?
			$sql_statement="SELECT upper(name1) as name,initcap(address11||' '||address12||' '||address13||' '||'PIN-'||pin1) address,'S.H.G' as type,'YES' as a_type,'Agriculture' as type_of,d.account_no,d.balance,d.interest,d.balance,round((d.interest*$nonsubsidy),2) as intr,round((d.interest*$subsidy),2) as sub_int FROM customer_master cm,(SELECT so.*,b.account_no FROM (SELECT fo.shg_no,s.* FROM shg_info fo,(SELECT z.customer_id,SUM(balance) as balance,SUM(interest) as interest FROM  (SELECT customer_id,x.* FROM loan_ledger_hrd hr,(SELECT foo.*,SUM(loan_amount-r_principal) as balance FROM loan_statement st,(SELECT loan_serial_no,SUM(r_due_int+r_overdue_int)as interest FROM loan_return_dtl where account_no LIKE 'SGL-%' and action_date BETWEEN '$fromDate' AND '$toDate' GROUP BY loan_serial_no HAVING SUM(r_due_int+r_overdue_int)>0) as foo where foo.loan_serial_no=st.loan_serial_no AND action_date<='$toDate' GROUP BY foo.loan_serial_no,foo.interest)as x where x.loan_serial_no=hr.loan_serial_no) z GROUP BY z.customer_id) s where s.customer_id=fo.customer_id) so left join(SELECT account_no,customer_id FROM customer_account ca where account_type='sb') as b  on b.customer_id=so.customer_id) as d where cm.customer_id=d.customer_id;
";
			//echo "$sql_statement";		
			$result=dBConnect($sql_statement);
			if (pg_NumRows($result)>0) {
			?>
			<table class='tradAccountTable' align='center'>
				<caption></caption>
				<thead>
					<tr>
						<td rowspan=2>Srl No</td>
						<td rowspan=2>Name of S.H.G.</td>
						<td rowspan=2>Address</td>
						<td rowspan=2>Category</td>
						<td rowspan=2>Whether enrolled with Local Panchayet/Municipality</td>
						<td rowspan=2>Activity of the S.H.G.</td>
						<td rowspan=2>S/B A/c No of S.H.G.</td>
						<td colspan=3>Loan Outstanding as on <?echo $date?></td>
						<td rowspan=2>Interest @<?echo $nonsubsidy*100?>%</td>
						<td rowspan=2>Eligible Interest subsidy (@<?echo $subsidy*100?>%)</td>
					</tr>
					<tr>
						<td>Principal Outstanding</td>
						<td>Interest relised(@10%)</td>
						<td>Total Outstanding</td>
					</tr>				
				</thead>
				<tbody>
					<?
					for($i=0; $i<pg_NumRows($result); $i++){
					$row=pg_fetch_array($result,$i);
					?>
						<tr>
							<td><?php echo ($i+1);?></td>	
							<td><?php echo $row[0];?></td>	
							<td><?php echo $row[1];?></td>
							<td><?php echo $row[2];?></td>	
							<td><?php echo $row[3];?></td>	
							<td><?php echo $row[4];?></td>	
							<td><?php echo $row[5];?></td>	
							<td><?php echo $row[6];?></td>	
							<td><?php echo $row[7];?></td>	
							<td><?php echo $row[8];?></td>	
							<td><?php echo $row[9];?></td>	
							<td><?php echo $row[10];?></td>	
							<td><?php echo $row[11];?></td>	

						</tr>
					<?}?>
				</tbody>
			<table>
			<?}
			else{
				echo "<div class='error'>
				<center>No Record Found</center>
				</div>";
			}?>
		</div>
<?}?>
</body>
</html>
