<?
include "../../config/config.php";

$staff_id=verifyAutho();

$starting_date=$_REQUEST["starting_date"];
$ending_date=$_REQUEST["ending_date"];

if( empty($starting_date) ) { $starting_date=date("d/m/Y",time()-604800); }
if( empty($ending_date) ) { $ending_date=date("d/m/Y"); }
if(empty($_REQUEST['OFSET_DEFAULT'])){$OFSET_DEFAULT=0;}
else{$OFSET_DEFAULT=$_REQUEST['OFSET_DEFAULT'];}

echo "<html>";
echo "<head>";
echo "<title> New Customer List Between Date";
echo "</title>";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<h2>New Customer List Between Date";
echo "</h2>";
echo "<i>Here you get all New Customer list Between date";
echo "</i><hr>";

echo "<form method=\"POST\" action=\"customer_list_b_date.php\">";
echo "New Customer list between <input type=\"TEXT\" name=\"starting_date\" size=\"15\" value=\"$starting_date\">";
echo " and <input type=\"TEXT\" name=\"ending_date\" size=\"15\" value=\"$ending_date\">";
echo " <input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Submit\">";
echo "<br><hr>";
if(empty($_REQUEST['all']))
{
// Use for paging
/*$sql_statement="SELECT * FROM customer_master WHERE date_of_opening BETWEEN '$starting_date' AND '$ending_date'";

$result1=dBConnect($sql_statement);
echo "Total Record-<a href=\"customer_list_b_date.php?OFSET_DEFAULT=$a&starting_date=$starting_date&ending_date=$ending_date&all=all\">".pg_NumRows($result1)."</a>:-";
$i=1;
$row=pg_NumRows($result1);
$a=0;
for($j=0; $j<$row; $j=$j+$LIMIT_DEFAULT) 
{

echo "<a href=\"customer_list_b_date.php?OFSET_DEFAULT=$a&starting_date=$starting_date&ending_date=$ending_date\">$i</a>";
echo " ";
$a=$a+$LIMIT_DEFAULT;

$i++;
}
} end of paging portion*/
$sql_statement="SELECT * FROM customer_master WHERE date_of_opening BETWEEN '$starting_date' AND '$ending_date' order by type_of_customer";
if(empty($_REQUEST['all']))
{
 $sql_statement .=" limit $LIMIT_DEFAULT offset $OFSET_DEFAULT";}
echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4> New Customer Not found!!!</h4>";
} else {


echo "<table width=\"80%\">";

echo "<tr><td bgcolor=\"green\" colspan=\"9\" align=\"center\"><font color=\"white\">New customer List between date</font>";

// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color>Customer Id.</th>";
echo "<th bgcolor=$color colspan=\"1\">Name</th>";
echo "<th bgcolor=$color colspan=\"3\">Address</th>";
echo "<th bgcolor=$color colspan=\"1\">Contact No</th>";
echo "<th bgcolor=$color colspan=\"1\">Opening Date</th>";
echo "<th bgcolor=$color colspan=\"1\">Type of Account</th>";
echo "<th bgcolor=$color colspan=\"1\">Account</th>";

for($j=0; $j<pg_NumRows($result); $j++) 
{
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	echo "<tr>";
	echo "<td align=right bgcolor=$color><a href=\"../customer_statement.php?menu=$menu&id=".$row['customer_id']."\" target=\"_blank\">".$row['customer_id']."</a></td>";
	echo "<td align=right bgcolor=$color>".$row['name1']."</td>";
	//echo "<td align=right bgcolor=$color>".$row['middle_name1']."</td>";
	//echo "<td align=right bgcolor=$color>".$row['surname1']."</td>";
	echo "<td align=right bgcolor=$color>".$row['address11']."</td>";
	echo "<td align=right bgcolor=$color>".$row['address12']."</td>";
	echo "<td align=right bgcolor=$color>".$row['address13']."</td>";
	echo "<td align=right bgcolor=$color>".$row['telephone1']."</td>";
	echo "<td align=right bgcolor=$color>".$row['date_of_opening']."</td>";
	$type_of_customer=trim($row['type_of_customer']);
	$type_of_customer=getCustomerType($type_of_customer);
	echo "<td align=right bgcolor=$color>".$type_of_customer."</td>";
	$sql_statement1="SELECT account_type FROM customer_account WHERE customer_id='".$row['customer_id']."'";
	$result1=dBConnect($sql_statement1);
	$row1=pg_fetch_array($result1);
	echo "<td align=center bgcolor=$color>".$row1['account_type']."</td>";
}
echo "<tr>";
$color="cyan";
echo "<td align=center bgcolor=$color colspan=\"9\">Total: $j Account  !!!!!!</td>";
echo "</table>";
}

echo "<br>";

footer();

echo "</body>";
echo "</html>";
?>
