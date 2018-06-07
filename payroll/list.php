<?
include "../config/config.php";
$type=$_REQUEST['q'];
$status=$_REQUEST['status'];
//$id=$_REQUEST['id'];
$emp_id=$_REQUEST['emp_id'];
$t=$_REQUEST['type'];
//echo $emp_id;
$sql_statement3="select e.name,p.* from emp_pf_dtl p,emp_master e where p.emp_id=$emp_id and p.emp_id=e.emp_id";
$result3=dBConnect($sql_statement3);
$row3=pg_fetch_array($result3,0);
$p=(empty($row3['pf_ac_no']))?$a:$row3['pf_ac_no'];
$pf_amnt=$row3['op_bal']+$row3['total_empl_cont_pf_amt']+$row3['total_emplee_cont_pf_amt'];
$name=$row3['name'];
$acno=$row3['pf_ac_no'];


function makeSelectmode($element_array,$element,$default){

	echo "<SELECT name=\"".$element."\">";
	
	if(!empty($default)){
		echo "<option>".$default;
	}
	
	while(list($key,$val)=each($element_array)){
		if($val!=$default){
		
			echo "<option value=".$key.">".$val;
		}
	}
	echo "</select>";
}
echo "<head>";
echo "<title>Type of Invesment</title>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<script src=\"../JS/loading2.js\">";
echo "</script>";
?>
<script LANGUAGE="JavaScript">
function f2(str,emp_id){
window.location.assign("pf_invst_dtl.php?emp_id="+emp_id+"&type="+str)
//alert(str+emp_id)
//showHint_list_in(str,emp_id)
}
function f3(str,emp_id){
//alert(id+str);

showHint_list(str,emp_id)
}


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
echo"<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
if(empty($t)){
echo "<body bgcolor=\"#D8D8D8\">";

}
if(!empty($t)){

echo "<body bgcolor=\"#D8D8D8\" onload=\"f3($t,$emp_id);\">";
}
//=========================================================the selection procedure for investment type=============================================================
if(empty($type)){
echo "<h1 align='center'><font color='red'><blink>SELECT THE TYPE OF PF INVESTMENT</blink></font></h1>";
echo "<hr>";
echo"<table valign=\"top\"width='100%' align='center'>";
echo"<tr><th colspan='4'bgcolor='#839EB8'><font color='#043C70' size='4'>Employee PF Investment</font></th></tr><tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr>";
echo"<tr><td  bgcolor='#839EB8' colspan=\"4\" height='10%'></td></tr>";
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
echo"<tr><td  bgcolor='#839EB8' colspan=\"4\" height='10%'></td></tr>";
echo "</tr><tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr></table>";
echo"<hr>";
echo"<table width='100%' height='10%' align='center' bgcolor='yellow' >";
echo"<tr><td></td></tr><tr><td ></td></tr>";
echo "<tr><td align='right' ><font color='#043C70' size='3'>Select Investment type</font></td>";
echo "<td align='left' width='50%' >";
echo "<select name=\"type\" onchange=\"f2(this.value,$emp_id);\"> <option value=''> Select</option>";
$sql="select distinct(type) as type from emp_investment_mas";
$res=dBConnect($sql);
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
echo $row['type'];
echo $type_of_pf_investment_array[$row['type']];
echo"<option value=".$row['type'].">".$type_of_pf_investment_array[$row['type']]."</option>";
}
echo"</select></td></tr>";
echo"</table>";
echo "<hr>";
}
?>

<span id="txtHint"></span>


<?
//======================================================================selection for bank==========================================================================
if($type=='bank' || $t=='bank'){
$emp_id=$_REQUEST['emp_id'];

//echo $emp_id;
echo "<head>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"#D8D8D8\">";
echo"<form  name='f1' action=\"pf_invst_dtl.php?type=bank&op=i&emp_id=$emp_id\" method='post' >";

if($op=='i')
{
//$pac_no=$_REQUEST['acno'] ;
$pac_type='P' ;
$pemp_id=$_REQUEST['emp_id']  ;
$pid_emp_investment_mas=$_REQUEST['invst'] ;
$pdeposit_no=$_REQUEST['de_no'] ;
$pbank_name=$_REQUEST['bnk_name']  ;
$pbank_dtl=$_REQUEST['bnk_dtls'] ;
$pinv_mode=$_REQUEST['prds_in'] ;
$pinv_period=$_REQUEST['period'] ;
$pdt_of_issue=$_REQUEST['inv_dt'] ;
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
$mtrty_dt=$row['substr'];
//echo $mtrty_dt;
$sql="select emp_pforgratuity_sb_dtl_save_fnc('$acno','$pac_type',$emp_id,$pid_emp_investment_mas,'$pdeposit_no','$pbank_name','$pbank_dtl','$pinv_mode',$pinv_period,'$pdt_of_issue','$mtrty_dt',$pamount,'$pint_mode',$pint_percent,'$pint_amt','$poperator_code','$pentry_time')";
$res=dBConnect($sql);
//echo $sql;
header('location:pf_invst_dtl.php?type=bank&emp_id='.$emp_id);

}
echo"<table valign=\"top\"width='100%' align='center'>";
echo"<tr><th colspan='4'bgcolor='#839EB8'><font color='#043C70' size='2'>Bank Investment</font></th></tr><tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr>";
echo "<tr>";
echo "<td  colspan=\"2\"><font color='black' size='2' align='left'>Investment Type&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<select name=\"invst\"> <option value=''> Select</option>";
$sql="select distinct(invst_desc),upper(invst_desc) as invst_desc from emp_investment_mas where type like 'bank'";
$res=dBConnect($sql);
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
//echo $sql;
echo"<option value=".$row['id'].">".$row['invst_desc']."</option>";
}
echo"</select></td>";
echo "<td ><font color='black'size='2' align='left'>Deposit No.&nbsp;:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
echo"<input type='text' name='de_no' size='15'$HIGHLIGHT ></td>";
echo "<td ><font color='black'size='2' align='left'>Deposit Date&nbsp;:&nbsp;";
echo"<input type=\"TEXT\" name=\"inv_dt\" size=\"10\" value=\"".date("m/d/Y")."\" id=\"inv_dt\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\"  onclick=\"showCalendar(f1.inv_dt,'dd/mm/yyyy','Choose Date')\" >&nbsp;(mm/dd/yyyy)";
echo"</td>";
echo"</tr>";
echo"<tr>";
echo"<td  colspan=\"2\"><font color='black'size='2' align='left'>Bank Name&nbsp;:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
echo"<input type='text' name='bnk_name' size='15' $HIGHLIGHT></td>";
echo "<td  colspan=\"1\"><font color='black'size='2' align='left'>Periods in&nbsp;:";


echo 	"<input type=\"radio\" name=\"prds_in\" value=\"m\">Months 
	<input type=\"radio\" name=\"prds_in\" value=\"y\">Years


&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' id='period' name='period' value='' size='5' onChange=\"cal_days(this.form)\" onKeyup=\"cal_days(this.form)\" $HIGHLIGHT></td>";
echo "<td ><font color='black'size='2' align='left'>Maturity Date&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo"<input type=\"TEXT\" name=\"mtr_dt\" size=\"12\" value=\"\" id=\"mtr_dt\" onClick=\"cal_days(this.form)\" onKeyup=\"cal_days(this.form)\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.mtr_dt,'dd/mm/yyyy','Choose Date')\" >";
echo"</td>";
echo "</tr>";
echo "<td  colspan=\"2\"><font color='black'size='2' align='left'>Bank Details&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo"<input type='text' name='bnk_dtls' size='15' $HIGHLIGHT></td>";
echo "<td  colspan=\"2\"><font color='black'size='2' align='left'>Deposit Amount&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo"<input type='text' name='dp_amnt' id='dp_amnt' size='5'  onchange=\"cal_days(this.form)\" onkeyup=\"cal_days(this.form) $HIGHLIGHT></td></tr>";
echo"<tr><td  bgcolor='#839EB8' colspan=\"4\" height='10%'></td></tr>";
echo"<tr><th colspan='4'bgcolor='#839EB8'><font color='#043C70' size='2' >Interest Details</font></th></tr><tr><td  colspan='3'></td></tr><tr><td colspan='3'></td></tr><tr><td  colspan='3'></td></tr>";
echo "<tr>";
echo "<td  colspan=\"2\" align='center'><font color='black'size='2' align='left'>Interest Mode&nbsp;:&nbsp;";
makeSelectmode($inst_array,'inst_mode','');
echo "<td  colspan=\"1\" align='center'><font color='black'size='2' align='left'>Interest Rate&nbsp;:&nbsp;&nbsp;";
echo"<input type='text' name='int_rt'  id='int_rt' size='3'  onchange=\"cal_days(this.form)\" onkeyup=\"cal_days(this.form) $HIGHLIGHT>&nbsp;%</td>";
echo "<td  colspan=\"1\"align='center'><font color='black'size='2' align='left'>Interest Amount&nbsp;:&nbsp;";
echo"<input type='text' name='int_amnt'  id='int_amnt' size='10'  onchange=\"cal_days(this.form)\" onkeyup=\"cal_days(this.form) READONLY $HIGHLIGHT></td>";
echo "</tr>";
echo"<tr><td  bgcolor='#839EB8' colspan=\"4\" height='10%'></td></tr>";
echo "<td  colspan=\"4\" align='center'><font color='black'size='2' >Total Maturity Amount&nbsp;:&nbsp;";
echo"<input type='text' name='t_m_amnt' id='t_m_amnt' size='15'  onchange=\"cal_days(this.form)\" onkeyup=\"cal_days(this.form) READONLY $HIGHLIGHT></td><br>";
echo"</tr>";
echo"<tr><td  bgcolor='#839EB8' colspan=\"4\" height='10%'></td></tr>";
echo"<tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr>";
echo"<tr><td align='center'  colspan='4'><input type='submit' value='Submit'></td></tr>";
echo"</table>";
//........//.............//......................//...............GriedView..........//.........//...........//..........//.............//........//...............
echo"<table width='100%' >";
echo"<tr>";
echo "<th bgcolor='#BCA9F5' width=\"10%\"><font color='#043C70' size='2'>Deposit No.</font></th>";
echo "<th bgcolor='#BCA9F5' width=\"25%\"><font color='#043C70' size='2'>Bank Name</font></th>";
echo "<th bgcolor='#BCA9F5' width=\"20%\"><font color='#043C70' size='2'>Deposit Amount</font></th>";
echo "<th bgcolor='#BCA9F5' width=\"20%\"><font color='#043C70' size='2'>Deposit Date</font></th>";
echo "<th bgcolor='#BCA9F5' width=\"20%\"><font color='#043C70' size='2'>Maturity Date</font></th>";
echo "<th bgcolor='#BCA9F5' width=\"5%\"><font color='#043C70' size='2'>Operation</font></th>";
echo"<tr><td colspan=\"7\" align=center><iframe src=\"pf_dis.php?&emp_id=$emp_id&type=bank\" width=\"100%\" height=\"150\" scrollbars=yes, top=100,left=150, width=1098,height=300></iframe>";
echo"</table>";
echo "</form>";
}
//===============================================================selection for post office=========================================================================
if($type=='po' || $t=='po')
{
$emp_id=$_REQUEST['emp_id'];
echo"<form  name='f1' action=\"pf_invst_dtl.php?type=po&op=i&emp_id=$emp_id\" method='post' >";
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
//echo $sql;
header('location:pf_invst_dtl.php?type=po&emp_id='.$emp_id);
}
echo"<table valign=\"top\"width='100%' align='center'>";
echo"<tr><th colspan='4'bgcolor='#839EB8'><font color='#043C70' size='2'>Post Office Investment</font></th></tr>";
echo"<tr><td  bgcolor='#839EB8' colspan=\"4\" height='10%'></td></tr>";
echo"<tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr>";
echo "<tr>";
echo "<td  colspan=\"1\" align='right' width='30%'><font color='black'size='2' >Post Office Name&nbsp;:</td>";
echo"<td width='20%'><input type='text' name='po_name' size='15' $HIGHLIGHT></td>";
echo "<td  colspan=\"1\" align='right' rowspan='2'><font color='black'size='2' >Post Office Details&nbsp;:</td>";
echo"<td valign='bottom'><textarea name='po_dtls' rows='2' cols='15' $HIGHLIGHT></textarea></td>";
echo"</tr>";
echo "<tr>";

echo "<td  colspan=\"1\" align='right'><font color='black' size='2' >Policy Type&nbsp;:</td>";
echo "<td><select name=\"invst\"> <option value=''> Select</option>";
$sql="select distinct(invst_desc) ,upper(invst_desc) as invst_desc from emp_investment_mas where type like 'po'";
$res=dBConnect($sql);
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
//echo $sql;
echo"<option value=".$row['id'].">".$row['invst_desc']."</option>";
}
echo"</select></td></tr>";
echo"<tr>";
echo "<td  colspan=\"1\" align='right'><font color='black'size='2' >Date of Issue&nbsp;:</td>";
echo"<td><input type=\"TEXT\" name=\"dt_iss\" size=\"10\" value=\"".date("d.m.Y")."\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.dt_iss,'dd/mm/yyyy','Choose Date')\" ></td>";
echo "<td  colspan=\"1\" align='right'><font color='black'size='2' >Date of Maturity&nbsp;:</td>";
echo"<td><input type=\"TEXT\" name=\"dt_mtrty\" size=\"10\" value=\"".date("d.m.Y")."\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.dt_mtrty,'dd/mm/yyyy','Choose Date')\" ></td>";
echo"</tr>";
echo"<tr>";
echo "<td  colspan=\"1\" align='right'><font color='black'size='2' >Certificate Registration No.&nbsp;:</td>";
echo"<td><input type='text' name='saving_regno' size='15' $HIGHLIGHT></td>";
echo "<td  colspan=\"1\" align='right'><font color='black'size='2' >Total No. of Certificate&nbsp;:</td>";
echo"<td><input type='text' name='to_n_ct' size='5' $HIGHLIGHT></td>";
echo"<tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr>";
echo"</tr>";
echo"<tr><th colspan='4' bgcolor='#839EB8'><font color='#043C70' size='2' >Post Office Interest Details</font></th></tr><tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr>";
echo "<tr>";
echo "<td align='center'><font color='black' size='2' align='right'>Interest Mode:&nbsp;&nbsp;&nbsp;&nbsp;";
makeSelectmode($inst_array,'inst_mode','');
echo"</td>";
echo "<td  ><font color='black' size='2' align='left'>Total Amount&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;";
echo"<input type='text' name='to_amnt' size='5'$HIGHLIGHT ></td>";
echo "<td  ><font color='black' size='2' align='left'>Interest Rate&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;";
echo"<input type='text' name='int_rt' size='5'$HIGHLIGHT >&nbsp;%</td>";
echo "<td ><font color='black' size='2' align='left'>Interest Amount &nbsp;:&nbsp;&nbsp;&nbsp;";
echo"<input type='text' name='int_amnt' size='5'$HIGHLIGHT ></td>";
echo"</tr>";
echo"<tr><td  bgcolor='#839EB8' colspan=\"4\" height='10%'></td></tr>";
echo"<tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr>";
echo"<tr><td align='center'  colspan='4'><input type='submit' value='Submit'></td></tr>";
echo"</table>";
//.....................//...............//..........................Gridview........//.....................//..............//................//..................
echo"<table width='100%' >";

echo"<tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr>";
echo"<tr><td  bgcolor='#839EB8' colspan=\"7\" height='10%'></td></tr>";
echo"<tr>";
echo "<th bgcolor='#BCA9F5' ><font color='#043C70' size='2'>Registration No.</font></th>";
echo "<th bgcolor='#BCA9F5' ><font color='#043C70' size='2'>Date of Issue</font></th>";
echo "<th bgcolor='#BCA9F5' ><font color='#043C70' size='2'>Total No. of Certificate</font></th>";
echo "<th bgcolor='#BCA9F5' ><font color='#043C70' size='2'>Date of Maturity</font></th>";
echo "<th bgcolor='#BCA9F5' ><font color='#043C70' size='2'>Total Amount</font></th>";
echo "<th bgcolor='#BCA9F5' ><font color='#043C70' size='2'>Add Certificate</font></th>";
echo "<th bgcolor='#BCA9F5' ><font color='#043C70' size='2'>Operation</font></th>";
echo"<tr><td colspan=\"7\" align=center><iframe src=\"pf_dis.php?&emp_id=$emp_id&type=po&saving_regno=$saving_regno\" width=\"100%\" height=\"150\" scrollbars=yes, top=100,left=150, width=1098,height=300></iframe>";
echo "</table>";
echo"</form>";
}
//======================================================================selection for lic===========================================================================
if($type=='lic' || $t=='lic')
{
$emp_id=$_REQUEST['emp_id'];
echo"<form  name='f1' action=\"pf_invst_dtl.php?type=lic&op=i&emp_id=$emp_id\" method='post' >";
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
header('location:list.php?type=lic&emp_id='.$emp_id);
}
echo"<table width='100%' align='center' >";
echo"<tr><th colspan='4'bgcolor='#839EB8'><font color='#043C70' size='2'> LIC Investment</font></th></tr><tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr>";
echo "<tr>";
echo "</table><table width='100%' >";
echo "<td colspan=\"1\"  width='30%' align='right'><font color='black' size='2' align='left'>Policy Number&nbsp;:&nbsp;&nbsp;</td><td width='20%'>";
echo"<input type='text' name='pl_no' size='5'$HIGHLIGHT></td>";

echo"<td width='30%' align='right'><font color='black' size='2' >&nbsp;Policy Details:</td>";
echo"<td rowspan='2' width='20%' ><textarea name='pl_dtl' rows='2' cols='15' $HIGHLIGHT></textarea></td>";
echo"</tr>";
echo "<tr><td width='30%' colspan=\"1\" align='right'><font color='black' size='2' align='left'>Policy Type&nbsp;:&nbsp;&nbsp;</td>";
echo "<td width='20%'><select name=\"invst\"> <option value=''> Select</option>";
$sql="select distinct(invst_desc) ,upper(invst_desc) as invst_desc from emp_investment_mas where type like 'lic'";
$res=dBConnect($sql);
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
//echo $sql;
echo"<option value=".$row['id'].">".$row['invst_desc']."</option>";
}
echo"</select></td></tr>";
echo"<tr><td colspan='3' ><br></td></tr>";
echo"</table><table width='100%'  >";
echo "<td colspan=\"1\" width='30%' align='right'><font color='black'size='2'align='left'>Date Of Commencement&nbsp;:&nbsp;&nbsp;</td><td width='20%'>";
echo"<input type=\"TEXT\" name=\"dt_cmcmt\" size=\"10\" value=\"".date("d.m.Y")."\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.dt_cmcmt,'dd/mm/yyyy','Choose Date')\" >";
echo"</td>";
echo"<td></td>";
echo "<td colspan=\"1\" width='30%' align='right'><font color='black'size='2' align='left'>Date of Maturity&nbsp;:&nbsp;</td><td width='20%'>";
echo"<input type=\"TEXT\" name=\"dt_mtrty\" size=\"10\" value=\"".date("d.m.Y")."\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.dt_mtrty,'dd/mm/yyyy','Choose Date')\" >";
echo"</td>";
echo"</tr>";
echo "<tr>";
echo "<td width='30%' align='right'><font color='black' size='2' align='left'>Branch Code&nbsp;:&nbsp;&nbsp;</td><td width='20%'>";
echo"<input type='text' name='br_cd' size='5'$HIGHLIGHT ></td>";
echo"<td></td>";
echo "<td  width='30%' align='right'><font color='black' size='2' align='left'>&nbsp;&nbsp; Policy Value&nbsp;:&nbsp;&nbsp;</td><td width='20%'>";
echo"<input type='text' name='pl_vl' size='5'$HIGHLIGHT ></td>";
echo"</tr>";
echo"</table><table width='100%' >";
echo"<tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr>";
echo"<tr><td  bgcolor='#839EB8' colspan=\"6\" height='10%'></td></tr>";
echo"<tr><th colspan='6' bgcolor='#839EB8'><font color='#043C70' size='2' >Premium Details</font></th></tr><tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr>";
echo "<tr>";
echo "<td align='right' ><font color='black' size='2' align='left'>Premium Mode:&nbsp;</td><td align='left' >";
makeSelectmode($inst_array,'inst_mode','');
echo"</td>";
echo "<td align='right' ><font color='black' size='2' align='left'>Premium Amount&nbsp;:&nbsp;</td><td align='left'>";
echo"<input type='text' name='pr_amnt' size='5'$HIGHLIGHT ></td>";
echo "<td  align='right'><font color='black' size='2' align='left'>Total No. of Premium&nbsp;:&nbsp;</td><td align='left'>";
echo"<input type='text' name='no_pr' size='5'$HIGHLIGHT ></td>";
echo"</tr>";
echo"<tr><td  bgcolor='#839EB8' colspan=\"6\" height='10%'></td></tr>";
echo"<tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr>";
echo"<tr><td align='center'  colspan='6'><input type='submit' value='Submit'></td></tr>";
echo"</table>";
//................//..................//....................Gridview.......................//...................//....................//...........................
echo"<table width='100%' >";

echo"<tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr>";
echo"<tr><td  bgcolor='#839EB8' colspan=\"8\" height='10%'></td></tr>";
echo"<tr>";
echo "<th bgcolor='#BCA9F5' ><font color='#043C70' width=\"6%\" size='2'>Policy No.</font></th>";
echo "<th bgcolor='#BCA9F5' ><font color='#043C70' width=\"18%\" size='2'>Date of Commencement</font></th>";
echo "<th bgcolor='#BCA9F5' ><font color='#043C70' size='2'>Policy Value</font></th>";
echo "<th bgcolor='#BCA9F5' ><font color='#043C70' width=\"14%\" size='2'>Date of Maturity</font></th>";
echo "<th bgcolor='#BCA9F5' ><font color='#043C70' width=\"12%\" size='2'>Premium Paid</font></th>";
echo "<th bgcolor='#BCA9F5' ><font color='#043C70' width=\"20%\" size='2'>Last Premium Deposit Date</font></th>";
echo "<th bgcolor='#BCA9F5' ><font color='#043C70' width=\"10%\" size='2'>Add Premium</font></th>";
echo "<th bgcolor='#BCA9F5' ><font color='#043C70' width=\"10%\" size='2'>Operation</font></th>";
echo"<tr><td colspan=\"8\" align=center><iframe src=\"pf_dis.php?&emp_id=$emp_id&type=lic\" width=\"100%\" height=\"150\" scrollbars=yes, top=100,left=150, width=1098,height=300></iframe>";


echo "</table>";
echo"</form>";
}
echo "</body>";
?>
