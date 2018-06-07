<?
include "../config/config.php";
echo "<head>";
echo"<title>Edit Page</title>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
$acno=$_REQUEST['acno'];
$c_id=$_REQUEST['c_id'];

function makeSelectmode($element_array,$element,$default,$val){

	echo "<SELECT name=\"".$element."\">";
	
	if(!empty($default)){
		echo "<option value=\"".$val."\">".$default;
	}
	
	while(list($key,$val)=each($element_array)){
		if($val!=$default){
		
			echo "<option value=".$key.">".$val;
		}
	}
	echo "</select>";
}


echo "<body bgcolor=\"#D8D8D8\">";
?>
<script LANGUAGE="JavaScript">
function cal_days(f){

var prd=parseInt(document.getElementById('period').value);

var date=new Date(document.getElementById('inv_dt').value);

if(f.prds_in[0].checked){

var days=Math.round(30.42*prd);
}
if(f.prds_in[1].checked){

var days=Math.round(365.24*prd);
 }

//alert (days)

date.setDate(date.getDate()+days);
//alert (date)
document.getElementById('mtr_dt').value=date;
var p=parseInt(document.getElementById('dp_amnt').value);
var i=parseInt(document.getElementById('int_rt').value);
var interest=Math.round((p*i*days)/(100*365.24));
if(i>0){
document.getElementById('int_amnt').value=interest;
document.getElementById('t_m_amnt').value=interest+p;
}

}

</script>

<?
$emp_id=$_REQUEST['emp_id'];
$type=$_REQUEST['type'];
$id=$_REQUEST['id'];
$sql_statement3="select e.name,p.* from emp_pf_dtl p,emp_master e where p.emp_id=$emp_id and p.emp_id=e.emp_id";
$result3=dBConnect($sql_statement3);
$row3=pg_fetch_array($result3,0);
$p=(empty($row3['pf_ac_no']))?$a:$row3['pf_ac_no'];
$pf_amnt=$row3['op_bal']+$row3['total_empl_cont_pf_amt']+$row3['total_emplee_cont_pf_amt'];
$name=$row3['name'];
$acno=$row3['pf_ac_no'];
$pol_no=$_REQUEST['pol_no'];
//.............................................................bank edit...........................................................................................
if($type=='bank'){
echo"<form  name='f1' action=\"pf_bnk_edit.php?type=bank&op=i&emp_id=$emp_id&c_id=$c_id\" method='post' >";
if($op=='i')
{
//$pac_no=$_REQUEST['acno'] ;
$pac_type='P' ;
$pemp_id=$_REQUEST['emp_id']  ;
$pid_emp_investment_mas=$_REQUEST['inv_id'] ;
$pdeposit_no=$_REQUEST['de_no'] ;
$pbank_name=$_REQUEST['bnk_name']  ;
$pbank_dtl=$_REQUEST['bnk_dtls'] ;
$pinv_mode=$_REQUEST['prds_in'] ;
$pinv_period=$_REQUEST['period'] ;
$pdt_of_issue=$_REQUEST['inv_dt'] ;
$pdt_of_issue=$_REQUEST['inv_dt'] ;
$parts=explode('/',$pdt_of_issue);
$pdt_of_issue=$parts[1].'/'.$parts[0].'/'.$parts[2];
$pdt_of_maturity=$_REQUEST['mtr_dt'] ;
$pamount=$_REQUEST['dp_amnt']  ;
$pint_mode=$_REQUEST['inst_mode'] ;
$pint_percent=$_REQUEST['int_rt']  ;
$pint_amt=$_REQUEST['int_amnt'] ;
$poperator_code=verifyAutho();
$pentry_time=date('d/m/Y H:i:s ');
$date_sql="select  cast(substr('$pdt_of_maturity',5,11) as date)";
//echo $date_sql;
$r=dBConnect($date_sql);
$row=pg_fetch_array($r,0);
$mtrty_dt=(empty($row['substr']))?$pdt_of_maturity:$row['substr'];
//echo $mtrty_dt;
$sql="select emp_pforgratuity_sb_dtl_save_fnc('$acno','$pac_type',$emp_id,$pid_emp_investment_mas,'$pdeposit_no','$pbank_name','$pbank_dtl','$pinv_mode',$pinv_period,'$pdt_of_issue','$mtrty_dt',$pamount,'$pint_mode',$pint_percent,'$pint_amt','$poperator_code','$pentry_time')";
$res=dBConnect($sql);
echo $sql;
echo $c_id;
header('location:pf_invst_dtl.php?id='.$emp_id.'&c_id='.$c_id.'&acno='.$acno.'#tabs-1');

}
echo"<table valign=\"top\"width='100%' align='center'>";
echo"<tr><th colspan='4'bgcolor='#839EB8'><font color='#043C70' size='2'>Bank Investment</font></th></tr><tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr>";
echo "<tr>";

$sql="select p.* , to_char(p.dt_of_issue,'mm/dd/yyyy') as dt_of_issue from emp_pforgratuity_sb_dtl p where emp_id=$emp_id and id=$id";
$res=dBConnect($sql);
$row=pg_fetch_array($res,0);
echo "<td  colspan=\"2\"><font color='black' size='2' align='left'>Investment Type&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
$sql="select upper(invst_desc) as invst_desc from emp_investment_mas where id=".$row['id_emp_investment_mas'];
$res=dBConnect($sql);
//echo $sql;
$r=pg_fetch_array($res,0);
echo"<input type='hidden' name='inv_id' value=\"".$row['id_emp_investment_mas']."\" size='15'$HIGHLIGHT >";
echo $r['invst_desc']."</td>";

//echo $sql;
echo"</select></td>";
echo "<td ><font color='black'size='2' align='left'>Deposit No.&nbsp;: ";
echo $row['deposit_no']."</td>";
echo "<td ><font color='black'size='2' align='left'>Deposit Date&nbsp;:&nbsp;";
echo $row['dt_of_issue'];
//echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\"  onclick=\"showCalendar(f1.inv_dt,'dd/mm/yyyy','Choose Date')\" >&nbsp;(mm/dd/yyyy)";
echo"&nbsp;&nbsp;&nbsp;&nbsp; (mm/dd/yyyy) </td>";
echo"</tr>";
echo"<tr>";
echo"<td  colspan=\"2\"><font color='black'size='2' align='left'>Bank Name&nbsp;:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
echo"<input type='text' name='bnk_name' size='15' value=\"".$row['bank_name']."\" $HIGHLIGHT></td>";
echo "<td  colspan=\"1\"><font color='black'size='2' align='left'>Periods in&nbsp;:";
if($row['inv_mode']=='m'){


echo 	"<input type=\"radio\" name=\"prds_in\" value=\"m\" checked>Months 
	<input type=\"radio\" name=\"prds_in\" value=\"y\">Years";

}
else{

echo 	"<input type=\"radio\" name=\"prds_in\" value=\"m\">Months 
	<input type=\"radio\" name=\"prds_in\" value=\"y\" checked>Years";


}
echo"&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' id='period' name='period' value=\"".$row['inv_period']."\" size='5' onChange=\"cal_days(this.form)\" onKeyup=\"cal_days(this.form)\" $HIGHLIGHT></td>";
echo "<td ><font color='black'size='2' align='left'>Maturity Date&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo"<input type=\"TEXT\" name=\"mtr_dt\" size=\"12\" value=\"".$row['dt_of_maturity']."\" id=\"mtr_dt\" onClick=\"cal_days(this.form)\" onKeyup=\"cal_days(this.form)\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.mtr_dt,'dd/mm/yyyy','Choose Date')\" >";
echo"</td>";
echo "</tr>";
echo "<td  colspan=\"2\"><font color='black'size='2' align='left'>Bank Details&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo"<input type='text' name='bnk_dtls' size='15'  value=\"".$row['bank_dtl']."\" $HIGHLIGHT></td>";
echo "<td  colspan=\"2\"><font color='black'size='2' align='left'>Deposit Amount&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo"<input type='text' name='dp_amnt' id='dp_amnt' size='5' value=\"".$row['amount']."\" onchange=\"cal_days(this.form)\" onkeyup=\"cal_days(this.form) $HIGHLIGHT></td></tr>";
echo"<tr><td  bgcolor='#839EB8' colspan=\"4\" height='10%'></td></tr>";
echo"<tr><th colspan='4'bgcolor='#839EB8'><font color='#043C70' size='2' >Interest Details</font></th></tr><tr><td  colspan='3'></td></tr><tr><td colspan='3'></td></tr><tr><td  colspan='3'></td></tr>";
echo "<tr>";
echo "<td  colspan=\"2\" align='center'><font color='black'size='2' align='left'>Interest Mode&nbsp;:&nbsp;";
makeSelectmode($inst_array,'inst_mode',''.$inst_array[$row['int_mode']].'',''.$row['int_mode'].'');
echo "<td  colspan=\"1\" align='center'><font color='black'size='2' align='left'>Interest Rate&nbsp;:&nbsp;&nbsp;";
echo"<input type='text' name='int_rt'  id='int_rt' size='3' value=\"".$row['int_percent']."\" onchange=\"cal_days(this.form)\" onkeyup=\"cal_days(this.form) $HIGHLIGHT>&nbsp;%</td>";
echo "<td  colspan=\"1\"align='center'><font color='black'size='2' align='left'>Interest Amount&nbsp;:&nbsp;";
echo"<input type='text' name='int_amnt'  id='int_amnt' size='10' value=\"".$row['int_amt']."\" onchange=\"cal_days(this.form)\" onkeyup=\"cal_days(this.form) READONLY $HIGHLIGHT></td>";
echo "</tr>";
echo"<tr><td  bgcolor='#839EB8' colspan=\"4\" height='10%'></td></tr>";
echo "<td  colspan=\"4\" align='center'><font color='black'size='2' >Total Maturity Amount&nbsp;:&nbsp;";
echo"<input type='text' name='t_m_amnt' id='t_m_amnt' size='15' value=\"".($row['int_amt']+$row['amount'])."\" onchange=\"cal_days(this.form)\" onkeyup=\"cal_days(this.form) READONLY $HIGHLIGHT></td><br>";
echo"</tr>";
echo"<tr><td  bgcolor='#839EB8' colspan=\"4\" height='10%'></td></tr>";
echo"<tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr>";
echo"<tr><td align='center'  colspan='4'><input type='submit' value='Submit'></td></tr>";
echo"</table>";
echo "</form>";}
//..................................................................lic edit........................................................................................
if($type=='lic'){
$emp_id=$_REQUEST['emp_id'];
echo"<form  name='f2' action=\"pf_bnk_edit.php?type=lic&op=i&emp_id=$emp_id&c_id=$c_id\" method='post' >";
if($op=='i')
{
$pac_type='P' ;
$emp_id=$_REQUEST['emp_id'];
$ppol_no=$_REQUEST['pl_no'];
$ppol_dtl=$_REQUEST['pl_dtl'];
$pid_emp_investment_mas=$_REQUEST['invst'] ;
$pdt_of_commencement=$_REQUEST['dt_cmcmt'];
$pdt_of_maturity=$_REQUEST['dt_mtrty'];
$pbr_code=$_REQUEST['br_cd'];
$ppol_val=$_REQUEST['pl_vl'];
$pprem_mode=$_REQUEST['inst_mode'];
$ptotal_no_of_premium=$_REQUEST['no_pr'];
$ppremium_amt=$_REQUEST['pr_amnt'];
$poperator_code=verifyAutho();
$pentry_time=date('d/m/Y H:i:s ');
$sql="select emp_pforgratuity_lic_hdr_save_fnc('$acno','$pac_type',$emp_id,$pid_emp_investment_mas,'$ppol_no','$ppol_dtl','$pdt_of_commencement','$pdt_of_maturity','$pbr_code',$ppol_val,'$pprem_mode',$ptotal_no_of_premium,$ppremium_amt,'$poperator_code','$pentry_time')";
$res=dBConnect($sql);
//echo $sql;
header('location:pf_invst_dtl.php?id='.$emp_id.'&c_id='.$c_id.'&acno='.$acno.'#tabs-3');
}

$sql="select * from emp_pforgratuity_lic_hdr where emp_id=$emp_id and pol_no='$pol_no'";
$res=dBConnect($sql);
$row=pg_fetch_array($res,0);
//echo $sql;

echo"<table width='100%' align='center' >";
echo"<tr><th colspan='4'bgcolor='#839EB8'><font color='#043C70' size='2'> LIC Investment</font></th></tr><tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr>";
echo "<tr>";
echo "</table><table width='100%' >";
echo "<td colspan=\"1\"  width='30%' align='right'><font color='black' size='2' align='left'>Policy Number&nbsp;:&nbsp;&nbsp;</td><td width='20%'>";
echo $row['pol_no'];

echo"<td width='30%' align='right'><font color='black' size='2' >&nbsp;Policy Details:</td>";
echo"<td rowspan='2' width='20%' ><textarea name='pl_dtl' rows='2' cols='15' $HIGHLIGHT>".$row['pol_dtl']."</textarea></td>";
echo"</tr>";
echo "<tr><td width='30%' colspan=\"1\" align='right'><font color='black' size='2' align='left'>Policy Type&nbsp;:&nbsp;&nbsp;</td>";
echo "<td width='20%'>";
$sql="select upper(invst_desc) as invst_desc from emp_investment_mas where id=".$row['id_emp_investment_mas'];
$res=dBConnect($sql);
//echo $sql;
$r=pg_fetch_array($res,0);
echo"<input type='hidden' name='invst' value=\"".$row['id_emp_investment_mas']."\" size='15'$HIGHLIGHT >";
echo $r['invst_desc']."</td>";

echo"</select></td></tr>";
echo"<tr><td colspan='3' ><br></td></tr>";
echo"</table><table width='100%'  >";
echo "<td colspan=\"1\" width='30%' align='right'><font color='black'size='2'align='left'>Date Of Commencement&nbsp;:&nbsp;&nbsp;</td><td width='20%'>";
echo $row['dt_of_commencement'];
//echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.dt_cmcmt,'dd/mm/yyyy','Choose Date')\" >";
echo"</td>";
echo"<td></td>";
echo "<td colspan=\"1\" width='30%' align='right'><font color='black'size='2' align='left'>Date of Maturity&nbsp;:&nbsp;</td><td width='20%'>";
echo"<input type=\"TEXT\" name=\"dt_mtrty\" size=\"10\" value=\"".$row['dt_of_maturity']."\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f2.dt_mtrty,'dd/mm/yyyy','Choose Date')\" >";
echo"</td>";
echo"</tr>";
echo "<tr>";
echo "<td width='30%' align='right'><font color='black' size='2' align='left'>Branch Code&nbsp;:&nbsp;&nbsp;</td><td width='20%'>";
echo"<input type='text' name='br_cd' value=\"".$row['br_code']."\"size='5'$HIGHLIGHT ></td>";
echo"<td></td>";
echo "<td  width='30%' align='right'><font color='black' size='2' align='left'>&nbsp;&nbsp; Policy Value&nbsp;:&nbsp;&nbsp;</td><td width='20%'>";
echo"<input type='text' name='pl_vl' value=\"".$row['pol_val']."\" size='10'$HIGHLIGHT ></td>";
echo"</tr>";
echo"</table><table width='100%' >";
echo"<tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr>";
echo"<tr><td  bgcolor='#839EB8' colspan=\"6\" height='10%'></td></tr>";
echo"<tr><th colspan='6' bgcolor='#839EB8'><font color='#043C70' size='2' >Premium Details</font></th></tr><tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr>";
echo "<tr>";
echo "<td align='right' ><font color='black' size='2' align='left'>Premium Mode:&nbsp;</td><td align='left' >";
makeSelectmode($inst_array,'inst_mode',''.$inst_array[$row['prem_mode']].'',''.$row['prem_mode'].'');
echo"</td>";
echo "<td align='right' ><font color='black' size='2' align='left'>Premium Amount&nbsp;:&nbsp;</td><td align='left'>";
echo"<input type='text' name='pr_amnt'  value=\"".$row['premium_amt']."\" size='5'$HIGHLIGHT ></td>";
echo "<td  align='right'><font color='black' size='2' align='left'>Total No. of Premium&nbsp;:&nbsp;</td><td align='left'>";
echo"<input type='text' name='no_pr'  value=\"".$row['total_no_of_premium']."\" size='5'$HIGHLIGHT ></td>";
echo"</tr>";
echo"<tr><td  bgcolor='#839EB8' colspan=\"8\" height='10%'></td></tr>";
echo"<tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr>";
echo"<tr><td align='center'  colspan='8'><input type='submit' value='Submit'></td></tr>";
echo "</table>";
echo"</form>";
}
//.........................................................post office edit.........................................................................................
if($type=='po')
{
$emp_id=$_REQUEST['emp_id'];
echo"<form  name='f3' action=\"pf_bnk_edit.php?type=po&op=i&emp_id=$emp_id&c_id=$c_id\" method='post' >";
if($op=='i')
{
$pac_type='P' ;
$pemp_id=$_REQUEST['emp_id'] ;
$pid_emp_investment_mas=$_REQUEST['invst'] ;
$ppo_name =$_REQUEST['po_name'];
$ppo_dtl =$_REQUEST['po_dtls'];
$psaving_regno=$_REQUEST['saving_regno'] ;
$pdt_of_issue=$_REQUEST['dt_iss'] ;
$pdt_of_maturity=$_REQUEST['dt_mtrty'] ;
$ptot_no_of_cerf=$_REQUEST['to_n_ct'] ;
$ptot_amount=$_REQUEST['to_amnt'] ;
$pint_mode=$_REQUEST['inst_mode'] ;
$pint_percent=$_REQUEST['int_rt'] ;
$pint_amt=$_REQUEST['int_amnt'] ;
$poperator_code=verifyAutho();
$pentry_time=date('d/m/Y H:i:s ') ;
$sql="select emp_pforgratuity_po_hdr_save_fnc('$acno','$pac_type',$emp_id,$pid_emp_investment_mas,'$ppo_name','$ppo_dtl','$psaving_regno','$pdt_of_issue','$pdt_of_maturity',$ptot_no_of_cerf,$ptot_amount,'$pint_mode',$pint_percent,$pint_amt,'$poperator_code','$pentry_time')";
$res=dBConnect($sql);
echo $sql;
header('location:pf_invst_dtl.php?id='.$emp_id.'&c_id='.$c_id.'&acno='.$acno.'#tabs-2');
}
$sql="select * from emp_pforgratuity_po_hdr where emp_id=$emp_id and saving_regno='$saving_regno'";
$res=dBConnect($sql);
$row=pg_fetch_array($res,0);
echo"<table valign=\"top\"width='100%' align='center'>";
echo"<tr><th colspan='4'bgcolor='#839EB8'><font color='#043C70' size='2'>Post Office Investment</font></th></tr>";
echo"<tr><td  bgcolor='#839EB8' colspan=\"4\" height='10%'></td></tr>";
echo"<tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr>";
echo "<tr>";
//echo "<td  colspan=\"1\" align='right' width='30%'><font color='black'size='2' >Post Office Name&nbsp;:</td>";
//echo"<td width='20%'><input type='text' name='po_name' value=\"".$row['po_name']."\" size='15' $HIGHLIGHT></td>";
echo "<td  colspan=\"1\" align='right'><font color='black'size='2' >Certificate Registration No.&nbsp;:</td>";
echo"<td>".$row['saving_regno']."</td>";
echo "<td  colspan=\"1\" align='right' rowspan='2'><font color='black'size='2' >Post Office Details&nbsp;:</td>";
echo"<td valign='bottom'><textarea name='po_dtls' rows='2' cols='15' $HIGHLIGHT>".$row['po_dtl']."</textarea></td>";
echo"</tr>";
echo "<tr>";
echo "<td  colspan=\"1\" align='right'><font color='black'size='2' >Date of Issue&nbsp;:</td>";
echo"<td>".$row['dt_of_issue'];
echo "</td>";
echo"<tr>";
//echo "<td  colspan=\"1\" align='right'><font color='black'size='2' >Date of Issue&nbsp;:</td>";
//echo"<td>".$row['dt_of_issue'];
//echo "</td>";
echo "<td  colspan=\"1\" align='right' width='30%'><font color='black'size='2' >Post Office Name&nbsp;:</td>";
echo"<td width='20%'><input type='text' name='po_name' value=\"".$row['po_name']."\" size='15' $HIGHLIGHT></td>";
echo "<td  colspan=\"1\" align='right'><font color='black'size='2' >Date of Maturity&nbsp;:</td>";
echo"<td><input type=\"TEXT\" name=\"dt_mtrty\" size=\"10\" value=\"".$row['dt_of_maturity']."\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f3.dt_mtrty,'dd/mm/yyyy','Choose Date')\" ></td>";
echo"</tr>";
echo"<tr>";
echo "<td  colspan=\"1\" align='right'><font color='black' size='2' >Policy Type&nbsp;:</td>";
echo "<td>";
$sql="select upper(invst_desc) as invst_desc from emp_investment_mas where id=".$row['id_emp_investment_mas'];
$res=dBConnect($sql);
//echo $sql;
$r=pg_fetch_array($res,0);
echo"<input type='hidden' name='invst' value=\"".$row['id_emp_investment_mas']."\" size='15'$HIGHLIGHT >";
echo"<input type='text' name='inv_des' value=\"".$r['invst_desc']."\" size='15'$HIGHLIGHT ></td>";
echo"</select></td>";
echo "<td  colspan=\"1\" align='right'><font color='black'size='2' >Total No. of Certificate&nbsp;:</td>";
echo"<td><input type='text' name='to_n_ct' size='5' value=\"".$row['tot_no_of_cerf']."\" $HIGHLIGHT></td>";
echo"<tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr>";
echo"</tr>";
echo"<table width='100%' align='center' >";
echo"<tr><th colspan='5' bgcolor='#839EB8'><font color='#043C70' size='2' >Post Office Interest Details</font></th></tr><tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr>";
echo "<tr>";
echo "<td align='center'><font color='black' size='2' align='right'>Interest Mode:&nbsp;&nbsp;";
makeSelectmode($inst_array,'inst_mode',''.$inst_array[$row['int_mode']].'',''.$row['int_mode'].'');
echo"</td>";
echo "<td  align='right'><font color='black' size='2' >Total Amount&nbsp;:&nbsp;</td><td align='left'>";
echo"<input type='text' name='to_amnt' value=\"".$row['tot_amount']."\" size='10'$HIGHLIGHT ></td>";
echo "<td  ><font color='black' size='2' align='left'>Interest Rate&nbsp;:&nbsp;";
echo"<input type='text' name='int_rt' value=\"".$row['int_percent']."\" size='5'$HIGHLIGHT >&nbsp;%</td>";
echo "<td ><font color='black' size='2' align='left'>Interest Amount &nbsp;:&nbsp;&nbsp;&nbsp;";
echo"<input type='text' name='int_amnt' value=\"".$row['int_amt']."\" size='5'$HIGHLIGHT ></td>";
echo"</tr>";
echo"<tr><td  bgcolor='#839EB8' colspan=\"5\" height='10%'></td></tr>";
echo"<tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr>";
echo"<tr><td align='center'  colspan='5'><input type='submit' value='Submit'></td></tr>";
echo"</table>";
echo"</table>";
echo"</form>";
}
echo"</body></html>";
?>
