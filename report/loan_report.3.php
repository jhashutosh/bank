<?
include "../config/config.php";
$staff_id=verifyAutho();
$fy=$_SESSION['fy'];
getDetailFy($fy,&$f_start_dt,&$f_end_dt);
$start_date=$_REQUEST["start_date"];
if(empty($start_date) ) { $start_date=$f_end_dt; }
$vdebit="0";
$vcredit="0";
$cldebit="0";
$clcredit="0";
$vdebit1="0";
$vcredit1="0";
$Lbal="0";
$Abal="0";
echo "<html>";
echo "<head>";
echo "<title>Deposite Report";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "<script src=\"../JS/date_validation.js\"></script>";
//echo "<script src=\"../JS/dateValidation.js\"></script>";
?>
<SCRIPT LANGUAGE="JavaScript">
function check(){
f_s_dt=document.f1.f_start_dt.value;
f_e_dt=document.f1.f_end_dt.value;
start_dt=document.f1.start_date.value;
if(start_dt.length==0){
alert("Ending Date Should Not be Null")
	document.f1.start_date.focus();
	return false;
}
if(!IsDateLess(f_s_dt,start_dt)){
	alert("Starting Date beyond of ending date of Financial Year")
	document.f1.start_date.focus();
	return false;
}
if(!IsDateLess(start_dt,f_e_dt)){
	alert("Ending Date beyond of ending date of Financial Year")
	document.f1.start_date.focus();
	return false;
}

}
</script>
<?
echo "</head>";
echo "<body bgcolor=\"#4C787E\">";
echo "<font size=+3>$SYSTEM_TITLE</font> <br><font size=+1><b>Report Date:".date('d.m.Y')."::".getPrintTime()."</b></font><hr>";
echo "<form name=\"f1\" action=\"profit_loss.php\" method=\"POST\" onsubmit=\"return check();\">";
echo "<table align=center bgcolor=\"#90EE90\"><tr><td  align=\"\"><b>Date (DD/MM/YYYY) :<td><input type=TEXT size=10 maxlength=\"10\" name=\"start_date\" id=\"start_date\" value=\"$start_date\"  maxlength=\"10\" onFocus=\"javascript:vDateType='1'\" onKeyUp=\"DateFormat(this,this.value,event,false,'3')\" onBlur=\"DateFormat(this,this.value,event,true,'3')\" $HIGHLIGHT>&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.start_date,'dd/mm/yyyy','Choose Date')\">";
echo "<input type=\"HIDDEN\" name=\"f_start_dt\" id=\"f_start_dt\" value=\"$f_start_dt\">";
echo "<input type=\"HIDDEN\" name=\"f_end_dt\" id=\"f_end_dt\" value=\"$f_end_dt\">";
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> ";
echo "</table></form>";


echo "<table bgcolor=\"#AF7817\" width=\"100%\" align=\"CENTER\">";

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
//echo "</tr>";
//echo"</table>";



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
echo "</table>";






/*

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
*/
echo "</body>";
echo "</html>";


?>
