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
echo"<caption><font color='white'>Asset Register</font></caption><tr>";
echo"<th align='center' width='15%'bgcolor='66CCFF' ><font color='000033'>Serial No.</font></th>";
echo"<th align='center' width='35%'bgcolor='66CCFF' ><font color='000033'>Asset Master Items</font></th>";
echo"<th align='center' width='25%'bgcolor='66CCFF' ><font color='000033'>Number Of Items</font></th>";
echo"<th align='center' width='25%'bgcolor='66CCFF' ><font color='000033'>Current Value</font></th>";
echo "</tr><tr><td colspan=\"4\" align=center>";
		echo "<div style=\"overflow-y:auto;max-height:450px\">";
		echo"<table valign=\"top\"width='100%' align='center' class='report'>";
$color="#F0E68C";
$color==$TCOLOR;
$sql_statement=" select asset_mast_rpt('refcursor')";
$sql_statement.=";fetch all from refcursor";
//echo $sql_statement;
$result=dBConnect($sql_statement);
$a=pg_NumRows($result)-1;
for($j=0;$j<pg_NumRows($result);$j++){
$row=pg_fetch_array($result,$j);
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
echo "<tr>";

if($j==$a){
	//echo "<th align=center width='15%' bgcolor=$color>".$row['SRL'];
	echo "<th  bgcolor='$color' align='center' colspan=\"2\"  width=\"50%\">".$row['ASSET MASTER']."</th>";
	echo "<th align=center width='25%' bgcolor=$color>".$row['NO. OF ITEM(S)'];
	echo "<th align=center width='25%' bgcolor=$color>".$row['CURRENT VALUE']."</th>";

}
else{
echo "<td align=center width='15%' bgcolor=$color>".$row['SRL'];
echo "<td align=center width='35%' bgcolor=$color><a href=\"asset_mstr_item.php?asst_mstr=".$row['ASSET MASTER']."\" onClick=\"window.open(this.href,'_child','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=250,left=80, width=1300,height=400'); return false;\">".$row['ASSET MASTER']."</a></td>";
echo "<td align=center width='25%' bgcolor=$color>".$row['NO. OF ITEM(S)'];
echo "<td align=center width='25%' bgcolor=$color>".$row['CURRENT VALUE']."</td>";
}
echo"</tr>";
		}
		echo"</table></div>";

echo"</td></tr></table>";
echo"</body>";
?>
