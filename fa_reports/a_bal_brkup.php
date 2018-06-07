<?php
include "../config/config.php";
$code=$_REQUEST['id'];
$staff_id=verifyAutho();
$desc=strtoupper($_REQUEST['desc']);
$fy=$_SESSION['fy'];
getDetailFy($fy,&$f_start_dt,&$f_end_dt);
$end_date=$_REQUEST["end_date"];
//$f_start_dt=$_REQUEST["f_start_dt"];
if(empty($start_date) ) { $start_date=date('d/m/Y'); }
$color='silver';
echo "<html>";
echo "<head>";
echo "<title>Balance Sheet";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
?>
<script language="JAVASCRIPT">
function closeme() { 
	close(); 
}
function myRefresh(URL){
	window.opener.location.href =URL;
    	self.close();
    	}

</script>
<?php
echo "</head>";
echo"<body bgcolor='006699'>";
echo"<br>";
echo"<table align=\"center\" valign='center' width='90%'>";
echo"<tr><th colspan=\"6\" bgcolor='white'>Annexture Balance Sheet Break Up</th></tr>";
echo"<tr><th colspan=\"6\" bgcolor='aqua' align='center'>".$desc." ["."Annexture-".$code."]</th></tr>";
echo "<tr><th bgcolor=$color colspan=\"1\" width=\"10%\">GL_CODE</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"45%\">GL Desc</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"15%\">Op_Bal </th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"15%\">Dr Amount</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"15%\">Cr Amount</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"15%\">Curr Bal</th>";
//echo "<th bgcolor=$color colspan=\"1\" width=\"5%\">Dr/Cr</th></tr>";

$sql_statement="SELECT UPPER(gm.gl_mas_desc)  as gl_mas_desc,foo.* FROM
(SELECT gl_mas_code,SUM(gl_mas_bl_prv) as op_bal,SUM(dr_amt)as dr,SUM(cr_amt) as cr FROM sch_bs_sh_gm WHERE annexure=$code GROUP BY gl_mas_code) as foo,
gl_master gm 
WHERE gm.gl_mas_code=foo.gl_mas_code order by cast(gm.gl_mas_code as integer)";
//echo $sql_statement;
$result=dBConnect($sql_statement);
for($j=0; $j<pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	//if($code<'20000'){
	if($row['gl_mas_code']<'20000'){
	/*$dr_cr=($row['curr_bal']<0)?"dr":"cr";
        $fcolor=($dr_cr=='dr')?'red':'green';*/
	//$T_cr+=$row['cr']-$row['op_bal'];
	$T_cr+=$row['cr'];
	$par_cr=$row['cr'];
	$par_dr=$row['dr'];
	$T_dr+=$row['dr']; 
	$curr_bal=$row['cr']-$row['dr']+$row['op_bal']; 
		       }
	else
        { 
	$dr_cr=($row['curr_bal']<0)?"cr":"dr";
        $fcolor=($dr_cr=='cr')?'red':'green';
        $T_dr+=$row['dr'];
        $par_dr=$row['dr'];
	$par_cr=$row['cr'];
	$T_cr+=$row['cr'];
	$curr_bal=$row['dr']-$row['cr']+$row['op_bal']; 
	
         }
	$curr_bal=round($curr_bal,2);
	echo "<tr>";
	echo "<td align=left width=\"10%\" bgcolor=$color><a href=\"gl_ledger.php?chead=".$row['gl_mas_desc']."[".$row['gl_mas_code']."]&start_date=$f_start_dt&end_date=$end_date&status=1"."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=150,left=350, width=700,height=300'); return false;\">".$row['gl_mas_code']."</a>";
	echo "<td width=\"45%\"  bgcolor=$color>".$row['gl_mas_desc']."</td>";
	echo "<td align=right width=\"45%\"  bgcolor=$color>".amount2Rs($row['op_bal'])."</td>";
	$T_op_bal+=$row['op_bal'];
	echo "<td align=right width=\"15%\"  bgcolor=$color>".amount2Rs(($par_dr))."</td>";
	echo "<td align=right width=\"15%\"  bgcolor=$color>".amount2Rs(($par_cr))."</td>";
    /* 
if($code<'20000'){
 $dr_cr=($row['gl_mas_bl']<0)?"dr":"cr";
        $fcolor=($dr_cr=='dr')?'red':'green';
		       }
	else
        { $dr_cr=($row['gl_mas_bl']<0)?"cr":"dr";
        $fcolor=($dr_cr=='cr')?'red':'green'; }
*/
	echo "<td align=right width=\"15%\"  bgcolor=$color>".amount2Rs($curr_bal)."</td>";
	$T_curr+=$curr_bal;
        //echo "<td align='left' width=\"5%\" bgcolor=$color><font color=$fcolor>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;($dr_cr)</td>";
      	echo "</tr>";
		}
	$color="AQUA";
	echo "<tr  bgcolor=$color>";
	echo "<td align=left colspan=2>Total:</td>";
	echo "<td align=right >$T_op_bal";
	echo "<td align=right >$T_dr";
	echo "<td align=right >$T_cr";
	echo "<td align=right >$T_curr";
	echo "</tr>";
echo"</table>";
echo"</form>";
?>

