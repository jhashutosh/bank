<?
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$account_no=$_REQUEST['account_no'];
$account_type=$_REQUEST['account_type'];
$type_of=$_REQUEST['type_of'];
$bank_name=$_REQUEST['bank_name'];
$branch_name=$_REQUEST['branch_name'];
$certifiacate_no=$_REQUEST['cer_no'];
$op_date=$_REQUEST['op_date'];
$remarks=$_REQUEST['remarks'];
$period=$_REQUEST["period"];
echo "<html>";
echo "<head>";
echo "<script src=\"../JS/loading1.js\"></script>";
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";
echo "<title>Investment";
echo "</title>";
?>
<SCRIPT LANGUAGE="JavaScript">
function onCheck(){
	if(str.length==0){
		alert("You Should select First")
	}
	else{
		if(str=="ln"){
			alert(str)
			document.form1.gl_code.disabled=false;
		
			}
		
	}
}
function f1(){
showHint(str);
}
function f2(str){
if(str=='po'){
//alert(str);
document.form1.ac_type.disabled=false;
}
else{
document.form1.ac_type.disabled=true;
}
document.form1.gl_code.disabled=true;
}
function f3(str){
if(str=='cash'){
document.form1.ch_no.value=0;
document.form1.ch_no.disabled=true;
document.form1.bank_ac_no.disabled=true;
document.form1.rm.focus();
}
if(str=='ch'){
document.form1.ch_no.disabled=false;
document.form1.bank_ac_no.disabled=false;
document.form1.ch_no.value='';
document.form1.ch_no.focus();
}
if(str=='trf'){
document.form1.ch_no.value=0;
document.form1.ch_no.disabled=true;
document.form1.bank_ac_no.disabled=false;
document.form1.bank_ac_no.focus();
}
if(str=='dft'){
document.form1.ch_no.disabled=false;
document.form1.bank_ac_no.disabled=true;
document.form1.ch_no.value='';
document.form1.ch_no.focus();
}
if(str.length==0){
document.form1.ch_no.value=0;
document.form1.ch_no.disabled=true;
document.form1.bank_ac_no.disabled=true;
}
}
</script>
<?
//--------------------------------------------------------------------------------------------
//-------------------INSERT
if($_REQUEST['o']=='i'){
$maturity_date=$_REQUEST['mat_dt'];
$period=$_REQUEST["period"];
echo $period;
$maturity_amount=$_REQUEST['mat_amt'];
$interest_rate=$_REQUEST['int_rate'];
$m_principal=$_REQUEST['m_principal'];

$t_principal=$_REQUEST['t_principal'];
$m_amount=$_REQUEST['m_amount'];
$interest=$_REQUEST['interest'];

$ch_no=$_REQUEST['ch_no'];
$payment_term=$_REQUEST['p_mode'];
$bank_account_no=$_REQUEST['bank_ac_no'];
$bk_gl_code=getGlCode4mBank($bank_account_no);

//$type_of=getIndex($source_type_array,$type_of);
if($type_of=='po' && $account_type=='oth'){
$account_type=(empty($_REQUEST['ac_type']))?$account_type:strtolower($_REQUEST['account_type1']);
}
$gl_code=getData(trim($_REQUEST['gl_code']));
//$fy=getFy($op_date);
$fy=$_SESSION['fy'];
if(empty($fy)){
echo "<h1><center><b>You Can't Insert any value Into database Because Financial Year already Locked by administrator !!!!!!!!!";
}
else{
//bank_bk_dtl 



if($type_of=='ccb')
{
$sql_statement="INSERT INTO bank_bk_dtl(link_tb,account_no,account_type,b_type,b_name,br_name, op_date,gl_code,status,remarks,operator_code,entry_time,account_sub_type) VALUES('1','$account_no', '$account_type','$type_of','$bank_name','$branch_name','$op_date','22401','op','$remarks', '$staff_id',CAST('$op_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP),'$account_type')";
//deposit_info
//$maturity_amount1=$principal*$period;
$sql_statement.=";INSERT INTO deposit_info(account_no,certificate_no,account_type,action_date, principal,maturity_amount,withdrawal_interest,period,interest_rate,maturity_date,operator_code,entry_time) VALUES('$account_no','$certifiacate_no','$account_type','$op_date',$principal,$m_amount,$interest,$period,$interest_rate, '$maturity_date','$staff_id',CAST('$op_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))"; 
//gl_ledger_hrd
$t_id=getTranId();
$vou_type='c-'.$account_type;
$sql_statement.=";INSERT INTO gl_ledger_hrd (tran_id,type,action_date, certificate_no,fy,cheque_no,cheque_dt,operator_code,entry_time)VALUES ('$t_id','$vou_type','$op_date','$certifiacate_no','$fy','$ch_no','$op_date','$staff_id', CAST('$op_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
//gl_ledger_dtl
$sql_statement.=";INSERT INTO gl_ledger_dtl (tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES ('$t_id','$account_no', '22401',$principal,'Dr','$payment_term')";
if($payment_term=='cash'){
$sql_statement.=";INSERT INTO gl_ledger_dtl (tran_id,gl_mas_code,amount,dr_cr, particulars) VALUES ('$t_id','28101',$principal,'Cr','$payment_term')";
}else{
$sql_statement.=";INSERT INTO gl_ledger_dtl (tran_id,gl_mas_code,account_no,amount,dr_cr, particulars)VALUES ('$t_id','22401','$bank_account_no',$principal,'Cr','$payment_term')";
}
}


if($type_of=='oth')
{
$sql_statement="INSERT INTO bank_bk_dtl(link_tb,account_no,account_type,b_type,b_name,br_name, op_date,gl_code,status,remarks,operator_code,entry_time,account_sub_type) VALUES('1','$account_no', '$account_type','$type_of','$bank_name','$branch_name','$op_date','22501','op','$remarks', '$staff_id',CAST('$op_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP),'$account_type')";
//deposit_info
//$maturity_amount1=$principal*$period;
$sql_statement.=";INSERT INTO deposit_info(account_no,certificate_no,account_type,action_date, principal,maturity_amount,withdrawal_interest,period,interest_rate,maturity_date,operator_code,entry_time) VALUES('$account_no','$certifiacate_no','$account_type','$op_date',$principal,$m_amount,$interest,$period,$interest_rate, '$maturity_date','$staff_id',CAST('$op_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))"; 
//gl_ledger_hrd
$t_id=getTranId();
$vou_type='c-'.$account_type;
$sql_statement.=";INSERT INTO gl_ledger_hrd (tran_id,type,action_date, certificate_no,fy,cheque_no,cheque_dt,operator_code,entry_time)VALUES ('$t_id','$vou_type','$op_date','$certifiacate_no','$fy','$ch_no','$op_date','$staff_id', CAST('$op_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
//gl_ledger_dtl
$sql_statement.=";INSERT INTO gl_ledger_dtl (tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES ('$t_id','$account_no', '22501',$principal,'Dr','$payment_term')";
if($payment_term=='cash'){
$sql_statement.=";INSERT INTO gl_ledger_dtl (tran_id,gl_mas_code,amount,dr_cr, particulars) VALUES ('$t_id','28101',$principal,'Cr','$payment_term')";
}else{
$sql_statement.=";INSERT INTO gl_ledger_dtl (tran_id,gl_mas_code,account_no,amount,dr_cr, particulars)VALUES ('$t_id','22501','$bank_account_no',$principal,'Cr','$payment_term')";
}
}



//echo $sql_statement;
$result=dBConnect($sql_statement);
//if(pg_affected_rows($result)<1){echo "<h3><font color=\"RED\">Failed to insert data into database.</font></h3>";

if(pg_affected_rows($result)<1) {
	echo "<br><h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
	} 
else {
       header("location:../investment/bk_investment_rd.php");

	} 


    }
}








echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\"/>";
echo "</head>";
echo "</html>";
?>
