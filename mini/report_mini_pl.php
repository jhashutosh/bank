<?
include "../config/config.php";
$mini_id=$_REQUEST['mini'];
$op=$_REQUEST['op'];
$staff_id=verifyAutho();
$fy=$_SESSION['fy'];
echo "<html>";
echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script src=\"../JS/mini_clienthint.js\"></script>";
echo "<body bgcolor=\"\"> ";
echo "<form name=\"f1\" method=\"POST\" action=\"report_mini_pl.php?menu=min&op=display\">";
echo "<table width=\"100%\" bgcolor=\"skyblue\" align=\"center\" ><tr><th align=\"center\" colspan='2'>";
echo "<h2><font color=blue>Mini wise search...</font></h2></th>";
echo "<tr><td width='45%' align=\"right\"><b><i>Mini Name:</td><td align=\"left\" width='55%'>"; 
echo"<select name=\"mini\" onChange=\"f2(this.value);\"><option value='0'>Select</option>";
echo"<option value='0'>All Mini</option>";
$sql="select * from lc_mini_master";
$res=dBConnect($sql);
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
echo $sql;
echo"<option value=\"".$row['id']."\">".$row['mini_name']."</option>";
}
//
echo"</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo"<input type='submit' value='ok'></td><tr>";
echo "</table>";
echo "</form>";
if ($op=='display')
{
echo "<table  width=\"100%\" bgcolor='white'>";
echo "<tr><td bgcolor=\"#BF9FBC\" colspan=\"12\" align=\"center\"><font color=\"#472C44\"><b>Mini wise p/l as on ".date('d.m.Y')."</font>";

echo "<tr>";
$color='#839EB8';
//$TBGCOLOR="#FFFFFF";
//$TCOLOR="#CCDDCC";
$fcolor='black';
		//echo "<th bgcolor=$color width =\"50\" Rowspan=\"2\"><font color=$fcolor>Mini Id</font></th>";
		echo "<th bgcolor=$color width =\"75\" Rowspan=\"2\"><font color=$fcolor>Mini name</font></th>";
		echo"<th bgcolor='lightgreen' colspan='5'><font color='green'>I     N     C     O     M     E";
		echo"<th bgcolor='grey' width='1%' style='border-top:0px solid black;border-bottom:0px solid black;'>";
		echo"<th bgcolor='pink' colspan='4'><font color='dark#F78364'>E   X   P   E   N   D   I   T   U   R   E";
		echo "<th bgcolor=$color width =\"100\" Rowspan=\"2\"><font color=$fcolor>Net P/L</font></th>";
		echo "</tr>";
		echo "<tr><th bgcolor=$color width =\"120\" Rowspan=\"1\"><font color=$fcolor>Op bal Due</font></th>";
		echo "<th bgcolor=$color width =\"120\" Rowspan=\"1\"><font color=$fcolor>Op bal Paid</font></th>";
		echo "<th bgcolor=$color width =\"120\" Rowspan=\"1\"><font color=$fcolor>Water rent Due</font></th>";
		echo "<th bgcolor=$color width =\"120\" Rowspan=\"1\"><font color=$fcolor>Water rent Paid</font></th>";
		echo "<th bgcolor=$color width =\"75\" Rowspan=\"1\"><font color=$fcolor>Tot income</font></th>";
		echo"<th bgcolor='grey'  width='1%'>";
		echo "<th bgcolor=$color width =\"120\" Rowspan=\"1\"><font color=$fcolor>Oprt Sal Due</font></th>";
		echo "<th bgcolor=$color width =\"120\" Rowspan=\"1\"><font color=$fcolor>Oprt Sal Paid</font></th>";	
		echo "<th bgcolor=$color width =\"120\" Rowspan=\"1\"><font color=$fcolor>Sundry Exp</font></th>";
		echo "<th bgcolor=$color width =\"75\" Rowspan=\"1\"><font color=$fcolor>Tot Exp</font></th></tr>";
		
$psql_statement="select mini_rpt_pl($mini_id,'$fy')";
echo $psql_statement;
$presult=dBConnect($psql_statement);
if(pg_NumRows($presult)<0) {
echo "<center>";
echo "<h4><font size=2 color=green><blink> Please Enter Mini Details!!!</blink></font></h4>";
echo "</center>";
} 
else
{	

$sql_statement="select * from lc_mini_rpt_pl ";
$result=dBConnect($sql_statement);
echo $sql_statement;
if(pg_NumRows($result)==0) 	{
echo "<center>";
echo "<h4><font size=2 color=green><blink> Please Enter Customer Mini Details!!!</blink></font></h4>";
echo "</center>";
				} 
else
				{
for($j=0; $j<pg_NumRows($result); $j++) 
	{
	$row=pg_fetch_array($result,$j);
$color='silver';

	echo "<tr>";
	//echo "<td align=Center bgcolor=$color>".$row['mn_id']."</td>";
	echo "<td align=Center bgcolor='#FFDEAD' style='height:22px;'>".ucwords($row['mn_name'])."</td>";
	echo "<td align=Center bgcolor=$color>".$row['opbaldue']."</td>";
	echo "<td align=Center bgcolor=$color>".$row['opbalpd']."</td>";
	echo "<td align=Center bgcolor=$color>".$row['wtrntdue']."</td>";
	echo "<td align=Center bgcolor=$color>".$row['wtrntpd']."</td>";
	echo "<td align=Center bgcolor=$color>".$row['totincome']."</td>";
	echo"<th bgcolor='grey' width='1%'>";
	echo "<td align=Center bgcolor=$color>".$row['opsaldue']."</td>";
	echo "<td align=Center bgcolor=$color>".$row['opsalpd']."</td>";
	echo "<td align=Center bgcolor=$color>".$row['sundryexp']."</td>";

	echo "<td align=Center bgcolor=$color>".$row['totexp']."</td>";
$col=($row['netpl']>0)?'lightgreen':'#F78364';
	echo "<td align=Center bgcolor=$col>".$row['netpl']."</td>";
	}
echo "<tr>";
}}}
echo "</table>";
echo "</body>";
echo "</html>";
?>

