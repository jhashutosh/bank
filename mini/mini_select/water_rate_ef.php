<?
include "../config/config.php";
$staff_id=verifyAutho();
$time=date('d/m/Y H:i:s ');
$op=$_REQUEST['op'];
$customer_id=$_REQUEST['id'];
$menu=$_REQUEST['menu'];
$type=trim($_REQUEST['type']);
$wat_rt_hr=$_REQUEST['wat_rt_hr'];
$opr_sal_rt=$_REQUEST['opr_sal_rt'];
$op_dt=$_REQUEST['op_dt'];
echo "<HTML>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<BODY bgcolor=\"silver\" onload=\"f1.wat_rt_hr.focus();\">";
echo "<center>";
echo "<font color=\"GREEN\"><H1>Water rate master </H1></font></center>";
echo "<hr>";
echo "<table width=\"85%\" bgcolor=\"#F5F5DC\" align=\"CENTER\">";
echo "<tr><th colspan=\"5\" bgcolor=green><b><font color=White><blink>Water</blink> rate entry form</font></b></th>";
echo "<form name=\"f1\" method=\"POST\" action=\"water_rate_ef.php?menu=$menu&op=i\">";
echo "<tr><td align=\"left\"><font color=red size=\"2\">*</font>Water rate / Hour:<input type=\"TEXT\" name=\"wat_rt_hr\" size=5 value=\"\" $HIGHLIGHT>";
echo "<td align=\"left\"><font color=red size=\"2\">  *</font>Operator salary % rate :<input type=\"TEXT\" name=\"opr_sal_rt\" size=5 value=\"\" $HIGHLIGHT>";
echo "<tr><td align=\"left\"><font color=red size=\"2\">*</font>With effect from:<input type=\"TEXT\" name=\"op_dt\" id=\"op_dt\" size=\"10\" value=\"".date('d/m/Y')."\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"date1\" value=\"...\" onclick=\"showCalendar(f1.op_dt,'dd/mm/yyyy','Choose Date')\">";
echo "<tr><td><td><input type=submit value=Submit align=\"right\">&nbsp;";
echo "<input type=\"RESET\" name=\"RESET_BUTTON\" value=\"Reset\"><br>";
echo "<tr><td><label align=\"right\"><font color=red size=\"2\">'*' marked filleds are mandetory.</font></label>";
//echo "<input type=Button value=Return onClick=\"Location.href='customer_statement.php?id=$customer_id'\"> ";
echo "</form>";
echo "</table>";
if($op=='i')
{
$sql_statement="select vldminiratedetails('$op_dt')";
		$result=dBConnect($sql_statement);
		$row=pg_NumRows($result);
		if(pg_NumRows($result)>0)
			{
			for($k=0; $k<pg_NumRows($result); $k++)
				{
				$srow=pg_fetch_array($result,$k);
				$return=$srow['vldminiratedetails'];
				//echo "<td align=\"right\" bgcolor=$color>g".($srow['vldoperatormaster'])."</td>";
				}
			}
		if($return!=0)
			{
			$sql_statement="SELECT setminiratedetails('$wat_rt_hr','$opr_sal_rt','$op_dt','$staff_id','$time') as integer";		
			$result=dBConnect($sql_statement);
			$row=pg_NumRows($result);
			if(pg_NumRows($result)>0)
				{
				echo "<h4><font color=GREEN>Data inserted successfully.</font></h4>";
				}
			else
				{
				echo "<h4><font color=RED><blink> Entry failour</blink></font></h4>";
				}
			}
		else
			{
			echo "<h4><font color=RED><blink>Duplicate entry / with effect from can not be less than existing with effect from date</blink></font></h4>";
			}

}
echo "<hr>";
$sql_statement="select * from mini_rate_details order by with_effect_from";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<center>";
echo "<h4><font size=5 color=green><blink>Please enter water rate !!!</blink></font></h4>";
echo "</center>";
} 
else 
{
echo "<table width=\"100%\">";
echo "<tr><td bgcolor=\"green\" colspan=\"9\" align=\"center\"><font color=\"white\"><b>Water rate list</b></font>";
// Place line comments if you do not need column header.
$color="green";
echo "<tr>";
echo "<th bgcolor=$color colspan=\"1\"><font color=\"white\">Id</font></th>";
echo "<th bgcolor=$color colspan=\"1\"><font color=\"white\">Rate/hour</font></th>";
echo "<th bgcolor=$color colspan=\"1\"><font color=\"white\">Operator %</font></th>";
echo "<th bgcolor=$color colspan=\"1\"><font color=\"white\">Effect date</font></th>";
$color=$TCOLOR;

for($j=0; $j<pg_NumRows($result); $j++) 
{
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	echo "<tr>";
	//echo "<td bgcolor=$color><a href=\"../customer_statement.php?menu=$menu&id=".$row['customer_id']."\" target=\"_blank\">".$row['customer_id']."</a></td>";id | operator_name | address | join_date  
	echo "<td bgcolor=$color>".ucwords($row['id'])."</td>";
	echo "<td bgcolor=$color align=\"middle\">".ucwords($row['rate_per_hr'])."</td>";
	echo "<td bgcolor=$color align=\"middle\">".ucwords($row['operator_rate_percent'])."</td>";
	echo "<td bgcolor=$color align=\"middle\">".ucwords($row['with_effect_from'])."</td>";
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
 frmvalidator.addValidation("wat_rt_hr","req","Please enter rate");
   frmvalidator.addValidation("opr_sal_rt","req","Please enter %");
  //frmvalidator.addValidation("telephone1","req","Contact number should not Blank");
  //frmvalidator.addValidation("rateeff","maxlen=4","Max Lenght is 4 only");
  frmvalidator.addValidation("wat_rt_hr","numeric","Enter number only for rate field");
frmvalidator.addValidation("opr_sal_rt","numeric","Enter number only for % field");

</script>
<?
echo "</body>";
echo "</HTML>";
?>
