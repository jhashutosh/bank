<?include "../config/config.php";
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
	<link rel="stylesheet" href="../JS/themes/base/jquery.ui.all.css">    
	<LINK href="../JS/register.css" type="text/css" rel="STYLESHEET">
	<link rel="stylesheet" href="../css/test.css">
	<link rel="stylesheet" href="../JS/daterange.css">
	<script src="../JS/jquery-1.9.1.js"></script>
	<script src="../JS/ui/jquery-ui-1.10.3.custom.min.js"></script>	
	<script src="../JS/jquery.daterange.min.js"></script>
	<script type="text/javascript">
		$(function(){
			$("#tabs").tabs();
			var serverDate=document.getElementById("serverDate").value;
			var fy=document.getElementById("fy").value;
			$('table').dateRange({
				today: serverDate,
				fromDate: "#fromDate",
				toDate: "#toDate",
				fy: fy
			});
			$("#regType").change(function(){
				if(this.value != '' && this.value !=null){
					var msg="";
					if($("#fromDate").val()=='' ||$("#fromDate").val()===null)
					{msg+="Enter From Date.\n";
					document.getElementById('fromDate').focus();}
					if($("#toDate").val()=='' ||$("#toDate").val()===null)
					{msg+="Enter To Date.\n";
					document.getElementById('toDate').focus();}
					if(msg==""){
						document.reportForm.submit();
					}
					else{alert(msg);document.reportForm.reset(); return false;}
				}
			});
		});
	</script>
	<style type="text/css">
		*, *:after, *:before {
			box-sizing: border-box;
		}
		button,
		input[type='submit']{
			outline: none;
			background-color: #f5f5f5;
			color: #505050;
			border: solid 1px #505050;
			padding: 7px;
			cursor: pointer;
		}
		button:hover,
		input[type='submit']:hover{
			background-color: #505050;
			color: #f5f5f5;
		}
		.regReportDiv{
			margin-left: auto;
			margin-right: auto;
		}
		.regReport{
			border-collapse: collapse;
			border-spacing: 0px;
			min-width: 70%;
			width: 100%;
			border: solid 1px #000;
		}
		.regReport caption{
			background-color: #000;	
			border: solid 1px #cdcdcd;		
			font-size: 1.4em;
			color: #cdcdcd;
			padding: 5px;
		}
		.regReport tbody td{
			border: solid 1px #000;	
		}
		.regReport tr{
			background-color: #cdcdcd;
		}
		.regReport tbody tr:hover{
			background-color: #dcdcdc;	
		}
		.regReport tfoot td,	
		.regReport thead td{
			font-size: 1.2em;
			color: #cdcdcd;
			background-color: #000;
			border: solid 1px #cdcdcd;	
		}
	</style>
</head>
<body>
<div id="tabs">
	<ul>
		<li><a href="#date-ranger">Report Shown by Date Range</a></li>
		<li><a href="#month-year">Report Shown by Month Year</a></li>
	</ul>
	<div id='date-ranger'>
		<form name='reportForm' action='register.php'>
		<div id="dateRange" align="center" style="width:100%">
			<table class='dateRangeTable' align="center">
				<tr>
					<input type="hidden" name="fy" id="fy" value=<?echo $_SESSION["fy"]?> >
					<input type="hidden" name="serverDate" id="serverDate" value=<?echo Date('d/m/Y')?> >
					<td align="right">
					<label for="formDate">Date From :</label>  <font color='red'>*</font>
					</td>
					<td align="left">
						<input type="TEXT" name="fromDate" id="fromDate" readonly class="s-text1" size="10">
					</td>
					<td align="right">
					<label for="toDate">Date To :</label> <font color='red'>*</font>
					</td>
					<td align="left">
						<input type="TEXT" name="toDate" id="toDate" readonly class="s-text1" size="10">
					</td>
					<td><button>Show</button></td>
				</tr>
			</table>
		</div>
		</form>
	</div>
	<div id='month-year'>
		<form name='reportForm1' action='register.php'>
		<select name='month' id='month'>
			<option value=''>Select</option>
			<option value='APR'>APR</option>
			<option value='MAY'>MAY</option>
			<option value='JUN'>JUN</option>
			<option value='JUL'>JUL</option>
			<option value='AUG'>AUG</option>
			<option value='SEP'>SEP</option>
			<option value='OCT'>OCT</option>
			<option value='NOV'>NOV</option>
			<option value='DEC'>DEC</option>
			<option value='JAN'>JAN</option>
			<option value='FEB'>FEB</option>
			<option value='MAR'>MAR</option>
		</select>
	<input type="TEXT" name="year" id="year" size="10">
	<button>Show</button>
		</form>
	</div>
</div>
<div class='regReportDiv'>
	<?
		if ((!empty($_REQUEST['fromDate']) && !empty($_REQUEST['toDate'])) || (
				!empty($_REQUEST['month']) && !empty($_REQUEST['year']))) {

		$fromDate=$_REQUEST['fromDate'];
		$toDate=$_REQUEST['toDate'];
		$year=$_REQUEST['year'];
		$month=$_REQUEST['month'];
		$month_year=$month."-".$year;
		if (!empty($_REQUEST['fromDate']) && !empty($_REQUEST['toDate'])) {
			$sql_statement="select * from ccb_dp_dtls_glnc (null,'2014/04/01','2014/07/02','ref'); fetch all from ref;";
			$reportHead="Report between ".$fromDate." and ".$toDate;
		}
		elseif(!empty($_REQUEST['month']) && !empty($_REQUEST['year'])){
			$sql_statement="select * from ccb_dp_dtls_glnc ('$month_year',null,null,'ref'); fetch all from ref;";
			$reportHead="Report of ".$month_year;
		}
		//echo $sql_statement;
		$result=dBConnect($sql_statement);?>
		<table class='regReport' align='center'>
			<caption><?echo $reportHead?></caption>
			<thead><tr>
				<td>SRL</td>
				<td>ACCOUNT NO.</td>
				<td>BANK (BRANCH)</td>
				<td>TYPE OF A/C</td>
				<td>OP. BALANCE</td>
				<td>DEPOSIT</td>
				<td>WITHDRAWAL</td>
				<td>INT. RECEIVED</td>
				<td>CHARGES</td>
				<td>CL. BALANCE</td>
				<td>INT. RECEIVABLE</td>
			</tr></thead>
			<tbody>
		<?for($i=0; $i<pg_NumRows($result)-1; $i++){
		$row=pg_fetch_array($result,$i);?>
			<tr>
				<td><?php echo $row[0];?></td>
				<td><?php echo $row[1];?></td>
				<td><?php echo $row[2];?></td>
				<td><?php echo $row[3];?></td>
				<td align="right"><?php echo $row[4];?></td>
				<td align="right"><?php echo $row[5];?></td>
				<td align="right"><?php echo $row[6];?></td>
				<td align="right"><?php echo $row[7];?></td>
				<td align="right"><?php echo $row[8];?></td>
				<td align="right"><?php echo $row[9];?></td>
				<td align="right"><?php echo $row[10];?></td>
			</tr>
		<?}
		echo"</tbody>";
		$row=pg_fetch_array($result,$i);?>
			<tfoot><tr>
				<td colspan=2><?php echo $row[1];?></td>
				<td colspan=2><?php echo $row[2];?></td>
				<td align="right"><?php echo $row[4];?></td>
				<td align="right"><?php echo $row[5];?></td>
				<td align="right"><?php echo $row[6];?></td>
				<td align="right"><?php echo $row[7];?></td>
				<td align="right"><?php echo $row[8];?></td>
				<td align="right"><?php echo $row[9];?></td>
				<td align="right"><?php echo $row[10];?></td>
			</tr></tfoot>
	</table>
	<?}?>
</div>
</body>
<html>
