<?php
include "../config/config.php";
$staff_id=verifyAutho();
$fy=$_SESSION['fy'];
$op=$_REQUEST['op'];
getDetailFy($fy,$f_start_dt,$f_end_dt);
$start_date=$_REQUEST["start_date"];
echo "<html>";
echo "<head>";
echo "<title>Trial Balance";
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
echo "<body bgcolor=\"lightyellow\">";
echo "<center><font size=2>$SYSTEM_TITLE</font> <br><font size=1><b>Report Date:".date('d.m.Y')."::".getPrintTime()."</b></font></center>";
echo "<div align='center'><input type='button' onclick='print()' value='print'></div>";
//---------------------------------------------------------------------------------------------
echo "<hr>";
$TBGCOLOR='white';
$TCOLOR='#FFDEAD';
$color='#839EB8';
$sql_statement="SELECT FOO.*,UPPER(gl_mas_desc) as gl_mas_desc FROM(
SELECT  gl_mas_code,SUM(gl_mas_bl_prv) as op_dr,0 as op_cr,SUM(dr_amt) as dr,SUM(cr_amt) as cr,SUM(dr_amt-cr_amt+gl_mas_bl_prv) as dr_bal,0 FROM sch_bs_sh_gm WHERE fn_nm IN ('bs_sch','P/L') AND (CAST(gl_mas_code AS INT) BETWEEN 20000 AND 39999 OR CAST(gl_mas_code AS INT) BETWEEN 60000 AND 79999)  GROUP BY gl_mas_code
) as FOO,gl_master gm WHERE FOO.gl_mas_code=gm.gl_mas_code ORDER BY CAST(FOO.gl_mas_code as INT)
";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result) == 0) {
echo "<h4> No Suitable data found !!!</h4>";
			   } 
else 			{
echo "<table width=\"100%\" bgcolor=\"white\">";
echo "<tr>";
echo "<th bgcolor=$color colspan=\"6\"><font size='2'>Cash Cum Trial Balance(Adjusted) -Dr as on : $start_date </font></th></tr>";
echo "<tr>";
echo "<th bgcolor=$color width=\"8%\" colspan=\"1\" width=\"8%\" >Code</th>";
echo "<th bgcolor=$color   width=\"37%\" colspan=\"1\" width=\"37%\">Account Name</th>";
echo"<th bgcolor=$color width=\"7%\" colspan=\"1\" width=\"16%\">Opening Balance Cr.</th>";
echo "<th bgcolor=$color  width=\"10%\" colspan=\"1\" width=\"10%\" >Debit(+)</th>";
echo "<th bgcolor=$color  width=\"10%\" colspan=\"1\" width=\"10%\" >Credit(-)</th>";
echo "<th bgcolor=$color  width=\"10%\" colspan=\"1\" width=\"10%\" >Balance</th></tr>";
echo"<tr><td colspan=\"6\" align=center>";
//echo "<div style=\"overflow-y:auto;height:450px\">";
echo "<div>";
echo"<table width='100%' align='center'>";
//echo "<th bgcolor=$color colspan=\"1\">closing Balance</th>";
echo"</tr>";
for($j=0; $j<pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
echo "<tr>";

echo "<td bgcolor=$color colspan=\"1\" width=\"8%\" ><a href=\"gl_ledger.php?chead=".$row['gl_mas_desc']."[".$row['gl_mas_code']."]&start_date=$f_start_dt&end_date=$end_date&status=1"."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=150,left=350, width=700,height=300'); return false;\">".$row['gl_mas_code']."</a></td>";
echo "<td bgcolor=$color colspan=\"1\"  width=\"37%\" style=\"height:25px;\">".$row['gl_mas_desc']."</td>";
echo "<td bgcolor=$color colspan=\"1\"  width=\"7%\" align='right'>".amount2Rs($row['op_dr'])."</td>";
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
//

echo"</table>";
echo"</div>";


echo"</td></tr>";
echo"<tr>
<td  style=\"height:25px;\" colspan='2' bgcolor='#18CAAF'>TOTAL </td>

<td  style=\"height:25px;\" colspan='1' bgcolor='#18CAAF' align='right'>".amount2rs($op_dr)."</td>
<td  style=\"height:25px;\" colspan='1' bgcolor='#18CAAF' align='right'>".amount2rs($dr)."</td>
<td  style=\"height:25px;\" colspan='1' bgcolor='#18CAAF' align='right'>".amount2rs($cr)."</td>
<td  style=\"height:25px;\" colspan='1' bgcolor='#18CAAF' align='right'>".amount2rs($bdr)."</td>
</tr></table>";
//
			}

echo "</body>";
echo "</html>";
?>
