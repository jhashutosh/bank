<?
include "../config/config.php";
$staff_id=verifyAutho();
$group_no=$_SESSION["current_account_no"];
$menu=$_REQUEST['menu'];
$op=$_REQUEST['op'];
$account_no=$_REQUEST["loan_no"];
$ln_sl=$_REQUEST['ln_sl'];
$action_date=$_REQUEST['action_date'];
//echo $account_no;
if(empty($op)){
if(empty($action_date)){
$sql_statement="SELECT shg_mem_loan_dtl('$account_no',CURRENT_DATE) as int";
}
else{
$sql_statement="SELECT shg_mem_loan_dtl('$account_no','$action_date') as int";
}
echo $sql_statement;
$result=dBConnect($sql_statement);
$sql_statement="SELECT getLoanInterest('$account_no','$action_date','jgl') as int";
//echo $sql_statement;
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
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"amount.focus();\">";
$flag=getGeneralInfo_Customer($id);
if($flag==1){
echo "<hr>";
//==========================DISPLAY HERE===============================================
if(empty($op)){
	if(isOpenLoan($account_no)){
		echo "<table algin=CENTER width=\"100%\">";
		$sql_statement="SELECT * FROM loan_cal_int where account_no='$account_no'";
		echo $sql_statement;
		$result=dBConnect($sql_statement);
		if(pg_NumRows($result)>0){
			$color="GREEN";
			echo "<tr><th bgcolor=YELLOW colspan=\"9\">JLG Loan Details of [$account_no] as on ".$action_date."</th>";
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
				echo "<td align=center bgcolor=$color>".$row['days']."</td>";
				echo "<td align=right bgcolor=$color>".(float)$row['principal']."</td>";
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
$days=pg_result($result,'days');
$due_i=pg_result($result,'due_int');
$odue_i=pg_result($result,'overdue_int');

echo "<table bgcolor=\"#F5F5DC\" width=\"80%\" align=\"CENTER\">";
echo "<tr><th bgcolor=\"#808000\" colspan=\"4\"><font size=-1>JLG Loan Repayment Form of [$account_no]</font>";
echo "<FORM NAME=\"orderform\" method=\"POST\" action=\"loan_repayment.php?menu=$menu&op=i&ln_sl=$ln_sl&loan_no=$account_no\"  onSubmit=\"return varify();\">";
echo "<tr><td> Account No:<td><INPUT TYPE=\"TEXT\" VALUE=\"$account_no\" $HIGHLIGHT size=\"15\" >";
echo "<td>Date:<td><INPUT NAME=\"action_date\" TYPE=\"TEXT\" VALUE=\"$action_date\" $HIGHLIGHT size=\"12\" >";
echo "<input type=\"hidden\" name=\"gl_status\"  value=\"".pg_result($result,'status')."\" >";
echo "<tr><td colspan=\"2\"><b>RECOVERY:</b><td colspan=\"2\"><b>DUE:</b>";
recoverDetails($ln_sl,$p,$d,$o);
if(empty($p))$p=0;
if(empty($d))$d=0;
if(empty($o))$o=0;
echo "<tr><td>Principal :<td>Rs.&nbsp;<INPUT NAME=\"r_principal\" TYPE=\"TEXT\" VALUE=\"$p\" $HIGHLIGHT size=10>";
echo "<td>Principal :<td>Rs.&nbsp;<INPUT NAME=\"d_principal\" id=\"d_principal\" TYPE=\"TEXT\" VALUE=\"$principal\" $HIGHLIGHT size=10>";
echo "<tr><td >Due Interest :<td>Rs.&nbsp;<INPUT NAME=\"r_d_int\" TYPE=\"TEXT\" VALUE=\"$d\" $HIGHLIGHT size=10>";
echo "<td>Due Interest :<td>Rs.&nbsp;<INPUT NAME=\"d_int\" TYPE=\"TEXT\" VALUE=\"$due_i\" $HIGHLIGHT size=10 id=\"d_int\">";
echo "<tr><td>Over Due Interest:<td>Rs.&nbsp;<INPUT NAME=\"r_od_int\" TYPE=\"TEXT\" VALUE=\"$o\" $HIGHLIGHT size=\"10\">";
echo "<td>Over Due Interest:<td>Rs.&nbsp;<INPUT NAME=\"od_int\" TYPE=\"TEXT\" VALUE=\"$odue_i\" $HIGHLIGHT size=\"10\" id=\"od_int\">";
echo "<tr><td>Total:<td>Rs.&nbsp;<INPUT NAME=\"total_r\" TYPE=\"TEXT\" VALUE=\"".($o+$p+$d)."\" $HIGHLIGHT size=\"10\">";
echo "<td>Total:<td>Rs.&nbsp;<INPUT NAME=\"total_d\" TYPE=\"TEXT\" VALUE=\"".($principal+$odue_i+$due_i)."\" $HIGHLIGHT size=\"10\" id=\"o\">";
echo "<tr><td>Days:<td>Rs.&nbsp;<INPUT NAME=\"days\" TYPE=\"TEXT\" VALUE=\"$days\" $HIGHLIGHT size=5>";
echo "<td>Principal:<td>Rs.&nbsp;<INPUT NAME=\"amount\" TYPE=\"TEXT\" VALUE=\"\" id=\"amount\" $HIGHLIGHT size=\"10\">";
echo "</table><hr>";
echo "<table align=center width=100%>";

echo "<tr><TH colspan=13 bgcolor=BLUE><font color=WHITE size=-1><b>SHG Loan Repaymnt Details Form";
//$sql_statement="SELECT shg_mem_loan_dtl('$account_no','$action_date') as int";
//echo $sql_statement;
//$result=dBConnect($sql_statement);
//if(pg_result($result,'int')==1){$iflag=true;}
$sql_statement="SELECT ln_sl,customer_id,name1,days,mem_id,designation1,p,r_d_i,r_od_i,r_p,ROUND(b_d_i) AS b_d_i,ROUND(b_od_i) as b_od_i,b_p FROM shg_mem_loan_dtl_v  WHERE ln_sl='$ln_sl'";
$result=dBConnect($sql_statement);
//echo $sql_statement; 
echo "<tr>";
$color="GREEN";
echo "<th bgcolor=$color Rowspan=\"2\">Name</th>";
echo "<th bgcolor=$color Rowspan=\"2\">Days</th>";
echo "<th bgcolor=$color Rowspan=\"2\">Principal<br>(Rs.)</th>";
echo "<th bgcolor=$color colspan=\"3\">Recovery</th>";
echo "<th bgcolor=$color colspan=\"3\">Balance</th>";
echo "<th bgcolor=$color Rowspan=\"2\">Total<br>(Rs.)</th>";
echo "<th bgcolor=$color Rowspan=\"2\">Amount</th>";
echo "<tr><th bgcolor=$color>Due</th>";
echo "<th bgcolor=$color >Odue</th>";
echo "<th bgcolor=$color >Prin</th>";
echo "<th bgcolor=$color >Due</th>";
echo "<th bgcolor=$color >Odue</th>";
echo "<th bgcolor=$color >Prin</th>";

if(pg_NumRows($result)>0){
for($j=0; $j<pg_NumRows($result); $j++){
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
echo "<tr>";
$sl_no=$row['customer_id'];
echo "<td bgcolor=$color><input type=\"checkbox\" name=\"music\" value=\"$sl_no\" onclick=\"ShowInfo(this.value);\">".ucwords($row['name1']);
echo " ( ".ucwords($row['designation1']).")";
echo "<td bgcolor=$color>".($row['days']);
echo "<td bgcolor=$color align=right>".amount2Rs((int)($row['p']));
echo "<td bgcolor=$color align=right>".amount2Rs((int)($row['r_d_i']));
echo "<td bgcolor=$color align=right>".amount2Rs((int)($row['r_od_i']));
echo "<td bgcolor=$color align=right>".amount2Rs((int)($row['r_p']));

/*if($j==(pg_NumRows($result)-1)){
//
echo "<td bgcolor=$color align=right><input type=text name=\"b_d_i\" size=\"3\" value=\"".($due_i-$t_due_int)."\"  $HIGHLIGHT>";
echo "<td bgcolor=$color align=right><input type=text name=\"b_od_i\" size=\"3\" value=\"".($odue_i-$t_od_int)."\"  $HIGHLIGHT>";
$t_due=($due_i-$t_due_int)+($odue_i-$t_od_int);
//echo "<h1>$t_due</h1>";
}
else{*/
echo "<td bgcolor=$color align=right><input type=text name=\"b_d_i\" size=\"3\" value=\"".(int)($row['b_d_i'])."\"  $HIGHLIGHT>";
echo "<td bgcolor=$color align=right><input type=text name=\"b_od_i\" size=\"3\" value=\"".(int)($row['b_od_i'])."\"  $HIGHLIGHT>";
$t_due=(int)$row['b_od_i']+(int)$row['b_d_i'];
//}
$t_due_int+=(int)$row['b_d_i'];
$t_od_int+=(int)$row['b_od_i'];
echo "<td bgcolor=$color align=right><input type=text name=\"b_p\" size=\"5\" value=\"".(int)($row['b_p'])."\"  $HIGHLIGHT>";
echo "<td bgcolor=$color align=right>".amount2Rs($t_due+$row['b_p']);


//echo "<td bgcolor=$color><input type=text name=\"due\" size=\"3\" disabled $HIGHLIGHT>";
//echo "<td bgcolor=$color><input type=text name=\"overdue\" size=\"3\" disabled $HIGHLIGHT>";
echo "<td bgcolor=$color><input type=text name=\"name\" size=\"7\" disabled $HIGHLIGHT>";
}

echo "<input type=\"HIDDEN\" value=\"\" name=\"member_info\" id=\"member_info\">";
echo "<input type=\"HIDDEN\" value=\"\" name=\"member_amount\" id=\"member_amount\">";


echo "<tr><td bgcolor=#9370D8 colspan=\"13\" align=\"RIGHT\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" VALUE=\" GO \" >";
echo "</table>";
echo "</FORM>";
	}
   }
 }
//exit;
?>
<script language="JAVASCRIPT">
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
     	else{
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
	
	if(IsPNumeric(document.orderform.amount.value) && IsPNumeric(document.orderform.total_d.value)){
	 	var amt=parseFloat(document.orderform.amount.value);
		var t_due=parseFloat(document.orderform.total_d.value);
		if(t_due>=amt){
			var flag;
			var c_value = "";
			var c_amount="";
			var amount=0;
			if(document.orderform.music.length>1){
			
			//alert(document.orderform.music.length);
			//
				for (var i=0; i < document.orderform.music.length; i++){
					if (document.orderform.music[i].checked){
						if(IsPNumeric(document.orderform.name[i].value)&&IsPNumeric(document.orderform.b_d_i[i].value)&&IsPNumeric(document.orderform.b_od_i[i].value)&&IsPNumeric(document.orderform.b_p[i].value)){
							var m_t_dues=parseFloat(document.orderform.b_d_i[i].value)+parseFloat(document.orderform.b_od_i[i].value)+parseFloat(document.orderform.b_p[i].value);
							var collect_amount=parseFloat(document.orderform.name[i].value);
							if(m_t_dues>=collect_amount){
								if(c_value!=""){       
									 c_value=c_value+',';
									 c_amount=c_amount+',';
									
									}
								c_value = c_value + document.orderform.music[i].value;
                                				c_amount=c_amount+ document.orderform.name[i].value;
                                				amount=amount+collect_amount;
							
								flag=1;
							
							
							
							
							}
							else{
								alert("Member Collected Amount Should not be greater than Total Due");
	   							document.orderform.name[i].value='';
								document.orderform.name[i].focus();
								return false;
							
							
							}
		
							
						}
						else{
						
							alert("Enter the valid data !!!!!!!!");
							document.orderform.name[i].value='';
							document.orderform.name[i].focus();
							return false;
						}
					
					
					}//if he checked or not
					/*else{
						
					
					}*/
				
				}//end of for loop
				//alert("correct"+ amount);
			
			}
			else{
				if (document.orderform.music.checked){
					if(IsPNumeric(document.orderform.name.value)){
							//alert(document.orderform.music.value);
							c_value =document.orderform.music.value;
							c_amount=document.orderform.name.value;
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
			
			
			
			
			
				//alert(" not reqired for INPUT  not MORE THAN ONE");
			}
			if(amount>amt){
				alert("Collected Amount Should not be greater than Total amount");
				document.orderform.amount.focus();
				return false;
						}
			
			}
		else{
			alert("Collected Amount Should not be greater than Total Due");
			document.orderform.amount.focus();
			return false;
		}
	}
	else{
		alert("Enter the valid data !!!!!!!!");
		document.orderform.amount.focus();
		return false;
	}
	if(flag!=1){
	
		alert("Please check one of member");
		document.orderform.music[0].focus();
		return false;
	
	}
	document.getElementById("member_info").value=c_value;
	document.getElementById("member_amount").value=c_amount;
	//alert(c_value+">>>>>>"+c_amount);
	
//return false;	
	
	}
</script>
<?
if($op=='i'){

$member_amount=$_REQUEST['member_amount'];
$member_id=$_REQUEST['member_info'];

//echo "<h1>$member_id</h1>";
//echo "<h1>$member_amount</h1>";
$gl_status=$_REQUEST['gl_status'];
$d_int=$_REQUEST['d_int'];
$amount=$_REQUEST['amount'];
$od_int=$_REQUEST['od_int'];
$ln_sl=$_REQUEST['ln_sl'];
$c_d_i=$_REQUEST['c_d_i'];
$c_od_i=$_REQUEST['c_od_i'];
$action_date=$_REQUEST['action_date'];
$total_d=$_REQUEST['total_d'];

$member_amount=explode(",",$member_amount);
$member_id=explode(",",$member_id);


$gl_code=getGlCode4mCustomerAccount($account_no,$action_date);
$fy=getFy($action_date);
if(empty($fy)){
	echo "<h1><center><b>You Can't Insert any value Into database Because Financial Year already Locked by administrator !!!!!!!!!</h1>";
		} 

else{
	$t_id=getTranId();
	$gl_code_p=getGlCode4mLoanLedger($ln_sl,$gl_status);
	
	for($i=0;$i<COUNT($member_id);$i++){
		$sql_statement="select ROUND(b_d_i) AS b_d_i,ROUND(b_od_i) as b_od_i,b_p from shg_mem_loan_dtl where ln_sl='$ln_sl' and mem_id='$member_id[$i]'";
		//echo $sql_statement;
		$result=dBConnect($sql_statement);

		if(pg_NumRows($result)==0) {
			echo "<h4>Not found!!!</h4>";
			} 
		else {
		
			$od_amount=pg_result($result,'b_od_i');
			$d_amount=pg_result($result,'b_d_i');
			$principal_amount=pg_result($result,'b_p');
			if($member_amount[$i]>=($d_amount+$od_amount)){
				$r_i_d=$d_amount;
				$r_i_od=$od_int;
				$r_p=$member_amount[$i]-($d_amount+$od_amount);
				$b_p=$principal_amount-$r_p;
				$b_i_d=0;
				$b_i_od=0;
				}
			else{
				if($member_amount[$i]>$od_amount){
					$r_i_od=$od_amount;
					$r_i_d=$member_amount[$i]-$od_amount;
					$b_i_d=$d_amount-$r_i_d;
					$b_i_od=0;
				}
				else{
					$r_i_od=$member_amount[$i];
					//$r_i_od=$od_amount;
					$r_i_d=0;
					$b_i_d=$d_amount;
					$b_i_od=$od_amount-$member_amount[$i];
					}
				$r_p=0;
				$b_p=$principal_amount;
				}
			   }
			   $total_recovery_principal+=$r_p;
			   $total_recovery_due_int+=$r_i_d;
			   $total_recovery_odue_int+=$r_i_od;
		$sql_statement1.="INSERT INTO shg_loan_ledger_dtl(tran_id, loan_sl_no,member_id, action_date,r_principal,r_d_int,r_od_int,b_principal,b_d_int,b_od_int,staff_id,entry_time) VALUES('$t_id','$ln_sl','".$member_id[$i]."','$action_date',$r_p,$r_i_d,$r_i_od,$b_p, $b_i_d,$b_i_od,'$staff_id',CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP));";

if($b_p<1){
			$sql_statement1.=";UPDATE shg_loan_ledger_hrd SET status='cl',closing_date='$action_date' WHERE loan_sl_no='$ln_sl' AND member_id='$member_id[$i]';";
	}
			
		}//end of for loop
	//echo "<h1>$sql_statement1</h1>";

	//echo "<h1>due:$total_recovery_due_int AND  OD:$total_recovery_odue_int AND  Principal:$total_recovery_princippal</h1>";
	
	}
/*if($amount>=($d_int+$od_int)){
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
	$r_i_d=$total_recovery_due_int;
	$r_i_od=$total_recovery_odue_int;
	$r_p=$total_recovery_principal;
	$b_p=$d_principal-$r_p;
	$b_i_d=$d_int-$r_i_d;
	$b_i_od=$od_int-$r_i_od;
	
$sql_statement1.=";INSERT INTO loan_return_dtl (tran_id,loan_serial_no,account_no, action_date,r_total_amount,r_due_int,r_overdue_int,r_principal,b_due_int,b_overdue_int, b_principal,staff_id,entry_time) VALUES('$t_id','$ln_sl','$account_no','$action_date',$amount, $r_i_d,$r_i_od,$r_p,$b_i_d,$b_i_od,$b_p,'$staff_id',CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
	//For GL ENTRY-------------------------------------
	$sql_statement1.=";INSERT INTO gl_ledger_hrd(tran_id,type, action_date,fy,remarks, operator_code, entry_time) VALUES ('$t_id','jgl','$action_date','$fy','$remarks','$staff_id', CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
	$sql_statement1.=";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','28101',$amount,'Dr','jgl repay')";
	if($r_i_od>0){
	$gl_od=getGLCodeLoanInterest($gl_code_p,'o');
	$sql_statement1.=";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','$account_no','$gl_od',$r_i_od,'Cr','over due interest')";
	}
	if($r_i_d>0){
	$gl_d=getGLCodeLoanInterest($gl_code_p,'d');
	$sql_statement1.=";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','$account_no','$gl_d',$r_i_d,'Cr','due interest')";
	}
	if($r_p>0){
	//$gl_d=getGLCodeLoanInterest($gl_code_p,'d');
	$sql_statement1.=";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','$account_no','$gl_code_p',$r_p,'Cr','principal')";
	}
       if($b_p<1){
	$sql_statement1.=";UPDATE loan_ledger_hrd SET status='cl',closing_date='$action_date' WHERE loan_serial_no='$ln_sl' AND account_no='$account_no'";
	}

   	echo $sql_statement1;
	$result1=dBConnect($sql_statement1);
	if(pg_affected_rows($result1)<1){
		echo "<br><h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
			} 
		else{
			echo "<h4><font color=\"Green\">Sucessfully inserted data into database.</font><br>Your Transaction Id:$t_id</h4>";
			echo "<pre><font size=\"+2\"><b>Your Amount Allocated as: <br>";
			echo "Principal          : Rs. $r_p <br>";
			echo "Due Interest        : Rs. $r_i_d<br>";
			echo "Over Due Interest  : Rs. $r_i_od<br>";
			echo "Total              : Rs. $amount";
			echo "</font></pre>";
			echo "<font size=+1><a href=\"../main/set_account.php?menu=$menu&account_no=$group_no\">Click</a> here to go Statement"; 

		}


}



}

?>
