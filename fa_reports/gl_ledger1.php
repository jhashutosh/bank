<?
include "../config/config.php";
$staff_id=verifyAutho();
$fy=$_SESSION['fy'];
getDetailFy($fy,&$f_start_dt,&$f_end_dt);

if(empty($op)){$_SESSION['op']='jv';}
$gl_code=$_REQUEST['chead'];
$start_date=$_REQUEST["start_date"];
$end_date=$_REQUEST["end_date"];
$gl_code=getData($gl_code);
if(empty($start_date) ) { $start_date=$f_start_dt; }
if(empty($end_date) ) { $end_date=date("d.m.Y"); }

//$menu=$_REQUEST['menu'];
$vdebit="0.00";
$vcredit="0.00";
$cldebit="0.00";
$clcredit="0.00";
$vdebit1="0.00";
$vcredit1="0.00";

$color21="lightgreen";
$color22="lightgrey";
echo "<html>";
echo "<head>";
echo "<title>  General Ledger";
echo "</title>";
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";
echo "<link rel=\"stylesheet\" href=\"../css/autosuggest_inquisitor.css\" type=\"text/css\" media=\"screen\" charset=\"utf-8\" />";
echo "<script src=\"../JS/date_validation.js\"></script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script type=\"text/javascript\" src=\"../JS/bsn.AutoSuggest_c_2.0.js\"></script>";
echo "<script language=\"JavaScript\">";
echo "function closeme() { close(); }";
echo "</script>";

?>
<SCRIPT LANGUAGE="JavaScript">
function check(){
f_s_dt=document.f1.f_start_dt.value;
f_e_dt=document.f1.f_end_dt.value;
start_dt=document.f1.start_date.value;
end_dt=document.f1.end_date.value;
gl_name=document.f1.chead.value;

if(gl_name.length==0){
alert("GL name Should Not be Null")
	document.f1.chead.focus();
	return false;
}
if(start_dt.length==0){
alert("Start Date Should Not be Null")
	document.f1.start_date.focus();
	return false;
}
if(end_dt.length==0){
alert("Ending Date Should Not be Null")
	document.f1.end_date.focus();
	return false;
}
if(!IsDateLess(f_s_dt,start_dt)){
	alert("Starting Date beyond of ending date of Financial Year")
	document.f1.start_date.focus();
	return false;
}
/*if(!IsDateLess(end_dt,start_dt)){
	alert("Starting Date beyond of Ending date")
	document.f1.start_date.focus();
	return false;
}*/
if(!IsDateLess(start_dt,f_e_dt)){
	alert("Ending Date beyond of ending date of Financial Year")
	document.f1.start_date.focus();
	return false;
}
if(!IsDateLess(f_e_dt,end_dt)){
	alert("Ending Date beyond of ending date of Financial Year")
	document.f1.end_date.focus();
	return false;
}
/*if(!IsDateLess(end_dt,f_s_dt)){
	alert("Starting Date beyond of ending date of Financial Year")
	document.f1.end_date.focus();
	return false;
}*/



}
</script>
<?
echo "</head>";
echo "<body bgcolor=\"silver\">";

if(empty($_REQUEST['status'])){
echo "<form name=\"f1\" action=\"gl_ledger.php?glc=$glc\" method=\"POST\" onsubmit=\"return check();\">";
echo "<table align=center bgcolor=\"#90EE90\"><tr><td  align=\"\"><b>Date Between :<td><input type=TEXT size=12 name=start_date id=cd value=\"$start_date\" $HIGHLIGHT>&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.start_date,'dd/mm/yyyy','Choose Date')\"> AND <input type=TEXT size=12 name=end_date value=\"$f_end_dt\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.end_date,'dd/mm/yyyy','Choose Date')\">";

echo "<input type=\"HIDDEN\" name=\"f_start_dt\" id=\"f_start_dt\" value=\"$f_start_dt\">";
echo "<input type=\"HIDDEN\" name=\"f_end_dt\" id=\"f_end_dt\" value=\"$f_end_dt\">";

echo "<tr><td>Account Head :<td><input type=\"TEXT\" id=\"chead\"  name=\"chead\" size=\"45\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";

echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> ";
echo "</table></form>";
}
if(!empty($gl_code)){
if(empty($_REQUEST['status'])){
$sql_statement="SELECT gl_mas_code,tran_id, gl_mas_desc, action_date, particulars, debit, credit from gl_ledger_rep('$start_date', '$end_date') where gl_mas_code='$gl_code'";
}
else{
$sql_statement="SELECT * FROM (
SELECT gl_mas_code, tran_id,gl_mas_desc, action_date, particulars, debit, credit  from gl_ledger_rep('$start_date', '$end_date') where gl_mas_code='$gl_code'
UNION ALL
SELECT foo.gl_mas_code,'',gl_mas_desc,to_dt,'adjustment',debit,credit FROM (
SELECT to_dt,gl_mas_code,SUM(dr_amt) debit,SUM(cr_amt) as credit FROM sch_bs_sh_gm WHERE fn_nm NOT IN ('bs_sch','P/L') GROUP BY gl_mas_code ,to_dt) 
AS foo,gl_master gm where gm.gl_mas_code=foo.gl_mas_code and foo.gl_mas_code='$gl_code') as zoo order by action_date,tran_id";
}

//echo $sql_statement;
$result=dBConnect($sql_statement);

echo "<table width=\"100%\" valign=\"top\"><tr><td valign=\"top\" width=\"100%\">";
echo "<table width=\"100%\">";

echo "<tr><td bgcolor=\"green\" colspan=\"5\" align=\"center\"><font color=\"white\"><b>General Ledger: Accountwise</b></font>";

// Place line comments if you do not need column header.
$color=$TCOLOR;

$vglcode='   ';
	$vdebit=0.00;
	$vcredit=0.00;
for($j=0; $j<pg_NumRows($result); $j++) 
{
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
		

        if($vglcode <> $row['gl_mas_code']){
		if($vdebit+$vcredit>0){
		echo "<tr>";
		echo "<td align=left bgcolor=$color></td>";
		//echo "<td align=left bgcolor=$color></td>";
		echo "<td align=left bgcolor=$color>Balance c/f</td>";
		$bal=$vdebit-$vcredit;
		if($vdebit>$vcredit){
			echo "<td align=right bgcolor=$color> </td>";
			echo "<td align=right bgcolor=$color>".$bal."</td>";
		} else
		{
			echo "<td align=right bgcolor=$color>".-$bal."</td>";
			echo "<td align=right bgcolor=$color> </td>";

		}
		echo "<tr>";
		
		
		echo "<td align=left bgcolor=$color21></td>";
		//echo "<td align=left bgcolor=$color21></td>";
		echo "<td align=left bgcolor=$color21>Total</td>";
		if($vdebit>$vcredit){
			echo "<td align=right bgcolor=$color21>".$vdebit."</td>";
			echo "<td align=right bgcolor=$color21>".$vdebit."</td>";
		} else{
			echo "<td align=right bgcolor=$color21>".$vcredit."</td>";
			echo "<td align=right bgcolor=$color21>".$vcredit."</td>";
		} 
		}
		echo "<tr>";
		$color=$TCOLOR;
		echo "<th bgcolor=$color colspan=\"5\" width=\"15%\">".$row['gl_mas_code']." - ".$row['gl_mas_desc']."</th>";



		echo "<tr>";
		echo "<th bgcolor=$color22 colspan=\"1\" width=\"15%\">Date</th>";
		echo "<th bgcolor=$color22 colspan=\"1\" width=\"15%\">Tran Id</th>";
		echo "<th bgcolor=$color22 colspan=\"1\" width=\"40%\">Particulars</th>";
		echo "<th bgcolor=$color22 colspan=\"1\" width=\"15%\">Debit</th>";
		echo "<th bgcolor=$color22 colspan=\"1\" width=\"30%\">Credit</th>";
		$vglcode = $row['gl_mas_code'];
		$vdebit=0.00;
		$vcredit=0.00;

	}
	echo "<tr>";
	echo "<td align=left bgcolor=$color>".$row['action_date']."</td>";
	echo "<td align=left bgcolor=$color><a href =\"../general/voucherdetails.php?tran_id=".$row['tran_id']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=700,height=500'); return false;\" >".$row['tran_id']."</a></td>";
	//if(ltrim($row['account_no'])){
//echo "<td align=left bgcolor=$color>".$row['account_no']." - ".$row['particulars']."</td>";
//} else{
	echo "<td align=left bgcolor=$color>".$row['particulars']."</td>";
//}
	echo "<td align=right bgcolor=$color>".$row['debit']."</td>";
	echo "<td align=right bgcolor=$color>".$row['credit']."</td>";
	$vdebit=$vdebit+$row['debit'];
	$vcredit=$vcredit+$row['credit'];

}


echo "</tr>";
		if($vdebit+$vcredit>0){
		echo "<tr>";
		echo "<td align=left bgcolor=$color>$end_date</td>";
		echo "<td align=left bgcolor=$color></td>";
		echo "<td align=left bgcolor=$color>Balance c/f</td>";
		$bal=$vdebit-$vcredit;
		if($vdebit>$vcredit){
			echo "<td align=right bgcolor=$color> </td>";
			echo "<td align=right bgcolor=$color>".$bal."</td>";
		} else
		{
			echo "<td align=right bgcolor=$color>".-$bal."</td>";
			echo "<td align=right bgcolor=$color> </td>";

		}
		echo "<tr>";
		echo "<td align=left bgcolor=$color21></td>";
		echo "<td align=left bgcolor=$color21></td>";
		echo "<td align=left bgcolor=$color21>Total</td>";
		if($vdebit>$vcredit){
			echo "<td align=right bgcolor=$color21>".$vdebit."</td>";
			echo "<td align=right bgcolor=$color21>".$vdebit."</td>";
		} else{
			echo "<td align=right bgcolor=$color21>".$vcredit."</td>";
			echo "<td align=right bgcolor=$color21>".$vcredit."</td>";
		} 
		}

echo "</tr><tr>";
$color="cyan";
echo "<th bgcolor=$color colspan=\"1\" width=\"10%\"></th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"30%\">Total</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"20%\"></th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"20%\"></th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"20%\"></th>";
echo "</table>";
}

echo "<br>";
echo "</body>";
echo "</html>";
?>
<script type="text/javascript">
	var options = {
		script:"autoComplete.php?json=true&",
		varname:"input",
		json:true,
	};
	var as_json2 = new AutoSuggest('chead', options);
</script>
