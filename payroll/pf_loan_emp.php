<?
include "../config/config.php";
$TCOLOR='FFFF99';
$id=$_REQUEST['id'];
$name=$_REQUEST['name'];
echo "<HTML>";
echo "<HEAD>";
echo "<title>Pf loan Detail";
echo "</title>";
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

<?
echo "</HEAD>";
echo "<body bgcolor='white'><table align='center' id=\"matTable\" style=\"width:100%;\" cellspacing=\"0\" cellpadding=\"0\" >";
echo"<tr><td colspan='6' align='center' bgcolor='CCFFFF'>Provident Fund Loan Statement of <font color='CC0066' size='2'>&nbsp;&nbsp; ".ucwords($name)."</td></tr>"; 
echo "<tr>
<th bgcolor=$color  align='center' width='15%' rowspan=2>Date</th>";  
echo "<th bgcolor=$color  align='center' width='30%' colspan=2>Return</th>";  
echo "<th bgcolor=$color  align='center' width='30%' colspan=2>Balance</th>";  
echo "<th bgcolor=$color  align='center' width='25%' rowspan=2>Entry time</th></tr>";              
echo "<tr><th bgcolor=$color  align='center' width='15%'>Principal </th>";
echo "<th bgcolor=$color  align='center' width='15%'>Interest</th>";
echo "<th bgcolor=$color  align='center' width='15%'>Principal</th>";
echo "<th bgcolor=$color  align='center' width='15%'>Interest</th></tr>";
$sql="select date(substr(cast(entry_time as character varying),1,10)),r_principal,r_due_int,b_principal,b_due_int,entry_time from emp_pf_loan_dtl p where emp_id=$id order by entry_time desc ";
$result=dBConnect($sql);
$color='#CDCDCD';
$TBGCOLOR='#efefef';
for($j=0; $j<pg_NumRows($result); $j++)
 {
//$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
echo "<tr>";
echo "<td bgcolor=$color width='15%' align='center'>".$row['date']."</td>";
echo "<td bgcolor=$color width='15%' align='center'>".$row['r_principal']."</td>";
echo "<td bgcolor=$color width='15%' align='center'>".$row['r_due_int']."</td>";
echo "<td bgcolor=$color width='15%' align='center'>".$row['b_principal']."</td>";
echo "<td bgcolor=$color width='15%' align='center'>".$row['b_due_int']."</td>";
echo "<td bgcolor=$color width='25%' align='center'>".$row['entry_time']."</td></tr>";
}
echo "<tr>";
echo "<td bgcolor=$color width='15%' align='center'>$dt</td>";
echo "<td bgcolor=$color width='15%' align='center'></td>";
echo "<td bgcolor=$color width='15%' align='center'></td>";
echo "<td bgcolor=$color width='15%' align='center'>".$is_amt."</td>";
echo "<td bgcolor=$color width='15%' align='center'></td>";
echo "<td bgcolor=$color width='25%' align='center'>".$et."</td></tr>";
?>
