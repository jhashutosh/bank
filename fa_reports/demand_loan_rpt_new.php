<? 
include "../config/config.php";
$menu=$_REQUEST['menu']; 
$staff_id=verifyAutho();
$fy=$_SESSION['fy'];
$mdate=$_REQUEST['mdate'];
echo "<html>";
echo "<head>";
echo "<title>List of accounts";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../../css/test.css\" />";
?>
<link rel="stylesheet" href="../JS/themes/base/jquery.ui.all.css">
	<script src="../JS/jquery-1.9.1.js"></script>
	<script src="../JS/ui/jquery.ui.core.js"></script>
	<script src="../JS/ui/jquery.ui.widget.js"></script>
	<script src="../JS/ui/jquery-ui-1.10.3.custom.min.js"></script>
<script type="text/javascript">

$(function(){
	$("#mdate").datepicker({dateFormat :'dd/mm/yy'});
});
</script>
<?
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<hr>";
echo "<form METHOD=\"POST\" ACTION=\"demand_loan_rpt_new.php\">";
echo "<table align=center bgcolor=\"#adadad\">";
echo"<tr><td><b>Return Month as on :</td>";
echo"<td><input type=TEXT name=\"mdate\" id='mdate' Value=\"".date('d/m/Y')."\"></td>";
echo "<td><input type=\"Submit\"  value=\"Enter\"></td>";
echo "<td align='right'><input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"></td>";
echo "</table></form>";
if(empty($mdate)){
echo "<div align='center' bgcolor=\"#ffffff\" style='color:red;text-align:center'>
<font size='6' style='float:both'>Please Enter Date to View Report</font>
</div>";
}
echo "<hr>";
echo "<table bgcolor=\"#606060\" width=\"100%\" align=\"center\" border=1 cellspacing=0>";
$color="#adadad";
echo "<tr>";
echo "<th colspan=\"15\" bgcolor=\"#606060\"><font color=WHITE size=\"5\" align=\"center\">Demand Collection and Balance Statement as on $mdate";
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
echo "<th bgcolor=\"$color\">(12-13)=15</th></tr>";
if(!empty($mdate)){
$sql_statement="select ln_dmd_col_rpt('$mdate','n');";
//$result=dBConnect($sql_statement1);
$sql_statement.="FETCH all from n;";
//echo $sql_statement;
$result=dBConnect($sql_statement);
$TCOLOR='#ffffff';
$TBGCOLOR='#dfdfdf';
	if(pg_NumRows($result)>0){
	for($j=0; $j<pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);

$srl=$row['srl'] ;
$ln_typ=$row['ln_typ'] ;
$pr_arr_dmd=$row['pr_arr_dmd'] ;$t1+=$pr_arr_dmd;
$cr_pr_dmd_incl_adv=$row['cr_pr_dmd_incl_adv'] ;$t2+=$cr_pr_dmd_incl_adv;
$col_5=$row['col_5']    ; $t3+=$col_5;
$prd_pr_coll=$row['prd_pr_coll'] ; $t4+=$prd_pr_coll;
$adv_pr_rpy=$row['adv_pr_rpy'] ;    $t5+=$adv_pr_rpy;
$col_8=$row['col_8']    ; $t6+=$col_8;
$prcnt_coll_dmd=$row['prcnt_coll_dmd'] ;
$int_arr_dmd=$row['int_arr_dmd'] ; $t7+=$int_arr_dmd;
$cr_int_dmd=$row['cr_int_dmd'] ;   $t8+=$cr_int_dmd;
$col_12=$row['col_12']   ; $t9+=$col_12;
$prd_int_coll=$row['prd_int_coll'] ; $t10+=$prd_int_coll;
$adv_int_rpy=$row['adv_int_rpy'] ;   $t11+=$adv_int_rpy;
$col_15=$row['col_15'];$t12+=$col_15;

echo "<tr><td  bgcolor=\"$color\" height='35' align=center>$srl</td>";
echo "<td  bgcolor=\"$color\">$ln_typ</td>";
echo "<td  bgcolor=\"$color\" align=right>".amount2Rs($pr_arr_dmd)."</td>";
echo "<td  bgcolor=\"$color\" align=right>".amount2Rs($cr_pr_dmd_incl_adv)."</td>";
echo "<td  bgcolor=\"$color\" align=right>".amount2Rs($col_5)."</td>";
echo "<td  bgcolor=\"$color\" align=right>".amount2Rs($prd_pr_coll)."</td>";
echo "<td  bgcolor=\"$color\" align=right>".amount2Rs($adv_pr_rpy)."</td>";
echo "<td  bgcolor=\"$color\" align=right>".amount2Rs($col_8)."</td>";
echo "<td  bgcolor=\"$color\" align=right>".amount2Rs($prcnt_coll_dmd)."</td>";
echo "<td  bgcolor=\"$color\" align=right>".amount2Rs($int_arr_dmd)."</td>";
echo "<td  bgcolor=\"$color\"  align=right>".amount2Rs($cr_int_dmd)."</td>";
echo "<td  bgcolor=\"$color\" align=right>".amount2Rs($col_12)."</td>";
echo "<td  bgcolor=\"$color\" align=right>".amount2Rs($prd_int_coll)."</td>";
echo "<td  bgcolor=\"$color\" align=right>".amount2Rs($adv_int_rpy)."</td>";
echo "<td  bgcolor=\"$color\" align=right>".amount2Rs($col_15)."</td></tr>";
	}
	}
}

$color='#9d9d9d';
echo "<tr>";
echo "<th colspan=\"2\" bgcolor=\"$color\"> Total";
echo "<th align=right bgcolor=\"$color\" >".amount2Rs($t1);
echo "<th align=right bgcolor=\"$color\" >".amount2Rs($t2);
echo "<th align=right bgcolor=\"$color\" >".amount2Rs($t3);
echo "<th align=right bgcolor=\"$color\" >".amount2Rs($t4);
echo "<th align=right bgcolor=\"$color\" >".amount2Rs($t5);
echo "<th align=right bgcolor=\"$color\" >".amount2Rs($t6);
echo "<th align=right bgcolor=\"$color\" >";
echo "<th align=right bgcolor=\"$color\" >".amount2Rs($t7);
echo "<th align=right bgcolor=\"$color\" >".amount2Rs($t8);
echo "<th align=right bgcolor=\"$color\" >".amount2Rs($t9);
echo "<th align=right bgcolor=\"$color\" >".amount2Rs($t10);
echo "<th align=right bgcolor=\"$color\" >".amount2Rs($t11);
echo "<th align=right bgcolor=\"$color\" >".amount2Rs($t12);
echo "</table>";
echo "</body>";
echo "</html>";
?>
