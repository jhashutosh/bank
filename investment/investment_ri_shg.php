<?
include "../config/config.php";
$menu=$_REQUEST['menu'];
$staff_id=verifyAutho();
$account_no=$_REQUEST["account_no"];
$id=$_REQUEST['id'];

$fy=$_SESSION['fy'];
getDetailFy($fy,&$f_start_dt,&$f_end_dt);
$start_date=$_REQUEST["start_date"];
if(empty($start_date) ) { $start_date=$f_end_dt; }
$withdrawal_date=$_REQUEST['$withdrawal_date'];

echo "<HTML>";
echo "<HEAD>";
echo "<TITLE>Statement</TITLE>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script language=\"JAVASCRIPT\">";
echo "function closeme() { close(); }";
echo "</script>";
echo "</HEAD>";
echo "<BODY bgcolor=\"SILVER\">";
$flag=1;
if($flag==1){
//$sql_statement="SELECT * FROM bk_investment where  withdrawal_date is null and account_type='ri' and op_date<='$start_date'";
$sql_statement="SELECT * FROM bk_investment where (withdrawal_date not in(select withdrawal_date FROM bk_investment where withdrawal_date<='$start_date') or withdrawal_date is null)and account_type='rs' and op_date<='$start_date'";
echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h1><center><font color=Green>New Account!!!!!</center></font></h1>";
} 
else {
echo "<table valign=\"top\" width=\"100%\">";
echo "<tr><td bgcolor=\"BLUE\" colspan=\"9\" align=\"center\"><font color=\"white\"><B>$SYSTEM_TITLE<B></font><font size=+1 color=\"white\"></font>";
echo "<tr><td bgcolor=\"BLUE\" colspan=\"9\" align=\"center\"><font color=\"white\"><B>$VILL_DEFAULT****$DISTRIC_DEFAULT<B></font><font size=+1 color=\"white\"></font>";
$color="GREEN";
echo "<tr>";
echo "<th bgcolor=$color width=\"100\">Sl No.</th>";
echo "<th bgcolor=$color width=\"90\">Name Of Bank.</th>";
//echo "<th bgcolor=$color  width=\"100\">Tran Id.</th>";
//echo "<th bgcolor=$color width=\"75\">Receipt No.</th>";
echo "<th bgcolor=$color width=\"75\">A/C No.</th>";
echo "<th bgcolor=$color width=\"75\">Opening Date.</th>";
echo "<th bgcolor=$color width=\"75\">Principal.</th>";
echo "<th bgcolor=$color width=\"75\">Rate Of Int.</th>";
echo "<th bgcolor=$color>Date Of Maturity.</th>";
echo "<th bgcolor=$color width=\"75\">Maturity Value.</th>";
echo "<th bgcolor=$color width=\"75\">Interest Receivable.</th>";
for($j=1; $j<=pg_NumRows($result); $j++){
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j-1));
echo "<tr>";
echo "<td align=right bgcolor=$color  width=\"90\">".($j)."</td>";
echo "<td align=right bgcolor=$color width=\"75\">".$row['b_name']."</td>";
//echo "<td align=right bgcolor=$color width=\"75\">".$row['t_id']."</td>";
//echo "<td align=right bgcolor=$color>".$row['r_no']."</td>";
echo "<td align=right bgcolor=$color  width=\"90\">".$row['account_no']."</td>";
echo "<td align=right bgcolor=$color width=\"75\">".$row['op_date']."</td>";
echo "<td align=right bgcolor=$color width=\"75\">".$row['principal']."</td>";
echo "<td align=right bgcolor=$color>".$row['interest_rate']."</td>";
echo "<td align=right bgcolor=$color width=\"75\">".$row['maturity_date']."</td>";
echo "<td align=right bgcolor=$color width=\"75\">".$row['maturity_amount']."</td>";
echo "<td align=right bgcolor=$color>".$row['int_receive']."</td>";
$totalprincipal=$totalprincipal+$row['principal'];
$totalmaturityamount=$totalmaturityamount+$row['maturity_amount'];

   }

echo "<tr>";
$color="cyan";
echo "<td align=center bgcolor=$color><B>Total Account:".($j-1)." </B></td>";
echo "<td align=right bgcolor=$color><B></B></td>";
echo "<td align=right bgcolor=$color><B></B></td>";
echo "<td align=right bgcolor=$color><B></B></td>";
echo "<td align=right bgcolor=$color><B>".$totalprincipal."</B></td>";
echo "<td align=right bgcolor=$color><B></B></td>";
echo "<td align=right bgcolor=$color><B></B></td>";
echo "<td align=right bgcolor=$color><B>".$totalmaturityamount."</B></td>";
echo "<td align=right bgcolor=$color><B></B></td>";
echo "<br>";
	
echo "</table>";
 	}
}
else{
echo "Invalid Input !!!!!!!!!!!!!!";
}

if(!empty($op)){
echo "<DIV ID=\"date_time\" style=\"position:relative; left:5; top:5\">";
echo "<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> </DIV> ";
}
?>
