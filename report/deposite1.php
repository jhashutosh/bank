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
echo "<form name=\"f1\" action=\"deposite1.php\" method=\"POST\" onsubmit=\"return check();\">";
echo "<table align=center bgcolor=\"#90EE90\"><tr><td  align=\"\"><b>Profit & Loss A/C As On (DD/MM/YYYY) :<td><input type=TEXT size=10 maxlength=\"10\" name=\"start_date\" id=\"start_date\" value=\"$start_date\"  maxlength=\"10\" onFocus=\"javascript:vDateType='1'\" onKeyUp=\"DateFormat(this,this.value,event,false,'3')\" onBlur=\"DateFormat(this,this.value,event,true,'3')\" $HIGHLIGHT>&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.start_date,'dd/mm/yyyy','Choose Date')\">";
echo "<input type=\"HIDDEN\" name=\"f_start_dt\" id=\"f_start_dt\" value=\"$f_start_dt\">";
echo "<input type=\"HIDDEN\" name=\"f_end_dt\" id=\"f_end_dt\" value=\"$f_end_dt\">";
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> ";
echo "</table></form>";




$sql_statement="SELECT count(customer_id) AS no_pyshare,sum(value_of_share) AS share_pyvalue from share_details WHERE '$f_start_dt'-opening_date<365 and '$f_start_dt'-opening_date>0";
 
//echo "$sql_statement";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){





echo "<table bgcolor=\"#AF7817\" width=\"100%\" align=\"CENTER\">";
echo "<tr><th colspan=\"10\" bgcolor=green><font color=white size=5> CURRENT BALANCE IN A PARTICULAR DAY </th>";
echo "<tr>";

$color="#CCCCC5555";
echo "<th rowspan=\"2\" bgcolor=\"$color\" width=10%>********</th>";
echo "<th colspan=\"2\" bgcolor=\"$color\" width=22%>OPENING BALANCE 1st APRIL</th>";
echo "<th colspan=\"4\" bgcolor=\"$color\" width=40%>TO DAY BALANCE</th>";
echo "<th rowspan=\"2\" bgcolor=\"$color\" width=9%>INTEREST PAID</th>";
echo "<th rowspan=\"2\" bgcolor=\"$color\" width=8%>AMOUNT WITHDRAWL</th>";
echo "<th rowspan=\"2\" bgcolor=\"$color\" width=10%>DEPOSITE</th>";
//echo "</tr>";

echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\" width=10%>NO OF ACCOUNT</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\" width=10%>AMOUNT</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\" width=10%>NO OF ACCOUNT</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\" width=10%>AMOUNT</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\" width=10%>INTEREST PAYBLE</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\" width=10%>TOTAL</th>";
echo "</tr>";
// ==============================SHARE==========================================




$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);









/*$sql_statement="SELECT count('customer_id')as no_share from share_details WHERE opening_date <= '$start_date'";
//echo "$sql_statement";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){
for($j=0; $j<=pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;	
  $row=pg_fetch_array($result,$j);
  }
//$share=12;    //pg_result($result,'no_share');
*/
echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\" width=11%>SHARE</th>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=10% align=\"center\">".$row['no_pyshare']."</td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=10% align=\"center\">".$row['share_pyvalue']."</td>";
}
}
//=================================current share===================================================================
$sql_statement="select count(account_no) as count1 from loan_statement where action_date<'1/4/2011' and account_no like 'KCC%'";
 
//echo "$sql_statement";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);

echo "<td colspan=\"1\" bgcolor=\"$color\" width=10% align=center>".$row['count1']."</td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=10% align=center>".$row['count1']."</td>";
}
}
echo "<td colspan=\"1\" bgcolor=\"$color\" width=10%></td>";

echo "<td colspan=\"1\" bgcolor=\"$color\" width=10%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=10%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=9%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=10%></td>";
echo "</tr>";
echo "</table>";

//=============================================savings=======================================================







echo "<table bgcolor=\"#AF7817\" width=\"100%\" align=\"CENTER\">";
echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\" width=10%>SAVINGS</th>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=10% align=center></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=10%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=10%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=9%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=10%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=9%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=10%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=12%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=12%></td>";
echo "</tr>";

echo "</table>";
//===============================================FD===============================================


$sql_statement="SELECT count(account_no) AS no_fd,sum(principal) AS fd_pyvalue from deposit_info WHERE '$f_start_dt'-opening_date<365 and '$f_start_dt'-opening_date>0 and account='fd'";
 
//echo "$sql_statement";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
echo "<table bgcolor=\"#AF7817\" width=\"100%\" align=\"CENTER\">";
echo "<tr><td></td></tr>";
//echo "<tr><th colspan=\"10\" bgcolor=green></th>";
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);




echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\" width=10%>FD</th>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=10%>".$row['no_fd']."</td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=10%>".$row['fd_principal']."</td>";
}
}
echo "<td colspan=\"1\" bgcolor=\"$color\" width=10%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=9%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=10%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=9%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=10%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=12%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=12%></td>";
echo "</tr>";
echo "</table>";

echo "<table bgcolor=\"#AF7817\" width=\"100%\" align=\"CENTER\">";
//echo "<tr><th colspan=\"10\" bgcolor=green></th>";
echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\" width=10%>RD</th>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=10%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=10%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=10%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=9%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=10%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=9%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=10%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=12%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=12%></td>";
echo "</tr>";
echo "</table>";


echo "<table bgcolor=\"#AF7817\" width=\"100%\" align=\"CENTER\">";
//echo "<tr><th colspan=\"10\" bgcolor=green></th>";
echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\" width=10%>RI</th>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=10%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=10%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=10%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=9%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=10%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=9%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=10%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=12%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=12%></td>";
echo "</tr>";
echo "</table>";

echo "<table bgcolor=\"#AF7817\" width=\"100%\" align=\"CENTER\">";
//echo "<tr><th colspan=\"10\" bgcolor=green></th>";
echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\" width=10%>MIS</th>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=10%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=10%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=10%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=9%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=10%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=9%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=10%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=12%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=12%></td>";
echo "</tr>";
echo "</table>";

echo "<table bgcolor=\"#AF7817\" width=\"100%\" align=\"CENTER\">";
//echo "<tr><th colspan=\"10\" bgcolor=green></th>";
echo "<tr>";
$color1="#806517";
echo "<th colspan=\"1\" bgcolor=\"$color1\" width=10%>TOTAL</th>";
echo "<td colspan=\"1\" bgcolor=\"$color1\" width=10%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color1\" width=10%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color1\" width=10%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color1\" width=9%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color1\" width=10%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color1\" width=9%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color1\" width=10%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color1\" width=12%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color1\" width=12%></td>";
echo "</tr>";
echo "</table>";







//---------------------------------------------------------------------------------------------
/*echo "<hr>";
$sql_statement="select a.gl_mas_code, initcap(b.gl_mas_desc) as gl_mas_desc, sum(debit) as debit, sum(credit) as credit, sum(debit-credit) as bal from mas_gl_tran as a , gl_master_vw as b WHERE action_date BETWEEN '$f_start_dt' AND '$start_date' AND a.gl_mas_code= b.gl_mas_code and bs_pl='E' group by a.gl_mas_code, b.gl_mas_desc 
UNION ALL
SELECT '12302' as gl_mas_code, 'Profit & Loss' as gl_mas_desc,SUM(debit) as debit,SUM(credit) as cedit,SUM(credit-debit) as bal FROM (SELECT a.gl_mas_code,SUM(debit) as debit,SUM(credit) as credit,bs_pl from mas_gl_tran a,gl_master_vw b WHERE action_date BETWEEN '$f_start_dt' AND '$start_date' AND a.gl_mas_code=b.gl_mas_code group by a.gl_mas_code,bs_pl HAVING bs_pl='S' OR bs_pl='I' OR bs_pl='P' OR bs_pl='E') as foo order by gl_mas_code DESC";
//echo $sql_statement;
$result=dBConnect($sql_statement);
echo "<table width=\"100%\" bgcolor=\"pink\" bgcolor=\"\" border=\"1\" cellspacing=\"0\" bordercolor=\"BLACK\" bordercolorlight=\"BLACK\" bordercolordark=\"BLACK\"><tr>";
echo "<th colspan=\"2\" bgcolor=\"Yellow\">Profit & Loss A/C as on $end_date<tr>";
echo "<th colspan=\"1\" bgcolor=\"WHITE\" align=\"left\">Dr.<th colspan=\"1\" bgcolor=\"WHITE\" align=\"Right\">Cr.<tr>";
echo "<td valign=\"top\" width=\"50%\">";
echo "<table width=\"100%\" bgcolor=\"\" border=\"1\" cellspacing=\"0\" bordercolor=\"BLACK\" bordercolorlight=\"BLACK\" bordercolordark=\"BLACK\">";
echo "<tr><th bgcolor=\"green\" colspan=\"5\"><font color=\"white\"><b>Particulars</b></font>";

// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color colspan=\"1\" width=\"7%\">Code</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"\">Account Name</th>";
//echo "<th bgcolor=$color colspan=\"1\" width=\"20%\">Debit</th>";
//echo "<th bgcolor=$color colspan=\"1\" width=\"20%\">Credit</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"12%\">Amount</th>";

for($j=0; $j<pg_NumRows($result); $j++){
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
echo "</td></tr></table>";*/
echo "</body>";
echo "</html>";
?>
