<?
include "../config/config.php";

$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$op=$_REQUEST['op'];
$amt=$_REQUEST['amt'];
$cat=$_REQUEST['cat'];
$TCOLOR='#525252';
$action_date=$_REQUEST['action_date'];
$pentry_time=date('d/m/Y H:i:s ');
if($op=='i'){
$sql_statement="INSERT INTO pass_with_min_bal (min_bal,acc_type,w_e_f,opretor_code,entry_time) VALUES($amt,'$cat','$action_date','$staff_id','$pentry_time')";
$result=dBConnect($sql_statement);
echo $sql_statement;
if(pg_affected_rows($result)<1) {
	echo "<br><h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
	} 
else { header("Location:withdraw.php?op=d");
      }
}
echo "<html>";
echo "<head>";
?>
<script LANGUAGE="JavaScript">
function val(f){
var amt=document.getElementById('amt').value.length;
//alert(amt);
var cat=document.getElementByName('cat').value.length;
var acdate=document.getElementById('action_date').value.length;
if(amt<1){
alert("Amount Must be given");
return false;
}
if(cat<1){
alert("Account type should be selected");
return false;
}
if(acdate<1){
alert("Effect from date should not be blank");
return false;
}

}
</script>
<?
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script type=\"text/javascript\" src=\"../JS/bsn.AutoSuggest_c_2.0.js\"></script>";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "</head>";
if($op=='d'){
echo "<body bgcolor=\"#EFFFEF\"><br><br>";
echo "<form name=\"f1\" method=\"POST\" action=\"withdraw.php?op=i\" onsubmit=\"return val(this.form);\">";
echo "<table bgcolor='#A9A9A9' align=center width=70% >";
echo "<tr><th colspan='3' bgcolor=#CDCDCD><font color='grey'>Set up Maximum Withdrawl Amount without Authorisation</th></tr>";
echo"<tr><td colspan='3'></td></tr>";
echo "<tr>";
echo "<td align=\"right\">With Effect From</td><td>:</td><td><input type=\"TEXT\" name=\"action_date\" id=\"action_date\" size=\"12\" value=\"".date('d.m.Y')."\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.action_date,'dd/mm/yyyy','Choose Date')\"></td></tr>";
echo"<tr><td align='right'>Account Type</td><td>:</td><td>";
makeSelectcategory($type_of_pass_array,"cat");
echo"</td></tr>";
echo "<td align=\"right\">Maximum Dirrect Withdrawl Amount</td><td>:</td>";
echo "<td><input type=\"TEXT\" name=\"amt\" size=\"7\" id=\"amt\" $HIGHLIGHT>";
echo "</td></tr><tr>";
echo "<td colspan='3' align=\"right\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Enter\"></td></tr></table><br><br>";
echo"<table width='60%' align='center'><tr bgcolor='silver'><th><font color='1A1A1A'>Account Type</th><th><font color='1A1A1A'>With Effect From</th><th><font color='1A1A1A'>Direct Withdrawal Amount </th><tr></tr>";
$sql="select * from pass_with_min_bal where acc_type not like ''";
$res=dBConnect($sql);
for($j=0; $j<pg_NumRows($res); $j++){
$color=($color==$TBGCOLOR)?$TCOLOR:$TBGCOLOR;
$row=pg_fetch_array($res,$j);
$font=($color=='#525252')?'white':'#525252';
echo"<td bgcolor=$color align='center'><font color=$font>".$type_of_pass_array[$row['acc_type']];
echo"<td bgcolor=$color align='center'><font color=$font>".$row['w_e_f'];
echo"<td bgcolor=$color align='center'><font color=$font>".$row['min_bal'];
echo "</tr>";

}


echo "</table>";
echo "</form>";
}

echo "</body>";
echo "</html>";
?>
