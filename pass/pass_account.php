<?
include "../config/config.php";
$TCOLOR='lightyellow';
$s=$_REQUEST['str'];
$id=$_REQUEST['id'];
$acc_no=ucwords($_REQUEST['acc_no']);
$acno=$_REQUEST['acno'];
$value=$_REQUEST['value'];
$etime=$_REQUEST['etime'];
$pass=$_REQUEST['pass'];
$rem=$_REQUEST['remark'];
$op=$_REQUEST['op'];
$del=$_REQUEST['del'];
$did=$_REQUEST['did'];
$name="select initcap(m.name1) from customer_master m,customer_account a where m.customer_id=a.customer_id and a.account_no='$acc_no'";
$name_res=dBConnect($name);
$nm=pg_fetch_array($name_res,0);
$balance=sb_current_balance($account_no,"");
if($del=='y'){
$del="delete from pass_temp where id=$did";
$del_res=dBConnect($del);
}
if($op=='c'){
$sql_statement="insert into pass_temp values($id,$rem,'$acno','$etime',$value)";
$result=dBConnect($sql_statement);
//echo $sql_statement;
//$s=$s.$id.','.$acno.','.$value.','.$rem.'|';
}

echo"<html>";
echo "<head>";
echo "<title>EMPLOYEE";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"#D2E9F2\">";
//echo $tran_date;
$sql="select * from passing_withdraw_status where account_no=upper('$acc_no') and passing_status=0";
$res=dBConnect($sql);
//echo $sql;
echo"<table align='center' width='95%' bgcolor='darkgreen'><tr><th><font color=silver size=4>Passing Authority</th></tr></table>";
echo"<br>";
$fcolor='white';
echo"<table align='center' width='85%' bgcolor='silver'>";
echo"<tr><th bgcolor='silver' colspan='5'><font color=darkred>List Of Submitted Withdrawl(s) by :".$nm['initcap']." Account Number :$acc_no</th></tr>";
echo"<tr><th bgcolor='grey'><font color=$fcolor>Serial No.</th>";
//echo"<th bgcolor='grey'><font color=$fcolor>Account Number</th>";
//echo"<th bgcolor='grey'><font color=$fcolor>Account Number</th>";
//echo"<th bgcolor='grey'><font color=$fcolor>Current Balance</th>";
echo"<th bgcolor='grey'><font color=$fcolor>Withdrawl Amount</th>";
echo"<th bgcolor='grey'><font color=$fcolor>Remarks</th>";
echo"<th bgcolor='grey'><font color=$fcolor>Modification</th></tr>";
for($j=0; $j<pg_NumRows($res); $j++) {
echo "<tr>";
$k=$j+1;
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($res,$j);
$sq="select * from pass_temp where entry_time='".$row['entry_time']."'";
//echo $sq;
$r=dBConnect($sq);

$t=pg_fetch_array($r);
if($row['entry_time']==$t['entry_time'])
{
//echo $t['remarks'];
$rem_sql="select * from remarks where id='".$t['remarks']."'";
//echo $rem_sql;

$rem_res=dBConnect($rem_sql);
$remarks=pg_fetch_array($rem_res,0);
if($remarks['passing_status']=='1'){$fcolor='Green';}
if($remarks['passing_status']=='-1'){$fcolor='red';}
if($remarks['passing_status']=='0'){$fcolor='blue';}
//echo "<td bgcolor=$color>".$row['id']."</td>";
echo "<td bgcolor=$color>$k</td>";
//echo "<td bgcolor=$color><font color=$fcolor>".$row['account_no']."</td>";
echo "<td bgcolor=$color>".$row['withdraw_amt']."</td>";
echo"<td bgcolor=$color width='20%'><font color=$fcolor>".$remarks['remarks']."</td>";
echo"<td bgcolor=$color  width='20%'><a href=\"pass_account.php?del=y&did=".$row['id']."&acc_no=$acc_no\">Modify</a></td></tr>";
}else{
echo"<form name='f1' action=\"pass_account.php?str=$s&op=c&acc_no=$acc_no\" method='post'>";
//echo"<td bgcolor=$color>".$row['id']."</td><input type='hidden' name='id' value='".$row['id']."'>";
echo"<td bgcolor=$color>$k</td><input type='hidden' name='id' value='".$row['id']."'>";
//echo"<td bgcolor=$color>".$row['account_no']."</td><input type='hidden' name='acno' value='".$row['account_no']."'>";
echo"<td bgcolor=$color>".$row['withdraw_amt']."</td><input type='hidden' name='value' value='".$row['withdraw_amt']."'>";
echo"<input type='hidden' name='etime' value='".$row['entry_time']."'>";
echo"<td bgcolor=$color width='20%'>";
makeSelectFromDbwithId('remarks','id','remarks','remark');
echo"</td>";
echo"<td bgcolor=$color  width='20%'></td>";
echo"</tr>";
echo"</form>";
}}
echo"</table>";
echo"</body>";
echo"</html>";

?>
