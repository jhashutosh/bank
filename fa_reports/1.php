<?
include "../config/config.php";
$staff_id=verifyAutho();
$fy=$_SESSION['fy'];
getDetailFy($fy,&$f_start_dt,&$f_end_dt);
$start_date=$_REQUEST["start_date"];
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
echo "<center><table>";
echo "<font size=+2>$SYSTEM_TITLE</font> <br><font size=+1><b>Report Date:".date('d.m.Y')."::".getPrintTime()."</b></font><hr>";
echo "<div align='center'><input type='button' onclick='print()' value='print'></div>";
echo "</table></center>";
//---------------------------------------------------------------------------------------------
echo "<hr>";
$sql_statement="SELECT INITCAP(ann.annexture_desc) as ann_desc,ann.annexture_no,foo.* FROM 
(SELECT annexure,SUM(cr_amt-dr_amt+gl_mas_bl_prv) as curr_bal,SUM(gl_mas_bl_prv) as prv_bal FROM sch_bs_sh_gm WHERE CAST(gl_mas_code as int)<20000 group by annexure) AS foo,
 annexture_mas as ann 
 WHERE ann.id=foo.annexure
 ORDER BY foo.annexure";
//echo $sql_statement;
$result=dBConnect($sql_statement);


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
	echo "<td align=left  width=\"10%\" bgcolor=$color><a href=\"a_bal_brkup.php?id=".$row['annexure']."&desc=".$row['ann_desc']."&end_date=$start_date"."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=150,left=350, width=700,height=300'); return false;\">Annex-".$row['annexure']."</a>";
	echo "<td align=left width=\"70%\" bgcolor=$color>".$row['ann_desc']."</td>";
	/*$dr_cr=($row['bl']<0)?"dr":"cr";
        $fcolor=($dr_cr=='dr')?'red':'green';
	$p_dr_cr=($row['bl_p']<0)?"dr":"cr";
        $fcolor=($p_dr_cr=='dr')?'red':'green';	*/
	//bl_p
	echo "<td align=right  width=\"15%\" bgcolor=$color>".amount2Rs($row['curr_bal'])."</td>";
	//echo "<font color=$fcolor>($dr_cr)</font>";
       //echo "<td align='left' width=\"5%\" bgcolor=$color>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;($dr_cr)</td>";
	echo "<td align=right  width=\"15%\" bgcolor=$color>".amount2Rs($row['prv_bal'])."</td>";
	//echo " <font color=$fcolor>($p_dr_cr)</font>";
	$Lbal=$Lbal+$row['curr_bal'];
	$P_Lbal+=$row['prv_bal'];

	}
	
echo "</table>";
echo "</td><td valign=\"top\">";
$sql_statement="SELECT INITCAP(ann.annexture_desc) as ann_desc,ann.annexture_no,foo.* FROM 
(SELECT annexure,SUM(dr_amt-cr_amt+gl_mas_bl_prv) as curr_bal,SUM(gl_mas_bl_prv) as prv_bal FROM sch_bs_sh_gm WHERE CAST(gl_mas_code as int) BETWEEN 20000 AND 30000 group by annexure) AS foo,
 annexture_mas as ann 
 WHERE ann.id=foo.annexure
 ORDER BY foo.annexure";
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
	echo "<td align=left  width=\"10%\" bgcolor=$color><a href=\"a_bal_brkup.php?id=".$row['annexure']."&desc=".$row['ann_desc']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=150,left=350, width=700,height=300'); return false;\">Annex-".$row['annexure']."</a>";
	echo "<td align=left width=\"70%\" bgcolor=$color>".$row['ann_desc']."</td>";
	
       /* $dr_cr=($row['bl']<0)?"cr":"dr";
        $fcolor=($dr_cr=='cr')?'red':'green';
	$p_dr_cr=($row['bl_p']<0)?"dr":"cr";
        $fcolor=($p_dr_cr=='dr')?'red':'green';	*/
	echo "<td align=right width=\"15%\"  bgcolor=$color>".amount2Rs($row['curr_bal'])."</td>";
	//echo "<font color=$fcolor>&nbsp;&nbsp;($dr_cr) </font>";
	
       echo "<td align=right  width=\"15%\" bgcolor=$color>".amount2Rs($row['prv_bal'])." </td>";
	//echo "<font color=$fcolor>($p_dr_cr)</font>";
	
	$Abal=$Abal+$row['curr_bal'];
	$P_Abal=$P_Abal+$row['prv_bal'];
	
  
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
