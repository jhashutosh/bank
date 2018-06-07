<?
include "../config/config.php";
$id=$_REQUEST['id'];
$name=$_REQUEST['name'];
$doj=$_REQUEST['doj'];
$bp=$_REQUEST['bp'];
$d="1/";
$a="0";
$ef=$d.$_REQUEST['ef'];
$si=$_REQUEST['si'];
$ts=$_REQUEST['ts'];
$sql_statement="select emp_populate_sal_struct_fnc($id,'$ef',$bp,'$si','$ts')";
//echo $sql_statement;
$result1=dBConnect($sql_statement);
$r=pg_fetch_array($result1,0);
$sql="select * from emp_sal_dtl where emp_id=$id and effected_from = (select max(effected_from) from emp_sal_dtl where emp_id=$id)";
$result=dBConnect($sql);
$row=pg_fetch_array($result,0);
$hra=(empty($row['hra']))?$a:$row['hra'];
$op=$_REQUEST['op'];
$ym=date('Ym');
$pb_sql="select puja_bonus from emp_sal_reg where emp_id=$id and year_month='$ym'";
$pb_res=dBConnect($pb_sql);
$pb=pg_fetch_array($pb_res,0);
//
$s="select * from emp_other_earnings where emp_id=$id and year_month='$ym'";
$r=dBConnect($s);
$othear=pg_fetch_array($r,0);
$banka=(empty($othear['bank_allow']))?0:$othear['bank_allow'];
$incn=(empty($othear['incentive']))?0:$othear['incentive'];
//
//over time

$s="select * from emp_overtime_dtl where emp_id=$id and year_month='$ym'";
$r=dBConnect($s);
$ovr=pg_fetch_array($r,0);
$over_pay=(empty($ovr['ot_payment']))?0:$ovr['ot_payment'];
//
if($op=='i'){
$time=date('d/m/Y H:i:s ');
$staff_id=verifyAutho();
$inc=$_REQUEST['inc'];
$ba=$_REQUEST['ba'];
$ot_pay=$_REQUEST['ot_pay'];
$ym=date('Ym');
$sql="insert into emp_other_earnings values($id,'$ym',$inc,$ba,'$staff_id','$time',$ot_pay)";
$res=dBConnect($sql);
//echo $sql;
if(pg_affected_rows($res)<1)
echo"<font color='red' size='2'>failed to update";
else
echo"<font color='white' size='2'>your Salary information updated";
}
echo "<html>";
echo "<head>";
if(empty($row['basic']))
echo"<h5 align='center'><font color=white size='3'><blink>Basic Pay Information Unavailable";
else{
if($ef==$d)
echo"";
else {
if($r['emp_populate_sal_struct_fnc']==1)
echo "<h4><font color=white>Basic Changed<h4></font>";
else echo "<h4><font color=white>Already processed Basic Pay for this month!!<h4></font>";
     }
echo"</font></blink></h5>";}
echo "<script src=\"../JS/loading2.js\"></script>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
?>
<script LANGUAGE="JavaScript">
function get_ot_pay(){
var days=document.getElementById('ot_day').value;
alert(days)
var pay=document.getElementById('ot_pr_dy').value;
var tot=days*pay;
document.getElementById('ot_pay').value=tot;
}
</script>
<?
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<title>Employee Salary Details";
echo "</title>";
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";
echo "<script type=\"text/javascript\" src=\"../JS/bsn.AutoSuggest_c_2.0.js\"></script>";
//echo $id;
echo"</head>";
echo "<body bgcolor=\"9999FF\" onload=\"f1();\">";
echo "<form name=\"f1\" method=\"post\" action=\"emp_sal_dtl.php?op=i&id=$id\">";
echo "<table align=center width='100%'bgcolor='black' >";
echo"<tr><th colspan='10' bgcolor='333366'><font color='white'>EMPLOYEE SALARY DETAILS</font></th></tr>";
echo"<tr><th bgcolor='lightyellow' align='center' colspan='2'><font color='darkblue'>Employee Id: </font>$id</th><th colspan='4' bgcolor='lightyellow' align='center'><font color='darkblue'>Name : </font>$name</th><th bgcolor='lightyellow' align='center' colspan='2'><font color='darkblue'>Date of Joining :</font></th><th bgcolor='lightyellow' align='center' colspan='2'> $doj</font></th></tr>";
echo"<tr><td bgcolor='lightyellow' align='center' colspan='5'><font color='red'><b>Basic pay:</b></font>".$row['basic']."</td><td colspan='5' bgcolor='lightyellow' align='center'><font color='red'><b>Effect from : </b></font>".$row['effected_from']."</td></tr>";
echo"<tr><th bgcolor='lightgreen' colspan='10'> Earnings</th></tr>";
echo"<td bgcolor='white' align='center' width='10%'><font color='green'>DA:</td><td bgcolor='white'><input type='text' width='10%' name='da' size='8' value='".$row['da']."' READONLY $HIGHLIGHT></td>
<td bgcolor='white' align='center'><font color='green' width='10%'>MA:</td><td width='10%' bgcolor='white'><input type='text' name='ma' size='8' value='".$row['ma']."' READONLY $HIGHLIGHT></td>
<td width='5%' bgcolor='white' align='center'><font color='green'>Banking Allowance:</td><td width='10%' bgcolor='white'><input type='text' name='ba' value='$banka' size='8'  $HIGHLIGHT></td>
<td bgcolor='white' align='center' width='10%'><font color='green'>Incentive:</td><td width='10%' bgcolor='white'><input type='text' name='inc' size='7' value='$incn'  $HIGHLIGHT></td>";
echo"<td bgcolor='white' align='center' width='15%'><font color='green'>Puja Bonus :</td><td width='10%' bgcolor='white'><input width='10%' type='text' name='pa' size='8' value='".$pb['puja_bonus']."' READONLY $HIGHLIGHT></td></tr>";

//echo"<td bgcolor='white' align='center' width='15%' colspan='5' align='right'><font color='green'>Overtime Payment :</td><td width='10%' bgcolor='white' colspan='5'>(days)<input width='10%' type='text' name='ot_day' id='ot_day' size='2' value='' $HIGHLIGHT>&nbsp;&nbsp;&nbsp;X&nbsp;&nbsp;&nbsp;<input width='10%' type='text' name='ot_pr_dy' id='ot_pr_dy' size='5' value='' $HIGHLIGHT>(Rs./day)&nbsp;&nbsp;=&nbsp;&nbsp;<input width='10%' type='text' name='ot_pay' id='ot_pay' size='5' value='' onclick='get_ot_pay()' $HIGHLIGHT></td></tr>";

echo"<td bgcolor='white' width='15%' colspan='5' align='right'><font color='green'>Overtime Payment &nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input width='10%' type='text' name='ot_pay' id='ot_pay' size='8' value='$over_pay' onclick='get_ot_pay()' $HIGHLIGHT>&nbsp;&nbsp;&nbsp;&nbsp;</td><td width='10%' bgcolor='white' colspan='5'></td></tr>";

echo"<tr><th bgcolor='red' colspan='10'> Deductions</th></tr>";
echo"<tr><td bgcolor='white' align='center' colspan='3'><font color='darkred'>PF:(Employer)</td><td bgcolor='white' colspan='2'><input type='text' name='pf1' size='8' value='".$row['empl_cont_pf']."' READONLY $HIGHLIGHT></td>
<td bgcolor='white' align='center' colspan='3'><font color='darkred'>PF:(Employee)</td><td bgcolor='white' colspan='2'><input type='text' name='pf2' size='8' value='".$row['emplee_cont_pf']."' READONLY $HIGHLIGHT></td></tr>";
echo"<tr><td bgcolor='white' colspan='10' align='center'><input type='submit' value='Give Incentive / Banking Allowance'></td></tr>";
echo"</body>";
echo "</form>";
echo"</html>";
?>

