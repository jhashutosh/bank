<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$op=$_REQUEST['op'];
$ln_sl=$_REQUEST['ln_sl'];
$action_date=$_REQUEST['action_date'];
if(empty($_REQUEST['account_no'])){
	$account_no=$_SESSION["current_account_no"];
	}
	
else{
	$account_no=$_REQUEST['account_no'];
	$_SESSION["current_account_no"]=$account_no;
	}
if(empty($action_date)){$action_date=date('d.m.Y');}
$sql_statement="SELECT getLoanInterest('$account_no','$action_date','kcc') as int";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_result($result,'int')==1){$iflag=true;}
$id=getCustomerId($account_no,$menu);
echo "<html>";
echo "<head>";
echo "<title> KCC Details </title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script src=\"../JS/validation.js\"></script>";
echo "</head>";
?>
<link rel="stylesheet" href="../retail/css/retail.css">

<script language="JAVASCRIPT">
function check(e)
{
	var r_prin=document.getElementById("d_principal").value;
	var due_int=document.getElementById("d_int").value;
	var od_due_int=document.getElementById("od_int").value;
	var tot=(parseFloat(r_prin)+parseFloat(due_int)+parseFloat(od_due_int));
	document.getElementById("total_d").value=tot;
//alert("123"+due_int)
//alert("r_prin"+r_prin+"ra"+due_int+"bb"+od_due_int+"cc"+total)
//alert("tatal"+tot)
}

function numbersonly(e){
	var unicode=e.charCode? e.charCode : e.keyCode;
	//alert(unicode)
	if (unicode!=8){ 
		if (unicode<46||unicode>57||unicode==47) {
			return false;		
		}
	}
	else{
if(document.getElementById("ac_ty").value==document.getElementById("m_no").value){return false;}else{return true;}
	
	}
}

function cr_chk()
{
	var due_prin=parseInt(document.getElementById('d_principal').value);
	var due_int=parseInt(document.getElementById('d_int').value);
	var over_int=parseInt(document.getElementById('od_int').value);
	var r_due_prin=parseInt(document.getElementById('amount').value);
	var r_due_i=parseInt(document.getElementById('d_i').value);
	var r_over_int=parseInt(document.getElementById('od_i').value);
	
	var re_due_prin=document.getElementById('amount').value.length;
	var re_due_i=document.getElementById('d_i').value.length;
	var re_over_int=document.getElementById('od_i').value.length;
	
	if(due_prin<r_due_prin)
	{
		alert('Recovery Principal Amount Exceeds Due Principal')
		document.getElementById("amount").value='';
		document.getElementById("amount").focus();
		return false;
	}
	if(due_int<r_due_i)
	{
		alert('Recovery Due Interest Amount Exceeds Due Interest')
		document.getElementById("d_i").value='';
		document.getElementById("d_i").focus();
		return false;
	}
	if(over_int<r_over_int)
	{
		alert('Recovery OverDue Interest Amount Exceeds OverDue Interest')
		document.getElementById("od_i").value='';
		document.getElementById("od_i").focus();
		return false;
	}

	if(re_due_prin=='0')
	{
		alert("Recovery Principal Should Not Be Blank !!!!");
		document.getElementById("amount").focus();
		return false;
	}
	if(re_due_i=='0')
	{
		alert("Recovery Due Interest Should Not Be Blank !!!!");
		document.getElementById("d_i").focus();
		return false;
	}
	if(re_over_int=='0')
	{
		alert("Recovery OverDue Interest Should Not Be Blank !!!!");
		document.getElementById("od_i").focus();
		return false;
	}
	
}
</script>
<?php


echo "<body bgcolor=\"silver\" onload=\"amount.focus();\">";
$flag=getGeneralInfo_Customer($id);
if($flag==1){
echo "<hr>";
//==========================DISPLAY HERE =======================================
if(empty($op)){
echo "<table algin=CENTER width=\"100%\">";
$sql_statement="SELECT account_no,loan_serial_no,loan_type,action_date,days,round(due_int) as due_int,round(overdue_int) as overdue_int,round(principal) as  principal,crop_id,status FROM loan_cal_int where account_no='$account_no'";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
	$color="GREEN";
	echo "<tr><th bgcolor=YELLOW colspan=\"9\">KCC Details of [$account_no] as on ".$action_date."</th>";
	echo "<tr>";
	echo "<th bgcolor=$color Rowspan=\"2\">Loan <br>Serial No</th>";
	echo "<th bgcolor=$color Rowspan=\"2\">Name</th>";
	echo "<th bgcolor=$color Rowspan=\"2\">Crop<br>Name</th>";
	echo "<th bgcolor=$color Rowspan=\"2\">Days</th>";
	echo "<th bgcolor=$color Rowspan=\"2\">Principal<br>(Rs.)</th>";
	echo "<th bgcolor=$color colspan=\"2\">Interest</th>";
	echo "<th bgcolor=$color Rowspan=\"2\">Total<br>(Rs.)</th>";
	echo "<th bgcolor=$color Rowspan=\"2\">Operation</th>";
	echo "<tr><th bgcolor=$color>Due</th>";
	echo "<th bgcolor=$color >Overdue</th>";
	for($j=0; $j<pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	echo "<tr>";
	$row=pg_fetch_array($result,$j);
	if($row['status']=='o'){
	$fcolor="#DC143C";
	}
	else{
	$fcolor="BLACK";
	}
	
	$loan_sl_no=$row['loan_serial_no'];
	echo "<td bgcolor=$color align=center><font color=$fcolor> $loan_sl_no";
	echo "<td align=center bgcolor=$color><font color=$fcolor>".getName('customer_id',$id,'name1','customer_master')."</td>";
	$c_id=$row['crop_id'];
	echo "<td align=center bgcolor=$color><font color=$fcolor>".getName('crop_id',$c_id,'crop_desc','crop_mas')."</td>";
	echo "<td align=center bgcolor=$color><font color=$fcolor>".$row['days']."</td>";
	echo "<td align=right bgcolor=$color><font color=$fcolor>".(float)$row['principal']."</td>";
	echo "<td align=right bgcolor=$color><font color=$fcolor>".$row['due_int']."</td>";
	echo "<td align=right bgcolor=$color><font color=$fcolor>".$row['overdue_int']."</td>";
	echo "<td align=right bgcolor=$color><font color=$fcolor>".($row['principal']+$row['due_int']+$row['overdue_int'])."</td>";
	echo "<td align=Center bgcolor=$color><a href=\"kcc_loan_repayment.php?menu=$menu&ln_sl=$loan_sl_no&op=r&action_date=$action_date\"><font color=$fcolor>Repay</td>";

	}
}
else{
 echo "<h1><center>Your dont have any KCC Loan!!!!!!!!!!!</h1></center>";
    }
}
//==================================FOR REPAY FORM=========================================
if($op=='r'){

$sql_statement="SELECT account_no,loan_serial_no,loan_type,action_date,days,round(due_int) as due_int,round(overdue_int) as overdue_int,round(principal) as  principal,crop_id,status FROM loan_cal_int where account_no='$account_no' AND loan_serial_no='$ln_sl'";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$crop_id=pg_result($result,'crop_id');
$principal=(float)pg_result($result,'principal');
$days=pg_result($result,'days');
$due_i=pg_result($result,'due_int');
$odue_i=pg_result($result,'overdue_int');
echo "<table bgcolor=\"#B0C4DE\" width=\"80%\" align=\"CENTER\">";
echo "<tr><th bgcolor=\"#808000\" colspan=\"4\"><font size=+2>KCC Repayment Form of [$account_no]</font>";
echo "<FORM NAME=\"pForm\" method=\"POST\" action=\"kcc_loan_repayment.php?menu=$menu&op=i&ln_sl=$ln_sl\" onSubmit=\"return cr_chk();\">";
echo "<tr><td> Crop:<td><INPUT TYPE=\"TEXT\" VALUE=\"".getName('crop_id',$crop_id,'crop_desc','crop_mas')."\" $HIGHLIGHT size=\"15\" readonly>";
echo "<td>Date:<td><INPUT NAME=\"action_date\" TYPE=\"TEXT\" VALUE=\"".$action_date."\" $HIGHLIGHT size=\"12\" readonly>";
echo "<tr><td colspan=\"2\"><b>RECOVERY:</b><td colspan=\"2\"><b>DUE:</b>";
recoverDetails($ln_sl,$p,$d,$o);
if(empty($p))$p=0;
if(empty($d))$d=0;
if(empty($o))$o=0;
echo "<tr><td>Principal :<td>Rs.&nbsp;<INPUT NAME=\"r_principal\" id=\"r_principal\" TYPE=\"TEXT\" VALUE=\"$p\" $HIGHLIGHT size=10 READONLY>";
echo "<td>Principal :<td>Rs.&nbsp;<INPUT NAME=\"d_principal\" id=\"d_principal\" TYPE=\"TEXT\" VALUE=\"$principal\" READONLY $HIGHLIGHT size=10 id=\"p\" onchange=\"return check(event)\">";
echo "<tr><td >Due Interest :<td>Rs.&nbsp;<INPUT NAME=\"r_d_int\" TYPE=\"TEXT\" VALUE=\"$d\" $HIGHLIGHT size=10 READONLY>";
echo "<td>Due Interest :<td>Rs.&nbsp;<INPUT NAME=\"d_int\" id=\"d_int\" TYPE=\"TEXT\" VALUE=\"$due_i\" $HIGHLIGHT size=10 id=\"d\" onchange=\"return check(event)\">";
echo "<tr><td>Over Due Interest:<td>Rs.&nbsp;<INPUT NAME=\"r_od_int\" TYPE=\"TEXT\" VALUE=\"$o\" $HIGHLIGHT size=\"10\" READONLY>";
echo "<td>Over Due Interest:<td>Rs.&nbsp;<INPUT NAME=\"od_int\" id=\"od_int\" TYPE=\"TEXT\" VALUE=\"$odue_i\" $HIGHLIGHT  size=\"10\" id=\"o\" onchange=\"return check(event)\">";
echo "<tr><td>Total:<td>Rs.&nbsp;<INPUT NAME=\"total_r\" TYPE=\"TEXT\" VALUE=\"".($o+$p+$d)."\" $HIGHLIGHT size=\"10\" READONLY>";
echo "<td>Total:<td>Rs.&nbsp;<INPUT NAME=\"total_d\" id=\"total_d\" TYPE=\"TEXT\" VALUE=\"".($principal+$odue_i+$due_i)."\" $HIGHLIGHT READONLY size=\"10\" id=\"o\">";
echo "<tr><td>Days:<td>Rs.&nbsp;<INPUT NAME=\"days\" TYPE=\"TEXT\" VALUE=\"$days\" $HIGHLIGHT size=5 READONLY>";
echo "<td>Principal:<td>Rs.&nbsp;<INPUT NAME=\"amount\" TYPE=\"TEXT\" VALUE=\"\" id=\"amount\" $HIGHLIGHT size=\"10\" onkeypress=\"return numbersonly(event);\">";
echo "<tr><td>Due Int.:<td>Rs.&nbsp;<INPUT NAME=\"d_i\" TYPE=\"TEXT\" VALUE=\"\" id=\"d_i\" $HIGHLIGHT size=\"5\" onkeypress=\"return numbersonly(event);\">";
echo "<td>Over Due Int.:<td>Rs.&nbsp;<INPUT NAME=\"od_i\" TYPE=\"TEXT\" VALUE=\"\" id=\"od_i\" $HIGHLIGHT size=\"10\" onkeypress=\"return numbersonly(event);\">";
echo "<input type=\"hidden\" name=\"ln_sl\"  value=\"$ln_sl\" >";
echo "<input type=\"hidden\" name=\"gl_status\"  value=\"".pg_result($result,'status')."\" >";
echo "<tr><td colspan=\"1\">Remarks:<td colspan=\"2\"><INPUT NAME=\"remarks\" TYPE=\"TEXT\" $HIGHLIGHT size=\"50\"><td align=\"RIGHT\"><input type=\"SUBMIT\" VALUE=\"    Go   \" >";
echo "</FORM>";
   }
 }
//-------------------------------INSERT INTO DATABASE ------------------------------------------
if($op=='i'){
$d_principal=$_REQUEST['d_principal'];
$d_int=$_REQUEST['d_int'];
$amount=$_REQUEST['amount'];
$od_int=$_REQUEST['od_int'];
$ln_sl=$_REQUEST['ln_sl'];
$d_i=$_REQUEST['d_i'];
$od_i=$_REQUEST['od_i'];
$action_date=$_REQUEST['action_date'];
$total_d=$_REQUEST['total_d'];
$remarks=$_REQUEST['remarks'];
$gl_status=$_REQUEST['gl_status'];
$gl_code_p=getGlCode4mLoanLedger($ln_sl,$gl_status);
$fy=getFy($action_date);
if(empty($fy)){
	echo "<h1><center><b>You Can't Insert any value Into database Because Financial Year already Locked by administrator !!!!!!!!!</h1>";
		} 	
else{
    /* if($amount>=($d_int+$od_int)){
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
	}*/
	//echo "<h1>$amount</h1>";
	
	//just for existing *********************************************
	$r_i_d=$d_i;        //*******************************************
	$r_i_od=$od_i;	    //*******************************************
	$r_p=$amount;       //*******************************************
	$b_p=$d_principal-$amount;//*************************************
	$b_i_d=$d_int-$d_i; //*******************************************
	$b_i_od=$od_int-$od_i;//*****************************************
	$amount=$amount+$d_i+$od_i;//************************************
	//***************************************************************
  	$t_id=getTranId();
	$sql_statement='';
	//loan_return_dtl
	if($b_p<1){
	$sql_statement="UPDATE loan_ledger_hrd SET status='cl',closing_date='$action_date' WHERE loan_serial_no='$ln_sl' AND account_no='$account_no';UPDATE loan_security SET status='r' WHERE loan_serial_no='$ln_sl' AND account_no='$account_no';";
     }
	$sql_statement.="INSERT INTO loan_return_dtl (tran_id,loan_serial_no,account_no, action_date,r_total_amount,r_due_int,r_overdue_int,r_principal,b_due_int,b_overdue_int, b_principal,staff_id,remarks,entry_time) VALUES('$t_id','$ln_sl','$account_no','$action_date',$amount, $r_i_d,$r_i_od,$r_p,$b_i_d,$b_i_od,$b_p,'$staff_id','$remarks',CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
	//For GL ENTRY-------------------------------------
	$sql_statement.=";INSERT INTO gl_ledger_hrd(tran_id,type, action_date,fy,remarks, operator_code, entry_time) VALUES ('$t_id','kcc','$action_date','$fy','$remarks','$staff_id',CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
	$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','28101',$amount,'Dr','kcc repay')";
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
	
  // echo $sql_statement;
	$result=dBConnect($sql_statement);
		if(pg_affected_rows($result)<1){
		echo "<div class='failed'><h3><font color=\"white\">Failed to update database.</font></h3></div>";
			} 
		else{
			echo "<div class='success'><h4><font color=\"Green\">Sucessfully inserted data into database.</font><br>Your Transaction Id:$t_id</h4>";
			echo "<pre><font size=\"+2\"><b>Your Amount Allocated as: <br>";
			echo "Principal          : Rs. $r_p <br>";
			echo "Due Interest       : Rs. $r_i_d<br>";
			echo "Over Due Interest  : Rs. $r_i_od<br>";
			echo "Total              : Rs. $amount";
			echo "</font></pre>";
			echo "<font size=+1><a href=\"../main/set_account.php?menu=kcc&account_no=$account_no\">Click</a> here to go Statement</div>"; 

		}
		
		
 	}
    }
//----------------------------------------------------------------------------------------------
}
?>
