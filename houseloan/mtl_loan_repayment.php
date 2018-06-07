<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$op=$_REQUEST['op'];
$ln_sl=$_REQUEST['ln_sl'];
$action_date=$_REQUEST['action_date'];
$im=$_REQUEST['im'];
if(empty($_REQUEST['account_no'])){
	$account_no=$_SESSION["current_account_no"];
	}
	
else{
	$account_no=$_REQUEST['account_no'];
	$_SESSION["current_account_no"]=$account_no;
	}
if(empty($action_date)){$action_date=date('d.m.Y');}
$sql_statement="truncate table loan_cal_int;SELECT getloaninterest_ram_ag_hb_car_pcl_cc('$account_no','$action_date','hb') as int";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_result($result,'int')==1){$iflag=true;}
$id=getCustomerId($account_no,$menu);
echo "<html>";
echo "<head>";
echo "<title>House Loan Details </title>";
echo "<script src=\"../JS/loading2.js\"></script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script src=\"../JS/validation.js\"></script>";
?>
<link rel="stylesheet" href="../retail/css/retail.css">
<SCRIPT LANGUAGE="JavaScript">
function f2(str,ac_no,menu){
//alert(str);
if(str=='ch'){
gethousehintrepay(str,ac_no,menu);
//alert(str+ac_no+menu);
}
}

function get(f){
var a=document.getElementById("chq_no").value;
var b=document.getElementById("bnk").value;
document.getElementById("bnk_get").value=b;
document.getElementById("chq_no_get").value=a;
}

function findAccount(){
var str=document.getElementById("sb_ac").value;
if(str.length==0)
{
alert("Please enter introducer account no.")
document.form.sb_ac.disabled=false;
document.form.sb_ac.readonly=false;
document.form.sb_ac.focus();
}
else
{
url="../main/pop_up_account.php?menu=sb&account_no="+str;
window.open(url,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150,width=1050,height=500');
return false;
}
}
function cr_chk(e)
{
//alert(str);

	var t_due_prin=parseInt(document.getElementById('total_d').value);
	var r_due_prin=parseInt(document.getElementById('amount').value);
	
	var re_due_prin=document.getElementById('amount').value.length;
	
	if(t_due_prin<r_due_prin)
	{
		alert('Recovery Amount Exceeds Total Amount')
		document.getElementById("amount").value='';
		document.getElementById("amount").focus();
		return false;
	}

	if(re_due_prin=='0')
	{
		alert("Recovery Amount Should Not Be Blank !!!!");
		document.getElementById("amount").focus();
		return false;
	}
	
}
function Result(str)
{
//alert(str)
if (str=='y')
	{
		document.getElementById("y").style.display='';
	}
	else
	{
		document.getElementById("y").style.display='none';
	}
}

function check(e)
{
	var r_prin=document.getElementById("d_principal").value;
	var due_int=document.getElementById("d_int").value;
	var od_due_int=document.getElementById("od_int").value;
	var tot=(parseFloat(r_prin)+parseFloat(due_int)+parseFloat(od_due_int));
	document.getElementById("total_d").value=tot;
//alert(due_int);
//alert(r_prin);
//alert("tatal"+tot);
//alert("tatal"+tot)
}
</SCRIPT>
<?php
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"amount.focus();\">";
if(empty($_REQUEST['im'])){
$flag=getGeneralInfo_Customer($id);}
else $flag=1;
if($flag==1){
if(empty($_REQUEST['im'])){
echo "<hr>";}
//==========================DISPLAY HERE ======================================================
if(empty($op)){
 if(isOpenLoan($account_no)){
echo "<table algin=CENTER width=\"100%\">";
$sql_statement="SELECT * FROM loan_cal_int where account_no='$account_no'";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
	$color="GREEN";
	echo "<tr><th bgcolor=YELLOW colspan=\"9\">House-Loan Details of [$account_no] as on ".date('d.m.Y')."</th>";
	echo "<tr>";
	echo "<th bgcolor=$color Rowspan=\"2\">Loan <br>Serial No</th>";
	echo "<th bgcolor=$color Rowspan=\"2\">Name</th>";
	//echo "<th bgcolor=$color Rowspan=\"2\">Crop<br>Name</th>";
	echo "<th bgcolor=$color Rowspan=\"2\">Days</th>";
	echo "<th bgcolor=$color Rowspan=\"2\">Principal<br>(Rs.)</th>";
	echo "<th bgcolor=$color colspan=\"2\">Interest</th>";
	echo "<th bgcolor=$color Rowspan=\"2\">Total<br>(Rs.)</th>";
	echo "<th bgcolor=$color Rowspan=\"2\">Operation</th>";
	echo "<tr><th bgcolor=$color>Due</th>";
	echo "<th bgcolor=$color >Overdue</th>";
	for($j=0; $j<pg_NumRows($result); $j++){
	echo "<tr>";
	$row=pg_fetch_array($result,$j);
	if($row['status']=='o'){
	$color="#DC143C";
	}
	else{
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	}
	
	$loan_sl_no=$row['loan_serial_no'];
	echo "<td bgcolor=$color align=center> $loan_sl_no";
	echo "<td align=center bgcolor=$color>".getName('customer_id',$id,'name1','customer_master')."</td>";
	$c_id=$row['crop_id'];
	//echo "<td align=center bgcolor=$color>".getName('crop_id',$c_id,'crop_desc','crop_mas')."</td>";
	echo "<td align=center bgcolor=$color>".$row['days']."</td>";
	echo "<td align=right bgcolor=$color>".(float)$row['principal']."</td>";
	echo "<td align=right bgcolor=$color>".$row['due_int']."</td>";
	echo "<td align=right bgcolor=$color>".$row['overdue_int']."</td>";
	echo "<td align=right bgcolor=$color>".($row['principal']+$row['due_int']+$row['overdue_int'])."</td>";
	echo "<td align=Center bgcolor=$color><a href=\"mtl_loan_repayment.php?menu=$menu&ln_sl=$loan_sl_no&op=r&action_date=$action_date\">Repay</td>";

	}
}
else{
 echo "<h1><center>Your dont have any House-Loan!!!!!!!!!!!</h1></center>";
    }
  }
else{
 echo "<h1><font color=RED><center>Your dont have any House-Loan for Payment!!!!!!!!!!!</h1></center>";
    }
}
//==================================FOR REPAY FORM=========================================
if($op=='r'){
$sql_statement="SELECT * FROM loan_cal_int where account_no='$account_no' AND loan_serial_no='$ln_sl'";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$crop_id=pg_result($result,'crop_id');
$principal=(float)pg_result($result,'principal');
$days=pg_result($result,'days');
$due_i=pg_result($result,'due_int');
$odue_i=pg_result($result,'overdue_int');
echo "<table bgcolor=\"#F5F5DC\" width=\"80%\" align=\"CENTER\">";
echo "<tr><th bgcolor=\"#808000\" colspan=\"4\"><font size=+2>House-Loan Repayment Form of [$account_no]</font>";
echo "<FORM NAME=\"pForm\" method=\"POST\" action=\"mtl_loan_repayment.php?menu=$menu&op=i&ln_sl=$ln_sl\" onSubmit=\"return cr_chk(this.form);\">";
echo "<tr><td> Account No:<td><INPUT TYPE=\"TEXT\" VALUE=\"$account_no\" $HIGHLIGHT size=\"15\" readonly>";
echo "<td>Date:<td><INPUT NAME=\"action_date\" TYPE=\"TEXT\" VALUE=\"".$action_date."\" $HIGHLIGHT size=\"12\" readonly>";
echo "<tr><td colspan=\"2\"><b>RECOVERY:</b><td colspan=\"2\"><b>DUE:</b>";
recoverDetails($ln_sl,$p,$d,$o);
if(empty($p))$p=0;
if(empty($d))$d=0;
if(empty($o))$o=0;
echo "<tr><td>Principal :<td>Rs.&nbsp;<INPUT NAME=\"r_principal\" TYPE=\"TEXT\" VALUE=\"$p\" $HIGHLIGHT size=10 READONLY>";
echo "<td>Principal :<td>Rs.&nbsp;<INPUT NAME=\"d_principal\" id=\"d_principal\" TYPE=\"TEXT\" VALUE=\"$principal\" $HIGHLIGHT size=10 onchange=\"return check(event)\"READONLY>";
echo "<tr><td >Due Interest :<td>Rs.&nbsp;<INPUT NAME=\"r_d_int\" TYPE=\"TEXT\" VALUE=\"$d\" $HIGHLIGHT size=10 >";
echo "<td>Due Interest :<td>Rs.&nbsp;<INPUT NAME=\"d_int\"id=\"d_int\"TYPE=\"TEXT\" VALUE=\"$due_i\" $HIGHLIGHT size=10 onchange=\"return check(event)\">";
echo "<tr><td>Over Due Interest:<td>Rs.&nbsp;<INPUT NAME=\"r_od_int\" TYPE=\"TEXT\" VALUE=\"$o\" $HIGHLIGHT size=\"10\" >";
echo "<td>Over Due Interest:<td>Rs.&nbsp;<INPUT NAME=\"od_int\" id=\"od_int\"TYPE=\"TEXT\" VALUE=\"$odue_i\" $HIGHLIGHT size=\"10\" onchange=\"return check(event)\">";
echo "<tr><td>Total:<td>Rs.&nbsp;<INPUT NAME=\"total_r\" TYPE=\"TEXT\" VALUE=\"".($o+$p+$d)."\" $HIGHLIGHT size=\"10\" readonly>";
echo "<td>Total:<td>Rs.&nbsp;<INPUT NAME=\"total_d\" id=\"total_d\" TYPE=\"TEXT\" VALUE=\"".($principal+$odue_i+$due_i)."\" $HIGHLIGHT size=\"10\" onchange=\"return check(event)\" readonly >";
echo "<tr><td>Days:<td>Rs.&nbsp;<INPUT NAME=\"days\" TYPE=\"TEXT\" VALUE=\"$days\" $HIGHLIGHT size=5 READONLY>";
echo "<td>Amount:<td>Rs.&nbsp;<INPUT NAME=\"amount\" TYPE=\"TEXT\" VALUE=\"\" id=\"amount\" $HIGHLIGHT size=\"10\">";
echo "<input type=\"hidden\" name=\"ln_sl\"  value=\"$ln_sl\" >";
$id=getCustomerId($account_no,$menu);
echo "<tr><td align=\"right\" >Payment Mood : </td>";
echo "<td><SELECT name=\"t_status\"><option value=\"c\" onclick=\"Result(this.value)\">CASH</option><option value=\"y\" onclick=\"Result(this.value)\">Repay From SB</option></td>";
$sb_account_no=customerAccountNo($id,'sb');
echo "<tr ID='y' style='display:none'><td>Payment From SB A/C :</td>";
echo "<td><input type=\"TEXT\" id=\"sb_ac\" size=\"8\" value=\"$sb_account_no\" name=\"sb_account_no\" $READONLY $HIGHLIGHT $DISABLED>";
echo "<td><input type=\"BUTTON\" id=\"sb_bt\" name=\"BUTTON\" value=\"Search\" $DISABLED onClick=\"findAccount();\"></tr>";
echo "<td colspan=\"4\" align=\"RIGHT\"><input type=\"SUBMIT\" VALUE=\"   Go   \" ></tr>";
echo "</FORM>";
/*echo"<tr><td align=\"right\">Loan Repay Method</td><td width=\"2%\"  align=\"center\">:</td><td align=\"left\" colspan=\"2\"><select name='issue' onchange=\"f2(this.value,'$account_no','$menu');\"><option value=\"ca\">Cash</option><option value=\"ch\">Cheque</option></select></td></tr>";
echo "<tr><td colspan=\"4\">";

echo"<input type='hidden' name='bnk_get' id='bnk_get'><input type='hidden' name='chq_no_get' id='chq_no_get'>";
}
?>
<span id="txtHint"></span>
<?
if($im==1){
echo"<tr><td colspan='4'><hr></td></tr>";
//echo $im;
$sql_statement="SELECT * FROM bank_bk_dtl WHERE (account_type='sb' OR account_type='ca') AND status='op'";
$result=dBConnect($sql_statement);
echo"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Transfer from : <select name=\"bnk\" id=\"bnk\"><option value=\"null\">select</option>";

   for($j=0;$j<pg_NumRows($result);$j++){
    $row=pg_fetch_array($result,$j);
     echo"<option value=\"".$row['account_no']."-".strtoupper($row['account_sub_type'])."\">".strtoupper($row['account_sub_type'])."[".$row['account_no']."]</option>";}
echo"</select>";
echo"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cheque Number:&nbsp;&nbsp;&nbsp;<input type='text' name=\"chq_no\" id=\"chq_no\" onchange=\"get(this.form)\"$HIGHLIGHT>";
}

if(empty($im)){
echo "<tr><td colspan=\"3\"><td align=\"RIGHT\"><input type=\"SUBMIT\" VALUE=\"   Go   \" >";*/}
              
echo "</form>";
}
//-------------------------------INSERT INTO DATABASE ------------------------------------------
if($op=='i'){
$d_principal=$_REQUEST['d_principal'];
$d_int=$_REQUEST['d_int'];
$amount=$_REQUEST['amount'];
$od_int=$_REQUEST['od_int'];
$ln_sl=$_REQUEST['ln_sl'];
$issue=$_REQUEST['issue'];
$bnk=$_REQUEST['bnk_get'];
$chq_no=$_REQUEST['chq_no_get'];
echo $_REQUEST['chq_no'];
$ac=explode('-',$bnk);
$ac_num=$ac[0];
$ac_typ=strtolower($ac[1]);
//$action_date=$_REQUEST['action_date'];
$total_d=$_REQUEST['total_d'];
$gl_code=getGlCode4mCustomerAccount($account_no,$action_date);
$fy1=getFy($action_date);
if(empty($fy1)){
	echo "<h1><center><b>You Can't Insert any value Into database Because Financial Year already Locked by administrator !!!!!!!!!</h1>";
		} 	
else{
     if($amount>=($d_int+$od_int)){
	$r_i_d=$d_int;
	$r_i_od=$od_int;
	$r_p=$amount-($d_int+$od_int);
	$b_p=$d_principal-$r_p;
	$b_i_d=0;
	$b_i_od=0;
	}
     else{
	if($amount>$od_int){
	$r_i_od=$od_int;
	$r_i_d=$amount-$od_int;
	$b_i_d=$d_int-$r_i_d;
	$b_i_od=0;
	}
	else{
	$r_i_od=$amount;
	$r_i_d=0;
	$b_i_d=$d_int;
	$b_i_od=$od_int-$amount;
	}
	$r_p=0;
	$b_p=$d_principal;
	}
	$t_id=getTranId();
	$gl_code_p=getGlCode4mCustomerAccount($account_no,$action_date);
	//loan_return_dtl
	/*$sql_statement="INSERT INTO loan_return_dtl (tran_id,loan_serial_no,account_no, action_date,r_total_amount,r_due_int,r_overdue_int,r_principal,b_due_int,b_overdue_int, b_principal,staff_id,entry_time) VALUES('$t_id','$ln_sl','$account_no','$action_date',$amount, $r_i_d,$r_i_od,$r_p,$b_i_d,$b_i_od,$b_p,'$staff_id',now())";
	//For GL ENTRY-------------------------------------
	if($issue=='ca'){
	$sql_statement.=";INSERT INTO gl_ledger_hrd(tran_id,type, action_date,fy,remarks, operator_code, entry_time) VALUES ('$t_id','hb','$action_date','$fy','$remarks','$staff_id', CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
         $sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','28101',$amount,'Dr','hb repay')";}
if($issue=='ch'){

$sql_statement.=";INSERT INTO gl_ledger_hrd(tran_id,type, action_date,fy,remarks, operator_code, entry_time,cheque_no,cheque_dt) VALUES ('$t_id','hb','$action_date','$fy','$remarks','$staff_id', CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP),'$chq_no','$action_date')";
        
         $gl_bank_code=getGlCode4mBank($ac_num,$ac_typ);
         $part_dr='trf['.$account_no.']'; 


$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars,account_no) VALUES('$t_id','$gl_bank_code',$amount,'Dr','$part_dr','$ac_num')";

}
	if($r_i_od>0){
	$gl_od=getGLCodeLoanInterest($gl_code_p,'o');
	$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','$account_no','$gl_od',$r_i_od,'Cr','over due interest')";
	}
	if($r_i_d>0){
	$gl_d=getGLCodeLoanInterest($gl_code_p,'d');
	$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','$account_no','$gl_d',$r_i_d,'Cr','due interest')";
	}
	if($r_p>0){
	//$gl_d=getGLCodeLoanInterest($gl_code_p,'d');
	$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','$account_no','$gl_code_p',$r_p,'Cr','principal')";
	}
       if($b_p<=0){
	//for remove security from loan_security table
	$sql_statement.=";UPDATE loan_security SET status='r' WHERE loan_serial_no='$ln_sl' AND account_no='$account_no'";
	$sql_statement.=";UPDATE loan_ledger_hrd SET status='cl',closing_date='$action_date' WHERE loan_serial_no='$ln_sl' AND account_no='$account_no'";
	}*/

$sql_statement="INSERT INTO loan_return_dtl (tran_id,loan_serial_no,account_no, action_date,r_total_amount,r_due_int,r_overdue_int,r_principal,b_due_int,b_overdue_int, b_principal,staff_id,entry_time) VALUES('$t_id','$ln_sl','$account_no','$action_date',$amount, $r_i_d,$r_i_od,$r_p,$b_i_d,$b_i_od,$b_p,'$staff_id',now())";
	//For GL ENTRY-------------------------------------
	$sql_statement.=";INSERT INTO gl_ledger_hrd(tran_id,type, action_date,fy,remarks, operator_code, entry_time) VALUES ('$t_id','pl','$action_date','$fy1','$remarks','$staff_id', CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";

	if($t_status=='c'){
	         		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','28101',$amount,'Dr','pl repay')";
			}
	if($t_status=='y'){
        			$gl_code=getGlCode4mCustomerAccount($sb_account_no,$action_date);
				$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,account_no,amount,dr_cr, particulars) VALUES('$t_id','$gl_code','$sb_account_no',$amount,'Dr','Repay To $account_no')";			
	}
	if($r_i_od>0){
	$gl_od=getGLCodeLoanInterest($gl_code_p,'o');
	$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','$account_no','$gl_od',$r_i_od,'Cr','over due interest')";
	}
	if($r_i_d>0){
	$gl_d=getGLCodeLoanInterest($gl_code_p,'d');
	$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','$account_no','$gl_d',$r_i_d,'Cr','due interest')";
	}
	if($r_p>0){
	$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','$account_no','$gl_code_p',$r_p,'Cr','principal')";
	}
	if($b_p<0){
	$sql_statement="UPDATE loan_ledger_hrd SET status='cl',closing_date='$action_date' WHERE loan_serial_no='$ln_sl' AND account_no='$account_no';UPDATE loan_security SET status='r' WHERE loan_serial_no='$ln_sl' AND account_no='$account_no';";
    		 }

    echo $sql_statement;
	$result=dBConnect($sql_statement);
		if(pg_affected_rows($result)<1){
		echo "<br><h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
			} 
		else{
			echo "<h4><font color=\"Green\">Sucessfully inserted data into database.</font><br>Your Transaction Id:$t_id</h4>";
			echo "<pre><font size=\"+2\"><b>Your Amount Allocated as: <br>";
			echo "Principal          : Rs. $r_p <br>";
			echo "Due Interst        : Rs. $r_i_d<br>";
			echo "Over Due Interest  : Rs. $r_i_od<br>";
			echo "Total              : Rs. $amount";
			echo "</font></pre>";
			echo "<font size=+1><a href=\"../main/set_account.php?menu=$menu&account_no=$account_no\">Click</a> here to go Statement"; 

		}
		
		
 	}
    }
//----------------------------------------------------------------------------------------------
}
?>
