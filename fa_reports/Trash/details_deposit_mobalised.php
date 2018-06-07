<?
include "../config/config.php";
$staff_id=verifyAutho();
$fy=$_SESSION['menu'];
getDetailFy($fy,&$f_start_dt,&$f_end_dt);
$start_date=$_REQUEST["start_date"];
if(empty($start_date) ) { $start_date=$f_end_dt; }
$vdebit="0";
$vcredit="0";
$cldebit="0";
$clcredit="0";
$vdebit1="0";
$vcredit1="0";
$Lbal="0";
$Abal="0";
echo "<html>";
echo "<head>";
echo "<title>Annual Report";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "<script src=\"../JS/date_validation.js\"></script>";
//echo "<script src=\"../JS/dateValidation.js\"></script>";
?>
<SCRIPT LANGUAGE="JavaScript">
function check(){
f_s_dt=document.f1.f_start_dt.value;
f_e_dt=document.f1.f_end_dt.value;
start_dt=document.f1.start_date.value;
if(start_dt.length==0){
alert("Ending Date Should Not be Null")
	document.f1.start_date.focus();
	return false;
}
if(!IsDateLess(f_s_dt,start_dt)){
	alert("Starting Date beyond of ending date of Financial Year")
	document.f1.start_date.focus();
	return false;
}
if(!IsDateLess(start_dt,f_e_dt)){
	alert("Ending Date beyond of ending date of Financial Year")
	document.f1.start_date.focus();
	return false;
}

}
</script>
<?
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<font size=+3>$SYSTEM_TITLE</font> <br><font size=+1><b>Report Date:".date('d.m.Y')."::".getPrintTime()."</b></font><hr>";
//--------------------------------------------form area for printing statement --------------------------------------------
/*echo "<form name=\"f1\" action=\"period_annual_report.php\" method=\"POST\" onsubmit=\"return check();\">";
echo "<table align=center bgcolor=\"#90EE90\"><tr><td  align=\"\"><b>Date On (DD/MM/YYYY) :<td><input type=TEXT size=10 maxlength=\"10\" name=\"start_date\" id=\"start_date\" value=\"$start_date\"  maxlength=\"10\" onFocus=\"javascript:vDateType='1'\" onKeyUp=\"DateFormat(this,this.value,event,false,'3')\" onBlur=\"DateFormat(this,this.value,event,true,'3')\" $HIGHLIGHT>&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.start_date,'dd/mm/yyyy','Choose Date')\">";
echo "<input type=\"HIDDEN\" name=\"f_start_dt\" id=\"f_start_dt\" value=\"$f_start_dt\">";
echo "<input type=\"HIDDEN\" name=\"f_end_dt\" id=\"f_end_dt\" value=\"$f_end_dt\">";
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> ";
echo "</table></form>";*/
//--------------------------------------------printinting R-----------------------------------------------------------------------------
echo "<table bgcolor=\"#667C26\" width=\"100%\" align=\"CENTER\">";
echo "<tr><th colspan=\"14\" bgcolor=green><font color=white size=5 align=\"CENTER\"> Details of Deposits Mobilized </th>";
echo "</tr>";
$color="#CCCCC5555";
echo "<tr>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">S.NO</th>";
echo "<th colspan=\"2\" bgcolor=\"$color\">Types of deposit</th>";
echo "<th colspan=\"2\" bgcolor=\"$color\">Deposits as on 31st march of previous accounting year</th>";
echo "<th colspan=\"2\" bgcolor=\"$color\">Deposits as on the last day of the reporting month</th>";
echo "<th colspan=\"2\" bgcolor=\"$color\">Increase/Decrease during the month(YES/NO)</th>";
echo "<th colspan=\"2\" bgcolor=\"$color\">Net increase/decrease over the position of 31st marchof previous accounting year </th>";
echo "<th colspan=\"2\" bgcolor=\"$color\">prevailing rate of interest</th>";
echo "</tr>";
echo "<tr>";
echo "<th colspan=\"2\" bgcolor=\"$color\"> 1 </th>";
echo "<th colspan=\"2\" bgcolor=\"$color\"> 2 </th>";
echo "<th colspan=\"2\" bgcolor=\"$color\" width=11%> 3 </th>";
echo "<th colspan=\"2\" bgcolor=\"$color\" > 4 </th>";
echo "<th colspan=\"2\" bgcolor=\"$color\"> 5 </th>";
echo "<th colspan=\"2\" bgcolor=\"$color\"width=11%> 6 </th>";
echo "</tr>";
//------------------------------------- display code below----------------------------------------

$sql_statement="select * from gl_master where gl_mas_code='11100' or gl_mas_code='11200'";
//echo $sql_statement; exit;
$result=dBConnect($sql_statement);
//echo $result; exit;
for ($i=0;$i<pg_NumRows($result);$i++)
{
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\">$i</th>";
echo "<th colspan=\"2\" bgcolor=\"$color\"></th>";
echo "<th colspan=\"2\" bgcolor=\"$color\" width=9%> </th>";
echo "<th colspan=\"2\" bgcolor=\"$color\" width=11%> </th>";
echo "<th colspan=\"2\" bgcolor=\"$color\">  </th>";
echo "<th colspan=\"2\" bgcolor=\"$color\"> </th>";
echo "<th colspan=\"2\" bgcolor=\"$color\"> </th>";

echo "</tr>";
}
//-----------------------------------------------------------------------------------------------------------
echo "</table>";
echo "</body>";
echo "</html>";
?>
