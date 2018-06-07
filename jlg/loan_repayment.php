<?php
include "../config/config.php";
$staff_id=verifyAutho();
$group_no=$_SESSION["current_account_no"];
$menu=$_REQUEST['menu'];
$op=$_REQUEST['op'];
$account_no=$_REQUEST["loan_no"];
$ln_sl=$_REQUEST['ln_sl'];
$action_date=$_REQUEST['action_date'];
if(empty($op)){
if(empty($action_date)){
$sql_statement="SELECT shg_mem_loan_dtl('$account_no',CURRENT_DATE) as int";
}
else{
$sql_statement="SELECT shg_mem_loan_dtl('$account_no','$action_date') as int";
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
echo "<script src=\"../JS/jquery-1.9.1.js\"></script>";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"amount.focus();\">";
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
	echo "<tr><th bgcolor=YELLOW colspan=\"9\">SHG Loan Details of [$account_no] as on ".$action_date."</th>";
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
	if(!empty($loan_sl_no))
	{
		echo "<td align=Center bgcolor=$color><a href=\"loan_repayment.php?menu=$menu&loan_no=$account_no&ln_sl=$loan_sl_no&op=r&action_date=$action_date\">Repay</td>";
		}
	else	
	{
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
echo "<tr><th bgcolor=\"#808000\" colspan=\"4\"><font size=-1>SHG Loan Repayment Form of [$account_no]</font>";
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
echo "<td>Principal :<td>Rs.&nbsp;<INPUT NAME=\"d_principal\" id=\"d_principal\" TYPE=\"TEXT\" VALUE=\"$principal\" $HIGHLIGHT size=10 READONLY>";
echo "<tr><td >Due Interest :<td>Rs.&nbsp;<INPUT NAME=\"r_d_int\" TYPE=\"TEXT\" VALUE=\"$d\" $HIGHLIGHT size=10 READONLY>";
echo "<td>Due Interest :<td>Rs.&nbsp;<INPUT class='due_int' NAME=\"d_int\" TYPE=\"TEXT\" VALUE=\"$due_i\" $HIGHLIGHT size=10 id=\"d_int\" READONLY>";
echo "<tr><td>Over Due Interest:<td>Rs.&nbsp;<INPUT NAME=\"r_od_int\" TYPE=\"TEXT\" VALUE=\"$o\" $HIGHLIGHT size=\"10\" READONLY>";
echo "<td>Over Due Interest:<td>Rs.&nbsp;<INPUT class='od_int' NAME=\"od_int\" TYPE=\"TEXT\" VALUE=\"$odue_i\" $HIGHLIGHT size=\"10\" id=\"od_int\" READONLY>";
echo "<tr><td>Total:<td>Rs.&nbsp;<INPUT NAME=\"total_r\" TYPE=\"TEXT\" VALUE=\"".($o+$p+$d)."\" $HIGHLIGHT size=\"10\" READONLY>";
echo "<td>Total:<td>Rs.&nbsp;<INPUT class='form_total' NAME=\"total_d\" TYPE=\"TEXT\" VALUE=\"".($principal+$odue_i+$due_i)."\" $HIGHLIGHT size=\"10\" id=\"o\" READONLY>";
echo "<tr><td>Days:<td>Rs.&nbsp;<INPUT NAME=\"days\" TYPE=\"TEXT\" VALUE=\"$days\" $HIGHLIGHT size=5>";
echo "</table><hr>";
echo "<table align=center width=100% class='shg_table'>";

echo "<tr><TH colspan=16 bgcolor=BLUE><font color=WHITE size=-1><b>SHG Loan Repaymnt Details Form";
$sql_statement="SELECT * FROM shg_mem_loan_dtl_v  WHERE ln_sl='$ln_sl'";
$result=dBConnect($sql_statement);
//echo $sql_statement; 
echo "<tr>";
$color="GREEN";
echo "<th bgcolor=$color Rowspan=\"2\">Name</th>";
echo "<th bgcolor=$color Rowspan=\"2\">Days</th>";
echo "<th bgcolor=$color Rowspan=\"2\">Principal<br>(Rs.)</th>";
echo "<th bgcolor=WHITE colspan=\"3\">Recovery</th>";
echo "<th bgcolor=$color colspan=\"3\">Balance</th>";
echo "<th bgcolor=$color Rowspan=\"2\">Total<br>(Rs.)</th>";
echo "<th bgcolor=#CDCDCD colspan=\"3\">Payment</th>";

echo "<th bgcolor=$color Rowspan=\"2\">Amount</th>";
echo "<tr><th bgcolor=WHITE>Due</th>";
echo "<th bgcolor=WHITE >Odue</th>";
echo "<th bgcolor=WHITE >Prin</th>";
echo "<th bgcolor=$color >Due</th>";
echo "<th bgcolor=$color >Odue</th>";
echo "<th bgcolor=$color >Prin</th>";
echo "<th bgcolor=#A9A9A9 >Due</th>";
echo "<th bgcolor=#A9A9A9 >Odue</th>";
echo "<th bgcolor=#A9A9A9 >Prin</th>";

if(pg_NumRows($result)>0){
for($j=0; $j<pg_NumRows($result); $j++){
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
echo "<tr>";
$sl_no=$row['customer_id'];
echo "<td bgcolor=$color><input type=\"checkbox\" name=\"music\" value=\"$sl_no\" onclick=\"ShowInfo(this.value);\">".ucwords($row['name1']);
echo " ( ".ucwords($row['designation1']).")";
echo "<td bgcolor=$color>".($row['days']);
echo "<td bgcolor=$color align=right>
<span class='prin'>".(int)($row['p'])."</span>";//------------------------------princ
echo "<td bgcolor=$color align=right>".amount2Rs(($row['r_d_i']));
echo "<td bgcolor=$color align=right>".amount2Rs(($row['r_od_i']));
echo "<td bgcolor=$color align=right class='r_p'>".($row['r_p']);
echo "<td bgcolor=$color align=right><input class='b_d' type=text name=\"b_d_i\" size=\"3\" value=\"".($row['b_d_i'])."\"  $HIGHLIGHT READONLY>";

echo "<td bgcolor=$color align=right><input class='b_o' type=text name=\"b_od_i\" size=\"3\" value=\"".($row['b_od_i'])."\"  $HIGHLIGHT READONLY>";

$t_due=$row['b_od_i']+$row['b_d_i'];

$t_due_int+=$row['b_d_i'];
$t_od_int+=$row['b_od_i'];
echo "<td bgcolor=$color align=right><input class='b_p' type=text name=\"b_p\" size=\"5\" value=\"".($row['b_p'])."\"  $HIGHLIGHT onkeypress=\"return numbersonly(event)\" READONLY>";
echo "<td bgcolor=$color align=right><input class='total' type=text name=\"t_r\" size=\"5\" value=\"".($t_due+$row['b_p']). "\"  $HIGHLIGHT READONLY onkeypress=\"return numbersonly(event)\">";
echo "<td bgcolor=$color align=right><input class='p_d' type=text name=\"rb_d_i\" size=\"3\" value=\"0\"  $HIGHLIGHT READONLY onkeypress=\"return numbersonly(event)\">";
echo "<td bgcolor=$color align=right><input class='p_o' type=text name=\"rb_od_i\" size=\"3\" value=\"0\" $HIGHLIGHT READONLY onkeypress=\"return numbersonly(event)\">";
echo "<td bgcolor=$color align=right><input class='p_p' type=text name=\"rb_p\" size=\"5\" value=\"0\"  $HIGHLIGHT READONLY onkeypress=\"return numbersonly(event)\">";

//echo "<td bgcolor=$color><input type=text name=\"due\" size=\"3\" disabled $HIGHLIGHT>";
//echo "<td bgcolor=$color><input type=text name=\"overdue\" size=\"3\" disabled $HIGHLIGHT>";
echo "<td bgcolor=$color><input class='amt' type=text name=\"name\" size=\"7\" READONLY $HIGHLIGHT>";
}

echo "<input type=\"HIDDEN\" value=\"\" name=\"member_info\" id=\"member_info\">";
echo "<input type=\"HIDDEN\" value=\"\" name=\"member_amount\" id=\"member_amount\">";


echo "<tr><td bgcolor=#9370D8 colspan=\"14\" align=\"RIGHT\"><i>Your Total Collected Amount is</i><span style='margin:5px' class='totAmt' id='totAmt'>0</span> /=<input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" VALUE=\" GO \" >";
echo "</table>";
echo "</FORM>";
	}
   }
 }
//exit;
?>
<script language="JAVASCRIPT">
$(function(){
	$(".shg_table .b_d").change(function(){
		var row=$(this.parentNode.parentNode);
		total(row);
	});
	$(".shg_table .b_o").change(function(){
		var row=$(this.parentNode.parentNode);
		total(row);
	});
	$(".shg_table .p_d").change(function(){
		var row=$(this.parentNode.parentNode);
		var b_d=parseFloat(row.find(".b_d").val(),10);
		if(b_d>=parseFloat(this.value,10)){
			totalAmt(row);showTotalAmt();
		}
		else{
			this.value='0';
		}
	});
	$(".shg_table .p_o").change(function(){
		var row=$(this.parentNode.parentNode);
		var b_o=parseFloat(row.find(".b_o").val(),10);
		if(b_o>=parseFloat(this.value,10)){
			totalAmt(row);showTotalAmt();
		}
		else{
			this.value='0';totalAmt(row);showTotalAmt();
		}
	});
	$(".shg_table .p_p").change(function(){
		var row=$(this.parentNode.parentNode);
		var b_p=parseFloat(row.find(".b_p").val(),10);
		if(b_p>=parseFloat(this.value,10)){
			totalAmt(row);showTotalAmt();
		}
		else{
			this.value='0';totalAmt(row);showTotalAmt();
		}
	});
	function showTotalAmt(){
		var tot=0;
		$.each($(".shg_table .amt"),function(){
			if(this.value!=null && this.value!='' && typeof this.value!='undefine'){
				tot+=parseFloat(this.value,10);
				
			}
		});
		$(".shg_table .totAmt").html(tot);
	}
	function total(row){
		var prin=parseFloat(row.find(".prin").html(),10);
		var r_prin=parseFloat(row.find(".r_p").html(),10);
		var b_d=parseFloat(row.find(".b_d").val(),10);
		var b_o=parseFloat(row.find(".b_o").val(),10);
		row.find(".total").val((b_d+b_o+prin-r_prin).toFixed(2));
		row.find(".p_d").val(0);
		row.find(".p_o").val(0);
		row.find(".p_p").val(0);
		dueInt();odInt();
		totalAmt(row);
		showTotalAmt();
		form_total();
	}
	function totalAmt(row){
		var p_d=parseFloat(row.find(".p_d").val(),10);
		var p_o=parseFloat(row.find(".p_o").val(),10);	
		var p_p=parseFloat(row.find(".p_p").val(),10);
		row.find(".amt").val(p_d+p_o+p_p);		
	}
	function dueInt(){
		var tot=0;
		$.each($(".shg_table .b_d"),function(){
		tot+=parseFloat(this.value,10);	
		});
		$(".due_int").val(tot);
	}
	function odInt(){
		var tot=0;
		$.each($(".shg_table .b_o"),function(){
		tot+=parseFloat(this.value,10);	
		});
		$(".od_int").val(tot);
	}
	function form_total(){
		var tot=0;
		$.each($(".shg_table .total"),function(){
		tot+=parseFloat(this.value,10);	
		});
		$(".form_total").val(tot);
	}
});
function ShowInfo(){
	
	if(document.orderform.music.length>1){
	
		for (var i=0; i < document.orderform.music.length; i++){
			//alert(document.orderform.music[i].checked);
	   		if (document.orderform.music[i].checked){
				//alert("checked");
				//alert(document.orderform.rb_d_i[i].value)
				$(document.orderform.rb_d_i[i]).attr('readonly',false);
				$(document.orderform.rb_od_i[i]).attr('readonly',false);	
				$(document.orderform.b_d_i[i]).attr('readonly',false);
				$(document.orderform.b_od_i[i]).attr('readonly',false);
				$(document.orderform.rb_p[i]).attr('readonly',false);
				
				//document.orderform.rb_d_i[i].focus();
                        	// alert("bye")
							}
			else{
				
				$(document.orderform.rb_d_i[i]).attr('readonly',true);
				$(document.orderform.rb_od_i[i]).attr('readonly',true);	
				$(document.orderform.b_d_i[i]).attr('readonly',true);
				$(document.orderform.b_od_i[i]).attr('readonly',true);
				$(document.orderform.rb_p[i]).attr('readonly',true);
				document.orderform.rb_d_i[i].value=0;
				document.orderform.rb_od_i[i].value=0;
				document.orderform.rb_p[i].value=0;
				document.orderform.name[i].value='';
				var tot=0;
				$.each($(".shg_table .amt"),function(){
				if(this.value!=null && this.value!='' && typeof this.value!='undefine'){
					tot+=parseFloat(this.value,10);
				
					}
				});
				$(".shg_table .totAmt").html(tot);
			
			}
		}
	}
	
    else{
		if (document.orderform.music.checked){
			$(document.orderform.rb_d_i).attr('readonly',false);
			$(document.orderform.rb_od_i).attr('readonly',false);	
			$(document.orderform.b_d_i).attr('readonly',false);
			$(document.orderform.b_od_i).attr('readonly',false);
			$(document.orderform.rb_p).attr('readonly',false);
		
			document.orderform.rb_d_i.focus();
			
			}
		else{
			$(document.orderform.rb_d_i).attr('readonly',true);
			$(document.orderform.rb_od_i).attr('readonly',true);	
			$(document.orderform.b_d_i).attr('readonly',true);
			$(document.orderform.b_od_i).attr('readonly',true);
			$(document.orderform.rb_p).attr('readonly',true);
			document.orderform.rb_d_i.value=0;
			document.orderform.rb_od_i.value=0;
			document.orderform.rb_p.value=0;
			document.orderform.name.value='';
			var tot=0;
			$.each($(".shg_table .amt"),function(){
			if(this.value!=null && this.value!='' && typeof this.value!='undefine'){
				tot+=parseFloat(this.value,10);
			
				}
			});
			$(".shg_table .totAmt").html(tot);
			}
			
	   }
}
//---------------------------------------------------------------------------------------------
function numbersonly(e){
	var unicode=e.charCode? e.charCode : e.keyCode;
	//alert(unicode)
	if (unicode!=8){ 
		if (unicode<46||unicode>57||unicode==47) {
			return false;
		
		}
	}
}
//---------------------------------------------------------------------------------------------
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
//---------------------------------------------------------------------------------------
function varify(){
	 	
var flag=0;
var c_value ="";
var amt=0;
if(document.orderform.music.length>1){
	for (var i=0; i < document.orderform.music.length; i++){
		if (document.orderform.music[i].checked){
			c_value +=document.orderform.music[i].value+','+document.orderform.b_d_i[i].value+','+document.orderform.b_od_i[i].value+','+document.orderform.b_p[i].value+','+document.orderform.rb_d_i[i].value+','+document.orderform.rb_od_i[i].value+','+document.orderform.rb_p[i].value+'|';
			amt+=parseFloat(document.orderform.rb_d_i[i].value)+parseFloat(document.orderform.rb_od_i[i].value)+parseFloat(document.orderform.rb_p[i].value);
        		flag=1;
		}
	
	}//end of for loop
}
else{
	if (document.orderform.music.checked){
		c_value +=document.orderform.music.value+','+document.orderform.b_d_i.value+','+document.orderform.b_od_i.value+','+document.orderform.b_p.value+','+document.orderform.rb_d_i.value+','+document.orderform.rb_od_i.value+','+document.orderform.rb_p.value+'|';
		flag=1;
		amt+=parseFloat(document.orderform.rb_d_i.value)+parseFloat(document.orderform.rb_od_i.value)+parseFloat(document.orderform.rb_p.value);	
	}
}
if(amt==0){
	alert("Please repay atleast one of member");
	return false;

}
if(flag==0){
	
	alert("Please check atleast one of member");
	return false;
}
document.getElementById("member_info").value=c_value;

}
//---------------------------------------------------------------------------------------------------------
</script>
<?php

if($op=='i'){
$d_principal=$_REQUEST['d_principal'];
$member_info=$_REQUEST['member_info'];
echo "<h1>$member_info</h1>";
//echo "<h1>$member_amount</h1>";
$gl_status=$_REQUEST['gl_status'];
$d_int=$_REQUEST['d_int'];
$od_int=$_REQUEST['od_int'];
$ln_sl=$_REQUEST['ln_sl'];
$action_date=$_REQUEST['action_date'];
$member_data=explode("|",$member_info);
$gl_code=getGlCode4mCustomerAccount($account_no,$action_date);
$fy=getFy($action_date);
if(empty($fy)){
	echo "<h1><center><b>You Can't Insert any value Into database Because Financial Year already Locked by administrator !!!!!!!!!</h1>";
		} 

else{
	$t_id=getTranId();
	$gl_code_p=getGlCode4mLoanLedger($ln_sl,$gl_status);
	for($i=0;$i<count($member_data)-1;$i++)
	{
		$individual_data=explode(",",$member_data[$i]);
		
		$member_id=$individual_data[0];
		$d_amount=$individual_data[1];
		$od_amount=$individual_data[2];
		$principal_amount=$individual_data[3];
		$r_i_d=$individual_data[4];
		$r_i_od=$individual_data[5];
		$r_p=$individual_data[6];
		$b_p=$principal_amount-$r_p;
		$b_i_d=$d_amount-$r_i_d;
		$b_i_od=$od_amount-$r_i_od;
		$t_d_i+=$r_i_d;
		$t_od_i+=$r_i_od;
		$t_p+=$r_p;
		$sql_statement1.="INSERT INTO shg_loan_ledger_dtl(tran_id, loan_sl_no,member_id, action_date,r_principal,r_d_int,r_od_int,b_principal,b_d_int,b_od_int,staff_id,entry_time) VALUES('$t_id','$ln_sl','".$member_id."','$action_date',$r_p,$r_i_d,$r_i_od,$b_p, $b_i_d,$b_i_od,'$staff_id',CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP));";
		if($b_p<1&& $b_i_d==0 && $b_i_od==0){
			$sql_statement1.=";UPDATE shg_loan_ledger_hrd SET status='cl' WHERE loan_sl_no='$ln_sl' AND member_id='$member_id';";
		}
			
	}//end of for loop
	//echo "<h1>$sql_statement1</h1>";
echo "<h1>total_due_int:$d_int========total_odue_int:$od_int=======total_proi:$d_principal</h1>";
$b_i_d=$d_int-$t_d_i;
$b_i_od=$od_int-$t_od_i;
$b_p=$d_principal-$t_p;
$amount=$t_d_i+$t_od_i+$t_p;
echo "<h1>total_due_int:$b_i_d========total_odue_int:$b_i_od=======total_proi:$b_p</h1>";
$sql_statement1.=";INSERT INTO loan_return_dtl (tran_id,loan_serial_no,account_no, action_date,r_total_amount,r_due_int,r_overdue_int,r_principal,b_due_int,b_overdue_int, b_principal,staff_id,entry_time) VALUES('$t_id','$ln_sl','$account_no','$action_date',$amount,$t_d_i,$t_od_i,$t_p,$b_i_d,$b_i_od,$b_p,'$staff_id',CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
	//For GL ENTRY-------------------------------------
	$sql_statement1.=";INSERT INTO gl_ledger_hrd(tran_id,type, action_date,fy,remarks, operator_code, entry_time) VALUES ('$t_id','sgl','$action_date','$fy','$remarks','$staff_id', CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
	$sql_statement1.=";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','28101',$amount,'Dr','sgl repay')";
	if($t_od_i>0)
	{
		$gl_od=getGLCodeLoanInterest($gl_code_p,'o');
		$sql_statement1.=";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','$account_no','$gl_od',$t_od_i,'Cr','over due interest')";
	}
	if($t_d_i>0)
	{
		$gl_d=getGLCodeLoanInterest($gl_code_p,'d');
		$sql_statement1.=";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','$account_no','$gl_d',$t_d_i,'Cr','due interest')";
	}
	if($t_p>0)
	{
	//$gl_d=getGLCodeLoanInterest($gl_code_p,'d');
		$sql_statement1.=";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','$account_no','$gl_code_p',$t_p,'Cr','principal')";	
	}
echo "<h1>PRINCIPAL:$b_p==========DUE INT=$b_i_d::::::::::::::::OD:::::::$b_i_od</h1>";
        if($b_p<1 && $b_i_d==0 && $b_i_od==0)
	{
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
			echo "Principal          : Rs. $t_p <br>";
			echo "Due Interest        : Rs. $t_d_i<br>";
			echo "Over Due Interest  : Rs. $t_od_i<br>";
			echo "Total              : Rs. $amount";
			echo "</font></pre>";
			//echo "<font size=+1><a href=\"../main/set_account.php?menu=$menu&account_no=$account_no\">Click</a> here to go Statement"; 
			echo "<font size=+1><a href=\"../shg/loan_statement.php?menu=sgl&account_no=$account_no&op=i\">Click</a> here to go Statement";

		}


	}


}


}

?>
