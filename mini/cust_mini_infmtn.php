<?
include "../config/config.php";
echo "<head>";
echo "<title>Mini Report";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"lightblue\">";
echo"<form action='emp_new.php' method='post'>";
//echo $id;
echo"<table valign=\"top\" width='100%' bgcolor='lightblue'>"; 
echo"<tr><th colspan='6' bgcolor='000033' align='center'><font color='white'>*Customer Mini Information*</font></td></tr>";
echo"<td align='center' width='9%'bgcolor='66CCFF' ><font color='000033'>Customer Id</font></td>";
echo"<td align='center' width='13%'bgcolor='66CCFF' ><font color='000033'>Name</font></td>";
echo"<td align='center' width='12%'bgcolor='66CCFF' ><font color='000033'>Father's Name</font></td>";
echo"<td align='center' width='10%'bgcolor='66CCFF'><font color='000033'>Total Land Area</font></td>";
echo"<td align='center' width='18%'bgcolor='66CCFF' ><font color='000033'>Opening Balance</font></td>";
echo"<td align='center' width='8%'bgcolor='66CCFF' ><font color='000033'>Current Balance</font></td>";
echo "<tr><td colspan=\"6\" align=center><iframe src=\"cust_min_frame.php\" width=\"100%\" height=\"200\" ></iframe></td></trs>";
echo"</table>";
echo"</form>";
echo"</body>";
?>
