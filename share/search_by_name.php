<?php
include "../config/config.php";
$mem_no=$_REQUEST['did'];
$del=$_REQUEST['del'];
$op=$_REQUEST['op'];
$q=$_REQUEST['q'];
$where="where name1 like '$q%'";
echo "<html>";
echo "<head>";
echo "<title>List of Members";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script src=\"../JS/loading2.js\"></script>";
echo "<script language=\"JAVASCRIPT\">";
echo "function closeme() { close(); }";
echo "</script>";
?>
<SCRIPT Language="JAVASCRIPT">
function search_mem(str)
{
//alert(str);
show_hint_member(str);
}
</SCRIPT>
<?
echo "</head>";

echo "<body bgcolor=\"silver\">";
echo "</i><hr>";

if($del=='y'){
$dead_sql="update membership_info set membership_status ='d' where membership_no='$mem_no'";
//echo $dead_sql;
$dead_res=dBConnect($dead_sql);
echo "<table bgcolor=\"YELLOW\" width=\"100%\">";
echo "<tr><td bgcolor=\"green\" colspan=\"12\" align=\"center\"><font color=\"yellow\" size=\"6\">Member Register</font>";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> ";
echo"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Search member By Name :&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<input type='text' name='search' value='%' onkeyup=\"search_mem(this.value)\" onfocus=\"search_mem(this.value)\">";
}

$sql_statement="SELECT * from customer_member $where order BY name1";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4>Not found!!!</h4>";
} else {
echo "<table bgcolor=\"YELLOW\" width=\"100%\">";
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
echo "<th bgcolor=$color Rowspan=\"2\">Alive/Daed</th>";
echo "</tr>";
echo "<th bgcolor=$color >Area</th>";
echo "<th bgcolor=$color>Value</th>";
echo "</tr>";
for($j=0; $j<pg_NumRows($result); $j++) {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j));

echo "<tr>";
$mem_id=$row['membership_no'];
echo "<td align=\"Center\" bgcolor=$color>".$row['membership_no']."</a></td>";
echo "<td bgcolor=$color>".ucwords($row['name1'])."</td>";

$value_of_share=$row['share_balance'];
$total_val=$total_val+$value_of_share;
echo "<td align=\"right\" bgcolor=$color>".amount2Rs($value_of_share)."</td>";
echo "<td  bgcolor=$color>".ucwords($row['father_name1'])."</td>";
echo "<td align=\"right\" bgcolor=$color>".ucwords($row['address11'])." ".ucwords($row['address12'])." ".ucwords($row['address13'])."</td>";
echo "<td align=\"right\" bgcolor=$color>".getAcer($row['area_of_land'])."</td>";
echo "<td align=\"right\" bgcolor=$color>".amount2Rs($row['value_of_land'])."</td>";
echo "<td  bgcolor=$color>".$row['customer_id']."</td>";

echo "<td align=\"right\" bgcolor=$color>".$row['date_of_membership']."</td>";
echo "<td align=\"right\" bgcolor=$color>".$sex_array[$row['sex1']]."</td>";
echo "<td align=\"right\" bgcolor=$color>".$caste_array[$row['caste1']]."</td>";
echo "<td align=\"right\" bgcolor=$color>".$row['lf_no']."</td>";
echo"<td bgcolor=$color align=\"center\">";

if($row['membership_status']=='l'){
echo "<a href=\"share_reg_name.php?del=y&did=".$row['membership_no']."\">Alive</a>";
}else{echo "<a href=\"#\"><font color='red'>Dead</font></a>";}
echo"</td></tr>";

}
} 
{
$color="cyan";
echo "<tr>";
echo "<td align=\"center\" bgcolor=$color colspan=2><B>Total: ".$j."</B></td>";
echo "<td align=\"right\" bgcolor=$color ><B>".amount2Rs($total_val)."</B></td>";
echo "<td align=\"right\" bgcolor=$color colspan='10'><B>&nbsp;</B></td>";
echo "</table>";
}
echo "</body>";
echo "</html>";
?>
