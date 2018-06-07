<?
include "../config/config.php";
$staff_id=verifyAutho();
$fy=$_SESSION['fy'];
getDetailFy($fy,&$f_start_dt,&$f_end_dt);
$start_date=$_REQUEST["start_date"];
//if(empty($start_date) ) { $start_date=$f_end_dt; }
if(empty($start_date)){
	$func_balance="delete from sch_bs_sh_gm";
	}
else{
	$func_balance="delete from sch_bs_sh_gm; select all_receivables_payables('$start_date')";
}

$func_res=dBConnect($func_balance);
//echo $func_balance;
if(empty($start_date) ) { $start_date=date('d/m/Y'); }
echo "<html>";
echo "<head>";
echo "<title>Balance Sheet";
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
<?
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<font size=+3>$SYSTEM_TITLE</font> <br><font size=+1><b>Report Date:".date('d.m.Y')."::".getPrintTime()."</b></font><hr>";
echo "<form name=\"f1\" action=\"p_balance_sheet.php\" method=\"POST\" onsubmit=\"return check();\">";
echo "<table align=center bgcolor=\"#90EE90\"><tr><td  align=\"\"><b>Balance Sheet As On (DD/MM/YYYY) :<td><input type=TEXT size=10 maxlength=\"10\" name=\"start_date\" id=\"start_date\" value=\"".date('d/m/Y')."\"  maxlength=\"10\" onFocus=\"javascript:vDateType='1'\" onKeyUp=\"DateFormat(this,this.value,event,false,'3')\" onBlur=\"DateFormat(this,this.value,event,true,'3')\" $HIGHLIGHT>&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.start_date,'dd/mm/yyyy','Choose Date')\">";
echo "<input type=\"HIDDEN\" name=\"f_start_dt\" id=\"f_start_dt\" value=\"$f_start_dt\">";
echo "<input type=\"HIDDEN\" name=\"f_end_dt\" id=\"f_end_dt\" value=\"$f_end_dt\">";
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> ";
echo "</table></form>";
//---------------------------------------------------------------------------------------------
echo "<hr>";

//$sql_statement="select * from (select s.gl_sub_header_code, initcap(gl_sub_header_desc) as gl_sub_header_desc, sum(dr_amt) dr, sum(cr_amt) cr, sum(gl_mas_bl) bl from sch_bs_sh_gm s, gl_sub_header g where g.gl_sub_header_code=s.gl_sub_header_code group by s.gl_sub_header_code, gl_sub_header_desc order by s.gl_sub_header_code) s where bl<>0 and cast(gl_sub_header_code as int)<20000";
$sql_statement="select * from (select s.gl_sub_header_code, INITCAP(gl_sub_header_desc) as gl_sub_header_desc, sum(dr_amt) dr, sum(cr_amt) cr, sum(gl_mas_bl) bl,sum(gl_mas_bl_prv) as bl_p from sch_bs_sh_gm s, gl_sub_header g where g.gl_sub_header_code=s.gl_sub_header_code group by s.gl_sub_header_code, gl_sub_header_desc order by s.gl_sub_header_code) s where bl<>0 and CAST(gl_sub_header_code as BIGINT)<20000";
//echo $sql_statement;
$result=dBConnect($sql_statement);
//$num_row=pg_NumRows($result);
//echo "<h1> hiiii$num_row</h1>";
//$row=pg_fetch_array($result,0);

echo "<table width=\"100%\" bgcolor=\"\"><tr>";
echo "<th colspan=\"2\" bgcolor=\"Yellow\">Balance Sheet as on $start_date<tr>";
echo "<td valign=\"top\" width=\"50%\">";
echo "<table width=\"100%\" border=\"1\" cellspacing=\"0\" bordercolor=\"BLACK\" bordercolorlight=\"BLACK\" bordercolordark=\"BLACK\">";
echo "<tr><th bgcolor=\"green\" colspan=\"5\"><font color=\"white\"><b>Liabilities</b></font>";

// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color colspan=\"1\" width=\"10%\">Schedule</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"70%\">Account Name</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"15%\">Current<br>Amount</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"15%\">Previous<br>Amount</th>";
for($j=0; $j<pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	echo "<tr>";
	echo "<td align=left  width=\"10%\" bgcolor=$color><a href=\"bal_brkup.php?id=".$row['gl_sub_header_code']."&desc=".$row['gl_sub_header_desc']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=150,left=350, width=700,height=300'); return false;\">[".$row['gl_sub_header_code']."]</a>";
	echo "<td align=left width=\"70%\" bgcolor=$color>".$row['gl_sub_header_desc']."</td>";
	/*$dr_cr=($row['bl']<0)?"dr":"cr";
        $fcolor=($dr_cr=='dr')?'red':'green';
	$p_dr_cr=($row['bl_p']<0)?"dr":"cr";
        $fcolor=($p_dr_cr=='dr')?'red':'green';	*/
	//bl_p
	echo "<td align=right  width=\"15%\" bgcolor=$color>".amount2Rs($row['bl'])."</td>";
	//echo "<font color=$fcolor>($dr_cr)</font>";
       //echo "<td align='left' width=\"5%\" bgcolor=$color>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;($dr_cr)</td>";
	echo "<td align=right  width=\"15%\" bgcolor=$color>".amount2Rs($row['bl_p'])."</td>";
	//echo " <font color=$fcolor>($p_dr_cr)</font>";
	$Lbal=$Lbal+$row['bl'];
	$P_Lbal+=$row['bl_p'];

	}
	
echo "</table>";
echo "</td><td valign=\"top\">";
$sql_statement="select * from (select s.gl_sub_header_code, initcap(gl_sub_header_desc) as gl_sub_header_desc, sum(dr_amt) dr, sum(cr_amt) cr, sum(gl_mas_bl) bl,sum(gl_mas_bl_prv) as bl_p from sch_bs_sh_gm s, gl_sub_header g where g.gl_sub_header_code=s.gl_sub_header_code group by s.gl_sub_header_code, gl_sub_header_desc order by s.gl_sub_header_code) s where cast(gl_sub_header_code as int) between 20000 and 30000";
//echo $sql_statement;
$result=dBConnect($sql_statement);
echo "<table width=\"100%\" border=\"1\" cellspacing=\"0\" bordercolor=\"BLACK\" bordercolorlight=\"BLACK\" bordercolordark=\"BLACK\">";
echo "<tr><td bgcolor=\"green\" colspan=\"9\" align=\"center\"><font color=\"white\"><b>Assets</b></font>";

// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";

echo "<th bgcolor=$color colspan=\"1\" width=\"10%\">Schedule</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"70%\">Account Name</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"15%\">Current<br>Amount</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"15%\">Previous<br>Amount</th>";
for($j=0; $j<pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	
	echo "<tr>";
	echo "<td  width=\"10%\" align=left bgcolor=$color><a href=\"bal_brkup.php?id=".$row['gl_sub_header_code']."&desc=".$row['gl_sub_header_desc']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=150,left=350, width=700,height=300'); return false;\">[".$row['gl_sub_header_code']."]</a>";
	echo "<td align=left width=\"70%\" bgcolor=$color>".$row['gl_sub_header_desc']."</td>";
       /* $dr_cr=($row['bl']<0)?"cr":"dr";
        $fcolor=($dr_cr=='cr')?'red':'green';
	$p_dr_cr=($row['bl_p']<0)?"dr":"cr";
        $fcolor=($p_dr_cr=='dr')?'red':'green';	*/
	echo "<td align=right width=\"15%\"  bgcolor=$color>".amount2Rs($row['bl'])."</td>";
	//echo "<font color=$fcolor>&nbsp;&nbsp;($dr_cr) </font>";
	
       echo "<td align=right  width=\"15%\" bgcolor=$color>".amount2Rs($row['bl_p'])." </td>";
	//echo "<font color=$fcolor>($p_dr_cr)</font>";
	
	$Abal=$Abal+$row['bl'];
	$P_Abal=$P_Abal+$row['bl_p'];
	
  
	}
	
echo "</tr>";
echo "</table border=\"1\" cellspacing=\"0\" bordercolor=\"BLACK\" bordercolorlight=\"BLACK\" bordercolordark=\"BLACK\">";
$color="AQUA";
echo "</td></tr>";
echo "<tr><td align=left><table width=\"100%\">";
echo "<tr>";
echo "<th bgcolor=$color colspan=\"1\" width=\"10%\"></th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"70%\">Total</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"15%\" align=\"RIGHT\">".amount2Rs($Lbal)."</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"15%\" align=\"RIGHT\">".amount2Rs($P_Lbal)."</th>";
echo "</tr>";
echo "</table border=\"1\" cellspacing=\"0\" bordercolor=\"BLACK\" bordercolorlight=\"BLACK\" bordercolordark=\"BLACK\">";
echo "<td align=left><table width=\"100%\">";
echo "<tr>";
echo "<th bgcolor=$color colspan=\"1\" width=\"10%\"></th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"70\">Total</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"15%\" align=\"RIGHT\">".amount2Rs($Abal)."</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"15%\" align=\"RIGHT\">".amount2Rs($P_Abal)."</th>";
echo "</tr></table>";
echo "</td></tr></table>";
echo "</body>";
echo "</html>";
?>
