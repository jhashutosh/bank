<?php
include "../config/config.php";
$staff_id==verifyAutho();
$menu=$_REQUEST['menu'];
$title=strtoupper($menu)." Provissional Interest";
$ending_date=$_REQUEST["ending_date"];
//echo "<h1>$ending_date</h1>";
if(empty($ending_date)) { $ending_date=date("d.m.Y"); 
				
			$sql_statement="DELETE FROM provissional_interest;SELECT compute_main_deposit_pint('$menu','$ending_date') AS pint";
			$flag=1;
			$ZERO=0;
}
else{	
		$sql_statement="DELETE FROM provissional_interest;SELECT compute_main_deposit_pint('$menu','$ending_date') AS pint";

//echo $sql_statement;	
		$ZERO=0;	
		}
if($menu=='rd' || $menu=='mis'){$cols=6;}
else{$cols=6;}
echo "<html>";
echo "<head>";
echo "<title>$title";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"ed.focus();\">";
echo "<hr>";
echo "<form method=\"POST\" action=\"provisional_interest.php?menu=$menu\">";
echo "<table width=\"100%\" bgcolor=\"YELLOW\" ><tr>";
echo "<th>$title as on:<th><input type=\"TEXT\" name=\"ending_date\" id=\"ed\" size=\"15\" value=\"$ending_date\" $HIGHLIGHT>";
echo "&nbsp <input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Submit\">";
echo "</table></form>";
echo "<hr>";


$result=dBConnect($sql_statement);
if(!empty($ZERO)){
//echo $sql_statement; 
if(empty($flag)){
	if(pg_affected_rows($result)<1){
		echo "<br><font color=\"RED\">Failed to calculate.</font>";
		} 
	}
else{
	if(pg_NumRows($result)==0){
		echo "<br><font color=\"RED\">Failed to calculate.</font>";
		} 
	}


}
else{
$sql_statement="SELECT SUM(principal) AS p,COUNT(*) as c,SUM(interest) AS i FROM provissional_interest WHERE trim(deposit_type)='$menu'";
$result=dBConnect($sql_statement);
//echo $sql_statement; 
$count_row=pg_result($result,'c');
$t_p=pg_result($result,'p');
$t_i=pg_result($result,'i');	
echo "<font size=\"+2\" color=\"GREEN\"><center>Total Payable Interest&nbsp;:&nbsp;&nbsp;<font color=\"BLUE\"<B>Rs.".amount2Rs($t_i)."/=</B></font></font>";
echo "<table width=\"100%\"  border=solid .5px black cellspacing=0 cellpadding=0>";
echo "<tr><th bgcolor=\"green\" colspan=\"$cols\" align=\"center\"><font color=\"white\">$title List</font>";
//Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color width=\"75\">Account No.</th>";
echo "<th bgcolor=$color width=\"75\">Certificate No.</th>";
echo "<th bgcolor=$color width=\"175\">Name</th>";
echo "<th bgcolor=$color width=\"75\">Principal</th>";
echo "<th bgcolor=$color width=\"100\">Maturity Date</th>";
echo "<th bgcolor=$color width=\"100\">Interest</th></tr>";
$sql_statement="SELECT * FROM provissional_interest WHERE trim(deposit_type)='$menu' order by cast(substr(account_no,position ('-' in account_no)+1) as integer)";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0){
   echo "<br><font size=+3 color=\"RED\"><b>Account Not available at Present</font>";
} else {
$color=$TCOLOR;
for($j=0; $j<pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
        echo "<tr>";
	$account=$row['account_no'];
	echo "<td align=right bgcolor=$color width=\"93\" align=\"center\"><a href =\"../main/pop_up_account.php?account_no=$account&menu=$menu\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1100,height=700'); return false;\" >".$account."</a></td>";
	//if($menu!='rd'){
	echo "<td bgcolor=$color width=\"108\">".$row['cetificate_no']."</td>";
	//}
	echo "<td bgcolor=$color width=\"252\">".ucwords($row['name'])."</td>";
	echo "<td align=right bgcolor=$color width=\"108\">".$row['principal']."</td>";
	echo "<td align=right bgcolor=$color width=\"145\">".$row['maturity_date']."</td>";
	echo "<td align=right bgcolor=$color>".$row['interest']."</td></tr>";
	}
}

$color="cyan";
echo "<tr><th align=center bgcolor=$color colspan=\"3\"><B>Total: $count_row<th align=right bgcolor=$color>".amount2Rs($t_p);
echo "<th align=center bgcolor=$color><th align=right bgcolor=$color>".amount2Rs($t_i);
echo "</table>";
}
echo "</body>";
echo "</html>";
?>
