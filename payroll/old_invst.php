<?include "../config/config.php";

function rsPointZerosas($amt){
if(!empty($amt)){
$part=explode('.',$amt);
$size=sizeof($part);
if($size=='1')
$amt=$amt.'.00';}
else
$amt='0.00';

return $amt;
		
			     }
$staff_id=verifyAutho();
$status=$_REQUEST['status'];
$id=$_REQUEST['id'];
$emp_id=$_REQUEST['id'];
$name=$_REQUEST['name'];
$acno=$_REQUEST['acno'];
$op=$_REQUEST['op'];
$c_id=$_REQUEST['c_id'];
$opr=$_REQUEST['opr'];
$type=$_REQUEST['type'];
//echo $op;
$fy=$_SESSION['fy'];
$ri_cer_no_op=$_REQUEST['ri_cer_no_op'];
$ri_ac_no_op=$_REQUEST['ri_ac_no_op'];
$ri_cer_no_op=(empty($op))?$id:$ri_cer_no_op;
$ri_ac_no_op=(empty($op))?$id:$ri_ac_no_op;

$ri_cer_no=$_REQUEST['ri_cer_no'];
$ri_ac_no=$_REQUEST['ri_ac_no'];
//echo $ri_ac_no.$ri_cer_no;

//echo $op;

$amount_deposit=$_REQUEST['amt'];
$period=$_REQUEST['period'];
$opening_date=$_REQUEST['ac_op_dt'];
$account_no='PFRI-'.$ri_ac_no;
$certificate_no='PFRI/'.$ri_cer_no;
if($opr=='i')	{
if($type=='ri'){
$gl_code=getGlCode4Deposit($c_id,'ri');
$val="select count(*) from customer_account where lower(account_no)=lower('$account_no')";
$val_res=dBConnect($val);
$exist=pg_result($val_res,'count');
//echo $val;
if(empty($exist)){
$sql_statement="INSERT INTO customer_account (customer_id,opening_date,account_no, account_type,operation_mode,gl_mas_code,operator_code,entry_time,status,account_flag)values('$c_id','$opening_date',upper('$account_no'),'ri','si','$gl_code','$staff_id',now(),'op','ri');";
}
//echo $sql_statement;
//----------------------------------------------------------------------------------------------------------------------------------------------------------------
$t_id=getTranId();
$sql_statement=$sql_statement."INSERT INTO deposit_info (account_no, certificate_no, account_type, scheme, action_date,date_with_effect ,principal ,period, interest_rate, maturity_amount, maturity_date, sb_account_no,interest_method,operator_code, entry_time) VALUES ('$account_no','$certificate_no', 'ri', 'nm','$opening_date','$opening_date', $amount_deposit,$period,$rate_of_interest,$maturity_amount,'$maturity_date','$acno','qc','$staff_id',CAST('$opening_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
//gl_ledger_hrd
$sql_statement=$sql_statement.";INSERT INTO gl_ledger_hrd (tran_id,type,action_date, certificate_no,fy,operator_code,entry_time)VALUES ('$t_id','ri','$opening_date', '$certificate_no','$fy','$staff_id',CAST('$opening_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP));";
//gl_ledger_dtl
$sql_statement=$sql_statement."INSERT INTO gl_ledger_dtl (tran_id,gl_mas_code,amount,dr_cr, particulars) VALUES ('$t_id','28101',$amount_deposit,'Dr','cash');";//pfsb account gl_code
$sql_statement=$sql_statement."INSERT INTO gl_ledger_dtl (tran_id,account_no,gl_mas_code,amount, dr_cr, particulars) VALUES ('$t_id','$account_no','$gl_code',$amount_deposit,'Cr','cash')";
//--------------------------------------------------------------------------------------------------------------------------------------------------------------
$sql_statement=$sql_statement.";insert into emp_investment_dtl(emp_id  ,customer_id , pf_ac_no ,invst_ac_no ,invst_ac_type ,invst_ac_sub_type ,invst_ac_opening_dt ,invst_certificate_no,invst_amt ,operator_code ,entry_time ) values ($id,'$c_id','$acno','$account_no','ri','ri','$opening_date','$certificate_no','$amount_deposit','$staff_id',CAST('$opening_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
//echo $sql_statement;
$result=dBConnect($sql_statement);

}

if($type=='bank'){
$pac_type='P';
$maturity_amount=$_REQUEST['t_m_amnt'];
$pemp_id=$_REQUEST['id']  ;
$pid_emp_investment_mas=$_REQUEST['invst'] ;
$pdeposit_no=$_REQUEST['de_no'] ;
$pbank_name=$_REQUEST['bnk_name']  ;
$pbank_dtl=$_REQUEST['bnk_dtls'] ;
$pinv_mode=$_REQUEST['prds_in'] ;
$pinv_period=$_REQUEST['period'] ;
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
$mtrty_dt=$row['substr'];
//echo $mtrty_dt;
$sql="select emp_pforgratuity_sb_dtl_save_fnc('$acno','$pac_type',$emp_id,$pid_emp_investment_mas,'$pdeposit_no','$pbank_name','$pbank_dtl','$pinv_mode',$pinv_period,'$pdt_of_issue','$mtrty_dt',$pamount,$maturity_amount,'$pint_mode',$pint_percent,'$pint_amt','$poperator_code','$pentry_time')";
$res=dBConnect($sql);
//echo $sql;
}
if($type=='po'){
$pac_type='P';
$pemp_id=$_REQUEST['id'] ;
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
echo $sql;
$res=dBConnect($sql);
}

if($type=='lic'){

$pac_type='P' ;
$emp_id=$_REQUEST['id'];
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
//echo $sql;
$res=dBConnect($sql);

}
		}

$s="select * from customer_account a,emp_master b where b.emp_id=$id and a.customer_id=b.customer_id and a.account_no like 'PFSB%'";
$r=dBConnect($s);
//echo $s;
$pfr=pg_fetch_array($r,0);
$sql="select * from emp_master where emp_id=$id";
$sql1="select w.pf_ac_no,w.emp_id,w.op_bal,w.pf_dep as dep,coalesce(x.lic_gain,0)+coalesce(y.po_gain,0)+coalesce(z.bn_gain,0)+w.pf_dep as bal  from (select emp_id,pf_ac_no,op_bal,op_bal+total_empl_cont_pf_amt+total_emplee_cont_pf_amt as pf_dep from emp_pf_dtl where emp_id=$id) as w left outer join 
(select a.emp_id,sum(case when a.withdrawl <= 0 then 0 else a.withdrawl-b.pol end)as lic_gain  from ( 
(select emp_id,pol_no,sum(coalesce(withdrawl_amount,0)) as withdrawl from emp_pforgratuity_lic_hdr group by pol_no,emp_id) as a join 
(select emp_id,pol_no,sum(coalesce(tot_amt,0)) as pol from emp_pforgratuity_lic_dtl group by pol_no,emp_id) as b on a.emp_id=b.emp_id and a.pol_no=b.pol_no join (select sum(int_amt) as po_gain,emp_id from emp_pforgratuity_po_hdr group by emp_id) as c on a.emp_id=c.emp_id)
group by a.emp_id) as x on w.emp_id=x.emp_id left outer join 
(select emp_id,sum(coalesce(int_amt,0)) as po_gain from emp_pforgratuity_po_hdr group by emp_id) as y on w.emp_id=y.emp_id left outer join 
(select emp_id,sum(coalesce(int_amt,0)) as bn_gain from emp_pforgratuity_sb_hdr group by emp_id) as z on w.emp_id=z.emp_id;";
$result=dBConnect($sql);
$result1=dBConnect($sql1);
$row=pg_fetch_array($result,0);
$name=ucwords($row['name']);
echo"<input type='hidden' name=\"dob\" id=\"dob\" value=\"".$row['dob']."\">";
$row1=pg_fetch_array($result1,0);
$pf_amnt=$row1['bal'];
$op_bal=$row1['op_bal'];

$c_b="select coalesce(pf_dep,0)+coalesce(po_with,0)-coalesce(po_dep,0)+coalesce(bk_with,0)-coalesce(bk_dep,0)+coalesce(lic_with,0)-coalesce(lic_dep,0)+coalesce(inv_with,0)-coalesce(inv_dep,0) as current_balance from (	
	(select op_bal+total_empl_cont_pf_amt+total_emplee_cont_pf_amt as pf_dep,emp_id from emp_pf_dtl) as a
left outer join
	(select sum(coalesce(withdrawl_amount,0)) as po_with,sum(coalesce(tot_amount,0)) as po_dep ,emp_id from emp_pforgratuity_po_hdr group by emp_id ) as b
on a.emp_id=b.emp_id
left outer join 
	(select sum(coalesce(withdrawl_amount,0)) as bk_with,sum(coalesce(amount,0)) as bk_dep ,emp_id from emp_pforgratuity_sb_hdr group by emp_id) as c 
on a.emp_id=c.emp_id
left outer join 
	(select sum(coalesce(withdrawl_amount,0)) as lic_with,emp_id from emp_pforgratuity_lic_hdr group by emp_id) as d 
on a.emp_id=d.emp_id
left outer join 
	(select sum(coalesce(premium_amount,0)) as lic_dep,emp_id from emp_pforgratuity_lic_dtl group by emp_id) as e 
on a.emp_id=e.emp_id

left outer join 
	(select sum(coalesce(withdrawl_amount,0)) as inv_with,sum(coalesce(invst_amt,0)) as inv_dep ,emp_id  from emp_investment_dtl group by emp_id) as f
on a.emp_id=f.emp_id
							
	) 
where a.emp_id =$id";
//echo $c_b;
$res_b=dBConnect($c_b);
$current_bal=pg_result($res_b,'current_balance');
echo "<head>";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="../JS/themes/base/jquery.ui.all.css">
	<script src="../JS/jquery-1.9.1.js"></script>
	<script src="../JS/ui/jquery.ui.core.js"></script>
	<link rel="stylesheet" type="text/css" href="../JS/jquery.gritter.css" />
	<script type="text/javascript" src="../JS/jquery.gritter.js"></script>
	<script src="../JS/ui/jquery.ui.widget.js"></script>
	<script src="../JS/ui/jquery.ui.tabs.js"></script>
	<script src="../JS/ui/jquery.ui.accordion.js"></script>
	<script src="../JS/ui/jquery-ui-1.10.3.custom.min.js"></script>
<script src="../JS/modernizr.custom.js"></script> 

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
<script type="text/javascript">
$(function() {
		$( ".date" ).datepicker({dateFormat :'yy/mm/dd'});
		$( "#tab").tabs();
	
		});

function validator1(f)
{	var msg='';
			if(f.de_no.value==null || f.de_no.value=='')
		{
			msg+=" Enter Deposit No...\n";
		}
		if(f.inv_dt.value==null || f.inv_dt.value=='')
		{
			msg+=" Enter Investment Date...\n";
		}		
		if(f.bnk_name.value==null || f.bnk_name.value=='')
		{
			msg+=" Enter Bank Name...\n";
		}
		if(f.invst.value==null || f.invst.value=='') {
			msg+=" Select  Investment Type..\n";
		}
		if(f.dp_amnt.value==null || f.dp_amnt.value=='')
		{
			msg+=" Enter Deposit Amount...\n";
		}
		if(f.inst_mode.value==null || f.inst_mode.value=='')
		{
			msg+=" Select Interest Mode...\n";
		}
		if(f.int_rt.value==null || f.int_rt.value=='')
		{
			msg+=" Enter Interest Rate ...\n";
		}
		if(f.int_amnt.value==null || f.int_amnt.value=='')
		{
			msg+=" Enter Interest Amount...\n";
		}
		if(f.t_m_amnt.value==null || f.t_m_amnt.value=='')
		{
			msg+=" Enter Total Maturity Amount...";
		}
		if(msg==''){
			return true;
		}
		else{
			alert(msg);
			return false;
		}
		
}
function validator2(f)
{	var msg='';
		if(f.po_name.value==null || f.po_name.value=='')
		{
			msg+=" Enter Post Office Name...\n";
		}
		if(f.po_dtls.value==null || f.po_dtls.value=='')
		{
			msg+=" Enter Post Office Details...\n";
		}		
		if(f.invst.value==null || f.invst.value=='') {
			msg+=" Select  Investment Type..\n";
		}
		if(f.dt_iss.value==null || f.dt_iss.value=='')
		{
			msg+=" Enter Date of Issue...\n";
		}
		if(f.dt_mtrty.value==null || f.dt_mtrty.value=='')
		{
			msg+=" Enter Date of Maturity...\n";
		}
		if(f.saving_regno.value==null || f.saving_regno.value=='')
		{
			msg+=" Enter Certificate No. ...\n";
		}
		if(f.to_n_ct.value==null || f.to_n_ct.value=='')
		{
			msg+=" Total No. Of Certificates...\n";
		}
		if(f.inst_mode.value==null || f.inst_mode.value=='')
		{
			msg+=" Enter Interest Mode...\n";
		}
		if(f.to_amnt.value==null || f.to_amnt.value=='')
		{
			msg+=" Enter Total  Amount..\n";
		}
		if(f.int_rt.value==null || f.int_rt.value=='')
		{
			msg+=" Enter Interest Rate...\n";
		}
		if(f.int_amnt.value==null || f.int_amnt.value=='')
		{
			msg+=" Enter Interest Amount...\n";
		}
		if(msg==''){
			return true;
		}
		else{
			alert(msg);
			return false;
		}
		
}
function validator3(f)
{	var msg='';
		if(f.pl_no.value==null || f.pl_no.value=='')
		{
			msg+=" Enter Policy No....\n";
		}
		if(f.pl_dtl.value==null || f.pl_dtl.value=='')
		{
			msg+=" Enter Policy Details...\n";
		}
		
		if(f.invst.value==null || f.invst.value=='') {
			msg+=" Select  Policy Type..\n";
		}
		if(f.dt_cmcmt.value==null || f.dt_cmcmt.value=='')
		{
			msg+=" Enter Date of Commencement...\n";
		}
		if(f.dt_mtrty.value==null || f.dt_mtrty.value=='')
		{
			msg+=" Enter Date of Maturity...\n";
		}
		if(f.br_cd.value==null || f.br_cd.value=='')
		{
			msg+=" Enter Branch Code. ...\n";
		}
		if(f.pl_vl.value==null || f.pl_vl.value=='')
		{
			msg+=" Enter policy Value. ...\n";
		}		
		if(f.inst_mode.value==null || f.inst_mode.value=='')
		{
			msg+=" Enter Interest Mode...\n";
		}
		if(f.pr_amnt.value==null || f.pr_amnt.value=='')
		{
			msg+=" Enter Premium  Amount..\n";
		}
		if(f.no_pr.value==null || f.no_pr.value=='')
		{
			msg+=" Enter No. Of Premium...\n";
		}
		if(msg==''){
			return true;
		}
		else{
			alert(msg);
			return false;
		}
		
}				
function numbersonly(e){
	var unicode=e.charCode? e.charCode : e.keyCode;
	if (unicode!=8){ 
		if (unicode<46||unicode>57||unicode==47) {
			return false;		
		}
	}
}
function charonly(e){
	var unicodechar=e.charCode? e.charCode : e.keyCode;
	if (unicodechar!=8){ 
		if (unicodechar<65||unicodechar>122 || unicodechar==96 ||unicodechar==92) {
			if(unicodechar!=32)
			return false;		
		}
	}
	
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
/*
var p=parseInt(document.getElementById('dp_amnt').value);
var i=parseInt(document.getElementById('int_rt').value);
var interest=Math.round((p*i*days)/(100*365.24));
if(i>0){
document.getElementById('int_amnt').value=interest;
document.getElementById('t_m_amnt').value=interest+p;
}
*/

}

</script>
<?echo "<title>
PF DETAILS";
echo "</title>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<script src=\"../JS/loading2.js\"></script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
?>
<script type="text/javascript">

function amt_val(f)
    {
var dep=parseInt(document.getElementById('pf_dep').value,10);
var ri=parseInt(document.getElementById('amt').value,10);
if(dep<ri)
 {
alert("Your deposit Amount is "+dep+" Rs./-\nYou can not withdraw"+ri+" Rs./-");
return false;
 } 
  }
function cer(){
document.getElementById('ri_cer_no_op').value=document.getElementById('ri_ac_no_op').value+"/";


}
function checkdepositno(){
//alert("sec");
var str=document.getElementById("de_no").value;
var url="checkdep.php?dep="+str;
if (window.XMLHttpRequest) 
	{
		xmlhttp=new XMLHttpRequest();
	}
	else		
	{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{	
			if(xmlhttp.responseText==1){document.getElementById("hintSpan1").innerHTML="<font color=green>Deposit No. is OK</font>";
				document.getElementById("sub").disabled=false;}
			else{document.getElementById("hintSpan1").innerHTML=xmlhttp.responseText;
				document.getElementById("sub").disabled=true;}
			
		}
	}
	xmlhttp.open("POST",url,true);
	xmlhttp.send();
}
function checkcertificateno(){
//alert("sec");
var str=document.getElementById("saving_regno").value;
var url="checkcert.php?cert="+str;
if (window.XMLHttpRequest) 
	{
		xmlhttp=new XMLHttpRequest();
	}
	else		
	{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{	
			if(xmlhttp.responseText==1){document.getElementById("hintSpan2").innerHTML="<font color=green>Certificate No. is OK</font>";
				document.getElementById("sub1").disabled=false;}
			else{document.getElementById("hintSpan2").innerHTML=xmlhttp.responseText;
				document.getElementById("sub1").disabled=true;}
			
		}
	}
	xmlhttp.open("POST",url,true);
	xmlhttp.send();
}
function checkpolicyno(){
//alert("sec");
var str=document.getElementById("pl_no").value;
var url="checkpol.php?pol="+str;
if (window.XMLHttpRequest) 
	{
		xmlhttp=new XMLHttpRequest();
	}
	else		
	{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{	
			if(xmlhttp.responseText==1){document.getElementById("hintSpan3").innerHTML="<font color=green>Policy No. is OK</font>";
				document.getElementById("sub2").disabled=false;}
			else{document.getElementById("hintSpan3").innerHTML=xmlhttp.responseText;
				document.getElementById("sub2").disabled=true;}
			
		}
	}
	xmlhttp.open("POST",url,true);
	xmlhttp.send();
}

</script>
</head>
<body bgcolor="#cdcdcd">
	<div id="tab">
<ul>	

		
		<li><a href="#tabs-1">BANK INVESTMENT</a></li>
		
		<li><a href="#tabs-2">PO INVESTMENT</a></li>

		<li><a href="#tabs-3">LIC INVESTMENT</a></li>
		

	</ul>

<div id="tabs-1">
<?

echo"<table valign=\"top\" width='100%' align='center'>";
echo"<tr><th colspan='6' bgcolor='#839EB8'><font color='white' size='2'>Staff Information</font></th></tr>";

echo"<tr><td align='left' width=\"20%\" bgcolor=\"#D3D3D3\" style='height:25px;'> Customer Id</td><td align='left' bgcolor=\"#E6E6FA\" width=\"10%\">$c_id";
echo"<td align='left' width=\"20%\" bgcolor=\"#D3D3D3\"> Employee Id</td><td align='left' bgcolor=\"#E6E6FA\" width=\"10%\">";
echo $id;
echo"</td><td align='left' width=\"20%\" bgcolor=\"#D3D3D3\">Name</td><td align='left' bgcolor=\"#E6E6FA\" width=\"20%\">";
echo $name."</td></tr>";

echo"<tr><td align='left' bgcolor=\"#D3D3D3\" width=\"20%\" style='height:25px;'>PF Savings Ac/No.</td><td bgcolor=\"#E6E6FA\" width=\"10%\">".$pfr['account_no']."</td><td align='left' bgcolor=\"#D3D3D3\" width=\"20%\" >PF Deposit</td><td bgcolor=\"#E6E6FA\" width=\"10%\">$pf_amnt</td><td width='20%' bgcolor=\"#D3D3D3\">Opening Balance</td><td bgcolor=\"#E6E6FA\" width=\"10%\">$op_bal</td></tr>
<tr><td colspan='6' bgcolor='#00B7FF' align='center'>Current PF Depositable : <b><font size='+2' color='white'>".amount2Rs($current_bal)."</font><font size='+2'><I> Rs/=</td></tr></table>";
echo"<hr>";
//=================================================================================================================================================================
echo"<form  name='f1' action=\"pf_invst_dtl.php?type=bank&opr=i&id=$emp_id&c_id=$c_id&acno=$acno\" method='post' onSubmit=\"return validator1(this);\">";
echo"<table valign=\"top\"width='100%' align='center'>";
echo"<tr><th colspan='4'bgcolor='#839EB8'><font color='#043C70' size='2'>Bank Investment</font></th></tr><tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr>";
echo "<tr>";
echo "<td  colspan=\"2\"><font color='black' size='2' align='left'>Investment Type&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<select name=\"invst\" id=\"invst\"> <option value=''> Select</option>";
$sql="select distinct(invst_desc),upper(invst_desc) as invst_desc,id from emp_investment_mas where type like 'bank'";
//echo $sql;
$res=dBConnect($sql);
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);

echo"<option value=".$row['id'].">".$row['invst_desc']."</option>";
}
echo"</select></td>";
echo "<td ><font color='black'size='2' align='left'>Deposit No.&nbsp;:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
echo"<input type='text' name='de_no' id='de_no' size='15' class='s-text' $HIGHLIGHT1 onchange=\"checkdepositno()\"><span id=\"hintSpan1\"></span></td>";
echo "<td ><font color='black'size='2' align='left'>Deposit Date&nbsp;:&nbsp;";
echo"<input type=\"TEXT\" name=\"inv_dt\" size=\"10\" value=\"".date("m/d/Y")."\" id=\"inv_dt\" $HIGHLIGHT1 >";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\"  onclick=\"showCalendar(f1.inv_dt,'mm/dd/yyyy','Choose Date')\" >&nbsp;(mm/dd/yyyy)";
echo"</td>";
echo"</tr>";
echo"<tr>";
echo"<td  colspan=\"2\"><font color='black'size='2' align='left'>Bank Name&nbsp;:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
echo"<input type='text' name='bnk_name' size='15' $HIGHLIGHT1 onkeypress=\"return charonly(event);\"></td>";
echo "<td  colspan=\"1\"><font color='black'size='2' align='left'>Periods in&nbsp;:";


echo 	"<input type=\"radio\" name=\"prds_in\" value=\"m\">Months 
	<input type=\"radio\" name=\"prds_in\" value=\"y\">Years


&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' id='period' name='period' value='' size='5' onChange=\"cal_days(this.form)\" onKeyup=\"cal_days(this.form)\" $HIGHLIGHT1 onkeypress=\"return numbersonly(event);\"></td>";
echo "<td ><font color='black'size='2' align='left'>Maturity Date&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo"<input type=\"TEXT\" name=\"mtr_dt\" size=\"12\" value=\"\" id=\"mtr_dt\" onClick=\"cal_days(this.form)\" onKeyup=\"cal_days(this.form)\" $HIGHLIGHT1 >";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.mtr_dt,'mm/dd/yyyy','Choose Date')\" >";
echo"</td>";
echo "</tr>";
echo "<td  colspan=\"2\"><font color='black'size='2' align='left'>Bank Details&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo"<input type='text' name='bnk_dtls' size='15' $HIGHLIGHT1></td>";
echo "<td  colspan=\"2\"><font color='black'size='2' align='left'>Deposit Amount&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo"<input type='text' name='dp_amnt' id='dp_amnt' size='5' $HIGHLIGHT1 onkeypress=\"return numbersonly(event);\"></td></tr>";
echo"<tr><td  bgcolor='#839EB8' colspan=\"4\" height='10%'></td></tr>";
echo"<tr><th colspan='4'bgcolor='#839EB8'><font color='#043C70' size='2' >Interest Details</font></th></tr><tr><td  colspan='3'></td></tr><tr><td colspan='3'></td></tr><tr><td  colspan='3'></td></tr>";
echo "<tr>";
//echo "<td  colspan=\"2\" align='center'><font color='black'size='2' align='left'>Interest Mode&nbsp;:&nbsp;";
//makeSelectmode($inst_array,'inst_mode','');
echo "<td  colspan=\"2\" align='left'><font color='black'size='2' align='left'>Interest Rate&nbsp;:&nbsp;&nbsp;";
echo"<input type='text' name='int_rt'  id='int_rt' size='3'  onchange=\"cal_days(this.form)\" onkeyup=\"cal_days(this.form) $HIGHLIGHT1 onkeypress=\"return numbersonly(event);\">&nbsp;%</td>";
echo "<td  colspan=\"1\"align='left'><font color='black'size='2' align='left'>Interest Amount&nbsp;:&nbsp;";
echo"<input type='text' name='int_amnt'  id='int_amnt' size='10' $HIGHLIGHT1 onkeypress=\"return numbersonly(event);\"></td>";
echo "<td align='left' ><font color='black' size='2' >Total Maturity Amount&nbsp;:&nbsp;";
echo"<input type='text' name='t_m_amnt' id='t_m_amnt' size='15' $HIGHLIGHT1 onkeypress=\"return numbersonly(event);\"></td>";
echo "</tr>";
echo"<tr><td  bgcolor='#839EB8' colspan=\"4\" height='10%'></td></tr>";
echo"<br>";
echo"</tr>";





echo"<tr><td  bgcolor='#839EB8' colspan=\"4\" height='10%'></td></tr>";
echo"<tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr>";
echo"<tr><td align='center'  colspan='4'><input type='submit' id='sub' value='Submit'></td></tr>";
echo"</table>";

echo "</form>";
//........//.............//......................//...............GriedView..........//.........//...........//..........//.............//........//...............
echo"<table width='100%' border='1'>";
echo"<tr>";
echo "<th bgcolor='#BCA9F5' width=\"10%\"><font color='#043C70' size='2'>Deposit No.</font></th>";
echo "<th bgcolor='#BCA9F5' width=\"15%\"><font color='#043C70' size='2'>Bank Name</font></th>";
echo "<th bgcolor='#BCA9F5' width=\"20%\"><font color='#043C70' size='2'>Deposit Amount</font></th>";
echo "<th bgcolor='#BCA9F5' width=\"15%\"><font color='#043C70' size='2'>Deposit Date</font></th>";
echo "<th bgcolor='#BCA9F5' width=\"15%\"><font color='#043C70' size='2'>Maturity Date</font></th>";
echo "<th bgcolor='#BCA9F5' width=\"10%\"><font color='#043C70' size='2'>Deposit</font></th>";
echo "<th bgcolor='#BCA9F5' width=\"15%\"><font color='#043C70' size='2'>Operation</font></th>";
echo"<tr><td colspan=\"7\" align=center >";
echo "<div style=\"overflow-y:auto;height:100px\">";
echo"<input type='hidden' id=\"type\" value='bank'><input type='hidden' id=\"emp_id\" value='$emp_id'><input type='hidden' id=\"c_id\" value='$c_id'><input type='hidden' id=\"acno\" value='$acno'>";
echo"<table valign=\"top\"width='100%;' align='center' class='report'>";
$sql=" select s.*,m.invst_desc,m.gl_mas_code,case when  dt_of_maturity-current_date <= 0 then 0 
 	 when  dt_of_maturity-current_date < 3 then 1 
 	 else 2 end as cl ,
 	 case when withdrawl_amount is null then 0 else 1 end as mt
 from emp_pforgratuity_sb_hdr s,emp_investment_mas m where s.id_emp_investment_mas=m.id and s.emp_id=$emp_id";
$res=dBConnect($sql);
//echo $sql;
$color==$TCOLOR;
for($j=0;$j<pg_NumRows($res);$j++){
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($res,$j);
$deposit_no=$row['deposit_no'];
if($row['mt']==1){$fcolor='#00C168';
		 $mt=1;}
else {	
	if($row['cl']==0)$fcolor='#FF007E';
	elseif($row['cl']==1){$mat='Pre';$fcolor='#A800FF'; }
	elseif($row['cl']==2){$mat='Pre'; $fcolor='#0085FF';}
	else $fcolor='#004A97';
	$mt=0;}
echo "<tr>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"10%\"><font color='$fcolor' size='2'>".$row['deposit_no']."</font><input type='hidden' class=\"row_id\" value='".$row['id']."'></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"15%\"><font color='$fcolor' size='2'>".$row['bank_name']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"20%\"><font color='$fcolor' size='2'>".$row['deposit_amount']."</font></td>";
$amt+=$row['amount'];
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"15%\"><font color='$fcolor' size='2'>".$row['dt_of_issue']."</font></td>";
echo "<td  bgcolor='$color' align='center'  colspan=\"1\"  width=\"15%\"><font color='$fcolor' size='2'>".$row['dt_of_maturity']."</font></td>" ;
if($row['invst_desc']=='rd' or $row['invst_desc']=='sb')
echo"<td width='10%'><a href=\"../payroll/bank_dep.php?type=".$row['invst_desc']."&gl_mas_code=".$row['gl_mas_code']."&c_id=$c_id&emp_id=$emp_id&deposit_no=$deposit_no\" target=_parent onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=300,left=350, width=500,height=150'); return false;\"><font color='#0085FF' style='bold',style='italics'>Deposit</a></td>";

else echo "<td>Can't Deposit for </td>".$row['invest_desc'];
echo "<td><a href='#' class='popupClass'>Edit</a>";
if($mt==0 ) 
echo"    ||   <a href=\"../payroll/mature_invst.php?type=bn&c_id=$c_id&emp_id=$emp_id&deposit_no=$deposit_no\" target=_parent onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=300,left=350, width=500,height=150'); return false;\"><font color='#0085FF' style='bold',style='italics'>$mat Mature </a>";
echo"</td>"; 
echo"</tr>";
}

echo"</table>";
echo "</div>";
echo"<tr><th colspan='2' width='35%'>Total Deposit !!</th><th width='20%' align='center'>".rsPointZerosas($amt)." Rs./-</th><th colspan='3'></th></tr>";
echo"</td></tr></table>";

//=================================================================================================================================================================
?>
</div>
<div id="tabs-2">
<?
echo"<table valign=\"top\" width='100%' align='center'>";//sas1
echo"<tr><th colspan='6' bgcolor='#839EB8'><font color='white' size='2'>Staff PF Investment</font></th></tr>";

echo"<tr><td align='left' width=\"20%\" bgcolor=\"#D3D3D3\" style='height:25px;'> Customer Id</td><td align='left' bgcolor=\"#E6E6FA\" width=\"10%\">$c_id";
echo"<td align='left' width=\"20%\" bgcolor=\"#D3D3D3\"> Employee Id</td><td align='left' bgcolor=\"#E6E6FA\" width=\"10%\">";
echo $id;
echo"</td><td align='left' width=\"20%\" bgcolor=\"#D3D3D3\">Name</td><td align='left' bgcolor=\"#E6E6FA\" width=\"20%\">";
echo $name."</td></tr>";

echo"<tr><td align='left' bgcolor=\"#D3D3D3\" width=\"20%\" style='height:25px;'>PF Savings Ac/No.</td><td bgcolor=\"#E6E6FA\" width=\"10%\">".$pfr['account_no']."</td><td align='left' bgcolor=\"#D3D3D3\" width=\"20%\" >PF Deposit</td><td bgcolor=\"#E6E6FA\" width=\"10%\">$pf_amnt</td><td width='20%' bgcolor=\"#D3D3D3\">Opening Balance</td><td bgcolor=\"#E6E6FA\" width=\"10%\">$op_bal</td></tr>
<tr><td colspan='6' bgcolor='#00B7FF' align='center'>Current PF Depositable : <b><font size='+2' color='white'>".amount2Rs($current_bal)."</font><font size='+2'><I> Rs/=</td></tr></table>";
echo"<hr>";
echo"<form  name='f2' action=\"pf_invst_dtl.php?type=po&opr=i&id=$emp_id&c_id=$c_id&acno=$acno#tabs-2\" method='post' onSubmit=\"return validator2(this);\">";
echo"<table valign=\"top\"width='100%' align='center'>";
echo"<tr><th colspan='4'bgcolor='#839EB8'><font color='#043C70' size='2'>Post Office Investment</font></th></tr>";
echo"<tr><td  bgcolor='#839EB8' colspan=\"4\" height='10%'></td></tr>";
echo"<tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr>";
echo "<tr>";
echo "<td  colspan=\"1\" align='right' width='30%'><font color='black'size='2' >Post Office Name&nbsp;:</td>";
echo"<td width='20%'><input type='text' name='po_name' size='15' $HIGHLIGHT1 onkeypress=\"return charonly(event);\"></td>";
echo "<td  colspan=\"1\" align='right' rowspan='2'><font color='black'size='2' >Post Office Details&nbsp;:</td>";
echo"<td valign='bottom'><textarea name='po_dtls' rows='2' cols='15' $HIGHLIGHT1></textarea></td>";
echo"</tr>";
echo "<tr>";

echo "<td  colspan=\"1\" align='right'><font color='black' size='2' >Policy Type&nbsp;:</td>";
echo "<td><select name=\"invst\"> <option value=''> Select</option>";
$sql="select distinct(invst_desc) ,upper(invst_desc) as invst_desc,id from emp_investment_mas where type like 'po'";
$res=dBConnect($sql);
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
//echo $sql;
echo"<option value=".$row['id'].">".$row['invst_desc']."</option>";
}
echo"</select></td></tr>";
echo"<tr>";
echo "<td  colspan=\"1\" align='right'><font color='black'size='2' >Date of Issue&nbsp;:</td>";
echo"<td><input type=\"TEXT\" name=\"dt_iss\" size=\"10\" value=\"".date("d.m.Y")."\" $HIGHLIGHT1>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f2.dt_iss,'dd/mm/yyyy','Choose Date')\" ></td>";
echo "<td  colspan=\"1\" align='right'><font color='black'size='2' >Date of Maturity&nbsp;:</td>";
echo"<td><input type=\"TEXT\" name=\"dt_mtrty\" size=\"10\" value=\"".date("d.m.Y")."\" $HIGHLIGHT1>";

echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f2.dt_mtrty,'dd/mm/yyyy','Choose Date')\" ></td>";
echo"</tr>";
echo"<tr>";
echo "<td  colspan=\"1\" align='right'><font color='black'size='2' >Certificate Registration No.&nbsp;:</td>";
echo"<td><input type='text' name='saving_regno' id='saving_regno' size='15' $HIGHLIGHT1 onchange=\"checkcertificateno()\"></td>";
echo "<td  colspan=\"1\" align='right'><font color='black'size='2' >Total No. of Certificate&nbsp;:</td>";
echo"<td><input type='text' name='to_n_ct' size='5' $HIGHLIGHT1 onkeypress=\"return numbersonly(event);\"></td></tr>";
echo"<tr><td colspan='3'  align='center'><span id=\"hintSpan2\"></span></td></tr>";
echo"<tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr>";
echo"<tr><th colspan='4' bgcolor='#839EB8'><font color='#043C70' size='2' >Post Office Interest Details</font></th></tr><tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr>";
echo "<tr>";
echo "<td align='center'><font color='black' size='2' align='right'>Interest Mode:&nbsp;&nbsp;&nbsp;&nbsp;";
makeSelectmode($inst_array,'inst_mode','');
echo"</td>";
echo "<td  ><font color='black' size='2' align='left'>Total Amount&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;";
echo"<input type='text' name='to_amnt' size='5'$HIGHLIGHT1 onkeypress=\"return numbersonly(event);\"></td>";
echo "<td  ><font color='black' size='2' align='left'>Interest Rate&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;";
echo"<input type='text' name='int_rt' size='5'$HIGHLIGHT1 onkeypress=\"return numbersonly(event);\">&nbsp;%</td>";
echo "<td ><font color='black' size='2' align='left'>Interest Amount &nbsp;:&nbsp;&nbsp;&nbsp;";
echo"<input type='text' name='int_amnt' size='5'$HIGHLIGHT1 onkeypress=\"return numbersonly(event);\"></td>";
echo"</tr>";
echo"<tr><td  bgcolor='#839EB8' colspan=\"4\" height='10%'></td></tr>";
echo"<tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr>";
echo"<tr><td align='center'  colspan='4'><input type='submit' id='sub1' value='Submit'></td></tr>";
echo"</table>";
//.....................//...............//..........................Gridview........//.....................//..............//................//..................
echo"<table width='100%' >";

echo"<tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr>";
echo"<tr>";
echo "<th bgcolor='#BCA9F5' ><font color='#043C70' size='2'>Registration No.</font></th>";
echo "<th bgcolor='#BCA9F5' ><font color='#043C70' size='2'>Date of Issue</font></th>";
echo "<th bgcolor='#BCA9F5' ><font color='#043C70' size='2'>Total No. of Certificate</font></th>";
echo "<th bgcolor='#BCA9F5' ><font color='#043C70' size='2'>Date of Maturity</font></th>";
echo "<th bgcolor='#BCA9F5' ><font color='#043C70' size='2'>Total Amount</font></th>";
echo "<th bgcolor='#BCA9F5' ><font color='#043C70' size='2'>Add Certificate</font></th>";
echo "<th bgcolor='#BCA9F5' ><font color='#043C70' size='2'>Operation</font></th></tr>";
echo"<tr><td colspan=\"7\" align=center >";
echo "<div style=\"overflow-y:auto;height:80px\">";
echo"<input type='hidden' id=\"type_po\" value='po'><input type='hidden' id=\"emp_id\" value='$emp_id'><input type='hidden' id=\"c_id\" value='$c_id'><input type='hidden' id=\"acno\" value='$acno'>";
echo"<table valign=\"top\"width='100%;' align='center' class='report'>";
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
$sql=" select p.*,case when  dt_of_maturity-current_date <= 0 then 0 
 	 when  dt_of_maturity-current_date < 3 then 1 
 	 else 2 end as cl ,
 	 case when withdrawl_amount is null then 0 else 1 end as mt
 from emp_pforgratuity_po_hdr p where p.emp_id=$emp_id";
$res=dBConnect($sql);
//echo $sql;
$color==$TCOLOR;
for($j=0;$j<pg_NumRows($res);$j++){
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($res,$j);
$saving_regno=$row['saving_regno'];
if($row['mt']==1){$fcolor='#00C168';
		 $cer='Show Certificate';
		 $mt=1;}
else {	
	if($row['cl']==0)$fcolor='#FF007E';
	elseif($row['cl']==1)$fcolor='#A800FF'; 
	else $fcolor='#004A97';
	$cer='Add Certificate';
	$mt=0;}
echo "<tr style=\"color:$fcolor\">";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"75\"><font color='$fcolor' size='2'>".$row['saving_regno']."</font><input type='hidden' class=\"row_id_po\" value='".$row['id']."'><input type='hidden' class=\"reg_no\" value='".$row['saving_regno']."'></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"35\"><font color='$fcolor' size='2'>".$row['dt_of_issue']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"125\"><font color='$fcolor' size='2'>".$row['tot_no_of_cerf']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"85\"><font color='$fcolor' size='2'>".$row['dt_of_maturity']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"70\"><font color='$fcolor' size='2'>".$row['tot_amount']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"75\"><a href=\"../payroll/post_off_cert.php?&emp_id=$emp_id&saving_regno=$saving_regno&mt=$mt\" target=_parent onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=300,left=350, width=900,height=400'); return false;\"><font color='darkblue' style='bold',style='italics'><em>$cer</em></font></td>";
echo "<td width=\"10%\"><a href='#' class='popupClasspo'>Edit</a>";
if($mt==0) 
echo"    ||   <a href=\"../payroll/mature_invst.php?type=po&c_id=$c_id&emp_id=$emp_id&saving_regno=$saving_regno\" target=_parent onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=300,left=350, width=500,height=150'); return false;\"><font color='#0085FF' style='bold',style='italics'>Mature </a>";
echo"</td>";
echo"</tr>";
}
echo"</table>";



//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
echo "</td></tr></table>";
echo"</form>";
?>
</div>

<div id="tabs-3">
<?
echo"<table valign=\"top\" width='100%' align='center'>";//sas1
echo"<tr><th colspan='6' bgcolor='#839EB8'><font color='white' size='2'>Staff PF Investment</font></th></tr>";

echo"<tr><td align='left' width=\"20%\" bgcolor=\"#D3D3D3\" style='height:25px;'> Customer Id</td><td align='left' bgcolor=\"#E6E6FA\" width=\"10%\">$c_id";
echo"<td align='left' width=\"20%\" bgcolor=\"#D3D3D3\"> Employee Id</td><td align='left' bgcolor=\"#E6E6FA\" width=\"10%\">";
echo $id;
echo"</td><td align='left' width=\"20%\" bgcolor=\"#D3D3D3\">Name</td><td align='left' bgcolor=\"#E6E6FA\" width=\"20%\">";
echo $name."</td></tr>";

echo"<tr><td align='left' bgcolor=\"#D3D3D3\" width=\"20%\" style='height:25px;'>PF Savings Ac/No.</td><td bgcolor=\"#E6E6FA\" width=\"10%\">".$pfr['account_no']."</td><td align='left' bgcolor=\"#D3D3D3\" width=\"20%\" >PF Deposit</td><td bgcolor=\"#E6E6FA\" width=\"10%\">$pf_amnt</td><td width='20%' bgcolor=\"#D3D3D3\">Opening Balance</td><td bgcolor=\"#E6E6FA\" width=\"10%\">$op_bal</td></tr>
<tr><td colspan='6' bgcolor='#00B7FF' align='center'>Current PF Depositable : <b><font size='+2' color='white'>".amount2Rs($current_bal)."</font><font size='+2'><I> Rs/=</td></tr></table>";
echo"<hr>";
echo"<form  name='f3' action=\"pf_invst_dtl.php?type=lic&opr=i&id=$emp_id&c_id=$c_id&acno=$acno#tabs-3\" method='post' onSubmit=\"return validator3(this);\">";
echo"<table width='100%' align='center' >";
echo"<tr><th colspan='4'bgcolor='#839EB8'><font color='#043C70' size='2'> LIC Investment</font></th></tr><tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr>";
echo "<tr>";
echo "</table><table width='100%' >";
echo "<tr><td colspan=\"1\"  width='30%' align='right'><font color='black' size='2' align='left'>Policy Number&nbsp;:&nbsp;&nbsp;</td><td width='20%'>";
echo"<input type='text' name='pl_no' id='pl_no' size='5'$HIGHLIGHT1 onchange=\"checkpolicyno()\"><br><span id=\"hintSpan3\"></span></td>";

echo"<td width='30%' align='right'><font color='black' size='2' >&nbsp;Policy Details:</td>";
echo"<td rowspan='2' width='20%' ><textarea name='pl_dtl' rows='2' cols='15' $HIGHLIGHT1></textarea></td>";
echo"</tr>";
echo "<tr><td width='30%' colspan=\"1\" align='right'><font color='black' size='2' align='left'>Policy Type&nbsp;:&nbsp;&nbsp;</td>";
echo "<td width='20%'><select name=\"invst\"> <option value=''> Select</option>";
$sql="select distinct(invst_desc) ,upper(invst_desc) as invst_desc,id from emp_investment_mas where type like 'lic'";
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
echo"<input type=\"TEXT\" name=\"dt_cmcmt\" size=\"10\" value=\"".date("d.m.Y")."\" $HIGHLIGHT1>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f3.dt_cmcmt,'dd/mm/yyyy','Choose Date')\" >";
echo"</td>";
echo"<td></td>";
echo "<td colspan=\"1\" width='30%' align='right'><font color='black'size='2' align='left'>Date of Maturity&nbsp;:&nbsp;</td><td width='20%'>";
echo"<input type=\"TEXT\" name=\"dt_mtrty\" size=\"10\" value=\"".date("d.m.Y")."\" $HIGHLIGHT1>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f3.dt_mtrty,'dd/mm/yyyy','Choose Date')\" >";
echo"</td>";
echo"</tr>";
echo "<tr>";
echo "<td width='30%' align='right'><font color='black' size='2' align='left'>Branch Code&nbsp;:&nbsp;&nbsp;</td><td width='20%'>";
echo"<input type='text' name='br_cd' size='5'$HIGHLIGHT1 ></td>";
echo"<td></td>";
echo "<td  width='30%' align='right'><font color='black' size='2' align='left'>&nbsp;&nbsp; Policy Value&nbsp;:&nbsp;&nbsp;</td><td width='20%'>";
echo"<input type='text' name='pl_vl' size='5'$HIGHLIGHT1 ></td>";
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
echo"<input type='text' name='pr_amnt' size='5'$HIGHLIGHT1 ></td>";
echo "<td  align='right'><font color='black' size='2' align='left'>Total No. of Premium&nbsp;:&nbsp;</td><td align='left'>";
echo"<input type='text' name='no_pr' size='5'$HIGHLIGHT1 ></td>";
echo"</tr>";
echo"<tr><td  bgcolor='#839EB8' colspan=\"6\" height='10%'></td></tr>";
echo"<tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr>";
echo"<tr><td align='center'  colspan='6'><input type='submit' id='sub2' value='Submit'></td></tr>";
echo"</table>";
echo"</form>";
//................//..................//....................Gridview.......................//...................//....................//...........................
echo"<table width='100%' >";

echo"<tr><td  colspan='3'></td></tr><tr><td  colspan='3'></td></tr>";
//echo"<tr><td  bgcolor='#839EB8' colspan=\"8\" height='10%'></td></tr>";
echo"<tr>";
echo "<th bgcolor='#BCA9F5' width=\"6%\"><font color='#043C70'  size='2'>Policy No.</font></th>";
echo "<th bgcolor='#BCA9F5' width=\"14%\"><font color='#043C70'  size='2'>Date of Commencement</font></th>";
echo "<th bgcolor='#BCA9F5' width=\"15%\"><font color='#043C70' size='2'>Policy Value</font></th>";
echo "<th bgcolor='#BCA9F5' width=\"15%\"><font color='#043C70' size='2'>Date of Maturity</font></th>";
echo "<th bgcolor='#BCA9F5' width=\"10%\"><font color='#043C70' size='2'>Premium Paid</font></th>";
echo "<th bgcolor='#BCA9F5' width=\"10%\"><font color='#043C70'  size='2'>Last Premium Deposit Date</font></th>";
echo "<th bgcolor='#BCA9F5' width=\"10%\"><font color='#043C70'  size='2'>Add Premium</font></th>";
echo "<th bgcolor='#BCA9F5' width=\"20%\"><font color='#043C70' size='2'>Operation</font></th>";
echo"<tr><td colspan=\"8\" align=center>";
//echo"<iframe src=\"pf_dis.php?&emp_id=$emp_id&type=lic\" width=\"100%\" height=\"100\" scrollbars=yes, top=100,left=150, width=1098,height=300></iframe>";
echo "<div style=\"overflow-y:auto;height:100px\">";
echo"<input type='hidden' id=\"emp_id\" value='$emp_id'><input type='hidden' id=\"c_id\" value='$c_id'><input type='hidden' id=\"acno\" value='$acno'>";
echo"<table valign=\"top\"width='100%;' align='center' class='report'>";
//
$sql="select l.*,case when  dt_of_maturity-current_date <= 0 then 0 
  when  dt_of_maturity-current_date < 3 then 1 
  else 2 end as cl ,
  case when withdrawl_amount is null then 0 else 1 end as mt
 from emp_pforgratuity_lic_hdr l where l.emp_id=$emp_id;";
$res=dBConnect($sql);
//echo $sql;
$color==$TCOLOR;
for($j=0;$j<pg_NumRows($res);$j++){
$mat='';
//$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($res,$j);
$pol_no=$row['pol_no'];

if($row['mt']==1){$fcolor='#00C168';
		 $cer='Show Premium';
		 $mt=1;}
else {	
	if($row['cl']==0)$fcolor='#FF007E';
	elseif($row['cl']==1)$fcolor='#A800FF'; 
	elseif($row['cl']==2){$mat='Pre'; $fcolor='#0085FF';}
	else $fcolor='#004A97';
	$cer='Add Premium';
	$mt=0;}
echo "<tr>";
$sql1="select max(rcpt_date),sum(premium_amount) from emp_pforgratuity_lic_dtl where pol_no='$pol_no' and emp_id=$emp_id";
$res1=dBConnect($sql1);
$row3=pg_fetch_array($res1,0);
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"6%\"><font color='$fcolor' size='2'>".$row['pol_no']."</font><input type='hidden' class=\"row_id_lic\" value='".$row['id']."'><input type='hidden' class=\"pol_no\" value='".$row['pol_no']."'></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"14%\"><font color='$fcolor' size='2'>".$row['dt_of_commencement']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"15%\"><font color='$fcolor' size='2'>".$row['pol_val']."</font></td>";
echo "<td  bgcolor='$color' align='center'  colspan=\"1\"  width=\"15%\"><font color='$fcolor' size='2'>".$row['dt_of_maturity']."</font></td>" ;
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"10%\"><font color='$fcolor' size='2'>".$row3['sum']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"10%\"><font color='$fcolor' size='2'>".$row3['max']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"10%\"><a href=\"../payroll/lic_pre.php?&emp_id=$emp_id&pol_no=$pol_no\" target=_parent onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=150,left=350, width=1000,height=800'); return false;\"><font bgcolor='darkblue' style='bold'><em>Add Premium</em></font></td>";
echo "<td width=\"20%\" align='center'><a href='#' class='popupClasslic'>Edit</a>";
if($mt==0) 
echo"||   <a href=\"../payroll/mature_invst.php?type=lic&c_id=$c_id&emp_id=$emp_id&pol_no=$pol_no\" target=_parent onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=300,left=350, width=500,height=150'); return false;\"><font color='#0085FF' style='bold',style='italics'>$mat Mature </a>";
echo"</td>";
echo"</tr>";
}

echo"</table>";
echo "</td></tr></table>";


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
?>

<div id="dialog" style="display:none">
</div>
<SCRIPT>
$(document).ready(function(){
$("body .popupClass").delegate($(".popupClass"),'click',function(){
var id=$(this.parentNode.parentNode).find(".row_id").val();
//var id=2;
var emp_id=$("#emp_id").val();
var type=$("#type").val();
var c_id=$("#c_id").val();
var acno=$("#acno").val();
var url1="./pf_bnk_edit.php?id="+id+"&emp_id="+emp_id+"&type="+type+"&c_id="+c_id+"&acno="+acno;
	if (window.XMLHttpRequest) 
	{xmlhttp=new XMLHttpRequest();
	}
	else
	{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			$("#dialog").html(xmlhttp.responseText);
			return true;
		}
	}
	xmlhttp.open("POST",url1,true);
	xmlhttp.send();
	$("#dialog").html("<img src='ajax-loader.gif' alt='loading.......'>");
	$("#dialog").dialog({	
		modal: true,
		autOpen:false,
		resizable:false,
		draggable:false,
		title:"Bank Investment Modification:",
		width:'900px',
		
	});
});
});


$(document).ready(function(){
$("body .popupClasspo").delegate($(".popupClasspo"),'click',function(){
var id=$(this.parentNode.parentNode).find(".row_id_po").val();
var reg_no=$(this.parentNode.parentNode).find(".reg_no").val();
//var id=2;
var emp_id=$("#emp_id").val();
var type="po";
//alert(type)
var c_id=$("#c_id").val();
var acno=$("#acno").val();
var url1="./pf_bnk_edit.php?id="+id+"&emp_id="+emp_id+"&type="+type+"&c_id="+c_id+"&acno="+acno+"&saving_regno="+reg_no;
	if (window.XMLHttpRequest) 
	{xmlhttp=new XMLHttpRequest();
	}
	else
	{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			$("#dialog").html(xmlhttp.responseText);
			return true;
		}
	}
	xmlhttp.open("POST",url1,true);
	xmlhttp.send();
	$("#dialog").html("<img src='ajax-loader.gif' alt='loading.......'>");
	$("#dialog").dialog({	
		modal: true,
		autOpen:false,
		resizable:false,
		draggable:true,
		title:"Post Office Investment Modification",
		width:'900px',
		
	});
});
});



$(document).ready(function(){
$("body .popupClasslic").delegate($(".popupClasslic"),'click',function(){
var id=$(this.parentNode.parentNode).find(".row_id_lic").val();
var pol_no=$(this.parentNode.parentNode).find(".pol_no").val();
//var id=2;
var emp_id=$("#emp_id").val();
var type="lic";
//alert(type)
var c_id=$("#c_id").val();
var acno=$("#acno").val();
var url1="./pf_bnk_edit.php?id="+id+"&emp_id="+emp_id+"&type="+type+"&c_id="+c_id+"&acno="+acno+"&pol_no="+pol_no;
	if (window.XMLHttpRequest) 
	{xmlhttp=new XMLHttpRequest();
	}
	else
	{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			$("#dialog").html(xmlhttp.responseText);
			return true;
		}
	}
	xmlhttp.open("POST",url1,true);
	xmlhttp.send();
	$("#dialog").html("<img src='ajax-loader.gif' alt='loading.......'>");
	$("#dialog").dialog({	
		modal: true,
		autOpen:false,
		resizable:false,
		draggable:true,
		title:"LIC Investment Modification for Policy Number : "+pol_no,
		width:'900px',
		
	});
});
});
</SCRIPT>
</body>
</html>
