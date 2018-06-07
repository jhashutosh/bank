<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$account_no=$_REQUEST['account_no'];
$account_type=$_REQUEST['account_type'];
$type_of=$_REQUEST['type_of'];
$bank_name=$_REQUEST['bank_name'];
$branch_name=$_REQUEST['branch_name'];
$certifiacate_no=$_REQUEST['cer_no'];
$op_date=$_REQUEST['op_date'];
$remarks=$_REQUEST['remarks'];
echo "<html>";
echo "<head>";
echo "<script src=\"../JS/loading1.js\"></script>";
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";
echo "<title>Investment";
echo "</title>";
?>
<SCRIPT LANGUAGE="JavaScript">
function onCheck(){
	if(str.length==0){
		alert("This Account No Is Not Mature")
	}
	else{
		if(str=="ln"){
			alert(str)
			document.form1.gl_code.disabled=false;
		
			}
		
	}
}
function f1(){
showHint(str);
}
function f2(str){
if(str=='po'){
//alert(str);
document.form1.ac_type.disabled=false;
}
else{
document.form1.ac_type.disabled=true;
}
document.form1.gl_code.disabled=true;
}
function f3(str){
if(str=='cash'){
document.form1.ch_no.value=0;
document.form1.ch_no.disabled=true;
document.form1.bank_ac_no.disabled=true;
document.form1.rm.focus();
}
if(str=='ch'){
document.form1.ch_no.disabled=false;
document.form1.bank_ac_no.disabled=false;
document.form1.ch_no.value='';
document.form1.ch_no.focus();
}
if(str=='trf'){
document.form1.ch_no.value=0;
document.form1.ch_no.disabled=true;
document.form1.bank_ac_no.disabled=false;
document.form1.bank_ac_no.focus();
}
if(str=='dft'){
document.form1.ch_no.disabled=false;
document.form1.bank_ac_no.disabled=true;
document.form1.ch_no.value='';
document.form1.ch_no.focus();
}
if(str.length==0){
document.form1.ch_no.value=0;
document.form1.ch_no.disabled=true;
document.form1.bank_ac_no.disabled=true;
}
}
</script>
<?php
//--------------------------------------------------------------------------------INSERT
if($_REQUEST['o']=='i'){
$maturity_date=$_REQUEST['mat_dt'];
$maturity_amount=$_REQUEST['mat_amt'];
$interest_rate=$_REQUEST['int_rate'];
$principal=$_REQUEST['principal'];
$ch_no=$_REQUEST['ch_no'];
$payment_term=$_REQUEST['p_mode'];
$bank_account_no=$_REQUEST['bank_ac_no'];
$bk_gl_code=getGlCode4mBank($bank_account_no);
//$type_of=getIndex($source_type_array,$type_of);
if($type_of=='po' && $account_type=='oth'){
$account_type=(empty($_REQUEST['ac_type']))?$account_type:strtolower($_REQUEST['account_type1']);
}
$gl_code=getData(trim($_REQUEST['gl_code']));
//$fy=getFy($op_date);
$fy=$_SESSION['fy'];
if(empty($fy)){
echo "<h1><center><b>You Can't Insert any value Into database Because Financial Year already Locked by administrator !!!!!!!!!";
}
else{
//bank_bk_dtl 
$sql_statement="INSERT INTO bank_bk_dtl(link_tb,account_no,account_type,b_type,b_name,br_name, op_date,gl_code,status,remarks,operator_code,entry_time,account_sub_type) VALUES(default,'$account_no', '$account_type','$type_of','$bank_name','$branch_name','$op_date','$gl_code','op','$remarks', '$staff_id',CAST('$op_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP),'$account_type')";
//deposit_info
$sql_statement.=";INSERT INTO deposit_info(account_no,certificate_no,account_type,action_date, principal,interest_rate,maturity_date,maturity_amount,operator_code,entry_time) VALUES('$account_no','$certifiacate_no','$account_type','$op_date',$principal,$interest_rate, '$maturity_date',$maturity_amount,'$staff_id',CAST('$op_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))"; 
//gl_ledger_hrd
$t_id=getTranId();
$vou_type='c'.$account_type;
$sql_statement.=";INSERT INTO gl_ledger_hrd (tran_id,type,action_date, certificate_no,fy,cheque_no,cheque_dt,operator_code,entry_time)VALUES ('$t_id','$vou_type','$op_date','$certifiacate_no','$fy','$ch_no','$op_date','$staff_id', CAST('$op_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
//gl_ledger_dtl
$sql_statement.=";INSERT INTO gl_ledger_dtl (tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES ('$t_id','$account_no', '$gl_code',$principal,'Dr','$payment_term')";
if($payment_term=='cash'){
$sql_statement.=";INSERT INTO gl_ledger_dtl (tran_id,gl_mas_code,amount,dr_cr, particulars) VALUES ('$t_id','28101',$principal,'Cr','$payment_term')";
}else{
$sql_statement.=";INSERT INTO gl_ledger_dtl (tran_id,gl_mas_code,account_no,amount,dr_cr, particulars)VALUES ('$t_id','$bk_gl_code','$bank_account_no',$principal,'Cr','$payment_term')";
}
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_affected_rows($result)<1){echo "<h3><font color=\"RED\">Failed to insert data into database.</font></h3>";
	} 
    }
}

echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\"/>";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"f1();\">";
echo "<hr>";
//========================Entry Form ====================================
echo "<form name=\"form1\" method=\"post\" action=\"bk_investment.php?menu=bb&o=i\">";
echo "<table align=center width=100% bgcolor=\"BLACK\">";
echo "<tr><th colspan=\"6\" bgcolor=\"#8B008B\"><font color=white size=5>Create New Investment In Bank</font></th>";
echo "<tr>";
echo "<td bgcolor=\"#6B8E23\">Type of :<td bgcolor=\"#6B8E23\">";
makeSelectwithJS($bk_type_array,'type_of',"","type_of","onchange=\"f2(this.value);\"");
echo "<td bgcolor=\"#6B8E23\">Account Type:<td bgcolor=\"#6B8E23\">";
makeSelectwithJS($in_type_bank,'account_type',"","account_type","onchange=\"showHint(this.value);\"");
echo"<input type=TEXT name=\"ac_type\" id=\"ac_type\" size=\"7\" $HIGHLIGHT disabled>";
echo "<td bgcolor=\"#6B8E23\">Investment Catagory:<td bgcolor=\"#6B8E23\">";
//makeSelectDisabled($ccb_loan_array,'gl_code',"");
?>
<span id="txtHint"></span>
<?php
echo "<tr>";
echo "<td bgcolor=\"#6B8E23\">Bank Name:<td bgcolor=\"#6B8E23\"><input type=TEXT name=\"bank_name\" size=\"15\" $HIGHLIGHT>";
echo "<td bgcolor=\"#6B8E23\">Branch Name:<td bgcolor=\"#6B8E23\"><input type=TEXT name=\"branch_name\" size=\"15\" $HIGHLIGHT>";
echo "<td bgcolor=\"#6B8E23\">Opening Date:<td bgcolor=\"#6B8E23\"><input type=TEXT name=\"op_date\" size=\"10\" VALUE=\"".date('d.m.Y')."\" $HIGHLIGHT>";
echo "<tr>";

echo "<td bgcolor=\"#6B8E23\">Account No:<td bgcolor=\"#6B8E23\"><input type=TEXT name=\"account_no\" size=\"16\" $HIGHLIGHT>";
echo "<td bgcolor=\"#6B8E23\">Certificate No:<td bgcolor=\"#6B8E23\"><input type=TEXT name=\"cer_no\" size=\"16\" $HIGHLIGHT>";
echo "<td bgcolor=\"#6B8E23\">Principal:<td bgcolor=\"#6B8E23\">&nbsp;Rs.<input type=TEXT name=\"principal\" size=\"12\" $HIGHLIGHT>";


echo "<tr>";
echo "<td bgcolor=\"#6B8E23\">Maturity Date<td bgcolor=\"#6B8E23\"><input type=TEXT name=\"mat_dt\" size=\"12\" $HIGHLIGHT>";
echo "<td bgcolor=\"#6B8E23\">Rate of Interest:<td bgcolor=\"#6B8E23\">&nbsp;Rs.<input type=TEXT name=\"int_rate\" size=\"5\" $HIGHLIGHT> &nbsp;%";
echo "<td bgcolor=\"#6B8E23\">Maturity Amount:<td bgcolor=\"#6B8E23\">&nbsp;Rs.<input type=TEXT name=\"mat_amt\" size=\"10\" VALUE=\"\" $HIGHLIGHT>";

echo "<tr>";
echo "<td bgcolor=\"#6B8E23\">Payment Mode:<td bgcolor=\"#6B8E23\">";
makeSelectwithJS($mode_array,'p_mode',"","p_mode","onchange=\"f3(this.value);\"");
echo "<td bgcolor=\"#6B8E23\">Cheque No:<td bgcolor=\"#6B8E23\"><input type=TEXT name=\"ch_no\" size=\"12\" id=\"ch_no\" value=\"0\" disabled $HIGHLIGHT>";
echo "<td bgcolor=\"#6B8E23\">Transfer From<td bgcolor=\"#6B8E23\">";
selectBankAccount('bank_ac_no','DISABLED','');
echo "<tr>";
echo "<td bgcolor=\"#6B8E23\">Remarks:<td colspan=5 bgcolor=\"#6B8E23\" valign=\"center\"><textarea name=\"remarks\" rows=\"2\" cols=\"80\" id=\"rm\" $HIGHLIGHT></textarea>";
echo "&nbsp;<input type=\"submit\" value=\"submit\">";
echo "</table>";
echo "</form>";

//-------------------------------------------------

echo "<hr>";

//--------------------Display
$sql_statement="SELECT * FROM bank_bk_dtl WHERE (account_type<>'sb' AND account_type<>'ca' AND account_type<>'ln' AND account_type<>'sh') order by account_type";
//echo "$sql_statement";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
echo "<table align=center bgcolor=silver width=100%>";
echo "<tr><th colspan=5 bgcolor=#8A2BE2><font color=white>Bank Account Details</font></th>";
echo "<tr bgcolor=GREEN><th>Sl No.<th>A/C No.<th>Bank Name<th>Balance<th>Operation";
		$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
 		if($j==0){
			echo"<tr><td colspan=5 align=center bgcolor='#9A9A9A'><font color='white' size=+1>".ucwords($type_of_account1_array[$row['account_type']])."</td></tr>";
			$type=trim($row['account_type']);
		}	
		if($type!=$row['account_type']){
			$type=trim($row['account_type']);
			echo"<tr><td colspan=5 align=center bgcolor='#9A9A9A'><font color='white' size=+1>".ucwords($type_of_account1_array[$row['account_type']])."</td></tr>";


		}
		echo "<tr>";
		echo "<td bgcolor=$color align=\"CENTER\"><B>".($j+1);
		echo "<td bgcolor=$color align=\"CENTER\"><B>".strtoupper($row['account_type'])."[".$row['account_no']."]";
		echo "<td bgcolor=$color align=\"CENTER\"><B>".$row['b_name'];
		$balance=(float)ccb_deposits_current_balance($row['account_no'],'');
		echo "<td bgcolor=$color align=\"RIGHT\"><B>".amount2Rs($balance);
	$sql1="SELECT (CURRENT_DATE-maturity_date) as days  FROM bk_investment WHERE account_no='".$row['account_no']."' and account_type='ri' and withdrawal_type is null";

	$res=dBConnect($sql1);
	$row1=pg_fetch_array($res);
	$days=$row1['days'];
	//echo $sql1;
	//echo $days;
		if(trim($row['account_type'])=='rd'){
		//statement
		echo "<td bgcolor=$color align=\"CENTER\"><B><a href=\"statement.php?menu=".$row['account_type']."&id=".$row['link_tb']."&account_no=".$row['account_no']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;\">Statement</a>&nbsp;||&nbsp;";
		//deposit
		echo "<a href=\"operation_page.php?menu=".$row['account_type']."&id=".$row['link_tb']."&account_no=".$row['account_no']."&op=d\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=600,height=300'); return false;\">Deposit</a>";
		if($balance>0){
		//withdrawal
		//echo "&nbsp;||&nbsp;<a href=\"withdrawal.php?menu=".$row['account_type']."&id=".$row['link_tb']."&account_no=".$row['account_no']."&op=w\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=950,height=500'); return false;\">Withdrawal</a>";
		}
            }
	    else{
		//statement
		echo "<td bgcolor=$color align=\"CENTER\"><B><a href=\"statement.php?menu=".$row['account_type']."&op=1&id=".$row['link_tb']."&account_no=".$row['account_no']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=400'); return false;\">Statement</a>&nbsp;";
		
		
		//withdrawal
		//echo "&nbsp;||&nbsp;<a href=\"withdrawal.php?menu=".$row['account_type']."&id=".$row['link_tb']."&account_no=".$row['account_no']."&op=w\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=950,height=500'); return false;\">Withdrawal</a>";
//--------------------------------------------------------update--------------------------------------------------------//
	
		if($days<0)
		{//echo $unmtr_dt;
			echo "&nbsp;||&nbsp;<a  href=\"#\" onClick=\"javascript:alert('This Account No Is Not Mature');\">Renewal</a>";
		}
		else
		{//echo $unmtr_dt;

		echo "&nbsp;||&nbsp;<a href=\"renew.php?menu=".$row['account_type']."&id=".$row['link_tb']."&account_no=".$row['account_no']."&op=r\" onClick=\"window.open	(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=600,height=300'); return false;\">Renewal</a>";
	
		}
		}		
		
	}
}
//---------------------------------------------------------------------------------------------
?>
<script language="JavaScript" type="text/javascript">
 var frmvalidator  = new Validator("form1");
  frmvalidator.addValidation("type_of","req","Please Select Bank Type.");
  frmvalidator.addValidation("account_type","req","Please Select Bank Account Type");
  frmvalidator.addValidation("op_date","req","Please enter Account Opening date");
  frmvalidator.addValidation("bank_name","req","Please enter the Bank Name");
  frmvalidator.addValidation("account_no","req","Please enter Account No");
  frmvalidator.addValidation("branch_name","req","Please enter Branch Name");
  frmvalidator.addValidation("principal","req","Please Enter the principal Amount!!!!");
  frmvalidator.addValidation("principal","dec","Princpal Amount Should be positive numeric Number!!!!!!");
  frmvalidator.addValidation("mat_amt","req","Please enter Maturity Amount");
  frmvalidator.addValidation("mat_dt","req","Please enter Maturity Date");
  frmvalidator.addValidation("ch_no","req","Please enter Cheque No");
  frmvalidator.addValidation("p_mode","req","Payment Mode should not be Null!!!!");
  frmvalidator.addValidation("int_rate","req","Please enter Rate of Interest");
  frmvalidator.addValidation("mat_amt","dec","Maturity Amount Should be positive numeric Number!!!!!!");
  frmvalidator.addValidation("int_rate","dec","interest Rate Should be positive numeric Number!!!!!!");
 
  
  </script>
