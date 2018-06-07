<?php
include "../config/config.php";
// PHP4 
$staff_id=verifyAutho();
$id=$_REQUEST["id"];
$period=empty($_REQUEST["period"])?0:$_REQUEST["period"];
$rate=$_REQUEST["rate"];
$effective_date=$_REQUEST["effective_date"];
$remarks=$_REQUEST["remarks"];
$menu=$_REQUEST['menu'];
$status=$_REQUEST['status'];
$scheme=$_REQUEST['scheme'];
//echo "scheme is $scheme";
$scheme=getIndex($scheme_array,$scheme);
echo "<html>";
echo "<head>";
echo "<title>Entry Form - Table: Fd_interest_rate";
echo "</title>";
echo "</head>";
echo "<body>";
echo "<h1>Entry Form - $menu interest rate";
echo "</h1>";
echo "<h3>Your submission has been accepted.";
echo "</h3>";
echo "<hr>";
if(empty($status)){
// Modification required to suite data type
$sql_statement="INSERT INTO interest_rate ( id, period, rate, deposit_type,year_witheffect, scheme,remarks, operator_code, entry_time) VALUES ( '$id', $period, $rate, '$menu','$effective_date','$scheme','$remarks', '$staff_id', now())";
}
else{
$sql_statement="UPDATE interest_rate set period=$period,rate=$rate,year_witheffect='$effective_date',scheme='$scheme',operator_code='$staff_id', remarks='$remarks',entry_time= now() where id='$id'";
}
echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_affected_rows($result)<1) {
	echo "<br><h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
} else {
	//echo "<br><h5><font color=\"GREEN\">Data entered into database.</font></h5>";
	header("Location: interest_rate_tabular.php?menu=$menu");
}
echo "</body>";
echo "</html>";

?>
