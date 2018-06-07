<?php 
include "../config/config.php";
$menu=$_REQUEST['menu']; 
$staff_id=verifyAutho();
$fy=$_SESSION['fy'];
$mdate=$_REQUEST['mdate'];
if(empty($mdate)){$mdate=date('d.m.Y');}
$sql_statement="SELECT demand_list_loan('$mdate') As monthly";
//echo $sql_statement;
$result=dBConnect($sql_statement);
$name=pg_result($result,'monthly');
echo "<html>";
echo "<head>";
echo "<title>List of accounts";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<hr>";
echo "<form METHOD=\"POST\" ACTION=\"demand_loan_rpt.php\">";
echo "<table align=center bgcolor=\"#90EE90\">";
echo"<tr><td><b>Return Month as on :<td>";
echo"<input type=TEXT size=12 name=\"mdate\" id=cd Value=\"$mdate\" onclick=\"this.value=''\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> ";
echo "</table></form>";
echo "<hr>";

echo "<table bgcolor=\"#0000CD\" width=\"100%\" align=\"center\">";
$color="#CCCC0000";
echo "<tr>";
echo "<th colspan=\"15\" bgcolor=\"green\"><font color=WHITE size=\"4\" align=\"center\">Demand Collection and Balance Statement as on $mdate";
echo "<tr>";
echo "<th rowspan=\"3\" bgcolor=\"$color\">Serial No.</th>";
echo "<th rowspan=\"3\" bgcolor=\"$color\">Type of Loan</th>";
echo "<th colspan=\"6\" bgcolor=\"$color\">Principal</th>";
echo "<th rowspan=\"3\" bgcolor=\"$color\">Percentage of collection to Demand under principal</th>";
echo "<th colspan=\"6\" bgcolor=\"$color\">Interest</th>";
echo "<tr>";
echo "<th colspan=\"3\" bgcolor=\"$color\">Demand</th>";
echo "<th colspan=\"2\" bgcolor=\"$color\">Collection</th>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">Balance</th>";
echo "<th colspan=\"3\" bgcolor=\"$color\">Demand</th>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">Total Collection</th>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">Of which repaid<br> in advance</th>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">Balance</th>";
echo "<tr>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Arrears</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Current(including)<br>advance repayment)</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Total</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Total Collection</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Of which repaid <br>in advance</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Arrears</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Current</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Total</th>";

echo "<tr>";
echo "<th bgcolor=\"$color\">1</th>";
echo "<th bgcolor=\"$color\">2</th>";
echo "<th bgcolor=\"$color\">3</th>";
echo "<th bgcolor=\"$color\">4</th>";
echo "<th bgcolor=\"$color\">(3+4)=5</th>";
echo "<th bgcolor=\"$color\">6</th>";
echo "<th bgcolor=\"$color\">7</th>";
echo "<th bgcolor=\"$color\">(5-6)=8</th>";
echo "<th bgcolor=\"$color\">9</th>";
echo "<th bgcolor=\"$color\">10</th>";
echo "<th bgcolor=\"$color\">11</th>";
echo "<th bgcolor=\"$color\">(10+11)=12</th>";
echo "<th bgcolor=\"$color\">13</th>";
echo "<th bgcolor=\"$color\">14</th>";
echo "<th bgcolor=\"$color\">(12-13)=15</th>";

//$sql_statement="SELECT  * FROM monthly_return_loan ";
$sql_statement="SELECT loan_type,sum(r_p) as r_p,sum(r_d) as r_d,sum(r_od) as r_od,sum(r_t) as r_t,sum(d_i) as d_i,sum(d_p) as d_p,sum(od_i) as od_i,sum(od_p) as od_p FROM monthly_return_loan group by loan_type";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
for($j=0; $j<pg_NumRows($result); $j++){
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
echo "<tr>";
echo "<td bgcolor=\"$color\"><b>".($j+1);
echo "<td bgcolor=\"$color\"><b>".$type_of_account1_array[$row[0]]."</td>";
$t_col3+=$row['od_p'];
echo "<td align=right bgcolor=\"$color\">".amount2Rs($row['od_p'])."</td>";
$t_col4+=$row['d_p'];
echo "<td align=right bgcolor=\"$color\">".amount2Rs($row['d_p'])."</td>";
$demand_p=$row['od_p']+$row['d_p'];
$t_col5+=$demand_p;
echo "<td align=right bgcolor=\"$color\">".amount2Rs($demand_p)."</td>";
$recovery_p=$row['r_p']+$row['r_t'];
$t_col6+=$recovery_p;
echo "<td align=right bgcolor=\"$color\">".amount2Rs($recovery_p)."</td>";
$t_col7+=$row['r_p'];
echo "<td align=right bgcolor=\"$color\">".amount2Rs($row['r_p'])."</td>";
$t_col8+=$demand_p-$recovery_p;
echo "<td align=right bgcolor=\"$color\">".amount2Rs($demand_p-$recovery_p)."</td>";
echo "<td align=right bgcolor=\"$color\">0%</td>";
$t_col9+=$row['od_i'];
echo "<td align=right bgcolor=\"$color\">".amount2Rs($row['od_i'])."</td>";
$t_col10+=$row['d_i'];
echo "<td align=right bgcolor=\"$color\">".amount2Rs($row['d_i'])."</td>";
$demand_i=$row['od_i']+$row['d_i'];
$t_col11+=$demand_i;
echo "<td align=right bgcolor=\"$color\">".amount2Rs($demand_i)."</td>";
$recovery_i=$row['r_d']+$row['r_od'];
$t_col12+=$recovery_i;
echo "<td align=right bgcolor=\"$color\">".amount2Rs($recovery_i)."</td>";
$t_col3+=$row['r_d'];
echo "<td align=right bgcolor=\"$color\">".amount2Rs($row['r_d'])."</td>";
$t_col14+=$demand_i-$recovery_i;
echo "<td align=right bgcolor=\"$color\">".amount2Rs($demand_i-$recovery_i)."</td>";
}
}
$color='AQUA';
echo "<tr>";
echo "<th colspan=\"2\" bgcolor=\"$color\"> Total";
echo "<th align=right bgcolor=\"$color\" >".amount2Rs($t_col3);
echo "<th align=right bgcolor=\"$color\" >".amount2Rs($t_col4);
echo "<th align=right bgcolor=\"$color\" >".amount2Rs($t_col5);
echo "<th align=right bgcolor=\"$color\" >".amount2Rs($t_col6);
echo "<th align=right bgcolor=\"$color\" >".amount2Rs($t_col7);
echo "<th align=right bgcolor=\"$color\" >".amount2Rs($t_col8);
echo "<th align=right bgcolor=\"$color\" >";
echo "<th align=right bgcolor=\"$color\" >".amount2Rs($t_col9);
echo "<th align=right bgcolor=\"$color\" >".amount2Rs($t_col10);
echo "<th align=right bgcolor=\"$color\" >".amount2Rs($t_col11);
echo "<th align=right bgcolor=\"$color\" >".amount2Rs($t_col12);
echo "<th align=right bgcolor=\"$color\" >".amount2Rs($t_col13);
echo "<th align=right bgcolor=\"$color\" >".amount2Rs($t_col14);
echo "</table>";
echo "</body>";
echo "</html>";
?>