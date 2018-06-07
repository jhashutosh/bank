<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$account_no=$_REQUEST['account_no'];
$group_no=$_SESSION["current_account_no"];
$fy=$_SESSION["fy"];
$type=$_REQUEST['type'];
$gl_code_loan=$_REQUEST['gl_code_loan'];
$crop_id=$_REQUEST['crop_id'];
$due_int=$_REQUEST['d_int_r'];
$overdue_int=$_REQUEST['od_int_r'];
$action_date=$_REQUEST['action_date'];
$repay_date=$_REQUEST['repay_date'];
$amount=$_REQUEST['amount'];
$issued_amount=$_REQUEST['issued_amount'];
$balance_p=$_REQUEST['bal_p'];
$b_d_int=$_REQUEST['bal_d_int'];
$b_od_int=$_REQUEST['bal_od_int'];
$curr_date='31.03.2011';
$r_d_int=$_REQUEST['r_d_int'];
$r_od_int=$_REQUEST['r_od_int'];
$member_info=$_REQUEST['member_info'];
$m_loan_amount=$_REQUEST['m_loan_amount'];
$m_r_d_i=$_REQUEST['m_r_d_i'];
$m_r_od_i=$_REQUEST['m_r_od_i'];
$m_b_p=$_REQUEST['m_b_p'];
$m_b_d_i=$_REQUEST['m_b_d_i'];
$m_b_od_i=$_REQUEST['m_b_od_i'];
echo "<html>";
echo "<head>";
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";
echo "<script src=\"../JS/validation.js\"></script>";
?>
<script language="javascript">
function ShowInfo(){
	if(document.orderform.music.length>1){
		for (var i=0; i < document.orderform.music.length; i++){
	   		if (document.orderform.music[i].checked){
			document.orderform.loan_amount[i].disabled=false;
			document.orderform.r_d_i[i].disabled=false;
			document.orderform.r_od_i[i].disabled=false;
			document.orderform.b_d_i[i].disabled=false;
			document.orderform.b_od_i[i].disabled=false;
			document.orderform.b_p[i].disabled=false;
			document.orderform.loan_amount[i].focus();
			}
			else{
			document.orderform.loan_amount[i].value='';
			document.orderform.loan_amount[i].disabled=true;
			document.orderform.r_d_i[i].value='';
			document.orderform.r_d_i[i].disabled=true;
			document.orderform.r_od_i[i].value='';
			document.orderform.r_od_i[i].disabled=true;
			document.orderform.b_d_i[i].value='';
			document.orderform.b_d_i[i].disabled=true;
			document.orderform.b_od_i[i].value='';
			document.orderform.b_od_i[i].disabled=true;
			document.orderform.b_p[i].value='';
			document.orderform.b_p[i].disabled=true;
			}
		}
	}
     	else{
		if (document.orderform.music.checked){
			document.orderform.loan_amount.disabled=false;
			document.orderform.r_d_i.disabled=false;
			document.orderform.r_od_i.disabled=false;
			document.orderform.b_d_i.disabled=false;
			document.orderform.b_od_i.disabled=false;
			document.orderform.b_p.disabled=false;
			document.orderform.loan_amount.focus();
			}
		else{
			document.orderform.loan_amount.value='';
			document.orderform.loan_amount.disabled=true;
			document.orderform.r_d_i.value='';
			document.orderform.r_d_i.disabled=true;
			document.orderform.r_od_i.value='';
			document.orderform.r_od_i.disabled=true;
			document.orderform.b_d_i.value='';
			document.orderform.b_d_i.disabled=true;
			document.orderform.b_od_i.value='';
			document.orderform.b_od_i.disabled=true;
			document.orderform.b_p.value='';
			document.orderform.b_p.disabled=true;
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
		var t_bal_p=parseFloat(document.orderform.bal_p.value);
		var t_bal_d_int=parseFloat(document.orderform.bal_d_int.value);
		var t_bal_od_int=parseFloat(document.orderform.bal_od_int.value);
		var t_r_od_int=parseFloat(document.orderform.r_od_int.value);
		var t_r_due_int=parseFloat(document.orderform.r_d_int.value);
		var t_loan_amount=parseFloat(document.orderform.issued_amount.value);
		var flag;
		var c_value ="";
		var bal_p="";
		var bal_d_i="";
		var bal_od_i="";
		var r_d_i="";
		var r_od_i="";
		var p_amount="";
		var bal_amount=0;
		var bal_due_int=0;
		var bal_od_int=0;
		var l_amount=0;
		var r_due_int=0;
		var r_od_int=0;
		
		if(document.orderform.music.length>1){
		for (var i=0; i < document.orderform.music.length; i++){
	   		if (document.orderform.music[i].checked){
				 if(IsPNumeric(document.orderform.loan_amount[i].value)&&IsPNumeric(document.orderform.r_d_i[i].value)&&IsPNumeric(document.orderform.r_od_i[i].value)&&IsPNumeric(document.orderform.b_d_i[i].value)&&IsPNumeric(document.orderform.b_od_i[i].value)&&IsPNumeric(document.orderform.b_p[i].value)){
				 if(c_value!=""){
				 c_value=c_value+',';
				 p_amount=p_amount+',';
				 bal_p=bal_p+',';
				 bal_d_i=bal_d_i+',';
				 bal_od_i=bal_od_i+',';
				 r_d_i=r_d_i+',';
				 r_od_i=r_od_i+',';
				 }
				 c_value = c_value + document.orderform.music[i].value;
				 //alert(c_value);
				 p_amount=p_amount+ document.orderform.loan_amount[i].value;
				 bal_p=bal_p+document.orderform.b_p[i].value;
				 bal_d_i=bal_d_i+document.orderform.b_d_i[i].value;
				 bal_od_i=bal_od_i+document.orderform.b_od_i[i].value;
				 r_d_i=r_d_i+document.orderform.r_d_i[i].value;
				 r_od_i=r_od_i+document.orderform.r_od_i[i].value;
				 bal_amount=bal_amount+parseFloat(document.orderform.b_p[i].value);
				 bal_due_int=bal_due_int+parseFloat(document.orderform.b_d_i[i].value);
				 bal_od_int=bal_od_int+parseFloat(document.orderform.b_od_i[i].value);
				 r_od_int=r_od_int+parseFloat(document.orderform.r_od_i[i].value);
				 r_due_int=r_due_int+parseFloat(document.orderform.r_d_i[i].value);
				 l_amount=l_amount+parseFloat(document.orderform.loan_amount[i].value);
		     		 flag=1;
      					}
				else{
					alert("Please Enter the amount or put off the check mark");
					document.orderform.loan_amount[i].value='';
					document.orderform.r_d_i[i].value='';
					document.orderform.r_od_i[i].value='';
					document.orderform.b_d_i[i].value='';
					document.orderform.b_od_i[i].value='';
					document.orderform.b_p[i].value='';
					document.orderform.loan_amount[i].focus();
					return false;
				     }
				}

			}
		}
		else{
			if (document.orderform.music.checked){
				if(IsPNumeric(document.orderform.loan_amount.value)&&IsPNumeric(document.orderform.r_d_i.value)&&IsPNumeric(document.orderform.r_od_i.value)&&IsPNumeric(document.orderform.b_d_i.value)&&IsPNumeric(document.orderform.b_od_i.value)&&IsPNumeric(document.orderform.b_p.value)){
				 c_value = c_value + document.orderform.music.value;
				 p_amount=p_amount+ document.orderform.loan_amount.value;
				 bal_p=bal_p+document.orderform.b_p.value;
				 bal_d_i=bal_d_i+document.orderform.b_d_i.value;
				 bal_od_i=bal_od_i+document.orderform.b_od_i.value;
				 r_d_i=r_d_i+document.orderform.r_d_i.value;
				 r_od_i=r_od_i+document.orderform.r_od_i.value;
				 bal_amount=bal_amount+parseFloat(document.orderform.b_p.value);
				 bal_due_int=bal_due_int+parseFloat(document.orderform.b_d_i.value);
				 bal_od_int=bal_od_int+parseFloat(document.orderform.b_od_i.value);
				 r_od_int=r_od_int+parseFloat(document.orderform.r_od_i.value);
				 r_due_int=r_due_int+parseFloat(document.orderform.r_d_i.value);
				 l_amount=l_amount+parseFloat(document.orderform.loan_amount.value);
		     		 flag=1;
				}
				else{
					alert("Please Enter the amount or put off the check mark");
					document.orderform.loan_amount.value='';
					document.orderform.r_d_i.value='';
					document.orderform.r_od_i.value='';
					document.orderform.b_d_i.value='';
					document.orderform.b_od_i.value='';
					document.orderform.b_p.value='';
					document.orderform.loan_amount.focus();
					return false;
				}
			}		
   		}
		if(flag!=1){
		alert("You must Select atleast one Member to Issue the entire loan Amount!!!!!!!! ");
		return false;
	 	}
		if(t_loan_amount!=l_amount){
		alert("Loan amount is not match to allocated amount !!!!!!\nGroup's Total Loan Amount is :Rs. "+t_loan_amount+"\n But you Allocate :Rs. "+l_amount);
		return false;
		}
		if(t_r_due_int!=r_due_int){
		alert("Recovery due Interest is not match to allocated due interest !!!!!!\nGroup's Total due Interest is :Rs. "+t_r_due_int+"\n But you Allocate :Rs. "+r_due_int);
		return false;
		}
		if(t_r_od_int!=r_od_int){
		alert("Recovery Over due Interest is not match to allocated over due interest !!!!!!\nGroup's Total due Interest is :Rs. "+t_r_od_int+"\n But you Allocate :Rs. "+r_od_int);
		return false;
		}
		
		if(t_bal_d_int!=bal_due_int){
		alert("Loan Due Interest is not match to allocated due Interest !!!!!!\nGroup's Total Due Interest is :Rs. "+t_bal_d_int+"\n But you Allocate :Rs. "+bal_due_int);
		return false;
		}
		if(t_bal_od_int!=bal_od_int){
		alert("Loan Over Due Interest is not match to allocated OD Interest !!!!!!\nGroup's Total OD Interest is :Rs. "+t_bal_od_int+"\n But you Allocate :Rs. "+bal_od_int);
		return false;
		}
		if(t_bal_p!=bal_amount){
		alert("Balance Loan amount is not match to allocated amount !!!!!!\nGroup's Total Loan Amount is :Rs. "+t_bal_p+"\n But you Allocate :Rs. "+bal_amount);
		return false;
		}
		
		document.getElementById("member_info").value=c_value;
		document.getElementById("m_loan_amount").value=p_amount;
		document.getElementById("m_r_d_i").value=r_d_i;
		document.getElementById("m_r_od_i").value=r_od_i;
		document.getElementById("m_b_p").value=bal_p;
		document.getElementById("m_b_d_i").value=bal_d_i;
		document.getElementById("m_b_od_i").value=bal_od_i;
	}
</script>	
<?php
echo "<title></title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
$c_id=getCustomerIdFromJLGId($group_no);
$flag1=getGeneralInfo_Customer($c_id);
if($flag1==1){
echo "<hr>";
echo "<body bgcolor=\"silver\"\" onload=\"account_no.focus();\">";
//==========================here Inserting Data into Database==================================
if($_REQUEST['op']=='i'){
	$member_info=explode(",",$member_info);
	$m_loan_amount=explode(",",$m_loan_amount);
	$m_r_d_i=explode(",",$m_r_d_i);
	$m_r_od_i=explode(",",$m_r_od_i);
	$m_b_p=explode(",",$m_b_p);
	$m_b_d_i=explode(",",$m_b_d_i);
	$m_b_od_i=explode(",",$m_b_od_i);
	$type=getIndex($jlgl_type_array,$type);
       if($gl_code_loan=='d'){
	$gl_code_loan=$type;
	$gl_status='d';
	}
	else{
	$gl_status='o';
	$gl_code_loan=$type+1;
	}
	$r_principal=$issued_amount-$balance_p;
	$loan_sl_no=$_REQUEST['loan_sl_no'];
	if(empty($loan_sl_no)){	$loan_sl_no=nextValue('loan_sl_no');}
	$t_id=getTranId();
	//$repay_date=maturity_date($action_date,$repay_date,'m');
	
	for($i=0;$i<count($member_info);$i++){
	if($i>0){$sql_statement.=";";}
	//print_r ($member_info);
	//echo "COUNT=".count($member_info);
echo $crop_id;
	$sql_statement.="INSERT INTO jlg_loan_ledger_hrd VALUES('$loan_sl_no','".$member_info[$i]."','$account_no','$group_no','$action_date',0,'$repay_date',$due_int,$overdue_int,'op','$staff_id', CAST('$curr_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
	//For shg_loan_ledger_dtl
	$sql_statement.=";INSERT INTO jlg_loan_ledger_dtl(tran_id, loan_sl_no,member_id, action_date,loan_amount,r_principal,r_d_int,r_od_int,b_principal,b_d_int,b_od_int,staff_id,entry_time)VALUES('$t_id','$loan_sl_no','".$member_info[$i]."','$curr_date',".$m_loan_amount[$i].",".($m_loan_amount[$i]-$m_b_p[$i]).",".$m_r_d_i[$i].",".$m_r_od_i[$i].",".$m_b_p[$i].",".$m_b_d_i[$i].",".$m_b_od_i[$i].",'$staff_id', CAST('$curr_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
	//echo $sql_statement; 
	}
	//customer Account Creation
	$sql_statement.=";INSERT INTO customer_account(customer_id,account_type,opening_date, account_no,gl_mas_code,remarks, status,operator_code,entry_time) VALUES ('$c_id','jlgl', '$action_date','$account_no','$type','$remarks','op','$staff_id', CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";

// Loan_Ledger_Hrd
	$sql_statement.=";INSERT INTO loan_ledger_hrd(loan_serial_no,loan_type,customer_id,account_no,issue_date,repay_date,crop_id,int_due_rate, int_overdue_rate,status,gl_code,gl_status) VALUES ('$loan_sl_no','jlgl','$c_id','$account_no','$action_date', '$repay_date','$crop_id',$due_int,$overdue_int,'op','$gl_code_loan','$gl_status')";
// loan_return_dtl
$sql_statement=$sql_statement.";INSERT INTO loan_return_dtl(tran_id, loan_serial_no,account_no,action_date,r_total_amount,r_due_int,r_overdue_int,r_principal, b_due_int,b_overdue_int,b_principal,staff_id,entry_time)VALUES('$t_id','$loan_sl_no','$account_no','$curr_date',($r_d_int+$r_od_int+$r_principal),$r_d_int,$r_od_int,$r_principal,$b_d_int,$b_od_int,$balance_p,'$staff_id',CAST('$curr_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
// loan_issue_dtl
$sql_statement=$sql_statement.";INSERT INTO loan_issue_dtl(tran_id, loan_serial_no,account_no, action_date,loan_amount,b_principal,staff_id,entry_time)VALUES('$t_id','$loan_sl_no','$account_no','$action_date',$issued_amount,$issued_amount,'$staff_id',(CAST('$curr_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP)-INTERVAL '1 days'))";
//general ledger posting
$sql_statement=$sql_statement.";INSERT INTO gl_ledger_hrd(tran_id,type, action_date,fy,remarks, operator_code, entry_time) VALUES ('$t_id','jlgl','$curr_date','$fy','$remarks', '$staff_id', CAST('$curr_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
		
	$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','$account_no','$gl_code_loan',$balance_p,'Dr','opening JLGL')";

	echo $sql_statement;
echo $crop_id;

   	$result=dBConnect($sql_statement);
	if(pg_affected_rows($result)<1){
		echo "<h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
	} else{
		echo "<font size=+4><b>Transaction Id:$t_id";
		//echo "<br>Your Loan Amount:Rs. $issue_amount<br></h4>";
		echo "<br><font size=+2><a href=\"../main/set_account.php?menu=$menu&account_no=$group_no\">Click</a> here to go Statement"; 
				     	
           	   }
	
 }
//============================================VIEW==========================================
else if($_REQUEST['op']=='v'){
echo "<FORM NAME=\"orderform\" method=\"POST\" action=\"jlg_loan_ledger_ef.php?menu=$menu&op=i\" onSubmit=\"return varify();\">";
echo "<table bgcolor=\"BLACK\" width=\"100%\" align=\"CENTER\">";
echo "<tr><th bgcolor=\"#006400\" colspan=\"6\">JLG Loan Balance Entry Form [$account_no]";
echo "<INPUT NAME=\"account_no\" TYPE=\"HIDDEN\" VALUE=\"$account_no\" >";
echo "<tr><td bgcolor=\"#9370D8\">Issuing Date:<td bgcolor=\"#9370D8\"><INPUT NAME=\"action_date\" TYPE=\"TEXT\" VALUE=\"$action_date\" $HIGHLIGHT size=\"12\" READONLY>";
echo "<td align=\"left\" bgcolor=\"#9370D8\">Loan Type:<td bgcolor=\"#9370D8\"><INPUT NAME=\"type\" TYPE=\"TEXT\" VALUE=\"$type\" $HIGHLIGHT size=\"20\" READONLY>";
echo "<td bgcolor=\"#9370D8\">Repay Date:<td bgcolor=\"#9370D8\"><INPUT NAME=\"repay_date\" TYPE=\"TEXT\" VALUE=\"$repay_date\" $HIGHLIGHT size=\"12\" READONLY>";
echo "<tr><td bgcolor=\"#9370D8\">Status of Loan<td bgcolor=\"#9370D8\">";
echo "<SELECT name=\"gl_code_loan\">";
if($gl_code_loan=='d'){
echo "<option value=\"d\">Due";
}else{
echo "<option value=\"o\">Overdue";
}
echo "</select>";
echo "<td bgcolor=\"#9370D8\">Due Interest Rate:<td bgcolor=\"#9370D8\">Rs.&nbsp;<INPUT NAME=\"d_int_r\" TYPE=\"TEXT\" VALUE=\"$due_int\" $HIGHLIGHT maxlength=\"2\" size=3 READONLY>&nbsp;%";
echo "<td bgcolor=\"#9370D8\">Over Due Interest Rate:<td bgcolor=\"#9370D8\">Rs.&nbsp;<INPUT NAME=\"od_int_r\" TYPE=\"TEXT\" VALUE=\"$overdue_int\" $HIGHLIGHT size=\"3\" maxlength=\"2\" READONLY>&nbsp;%";
echo "<tr><td bgcolor=\"#9370D8\">Issue Amount:<td bgcolor=\"#9370D8\">Rs.&nbsp;<INPUT NAME=\"issued_amount\" id=\"issued_amount\" TYPE=\"TEXT\" VALUE=\"$issued_amount\" $HIGHLIGHT size=10 READONLY>";
echo "<td bgcolor=\"#9370D8\">Balance Principal Amount:<td bgcolor=\"#9370D8\">Rs.&nbsp;<INPUT NAME=\"bal_p\" TYPE=\"TEXT\" VALUE=\"$balance_p\" id=\"bal_p\" $HIGHLIGHT size=\"10\" READONLY>";
echo "<td bgcolor=\"#9370D8\">Upto Due Interest Received:<td bgcolor=\"#9370D8\">Rs.&nbsp<INPUT NAME=\"r_d_int\" id=\"r_d_int\" TYPE=\"TEXT\" VALUE=\"$r_d_int\" size=\"10\" $HIGHLIGHT READONLY>";
echo "<tr><td bgcolor=\"#9370D8\">Upto OverDue Interest Received:<td bgcolor=\"#9370D8\">Rs.&nbsp<INPUT NAME=\"r_od_int\" id=\"r_od_int\" TYPE=\"TEXT\" VALUE=\"$r_od_int\" size=\"10\" $HIGHLIGHT READONLY>";;
echo "<td bgcolor=\"#9370D8\">Balance Due Interest:<td bgcolor=\"#9370D8\">Rs.&nbsp<INPUT NAME=\"bal_d_int\" id=\"bal_d_int\"TYPE=\"TEXT\" VALUE=\"$b_d_int\" size=\"10\" $HIGHLIGHT READONLY>";
echo "<td bgcolor=\"#9370D8\">Balance OverDue Interest:<td bgcolor=\"#9370D8\">Rs.&nbsp<INPUT NAME=\"bal_od_int\" id=\"bal_od_int\" TYPE=\"TEXT\" VALUE=\"$b_od_int\" size=\"10\" $HIGHLIGHT READONLY>";
//echo "<tr><td align=\"left\" bgcolor=\"#9370D8\">Select Crop:<td bgcolor=\"#9370D8\"><INPUT NAME=\"type\" TYPE=\"TEXT\" VALUE=\"$crop_id\" $HIGHLIGHT size=\"20\" READONLY>";
echo "<tr><td bgcolor=\"#9370D8\"> Select Crop:<td bgcolor=\"#9370D8\">";
makeSelectFromDBWithCode('crop_id','crop_desc','crop_mas','crop_id');
echo "<td align=\"RIGHT\" bgcolor=\"#9370D8\"></td >";
echo "<td align=\"RIGHT\" bgcolor=\"#9370D8\"></td >";
echo "<td align=\"RIGHT\" bgcolor=\"#9370D8\"></td >";
echo "<td align=\"RIGHT\" bgcolor=\"#9370D8\"></td >";
echo "</table>";
//echo "<tr> ";
echo "<table bgcolor=\"\" width=\"100%\" align=\"CENTER\">";
echo "<tr><th bgcolor=\"WHITE\" colspan=\"7\">JLG Group Details of Loan [$account_no]";
echo "<tr><th bgcolor=\"pink\" Rowspan=\"2\">Name<th bgcolor=\"pink\" Rowspan=\"2\">Loan Amount<th bgcolor=\"pink\" colspan=\"2\">Recovery Interest<th bgcolor=\"pink\" colspan=\"3\">Balance";
echo "<tr><th bgcolor=\"pink\">Due<th bgcolor=\"pink\">Over Due <th bgcolor=\"pink\">Due <th bgcolor=\"pink\">Over Due <th bgcolor=\"pink\">principal";
$sql_statement="SELECT * FROM customer_master  WHERE type_of_customer='$group_no'";
$result=dBConnect($sql_statement);
//echo $sql_statement; 
if(pg_NumRows($result)>0){
for($j=0; $j<pg_NumRows($result); $j++){
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
echo "<tr>";
$sl_no=$row['customer_id'];
echo "<td bgcolor=$color><input type=\"checkbox\" name=\"music\" value=\"$sl_no\" onclick=\"ShowInfo(this.value);\">".ucwords($row['name1']);

echo "<td bgcolor=$color><input type=text name=\"loan_amount\" size=\"10\" disabled $HIGHLIGHT>";
echo "<td bgcolor=$color><input type=text name=\"r_d_i\" size=\"5\"disabled $HIGHLIGHT>";
echo "<td bgcolor=$color><input type=text name=\"r_od_i\" size=\"5\" disabled $HIGHLIGHT>";
echo "<td bgcolor=$color><input type=text name=\"b_d_i\" size=\"5\" disabled $HIGHLIGHT>";
echo "<td bgcolor=$color><input type=text name=\"b_od_i\" size=\"5\" disabled $HIGHLIGHT>";
echo "<td bgcolor=$color><input type=text name=\"b_p\"  size=\"10\" disabled $HIGHLIGHT>";
}

}
echo "<INPUT NAME=\"member_info\" id=\"member_info\" TYPE=\"HIDDEN\">";
echo "<INPUT NAME=\"m_loan_amount\" id=\"m_loan_amount\" TYPE=\"HIDDEN\">";
echo "<INPUT NAME=\"m_r_d_i\" id=\"m_r_d_i\" TYPE=\"HIDDEN\">";
echo "<INPUT NAME=\"m_r_od_i\" id=\"m_r_od_i\" TYPE=\"HIDDEN\">";
echo "<INPUT NAME=\"m_b_p\" id=\"m_b_p\" TYPE=\"HIDDEN\">";
echo "<INPUT NAME=\"m_b_d_i\" id=\"m_b_d_i\" TYPE=\"HIDDEN\">";
echo "<INPUT NAME=\"m_b_od_i\" id=\"m_b_od_i\" TYPE=\"HIDDEN\">";
echo "<tr><td align=\"RIGHT\" bgcolor=\"#9370D8\" colspan=\"7\"><input type=\"SUBMIT\" VALUE=\"    Go   \" >";
echo "</table>";
echo "</FORM>";

}
//==================================FOR ISSUING FORM=========================================
else if(empty($_REQUEST['op'])){
echo "<table bgcolor=\"BLACK\" width=\"80%\" align=\"CENTER\">";
echo "<tr><th bgcolor=\"#006400\" colspan=\"4\"><font size=+2>JLG Loan Balance Entry Form</font>";
echo "<FORM NAME=\"f1\" method=\"POST\" action=\"jlg_loan_ledger_ef.php?menu=$menu&op=v\">";
echo "<TR><td bgcolor=\"#E6E6FA\">Loan Account No:<td bgcolor=\"#E6E6FA\"><INPUT NAME=\"account_no\" TYPE=\"TEXT\" VALUE=\"JLGL-\" $HIGHLIGHT size=\"12\" id=\"account_no\" >";
echo "<td bgcolor=\"#E6E6FA\">Issuing Date:<td bgcolor=\"#E6E6FA\"><INPUT NAME=\"action_date\" TYPE=\"TEXT\" VALUE=\"\" $HIGHLIGHT size=\"12\" id=\"action_date\" >";
echo "<tr><td align=\"left\" bgcolor=\"#E6E6FA\">Loan Type:<td bgcolor=\"#E6E6FA\">";
makeSelect($jlgl_type_array,'type','');
echo "<td bgcolor=\"#E6E6FA\">Status of Loan<td bgcolor=\"#E6E6FA\">";
echo "<SELECT name=\"gl_code_loan\">";
echo "<option value=\"d\">Due";
echo "<option value=\"o\">Overdue";
echo "</select>";

echo "<tr><td bgcolor=\"#E6E6FA\">Due Interest Rate:<td bgcolor=\"#E6E6FA\">Rs.&nbsp;<INPUT NAME=\"d_int_r\" TYPE=\"TEXT\" VALUE=\"11\" $HIGHLIGHT maxlength=\"2\" size=3>&nbsp;%";
echo "<td bgcolor=\"#E6E6FA\">Over Due Interest Rate:<td bgcolor=\"#E6E6FA\">Rs.&nbsp;<INPUT NAME=\"od_int_r\" TYPE=\"TEXT\" VALUE=\"12\" $HIGHLIGHT size=\"3\" maxlength=\"2\">&nbsp;%";
echo "<tr><td bgcolor=\"#E6E6FA\">Issue Amount:<td bgcolor=\"#E6E6FA\">Rs.&nbsp;<INPUT NAME=\"issued_amount\" TYPE=\"TEXT\" VALUE=\"\" $HIGHLIGHT size=10>";
echo "<td bgcolor=\"#E6E6FA\">Balance Principal Amount:<td bgcolor=\"#E6E6FA\">Rs.&nbsp;<INPUT NAME=\"bal_p\" TYPE=\"TEXT\" VALUE=\"\" id=\"issued_amount\" $HIGHLIGHT size=\"10\">";
echo "<tr><td bgcolor=\"#E6E6FA\">Upto Due Interest Received:<td bgcolor=\"#E6E6FA\">Rs.&nbsp<INPUT NAME=\"r_d_int\" TYPE=\"TEXT\" VALUE=\"0\" size=\"10\" $HIGHLIGHT >";
echo "<td bgcolor=\"#E6E6FA\">Upto OverDue Interest Received:<td bgcolor=\"#E6E6FA\">Rs.&nbsp<INPUT NAME=\"r_od_int\" TYPE=\"TEXT\" VALUE=\"0\" size=\"10\" $HIGHLIGHT >";;
echo "<tr><td bgcolor=\"#E6E6FA\">Balance Due Interest:<td bgcolor=\"#E6E6FA\">Rs.&nbsp<INPUT NAME=\"bal_d_int\" TYPE=\"TEXT\" VALUE=\"0\" size=\"10\" $HIGHLIGHT >";
echo "<td bgcolor=\"#E6E6FA\">Balance OverDue Interest:<td bgcolor=\"#E6E6FA\">Rs.&nbsp<INPUT NAME=\"bal_od_int\" TYPE=\"TEXT\" VALUE=\"0\" size=\"10\" $HIGHLIGHT >";
echo "<tr><td bgcolor=\"#E6E6FA\">Repay Date:<td bgcolor=\"#E6E6FA\"><INPUT NAME=\"repay_date\" TYPE=\"TEXT\" VALUE=\"\" $HIGHLIGHT size=\"12\"> ";

echo "<td align=\"RIGHT\" bgcolor=\"#E6E6FA\" colspan=\"2\"><input type=\"SUBMIT\" VALUE=\"    Go   \" >";
echo "</FORM>";
    }
}
if(empty($_REQUEST['op'])&&$flag1==1){
?>
<script language="JavaScript" type="text/javascript">
 var frmvalidator  = new Validator("f1");
 frmvalidator.addValidation("account_no","req","Please enter Account No");
  frmvalidator.addValidation("account_no","minlen=5","Please enter the Correct Account No Like SGL-123");
 frmvalidator.addValidation("action_date","req","Please enter Issuing Date");
 frmvalidator.addValidation("repay_date","req","Please enter Repay Date");
 frmvalidator.addValidation("d_int_r","req","Please enter Due Interest Rate");
 frmvalidator.addValidation("od_int_r","req","Please enter Due Interest Rate");
 frmvalidator.addValidation("issued_amount","req","Please enter Issuing Amount");
 frmvalidator.addValidation("bal_p","req","Please enter Balance Principal");
 frmvalidator.addValidation("bal_d_int","req","Please enter Due Interest Amount If There are no due int then just put 0");
 frmvalidator.addValidation("bal_od_int","req","Please enter Over Due Interest Amount If There are no due int then just put 0");
 frmvalidator.addValidation("r_d_int","req","Please enter Recovery Due Interest Amount If There are no due int then just put 0");
 frmvalidator.addValidation("r_od_int","req","Please enter Recovery Over Due Interest Amount If There are no due int then just put 0");
 frmvalidator.addValidation("d_int_r","decimal","Due Interest Rate should be positive number");
 frmvalidator.addValidation("od_int_r","decimal","Overue Interest Rate should be positive number");
 frmvalidator.addValidation("issued_amount","decimal","Issue Amount should be positive number");
 frmvalidator.addValidation("bal_p","decimal","Balance Principal amount should be positive number");
 frmvalidator.addValidation("bal_d_int","decimal","Balance Due Interest Amount should be positive number");
 frmvalidator.addValidation("bal_od_int","decimal","Balance Over Due Interest amount should be positive number");
frmvalidator.addValidation("r_d_int","decimal","Received Due Interest Amount should be positive number");
 frmvalidator.addValidation("r_od_int","decimal","Received Over Due Interest amount should be positive number");
</script>
<?php
}
?>
