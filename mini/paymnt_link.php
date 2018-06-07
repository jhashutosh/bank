<?
include "../config/config.php";
$op_id=$_REQUEST['c'];
$operator=$_REQUEST['name'];
$mini=$_REQUEST['mini_id'];
echo "<head>";
echo "<title>Personal statement";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"lightblue\">";
$color='#66CCFF';
echo"<form action='paymnt_link.php?op=v' method='post'>";
echo"<table width='40%' align='center'><tr bgcolor='#8C80C8'><th align='center'>Operator's Name :  $operator</th></tr></table>";
//Mini Id : </th><th>$mini</th>";
echo"<table valign=\"top\" align='center' width='100%'>"; 
echo"<tr><th colspan='8' bgcolor='grey' align='center'><font color='white'>*Payment Details*</font></td></tr>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width='15%'><font color='black' size='2'>Bill No</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width='15%'><font color='black' size='2'>Mini Name</font></td>";
echo"<td  bgcolor='$color' align='center' colspan=\"1\"  width='15%'><font color='black' size='2'>Total Salary Amount</font></td>";
echo"<td  bgcolor='$color' align='center' colspan=\"1\"  width='15%'><font color='black' size='2'>Due Amount</font></td>";
echo"<td  bgcolor='$color' align='center' colspan=\"1\"  width='25%'><font color='black' size='2'>Payment</font></td>";
echo"</tr>";
echo "<tr><td colspan=\"5\" align=center><iframe src=\"paymnt_dtls.php?c=$op_id&name=$operator&mini_id=$mini\" width=\"100%\" height=\"200\" ></iframe></td></tr>";
echo"</table>";
echo"</form>";
echo"</body>";

?>
