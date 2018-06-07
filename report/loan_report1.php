<?
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$c_month=date('m');
$c_year=(float)date('Y');
if($c_month<4){
	$p_year=$c_year-1;
}
else{
	$p_year=$c_year;
}
$p_year_month=$p_year."-03";
$c_year_month=$c_year."-".$c_month;
//echo "<h1>$p_year_month</h1>";
//echo "<h1>$c_year_month</h1>";
$sql_statement="SELECT gl_ins_current_balance(current_date) as cal";
$result=dBConnect($sql_statement);
if(pg_result($result,'cal')=='o'){
echo "<html>";
echo "<head>";
echo "<title>Liabilities Details </title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\"\" onload=\"amount.focus();\">";
if($menu==lia){$value='LA';$dr_cr='Cr';$code='10000';}
if($menu==assets){$value='AS';$dr_cr='Dr';$code='20000';}
if($menu==pur){$value='PU';$dr_cr='Dr';$code='30000';}
if($menu==sale){$value='SA';$dr_cr='Cr';$code='40000';}
if($menu==income){$value='IN';$dr_cr='Cr';$code='50000';}
if($menu==expen){$value='EX';$dr_cr='Dr';$code='60000';}
echo "<table bgcolor=\"silver\" width=\"70%\" align=\"CENTER\">";
echo "<tr><th colspan=\"15\" bgcolor=green><font color=white size=2> CURRENT BALANCE IN A PARTICULAR DAY </th>";
echo "<tr>";

$color="#CCCCC5555";
echo "<th rowspan=\"2\" bgcolor=\"$color\">********</th>";
echo "<th colspan=\"4\" bgcolor=\"$color\">OPENING BALANCE 1st APRIL</th>";
echo "<th colspan=\"5\" bgcolor=\"$color\">TOTAL BALANCE</th>";
echo "<th colspan=\"5\" bgcolor=\"$color\">INTEREST PAID</th>";

echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\">NO OF ACCOUNT</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">PRINCIPAL</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">DUE</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">OVER DUE</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">NO OF ACCOUNT</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">PRINCIPAL</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">DUE INTEREST</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">OVER DUE INTREST</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">TOTAL</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">NO OF ACCOUNT</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">PRINCIPAL</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">DUE INTREST</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">OVER DUE INTEREST</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">TOTAL</th>";

echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\">KCC</th>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";

echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\">MT</th>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";

echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\">CASH CREDIT</th>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";

echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\">KVP</th>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";

echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\">STAFF LOAN</th>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";

echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\">PLEDGE</th>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";

echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\">BOND</th>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";

echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\">LT</th>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";


echo "<tr>";
$color1=green;
echo "<th colspan=\"1\" bgcolor=\"$color1\">TOTAL</th>";
echo "<td colspan=\"1\" bgcolor=\"$color1\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color1\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color1\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color1\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color1\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color1\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color1\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color1\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color1\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color1\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color1\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color1\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color1\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color1\"></td>";









$sql_statement="SELECT * FROM gl_header WHERE status='$value' ORDER BY cast(gl_header_code as int)";
//echo "$sql_statement";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){
for($j=0; $j<=pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
echo "<tr>";
echo "<th rowspan=\"1\" bgcolor=\"$color\"><font color=green size=+2>".$row['gl_header_code']."</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\" align=\"left\"><font color=green size=+2>".strtoupper($row['gl_header_desc'])."</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\"><font color=green size=+2>".gl_header($row['gl_header_code'],$c_year_month,$dr_cr)."</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\"><font color=green size=+2>".gl_header($row['gl_header_code'],$p_year_month,$dr_cr)."</th>";
$sql_statement2="SELECT * FROM gl_sub_header WHERE gl_header_code='".$row['gl_header_code']."'  ORDER BY CAST(gl_sub_header_code as int)";
//echo "$sql_statement2";
$result2=dBConnect($sql_statement2);
if(pg_NumRows($result2)>0){
for($i=0; $i<=pg_NumRows($result2); $i++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row2=pg_fetch_array($result2,$i);
echo "<tr>";
echo "<th rowspan=\"1\" bgcolor=\"$color\"><font color=RED size=+1>".$row2['gl_sub_header_code']."</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\" align=\"left\"><font color=RED size=+1>".ucwords($row2['gl_sub_header_desc'])."</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\"><font color=RED size=+1>".gl_sub_header($row2['gl_sub_header_code'],$c_year_month,$dr_cr)."</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\"><font color=RED size=+1>".gl_sub_header($row2['gl_sub_header_code'],$p_year_month,$dr_cr)."</th>";

$sql_statement3="SELECT * FROM gl_master WHERE gl_sub_header_code='".$row2['gl_sub_header_code']."' ORDER BY CAST(gl_mas_code as int)";
//echo "$sql_statement3";
$result3=dBConnect($sql_statement3);
if(pg_NumRows($result3)>0){
for($k=0; $k<pg_NumRows($result3); $k++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row3=pg_fetch_array($result3,$k);
echo "<tr>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">".$row3['gl_mas_code']."</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\" align=\"left\">".ucwords($row3['gl_mas_desc'])."</th>";
//echo "<th bgcolor=\"$color\">0..0</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">".totalValue($row3['gl_mas_code'],$c_year_month,$dr_cr)."</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">".totalValue($row3['gl_mas_code'],$p_year_month,$dr_cr)."</th>";


}
}
}
}
}

}
echo "</table>";
}
else{
echo "<h1><font color='red'>Function Error !!!!!!!!!!</font></h1>";

}

echo "</body>";
echo "</html>";


?>
