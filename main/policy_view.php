<?php
include "../config/config.php";
$staff_id=verifyAutho();
$op=$_REQUEST['op'];
$id=$_REQUEST['id'];
echo "<html>";
echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"id.focus();\">";
if($op=='kcc'){$name='KCC';$id_name='crop_id';}
if($op=='pl'){$name='PL';$id_name='crop_id';}
if($op=='mt'){$name='MT';$id_name='crop_id';}
if(!empty($id)){
	$arr=explode(",",$id); // Multiple entry seperated by ,
	$n=count($arr);
	$WHERE_CONDITIONS=""; 
	for($i=0; $i<($n-1);$i++){
		$WHERE_CONDITIONS="$WHERE_CONDITIONS $id_name='$arr[$i]' OR ";
	}
 
	$WHERE_CONDITIONS="WHERE loan_type='$op' AND $WHERE_CONDITIONS $id_name='$arr[$i]'"; 
	
} else {
	$WHERE_CONDITIONS="WHERE loan_type='$op'"; 
}

$sql_statement="SELECT * from loan_policy $WHERE_CONDITIONS";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_num_rows($result)<1) {
echo "<center><font color=\"#55332200\" size=6><blink><b>!!! There is no new Policy !!!</b></blink></font></center>";
} else {
if($op=='kcc'){
echo "<form method=\"POST\" action=\"policy_view.php?op=$op\">";
echo "<font size=+2><b><I>Specify the searching criteria: </I></font>";
echo "<tr><td align=\"right\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 Crop ID: <input type=\"TEXT\" name=\"id\" id=\"id\" size=\"10\" value=\"$id\" $HIGHLIGHT>";
echo "&nbsp; <input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"go\">";
echo "</table>";
echo "</form>";
echo "<hr>";
}

echo "<table valign=\"top\" width=\"100%\" align=\"center\">";
$color=$TCOLOR;
echo "<tr><td bgcolor=\"GREEN\" colspan=\"14\" align=\"center\"><font color=\"white\" size=2><b>$name DETAILS OF FARMER & CCB</b></font>";
echo "<tr>";
if($op=='kcc')
{
echo "<th bgcolor=$color rowspan=\"2\">Crop Name</th>";
}
echo "<th bgcolor=$color colspan=\"3\">Date</th>";
if($op=='kcc'){
echo "<th bgcolor=$color rowspan=\"2\">Financial<br>Year</th>";
//echo "<th bgcolor=$color rowspan=\"2\">Crop Name</th>";
echo "<th bgcolor=$color rowspan=\"2\">Minimum<br>Land(satak)</th>";
echo "<th bgcolor=$color rowspan=\"2\">Credit Limit</th>";
echo "<th bgcolor=$color rowspan=\"2\">Insurance<br>Crop(%)</th>";
}
echo "<th bgcolor=$color colspan=\"2\">Interest Rate take from Farmer</th>";
echo "<th bgcolor=$color colspan=\"2\">Interest Rate give to CCB</th>";
echo "<th bgcolor=$color rowspan=\"2\">Staff</th>";
echo "<th bgcolor=$color rowspan=\"2\">Operation</th><tr>";
echo "<th bgcolor=$color colspan=\"1\">Start</th>";
echo "<th bgcolor=$color colspan=\"1\">End</th>";
echo "<th bgcolor=$color colspan=\"1\">Repay</th>";
echo "<th bgcolor=$color colspan=\"1\">Due(%)</th>";
echo "<th bgcolor=$color colspan=\"1\">Overdue(%)</th>";
echo "<th bgcolor=$color colspan=\"1\">Due(%)</th>";
echo "<th bgcolor=$color colspan=\"1\">Overdue(%)</th>";
for($j=1; $j<=pg_NumRows($result); $j++) {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j-1));
echo "<tr>";
if($op=='kcc')
{
echo "<td  bgcolor=$color>".getName('crop_id',trim($row[3]),'crop_desc','crop_mas')."</td>";
}
echo "<td  bgcolor=$color align=center>".$row[1]."</td>";
echo "<td  bgcolor=$color align=center>".$row[2]."</td>";
echo "<td  bgcolor=$color align=center>".$row[10]."</td>";
if($op=='kcc'){
echo "<td  bgcolor=$color align=right>".$row['fy']."</td>";
//echo "<td  bgcolor=$color>".getName('crop_id',trim($row[3]),'crop_desc','crop_mas')."</td>";
echo "<td  bgcolor=$color align=right>".$row[4]."</td>";
echo "<td  bgcolor=$color align=right>".(float)$row[5]."</td>";
echo "<td  bgcolor=$color align=right>".(float)$row['crop_insurance']."</td>";

}
echo "<td  bgcolor=$color align=right>".$row[6]."%</td>";
echo "<td  bgcolor=$color align=right>".$row[7]."%</td>";
//-----------------------new for ccb-------------------------
$value=0;
echo "<td  bgcolor=$color align=right>".$value."%</td>";
echo "<td  bgcolor=$color align=right>".$value."%</td>";

echo "<td  bgcolor=$color align=right>".$row[8]."</td>";
echo "<td align=center bgcolor=$color><A HREF=\"policy_master.php?menu=$op\">New</a>&nbsp;||&nbsp<A HREF=\"policy_master.php?menu=".$row[0]."&op=up&fy=".$row['fy']."\" $HIDERESORCE>Alter</a></td>";





}
echo "<tr>";
$color="cyan";
echo "<th bgcolor=$color colspan=14>Total:".($j-1)."</td>";

echo "</table>";
}
echo "</body>";
echo "</html>";
?>
