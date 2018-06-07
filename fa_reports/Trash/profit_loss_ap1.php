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
echo "<form name=\"f1\" action=\"profit_loss_ap.php\" method=\"POST\" onsubmit=\"return check();\">";
echo "<table align=center bgcolor=\"#90EE90\"><tr><td  align=\"\"><b>Profit & Loss A/C As On (DD/MM/YYYY) :<td><input type=TEXT size=10 maxlength=\"10\" name=\"start_date\" id=\"start_date\" value=\"$start_date\"  maxlength=\"10\" onFocus=\"javascript:vDateType='1'\" onKeyUp=\"DateFormat(this,this.value,event,false,'3')\" onBlur=\"DateFormat(this,this.value,event,true,'3')\" $HIGHLIGHT>&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.start_date,'dd/mm/yyyy','Choose Date')\">";
echo "<input type=\"HIDDEN\" name=\"f_start_dt\" id=\"f_start_dt\" value=\"$f_start_dt\">";
echo "<input type=\"HIDDEN\" name=\"f_end_dt\" id=\"f_end_dt\" value=\"$f_end_dt\">";
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> ";
echo "</table></form>";
//---------------------------------------------------------------------------------------------
echo "<hr>";
$sql_statement="SELECT SUM(credit-debit) as bal FROM (SELECT a.gl_mas_code,SUM(debit) as debit,SUM(credit) as credit,bs_pl from mas_gl_tran a,gl_master_vw b WHERE (action_date BETWEEN '$f_start_dt' AND '$start_date') AND a.gl_mas_code=b.gl_mas_code group by a.gl_mas_code,bs_pl HAVING bs_pl='S' OR bs_pl='I' OR bs_pl='P' OR bs_pl='E') AS foo";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$balance=pg_result($result,'bal');
}
//echo "<h1> BALANCE :$balance</h1>";
if($balance>0){
$sql_statement="
SELECT gl_mas_code,
gl_mas_desc,
debit,
credit,
bal

from(
SELECT case  when gl_mas_code='12301' and  bal>0 then '12303'  when gl_mas_code='12304' and  bal<0 then null else gl_mas_code end as gl_mas_code,
case  when gl_mas_code='12301' and  bal>0 then 'Accumulated Loss' when gl_mas_code='12304' and  bal<0 then null else gl_mas_desc end as gl_mas_desc,
debit,
credit,
bal
from(

select a.gl_mas_code, initcap(b.gl_mas_desc) as gl_mas_desc, sum(debit) as debit, sum(credit) as credit, sum(debit-credit) as bal from mas_gl_tran as a , gl_master_vw as b WHERE action_date BETWEEN '$f_start_dt' AND '$start_date' AND a.gl_mas_code= b.gl_mas_code and bs_pl='Z' group by a.gl_mas_code, b.gl_mas_desc 

--union all
--select a.gl_mas_code, initcap(b.gl_mas_desc) as gl_mas_desc, sum(debit) as debit, sum(credit) as credit, sum(debit-credit) as bal from mas_gl_tran as 
--a , gl_master_vw1 as b WHERE action_date<='$start_date'  AND a.gl_mas_code= b.gl_mas_code and (bs_pl='Z' or bs_pl='O') group by a.gl_mas_code, 
--b.gl_mas_desc 
union all
SELECT '12301' as gl_mas_code, 'Profit & Loss(U/D Profit)' as gl_mas_desc,SUM(debit) as debit,SUM(credit) as credit,SUM(debit-credit) as bal from
(
SELECT a.gl_mas_code, SUM(debit) as debit,SUM(credit) as credit FROM mas_gl_tran  a ,gl_master_vw b where a.gl_mas_code::text='12301' and 
action_date<'$start_date' AND a.gl_mas_code=b.gl_mas_code GROUP BY a.gl_mas_code 
union all
SELECT '12301' as gl_mas_code, debit,credit FROM (SELECT a.gl_mas_code,SUM(debit) as debit,SUM(credit) as credit from mas_gl_tran a,gl_master_vw b WHERE action_date<'$f_start_dt' AND a.gl_mas_code=b.gl_mas_code group by bs_pl,a.gl_mas_code HAVING bs_pl='S' OR bs_pl='I' OR bs_pl='P' OR bs_pl='E' OR bs_pl='Z') as foo
) foo


UNION ALL
SELECT '12304' as gl_mas_code, 'Profit & Loss(U/D Profit)' as gl_mas_desc,SUM(debit) as debit,SUM(credit) as cedit,SUM(credit-debit) as bal 
FROM 
(SELECT a.gl_mas_code,SUM(debit) as debit,SUM(credit) as credit,bs_pl from mas_gl_tran a,gl_master_vw2 b WHERE action_date BETWEEN '2010-04-01' AND '$start_date' AND a.gl_mas_code=b.gl_mas_code group by a.gl_mas_code,bs_pl HAVING bs_pl='S' OR bs_pl='I' OR bs_pl='P' OR bs_pl='E' OR bs_pl='Z'
union all
SELECT a.gl_mas_code, SUM(debit) as debit,SUM(credit) as credit,bs_pl FROM mas_gl_tran  a ,gl_master_vw2 b where a.gl_mas_code::text='12301' and action_date<'$start_date' AND a.gl_mas_code=b.gl_mas_code GROUP BY a.gl_mas_code ,bs_pl) as foo order by gl_mas_code DESC

) foo

) a where gl_mas_code<>'12301' and gl_mas_code is not null order by gl_mas_code";
//echo $sql_statement;
$result=dBConnect($sql_statement);
echo "<table width=\"100%\" bgcolor=\"pink\"><tr>";
echo "<th colspan=\"2\" bgcolor=\"Yellow\">Profit & Loss Appropriation A/C as on $end_date<tr>";
echo "<th colspan=\"1\" bgcolor=\"WHITE\" align=\"left\">Dr.<th colspan=\"1\" bgcolor=\"WHITE\" align=\"Right\">Cr.<tr>";
echo "<td valign=\"top\" width=\"50%\">";
echo "<table width=\"100%\">";
echo "<tr><th bgcolor=\"green\" colspan=\"5\"><font color=\"white\"><b>Expenditure</b></font>";

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
$sql_statement="
SELECT gl_mas_code,
gl_mas_desc,
debit,
cedit,
bal
from(

SELECT case  when gl_mas_code='12301' and  bal<0 then null when gl_mas_code='12304' and  bal>0 then NULL else gl_mas_code end as gl_mas_code,
case  when gl_mas_code='12301' and  bal<0 then null when gl_mas_code='12304' and  bal>0 then null else gl_mas_desc end as gl_mas_desc,
debit,
cedit,
case  when gl_mas_code='12304' and  bal<0 then ABS(bal) else bal end as bal
from(

(SELECT a.gl_mas_code, 'Profit & Loss Balance As Per Last Account' as gl_mas_desc, SUM(debit) as debit,SUM(credit) as cedit,SUM(credit-debit) as bal FROM mas_gl_tran  a where a.gl_mas_code::text='12301' and action_date<'$start_date' GROUP BY a.gl_mas_code) 
union all
(SELECT '12302' as gl_mas_code, 'Profit & Loss' as gl_mas_desc,SUM(debit) as debit,SUM(credit) as cedit,SUM(credit-debit) as bal FROM (SELECT a.gl_mas_code,SUM(debit) as debit,SUM(credit) as credit,bs_pl from mas_gl_tran a,gl_master_vw b WHERE action_date BETWEEN '$f_start_dt' AND '$start_date' AND a.gl_mas_code=b.gl_mas_code group by a.gl_mas_code,bs_pl HAVING bs_pl='S' OR bs_pl='I' OR bs_pl='P' OR bs_pl='E') as foo order by gl_mas_code)
UNION ALL
(SELECT '12304' as gl_mas_code, 'Acumulated Loss (Carried to B/S)' as gl_mas_desc,SUM(debit) as debit,SUM(credit) as cedit,SUM(credit-debit) as bal 
FROM 
(SELECT a.gl_mas_code,SUM(debit) as debit,SUM(credit) as credit,bs_pl from mas_gl_tran a,gl_master_vw2 b WHERE action_date BETWEEN '2010-04-01' AND '$start_date' AND a.gl_mas_code=b.gl_mas_code group by a.gl_mas_code,bs_pl HAVING bs_pl='S' OR bs_pl='I' OR bs_pl='P' OR bs_pl='E' OR bs_pl='Z'
union all
SELECT a.gl_mas_code, SUM(debit) as debit,SUM(credit) as credit,bs_pl FROM mas_gl_tran  a ,gl_master_vw2 b where a.gl_mas_code::text='12301' and action_date<'$start_date' AND a.gl_mas_code=b.gl_mas_code GROUP BY a.gl_mas_code ,bs_pl) as foo order by gl_mas_code DESC)

) foo
) a where gl_mas_desc is not null";

//echo $sql_statement;
$result=dBConnect($sql_statement);
echo "<table width=\"100%\">";
echo "<tr><td bgcolor=\"green\" colspan=\"5\" align=\"center\"><font color=\"white\"><b>Income</b></font>";

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
	echo "<td align=left bgcolor=$color>".$row['gl_mas_desc']."</td>";
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
echo "<tr><td align=left><table width=\"100%\">";
echo "<tr>";
echo "<th bgcolor=$color colspan=\"1\" width=\"7%\"></th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"\" >Total</th>";
//echo "<th bgcolor=$color colspan=\"1\" width=\"20%\" align=\"RIGHT\">".amount2Rs($vdebit)."</th>";
//echo "<th bgcolor=$color colspan=\"1\" width=\"20%\" align=\"RIGHT\">".amount2Rs($vcredit)."</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"12%\" align=\"RIGHT\">".amount2Rs($Lbal)."</th>";
echo "</tr>";
echo "</table>";
echo "<td align=left><table width=\"100%\">";
echo "<tr>";
echo "<th bgcolor=$color colspan=\"1\" width=\"7%\"></th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"\">Total</th>";
//echo "<th bgcolor=$color colspan=\"1\" width=\"20%\" align=\"RIGHT\">".amount2Rs($vdebit1)."</th>";
//echo "<th bgcolor=$color colspan=\"1\" width=\"20%\" align=\"RIGHT\">".amount2Rs($vcredit1)."</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"12%\" align=\"RIGHT\">".amount2Rs($Abal)."</th>";
echo "</tr></table>";
echo "</td></tr></table>";
}
else{
echo "<h1><font color=\"RED\">Sorry Profit & Loss Appropriation Can't  Created Because profit is not earn </h1></font>";
}
echo "</body>";
echo "</html>";
?>
