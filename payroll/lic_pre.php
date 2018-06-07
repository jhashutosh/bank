<?
include "../config/config.php";
function rsPointZerosas($amt){
if(!empty($amt)){
$part=explode('.',$amt);
$size=sizeof($part);
if($size=='1')
$amt=$amt.'.00';
}
else $amt='0.00';
return $amt;
}

$status=$_REQUEST['status'];
$emp_id=$_REQUEST['emp_id'];
$sql_statement3="select e.name,p.* from emp_pf_dtl p,emp_master e where p.emp_id=$emp_id and p.emp_id=e.emp_id";
$result3=dBConnect($sql_statement3);
$row3=pg_fetch_array($result3,0);
$p=(empty($row3['pf_ac_no']))?$a:$row3['pf_ac_no'];
$pf_amnt=$row3['op_bal']+$row3['total_empl_cont_pf_amt']+$row3['total_emplee_cont_pf_amt'];
$name=$row3['name'];
$acno=$row3['pf_ac_no'];
//$pol_id=$_REQUEST['pol_id'];
$sql2="select * from emp_pforgratuity_lic_hdr where pol_no='$pol_no' and emp_id=$emp_id";
$result1=dBConnect($sql2);
$row2=pg_fetch_array($result1,0);
$pre_end_dt=$row2['dt_of_maturity'];
$pre_amnt=$row2['premium_amt'];
$pol_no=$row2['pol_no'];
//echo $pre_amnt;

echo "<head>";
echo "<title>lic premium</title>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
?>
<script LANGUAGE="JavaScript">
 
function cal_int(){

var pre_amnt=parseFloat(document.getElementById('pre_amnt').value);

var lt=document.getElementById('lt_fee').value.length;
//alert(lt)
var lt_fee=parseFloat(document.getElementById('lt_fee').value);
if(lt>0)
document.getElementById('to_pre_amnt').value=pre_amnt+lt_fee;
else
document.getElementById('to_pre_amnt').value=pre_amnt;
}
</script>
<style type="text/css">
	#menuUL
	{
	   background-color:  #999999;
	   filter: alpha(opacity=80);
	   -moz-opacity: 0.80;
 	   opacity: 0.80;
	}
	.report { border-collapse:collapse;}
        .report h4 { margin:0px; padding:0px;}
        .report img { float:right;}
        .report ul { margin:10px 0 10px 40px; padding:0px;}
        .report th { background:white url(header_bkg1.png) repeat-x scroll center left; color:#0a0a0a; padding:7px 15px; text-align:left;}
	//.report th { background:#CCCCCC none repeat-x scroll center left; color:#fff; padding:7px 15px; text-align:left;}
        .report td { background:#CCCCCC  url(row_bkg1.png) repeat-x scroll center left; color:#000; padding:7px 15px; }
	//.report td { background-color: #FFFFFF; border-top-style: solid; border-top-width: 2px; border-top-color: #CCCCCC; border-bottom-style: solid; border-bottom-width: 2px; border-bottom-color: #CCCCCC;}
        .report tr.odd td { background:#fff url(row_bkg1.png) repeat-x scroll center left; cursor:pointer; }
	//.report tr.odd td { cursor:pointer;}
        .report div.arrow { background:transparent url(arrows.png) no-repeat scroll 0px -16px; width:16px; height:16px; display:block;}
        .report div.up { background-position:0px 0px;}


</style>
<?
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";

echo "<body bgcolor=\"white\">";

echo"<form  name='f1' action=\"lic_pre.php?op=i&emp_id=$emp_id&pol_no=$pol_no\" method='post' >";
if($op=='i')
{
$pemp_id=$_REQUEST['emp_id'];
$ppol_no=$_REQUEST['pol_no'];
$ppremium_sl_no=$_REQUEST['premium_sl_no'];
$ppremium_start_dt=$_REQUEST['pre_srt_dt'];
$ppremium_end_dt=$_REQUEST['pre_end_dt'] ;
$ppremium_amount=$_REQUEST['pre_amnt'];
$plate_fee=$_REQUEST['lt_fee'] ;
$ptot_amt= $_REQUEST['to_pre_amnt'] ;
$prcpt_no=$_REQUEST['re_no']  ;
$prcpt_date=$_REQUEST['re_dt'] ;
$poperator_code=verifyAutho() ;
$pentry_time=date('d/m/Y H:i:s ') ;
$sql="select emp_pforgratuity_lic_dtl_save_fnc($pemp_id,'$ppol_no',$ppremium_sl_no,'$ppremium_start_dt','$ppremium_end_dt',$ppremium_amount,$plate_fee,$ptot_amt,'$prcpt_no','$prcpt_date','$poperator_code','$pentry_time')";
$res=dBConnect($sql);
//echo $sql;
//header('location:lic_pre.php?emp_id='.$emp_id);
}


echo"<table valign=\"top\"width='100%' align='center'  bgcolor=\"#E6E6FA\" >";
echo"<tr><th colspan='4'bgcolor='#839EB8'><font color='white' size='2'>LIC Premium</font></th></tr><tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr>";
/*echo"<tr><td  bgcolor='#839EB8' colspan=\"4\" height='10%'></td></tr>";

echo"<tr>";
echo "<th bgcolor='#BCA9F5' ><font color='#043C70' size='2'>Employee Id</font></th>";
echo "<th bgcolor='#BCA9F5' ><font color='#043C70' size='2'>Name</font></th>";
echo "<th bgcolor='#BCA9F5' ><font color='#043C70' size='2'>PF Account Number</font></th>";
echo "<th bgcolor='#BCA9F5' ><font color='#043C70' size='2'>PF Amount</font></th>";
echo "</tr>";
echo "<tr>";
echo "<td  bgcolor='#BCA9F5' align='center' colspan=\"1\"><font color='#043C70' size='2'>".$emp_id."</font></td>";
echo "<td  bgcolor='#BCA9F5' align='center' colspan=\"1\"><font color='#043C70' size='2'>".$name."</font></td>";
echo "<td  bgcolor='#BCA9F5' align='center' colspan=\"1\"><font color='#043C70' size='2'>".$acno."</font></td>";
echo "<td  bgcolor='#BCA9F5' align='center'  colspan=\"1\"><font color='#043C70' size='2'>".$pf_amnt."</font></td>" ;
echo "</tr>";
echo"<tr><td  bgcolor='#839EB8' colspan=\"4\" height='10%'></td></tr>";*/
echo"<tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr>";

echo "<tr>";
$sql="select count(*)+1 as sl_no from emp_pforgratuity_lic_dtl where pol_no='$pol_no'";
$res=dBConnect($sql);
$row=pg_fetch_array($res,0);
$premium_sl_no=$row['sl_no'];


	echo "<td  colspan=\"1\" align='right'><font color='black'size='2' >Premium serial No.&nbsp;:</td>";
	echo"<td><input type='text' name='premium_sl_no' size='5' value='$premium_sl_no' READONLY $HIGHLIGHT1></td>";

echo "<td  colspan=\"1\" align='right'><font color='black'size='2' >Premium Amount&nbsp;:</td>";
echo"<td><input type='text' name='pre_amnt'  id='pre_amnt' size='15' value=\"$pre_amnt\" $HIGHLIGHT1></td>";
echo"</tr>";
echo"<tr>";
echo "<td  colspan=\"1\" align='right'><font color='black'size='2' >Late Fee&nbsp;:</td>";
echo"<td><input type='text' value='0' name='lt_fee' id='lt_fee' size='15'  onfocus=\"cal_int()\" onchange=\"cal_int()\" onkeyup=\"cal_int()\" $HIGHLIGHT1></td>";
echo "<td  colspan=\"1\" align='right'><font color='black'size='2' >Total Amount&nbsp;:</td>";
echo"<td><input type='text' name='to_pre_amnt' id='to_pre_amnt' size='15' onfocus=\"cal_int()\"  onchange=\"cal_int()\" onkeyup=\"cal_int()\" $HIGHLIGHT1></td>";
echo"</tr>";
echo"<tr>";
echo "<td  colspan=\"1\" align='right'><font color='black'size='2' >Premium Start Date&nbsp;:</td>";
echo"<td><input type=\"TEXT\" name=\"pre_srt_dt\" size=\"10\" value=\"".date("d.m.Y")."\" $HIGHLIGHT1>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.pre_srt_dt,'dd/mm/yyyy','Choose Date')\" ></td>";
echo "<td  colspan=\"1\" align='right'><font color='black'size='2' >Premium End Date&nbsp;:</td>";
echo"<td><input type=\"TEXT\" name=\"pre_end_dt\" size=\"10\" value=\"".date("d.m.Y")."\" $HIGHLIGHT1>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.pre_end_dt,'dd/mm/yyyy','Choose Date')\" ></td>";
echo"</tr>";
echo"<tr>";
echo "<td  colspan=\"1\" align='right'><font color='black'size='2' >Reciept No.&nbsp;:</td>";
echo"<td><input type='text' name='re_no' size='15' $HIGHLIGHT1></td>";
echo "<td  colspan=\"1\" align='right'><font color='black'size='2' >Reciept Date&nbsp;:</td>";
echo"<td><input type=\"TEXT\" name=\"re_dt\" size=\"10\" value=\"".date("d.m.Y")."\" $HIGHLIGHT1>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.re_dt,'dd/mm/yyyy','Choose Date')\" ></td>";
echo"</tr>";

echo"<tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr>";
echo"<tr><td  bgcolor='#839EB8' colspan=\"4\" height='10%'></td></tr>";
echo"<tr><td colspan='4'bgcolor='#839EB8' align='center'><input type='submit'  value='Submit'></td><tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr></table>";
echo"<table width='100%' class='report' >";
echo"<tr>";
echo "<th bgcolor='#BBBBBB' width='25%'  align='center' ><font color='black' size='2'>Policy No.</font></th>";
echo "<th bgcolor='#BBBBBB' width='25%'  align='center' ><font color='black' size='2'>Date Of Commencement</font></th>";
echo "<th bgcolor='#BBBBBB' width='25%'  align='center' ><font color='black' size='2'>Date Of Maturity</font></th>";
echo "<th bgcolor='#BBBBBB' width='25%'  align='center' ><font color='black' size='2'>Policy Value</font></th>";
echo "</tr>";
$sql="select * from emp_pforgratuity_lic_hdr where pol_no='$pol_no'";
$res=dBConnect($sql);
for($j=0;$j<pg_NumRows($res);$j++){
//echo $sql;
$row=pg_fetch_array($res,$j);
echo "<tr>";
echo "<td  bgcolor='#BCA9F5' align='center' colspan=\"1\"  width='25%' ><font color='#043C70' size='2'>".$row['pol_no']."</font></td>";
echo "<td  bgcolor='#BCA9F5' align='center' colspan=\"1\"  width='25%' ><font color='#043C70' size='2'>".$row['dt_of_commencement']."</font></td>";
echo "<td  bgcolor='#BCA9F5' align='center' colspan=\"1\"  width='25%' ><font color='#043C70' size='2'>".$row['dt_of_maturity']."</font></td>";
echo "<td  bgcolor='#BCA9F5' align='center'  colspan=\"1\"  width='25%' ><font color='#043C70' size='2'>".$row['pol_val']."</font></td>" ;
echo "</tr>";
}


echo"</table><hr>";
//=================================================================gridview=========================================================================================
echo"<table width='100%' >";

echo"<tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr>";
echo"<tr><td  bgcolor='#839EB8' colspan=\"7\" height='10%'></td></tr>";
echo"<tr>";
echo "<th bgcolor='#BCA9F5' width=\"6%\"><font color='#043C70' size='2'>Serial No.</font></th>";
echo "<th bgcolor='#BCA9F5'  width=\"20%\" ><font color='#043C70' size='2'>Start Date</font></th>";
echo "<th bgcolor='#BCA9F5' width=\"20%\"><font color='#043C70' size='2'>End Date</font></th>";
echo "<th bgcolor='#BCA9F5'  width=\"28%\"><font color='#043C70' size='2'>Total Amount</font></th>";
echo "<th bgcolor='#BCA9F5'  width=\"6%\"><font color='#043C70' size='2'>Reciept No.</font></th>";
echo "<th bgcolor='#BCA9F5' width=\"20%\"><font color='#043C70' size='2'>Reciept Date</font></th>";
echo"<tr><td colspan=\"6\" align=center>";
echo "<div style=\"overflow-y:auto;height:100px\">";
echo"<table valign=\"top\"width='110%' align='center' class='report'>";
$sql="select * from emp_pforgratuity_lic_dtl where pol_no='$pol_no'";
$res=dBConnect($sql);
//echo $sql;
$color==$TCOLOR;
for($j=0;$j<pg_NumRows($res);$j++){
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($res,$j);
echo "<tr>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"6%\"><font color='black' size='2'>".$row['premium_sl_no']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"20%\"><font color='black' size='2'>".$row['premium_start_dt']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"20%\"><font color='black' size='2'>".$row['premium_end_dt']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"28%\"><font color='black' size='2'>".$row['tot_amt']."</font></td>";
$amt+=$row['tot_amt'];
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"6%\"><font color='black' size='2'>".$row['rcpt_no']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"20%\"><font color='black' size='2'>".$row['rcpt_date']."</font></td>";
echo"</tr>";
}
echo"</table>";
echo"</div>";
//$amt='';
echo"</td></tr><tr bgcolor='silver'><td colspan=3 align='center'><b>Total Amount !!!</td><td colspan=1 width=\"28%\" align='right'><b>".rsPointZerosas($amt)."</td>";
echo"<td colspan=2 align='center' width=\"26%\"></td></tr></table>";
//echo "</table>";
echo"</form>";
echo"</body>";
?>
