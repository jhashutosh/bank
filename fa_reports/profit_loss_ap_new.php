<?php
include "../config/config.php";
$staff_id=verifyAutho();
$fy=$_SESSION['fy'];
$op=$_REQUEST['op'];
getDetailFy($fy,$f_start_dt,$f_end_dt);
$start_date=$_REQUEST["start_date"];

/*if(empty($start_date)){
	$func_balance="delete from sch_bs_sh_gm";
	}
else{
	$func_balance="delete from sch_bs_sh_gm; select all_receivables_payables('$start_date')";

}

$func_res=dBConnect($func_balance);*/
//echo $func_balance;
if(empty($start_date) ) { $start_date=date('d/m/Y'); }
echo "<html>";
echo "<head>";
echo "<title>Profit & Loss AP";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "<script src=\"../JS/date_validation.js\"></script>";
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
echo "</head>";
echo "<body bgcolor=\"\">";
echo "<font size=2>$SYSTEM_TITLE</font> <br><font size=1><b>Report Date:".date('d.m.Y')."::".getPrintTime()."</b></font><hr>";
/*echo "<form name=\"f1\" action=\"profit_loss_ap_new.php?op=f\" method=\"POST\" onsubmit=\"return check();\">";
echo "<table align=center bgcolor=\"yellow\"><tr><td  align=\"\"><b>Profit & Loss As On (DD/MM/YYYY) :<td><input type=TEXT size=10 maxlength=\"10\" name=\"start_date\" id=\"start_date\" value=\"".date('d/m/Y')."\"  maxlength=\"10\" onFocus=\"javascript:vDateType='1'\" onKeyUp=\"DateFormat(this,this.value,event,false,'3')\" onBlur=\"DateFormat(this,this.value,event,true,'3')\" $HIGHLIGHT>&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.start_date,'dd/mm/yyyy','Choose Date')\">";
echo "<input type=\"HIDDEN\" name=\"f_start_dt\" id=\"f_start_dt\" value=\"$f_start_dt\">";
echo "<input type=\"HIDDEN\" name=\"f_end_dt\" id=\"f_end_dt\" value=\"$f_end_dt\">";
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> ";
echo "</table></form>";*/
//---------------------------------------------------------------------------------------------
echo "<hr>";
$TBGCOLOR='white';
$TCOLOR='#FFDEAD';
$color='#839EB8';

$sql_statement="SELECT '12301' as gl_sub_header_code, 'Previous Year Net Loss' as gl_mas_desc,abs(coalesce(gl_mas_bl_prv,0)) as bl from sch_bs_sh_gm where CAST(gl_mas_code as BIGINT)=12302 AND coalesce(gl_mas_bl_prv,0)<0
UNION ALL
SELECT '0' as gl_sub_header_code, 'Current Year Net Loss' as gl_mas_desc,abs(coalesce(gl_mas_bl,0)) as bl from sch_bs_sh_gm where CAST(gl_mas_code as INT)=0 AND  coalesce(gl_mas_bl,0)<0
UNION ALL
select * from  (select s.gl_sub_header_code, gl_sub_header_desc as gl_sub_header_desc,  sum(gl_mas_bl)  as bl from sch_bs_sh_gm s, gl_sub_header g where g.gl_sub_header_code=s.gl_sub_header_code group by s.gl_sub_header_code, gl_sub_header_desc order by s.gl_sub_header_code) s where bl<>0 and CAST(gl_sub_header_code as BIGINT) BETWEEN 70000 AND 79999 
UNION ALL 
SELECT '12302' as gl_sub_header_code, 'Current Year Net Profit(U/D)' as gl_mas_desc,abs(coalesce((gl_mas_bl+gl_mas_bl_prv),0)) as bl from sch_bs_sh_gm where CAST(gl_mas_code as BIGINT)=12302 AND coalesce((gl_mas_bl+gl_mas_bl_prv),0)>0";
//echo $sql_statement;
$result=dBConnect($sql_statement);
echo "<table width=\"100%\" class=\"border\" ><tr>";
echo "<th colspan=\"2\" bgcolor=\"Yellow\">Profit & Loss Appropriation A/C as the year ended on $f_end_dt<tr>";
echo "<th colspan=\"1\" bgcolor=\"WHITE\" align=\"left\">Dr.<th colspan=\"1\" bgcolor=\"WHITE\" align=\"Right\">Cr.<tr>";
echo "<td valign=\"top\" width=\"50%\">";
echo "<table width=\"100%\" class=\"border\">";
echo "<tr><th bgcolor=\"green\" colspan=\"5\"><font color=\"white\"><b>Particulars</b></font>";

// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color colspan=\"1\" width=\"10%\">Code</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"\">Account Name</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"12%\">Amount</th>";

for($j=0; $j<pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);

	echo "<tr>";
	echo "<td align=left bgcolor=$color>".$row['gl_sub_header_code']."</a></td>";
	echo "<td align=left bgcolor=$color>".ucwords($row['gl_mas_desc'])."</td>";
	echo "<td align=right bgcolor=$color>".amount2Rs($row['bl'])."</td>"; 
		$Lbal=$Lbal+$row['bl'];	
					}
	
echo "</table>";
echo "</td><td valign=\"top\" width=\"50%\">";
$sql_statement="SELECT '12301' as gl_sub_header_code, 'Previous Year Net Profit(U/D)' as gl_mas_desc,coalesce(gl_mas_bl_prv,0) as bl from sch_bs_sh_gm where CAST(gl_mas_code as BIGINT)=12302 AND coalesce(gl_mas_bl_prv,0)>0
UNION ALL
SELECT '0' as gl_sub_header_code, 'Current Year Net Profit' as gl_mas_desc,coalesce(gl_mas_bl,0) as bl from sch_bs_sh_gm where CAST(gl_mas_code as INT)=0 AND  coalesce(gl_mas_bl,0)>0
UNION ALL
SELECT '12302' as gl_sub_header_code, 'Current Year Net LOSS(U/D)' as gl_mas_desc,abs(coalesce((gl_mas_bl+gl_mas_bl_prv),0)) as bl from sch_bs_sh_gm where CAST(gl_mas_code as BIGINT)=12302 AND coalesce((gl_mas_bl+gl_mas_bl_prv),0)<0";
//echo $sql_statement;
$result=dBConnect($sql_statement);
echo "<table width=\"100%\"  class=\"border\">";
echo "<tr><td bgcolor=\"green\" colspan=\"5\" align=\"center\"><font color=\"white\"><b>Particulars</b></font>";

// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";

echo "<th bgcolor=$color colspan=\"1\" width=\"7%\">Code</th>";
echo "<th bgcolor=$color colspan=\"1\" >Account Name</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"12%\">Amount</th>";
for($j=0; $j<pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	echo "<tr>";
	echo "<td align=left bgcolor=$color>".$row['gl_sub_header_code']."</a></td>";
	echo "<td align=left bgcolor=$color>".ucwords($row['gl_mas_desc'])."</td>";
        echo "<td align=right bgcolor=$color>".amount2Rs((float)$row['bl'])."</td>"; 
	$Abal=$Abal+$row['bl'];	

					}
	
echo "</tr>";
echo "</table>";
$color="AQUA";
echo "</td></tr>";
echo "<tr><td align=left><table width=\"100%\" class=\"border\">";
echo "<tr>";
echo "<th bgcolor=$color colspan=\"1\" width=\"7%\"></th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"\" >Total</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"12%\" align=\"RIGHT\">".amount2Rs($Lbal)."</th>";
echo "</tr>";
echo "</table>";
echo "<td align=left><table width=\"100%\" class=\"border\">";
echo "<tr>";
echo "<th bgcolor=$color colspan=\"1\" width=\"7%\"></th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"\">Total</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"12%\" align=\"RIGHT\">".amount2Rs($Abal)."</th>";
echo "</tr></table>";
echo "</td></tr></table>";


					
			
	
echo "</body>";
echo "</html>";
?>
