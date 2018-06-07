<?php
include "../config/config.php";
$menu=$_REQUEST["menu"]; 
$staff_id=verifyAutho();
echo "<html>";
echo "<head>";
echo "<title>  Customer List Between Date";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";

echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<table bgcolor=\"white\" width=\"100%\" align=\"center\">";
$color="#CCCC0000";
echo "<tr>";
echo "<th colspan=\"6\" bgcolor=\"green\"><font color=WHITE size=\"4\" align=\"center\">List Of Members Depending On Share Value";
echo "<tr>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Customer Id</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Member Id</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Name</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">No Of Share</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Per Share Value</th>";
echo "<th rowspan=\"1\" bgcolor=\"$color\">Total Value Of Share</th>";
$sql_statement=" SELECT * FROM share_details ORDER BY value_of_share DESC";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0){
echo "<center>";
echo "<h4><font size=5 color=green><blink> Please Enter Customer Details!!!</blink></font></h4>";
echo "</center>";
}
else
{
$color=$TCOLOR;
for($j=0; $j<=pg_NumRows($result); $j++)
{    	
	 $color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
         $row=pg_fetch_array($result,$j);
echo "<tr>";
echo "<th rowspan=\"1\" width=\"15%\" bgcolor=$color>".$row['customer_id']."</th>";
$customer_id=trim($row['customer_id']);
$member_id=getMemberId($customer_id);
echo "<th rowspan=\"1\" width=\"15%\" bgcolor=$color>$member_id</th>";
$name=getCustomerName($customer_id);
echo "<th rowspan=\"1\" width=\"15%\" bgcolor=$color>$name</th>";
echo "<th rowspan=\"1\" width=\"15%\" bgcolor=$color>".$row['no_of_share']."</th>";
echo "<th rowspan=\"1\" width=\"15%\" bgcolor=$color>".$row['per_share']."</th>";
echo "<th rowspan=\"1\" width=\"15%\" bgcolor=$color>".$row['value_of_share']."</th>";

  }
echo "<tr>";
echo "<th bgcolor=\"aqua\" colspan=\"6\">Total: $j  Account!!!</th>";
}
echo "</table>";

echo "</body>";
echo "</html>";
?>
