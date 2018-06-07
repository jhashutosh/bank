<?php
include "../../config/config.php";

$staff_id=verifyAutho();
//$menu=$_REQUEST['menu'];

if(empty($_REQUEST['OFSET_DEFAULT'])){$OFSET_DEFAULT=0;}
else{$OFSET_DEFAULT=$_REQUEST['OFSET_DEFAULT'];}

echo "<html>";
echo "<head>";
echo "<title>  Customer Summary";
echo "</title>";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<center>";
echo "<font size=5 color=blue align=center>Customer Summary</font>";
echo "</center>";
echo "<br>";
$sql_statement="SELECT count(*) as so FROM customer_master where type_of_customer='so'";

$result=dBConnect($sql_statement);
$row=pg_fetch_array($result);
$so=$row['so'];
if($so==""){$so=0;}
$sql_statement="SELECT count(*) as jn FROM customer_master where type_of_customer='jn'";
$result=dBConnect($sql_statement);
$row=pg_fetch_array($result);
$jn=$row['jn'];
if($jn==""){$jn=0;}
$sql_statement="SELECT count(*) FROM customer_master where type_of_customer='nr'";
$result=dBConnect($sql_statement);
$row=pg_fetch_array($result);
$nr=$row['nr'];
if($nr==""){$nr=0;}
$sql_statement="SELECT count(*) as or FROM customer_master where type_of_customer='or'";
$result=dBConnect($sql_statement);
$row=pg_fetch_array($result);
$or=$row['or'];
if($or==""){$or=0;}
$sql_statement="SELECT count(*) as gp FROM customer_master where type_of_customer='gp'";
$result=dBConnect($sql_statement);
$row=pg_fetch_array($result);
$gp=$row['gp'];
//echo "$gp";
$sql_statement="SELECT count(*) as member FROM membership_info ";
$result=dBConnect($sql_statement);
$row=pg_fetch_array($result);
$member=$row['member'];
if($member==""){$member=0;}
echo "<table width=90% align=center border=1>";
echo "<tr><th width=22% bgcolor=white><font color=green>Sole Account Record</th><th width=22% bgcolor=white><font color=green>$so</th><th width=22% bgcolor=white><font color=green>NREGS Account Record</th><th width=22% bgcolor=white><font color=green>$nr</th>";
echo "<tr><th width=22% bgcolor=white ><font color=green>Organizational Account Record</th><th width=22% bgcolor=white><font color=green>$or</th><th width=22% bgcolor=white><font color=green>Joint Account Record</th><th width=22% bgcolor=white><font color=green>$jn</th>";
echo "<tr><th width=22% bgcolor=white><font color=green>Group Account Record</th><th width=22% bgcolor=white><font color=green>$gp</th><th width=22% bgcolor=white><font color=green>No of Member Record</th><th width=22% bgcolor=white><font color=green>$member</th>";
echo "</table>";

//echo "<p><font size=4 color=green align=center>Sole Account Record =$so</font>&nbsp";
//echo "<p><font size=4 color=green align=center>NREGS Account Record =$nr</font>";
//echo "<p><font size=4 color=green align=center> Organizational Account Record =$or</font>";
//echo "<p><font size=4 color=green align=center>Joint Account Record =$jn</font>";
//echo "<p><font size=4 color=green align=center> Group Account Record =$gp</font> ";
//echo "<p><font size=4 color=green align=center> No of Member Record =$member</font> ";

$sql_statement="SELECT * FROM customer_master  order by type_of_customer,cast(substr(customer_id,6) as varchar)";

/*if(empty($_REQUEST['all']))
{
 $sql_statement .=" limit $LIMIT_DEFAULT offset $OFSET_DEFAULT";}*/
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<center>";
echo "<h4><font size=5 color=green><blink> Please Enter Customer Details!!!</blink></font></h4>";
echo "</center>";
} else {


echo "<table width=\"80%\" align=center>";

echo "<tr><td bgcolor=\"green\" colspan=\"9\" align=\"center\"><font color=\"white\">New customer List</font>";

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
	echo "<td align=right bgcolor=$color>".ucwords($row['name1'])."</td>";
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
