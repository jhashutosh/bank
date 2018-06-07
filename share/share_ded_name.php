<?php
include "../config/config.php";
if(isset($_REQUEST['menu']))
{
$menu=$_REQUEST['menu'];
}
else
{
	$menu='';
}
if(isset($_REQUEST['caste']))
{
$caste=$_REQUEST['caste'];
}
else
{
	$caste='';
}
$caste=getIndex($caste_array,$caste);
if(isset($_REQUEST['alive']))
{
$alive=$_REQUEST['alive'];
}
else
{
	$alive='';
}
$alive=getIndex($alive_array,$alive);
$alive1=getIndex1($alive_array,$alive);
echo "<html>";
echo "<head>";
echo "<title>List of Members";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script language=\"JAVASCRIPT\">";
echo "function closeme() { close(); }";
echo "</script>";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "</i><hr>";
if(empty($alive)){$sql_statement="SELECT * from customer_member ORDER BY cast(substr(membership_no,3,length(membership_no)) AS int)";}
else{$sql_statement="SELECT * from customer_member WHERE membership_status='$alive' ORDER BY cast(substr(membership_no,3,length(membership_no)) AS int)";}
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4>Not found!!!</h4>";
} else {
echo "<table class=\"border\" width=\"100%\">";
echo "<form action=\"share_ded_name.php\" method=\"POST\">";
$alive1=(empty($alive1))?'Dead/Alive':$alive1;
echo "<tr><td bgcolor=\"green\" colspan=\"11\" align=\"center\"><font color=\"#CDCDCD\" size=\"5\">$alive1 Share Holder Register</font>";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> ";
echo "Select Type :";
makeSelect($alive_array,"alive","All");
echo " <input type=\"SUBMIT\" name=\"PRINT_BUTTON\" value=\"Enter\"> ";

echo "</form>";
$color='#A9A9A9';
echo "<tr>";
echo "<th bgcolor=$color colspan=\"1\">Membership no</th>";
echo "<th bgcolor=$color colspan=\"1\">Name</th>";
echo "<th bgcolor=$color colspan=\"1\">Value of Share</th>";
echo "<th bgcolor=$color colspan=\"1\">Father's Name</th>";
echo "<th bgcolor=$color colspan=\"1\">Address</th>";
echo "<th bgcolor=$color colspan=\"1\">Remarks</th>";
echo "<th bgcolor=$color colspan=\"1\">Customer Id</th>";
echo "<th bgcolor=$color colspan=\"1\">Joining date</th>";
echo "<th bgcolor=$color colspan=\"1\">Sex</th>";
echo "<th bgcolor=$color colspan=\"1\">Caste</th>";
echo "<th bgcolor=$color colspan=\"1\">LF No</th>";
echo "</tr>";
$total_val=0;
for($j=0; $j<pg_NumRows($result); $j++) {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j));
echo "<tr>";
$mem_id=$row['membership_no'];
echo "<td align=\"Center\" bgcolor=$color>".$mem_id."</a></td>";
echo "<td align=\"right\" bgcolor=$color>".ucwords($row['name1'])."</td>";
share_current_balance(trim($mem_id),$no_of_share,$value_of_share,date('Y/m/d'));
$total_val=$total_val+$value_of_share;
echo "<td align=\"right\" bgcolor=$color>".$value_of_share."</td>";
echo "<td align=\"right\" bgcolor=$color>".ucwords($row['father_name1'])."</td>";
echo "<td align=\"right\" bgcolor=$color>".ucwords($row['address11'])." ".ucwords($row['address12'])." ".ucwords($row['address13'])."</td>";
echo "<td align=\"right\" bgcolor=$color>".$row['remarks']."</td>";
echo "<td align=\"right\" bgcolor=$color>".$row['customer_id']."</td>";
echo "<td align=\"right\" bgcolor=$color>".$row['date_of_opening']."</td>";
echo "<td align=\"right\" bgcolor=$color>".$sex_array[$row['sex1']]."</td>";
echo "<td align=\"right\" bgcolor=$color>".$caste_array[$row['caste1']]."</td>";
echo "<td align=\"right\" bgcolor=$color>".$row['lf_no']."</td>";
}
}

{
$color="cyan";
//$row1=pg_fetch_array($result1,0);
echo "<tr>";
echo "<td align=\"center\" bgcolor=$color colspan=2><B>Total: ".$j."</B></td>";
echo "<td align=\"right\" bgcolor=$color><B>".$total_val."</B></td>";
echo "<td align=\"right\" bgcolor=$color><B>&nbsp;</B></td>";
echo "<td align=\"right\" bgcolor=$color><B>".$row1['total_size_of_land']."</B></td>";
echo "<td align=\"right\" bgcolor=$color><B>&nbsp;</B></td>";
echo "<td align=\"right\" bgcolor=$color><B>&nbsp;</B></td>";
echo "<td align=\"right\" bgcolor=$color><B>&nbsp;</B></td>";
echo "<td align=\"right\" bgcolor=$color><B>&nbsp;</B></td>";
echo "<td align=\"right\" bgcolor=$color><B>&nbsp;</B></td>";
echo "<td align=\"right\" bgcolor=$color><B>&nbsp;</B></td>";

// END of Summary -------------------------------------
echo "</table>";
}

echo "</body>";
echo "</html>";
?>
