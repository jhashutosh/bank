<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$op=$_REQUEST['op'];

?>
<script>
function validator1(f)
	{	//alert("ok");
		var msg='';//alert("msg");
		if(f.amount.value==null || f.amount.value=='')
		{
			msg+="Please Give Amount..\n";//return false;
		}
		if(msg==''){
			return true;
		}
		else{
			alert(msg);
			return false;
		}
	}
function numbersonly(e){
	var unicode=e.charCode? e.charCode : e.keyCode;
	//alert(unicode)
	if (unicode!=8){ 
		if (unicode<46||unicode>57||unicode==47) {
			return false;		
		}
	}
	
}

</script>
<?php
 
echo "<html>";
echo "<head>";
echo "<title>Entry Permission";
echo "</title>";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<form method=\"POST\" action=\"opening_balance.php?op=e\" name=\"f1\" onSubmit=\"return validator1(this);\">";
if($op=='e'){
$amount=$_REQUEST['amount'];
$code=$_REQUEST['code'];
$dr_cr=$_REQUEST['d_c'];
$year_month=$_REQUEST['year_month'];
$x=explode('-',$_SESSION['fy']);
$action_date="31/03/".$x[0];
$fy1=($x[0]-1);
$fy1.='-'.$x[0];
//$fy=getFy();
$t_id=getTranId();
$sql_statement="INSERT INTO gl_ledger_hrd(tran_id,type,action_date,fy,operator_code,entry_time) VALUES ('$t_id','op','$action_date','$fy1','$staff_id',CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";

$sql_statement.=";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,dr_cr,qty,amount,particulars) VALUES('$t_id','$code','$dr_cr',0,$amount,'op')";
//echo $sql_statement;
$result=dBConnect($sql_statement);
//echo $sql_statement;
}
if(is_null($result)==false)
{
if(pg_affected_rows($result)>0){
echo "<h2><font color=\"green\">Successfully Inserted data into database.
<br>Please Write drown Transaction Id is :<b>$t_id</b></font></h2>";
}
}
echo "<table bgcolor=#E6E6FA align=center width=90%>";
echo "<tr><th colspan=\"2\" bgcolor=\"green\"><font size=6 color=white>Opening Balance Entry Form </font></th></tr>";
echo "<tr><td align=\"left\">General Ledger:<td>";
makeSelectFromDBWithCode('gl_mas_code','gl_mas_desc','gl_master','code',"WHERE gl_mas_code NOT IN (SELECT gl_mas_code FROM mas_gl_tran where particulars='op') and gl_mas_code<'30000'");
echo "<tr><td align=\"left\">Account Header:<td>";
echo "<Select name=\"d_c\"><option>Dr<option>Cr</select>";
echo "<tr><td align=\"left\">Amount:<td> <input type=\"text\" name=\"amount\" id=\"amount\" size=\"7\" onblur=\"return validator1(this);\" onkeypress=\"return numbersonly(event);\" $HIGHLIGHT>";
echo "<INPUT TYPE=\"HIDDEN\" name=\"year_month\" VALUE=\"2010-3\">";
echo "<tr><td><td align=RIGHT><INPUT TYPE=\"SUBMIT\" VALUE=\"Enter\">";
echo "</table>";
echo "</form>";
echo"<HR>";
//==========================================================================================================================================

?>
