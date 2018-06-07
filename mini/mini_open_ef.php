<?
include "../config/config.php";
$staff_id=verifyAutho();
$time=date('d/m/Y H:i:s ');
$op=$_REQUEST['op'];
$mininm=ucwords($_REQUEST['mininm']);
$op_dt=$_REQUEST['op_dt'];
$menu=$_REQUEST['menu'];
$type=trim($_REQUEST['type']);
echo "<HTML>";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<BODY bgcolor=\"silver\" onload=\"f1.mininm.focus();\">";
echo"<center>";
echo"<font color=\"GREEN\"><H1>MINI MASTER </H1></font></center>";
echo"<hr>";
echo "<table border=0 table align=center width=65% bgcolor=\"#F5F5DC\">";
//echo "<tr><td bgcolor=\"red\" colspan=\"5\" align=\"center\"><font color=\"white\">Sole Holder</font>";
//echo "<table width=\"60%\" bgcolor=\"#F5F5DC\" align=\"CENTER\">";
echo "<tr><th colspan=\"3\" bgcolor=green><b><font color=White><blink>New </blink>mini name entry form</font></b></th>";
echo "<form name=\"f1\" method=\"POST\" action=\"mini_open_ef.php?menu=$menu&op=i\">";
echo "<tr><td align=\"left\"><font color=red size=\"2\">*</font>Mini name:<input type=\"TEXT\" name=\"mininm\" size=10  td align=\"left\" value=\"\">";
echo "<td align=\"left\"><font color=red size=\"2\">*</font>Installation date:<input type=\"TEXT\" name=\"op_dt\" id=\"op_dt\" size=\"10\" td align=\"left\" value=\"".date('d/m/Y')."\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"date1\" value=\"...\" onclick=\"showCalendar(f1.op_dt,'dd/mm/yyyy','Choose Date')\">";
echo "<tr><td align=\"right\" colspan=1><input type=submit value=Submit>&nbsp;";
echo "  <input type=\"RESET\" name=\"RESET_BUTTON\" size=10 value=\"Reset\"><br>";
echo "<tr><td><label align=\"right\"><font color=red size=\"2\">'*' marked filleds are mandetory.</font></label>";
//echo "<input type=Button value=Return onClick=\"Location.href='customer_statement.php?id=$customer_id'\"> ";
echo "</form>";
echo "</table>";
if($op=='i')
	{
		$sql_statement="select LC_Mini_Master_Vld_Fnc('$mininm') as vld";
		echo $sql_statement;
		$result=dBConnect($sql_statement);
		$return=pg_result($result,'vld');
		if($return==1)
			{
			$sql_statement="SELECT LC_Mini_Master_Save_Fnc('$mininm','$op_dt','$staff_id','$time')";
			$result=dBConnect($sql_statement);
			//echo $sql_statement;
			if(pg_NumRows($result)>0)
			
				echo "<h4><font color=GREEN>Data inserted successfully.</font></h4>";
			
			else
			
				echo "<h4><font color=RED><blink> Entry failure</blink></font></h4>";
			
			}
		else
			
			echo "<h4><font color=RED><blink>Duplicate entry.</blink></font></h4>";
			

	}


echo"<hr>";
$sql_statement="SELECT * from LC_Mini_Master";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<center>";
echo "<h4><font size=5 color=green><blink>Please enter mini name !!!</blink></font></h4>";
echo "</center>";
} 
else 
{
echo "<table width=\"100%\">";
//echo "<tr><td bgcolor=\"green\" colspan=\"4\" align=\"center\"><font color=\"white\"><b><blink>Existing</blink> MINI LIST</b></font>";

echo "<tr>";
echo "<th bgcolor=\"green\"><font color=\"white\">Existing mini name</font></th>";
echo "<th bgcolor=\"green\" colspan=\"1\"><font color=\"white\">Installation date</font></th>";
//echo "<th bgcolor=$color colspan=\"1\">Close?</th>";
$color=$TCOLOR;
for($j=0; $j<pg_NumRows($result); $j++) 
{
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	echo "<tr>";
	//echo "<td bgcolor=$color><a href=\"../customer_statement.php?menu=$menu&id=".$row['customer_id']."\" target=\"_blank\">".$row['customer_id']."</a></td>";
	echo "<td bgcolor=$color align=\"middle\">".ucwords($row['mini_name'])."</td>";
	echo "<td bgcolor=$color align=\"middle\">".ucwords($row['install_date'])."</td>";
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
 frmvalidator.addValidation("mininm","req","Please enter mini name");
</script>
<?
echo "</body>";
echo "</HTML>";
?>
