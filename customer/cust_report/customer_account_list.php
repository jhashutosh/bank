<?php
include "../../config/config.php";
$staff_id=verifyAutho();
$type_array = array (
	"so" =>"Sole",
	"jn"=>"Join",
	"or"=>"Organisation",
	"gp"=>"Group"
);
$menu=$_REQUEST['menu'];
$type=$_REQUEST['type'];
$type=getIndex($type_array,$type);
$type1=getIndex1($type_array,$type);
echo "<html>";
echo "<head>";
echo "<title>  Customer List Between Date";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../../css/test.css\" />";

echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<hr>";
if(empty($type)){$sql_statement="SELECT * FROM customer_master WHERE customer_id like '%C-%'  order by cast(substr(customer_id,2,length(customer_id)) as int) DESC";}
else{$sql_statement="SELECT * FROM customer_master WHERE type_of_customer='$type' and customer_id like '%C-%'  order by cast(substr(customer_id,2,length(customer_id)) as int) DESC";}
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<center>";
echo "<h4><font size=5 color=green><blink> Please Enter Customer Details!!!</blink></font></h4>";
echo "</center>";
} else {
echo "<table width=\"100%\">";
echo "<form action=\"customer_account_list.php\" method=\"POST\">";
$type1=(empty($type1))?'All':$type1;
if(empty($type) or ($type=='All') or ($type=='so') or ($type=='or') or ($type=='gp')){$colspan=11;}
if($type=='jn') {$colspan=12;}
echo "<tr><td bgcolor=\"green\" colspan=\"$colspan\" align=\"center\"><font color=\"white\"><b>$type1 Customer Account List</b></font>";
// Place line comments if you do not need column header.
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Select Type :&nbsp; &nbsp;";
makeSelect($type_array,"type","All");
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <input type=\"SUBMIT\" name=\"PRINT_BUTTON\" value=\"Enter\"> ";
echo "</form>";
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color>Customer Id.</th>";
if(empty($type) or ($type=='All') or ($type=='so') or ($type=='or') or ($type=='gp'))
{echo "<th bgcolor=$color colspan=\"1\">Name</th>";}
if($type=='jn') 
{echo "<th bgcolor=$color colspan=\"1\">First Holder Name</th>";
echo "<th bgcolor=$color colspan=\"1\">Second Holder Name</th>";
}
echo "<th bgcolor=$color colspan=\"1\">Father Name</th>";
echo "<th bgcolor=$color colspan=\"3\">Address</th>";
echo "<th bgcolor=$color colspan=\"1\">Contact No</th>";
echo "<th bgcolor=$color colspan=\"1\">Opening Date</th>";
echo "<th bgcolor=$color colspan=\"1\">Voter Id</th>";
echo "<th bgcolor=$color colspan=\"1\">Operator code</th>";
echo "<th bgcolor=$color colspan=\"1\">Details</th>";

for($j=0; $j<pg_NumRows($result); $j++) 
{
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	echo "<tr>";
	echo "<td bgcolor=$color><a href=\"../customer_statement.php?menu=$menu&id=".$row['customer_id']."\" target=\"_blank\">".$row['customer_id']."</a></td>";
	if(empty($type) or ($type=='All') or ($type=='so') or ($type=='or') or ($type=='gp'))
	{echo "<td bgcolor=$color>".ucwords($row['name1'])."</td>";}
	if($type=='jn') 
	{
	echo "<td bgcolor=$color>".ucwords($row['name1'])."</td>";
	echo "<td bgcolor=$color>".ucwords($row['name2'])."</td>";
	}
	echo "<td bgcolor=$color>".ucwords($row['father_name1'])."</td>";
	echo "<td bgcolor=$color>".ucwords($row['address11'])."</td>";
	echo "<td bgcolor=$color>".ucwords($row['address12'])."</td>";
	echo "<td bgcolor=$color>".ucwords($row['address13'])."</td>";
	echo "<td bgcolor=$color>".$row['telephone1']."</td>";
	echo "<td align=Center bgcolor=$color>".$row['date_of_opening']."</td>";
	echo "<td align=center bgcolor=$color>".$row['voter_id_no1']."</td>";
	echo "<td align=center bgcolor=$color>".$row['operator_code']."</td>";
	echo "<td align=center bgcolor=$color><a href=\"../../main/set_account.php?menu=cust&account_no=".$row['customer_id']."\" target=\"parent\">Show</td>";
}
echo "<tr>";
$color="cyan";
echo "<td align=center bgcolor=$color colspan=\"$colspan\"><b>Total:  $j Account  !!!!!!</b></td>";
echo "</table>";
}
echo "</body>";
echo "</html>";
?>
