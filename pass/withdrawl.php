<?
include "../config/config.php";
$TCOLOR='lightyellow';
$s=$_REQUEST['str'];
$id=$_REQUEST['id'];
$tran_date=$_REQUEST['tran_date'];
$tran_dt=$_REQUEST['tran_dt'];
$tran_id=$_REQUEST['tran_id'];
$acno=$_REQUEST['acno'];
$value=$_REQUEST['value'];
$chqno=($_REQUEST['chqno']==0)?"":$_REQUEST['chqno'];
$chqdt=($_REQUEST['chqdt']=='01.01.1900')?'null':$_REQUEST['chqdt'];
//echo $chqdt;
$withrem=$_REQUEST['withrem'];
$acdt=date('d/m/Y');
$operator_code=verifyAutho();
$etime=$_REQUEST['etime'];
$pass=$_REQUEST['pass'];
$rem=$_REQUEST['remark'];
$op=$_REQUEST['op'];
$del=$_REQUEST['del'];
$did=$_REQUEST['did'];
if($op=='f'){
$sql_string="select * pass_temp where tran_date='$tran_date'";
$result_st=dBConnect($sql_string);
echo $sql_string;
for($j=0; $j<pg_NumRows($result_st); $j++){
$String=pg_fetch_array($result_st,$j);
//$s=$s.;


//$s=$s.$id.','.$acno.','.$value.','.$rem.'|';
}

}
if($del=='y'){
$del="delete from pass_temp where entry_time='$did'";
//echo $del;
$del_res=dBConnect($del);
}
if($op=='c'){
$sql_statement="insert into pass_temp values($id,$rem,'$acno','$etime',$value,'$tran_id','$tran_dt','$operator_code','$chqno',$chqdt,'$withrem','$acdt')";
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
$sql="select * from passing_withdraw_status where tran_dt='$tran_date' and passing_status=0";
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
echo"<th bgcolor='grey'><font color=$fcolor>Modification</th></tr>";
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
echo "<td bgcolor=$color><font color=$fcolor>".$row['account_no']."</td>";
echo "<td bgcolor=$color>".$nm['initcap']."</td>";
echo "<td bgcolor=$color>$balance</td>";
echo "<td bgcolor=$color>".$row['withdraw_amt']."</td>";

echo"<td bgcolor=$color width='20%'><font color=$fcolor>".$remarks['remarks']."</td>";
echo"<td bgcolor=$color  width='20%'><a href=\"pass.php?del=y&did=".$row['entry_time']."&tran_date=$tran_date\">Modify</a></td></tr>";
}else{
echo"<form name='f1' action='pass.php?str=$s&op=c&tran_date=$tran_date' method='post'>";
//echo"<td bgcolor=$color>".$row['id']."</td><input type='hidden' name='id' value='".$row['id']."'>";
echo"<td bgcolor=$color>$k</td><input type='hidden' name='id' value='".$row['id']."'>";
echo"<td bgcolor=$color>".$row['account_no']."</td><input type='hidden' name='acno' value='".$row['account_no']."'>";
echo "<td bgcolor=$color>".$nm['initcap']."</td>";
echo "<td bgcolor=$color>$balance</td>";
echo"<td bgcolor=$color>".$row['withdraw_amt']."</td><input type='hidden' name='value' value='".$row['withdraw_amt']."'>";

echo"<input type='hidden' name='etime' value='".$row['entry_time']."'>";
echo"<input type='hidden' name='tran_id' value='".$row['tran_id']."'>";
echo"<input type='hidden' name='tran_dt' value='".$row['tran_dt']."'>";
echo"<input type='hidden' name='chqdt' value='".$row['chq_dt']."'>";
echo"<input type='hidden' name='chqno' value='".$row['chq_no']."'>";
echo"<input type='hidden' name='withrem' value='".$row['remarks']."'>";
echo"<td bgcolor=$color width='20%'>";
makeSelectFromDbwithId('remarks','id','remarks','remark');
echo"</td>";
echo"<td bgcolor=$color  width='20%'></td>";
echo"</tr>";
echo"</form>";
}}
echo"</table>";
echo"<form name='f2' method='post' action='pass.php?op=f&tran_date=$tran_date'>";
echo"<table align='center'><tr><td><input type='submit' name='submit' value='submit'></td></tr></table>";
echo"</form>";
echo"</body>";
echo"</html>";

?>
