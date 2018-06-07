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
$banka=(empty($othear['bank_allow']))?null:$othear['bank_allow'];
$incn=(empty($othear['incentive']))?null:$othear['incentive'];
//
//over time

$s="select * from emp_overtime_dtl where emp_id=$id and year_month='$ym'";
$r=dBConnect($s);
$ovr=pg_fetch_array($r,0);
$over_pay=(empty($ovr['ot_payment']))?null:$ovr['ot_payment'];
//
if($op=='i'){
$time=date('d/m/Y H:i:s ');
$staff_id=verifyAutho();
$inc=$_REQUEST['inc'];
$ba=$_REQUEST['ba'];
$ot_pay=$_REQUEST['ot_pay'];
$bnk=$_REQUEST['bnk'];
$in=$_REQUEST['in'];
$ym=date('Ym');
//echo $bnk.$in;
if($bnk==null && $in==null ){

$sql="insert into emp_other_earnings values($id,'$ym',$inc,$ba,'$staff_id','$time')";}
else{
$sql="update emp_other_earnings set bank_allow=$ba ,incentive=$inc where emp_id=$id and year_month='$ym'";

}
$res=dBConnect($sql);
//echo $sql;
echo"<div align=center>";
if(pg_affected_rows($res)<1)
echo"<font color='red' size='2'>failed to update";
else
echo"Salary information updated <img height=25px width='30px' src='success.png'>";
}
echo"</div>";
echo "<html>";
echo "<head>";
if(empty($row['basic']))
echo"<h5 align='center'><font color=white size='+1'>Basic Pay Information Unavailable";
else{
if($ef==$d)
echo"";
else {
if($r['emp_populate_sal_struct_fnc']==1)
echo "<h4><font color=white>Basic Changed<h4></font>";
else echo "<h4><font color=white>Already processed Basic Pay for this month!!<h4></font>";
     }
echo"</font></h5>";}
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
echo "<body bgcolor=\"#D9F3FF\" onload=\"f1();\">";
echo "<form name=\"f1\" method=\"post\" action=\"emp_sal_dtl.php?op=i&id=$id&bnk=$banka&in=$incn\">";
echo "<table align=center width='100%' bgcolor='#5F7AC1' cellspacing=0 cellpadding=0 >";
echo"<tr style=height:25px><td colspan='4' align='center' bgcolor='#5F7AC1'><font color='white'>SALARY DETAILS</font></td></tr>";
//echo"<tr><th bgcolor='#CDCDCD' align='center' colspan='2'><font color='darkblue'>Employee Id: </font>$id</th><th colspan='4' bgcolor='#CDCDCD' align='center'><font color='darkblue'>Name : </font>$name</th><th bgcolor='#CDCDCD' align='center' colspan='2'><font color='darkblue'>Date of Joining :</font></th><th bgcolor='#CDCDCD' align='center' colspan='2'> $doj</font></th></tr>";
//echo"<tr><td bgcolor='#CDCDCD' align='center' colspan='5'><font color='red'><b>Basic pay:</b></font>".$row['basic']."</td><td colspan='5' bgcolor='#CDCDCD' align='center'><font color='red'><b>Effect from : </b></font>".$row['effected_from']."</td></tr>";
echo"<tr style=height:25px><td  align=center  bgcolor='#1ED1C0' colspan='4'> Earnings</th></tr>";

echo"<tr>";
echo"<td style=height:25px bgcolor='#58FFD5' align='center'>DA:</td>
<td bgcolor='#58FFD5'><input type='hidden' name='da' size='8' value='".$row['da']."'>".$row['da']."</td>
<td bgcolor='#58FFD5' align='center'>MA:</td>
<td bgcolor='#58FFD5'><input type='hidden' name='ma' size='8' value='".$row['ma']."'>".$row['ma']."</td>";
echo"</tr>";
//echo"<td bgcolor='#58FFD5' align='center'>HRA:</td><td width='10%' bgcolor='#58FFD5'><input type='text' name='hra' size='8' value='".$row['hra']."'>".$row['hra']."</td><td bgcolor='#58FFD5'><td bgcolor='#58FFD5'>";
echo"<tr>";
echo"<td style=height:25px  bgcolor='#58FFD5' align='center'>Special Allowance:</td>
<td bgcolor='#58FFD5'><input type='text' name='ba' value='$banka' size='8'  $HIGHLIGHT></td>
<td bgcolor='#58FFD5' align='center'>Key Allowance:</td>
<td bgcolor='#58FFD5'><input type='text' name='inc' size='7' value='$incn'  $HIGHLIGHT></td>";
echo"</tr>";
echo"<tr>";
if($over_pay>0)
echo"<td bgcolor='#58FFD5' align='center'style=height:25px >Overtime Payment :</td>
<td bgcolor=white><input type='hidden' name='ot_pay' id='ot_pay' size='8' value='$over_pay' onclick='get_ot_pay()' $HIGHLIGHT>$over_pay</td>";
else echo"<td bgcolor='#58FFD5' colspan=2>";
if($pb['puja_bonus']>0)
echo"<td bgcolor='#58FFD5' align='center' >Puja Bonus :</td>
<td bgcolor='#58FFD5'><input type='hidden' name='pa' size='8' value='".$pb['puja_bonus']."'>".$pb['puja_bonus']."</td>";
else echo"<td bgcolor='#58FFD5' colspan=2>";
echo"</tr>";
//echo"<td bgcolor='#58FFD5' align='center' width='15%' colspan='5' align='right'>Overtime Payment :</td><td width='10%' bgcolor='#58FFD5' colspan='5'>(days)<input width='10%' type='text' name='ot_day' id='ot_day' size='2' value='' $HIGHLIGHT>&nbsp;&nbsp;&nbsp;X&nbsp;&nbsp;&nbsp;<input width='10%' type='text' name='ot_pr_dy' id='ot_pr_dy' size='5' value='' $HIGHLIGHT>(Rs./day)&nbsp;&nbsp;=&nbsp;&nbsp;<input width='10%' type='text' name='ot_pay' id='ot_pay' size='5' value='' onclick='get_ot_pay()' $HIGHLIGHT></td></tr>";
//echo"<tr><td bgcolor='#58FFD5' colspan='12' align=center  style=height:25px ></th></tr>";

echo"<tr><td bgcolor='#58FFD5' colspan='4' align=center  style=height:25px ><br></th></tr>";

echo"<tr><td bgcolor='#F02A4B' colspan='4' align=center  style=height:25px > Deductions</th></tr>";

//echo"<tr><td bgcolor='#58FFD5' colspan='4' align=center  style=height:25px ></th></tr>";

echo"<td bgcolor='#FFB7B9' align='center'><font color=''>PF (Employee):</td>
<td style=height:25px bgcolor='#FFB7B9'><input type='hidden' name='pf2' size='8' value='".$row['emplee_cont_pf']."'>".$row['emplee_cont_pf']."</td>
<td style=height:25px bgcolor='#FFB7B9' colspan='2'></td>
</tr>";
//echo"<tr><td  style=height:25px bgcolor='#58FFD5' align='center'><font color='darkred'>PF (Employer) :</td>";
//echo"<td bgcolor='#58FFD5'><input type='hidden' name='pf1' size='8' value='".$row['empl_cont_pf']."'>".$row['empl_cont_pf']."</td>";

echo"<tr><td bgcolor='#FFB7B9' colspan='4' align=center  style=height:25px ><br></th></tr>";

echo"<tr><td bgcolor='#D9F3FF' colspan='4' align='center'><input type='submit' value='Give Special / Key Allowance'></td></tr>";
echo"</body>";
//echo "</form>";
echo"</html>";
?>

