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
echo "<title>Profit & Loss A/C";
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
echo "<body bgcolor=\"silver\">";
echo "<font size=+3>$SYSTEM_TITLE</font> <br><font size=+1><b>Report Date:".date('d.m.Y')."::".getPrintTime()."</b></font><hr>";
echo "<form name=\"f1\" action=\"profit_loss.php\" method=\"POST\" onsubmit=\"return check();\">";
echo "<table align=center bgcolor=\"#90EE90\"><tr><td  align=\"\"><b>Profit & Loss A/C As On (DD/MM/YYYY) :<td><input type=TEXT size=10 maxlength=\"10\" name=\"start_date\" id=\"start_date\" value=\"$start_date\"  maxlength=\"10\" onFocus=\"javascript:vDateType='1'\" onKeyUp=\"DateFormat(this,this.value,event,false,'3')\" onBlur=\"DateFormat(this,this.value,event,true,'3')\" $HIGHLIGHT>&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.start_date,'dd/mm/yyyy','Choose Date')\">";
echo "<input type=\"HIDDEN\" name=\"f_start_dt\" id=\"f_start_dt\" value=\"$f_start_dt\">";
echo "<input type=\"HIDDEN\" name=\"f_end_dt\" id=\"f_end_dt\" value=\"$f_end_dt\">";
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> ";
echo "</table></form>";
//---------------------------------------------------------------------------------------------
echo "<hr>";
/*$sql_statement="select a.gl_mas_code, initcap(b.gl_mas_desc) as gl_mas_desc, sum(debit) as debit, sum(credit) as credit, sum(debit-credit) as bal from mas_gl_tran as a , gl_master_vw as b WHERE action_date BETWEEN '$f_start_dt' AND '$start_date' AND a.gl_mas_code= b.gl_mas_code and bs_pl='E' group by a.gl_mas_code, b.gl_mas_desc 
UNION ALL
SELECT '12302' as gl_mas_code, 'Profit & Loss' as gl_mas_desc,SUM(debit) as debit,SUM(credit) as cedit,SUM(credit-debit) as bal FROM (SELECT a.gl_mas_code,SUM(debit) as debit,SUM(credit) as credit,bs_pl from mas_gl_tran a,gl_master_vw b WHERE action_date BETWEEN '$f_start_dt' AND '$start_date' AND a.gl_mas_code=b.gl_mas_code group by a.gl_mas_code,bs_pl HAVING bs_pl='S' OR bs_pl='I' OR bs_pl='P' OR bs_pl='E') as foo order by gl_mas_code DESC";
//echo $sql_statement;
$result=dBConnect($sql_statement);
*/
echo "<table width=\"100%\" bgcolor=\"pink\" bgcolor=\"\" border=\"1\" cellspacing=\"0\" bordercolor=\"BLACK\" bordercolorlight=\"BLACK\" bordercolordark=\"BLACK\"><tr>";
echo "<th colspan=\"1\" bgcolor=\"Yellow\">Balance Sheet<tr>";
//echo "<th colspan=\"1\" bgcolor=\"WHITE\" align=\"left\">Dr.<th colspan=\"1\" bgcolor=\"WHITE\" align=\"Right\">Cr.<tr>";
echo "<td valign=\"top\" width=\"50%\">";
echo "<table width=\"50%\" bgcolor=\"\" border=\"1\" cellspacing=\"0\" bordercolor=\"BLACK\" bordercolorlight=\"BLACK\" bordercolordark=\"BLACK\">";
echo "<tr><th bgcolor=\"green\" colspan=\"4\"><font color=\"white\"><b>Particulars</b></font>";

// Place line comments if you do not need column header.
//color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color colspan=\"1\" width=\"7%\">SL.No</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"\">Liabilities</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"20%\">Break Up</th>";
//echo "<th bgcolor=$color colspan=\"1\" width=\"20%\">Credit</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"12%\">31st March(current year) </th>";

/*for($j=0; $j<pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	//$vdebit=$vdebit+$row['debit'];
	//$vcredit=$vcredit+$row['credit'];

	echo "<tr>";
	echo "<td align=left bgcolor=$color><a href=\"gl_ledger.php?glc=".$row['gl_mas_code']."&edt=$end_date&sdt=$start_date\">".$row['gl_mas_code']."</a></td>";
	echo "<td align=left bgcolor=$color>".$row['gl_mas_desc']."</td>";
	//echo "<td align=right bgcolor=$color>".amount2Rs((float)$row['debit'])."</td>";
	//echo "<td align=right bgcolor=$color>".amount2Rs((float)$row['credit'])."</td>";
	$Lbal=$Lbal+$row['bal'];
        if ($row['bal'] > 0){
		echo "<td align=right bgcolor=$color>".amount2Rs((float)$row['bal'])."</td>";
	//	$cldebit=$cldebit+$row['bal'];
		
	}else {
		echo "<td align=right bgcolor=$color>".amount2Rs((float)$row['bal'])."</td>"; 
	//	$clcredit=$clcredit -$row['bal'];
		}


	}
	
*/

echo "<tr>";
echo "<th bgcolor=$color rowspan=\"7\" width=\"7%\">1.</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"\">Capital</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"20%\"></th>";
//echo "<th bgcolor=$color colspan=\"1\" width=\"20%\">Credit</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"12%\"></th>";

echo "<tr>";
echo "<th bgcolor=$color colspan=\"1\" width=\"15%\">i) Authorised</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"20%\"></th>";
//echo "<th bgcolor=$color colspan=\"1\" width=\"20%\">Credit</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"12%\"></th>";


echo "<tr>";
echo "<th bgcolor=$color colspan=\"1\" width=\"\">ii) Subscribed</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"20%\"></th>";
//echo "<th bgcolor=$color colspan=\"1\" width=\"20%\">Credit</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"12%\"></th>";


echo "<tr>";
echo "<th bgcolor=$color colspan=\"1\" width=\"\">iii) Paid UP</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"20%\"></th>";
//echo "<th bgcolor=$color colspan=\"1\" width=\"20%\">Credit</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"12%\"></th>";


echo "<tr>";
echo "<th bgcolor=$color colspan=\"1\" width=\"\">Individuals</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"20%\"></th>";
//echo "<th bgcolor=$color colspan=\"1\" width=\"20%\">Credit</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"12%\"></th>";


echo "<tr>";
echo "<th bgcolor=$color colspan=\"1\" width=\"\">Government</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"20%\"></th>";
//echo "<th bgcolor=$color colspan=\"1\" width=\"20%\">Credit</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"12%\"></th>";


echo "<tr>";
echo "<th bgcolor=$color colspan=\"1\" width=\"\">Others</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"20%\"></th>";
//echo "<th bgcolor=$color colspan=\"1\" width=\"20%\">Credit</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"12%\"></th>";










/*

echo "</table>";
echo "</td><td valign=\"top\" width=\"50%\">";
$sql_statement="SELECT a.gl_mas_code, b.gl_mas_desc, sum(debit) as debit, sum(credit) as credit, sum(credit-debit) as bal from mas_gl_tran as a , gl_master_vw as b where action_date BETWEEN '$f_start_dt' AND '$start_date' AND a.gl_mas_code= b.gl_mas_code and bs_pl='I' group by a.gl_mas_code, b.gl_mas_desc
UNION ALL
SELECT '39000' as gl_mas_code, 'Gross prifit' as gl_mas_desc,SUM(debit) as debit,SUM(credit) as cedit,SUM(credit-debit) as bal FROM (SELECT a.gl_mas_code,SUM(debit) as debit,SUM(credit) as credit,bs_pl from mas_gl_tran a,gl_master_vw b WHERE action_date BETWEEN '$f_start_dt' AND '$start_date' AND a.gl_mas_code=b.gl_mas_code group by a.gl_mas_code,bs_pl HAVING bs_pl='S' OR bs_pl='P') as foo order by gl_mas_code";

//echo $sql_statement;
$result=dBConnect($sql_statement);
echo "<table width=\"100%\" bgcolor=\"\" border=\"1\" cellspacing=\"0\" bordercolor=\"BLACK\" bordercolorlight=\"BLACK\" bordercolordark=\"BLACK\">";
echo "<tr><td bgcolor=\"green\" colspan=\"5\" align=\"center\"><font color=\"white\"><b>Particulars</b></font>";

// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";

echo "<th bgcolor=$color colspan=\"1\" width=\"7%\">Code</th>";
echo "<th bgcolor=$color colspan=\"1\" >Account Name</th>";
//echo "<th bgcolor=$color colspan=\"1\">Debit</th>";
//echo "<th bgcolor=$color colspan=\"1\">Credit</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"12%\">Amount</th>";
for($j=0; $j<pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	//$vdebit1=$vdebit1+$row['debit'];
	//$vcredit1=$vcredit1+$row['credit'];
	echo "<tr>";
	echo "<td align=left bgcolor=$color><a href=\"gl_ledger.php?glc=".$row['gl_mas_code']."&edt=$end_date&sdt=$start_date\">".$row['gl_mas_code']."</a></td>";
	echo "<td align=left bgcolor=$color>".ucwords($row['gl_mas_desc'])."</td>";
	//echo "<td align=right bgcolor=$color>".amount2Rs((float)$row['debit'])."</td>";
	//echo "<td align=right bgcolor=$color>".amount2Rs((float)$row['credit'])."</td>";
	$Abal=$Abal+$row['bal'];
        if ($row['bal'] > 0){
		echo "<td align=right bgcolor=$color>".amount2Rs((float)$row['bal'])."</td>";
	//	$cldebit=$cldebit+$row['bal'];
		
	}else {
		echo "<td align=right bgcolor=$color>".amount2Rs((float)$row['bal'])."</td>"; 
	//	$clcredit=$clcredit -$row['bal'];
		}

	}
	
echo "</tr>";
echo "</table>";
$color="AQUA";
echo "</td></tr>";
echo "<tr><td align=left><table width=\"100%\" bgcolor=\"\" border=\"1\" cellspacing=\"0\" bordercolor=\"BLACK\" bordercolorlight=\"BLACK\" bordercolordark=\"BLACK\">";
echo "<tr>";
echo "<th bgcolor=$color colspan=\"1\" width=\"7%\"></th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"\" >Total</th>";
//echo "<th bgcolor=$color colspan=\"1\" width=\"20%\" align=\"RIGHT\">".amount2Rs($vdebit)."</th>";
//echo "<th bgcolor=$color colspan=\"1\" width=\"20%\" align=\"RIGHT\">".amount2Rs($vcredit)."</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"12%\" align=\"RIGHT\">".amount2Rs($Lbal)."</th>";
echo "</tr>";
echo "</table>";
echo "<td align=left><table width=\"100%\" bgcolor=\"\" border=\"1\" cellspacing=\"0\" bordercolor=\"BLACK\" bordercolorlight=\"BLACK\" bordercolordark=\"BLACK\">";
echo "<tr>";
echo "<th bgcolor=$color colspan=\"1\" width=\"7%\"></th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"\">Total</th>";
//echo "<th bgcolor=$color colspan=\"1\" width=\"20%\" align=\"RIGHT\">".amount2Rs($vdebit1)."</th>";
//echo "<th bgcolor=$color colspan=\"1\" width=\"20%\" align=\"RIGHT\">".amount2Rs($vcredit1)."</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"12%\" align=\"RIGHT\">".amount2Rs($Abal)."</th>";
echo "</tr></table>";
echo "</td></tr></table>";
*/
echo "</body>";
echo "</html>";
?>
