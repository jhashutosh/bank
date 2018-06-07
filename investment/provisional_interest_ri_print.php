<?php
include "../config/config.php";
$staff_id==verifyAutho();
$menu=$_REQUEST['menu'];
$title=strtoupper($menu);
if($menu=='rd' || $menu=='mis'){$cols=5;}
else{$cols=6;}
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
$sql_statement="SELECT * FROM provissional_interest WHERE trim(deposit_type)='$menu'";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0){
   echo "<br><font size=+3 color=\"RED\"><b>Account Not available at Present</font>";
} else {
$color=$TCOLOR;



echo "<table BGCOLOR=\"YELLOW\" width=\"100%\">";
echo "<tr><td bgcolor=\"BLUE\" colspan=\"9\" align=\"center\"><font color=\"white\"><B>$SYSTEM_TITLE<B></font><font size=+1 color=\"white\"></font>";
echo "<tr><td bgcolor=\"BLUE\" colspan=\"9\" align=\"center\"><font color=\"white\"><B>$VILL_DEFAULT****$DISTRIC_DEFAULT<B></font><font size=+1 color=\"white\"></font>";
echo "<tr><td bgcolor=\"green\" colspan=\"$cols\" align=\"center\"><font color=\"white\">provissional Interest of $menu</font>";

// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color>Account No.</th>";
//echo $menu;
if($menu!='rd' && $menu!='mis' ){
echo "<th bgcolor=$color>Certificate No.</th>";
}


echo "<th bgcolor=$color width\"275\">Name</th>";
//echo "<th bgcolor=$color colspan=\"1\">Opening Date</th>";
//echo "<th bgcolor=$color colspan=\"1\">Maturity Date</th>";
//echo "<th bgcolor=$color colspan=\"1\">Maturity Amount</th>";
echo "<th bgcolor=$color colspan=\"1\">Principal</th>";
echo "<th bgcolor=$color colspan=\"1\">Maturity Date</th>";
echo "<th bgcolor=$color colspan=\"1\">Interest</th>";






for($j=0; $j<pg_NumRows($result); $j++){
	//echo "<table width=\"100%\" bgcolor=\"pink\">";
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
        echo "<tr>";
	$account=$row['account_no'];
	echo "<td align=right bgcolor=$color width=\"93\" align=\"center\"><a href =\"../main/pop_up_account.php?account_no=$account&menu=$menu\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1100,height=700'); return false;\" >".$account."</a></td>";
	if($menu!='rd'){
	echo "<td bgcolor=$color width=\"108\">".$row['cetificate_no']."</td>";
	}
	echo "<td bgcolor=$color width=\"252\">".ucwords($row['name'])."</td>";
	echo "<td align=right bgcolor=$color width=\"108\">".$row['principal']."</td>";
	echo "<td align=right bgcolor=$color width=\"145\">".$row['maturity_date']."</td>";
	echo "<td align=right bgcolor=$color>".$row['interest']."</td>";
$t_p=$t_p+$row['principal'];
$t_i=$t_i+$row['interest'];
	}
}
echo "<tr>";





$color="cyan";
echo "<th align=center bgcolor=$color colspan=".($cols-3)."\"><B>Total: $j<th align=right bgcolor=$color>".amount2Rs($t_p);
echo "<th align=center bgcolor=$color><th align=right bgcolor=$color>".amount2Rs($t_i);
echo "</table>";
echo "</body>";
echo "</html>";
?>
