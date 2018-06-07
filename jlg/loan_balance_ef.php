<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$account_no=$_REQUEST['account_no'];
$group_no=$_SESSION["current_account_no"];
$fy=$_SESSION["fy"];
$crop_id=$_REQUEST['crop_id'];
$type=$_REQUEST['type'];
$gl_code_loan=$_REQUEST['gl_code_loan'];
$due_int=$_REQUEST['d_int_r'];
$overdue_int=$_REQUEST['od_int_r'];
$action_date=$_REQUEST['action_date'];
$repay_date=$_REQUEST['repay_date'];
$amount=$_REQUEST['amount'];
$issued_amount=$_REQUEST['issued_amount'];
$balance_p=$_REQUEST['bal_p'];
$b_d_int=$_REQUEST['bal_d_int'];
$b_od_int=$_REQUEST['bal_od_int'];
$curr_date='31.03.2013';
$member_info=$_REQUEST['member_info'];
$m_loan_amount=$_REQUEST['m_loan_amount'];
$m_b_p=$_REQUEST['m_b_p'];
$m_b_d_i=$_REQUEST['m_b_d_i'];
$m_b_od_i=$_REQUEST['m_b_od_i'];
echo "<html>";
echo "<head>";
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";
echo "<script src=\"../JS/validation.js\"></script>";
?>
<script language="javascript">

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

//--------------------------------------------------------------
function ShowInfo(){
	if(document.orderform.music.length>1){
		//alert("HI");
		for (var i=0; i < document.orderform.music.length; i++){
	   		if (document.orderform.music[i].checked){
				document.orderform.loan_amount[i].disabled=false;
				document.orderform.b_p[i].disabled=false;
				document.orderform.b_d_i[i].disabled=false;
				document.orderform.b_od_i[i].disabled=false;
				
				document.orderform.loan_amount[i].focus();
				}
			else{
				document.orderform.loan_amount[i].disabled=true;
				document.orderform.b_p[i].disabled=true;
				document.orderform.b_d_i[i].disabled=true;
				document.orderform.b_od_i[i].disabled=true;
				document.orderform.loan_amount[i].value='';
				document.orderform.b_p[i].value=''
				document.orderform.b_d_i[i].value=''
				document.orderform.b_od_i[i].value=''
				}
			}	// end if
		
		} //end for
		

	
}

//------------------------------------------------------------------------------------------

function varify(){
	if(IsPNumeric(document.orderform.issued_amount.value) && IsPNumeric(document.orderform.bal_p.value)){	
		var t_due=parseFloat(document.orderform.issued_amount.value);
		var amt=parseFloat(document.orderform.bal_p.value);
		if(t_due>=amt){
			//alert("correct");
			if(document.orderform.music.length>1){
				var flag;
				var c_value = "";
				var c_amount="";
				var c_due="";
				var c_p="";
				var c_odue="";
				var ln_amt=0;
				var m_b_p=0;
				var m_b_d=0;
				var m_b_o=0;
				
				for (var i=0; i < document.orderform.music.length; i++){
					if (document.orderform.music[i].checked){
						if(IsPNumeric(document.orderform.loan_amount[i].value)&&IsPNumeric(document.orderform.b_d_i[i].value)&&IsPNumeric(document.orderform.b_od_i[i].value)&&IsPNumeric(document.orderform.b_p[i].value)){
							if(parseFloat(document.orderform.loan_amount[i].value)>=parseFloat(document.orderform.b_p[i].value)){
								m_b_d=m_b_d+parseFloat(document.orderform.b_d_i[i].value);
							 	m_b_p+=parseFloat(document.orderform.b_p[i].value);
							 	ln_amt+=parseFloat(document.orderform.loan_amount[i].value);
								 m_b_o+=parseFloat(document.orderform.b_od_i[i].value);
								 if(c_value!=""){      
								 	c_value=c_value+',';
									c_amount=c_amount+',';
									c_due=c_due+',';
									c_p=c_p+',';
									c_odue=c_odue+',';
								 
								 }
								 c_value = c_value + document.orderform.music[i].value;
                                				 c_amount=c_amount+ document.orderform.loan_amount[i].value;
                                				 c_due=c_due+orderform.b_d_i[i].value;
                                				 c_p=c_p+orderform.b_p[i].value;
                                				 c_odue=c_odue+orderform.b_od_i[i].value;
                                				 flag=1;
                                				 //alert(c_value+"->"+c_amount+"->"+c_due+"->"+c_p+"->"+c_odue);
							
							
							
							}
							else{
							
								alert("Member Due principal Amount Should not be greater than Loan amount");
	   							document.orderform.loan_amount[i].value='';
	   							document.orderform.b_p[i].value='';
								document.orderform.loan_amount[i].focus();
								return false;
							
							}
						
						
						}
						else{
							alert("Due Interest Or Overdue Ineterest should not be Null!");
							document.orderform.loan_amount[i].focus();
							return false;
						
						}
						
						
						
						//alert("correct");
						}
					//else{
					//
					//}
				
				
				
				}//end of for loop
				
				
				}
			else{
			// nothing becz member always more than 1
			}
			
			
			
			
			
			}
		else{
		
			alert("Balance Principal Amount Should not be greater than Loan Amount");
	   		document.orderform.bal_p.value='';
			document.orderform.bal_p.focus();
			return false;
		}
		
		
		}
	else{
		alert("Enter the valid data !!!!!!!!");
		document.orderform.bal_p.focus();
		return false;
	
	
		}
	if(flag!=1){
	
		alert("Please check one of member");
		document.orderform.music[0].focus();
		return false;

		}//
	if(m_b_d!=parseFloat(document.orderform.bal_d_int.value)){
		alert("Please enter the valid due interest");
		document.orderform.bal_d_int.focus();
		return false;
	}
	if( m_b_p!=parseFloat(document.orderform.bal_p.value)){
		alert("Please enter the valid Balance Principal");
		document.orderform.bal_p.focus();
		return false;
	}
	if( m_b_o!=parseFloat(document.orderform.bal_od_int.value)){
		alert("Please enter the valid due interest");
		document.orderform.bal_od_int.focus();
		return false;
	}
	if(ln_amt!=parseFloat(document.orderform.issued_amount.value)){
		alert("Please enter the valid Issue amount");
		document.orderform.issued_amount.focus();
		return false;
	}
	document.getElementById("member_info").value=c_value;
	document.getElementById("m_loan_amount").value=c_amount;
	document.getElementById("m_b_d_i").value=c_due;
	document.getElementById("m_b_p").value=c_p;
	document.getElementById("m_b_od_i").value=c_odue;

	
		
	}
</script>	
<?php
echo "<title></title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
$c_id=getCustomerIdFromGroupId($group_no);
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
	$type=getIndex($shgl_type_array,$type);

	//$gl_code=getGlCode4mCustomerAccount($account_no,$action_date);
  	$fy=getFy($action_date);
	if(empty($fy)){
	echo "<h1><center><b>You Can't Insert any value Into database Because Financial Year already Locked by administrator !!!!!!!!!</h1>";
		} 
else {
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
	getSHGInfo($group_no,$no_of_member,$leader,$group_id,$gp_type);
	$MAX_LIMIT=$no_of_member*10000; // LET MAXMIMUM LIMIT WILL BE 10000/member

	for($i=0;$i<count($member_info);$i++){
	if($i>0){$sql_statement.=";";}
	//print_r ($member_info);
	//echo "COUNT=".count($member_info);
     	 $m_r_d_i[$i]=(empty($m_r_d_i[$i]))?'0':$m_r_d_i[$i];
	 $m_r_od_i[$i]=(empty($m_r_od_i[$i]))?'0':$m_r_od_i[$i];
	$sql_statement.=";INSERT INTO shg_loan_ledger_hrd(loan_sl_no , member_id, account_no , shg_no ,action_date ,repay_date ,d_int_r,od_int_r, status, staff_id, entry_time,crop_id,max_limit) VALUES('$loan_sl_no','".$member_info[$i]."','$account_no','$group_no','$action_date','$repay_date',$due_int,$overdue_int,'op','$staff_id', CAST('$curr_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP),'$crop_id',10000)";
	//For shg_loan_ledger_dtl
	$sql_statement.=";INSERT INTO shg_loan_ledger_dtl(tran_id, loan_sl_no,member_id, action_date,loan_amount,r_principal,r_d_int,r_od_int,b_principal,b_d_int,b_od_int,staff_id,entry_time)VALUES('$t_id','$loan_sl_no','".$member_info[$i]."','$curr_date',".$m_loan_amount[$i].",".($m_loan_amount[$i]-$m_b_p[$i]).",".$m_r_d_i[$i].",".$m_r_od_i[$i].",".$m_b_p[$i].",".$m_b_d_i[$i].",".$m_b_od_i[$i].",'$staff_id', CAST('$curr_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
	//echo $sql_statement; 
	}//end loop
	//customer Account Creation
	$sql_statement.=";INSERT INTO customer_account(customer_id,account_type,opening_date, account_no,gl_mas_code,remarks, status,operator_code,entry_time) VALUES ('$c_id','jgl', '$action_date','$account_no','$type','$remarks','op','$staff_id', CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";

// Loan_Ledger_Hrd
	$sql_statement.=";INSERT INTO loan_ledger_hrd(loan_serial_no,loan_type,customer_id,account_no,issue_date,repay_date,int_due_rate, int_overdue_rate,status,gl_code,gl_status,crop_id,max_limit) VALUES ('$loan_sl_no','jgl','$c_id','$account_no','$action_date', '$repay_date',$due_int,$overdue_int,'op','$gl_code_loan','$gl_status','$crop_id',$MAX_LIMIT)";
// loan_return_dtl
$sql_statement=$sql_statement.";INSERT INTO loan_return_dtl(tran_id, loan_serial_no,account_no,action_date,r_principal, b_due_int,b_overdue_int,b_principal,staff_id,entry_time)VALUES('$t_id','$loan_sl_no','$account_no','$curr_date',$r_principal,$b_d_int,$b_od_int,$balance_p,'$staff_id',CAST('$curr_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
// loan_issue_dtl
$sql_statement=$sql_statement.";INSERT INTO loan_issue_dtl(tran_id, loan_serial_no,account_no, action_date,loan_amount,b_principal,staff_id,entry_time)VALUES('$t_id','$loan_sl_no','$account_no','$action_date',$issued_amount,$issued_amount,'$staff_id',(CAST('$curr_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP)-INTERVAL '1 days'))";
//general ledger posting
$sql_statement=$sql_statement.";INSERT INTO gl_ledger_hrd(tran_id,type, action_date,fy,remarks, operator_code, entry_time) VALUES ('$t_id','sgl','$curr_date','$fy','$remarks', '$staff_id', CAST('$curr_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
		
$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','$account_no','$gl_code_loan',$balance_p,'Dr','opening SGL')";

	echo $sql_statement;

   	$result=dBConnect($sql_statement);
	if(pg_affected_rows($result)<1){
		echo "<h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
	} else{
		echo "<font size=+4><b>Transaction Id:$t_id";
		//echo "<br>Your Loan Amount:Rs. $issue_amount<br></h4>";
		echo "<br><font size=+2><a href=\"../main/set_account.php?menu=$menu&account_no=$group_no\">Click</a> here to go Statement"; 
				     	
           	   }
	
 }
}
//============================================VIEW==========================================
else if($_REQUEST['op']=='v'){
echo "<FORM NAME=\"orderform\" method=\"POST\" action=\"loan_balance_ef.php?menu=$menu&op=i\" onSubmit=\"return varify();\">";
echo "<table bgcolor=\"BLACK\" width=\"100%\" align=\"CENTER\">";
echo "<tr><th bgcolor=\"#006400\" colspan=\"10\">JGL Loan Balance Entry Form [$account_no]";
echo "<INPUT NAME=\"account_no\" TYPE=\"HIDDEN\" VALUE=\"$account_no\" >";
echo "<tr><td bgcolor=\"#9370D8\">Issuing Date:<td bgcolor=\"#9370D8\"><INPUT NAME=\"action_date\" TYPE=\"TEXT\" VALUE=\"$action_date\" $HIGHLIGHT size=\"12\" READONLY>";
echo "<td align=\"left\" bgcolor=\"#9370D8\">Loan Type:<td bgcolor=\"#9370D8\"><INPUT NAME=\"type\" TYPE=\"TEXT\" VALUE=\"$type\" $HIGHLIGHT size=\"20\" READONLY>";
echo "<td bgcolor=\"#9370D8\">Status of Loan<td bgcolor=\"#9370D8\">";
echo "<SELECT name=\"gl_code_loan\">";
if($gl_code_loan=='d'){
echo "<option value=\"d\">Due";
}else{
echo "<option value=\"o\">Overdue";
}
echo "</select>";
//getcropname('crop_id',$row['crop_id'])
echo "<td bgcolor=\"#9370D8\">CROP Name:<td bgcolor=\"#9370D8\">Rs.&nbsp;<INPUT NAME=\"crp\" TYPE=\"TEXT\" VALUE=\"".UCWORDs(cropname($crop_id))."\" $HIGHLIGHT  size=3 READONLY>";
echo "<tr><td bgcolor=\"#9370D8\">Due Interest Rate:<td bgcolor=\"#9370D8\">Rs.&nbsp;<INPUT NAME=\"d_int_r\" TYPE=\"TEXT\" VALUE=\"$due_int\" $HIGHLIGHT maxlength=\"2\" size=3 READONLY>&nbsp;%";
echo "<td bgcolor=\"#9370D8\">Over Due Interest Rate:<td bgcolor=\"#9370D8\">Rs.&nbsp;<INPUT NAME=\"od_int_r\" TYPE=\"TEXT\" VALUE=\"$overdue_int\" $HIGHLIGHT size=\"3\" maxlength=\"2\" READONLY>&nbsp;%";
echo "<td bgcolor=\"#9370D8\">Issue Amount:<td bgcolor=\"#9370D8\">Rs.&nbsp;<INPUT NAME=\"issued_amount\" id=\"issued_amount\" TYPE=\"TEXT\" VALUE=\"$issued_amount\" $HIGHLIGHT size=10 READONLY>";
echo "<td bgcolor=\"#9370D8\">Bal.Principal Amount:<td bgcolor=\"#9370D8\">Rs.&nbsp;<INPUT NAME=\"bal_p\" TYPE=\"TEXT\" VALUE=\"$balance_p\" id=\"bal_p\" $HIGHLIGHT size=\"10\" READONLY>";

echo "<tr><td bgcolor=\"#9370D8\">Bal. Due Int.:<td bgcolor=\"#9370D8\">Rs.&nbsp<INPUT NAME=\"bal_d_int\" id=\"bal_d_int\"TYPE=\"TEXT\" VALUE=\"$b_d_int\" size=\"10\" $HIGHLIGHT READONLY>";
echo "<td bgcolor=\"#9370D8\">Bal ODue Int.:<td bgcolor=\"#9370D8\">Rs.&nbsp<INPUT NAME=\"bal_od_int\" id=\"bal_od_int\" TYPE=\"TEXT\" VALUE=\"$b_od_int\" size=\"10\" $HIGHLIGHT READONLY>";
echo "<td bgcolor=\"#9370D8\">Repay Date:<td bgcolor=\"#9370D8\">Rs.&nbsp;<INPUT NAME=\"repay_date\" id=\"repay_date\" TYPE=\"TEXT\" VALUE=\"$repay_date\" $HIGHLIGHT size=10 READONLY>";
//echo "<tr><td bgcolor=\"#9370D8\">Issuing Date:<td bgcolor=\"#9370D8\"><INPUT NAME=\"action_date\" TYPE=\"TEXT\" VALUE=\"$action_date\" $HIGHLIGHT size=\"12\" READONLY>";
echo "<td bgcolor=\"#9370D8\"><td bgcolor=\"#9370D8\">";

echo "</table>";
//echo "<tr> ";
echo "<table bgcolor=\"BLACK\" width=\"100%\" align=\"CENTER\">";
echo "<tr><th bgcolor=\"WHITE\" colspan=\"7\">JLG Group Details of Loan [$account_no]";
echo "<tr><th bgcolor=\"pink\" Rowspan=\"2\">Name<th bgcolor=\"pink\" Rowspan=\"2\">Father's Name<th bgcolor=\"pink\" Rowspan=\"2\">Loan Amount<th bgcolor=\"pink\" colspan=\"3\">Balance";
echo "<tr><th bgcolor=\"pink\">principal<th bgcolor=\"pink\">Due <th bgcolor=\"pink\">Over Due ";
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
echo "<td bgcolor=$color>".ucwords($row['father_name1']);
echo "<td bgcolor=$color align=\"RIGHT\">Rs.<input type=text name=\"loan_amount\" size=\"10\" disabled $HIGHLIGHT>";
echo "<td bgcolor=$color align=\"RIGHT\">Rs.<input type=text name=\"b_p\"  size=\"10\" disabled $HIGHLIGHT>";
echo "<td bgcolor=$color align=\"RIGHT\">Rs.<input type=text name=\"b_d_i\" size=\"5\" disabled $HIGHLIGHT>";
echo "<td bgcolor=$color align=\"RIGHT\">Rs.<input type=text name=\"b_od_i\" size=\"5\" disabled $HIGHLIGHT>";

}

}
echo "<INPUT NAME=\"member_info\" id=\"member_info\" TYPE=\"HIDDEN\">";
echo "<INPUT NAME=\"m_loan_amount\" id=\"m_loan_amount\" TYPE=\"HIDDEN\">";
echo "<INPUT NAME=\"crop_id\" VALUE=\"$crop_id\" TYPE=\"HIDDEN\">";
echo "<INPUT NAME=\"m_b_p\" id=\"m_b_p\" TYPE=\"HIDDEN\">";
echo "<INPUT NAME=\"m_b_d_i\" id=\"m_b_d_i\" TYPE=\"HIDDEN\">";
echo "<INPUT NAME=\"m_b_od_i\" id=\"m_b_od_i\" TYPE=\"HIDDEN\">";
echo "<tr><td align=\"RIGHT\" bgcolor=\"#9370D8\" colspan=\"7\"><input type=\"SUBMIT\" VALUE=\"    Go   \" >";
echo "</table>";
echo "</FORM>";

}
//==================================FOR ISSUING FORM=========================================
else if(empty($_REQUEST['op'])){
$ROWCOLOR="#ADD8E6";
$THCOLOR="#778899";
echo "<table bgcolor=\"BLACK\" width=\"80%\" align=\"CENTER\">";
echo "<tr><th bgcolor=\"$THCOLOR\" colspan=\"6\"><font size=+2>JGL Loan Balance Entry Form</font>";
echo "<FORM NAME=\"f1\" method=\"POST\" action=\"loan_balance_ef.php?menu=$menu&op=v\">";
echo "<TR><td bgcolor=\"$ROWCOLOR\">Loan Account No:<td bgcolor=\"$ROWCOLOR\"><INPUT NAME=\"account_no\" TYPE=\"TEXT\" VALUE=\"JGL-\" $HIGHLIGHT size=\"12\" id=\"account_no\" >";
echo "<td bgcolor=\"$ROWCOLOR\">Issuing Date:<td bgcolor=\"$ROWCOLOR\"><INPUT NAME=\"action_date\" TYPE=\"TEXT\" VALUE=\"\" $HIGHLIGHT size=\"12\" id=\"action_date\" >";
echo "<td bgcolor=\"$ROWCOLOR\">Repay Date:<td bgcolor=\"$ROWCOLOR\"><INPUT NAME=\"repay_date\" TYPE=\"TEXT\" VALUE=\"\" $HIGHLIGHT size=\"12\"> ";
echo "<tr><td align=\"left\" bgcolor=\"$ROWCOLOR\">Loan Type:<td bgcolor=\"$ROWCOLOR\">";
makeSelect($shgl_type_array,'type','');
echo "<td bgcolor=\"$ROWCOLOR\"> Select Crop:<td bgcolor=\"$ROWCOLOR\">";
makeSelectFromDBWithCode('crop_id','crop_desc','crop_mas','crop_id');
echo "<td bgcolor=\"$ROWCOLOR\">Status of Loan<td bgcolor=\"$ROWCOLOR\">";
echo "<SELECT name=\"gl_code_loan\">";
echo "<option value=\"d\">Due";
echo "<option value=\"o\">Overdue";
echo "</select>";
echo "<tr><td bgcolor=\"$ROWCOLOR\">Due Interest Rate:<td bgcolor=\"$ROWCOLOR\">Rs.&nbsp;<INPUT NAME=\"d_int_r\" TYPE=\"TEXT\" VALUE=\"7\" $HIGHLIGHT maxlength=\"2\" size=3>&nbsp;%";
echo "<td bgcolor=\"$ROWCOLOR\">Over Due Interest Rate:<td bgcolor=\"$ROWCOLOR\">Rs.&nbsp;<INPUT NAME=\"od_int_r\" TYPE=\"TEXT\" VALUE=\"11\" $HIGHLIGHT size=\"3\" maxlength=\"2\">&nbsp;%";
echo "<td bgcolor=\"$ROWCOLOR\">Issue Amount:<td bgcolor=\"$ROWCOLOR\">Rs.&nbsp;<INPUT NAME=\"issued_amount\" TYPE=\"TEXT\" VALUE=\"\" $HIGHLIGHT size=10>";
echo "<tr><td bgcolor=\"$ROWCOLOR\">Balance Principal Amount:<td bgcolor=\"$ROWCOLOR\">Rs.&nbsp;<INPUT NAME=\"bal_p\" TYPE=\"TEXT\" VALUE=\"\" id=\"issued_amount\" $HIGHLIGHT size=\"10\">";

echo "<td bgcolor=\"$ROWCOLOR\">Balance Due Interest:<td bgcolor=\"$ROWCOLOR\">Rs.&nbsp<INPUT NAME=\"bal_d_int\" TYPE=\"TEXT\" VALUE=\"0\" size=\"10\" $HIGHLIGHT >";
echo "<td bgcolor=\"$ROWCOLOR\">Balance OverDue Interest:<td bgcolor=\"$ROWCOLOR\">Rs.&nbsp<INPUT NAME=\"bal_od_int\" TYPE=\"TEXT\" VALUE=\"0\" size=\"10\" $HIGHLIGHT >";
echo "<tr><td align=\"RIGHT\" bgcolor=\"$ROWCOLOR\" colspan=\"6\"><input type=\"SUBMIT\" VALUE=\"    Go   \" >";
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
