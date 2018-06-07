<?
include "../config/config.php";
$staff_id=verifyAutho();
$fy=$_SESSION['fy'];
getDetailFy($fy,&$f_start_dt,&$f_end_dt);
$start_date=$_REQUEST["start_date"];
if(empty($start_date) ) { $start_date=$f_end_dt; }
$PTcapital="0";
$CTcapital="0";
$slno="0";
$a="0";
$flag="0";
$flag1="0";
$flag2="0";
$flag3="0";
$flag4="0";
$flag5="0";
$flag6="0";
$flag7="0";
$flag8="0";
$PTLia="0";
$CTLia="0";
$PTAss="0";
$CTAss="0";
$PTDepo="0";
$CTDepo="0";
$PTOLib="0";
$CTOLib="0";
$PTFA="0";
$CTFA="0";
$PTINV="0";
$CTINV="0";
$PTLA="0";
$CTLA="0";
$PTOA="0";
$PTOA="0";
$PTBB="0";
$CTBB="0";
$PTBOB="0";
$PTBOB="0";
echo "<html>";
echo "<head>";
echo "<title>Balance sheet";
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
echo "<form name=\"f1\" action=\"balance_sheet123.php\" method=\"POST\" onsubmit=\"return check();\">";
echo "<table align=center bgcolor=\"#90EE90\"><tr><td  align=\"\"><b>Balance Sheet As On (DD/MM/YYYY) :<td><input type=TEXT size=10 maxlength=\"10\" name=\"start_date\" id=\"start_date\" value=\"$start_date\"  maxlength=\"10\" onFocus=\"javascript:vDateType='1'\" onKeyUp=\"DateFormat(this,this.value,event,false,'3')\" onBlur=\"DateFormat(this,this.value,event,true,'3')\" $HIGHLIGHT>&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.start_date,'dd/mm/yyyy','Choose Date')\">";
echo "<input type=\"HIDDEN\" name=\"f_start_dt\" id=\"f_start_dt\" value=\"$f_start_dt\">";
echo "<input type=\"HIDDEN\" name=\"f_end_dt\" id=\"f_end_dt\" value=\"$f_end_dt\">";
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> ";
echo "<tr>";
echo "<th colspan=\"2\" bgcolor=\"Yellow\">Balance Sheet as on $start_date</th>";
echo "</tr>";
echo "</table></form>";


$sql_statement=" select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and gl_mas_code='11200') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){



echo "<table align=left width=50% bgcolor=\"#817339\" border=1>"; 

//-----------------------------------------------------------------------------------------------



//----------------------------------------------------------------------------------------------

echo "<tr bgcolor=#4AA02C colspan=5>";
echo "<th width=5%>Sl No.</th>";
echo "<th width=14%>Liabilities</th>";
echo "<th width=11%>Breakup</th>";
echo "<th width=10%>31st March Previous Year</th>";
echo "<th width=10%>31st March Current Year</th>";
echo "</tr>";
//-------------------------------------------------------------------------------------------------

//------------------------------------CAPITAL-------------------------------------------------
echo "<tr colspan=5>";
echo "<th width=5% rowspan=7 bgcolor=#4E9258>1.</th>";
echo "<th width=14% colspan=2 align=left  bgcolor=#254117><font color=white>Capital</font></th>";
//echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258></th>";

echo "<th width=10% colspan=1 bgcolor=#4E9258></th>";
echo "</tr>";

//-------------------------------------------AUTHORISED----------------------------

echo "<tr >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>a) Authorised</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258></th>";

echo "<th width=10% colspan=1 bgcolor=#4E9258></th>";
echo "</tr>";

//-----------------------------------------------------SUBCRIBED-----------------------
echo "<tr >";


echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>ii) Subscribed</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258></th>";

echo "<th width=10% colspan=1 bgcolor=#4E9258></th>";
echo "</tr>";

//--------------------------------------------------------------PAID-UP--------
echo "<tr >";

echo "<th width=14% colspan=2 bgcolor=#4AA02C align=left>iii) Paid Up</th>";
//echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258></th>";

echo "<th width=10% colspan=1 bgcolor=#4E9258></th>";
echo "</tr>";

//-------------------------------------------------------------------INDIVIDUALS--------

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_11200=0;
$p_11200=$p_11200+$row['p_cr'];


echo "<tr >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>a) Individuals</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_11200)."</th>";
}
}


$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='11200') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_11200=0;
$c_11200=$o_11200+$row['c_cr'];
$o_11200=$c_11200+$p_11200;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_11200)."</th>";
}
}
echo "</tr>";


//----------------------------------------------------------------------------GOVERNMENT-----------------------

$sql_statement=" select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and gl_mas_code='11100') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_11100=0;
$p_11100=$p_11100+$row['p_cr'];

echo "<tr >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>b) Government</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_11100)."</th>";
}
}
$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='11100') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_11100=0;
$c_11100=$c_11100+$row['c_cr'];
$o_11100=$c_11100+$p_11100;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_11100)."</th>";
}
}
echo "</tr>";

//--------------------------------------------------------------------------OTHERS-----------------

echo "<tr >";






echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>c) Others</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258></th>";

echo "<th width=10% colspan=1 bgcolor=#4E9258></th>";
echo "</tr>";

//----------------------------------------------------------------------------TOTAL---------------------

$p1_total=$p_11200+$p_11100;
$c1_total=$o_11200+$o_11100;
echo "<tr bgcolor=#4AA02C colspan=5>";

echo "<th width=5% colspan=3>Total of Capital</th>";
echo "<th width=14% colspan=1>".amount2Rs((float)$p1_total)."</th>";
echo "<th width=11% colspan=1>".amount2Rs((float)$c1_total)."</th>";

echo "</tr>";



//-----------------------------------------------------------------222222222-----------RESERVES AND FUNDS------------

echo "<tr colspan=5>";
echo "<th width=5% rowspan=8 bgcolor=#4E9258>2.</th>";
echo "<th width=14% colspan=2 align=left bgcolor=#254117><font color=white>Reserves and Funds</font></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258></th>";
echo "</tr>";

//-----------------------------------------------------------------------------RESERVE FUND----------------
$sql_statement=" select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code='12101' or gl_mas_code='12102' or gl_mas_code='12103')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_12101=0;
$p_12101=$p_12101+$row['p_cr'];
echo "<tr bgcolor=#4E9258>";
echo "<th width=14% rowspan=1 align=left bgcolor=#4E9258>i. Reserve Fund</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_12101)."</th>";
}
}

$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code='12101' or gl_mas_code='12102' or gl_mas_code='12103')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_12101=0;
$c_12101=$c_12101+$row['c_cr'];
$o_12101=$c_12101+$p_12101;
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_12101)."</th>";
}
}
echo "</tr>";

//-------------------------------------------------------------------------CAPITAL RESERVE-------------------------
$sql_statement=" select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and gl_mas_code='12202') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_12202=0;
$p_12202=$p_12202+$row['p_cr'];
echo "<tr bgcolor=#4E9258>";
echo "<th width=14% colspan=1 align=left>ii. Capital Reserve</th>";
echo "<th width=11% colspan=1></th>";
echo "<th width=10% colspan=1>".amount2Rs((float)$p_12202)."</th>";
}
}
$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='12202') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_12202=0;
$c_12202=$c_12202+$row['c_cr'];
$o_12202=$c_12202+$p_12202;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_12202)."</th>";
}
}
echo "</tr>";

//--------------------------------------------------------------------------------AGRICULTURAL CREDIT----------------------
$sql_statement=" select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and gl_mas_code='12206') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_12206=0;
$p_12206=$p_12206+$row['p_cr'];
echo "<tr bgcolor=#4E9258>";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>iii. Agricultural Credit Stabilisation Fund</th>";;
echo "<th width=11% colspan=1></th>";
echo "<th width=10% colspan=1>".amount2Rs((float)$p_12206)."</th>";
}
}
$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='12206') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_12206=0;
$c_12206=$c_12206+$row['c_cr'];
$o_12206=$c_12206+$p_12206;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_12206)."</th>";
}
}
echo "</tr>";

//-------------------------------------------------------------------------------------DIVIDENT EQUALIZATION FUND---------
$sql_statement=" select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and gl_mas_code='12205') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_12205=0;
$p_12205=$p_12205+$row['p_cr'];
echo "<tr bgcolor=#4E9258>";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>iv. Dividend Equalization Fund</th>";
echo "<th width=11% colspan=1></th>";
echo "<th width=10% colspan=1>".amount2Rs((float)$p_12205)."</th>";
}
}
$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='12205') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_12205=0;
$c_12205=$c_12205+$row['c_cr'];
$o_12205=$c_12205+$p_12205;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_12205)."</th>";
}
}
echo "</tr>";
//-------------------------------------------------------------------------------COMMON GOOD FUND----------
$sql_statement=" select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and gl_mas_code='12212') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_12212=0;
$p_12212=$p_12212+$row['p_cr'];
echo "<tr bgcolor=#4E9258>";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>v. Common Good Fund</th>";
echo "<th width=11% colspan=1></th>";
echo "<th width=10% colspan=1>".amount2Rs((float)$p_12212)."</th>";
}
}
$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='12212') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_12212=0;
$c_12212=$c_12212+$row['c_cr'];
$o_12212=$c_12212+$p_12212;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_12212)."</th>";
}
}
echo "</tr>";
//----------------------------------------------------------------------------------BUILDING FUND---------------
$sql_statement=" select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and gl_mas_code='12208') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_12208=0;
$p_12208=$p_12208+$row['p_cr'];

echo "<tr >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>vi. Building Fund (created out of surplus by PACS)</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_12208)."</th>";
}
}

$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='12208') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_12208=0;
$c_12208=$c_12208+$row['c_cr'];
$o_12208=$c_12208+$p_12208;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_12208)."</th>";
}
}
echo "</tr>";

//------------------------------------------------------------------------------------OTHERS---------
$sql_statement=" select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code='12201' or gl_mas_code='12207' or gl_mas_code='12209' or gl_mas_code='12210' or gl_mas_code='12211' or gl_mas_code='12213' or gl_mas_code='12214' or gl_mas_code='12215' or gl_mas_code='12299')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_12201=0;
$p_12201=$p_12201+$row['p_cr'];
echo "<tr  >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>vii. Others (to be specified)</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_12201)."</th>";
}
}

$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code='12201' or gl_mas_code='12207' or gl_mas_code='12209' or gl_mas_code='12210' or gl_mas_code='12211' or gl_mas_code='12213' or gl_mas_code='12214' or gl_mas_code='12215' or gl_mas_code='12299')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_12201=0;
$c_12201=$c_12201+$row['c_cr'];
$o_12201=$c_12201+$p_12201;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_12201)."</th>";
}
}
echo "</tr>";

///--------------------------------------------------TOTAL-----------------------------------------------------

$p2_total=$p_12101+$p_12102+$p_12206+$p_12205+$p_12212+$p_12208+$p_12201;
$c2_total=$o_12101+$o_12102+$o_12206+$o_12205+$o_12212+$o_12208+$o_12201;

echo "<tr bgcolor=#4AA02C colspan=5>";
echo "<th width=5% colspan=3>Total of reserve fund:</th>";
echo "<th width=14% colspan=1>".amount2Rs((float)$p2_total)."</th>";
echo "<th width=11% colspan=1>".amount2Rs((float)$c2_total)."</th>";
echo "</tr>";



///--------------------------------------------PROFIT AND LOSS ACCOUNT----------------333333333333333-------------
$sql_statement="SELECT '12302' as gl_mas_code, 'Profit & Loss' as gl_mas_desc,SUM(debit) as debit,SUM(credit) as cedit,SUM(credit-debit) as bal FROM (SELECT a.gl_mas_code,SUM(debit) as debit,SUM(credit) as credit,bs_pl from mas_gl_tran a,gl_master_vw b WHERE action_date<=date('$start_date')-INTERVAL '1 year' AND a.gl_mas_code=b.gl_mas_code group by a.gl_mas_code,bs_pl HAVING bs_pl='S' OR bs_pl='I' OR bs_pl='P' OR bs_pl='E') as foo";

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_12302=0;
$p_12302=$p_12302+$row['bal'];

echo "<tr colspan=5>";
echo "<th width=5% rowspan=1 bgcolor=#4E9258>3.</th>";
echo "<th width=14% colspan=1 align=left bgcolor=#254117><font color=white>Profit and Loss Account (if closing balance is profit)</th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258></th>";
if($p_12302>0){
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_12302)."</th>";
}
else
{
$p_12302=0;
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_12302)."</th>";
}
}
}


$sql_statement="SELECT '12302' as gl_mas_code, 'Profit & Loss' as gl_mas_desc,SUM(debit) as debit,SUM(credit) as cedit,SUM(credit-debit) as bal FROM (SELECT a.gl_mas_code,SUM(debit) as debit,SUM(credit) as credit,bs_pl from mas_gl_tran a,gl_master_vw b WHERE action_date<='$start_date' and action_date>='$f_start_dt'  AND a.gl_mas_code=b.gl_mas_code group by a.gl_mas_code,bs_pl HAVING bs_pl='S' OR bs_pl='I' OR bs_pl='P' OR bs_pl='E') as foo";

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_12302=0;
$c_12302=$c_12302+$row['bal'];
$o_12302=$c_12302+$p_12302;
if($o_12302>0){
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_12302)."</th>";
}
else{
$o_12302=0;
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_12302)."</th>";
}
}
}
echo "</tr>";

//------------------------------------------444444-----------------------------------GRANTS AND OTHERS FUNDS-------------
echo "<tr colspan=5>";
echo "<th width=5% rowspan=7 bgcolor=#4E9258>4.</th>";
echo "<th width=14% colspan=2 align=left bgcolor=#254117><font color=white>Grants and other Funds</font></th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258></th>";
echo "</tr>";

//-------------------------------------------------------------------------------PROVIDENT FUND---------------

$sql_statement=" select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and gl_mas_code='12216') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_12216=0;
$p_12216=$p_12216+$row['p_cr'];


echo "<tr bgcolor=#4E9258>";
echo "<th width=14% colspan=1 align=left>i. Provident Fund</th>";
echo "<th width=11% colspan=1></th>";
echo "<th width=10% colspan=1>".amount2Rs((float)$p_12216)."</th>";
}
}

$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='12216') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_12216=0;
$c_12216=$c_12216+$row['c_cr'];
$o_12216=$c_12216+$p_12216;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_12216)."</th>";
}
}

echo "</tr>";

//-------------------------------------------------------BUILDING FUND----------12402---------------------------------
$sql_statement=" select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and gl_mas_code='12401') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_12401=0;
$p_12401=$p_12401+$row['p_cr'];
echo "<tr >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>ii. Building Fund (received from State Government)</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_12401)."</th>";
}
}

$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='12401') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_12401=0;
$c_12401=$c_12401+$row['c_cr'];
$o_12401=$c_12401+$p_12401;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_12401)."</th>";
}
}

echo "</tr>";

//---------------------------------------------------RECAPITALISATION ASSISTANCE FUND---------------------------------

$sql_statement="select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code='12203' or gl_mas_code='12204')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_12203=0;
$p_12203=$p_12203+$row['p_cr'];

echo "<tr >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>iii. Recapitalisation Assistance Fund</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_12203)."</th>";
}
}

$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code='12203' or gl_mas_code='12204')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_12203=0;
$c_12203=$c_12203+$row['c_cr'];
$o_12203=$c_12203+$p_12203;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_12203)."</th>";
}
}
echo "</tr>";


//-------------------------------------------------------------SUBSIDIES MEANT FOR SOCIETY-------------------------

$sql_statement="select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code between '12402' and '12499')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_12402=0;
$p_12402=$p_12402+$row['p_cr'];

echo "<tr >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>iv. Subsidies meant for Society</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_12402)."</th>";
}
}

$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code between '12402' and '12499')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_12402=0;
$c_12402=$c_12402+$row['c_cr'];
$o_12402=$c_12402+$p_12402;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_12402)."</th>";
}
}
echo "</tr>";
//-----------------------------------------------------------SUBSIDY BMEANT FOR MEMBERS-------------------------------

$sql_statement="select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code='18805' or gl_mas_code='18806' or gl_mas_code='18807' or gl_mas_code='18808' )) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_18805=0;
$p_18805=$p_18805+$row['p_cr'];

echo "<tr >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>v. Subsidy meant for members</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_18805)."</th>";
}
}

$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code='18805' or gl_mas_code='18806' or gl_mas_code='18807' or gl_mas_code='18808')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_18805=0;
$c_18805=$c_18805+$row['c_cr'];
$o_18805=$c_18805+$p_18805;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_18805)."</th>";
}
}
echo "</tr>";

//-------------------------------------------------------------------OTHERS-------------------------
$sql_statement=" select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and gl_mas_code='18809') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_18809=0;
$p_18809=$p_18809+$row['p_cr'];
echo "<tr >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>vi. Others (to be specified)</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_18809)."</th>";
}
}

$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='18809') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_18809=0;
$c_18809=$c_18809+$row['c_cr'];
$o_18809=$c_18809+$p_18809;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_18809)."</th>";
}
}

echo "</tr>";
//-------------------------------------------------------------TOTAL---------------------------------
$p4_total=$p_12216+$p_12401+$p_12203+$p_12402+$p_18805+$p_18809;
$c4_total=$o_12216+$o_12401+$o_12203+$o_12402+$o_18805+$o_18809;

echo "<tr bgcolor=#4AA02C colspan=5>";
echo "<th width=5% colspan=3>Total of PL Account:</th>";
echo "<th width=14% colspan=1>".amount2Rs((float)$p4_total)."</th>";
echo "<th width=11% colspan=1>".amount2Rs((float)$c4_total)."</th>";
echo "</tr>";


///-----------------------------------------------------------------------------------5.----------------------

///--------------------------------------------------------------SAVINGS DEPOSITS-----------------------------

echo "<tr colspan=5>";
echo "<th width=5% rowspan=6 bgcolor=#4E9258>5.</th>";
echo "<th width=14% colspan=2 align=left bgcolor=#254117><font color=white>Deposit</font></th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258></th>";
echo "</tr>";

//--------------------------------------------------------------SAVINGS DEPOSITS-----------------------------
//$sql_statement=" select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code='14101' or gl_mas_code='14201' or gl_mas_code='14301' or gl_mas_code='14106' or gl_mas_code='14107')) as foo"; 
$sql_statement=" select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code='14101' or gl_mas_code='14201' or gl_mas_code='14301' or gl_mas_code='14106' or gl_mas_code='14107')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_14101=0;
$p_14101=$p_14101+$row['p_cr'];
echo $p_14101;
echo "<tr bgcolor=#4E9258>";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>1.Savings Deposits</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_14101)."</th>";
}
}
$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date'  and (gl_mas_code='14101' or gl_mas_code='14201' or gl_mas_code='14301')) as foo"; 
//$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date'  and action_date>='$f_start_dt' and (gl_mas_code='14101' or gl_mas_code='14201' or gl_mas_code='14301' or gl_mas_code='14106' or gl_mas_code='14107')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_14101=0;
//$c_14101=$c_14101+$row['c_cr'];
$c_14101=$row['c_cr']-$p_14101;
$o_14101=$c_14101+$p_14101;


echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_14101)."</th>";
}
}
echo "</tr>";

//---------------------------------------------------------------RECURRING DEPOSITS-------------------------------

$sql_statement=" select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code='14102' or gl_mas_code='14202' or gl_mas_code='14302' or gl_mas_code='14308' or gl_mas_code='14309')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_14102=0;
$p_14102=$p_14102+$row['p_cr'];
echo "<tr bgcolor=#4E9258>";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>2.Recurring Deposits</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_14102)."</th>";
}
}

$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code='14102' or gl_mas_code='14202' or gl_mas_code='14302' or gl_mas_code='14308' or gl_mas_code='14309')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_14102=0;
$c_14102=$c_14102+$row['c_cr'];
$o_14102=$c_14102+$p_14102;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_14102)."</th>";
}
}
echo "</tr>";

//----------------------------------------------------------------------FIXED DEPOSITS------------------------

$sql_statement=" select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code='14103' or gl_mas_code='14203' or gl_mas_code='14303' or gl_mas_code='14310' or gl_mas_code='14307')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_14103=0;
$p_14103=$p_14103+$row['p_cr'];
echo "<tr bgcolor=#4E9258>";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>3.Fixed Deposits</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_14103)."</th>";
}
}

$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code='14103' or gl_mas_code='14203' or gl_mas_code='14303' or gl_mas_code='14310' or gl_mas_code='14307')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_14103=0;
$c_14103=$c_14103+$row['c_cr'];
$o_14103=$c_14103+$p_14103;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_14103)."</th>";
}
}
echo "</tr>";


//-------------------------------------------------------------------REINVESTMENT DEPOSITS---------------

$sql_statement=" select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code='14104' or gl_mas_code='14204' or gl_mas_code='14304')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_14104=0;
$p_14104=$p_14104+$row['p_cr'];
echo "<tr bgcolor=#4E9258>";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>4.Reinvestment Deposits</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_14104)."</th>";
}
}

$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code='14104' or gl_mas_code='14204' or gl_mas_code='14304')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_14104=0;
$c_14104=$c_14104+$row['c_cr'];
$o_14104=$c_14104+$p_14104;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_14104)."</th>";
}
}
echo "</tr>";


//-------------------------------------------------------------------------OTHERS--------------

$sql_statement=" select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and gl_mas_code='14306') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_14306=0;
$p_14306=$p_14306+$row['p_cr'];
echo "<tr bgcolor=#4E9258>";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>5.Others (to be specified)</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_14306)."</th>";
}
}

$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='14306') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_14306=0;
$c_14306=$c_14306+$row['c_cr'];
$o_14306=$c_14306+$p_14306;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_14306)."</th>";
}
}
echo "</tr>";

///--------------------------------------------------------------------------TOTAL----------------------
$p5_total=$p_14101+$p_14102+$p_14103+$p_14104+$p_14306;
$c5_total=$o_14101+$o_14102+$o_14103+$o_14104+$o_14306;

echo "<tr bgcolor=#4AA02C colspan=5>";
echo "<th width=5% colspan=3>Total of Deposit:</th>";
echo "<th width=14% colspan=1>".amount2Rs((float)$p5_total)."</th>";
echo "<th width=11% colspan=1>".amount2Rs((float)$c5_total)."</th>";
echo "</tr>";

////----------------------------------------------------Borrowings------------------------6.------------------------
echo "<tr colspan=5>";
echo "<th width=5% rowspan=20 bgcolor=#4E9258>6.</th>";
echo "<th width=14% colspan=2 align=left bgcolor=#254117><font color=white>Borrowings</font></th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258></th>";
echo "</tr>";
//*------------------------------------------------------BORROWING FROM DCCB----------------------------------------
echo "<tr bgcolor=#4E9258>";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>BORROWING FROM DCCB</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258></th>";
echo "</tr>";

//-----------------------------------------------ST(SAO)---------------------------------------------------

$sql_statement=" select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and gl_mas_code='13201') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_13201=0;
$p_13201=$p_13201+$row['p_cr'];
echo "<tr bgcolor=#4E9258>";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>i. ST (SAO) / KCC Credit Limit</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_13201)."</th>";
}
}

$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='13201') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_13201=0;
$c_13201=$c_13201+$row['c_cr'];
$o_13201=$c_13201+$p_13201;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_13201)."</th>";
}
}
echo "</tr>";

//---------------------------------------------------------------------MT/LT Agri Loans----------------------

$sql_statement=" select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and gl_mas_code='13205') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_13205=0;
$p_13205=$p_13205+$row['p_cr'];
echo "<tr bgcolor=#4E9258>";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>ii. MT/LT Agri Loans</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_13205)."</th>";
}
}

$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='13205') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_13205=0;
$c_13205=$c_13205+$row['c_cr'];
$o_13205=$c_13205+$p_13205;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_13205)."</th>";
}
}
echo "</tr>";
//------------------------------------------------------------------MT CONVERSION------------------------------

$sql_statement=" select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and gl_mas_code='13202') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_13202=0;
$p_13202=$p_13202+$row['p_cr'];
echo "<tr bgcolor=#4E9258>";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>iii. MT Conversion</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_13202)."</th>";
}
}

$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='13202') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_13202=0;
$c_13202=$c_13202+$row['c_cr'];
$o_13202=$c_13202+$p_13202;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_13202)."</th>";
}
}
echo "</tr>";
//--------------------------------------------------------MT/LT RESCHEDULMENT----4444444444444---------------

$sql_statement=" select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and gl_mas_code='13203') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_13203=0;
$p_13203=$p_13203+$row['p_cr'];
echo "<tr bgcolor=#4E9258>";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>iv. MT/LT Reschedulement</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_13203)."</th>";
}
}

$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='13203') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_13203=0;
$c_13203=$c_13203+$row['c_cr'];
$o_13203=$c_13203+$p_13203;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_13203)."</th>";
}
}
echo "</tr>";

//----------------------------------------------------------SHG LOANS-----------------------------------
$sql_statement=" select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and gl_mas_code='13204') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_13204=0;
$p_13204=$p_13204+$row['p_cr'];
echo "<tr bgcolor=#4E9258>";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>v. SHG Loans</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_13204)."</th>";
}
}

$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='13204') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_13204=0;
$c_13204=$c_13204+$row['c_cr'];
$o_13204=$c_13204+$p_13204;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_13204)."</th>";
}
}
echo "</tr>";
//------------------------------------------------------------NON FARM SECTOR LOANS------------------------
$sql_statement=" select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and gl_mas_code='13206') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_13206=0;
$p_13206=$p_13206+$row['p_cr'];
echo "<tr bgcolor=#4E9258>";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>vi. Non farm sector Loans</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_13206)."</th>";
}
}

$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='13206') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_13206=0;
$c_13206=$c_13206+$row['c_cr'];
$o_13206=$c_13206+$p_13206;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_13206)."</th>";
}
}
echo "</tr>";

//---------------------------CASH CREDIT LIMIT FOR PROCUREMTNT OF AGRICULTURAL PRODUCE----------------------

$sql_statement=" select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and gl_mas_code='13207') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_13207=0;
$p_13207=$p_13207+$row['p_cr'];
echo "<tr bgcolor=#4E9258>";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>vii. Cash Credit Limit for procurement ofAgricultural Produce</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_13207)."</th>";
}
}

$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='13207') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_13207=0;
$c_13207=$c_13207+$row['c_cr'];
$o_13207=$c_13207+$p_13207;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_13207)."</th>";
}
}
echo "</tr>";

//------------------------------------------------CASH CREDIT LIMIT FOR GOLD LOANS-------------------------
$sql_statement=" select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and gl_mas_code='13208') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_13208=0;
$p_13208=$p_13208+$row['p_cr'];
echo "<tr bgcolor=#4E9258>";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>viii. Cash Credit Limit for Gold Loans</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_13208)."</th>";
}
}

$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='13208') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_13208=0;
$c_13208=$c_13208+$row['c_cr'];
$o_13208=$c_13208+$p_13208;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_13208)."</th>";
}
}
echo "</tr>";
//-------------------------------------------LOANS AGAINST DEPOSITS WITH DCCB/SCB--------------------

$sql_statement=" select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and gl_mas_code='13214') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_13214=0;
$p_13214=$p_13214+$row['p_cr'];
echo "<tr bgcolor=#4E9258>";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>ix. Loans against deposits with DCCB / SCB</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_13214)."</th>";
}
}

$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='13214') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_13214=0;
$c_13214=$c_13214+$row['c_cr'];
$o_13214=$c_13214+$p_13214;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_13214)."</th>";
}
}
echo "</tr>";
//--------------------------------------------------------FERTILIZER CASH CREDIT LIMIT---------------------

$sql_statement=" select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and gl_mas_code='13209') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_13209=0;
$p_13209=$p_13209+$row['p_cr'];
echo "<tr bgcolor=#4E9258>";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>x. Fertilizer Cash Credit Limit</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_13209)."</th>";
}
}

$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='13209') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_13209=0;
$c_13209=$c_13209+$row['c_cr'];
$o_13209=$c_13209+$p_13209;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_13209)."</th>";
}
}
echo "</tr>";
//--------------------------------------------------------SEEDS CASH CREDIT LIMIT-----------------------------

$sql_statement=" select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and gl_mas_code='13210') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_13210=0;
$p_13210=$p_13210+$row['p_cr'];
echo "<tr bgcolor=#4E9258>";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>xi. Seeds Cash Credit Limit</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_13210)."</th>";
}
}

$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='13210') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_13210=0;
$c_13210=$c_13210+$row['c_cr'];
$o_13210=$c_13210+$p_13210;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_13210)."</th>";
}
}
echo "</tr>";

//--------------------------------------------------------PUBLIC DISTRIBUTION SCHEME CC LIMIT----------------

$sql_statement=" select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and gl_mas_code='13211') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_13211=0;
$p_13211=$p_13211+$row['p_cr'];
echo "<tr bgcolor=#4E9258>";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>xii. Public Distribution Scheme CC Limit</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_13211)."</th>";
}
}

$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='13211') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_13211=0;
$c_13211=$c_13211+$row['c_cr'];
$o_13211=$c_13211+$p_13211;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_13211)."</th>";
}
}
echo "</tr>";

//-----------------------------------------------------CONSUMER COMMODITION-----------------------------------
$sql_statement=" select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and gl_mas_code='13212') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_13212=0;
$p_13212=$p_13212+$row['p_cr'];
echo "<tr bgcolor=#4E9258>";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>xiii. Consumer Commodities CC Limit</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_13212)."</th>";
}
}

$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='13212') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_13212=0;
$c_13212=$c_13212+$row['c_cr'];
$o_13212=$c_13212+$p_13212;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_13212)."</th>";
}
}
echo "</tr>";

//-------------------------------------------------------OTHER NON CREDIT ACTIVITITES-----------------------

$sql_statement=" select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and gl_mas_code='13213') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_13213=0;
$p_13213=$p_13213+$row['p_cr'];
echo "<tr bgcolor=#4E9258>";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>xiv. Other non credit activities</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_13213)."</th>";
}
}

$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='13213') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_13213=0;
$c_13213=$c_13213+$row['c_cr'];
$o_13213=$c_13213+$p_13213;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_13213)."</th>";
}
}
echo "</tr>";
//------------------------------------------------------------------OTHER BORROWING FROM DCCB/SCB------------

$sql_statement=" select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and gl_mas_code='13299') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_13299=0;
$p_13299=$p_13299+$row['p_cr'];
echo "<tr bgcolor=#4E9258>";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>xv. Other borrowings from DCCB / SCB</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_13299)."</th>";
}
}

$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='13299') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_13299=0;
$c_13299=$c_13299+$row['c_cr'];
$o_13299=$c_13299+$p_13299;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_13299)."</th>";
}
}
echo "</tr>";

///------------------------------------------------------TOTAL-------------------------------------
$p66_total=$p_13201+$p_13205+$p_13202+$p_13203+$p_13204+$p_13206+$p_13207+$p_13208+$p_13214+$p_13209+$p_13210+$p_13211+$p_13212+$p_13213+$p_13299;
$c66_total=$o_13201+$o_13205+$o_13202+$o_13203+$o_13204+$o_13206+$o_13207+$o_13208+$o_13214+$o_13209+$o_13210+$o_13211+$o_13212+$o_13213+$o_13299;

echo "<tr bgcolor=#4AA02C colspan=5>";
echo "<th width=5% colspan=2>Total:</th>";
echo "<th width=14% colspan=1>".amount2Rs((float)$p66_total)."</th>";
echo "<th width=11% colspan=1>".amount2Rs((float)$c66_total)."</th>";
echo "</tr>";

//---------------------------------------------BORROWINGS FROM STATE GOVERNMENT------------------------------
$sql_statement=" select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code between '13101' and '13199')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_13101=0;
$p_13101=$p_13101+$row['p_cr'];
echo "<tr bgcolor=#4E9258>";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>(b) Borrowings from State Government</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_13101)."</th>";
}
}

$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code between '13101' and '13199')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_13101=0;
$c_13101=$c_13101+$row['c_cr'];
$o_13101=$c_13101+$p_13101;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_13101)."</th>";
}
}

echo "</tr>";
//------------------------------------------BORROWINGS FROM OTHER INSTITUTIONS-----------
$sql_statement=" select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code between '13301' and '13399')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_13301=0;
$p_13301=$p_13301+$row['p_cr'];
echo "<tr bgcolor=#4E9258>";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>(c) Borrowings from Other Institutions (details in annexure)</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_13301)."</th>";
}
}

$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code between '13101' and '13199')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_13301=0;
$c_13301=$c_13301+$row['c_cr'];
$o_13301=$c_13301+$p_13301;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_13301)."</th>";
}
}
echo "</tr>";
//------------------------------------------------------------TOTAL--------------------------------
$p6_total=$p66_total+$p_13101+$p_13301;
$c6_total=$c66_total+$o_13101+$o_13301;



echo "<tr bgcolor=#4AA02C colspan=5>";
echo "<th width=5% colspan=3>Total of Borrowings:</th>";
echo "<th width=14% colspan=1>".amount2Rs((float)$p6_total)."</th>";
echo "<th width=11% colspan=1>".amount2Rs((float)$c6_total)."</th>";
echo "</tr>";


//--------------------------------------------------------7.-----------other liabilities-------------------------------
echo "<tr colspan=5>";
echo "<th width=5% rowspan=6 bgcolor=#4E9258>7.</th>";
echo "<th width=14% colspan=2 align=left bgcolor=#254117><font color=white>Other Liabilities</font></th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258></th>";
echo "</tr>";


//-----------------------------------------------------------INTEREST ACCRUED ON DEPOSITS---------------
$sql_statement=" select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code between '16101' and '16199' or gl_mas_code between '16201' and '16299' or gl_mas_code between '16301' and '16399')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_16101=0;
$p_16101=$p_16101+$row['p_cr'];
echo "<tr bgcolor=#4E9258>";
echo "<th width=14% colspan=1 align=left>(i) Interest Accrued on Deposits</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_16101)."</th>";
}
}

$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code between '16101' and '16199' or gl_mas_code between '16201' and '16299' or gl_mas_code between '16301' and '16399')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_16101=0;
$c_16101=$c_16101+$row['c_cr'];
$o_16101=$c_16101+$p_16101;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_16101)."</th>";
}
}
echo "</tr>";

//-----------------------------------------------------INTEREST ACCRUED ON BORROWINGS-------------------------------

$sql_statement=" select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code between '15101' and '15199' or gl_mas_code between '15201' and '15299' or gl_mas_code between '15301' and '15399' or gl_mas_code between '15401' and '15499')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_15101=0;
$p_15101=$p_15101+$row['p_cr'];
echo "<tr bgcolor=#4E9258>";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>(ii) Interest Accrued on Borrowings</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_15101)."</th>";
}
}

$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code between '15101' and '15199' or gl_mas_code between '15201' and '15299' or gl_mas_code between '15301' and '15399' or gl_mas_code between '15401' and '15499')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_15101=0;
$c_15101=$c_15101+$row['c_cr'];
$o_15101=$c_15101+$p_15101;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_15101)."</th>";
}
}
echo "</tr>";
//--------------------------------------------------------------UNCLAIMED DIVIDEND----------------------------------

$sql_statement=" select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and gl_mas_code='18801') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_18801=0;
$p_18801=$p_18801+$row['p_cr'];
echo "<tr bgcolor=#4E9258>";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>(iii) Unclaimed Dividend</th>";;
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_18801)."</th>";
}
}

$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='18801') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_18801=0;
$c_18801=$c_18801+$row['c_cr'];
$o_18801=$c_18801+$p_18801;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_18801)."</th>";
}
}
echo "</tr>";
///------------------------------------------------------SUNDRRY CREDITORS-------------------------
$sql_statement=" select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code between '17101' and '17191' or gl_mas_code between '17201' and '17291' or gl_mas_code between '17301' and '17391')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_17101=0;
$p_17101=$p_17101+$row['p_cr'];
echo "<tr bgcolor=#4E9258>";
echo "<th width=14% colspan=1 align=left bgcolor=#254117><font color=white>a.Sundry Creditors (details in Annexure)</font></th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_17101)."</th>";
}
}

$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code between '17101' and '17191' or gl_mas_code between '17201' and '17291' or gl_mas_code between '17301' and '17391')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_17101=0;
$c_17101=$c_17101+$row['c_cr'];
$o_17101=$c_17101+$p_17101;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_17101)."</th>";
}
}
echo "</tr>";
//-----------------------------------------------------------OTHERS--------------------------------------
$sql_statement=" select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code between '18101' and '18102' or gl_mas_code between '18108' and '18199' or gl_mas_code between '18201' and '18206' or gl_mas_code between '18301' and '18308' or gl_mas_code between '18401' and '18499' or gl_mas_code between '18501' and '18599' or gl_mas_code between '18601' and '18699' or gl_mas_code between '18701' and '18799' or gl_mas_code between '18802' and '18804' or gl_mas_code between '18811' and '18899' or gl_mas_code between '18901' and '18911' or gl_mas_code='18999' or gl_mas_code='18105')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_18101=0;
$p_18101=$p_18101+$row['p_cr'];
echo "<tr bgcolor=#4E9258>";
echo "<th width=14% colspan=1 align=left bgcolor=#254117><font color=white>b.Others (to be specified)</font></th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_18101)."</th>";
}
}

$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code between '18101' and '18102' or gl_mas_code between '18108' and '18199' or gl_mas_code between '18201' and '18206' or gl_mas_code between '18301' and '18308' or gl_mas_code between '18401' and '18499' or gl_mas_code between '18501' and '18599' or gl_mas_code between '18601' and '18699' or gl_mas_code between '18701' and '18799' or gl_mas_code between '18802' and '18804' or gl_mas_code between '18811' and '18899' or gl_mas_code between '18901' and '18911' or gl_mas_code='18999' or gl_mas_code='18105')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_18101=0;
$c_18101=$c_18101+$row['c_cr'];
$o_18101=$c_18101+$p_18101;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_18101)."</th>";
}
}
echo "</tr>";
//------------------------------------------------------TOTAL--------------------------------------------

$p7_total=$p_16101+$p_15101+$p_18801+$p_17101+$p_18101;
$c7_total=$o_16101+$o_15101+$o_18801+$o_17101+$o_18101;

echo "<tr bgcolor=#4AA02C colspan=5>";
echo "<th width=5% colspan=3>Total of  other Lbts</th>";
echo "<th width=14% colspan=1>".amount2Rs((float)$p7_total)."</th>";
echo "<th width=11% colspan=1>".amount2Rs((float)$c7_total)."</th>";
echo "</tr>";


//------------------------------------------------BILLS FOR COLLECTION---88888--------------------------------
$sql_statement=" select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and gl_mas_code='18920') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_18920=0;
$p_18920=$p_18920+$row['p_cr'];
echo "<tr colspan=5>";
echo "<th width=5% rowspan=1 bgcolor=#4E9258>8.</th>";

echo "<th width=14% colspan=1 align=left bgcolor=#4E9258>Bills for Collection (being Bills Receivable as per Contra)</th>";
echo "<th width=5% rowspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_18920)."</th>";
}
}

$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='18920') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_18920=0;
$c_18920=$c_18920+$row['c_cr'];
$o_18920=$c_18920+$p_18920;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_18920)."</th>";
}
}
echo "</tr>";


//---------------------------------------------BRANCH ADJUSTMENT ACCOUNT-----999999--------------------------
$sql_statement=" select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and gl_mas_code='18930') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_18930=0;
$p_18930=$p_18930+$row['p_cr'];
echo "<tr colspan=5>";
echo "<th width=5% rowspan=1 bgcolor=#4E9258>9.</th>";

echo "<th width=14% colspan=1 align=left bgcolor=#4E9258>Branch Adjustment Account</th>";

echo "<th width=5% rowspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_18930)."</th>";
}
}

$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='18930') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_18930=0;
$c_18930=$c_18930+$row['c_cr'];
$o_18930=$c_18930+$p_18930;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_18930)."</th>";
}
}
echo "</tr>";

//--------------------------------------------------PROVISIONS-----------------------------10-------------------

echo "<tr colspan=5>";
echo "<th width=5% rowspan=5 bgcolor=#4E9258>10.</th>";
echo "<th width=14% colspan=2 align=left bgcolor=#254117><font color=white>Provisions</font></th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258></th>";
echo "</tr>";

//-------------------------------------------------------------PROVISION FOR PF /GRATUITY/BONUS/PENSION------------
$sql_statement=" select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code='18103' or gl_mas_code='18104' or gl_mas_code='18106' or gl_mas_code='18107')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_18103=0;
$p_18103=$p_18103+$row['p_cr'];
echo "<tr colspan=5>";

echo "<th width=14% colspan=1 align=left bgcolor=#4E9258>(i)Provision for PF / Gratuity / Bonus / Pension</th>";
echo "<th width=5% rowspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_18103)."</th>";
}
}

$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code='18103' or gl_mas_code='18104' or gl_mas_code='18106' or gl_mas_code='18107')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_18103=0;
$c_18103=$c_18103+$row['c_cr'];
$o_18103=$c_18103+$p_18103;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_18103)."</th>";
}
}
echo "</tr>";

//---------------------------------------PROVISION FOR STANDARD ASSETS---------------------------------------
$sql_statement=" select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and gl_mas_code='19100') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_19100=0;
$p_19100=$p_19100+$row['p_cr'];
echo "<tr colspan=5>";

echo "<th width=14% colspan=1 align=left bgcolor=#4E9258>(ii)Provision for Standard Assets</th>";
echo "<th width=5% rowspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_19100)."</th>";
}
}


$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='19100') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_19100=0;
$c_19100=$c_19100+$row['c_cr'];
$o_19100=$c_19100+$p_19100;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_19100)."</th>";
}
}
echo "</tr>";
//---------------------------------------------------------PROVISION FOR EXPENSES------------------------
$sql_statement=" select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code='19600' or gl_mas_code='19900')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_19600=0;
$p_19600=$p_19600+$row['p_cr'];
echo "<tr colspan=5>";

echo "<th width=14% colspan=1 align=left bgcolor=#4E9258>(iii)Provision for Expenses</th>";
echo "<th width=5% rowspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_19600)."</th>";
}
}

$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code='19600' or gl_mas_code='19900')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_19600=0;
$c_19600=$c_19600+$row['c_cr'];
$o_19600=$c_19600+$p_19600;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_19600)."</th>";
}
}
echo "</tr>";#4AA02C
//------------------------------------------------------OTHERS-----------------------------------
$sql_statement=" select (cr-dr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code between '19501' and '19599')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_19501=0;
$p_19501=$p_19501+$row['p_cr'];
echo "<tr colspan=5>";

echo "<th width=14% colspan=1 align=left bgcolor=#4E9258>(iv)Others (to be specified)</th>";
echo "<th width=5% rowspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_19501)."</th>";
}
}

$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code between '19501' and '19599')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_19501=0;
$c_19501=$c_19501+$row['c_cr'];
$o_19501=$c_19501+$p_19501;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_19501)."</th>";
}
}
echo "</tr>";

//----------------------------------------------------------TOTAL-----------------------------------------
$p10_total=$p_18103+$p_19100+$p_19600+$p_19501;
$c10_total=$o_18103+$o_19100+$o_19600+$o_19501;

echo "<tr bgcolor=#4AA02C colspan=5>";
echo "<th width=5% colspan=3>Total of Provision</th>";
echo "<th width=14% colspan=1>".amount2Rs((float)$p10_total)."</th>";
echo "<th width=11% colspan=1>".amount2Rs((float)$c10_total)."</th>";
echo "</tr>";

//--------------------------------------------------------------------------------------------------
$pg_total=$p1_total+$p2_total+$p_12302+$p4_total+$p5_total+$p6_total+$p7_total+$p_18920+$p_18930+$p10_total;
$cg_total=$c1_total+$c2_total+$c_12302+$c4_total+$c5_total+$c6_total+$c7_total+$c_18920+$c_18930+$c10_total;
echo "<tr bgcolor=#4AA02C colspan=5>";
echo "<th width=5% colspan=3>Total:</th>";
echo "<th width=14% colspan=1>".amount2Rs((float)$pg_total)."</th>";
echo "<th width=11% colspan=1>".amount2Rs((float)$cg_total)."</th>";
echo "</tr>";

echo "</table>";



//------------------------------------------------END OF LIBILITIES--------------------------------------------



//---------------------------------------ASSET--------------------------------------------------------------------

echo "<table align=left width=50% bgcolor=#817339 border=1>";
echo "<tr bgcolor=#4AA02C colspan=5>";
echo "<th width=5%>Sl No.</th>";
echo "<th width=14%>Asset</th>";
echo "<th width=11%>Breakup</th>";

echo "<th width=10%>31st March Previous Year</th>";
echo "<th width=10%>31st March Current Year</th>";
echo "</tr>";


//----------------------------------------------------------CASH IN HAND------------------------------
$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code='28101' or gl_mas_code='28102')) as foo"; 
//echo $sql_statement;

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_28101=0;
$p_28101=$p_28101+$row['p_cr'];
echo "<tr bgcolor=#4E9258>";
echo "<th width=5% colspan=1 bgcolor=#4E9258>1.</th>";
echo "<th width=14% colspan=2 align=left  bgcolor=#254117><font color=white>Cash in Hand</font></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_28101)."</th>";
}
}


$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code='28101' or gl_mas_code='28102')) as foo"; 
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_28101=0;
$c_28101=$c_28101+$row['c_cr'];
$o_28101=$c_28101+$p_28101;


echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_28101)."</th>";
}
}
echo "</tr>";
//-------------------------------------------------------------2.--------------------------------------
//------------------------------------------------------------BALANCES WITH DCC BANK ---------------------------
echo "<tr colspan=5>";
echo "<th width=5% rowspan=3 bgcolor=#4E9258>2.</th>";
echo "<th width=14% colspan=2 align=left bgcolor=#254117><font color=white>Balances with DCC Bank / SCB *</font></th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258></th>";
echo "</tr>";


//------------------------------------------------CURRENT ACCOUNT------------------------------------------

$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and gl_mas_code='28201') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_28201=0;
$p_28201=$p_28201+$row['p_cr'];
echo "<tr bgcolor=#4E9258>";

echo "<th width=11% colspan=1>i. Current Account</th>";
echo "<th width=11% colspan=1></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_28201)."</th>";
}
}

$sql_statement=" select (cr-dr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='28201') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_28201=0;
$c_28201=$c_28201+$row['c_cr'];
$o_28201=$c_28201+$p_28201;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_28201)."</th>";
}
}
echo "</tr>";
//-------------------------------------------------------SAVINGS ACCOUNT----------------------------------

$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and gl_mas_code='28202') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_28202=0;
$p_28202=$p_28202+$row['p_cr'];
echo "<tr bgcolor=#4E9258>";

echo "<th width=11% colspan=1>ii). Savings Account</th>";
echo "<th width=11% colspan=1></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_28202)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='28202') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_28202=0;
$c_28202=$c_28202+$row['c_cr'];
$o_28202=$c_28202+$p_28202;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_28202)."</th>";
}
}
echo "</tr>";
//-------------------------------------------------------------------------TOTAL------------------------------

$p21_total=$p_28201+$p_28202;
$c21_total=$o_28201+$o_28202;
echo "<tr bgcolor=#4AA02C colspan=5>";
echo "<th width=5% colspan=3>Total of SCB:</th>";
echo "<th width=14% colspan=1>".amount2Rs((float)$p21_total)."</th>";
echo "<th width=11% colspan=1>".amount2Rs((float)$c21_total)."</th>";
echo "</tr>";


//----------------------------------------------------------------------------3.-----------------------------------
//---------------------------------------------------------------BALANCES WITH OTHERS BANKS----------------------

echo "<tr colspan=5>";

echo "<th width=5% rowspan=3 bgcolor=#4E9258>3.</th>";
echo "<th width=14% colspan=2 align=left bgcolor=#254117><font color=white>Balances with Other Banks / Institutions</font></th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258></th>";
echo "</tr>";


//------------------------------------------------------------CURRENT ACCOUNT----------------------------------------


$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and gl_mas_code='28301') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_28301=0;
$p_28301=$p_28301+$row['p_cr'];
echo "<tr bgcolor=#4E9258>";

echo "<th width=11% colspan=1>i. Current Account</th>";
echo "<th width=11% colspan=1></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_28301)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='28301') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_28301=0;
$c_28301=$c_28301+$row['c_cr'];
$o_28301=$c_28301+$p_28301;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_28301)."</th>";
}
}
echo "</tr>";
//-----------------------------------------------------SAVINGS ACCOUNT------------------------------------------
$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and gl_mas_code='28302') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_28302=0;
$p_28302=$p_28302+$row['p_cr'];

echo "<tr bgcolor=#4E9258>";

echo "<th width=11% colspan=1>ii. Savings Account</th>";
echo "<th width=11% colspan=1></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_28302)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='28302') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_28302=0;
$c_28302=$c_28302+$row['c_cr'];
$o_28302=$c_28302+$p_28302;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_28302)."</th>";
}
}
echo "</tr>";
//-----------------------------------------------------------------TOTAL------------------------------------
$p31_total=$p_28301+$p_28302;
$c31_total=$o_28301+$o_28302;

echo "<tr bgcolor=#4AA02C colspan=5>";
echo "<th width=5% colspan=3>Total Balance of bank:</th>";
echo "<th width=14% colspan=1>".amount2Rs((float)$p31_total)."</th>";
echo "<th width=11% colspan=1>".amount2Rs((float)$c31_total)."</th>";
echo "</tr>";
///---------------------------------------------------------4.-----------------------------------------------


//--------------------------------------------------------INVESTMENTS-----------------------------------------------
echo "<tr colspan=5>";
echo "<th width=5% rowspan=12 bgcolor=#4E9258>4.</th>";
echo "<th width=14% colspan=2 align=left bgcolor=#254117><font color=white>Investments</font></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258></th>";
echo "</tr>";
//----------------------------------------------------------GOVERNMENT AND TRUSTEE SECURITIES-------------------------
$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and gl_mas_code='22701') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_22701=0;
$p_22701=$p_22701+$row['p_cr'];

echo "<tr bgcolor=#4E9258>";
echo "<th width=14% rowspan=1 align=left bgcolor=#4E9258>i. Government and Trustee Securities</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_22701)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='22701') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_22701=0;
$c_22701=$c_22701+$row['c_cr'];
$o_22701=$c_22701+$p_22701;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_22701)."</th>";
}
}
echo "</tr>";
//-------------------------------------------------------SHARES IN OTHERS COOPERATIVE INSTITUTIONS-------------

$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and gl_mas_code between '22101' and '22199') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_22101=0;
$p_22101=$p_22101+$row['p_cr'];

echo "<tr bgcolor=#4E9258>";
echo "<th width=14% colspan=1 align=left>ii. Shares in Other Cooperative Institutions(specify details in annexure)</th>";
echo "<th width=11% colspan=1></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_22101)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code between '22101' and '22199') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_22101=0;
$c_22101=$c_22101+$row['c_cr'];
$o_22101=$c_22101+$p_22101;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_22101)."</th>";
}
}
echo "</tr>";
//---------------------------------TERM DEPOSITS WITH DCCB/SCB(REPRESENTING RESERVE FUND)---------------------------



///----------------------------------------------------TERM DEPOSITS WITH DCCB/SCB (Annexure)-------------------

$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code='22201' or gl_mas_code='22202' or gl_mas_code between  '22301' and '22314' or gl_mas_code='22399')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_22201=0;
$p_22201=$p_22201+$row['p_cr'];

echo "<tr bgcolor=#4E9258>";
echo "<th width=11% colspan=1 align=left>iii. Term Deposits with DCCB/ SCB * representing Reserve Funds (Annexure)</th>";
echo "<th width=11% colspan=1></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_22201)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code='22201' or gl_mas_code='22202' or gl_mas_code between '22301' and '22314' or gl_mas_code='22399')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_22201=0;
$c_22201=$c_22201+$row['c_cr'];
$o_22201=$c_22201+$p_22201;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_22201)."</th>";
}
}
echo "</tr>";
//--------------------------------4------TERM DEPOSITS WITH DCCB/SCB (RESERVE FUND-------------------------
$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code between  '22401' and '22499')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_22401=0;
$p_22401=$p_22401+$row['p_cr'];

echo "<tr >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>iv. Term Deposits with DCCB / SCB* (other than
Reserve Funds)</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_22401)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code between  '22401' and '22499')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_22401=0;
$c_22401=$c_22401+$row['c_cr'];
$o_22401=$c_22401+$p_22401;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_22401)."</th>";
}
}
echo "</tr>";
//-----------------------------------------------------TERM DEPOSITS WITH OTHER BANKS-------------------------------
$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code between  '22501' and '22599')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_22501=0;
$p_22501=$p_22501+$row['p_cr'];

echo "<tr  >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>v. Term Deposits with other banks</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258 ></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_22501)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code between  '22501' and '22599')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_22501=0;
$c_22501=$c_22501+$row['c_cr'];
$o_22501=$c_22501+$p_22501;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_22501)."</th>";
}
}
echo "</tr>";
//-------------------------------------------------------NSC / KVP-------------------------------------------
$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and gl_mas_code='22601') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_22601=0;
$p_22601=$p_22601+$row['p_cr'];

echo "<tr  >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>vi. NSC / KVP</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_22601)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='22601') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_22601=0;
$c_22601=$c_22601+$row['c_cr'];
$o_22601=$c_22601+$p_22601;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_22601)."</th>";
}
}
echo "</tr>";
//-----------------------------------------------STAFF PF BALANCE WITH PF--------------------------

$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and gl_mas_code='22315') as foo"; 


$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;

		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_22315=0;
$p_22315=$p_22315+$row['p_cr'];

echo "<tr  >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>Vii).Staff PF balance with PF Trust / as deposit with Banks</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_22315)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='22315') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_22315=0;
$c_22315=$c_22315+$row['c_cr'];
$o_22315=$c_22315+$p_22315;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_22315)."</th>";
}
}
echo "</tr>";

//----------------------------------------------------------OTHERS---------------------------------------

$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and gl_mas_code='22901') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_22901=0;
$p_22901=$p_22901+$row['p_cr'];

echo "<tr  >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>viii. Others (Details in Annexure)</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_22901)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='22901') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_22901=0;
$c_22901=$c_22901+$row['c_cr'];
$o_22901=$c_22901+$p_22901;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_22901)."</th>";
}
}
echo "</tr>";

//------------------------------------------------------GROSS INVESTMENTS-----------------------------------
$p41a_total=$p_22701+$p_22101+$p_22201+$p_22401+$p_22501+$p_22601+$p_22315+$p_22901;
$c41a_total=$o_22701+$o_22101+$o_22201+$o_22401+$o_22501+$o_22601+$o_22315+$o_22901;
echo "<tr  >";
echo "<th width=14% colspan=1 bgcolor=#4AA02C align=left>(a) Gross Investments</th>";
echo "<th width=11% colspan=1 bgcolor=#4AA02C></th>";
echo "<th width=10% colspan=1 bgcolor=#4AA02C>".amount2Rs((float)$p41a_total)."</th>";
echo "<th width=10% colspan=1 bgcolor=#4AA02C>".amount2Rs((float)$c41a_total)."</th>";
echo "</tr>";
//-----------------------------------------------------LESS:PROVISION FOR DEPRECIATION IN-----------------
$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and gl_mas_code='19300') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_19300=0;
$p_19300=$p_19300+$row['p_cr'];

echo "<tr  >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>(b) Less: Provision for depreciation in the value of investment</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_19300)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='19300') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_19300=0;
$c_19300=$c_19300+$row['c_cr'];
$o_19300=$c_19300+$p_19300;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_19300)."</th>";
}
}
echo "</tr>";
//----------------------------------------------------------INVESTMENT NET OF PROVISIONS---------------------
$p41_total=$p41a_total-$p_19300;
$c41_total=$c41a_total-$o_19300;

echo "<tr  >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>(c) Investment net of provisions (a - b)</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4AA02C>".amount2Rs((float)$p41_total)."</th>";
echo "<th width=10% colspan=1 bgcolor=#4AA02C>".amount2Rs((float)$c41_total)."</th>";
echo "</tr>";
///-----------------------------------------------------------TOTAL-------------------------------------------
echo "<tr bgcolor=#4AA02C colspan=5>";
echo "<th width=5% colspan=3>Total of Investment:</th>";
echo "<th width=14% colspan=1>".amount2Rs((float)$p41_total)."</th>";
echo "<th width=11% colspan=1>".amount2Rs((float)$c41_total)."</th>";
echo "</tr>";

///----------------------------------------------------------------5.--------------------------------
echo "<tr colspan=5>";
echo "<th width=5% rowspan=16 bgcolor=#4E9258>5.</th>";
echo "<th width=14% colspan=2 align=left bgcolor=#254117><font color=white>Loans and Advances</font></th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";

echo "<th width=10% colspan=1 bgcolor=#4E9258></th>";
echo "</tr>";



//-------------------------------------------------------ST(SAO) LOANS/KCC LOANS--------------------------

$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code between '23101' and '23104')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_23101=0;
$p_23101=$p_23101+$row['p_cr'];

echo "<tr bgcolor=#4E9258>";
echo "<th width=11% colspan=1 align=left>i. ST (SAO) Loans / KCC Loans</th>";
echo "<th width=11% colspan=1></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_23101)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code between '23101' and '23104')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_23101=0;
$c_23101=$c_23101+$row['c_cr'];
$o_23101=$c_23101+$p_23101;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_23101)."</th>";
}
}
echo "</tr>";
//----------------------------------------------MEDIUM TERM/LONG TERM AGRICULTURAL LOANS----------------------------

$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code between '23205' and '23212')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_23205=0;

$p_23205=$p_23205+$row['p_cr'];

echo "<tr bgcolor=#4E9258>";
echo "<th width=14% colspan=1 align=left>ii. Medium Term / Long Term Agricultural Loans</th>";
echo "<th width=11% colspan=1></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_23205)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code between '23205' and '23212')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_23205=0;
$c_23205=$c_23205+$row['c_cr'];
$o_23205=$c_23205+$p_23205;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_23205)."</th>";
}
}
echo "</tr>";

//------------------------------------------------MT CONVERSION LOANS-------------------------------

$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code between '23201' and '23202')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_23201=0;
$p_23201=$p_23201+$row['p_cr'];

echo "<tr >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>iii. MT Conversion Loans</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_23201)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code between '23201' and '23202')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_23201=0;
$c_23201=$c_23201+$row['c_cr'];
$o_23201=$c_23201+$p_23201;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_23201)."</th>";
}
}
echo "</tr>";

//------------------------------------------------------MT/LT RESCHEDULEMENT-------------------------------
$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code between '23203' and '23204')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_23203=0;

$p_23203=$p_23203+$row['p_cr'];

echo "<tr >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>iv. MT /LT Reschedulement</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_23203)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code between '23203' and '23204')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_23203=0;
$c_23203=$c_23203+$row['c_cr'];
$o_23203=$c_23203+$p_23203;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_23203)."</th>";
}
}
echo "</tr>";
//---------------------------------------------------LOANS AGAINST PLEDGE OF AGRICULTURAL PRODUCE-----------------
$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code between '23105' and '23106')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_23105=0;

$p_23105=$p_23105+$row['p_cr'];

echo "<tr bgcolor=#4E9258>";
echo "<th width=11% colspan=1 align=left>v).Loans against pledge of agricultural produce</th>";
echo "<th width=11% colspan=1></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_23105)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code between '23105' and '23106')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_23105=0;
$c_23105=$c_23105+$row['c_cr'];
$o_23105=$c_23105+$p_23105;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_23105)."</th>";
}
}
echo "</tr>";
//----------------------------------------------------------------SHG LOANS-----------------------------
$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code='23113' or gl_mas_code='23114' or gl_mas_code='23213' or gl_mas_code='23214')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_23113=0;

$p_23113=$p_23113+$row['p_cr'];

echo "<tr bgcolor=#4E9258>";

echo "<th width=11% colspan=1 align=left>vi).SHG Loans</th>";
echo "<th width=11% colspan=1></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_23113)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code='23113' or gl_mas_code='23114' or gl_mas_code='23213' or gl_mas_code='23214')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_23113=0;
$c_23113=$c_23113+$row['c_cr'];
$o_23113=$c_23113+$p_23113;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_23113)."</th>";
}
}
echo "</tr>";

//-----------------------------------------------------------NON-FARM SECTOR LOANS---------------------
$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code='23215' or gl_mas_code='23216' or gl_mas_code='23303' or gl_mas_code='23304')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_23215=0;
$p_23215=$p_23215+$row['p_cr'];

echo "<tr bgcolor=#4E9258>";

echo "<th width=11% colspan=1 align=left>vii).Non-Farm Sector Loans</th>";
echo "<th width=11% colspan=1></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_23215)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code='23215' or gl_mas_code='23216' or gl_mas_code='23303' or gl_mas_code='23304')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_23215=0;
$c_23215=$c_23215+$row['c_cr'];
$o_23215=$c_23215+$p_23215;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_23215)."</th>";
}
}
echo "</tr>";
//---------------------------------------------------------LOANS AGAINST DEPOSIT--------------------

$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code='23115' or gl_mas_code='23116')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_23115=0;

$p_23115=$p_23115+$row['p_cr'];

echo "<tr bgcolor=#4E9258>";

echo "<th width=11% colspan=1 align=left>viii). Loans against Deposit</th>";
echo "<th width=11% colspan=1></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_23115)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code='23115' or gl_mas_code='23116')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_23115=0;
$c_23115=$c_23115+$row['c_cr'];
$o_23115=$c_23115+$p_23115;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_23115)."</th>";
}
}
echo "</tr>";
//-----------------------------------------------------LOANS FOR CONSUMER DURABLES----------------------
$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code='23217' or gl_mas_code='23218')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_23217=0;

$p_23217=$p_23217+$row['p_cr'];

echo "<tr bgcolor=#4E9258>";

echo "<th width=11% colspan=1 align=left>ix).LOANS FOR CONSUMER DURABLES</th>";
echo "<th width=11% colspan=1></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_23217)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code='23217' or gl_mas_code='23218')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_23217=0;
$c_23217=$c_23217+$row['c_cr'];
$o_23217=$c_23217+$p_23217;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_23217)."</th>";
}
}
echo "</tr>";
//--------------------------------------------------------GOLD LOANS-----------------------------------------
$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code='23501' or gl_mas_code='23502')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_23501=0;

$p_23501=$p_23501+$row['p_cr'];

echo "<tr  >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>x. Gold Loans</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_23501)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code='23501' or gl_mas_code='23502')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_23501=0;
$c_23501=$c_23501+$row['c_cr'];
$o_23501=$c_23501+$p_23501;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_23501)."</th>";
}
}
echo "</tr>";
//----------------------------------------------------------LOANS TO STAFF MEMBERS---------------------------
$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code='23401' or gl_mas_code='23402')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_23401=0;
$p_23401=$p_23401+$row['p_cr'];

echo "<tr  >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>xi. Loans To Staff Members</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_23401)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code='23401' or gl_mas_code='23402')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_23401=0;
$c_23401=$c_23401+$row['c_cr'];
$o_23401=$c_23401+$p_23401;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_23401)."</th>";
}
}
echo "</tr>";
//------------------------------------------------------------OTHERS LOANS------------------------------
$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code='23591' or gl_mas_code='23592' or gl_mas_code between  '22107' and '23112' or gl_mas_code='23600')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_23107=0;

$p_23107=$p_23107+$row['p_cr'];

echo "<tr bgcolor=#4E9258>";
echo "<th width=11% colspan=1 align=left>xii). Other Loans (to be specified</th>";
echo "<th width=11% colspan=1></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_23107)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code='23591' or gl_mas_code='23592' or gl_mas_code between  '22107' and '23112' or gl_mas_code='23600')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_23107=0;
$c_23107=$c_23107+$row['c_cr'];
$o_23107=$c_23107+$p_23107;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_23107)."</th>";
}
}
echo "</tr>";
//----------------------------------------------------------------TOTAL(I TO IX)---------------------------
$p51a_total=$p_23101+$p_23205+$p_23201_+$p_23203+$p_23105+$p_23113+$p_23215+$p_23115+$p_23217+$p_23501+$p_23401+$p_23107;
$c51a_total=$o_23101+$o_23205+$o_23201_+$o_23203+$o_23105+$o_23113+$o_23215+$o_23115+$o_23217+$o_23501+$o_23401+$o_23107;

echo "<tr  >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left><font color=white>(a) Total(i to xii)</font></th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p51a_total)."</th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$c51a_total)."</th>";
echo "</tr>";
//------------------------------------------------------------LESS:PROVISION FOR NPA---------------------

$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code between  '19201' and '19204')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_19201=0;

$p_19201=$p_19201+$row['p_cr'];

echo "<tr  >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>(b) Less: Provision for NPA</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_19201)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code between  '19201' and '19204')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_19201=0;
$c_19201=$c_19201+$row['c_cr'];
$o_19201=$c_19201+$p_19201;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_19201)."</th>";
}
}
echo "</tr>";
//------------------------------------------------------LOANS AND ADVANCES NET OF PROVISIONS-----------------
$p51_total=$p51a_total+$p_19201;
$c51_total=$c51a_total+$o_19201;

echo "<tr  >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>(c)Loans and Advances net of provisions (a - b)</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p51_total)."</th>";

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$c51_total)."</th>";
echo "</tr>";

///------------------------------------------------------------TOTAL-------------------------------
echo "<tr bgcolor=#4AA02C colspan=5>";
echo "<th width=5% colspan=3>Total:</th>";
echo "<th width=14% colspan=1>".amount2Rs((float)$p51_total)."</th>";
echo "<th width=11% colspan=1>".amount2Rs((float)$c51_total)."</th>";
echo "</tr>";

//------------------------------------------------------------------6.------------------------------------------------
echo "<tr colspan=5>";
echo "<th width=5% rowspan=10 bgcolor=#4E9258>6.</th>";
echo "<th width=14% colspan=2 align=left bgcolor=#254117><font color=white>Closing Stocks</font></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258></th>";
echo "</tr>";
//-----------------------------------------------AGRICULTURAL INPUTS--------------------------------------

$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code between  '26111' and '26119')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_26111=0;
$p_26111=$p_26111+$row['p_cr'];

echo "<tr bgcolor=#4E9258>";
echo "<th width=14% rowspan=1 align=left bgcolor=#4E9258>i. Agricultural Inputs (fertilisers, seeds and pesticides</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_26111)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code between  '26111' and '26119')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_26111=0;
$c_26111=$c_26111+$row['c_cr'];
$o_26111=$c_26111+$p_26111;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_26111)."</th>";
}
}
echo "</tr>";
//-------------------------------------------PUBLIC DISTRIBUTIONS SYSTEM COMMODITIES----------------------------
$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and gl_mas_code='26141') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_26141=0;
$p_26141=$p_26141+$row['p_cr'];

echo "<tr bgcolor=#4E9258>";
echo "<th width=14% colspan=1 align=left>ii. Public Distribution System Commodities</th>";
echo "<th width=11% colspan=1></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_26141)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='26141') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_26141=0;
$c_26141=$c_26141+$row['c_cr'];
$o_26141=$c_26141+$p_26141;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_26141)."</th>";
}
}
echo "</tr>";
//-----------------------------------------------NON-PDS CONSUMERS ITEMS-------------------------------

$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code between  '26142' and '26149')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_26142=0;
$p_26142=$p_26142+$row['p_cr'];

echo "<tr >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>iii. Non-PDS Consumer Items</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_26142)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code between  '26142' and '26149')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_26142=0;
$c_26142=$c_26142+$row['c_cr'];
$o_26142=$c_26142+$p_26142;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_26142)."</th>";
}
}
echo "</tr>";
//--------------------------------------------FOOD GRAINS AND OTHERS COMMODITies------------------
$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and gl_mas_code='26161') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_26161=0;
$p_26161=$p_26161+$row['p_cr'];

echo "<tr >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>iv. Food grains and other Commodities under Procurement Scheme</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_26161)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='26161') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_26161=0;
$c_26161=$c_26161+$row['c_cr'];
$o_26161=$c_26161+$p_26161;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_26161)."</th>";
}
}
echo "</tr>";
//---------------------------------------MATERIAL UNDER MID-DAY MEALS SCHEME------------------------------
$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and gl_mas_code='26171') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_26171=0;
$p_26171=$p_26171+$row['p_cr'];

echo "<tr  >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>v. Materials under Mid-day Meals Scheme</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258 ></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_26171)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='26171') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_26171=0;
$c_26171=$c_26171+$row['c_cr'];
$o_26171=$c_26171+$p_26171;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_26171)."</th>";
}
}
echo "</tr>";
//------------------------------------ANY OTHER STOCKS/WORK-IN-PROGRESS/GOODS-----------------------------------

$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code='26121' or gl_mas_code='26151' or gl_mas_code='26191' or gl_mas_code between '26131' and '26139' or gl_mas_code between '26201' and '26204' or gl_mas_code='26301')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_26121=0;
$p_26121=$p_26121+$row['p_cr'];

echo "<tr  >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>vi. Any other stocks/ work-in-progress/goods (itemwise details in annexure</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258 ></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_26121)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code='26121' or gl_mas_code='26151' or gl_mas_code='26191' or gl_mas_code between '26131' and '26139' or gl_mas_code between '26201' and '26204' or gl_mas_code='26301')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_26121=0;
$c_26121=$c_26121+$row['c_cr'];
$o_26121=$c_26121+$p_26121;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_26121)."</th>";
}
}
echo "</tr>";
//---------------------------------------------------------------------TOTAL-------------------------------------
$p61a_total=$p_26111+$p_26141+$p_26142+$p_26161+$p_26171+$p_26121;
$c61a_total=$o_26111+$o_26141+$o_26142+$o_26161+$o_26171+$o_26121;

echo "<tr  >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left><font color=white>(a) Total ( i to vi)</font></th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258 ></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p61a_total)."</th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$c61a_total)."</th>";
echo "</tr>";
//---------------------------------------------------------------LESS:REDUCTION FOR VALUE OF SHORTAGE-----------

$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code='13201' or gl_mas_code='13205' or gl_mas_code='13202' or gl_mas_code='13203' or gl_mas_code='13204' or gl_mas_code='13206')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_132011=0;
$p_132011=$p_132011+$row['p_cr'];

echo "<tr  >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>(b) Less: Provision for NPA</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_132011)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code='13201' or gl_mas_code='13205' or gl_mas_code='13202' or gl_mas_code='13203' or gl_mas_code='13204' or gl_mas_code='13206')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_132011=0;
$c_132011=$c_132011+$row['c_cr'];
$o_132011=$c_132011+$p_132011;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_132011)."</th>";
}
}
echo "</tr>";
//-----------------------------------------------------------NET CLOSING STOCK---------------------------------
$p61_total=$p61a_total+$p_132011;
$c61_total=$c61a_total+$o_132011;
echo "<tr  >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left><font color=white>(c) Net closing stock (a) - (b)</font></th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258 ></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p61_total)."</th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$c61_total)."</th>";
echo "</tr>";
//----------------------------------------------------------TOTAL-----------------------------------------------
echo "<tr bgcolor=#4AA02C colspan=5>";
echo "<th width=5% colspan=3>Total:</th>";
echo "<th width=14% colspan=1>".amount2Rs((float)$p61_total)."</th>";
echo "<th width=11% colspan=1>".amount2Rs((float)$c61_total)."</th>";
echo "</tr>";

///--------------------------------------------------------------------------7.-----------------------------

echo "<tr colspan=5>";
echo "<th width=5% rowspan=5 bgcolor=#4E9258>7.</th>";
echo "<th width=14% colspan=2 align=left bgcolor=#254117><font color=white>Fixed Assets (net of depreciation as per Depreciation Chart)</font></th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258></th>";
echo "</tr>";

///-------------------------------------------------LAND AND BUILDINGS/GODOWNS----------------------------
$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code between  '21101' and '21106')) as foo"; 
//echo "$sql_statement";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_21101=0;
$p_21101=$p_21101+$row['p_cr'];

echo "<tr bgcolor=#4E9258>";
echo "<th width=11% colspan=1 align=left>i).Land and Buildings / Godowns</th>";
echo "<th width=11% colspan=1></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_21101)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code between  '21101' and '21106')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_21101=0;
$c_21101=$c_21101+$row['c_cr'];
$o_21101=$c_21101+$p_21101;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_21101)."</th>";
}
}
echo "</tr>";
//-------------------------------------------FURNITURE AND FIXTURES--------------------------------------------

$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code between  '21107' and '21199' or gl_mas_code='21201' or gl_mas_coe='21202')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_21107=0;
$p_21107=$p_21107+$row['p_cr'];

echo "<tr bgcolor=#4E9258>";
echo "<th width=11% colspan=1 align=left>ii).Furniture and Fixtures</th>";
echo "<th width=11% colspan=1></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_21107)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code between  '21107' and '21199' or gl_mas_code='21201' or gl_mas_coe='21202')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_21107=0;
$c_21107=$c_21107+$row['c_cr'];
$o_21107=$c_21107+$p_21107;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_21107)."</th>";
}
}
echo "</tr>";
//----------------------------------------------------COMPUTERS AND ELECTRICAL INSTALLATIONS-----------------------
$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code between  '21203' and '21204')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_21203=0;
$p_21203=$p_21203+$row['p_cr'];

echo "<tr bgcolor=#4E9258>";
echo "<th width=11% colspan=1 align=left>iii). Computers and Electrical Installations</th>";
echo "<th width=11% colspan=1></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_21203)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code between  '21203' and '21204')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_21203=0;
$c_21203=$c_21203+$row['c_cr'];
$o_21203=$c_21203+$p_21203;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_21203)."</th>";
}
}
echo "</tr>";
//--------------------------------------------------------------VEHICLES--------------------------------------

$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and gl_mas_code='21301') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_21301=0;
$p_21301=$p_21301+$row['p_cr'];

echo "<tr >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>iv. Vehicles</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_21301)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='21301') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_21301=0;
$c_21301=$c_21301+$row['c_cr'];
$o_21301=$c_21301+$p_21301;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_21301)."</th>";
}
}
echo "</tr>";
//------------------------------------------------------------OTHERS-------------------------------------

$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code between  '21302' and '21399' or gl_mas_code='21401' or gl_mas_code='21501')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_21302=0;
$p_21302=$p_21302+$row['p_cr'];

echo "<tr  >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>v. Others (to be specified)</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258 ></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_21302)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code between  '21302' and '21399' or gl_mas_code='21401' or gl_mas_code='21501')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_21302=0;
$c_21302=$c_21302+$row['c_cr'];
$o_21302=$c_21302+$p_21302;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_21302)."</th>";
}
}
echo "</tr>";
//-------------------------------------------------------------TOTAL-----------------------------------
$p71_total=$p_21101+$p_21107+$p_21203+$p_21301+$p_21302;
$c71_total=$o_21101+$o_21107+$o_21203+$o_21301+$o_21302;

echo "<tr bgcolor=#4AA02C colspan=5>";
echo "<th width=5% colspan=3>Total:</th>";
echo "<th width=14% colspan=1>".amount2Rs((float)$p71_total)."</th>";
echo "<th width=11% colspan=1>".amount2Rs((float)$c71_total)."</th>";
echo "</tr>";

//---------------------------------------------------------------------------8.--------------------------------------
echo "<tr colspan=5>";
echo "<th width=5% rowspan=20 bgcolor=#4E9258>8.</th>";
echo "<th width=14% colspan=2 align=left bgcolor=#254117><font color=white>Other Assets</font></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258></th>";
echo "</tr>";
//---------------------------------------------------INTEREST ACCRUED AND RECEIVABLE-----------------------------

echo "<tr bgcolor=#4E9258>";
echo "<th width=14% rowspan=1 align=left bgcolor=#4E9258>1 (a) Interest Accrued and Receivable (i to iii)</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258></th>";
echo "</tr>";
//-------------------------------------------INTEREST ACCRUED BUT NOT DUE ON STANDARD LOANS----------------------
$sql_statement="select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code='25103' or gl_mas_code='25105' or gl_mas_code='25107' or gl_mas_code='25109' or gl_mas_code='25115' or gl_mas_code='25207' or gl_mas_code='25213')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);

$p_25103=0;
$p_25103=$p_25103+$row['p_cr'];
echo "<tr bgcolor=#4E9258>";
echo "<th width=14% colspan=1 align=left>i. Interest Accrued but not due on Standard Loans</th>";
echo "<th width=11% colspan=1></th>";
echo "<th width=10% colspan=1>".amount2Rs((float)$p_25103)."</th>";
}
}
$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code='25103' or gl_mas_code='25105' or gl_mas_code='25107' or gl_mas_code='25109' or gl_mas_code='25115' or gl_mas_code='25207' or gl_mas_code='25213')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_25103=0;
$c_25103=$c_25103+$row['c_cr'];
$o_25103=$c_25103+$p_25103;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_25103)."</th>";
}
}
echo "</tr>";
//-------------------------------------------------INTEREST ACCRUED BUT NOT DUE ON NPA LOANS-------------
$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and  gl_mas_code='25600') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);


$p_25600=0;
$p_25600=$p_25600+$row['p_cr'];

echo "<tr >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>ii. Interest accrued but not due on NPA Loans</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_25600)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='25600') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_25600=0;
$c_25600=$c_25600+$row['c_cr'];
$o_25600=$c_25600+$p_25600;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_25600)."</th>";
}
}
echo "</tr>";
//-----------------------------------------------OVERDUE INTEREST RECEIVABLE---------------------------------------
$sql_statement="select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code='25102' or gl_mas_code='25104' or gl_mas_code='25106' or gl_mas_code='25108' or gl_mas_code='25114' or gl_mas_code='25206' or gl_mas_code='25212')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);

$p_25102=0;
$p_25102=$p_25102+$row['p_cr'];
echo "<tr bgcolor=#4E9258>";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>iii. Overdue interest receivable</th>";
echo "<th width=11% colspan=1></th>";
echo "<th width=10% colspan=1>".amount2Rs((float)$p_25102)."</th>";
}
}
$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code='25102' or gl_mas_code='25104' or gl_mas_code='25106' or gl_mas_code='25108' or gl_mas_code='25114' or gl_mas_code='25206' or gl_mas_code='25212')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_25102=0;
$c_25102=$c_25102+$row['c_cr'];
$o_25102=$c_25102+$p_25102;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_25102)."</th>";
}
}
echo "</tr>";


//-------------------------------------------LESS:PROVISION FOR OVERDUE INTEREST-------------------------
$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and  gl_mas_code='19401') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_19401=0;
$p_19401=$p_19401+$row['p_cr'];

echo "<tr  >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>1(b) Less: Provision for overdue interest</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258 ></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_19401)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='19401') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_19401=0;
$c_19401=$c_19401+$row['c_cr'];
$o_19401=$c_19401+$p_19401;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_19401)."</th>";
}
}
echo "</tr>";
//-------------------------------NET INTEREST ACCRUED AND RECEIVABLE------------------------
$p81a_total=$p_25103+$p_25600+$p_25102-$p_19401;
$o81a_total=$o_25103+$o_25600+$o_25102-$o_19401;

echo "<tr  >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left><font color=white>1(c) Net interest Accrued and Receivable (a) - (b)</font></th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258 ></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p81a_total)."</th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o81a_total)."</th>";
echo "</tr>";
//--------------------------------------------INTEREST RECEIVABLE ON INVESTMENTS--------------------------------
$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and  (gl_mas_code between '24104' and '24901')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_24104=0;
$p_24104=$p_24104+$row['p_cr'];

echo "<tr  >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>2(a) Interest receivable on Investments</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258 ></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_24104)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code between '24104' and '24901')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_24104=0;
$c_24104=$c_24104+$row['c_cr'];
$o_24104=$c_24104+$p_24104;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_24104)."</th>";
}
}
echo "</tr>";
//---------------------------------------------LESS:PROVISION FOR OVERDUE INTEREST ON INVESTMENTS--------------------

$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and gl_mas_code='19402') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_19402=0;
$p_19402=$p_19402+$row['p_cr'];

echo "<tr  >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>2(b) Less : Provision for overdue interest on investments</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258 ></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_19402)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='19402') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_19402=0;
$c_19402=$c_19402+$row['c_cr'];
$o_19402=$c_19402+$p_19402;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_19402)."</th>";
}
}
echo "</tr>";

//---------------------------------------------NET INTEREST RECEIVABLE ON INVESTMENTS---------------------------
$p81b_total=$p_24104-$p_19402;
$c81b_total=$o_24104-$o_19402;


echo "<tr  >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left><font color=white>2(c) Net Interest receivable on investments (a) - (b)</font></th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258 ></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p81b_total)."</th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$c81b_total)."</th>";
echo "</tr>";
//-------------------------------------------------------MISCELLANEOUS INCOME RECEIVABLE----------------
$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and  (gl_mas_code between '27101' and '27139' or gl_mas_code='27150' or gl_mas_code='27190')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_27101=0;
$p_27101=$p_27101+$row['p_cr'];

echo "<tr  >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>3. Miscellaneous Income Receivable</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258 ></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_27101)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code between '27101' and '27139' or gl_mas_code='27150' or gl_mas_code='27190')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_27101=0;
$c_27101=$c_27101+$row['c_cr'];
$o_27101=$c_27101+$p_27101;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_27101)."</th>";
}
}
echo "</tr>";
//--------------------------------------------------------SUNDRY DEBTORS---------------------------
$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and  (gl_mas_code between '27141' and '27144')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_27141=0;
$p_27141=$p_27141+$row['p_cr'];

echo "<tr  >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>4(a) Sundry debtors (for credit sales)</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258 ></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_27141)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code between '27141' and '27144')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_27141=0;
$c_27141=$c_27141+$row['c_cr'];
$o_27141=$c_27141+$p_27141;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_27141)."</th>";
}
}
echo "</tr>";
//--------------------------------LESS:PROVISION FOR BAD AND DOUBTFUL SUNDRY DEBTORS--------------------
$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and  gl_mas_code='19501') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_19501=0;
$p_19501=$p_19501+$row['p_cr'];

echo "<tr  >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>4(b) Less: Provision for bad and doubtful Sundry Debtors (for credit sales)</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258 ></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_19501)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='19501') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_19501=0;
$c_19501=$c_19501+$row['c_cr'];
$o_19501=$c_19501+$p_19501;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_19501)."</th>";
}
}
echo "</tr>";
//--------------------------NET SUNDRY DEBTORS FOR CREDIT SALES----------------------------------------
$p81d_total=$p_27141-$p_19501;
$c81d_total=$o_27141-$o_19501;

echo "<tr  >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left><font color=white>4(c) Net Sundry debtors for credit sales (net of provision i.e. (a)-(b))</font></th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258 ></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p81d_total)."</th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$c81d_total)."</th>";
echo "</tr>";
//----------------------------------------------------SUNDRY DEBTORS(OTHERS)--------------------------------
$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code between '27211' and '27215')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_27211=0;
$p_27211=$p_27211+$row['p_cr'];

echo "<tr  >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>5 (a) Sundry debtors (others) - details in annexure</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258 ></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_27211)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code between '27211' and '27215')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_27211=0;
$c_27211=$c_27211+$row['c_cr'];
$o_27211=$c_27211+$p_27211;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_27211)."</th>";
}
}
echo "</tr>";

//-------------------------------------------LESS:PROVISION FOR BAD DOUBTFUL SUNDRYDEBTORS------------------------------

$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and gl_mas_code='19599') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_19599=0;
$p_19599=$p_19599+$row['p_cr'];

echo "<tr  >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>5(b) Less : Provision for bad and doubtful sundrydebtors (others</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258 ></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_19599)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and gl_mas_code='19599') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_19599=0;
$c_19599=$c_19599+$row['c_cr'];
$o_19599=$c_19599+$p_19599;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_19599)."</th>";
}
}
echo "</tr>";
//---------------------------------------------------NET SUNDRY DEBTORS(OTHERS)--------------
$p81e_total=$p_27211-$p_19599;
$c81e_total=$o_27211-$o_19599;

echo "<tr  >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left><font color=white>5(c) Net Sundry Debtors (others) (a - b)</font></th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258 ></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p81e_total)."</th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$c81e_total)."</th>";
echo "</tr>";
//---------------------------------------------------------PREPAID EXPENSES-----------------------

$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and  gl_mas_code='27201') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_27201=0;
$p_27201=$p_27201+$row['p_cr'];

echo "<tr  >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>6. Prepaid expenses</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258 ></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_27201)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and  gl_mas_code='27201') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_27201=0;
$c_27201=$c_27201+$row['c_cr'];
$o_27201=$c_27201+$p_27201;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_27201)."</th>";
}
}
echo "</tr>";
//-----------------------------------------------------TAX DEDUCTED AT SOURCE-------------------------------
$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and  gl_mas_code='27216') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_27216=0;
$p_27216=$p_27216+$row['p_cr'];

echo "<tr  >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>7. Tax Deducted at source</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258 ></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_27216)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and  gl_mas_code='27216') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_27216=0;
$c_27216=$c_27216+$row['c_cr'];
$o_27216=$c_27216+$p_27216;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_27216)."</th>";
}
}
echo "</tr>";
//--------------------------------------------------------------OTHERS------------------------------

$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and (gl_mas_code between  '28203' and '28299' or gl_mas_code between '28303' and '28399' or gl_mas_code='29100' or gl_mas_code='27220')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_27220=0;
$p_27220=$p_27220+$row['p_cr'];

echo "<tr  >";
echo "<th width=14% colspan=1 bgcolor=#4E9258 align=left>8. Others</th>";
echo "<th width=11% colspan=1 bgcolor=#4E9258 ></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_27220)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and (gl_mas_code between  '28203' and '28299' or gl_mas_code between '28303' and '28399' or gl_mas_code='29100' or gl_mas_code='27220')) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_27220=0;
$c_27220=$c_27220+$row['c_cr'];
$o_27220=$c_27220+$p_27220;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_27220)."</th>";
}
}
echo "</tr>";
//--------------------------------------------------------------TOTAL----------------------------------
$p81_total=$p81a_total+$p81b_total+$p_27101+$p81d_total+$p81e_total+$p_27201+$p_27216+$p_27220;
$c81_total=$c81a_total+$c81b_total+$o_27101+$c81d_total+$c81e_total+$o_27201+$o_27216+$o_27220;
echo "<tr bgcolor=#4AA02C colspan=5>";
echo "<th width=5% colspan=3>Total:</th>";
echo "<th width=14% colspan=1>".amount2Rs((float)$p81_total)."</th>";
echo "<th width=11% colspan=1>".amount2Rs((float)$c81_total)."</th>";
echo "</tr>";

//---------------------------------------------------------------------------------9.--------------------

$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and  gl_mas_code='27160') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_27160=0;
$p_27160=$p_27160+$row['p_cr'];

echo "<tr colspan=5>";
echo "<th width=5% colspan=1 bgcolor=#4E9258>9.</th>";
echo "<th width=14% colspan=2 align=left bgcolor=#254117><font color=white>Bills Receivable (as per contra)</font></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_27160)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and  gl_mas_code='27160') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_27160=0;
$c_27160=$c_27160+$row['c_cr'];
$o_27160=$c_27160+$p_27160;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_27160)."</th>";
}
}
echo "</tr>";
//-----------------------------------------------------------------------------------10.-------------------------
$sql_statement=" select (dr-cr) as p_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<=date('$start_date')-INTERVAL '1 year' and  gl_mas_code='27170') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_27170=0;
$p_27170=$p_27170+$row['p_cr'];

echo "<tr bgcolor=#4E9258>";
echo "<th width=11% colspan=1>10.</th>";
echo "<th width=14% colspan=2 align=left  bgcolor=#254117><font color=white>Branch Adjustments accounts</font></th>";
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_27170)."</th>";
}
}

$sql_statement=" select (dr-cr) as c_cr from (select sum(credit) as cr,sum(debit) as dr from mas_gl_tran where action_date<='$start_date' and action_date>='$f_start_dt' and  gl_mas_code='27170') as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_27170=0;
$c_27170=$c_27170+$row['c_cr'];
$o_27170=$c_27170+$p_27170;

echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_27170)."</th>";
}
}
echo "</tr>";
//--------------------------------------------------------------------------------------11.--------------------
$sql_statement="SELECT '12302' as gl_mas_code, 'Profit & Loss' as gl_mas_desc,SUM(debit) as debit,SUM(credit) as cedit,SUM(credit-debit) as bal FROM (SELECT a.gl_mas_code,SUM(debit) as debit,SUM(credit) as credit,bs_pl from mas_gl_tran a,gl_master_vw b WHERE action_date<=date('$start_date')-INTERVAL '1 year' AND a.gl_mas_code=b.gl_mas_code group by a.gl_mas_code,bs_pl HAVING bs_pl='S' OR bs_pl='I' OR bs_pl='P' OR bs_pl='E') as foo";

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$p_123021=0;
$p_123021=$p_123021+$row['bal'];




echo "<tr colspan=5>";
echo "<th width=5% rowspan=1 bgcolor=#4E9258>11.</th>";
echo "<th width=14% colspan=2 align=left bgcolor=#254117><font color=white>Profit and Loss Account (if balance is loss)</th>";
//echo "<th width=10% colspan=1 bgcolor=#4E9258></th>";
if($p_123021<0){
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_123021)."</th>";
}
else
{
$p_123021=0;
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$p_123021)."</th>";
}
}
}
$sql_statement="SELECT '12302' as gl_mas_code, 'Profit & Loss' as gl_mas_desc,SUM(debit) as debit,SUM(credit) as cedit,SUM(credit-debit) as bal FROM (SELECT a.gl_mas_code,SUM(debit) as debit,SUM(credit) as credit,bs_pl from mas_gl_tran a,gl_master_vw b WHERE action_date<='$start_date' and action_date>='$f_start_dt'  AND a.gl_mas_code=b.gl_mas_code group by a.gl_mas_code,bs_pl HAVING bs_pl='S' OR bs_pl='I' OR bs_pl='P' OR bs_pl='E') as foo";

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$c_123021=0;
$c_123021=$c_123021+$row['bal'];
$o_123021=$c_123021+$p_123021;
if($o_123021<0){
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_123021)."</th>";
}
else{
$o_123021=0;
echo "<th width=10% colspan=1 bgcolor=#4E9258>".amount2Rs((float)$o_123021)."</th>";
}
}
}
echo "</tr>";


//----------------------------------------------------------TOTAL---------------------------------------------------

$gptotal=$p_28101+$p21_total+$p31_total+$p41_total+$p51_total+$p61_total+$p71_total+$p81_total+$p_27160+$p_27170+$p_12301;
$gctotal=$o_28101+$c21_total+$c31_total+$c41_total+$c51_total+$c61_total+$c71_total+$c81_total+$o_27160+$o_27170+$o_12301;
echo "<tr bgcolor=#4AA02C colspan=5>";
echo "<th width=5% colspan=3>Total</th>";
echo "<th width=14% colspan=1>".amount2Rs((float)$gptotal)."</th>";
echo "<th width=11% colspan=1>".amount2Rs((float)$gctotal)."</th>";
echo "</table>";



echo "</body>";
echo "</html>";
?>
