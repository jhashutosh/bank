<?
include "../config/config.php";
$frmr_id=$_REQUEST['c'];
echo "<head>";
echo "<title>Mini Usage link";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"lightblue\">";
echo"<form action='min_uge_link.php' method='post'>";
//echo $id;
echo"<table valign=\"top\" width='100%' bgcolor='lightblue'>"; 
echo"<tr><th colspan='5' bgcolor='000033' align='center'><font color='white'>*Mini Usage Information*</font></td></tr>";
echo"<td align='center' width='15%'bgcolor='66CCFF' ><font color='000033'>Mini No.</font></td>";
echo"<td align='center' width='20%'bgcolor='66CCFF' ><font color='000033'> Crop Name</font></td>";
echo"<td align='center' width='20%'bgcolor='66CCFF' ><font color='000033'> Crop Rate</font></td>";
echo"<td align='center' width='15%'bgcolor='66CCFF' ><font color='000033'>Area of Land</font></td>";
echo"<td align='center' width='30%'bgcolor='66CCFF'><font color='000033'>Amount</font></td>";
echo "<tr><td colspan=\"5\" align=center><iframe src=\"min_uge_link_frame.php?c=$frmr_id\" width=\"100%\" height=\"200\" ></iframe></td></trs>";
echo"</table>";
echo"</form>";
echo"</body>";
?>
