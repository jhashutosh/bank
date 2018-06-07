<!doctype html>
<?php
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
<!--echo "<font size=+3>$SYSTEM_TITLE</font> <br><font size=+1><b>Report Date:".date('d.m.Y')."::".getPrintTime()."</b></font><hr>";-->

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
#codingTable th{
	font-size:1em;
}
.subTable{
	width:100%;
}
.subTable td{
	word-warp:break-line;
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
<?php
$gl=$_REQUEST['gl'];
$glName=$gl_arr[$gl];
//$glName='LIABILITIES';
$upper=$gl+10000;
$lower=$gl;
if($gl== 30000 || $gl== 60000)
$dr_cr='dr_amt-cr_amt';
if($gl== 40000 || $gl== 50000)
$dr_cr='cr_amt-dr_amt';
if($gl==20000)
$dr_cr='coalesce(gl_mas_bl_prv,0)+dr_amt-cr_amt';
if($gl==10000)
$dr_cr='coalesce(gl_mas_bl_prv,0)+cr_amt-dr_amt';

$sql_statement="SELECT * FROM (
(select '$gl' as code,'$glName' as head,sum(a.bal) as curr_bal ,sum(a.prv) as prev_bal,'top' as lvl,0 as od from (select gl_mas_code,sum(gl_mas_bl_prv) prv,sum(dr_amt),sum(cr_amt),sum($dr_cr) as bal from sch_bs_sh_gm group by gl_mas_code having cast(gl_mas_code as integer)<$upper and cast(gl_mas_code as integer)>$lower  order by gl_mas_code) as a)
union 
(select a.gl_header_code,initcap(a.gl_header_desc),b.cur_bl,b.prv_bl,'gl_header'as lvl,1 as od 
from (select gm.gl_header_code as code, gm.gl_header_desc, sum(curr_bal) cur_bl, sum(prev_bal) prv_bl from
	(select substr(sc.gl_sub_header_code,1,2)||'000' as cd,sum(".$dr_cr.") as curr_bal, sum(gl_mas_bl_prv) as prev_bal
	from sch_bs_sh_gm sc
	group by sc.gl_sub_header_code
	having cast(sc.gl_sub_header_code as integer)<$upper and cast(sc.gl_sub_header_code as integer)>$lower
	and cast(sc.gl_sub_header_code as integer)>$lower) gp,gl_header gm
group by gp.cd,gm.gl_header_code,gm.gl_header_desc
having gp.cd=gm.gl_header_code) b right outer join gl_header a 
on b.code=a.gl_header_code 
where cast(a.gl_header_code as integer)<$upper
and cast(a.gl_header_code as integer)>$lower)
union 
(select a.gl_sub_header_code,initcap(a.gl_sub_header_desc),b.curr_bal,b.prev_bal,'gl_sub_header'as lvl,2 as od 
from (select sc.gl_sub_header_code as code, gm.gl_sub_header_desc, sum($dr_cr) as curr_bal, sum(gl_mas_bl_prv) as prev_bal
from sch_bs_sh_gm sc,gl_sub_header gm 
where sc.gl_sub_header_code=gm.gl_sub_header_code 
group by sc.gl_sub_header_code,gm.gl_sub_header_desc  
having cast(sc.gl_sub_header_code as integer)<$upper and cast(sc.gl_sub_header_code as integer)>$lower
and cast(sc.gl_sub_header_code as integer)>$lower) b right outer join gl_sub_header a 
on b.code=a.gl_sub_header_code 
where cast(a.gl_sub_header_code as integer)<$upper
and cast(a.gl_sub_header_code as integer)>$lower
)
union 
(
select a.gl_mas_code,initcap(a.gl_mas_desc),b.curr_bal,b.prev_bal,'gl_mas_code'as lvl,3 as od from( 
select sc.gl_mas_code as code,gm.gl_mas_desc as head,sum($dr_cr) as curr_bal,sum(sc.gl_mas_bl_prv) as prev_bal,'gl_mas_code'as lvl,3 as od 
from sch_bs_sh_gm sc,gl_master gm
where sc.gl_mas_code=gm.gl_mas_code
group by sc.gl_mas_code,gm.gl_mas_desc 
having cast(sc.gl_mas_code as integer)<$upper and cast(sc.gl_mas_code as integer)>$lower 
and cast(sc.gl_mas_code as integer)>$lower) b right outer join gl_master a 
on b.code=a.gl_mas_code 
where cast(a.gl_mas_code as integer)<$upper
and cast(a.gl_mas_code as integer)>$lower
)
) as b order by code,od;";
//echo "$sql_statement";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){
for($j=0; $j<pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
?>
<?php if($row['od']==0){?>
<table id='codingTable'>
<caption>
	STANDRAD HEAD OF <b><?php echo $row['head'];?>(CODE-<?php echo $row['code'];?>)</b> FOR PACS<br/>
	<!--<b>CURRENT YEAR AMOUNT(Rs):</b><?phpecho amount2Rs($row['curr_bal']);?><br/>
	<b>PREVIOUS YEAR AMOUNT(Rs):</b><?phpecho amount2Rs($row['prev_bal']);?>-->
	<?php echo "<font size=+3>$SYSTEM_TITLE</font> <br><font size=+1><b>Report Date:".date('d.m.Y')."::".getPrintTime()."</b></font><hr>";?>
</caption>
<tr>
	<th width='10%'>CODE</th>
	<th width='40%'>HEAD OF ACCOUNT</th>
	<th width='25%'>CURRENT YEAR AMOUNT(Rs)</th>
	<th width='25%'>PREVIOUS YEAR AMOUNT(Rs)</th>
</tr>
<tr  class='tr0'>
	<td width='10%'><?php echo $row['code'];?></td>
	<td width='40%'><?php echo $row['head'];?></td>
	<td width='25%'><?php echo amount2Rs($row['curr_bal']);?></td>
	<td width='25%'><?php echo amount2Rs($row['prev_bal']);?></td>
</tr>
<tr><td colspan='4'>
	<div style="height:410px;overflow-y:auto;width:100%">
	<table class='subTable'>		
		<?php }if($row['od']==1){?>
			<tr  class='tr1'>
				<td width='10%'><?php echo $row['code'];?></td>
				<td width='40%'><?php echo ucwords($row['head']);?></td>
				<td width='25%'><?php echo amount2Rs($row['curr_bal']);?></td>
				<td width='25%'><?php echo amount2Rs($row['prev_bal']);?></td>
			</tr>
		<?php }if($row['od']==2){?>
			<tr class='tr2'>
				<td><?php echo $row['code'];?></td>
				<td><?php echo ucwords($row['head']);?></td>
				<td><?php echo amount2Rs($row['curr_bal']);?></td>
				<td><?php echo amount2Rs($row['prev_bal']);?></td>
			</tr>
		<?php }if($row['od']==3){?>
			<tr class='tr3'>
				<td><?php echo $row['code'];?></td>
				<td><?php echo ucwords($row['head']);?></td>
				<td><?php echo amount2Rs($row['curr_bal']);?></td>
				<td><?php echo amount2Rs($row['prev_bal']);?></td>
			</tr>
<?php }}}?>
		</table>
		</div>
	</td></tr>
</table>
</body>
</html>
