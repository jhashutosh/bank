<?php
include "../config/config.php";
$staff_id=verifyAutho();
$fy=$_SESSION['fy'];
getDetailFy($fy,$f_start_dt,$f_end_dt);
$start_date=$_REQUEST["start_date"];
//if(empty($start_date) ) { $start_date=$f_end_dt; }
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
<?php
/*if(empty($start_date)){
	$func_balance="delete from sch_bs_sh_gm";
	}
else{
	$func_balance="delete from sch_bs_sh_gm; select all_receivables_payables('$start_date')";
}*/
//$func_balance="select all_receivables_payables('$start_date')";
//$func_res=dBConnect($func_balance);
//echo $func_balance;
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<font size=+3>$SYSTEM_TITLE</font> <br><font size=+1><b>Report Date:".date('d.m.Y')."::".getPrintTime()."</b></font><hr>";
/*echo "<form name=\"f1\" action=\"profit_loss.php\" method=\"POST\" onsubmit=\"return check();\">";
echo "<table align=center bgcolor=\"#90EE90\"><tr><td  align=\"\"><b>Profit & Loss A/C As On (DD/MM/YYYY) :<td><input type=TEXT size=10 maxlength=\"10\" name=\"start_date\" id=\"start_date\" value=\"".date('d/m/Y')."\"  maxlength=\"10\" onFocus=\"javascript:vDateType='1'\" onKeyUp=\"DateFormat(this,this.value,event,false,'3')\" onBlur=\"DateFormat(this,this.value,event,true,'3')\" $HIGHLIGHT>&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.start_date,'dd/mm/yyyy','Choose Date')\">";
echo "<input type=\"HIDDEN\" name=\"f_start_dt\" id=\"f_start_dt\" value=\"$f_start_dt\">";
echo "<input type=\"HIDDEN\" name=\"f_end_dt\" id=\"f_end_dt\" value=\"$f_end_dt\">";
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> ";
echo "</table></form>";*/
//---------------------------------------------------------------------------------------------
echo "<hr>";
$sql_statement="SELECT gl_sub_header_code, gl_sub_header_desc,SUM(dr) as dr,SUM(cr)as cr,SUM(bl) as bl,SUM(bl_p) as bl_p FROM (
select '' as gl_sub_header_code, 'GROSS LOSS' as gl_sub_header_desc, 0 as dr,0 as cr, abs(gl_mas_bl) as bl,0 as bl_p from sch_bs_sh_gm  where CAST(gl_mas_code as BIGINT)=1 and gl_mas_bl<0
UNION ALL
select '' as gl_sub_header_code, 'GROSS LOSS' as gl_sub_header_desc, 0 as dr,0 as cr, 0 as bl,abs(coalesce(gl_mas_bl_prv,0)) as bl_p from sch_bs_sh_gm  where CAST(gl_mas_code as BIGINT)=1 and gl_mas_bl_prv<0 ) as foo group by gl_sub_header_code, gl_sub_header_desc
UNION ALL
select * from (select s.gl_sub_header_code, UPPER(gl_sub_header_desc) as gl_sub_header_desc, sum(dr_amt) dr, sum(cr_amt) cr, sum(dr_amt-cr_amt) bl,sum(gl_mas_bl_prv) as bl_p from sch_bs_sh_gm s, gl_sub_header g where g.gl_sub_header_code=s.gl_sub_header_code group by s.gl_sub_header_code, gl_sub_header_desc order by s.gl_sub_header_code) s where (bl<>0 OR  bl_p<>0)and CAST(gl_sub_header_code as BIGINT) BETWEEN 60000 AND 69999
UNION ALL
SELECT gl_sub_header_code, gl_mas_desc,SUM(dr) as dr,SUM(cr)as cr,SUM(bl) as bl,SUM(bl_p) as bl_p FROM (
select '' as gl_sub_header_code, 'NET PROFIT' as gl_mas_desc, 0 as dr,0 as cr, gl_mas_bl as bl,0 as bl_p from sch_bs_sh_gm  where CAST(gl_mas_code as BIGINT)=0 and gl_mas_bl>0
UNION ALL
select '' as gl_sub_header_code, 'NET PROFIT' as gl_mas_desc, 0 as dr,0 as cr, 0 as bl,coalesce(gl_mas_bl_prv,0) as bl_p from sch_bs_sh_gm  where CAST(gl_mas_code as BIGINT)=0 and gl_mas_bl_prv>0 ) as foo group by gl_sub_header_code, gl_mas_desc";
///echo $sql_statement;
$result=dBConnect($sql_statement);
echo "<table width=\"100%\" border=\"1\" cellspacing=\"0\" bordercolor=\"BLACK\" bordercolorlight=\"BLACK\" bordercolordark=\"BLACK\"><tr>";
echo "<th colspan=\"2\" bgcolor=\"Yellow\"><font size=\"+3\">Profit & Loss A/C as on $start_date</font><tr>";
echo "<th colspan=\"1\" bgcolor=\"WHITE\" align=\"left\">Dr.<th colspan=\"1\" bgcolor=\"WHITE\" align=\"Right\">Cr.<tr>";
echo "<td valign=\"top\" width=\"50%\">";
echo "<table width=\"100%\" border=\"1\" cellspacing=\"0\" bordercolor=\"BLACK\" bordercolorlight=\"BLACK\" bordercolordark=\"BLACK\">";
echo "<tr><th bgcolor=\"green\" colspan=\"5\"><font color=\"white\"><b>Expenditure</b></font>";

// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color colspan=\"1\" width=\"7%\">Code</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"\">Account Name</th>";
//echo "<th bgcolor=$color colspan=\"1\" width=\"20%\">Debit</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"20%\">Current</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"20%\">Previous</th>";

for($j=0; $j<pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	//$vdebit=$vdebit+$row['debit'];
	//$vcredit=$vcredit+$row['credit'];
	echo "<tr>";
	//if ($row['gl_sub_header_code']!='1'  or $row['gl_sub_header_code']!='0')
	echo "<td align=left  width=\"10%\" bgcolor=$color><a href=\"bal_brkup.php?id=".$row['gl_sub_header_code']."&desc=".$row['gl_sub_header_desc']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=150,left=350, width=700,height=300'); return false;\">[".$row['gl_sub_header_code']."]</a>";
	//else
	//	echo "<td align=left  width=\"10%\" bgcolor=$color></td>";
	echo "<td align=left width=\"70%\" bgcolor=$color>".$row['gl_sub_header_desc']."</td>";
	echo "<td align=right bgcolor=$color>".amount2Rs($row['bl'])."</td>";
	echo "<td align=right bgcolor=$color>".amount2Rs($row['bl_p'])."</td>";
	$Lbal=$Lbal+$row['bl'];
	$P_Lbal=$P_Lbal+$row['bl_p'];
        }
	
echo "</table border=\"1\" cellspacing=\"0\" bordercolor=\"BLACK\" bordercolorlight=\"BLACK\" bordercolordark=\"BLACK\">";
echo "</td><td valign=\"top\" width=\"50%\">";
$sql_statement="SELECT gl_sub_header_code, gl_sub_header_desc,SUM(dr) as dr,SUM(cr)as cr,SUM(bl) as bl,SUM(bl_p) as bl_p FROM (
select '' as gl_sub_header_code, 'GROSS PROFIT' as gl_sub_header_desc, 0 as dr,0 as cr, gl_mas_bl as bl,0 as bl_p from sch_bs_sh_gm  where CAST(gl_mas_code as BIGINT)=1 and gl_mas_bl>0
UNION ALL
select '' as gl_sub_header_code, 'GROSS PROFIT' as gl_sub_header_desc, 0 as dr,0 as cr, 0 as bl,coalesce(gl_mas_bl_prv,0) as bl_p from sch_bs_sh_gm  where CAST(gl_mas_code as BIGINT)=1 and gl_mas_bl_prv>0 ) as foo group by gl_sub_header_code, gl_sub_header_desc
UNION ALL
select * from (select s.gl_sub_header_code, UPPER(gl_sub_header_desc) as gl_sub_header_desc, sum(dr_amt) dr, sum(cr_amt) cr, sum(cr_amt-dr_amt) bl,sum(gl_mas_bl_prv) as bl_p from sch_bs_sh_gm s, gl_sub_header g where g.gl_sub_header_code=s.gl_sub_header_code group by s.gl_sub_header_code, gl_sub_header_desc order by s.gl_sub_header_code) s where (bl<>0 OR  bl_p<>0) and CAST(gl_sub_header_code as BIGINT) BETWEEN 50000 AND 59999
UNION ALL
SELECT gl_sub_header_code, gl_mas_desc,SUM(dr) as dr,SUM(cr)as cr,SUM(bl) as bl,SUM(bl_p) as bl_p FROM (
select '' as gl_sub_header_code, 'NET LOSS' as gl_mas_desc, 0 as dr,0 as cr, abs(gl_mas_bl) as bl,0 as bl_p from sch_bs_sh_gm  where CAST(gl_mas_code as BIGINT)=0 and gl_mas_bl<0
UNION ALL
select '' as gl_sub_header_code, 'NET LOSS' as gl_mas_desc, 0 as dr,0 as cr, 0 as bl,abs(gl_mas_bl_prv) as bl_p from sch_bs_sh_gm  where CAST(gl_mas_code as BIGINT)=0 and gl_mas_bl_prv<0 ) as foo group by gl_sub_header_code, gl_mas_desc";
//echo $sql_statement;
$result=dBConnect($sql_statement);
echo "<table width=\"100%\" border=\"1\" cellspacing=\"0\" bordercolor=\"BLACK\" bordercolorlight=\"BLACK\" bordercolordark=\"BLACK\">";
echo "<tr><td bgcolor=\"green\" colspan=\"5\" align=\"center\"><font color=\"white\"><b>Income</b></font>";

// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";

echo "<th bgcolor=$color colspan=\"1\" width=\"7%\">Code</th>";
echo "<th bgcolor=$color colspan=\"1\" >Account Name</th>";
//echo "<th bgcolor=$color colspan=\"1\">Debit</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"20%\">Current</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"20%\">Previous</th>";
for($j=0; $j<pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	echo "<tr>";
	//if ($row['gl_sub_header_code']!='1'  or $row['gl_sub_header_code']!='0')
	echo "<td align=left  width=\"10%\" bgcolor=$color><a href=\"bal_brkup.php?id=".$row['gl_sub_header_code']."&desc=".$row['gl_sub_header_desc']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=150,left=350, width=700,height=300'); return false;\">[".$row['gl_sub_header_code']."]</a>";
	//else
	//	echo "<td align=left  width=\"10%\" bgcolor=$color></td>";
	echo "<td align=left width=\"70%\" bgcolor=$color>".$row['gl_sub_header_desc']."</td>";
	echo "<td align=right bgcolor=$color>".amount2Rs($row['bl'])."</td>";
	echo "<td align=right bgcolor=$color>".amount2Rs($row['bl_p'])."</td>";
	$Abal=$Abal+$row['bl'];
        $P_Abal=$P_Abal+$row['bl_p'];
	}
	
echo "</tr>";
echo "</table border=\"1\" cellspacing=\"0\" bordercolor=\"BLACK\" bordercolorlight=\"BLACK\" bordercolordark=\"BLACK\">";
$color="AQUA";
echo "</td></tr>";
echo "<tr><td align=left><table width=\"100%\" border=\"1\" cellspacing=\"0\" bordercolor=\"BLACK\" bordercolorlight=\"BLACK\" bordercolordark=\"BLACK\">";
echo "<tr>";
echo "<th bgcolor=$color colspan=\"1\" width=\"7%\"></th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"\" >Total</th>";
//echo "<th bgcolor=$color colspan=\"1\" width=\"20%\" align=\"RIGHT\">".amount2Rs($vdebit)."</th>";
//echo "<th bgcolor=$color colspan=\"1\" width=\"20%\" align=\"RIGHT\">".amount2Rs($vcredit)."</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"12%\" align=\"RIGHT\">".amount2Rs($Lbal)."</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"12%\" align=\"RIGHT\">".amount2Rs($P_Lbal)."</th>";
echo "</tr>";
echo "</table>";
echo "<td align=left><table width=\"100%\">";
echo "<tr>";
echo "<th bgcolor=$color colspan=\"1\" width=\"7%\"></th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"\">Total</th>";
//echo "<th bgcolor=$color colspan=\"1\" width=\"20%\" align=\"RIGHT\">".amount2Rs($vdebit1)."</th>";
//echo "<th bgcolor=$color colspan=\"1\" width=\"20%\" align=\"RIGHT\">".amount2Rs($vcredit1)."</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"12%\" align=\"RIGHT\">".amount2Rs($Abal)."</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"12%\" align=\"RIGHT\">".amount2Rs($P_Abal)."</th>";
echo "</tr></table>";
echo "</td></tr></table>";
echo "</body>";
echo "</html>";
?>
