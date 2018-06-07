<?
include "../config/config.php";
$op=$_REQUEST['op'];
$tran_date=$_REQUEST['tran_date'];
$sub=$_REQUEST['sub'];
$tran_id=$_REQUEST['tran_id'];
echo "<html>";
echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script type=\"text/javascript\" src=\"../JS/bsn.AutoSuggest_c_2.0.js\"></script>";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "</head>";
echo "<body bgcolor=\"#FFF0F5\">";
echo "<form name=\"f1\" method=\"POST\" action=\"final.php?op=s\">";
echo "<table bgcolor='lightgreen' align=center width=100%>";
echo "<tr><th colspan='3' bgcolor=#4B0082><font color=WHITE>Date wise Passing</th></tr>";
echo"<tr><td colspan='3'></td></tr>";
echo "<td align=\"right\">Select Date</td><td>:</td>";
echo "<td><input type=\"TEXT\" name=\"tran_date\" size=\"12\" value=".date('d/m/Y')." $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"date\" value=\"...\" onclick=\"showCalendar(f1.tran_date,'dd/mm/yyyy','Choose Date')\">";
echo "</td></tr><tr>";
echo "<td colspan='3' align=\"right\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Enter\"></td></tr>";
echo "</table>";
echo "</form>";
if($op=='s'){
if($sub=='y'){
$sub_sql="select pass_auth_submit('$tran_id')";
//echo $sub_sql;
$sub_res=dBConnect($sub_sql);
$sub_fun=pg_fetch_array($sub_res,0);
if($sub_fun['pass_auth_submit']==0){

$pass_sql="update passing_withdraw_status set submit_tran='y' where tran_id='$tran_id'";
$pass_res=dBConnect($pass_sql);
//echo $pass_sql;
}
else{echo"Your Balance Amount is".$sub_fun['pass_auth_submit'];}
}


$tran_date=$_REQUEST['tran_date'];
$sql="select * from passing_withdraw_status where tran_dt='$tran_date'  and passing_status=1 and submit_tran is null ";
$res=dBConnect($sql);
//echo $sql;
echo"<table align='center' width='95%' bgcolor='darkgreen'><tr><th><font color=silver size=4>Passing Authority</th></tr></table>";
echo"<br>";
$fcolor='white';
echo"<table align='center' width='85%' bgcolor='silver'>";
echo"<tr><th bgcolor='silver' colspan='7'><font color=darkred>Withdrawl List As On : $tran_date</th></tr>";
echo"<tr><th bgcolor='grey'><font color=$fcolor>Serial No.</th>";
echo"<th bgcolor='grey'><font color=$fcolor>Account Number</th>";
echo"<th bgcolor='grey'><font color=$fcolor>Name</th>";
echo"<th bgcolor='grey'><font color=$fcolor>Balance Amount</th>";
echo"<th bgcolor='grey'><font color=$fcolor>Withdrawl Amount</th>";
echo"<th bgcolor='grey'><font color=$fcolor>Remarks</th>";
echo"<th bgcolor='grey'><font color=$fcolor>Final Submit</th></tr>";
for($j=0; $j<pg_NumRows($res); $j++) {
echo "<tr>";
$k=$j+1;
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($res,$j);
$account_no=$row['account_no'];
$name="select initcap(m.name1) from customer_master m,customer_account a where m.customer_id=a.customer_id and a.account_no='$account_no'";
$name_res=dBConnect($name);
$nm=pg_fetch_array($name_res,0);
$balance=sb_current_balance($account_no,"");
{
$rem_sql="select * from remarks where id='".$row['id_passing_status']."'";
$rem_res=dBConnect($rem_sql);
$remarks=pg_fetch_array($rem_res,0);
if($remarks['passing_status']=='1'){$fcolor='Green';}
if($remarks['passing_status']=='-1'){$fcolor='red';}
if($remarks['passing_status']=='0'){$fcolor='blue';}
//echo "<td bgcolor=$color>".$row['id']."</td>";
echo"<form name='f2' action='final.php?&op=s&tran_date=$tran_date&sub=y' method='post'>";
//echo"<td bgcolor=$color>".$row['id']."</td><input type='hidden' name='id' value='".$row['id']."'>";
echo"<td bgcolor=$color>$k</td><input type='hidden' name='id' value='".$row['id']."'>";
echo"<td bgcolor=$color>".$row['account_no']."</td><input type='hidden' name='acno' value='".$row['account_no']."'>";
echo "<td bgcolor=$color>".$nm['initcap']."</td>";
echo "<td bgcolor=$color>$balance</td>";
echo"<td bgcolor=$color>".$row['withdraw_amt']."</td><input type='hidden' name='value' value='".$row['withdraw_amt']."'>";
echo"<td bgcolor=$color>".$remarks['remarks']."</td>";
//echo"<input type='hidden' name='etime' value='".$row['entry_time']."'>";
echo"<input type='hidden' name='tran_id' value='".$row['tran_id']."'>";
/*echo"<input type='hidden' name='tran_dt' value='".$row['tran_dt']."'>";
echo"<input type='hidden' name='chqdt' value='".$row['chq_dt']."'>";
echo"<input type='hidden' name='chqno' value='".$row['chq_no']."'>";
echo"<input type='hidden' name='withrem' value='".$row['remarks']."'>";*/
echo"<td bgcolor=$color align='center' width='20%'><input type='submit' name='submit' value='withdrawn'></td>";
echo"</tr>";
echo"</form>";
}}
echo"</table>";

}
echo "</body>";
echo "</html>";
?>
