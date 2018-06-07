<?
include "../config/config.php";
$staff_id=verifyAutho();
$mt_doc_type_array=array(
		"land"=>"Land",
		"oth"=>"Other"
		);
$menu=$_REQUEST['menu'];
$account_no=$_SESSION["current_account_no"];
$loan_sl_no=$_REQUEST["loan_sl_no"];
$load_status=$_REQUEST['ls'];
$entry_date=$_REQUEST['l_date'];
if($load_status=='o'){$URL='mt_loan_balance_ef.php?menu=mt&action_date='.$entry_date;}
else{$URL='mt_loan_issue_ef.php?menu=mt&action_date='.$entry_date;}
echo "<html>";
echo "<head>";
echo "<title>Security Deposit for pledge[$account_no]</title>";
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

function Result(str)
{
//alert(str)
if (str=='oth')
	{
		document.getElementById("oth").style.display='';
		document.getElementById("amt").value=20000;
		//document.getElementById("amt").disabled=true;
	}
	else
	{
		document.getElementById("oth").style.display='none';
		document.getElementById("amt").value='';
		//document.getElementById("amt").disabled=false;

	}
if (str=='land')
	{
		document.getElementById("land").style.display='';
	}
	else
	{
		document.getElementById("land").style.display='none';
	}
	
}
</script>
<?


echo "</head>";
echo "<body>";
//===================================INSERT===============================================
if($_REQUEST['op']=='i'){
$p_type=$_REQUEST['p_type'];
//$ac_no=$_REQUEST['ac_no'];
$reg_no=$_REQUEST['reg_no'];
$ast_dsc=$_REQUEST['ast_dsc'];
$first_gr=$_REQUEST['f_g'];
$second_gr=$_REQUEST['s_g'];
$amount=$_REQUEST['amt'];

//echo "<h1>==$p_type==$reg_no==$ast_dsc==$first_gr==$second_gr==$amount==<h1>";


if(empty($loan_sl_no)){$loan_sl_no=nextValue('loan_sl_no');}
if($p_type=='oth'){
$sql_statement="INSERT INTO loan_security (loan_serial_no,account_no,security_type,first_gra_nam,second_gra_nam,security_value,entry_date) VALUES ('$loan_sl_no','$account_no','$p_type','$first_gr','$second_gr',$amount,'$entry_date')";
}
else{

  $sql_statement="INSERT INTO loan_security (loan_serial_no,account_no,security_type, security_id,security_info,security_value,entry_date) VALUES ('$loan_sl_no','$account_no','$p_type','$reg_no','$ast_dsc',$amount,'$entry_date')";
}
//echo $sql_statement;
  $result=dBConnect($sql_statement);
  if(pg_affected_rows($result)<1){
	
	echo "<font size=+2 color=red>Failed to insert data into database.<br>please contact to System administator &nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"></font>";
	
	}
  }

//=====================================INSERTED VALUE====================================

$sql_statement="SELECT * FROM loan_security where account_no='$account_no' AND status is NULL AND entry_date='$entry_date'";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0) {
$color=$TCOLOR;
echo "<table valign=\"top\" width=\"100%\" align=\"CENTER\">";
echo "<tr bgcolor=Green>";
echo "<th colspan=\"7\">Details Information of [$account_no] &nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Return\" onclick=\"myRefresh('".$URL."')\"></th>";
echo "<tr bgcolor=\"PINK\">";
echo "<th>Security Type</th>";
echo "<th>Security Description</th>";
echo "<th>Security ID</th>";
echo "<th>First Garenter Name</th>";
echo "<th>Second Garenter Name</th>";
echo "<th>Registration No.</th>";
//echo "<th>Maturity Date</th>";
echo "<th>Asset Value</th>";
for($j=0; $j<pg_NumRows($result); $j++){
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
echo "<tr>";
echo "<td  bgcolor=$color>".$mt_doc_type_array[trim($row['security_type'])]."</td>";
echo "<td  bgcolor=$color>".$row['security_info']."</td>";
echo "<td  bgcolor=$color>".$row['security_id']."</td>";
echo "<td  bgcolor=$color>".$row['first_gra_nam']."</td>";
echo "<td  bgcolor=$color>".$row['second_gra_nam']."</td>";
//echo "<td bgcolor=$color>".$row['max_date']."</td>";
echo "<td bgcolor=$color align=\"right\">".(float)$row['security_value']."</td>";
$t_val+=$row['security_value'];
	}
echo "<tr bgcolor=AQUA>";
echo "<th colspan=6>Total : $j Infomation Found!!!!!!";
echo "<td align=right><b> Rs. $t_val /=";
echo "</table>";
}
//=======================================FORM =============================================
echo "<form name=\"orderform\" action=\"addDocument.php?menu=$menu&op=i&ls=$load_status&l_date=$entry_date\" method=\"POST\"  onSubmit=\"return varify();\">";
echo "<table align=center bgcolor=\"#8FBC8F\" width=100%>";


echo "<tr><td ><b>Document Type:</td>";
echo  "<td><select name=\"p_type\" onclick=\"Result(this.value)\">";
echo "<option>Select</option>";
echo "<option value=\"land\">Land</option>";
echo "<option value=\"oth\">Other</option>";
echo "</select></td>";

echo "<tr id='oth' style='display:none'><td><b>First Garenter Name:<td><INPUT NAME=\"f_g\" TYPE=\"TEXT\" id=\"f_g\" VALUE=\"\" size=\"20\" $HIGHLIGHT>";
echo "<td><b>Second Garenter Name:<td><INPUT NAME=\"s_g\" id=\"s_g\" TYPE=\"TEXT\" VALUE=\"\" size=\"20\" $HIGHLIGHT>";
echo "<tr id='land' style='display:none'><td><b>Asset Description:<td><INPUT NAME=\"ast_dsc\" TYPE=\"TEXT\" id=\"ast_dsc\" VALUE=\"\" size=\"15\" $HIGHLIGHT >";
echo "<td><b>Registration No.<td><INPUT NAME=\"reg_no\" id=\"reg_no\" TYPE=\"TEXT\" VALUE=\"\" size=\"15\" $HIGHLIGHT>";
echo "<tr><td><B>Asset Value:<td>Rs.&nbsp<INPUT NAME=\"amt\" TYPE=\"TEXT\" id=\"amt\"  VALUE=\"\" size=\"12\" $HIGHLIGHT >";
echo "<td><td><INPUT NAME=\"sbm\" TYPE=\"SUBMIT\" VALUE=\"Enter\" $HIGHLIGHT >";
echo "&nbsp;<input type=\"BUTTON\" id=\"rt\" name=\"CLOSE_BUTTON\" value=\"Return\" onclick=\"myRefresh('".$URL."')\" $HIGHLIGHT>";
echo "<input type=\"HIDDEN\" name=\"loan_sl_no\" value=\"$loan_sl_no\">";
echo "</table>";
echo "</form>";


?>
<script language="JavaScript" type="text/javascript">
var frmvalidator  = new Validator("orderform");
frmvalidator.addValidation("amt","req","Please Enter Asset Value.");
</script>



