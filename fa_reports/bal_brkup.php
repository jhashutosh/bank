<?php
include "../config/config.php";
$code=$_REQUEST['id'];
$desc=strtoupper($_REQUEST['desc']);
$color='silver';
echo "<html>";
echo "<head>";
echo "<title>Balance Sheet";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
?>
<script language="JAVASCRIPT">
function closeme() { 
	close(); 
}
function myRefresh(URL){
	window.opener.location.href =URL;
    	self.close();
    	}

</script>
<?php
echo "</head>";
echo"<body bgcolor='006699'>";
echo"<br>";
echo"<table align=\"center\" valign='center' width='90%'  border='1'>";
echo"<tr><th colspan=\"7\" bgcolor='white'>Balance Sheet Break Up</th></tr>";
echo"<tr><th colspan=\"7\" bgcolor='aqua' align='center'>".$desc."[".$code."]</th></tr>";
echo "<tr><th bgcolor=$color colspan=\"1\" width=\"10%\">Schedule</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"45%\">Account Name</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"15%\">Dr Amount</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"15%\">Cr Amount</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"15%\">Balance</th>";
$sql_statement="SELECT gl_mas_code,gl_mas_desc,SUM(dr_amt) dr,SUM(cr_amt)cr ,CASE WHEN CAST(gl_mas_code as INT) BETWEEN 40000 AND 59999 THEN SUM(cr_amt-dr_amt) ELSE SUM(dr_amt-cr_amt) END bal FROM (
SELECT s.gl_mas_code, UPPER(gl_mas_desc) as gl_mas_desc, dr_amt, cr_amt, gl_mas_bl,gl_mas_bl_prv from sch_bs_sh_gm s, gl_master g where g.gl_mas_code=s.gl_mas_code and s.gl_sub_header_code='$code' and gl_mas_bl<>0) AS foo GROUP BY gl_mas_code,gl_mas_desc";
//echo $sql_statement;
$result=dBConnect($sql_statement);
for($j=0; $j<pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	echo "<tr>";
	echo "<td align=left width=\"10%\" bgcolor=$color>".$row['gl_mas_code']."</td>";
	echo "<td width=\"45%\"  bgcolor=$color>".$row['gl_mas_desc']."</td>";
	
	echo "<td align=right width=\"15%\"  bgcolor=$color>".amount2Rs($row['dr'])."</td>";
	
	echo "<td align=right width=\"15%\"  bgcolor=$color>".amount2Rs($row['cr'])."</td>";
	
        echo "<td align=right width=\"15%\"  bgcolor=$color>".amount2Rs($row['bal'])."</td>";
        $dr+=$row['dr'];
        $cr+=$row['cr'];
	$bal+=$row['bal'];
	   
	echo "</tr>";
	}
	$color="AQUA";
	echo "<tr  bgcolor=$color>";
	echo "<td align=left colspan=2>Total:</td>";
	//echo "<td align=right >$T_op_bal";
	echo "<td align=right >$dr";
	echo "<td align=right >$cr";
	echo "<td align=right >$bal";
	echo "</tr>";
echo"</table>";
echo"</form>";
?>

