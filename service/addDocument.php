<?php
include "../config/config.php";
$staff_id=verifyAutho();
$ser_doc_type_array=array(
		"ser"=>"Service"
		);
$menu=$_REQUEST['menu'];
$account_no=$_SESSION["current_account_no"];
$loan_sl_no=$_REQUEST["loan_sl_no"];
$load_status=$_REQUEST['ls'];
$entry_date=$_REQUEST['l_date'];
//echo "<h1>$entry_date</h1>";
if($load_status=='o'){$URL='service_loan_issue_ef.php?menu=ser&action_date='.$entry_date;}
else{$URL='service_loan_issue_ef.php?menu=ser&action_date='.$entry_date;}
echo "<html>";
echo "<head>";
echo "<title>Security Deposit for KVP Loan[$account_no]</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script src=\"../JS/max_limit.js\"></script>";

echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";

?>
<script language="JAVASCRIPT">
function closeme() { 
	close(); 
}
function myRefresh(URL){
	//alert(URL)
	window.opener.location.href =URL;
    	self.close();
    	}

function checkSelect(str){
	//alert(str);
	document.orderform.ac.value='';
	if(str=='fd'||str=='rd'||str=='ri'||str=='mis'||str=='oth'||str=='ser'){
	if(str=='oth'){	
		document.orderform.s1.disabled=true;
		}
	else{
		document.orderform.s1.disabled=false;
	}
	document.orderform.ac.disabled=false;
	document.orderform.cn.disabled=false;
	document.orderform.mdate.disabled=false;
	document.orderform.amt.disabled=false;
	document.orderform.sbm.disabled=false;
	document.orderform.ac.focus();
	}
	else{
	if(str!='Select'){
	document.orderform.sbm.disabled=false;
       	document.orderform.s1.disabled=true;
	document.orderform.ac.disabled=true;
	document.orderform.cn.disabled=false;
	document.orderform.mdate.disabled=false;
	document.orderform.amt.disabled=false;
       	document.orderform.cn.focus();
	}
	else{
	document.orderform.sbm.disabled=true;
	document.orderform.cn.disabled=true;
	document.orderform.mdate.disabled=true;
	document.orderform.amt.disabled=true;
	document.orderform.s1.disabled=true;
	document.orderform.ac.disabled=true;
	document.orderform.p_type.focus();
	}
	}
    }
function openChild(){
	var str=document.getElementById('ac').value;
	var mnu=document.getElementById('p_type').value;
	if(str.length == 0){
		alert("Account No Should not be null!!!");
		document.orderform.ac.focus();	
		return false;
	}
  	else{
		URL="../main/pop_up_account.php?menu="+mnu+"&account_no="+str;
	window.open(URL,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no, scrollbars=yes,top=100,left=150,width=950,height=450');
return false;
 }
}

</script>
<?php
echo "</head>";
echo "<body bgcolor=\"#FDF5E6\">";
//===================================INSERT===============================================
if($_REQUEST['op']=='i'){
$p_type=$_REQUEST['p_type'];
$reg_no=$_REQUEST['reg_no'];
$ast_dsc=$_REQUEST['ast_dsc'];
$amount=$_REQUEST['amount'];
  if(empty($loan_sl_no)){$loan_sl_no=nextValue('loan_sl_no');}
  $sql_statement="INSERT INTO loan_security (loan_serial_no,account_no,security_type, security_id,security_info,security_value,entry_date) VALUES ('$loan_sl_no','$account_no','$p_type','$reg_no','$ast_dsc',$amount,'$entry_date')";
//echo $sql_statement;
  $result=dBConnect($sql_statement);
  if(pg_affected_rows($result)<1){
		echo "<font size=+2 color=red>Failed to insert data into database.<br>please contact to System administator &nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"></font>";
	}
}
//=====================================INSERTED VALUE====================================
$sql_statement="SELECT * FROM loan_security where account_no='$account_no' AND entry_date='$entry_date'";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0) {
$color=$TCOLOR;
echo "<table valign=\"top\" width=\"100%\" align=\"CENTER\">";
echo "<tr bgcolor=Green>";
echo "<th colspan=\"4\">Details Information of [$account_no] &nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Return\" onClick=\"myRefresh('".$URL."')\"></th>";
echo "<tr bgcolor=\"PINK\">";
echo "<th>Security Type</th>";
echo "<th>Security Description</th>";
echo "<th>Registration No.</th>";
//echo "<th>Maturity Date</th>";
echo "<th>Asset Value</th>";
for($j=0; $j<pg_NumRows($result); $j++){
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
echo "<tr>";
echo "<td  bgcolor=$color>".$ser_doc_type_array[trim($row['security_type'])]."</td>";
echo "<td  bgcolor=$color>".$row['security_info']."</td>";
echo "<td  bgcolor=$color>".$row['security_id']."</td>";
//echo "<td bgcolor=$color>".$row['max_date']."</td>";
echo "<td bgcolor=$color align=\"right\">".(float)$row['security_value']."</td>";
$t_val+=$row['security_value'];
	}
echo "<tr bgcolor=AQUA>";
echo "<th colspan=3>Total : $j Infomation Found!!!!!!";
echo "<td align=right><b> Rs. $t_val /=";
echo "</table>";

}
//=======================================FORM =============================================
echo "<form name=\"orderform\" action=\"addDocument.php?menu=$menu&op=i&ls=$load_status&l_date=$entry_date\" method=\"POST\"  onSubmit=\"return varify();\">";
echo "<table align=center bgcolor=\"#8FBC8F\" width=50%>";
echo "<tr><td><b>Document Type:<td>";
SelectPledgeDocument($ser_doc_type_array,$name='p_type');
//echo "<tr><td><b>Account No:<td><INPUT NAME=\"ac_no\" id=\"ac\" TYPE=\"TEXT\" VALUE=\"\" size=\"10\" $HIGHLIGHT disabled >";
//echo "&nbsp;<INPUT TYPE=\"button\" name=\"s1\" VALUE=\"Search\" disabled onClick=\"openChild();\">";
echo "<tr><td><b>Service Type :<td><INPUT NAME=\"ast_dsc\" TYPE=\"TEXT\" id=\"ast_dsc\" VALUE=\"\" size=\"13\" $HIGHLIGHT >";
echo "<tr><td><b>Service Bond No :<td><INPUT NAME=\"reg_no\" id=\"reg_no\" TYPE=\"TEXT\" VALUE=\"\" size=\"13\" $HIGHLIGHT >";
echo "<tr><td><B>Gross Pay :<td>Rs.&nbsp<INPUT NAME=\"amount\" TYPE=\"TEXT\" id=\"amt\"  VALUE=\"\" size=\"10\" $HIGHLIGHT >";
echo "<tr><td><td><INPUT NAME=\"sbm\" TYPE=\"SUBMIT\" VALUE=\"Enter\" $HIGHLIGHT >";
//echo "&nbsp;<input type=\"BUTTON\" name=\"CL_BUTTON\" value=\"Return\" onclick=\"myRefresh('".$URL."')\" $HIGHLIGHT disabled>";
echo "<input type=\"HIDDEN\" name=\"loan_sl_no\" value=\"$loan_sl_no\">";
echo "</table>";
echo "</form>";



?>
<script language="JavaScript" type="text/javascript">
var frmvalidator  = new Validator("orderform");
--frmvalidator.addValidation("account_no","req","Please enter Account No.");
frmvalidator.addValidation("mat_date","req","Please enter Maturity Date.");
frmvalidator.addValidation("cer_no","req","Please enter Certificate No.");
frmvalidator.addValidation("amount","req","Please enter Maturity Value.");
frmvalidator.addValidation("amount","dec","Please enter Numeric Value.");
</script>