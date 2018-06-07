<!doctype html>
<?
include "../config/config.php";
$staff_id=verifyAutho();
$v_id=$_REQUEST['q'];
$fy=$_SESSION['fy'];
//echo $fy;
/*$gl_arr=new array();
$gl_arr['10000']='LIABILITIES';
$gl_arr['20000']='ASSETS';
$gl_arr['30000']='PURCHASES';
$gl_arr['40000']='SALES';
$gl_arr['50000']='INCOMES';
$gl_arr['60000']='EXPENDITURES';*/

$gl_arr=array(
		"10000"=>"LIABILITIES",
		"20000"=>"ASSETS",
		"30000"=>"PURCHASES",
		"40000"=>"SALES",
		"50000"=>"INCOMES",
		"60000"=>"EXPENDITURES"
		);
?>
<html>
<head>
<link rel="stylesheet" href="../JS/themes/base/jquery.ui.all.css">
	<script src="../JS/jquery-1.9.1.js"></script>
	<script src="../JS/ui/jquery.ui.core.js"></script>
	<script src="../JS/ui/jquery.ui.widget.js"></script>
	<script src="../JS/ui/jquery-ui-1.10.3.custom.min.js"></script>
<script type="text/javascript">
</script>
<style>
#codingTable{
	border-collapse:collapse;
	width:100%;
}
#codingTable caption{
	width:100%;
	font-size:2em;
	color:#efefef;
	background-color:#4f4f4f;
}
#codingTable tr.tr0{
	font-size:1.8em;
	color:blue;
	background-color:#efefef;
}
#codingTable th,
#codingTable td
{
	font-size:1em;
	border:solid 1px black;
}
.subTable{
	border-collapse:collapse;
	width:100%;
}
.subTable td{
	word-warp:break-line;
	border:solid 1px black;
}
.subTable tr.tr1{
	font-size:1.7em;
	color:green;
	background-color:#dfdfdf;
}
.subTable tr.tr2{
	font-size:1.4em;
	color:red;
	background-color:#cfcfcf;
}
.subTable tr.tr3{
	font-size:1em;
	color:black;
	background-color:#bfbfbf;
}
</style>
</head>
<body>
<?
$gl=$_REQUEST['gl'];
$glName=$gl_arr[$gl];
//$glName='LIABILITIES';
$upper=$gl+10000;
$lower=$gl;
if($gl==20000 || $gl== 30000 || $gl== 60000)
$dr_cr='dr_amt-cr_amt';
else
$dr_cr='cr_amt-dr_amt';
$sql_statement="SELECT * FROM (

(select '$gl' as code,'$glName' as head,sum(a.bal) as curr_bal ,sum(a.prv) as prev_bal,'top' as lvl,0 as od from (select gl_mas_code,sum(gl_mas_bl_prv) prv,sum(dr_amt),sum(cr_amt),sum($dr_cr) as bal from sch_bs_sh_gm group by gl_mas_code having cast(gl_mas_code as integer)<$upper and cast(gl_mas_code as integer)>$lower  order by gl_mas_code) as a)

union 

(select gm.gl_header_code as code, gm.gl_header_desc, sum(curr_bal), sum(prev_bal),'gl_header'as lvl,1 as od from
	(select substr(sc.gl_sub_header_code,1,2)||'000' as cd,sum($dr_cr) as curr_bal, sum(gl_mas_bl_prv) as prev_bal
	from sch_bs_sh_gm sc
	group by sc.gl_sub_header_code
	having cast(sc.gl_sub_header_code as integer)<$upper 
	and cast(sc.gl_sub_header_code as integer)>$lower) gp,gl_header gm
group by gp.cd,gm.gl_header_code,gm.gl_header_desc
having gp.cd=gm.gl_header_code)


union 

(select sc.gl_sub_header_code as code, gm.gl_sub_header_desc, sum($dr_cr) as curr_bal, sum(gl_mas_bl_prv) as prev_bal,'gl_sub_header'as lvl,2 as od 
from sch_bs_sh_gm sc,gl_sub_header gm 
where sc.gl_sub_header_code=gm.gl_sub_header_code 
group by sc.gl_sub_header_code,gm.gl_sub_header_desc  
having cast(sc.gl_sub_header_code as integer)<$upper 
and cast(sc.gl_sub_header_code as integer)>$lower)


union 

(
select sc.gl_mas_code as code,gm.gl_mas_desc as head,sum($dr_cr) as curr_bal,sum(sc.gl_mas_bl_prv) as prev_bal,'gl_mas_code'as lvl,3 as od 
from sch_bs_sh_gm sc,gl_master gm
where sc.gl_mas_code=gm.gl_mas_code
group by sc.gl_mas_code,gm.gl_mas_desc 
having cast(sc.gl_mas_code as integer)<$upper 
and cast(sc.gl_mas_code as integer)>$lower
)

) as b 
where b.curr_bal<>0 
or b.prev_bal<>0 
order by code,od;";
//echo "$sql_statement";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){
for($j=0; $j<pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
?>
<?if($row['od']==0){?>
<table id='codingTable'  cellspacing=0 cellpadding=0>
<caption>
	STANDRAD HEAD OF <b><?echo $row['head'];?>(CODE-<?echo $row['code'];?>)</b> FOR PACS<br/>
	<?echo "<font size=+3>$SYSTEM_TITLE</font> <br><font size=+1><b>Report Date:".date('d.m.Y')."::".getPrintTime()."</b></font><hr>";?>
	<div align='center'><input type='button' onclick='print()' value='print'>
	<!--<b>CURRENT YEAR AMOUNT(Rs):</b><?echo amount2Rs($row['curr_bal']);?><br/>
	<b>PREVIOUS YEAR AMOUNT(Rs):</b><?echo amount2Rs($row['prev_bal']);?>style="height:410px;overflow-y:auto;width:100%"-->
</caption>
<tr>
	<th width='10%'>CODE</th>
	<th width='35%'>HEAD OF ACCOUNT</th>
	<th width='30%'>CURRENT YEAR AMOUNT(Rs)</th>
	<th width='25%'>PREVIOUS YEAR AMOUNT(Rs)</th>
</tr>
<tr  class='tr0'>
	<td width='10%'><?echo $row['code'];?></td>
	<td width='35%'><?echo $row['head'];?></td>
	<td width='30%'><?echo amount2Rs($row['curr_bal']);?></td>
	<td width='25%'><?echo amount2Rs($row['prev_bal']);?></td>
</tr>
<tr><td colspan='4'>
	<div>
	<table class='subTable'  cellspacing=0 cellpadding=0>		
		<?}if($row['od']==1){?>
			<tr  class='tr1'>
				<td width='10%'><?echo $row['code'];?></td>
				<td width='35%'><?echo ucwords($row['head']);?></td>
				<td width='30%'><?echo amount2Rs($row['curr_bal']);?></td>
				<td width='25%'><?echo amount2Rs($row['prev_bal']);?></td>
			</tr>
		<?}if($row['od']==2){?>
			<tr class='tr2'>
				<td><?echo $row['code'];?></td>
				<td><?echo ucwords($row['head']);?></td>
				<td><?echo amount2Rs($row['curr_bal']);?></td>
				<td><?echo amount2Rs($row['prev_bal']);?></td>
			</tr>
		<?}if($row['od']==3){?>
			<tr class='tr3'>
				<td><?echo $row['code'];?></td>
				<td><?echo ucwords($row['head']);?></td>
				<td><?echo amount2Rs($row['curr_bal']);?></td>
				<td><?echo amount2Rs($row['prev_bal']);?></td>
			</tr>
<?}}}?>
		</table>
		</div>
	</td></tr>
</table>
</body>
</html>
