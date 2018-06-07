<?
include "../config/config.php";
$code=$_REQUEST['id'];
$staff_id=verifyAutho();
$desc=strtoupper($_REQUEST['desc']);
$fy=$_SESSION['fy'];
getDetailFy($fy,&$f_start_dt,&$f_end_dt);
$start_date=$_REQUEST["f_end_date"];
if(empty($start_date) ) { $start_date=date('d/m/Y'); }
$color='silver';
echo "<html>";
echo "<head>";
echo "<title>Balance Sheet";
echo "</title>";
//echo $f_start_dt;
//echo $start_date;
echo $code;
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
<?
echo "</head>";
echo"<body bgcolor='006699'>";
echo"<br>";
echo"<table align=\"center\" valign='center' width='50%'>";
echo"<tr><th colspan=\"6\" bgcolor='white'>Annexture Balance Sheet Break Up</th></tr>";
echo"<tr><th colspan=\"6\" bgcolor='aqua' align='center'>[".$code."]</th></tr>";
echo "<tr><th bgcolor=$color colspan=\"1\" width=\"10%\">Tran Id</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"10%\">Action Date</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"15%\">OP Bal</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"15%\">Cr Amount</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"15%\">Dr Amount</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"15%\">Curr Bal</th>";
//echo "<th bgcolor=$color colspan=\"1\" width=\"5%\">Dr/Cr</th></tr>";
//$sql_statement="select opbal_ac, ac_op_bal, tot_cr, tot_dr, (ac_op_bal+tot_cr-tot_dr) ac_cl_bal from (select opbal_ac, coalesce(dr_acno, cr_acno) dr_acno, cr_acno, cast(coalesce(tot_dr, 0) as numeric(15, 2)) tot_dr, cast(coalesce(tot_cr, 0) as numeric(15, 2)) tot_cr, cast(coalesce(ac_op_bal, 0) as numeric(15, 2)) ac_op_bal from ( (select account_no opbal_ac, sum(credit-debit) ac_op_bal from mas_gl_tran where action_date<'$f_start_dt' and gl_mas_code='$code' group by account_no) op_ac_bal left join (select account_no cr_acno, cast(coalesce(sum(amount), 0) as numeric(15, 2)) tot_cr from gl_ledger_dtl d, gl_ledger_hrd h where h.tran_id=d.tran_id and action_date between '$f_start_dt' and '$start_date' and gl_mas_code='$code' and dr_cr='Cr' group by account_no) ac_cr on(opbal_ac=cr_acno) left join (select account_no dr_acno, cast(coalesce(sum(amount), 0) as numeric(15, 2)) tot_dr from gl_ledger_dtl d, gl_ledger_hrd h where h.tran_id=d.tran_id and action_date between '$f_start_dt' and '$start_date' and gl_mas_code='$code' and dr_cr='Dr' group by account_no) ac_dr on (opbal_ac=dr_acno) )) x;

//";
$sql_statement="select case when opbal_ac is null then cr_acno else opbal_ac end ac_no,case when opbal_dt is null then cr_dt else opbal_dt end ac_dt, ac_op_bal, tot_cr, tot_dr, (ac_op_bal+tot_cr-tot_dr) ac_cl_bal from (select opbal_ac,opbal_dt, cr_dt,coalesce(dr_acno, cr_acno) dr_acno, cr_acno, cast(coalesce(tot_dr, 0) as numeric(15, 2)) tot_dr, cast(coalesce(tot_cr, 0) as numeric(15, 2)) tot_cr, cast(coalesce(ac_op_bal, 0) as numeric(15, 2)) ac_op_bal from ((select tran_id opbal_ac,action_date opbal_dt, sum(credit-debit) ac_op_bal from mas_gl_tran where action_date<'$f_start_dt' and account_no='$code' group by tran_id,action_date) op_ac_bal full join (select d.tran_id cr_acno,action_date cr_dt, cast(coalesce(sum(amount), 0) as numeric(15, 2)) tot_cr from gl_ledger_dtl d, gl_ledger_hrd h where h.tran_id=d.tran_id and action_date between '$f_start_dt' and '$start_date' and account_no='$code' and dr_cr='Cr' group by d.tran_id,action_date) ac_cr on(opbal_ac=cr_acno) full join (select d.tran_id dr_acno,action_date dr_dt ,cast(coalesce(sum(amount), 0) as numeric(15, 2)) tot_dr from gl_ledger_dtl d, gl_ledger_hrd h where h.tran_id=d.tran_id and action_date between '$f_start_dt' and '$start_date' and account_no='$code' and dr_cr='Dr' group by d.tran_id,action_date) ac_dr on (cr_acno=dr_acno) )) x order by ac_dt;
";


//echo $sql_statement;
$result=dBConnect($sql_statement);
for($j=0; $j<pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	//if($code<'20000'){
	/*if($row['gl_mas_code']<'20000'){
	$dr_cr=($row['curr_bal']<0)?"dr":"cr";
        $fcolor=($dr_cr=='dr')?'red':'green';
	$T_cr+=$row['cr']-$row['op_bal'];
	$par_cr=$row['cr']-$row['op_bal'];
	$par_dr=$row['dr'];
	$T_dr+=$row['dr'];     
		       }
	else
        { 
	$dr_cr=($row['curr_bal']<0)?"cr":"dr";
        $fcolor=($dr_cr=='cr')?'red':'green';
        $T_dr+=$row['dr']-$row['op_bal'];
        $par_dr=$row['dr']-$row['op_bal'];
	$par_cr=$row['cr'];
	$T_cr+=$row['cr'];
         }*/
	echo "<tr>";
	echo "<td width=\"10%\"  bgcolor=$color>".$row[0]."</td>";
	echo "<td width=\"10%\"  bgcolor=$color>".$row[1]."</td>";
	echo "<td align=right width=\"15%\"  bgcolor=$color>".amount2Rs($row[2])."</td>";
	echo "<td align=right width=\"15%\"  bgcolor=$color>".amount2Rs($row[3])."</td>";
	echo "<td align=right width=\"15%\"  bgcolor=$color>".amount2Rs($row[4])."</td>";
	echo "<td align=right width=\"15%\"  bgcolor=$color>".amount2Rs($row[5])."</td>";
	
    /* 
if($code<'20000'){
 $dr_cr=($row['gl_mas_bl']<0)?"dr":"cr";
        $fcolor=($dr_cr=='dr')?'red':'green';
		       }
	else
        { $dr_cr=($row['gl_mas_bl']<0)?"cr":"dr";
        $fcolor=($dr_cr=='cr')?'red':'green'; }
*/
	//echo "<td align=right width=\"15%\"  bgcolor=$color>".amount2Rs(abs($row['curr_bal']))."</td>";
	$T_op_bal+=$row[2];
	$T_dr+=$row[3];
	$T_cr+=$row[4];
	$T_curr+=$row[5];
        //echo "<td align='left' width=\"5%\" bgcolor=$color><font color=$fcolor>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;($dr_cr)</td>";
      	echo "</tr>";
		}
	$color="AQUA";
	echo "<tr  bgcolor=$color>";
	echo "<td align=left colspan=2>Total:$j</td>";
	echo "<td align=right >$T_op_bal";
	echo "<td align=right >$T_dr";
	echo "<td align=right >$T_cr";
	echo "<td align=right >$T_curr";
	echo "</tr>";
echo"</table>";
echo"</form>";
?>

