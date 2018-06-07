<?php
include "../config/config.php";
$staff_id=verifyAutho();
//isPermissible($menu);
if(empty($_REQUEST['account_no'])){
	$group_no=$_SESSION["current_account_no"];
	}
else{
	$group_no=$_REQUEST['account_no'];
	$_SESSION["current_account_no"]=$group_no;
 }
//$group_no=$_SESSION["current_account_no"];
//$account_no=$_REQUEST['group_no'];
$menu=$_REQUEST['menu'];
$loan_limit=$_REQUEST['loan_limit'];
$type=$_REQUEST['type'];
//$typecrop=$_REQUEST['type2'];
$a_amount=$_REQUEST['a_amount'];
$loan_amount=$_REQUEST['loan_amount'];
$o_d_r=$_REQUEST['o_d_r'];
$d_r=$_REQUEST['d_r'];
$repay_date=$_REQUEST['repay_date'];
$purpose=$_REQUEST['purpose'];
$op=$_REQUEST['op'];
$action_date=$_REQUEST['date_of_issue'];
$period=$_REQUEST['period'];
$cid=$_REQUEST['cid'];

if(empty($group_no)){$group_no=$account_no;}
echo "<html>";
echo "<head>";
?>
<script language="JAVASCRIPT">
function beforeVarify(){
	if(document.form1.d_r.value.length==0||!(IsPNumeric(document.form1.d_r.value))){
	alert("Due Interest Rate Should not be Blank or\nshould not other than numeric value!!!!!");
	document.form1.d_r.value="";
	document.form1.d_r.focus();
	return false;
	}
	if(document.form1.o_d_r.value.length==0||!(IsPNumeric(document.form1.o_d_r.value))){
	alert("Over Due Interest Rate Should not be Blank or\nshould not other than numeric value!!!!!");
	document.form1.o_d_r.value="";
	document.form1.o_d_r.focus();
	return false;
	}
	if(document.form1.a_amount.value.length==0||!(IsPNumeric(document.form1.a_amount.value))){
	alert("Applied Amount Should not be Blank or\nshould not other than numeric value!!!!!");
	document.form1.a_amount.value="";
	document.form1.a_amount.focus();
	return false;
	}
	if(document.form1.loan_amount.value.length==0||!(IsPNumeric(document.form1.loan_amount.value))){
	alert("Loan Amount Should not be Blank or\nshould not other than numeric value!!!!!");
	document.form1.loan_amount.value="";
	document.form1.loan_amount.focus();
	return false;
	}
	if(document.form1.repay_date.value.length==0||!(IsPNumeric(document.form1.repay_date.value))){
	alert("Loan Repay Period Should not be Blank or\nshould not other than numeric value!!!!!");
	document.form1.repay_date.value="";
	document.form1.repay_date.focus();
	return false;
	}
	var ap_amount=parseFloat(document.form1.a_amount.value);
	var l_amount=parseFloat(document.form1.loan_amount.value);
	var l_limit=parseFloat(document.form1.loan_limit.value);
       	if(ap_amount>l_limit){
		alert("Loan Limit should not be less than Applied Amount!!!!");
		document.form1.a_amount.value="";
		document.form1.a_amount.focus();
		return false;
	}
	if(l_amount>ap_amount){
	alert("Loan Amount should not be more than Applied Amount!!!!! ");
	document.form1.loan_amount.value="";
	document.form1.loan_amount.focus();
	return false;
	}
	
}
</script>
<?php
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"a_amount.focus();\">";
$c_id=getCustomerIdFromGroupId($group_no);
$flag1=getGeneralInfo_Customer($c_id);
if($flag1==1){
	echo "<hr>";
/***********************************FIRST FORM *********************************************/
	if(empty($op)){
	$flag=1;
		if($flag){
			$ROWCOLOR="CC99FF";
			$THCOLOR="FF9900";
			echo "<form method=\"POST\" name=\"form1\" action=\"loan_ledger_ef.php?menu=$menu&op=v\" onSubmit=\"return beforeVarify();\">";
			echo "<table bgcolor=BLACK align=center width=75%>";
			echo "<tr><TH colspan=4 bgcolor=$THCOLOR><font color=WHITE size=+2><b>JGL Loan Issue Form";
			echo "<tr><td align=\"left\" bgcolor=$ROWCOLOR>Group No:<td bgcolor=$ROWCOLOR><input type=\"TEXT\" name=\"group_no\" size=\"8\" value=\"$group_no\"  READONLY $HIGHLIGHT>";
			echo "<td align=\"left\" bgcolor=$ROWCOLOR>Loan Type:<td bgcolor=$ROWCOLOR>";
			makeSelect($jlgl_type_array,'type','');//($shgl_type_array,'type');
			//echo "<tr><td align=\"left\">Loan Limit:<td>Rs.&nbsp;<input type=\"TEXT\" name=\"loan_limit\" size=\"8\" value=\"".shg_loan_limit($group_no)."\"  $HIGHLIGHT>";
			echo "<tr><td align=\"left\" bgcolor=$ROWCOLOR>Loan Issued Date:<td bgcolor=$ROWCOLOR><input type=\"TEXT\" name=\"date_of_issue\" size=\"12\" value=\"".date('d/m/Y')."\"  $HIGHLIGHT><td colspan=\"2\" bgcolor=$ROWCOLOR>";
			echo "<tr><td align=\"left\" bgcolor=$ROWCOLOR>Interest Rate:<td bgcolor=$ROWCOLOR>Rs.&nbsp;<input type=\"TEXT\" name=\"d_r\" size=\"5\" value=\"7\" $HIGHLIGHT>&nbsp;%";
			echo "<td align=\"left\" bgcolor=$ROWCOLOR>Over DueInterest Rate:<td bgcolor=$ROWCOLOR>Rs.&nbsp;<input type=\"TEXT\" name=\"o_d_r\" size=\"5\" value=\"11\" $HIGHLIGHT>&nbsp;%";
			echo "<tr><td align=\"left\" bgcolor=$ROWCOLOR>Applied Amount:<td bgcolor=$ROWCOLOR>Rs.&nbsp;<input type=\"TEXT\" name=\"a_amount\" size=\"8\" value=\"$a_amount\" id=\"a_amount\" $HIGHLIGHT>";
			echo "<td align=\"left\" bgcolor=$ROWCOLOR>Issued Amount:<td bgcolor=$ROWCOLOR>Rs.&nbsp;<input type=\"TEXT\" name=\"loan_amount\" size=\"8\" value=\"$loan_amount\" $HIGHLIGHT>";
			echo "<tr><td align=\"left\" bgcolor=$ROWCOLOR>Loan Repayment Period :<td bgcolor=$ROWCOLOR><input type=\"TEXT\" name=\"repay_date\" size=\"3\"  $HIGHLIGHT>&nbsp;<font color=RED size=-1>Month</font>";
			echo "<td align=\"left\" bgcolor=$ROWCOLOR>Purpose :<td bgcolor=$ROWCOLOR><input type=\"TEXT\" name=\"purpose\" size=\"15\" value=\"Business\" $HIGHLIGHT>";
echo "<tr><td align=\"left\" bgcolor=$ROWCOLOR>Crop Id:<td bgcolor=$ROWCOLOR>";
	//makeSelectSubmit4mdb('crop_id','crop_desc','crop_mas','cid');
makeSelect($crop_array,'typecrop','');
			echo "<td colspan=\"4\" align=\"right\" bgcolor=$ROWCOLOR><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Enter\">";
			echo "  <input type=\"RESET\" name=\"RESET_BUTTON\" value=\"Reset\"><br>";		
			echo "</table>";
			echo "</form>";
 			}

//******************************* for not eligible for loan**********************************
	else{
	      echo "<h1><b><font color=Red><center><blink>You Are Not Eligible for loan</blink></b><center></font></h1>";
              echo "<h2><center><b>You Will come after :$loan_el_date</h2></center></b>";
	      echo "<a href=\"../main/nextaccount.php?menu=shg\">BACK</a>";
	   }
    }
//**********************verifying the the entry**********************************************
if ($op=='v'){
$ROWCOLOR="CCCCFF";
$THCOLOR="CC00FF";
echo "<form name=\"orderform\" method=\"POST\" action=\"loan_ledger_ef.php?menu=$menu&op=i\" onSubmit=\"return varify();\">";
echo "<table bgcolor=black align=center width=95%>";
echo "<tr><TH colspan=6 bgcolor=$THCOLOR><font color=WHITE><b>JGL Loan Issue Summary Form";
echo "<tr bgcolor=$ROWCOLOR><td align=\"left\">Group No:<td><input type=\"TEXT\" name=\"group_no\" size=\"8\" value=\"$group_no\"  $HIGHLIGHT>";
echo "<td align=\"left\">Loan Type:<td><input type=\"TEXT\" name=\"type1\" size=\"20\" value=\"".$type."\"  $HIGHLIGHT>";
echo "<td align=\"left\">Loan Issued Date:<td><input type=\"TEXT\" name=\"date_of_issue\" size=\"12\" value=\"$action_date\"  $HIGHLIGHT>";
echo "<tr bgcolor=$ROWCOLOR><td align=\"left\">Interest Rate:<td>Rs.&nbsp;<input type=\"TEXT\" name=\"d_r\" size=\"5\" value=\"$d_r\" $HIGHLIGHT >&nbsp;%";
echo "<td align=\"left\">Over DueInterest Rate:<td>Rs.&nbsp;<input type=\"TEXT\" name=\"o_d_r\" size=\"5\" value=\"$o_d_r\" $HIGHLIGHT >&nbsp;%";
echo "<td align=\"left\">Purpose :<td><input type=\"TEXT\" name=\"purpose\" size=\"15\" value=\"$purpose\" $HIGHLIGHT >";
echo "<input type=\"HIDDEN\" name=\"loan_limit\" size=\"8\" value=\"".$loan_limit."\"  $HIGHLIGHT>";
echo "<tr bgcolor=$ROWCOLOR><td align=\"left\">Applied Amount:<td>Rs.&nbsp;<input type=\"TEXT\" name=\"a_amount\" size=\"8\" value=\"$a_amount\" id=\"applied_amount\"  $HIGHLIGHT>";
echo "<td align=\"left\">Issued Amount:<td>Rs.&nbsp;<input type=\"TEXT\" name=\"loan_amount\" size=\"8\" value=\"$loan_amount\"  $HIGHLIGHT>";
echo "<td align=\"left\">Loan Repayment Period :<td><input type=\"TEXT\" name=\"repay_date\" size=\"12\" value=\"$repay_date\" $HIGHLIGHT>&nbsp;Months";
echo "<tr bgcolor=\"$ROWCOLOR\"><td colspan=\"6\" align=\"center\">Crop:<input type=\"TEXT\" name=\"type2\" size=\"20\" value=\"".$typecrop."\"  $HIGHLIGHT>";
echo "</table>";
echo "<table align=center width=95% BGCOLOR=\"BLACK\">";
$ROWCOLOR="999933";
$THCOLOR="CC00FF";
echo "<tr><TH colspan=6 bgcolor=\"FF66CC\"><font color=WHITE><b>JGL Loan Issue Details Form";
$c_id=getCustomerIdFromGroupId($group_no);
$no_mem=getSHGMember($c_id);
$sql_statement="SELECT a.customer_id,a.type_of_customer,a.name1,a.designation1,
a.father_name1,a.address11,b.gl_mas_code,b.account_no
FROM customer_master a,customer_account b WHERE a.remarks=b.customer_id 
and type_of_customer='$group_no' and account_type='sb' and status='op'
order by customer_id";

$result=dBConnect($sql_statement);
echo $sql_statement; 
if(pg_NumRows($result)>0){

for($j=0; $j<pg_NumRows($result); $j++){
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
	

echo "<tr bgcolor=$color>";
$sl_no=$row['customer_id'];
$acc=$row['account_no'];
$sb_gl=$row['gl_mas_code'];
echo "<td align=right><input type=\"checkbox\" name=\"music\" value=\"$sl_no\" onclick=\"ShowInfo(this.value);\">$sl_no";
echo "<td >".ucwords($row['name1']);
echo " ( ".ucwords($row['designation1']).")";
echo "<td >".ucwords($row['father_name1']);
echo "<td >".ucwords($row['address11']);
echo "<td align=right><input type=\"HIDDEN\" name=\"acc\" value=\"$acc\">$acc";
echo "<input type=\"HIDDEN\" name=\"gl\" id=\"gl\" value=\"$sb_gl\">";
echo "<td>Amount :<input type=text name=\"name\" disabled $HIGHLIGHT>";
}
echo "<tr bgcolor=\"CC00FF\"r><td colspan=\"6\" align=\"right\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Enter\">";
echo "<input type=\"HIDDEN\" value=\"\" name=\"member_info\" id=\"member_info\">";
echo "<input type=\"HIDDEN\" value=\"\" name=\"member_amount\" id=\"member_amount\">";
echo "<input type=\"HIDDEN\" value=\"\" name=\"acc_array\" id=\"acc_array\">";
echo "<input type=\"HIDDEN\" value=\"\" name=\"gl_array\" id=\"gl_array\">";
echo "</table>";
echo "</form>";
	}
}

/************************************INSERTING INTO DATABASE *******************************/
if($op=='i'){
	$member_id=$_REQUEST['member_info'];
	$sb_id=$_REQUEST['acc_array'];
	$sb_code=$_REQUEST['gl_array'];
	$type= $_REQUEST['type1'];
	$typecrop= $_REQUEST['type2'];
	$member_amount=$_REQUEST['member_amount'];
	$member_id=explode(",",$member_id);
	$sb_id=explode(",",$sb_id);
        $sb_code=explode(",",$sb_code);
	$member_amount=explode(",",$member_amount);
	$type=getIndex($jlgl_type_array,$type);
//echo $typecrop;exit();
	$fy=getFy();
	if(empty($fy)){
		echo "<h1><center><b>You Can't Insert any value Into database Because Financial Year already Locked by administrator !!!!!!!!!";
}
	else{
		$t_id=getTranId();
		$loan_sl_no=nextValue('loan_sl_no');
		$account_no=getId('jgl');
		$period=maturity_date($action_date,$repay_date,'m');

$sql_statement.="INSERT INTO gl_ledger_hrd(tran_id,type,action_date,fy, remarks,operator_code,entry_time) VALUES ('$t_id','shg','$action_date','$fy','$remarks', '$staff_id',CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
//One By One DATA SENT INTO shg_member_loan_ledger_table 
		for($i=0;$i<count($member_id);$i++){
			echo $member_id[$i];
			echo $sb_id[$i];
			//for shg_loan_ledger_herader
			if($i>0){$sql_statement.=";";}
			$sql_statement.=";INSERT INTO shg_loan_ledger_hrd VALUES('$loan_sl_no','".$member_id[$i]."','$account_no','$group_no','$action_date',$repay_date,'$period',$d_r,$o_d_r,'op','$staff_id', CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
			//For shg_loan_ledger_dtl
			$sql_statement.=";INSERT INTO shg_loan_ledger_dtl(tran_id, loan_sl_no,member_id, action_date,loan_amount,b_principal,staff_id,entry_time)VALUES('$t_id','$loan_sl_no','".$member_id[$i]."','$action_date',".$member_amount[$i].",".$member_amount[$i].",'$staff_id',CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";

$sql_statement.=";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars,account_no) VALUES('$t_id','".$sb_code[$i]."',".$member_amount[$i].",'Cr','jlg issue','".$sb_id[$i]."')";

			//echo "<h1>$i</h1>:$sql_statement";
			}
// Customer Account For loan account Opening
		$sql_statement.=";INSERT INTO customer_account(customer_id,account_type,opening_date, account_no,gl_mas_code,remarks, status,operator_code,entry_time) VALUES ('$c_id','jgl', '$action_date','$account_no','$type','$remarks','op','$staff_id', CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
//loan_ledger_hrd
		$sql_statement=$sql_statement.";INSERT INTO loan_ledger_hrd(loan_serial_no,customer_id,loan_type, account_no,fy,issue_date,crop_id,int_due_rate,int_overdue_rate, applied_amount,repay_date,period,staff_id,status,entry_time,gl_code,gl_status)VALUES('$loan_sl_no','$c_id','jgl','$account_no','$fy','$action_date','$typecrop',$d_r,$o_d_r,$a_amount,'$period','$repay_date','$staff_id','op',CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP),'$type','d')";
//loan_issue_dtl
		$sql_statement.=";INSERT INTO loan_issue_dtl(tran_id,loan_serial_no,account_no,action_date,loan_amount,b_principal,staff_id,entry_time)VALUES('$t_id','$loan_sl_no','$account_no','$action_date',$loan_amount,$loan_amount,'$staff_id',CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";

//gl_ledger_hrd
		//$sql_statement=$sql_statement.";INSERT INTO gl_ledger_hrd(tran_id,type,action_date,fy, remarks,operator_code,entry_time) VALUES ('$t_id','shg','$action_date','$fy','$remarks', '$staff_id',CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";

//gl_ledger_dtl
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code, amount,dr_cr, particulars) VALUES('$t_id','$account_no','$type',$loan_amount,'Dr','loan issue')";
		//$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','28101',$loan_amount,'Cr','loan issue')";

//echo $sql_statement;
//echo $type;
		$result=dBConnect($sql_statement);
		if(pg_affected_rows($result)<1) {
			echo "<br><font size=+3 color=\"RED\">Failed to insert data into database.</font></h5>";
			} 
		else {
			echo "<font size=-1 color=\"GREEN\"><B>Successfully inserted data into database.</font>";
			echo "<br><font size=+1>Transaction No.:<b>$t_id";
			echo "<br><font size=+1>Loan Account No.:<b>".$account_no;
			echo "<br><font size=+1>Loan Repayement Date:<b>$period";
			echo "<br><font size=+1>Loan Amount:Rs. ".amount2Rs($loan_amount)."/=";
			echo "<br><a href=\"jlg_mem_detail.php\">Click</a> Here go to the statement";
			}

		}
	}
}
?>
<script language="javascript">
function ShowInfo(){
	if(document.orderform.music.length>1){
		for (var i=0; i < document.orderform.music.length; i++){
	   		if (document.orderform.music[i].checked){
			document.orderform.name[i].disabled=false;
			document.orderform.name[i].focus();
			}
			else{
			document.orderform.name[i].value='';
			document.orderform.name[i].disabled=true;
			}
		}
	}
     	else{document.orderform.name[i].value
		if (document.orderform.music.checked){
			document.orderform.name.disabled=false;
			document.orderform.name.focus();
			}
		else{
			document.orderform.name.value='';
			document.orderform.name.disabled=true;
			}
			
	   }
}
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
		var loan_amount=parseFloat(document.orderform.loan_amount.value);
		var flag;
		var c_value = "";
		var c_account = "";
		var c_code=""
		var c_amount="";
		var amount=0;
		if(document.orderform.music.length>1){
		for (var i=0; i < document.orderform.music.length; i++){
	   		if (document.orderform.music[i].checked){
				 if(IsPNumeric(document.orderform.name[i].value)){
				 if(c_value!=""){
				 c_value=c_value+',';
				c_account=c_account+',';
				c_code=c_code+',';
				 c_amount=c_amount+',';
					    }
				 c_value = c_value + document.orderform.music[i].value;
				 c_account = c_account + document.orderform.acc[i].value;
				 c_code = c_code + document.orderform.gl[i].value;
				 c_amount=c_amount+ document.orderform.name[i].value;
				 amount=amount+parseFloat(document.orderform.name[i].value);
		     		 flag=1;
      					}
				else{
					alert("Please Enter the amount or put off the check mark");
					document.orderform.name[i].value='';
					document.orderform.name[i].focus();
					return false;
				     }
				}

			}
		}
		else{
			if (document.orderform.music.checked){
				if(IsPNumeric(document.orderform.name.value)){
				c_value = c_value + document.orderform.music.value;
				c_account = c_account + document.orderform.acc.value;
				c_code = c_code + document.orderform.gl.value;
				c_amount=c_amount+ document.orderform.name.value;
				amount=amount+parseFloat(document.orderform.name.value);
				flag=1;
				}
				else{
				alert("Please Enter the amount or put off the check mark");
					document.orderform.name.value='';
					document.orderform.name.focus();
					return false;
				}
			}		
   		}
		if(flag!=1){
		alert("You must Select atleast one Member to Issue the entire loan Amount!!!!!!!! ");
		return false;
	 	}
		if(amount!=loan_amount){
		alert("Loan amount is not match to allocated amount !!!!!!\nGroup Loan Amount is :Rs. "+loan_amount+"\n But you Allocate :Rs. "+amount);
		return false;
		}
		document.getElementById("member_info").value=c_value;
		document.getElementById("acc_array").value=c_account;
		document.getElementById("gl_array").value=c_code;
		document.getElementById("member_amount").value=c_amount;
	
	}
</script>	
<?php
echo "</body>";
echo "</html>";
?>
