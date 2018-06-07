<?php
include "../config/config.php";
$caste=$_REQUEST['caste'];
$caste1=$_REQUEST['caste1'];
$caste=getIndex($village_array,$caste);
$caste1=getIndex($caste_array,$caste1);
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
//if(empty($address11)){$sql_statement="SELECT * from member_view where land_value=0 ORDER BY cast(substr(membership_id,3,length(membership_id)) AS int)";}
//else{$sql_statement="SELECT * from member_view WHERE address11='$' ORDER BY cast(substr(membership_id,3,length(membership_id)) AS int)";}

if(empty($caste)){$sql_statement="SELECT * from member_view where land_value=0 ORDER BY cast(substr(membership_id,3,length(membership_id)) AS int)";}
else{$sql_statement.=";SELECT * from member_view WHERE caste1='$caste1' ORDER BY cast(substr(membership_id,3,length(membership_id)) AS int)";}
//$result1=dBConnect($sql_statement);
//echo $sql_statement;

if(empty($caste)){$sql_statement.=";SELECT * from member_view where land_value=0 ORDER BY cast(substr(membership_id,3,length(membership_id)) AS int)";}
else{$sql_statement.=";SELECT * from member_view WHERE address11='$caste' ORDER BY address11";}
//if(empty($caste)){$sql_statement="SELECT * from member_view where land_value=0 ORDER BY name1";}
//else{$sql_statement="SELECT * from member_view WHERE caste1='$caste' ORDER BY cast(substr(membership_id,3,length(membership_id)) AS int)";}



//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4>Not found!!!</h4>";
} else {
echo "<table bgcolor=\"YELLOW\" width=\"100%\" border=1>";
echo "<form action=\"member_register.php\" method=\"POST\">";

echo "<tr><td bgcolor=\"green\" colspan=\"16\" align=\"center\"><font color=\"black\" size=\"5\">Member Register of CADP F.S.C.S Ltd.</font>";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> ";
echo "&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Select Villege :";

//makeSelect($caste_array,"caste1","All");
makeSelect($village_array,"caste","All");

echo " <input type=\"SUBMIT\" name=\"PRINT_BUTTON\" value=\"Enter\"> ";

echo "</form>";

// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color colspan=\"1\">Sl no</th>";
//echo "<th bgcolor=$color colspan=\"1\">Membership no</th>";
echo "<th bgcolor=$color colspan=\"1\">Name of member</th>";
echo "<th bgcolor=$color colspan=\"1\">Father's Name</th>";
echo "<th bgcolor=$color colspan=\"1\">Age on the date being member</th>";
//echo "<th bgcolor=$color colspan=\"1\">Value of Share</th>";
echo "<th bgcolor=$color colspan=\"1\">Present Address</th>";

echo "<th bgcolor=$color colspan=\"1\">Permanent Address</th>";

echo "<th bgcolor=$color colspan=\"1\">Occupation</th>";
echo "<th bgcolor=$color colspan=\"1\">Date of membership</th>";
echo "<th bgcolor=$color colspan=\"1\">Name of nominee</th>";
echo "<th bgcolor=$color colspan=\"1\">Nominee's relation with the member</th>";
echo "<th bgcolor=$color colspan=\"1\">Nominee's Address</th>";

echo "<th bgcolor=$color colspan=\"1\">Date & reason of cessation of membership</th>";

echo "<th bgcolor=$color colspan=\"1\">Share register folio</th>";
echo "<th bgcolor=$color colspan=\"1\">Remarks</th>";
echo "<th bgcolor=$color colspan=\"1\">Signature or thumb impression of the member</th>";


echo "</tr>";
//echo "<th bgcolor=$color colspan=\"1\">Remarks</th>";
//echo "<th bgcolor=$color colspan=\"1\">Actions</th>";
for($j=0; $j<pg_NumRows($result); $j++) {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j));
echo "<tr>";
$m=$j+1;
$mem_id=$row['membership_no'];
echo "<td align=\"right\" bgcolor=$color>".$mem_id."</td>";
//echo "<td align=\"Center\" bgcolor=$color>".$mem_id."</a></td>";
echo "<td align=\"right\" bgcolor=$color>".ucwords($row['name1'])."</td>";
echo "<td align=\"right\" bgcolor=$color>".ucwords($row['father_name1'])."</td>";
echo "<td align=\"right\" bgcolor=$color>".ucwords($row['mem_op_age'])."</td>";
echo "<td align=\"right\" bgcolor=$color>".ucwords($row['address11'])." ".ucwords($row['address12'])." ".ucwords($row['address13'])."</td>";

echo "<td align=\"right\" bgcolor=$color>".$row['present_address']."</td>";


echo "<td align=\"right\" bgcolor=$color>".$row['occupation1']."</td>";

echo "<td align=\"right\" bgcolor=$color>".$row['date_of_opening']."</td>";




echo "<td align=\"right\" bgcolor=$color>".$row['name']."</td>";
//echo "<td align=\"right\" bgcolor=$color>".$caste_array[$row['caste1']]."</td>";
echo "<td align=\"right\" bgcolor=$color>".$row['relation']."</td>";
echo "<td align=\"right\" bgcolor=$color>".$row['address']."</td>";

echo "<td align=\"right\" bgcolor=$color></td>";
echo "<td align=\"right\" bgcolor=$color>".$row['lf_no']."</td>";
echo "<td align=\"right\" bgcolor=$color>".$row['remarks']."</td>";
echo "<td align=\"right\" bgcolor=$color></td>";


}
}
// summary report
// Modification required to suite data type

//$sql_statement1="select count(membership_no) AS membership_no,sum(no_of_shares) AS no_of_shares,sum(value_of_share) AS value_of_share,sum(total_size_of_land) AS total_size_of_land from membership_t";
// echo $sql_statement1;

//$result1=pg_Exec($db,$sql_statement1);
//if(pg_NumRows($result1)==0) {
//echo "<h4>Not found!!!</h4>";
//} else 
{
$color="cyan";
//$row1=pg_fetch_array($result1,0);
echo "<tr>";
echo "<td align=\"center\" bgcolor=$color colspan=2><B>Total: ".($j)."</B></td>";
echo "<td align=\"right\" bgcolor=$color><B>&nbsp;</B></td>";
echo "<td align=\"right\" bgcolor=$color><B></B></td>";
echo "<td align=\"right\" bgcolor=$color><B></B></td>";

echo "<td align=\"right\" bgcolor=$color><B>&nbsp;</B></td>";
echo "<td align=\"right\" bgcolor=$color><B></B></td>";

echo "<td align=\"right\" bgcolor=$color><B>&nbsp;</B></td>";

echo "<td align=\"right\" bgcolor=$color><B>&nbsp;</B></td>";
echo "<td align=\"right\" bgcolor=$color><B>&nbsp;</B></td>";
echo "<td align=\"right\" bgcolor=$color><B>&nbsp;</B></td>";
echo "<td align=\"right\" bgcolor=$color><B>&nbsp;</B></td>";
echo "<td align=\"right\" bgcolor=$color><B>&nbsp;</B></td>";
echo "<td align=\"right\" bgcolor=$color><B>&nbsp;</B></td>";
echo "<td align=\"right\" bgcolor=$color><B>&nbsp;</B></td>";
echo "<td align=\"right\" bgcolor=$color><B>&nbsp;</B></td>";
echo "<td align=\"right\" bgcolor=$color></B></td>";

// END of Summary -------------------------------------
echo "</table>";
}


echo "</body>";
echo "</html>";
?>
