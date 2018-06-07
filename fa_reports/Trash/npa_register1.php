<?
include "../config/config.php";
$staff_id=verifyAutho();
getDetailFy($fy,&$f_start_dt,&$f_end_dt);
if(empty($start_date) ) { $start_date=$f_start_dt; }
$end_date=$_REQUEST["end_date"];
if(empty($end_date) ) { $end_date=$f_end_dt;}
$menu=$_REQUEST['menu'];
$type=$_REQUEST['type'];
if(empty($menu)){$type='All';}
else{$type=$loan_module_array[trim($menu)];}
$menu=getIndex($loan_module_array,$type);
echo "<body bgcolor=\"silver\">";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<font size=+3>$SYSTEM_TITLE</font> <br><font size=+1><b>Report Date:".date('d.m.Y')."::".getPrintTime()."</b></font><hr>";
echo "<form name=\"f1\" action=\"npa_register.php?menu=$menu\" method=\"POST\" onsubmit=\"return check();\">";
echo "<table align=center bgcolor=\"#90EE90\"><tr><th  align=\"\">NAP Statement As On(dd/mm/yyyy):<th><input TYPE=\"text\" NAME=\"end_date\" ID=\"end_date\" size=\"10\" VALUE=\"$end_date\" $HIGHLIGHT>";
echo "<th>Loan Module :<td>";
makeSelect($loan_module_array,'type',$type);
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> ";
echo "</table></form>";
echo "<hr>";
//-------------------------------------------------------------------------------------------
$sql_statement="truncate table loan_cal_int;SELECT loan_calculation('$menu','$end_date') as int;";
$sql_statement.="SELECT loan_type,round(SUM(issue_amount)) AS loan_amount,round(SUM(standard)) AS standard,round(SUM(sub)) AS sub,round(SUM(d1)) AS d1,round(SUM(d2)) AS d2,round(SUM(d3)) AS d3,round(SUM(unsecured_asset)) AS unsecured_asset,round(SUM(loss_asset)) AS loss_asset,SUM(balance_principal) AS balance_principal,SUM(due_int) AS due_int,SUM(overdue_int) AS overdue_int FROM npa_vw GROUP BY loan_type";
if($menu!='all'){
$sql_statement.=" HAVING loan_type='$menu'";
}
else{
$sql_statement.=" ORDER BY loan_type";
}
//echo $sql_statement; 
$result=dBConnect($sql_statement);
echo "<Table bgcolor=\"Black\" width=\"100%\" >";
echo "<tr><th bgcolor=\"Yellow\" colspan=\"21\" align=center><font color=\"BLACK\">NPA Register for $type Module</font>";
$color="skyblue";
echo "<tr>";
//echo "<th bgcolor=$color Rowspan=\"2\">Account<br>No</th>";
//echo "<th bgcolor=$color Rowspan=\"2\">Name</th>";
echo "<th bgcolor=$color Rowspan=\"2\">Loan<br>Type</th>";
echo "<th bgcolor=$color Rowspan=\"2\">Loan<br>Amount</th>";
echo "<th bgcolor=$color Rowspan=\"2\">Loan<br>Recovery</th>";
echo "<th bgcolor=$color Colspan=\"3\">Balance</th>";
//echo "<th bgcolor=$color Rowspan=\"2\">Issue<br>Date</th>";
echo "<th bgcolor=$color Colspan=\"2\">Standard<br>(Below 1 year)</th>";
echo "<th bgcolor=$color Colspan=\"2\">Sub-Standard<br>(1year to 3 year)</th>";
echo "<th bgcolor=$color Colspan=\"2\">Doubtful-1<br>(3 year to 4 year)</th>";
echo "<th bgcolor=$color Colspan=\"2\">Doubtful-2<br>(4yrs to 6 yrs)</th>";
echo "<th bgcolor=$color Colspan=\"2\">Doubtful-3<br>(above 6 year)</th>";
echo "<th bgcolor=$color Colspan=\"2\">Unsecure Assets</th>";
echo "<th bgcolor=$color Colspan=\"2\">Loss Assets</th>";

echo "<tr>";
echo "<th bgcolor=$color >Pincipal</th>";
echo "<th bgcolor=$color >Due Int.</th>";
echo "<th bgcolor=$color >OverDue Int.</th>";
echo "<th bgcolor=$color>Principal</th>";
echo "<th bgcolor=$color >0%</th>";
echo "<th bgcolor=$color>Principal</th>";
echo "<th bgcolor=$color >5%</th>";
echo "<th bgcolor=$color>Principal</th>";
echo "<th bgcolor=$color >10%</th>";
echo "<th bgcolor=$color>Principal</th>";
echo "<th bgcolor=$color >15%</th>";
echo "<th bgcolor=$color>Principal</th>";
echo "<th bgcolor=$color >50%</th>";
echo "<th bgcolor=$color>Principal</th>";
echo "<th bgcolor=$color >100%</th>";
echo "<th bgcolor=$color>Principal</th>";
echo "<th bgcolor=$color >100%</th>";

if(pg_NumRows($result)>0){
//if(true){
for($j=1; $j<=pg_NumRows($result); $j++){
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j-1));
echo "<tr>";
echo "<th bgcolor=\"$color\"><a href=\"npa_register_dtl1.php?menu=".trim($row['loan_type'])."&op=1&end_date=$end_date\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;\">".$loan_module_array[trim($row['loan_type'])];
//echo "<th bgcolor=\"$color\">".trim($row['loan_type']);
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($row['loan_amount']);
$t_loan_amount+=$row['loan_amount'];
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($row['loan_amount']-$row['balance_principal']);
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($row['balance_principal']);
$t_b_p+=$row['balance_principal'];
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($row['due_int']);
$t_d_i+=$row['due_int'];

echo "<td bgcolor=\"$color\" align=\"right\"><a href=\"npa_od_dtl.php?menu=".trim($row['loan_type'])."&op=1&end_date=$end_date\" onClick=\"window.open this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;\">".amount2Rs($row['overdue_int']);


//echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($row['overdue_int']);
$t_od_i+=$row['overdue_int'];
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($row['standard']);
$t_standard+=$row['standard'];
echo "<td bgcolor=\"$color\" align=\"right\">0";
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($row['sub']);
$t_sub+=$row['sub'];
$s_p=round($row['sub']*0.05);
$t_s_p+=$s_p;
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($s_p);
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($row['d1']);
$t_d1+=$row['d1'];
$d1_p=round($row['d1']*0.10);
$t_d1_p+=$d1_p;
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($d1_p);
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($row['d2']);
$t_d2+=$row['d2'];
$d2_p=round($row['d2']*0.15);
$t_d2_p+=$d2_p;
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($d2_p);
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($row['d3']);
$t_d3+=$row['d3'];
$d3_p=round($row['d3']*0.50);
$t_d3_p+=$d3_p;
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($d3_p);
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($row['unsecured_asset']);
$t_unsecure_asset+=$row['unsecured_asset'];

echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($row['unsecured_asset']);
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($row['loss_asset']);
$t_loss_asset+=$row['loss_asset'];
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($row['loss_asset']);

  }
//echo"<h1> OverDue:$t_od_i</h1>";
echo "<tr bgcolor=\"AQUA\"><th colspan=\"1\">Total:<th align=\"right\">".amount2Rs($t_loan_amount)."<th align=\"right\">".amount2Rs(($t_loan_amount-$t_b_p))."<th align=\"right\">".amount2Rs($t_b_p)."<th align=\"right\">".amount2Rs($t_d_i)."<th align=\"right\">".amount2Rs($t_od_i)."<th align=\"right\">".amount2Rs($t_standard)."<th align=\"right\">0<th align=\"right\">".amount2Rs($t_sub)."<th align=\"right\">".amount2Rs($t_s_p)."<th align=\"right\">".amount2Rs($t_d1)."<th align=\"right\">".amount2Rs($t_d1_p)."<th align=\"right\">".amount2Rs($t_d2)."<th align=\"right\">".amount2Rs($t_d2_p)."<th align=\"right\">".amount2Rs($t_d3)."<th align=\"right\">".amount2Rs($t_d3_p)."<th align=\"right\">".amount2Rs($t_unsecure_asset)."<th align=\"right\">".amount2Rs($t_unsecure_asset)."<th align=\"right\">".amount2Rs($t_loss_asset)."<th align=\"right\">".amount2Rs($t_loss_asset);
}
echo "</body>";
echo "</html>";

?>
