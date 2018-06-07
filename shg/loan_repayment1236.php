<?
include "../config/config.php";
$staff_id=verifyAutho();
$group_no=$_SESSION["current_account_no"];
$menu=$_REQUEST['menu'];
$op=$_REQUEST['op'];
$account_no=$_REQUEST["loan_no"];
$ln_sl=$_REQUEST['ln_sl'];
$action_date=$_REQUEST['action_date'];
$sql_statement="SELECT loan_compt_status FROM loan_ledger_hrd";
//echo $sql_statement;
$result=dBConnect($sql_statement);
$loan_serial_sql="SELECT loan_serial_no,loan_compt_status FROM loan_ledger_hrd WHERE issue_date<='$action_date' AND account_no=trim('$account_no') AND (status='op' OR closing_date IS NULL OR closing_date>'$action_date')"; 
//echo $loan_serial_sql;
$loan_sl_res=dBConnect($loan_serial_sql);
$row=pg_fetch_array($loan_sl_res,0);
$loan_serial_no=$row['loan_serial_no'];
$comp_method=$row['loan_compt_status'];
//echo $loan_serial_no;
//echo $comp_method; 
if(empty($op)){
if(empty($action_date)){
if($comp_method=='in')
$sql_statement="SELECT getLoanDtl('$action_date','$account_no','$loan_serial_no')";
else
$sql_statement="SELECT getLoanInterest('$account_no',CURRENT_DATE,'sgl') as int";
}
else{
if($comp_method=='in')
$sql_statement="SELECT getLoanDtl('$action_date','$account_no','$loan_serial_no')";
else
$sql_statement="SELECT getLoanInterest('$account_no','$action_date','sgl') as int";
}
echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_result($result,'int')==1){$iflag=true;}

//echo "account_no=$account_no";
}
$id=getCustomerIdFromGroupId($group_no);
echo "<html>";
echo "<head>";
echo "<title>SHG Loan Details </title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script src=\"../JS/validation.js\"></script>";
?>
<script LANGUAGE="JavaScript">

function od_p(f)
{
var dodprincipal=document.getElementById('d_od_principal').value;
var reodpril=document.getElementById('re_od_pri').value.length;
if(reodpril==0)
var reodpri=0;
else
var reodpri=document.getElementById('re_od_pri').value;
var diffodp=dodprincipal-reodpri;
d_int();
if(diffodp>0)
{
alert("You Must Repay Total Overdue Principal before Installment Principal !!!");
document.getElementById('re_od_pri').focus();
}
}

function d_int(f)
{
var ddint=document.getElementById('d_d_int').value;
var redl=document.getElementById('re_d_i').value.length;
if(redl==0)
var redi=0;
else
var redi=document.getElementById('re_d_i').value;
var diffdi=ddint-redi;
od_int();
if(diffdi>0)
{
alert("You Must Repay Total due interest before Principal Repayment!!!");
document.getElementById('re_d_i').focus();
}
}



function od_int(f)
{
var dodint=document.getElementById('d_od_int').value;
var reodl=document.getElementById('re_od_i').value.length;
if(reodl==0)
var reodi=0;
else
var reodi=document.getElementById('re_od_i').value;

var diffodi=dodint-reodi;
if(diffodi>0)
{
alert("You Must Repay Total Overdue interest 1st");
document.getElementById('re_od_i').focus();
}
}
</script>
<?
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"c_od_i.focus();\">";
$flag=getGeneralInfo_Customer($id);
if($flag==1){
echo "<hr>";
//==========================DISPLAY HERE ======================================================
if(empty($op)){
 if(isOpenLoan($account_no)){
echo "<table algin=CENTER width=\"100%\">";
$sql_statement="SELECT * FROM loan_cal_int where account_no='$account_no'";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
	$color="GREEN";
	echo "<tr><th bgcolor=YELLOW colspan=\"11\">SHG Loan Details of [$account_no] as on ".$action_date."</th>";
	echo "<tr>";
	echo "<th bgcolor=$color Rowspan=\"2\">Loan <br>Serial No</th>";
	echo "<th bgcolor=$color Rowspan=\"2\">Name</th>";
	//echo "<th bgcolor=$color Rowspan=\"2\">Crop<br>Name</th>";
	echo "<th bgcolor=$color Rowspan=\"2\">Days</th>";
	echo "<th bgcolor=$color colspan=\"3\">Principal</th>";
	echo "<th bgcolor=$color colspan=\"2\">Interest</th>";
	echo "<th bgcolor=$color Rowspan=\"2\">Total<br>(Rs.)</th>";
	echo "<th bgcolor=$color Rowspan=\"2\">Operation</th></tr>";
	echo "<tr><th bgcolor=$color >Total</th>";
	echo "<th bgcolor=$color>Due</th>";
	echo "<th bgcolor=$color >Overdue</th>";
	echo "<th bgcolor=$color>Due</th>";
	echo "<th bgcolor=$color >Overdue</th></tr>";
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
	echo "<td align=center bgcolor=$color>".$row['days']."</td>";
	echo "<td align=right bgcolor=$color>".(float)$row['principal']."</td>";
	echo "<td align=right bgcolor=$color>".(float)$row['due_principal']."</td>";
	echo "<td align=right bgcolor=$color>".(float)$row['overdue_principal']."</td>";
	echo "<td align=right bgcolor=$color>".$row['due_int']."</td>";
	echo "<td align=right bgcolor=$color>".$row['overdue_int']."</td>";
	echo "<td align=right bgcolor=$color>".($row['principal']+$row['due_int']+$row['overdue_int'])."</td>";
	if(!empty($loan_sl_no)){
	echo "<td align=Center bgcolor=$color><a href=\"loan_repayment.php?menu=$menu&loan_no=$account_no&ln_sl=$loan_sl_no&op=r&action_date=$action_date\">Repay</td>";
		}
	else{
		echo "<td align=Center bgcolor=$color>Sorry</td>";
	    }
	}
}
else{
 echo "<h1><center>Your dont have any SHG Loan!!!!!!!!!!!</h1></center>";
    }
  }
else{
 echo "<h1><font color=RED><center>Your dont have any SHG Loan for Payment!!!!!!!!!!!</h1></center>";
    }
}
//==================================FOR REPAY FORM=========================================
if($op=='r'){
$sql_statement="SELECT * FROM loan_cal_int where account_no='$account_no' AND loan_serial_no='$ln_sl'";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$principal=(float)pg_result($result,'principal');
$due_principal=pg_result($result,'due_principal');
$overdue_principal=pg_result($result,'overdue_principal');
$days=pg_result($result,'days');
$due_i=pg_result($result,'due_int');
$odue_i=pg_result($result,'overdue_int');
echo "<table bgcolor=\"#F5F5DC\" width=\"80%\" align=\"CENTER\">";
echo "<tr><th bgcolor=\"#808000\" colspan=\"4\"><font size=-1>SHG Loan Repayment Form of [$account_no]</font>";
echo "<FORM NAME=\"orderform\" method=\"POST\" action=\"loan_repayment.php?menu=$menu&op=i&ln_sl=$ln_sl&loan_no=$account_no\" onSubmit=\"return varify();\">";
echo "<tr><td> Account No:<td><INPUT TYPE=\"TEXT\" VALUE=\"$account_no\" $HIGHLIGHT size=\"15\" readonly>";
echo "<td>Date:<td><INPUT NAME=\"action_date\" TYPE=\"TEXT\" VALUE=\"$action_date\" $HIGHLIGHT size=\"12\" readonly>";
echo "<input type=\"hidden\" name=\"gl_status\"  value=\"".pg_result($result,'status')."\" >";
echo "<tr><td colspan=\"2\"><b>RECOVERY:</b><td colspan=\"2\"><b>DUE:</b>";
//recoverDetails($ln_sl,$p,$d,$o);
//for installment system
recoverinstDetails($ln_sl,$action_date,$odp,$rdp,$rdi,$rodi,$tamt,$rp);
if(empty($odp))$odp=0;
if(empty($rdp))$rdp=0;
if(empty($rdi))$rdi=0;
if(empty($rodi))$rodi=0;
if(empty($tamt))$tamt=0;
if(empty($rp))$rp=0;
//
echo "<tr><td>Total Principal :<td>Rs.&nbsp;<INPUT NAME=\"r_principal\" TYPE=\"TEXT\" VALUE=\"$rp\" $HIGHLIGHT size=10 READONLY>";
echo "<td>Total Principal :<td>Rs.&nbsp;<INPUT NAME=\"d_principal\" id=\"d_principal\" TYPE=\"TEXT\" VALUE=\"$principal\" $HIGHLIGHT size=10  READONLY>";
echo "<tr><td>Installment Principal[due] :<td>Rs.&nbsp;<INPUT NAME=\"r_d_principal\" TYPE=\"TEXT\" VALUE=\"$rdp\" $HIGHLIGHT size=10 READONLY>";
echo "<td>Installment Principal[due]<td>Rs.&nbsp;<INPUT NAME=\"d_d_principal\" id=\"d_d_principal\" TYPE=\"TEXT\" VALUE=\"$due_principal\" $HIGHLIGHT size=10  READONLY>";
echo "<tr><td>Over Due Principal :<td>Rs.&nbsp;<INPUT NAME=\"r_od_principal\" TYPE=\"TEXT\" VALUE=\"$odp\" $HIGHLIGHT size=10 READONLY>";
echo "<td>Over Due Principal :<td>Rs.&nbsp;<INPUT NAME=\"d_od_principal\" id=\"d_od_principal\" TYPE=\"TEXT\" VALUE=\"$overdue_principal\" $HIGHLIGHT size=10  READONLY>";
echo "<tr><td >Due Interest :<td>Rs.&nbsp;<INPUT NAME=\"r_d_int\" TYPE=\"TEXT\" VALUE=\"$rdi\" $HIGHLIGHT size=10 READONLY>";
echo "<td>Due Interest :<td>Rs.&nbsp;<INPUT NAME=\"d_d_int\" TYPE=\"TEXT\" VALUE=\"$due_i\" $HIGHLIGHT size=10 id=\"d_d_int\">";
echo "<tr><td>Over Due Interest:<td>Rs.&nbsp;<INPUT NAME=\"r_od_int\" TYPE=\"TEXT\" VALUE=\"$rodi\" $HIGHLIGHT size=\"10\" readonly>";
echo "<td>Over Due Interest:<td>Rs.&nbsp;<INPUT NAME=\"d_od_int\" id=\"d_od_int\" TYPE=\"TEXT\" VALUE=\"$odue_i\" $HIGHLIGHT size=\"10\" id=\"od_int\" >";
echo "<tr><td>Total:<td>Rs.&nbsp;<INPUT NAME=\"total_r\" TYPE=\"TEXT\" VALUE=\"$tamt\" $HIGHLIGHT size=\"10\" readonly>";
echo "<td>Total Upto $action_date:<td>Rs.&nbsp;<INPUT NAME=\"total_d\" TYPE=\"TEXT\" VALUE=\"".($due_principal+$odue_i+$due_i+$overdue_principal)."\" $HIGHLIGHT size=\"10\" id=\"o\" >";
echo "<tr><td colspan='2' align='right'>Days since last Repayment&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<td colspan='2'><INPUT NAME=\"days\" TYPE=\"TEXT\" VALUE=\"$days\" $HIGHLIGHT size=5 READONLY></td></tr>";
echo"<tr><td colspan='4' align='center' bgcolor='darkgreen'><font color='white'>Repayment</td></tr>";
echo "<tr><td>Over Due Interest:<td>Rs.&nbsp;<INPUT NAME=\"re_od_i\" TYPE=\"TEXT\" VALUE=\"0\" id=\"re_od_i\" $HIGHLIGHT size=\"10\">";
echo "<td>Due Interest:<td>Rs.&nbsp;<INPUT NAME=\"re_d_i\" TYPE=\"TEXT\" VALUE=\"0\" id=\"re_d_i\" $HIGHLIGHT size=\"10\" onclick=\"od_int()\"onChange=\"od_int()\" onKeyup=\"od_int()\"></td></tr>";
echo "<tr><td>Over Due Principal:<td>Rs.&nbsp;<INPUT NAME=\"re_od_pri\" TYPE=\"TEXT\" VALUE=\"0\" id=\"re_od_pri\" $HIGHLIGHT size=\"10\" onclick=\"d_int()\"onChange=\"d_int()\" onKeyup=\"d_int()\"></td>";
echo"<td>Installment Principal:<td>Rs.&nbsp;<INPUT NAME=\"re_d_p\" TYPE=\"TEXT\" VALUE=\"0\" id=\"re_d_p\" $HIGHLIGHT size=\"10\" onclick=\"od_p()\"onChange=\"od_p()\" onKeyup=\"od_p()\"></td></tr>";

echo "<tr><td bgcolor='' colspan=\"4\" align=\"RIGHT\"><input type=\"SUBMIT\" VALUE=\" GO \" >";
echo "</table>";
echo "</FORM>";
   }
 }

?>
<script language="JAVASCRIPT">
function IsPNumeric(strString){
   var strValidChars = "0123456789.";
   var strChar;
   var blnResult = true;
   if (strString.length == 0) return false;
   //  test strString consists of valid characters listed above
   for (i = 0; i < strString.length && blnResult == true; i++){
      strChar = strString.charAt(i);
      if (strValidChars.indexOf(strChar) == -1){
         blnResult = false;
         }
      }
   return blnResult;
   }
function varify(){
		if(IsPNumeric(document.orderform.amount.value)&&IsPNumeric(document.orderform.c_d_i.value)&&IsPNumeric(document.orderform.c_od_i.value)&&IsPNumeric(document.orderform.d_principal.value)&&IsPNumeric(document.orderform.d_int.value)&&IsPNumeric(document.orderform.od_int.value)){
		var t_p=parseFloat(document.orderform.amount.value);
		var t_due_int=parseFloat(document.orderform.c_d_i.value);
		var t_od_int=parseFloat(document.orderform.c_od_i.value);
		//var total=parseFloat(document.orderform.total_d.value);
		var due_int=parseFloat(document.orderform.d_int.value);
		var od_int=parseFloat(document.orderform.od_int.value);
		var due_principal=parseFloat(document.orderform.d_principal.value);
		}
		else{
		alert("Amount should not blank Or should be numeric value")
		return false;
		}
		if(t_p>due_principal){
		alert("You can't take more than from your dues !!!!!!\nTotal Due principal is :Rs. "+due_principal+"\n But you are putting :Rs. "+t_p);
		document.orderform.amount.focus();
		return false;
		}
		if(t_due_int>due_int){
		alert("You can't take more than from your dues !!!!!!\nTotal Due Interest is :Rs. "+due_int+"\n But you are putting :Rs. "+t_due_int);
		document.orderform.c_d_i.focus();
		return false;

		}
		if(t_od_int>od_int){
		alert("You can't take more than from your dues !!!!!!\nTotal Due Interest is :Rs. "+od_int+"\n But you are putting :Rs. "+t_od_int);
		document.orderform.c_od_i.focus();
		return false;
				}
	}
</script>
<?
//-------------------------------INSERT INTO DATABASE --------------------------------------------------------------------
if($op=='i'){
$d_principal=$_REQUEST['d_principal'];
$gl_status=$_REQUEST['gl_status'];
$d_int=$_REQUEST['d_int'];
$amount=$_REQUEST['amount'];
$od_int=$_REQUEST['od_int'];
$ln_sl=$_REQUEST['ln_sl'];
$c_d_i=$_REQUEST['c_d_i'];
$c_od_i=$_REQUEST['c_od_i'];
$action_date=$_REQUEST['action_date'];
$total_d=$_REQUEST['total_d'];
//========================================================================================================================for emi
$d_principal=$_REQUEST['d_principal'];
$re_od_pri=$_REQUEST['re_od_pri'];
$re_d_p=$_REQUEST['re_d_p'];
$re_d_i=$_REQUEST['re_d_i'];
$re_od_i=(empty($_REQUEST['re_od_i']))?0:$_REQUEST['re_od_i'];
$d_d_principal=$_REQUEST['d_d_principal'];
$d_od_principal=$_REQUEST['d_od_principal'];
$d_d_int=$_REQUEST['d_d_int'];
$d_od_int=$_REQUEST['d_od_int'];
$b_od_principal=$d_od_principal-$re_od_pri;
$b_d_principal=$d_d_principal-$re_d_p;
$b_od_i=$d_od_int-$re_od_i;
$b_d_i=$d_d_int-$re_d_i;
$re_tot_amt=$re_od_pri+$re_d_p+$re_d_i+$re_od_i;
$re_pri=$re_d_p+$re_od_pri;
$b_principal=$d_principal-$re_pri;
$days=$_REQUEST['days'];

echo $b_principal;

//========================================================================================================================
//echo "No OF SELECTED MEMBER is:".COUNT($member_id);
$gl_code=getGlCode4mCustomerAccount($account_no,$action_date);
$fy=getFy($action_date);
if(empty($fy)){
	echo "<h1><center><b>You Can't Insert any value Into database Because Financial Year already Locked by administrator !!!!!!!!!</h1>";
		} 	
else{
$t_id=getTranId();
$gl_code_p=getGlCode4mLoanLedger($ln_sl,$gl_status);

//-----------------------------------------------GROUP ENTRY ---------------------------------------------------
	/*$r_i_d=$c_d_i;
	$r_i_od=$c_od_i;
	$r_p=$amount;
	$b_p=$d_principal-$r_p;
	$b_i_d=$d_int-$c_d_i;
	$b_i_od=$od_int-$c_od_i;*/
	//loan_return_dtl
	//$sql_statement="INSERT INTO loan_return_dtl (tran_id,loan_serial_no,account_no,action_date,r_total_amount,r_due_principal,r_overdue_principal,r_due_int,r_overdue_int,r_principal,b_due_int,b_overdue_int,b_principal,days,staff_id,entry_time)
	 //VALUES
//('$t_id','$ln_sl','$account_no','$action_date',$re_tot_amt,$re_d_p,$re_od_pri,$re_d_i,$re_od_i,$re_pri,$b_d_i,$b_od_i,$b_principal,$days,'$staff_id',CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
$sql_statement="INSERT INTO loan_return_dtl (tran_id,loan_serial_no,account_no,action_date,r_total_amount,r_due_principal,r_overdue_principal,r_due_int,r_overdue_int,r_principal,b_due_int,b_overdue_int,b_principal,days,b_due_principal,b_overdue_principal,staff_id,entry_time)
	 VALUES
('$t_id','$ln_sl','$account_no','$action_date',$re_tot_amt,$re_d_p,$re_od_pri,$re_d_i,$re_od_i,$re_pri,$b_d_i,$b_od_i,$b_principal,$days,$b_d_principal,$b_od_principal,'$staff_id',CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";


	//For GL ENTRY-------------------------------------
	$sql_statement.=";INSERT INTO gl_ledger_hrd(tran_id,type, action_date,fy,remarks, operator_code, entry_time) VALUES ('$t_id','sgl','$action_date','$fy','$remarks','$staff_id', CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
	$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','28101',".($amount+$c_d_i+$c_od_i).",'Dr','SHG Loan repay')";
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
       if($b_principal<1 && $b_i_d<1 && $b_i_od<1){
	//for remove security from loan_security table
		$sql_statement.=";UPDATE loan_ledger_hrd SET status='cl',closing_date='$action_date' WHERE loan_serial_no='$ln_sl' AND account_no='$account_no'";
		//$sql_statement.=";UPDATE customer_account SET status='cl' WHERE account_no='$account_no'";
	}

   	echo $sql_statement;
	$result=dBConnect($sql_statement);
		if(pg_affected_rows($result)<1){
		echo "<br><h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
			} 
		else{
			echo "<h4><font color=\"Green\">Sucessfully inserted data into database.</font><br>Your Transaction Id:$t_id</h4>";
			echo "<pre><font size=\"+2\"><b>Your Amount Allocated as: <br>";
			if($r_p>0){
			echo "Principal          : Rs. $r_p <br>";
			}
			if($r_i_d>0){
			echo "Due Interst        : Rs. $r_i_d<br>";
			}
			if($r_i_od>0){
			echo "Over Due Interest  : Rs. $r_i_od<br>";
			}
			echo "Total              : Rs. ".($r_p+$r_i_d+$r_i_od);
			echo "</font></pre>";
			//echo "<font size=+1><a href=\"loan_statement.php?menu=$menu&account_no=$account_no&op=i\">Click</a> here to go Statement"; 

		}
		
		
 	}
    }
//----------------------------------------------------------------------------------------------
}
?>
