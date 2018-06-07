<?php
include "../config/config.php";

if(isset($_REQUEST['caste']))
{
$caste=$_REQUEST['caste'];
}
else
{
	$caste='';
}
$caste=getIndex($caste_array,$caste);
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
if(empty($caste)){
	$sql_statement="SELECT * from customer_member ORDER BY cast(substr(membership_no,3,length(membership_no)) AS int)";
	}
else{
	$sql_statement="SELECT * from customer_member WHERE caste1='$caste' ORDER BY cast(substr(membership_no,3,length(membership_no)) AS int)";
	}

//echo $sql_statement;



$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4>Not found!!!</h4>";
} else {
echo "<table class=\"border\" width=\"100%\" >";
echo "<form action=\"share_reg.php\" method=\"POST\">";

echo "<tr><td bgcolor=\"green\" colspan=\"12\" align=\"center\"><font color=\"yellow\" size=\"6\">$caste Share Register</font>";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> ";
echo "&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Select Catagory :";
makeSelect($caste_array,"caste","All");
echo " <input type=\"SUBMIT\" name=\"PRINT_BUTTON\" value=\"Enter\"> ";

echo "</form>";

// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color colspan=\"1\">Membership no</th>";
echo "<th bgcolor=$color colspan=\"1\">Customer Id</th>";
echo "<th bgcolor=$color colspan=\"1\">Name</th>";
echo "<th bgcolor=$color colspan=\"1\">Father's Name</th>";
echo "<th bgcolor=$color colspan=\"1\">Address</th>";
echo "<th bgcolor=$color colspan=\"1\">Joining date</th>";
//echo "<th bgcolor=$color colspan=\"1\">No of Share</th>";
echo "<th bgcolor=$color colspan=\"1\">Value of Share</th>";
echo "<th bgcolor=$color colspan=\"1\">Govt. Share</th>";
echo "<th bgcolor=$color colspan=\"1\">Share Suspense</th>";
//echo "<th bgcolor=$color colspan=\"1\">Remarks</th>";
echo "<th bgcolor=$color colspan=\"1\">Sex</th>";
echo "<th bgcolor=$color colspan=\"1\">Caste</th>";
echo "<th bgcolor=$color colspan=\"1\">LF No</th>";
echo "</tr>";
//echo "<th bgcolor=$color colspan=\"1\">Remarks</th>";
//echo "<th bgcolor=$color colspan=\"1\">Actions</th>";
$total_val=0;
$total_gov_sh=0;
$total_susp_sh=0;
for($j=0; $j<pg_NumRows($result); $j++) {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j));
echo "<tr>";
$mem_id=$row['membership_no'];
echo "<td align=\"Center\" bgcolor=$color>".$mem_id."</a></td>";
echo "<td align=\"right\" bgcolor=$color>".$row['customer_id']."</td>";
echo "<td align=\"right\" bgcolor=$color>".ucwords($row['name1'])."</td>";
echo "<td align=\"right\" bgcolor=$color>".ucwords($row['father_name1'])."</td>";
echo "<td align=\"right\" bgcolor=$color>".ucwords($row['address11'])." ".ucwords($row['address12'])." ".ucwords($row['address13'])."</td>";
echo "<td align=\"right\" bgcolor=$color>".$row['date_of_opening']."</td>";
share_current_balance(trim($mem_id),$no_of_share,$value_of_share,date('Y/m/d'));
$total_val=$total_val+$value_of_share;
echo "<td align=\"right\" bgcolor=$color>".$value_of_share."</td>";
echo "<td align=\"right\" bgcolor=$color>".$row['gov_sh']."</td>";
$total_gov_sh=$total_gov_sh+$row['gov_sh'];
echo "<td align=\"right\" bgcolor=$color>".$row['sh_suspense']."</td>";
$total_susp_sh=$total_susp_sh+$row['sh_suspense'];
//echo "<td align=\"right\" bgcolor=$color>".$row['remarks']."</td>";
echo "<td align=\"right\" bgcolor=$color>".$sex_array[$row['sex1']]."</td>";
echo "<td align=\"right\" bgcolor=$color>".$caste_array[$row['caste1']]."</td>";
echo "<td align=\"right\" bgcolor=$color>".$row['lf_no']."</td>";
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
echo "<td align=\"center\" bgcolor=$color colspan=1><B>Total: ".$j."</B></td>";
//echo "<td align=\"right\" bgcolor=$color><B>&nbsp;</B></td>";
//echo "<td align=\"right\" bgcolor=$color><B>".$total_no_share."</B></td>";
echo "<td align=\"right\" bgcolor=$color><B>&nbsp;</B></td>";
echo "<td align=\"right\" bgcolor=$color><B>&nbsp;</B></td>";
echo "<td align=\"right\" bgcolor=$color><B>".$row1['total_size_of_land']."</B></td>";
echo "<td align=\"right\" bgcolor=$color><B>&nbsp;</B></td>";
echo "<td align=\"right\" bgcolor=$color><B>&nbsp;</B></td>";
echo "<td align=\"right\" bgcolor=$color><B>".$total_val."</B></td>";
echo "<td align=\"right\" bgcolor=$color><B>".$total_gov_sh."</B></td>";
echo "<td align=\"right\" bgcolor=$color><B>".$total_susp_sh."</B></td>";
echo "<td align=\"right\" bgcolor=$color><B>&nbsp;</B></td>";
echo "<td align=\"right\" bgcolor=$color><B>&nbsp;</B></td>";
echo "<td align=\"right\" bgcolor=$color><B>&nbsp;</B></td>";

// END of Summary -------------------------------------
echo "</table>";
}


echo "</body>";
echo "</html>";
?>
