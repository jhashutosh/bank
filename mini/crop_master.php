<?
include "../config/config.php";
$staff_id=verifyAutho();
$time=date('d/m/Y H:i:s ');
$op=$_REQUEST['op'];
$customer_id=$_REQUEST['id'];
$menu=$_REQUEST['menu'];
$type=trim($_REQUEST['type']);
//$name=$_REQUEST['op_name'];
$op_dt=$_REQUEST['op_dt'];
//$op_add=$_REQUEST['address'];
$crop_rt=$_REQUEST['crop_rt'];
$crop_desc=$_REQUEST['crop_desc'];
$season_name=$_REQUEST['season_name'];

echo "<HTML>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<BODY bgcolor=\"silver\" onload=\"f1.op_name.focus();\">";
echo"<center>";
echo"<font color=\"GREEN\"><H1>Crop Master </H1></font></center>";
echo"<hr>";
echo "<table width=\"95%\" bgcolor=\"#F5F5DC\" align=\"CENTER\">";
echo "<tr><th colspan=\"5\" bgcolor=green><b><font color=White><blink>New </blink> operator details entry form</font></b></th>";
echo "<form name=\"f1\" method=\"POST\" action=\"crop_master.php?menu=$menu&op=i\">";

echo "<tr><td align=\"left\"><font color=red size=\"2\">*</font>Crop:";
makeSelectSubmit4mdbmini('crop_id','crop_desc','crop_mas','crop_desc');
echo "<td align=\"left\"><font color=red size=\"2\">*</font>Session:";
makeSelectSubmit4mdbmini('id','season_name','lc_season_master','season_name');
echo "<tr><td align=\"left\"><font color=red size=\"2\">  *</font>Crop Rate :<input type=\"TEXT\" name=\"crop_rt\" size=5 value=\"\" $HIGHLIGHT>";

echo "<td align=\"left\"><font color=red size=\"2\">*</font>Joining date:<input type=\"TEXT\" name=\"op_dt\" id=\"op_dt\" size=\"10\" value=\"".date('d/m/Y')."\" $HIGHLIGHT>";
echo "<input type=\"button\" name=\"date1\" value=\"...\" onclick=\"showCalendar(f1.op_dt,'dd/mm/yyyy','Choose Date')\">";
//echo "<tr><td align=\"left\"><font color=red size=\"2\">*</font>Operator address + Ph No.:<input type=\"TEXT\" name=\"address\" size=40 value=\"\" $HIGHLIGHT>";
echo "<tr><td><td align=RIGHT colspan=3><input type=submit value=Submit>&nbsp;";
echo "<input type=\"RESET\" name=\"RESET_BUTTON\" value=\"Reset\"><br>";
echo "<tr><td><label align=\"right\"><font color=red size=\"2\">'*' marked filleds are mandetory.</font></label>";
//echo "<input type=Button value=Return onClick=\"Location.href='customer_statement.php?id=$customer_id'\"> ";
echo "</form>";
echo "</table>";
if($op=='i')
	{
	//for crop
	if ($crop_desc=='amon')
	{
	$crop_id='1';
	}
	if ($crop_desc=='rabi')
	{
	$crop_id='2';
	}
	if ($crop_desc=='boro')
	{
	$crop_id='3';
	}
	// fror season
	if ($season_name=='Kharif')
	{
	$id=1;
	}
	if ($season_name=='Rabi')
	{
	$id=2;
	}
	if ($season_name=='Boro')
	{
	$id=3;
	}
	
		$sql_statement="select LC_Crop_Rate_Master_Vld_Fnc('$crop_id','$op_dt') as vld";
		$result=dBConnect($sql_statement);
		//echo $sql_statement;
		$row=pg_NumRows($result);
		if(pg_NumRows($result)>0)
			{
			
				$return=pg_result($result,'vld');
			}
		if($return==1)
			{
			$sql_statement="select LC_Crop_Rate_Master_Save_Fnc('$crop_id','$id','$crop_rt','$op_dt','$staff_id','$time') as integer";
			$result=dBConnect($sql_statement);
			//echo $sql_statement;
			$row=pg_NumRows($result);
			if(pg_NumRows($result)>0)
				{
				echo "<h4><font color=GREEN>Data inserted successfully.</font></h4>";
				//header("Location:../mini/mini_operator_relation.php?menu=min");
				}
			else
				{
				echo "<h4><font color=RED><blink> Entry failour</blink></font></h4>";
				}
			}
		else
			{
			echo "<h4><font color=RED><blink>Duplicate entry.</blink></font></h4>";
			}

	}

echo"<hr>";
$sql_statement="SELECT crop_desc,season_name,crop_rate,with_effect_from from crop_mas a,
lc_season_master b,LC_Crop_Rate_Master c where a.crop_id=cast(c.id_crop_mas as varchar)
and b.id=c.id_season_master ";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<center>";
echo "<h4><font size=5 color=green><blink>Please enter operator details!!!</blink></font></h4>";
echo "</center>";
} 
else 
{
echo "<table width=\"100%\">";
$color='green';
echo "<tr>";
echo "<th bgcolor=$color>Crop Name</th>";
echo "<th bgcolor=$color>Season Name</th>";
echo "<th bgcolor=$color colspan=\"1\">Rate</th>";
echo "<th bgcolor=$color colspan=\"1\">Date</th>";
$color=$TCOLOR;
for($j=0; $j<pg_NumRows($result); $j++) 
{
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	echo "<tr>";
	echo "<td bgcolor=$color align=\"middle\">".ucwords($row[0])."</td>";
	echo "<td bgcolor=$color align=\"middle\">".ucwords($row[1])."</td>";
	echo "<td bgcolor=$color align=\"middle\">".ucwords($row['crop_rate'])."</td>";
	echo "<td bgcolor=$color align=\"middle\">".ucwords($row['with_effect_from'])."</td>";
	}
echo "<tr>";
$color="cyan";
echo "</table>";
}
?>
 <script language="JavaScript" type="text/javascript">
 var frmvalidator  = new Validator("f1");
 frmvalidator.addValidation("crop_desc","req","Please enter crop name");
 frmvalidator.addValidation("$season_name","req","Please enter season name");
 frmvalidator.addValidation("crop_rt","req","Please enter crop rate");
 frmvalidator.addValidation("op_dt","req","Joining date should not blank");
 
  

</script>
<?
echo "</body>";
echo "</HTML>";
?>
