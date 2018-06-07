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
echo "<body bgcolor=\"\">";
echo "<font size=+3>$SYSTEM_TITLE</font> <br><font size=+1><b>Report Date:".date('d.m.Y')."::".getPrintTime()."</b></font><hr>";

//---------------------------------------------------------------------------------------------
echo "<hr>";

$sql_statement="SELECT FOO.*,UPPER(gl_mas_desc) as gl_mas_desc FROM( 
SELECT gl_mas_code,0 as op_dr,CASE WHEN CAST(gl_mas_code as INT)<30000 THEN SUM(coalesce(gl_mas_bl_prv,0)) ELSE 0 END as op_cr,SUM(dr_amt) as dr,SUM(cr_amt) as cr,0 as dr_bal,CASE WHEN CAST(gl_mas_code as INT)<30000 THEN SUM(cr_amt-dr_amt+coalesce(gl_mas_bl_prv,0)) ELSE SUM(cr_amt-dr_amt) END as cr_bal FROM sch_bs_sh_gm WHERE (CAST(gl_mas_code AS INT) BETWEEN 10000 AND 19999 OR CAST(gl_mas_code AS INT) BETWEEN 40000 AND 59999) AND CAST(gl_mas_code AS INT)NOT IN(12302) GROUP BY gl_mas_code 
UNION ALL 
SELECT '12301',0 ,SUM(gl_mas_bl_prv) as op_cr,0 as dr,0 as cr,0,SUM(gl_mas_bl_prv) as cr_bal FROM sch_bs_sh_gm WHERE CAST(gl_mas_code AS INT)=12302 
) as FOO,gl_master gm WHERE FOO.gl_mas_code=gm.gl_mas_code ORDER BY CAST(FOO.gl_mas_code as INT) ";
//echo $sql_statement;
$result=dBConnect($sql_statement);


echo "<table width=\"100%\" class=\"border\"><tr>";
echo "<th colspan=\"2\" bgcolor=\"Yellow\">Trial Balance NAB(Adjusted) as on : $start_date<tr>";
echo "<td valign=\"top\" width=\"50%\">";
echo "<table width=\"100%\" class=\"border\">";
echo "<tr><th bgcolor=\"green\" colspan=\"6\"><font color=\"white\"><b>Liabilities & Income</b></font>";

// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color colspan=\"1\" width=\"8%\" >Code</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"37%\">Head of account</th>";
echo"<th bgcolor=$color colspan=\"1\" width=\"16%\">Opening Balance at the beginning of the Year</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"10%\" >Total of Debit During the Year</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"10%\" >Total of Credit During the Year</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"10%\" >Closing Balance</th></tr>";
//echo"<tr><td colspan=\"7\" align=center>";
//echo "<div style=\"overflow-y:auto;height:450px\">";
//echo"<table width='100%' align='center'>";
//echo "<th bgcolor=$color colspan=\"1\">closing Balance</th>";
for($j=0; $j<pg_NumRows($result); $j++)
{
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	echo "<tr>";

	echo "<td bgcolor=$color colspan=\"1\" width=\"8%\" ><a href=\"gl_ledger.php?chead=".$row['gl_mas_desc']."[".$row['gl_mas_code']."]&start_date=$f_start_dt&end_date=$end_date&status=1"."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=150,left=350, width=700,height=300'); return false;\">".$row['gl_mas_code']."</a></td>";
	echo "<td bgcolor=$color colspan=\"1\"  width=\"37%\" style=\"height:25px;\">".$row['gl_mas_desc']."</td>";
	//echo "<td bgcolor=$color colspan=\"1\"  width=\"7%\" align='right'>".amount2Rs($row['op_dr'])."</td>";
	//$op_dr+=$row['op_dr'];
	echo "<td bgcolor=$color colspan=\"1\"  width=\"16%\" align='right'>".amount2Rs($row['op_cr'])."</td>";
	$op_cr+=$row['op_cr'];
	echo "<td bgcolor=$color colspan=\"1\"  width=\"10%\" style=\"height:25px;\" align='right'>".amount2Rs($row['dr'])."</td>";
	$dr=$dr+=$row['dr'];
	echo "<td bgcolor=$color colspan=\"1\"  width=\"10%\" style=\"height:25px;\" align='right'>".amount2Rs($row['cr'])."</td>";
	$cr=$cr+=$row['cr'];
	//echo "<td bgcolor=$color colspan=\"1\"  width=\"10%\" style=\"height:25px;\" align='right'>".amount2Rs($row['dr_bal'])."</td>";
	//$bdr+=$row['dr_bal'];
	echo "<td bgcolor=$color colspan=\"1\"  width=\"10%\" style=\"height:25px;\" align='right'>".amount2Rs($row['cr_bal'])."</td>";
	$cdr+=$row['cr_bal'];
	echo"</tr>";
}

echo "</table>";
echo "</td><td valign=\"top\">";
$sql_statement="SELECT FOO.*,UPPER(gl_mas_desc) as gl_mas_desc FROM( 
SELECT gl_mas_code,CASE WHEN CAST(gl_mas_code as INT)<30000 THEN SUM(coalesce(gl_mas_bl_prv,0)) ELSE 0 END as op_dr,0,SUM(dr_amt) as dr,SUM(cr_amt) as cr,CASE WHEN CAST(gl_mas_code as INT)<30000 THEN SUM(dr_amt-cr_amt+coalesce(gl_mas_bl_prv,0)) ELSE SUM(dr_amt-cr_amt) END as dr_bal,0 FROM sch_bs_sh_gm WHERE (CAST(gl_mas_code AS INT) BETWEEN 20000 AND 39999 OR CAST(gl_mas_code AS INT) BETWEEN 60000 AND 79999) GROUP BY gl_mas_code 
) as FOO,gl_master gm WHERE FOO.gl_mas_code=gm.gl_mas_code ORDER BY CAST(FOO.gl_mas_code as INT)";
//echo $sql_statement;
$result=dBConnect($sql_statement);
echo "<table width=\"100%\" class=\"border\">";
echo "<tr><td bgcolor=\"green\" colspan=\"9\" align=\"center\"><font color=\"white\"><b>Assets & Expenditure</b></font>";

// Place line comments if you do not need column header.
$color=$TCOLOR;

echo "<tr>";
echo "<th bgcolor=$color colspan=\"1\" width=\"8%\" >Code</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"37%\">Head of account</th>";
echo"<th bgcolor=$color colspan=\"1\" width=\"16%\">Opening Balance at the beginning of the Year</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"10%\" >Total of Debit During the Year</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"10%\" >Total of Credit During the Year</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"10%\" >Closing Balance</th></tr>";
//echo"<tr><td colspan=\"6\" align=center>";
//echo "<div style=\"overflow-y:auto;height:450px;width:100%\" >";
echo"</tr>";
for($j=0; $j<pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
echo "<tr>";
echo "<td bgcolor=$color colspan=\"1\" width=\"8%\" ><a href=\"gl_ledger.php?chead=".$row['gl_mas_desc']."[".$row['gl_mas_code']."]&start_date=$f_start_dt&end_date=$end_date&status=1"."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=150,left=350, width=700,height=300'); return false;\">".$row['gl_mas_code']."</a></td>";
echo "<td bgcolor=$color colspan=\"1\"  width=\"37%\" style=\"height:25px;\">".$row['gl_mas_desc']."</td>";
echo "<td bgcolor=$color colspan=\"1\"  width=\"16%\" align='right'>".amount2Rs($row['op_dr'])."</td>";
$op_dr+=$row['op_dr'];
//echo "<td bgcolor=$color colspan=\"1\"  width=\"16%\" align='right'>".amount2Rs($row['op_cr'])."</td>";
//$op_cr+=$row['op_cr'];
echo "<td bgcolor=$color colspan=\"1\"  width=\"10%\" style=\"height:25px;\" align='right'>".amount2Rs($row['dr'])."</td>";
$dr=$dr+=$row['dr'];
echo "<td bgcolor=$color colspan=\"1\"  width=\"10%\" style=\"height:25px;\" align='right'>".amount2Rs($row['cr'])."</td>";
$cr=$cr+=$row['cr'];
echo "<td bgcolor=$color colspan=\"1\"  width=\"10%\" style=\"height:25px;\" align='right'>".amount2Rs($row['dr_bal'])."</td>";
$bdr+=$row['dr_bal'];
//echo "<td bgcolor=$color colspan=\"1\"  width=\"10%\" style=\"height:25px;\" align='right'>".amount2Rs($row['cr_bal'])."</td>";
//$cdr+=$row['cr_bal'];
echo"</tr>";
}
echo"</td></tr>";
echo "</tabe>";
echo "<tabe>";
echo"<tr>
<th  style=\"height:25px;\" colspan='2' bgcolor='#18CAAF'>TOTAL </td>

<th  style=\"height:25px;\" colspan='1' bgcolor='#18CAAF' align='right'>".amount2rs($op_cr)."</td>
<th  style=\"height:25px;\" colspan='1' bgcolor='#18CAAF' align='right'>".amount2rs($dr)."</td>
<th  style=\"height:25px;\" colspan='1' bgcolor='#18CAAF' align='right'>".amount2rs($cr)."</td>
<th  style=\"height:25px;\" colspan='1' bgcolor='#18CAAF' align='right'>".amount2rs($cdr)."</td>
</tr>";
echo "</tabe>";
echo "<tabe>";
echo"<tr>
<th  style=\"height:25px;\" colspan='2' bgcolor='#18CAAF'>TOTAL </td>

<th  style=\"height:25px;\" colspan='1' bgcolor='#18CAAF' align='right'>".amount2rs($op_dr)."</td>
<th  style=\"height:25px;\" colspan='1' bgcolor='#18CAAF' align='right'>".amount2rs($dr)."</td>
<th  style=\"height:25px;\" colspan='1' bgcolor='#18CAAF' align='right'>".amount2rs($cr)."</td>
<th  style=\"height:25px;\" colspan='1' bgcolor='#18CAAF' align='right'>".amount2rs($bdr)."</td>
</tr></table>";	

echo "</body>";
echo "</html>";
?>
