<?php
include "../config/config.php";
$staff_id=verifyAutho();
$account_no=$_REQUEST['account_no'];
$withdrawal=$_REQUEST["withdrawal"];

$op=$_REQUEST["op"];
$action_date=$_REQUEST['action_date'];
$operation=$_REQUEST['o'];
$menu=$_REQUEST['menu'];
$id=$_REQUEST['id'];
$tranfer_to=$_REQUEST['bank_ac_no'];
echo "<html>";
echo "<head>";
echo "<title>".getName('link_tb',$id,'b_name','bank_bk_dtl')." bank's ".strtoupper($menu)." Account[$account_no]";
echo "</title>";
?>
<script>
  function myRefresh(URL){
    window.opener.location.href =URL;
    self.close();
    }
</script>
<?php
echo "<script src=\"../JS/validation.js\">";
echo "</script>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"amount.focus();\">";
if($operation=='i'){
	$fy=getFy($action_date);
	if(empty($fy)){
	echo "<h1><center><b>You Can't Insert any value Into database Because Financial Year already Locked by administrator !!!!!!!!!";
}
	else{
		$t_id=getTranId();
		$gl_code_from=getGlCode4mBank($account_no);
		$gl_code_to=getGlCode4mBank($tranfer_to);
		$ch_dt=(empty($_REQUEST['ch_dt']))?$DOB_DEFAULT:$_REQUEST['ch_dt'];
		$sql_statement="INSERT INTO gl_ledger_hrd(tran_id,type,action_date,fy,remarks, cheque_no,cheque_dt,operator_code,entry_time) VALUES ('$t_id','csb','$action_date','$fy', '$remarks','$ch_no','$ch_dt','$staff_id',CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
		
		$sql_statement.=";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr,particulars) VALUES('$t_id','$tranfer_to', '$gl_code_to',$withdrawal,'Dr','transfer')";
		$sql_statement.=";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','$account_no', '$gl_code_from',$withdrawal,'Cr','transfer')";
			
		     
	//echo $sql_statement;
	$result=dBConnect($sql_statement);
	if(pg_affected_rows($result)<1) {
	echo "<br><h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
	} 
	else {
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
echo "<form name=\"form1\" method=\"POST\" action=\"transfer.php?menu=$menu&id=$id&op=$op&o=i&account_no=$account_no\" onSubmit=\"return varify_sb(this.form);\">";
echo "<table bgcolor=#FAF0E6 width=100% align=center>";
echo "<tr><th colspan=4 bgcolor=Yellow>Transfer Form of ".strtoupper($menu)."<font size=+2> [$account_no]</font> Current balance:Rs. <font size=+2>$balance/=</font></th></tr>";
echo "<tr><td align=\"left\">Transfer From:<td><input type=\"TEXT\" name=\"account_no\" size=\"15\" value=\"$account_no\" disabled $HIGHLIGHT><br>";
echo "<td align=\"left\">Transfer To:<td>";
selectBankAccount('bank_ac_no','',$account_no);
echo "<tr>";
echo "<td align=\"left\">Date:<td><input type=\"TEXT\" id=\"action_date\" name=\"action_date\" size=\"12\" value=\"".date('d.m.Y')."\" $HIGHLIGHT>";
echo "&nbsp;&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(form1.action_date,'dd/mm/yyyy','Choose Date')\"><br>";
echo "<td align=\"left\">Transfer amount:<td><input type=\"TEXT\" name=\"withdrawal\" size=\"20\" id=\"amount\" value=\"\" $HIGHLIGHT><br>";
echo "<input type=\"hidden\" name=\"op\"  id=\"op\" value=\"$op\" >";
echo "<tr><td valign=\"middle\" align=\"left\" colspan=3>Remarks:&nbsp<textarea name=\"remarks\" rows=\"2\" cols=\"35\" $HIGHLIGHT></textarea>";
echo "<input type=\"hidden\" name=\"balance\"  value=\"$balance\" id=\"bal\">";
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
var bal=document.getElementById("bal").value;
if (IsPNumeric(amount)){
   amount=parseFloat(amount);
   bal=parseFloat(bal);
   if(amount>bal){
		alert("Amount Must Be lower than from current Balance\nYou Curren Balance is: Rs. "+bal)
		document.getElementById("amount").focus();
		return false;
		}
		
	 
  	}

else{
	alert("Amount Must Be Positive Numeric Value")
	document.getElementById("amount").focus();
	return false;
		
	}

}
</script>
