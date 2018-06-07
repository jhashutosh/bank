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




$sql_statement="SELECT count(account_no) AS no_pshare,sum(amount) AS share_pvalue from report_vw WHERE (action_date<'$f_start_dt' and '$f_start_dt'-action_date>0) and type='sh'";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){


echo "<table bgcolor=\"#AF7817\" width=\"10%\" align=\"CENTER\">";

echo "<tr><th colspan=\"14\" bgcolor=green><font color=white size=2> CURRENT BALANCE IN A PARTICULAR DAY </th>";
echo "<tr>";

$color="#CCCCC5555";
echo "<th rowspan=\"2\" bgcolor=\"$color\">Types of Loan</th>";
echo "<th colspan=\"4\" bgcolor=\"$color\">OPENING BALANCE 1st APRIL</th>";
echo "<th colspan=\"5\" bgcolor=\"$color\">TODAY BALANCE</th>";
echo "<th colspan=\"5\" bgcolor=\"$color\">AMOUNT RETURN</th>";

echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\">NO OF ACCOUNT</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">PRINCIPAL</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">DUE</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">OVER DUE</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">NO OF ACCOUNT</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">PRINCIPAL</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">DUE INTEREST</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">OVER DUE INTREST</th>";
//echo "<th colspan=\"1\" bgcolor=\"$color\">TOTAL</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">NO OF ACCOUNT</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">PRINCIPAL</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">DUE INTREST</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">OVER DUE INTEREST</th>";
echo "<th colspan=\"1\" bgcolor=\"$color\">TOTAL</th>";
//======================================kcc previous year========================================

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$sh_ac=0;
$sh_ac=$sh_ac+$row['no_pshare'];
$sh_val=0;
$sh_val=$sh_val+$row['share_pvalue'];
echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"green\">SHARE</th>";

echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$sh_ac</td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$sh_val.00</td>";
}
}
$sql_statement="select sum(loan_amount) as tp_kcc from loan_statement where account_no like 'KCC-%' and action_date<='$f_start_dt'"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);

echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2Rs($row['tp_kcc'])."</td>";

}
}
//echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".$row['p_kcc']."</td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"><A HREF=\"list_of_loan_p.php?menu=kcc&op=d\">Kcc Due List</A></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"><A HREF=\"list_of_loan_p1.php?menu=kcc&op=o\">Kcc Overdue List</A></td>";

//=======================================kcc by date=========================================================

$sql_statement=" select count(account_no) as no_c_kcc from  customer_account where account_no like 'KCC-%' and opening_date
<='$start_date'"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$kcc_c=0;
$kcc_c=$kcc_c+$row['no_c_kcc'];
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$kcc_c</td>";
}
}


echo "<td colspan=\"1\" bgcolor=\"$color\"><A HREF=\"list_of_loan.php?menu=kcc&op=d\">Kcc Due List</A></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"><A HREF=\"list_of_loan1.php?menu=kcc&op=o\">Kcc Overdue List</A></td>";
//echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".$row['todue_kcc']."</td>";
     //echo $total="$row['tp_kcc']+$row['tdue_kcc']+$row['todue_kcc']";
//echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".($row['tp_kcc']+$row['tdue_kcc']+$row['todue_kcc'])."</td>";

//===========================kcc amount return============================================================
$sql_statement="  select count(count) as kcc_r,sum(d) as kcc_d_r,sum(o) as kcc_o_r,sum(p) as kcc_p_r from (SELECT count(account_no) as count,SUM(r_due_int) as d,SUM(r_overdue_int) as o,SUM(r_principal) as p FROM loan_statement WHERE tr_type='R' AND (action_date BETWEEN '1980/01/01' AND current_date) AND account_no LIKE 'KCC%' GROUP BY account_no HAVING (SUM(r_due_int)>0 OR SUM(r_overdue_int)>0 OR SUM(r_principal)>0)) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);

echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".$row['kcc_r']."</td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".$row['kcc_p_r']."</td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".$row['kcc_d_r']."</td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".$row['kcc_o_r']."</td>";
//echo $total="$row['tp_kcc']+$row['tdue_kcc']+$row['todue_kcc']";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2Rs($row['kcc_p_r']+$row['kcc_o_r']+$row['kcc_d_r'])."</td>";
}
}

//===========================MT previous year============================================================

$sql_statement=" select count(account_no) as no_p_mt  from  customer_account where account_no like 'MT-%' and opening_date<'$f_start_dt'"; 
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);


echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\">MT</th>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".$row['no_p_mt']."</td>";
}
}
$sql_statement="select sum(loan_amount) as tp_mt from loan_statement where account_no like 'MT-%' and action_date<='$f_start_dt'"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);

echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2Rs($row['tp_mt'])."</td>";
}
}
echo "<td colspan=\"1\" bgcolor=\"$color\"><A HREF=\"list_of_loan_p.php?menu=mt&op=d\">Mt Due List</A></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"><A HREF=\"list_of_loan__p1.php?menu=mt&op=o\">Mt Overdue List</A></td>";

//=============================================MT loan by day==============================================

$sql_statement=" select count(account_no) as no_c_mt  from  customer_account where account_no like 'MT-%' and opening_date
<='$start_date'"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$mt_c=0;
$mt_c=$mt_c+$row['no_c_mt'];
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$mt_c</td>";
}
}


$sql_statement=" SELECT sum(loan_amount) as tp_mt FROM loan_statement WHERE action_date<='$start_date' and account_no LIKE 'MT-%'"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);


echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2Rs($row['tp_mt'])."</td>";
}
}
echo "<td colspan=\"1\" bgcolor=\"$color\"><A HREF=\"list_of_loan.php?menu=mt&op=d\">Mt Due List</A></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"><A HREF=\"list_of_loan1.php?menu=mt&op=o\">Mt Overdue List</A></td>";
//echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2RS($row['tp_mt']+$row['tdue_mt']+$row['todue_mt'])."</td>";

//=====================================Mt amount return==============================================
$sql_statement=" select count(count) as mt_r,sum(d) as mt_d_r,sum(o) as mt_o_r,sum(p) as mt_p_r from (SELECT count(account_no) as count,SUM(r_due_int) as d,SUM(r_overdue_int) as o,SUM(r_principal) as p FROM loan_statement WHERE tr_type='R' AND (action_date BETWEEN '1980/01/01' AND current_date) AND account_no LIKE 'MT%' GROUP BY account_no HAVING (SUM(r_due_int)>0 OR SUM(r_overdue_int)>0 OR SUM(r_principal)>0)) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);


echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".$row['mt_r']."</td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2Rs($row['mt_p_r'])."</td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2Rs($row['mt_d_r'])."</td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2Rs($row['mt_o_r'])."</td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2RS($row['mt_p_r']+$row['mt_d_r']+$row['mt_o_r'])."</td>";
}
}
//====================================cash credit previous year======================================

$sql_statement=" select count(account_no) as no_p_cc from  customer_account where account_no like 'CCL-%' and opening_date<'$f_start_dt'"; 
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);



echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\">CASH CREDIT</th>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".$row['no_p_cc']."</td>";
}
}

$sql_statement="select sum(loan_amount) as tp_cc from loan_statement where account_no like 'CCL-%' and action_date<='$f_start_dt'"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);

echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2Rs($row['tp_cc'])."</td>";
}
}

echo "<td colspan=\"1\" bgcolor=\"$color\"><A HREF=\"list_of_loan_p.php?menu=ccl&op=d\">Cash Credit Due List</A></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"><A HREF=\"list_of_loan_p1.php?menu=ccl&op=o\">Cash Overdue List</A></td>";

//==============================cash credit balance day=============================================

$sql_statement=" select count(account_no) as no_c_cc  from  customer_account where account_no like 'CCL-%' and opening_date
<='$start_date'"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
$cc_c=0;
$cc_c=$cc_c+$row['no_c_cc'];
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$cc_c</td>";

}
}

$sql_statement=" SELECT sum(loan_amount) as tp_cc FROM loan_statement WHERE action_date<='$start_date' and account_no LIKE 'CCL-%'"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);

echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2Rs($row['tp_cc'])."</td>";
}
}
echo "<td colspan=\"1\" bgcolor=\"$color\"><A HREF=\"list_of_loan.php?menu=ccl&op=d\">Cash Credit Due List</A></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"><A HREF=\"list_of_loan1.php?menu=ccl&op=o\">Cash Overdue List</A></td>";
//echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2RS($row['tp_cc']+$row['tdue_cc']+$row['todue_cc'])."</td>";

//====================================CC amount return=========================================
$sql_statement=" select count(count) as cc_r,sum(d) as cc_d_r,sum(o) as cc_o_r,sum(p) as cc_p_r from (SELECT count(account_no) as count,SUM(r_due_int) as d,SUM(r_overdue_int) as o,SUM(r_principal) as p FROM loan_statement WHERE tr_type='R' AND (action_date BETWEEN '1980/01/01' AND current_date) AND account_no LIKE 'CCL%' GROUP BY account_no HAVING (SUM(r_due_int)>0 OR SUM(r_overdue_int)>0 OR SUM(r_principal)>0)) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);


echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".$row['cc_r']."</td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2Rs($row['cc_p_r'])."</td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2Rs($row['cc_d_r'])."</td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2Rs($row['cc_o_r'])."</td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2RS($row['cc_p_r']+$row['cc_o_r']+$row['cc_d_r'])."</td>";
}
}
//============================kvp previous year==================================================

$sql_statement=" select count(account_no) as no_p_kvp from  customer_account where account_no like 'KPL-%' and opening_date<'$f_start_dt'"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);

echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\">KVP</th>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".$row['no_p_kvp']."</td>";
}
}
$sql_statement="select sum(loan_amount) as tp_kpl from loan_statement where account_no like 'KPL-%' and action_date<='$f_start_dt'"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);

echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2Rs($row['tp_kpl'])."</td>";
}
}
echo "<td colspan=\"1\" bgcolor=\"$color\"><A HREF=\"list_of_loan_p.php?menu=kpl&op=d\">Kvp Due List</A></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"><A HREF=\"list_of_loan_p1.php?menu=kpl&op=o\">Kvp Overdue List</A></td>";
//==============================KVP Loan TOday===================================================================
$sql_statement=" select count(account_no) as no_c_kvp from  customer_account where account_no like 'KPL-%' and opening_date
<='$start_date'"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);

$kvp_c=0;
$kvp_c=$kvp_c+$row['no_c_kvp'];
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$kvp_c</td>";
}
}

$sql_statement=" SELECT sum(loan_amount) as tp_kvp FROM loan_statement WHERE action_date<='$start_date' and account_no LIKE 'KPL-%'"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);

echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2RS($row['tp_kvp'])."</td>";
}
}
echo "<td colspan=\"1\" bgcolor=\"$color\"><A HREF=\"list_of_loan.php?menu=kpl&op=d\">Kvp Due List</A></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"><A HREF=\"list_of_loan1.php?menu=kpl&op=o\">Kvp Overdue List</A></td>";
//echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2RS($row['tp_kvp']+$row['tdue_kvp']+$row['todue_kvp'])."</td>";

//=====================================kvp amount retun==========================================
$sql_statement=" select count(count) as kvp_r,sum(d) as kvp_d_r,sum(o) as kvp_o_r,sum(p) as kvp_p_r from (SELECT count(account_no) as count,SUM(r_due_int) as d,SUM(r_overdue_int) as o,SUM(r_principal) as p FROM loan_statement WHERE tr_type='R' AND (action_date BETWEEN '1980/01/01' AND current_date) AND account_no LIKE 'KPL%' GROUP BY account_no HAVING (SUM(r_due_int)>0 OR SUM(r_overdue_int)>0 OR SUM(r_principal)>0)) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);

echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".$row['kvp_r']."</td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2RS($row['kvp_p_r'])."</td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2Rs($row['kvp_d_r'])."</td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2Rs($row['kvp_o_r'])."</td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2RS($row['kvp_p_r']+$row['kvp_d_r']+$row['kvp_o_r'])."</td>";
}
}


//==============================staff loan previous====================================================


$sql_statement="select count(account_no) as no_p_sl from  customer_account where account_no like 'SFL-%' and opening_date<'$f_start_dt'"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);



echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\">STAFF LOAN</th>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".$row['no_p_sl']."</td>";
}
}
$sql_statement="select sum(loan_amount) as tp_sfl from loan_statement where account_no like 'SFL-%' and action_date<='$f_start_dt'"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);

echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2Rs($row['tp_sfl'])."</td>";
}
}
echo "<td colspan=\"1\" bgcolor=\"$color\"><A HREF=\"list_of_loan_p.php?menu=sfl&op=d\">Staff Due List</A></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"><A HREF=\"list_of_loan_p1.php?menu=sfl&op=o\">Staff Overdue List</A></td>";
//===========================================staff loan current================================================
$sql_statement=" select count(account_no) as no_c_sl from  customer_account where account_no like 'SFL-%' and opening_date
<='$start_date'"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);

$sl_c=0;
$sl_c=$sl_c+$row['no_c_sl'];
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$sl_c</td>";
}
}

$sql_statement=" SELECT sum(loan_amount) as tp_staff FROM loan_statement WHERE action_date<='$start_date' and account_no LIKE 'SFL-%'"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);

echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2RS($row['tp_staff'])."</td>";
}
}
echo "<td colspan=\"1\" bgcolor=\"$color\"><A HREF=\"list_of_loan.php?menu=sfl&op=d\">Staff Due List</A></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"><A HREF=\"list_of_loan1.php?menu=sfl&op=o\">Staff Overdue List</A></td>";
//echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2RS($row['tp_staff']+$row['tdue_staff']+$row['todue_staff'])."</td>";

//===================================staff amount return===========================================
$sql_statement=" select count(count) as sf_r,sum(d) as sf_d_r,sum(o) as sf_o_r,sum(p) as sf_p_r from (SELECT count(account_no) as count,SUM(r_due_int) as d,SUM(r_overdue_int) as o,SUM(r_principal) as p FROM loan_statement WHERE tr_type='R' AND (action_date BETWEEN '1980/01/01' AND current_date) AND account_no LIKE 'SFL%' GROUP BY account_no HAVING (SUM(r_due_int)>0 OR SUM(r_overdue_int)>0 OR SUM(r_principal)>0)) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);

echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".$row['sf_r']."</td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2RS($row['sf_p_r'])."</td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2Rs($row['sf_d_r'])."</td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2Rs($row['sf_o_r'])."</td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2RS($row['sf_p_r']+$row['sf_d_r']+$row['sf_o_r'])."</td>";
}
}
//=========================================pledge loan previous=================================================
$sql_statement=" select count(account_no) as no_p_pl from  customer_account where account_no like 'PL-%' and opening_date<'$f_start_dt'"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);



echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\">PLEDGE LOAN</th>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".$row['no_p_pl']."</td>";
}
}
$sql_statement="select sum(loan_amount) as tp_pl from loan_statement where account_no like 'PL-%' and action_date<='$f_start_dt'"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);

echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2Rs($row['tp_pl'])."</td>";
}
}
echo "<td colspan=\"1\" bgcolor=\"$color\"><A HREF=\"list_of_loan_p.php?menu=pl&op=d\">Pledge Due List</A></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"><A HREF=\"list_of_loan_p1.php?menu=pl&op=o\">Pledge Overdue List</A></td>";

//==============================pledge current year======================================================
$sql_statement=" select count(account_no) as no_c_pl  from  customer_account where account_no like 'PL-%' and opening_date
<='$start_date'"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);

$pl_c=0;
$pl_c=$pl_c+$row['no_c_pl'];
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$pl_c</td>";
}
}

$sql_statement=" SELECT sum(loan_amount) as tp_plz FROM loan_statement WHERE action_date<='$start_date' and account_no LIKE 'PL-%'"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);

echo "<td colspan=\"1\" bgcolor=\"$color\"align=right>".amount2RS($row['tp_plz'])."</td>";
}
}
echo "<td colspan=\"1\" bgcolor=\"$color\"><A HREF=\"list_of_loan.php?menu=pl&op=d\">Pledge Due List</A></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"><A HREF=\"list_of_loan1.php?menu=pl&op=o\">Pledge Overdue List</A></td>";
//echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2RS($row['tp_plz']+$row['tdue_plz']+$row['todue_plz'])."</td>";

//===============================pledge loan amount return===========================================
$sql_statement=" select count(count) as pl_r,sum(d) as pl_d_r,sum(o) as pl_o_r,sum(p) as pl_p_r from (SELECT count(account_no) as count,SUM(r_due_int) as d,SUM(r_overdue_int) as o,SUM(r_principal) as p FROM loan_statement WHERE tr_type='R' AND (action_date BETWEEN '1980/01/01' AND current_date) AND account_no LIKE 'PL%' GROUP BY account_no HAVING (SUM(r_due_int)>0 OR SUM(r_overdue_int)>0 OR SUM(r_principal)>0)) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);

echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".$row['pl_r']."</td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2RS($row['pl_p_r'])."</td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2Rs($row['pl_d_r'])."</td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2Rs($row['pl_o_r'])."</td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2RS($row['pl_p_r']+$row['pl_o_r']+$row['pl_d_r'])."</td>";
}
}
//==================================bond loan previous===================================================
$sql_statement=" select count(account_no) as no_p_bl from  customer_account where account_no like 'BDL-%' and opening_date<'$f_start_dt'"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);



echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\">BOND LOAN</th>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".$row['no_p_bl']."</td>";
}
}

$sql_statement="select sum(loan_amount) as tp_bl from loan_statement where account_no like 'BDL-%' and action_date<='$f_start_dt'"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);

echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2Rs($row['tp_bl'])."</td>";
}
}
echo "<td colspan=\"1\" bgcolor=\"$color\"><A HREF=\"list_of_loan_p.php?menu=bdl&op=d\">Bond Due List</A></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"><A HREF=\"list_of_loan_p1.php?menu=bdl&op=o\">Bond overdue List</A></td>";

//==================================bond current loan====================================================
$sql_statement=" select count(account_no) as no_c_bl  from  customer_account where account_no like 'BDL-%' and opening_date
<='$start_date'"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);

$bl_c=0;
$bl_c=$bl_c+$row['no_c_bl'];
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$bl_c</td>";
}
}

$sql_statement=" SELECT sum(loan_amount) as tp_bond FROM loan_statement WHERE action_date<='$start_date' and account_no LIKE 'BDL-%'"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);

echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2RS($row['tp_bond'])."</td>";
}
}
echo "<td colspan=\"1\" bgcolor=\"$color\"><A HREF=\"list_of_loan.php?menu=bdl&op=d\">Bond Due List</A></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"><A HREF=\"list_of_loan1.php?menu=bdl&op=o\">Bond overdue List</A></td>";
//echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2RS($row['tp_bond']+$row['tdue_bond']+$row['todue_bond'])."</td>";
//===================================bond loan amount return=============================================
$sql_statement=" select count(count) as bdl_r,sum(d) as bdl_d_r,sum(o) as bdl_o_r,sum(p) as bdl_p_r from (SELECT count(account_no) as count,SUM(r_due_int) as d,SUM(r_overdue_int) as o,SUM(r_principal) as p FROM loan_statement WHERE tr_type='R' AND (action_date BETWEEN '1980/01/01' AND current_date) AND account_no LIKE 'BDL%' GROUP BY account_no HAVING (SUM(r_due_int)>0 OR SUM(r_overdue_int)>0 OR SUM(r_principal)>0)) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);

echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".$row['bdl_r']."</td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2RS($row['bdl_p_r'])."</td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2Rs($row['bdl_d_r'])."</td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2Rs($row['bdl_o_r'])."</td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2RS($row['bdl_p_r']+$row['bdl_d_r']+$row['bdl_o_r'])."</td>";
}
}
//=========================================lt loan previous=============================================
$sql_statement=" select count(account_no) as no_p_lt from  customer_account where account_no like 'SPL-%' and opening_date<'$f_start_dt'"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\">LT LOAN</th>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".$row['no_p_lt']."</td>";
}
}
$sql_statement="select sum(loan_amount) as tp_lt from loan_statement where account_no like 'SPL-%' and action_date<='$f_start_dt'"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);

echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2Rs($row['tp_lt'])."</td>";
}
}
echo "<td colspan=\"1\" bgcolor=\"$color\"><A HREF=\"list_of_loan_p.php?menu=spl&op=d\">Lt Due List</A></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"><A HREF=\"list_of_loan_p1.php?menu=spl&op=o\">Lt overdue List</A></td>";

//===========================================lt loan current============================================
$sql_statement=" select count(account_no) as no_c_lt  from  customer_account where account_no like 'SPL-%' and opening_date
<='$start_date'"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);

$lt_c=0;
$lt_c=$lt_c+$row['no_c_lt'];
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$lt_c</td>";
}
}

$sql_statement=" SELECT sum(loan_amount) as tp_lt FROM loan_statement WHERE action_date<='$start_date' and account_no LIKE 'SPL-%'"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);

echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2RS($row['tp_lt'])."</td>";
}
}
echo "<td colspan=\"1\" bgcolor=\"$color\"><A HREF=\"list_of_loan.php?menu=spl&op=d\">Lt Due List</A></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"><A HREF=\"list_of_loan1.php?menu=spl&op=o\">Lt overdue List</A></td>";
//echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2RS($row['tp_lt']+$row['tdue_lt']+$row['todue_lt'])."</td>";

//===============================================lt loan amount return===================================
$sql_statement=" select count(count) as lt_r,sum(d) as lt_d_r,sum(o) as lt_o_r,sum(p) as lt_p_r from (SELECT count(account_no) as count,SUM(r_due_int) as d,SUM(r_overdue_int) as o,SUM(r_principal) as p FROM loan_statement WHERE tr_type='R' AND (action_date BETWEEN '1980/01/01' AND current_date) AND account_no LIKE 'SPL%' GROUP BY account_no HAVING (SUM(r_due_int)>0 OR SUM(r_overdue_int)>0 OR SUM(r_principal)>0)) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);


echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".$row['lt_r']."</td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2RS($row['lt_p_r'])."</td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2Rs($row['lt_d_r'])."</td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2Rs($row['lt_o_r'])."</td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>".amount2RS($row['lt_p_r']+$row['lt_o_r']+$row['lt_d_r'])."</td>";
}
}

// ========================================previous total part=======================================================
$sql_statement=" select count(account_no) as t_p_a FROM customer_account where (account_no like 'SPL-%' or  account_no like 'KCC-%' or account_no like 'MT-%' or account_no like 'CCL-%' or account_no like 'KPL-%' or account_no like 'SFL-%' or account_no like 'PL-%' or account_no like 'BDL-%') and opening_date<='$f_start_dt'"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);

echo "<tr>";
echo "<td colspan=\"1\" bgcolor=\"$6CC417\" align=right>Total</td>";
echo "<td colspan=\"1\" bgcolor=\"$6CC417\" align=right>".$row['t_p_a']."</td>";
}
}

$sql_statement=" select sum(loan_amount) as t_p_amt FROM loan_statement where (account_no like 'SPL-%' or  account_no like 'KCC-%' or account_no like 'MT-%' or account_no like 'CCL-%' or account_no like 'KPL-%' or account_no like 'SFL-%' or account_no like 'PL-%' or account_no like 'BDL-%') and action_date<='$f_start_dt'"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);

echo "<td colspan=\"1\" bgcolor=\"$6CC417\" align=right>".amount2RS($row['t_p_amt'])."</td>";
}
}
echo "<td colspan=\"1\" bgcolor=\"$6CC417\" align=right>".amount2Rs($row['t1_due'])."</td>";
echo "<td colspan=\"1\" bgcolor=\"$6CC417\" align=right>".amount2Rs($row['t1_odue'])."</td>";

//======================================current total==================================================

$total_c=$kcc_c+$mt_c+$cc_c+$kvp_c+$sl_c+$pl_c+$bl_c+$lt_c;
echo "<td colspan=\"1\" bgcolor=\"$6CC417\" align=right>$total_c</td>";

$sql_statement=" select sum(loan_amount) as t_c_amt FROM loan_statement where (account_no like 'SPL-%' or  account_no like 'KCC-%' or account_no like 'MT-%' or account_no like 'CCL-%' or account_no like 'KPL-%' or account_no like 'SFL-%' or account_no like 'PL-%' or account_no like 'BDL-%') and action_date<'$start_date'"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);

echo "<td colspan=\"1\" bgcolor=\"$6CC417\" align=right>".amount2RS($row['t_c_amt'])."</td>";
}
}
echo "<td colspan=\"1\" bgcolor=\"$6CC417\" align=right>".amount2Rs($row['t_due'])."</td>";
echo "<td colspan=\"1\" bgcolor=\"$6CC417\" align=right>".amount2Rs($row['t_odue'])."</td>";
//echo "<td colspan=\"1\" bgcolor=\"$6CC417\" align=right>".amount2RS($row['t_p']+$row['t_due']+$row['t_odue'])."</td>";

//=========================================return amount total===========================================
$sql_statement=" select count(count) as t_r,sum(d) as t_d_r,sum(o) as t_o_r,sum(p) as t_p_r from (SELECT count(account_no) as count,SUM(r_due_int) as d,SUM(r_overdue_int) as o,SUM(r_principal) as p FROM loan_statement WHERE tr_type='R' AND (action_date BETWEEN '1980/01/01' AND current_date) AND account_no LIKE 'SPL%' or  account_no LIKE 'KCC%' or account_no LIKE 'MT%' or account_no LIKE 'CCL%' or account_no LIKE 'KPL%' or account_no LIKE 'SFL%' or account_no LIKE 'PL%' or account_no LIKE 'BDL%' GROUP BY account_no HAVING (SUM(r_due_int)>0 OR SUM(r_overdue_int)>0 OR SUM(r_principal)>0)) as foo"; 

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);

echo "<td colspan=\"1\" bgcolor=\"$6CC429\" align=right>".$row['t_r']."</td>";
echo "<td colspan=\"1\" bgcolor=\"$6CC429\" align=right>".amount2RS($row['t_p_r'])."</td>";
echo "<td colspan=\"1\" bgcolor=\"$6CC429\" align=right>".amount2Rs($row['t_d_r'])."</td>";
echo "<td colspan=\"1\" bgcolor=\"$6CC429\" align=right>".amount2Rs($row['t_o_r'])."</td>";
echo "<td colspan=\"1\" bgcolor=\"$6CC429\" align=right>".amount2RS($row['t_p_r']+$row['t_d_r']+$row['t_o_r'])."</td>";
}
}

// SELECT count(account_no) as no_lt,sum(b_due_int) as due_lt,SUM(b_overdue_int) as odue_lt,SUM(b_principal) as p_lt FROM loan_statement WHERE ('1/4/2011'-action_date<3650 and '1/4/2011'-action_date>0);


/*

$sql_statement="SELECT * FROM gl_header WHERE status='$value' ORDER BY cast(gl_header_code as int)";
//echo "$sql_statement";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){
for($j=0; $j<=pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
echo "<tr>";
echo "<th rowspan=\"1\" bgcolor=\"$color\"><font color=green size=+2>".$row['gl_header_code']."</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\" align=\"left\"><font color=green size=+2>".strtoupper($row['gl_header_desc'])."</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\"><font color=green size=+2>".gl_header($row['gl_header_code'],$c_year_month,$dr_cr)."</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\"><font color=green size=+2>".gl_header($row['gl_header_code'],$p_year_month,$dr_cr)."</th>";
$sql_statement2="SELECT * FROM gl_sub_header WHERE gl_header_code='".$row['gl_header_code']."'  ORDER BY CAST(gl_sub_header_code as int)";
//echo "$sql_statement2";
$result2=dBConnect($sql_statement2);
if(pg_NumRows($result2)>0){
for($i=0; $i<=pg_NumRows($result2); $i++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row2=pg_fetch_array($result2,$i);
echo "<tr>";
echo "<th rowspan=\"1\" bgcolor=\"$color\"><font color=RED size=+1>".$row2['gl_sub_header_code']."</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\" align=\"left\"><font color=RED size=+1>".ucwords($row2['gl_sub_header_desc'])."</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\"><font color=RED size=+1>".gl_sub_header($row2['gl_sub_header_code'],$c_year_month,$dr_cr)."</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\"><font color=RED size=+1>".gl_sub_header($row2['gl_sub_header_code'],$p_year_month,$dr_cr)."</th>";

$sql_statement3="SELECT * FROM gl_master WHERE gl_sub_header_code='".$row2['gl_sub_header_code']."' ORDER BY CAST(gl_mas_code as int)";
//echo "$sql_statement3";
$result3=dBConnect($sql_statement3);
if(pg_NumRows($result3)>0){
for($k=0; $k<pg_NumRows($result3); $k++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row3=pg_fetch_array($result3,$k);
echo "<tr>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">".$row3['gl_mas_code']."</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\" align=\"left\">".ucwords($row3['gl_mas_desc'])."</th>";
//echo "<th bgcolor=\"$color\">0..0</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">".totalValue($row3['gl_mas_code'],$c_year_month,$dr_cr)."</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">".totalValue($row3['gl_mas_code'],$p_year_month,$dr_cr)."</th>";


}
}
}
}
}

}
echo "</table>";
}
else{
echo "<h1><font color='red'>Function Error !!!!!!!!!!</font></h1>";

}
*/
echo "</body>";
echo "</html>";


?>
