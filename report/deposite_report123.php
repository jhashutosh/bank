<?
include "../config/config.php";
$staff_id=verifyAutho();
$fy=$_SESSION['fy'];
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
echo "<title>Deposite Report";
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
echo "<body bgcolor=\"#4C787E\">";
echo "<font size=+3>$SYSTEM_TITLE</font> <br><font size=+1><b>Report Date:".date('d.m.Y')."::".getPrintTime()."</b></font><hr>";
echo "<form name=\"f1\" width=\"center\" action=\"loan_report.php\" method=\"POST\" onsubmit=\"return check();\">";
echo "<table align=center bgcolor=\"#90EE90\"><tr><td  align=\"\"><b>Date (DD/MM/YYYY) :<td><input type=TEXT size=10 maxlength=\"10\" name=\"start_date\" id=\"start_date\" value=\"$start_date\"  maxlength=\"10\" onFocus=\"javascript:vDateType='1'\" onKeyUp=\"DateFormat(this,this.value,event,false,'3')\" onBlur=\"DateFormat(this,this.value,event,true,'3')\" $HIGHLIGHT>&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.start_date,'dd/mm/yyyy','Choose Date')\">";
echo "<input type=\"HIDDEN\" name=\"f_start_dt\" id=\"f_start_dt\" value=\"$f_start_dt\">";
echo "<input type=\"HIDDEN\" name=\"f_end_dt\" id=\"f_end_dt\" value=\"$f_end_dt\">";
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> ";
echo "</table></form>";
echo "<hr>";




echo "<table bgcolor=\"#667C26\" width=\"100%\" align=\"CENTER\">";
echo "<tr><th colspan=\"10\" bgcolor=green><font color=white size=5> CURRENT BALANCE IN A PARTICULAR DAY </th>";
echo "<tr>";

$color="#CCCCC5555";
echo "<th rowspan=\"2\" bgcolor=\"$color\">types of deposit</th>";
echo "<th colspan=\"2\" bgcolor=\"$color\">BALANCE 1st APRIL</th>";
echo "<th colspan=\"4\" bgcolor=\"$color\">TO DAY BALANCE</th>";
echo "<th ROWspan=\"2\" bgcolor=\"$color\">INTEREST PAID</th>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">AMOUNT WITHDRAWL</th>";
echo "<th rowspan=\"2\" bgcolor=\"$color\">DEPOSITE</th>";

echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\">NO OF ACCOUNT</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">AMOUNT</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\" width=9%>NO OF ACCOUNT</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\" width=11%>AMOUNT</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">INTEREST PAYBLE</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">TOTAL</th>";
//=========================================previous share============================================================


echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"green\">SHARE</th>";

echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$sh_ac</td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$sh_val</td>";



//==============================================current share===============================================

echo "<td colspan=\"1\" bgcolor=\"$color\" align=right></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right></td>";


//=====================================================share int=====================================================


echo "<td colspan=\"1\" bgcolor=\"$color\" align=right></td>";

//=====================================total share=========================================================

echo "<td colspan=\"1\" bgcolor=\"$color\" align=right></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
//=======================================savings previous===================================================


echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\">SAVINGS</th>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right></td>";




echo "<td colspan=\"1\" bgcolor=\"$color\" align=right></td>";


//================================================savings current========================================

echo "<td colspan=\"1\" bgcolor=\"$color\" align=right></td>";





echo "<td colspan=\"1\" bgcolor=\"$color\" align=right></td>";





//=======================================saving intrest===================================================================

// ==========================total savings======================================================================


echo "<td colspan=\"1\" bgcolor=\"$color\" align=\"right\" width=10%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=9%></td>";

echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";

//==============================================FD previous=====================================================


echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\">FD</th>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right></td>";

echo "<td colspan=\"1\" bgcolor=\"$color\" align=right></td>";



//=============================================fd current===========================================================

echo "<td colspan=\"1\" bgcolor=\"$color\" align=right></td>";

echo "<td colspan=\"1\" bgcolor=\"$color\" align=right></td>";

echo "<td colspan=\"1\" bgcolor=\"$color\" align=\"right\" width=10%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=9%></td>";



//======================================fd interest===============================================================

echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
//==================================================RD previous====================================================

echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\">RD</th>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right></td>";


echo "<td colspan=\"1\" bgcolor=\"$color\" align=right></td>";

//==========================================================rd current==================================



echo "<td colspan=\"1\" bgcolor=\"$color\" align=right></td>";


echo "<td colspan=\"1\" bgcolor=\"$color\" align=right></td>";




/*
//===============================================RD interest=============================================
$sql_statement="SELECT sum(interest) AS rd_int from deposit_vw WHERE type='rd'";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){






$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);

$rd_int=0;
$rd_int=$rd_int+$row['rd_int'];

echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$rd_int.00</td>";
//echo "<td colspan=\"1\" bgcolor=\"$color\">".$row['rd_int']."</td>";
}
}
//==============================================rd total=========================================
$rd_total=$rd_val+$rd_int;
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$rd_total.00</td>";
*/

echo "<td colspan=\"1\" bgcolor=\"$color\" align=\"right\" width=10%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=9%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
//=====================================RI Previous=======================================================

echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\">RI</th>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right></td>";


echo "<td colspan=\"1\" bgcolor=\"$color\" align=right></td>";


//==============================================ri current==================================

echo "<td colspan=\"1\" bgcolor=\"$color\" align=right></td>";

echo "<td colspan=\"1\" bgcolor=\"$color\" align=right></td>";


echo "<td colspan=\"1\" bgcolor=\"$color\" align=\"right\" width=10%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=9%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
//===========================================MIS PREVIOUS=============================================

echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\">MIS</th>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right></td>";


echo "<td colspan=\"1\" bgcolor=\"$color\" align=right></td>";

//============================================mis current===========================================

echo "<td colspan=\"1\" bgcolor=\"$color\" align=right></td>";



echo "<td colspan=\"1\" bgcolor=\"$color\" align=right></td>";


echo "<td colspan=\"1\" bgcolor=\"$color\" align=\"right\" width=10%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=9%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";


echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\">TOTAL</th>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right></td>";

echo "<td colspan=\"1\" bgcolor=\"$color\" align=right></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "</table>";







echo "</body>";
echo "</html>";


?>
