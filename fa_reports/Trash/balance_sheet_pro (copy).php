<?
include "../config/config.php";
$staff_id=verifyAutho();
$fy=$_SESSION['fy'];
getDetailFy($fy,&$f_start_dt,&$f_end_dt);
$start_date=$_REQUEST["start_date"];
if(empty($start_date) ) { $start_date=$f_end_dt; }
//if( empty($starting_date) ) { $pre_date=date("d/m/Y",time()-604600); }
echo "<html>";
echo "<head>";
echo "<title>Balance Sheet";
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
echo "<form name=\"f1\" action=\"balance_sheet.php\" method=\"POST\" onsubmit=\"return check();\">";
echo "<table align=center bgcolor=\"#90EE90\"><tr><td  align=\"\"><b>Balance Sheet As On (DD/MM/YYYY) :<td><input type=TEXT size=10 maxlength=\"10\" name=\"start_date\" id=\"start_date\" value=\"$start_date\"  maxlength=\"10\" onFocus=\"javascript:vDateType='1'\" onKeyUp=\"DateFormat(this,this.value,event,false,'3')\" onBlur=\"DateFormat(this,this.value,event,true,'3')\" $HIGHLIGHT>&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.start_date,'dd/mm/yyyy','Choose Date')\">";
echo "<input type=\"HIDDEN\" name=\"f_start_dt\" id=\"f_start_dt\" value=\"$f_start_dt\">";
echo "<input type=\"HIDDEN\" name=\"f_end_dt\" id=\"f_end_dt\" value=\"$f_end_dt\">";
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> ";
echo "</table></form>";
//---------------------------------------------------------------------------------------------
echo "<hr>";
$sql_statement="SELECT gl_mas_code,gl_mas_desc,SUM(p_balance) as p_balance,SUM(c_balance) as c_balance FROM (
SELECT master.gl_mas_code,initcap(b.gl_mas_desc) as gl_mas_desc,SUM(p_balance) as p_balance,0 as c_balance FROM (
SELECT CASE 
      WHEN c.gl_mas_code='14101' and a.gl_mas_code='14301' THEN c.gl_mas_code 
      WHEN c.gl_mas_code='14102' and a.gl_mas_code='14302' THEN c.gl_mas_code 
      WHEN c.gl_mas_code='14103' and a.gl_mas_code='14303' THEN c.gl_mas_code 
      WHEN c.gl_mas_code='14104' and a.gl_mas_code='14304' THEN c.gl_mas_code 
      WHEN c.gl_mas_code='14105' and a.gl_mas_code='14305' THEN c.gl_mas_code 
      ELSE a.gl_mas_code
      END as gl_mas_code, sum(credit-debit) as p_balance from mas_gl_tran as a 
LEFT JOIN 
(SELECT customer_id,opening_date,account_no,gl_mas_code,status from customer_account a WHERE opening_date=(SELECT MAX(opening_date) FROM customer_account b WHERE entry_time=(SELECT MAX(entry_time)FROM customer_account c WHERE a.customer_id=c.customer_id AND b.customer_id=c.customer_id AND opening_date<=date('$start_date')-INTERVAL '1 year'))
) as c on a.account_no=c.account_no
WHERE action_date<=date('$start_date')-INTERVAL '1 year'  
GROUP BY
CASE 
      WHEN c.gl_mas_code='14101' and a.gl_mas_code='14301' THEN c.gl_mas_code 
      WHEN c.gl_mas_code='14102' and a.gl_mas_code='14302' THEN c.gl_mas_code 
      WHEN c.gl_mas_code='14103' and a.gl_mas_code='14303' THEN c.gl_mas_code 
      WHEN c.gl_mas_code='14104' and a.gl_mas_code='14304' THEN c.gl_mas_code 
      WHEN c.gl_mas_code='14105' and a.gl_mas_code='14305' THEN c.gl_mas_code 
      ELSE a.gl_mas_code
      END
) as master,gl_master_vw as b
WHERE 
master.gl_mas_code= b.gl_mas_code and bs_pl='L' 
GROUP BY
master.gl_mas_code,b.gl_mas_desc
HAVING master.gl_mas_code not in('12302','12301')
--UNION ALL
--SELECT '12302' as gl_mas_code, 'Profit & Loss Balance As Per Current Year' as gl_mas_desc,SUM(credit-debit) as p_balance,0 as c_balance FROM (SELECT --a.gl_mas_code,SUM(debit) as debit,SUM(credit) as credit,bs_pl from mas_gl_tran a,gl_master_vw b WHERE (action_date BETWEEN date('$f_start_dt')
--INTERVAL '1 year' AND date('$start_date')-INTERVAL '1 year') AND a.gl_mas_code=b.gl_mas_code group by a.gl_mas_code,bs_pl HAVING bs_pl='S' OR 
--bs_pl='I' OR bs_pl='P' OR bs_pl='E') as foo 


UNION ALL

SELECT master.gl_mas_code,initcap(b.gl_mas_desc) as gl_mas_desc,0 as p_balance,SUM(c_balance) as c_balance FROM (
SELECT CASE 
      WHEN c.gl_mas_code='14101' and a.gl_mas_code='14301' THEN c.gl_mas_code 
      WHEN c.gl_mas_code='14102' and a.gl_mas_code='14302' THEN c.gl_mas_code 
      WHEN c.gl_mas_code='14103' and a.gl_mas_code='14303' THEN c.gl_mas_code 
      WHEN c.gl_mas_code='14104' and a.gl_mas_code='14304' THEN c.gl_mas_code 
      WHEN c.gl_mas_code='14105' and a.gl_mas_code='14305' THEN c.gl_mas_code 
      ELSE a.gl_mas_code
      END as gl_mas_code, sum(credit-debit) as c_balance from mas_gl_tran as a 
LEFT JOIN 
(SELECT customer_id,opening_date,account_no,gl_mas_code,status from customer_account a WHERE opening_date=(SELECT MAX(opening_date) FROM customer_account b WHERE entry_time=(SELECT MAX(entry_time)FROM customer_account c WHERE a.customer_id=c.customer_id AND b.customer_id=c.customer_id AND opening_date<='$start_date'))
) as c on a.account_no=c.account_no
WHERE action_date<='$start_date' 
GROUP BY
CASE 
      WHEN c.gl_mas_code='14101' and a.gl_mas_code='14301' THEN c.gl_mas_code 
      WHEN c.gl_mas_code='14102' and a.gl_mas_code='14302' THEN c.gl_mas_code 
      WHEN c.gl_mas_code='14103' and a.gl_mas_code='14303' THEN c.gl_mas_code 
      WHEN c.gl_mas_code='14104' and a.gl_mas_code='14304' THEN c.gl_mas_code 
      WHEN c.gl_mas_code='14105' and a.gl_mas_code='14305' THEN c.gl_mas_code 
      ELSE a.gl_mas_code
      END
) as master,gl_master_vw as b
WHERE 
master.gl_mas_code= b.gl_mas_code and bs_pl='L' 
GROUP BY
master.gl_mas_code,b.gl_mas_desc
HAVING master.gl_mas_code not in('12302','12301')
UNION ALL
SELECT '12302' as gl_mas_code, 'Profit & Loss Balance As Per Current Year' as gl_mas_desc,0 as p_balance,SUM(credit-debit) as c_balance FROM (SELECT a.gl_mas_code,SUM(debit) as debit,SUM(credit) as credit,bs_pl from mas_gl_tran a,gl_master_vw b WHERE (action_date BETWEEN '$f_start_dt' AND '$start_date') AND a.gl_mas_code=b.gl_mas_code group by a.gl_mas_code,bs_pl HAVING bs_pl='S' OR bs_pl='I' OR bs_pl='P' OR bs_pl='E' OR bs_pl='Z') as foo
--union all
--SELECT '12301' as gl_mas_code, 'Profit & Loss Balance As Per Last Account' as gl_mas_desc,0 as p_balance,SUM(credit-debit) as c_balance FROM (SELECT 
--a.gl_mas_code,SUM(debit) as debit,SUM(credit) as credit,bs_pl from mas_gl_tran a,gl_master_vw b WHERE action_date<'$f_start_dt' AND 
--a.gl_mas_code=b.gl_mas_code group by a.gl_mas_code,bs_pl HAVING bs_pl='S' OR bs_pl='I' OR bs_pl='P' OR bs_pl='E' OR bs_pl='Z') as foo

UNION ALL
SELECT '12304' as gl_mas_code, 'Profit & Loss(U/D Profit)' as gl_mas_desc,0 as p_balance,SUM(credit-debit) as c_balance 
FROM 
(SELECT a.gl_mas_code,SUM(debit) as debit,SUM(credit) as credit,bs_pl from mas_gl_tran a,gl_master_vw b WHERE action_date BETWEEN '$f_start_dt' AND '$start_date' AND a.gl_mas_code=b.gl_mas_code group by a.gl_mas_code,bs_pl HAVING bs_pl='S' OR bs_pl='I' OR bs_pl='P' OR bs_pl='E' OR bs_pl='Z'
union all
SELECT a.gl_mas_code, SUM(debit) as debit,SUM(credit) as credit,bs_pl FROM mas_gl_tran  a ,gl_master_vw b where a.gl_mas_code::text='12301' and action_date<'$start_date' AND a.gl_mas_code=b.gl_mas_code GROUP BY a.gl_mas_code ,bs_pl
union all
SELECT '12301' as gl_mas_code, debit,credit,bs_pl FROM (SELECT a.gl_mas_code,SUM(debit) as debit,SUM(credit) as credit,bs_pl from mas_gl_tran a,gl_master_vw b WHERE action_date<'$f_start_dt' AND a.gl_mas_code=b.gl_mas_code group by a.gl_mas_code,bs_pl HAVING bs_pl='S' OR bs_pl='I' OR bs_pl='P' OR bs_pl='E' OR bs_pl='Z') as foo
) as foo 


UNION ALL
SELECT '12304' as gl_mas_code, 'Profit & Loss(U/D Profit)' as gl_mas_desc,SUM(credit-debit) as p_balance,0 as c_balance 
FROM 
(--SELECT a.gl_mas_code,SUM(debit) as debit,SUM(credit) as credit,bs_pl from mas_gl_tran a,gl_master_vw b WHERE action_date BETWEEN '$f_start_dt' AND 
--'$start_date' AND a.gl_mas_code=b.gl_mas_code group by a.gl_mas_code,bs_pl HAVING bs_pl='S' OR bs_pl='I' OR bs_pl='P' OR bs_pl='E' OR bs_pl='Z'
--union all
SELECT a.gl_mas_code, SUM(debit) as debit,SUM(credit) as credit,bs_pl FROM mas_gl_tran  a ,gl_master_vw b where a.gl_mas_code::text='12301' and 
action_date<'$start_date' AND a.gl_mas_code=b.gl_mas_code GROUP BY a.gl_mas_code ,bs_pl
union all
SELECT '12301' as gl_mas_code, debit,credit,bs_pl FROM (SELECT a.gl_mas_code,SUM(debit) as debit,SUM(credit) as credit,bs_pl from mas_gl_tran a,gl_master_vw b WHERE action_date<'$f_start_dt' AND a.gl_mas_code=b.gl_mas_code group by a.gl_mas_code,bs_pl HAVING bs_pl='S' OR bs_pl='I' OR bs_pl='P' OR bs_pl='E' OR bs_pl='Z') as foo
) as foo 

) AS fo GROUP BY gl_mas_code,gl_mas_desc HAVING gl_mas_code not in('12302','12301') order by gl_mas_code";
//echo $sql_statement;
$result=dBConnect($sql_statement);
echo "<table width=\"100%\" bgcolor=\"\" border=\"1\" cellspacing=\"0\" bordercolor=\"BLACK\" bordercolorlight=\"BLACK\" bordercolordark=\"BLACK\"><tr>";
echo "<th colspan=\"2\" bgcolor=\"Yellow\">Balance Sheet as on $start_date<tr>";
echo "<td valign=\"top\" width=\"50%\">";
echo "<table width=\"100%\" border=\"1\" cellspacing=\"0\" bordercolor=\"BLACK\" bordercolorlight=\"BLACK\" bordercolordark=\"BLACK\">";
echo "<tr><th bgcolor=\"green\" colspan=\"5\"><font color=\"white\"><b>Liabilities</b></font>";

// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color rowspan=\"2\" width=\"7%\">Code</th>";
echo "<th bgcolor=$color rowspan=\"2\" width=\"\">Account Name</th>";
echo "<th bgcolor=$color colspan=\"2\" width=\"24%\">Amount</th>";
echo "<tr>";
echo "<th bgcolor=$color colspan=\"1\">Current Year</th>";
echo "<th bgcolor=$color colspan=\"1\">Previous Year</th>";

for($j=0; $j<pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	$vdebit=$vdebit+$row['debit'];
	$vcredit=$vcredit+$row['credit'];
	echo "<tr>";
	echo "<td align=left bgcolor=$color><a href=\"gl_ledger.php?glc=".$row['gl_mas_code']."&edt=$end_date&sdt=$start_date\">".$row['gl_mas_code']."</a></td>";
	echo "<td align=left bgcolor=$color>".$row['gl_mas_desc']."</td>";
	echo "<td align=right bgcolor=$color>".amount2Rs((float)$row['c_balance'])."</td>";
        echo "<td align=right bgcolor=$color>".amount2Rs((float)$row['p_balance'])."</td>";
	$Lbal=$Lbal+$row['c_balance'];
	$p_l_bal+=$row['p_balance'];
 
	}
	
echo "</table border=\"1\" cellspacing=\"0\" bordercolor=\"BLACK\" bordercolorlight=\"BLACK\" bordercolordark=\"BLACK\">";
echo "</td><td valign=\"top\">";
$sql_statement="SELECT gl_mas_code,gl_mas_desc,SUM(p_balance) AS p_balance,SUM(c_balance) AS c_balance FROM (
select a.gl_mas_code, initcap(b.gl_mas_desc) AS gl_mas_desc, 0 as p_balance, CASE WHEN sum(debit-credit) IS NULL THEN 0 ELSE  sum(debit-credit) END  as c_balance from mas_gl_tran as a , gl_master_vw as b where action_date<='$start_date' AND a.gl_mas_code= b.gl_mas_code and bs_pl='A' group by a.gl_mas_code, b.gl_mas_desc
UNION ALL 
select a.gl_mas_code, initcap(b.gl_mas_desc) AS gl_mas_desc, CASE WHEN sum(debit-credit) IS NULL THEN 0 ELSE  sum(debit-credit) END as p_balance, 0 as c_balance from mas_gl_tran as a , gl_master_vw as b where action_date<'$f_start_dt' AND a.gl_mas_code=b.gl_mas_code and bs_pl='A' group by a.gl_mas_code, b.gl_mas_desc 
) AS foo GROUP BY gl_mas_code,gl_mas_desc ORDER BY gl_mas_code";
//$sql_statement="select a.gl_mas_code, initcap(b.gl_mas_desc) AS gl_mas_desc, sum(debit) as debit, sum(credit) as credit, sum(debit-credit) as bal from mas_gl_tran as a , gl_master_vw as b where action_date<= '$start_date' AND a.gl_mas_code= b.gl_mas_code and bs_pl='A' group by a.gl_mas_code, b.gl_mas_desc order by a.gl_mas_code";
//echo $sql_statement;
$result=dBConnect($sql_statement);
echo "<table width=\"100%\" border=\"1\" cellspacing=\"0\" bordercolor=\"BLACK\" bordercolorlight=\"BLACK\" bordercolordark=\"BLACK\">";
echo "<tr><td bgcolor=\"green\" colspan=\"9\" align=\"center\"><font color=\"white\"><b>Assets</b></font>";

// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";

echo "<th bgcolor=$color rowspan=\"2\" width=\"7%\">Code</th>";
echo "<th bgcolor=$color Rowspan=\"2\" width=\"\">Account Name</th>";
echo "<th bgcolor=$color colspan=\"2\" width=\"24%\">Amount</th>";
echo "<tr>";
echo "<th bgcolor=$color colspan=\"1\">Current Year</th>";
echo "<th bgcolor=$color colspan=\"1\">Previous Year</th>";
for($j=0; $j<pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	echo "<tr>";
	echo "<td align=left bgcolor=$color><a href=\"gl_ledger.php?glc=".$row['gl_mas_code']."&edt=$end_date&sdt=$start_date\">".$row['gl_mas_code']."</a></td>";
	echo "<td align=left bgcolor=$color>".$row['gl_mas_desc']."</td>";
	echo "<td align=right bgcolor=$color>".amount2Rs((float)$row['c_balance'])."</td>";
        echo "<td align=right bgcolor=$color>".amount2Rs((float)$row['p_balance'])."</td>";
	$Abal=$Abal+$row['c_balance'];
        $p_bal+=$row['p_balance'];
	}
	
echo "</tr>";
echo "</table>";
$color="AQUA";
echo "</td></tr>";
echo "<tr><td align=left><table width=\"100%\" border=\"1\" cellspacing=\"0\" bordercolor=\"BLACK\" bordercolorlight=\"BLACK\" bordercolordark=\"BLACK\">";
echo "<tr>";
echo "<th bgcolor=$color colspan=\"1\" width=\"7%\"></th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"\">Total</th>";
//echo "<th bgcolor=$color colspan=\"1\" width=\"12%\" align=\"RIGHT\">".amount2Rs($vdebit)."</th>";
//echo "<th bgcolor=$color colspan=\"1\" width=\"20%\" align=\"RIGHT\">".amount2Rs($p_l_bal)."</th>";
//echo "<th bgcolor=$color colspan=\"1\" width=\"20%\" align=\"RIGHT\">".$Lbal."</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"20%\" align=\"RIGHT\">".amount2Rs($Lbal)."</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"12%\" align=\"RIGHT\">".amount2Rs($p_l_bal)."</th>";
echo "</tr>";
echo "</table>";
echo "<td align=left><table width=\"100%\" border=\"1\" cellspacing=\"0\" bordercolor=\"BLACK\" bordercolorlight=\"BLACK\" bordercolordark=\"BLACK\">";
echo "<tr>";
echo "<th bgcolor=$color colspan=\"1\" width=\"12%\"></th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"\">Total</th>";
//echo "<th bgcolor=$color colspan=\"1\" width=\"20%\" align=\"RIGHT\">".amount2Rs($vdebit1)."</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"12%\" align=\"RIGHT\">".amount2Rs($Abal)."</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"20%\" align=\"RIGHT\">".amount2Rs($p_bal)."</th>";
echo "</tr></table>";
echo "</td></tr></table>";
echo "</body>";
echo "</html>";
?>
