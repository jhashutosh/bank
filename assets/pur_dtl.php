<?php
include "../config/config.php";
$staff_id=verifyAutho();
$fy=$_SESSION['fy'];
$menu=$_SESSION['menu'];
getDetailFy($fy,$f_start_dt,$f_end_dt);
$year=$_REQUEST['current_date'];
$months=trim($_REQUEST['months']);
$end_dt=$_REQUEST['end_dt'];
$start_dt=$_REQUEST['start_dt'];
//echo $end_dt;
echo "<head>";
echo "<title>Asset Register";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"table.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">"; 
echo"<table valign=\"top\" width='100%' align=\"center\" bgcolor='#839EB8' class='thead'>"; 
echo"<caption><font color='white'>Asset Purchase Details</font></caption><tr>";
echo"<th align='center' width='12.5%'bgcolor='66CCFF' ><font color='000033'>Asset Id</font></th>";
echo"<th align='center' width='12.5%'bgcolor='66CCFF' ><font color='000033'>Asset Description</font></th>";
echo"<th align='center' width='12.5%'bgcolor='66CCFF' ><font color='000033'>Purchase Date</font></th>";
echo"<th align='center' width='12.5%'bgcolor='66CCFF' ><font color='000033'>Asset Value</font></th>";
echo"<th align='center' width='12.5%'bgcolor='66CCFF' ><font color='000033'>GL Code</font></th>";
echo"<th align='center' width='12.5%'bgcolor='66CCFF' ><font color='000033'>GL mas Description</font></th>";
echo"<th align='center' width='12.5%'bgcolor='66CCFF' ><font color='000033'>GL sub-header Code</font></th>";
echo"<th align='center' width='12.5%'bgcolor='66CCFF' ><font color='000033'>GL subheader Description</font></th>";
echo "</tr><tr><td colspan=\"8\" align=center>";
		echo "<div style=\"overflow-y:auto;max-height:450px\">";
		echo"<table valign=\"top\"width='100%' align='center' class='report'>";
$color="#F0E68C";
$color==$TCOLOR;
//$sql_statement=" select asset_mast_rpt('refcursor')";
$sql_statement="select ast_prchs_rpt('$fy','x')";

$sql_statement.=";fetch all from x";
//echo $sql_statement;
$result=dBConnect($sql_statement);
$a=pg_NumRows($result)-1;
$tvalue=0;
for($j=0;$j<pg_NumRows($result);$j++){
$row=pg_fetch_array($result,$j);
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
echo "<tr>";
echo "<td align=center width='12.5%' bgcolor=$color>".$row['ast_id']."</td>";
echo "<td align=center width='12.5%' bgcolor=$color>".$row['asset_desc']."</td>";
echo "<td align=center width='12.5%' bgcolor=$color>".$row['pur_dt']."</td>";
echo "<td align=center width='12.5%' bgcolor=$color>".$row['asset_value']."</td>";
echo "<td align=center width='12.5%' bgcolor=$color>".$row['gl_code']."</td>";
echo "<td align=center width='12.5%' bgcolor=$color>".$row['gl_mas_desc']."</td>";
echo "<td align=center width='12.5%' bgcolor=$color>".$row['gl_sub_header_code']."</td>";
echo "<td align=center width='12.5%' bgcolor=$color>".$row['gl_sub_header_desc']."</td>";
echo"</tr>";
$tvalue+=$row['asset_value'];
		}
	echo "<tr><th  bgcolor='$color' colspan=\"2\"  width=\"25%\" align='right'>No of Item</th>";
	echo "<th align=center width='25%'  colspan=\"2\" bgcolor=$color>".($a+1)."</th>";
		echo "<th  bgcolor='$color' align='center' colspan=\"2\"  width=\"25%\" align='right'>Total Amount</th>";
	echo "<th align=center width='25%'  colspan=\"2\" bgcolor=$color>".$tvalue."</th></tr>";
		echo"</table></div>";

echo"</td></tr></table>";
echo"</body>";
?>
