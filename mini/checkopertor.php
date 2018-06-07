<?
include "../config/config.php";
$staff_id=verifyAutho();
$opertor_id=$_REQUEST['opertor_id'];
//$customr_id=strtoupper($_REQUEST['acc']);
$sql_statement="select distinct(initcap(operator_name)) as operator_name,id from lc_operator_master where id='$opertor_id'";
//echo "$sql_statement";
$result=dBConnect($sql_statement);
//echo "$sql_statement";
if(pg_NumRows($result)<0)
{
echo "<h1>There is no data for this Operator!!!</h1>"

}
else
{
echo 1;
}



?>
