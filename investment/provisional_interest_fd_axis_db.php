<?php
include "../config/config.php";
$staff_id==verifyAutho();
$menu=$_REQUEST['menu'];
$title=strtoupper($menu);
if($menu=='rd' || $menu=='mis'){$cols=5;}
else{$cols=6;}
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
$sql_statement="SELECT * FROM provissional_interest WHERE trim(deposit_type)='fa'";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0){
   echo "<br><font size=+3 color=\"RED\"><b>Account Not available at Present</font>";
} else {
$color=$TCOLOR;
for($j=0; $j<pg_NumRows($result); $j++){
	echo "<table width=\"100%\" bgcolor=\"pink\">";
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
	}
}
echo "</table>";
echo "</body>";
echo "</html>";
?>
