<?
include "../config/config.php";
$staff_id=verifyAutho();
$time=date('d/m/Y H:i:s ');
$op=$_REQUEST['op'];
$customer_id=$_REQUEST['id'];
$menu=$_REQUEST['menu'];
$type=trim($_REQUEST['type']);
$name=$_REQUEST['op_name'];
$op_dt=$_REQUEST['op_dt'];
$op_add=$_REQUEST['address'];
echo "<HTML>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<BODY bgcolor=\"silver\" onload=\"f1.op_name.focus();\">";
echo"<center>";
echo"<font color=\"GREEN\"><H1>Operator Master </H1></font></center>";
echo"<hr>";
echo "<table width=\"95%\" bgcolor=\"#F5F5DC\" align=\"CENTER\">";
echo "<tr><th colspan=\"5\" bgcolor=green><b><font color=White><blink>New </blink> operator details entry form</font></b></th>";
echo "<form name=\"f1\" method=\"POST\" action=\"operator_master_ef.php?menu=$menu&op=i\">";
echo "<tr><td align=\"left\"><font color=red size=\"2\">*</font>Operator name:<input type=\"TEXT\" name=\"op_name\" size=25 value=\"\" $HIGHLIGHT>";
echo "<td align=\"left\"><font color=red size=\"2\">*</font>Joining date:<input type=\"TEXT\" name=\"op_dt\" id=\"op_dt\" size=\"10\" value=\"".date('d/m/Y')."\" $HIGHLIGHT>";
echo "<input type=\"button\" name=\"date1\" value=\"...\" onclick=\"showCalendar(f1.op_dt,'dd/mm/yyyy','Choose Date')\">";
echo "<tr><td align=\"left\"><font color=red size=\"2\">*</font>Operator address + Ph No.:<input type=\"TEXT\" name=\"address\" size=40 value=\"\" $HIGHLIGHT>";
echo "<tr><td><td align=RIGHT colspan=3><input type=submit value=Submit>&nbsp;";
echo "<input type=\"RESET\" name=\"RESET_BUTTON\" value=\"Reset\"><br>";
echo "<tr><td><label align=\"right\"><font color=red size=\"2\">'*' marked filleds are mandetory.</font></label>";
//echo "<input type=Button value=Return onClick=\"Location.href='customer_statement.php?id=$customer_id'\"> ";
echo "</form>";
echo "</table>";
if($op=='i')
	{
		$sql_statement="select LC_Operator_Master_Vld_Fnc('$name') as vld";
		$result=dBConnect($sql_statement);
		$row=pg_NumRows($result);
		//echo $sql_statement;
		if(pg_NumRows($result)>0)
			{
			/*for($k=0; $k<pg_NumRows($result); $k++)
				{
				$srow=pg_fetch_array($result,$k);
				$return=$srow['vldoperatormaster'];
				//echo "<td align=\"right\" bgcolor=$color>g".($srow['vldoperatormaster'])."</td>";
				}*/
				$return=pg_result($result,'vld');
			}
		if($return==1)
			{
			$sql_statement="SELECT LC_Operator_Master_Save_Fnc('$name','$op_add','$op_dt','$staff_id','$time') as integer";
			$result=dBConnect($sql_statement);
			$row=pg_NumRows($result);
			//echo $sql_statement;
			if(pg_NumRows($result)>0)
				{
				echo "<h4><font color=GREEN>Data inserted successfully.</font></h4>";
				//header("Location:../mini/mini_operator_relation.php?menu=min");
				}
			else
				{
				echo "<h4><font color=RED><blink> Entry failour</blink></font></h4>";
				}
			//echo "<h4><font color=GREEN>Data Inserted Successfully.</font></h4>";
			}
		else
			{
			echo "<h4><font color=RED><blink>Duplicate entry.</blink></font></h4>";
			}

	}

echo"<hr>";
$sql_statement="SELECT * from lc_operator_master";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<center>";
echo "<h4><font size=5 color=green><blink>Please enter operator details!!!</blink></font></h4>";
echo "</center>";
} 
else 
{
echo "<table width=\"100%\">";
//echo "<tr><td bgcolor=\"green\" colspan=\"9\" align=\"center\"><font color=\"white\"><b>OPERATOR LIST</b></font>";
// Place line comments if you do not need column header.
$color='green';
echo "<tr>";
echo "<th bgcolor=$color>Operator name</th>";
echo "<th bgcolor=$color colspan=\"1\">Operator address + Ph No.</th>";
echo "<th bgcolor=$color colspan=\"1\">Join date</th>";
//echo "<th bgcolor=$color colspan=\"1\">Close?</th>";
$color=$TCOLOR;
for($j=0; $j<pg_NumRows($result); $j++) 
{
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	echo "<tr>";
	//echo "<td bgcolor=$color><a href=\"../customer_statement.php?menu=$menu&id=".$row['customer_id']."\" target=\"_blank\">".$row['customer_id']."</a></td>";id | operator_name | address | join_date  
	echo "<td bgcolor=$color align=\"middle\">".ucwords($row['operator_name'])."</td>";
	echo "<td bgcolor=$color align=\"middle\">".ucwords($row['address'])."</td>";
	echo "<td bgcolor=$color align=\"middle\">".ucwords($row['join_date'])."</td>";
	//echo "<td align=center bgcolor=$color><a href=\"../mini_ac_open_ef.php?menu=$menu&op=c&id=$id&account_no=$account_no\" target=\"parent\">Show</td>";
}
echo "<tr>";
$color="cyan";
//echo "<td align=center bgcolor=$color colspan=\"9\"><b>Total:  $j Account  !!!!!!</b></td>";
echo "</table>";
}
?>
 <script language="JavaScript" type="text/javascript">
 var frmvalidator  = new Validator("f1");
 frmvalidator.addValidation("op_name","req","Please enter operator name");
 frmvalidator.addValidation("op_dt","req","Joining date should not blank");
 frmvalidator.addValidation("address","req","Operator address should not blank");
  //frmvalidator.addValidation("rateeff","maxlen=4","Max Lenght is 4 only");
  //frmvalidator.addValidation("rateeff","numeric","Enter Number Only For Rate Field");

</script>
<?
echo "</body>";
echo "</HTML>";
?>
