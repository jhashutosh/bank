<?
include "../config/config.php";
$staff_id=verifyAutho();
$entry_time=date('d/m/Y H:i:s ');
$type=$_REQUEST['type'];
getDetailFy($fy,&$f_start_dt,&$f_end_dt);
$start_date=$_REQUEST["start_date"];
if(empty($mdate)){$mdate=date('d.m.Y');}
echo "<html>";
echo "<head>";
echo "<title>Balance Sheet Parameter</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script src=\"../JS/calendar.js\"></script>";
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
//--------------------------------------------------------------------------------------
function numbersonly(e){
	var unicode=e.charCode? e.charCode : e.keyCode;
	//alert(unicode)
	if (unicode!=8){ 
		if (unicode<46||unicode>57||unicode==47) {
			return false;
		
		}
	}
}
//---------------------------------------------------------------------
function diabledEnabled(en_dt){
alert(en_dt)


}
</script>
<?


echo "</head>";
echo "<body bgcolor=\"#088A85\">";
echo"<br><br><br><br>";
echo "<form name=\"f1\" METHOD=\"POST\" ACTION=\"b_sheet.php\">";
echo "<center>";
$color='#FFC0CB';
echo "<table width=\"60%\" bgcolor=\"\"><tr>";
echo "<th colspan=\"\" bgcolor=\"Yellow\"><font size=\"+4\">Balance Sheet</font><tr>";
echo "<td valign=\"top\" width=\"50%\">";
echo "<table width=\"100%\" border=\"1\" cellspacing=\"0\" bordercolor=\"BLACK\" bordercolorlight=\"BLACK\" bordercolordark=\"BLACK\">";
echo "<tr><th bgcolor=\"green\" colspan=\"\"><font color=\"white\"><b>Current</b></font>";
echo "<th bgcolor=\"green\" colspan=\"\"><font color=\"white\"><input type=checkbox name=ck id=ck>&nbsp&nbsp&nbsp&nbsp&nbsp<b>Compare</b></font>";

echo "<tr bgcolor=$color><td>Day:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
echo "<input type=RADIO value=dt name=r1 onclick=\"diabledEnabled(en_dt);\">&nbsp&nbsp&nbsp&nbsp&nbspDate:&nbsp&nbsp&nbsp&nbsp&nbsp<input type=text Size=\"12\" name=en_dt id=\"en_dt\" DISABLED></td>";
echo "<td>Day:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
echo "<input type=RADIO value=dt name=r2 disabled>&nbsp&nbsp&nbsp&nbsp&nbspDate:&nbsp&nbsp&nbsp&nbsp&nbsp<input type=text Size=\"12\" name=en_dt DISABLED></td>";

echo "<tr bgcolor=$color><td>Month:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
echo "<input type=RADIO value=mn name=r1 onClick=enable_button(this.value);>&nbsp&nbsp&nbsp Month:";
makeSelectwithJS($month_array,'cuurent_month',$m,'cuurent_month','disabled');
echo "</td>";
echo "<td>Month:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
echo "<input type=RADIO value=mn name=r2 DISABLED>&nbsp&nbsp&nbsp Month:";
makeSelectwithJS($month_array,'prv_month',$m,'prv_month','disabled');
echo"&nbsp;-&nbsp;<input type=TEXT size=4 name=prv_year id=p_y Value=\"$year\" onclick=\"this.value=''\" onkeypress=\"return numbersonly(event)\" DISABLED $HIGHLIGHT>";
echo "</td>";

echo "<tr bgcolor=$color><td>Quaterly:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
echo "<input type=RADIO value=mn name=r1 onClick=enable_button(this.value);>&nbsp&nbsp&nbsp Quater:";
makeSelectwithJS($quarterly_array,'cuurent_quater',$m,'cuurent_quater','disabled');
echo "</td>";
echo "<td>Quaterly:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
echo "<input type=RADIO value=mn name=r2 onClick=enable_button(this.value); disabled>&nbsp&nbsp&nbsp Quater:";
makeSelectwithJS($quarterly_array,'prv_quater',$m,'prv_quater','disabled');
echo"&nbsp;-&nbsp;<input type=TEXT size=4 name=prv_quater id=p_q Value=\"\" onclick=\"this.value=''\" onkeypress=\"return numbersonly(event)\" DISABLED $HIGHLIGHT>";
echo "</td>";
echo "<tr bgcolor=$color><td>Half Yearly:&nbsp&nbsp&nbsp&nbsp&nbsp";
echo "<input type=RADIO value=mn name=r1 onClick=enable_button(this.value);>&nbsp&nbsp&nbsp Half Year:";
makeSelectwithJS($half_year_array,'cuurent_half',$m,'cuurent_half','disabled');
echo "</td>";
echo "<td>Half Yearly:&nbsp&nbsp&nbsp&nbsp&nbsp";
echo "<input type=RADIO value=mn name=r2 onClick=enable_button(this.value); disabled>&nbsp&nbsp&nbsp Half Year:";
makeSelectwithJS($half_year_array,'prv_half',$m,'prv_half','disabled');
echo"&nbsp;-&nbsp;<input type=TEXT size=4 name=\"prv_half\" id=\"p_h\" Value=\"\" onclick=\"this.value=''\" onkeypress=\"return numbersonly(event)\" DISABLED $HIGHLIGHT>";
echo "</td>";

echo "<tr bgcolor=$color><td>Yearly:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
echo "<input type=RADIO value=yr name=r1 onClick=enable_button(this.value);></td>";
echo "<td>Yearly:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
echo "<input type=RADIO value=yr name=r2 disabled>&nbsp;&nbsp;<input type=TEXT size=4 name=yr id=yr Value=\"\" onclick=\"this.value=''\" onkeypress=\"return numbersonly(event)\" DISABLED $HIGHLIGHT></td>";
echo "<tr><td  bgcolor=\"#9ACD32\" align=\"center\" colspan=\"2\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Submit\"></td></tr>";
echo "</table>";
echo "<input type=\"HIDDEN\" name=\"f_start_dt\" id=\"f_start_dt\" value=\"$f_start_dt\">";
echo "<input type=\"HIDDEN\" name=\"f_end_dt\" id=\"f_end_dt\" value=\"$f_end_dt\">";
echo "<input type=\"HIDDEN\" name=\"start_dt\" id=\"start_dt\" value=\"\">";
echo "<input type=\"HIDDEN\" name=\"end_dt\" id=\"end_dt\" value=\"\">";
echo "</form>";
echo "</body>";
echo "</html>";
?>
