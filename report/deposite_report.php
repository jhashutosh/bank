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
echo "<title>Profit & Loss A/C";
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
echo "<form name=\"f1\" action=\"deposite_report.php\" method=\"POST\" onsubmit=\"return check();\">";
echo "<table align=center bgcolor=\"#90EE90\"><tr><td  align=\"\"><b>Date On (DD/MM/YYYY) :<td><input type=TEXT size=10 maxlength=\"10\" name=\"start_date\" id=\"start_date\" value=\"$start_date\"  maxlength=\"10\" onFocus=\"javascript:vDateType='1'\" onKeyUp=\"DateFormat(this,this.value,event,false,'3')\" onBlur=\"DateFormat(this,this.value,event,true,'3')\" $HIGHLIGHT>&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.start_date,'dd/mm/yyyy','Choose Date')\">";
echo "<input type=\"HIDDEN\" name=\"f_start_dt\" id=\"f_start_dt\" value=\"$f_start_dt\">";
echo "<input type=\"HIDDEN\" name=\"f_end_dt\" id=\"f_end_dt\" value=\"$f_end_dt\">";
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> ";
echo "</table></form>";



$sql_statement="SELECT count(account_no) AS no_pshare,sum(amount) AS share_pvalue from report_vw WHERE (action_date<'$f_start_dt' and '$f_start_dt'-action_date>0) and type='sh'";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){


echo "<table bgcolor=\"#667C26\" width=\"100%\" align=\"CENTER\">";
echo "<tr><th colspan=\"10\" bgcolor=green><font color=white size=5> CURRENT BALANCE IN A PARTICULAR DAY </th>";
echo "<tr>";

$color="#CCCCC5555";
echo "<th rowspan=\"2\" bgcolor=\"$color\">deposit report</th>";
echo "<th colspan=\"2\" bgcolor=\"$color\">OPENING BALANCE 1st APRIL</th>";
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

//echo "<td colspan=\"1\" bgcolor=\"$color\">".$row['no_pshare']."</td>";
//echo "<td colspan=\"1\" bgcolor=\"$color\">".$row['share_pvalue']."</td>";
}
}
//==============================================current share===============================================
$sql_statement="SELECT count(account_no) AS no_cshare,sum(amount) AS share_cvalue from report_vw WHERE action_date<'$start_date' and type='sh'";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
                $row=pg_fetch_array($result,$j);    

$sh1_ac=0;
$sh1_ac=$sh1_ac+$row['no_cshare'];
	
$sh1_val=0;
$sh1_val=$sh1_val+$row['share_cvalue'];
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$sh1_ac</td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$sh1_val.00</td>";
//echo "<td colspan=\"1\" bgcolor=\"$color\">".$row['share_cvalue']."</td>";

}
}
//=====================================================share int=====================================================
$sql_statement="SELECT sum(amount) AS share_int from report_vw WHERE action_date<'$start_date' and type='sh' and particulars='issue'";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);

$sh_int=0;
//$sh_int=$sh_int+$row['share_int'];
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$sh_int.00</td>";
}
}
//=====================================total share=========================================================
$sh_total=$share_val+$sh_int;
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$sh_total.00</td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"><A HREF=\"report_with.php?menu=sh\">Withdrawal</A></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"><A HREF=\"report_deposit.php?menu=sh\">Deposit</A></td>";
//=======================================savings previous===================================================
$sql_statement="select count(account_no) as no_psaving from  customer_account where account_no like 'SB-%' and opening_date<='$f_start_dt'";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);

$sb_ac=0;
$sb_ac=$sb_ac+$row['no_psaving'];

echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\">SAVINGS</th>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$sb_ac</td>";
}
}

$sql_statement="select sum (amount) as saving_pvalue from report_vw where dr_cr='Cr' and action_date<='$f_start_dt' and account_no like 'SB-%'";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);


$sb_c_val=0;
$sb_c_val=$sb_c_val+$row['saving_pvalue'];
}
}
$sql_statement="select sum (amount) as saving_pvalue from report_vw where dr_cr='Dr' and action_date<='$f_start_dt' and account_no like 'SB-%'";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);


$sb_d_val=0;
$sb_d_val=$sb_val+$row['saving_pvalue'];
}
}
$sb_val=$sb_c_val-$sb_d_val;
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$sb_val</td>";


//================================================savings current========================================
$sql_statement="select count(account_no) as no_csaving from  customer_account where account_no like 'SB-%' and opening_date<='$start_date'";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);

$sb1_ac=0;
$sb1_ac=$sb1_ac+$row['no_csaving'];
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$sb1_ac</td>";
}
}

$sql_statement="select sum (amount) as saving_cvalue from report_vw where dr_cr='Cr' and action_date<='$start_date' and account_no like 'SB-%'";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);


$sb1_c_val=0;
$sb1_c_val=$sb1_c_val+$row['saving_cvalue'];
}
}
$sql_statement="select sum (amount) as saving_cvalue from report_vw where dr_cr='Dr' and action_date<='$start_date' and account_no like 'SB-%'";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);


$sb1_d_val=0;
$sb1_d_val=$sb1_val+$row['saving_cvalue'];
}
}
$sb1_val=$sb1_c_val-$sb1_d_val;
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$sb1_val</td>";


/*
echo "<td colspan=\"1\" bgcolor=\"$color\">".$row['no_csaving']."</td>";
echo "<td colspan=\"1\" bgcolor=\"$color\">".$row['saving_cvalue']."</td>";



//=======================================saving intrest===================================================================
/*$sql_statement="SELECT sum(amount) AS saving_int from report_vw WHERE action_date<'$start_date' and type='sb' and particulars='int.'";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);


$sb_int=0;
$sb_int=$sb_int+$row['saving_int'];

echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$sb_int.00</td>";
}
}
*/
// ==========================total savings======================================================================
/*$sql_statement="SELECT count(account_no) AS no_csaving,sum(amount) AS saving_tvalue from report_vw WHERE action_date<'$start_date' and type='sb' and particulars='cash' or particulars='int.'";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);


$total_sb=$sb_int+$sb1_val;
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$total_sb</td>";
$sql_statement="select sum (amount) as fd_c_pvalue from report_vw where dr_cr='Cr' and action_date<='$f_start_dt' and account_no like 'FD-%'";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);


$fd_c_val=0;
$fd_c_val=$fd_c_val+$row['fd_c_pvalue'];
}
}

$sql_statement="select sum (amount) as fd_d_pvalue from report_vw where dr_cr='Dr' and action_date<='$f_start_dt' and account_no like 'FD-%'";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);


$fd_d_val=0;
$fd_d_val=$fd_d_val+$row['fd_d_pvalue'];
}
}
$fd_val=$fd_c_val-$fd_d_val;

echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$fd_val</td>";
*/
$sql_statement="SELECT SUM(interest) AS i FROM provissional_interest WHERE trim(deposit_type)='sb'";
$result=dBConnect($sql_statement);
$tsb_i=0;
$tsb_i=$tsb_i+pg_result($result,'i');
//echo $sql_statement;

echo "<td colspan=\"1\" bgcolor=\"$color\" align=\"right\" width=10%><A HREF=\"provisional_interest.php?menu=sb\">Interest Payable</A></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=9%></td>";

echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"><A HREF=\"report_with.php?menu=sb\">Withdrawal</A></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"><A HREF=\"report_deposit.php?menu=sb\">Deposit</A></td>";

//==============================================FD previous=====================================================

$sql_statement="select count(account_no) as no_pfd from  customer_account where account_no like 'FD-%' and opening_date<='$f_start_dt'";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);

$fd_ac=0;
$fd_ac=$fd_ac+$row['no_pfd'];
echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\">FD</th>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$fd_ac</td>";
}
}

$sql_statement="select sum (amount) as fd_c_pvalue from report_vw where dr_cr='Cr' and action_date<='$f_start_dt' and account_no like 'FD-%'";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);


$fd_c_val=0;
$fd_c_val=$fd_c_val+$row['fd_c_pvalue'];
}
}

$sql_statement="select sum (amount) as fd_d_pvalue from report_vw where dr_cr='Dr' and action_date<='$f_start_dt' and account_no like 'FD-%'";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);


$fd_d_val=0;
$fd_d_val=$fd_d_val+$row['fd_d_pvalue'];
}
}
$fd_val=$fd_c_val-$fd_d_val;

echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$fd_val</td>";



//=============================================fd current===========================================================
$sql_statement="select count(account_no) as no_cfd from  customer_account where account_no like 'FD-%' and opening_date<='$start_date'";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);

$fd1_ac=0;
$fd1_ac=$fd1_ac+$row['no_cfd'];
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$fd_ac</td>";
}
}

$sql_statement="select sum (amount) as fd_c_cvalue from report_vw where dr_cr='Cr' and action_date<='$start_date' and account_no like 'FD-%'";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);


$fd1_c_val=0;
$fd1_c_val=$fd1_c_val+$row['fd_c_cvalue'];
}
}

$sql_statement="select sum (amount) as fd_d_cvalue from report_vw where dr_cr='Dr' and action_date<='$start_date' and account_no like 'FD-%'";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);


$fd1_d_val=0;
$fd1_d_val=$fd1_d_val+$row['fd_d_cvalue'];
}
}
$fd1_val=$fd1_c_val-$fd1_d_val;

echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$fd1_val</td>";

echo "<td colspan=\"1\" bgcolor=\"$color\" align=\"right\" width=10%><A HREF=\"provisional_interest.php?menu=fd\">Interest Payable</A></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=9%></td>";

/*
//echo "<td colspan=\"1\" bgcolor=\"$color\">".$row['no_cfd']."</td>";
//echo "<td colspan=\"1\" bgcolor=\"$color\">".$row['fd_cvalue']."</td>";


//======================================fd interest===============================================================
$fd_int=0;
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$fd_int.00</td>";
$fd_total=$fd_val+$fd_int;
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$fd_total.00</td>";
*/
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"><A HREF=\"report_with.php?menu=fd\">Withdrawal</A></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"><A HREF=\"report_deposit.php?menu=fd\">Deposit</A></td>";
//==================================================RD previous====================================================
$sql_statement="select count(account_no) as no_prd from  customer_account where account_no like 'RD-%' and opening_date<='$f_start_dt'";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);

$rd_ac=0;
$rd_ac=$rd_ac+$row['no_prd'];

echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\">RD</th>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$rd_ac</td>";
}
}
$sql_statement="select sum (amount) as rd_pvalue from report_vw where dr_cr='Cr' and action_date<='$f_start_dt' and account_no like 'RD-%'";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);


$rd_c_val=0;
$rd_c_val=$rd_c_val+$row['rd_pvalue'];
}
}
$sql_statement="select sum (amount) as rd_pvalue from report_vw where dr_cr='Dr' and action_date<='$f_start_dt' and account_no like 'RD-%'";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);


$rd_d_val=0;
$rd_d_val=$rd_val+$row['rd_pvalue'];
}
}
$rd_val=$rd_c_val-$rd_d_val;

echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$rd_val</td>";

//==========================================================rd current==================================

$sql_statement="select count(account_no) as no_crd from  customer_account where account_no like 'RD-%' and opening_date<='$start_date'";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);

$rd1_ac=0;
$rd1_ac=$rd1_ac+$row['no_crd'];

echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$rd1_ac</td>";
}
}
$sql_statement="select sum (amount) as rd_cvalue from report_vw where dr_cr='Cr' and action_date<='$start_date' and account_no like 'RD-%'";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);


$rd1_c_val=0;
$rd1_c_val=$rd1_c_val+$row['rd_cvalue'];
}
}
$sql_statement="select sum (amount) as rd_cvalue from report_vw where dr_cr='Dr' and action_date<='$start_date' and account_no like 'RD-%'";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);


$rd1_d_val=0;
$rd1_d_val=$rd1_val+$row['rd_cvalue'];
}
}
$rd1_val=$rd1_c_val-$rd1_d_val;

echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$rd1_val</td>";



//echo "<td colspan=\"1\" bgcolor=\"$color\">".$row['no_crd']."</td>";
//echo "<td colspan=\"1\" bgcolor=\"$color\">".$row['rd_cvalue']."</td>";

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

echo "<td colspan=\"1\" bgcolor=\"$color\" align=\"right\" width=10%><A HREF=\"provisional_interest.php?menu=rd\">Interest Payable</A></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=9%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"><A HREF=\"report_with.php?menu=rd\">Withdrawal</A></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"><A HREF=\"report_deposit.php?menu=rd\">Deposit</A></td>";
//=====================================RI Previous=======================================================
$sql_statement="select count(account_no) as no_pri from  customer_account where account_no like 'RI-%' and opening_date<='$f_start_dt'";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);


$ri_ac=0;
$ri_ac=$ri_ac+$row['no_pri'];
echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\">RI</th>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$ri_ac</td>";
}
}

$sql_statement="select sum (amount) as ri_c_pvalue from report_vw where dr_cr='Cr' and action_date<='$f_start_dt' and account_no like 'RI-%'";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);


$ri_c_val=0;
$ri_c_val=$ri_c_val+$row['ri_c_pvalue'];
}
}

$sql_statement="select sum (amount) as ri_d_pvalue from report_vw where dr_cr='Dr' and action_date<='$f_start_dt' and account_no like 'RI-%'";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);


$ri_d_val=0;
$ri_d_val=$ri_d_val+$row['ri_d_pvalue'];
}
}
$ri_val=$ri_c_val-$ri_d_val;

echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$ri_val</td>";


//==============================================ri current==================================
$sql_statement="select count(account_no) as no_cri from  customer_account where account_no like 'RI-%' and opening_date<='$start_date'";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);


$ri1_ac=0;
$ri1_ac=$ri1_ac+$row['no_cri'];
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$ri1_ac</td>";
}
}

$sql_statement="select sum (amount) as ri_c_cvalue from report_vw where dr_cr='Cr' and action_date<='$start_date' and account_no like 'RI-%'";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);


$ri1_c_val=0;
$ri1_c_val=$ri1_c_val+$row['ri_c_cvalue'];
}
}

$sql_statement="select sum (amount) as ri_d_cvalue from report_vw where dr_cr='Dr' and action_date<='$start_date' and account_no like 'RI-%'";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);


$ri1_d_val=0;
$ri1_d_val=$ri1_d_val+$row['ri_d_cvalue'];
}
}
$ri1_val=$ri1_c_val-$ri1_d_val;

echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$ri1_val</td>";

//echo "<td colspan=\"1\" bgcolor=\"$color\">".$row['no_cri']."</td>";
//echo "<td colspan=\"1\" bgcolor=\"$color\">".$row['ri_cvalue']."</td>";


//==========================================ri interest==================================================
/*$sql_statement="SELECT sum(interest) AS ri_int from deposit_vw WHERE type='ri'";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);

$ri_int=0;
$ri_int=$ri_int+$row['ri_int'];
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$ri_int.00</td>";
}
}
//=====================================ri total==========================================================================
$ri_total=$ri_int+$ri_val;
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$ri_total.00</td>";
*/
echo "<td colspan=\"1\" bgcolor=\"$color\" align=\"right\" width=10%><A HREF=\"provisional_interest.php?menu=ri\">Interest Payable</A></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=9%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"><A HREF=\"report_with.php?menu=ri\">Withdrawal</A></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"><A HREF=\"report_deposit.php?menu=ri\">Deposit</A></td>";
//===========================================MIS PREVIOUS=============================================
$sql_statement="select count(account_no) as no_pmis from  customer_account where account_no like 'MIS-%' and opening_date<='$f_start_dt'";;
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);

$mis_ac=0;
$mis_ac=$mis_ac+$row['no_pmis'];
echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\">MIS</th>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$mis_ac</td>";
}
}
$sql_statement="select sum (amount) as mis_c_pvalue from report_vw where dr_cr='Cr' and action_date<='$f_start_dt' and account_no like 'MIS-%'";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);


$mis_c_val=0;
$mis_c_val=$mis_c_val+$row['mis_c_pvalue'];
}
}

$sql_statement="select sum (amount) as mis_d_pvalue from report_vw where dr_cr='Dr' and action_date<='$f_start_dt' and account_no like 'MIS-%'";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);


$mis_d_val=0;
$mis_d_val=$mis_d_val+$row['mis_d_pvalue'];
}
}
$mis_val=$mis_c_val-$mis_d_val;

echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$mis_val</td>";

//============================================mis current===========================================
$sql_statement="select count(account_no) as no_cmis from  customer_account where account_no like 'MIS-%' and opening_date<='$start_date'";;
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);

$mis1_ac=0;
$mis1_ac=$mis1_ac+$row['no_cmis'];
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$mis1_ac</td>";
}
}

$sql_statement="select sum (amount) as mis_c_cvalue from report_vw where dr_cr='Cr' and action_date<='$start_date' and account_no like 'MIS-%' and particulars='cash'";
//echo $sql_statement;
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);


$mis1_c_val=0;
$mis1_c_val=$mis1_c_val+$row['mis_c_cvalue'];
}
}

$sql_statement="select sum (amount) as mis_d_cvalue from report_vw where dr_cr='Dr' and action_date<='$start_date' and account_no like 'MIS-%' and particulars='cash'";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);


$mis1_d_val=0;
$mis1_d_val=$mis1_d_val+$row['mis_d_cvalue'];
}
}
$mis1_val=$mis1_c_val-$mis1_d_val;

echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$mis1_val</td>";

//echo "<td colspan=\"1\" bgcolor=\"$color\">".$row['no_cmis']."</td>";
//echo "<td colspan=\"1\" bgcolor=\"$color\">".$row['mis_cvalue']."</td>";

//=============================================mis interest=============================================
/*
$sql_statement="SELECT sum(amount) AS mis_int from report_vw WHERE action_date<'$start_date' and type='mis' and dr_cr='Dr'";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);


$mis_int=0;
$mis_int=$mis_int+$row['mis_int'];

echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$mis_int.00</td>";
}
}
//============================================mis total==============================================================

/*$sql_statement="SELECT count(account_no) AS no_csaving,sum(amount) AS mis_tvalue from report_vw WHERE action_date<'$start_date' and type='mis'";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);


$mis_total=$mis_int+$mis_val;
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$mis_total.00</td>";
//}
//}
*/
echo "<td colspan=\"1\" bgcolor=\"$color\" align=\"right\" width=10%><A HREF=\"provisional_interest.php?menu=mis\">Interest Payable</A></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" width=9%></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"><A HREF=\"report_with.php?menu=mis\">Withdrawal</A></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"><A HREF=\"report_deposit.php?menu=mis\">Deposit</A></td>";
// ==============================================total previous====================================================


/*$sql_statement="SELECT count(account_no) AS no_acc,sum(amount) AS t_value from report_vw WHERE (action_date<'$f_start_dt' and '$f_start_dt'- action_date>0) and (type='mis' or type='sh' or type='sb' or type='fd' or type='rd' or type='ri')        and particulars='cash' or particulars='opening' or particulars='issue'";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
*/

$total_pac=$sh_ac+$sb_ac+$fd_ac+$rd_ac+$ri_ac+$mis_ac;
$total_pamount=$sh_val+$sb_val+$fd_val+$rd_val+$ri_val+$mis_val;
echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$color\">TOTAL</th>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$total_pac</td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$total_pamount</td>";


//=============================================current value======================================================
/*$sql_statement="SELECT count(account_no) AS no1_acc,sum(amount) AS t1_value from report_vw WHERE (action_date<'$start_date') and type='mis' or type='sh' or type='sb' or type='fd' or type='rd' or type='ri' and particulars='cash' or particulars='opening' or particulars='issue'";
$result=dBConnect($sql_statement);

if(pg_NumRows($result)>0){

$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
*/
$total_cac=$sh1_ac+$sb1_ac+$fd1_ac+$rd1_ac+$ri1_ac+$mis1_ac;
$total_camount=$sh1_val+$sb1_val+$fd1_val+$rd1_val+$ri1_val+$mis1_val;
$total_int=$sh_int+$sb_int+$fd_int+$rd_int+$ri_int+$mis_int;
$total=$sh_total+$total_sb+$fd_total+$rd_total+$ri_total+$mis_total;

echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$total_cac</td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$total_camount</td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$total_int</td>";
echo "<td colspan=\"1\" bgcolor=\"$color\" align=right>$total</td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "<td colspan=\"1\" bgcolor=\"$color\"></td>";
echo "</table>";








/*$sql_statement="SELECT * FROM gl_header WHERE status='$value' ORDER BY cast(gl_header_code as int)";
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
