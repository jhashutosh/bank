<?
include "../config/config.php";
$staff_id==verifyAutho();
$mname=ucwords($_REQUEST['mname']);
$yr=$_REQUEST['yr'];
$month=$_REQUEST['month'];
$total=0;
$ym=$yr.$month;
if(empty($mdate)){$mdate=date('d.m.Y');}
echo "<html>";
echo "<head>";
echo "<title>$PROJECT_TITLE</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"cd.focus();\">";
echo"<h3 align='center'><font color='darkred'>SALARY PAYMENT FOR THE MONTH OF &nbsp; $mname &nbsp; $yr</h3>";
echo "<table align=center bgcolor='black' width='75%'>";
echo "<tr bgcolor=#073123>";
echo "<th bgcolor=\"#9ACD32\">EMP ID.</th>";
echo "<th bgcolor=\"#9ACD32\" width=30%>NAME</th>";
echo "<th bgcolor=\"#9ACD32\" width=30%>DESIGNATION</th>";
echo "<th bgcolor=\"#9ACD32\" width=15%>SALARY</th>";
$sql_statement="select em.emp_id, em.name, edm.desg_desc,sum(esr.net_sal)
  from emp_master em, emp_designation_mas edm, emp_sal_reg esr
  where em.emp_id=esr.emp_id
  and em.id_emp_designation_mas=edm.id
  and substr(esr.year_month,1,4)='$yr'
  and substr(esr.year_month,5,2)='$month'
  group by em.emp_id, em.name, edm.desg_desc
  order by em.emp_id";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
for($j=0;$j<pg_NumRows($result); $j++){
$row=pg_fetch_array($result,$j);
$total=$total+$row['sum'];
echo"<tr>";
echo"<td align='center' bgcolor='white'>".$row['emp_id']."</td><td bgcolor='white'>".ucwords($row['name'])."</td><td bgcolor='white'>".$row['desg_desc']."</td><td bgcolor='white'><a href=\"payslip.php?ym=$ym&yy=$yr&id=".$row['emp_id']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=200, width=900,height=750'); return false;\">".$row['sum']."</a></td></tr>";
   }
}
echo "<tr><td bgcolor=\"66CCFF\" colspan='3' align='center'>Total</td>";
echo "<td bgcolor=\"66CCFF\" align='left' >$total</td></tr>";
echo "</table>";
echo "</body>";
echo "</html>";
?>
