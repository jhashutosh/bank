<?
include "../config/config.php";
//$TCOLOR='FFFF99';
echo "<HTML>";
echo "<HEAD>";
echo "<title>Salary Register Detail";
echo "</title>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";?>
<style>

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
		font-size: .8em;
		background-color: #efefef;
		padding: 3px;
	}
	#matTable td{
		padding: 3px;
		height: 50px;
	}
</style>

<?echo "</HEAD>";
echo "<body bgcolor=''><table align='center' id=\"matTable\" style=\"width:100%;\" cellspacing=\"0\" cellpadding=\"0\" >";
echo"<caption>Provident Fund Loan Statement</caption>";
echo "<tr>";
echo "<th  align='center' width='3%' rowspan=2>Id</th>";
echo "<th  align='center' width='13%' rowspan=2>Name</th>"; 
echo "<th  align='center' width='13%' rowspan=2>PF Loan Acc No.</th>"; 
echo "<th  align='center' width='13%' rowspan=2>Loan Date</th>";
echo "<th  align='center' width='13%' rowspan=2>Repay Date</th>";
echo "<th  align='center' width='13%' rowspan=2>Actual Amount</th>";
echo "<th  align='center' width='13%' rowspan=2>Interest Rate</th>";
echo "<th  align='center' width='13%' colspan=2>Balance</th></tr>";
echo"<tr><th>Principal</th><th>Interest</th></tr>";
$sql="select * from emp_pf_loan_hrd a,emp_master b where a.emp_id=b.emp_id";
$result=dBConnect($sql);
for($j=0; $j<pg_NumRows($result); $j++)
 {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
echo "<tr><td bgcolor=$color  align='center' width='3%'><a href=\"pf_loan_emp.php?id=".$row['emp_id']."&name=".$row['name']."&is_amt=".$row['actual_amt']."&dt=".$row['loan_date']."&et=".$row['entry_time']."\">".$row['emp_id']."</td></h5>";
echo "<td bgcolor=$color  align='center' width='13%'>".ucwords($row['name'])."</td>"; 
echo "<td bgcolor=$color  align='center' width='13%'>".$row['pf_loan_ac_no']."</td>"; 
echo "<td bgcolor=$color  align='center' width='13%'>".$row['loan_date']."</td>";                                            
echo "<td bgcolor=$color  align='center' width='13%'>".$row['repay_date']."</td>";
//echo "<h5><td bgcolor=$color  align='center' width='13%'>".$row['applied_amt']."</td></h5>";
echo "<td bgcolor=$color  align='center' width='13%'>".$row['actual_amt']."</td>";
echo "<td bgcolor=$color  align='center' width='13%'>".$row['int_due_rate']."</td>";
echo "<td bgcolor=$color  align='center' width='13%'>".$row['b_principal']."</td>";
echo "<td bgcolor=$color  align='center' width='13%'>".$row['b_interest']."</td>";
echo"</tr>";
}
echo"</table></body>";

