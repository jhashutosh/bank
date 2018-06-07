<?php
include "../config/config.php";
$staff_id=verifyAutho();
getDetailFy($fy,$f_start_dt,$f_end_dt);
$end_date=$_REQUEST["end_date"];
if(empty($end_date) ) { $end_date=$f_end_dt;}
$type=$_REQUEST['type'];
echo "<script src=\"../JS/date_validation.js\"></script>";
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
echo "<body bgcolor=\"silver\">";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<table align=center bgcolor=\"silver\"><tr><td  align=\"\"><b><font size=+3>$SYSTEM_TITLE</font> <br><font size=+1><b>Report Date:".date('d.m.Y')."::".getPrintTime()."</b></font><hr>";
echo "</table>";
echo "<form name=\"f1\" action=\"npa_register.php?menu=$menu&op=1\" method=\"POST\" onsubmit=\"return check();\">";
echo "<table align=center bgcolor=\"#90EE90\"><tr><th  align=\"\">NPA Statement As On(dd/mm/yyyy):";
if($type=='All' or $type==''){
echo "<th><input TYPE=\"text\" NAME=\"end_date\" ID=\"end_date\" size=\"10\" VALUE=\"$f_end_dt\" $HIGHLIGHT>";
}
else {echo "<th><input TYPE=\"text\" NAME=\"end_date\" ID=\"end_date\" size=\"10\" VALUE=\"".date('d/m/Y')."\" $HIGHLIGHT>";}
echo "<th>Loan Module :<td>";

makeSelectFm($loan_type_array,$end_date,'type');
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> ";
echo "<input type=\"HIDDEN\" name=\"f_start_dt\" id=\"f_start_dt\" value=\"$f_start_dt\">";
echo "<input type=\"HIDDEN\" name=\"f_end_dt\" id=\"f_end_dt\" value=\"$f_end_dt\">";
echo "</table></form>";
echo "<hr>";
//-------------------------------------------------------------------------------------------
if(!empty($_REQUEST['op'])){
$sql_statement="SELECT npa_cal('$end_date');";
$sql_statement.="SELECT loan_type,SUM(due_principal) as balance_principal,SUM(odue_principal) as balance_principal_o,SUM(due_int) as due_int,SUM(odue_int) as overdue_int,
SUM(stnd_principal)as standard,SUM(sub_principal) as sub,SUM(sub_npa_amount)as sub_npa_amount,SUM(d1_principal)as d1,SUM(d1_npa_amount) as d1_npa_amount,
SUM(d2_principal) as d2, SUM(d2_npa_amount) AS d2_npa_amount,SUM(d3_principal) AS d3,SUM(d3_npa_amount) as d3_npa_amount,SUM(unsecure_principal) as unsecured_asset,
SUM(unsecure_npa_amount) as unsecure_npa_amount,SUM(lost_asset_principal) AS loss_asset,SUM(lost_asset_npa_amount) AS lost_asset_npa_amount 
FROM npa_register GROUP BY loan_type ";

if($type!='All'){
$sql_statement.=" HAVING loan_type='$type'";
}
else{
$sql_statement.=" ORDER BY loan_type";
}
//echo $sql_statement; 
getNPA($end_date,$sub,$d1,$d2,$d3,$us,$la);
$result=dBConnect($sql_statement);
echo "<Table bgcolor=\"Black\" width=\"100%\" >";
echo "<tr><th bgcolor=\"Yellow\" colspan=\"19\" align=center><font color=\"BLACK\">NPA Register for $type Module As On ".date('d/m/Y')."</font>";
$color="skyblue";
echo "<tr>";
//echo "<th bgcolor=$color Rowspan=\"2\">Account<br>No</th>";
//echo "<th bgcolor=$color Rowspan=\"2\">Name</th>";
echo "<th bgcolor=$color Rowspan=\"2\">Loan<br>Type</th>";
//echo "<th bgcolor=$color Rowspan=\"2\">Loan<br>Amount</th>";
//echo "<th bgcolor=$color Rowspan=\"2\">Loan<br>Recovery</th>";
echo "<th bgcolor=$color Colspan=\"4\">Balance</th>";
//echo "<th bgcolor=$color Rowspan=\"2\">Issue<br>Date</th>";
echo "<th bgcolor=$color Colspan=\"2\">Standard<br>(Up To Due Date)</th>";
echo "<th bgcolor=$color Colspan=\"2\">Sub-Standard<br>(After Due date upto 3 year)</th>";
echo "<th bgcolor=$color Colspan=\"2\">Doubtful-1<br>(3 year to 4 year)</th>";
echo "<th bgcolor=$color Colspan=\"2\">Doubtful-2<br>(4 year to 6 year)</th>";
echo "<th bgcolor=$color Colspan=\"2\">Doubtful-3<br>(above 6 year)</th>";
echo "<th bgcolor=$color Colspan=\"2\">Unsecure Assets</th>";
echo "<th bgcolor=$color Colspan=\"2\">Loss Assets</th>";

echo "<tr>";
echo "<th bgcolor=$color >Pincipal Due</th>";
echo "<th bgcolor=$color >Pincipal OverDue</th>";
echo "<th bgcolor=$color >Due Int.</th>";
echo "<th bgcolor=$color >OverDue Int.</th>";
echo "<th bgcolor=$color>Principal</th>";
echo "<th bgcolor=$color >0%</th>";
echo "<th bgcolor=$color>Principal</th>";
echo "<th bgcolor=$color >$sub %</th>";
echo "<th bgcolor=$color>Principal</th>";
echo "<th bgcolor=$color >$d1 %</th>";
echo "<th bgcolor=$color>Principal</th>";
echo "<th bgcolor=$color >$d2 %</th>";
echo "<th bgcolor=$color>Principal</th>";
echo "<th bgcolor=$color >$d3 %</th>";
echo "<th bgcolor=$color>Principal</th>";
echo "<th bgcolor=$color >$us %</th>";
echo "<th bgcolor=$color>Principal</th>";
echo "<th bgcolor=$color >$la %</th>";

if(pg_NumRows($result)>0){
//if(true){
for($j=1; $j<=pg_NumRows($result); $j++){
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j-1));
echo "<tr>";
echo "<th bgcolor=\"$color\"><a href=\"npa_register_dtl.php?menu=".trim($row['loan_type'])."&op=1&end_date=$end_date\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;\">".$loan_module_array[trim($row['loan_type'])];
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($row['balance_principal']);
$t_b_p+=$row['balance_principal'];
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($row['balance_principal_o']);
$t_b_p_o+=$row['balance_principal_o'];
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($row['due_int']);
$t_d_i+=$row['due_int'];

echo "<td bgcolor=\"$color\" align=\"right\"><a href=\"npa_od_dtl.php?menu=".trim($row['loan_type'])."&op=1&end_date=$end_date\" onClick=\"window.open this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;\">".amount2Rs($row['overdue_int']);


//echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($row['overdue_int']);
$t_od_i+=$row['overdue_int'];
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($row['standard']);
$t_standard+=$row['standard'];
echo "<td bgcolor=\"$color\" align=\"right\">0";
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($row['sub']);
$t_sub+=$row['sub'];
$s_p=$row['sub_npa_amount'];
$t_s_p+=$s_p;
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($s_p);
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($row['d1']);
$t_d1+=$row['d1'];
$d1_p=$row['d1_npa_amount'];
$t_d1_p+=$d1_p;
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($d1_p);
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($row['d2']);
$t_d2+=$row['d2'];
$d2_p=$row['d2_npa_amount'];
$t_d2_p+=$d2_p;
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($d2_p);
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($row['d3']);
$t_d3+=$row['d3'];
$d3_p=$row['d3_npa_amount'];
$t_d3_p+=$d3_p;
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($d3_p);
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($row['unsecured_asset']);
$t_unsecure_asset+=$row['unsecured_asset'];
$t_unsecure_p+=$row['unsecure_npa_amount'];
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($row['unsecured_asset']);
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($row['loss_asset']);
$t_loss_asset+=$row['loss_asset'];
$t_loss_p+=$row['lost_asset_npa_amount'];
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($row['loss_asset']);

  }

echo "<tr bgcolor=\"AQUA\"><th colspan=\"1\">Total:<th align=\"right\">".amount2Rs($t_b_p)."<th align=\"right\">".amount2Rs($t_b_p_o)."<th align=\"right\">".amount2Rs($t_d_i)."<th align=\"right\">".amount2Rs($t_od_i)."<th align=\"right\">".amount2Rs($t_standard)."<th align=\"right\">0<th align=\"right\">".amount2Rs($t_sub)."<th align=\"right\">".amount2Rs($t_s_p)."<th align=\"right\">".amount2Rs($t_d1)."<th align=\"right\">".amount2Rs($t_d1_p)."<th align=\"right\">".amount2Rs($t_d2)."<th align=\"right\">".amount2Rs($t_d2_p)."<th align=\"right\">".amount2Rs($t_d3)."<th align=\"right\">".amount2Rs($t_d3_p)."<th align=\"right\">".amount2Rs($t_unsecure_asset)."<th align=\"right\">".amount2Rs($t_unsecure_p)."<th align=\"right\">".amount2Rs($t_loss_asset)."<th align=\"right\">".amount2Rs($t_loss_p);
}
}
echo "</body>";
echo "</html>";
//---------------------------------------------------------------------------------------------------------------
function getNPA($end_date,$sub,$d1,$d2,$d3,$us,$la){
$sql_statement="SELECT * FROM npa_mas where action_date=(SELECT MAX(action_date) FROM npa_mas where action_date<='$end_date')";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$sub=pg_result($result,'sub');
$d1=pg_result($result,'d1');
$d2=pg_result($result,'d2');
$d3=pg_result($result,'d3');
$us=pg_result($result,'unsec');
$la=pg_result($result,'lst_ast');
}
else{

$sub=0;
$d1=0;
$d2=0;
$d3=0;
$us=0;
$la=0;

}
}
//=============================================================
function makeSelectFm($arr,$ac_date,$name){
$sql_statement="SELECT loan_type FROM loan_repayment where npa_status='y' and effect_from<='$ac_date'";
$result=dBConnect($sql_statement);
 $result=dBConnect($sql_statement);
 echo "<select name=\"$name\">";
 echo"<option>All</option>"; 
 if(pg_NumRows($result)==0) {
 echo "<option>Null</option>";
}
else{ 

      for($j=1; $j<=pg_NumRows($result); $j++) {
      $row=pg_fetch_array($result,($j-1)); 
      $type=trim($row['loan_type']);
      echo "<option value=".$row['loan_type'].">".$arr[$type]."</option>";
    }
}
echo "</select>";
}
?>
