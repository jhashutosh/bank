<?php
include "../config/config.php";
$loan_inst_array=array(
			'm'=> "Monthly",
			'q'=>"Quartly",
			'h'=>"Half Yearly",
			'y'=>"Yearly"
			);
$staff_id=verifyAutho();
$entry_time=date('d/m/Y H:i:s');
echo "<HTML>";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "<script src=\"../JS/loading2.js\"></script>";
?>
<script LANGUAGE="JavaScript">
function f2(str){
//alert("str"+str);
if(str=='in')
{
showHint_loan(str);
}
}
</script>
<?php
if($_REQUEST['op']=='in')
{
$ln_typ=$_REQUEST['loan_type'];
$repay_mode=$_REQUEST['repay_mode'];
$inst_mode=$_REQUEST['inst_mode'];
$ef_frm=$_REQUEST['effect_from'];
$npa=$_REQUEST['npa'];
$sql_statement="insert into loan_repayment(loan_type , repayment_mode , installment_mode , effect_from ,npa_status,operator_code , entry_time ) values('$ln_typ','$repay_mode','$inst_mode','$ef_frm','$npa','$staff_id','$entry_time')";
//echo $sql_statement;
$result=dBConnect($sql_statement);

}
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<BODY bgcolor=\"silver\">";
echo"<br><br>";
echo"<form name=f1 action=\"loan_configuration.php?op=in\" method=\"post\">";
if(empty($_REQUEST['s'])){
echo "<table width=\"60%\" height=\"40%\" bgcolor=\"#F5F5DC\" align=\"CENTER\">";
echo"<tr><th colspan=\"3\" bgcolor=\"darkblue\"><font color=\"white\">Loan Repayment Setup</th></tr>";
echo"<tr><td>Effect From</td><td width='1%'>:</td><td><input type=\"TEXT\" name=\"effect_from\" id=\"effect_from\" size=\"12\" value=\"".date('d/m/Y')."\">&nbsp;&nbsp;<input type=\"button\" name=\"efdate\" value=\"...\" onclick=\"showCalendar(f1.effect_from,'dd/mm/yyyy','Choose Date')\"></td>";
echo"<tr><td>Loan type</td><td width='1%'>:</td><td>";
makeSelectloan($loan_type_array,'loan_type','');
echo"</td></tr>";
echo"<tr><td>NPA Status</td><td width='1%'>:</td><td>";
echo "<SELECT name=\"npa\"><option VALUE='y'>YES</option><option VALUE='n'>NO</option>";
echo"</td></tr>";
echo"<tr><td>Repayment Mode</td><td width='1%'>:</td><td><select name=\"repay_mode\" onChange=\"f2(this.value);\">";
echo"<option value=\"n\">No Installment</option><option value=\"in\">Installment</option>";
echo"</select></td></tr>";
echo"<tr><td colspan=\"3\" align=\"center\">";

?>
<span id="txtHint"></span>
<?php
echo"</td></tr>";}
if($_REQUEST['s']=='1')
{
echo"<table width='100%'>";
echo"<tr><td width='40%'>Installment Mode</td><td width='3%'>:</td><td>";
makeSelectloan($loan_inst_array,'inst_mode','');
echo"</td></tr>";
echo"</table>";
}
if(empty($_REQUEST['s'])){
echo"<tr><td colspan=\"3\" align=\"right\"><input type=\"submit\" value=\"submit\"></td></tr>";
}
echo"</form>";
if(empty($_REQUEST['s'])){
echo"</table>";
//====================================================================================================================================
echo"<br>";
echo"<table align='center' width=\"60%\">";
echo"<tr><th bgcolor='green'><font color=\"white\">LOAN TYPE</th><th bgcolor='green'><font color=\"white\">REPAYMENT MODE</th><th bgcolor='green'><font color=\"white\">EFFECT FROM</th><th bgcolor='green'><font color=\"white\">NPA Status</th></tr>";
$TCOLOR='white';
$TBGCOLOR='#80ADF6';
$sql_statement="select loan_type,npa_status,effect_from,case when repayment_mode like 'n' then 'No Installment' else case when installment_mode like 'm' then 'Monthly Installment' when installment_mode like 'q' then 'Quarterly Installment'  when installment_mode like 'h' then 'Half yearly Installment'  when installment_mode like 'Y' then 'Yearly Installment' end end as repay from loan_repayment";

$result=dBConnect($sql_statement);
for($j=0;$j<pg_NumRows($result);$j++)
{
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
$element=$row['loan_type'];
//echo $sql_statement;
echo"<tr>";
echo "<td bgcolor=$color align=\"center\">".$loan_type_array[$element];
echo "<td bgcolor=$color align=\"center\">".$row['repay']."</td>";
echo "<td bgcolor=$color align=\"center\">".$row['effect_from']."</td>";
if($row['npa_status']=='y'){$s='Yes';}else{$s='No';}
echo "<td bgcolor=$color align=\"center\">".$s."</td>";
echo"</tr>";
}}
echo"</table>";
echo"</body>";
echo"</html>";

function makeSelectloan($element_array,$element,$default){

	echo "<SELECT name=\"".$element."\">";
	
	if(!empty($default)){
		echo "<option>".$default;
	}
	
	while(list($key,$val)=each($element_array)){
		if($val!=$default){
		
			echo "<option value=".$key.">".$val;
		}
	}
	echo "</select>";
}
//-------------------------------------------------------


?>

