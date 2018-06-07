<?
include "../config/config.php";
$staff_id==verifyAutho();
$ym=$_REQUEST['ym'];
$id=$_REQUEST['id'];
$pla=$_REQUEST['pla'];
$rdi=$_REQUEST['rdi'];
$rp=$_REQUEST['rp'];
$bdi=$_REQUEST['bdi'];
$bal_pri=$_REQUEST['bal_pri'];
$poperator_code=verifyAutho();
$pentry_time=date('d/m/Y H:i:s ');
$sql_statement="select * from emp_pf_loan_dtl where emp_id=$id and pf_loan_ac_no='$pla'";
$result=dBConnect($sql_statement);
//echo $sql_statement;
$row=pg_fetch_array($result,0);
//echo $row['r_principal'];
if($row['r_principal']==0)
{$sql="update emp_pf_loan_dtl set r_principal=$rp , b_principal=$bal_pri , b_due_int=$bdi where emp_id=$id";}
else
{$sql="insert into emp_pf_loan_dtl values($id,'$ym','$pla',$rdi,0,$rp,$bdi,0,$bal_pri,0,'$poperator_code','$pentry_time')";}
$res=dBConnect($sql);
echo"<body bgcolor='silver'><div align='center'>";
echo"PF Loan information updated</body><a href='main.php'><font size='3'> <<--Back </font></div>";
echo $sql;
?>
