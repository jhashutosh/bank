<?
include "../config/config.php";
$staff_id=verifyAutho();
$time=date('d/m/Y H:i:s ');
//$sysdate=date("Y",time())."-".date("m",time())."-".date("d",time());
$menu=$_REQUEST['menu'];
$op=$_REQUEST['op'];


//$t_id=getTranId();
/*$sql_statement="INSERT INTO gl_ledger_hrd(tran_id,type,action_date,fy,operator_code,entry_time) VALUES ('$t_id','op','$action_date','$fy','$staff_id',CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";

$sql_statement.=";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,dr_cr,qty,amount,particulars) VALUES('$t_id','$code','$dr_cr',0,$amount,'op')";*/
//echo $sql_statement;

/*$sql_statement="SELECT setminioperatordetails('$mini_name','$operator_name','$op_dt') as integer";
echo $sql_statement;

$result=dBConnect($sql_statement);
if(pg_affected_rows($result)<1) {
   echo "<h1><blink>sorry database not updated due to some reason!!!!!!!!!!!!!!!!!!</h1>";
     }
else{$flag=1;
}*/
// }
echo "<html>";
echo "<head>";
echo "<title>Entry Permission";
echo "</title>";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo"<h1 align=\"center\"> <font color=green>Mini Operator Relation</font></h1>";
echo"<hr>";
//==================================================================
if($op=='i'){
$op_dt=$_REQUEST['op_dt'];

$operator_name=$_REQUEST['operator_name'];
$mini_name=$_REQUEST['mini_name'];
//echo $operator_name;
//$fy=getFy();
$sql_statement ="SELECT setminioperatordetails('$mini_name','$operator_name','$op_dt','$staff_id','$time')";
echo $sql_statement;

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0)
 	 {
  	echo "<h2><font color=\"green\">Data successfully inserted.</font></h2>";
 	 }
else
	{
	echo "<h4><font color=RED>Failed to insert data..</font></h4>";
//<br>Please Write drown Tranection Id is :<b>$t_id</b></font></h2>";
	}
}
echo "<table width=\"65%\" bgcolor=\"#F5F5DC\" align=\"CENTER\">";
echo "<tr><th colspan=\"4\" bgcolor=green><b><font color=White> Mini Operator Relation</font></b></th>";
echo "<form name=\"f1\" method=\"POST\" action=\"mini_operator_relation.php?menu=min&op=i\"/>";
//echo "<tr><td>Customer Id::<td><input type=\"TEXT\" name=\"cust_id\" size=\"25\" disabled value=\"$customer_id\" readonly>";
//echo "<tr><td>Mini:<select><option>MINI</option></select>";
echo "<tr><td align=\"left\"><font color=red size=\"2\">*</font>Operator:";
makeSelectSubmit4mdbmini_operator('id','operator_name','operator_master','id_operator_master','operator_name');
echo "<td align=\"left\"><font color=red size=\"2\">*</font>Mini:";
makeSelectSubmit4mdbmini_operator('id','mini_name','mini_master','id_mini_master','mini_name');
echo "<tr><td align=\"right\"><font color=red size=\"2\">*</font>Link Date:<input type=\"TEXT\" name=\"op_dt\" id=\"op_dt\" size=\"10\" value=\"".date('d/m/Y')."\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"date1\" value=\"...\" onclick=\"showCalendar(f1.op_dt,'dd/mm/yyyy','Choose Date')\">";
echo "<td align=RIGHT colspan=1><input type=\"submit\" value=Submit>&nbsp;";
//$sql_statement="INSERT INTO mini_operator_details(mini_name, operator_name, op_dt) VALUES('$operator_name','$mini_name','$op_dt')";
//$sql_statement.="SELECT setminioperatordetails('$mini_name','$operator_name','$op_dt') as integer";
echo "<tr><td><label align=\"right\"><font color=red size=\"2\">'*' marked filleds are mandetory.</font></label>";
echo "</form>";
echo "</table>";

echo"<HR>";
$sql_statement="SELECT a.id id,a.operator_name opnm,b.mini_name mnnm,c.link_date ldt,c.end_date edt from operator_master a,mini_master b,mini_operator_details c where a.id=c.id_operator_master and b.id=c.id_mini_master order by a.id,b.mini_name";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<center>";
echo "<h4><font size=5 color=green><blink>Please enter mini operator relation !!!</blink></font></h4>";
echo "</center>";
} 
else 
{
echo "<table width=\"100%\">";
echo "<tr><td bgcolor=\"green\" colspan=\"9\" align=\"center\"><font color=\"white\"><b>MINI LIST</b></font>";
// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color>Operator</th>";
echo "<th bgcolor=$color colspan=\"1\">Mini</th>";
echo "<th bgcolor=$color colspan=\"1\">Link date</th>";
echo "<th bgcolor=$color colspan=\"1\">Salary Due</th>";

//echo "<th bgcolor=$color colspan=\"1\">Close?</th>";

for($j=0; $j<pg_NumRows($result); $j++) 
{
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	echo "<tr>";
	//echo "<td bgcolor=$color><a href=\"../customer_statement.php?menu=$menu&id=".$row['customer_id']."\" target=\"_blank\">".$row['customer_id']."</a></td>";
	echo "<td bgcolor=$color align=\"middle\">".ucwords($row['opnm'])."</td>";
	echo "<td bgcolor=$color align=\"middle\">".ucwords($row['mnnm'])."</td>";
	echo "<td bgcolor=$color align=\"middle\">".ucwords($row['ldt'])."</td>";

	//echo "<td bgcolor=$color>".ucwords($row['edt'])."</td>";
	echo "<td align=center bgcolor=$color><a href=\"../mini/operator_salary_payment.php?menu=$menu&op=c&operator_id=".($row['id'])."\" >Salary Due</td>";
}
echo "<tr>";
$color="cyan";
//echo "<td align=center bgcolor=$color colspan=\"9\"><b>Total:  $j Account  !!!!!!</b></td>";
echo "</table>";
}

//==============================================================
?>
 <script language="JavaScript" type="text/javascript">
 var frmvalidator  = new Validator("f1");
 //frmvalidator.addValidation("op_name","req","Please enter Name");
 frmvalidator.addValidation("op_dt","req","Joining date should not Blank");
 //frmvalidator.addValidation("address","req","Address should not Blank");
  //frmvalidator.addValidation("rateeff","maxlen=4","Max Lenght is 4 only");
  //frmvalidator.addValidation("rateeff","numeric","Enter Number Only For Rate Field");

</script>
<?

echo "</body>";
echo "</HTML>";
?>
