<? include "config.php";
$status=$_REQUEST['status'];
$menu=$_REQUEST['menu'];
if($status=="name"){$sql_statement="SELECT * FROM customer_sb ORDER BY name1";}
if($status=="account_no"){$sql_statement="SELECT * FROM customer_sb ORDER BY cast(substring(account_no,3) as int)";}
//echo $sql_statement;
echo "<html>";
echo "<head>";
echo "<title>List of accounts";
echo "</title>";
echo "</head>";
echo "<body bgcolor=\"silver\"	>";
$db=pg_pConnect("host=$HOST dbname=$DATABASE");
$result=pg_Exec($db,$DATESTYLE);

$result=pg_Exec($db,$sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4>Not found abc!!!</h4>";
} else {
$row=pg_NumRows($result);
echo "<table width=\"80%\">";
echo "<tr><td bgcolor=\"green\" colspan=\"5\" align=\"center\"><font color=\"white\">Customer Details Of SB A/C[".ucwords($status)." Wise]</font>";
// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color width=\"15%\">Customer Id</th>";
echo "<th bgcolor=$color width=\"15%\">Account No.</th>";
echo "<th bgcolor=$color>Name</th>";
echo "<th bgcolor=$color>Address</th>";
echo "<th bgcolor=$color width=\"15%\">&nbsp; View &nbsp;</th>";
echo "<tr><td colspan=\"5\" align=center><iframe src=\"sb_list_of_accounts_db.php?menu=$menu&status=$status\" width=\"850\" height=\"290\" ></iframe>";
echo "<tr bgcolor=cyan><td colspan=5 align=center>Total : <font color=red><b>$row</b></font> SB Account Holder";
echo "</table>";
}


echo "</body>";
echo "</html>";
?>
