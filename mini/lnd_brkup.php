<?
include "../config/config.php";
$c_id=$_REQUEST['c_id'];
$c_name=$_REQUEST['nm'];
$c_fa_name=$_REQUEST['fa_name'];
echo "<head>";
//echo $c_id;
echo "<title>Mini Report";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"#DFB0DA\">";
//echo $id;
echo"<table valign=\"top\" width='100%' bgcolor='#DFB0DA'>"; 
echo"<tr><th colspan='7' bgcolor='#C292BD' align='center'><font color='white'>*Customer Mini Opening Information*</font></td></tr>";
echo"<tr bgcolor='silver'><td>Farmer's Id : </td><td>$c_id</td><td>Farmer's Name :</td><td>$c_name</td><td colspan=''></td><td>Father's Name : </td><td colspan=''>$c_fa_name</td></tr>";
echo"<td align='center' width='10%'bgcolor='66CCFF' ><font color='000033'>Land Id</font></td>";
echo"<td align='center' width='10%'bgcolor='66CCFF' ><font color='000033'>Mouja No</font></td>";
echo"<td align='center' width='10%'bgcolor='66CCFF' ><font color='000033'>JL No</font></td>";
echo"<td align='center' width='10%'bgcolor='66CCFF'><font color='000033'>Mini</font></td>";
//echo"<td align='center' width='10%'bgcolor='66CCFF' ><font color='000033'>Total Land Area</font></td>";
//echo"<td align='center' width='10%'bgcolor='66CCFF' ><font color='000033'>Crop Area Value</font></td>";
echo"<td align='center' width='25%'bgcolor='66CCFF'  colspan='3' ><font color='000033'>Opening</font></td>";
echo "<tr><td colspan=\"7\" align=center><iframe src=\"lnd_brkup_frame.php?c_id=$c_id&nm=$c_name&fa_name=$c_fa_name\" width=\"100%\" height=\"360\" ></iframe></td></trs>";
echo"<tr><form action='cust_mini_infmtn.php' method='post'><td colspan='7' align='right'><input type='submit' value='go back'></form></tr>";
echo"</table>";
echo"</body>";
?>
