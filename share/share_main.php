<?php
include "../config/config.php";
echo "<html>";
echo "<head>";
echo "<title>List of Members";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "</i><hr>";
//$sql_statement="SELECT * from member_view where land_value=0 order by membership_id";
 // $sql_statement="SELECT * from member_view1 ORDER BY membership_id";
$sql_statement="SELECT * from customer_member ORDER BY cast(substr(membership_no,3,length(membership_no)) AS int)";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4>Not found!!!</h4>";
} else {
echo "<table bgcolor=\"YELLOW\" width=\"100%\">";
echo "<tr><td bgcolor=\"green\" colspan=\"8\" align=\"center\"><font color=\"yellow\" size=\"6\">LIST OF MEMBERS</font>";
// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color colspan=\"1\">Membership no</th>";
echo "<th bgcolor=$color colspan=\"1\">Name</th>";
echo "<th bgcolor=$color colspan=\"1\">No of Share</th>";
echo "<th bgcolor=$color colspan=\"1\">Value of Share</th>";
echo "<th bgcolor=$color colspan=\"1\">No of Land</th>";
echo "<th bgcolor=$color colspan=\"1\">Size of land</th>";
//echo "<th bgcolor=$color colspan=\"1\">No of GP</th>";
//echo "<th bgcolor=$color colspan=\"1\">Kcc account no</th>";
//echo "<th bgcolor=$color colspan=\"1\">Pledge account no</th>";
//echo "<th bgcolor=$color colspan=\"1\">Loan account no</th>";
//echo "<th bgcolor=$color colspan=\"1\">Sb account no</th>";
echo "<th bgcolor=$color colspan=\"1\">Joining date</th>";
echo "<th bgcolor=$color colspan=\"1\">Ledger Folio</th>";
//echo "<th bgcolor=$color colspan=\"1\">Remarks</th>";
//echo "<th bgcolor=$color colspan=\"1\">Actions</th>";
for($j=1; $j<=pg_NumRows($result); $j++) {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j-1));
echo "<tr>";
$mem_id=$row['membership_no'];
echo "<td align=\"Center\" bgcolor=$color>".$mem_id."</a></td>";
echo "<td align=\"right\" bgcolor=$color>".ucwords($row['name1'])."</td>";
$no_of_share = 0;
$value_of_share = 0;
$total_no_share=0;
$total_val=0;
share_current_balance(trim($mem_id),$no_of_share,$value_of_share,date("Y/m/d"));
$total_no_share=$total_no_share+$no_of_share;
$total_val=$total_val+$value_of_share;
echo "<td align=\"right\" bgcolor=$color>".$no_of_share."</td>";
echo "<td align=\"right\" bgcolor=$color><A HREF=\"../share/share_statement.php?menu=sh&account_no=$mem_id\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=120,left=150, width=1000,height=600'); return false;\">".$value_of_share."</a></td>";
$no_of_land=$row['no_of_land'];
if($no_of_land>0){
echo "<td align=\"left\" bgcolor=$color>&nbsp;&nbsp;".$row['no_of_land']."</td>";}
else {
echo "<td align=\"left\" bgcolor=$color><blink><a href=\"../land/land_ledger_ef.php?membership_no=".$row['membership_no']."\" target=\"_self\">Add land</a></blink></td>";}
echo "<td align=\"left\" bgcolor=$color><A HREF=\"../land/land_statement.php?menu=ln&op=shi&customer_id=".$row['customer_id']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=120,left=150, width=1000,height=600'); return false;\">&nbsp;&nbsp;".getAcer($row['area_of_land'])."</a></td>";
echo "<td align=\"right\" bgcolor=$color>".$row['date_of_opening']."</td>";
echo "<td align=\"right\" bgcolor=$color>".$row['lf_no']."</td>";
//echo "<td align=\"right\" bgcolor=$color>".$row['remarks']."</td>";
//echo "<td align=\"center\" bgcolor=$color><a href=\"membership_t_uf.php?membership_no=".$row['membership_no']."\" target=\"_self\">M</a>&nbsp;";
//echo "<a href=\"member_del.php?membership_no=".$row['membership_no']."\" target=\"_self\">D</a></td>";
}
}
// summary report
// Modification required to suite data type

//$sql_statement1="select count(membership_no) AS membership_no,sum(no_of_shares) AS no_of_shares,sum(value_of_share) AS //value_of_share,sum(total_size_of_land) AS total_size_of_land from membership_t";
// echo $sql_statement1;

//$result1=pg_Exec($db,$sql_statement1);
//if(pg_NumRows($result1)==0) {
//echo "<h4>Not found!!!</h4>";
//} else 
{
$color="cyan";
//$row1=pg_fetch_array($result1,0);
echo "<tr>";
echo "<td align=\"center\" bgcolor=$color colspan=2><B>Total: ".($j-1)."</B></td>";
//echo "<td align=\"right\" bgcolor=$color><B>&nbsp;</B></td>";
echo "<td align=\"right\" bgcolor=$color><B>".$total_no_share."</B></td>";
 echo "<td align=\"right\" bgcolor=$color><B>".$total_val."</B></td>";

echo "<td align=\"right\" bgcolor=$color><B>&nbsp;</B></td>";
//echo "<td align=\"right\" bgcolor=$color><B>".$row1['total_size_of_land']."</B></td>";

echo "<td align=\"right\" bgcolor=$color><B>&nbsp;</B></td>";
//echo "<td align=\"right\" bgcolor=$color><B>&nbsp;</B></td>";
/*echo "<td align=\"right\" bgcolor=$color><B>&nbsp;</B></td>";
echo "<td align=\"right\" bgcolor=$color><B>&nbsp;</B></td>";
echo "<td align=\"right\" bgcolor=$color><B>&nbsp;</B></td>";
echo "<td align=\"right\" bgcolor=$color><B>&nbsp;</B></td>";
echo "<td align=\"right\" bgcolor=$color><B>&nbsp;</B></td>";*/
echo "<td align=\"right\" bgcolor=$color><B>&nbsp;</B></td>";

// END of Summary -------------------------------------
echo "</table>";
}

footer();

echo "</body>";
echo "</html>";
?>
