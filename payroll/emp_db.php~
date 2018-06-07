<?
include "../config/config.php";
$status=$_REQUEST['status'];
$menu=$_REQUEST['menu'];
$a="Enter";
//echo $sql_statement;
echo "<head>";
echo "<title>EMPLOYEE";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"white\">";
$TBGCOLOR="WHITE";
$TCOLOR="#ABABAB";
$sql_statement="select * from emp_master order by emp_id";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) 
{
echo "<h4>RECORD Not found!!!</h4>";

} else {
//echo pg_NumRows($result);
echo "<table width=\"100%\" bgcolor='white'>";
$color==$TCOLOR;
for($j=0; $j<pg_NumRows($result); $j++) {
echo "<tr>";
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
///////////////////////////////////////// insert code here
$a="Enter";
$id=$row['emp_id'];
//$name=$row['name'];
$doj=$row['doj'];
$did=$row['id_emp_designation_mas'];
$sql_statement1="select * from emp_designation_mas where id=$did";
$result1=dBConnect($sql_statement1);
$row1=pg_fetch_array($result1,0);
//

$sql_statement2="select * from emp_sal_dtl where emp_id=$id and effected_from = (select max(effected_from) from emp_sal_dtl where emp_id=$id)";
$result2=dBConnect($sql_statement2);
$row2=pg_fetch_array($result2,0);
$s=(pg_NumRows($result2)==0)?$a:$row2['basic'];
//echo $row2['basic']; 
/*$sql_statement3="select w.pf_ac_no,w.emp_id,w.pf_dep as dep,coalesce(x.lic_gain,0)+coalesce(y.po_gain,0)+coalesce(z.bn_gain,0)+w.pf_dep as bal  from (select emp_id,pf_ac_no,op_bal+total_empl_cont_pf_amt+total_emplee_cont_pf_amt as pf_dep from emp_pf_dtl where emp_id=$id) as w left outer join 
(select a.emp_id,sum(case when a.withdrawl <= 0 then 0 else a.withdrawl-b.pol end)as lic_gain  from ( 
(select emp_id,pol_no,sum(coalesce(withdrawl_amount,0)) as withdrawl from emp_pforgratuity_lic_hdr group by pol_no,emp_id) as a join 
(select emp_id,pol_no,sum(coalesce(tot_amt,0)) as pol from emp_pforgratuity_lic_dtl group by pol_no,emp_id) as b on a.emp_id=b.emp_id and a.pol_no=b.pol_no join (select sum(int_amt) as po_gain,emp_id from emp_pforgratuity_po_hdr group by emp_id) as c on a.emp_id=c.emp_id)
group by a.emp_id) as x on w.emp_id=x.emp_id left outer join 
(select emp_id,sum(coalesce(int_amt,0)) as po_gain from emp_pforgratuity_po_hdr group by emp_id) as y on w.emp_id=y.emp_id left outer join 
(select emp_id,sum(coalesce(int_amt,0)) as bn_gain from emp_pforgratuity_sb_hdr group by emp_id) as z on w.emp_id=z.emp_id";*/
$sql_statement3="select w.pf_ac_no,w.emp_id,w.op_bal,w.pf_dep as dep,coalesce(z.bn_gain,0)+coalesce(y.lic_gain,0)+coalesce(x.po_gain,0)+w.pf_dep as bal  from 
(select emp_id,pf_ac_no,op_bal,op_bal+total_empl_cont_pf_amt+total_emplee_cont_pf_amt as pf_dep from emp_pf_dtl where emp_id=$id) 
as w 
left outer join 
(select emp_id,sum(coalesce(int_amt,0)+coalesce(withdrawl_amount,0)-coalesce(deposit_amount,0))as bn_gain from emp_pforgratuity_sb_hdr where withdrawl_amount is not null group by emp_id) 
as z 
on w.emp_id=z.emp_id

left outer join 
(select emp_id,sum(coalesce(withdrawl_amount,0)-coalesce(deposit_amt,0))as lic_gain from lic_invst where withdrawl_amount is not null group by emp_id) 
as y 
on w.emp_id=y.emp_id

left outer join 
(select emp_id,sum(coalesce(withdrawl_amount,0)-coalesce(tot_amount,0))as po_gain from emp_pforgratuity_po_hdr where withdrawl_amount is not null group by emp_id) 
as x 
on x.emp_id=y.emp_id";
$result3=dBConnect($sql_statement3);
$row3=pg_fetch_array($result3,0);
$p=(empty($row3['pf_ac_no']))?$a:$row3['pf_ac_no'];
$pf_amnt=$row3['bal'];

$gra="select sum(amount) from emp_gratuity_dtl where emp_id=".$row['emp_id']."";
$gr_r=dBConnect($gra);
$gr=pg_fetch_array($gr_r,0);
$g=(empty($gr['sum']))?'Enter':$gr['sum'];

//echo "<tr>";
//echo "<td align=CENTER bgcolor=$color width=\"12%\">".$row['name']."</td>";
echo "<td align=CENTER bgcolor=$color width=\"8%\">".$row['customer_id']."</td>";
echo "<td align=CENTER bgcolor=$color width=\"9%\">".$row['emp_id']."</td>";
echo "<td align=center bgcolor=$color width=\"13%\">".ucwords($row['name'])."</a> </td>";
//echo "<td align=CENTER bgcolor=$color width=\"12%\">".$row['father_name']."</td>";
echo "<td align=CENTER bgcolor=$color width=\"12%\">".$row1['desg_desc']."</td>";
//echo "<td align=center bgcolor=$color width=\"8%\">".$row['pf_ac_no']."</td>";

echo "<td align=center bgcolor=$color width=\"9%\"><a href=\"gratuity_dtl.php?id=$id&name=".$row['name']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=150,left=350, width=450,height=300'); return false;\">$g</td>";

echo "<td align=center bgcolor=$color width=\"8%\"><a href=\"pf_dtl.php?menu=ast&id=$id&name=".$row['name']."&acno=".$row3['pf_ac_no']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=150,left=350, width=450,height=300'); return false;\">$p</td>";
echo "<td align=center bgcolor=$color width=\"8%\"><a href=\"pf_invst_dtl.php?c_id=".$row['customer_id']."&id=$id&name=".$row['name']."&acno=".$row3['pf_ac_no']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=150,left=350, width=1200,height=600'); return false;\">$pf_amnt</a></td>";

//echo "<td align=center bgcolor=$color width=\"16%\">".$row['sal']."</td>";
echo "<td align=center bgcolor=$color width=\"12%\"><a href=\"basic_pay.php?menu=ast&id=$id&name=".$row['name']."&doj=$doj\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=150,left=350, width=750,height=500'); return false;\">$s</td>";
//echo "<td align=CENTER bgcolor=$color width=\"12%\">".$row['bank_ac_no']."</td>";


echo "<td align=center bgcolor=$color width=\"9%\"><a href=\"ps_ef.php?menu=ast&id=$id&name=".$row['name']."\" onClick=\"window.open(this.href,'window','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=200,left=350, width=500,height=250'); return false;\"><blink>Pay Slip</blink></a> </td>";



echo "<td align=center bgcolor=$color width=\"8%\"><a href=\"../payroll/edit_emp.php?menu=ast&id=$id\" target=_parent> Edit </td>";
//echo "<td align=center bgcolor=$color width=\"9%\"><a href=\"edit_emp.php?menu=ast&id=$id\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=200,left=350, width=500,height=350'); return false;\">".$row['name']."</a> </td>";
}
echo "</table>";}
?>
