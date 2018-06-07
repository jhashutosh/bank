<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$account_no=$_REQUEST['account_no'];
$account_type=$_REQUEST['account_type'];
$type_of=$_REQUEST['type_of'];
//$type_of_ln=$_REQUEST['type_of_ln'];
$bank_name=$_REQUEST['bank_name'];
$branch_name=$_REQUEST['branch_name'];
$op_date=$_REQUEST['op_date'];
$remarks=$_REQUEST['remarks'];
echo "<html>";
echo "<head>";
echo "<script src=\"../JS/loading.js\"></script>";
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";
echo "<title>Investment";
echo "</title>";
?>
<SCRIPT LANGUAGE="JavaScript">
function onCheck(){
	if(str.length==0){
		alert("You Should select First")
	}
	else{
		if(str=="ln"){
			alert(str)
			document.form1.gl_code.disabled=false;
		
			}
		//
	}
}
function f1(){
showHint(str);
}
function f2(str){
document.form1.gl_code.disabled=true;
}
function checking(){
if(document.form1.type_of.value.length==0){
	alert("Please Select the Bank Catagory")
	document.form1.type_of.focus();
	return false;
	
	
}
if(document.form1.account_type.value.length==0){
	alert("Please Select the Bank account type")
	return false;
	document.form1.account_type.focus();
	
}
if(document.form1.account_no.value.length==0){
	alert("Please enter the Bank account No")
	document.form1.account_no.focus();
	return false;
}
if(document.form1.bank_name.value.length==0){
	alert("Please enter the Bank Name")
	document.form1.bank_name.focus();
	return false;
}

if(document.form1.op_date.value.length==0){
	alert("Please enter the Bank account Opening Date")
	document.form1.op_date.focus();
	return false;
	
	
}
if(document.form1.branch_name.value.length==0){
	//alert(document.form1.account_type.value+"->"+document.form1.type_of.value)
	alert("Please enter the Breanch Name")
	document.form1.branch_name.focus();
	return false;
}
if(document.form1.account_type.value=='ln' && document.form1.type_of_ln.value.length==0){
	alert(document.form1.account_type.value+"->"+document.form1.type_of_ln.value)
	alert("Please Select the Loan catagory")
	document.form1.type_of_ln.focus();
	return false;
	}
//}
if((document.form1.type_of.value=='gvt'||document.form1.type_of.value=='ot') &&(document.form1.account_type.value=='sb'||document.form1.account_type.value=='ca')){
	alert("Please Select Proper source along with account type")
	return false;
}

}
</script>
<?php
//--------------------------------------------------------------------------------------------
//-------------------INSERT
if($_REQUEST['o']=='i'){
//$type_of=getIndex($source_type_array,$type_of);
$sub_type=$account_type;
if($type_of=='ccb' && $account_type=='ca'){$gl_code='28201';}	
if($type_of=='ccb' && $account_type=='sb'){$gl_code='28202';}
if($type_of=='cm' && $account_type=='ca'){$gl_code='28301';}
if($type_of=='cm' && $account_type=='sb'){$gl_code='28302';}
if($account_type=='ln'){
	$sub_type=$_REQUEST['type_of_ln'];
	$gl_code=$_REQUEST['gl_code'];
}
$sql_statement="INSERT INTO bank_bk_dtl(link_tb,account_no,account_type,account_sub_type,b_type,b_name,br_name, op_date,gl_code,status,remarks,operator_code,entry_time) VALUES(default,'$account_no', '$account_type','$sub_type','$type_of','$bank_name','$branch_name','$op_date','$gl_code','op','$remarks', '$staff_id',CAST('$op_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_affected_rows($result)<1) {echo "<h3><font color=\"RED\">Failed to insert data into database.</font></h3>";
	} 
}
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\"/>";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"f1();\">";
echo "<hr>";
//========================Entry Form ====================================
echo "<form name=\"form1\" method=\"post\" action=\"bank_books_new.php?menu=bb&o=i\" onsubmit=\"return checking();\">";
echo "<table align=center width=100% bgcolor=\"BLACK\">";
echo "<tr><th colspan=\"6\" bgcolor=\"green\"><font color=white size=5>Create New Bank A/C</font></th>";
echo "<tr>";
echo "<td bgcolor=\"#BDB76B\">Type of :<td bgcolor=\"#BDB76B\">";
makeSelectwithJS($source_type_array,'type_of',"","type_of","onchange=\"f2(this.value);\"");
//makeSelectValue($source_type_array,"type_of","");
echo "<td bgcolor=\"#BDB76B\">Account Type:<td bgcolor=\"#BDB76B\">";
makeSelectwithJS($account_type_bank,'account_type',"","account_type","onchange=\"showHint(this.value);\"");
makeSelectwithJS($bk_loan_type_array,'type_of_ln',"","type_of_ln","DISABLED");

//echo "</td>";
echo "<td bgcolor=\"#BDB76B\">Loan Catagory:<td bgcolor=\"#BDB76B\">";
//makeSelectDisabled($ccb_loan_array,'gl_code',"");
?>
<span id="txtHint"></span>
<?php
echo "<tr>";
echo "<td bgcolor=\"#BDB76B\">Account No:<td bgcolor=\"#BDB76B\"><input type=TEXT name=\"account_no\" id=\"account_no\" isize=\"12\" $HIGHLIGHT>";
echo "<td bgcolor=\"#BDB76B\">Bank Name:<td bgcolor=\"#BDB76B\"><input type=TEXT name=\"bank_name\" id=\"bank_name\" size=\"15\" $HIGHLIGHT>";
echo "<td bgcolor=\"#BDB76B\">Branch Name:<td bgcolor=\"#BDB76B\"><input type=TEXT name=\"branch_name\" id=\"branch_name\" size=\"15\" $HIGHLIGHT>";
echo "<tr>";
echo "<td bgcolor=\"#BDB76B\">Opening Date:<td bgcolor=\"#BDB76B\"><input type=TEXT name=\"op_date\" \id=\"op_date\" size=\"10\" VALUE=\"".date('d.m.Y')."\" $HIGHLIGHT>";
echo "<td bgcolor=\"#BDB76B\">Remarks:<td colspan=3 bgcolor=\"#BDB76B\" valign=\"center\"><textarea name=\"remarks\" rows=\"2\" cols=\"60\" $HIGHLIGHT></textarea>";
echo "<input type=\"submit\" value=\"submit\">";
echo "</table>";
echo "</form>";

//-------------------------------------------------

echo "<hr>";

//--------------------Display
$sql_statement="SELECT * FROM bank_bk_dtl WHERE (account_type='sb' OR account_type='ca' OR account_type='ln') AND status='op'";

//$sql_statement="SELECT * FROM bank_bk_dtl WHERE account_sub_type='sb' AND status='op' order by b_name";


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
		echo "<tr>";
		echo "<td bgcolor=$color align=\"CENTER\"><B>".($j+1);
		echo "<td bgcolor=$color><B>".strtoupper($row['account_sub_type'])."[".$row['account_no']."]";
		echo "<td bgcolor=$color><B>".strtoupper($row['b_name']);
		if(trim($row['account_type'])!='ln'){
		$balance=(float)ccb_deposits_current_balance($row['account_no'],'');
		if($balance>0){
			echo "<td bgcolor=$color align=\"RIGHT\"><B>".amount2Rs($balance)." Dr.";
		}
		else{
			echo "<td bgcolor=$color align=\"RIGHT\"><B>".amount2Rs($balance)." Cr.";
		}
		echo "<td bgcolor=$color align=\"\"><B><a href=\"statement.php?menu=".$row['account_type']."&op=1&id=".$row['link_tb']."&account_no=".$row['account_no']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;\">Statement</a>&nbsp;||&nbsp;<a href=\"operation_page.php?menu=".$row['account_type']."&id=".$row['link_tb']."&account_no=".$row['account_no']."&op=d\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=600,height=300'); return false;\">Deposit</a>&nbsp;||&nbsp;<a href=\"operation_page.php?menu=".$row['account_type']."&id=".$row['link_tb']."&account_no=".$row['account_no']."&op=w\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=820,height=300'); return false;\">Withdrawal</a>&nbsp;||&nbsp;<a href=\"transfer.php?menu=".$row['account_type']."&id=".$row['link_tb']."&account_no=".$row['account_no']."&op=w\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=600,height=300'); return false;\">Transfer</a>";
		}
//---------------------------------LOAN---------------------------------------------------------
		else{
			//$balance=(float)ccb_deposits_current_balance($row['account_no']);
		        $balance=total_loan_current_balance($row['account_no'],$action_date);
       			if($balance<0){
			$balance=abs($balance);
			echo "<td bgcolor=$color align=\"RIGHT\"><B>".amount2Rs($balance)." Dr.";
			}
			else{
			echo "<td bgcolor=$color align=\"RIGHT\"><B>".amount2Rs($balance)." Cr.";
			}
echo "<td bgcolor=$color align=\"\">";
		
if(!isopening($row['account_no'])){
		echo "<a href=\"loan_opening.php?menu=".$row['account_sub_type']."&op=1&id=".$row['link_tb']."&account_no=".$row['account_no']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=200,left=140, width=900,height=500'); return false;\"><b>Opening</a> ||&nbsp;";
}
echo "<a href=\"loan_issue.php?menu=".$row['account_sub_type']."&op=1&id=".$row['link_tb']."&account_no=".$row['account_no']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=720,height=380'); return false;\">Issue</a>&nbsp;||&nbsp;<a href=\"loan_statement.php?menu=".$row['account_sub_type']."&op=1&id=".$row['link_tb']."&account_no=".$row['account_no']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1200,height=580'); return false;\">Statement</a>&nbsp;||&nbsp;<a href=\"loan_repayment.php?menu=".$row['account_sub_type']."&op=&id=".$row['link_tb']."&account_no=".$row['account_no']."\">Repay</a>&nbsp;";
		}
		
	}
}
//---------------------------------------------------------------------------------------------
?>
<script language="JavaScript" type="text/javascript">
 //var frmvalidator  = new Validator("form1");
  //frmvalidator.addValidation("type_of","req","Please enter your First Holder Name");
  //frmvalidator.addValidation("name1","maxlen=40","Max length for FirstName is 20");
  //frmvalidator.addValidation("name1","alpha_s","Only Alphabetic Characters and Space Allow For First Holder");
</script>
