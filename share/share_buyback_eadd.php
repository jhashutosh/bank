<?php
include "config.php";
// PHP4 
$staff_id=verifyAutho();
$operator_code=$staff_id;
$account_no=$_REQUEST["membership_no"];
$operation=$_REQUEST['operation'];
$menu=$_REQUEST['menu'];
$current_no_share=$_REQUEST['cns'];
$current_val_share=$_REQUEST['cvs'];
$action_date=$_REQUEST['action_date'];
$no_of_share=$_REQUEST['no_of_share'];
$val_per_share=$_REQUEST['val_per_share'];
$current_dividend=$_REQUEST['cur_div'];
$with_bal=$_REQUEST['with_div'];
$db=pg_pConnect("host=$HOST dbname=$DATABASE");
$result=pg_Exec($db,$DATESTYLE);
echo "<html>";
echo "<head>";
echo "<title>Statement";
echo "</title>";
echo "<meta http-equiv=\"refresh\" content=\"1, url=share_statement.php?menu=share\">";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<h2>[Share] Withdrawal Ledger";
echo "</h2><hr>";
// Customization required for WHERE CLAUSE
if($operation=="Share")
{
 if($current_no_share<$no_of_share)
  {
   echo "<h1><font color=RED><Center><B><blink>You can't Withdrawal $no_of_share share!!!!!!!!!</blink></b></h1></font>";
   echo "<h3><font color=BLUE><center><b>You have only $current_no_share Share</b></h3></font>";
  }
else
 {
 $sql_statement="INSERT into share_ledger(tran_id,member_id,action_date, no_of_share_sales,value_of_sales,no_of_share_balance,value_of_balance,particular,entry_time,
operator_code)Values('tran-'||cast(nextval('tran_id') as varchar),'$account_no','$action_date',$no_of_share,".($val_per_share*$no_of_share).",".($current_no_share-$no_of_share).",".($current_val_share-($val_per_share*$no_of_share)).",'Withdrawn',now(),'$operator_code')";
//echo $sql_statement;
 $result=pg_Exec($db,$sql_statement);
  if(pg_NumRows($result)!=0) {
	echo "<br><h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
} else {
	echo "<br><h5><font color=\"GREEN\">Data entered into database.</font></h5>";
}
 }
}
else
 {
    if($with_bal>$current_dividend)
	{
		echo "<h1><font color=RED><Center><B><blink>You can't Withdrawal Rs.$with_bal amount!!!!!!!!!</blink></b></h1></font>";
   echo "<h3><font color=BLUE><center><b>Your current dividend only Rs.$current_dividend</b></h3></font>";
 	}
    else
      {
 		$sql_statement="INSERT into share_ledger(tran_id,member_id,action_date,with_dividend,bal_dividend,particular,entry_time,operator_code)Values('tran-'||cast(nextval('tran_id') as varchar),'$account_no','$action_date',$with_dividend,".($current_dividend-$with_dividend)."'With_div',now(),'$operator_code')";
                //echo $sql_statement;
$result=pg_Exec($db,$sql_statement);
if(pg_NumRows($result)!=0) {
	echo "<br><h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
} else {
	echo "<br><h5><font color=\"GREEN\">Data entered into database.</font></h5>";
}
       }
 }

footer();
echo "</body>";
echo "</html>";




?>
