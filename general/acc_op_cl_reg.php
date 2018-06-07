<?php
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
echo "<title>ACCOUNTS OPENED AND CLOSED REGISTER";
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
<?php
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<font size=+3>$SYSTEM_TITLE</font> <br><font size=+1><b>Report Date:".date('d.m.Y')."::".getPrintTime()."</b></font><hr>";
//--------------------------------------------form area for printing statement --------------------------------------------
/*echo "<form name=\"f1\" action=\"growth_in_share.php\" method=\"POST\" onsubmit=\"return check();\">";
echo "<table align=center bgcolor=\"#90EE90\"><tr><td  align=\"\"><b>Date On (DD/MM/YYYY) :<td><input type=TEXT size=10 maxlength=\"10\" name=\"start_date\" id=\"start_date\" value=\"$start_date\"  maxlength=\"10\" onFocus=\"javascript:vDateType='1'\" onKeyUp=\"DateFormat(this,this.value,event,false,'3')\" onBlur=\"DateFormat(this,this.value,event,true,'3')\" $HIGHLIGHT>&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.start_date,'dd/mm/yyyy','Choose Date')\">";
echo "<input type=\"HIDDEN\" name=\"f_start_dt\" id=\"f_start_dt\" value=\"$f_start_dt\">";
echo "<input type=\"HIDDEN\" name=\"f_end_dt\" id=\"f_end_dt\" value=\"$f_end_dt\">";
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> ";
echo "</table></form>";*/
//--------------------------------------------printinting R-----------------------------------------------------------------------------

/*
echo "<table>";
$sql_statement="select count(customer_id) as count from customer_account where status in('op','m','cl')
group by status
order by status desc";
//echo $sql_statement; exit;
$result=dBConnect($sql_statement);
//echo $result; exit;
for ($i=1;$i<pg_NumRows($result);$i++)
{
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($i));
$i="LKJDFHGKJHSDGJKH";
echo "<tr>";
echo "<td>NO. of active :</td>";
echo "<td>".($row['count'])." </td>";
echo "</tr>";
}
echo "<tr>";
echo "<td>NO. of active :</td>";
echo "<td>".($row['count'])."</td>";
echo "</tr>";
echo "<tr>";
echo "<td>NO. of active :</td>";
echo "<td>".($row['count'])."</td>";
echo "</tr>";
echo "</table>";
*/

////////////////////////////
echo "<table bgcolor=\"#667C26\" width=\"100%\" align=\"left\">";
echo "<tr><th colspan=\"10\" bgcolor=green><font color=white size=5>ACCOUNTS OPENED AND CLOSED REGISTER</th>";
echo "</tr>";
$color="#CCCCC5555";
echo "<tr>";
echo "<th rowspan=\"2\" bgcolor=\"$color\"width=\"7%\">S.NO</th>";
echo "<th rowspan=\"2\" bgcolor=\"$color\"width=\"19%\">Acount Number</th>";
echo "<th rowspan=\"2\" bgcolor=\"$color\"width=\"30%\">Name of the account Holder</th>";
echo "<th colspan=\"2\" bgcolor=\"$color\">Date of</th>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">Remarks</th>";
echo "</tr>";
echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\" width=\"12%\"> Opening </th>";
echo "<th colspan=\"1\" bgcolor=\"$color\" width=\"18%\">Closing/Transfer</th>";
echo "</tr>";

//////////////////////////////////// frame area////////////////////////////////////////
echo "<tr><td colspan=\"10\" align=\"left\"><iframe src=\"frame.php\" width=\"100%\" height=\"250\"></iframe></td></tr>";


//------------------------------------- display code below----------------------------------------
/*
$sql_statement="
select b.account_no,a.name1,b.opening_date,b.closing_date,b.status from customer_master a,customer_account b where a.customer_id=b.customer_id and b.status='cl'
order by b.status desc
";
////////////////////////

//////////////////
//echo $sql_statement1; exit;
$result=dBConnect($sql_statement);


//echo $result; exit;
for ($i=1;$i<pg_NumRows($result);$i++)
{
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($i));

echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\">$i</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".($row['account_no'])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".($row['name1'])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".($row['opening_date'])."</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".($row['closing_date'])." </th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">".($row['status'])."</th>";
echo "</tr>";
}*/
//-----------------------------------------------------------------------------------------------------------
$sql_statement="
select b.account_no,a.name1,b.opening_date,b.closing_date,b.status from customer_master a,customer_account b where a.customer_id=b.customer_id and b.status='cl'
order by b.status desc
";
$result=dBConnect($sql_statement);
$i=pg_NumRows($result);
echo "<tr>";
echo "<th colspan=\"4\" bgcolor=\"$color\" ><font color=green size=4>Total no of accounts ::</font> </th>";

echo "<th colspan=\"3\" bgcolor=\"$color\" align=left><font color=green>$i</font></th>";
//echo "<th colspan=\"1\" bgcolor=\"$color\"></th>";
//echo "<th colspan=\"1\" bgcolor=\"$color\"></th>";
echo "</tr>";
echo "</table>";
echo "</body>";
echo "</html>";
?>
