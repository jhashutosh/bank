<?
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$type=$_REQUEST['type'];
$current_date=$_REQUEST["current_date"];
if($menu=='pl'){$l_name='PLEDGE';}
if($menu=='ccl'){$l_name='Cash Credit';	}
if($menu=='kpl'){$l_name='Kishan Bikhash Pathra';}
if($menu=='spl'){$l_name='SMP';}
if($menu=='bdl'){$l_name='Bond';}
if($menu=='sfl'){$l_name='Staff';}
if($menu=='mt'){$l_name='MT';}
if($menu=='sgl'){$l_name='SHG';}
if(empty($current_date) ) { $current_date=date("d/m/Y"); }
echo "<script src=\"../JS/calendar.js\"></script>";
echo "<script language=\"JAVASCRIPT\">";
echo "function closeme() { close(); }";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\">";
$sql_statement="SELECT ln_list('$menu','$current_date')";
//echo $sql_statement;
$result=dBConnect($sql_statement);
echo "<font size=+2><b>Yearly Report For $l_name Loan: </font><br>";
echo "<hr>";
echo "<form name=\"f1\" action=\"consolidated_loan_list.php?menu=$menu\" method=\"POST\">";
echo "<table align=center bgcolor=\"#90EE90\"><tr><td  align=\"\"><b> Date as on :<td><input type=TEXT size=12 name=current_date id=cd value=$current_date $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.current_date,'dd/mm/yyyy','Choose Date')\">";
echo "<tr><td valign=\"top\" align=\"left\">Type:<td>";
makeSelect($loan_module_array,"type","");
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> ";
echo "</table></form>";
echo "<hr>";
$sql_statement="SELECT * FROM ln_pr_rec";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
echo "<table valign=\"top\" width=\"100%\">";
echo "<tr>";
$color="#FFDEAD";
echo "<th bgcolor=$color>Month</th>";
echo "<th bgcolor=$color>Opening<br>Balance(Rs.)</th>";
echo "<th bgcolor=$color>No. of Account</th>";
echo "<th bgcolor=$color>Total Loan Issue(Rs)</th>";
echo "<th bgcolor=$color>Principal Received(Rs)</th>";
echo "<th bgcolor=$color>Due Interest Received(Rs)</th>";
echo "<th bgcolor=$color>Over Due Interest Received(Rs) </th>";
echo "<th bgcolor=$color>Total Received(Rs)</th>";
echo "<th bgcolor=$color>Closing<br>Balance(Rs)</th>";
$color=$TSCOLOR;
for($j=0; $j<pg_NumRows($result); $j++) {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
echo "<tr>";
echo "<td bgcolor=Yellow >".$row['month_yr']."</td>";
$op_bal+=$row['op_bal'];
echo "<td bgcolor=$color align=\"RIGHT\"><a href=\"../general/con_ln_op_dtl.php?menu=$menu&months=".$row['month_yr']."&current_date=$current_date&id=".$row['op_bal']."\" target=\"_blank\">".amount2Rs($row['op_bal'])."</td>";
$no+=$row['no_of_account'];
echo "<td bgcolor=$color align=\"RIGHT\">".$row['no_acc']."</td>";

$loan_amount+=$row['loan_amount'];
echo "<td bgcolor=$color align=\"RIGHT\"><a href=\"../general/con_ln_iss_dtl.php?menu=$menu&months=".$row['month_yr']."&current_date=$current_date&id=".$row['tot_ln_iss']."\" target=\"_blank\">".amount2Rs($row['tot_ln_iss'])."</td>";
$p_received+=$row['p_received'];
echo "<td bgcolor=$color align=\"RIGHT\"><a href=\"../general/con_pr_dtl.php?menu=$menu&months=".$row['month_yr']."&current_date=$current_date&id=".$row['p_received']."\" target=\"_blank\">".amount2Rs($row['pr_rec'])."</td>";
$d_i_received+=$row['d_i_received'];
echo "<td bgcolor=$color align=\"RIGHT\">".amount2Rs($row['d_int_rec'])."</td>";
$od_i_received+=$row['od_i_received'];
echo "<td bgcolor=$color align=\"RIGHT\">".amount2Rs($row['od_int_rec'])."</td>";
$t_received+=$row['t_received'];
echo "<td bgcolor=$color align=\"RIGHT\">".amount2Rs($row['tot_rec'])."</td>";
$cl_bal+=$row['cl_bal'];
echo "<td bgcolor=$color align=\"RIGHT\">".amount2Rs($row['cl_bal'])."</td>";
 }
echo "<tr bgcolor=AQUA><td>";

echo "<td align=\"RIGHT\"><B</td>";
echo "<td align=\"RIGHT\">$no</td>";
echo "<td align=\"RIGHT\"><B>".amount2Rs($loan_amount)."</td>";
echo "<td align=\"RIGHT\"><B>".amount2Rs($p_received)."</td>";
echo "<td align=\"RIGHT\"><B>".amount2Rs($d_i_received)."</td>";
echo "<td align=\"RIGHT\"><B>".amount2Rs($od_i_received)."</td>";
echo "<td align=\"RIGHT\"><B>".amount2Rs($t_received)."</td>";
echo "<td align=\"RIGHT\"><B></td>";
}


?>
