<?
include "../config/config.php";
//$staff_id==verifyAutho();
$id=$_REQUEST['id'];
$yy=$_REQUEST['yy'];
$mm=$_REQUEST['mm'];
$ym=$yy.$mm;
$name=$_REQUEST['name'];
$pf_ln_ac_no=$_REQUEST['pf_ln_ac_no'];
$poperator_code=verifyAutho();
$pentry_time=date('d/m/Y H:i:s ');
$sqlcheck="select count(*) from emp_pf_loan_dtl where emp_id=$id and year_month='$ym'";
$rescheck=dBConnect($sqlcheck);
$chkrow=pg_fetch_array($rescheck,0);
if($chkrow['count']==0){
$sqlpf="select count(*) from emp_pf_loan_dtl where emp_id=$id and pf_loan_ac_no='$pf_ln_ac_no'";
$rpf=dBConnect($sqlpf);
$pf=pg_fetch_array($rpf,0);
echo $pf['count'];
if($pf['count']==0)
{
$sql_statement="select emp_pf_loan_dtl_save_fnc($id,'$ym','$pf_ln_ac_no',0,0,0,0,0,0,0,'$poperator_code','$pentry_time')";
$result=dBConnect($sql_statement);
echo $sql_statement;
}
echo "<html>";
echo "<head>";
echo "<title>PF Loan detail</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script src=\"../JS/loading2.js\"></script>";
?>
<script LANGUAGE="JavaScript">
function cal_loan(){

var balp=document.getElementById('bp').value;
var retp=document.getElementById('rp').value;
balance=balp-retp;
document.getElementById('bal_pri').value=balance;
}

</script>
<?
echo "</head>";
echo "<body bgcolor=\"\">";
echo "<form name=\"f1\" METHOD=\"POST\" ACTION=\"pf_loan_dtl_add.php?ym=$ym\">";
echo "<center><br><br><br>";
echo"<input type='hidden' name='blnc' id='blnc' value=''>";
echo "<table width=\"50%\" bgcolor='black'>";
echo "<tr><td bgcolor=\"#0000CD\" colspan=\"19\" align=\"center\"><b><font color=\"WHITE\">PF Loan Detail</font>";
echo "<tr";
echo "<td bgcolor=\"#9ACD32\">Employee Id :&nbsp;&nbsp;&nbsp;<input type='text' name='id' value=$id size='3' $HIGHLIGHT>";
echo"</td><td bgcolor=\"#9ACD32\" width='50%'> Name :";
echo"<input type='text' name='name' value='$name' size='12' $HIGHLIGHT></td></tr>";
echo "<tr><td bgcolor=\"#9ACD32\">Year&nbsp;:&nbsp;&nbsp;
<input type='text' name='year' value=$yy size='3' $HIGHLIGHT></td>";
echo"<td bgcolor=\"#9ACD32\">Month&nbsp;:&nbsp;&nbsp;
<input type='text' name='mnth' value=$mm size='4' $HIGHLIGHT></td> ";
echo "<tr><td bgcolor=\"#9ACD32\" >PF Loan Account No</td><td bgcolor=\"#9ACD32\"><input type=\"text\" name=\"pla\"size=\"10\" value=\"$pf_ln_ac_no\" READONLY $HIGHLIGHT></td></tr>";
$sql="select * from emp_pf_loan_dtl where emp_id=$id and year_month=(select max(year_month) from emp_pf_loan_dtl where emp_id=$id)";
$res=dBConnect($sql);
//echo $sql;
$row=pg_fetch_array($res,0);
$bal_int=$row['b_due_int']-$row['r_due_int'];
echo "<tr><td bgcolor=\"#9ACD32\">Return Due Interest</td><td bgcolor=\"#9ACD32\"><input type=\"text\" name=\"rdi\" id='rdi' size=\"6\" value='".$row['r_due_int']."' $HIGHLIGHT READONLY></td></tr>";
echo "<tr><td bgcolor=\"#9ACD32\">Return Principal</td><td bgcolor=\"#9ACD32\"><input type=\"text\" name=\"rp\" id='rp' size=\"6\" onfocus=\"cal_loan()\"onChange=\"cal_loan()\" onKeyup=\"cal_loan()\"  $HIGHLIGHT></td>";
echo "<tr><td bgcolor=\"#9ACD32\">Balance Due Interest</td><td bgcolor=\"#9ACD32\"><input type=\"text\" name=\"bdi\" id='bdi' size=\"6\"  value='$bal_int' READONLY $HIGHLIGHT></td>";
echo "<tr><td  bgcolor=\"#9ACD32\">Balance Principal</td><td bgcolor=\"#9ACD32\"><input type=\"text\" name=\"bal_pri\" id='bal_pri' size=\"6\" value=".round($row['b_principal'])." $HIGHLIGHT READONLY><input type=\"hidden\" name=\"bp\" id='bp' value='".$row['b_principal']."'></td></tr>";
echo "<tr><td  bgcolor=\"#9ACD32\" align=\"center\" colspan=\"2\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Submit\">";
echo "</table>";
echo"</form>";
echo "</body>";
echo "</html>";}
else{
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo"<body bgcolor='lightgreen'>";
echo "<div align='center'><h4>You have Already paid for this month!!</h4> <br>
<a href='pf_loan_dt.php'><font size='3'> <<--Back </font></div></body>";
}
?>
