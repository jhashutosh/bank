<?php
include "../config/config.php";
$staff_id=verifyAutho();
$customer_id=$_REQUEST['acc'];
//$customr_id=strtoupper($_REQUEST['acc']);
$sql_statement="SELECT * FROM customer_account WHERE customer_id='$customer_id'";
//echo "$sql_statement";
$result=dBConnect($sql_statement);
//echo "$sql_statement";
if(pg_NumRows($result)>0)
{
echo "<h1>The account number is exist!!!</h1>"
//set_account.php?menu=$menu
//echo "<center><h1>Account number is exist</h1></center>";
//header("Location: ../main/nextaccount.php?menu=$menu");
//window.open("nextaccount.php?menu=$menu","nextaccount");
}
else
{
echo "<center><h1>The account number does not exit!!!!</h1></center>";
}



?>
