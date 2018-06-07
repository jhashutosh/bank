<?php
include "../config/config.php";
$staff_id=verifyAutho();
$account_no=$_REQUEST['account_no'];
$withdrawal=$_REQUEST["withdrawal"];
$deposit=$_REQUEST["deposit"];
$op=$_REQUEST["op"];
$action_date=$_REQUEST['action_date'];
$particulars=$_REQUEST['particulars'];
$operation=$_REQUEST['o'];
$menu=$_REQUEST['menu'];
$ch_no=$_REQUEST['ch_no'];
$ch_dt=(empty($_REQUEST['ch_dt']))?$DOB_DEFAULT:$_REQUEST['ch_dt'];
$id=$_REQUEST['id'];
echo "<html>";
echo "<head>";
echo "<title>".getName('link_tb',$id,'b_name','bank_bk_dtl')." bank's ".strtoupper($menu)." Account[$account_no]";
echo "</title>";
echo "<script src=\"../JS/validation.js\">";
echo "</script>";
?>
<script>
  function myRefresh(URL){
    window.opener.location.href =URL;
    self.close();
    }
  function activeDiv(str){
  	var t_type=document.form1.op.value;
	if(t_type=='w'){
		if(str=='c'){
		document.form1.ch_no.disabled=true;
		document.form1.ch_dt.disabled=true;
		document.form1.amount.focus();
		}
		else{
		document.form1.ch_no.disabled=false;
		document.form1.ch_dt.disabled=false;
		document.form1.amount.focus();
		}
	}

    }
</script>
<?php
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"amount.focus();\">";
if($operation=='i'){
	$fy1=$_SESSION['fy'];
	if(empty($fy1)){
	echo "<h1><center><b>You Can't Insert any value Into database Because Financial Year already Locked by administrator !!!!!!!!!";
}
	else{
		$t_id=getTranId();
		$gl_code=getGlCode4mBank($account_no);

//======================================================================================================================================

function depIntCode($gl_code){

	switch($gl_code){
			case 28202:
				$gl_code_int=57502;
			break;
			case 28302:
				$gl_code_int=57503;
			break;
			case 22317:
				$gl_code_int=12216;
			break;
			
			
	}
return $gl_code_int;
}


//===============================================================================================================================



		$sql_statement="INSERT INTO gl_ledger_hrd(tran_id,type,action_date,fy,remarks, cheque_no,cheque_dt,operator_code,entry_time) VALUES ('$t_id','c".trim($menu)."','$action_date','$fy1', '$remarks','$ch_no','$ch_dt','$staff_id',CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
		if($op=='d'){
			$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr,particulars) VALUES('$t_id','$account_no','$gl_code',$deposit,'Dr','cash')";
			if($particulars=='ca'){
			$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','28101',$deposit,'Cr','cash')";
				}
			else{
			//$intGl="58".substr($gl_code,2,strlen($gl_code));
			$intGl=depIntCode($gl_code);
			$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','$intGl',$deposit,'Cr','int.')";
			}
		}
		if($op=='w'){
			if($particulars=='c'){
			$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','63904',$withdrawal,'Dr','charge')";
			}
			else{
			$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','28101',$withdrawal,'Dr','ch')";
			
			$sql_statement.=";INSERT INTO cheque_reg (tran_id,account_no, action_date,cheque_no,cheque_date,amount,status,operator_code,entry_time) VALUES('$t_id', '$account_no','$action_date','$ch_no','$ch_dt','$withdrawal','g','$staff_id',CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
			}
			$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr,particulars) VALUES('$t_id','$account_no','$gl_code',$withdrawal,'Cr','$particulars')";
			
		       }
	//echo $sql_statement;
	$result=dBConnect($sql_statement);
	if(pg_affected_rows($result)<1) {
	echo "<br><h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
	} 
	else 
	{
	echo "<table width=\"100%\" bgcolor=GREEN>";
	//echo "<tr><td>Successfully inserted data into database.";
	echo "<tr><td align=\"Center\"><B>Transaction id :$t_id &nbsp;";
	echo "<input type=button onclick=\"myRefresh('bank_books_new.php?menu=bb')\" value=\"Return\"> </table>";
	}
	}
}
//---------------------------------------------------------------------------------------------
$balance=(float)ccb_deposits_current_balance($account_no,'');
$flag=getBankInfo($id);
echo "<form name=\"form1\" method=\"POST\" action=\"operation_page.php?menu=$menu&id=$id&op=$op&o=i&account_no=$account_no\" onSubmit=\"return varify_sb(this.form);\">";
echo "<table bgcolor=#FAF0E6 width=100% align=center>";
echo "<tr><th colspan=4 bgcolor=Yellow>Entry Form of ".strtoupper($menu)."<font size=+2> [$account_no]</font> Current balance:Rs. <font size=+2>$balance/=</font></th></tr>";
echo "<tr><td align=\"left\">A/C No:<td><input type=\"TEXT\" name=\"account_no\" size=\"15\" value=\"$account_no\" disabled $HIGHLIGHT><br>";
echo "<td align=\"left\">Date:<td><input type=\"TEXT\" id=\"action_date\" name=\"action_date\" size=\"12\" value=\"".date('d.m.Y')."\" $HIGHLIGHT>";
echo "&nbsp;&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(form1.action_date,'dd/mm/yyyy','Choose Date')\"><br>";
echo "<tr><td valign=\"top\" align=\"left\">Particulars:<td>";
if($op=='w'){
	echo "<Select name=\"particulars\" id=\"p\" onChange=\"activeDiv(this.value);\">";
	echo "<option value=\"ch\">Cheque</option>";
	echo "<option value=\"c\">Charges</option></select>";
	echo "<td align=\"left\">Withdrawals:<td><input type=\"TEXT\" name=\"withdrawal\" size=\"20\" id=\"amount\" value=\"\" $HIGHLIGHT><br>";
	echo "<tr><td align=\"left\">Cheque No.:<td><input type=\"TEXT\" name=\"ch_no\" size=\"20\" id=\"ch_no\" value=\"\" $HIGHLIGHT>";
	echo "<td align=\"left\">Cheque Date:<td><input type=\"TEXT\" name=\"ch_dt\" size=\"12\" id=\"ch_dt\" value=\"".date('d.m.Y')."\" $HIGHLIGHT>";
}
if($op=='d'){
	echo "<Select name=\"particulars\" id=\"p\" onChange=\"activeDiv(this.value);\">";
	echo "<option value=\"ca\">cash</option>";
	echo "<option value=\"i\">int.</option>";
	echo "<td align=\"left\">Deposits:<td><input type=\"TEXT\" name=\"deposit\" size=\"20\" id=\"amount\" value=\"\" $HIGHLIGHT><br>";
	}
echo "<input type=\"hidden\" name=\"balance\"  value=\"$balance\" id=\"bal\">";
echo "<input type=\"hidden\" name=\"op\"  id=\"op\" value=\"$op\" >";
echo "<tr><td valign=\"middle\" align=\"left\" colspan=3>Remarks:&nbsp<textarea name=\"remarks\" rows=\"2\" cols=\"35\" $HIGHLIGHT></textarea>";
echo "<td valign=\"middle\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Submit\">";
echo "</table>";
echo "</form>";
echo "</body>";
echo "</html>";
?>
<script language="JAVASCRIPT">
function varify_sb(f){
if((document.getElementById("action_date").value).length==0){
	alert("Date Should not be Null !!!!!")
	document.getElementById("action_date").focus();
	return false;
}
var amount=document.getElementById("amount").value;
var op=document.getElementById("op").value;
var bal=document.getElementById("bal").value;

if (IsPNumeric(amount)){
    if(op=='w'){
 		amount=parseFloat(amount);
		bal=parseFloat(bal);
		if(amount>bal){
		alert("Amount Must Be lower than from current Balance\nYou Curren Balance is: Rs. "+bal)
		document.getElementById("amount").focus();
		return false;
		}
		
	 
  	}
}
else{
	alert("Amount Must Be Positive Numeric Value")
	document.getElementById("amount").focus();
	return false;
		
	}

}
</script>

