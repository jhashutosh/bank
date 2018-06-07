<?
include "../config/config.php";
$staff_id==verifyAutho();
$mdate=$_REQUEST['mdate'];
if(empty($mdate)){$mdate=date('d.m.Y');}
echo "<html>";
echo "<head>";
echo "<title>PF Statement</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body onload=\"cd.focus();\">";
echo "<form METHOD=\"POST\" ACTION=\"monthly_return_loan.php\">";
echo "<center>";
echo "<table width=\"100%\">";
echo "<tr><td bgcolor=\"#0000CD\" colspan=\"19\" align=\"center\"><b><font color=\"WHITE\">PF Statement</font>";
echo "<tr bgcolor=#BA55D3>";
echo "<th bgcolor=\"#9ACD32\" rowspan='2'>Employee Id</th>";
echo "<th bgcolor=\"#9ACD32\" rowspan='2'>Name </th>";
echo "<th bgcolor=\"#9ACD32\" rowspan='2'>PF Opening Balance </th>";
echo "<th bgcolor=\"#9ACD32\" rowspan='2'>PF Cont. </th>";

echo "<th bgcolor=\"#9ACD32\" colspan='2'>BANK</th>";
echo "<th bgcolor=\"#9ACD32\" rowspan='2'>Current Balance</th>";
echo"<tr bgcolor=\"#9ACD32\"><th>Deposit</th><th>Mature</th></tr>";
$TBGCOLOR="WHITE";
$TCOLOR="FFFFCC";
$sql_statement="select m.emp_id,m.name,p.op_bal,p.total_empl_cont_pf_amt+p.total_empl_cont_pf_amt as dep from emp_master m,emp_pf_dtl p where m.emp_id=p.emp_id order by emp_id";
//echo $sql_statement;
$result=dBConnect($sql_statement);
for($j=0; $j<pg_NumRows($result); $j++){
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
echo "<tr>";
echo "<td  bgcolor=$color ><b>".$row['emp_id']."</td>";

echo "<td bgcolor=$color  align=center >".ucwords($row['name'])."</td>";

echo "<td  bgcolor=$color >".$row['op_bal']."</td>";

echo "<td  bgcolor=$color >".$row['dep']."</td>";

$sql="select w.emp_id,w.pf_dep as dep,coalesce(x.lic_gain,0)+coalesce(y.po_gain,0)+coalesce(z.bn_gain,0)+w.pf_dep as bal  from (select emp_id,op_bal+total_empl_cont_pf_amt+total_emplee_cont_pf_amt as pf_dep from emp_pf_dtl where emp_id=".$row['emp_id'].") as w left outer join 
(select a.emp_id,sum(case when a.withdrawl <= 0 then 0 else a.withdrawl-b.pol end)as lic_gain  from ( 
(select emp_id,pol_no,sum(coalesce(withdrawl_amount,0)) as withdrawl from emp_pforgratuity_lic_hdr group by pol_no,emp_id) as a join 
(select emp_id,pol_no,sum(coalesce(tot_amt,0)) as pol from emp_pforgratuity_lic_dtl group by pol_no,emp_id) as b on a.emp_id=b.emp_id and a.pol_no=b.pol_no join (select sum(int_amt) as po_gain,emp_id from emp_pforgratuity_po_hdr group by emp_id) as c on a.emp_id=c.emp_id)
group by a.emp_id) as x on w.emp_id=x.emp_id left outer join 
(select emp_id,sum(coalesce(int_amt,0)) as po_gain from emp_pforgratuity_po_hdr group by emp_id) as y on w.emp_id=y.emp_id left outer join 
(select emp_id,sum(coalesce(withdrawl_amount,0)-coalesce(deposit_amount,0)) as bn_gain from emp_pforgratuity_sb_hdr where withdrawl_amount >0 group by emp_id) as z on w.emp_id=z.emp_id";
$res=dBConnect($sql);
$bal=pg_result($res,'bal');
//echo $sql."<hr>";


$sql="select emp_id,coalesce(sum(deposit_amount),0) as bank_dep_amt,coalesce(sum(withdrawl_amount),0) as bank_maturity_amt                                          
from emp_pforgratuity_sb_hdr 
group by emp_id having emp_id=".$row['emp_id'];
$res=dBConnect($sql);
$b_d=pg_result($res,'bank_dep_amt');;
$b_m=pg_result($res,'bank_maturity_amt');

echo "<td bgcolor=$color  align=right >$b_d</td>";

echo "<td bgcolor=$color  align=right >$b_m</td>";

echo "<td bgcolor=$color  align=right >$bal</td>";
}
echo "</table>";
echo "</body>";
echo "</html>";
?>
					
