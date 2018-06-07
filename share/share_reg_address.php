<?php
include "../config/config.php";
$vill=$_REQUEST['vill'];
//$vill=getIndex($village_array,$vill);
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
if(empty($vill)){
	$sql_statement="SELECT * from customer_member ORDER BY cast(substr(membership_no,3,length(membership_no)) AS int)";
	}
else{
	$sql_statement="SELECT * from customer_member WHERE address11='$vill' ORDER BY cast(substr(membership_no,3,length(membership_no)) AS int)";
	}
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4>Not found!!!</h4>";
} else {
echo "<table bgcolor=\"YELLOW\" width=\"100%address11\">";
echo "<form action=\"share_reg_address.php\" method=\"POST\">";

echo "<tr><td bgcolor=\"green\" colspan=\"12\" align=\"center\"><font color=\"yellow\" size=\"6\">Share Register By Address</font>";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> ";
echo "&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Select Villege :";
//makeSelect($caste_array,"caste1","All");
makeSelectVillage('vill');
echo " <input type=\"SUBMIT\" name=\"PRINT_BUTTON\" value=\"Enter\"> ";
echo "</form>";
// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color Rowspan=\"2\">Membership no</th>";
echo "<th bgcolor=$color Rowspan=\"2\">Name</th>";
echo "<th bgcolor=$color Rowspan=\"2\">Value of Share</th>";
echo "<th bgcolor=$color Rowspan=\"2\">Father's Name</th>";
echo "<th bgcolor=$color Rowspan=\"2\">Address</th>";
echo "<th bgcolor=$color Colspan=\"2\">Land</th>";
echo "<th bgcolor=$color Rowspan=\"2\">Customer Id</th>";
echo "<th bgcolor=$color Rowspan=\"2\">Joining date</th>";
echo "<th bgcolor=$color Rowspan=\"2\" >Sex</th>";
echo "<th bgcolor=$color Rowspan=\"2\">Caste</th>";
echo "<th bgcolor=$color Rowspan=\"2\">LF No</th>";
echo "</tr>";
echo "<th bgcolor=$color >Area</th>";
echo "<th bgcolor=$color>Value</th>";
echo "</tr>";
//echo "<th bgcolor=$color colspan=\"1\">Remarks</th>";
//echo "<th bgcolor=$color colspan=\"1\">Actions</th>";
for($j=0; $j<pg_NumRows($result); $j++) {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j));
echo "<tr>";

echo "<td align=\"Center\" bgcolor=$color>".$row['membership_no']."</a></td>";
echo "<td  bgcolor=$color>".ucwords($row['name1'])."</td>";

$value_of_share=$row['share_balance'];
$total_val=$total_val+$value_of_share;
echo "<td align=\"right\" bgcolor=$color>".amount2Rs($value_of_share)."</td>";
echo "<td  bgcolor=$color>".ucwords($row['father_name1'])."</td>";
echo "<td align=\"right\" bgcolor=$color>".ucwords($row['address11'])." ".ucwords($row['address12'])." ".ucwords($row['address13'])."</td>";
echo "<td align=\"right\" bgcolor=$color>".getAcer($row['area_of_land'])."</td>";
echo "<td align=\"right\" bgcolor=$color>".amount2Rs($row['value_of_land'])."</td>";
echo "<td align=\"right\" bgcolor=$color>".$row['customer_id']."</td>";
echo "<td align=\"right\" bgcolor=$color>".$row['date_of_membership']."</td>";
echo "<td align=\"right\" bgcolor=$color>".$sex_array[$row['sex1']]."</td>";
echo "<td  bgcolor=$color>".$caste_array[$row['caste1']]."</td>";
echo "<td align=\"right\" bgcolor=$color>".$row['lf_no']."</td>";
}
}

{
$color="cyan";
//$row1=pg_fetch_array($result1,0);
echo "<tr>";
echo "<td align=\"center\" bgcolor=$color colspan=2><B>Total: ".$j."</B></td>";
//echo "<td align=\"right\" bgcolor=$color><B>&nbsp;</B></td>";
//echo "<td align=\"right\" bgcolor=$color><B>".$total_no_share."</B></td>";
 echo "<td align=\"right\" bgcolor=$color><B>".amount2Rs($total_val)."</B></td>";

echo "<td align=\"right\" bgcolor=$color><B>&nbsp;</B></td>";
echo "<td align=\"right\" bgcolor=$color><B>".$row1['total_size_of_land']."</B></td>";

echo "<td align=\"right\" bgcolor=$color><B>&nbsp;</B></td>";

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

function makeSelectVillage($name){
  $sql_statement="SELECT distinct(address11) from customer_member order by address11";
  //echo  $sql_statement;
 $result=dBConnect($sql_statement);
 echo "<select name=\"$name\">"; 
 if(pg_NumRows($result)==0) {
 echo "<option>Null</option>";
}
else{ 

      for($j=1; $j<=pg_NumRows($result); $j++) {
      $row=pg_fetch_array($result,($j-1)); 
      echo "<option value=".$row['address11'].">".$row['address11']."</option>";
    }
}
echo "</select>";
}


?>
