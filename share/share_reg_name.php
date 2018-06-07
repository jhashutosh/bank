<?php
$mem_no=$_REQUEST['did'];
$del=$_REQUEST['del'];
$op=$_REQUEST['op'];
$dod=$_REQUEST['dod'];
include "../config/config.php";
echo "<html>";
echo "<head>";
echo "<title>List of Members";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script src=\"../JS/loading2.js\"></script>";
echo "<script src=\"../JS/calendar.js\"></script>";
?>
<SCRIPT Language="JAVASCRIPT">
function search_mem(str)
{
//alert(str)
show_hint_member(str);
}
</SCRIPT>
<?
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"search_mem('%')\">";
echo "</i><hr>";
if($del=='y'){
$sql="select initcap(name1) as n,initcap(father_name1),membership_no from customer_member where membership_no='$mem_no'";
//echo $sql;
$res=dBConnect($sql);
$row=pg_fetch_array($res,0);
echo"<div align='center'><table bgcolor='red' width='70%'><tr><th bgcolor='red'><font color='white'>Membership No</th><th bgcolor='red'><font color='white'>Name</th><th bgcolor='red'><font color='white'>Father's Name</th></tr><tr><td align='center'  bgcolor='white'>".$row['membership_no']."</td><td align='center'  bgcolor='white'>".$row['n']."</td><td align='center' bgcolor='white'>".$row['initcap']."</td></tr><tr><td colspan='3' align='center' bgcolor='white'><h2><font color='darkblue'>Is ".$row['n']." really Dead ?? </h2></td></tr><tr><td colspan='3' align='center'><form name='f1' action='share_reg_name.php?del=y&did=$mem_no&op=d' method='post'>Date of Death :<input type='text' name='dod' id='dod' size='10' $HIGHLIGHT>&nbsp<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.dod,'dd/mm/yyyy','Choose Date')\"></td></tr><tr><td colspan='2' align='center'><input type='submit' name='submit' value='yes'></form></td><td align='left'><form action='share_reg_name.php' method='post'><input type='submit' name='submit' value='No'></form></td></tr></table></div>";
if($op=='d'){
$dead_sql="update membership_info set membership_status ='d',death_date='$dod' where membership_no='$mem_no'";
$dead_res=dBConnect($dead_sql);
header("Location: ../share/share_reg_name.php");
}}
echo "<table bgcolor=\"YELLOW\" width=\"100%\">";
echo "<tr><td bgcolor=\"green\" colspan=\"12\" align=\"center\"><font color=\"yellow\" size=\"6\">Share Register By Name</font>";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> ";
echo"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Search member By Name :&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<input type='text' name='search' onkeyup=\"search_mem(this.value)\">";
?>
<span id="txtHint"></span>
<?
echo "</body>";
echo "</html>";
?>
