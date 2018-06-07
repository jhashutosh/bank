<?php
include "../config/config.php";
$staff_id=verifyAutho();
echo "<html>";
echo "<head>";
echo "<title>Jlg group List";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
//echo "<h3><u><font color =\"red\"></h3></u></font>";
echo "<h1> No. of existing JLG groups ";
echo "</h1>";
echo "<hr>";
$sql_statement="SELECT *  FROM jlg_group_list";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h1>Record Not Found !!!!!!!!!</h1>";
} 
else {


$mgroup=pg_result($result,'mcount');
 $fgroup=pg_result($result,'fcount');
$ugroup=pg_result($result,'ucount');
$mcs=pg_result($result,'mcscount');
$mct=pg_result($result,'mctcount');
$mobc=pg_result($result,'mobccount');
$mgen=pg_result($result,'mgencount');
$fcs=pg_result($result,'fsccount');
$fct=pg_result($result,'fctcount');
$fobc=pg_result($result,'fobccount');
$fgen=pg_result($result,'fgencount');
$nmale=pg_result($result,'nmale');
$nfemale=pg_result($result,'nfemale');
$u_me_no=pg_result($result,'u_me_no');
$u_fe_no=pg_result($result,'u_fe_no');
$ucscount=pg_result($result,'ucscount');
$uctcount=pg_result($result,'uctcount');
$uobccount=pg_result($result,'uobccount');
$ugencount=pg_result($result,'ugencount');
$tcs=$mcs+$ucscount+$fcs;
$tct=$mct+$fct+$uctcount;
$tgen=$mgen+$fgen+$ugencount;
}
$member=$mgroup+$fgroup+$ugroup;


//echo $mct;
	echo "<table bgcolor=BLACK width=\"80%\" align=\"CENTER\">";

echo "<tr><th bgcolor=\"green\" colspan=\"9\" align=\"center\"><font color=\"white\">Division of Jlg group</font>";

// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color >Jlg Member</th>";
echo "<th bgcolor=$color >No. of groups</th>";
echo "<th bgcolor=$color >No.of Male</th>";
echo "<th bgcolor=$color >No.of Female</th>";
echo "<th bgcolor=$color >No.of SC</th>";
echo "<th bgcolor=$color >No.of ST</th>";
echo "<th bgcolor=$color >No.of OBC</th>";
echo "<th bgcolor=$color >General</th>";
echo "<th bgcolor=$color >Total No.Of Person</th>";
$color=$TCOLOR;
	echo "<tr>";
	echo "<td bgcolor=$color><a href=\"shg_male.php\" target=\"display\">Male</a></td>";
	echo "<td align=right bgcolor=\"pink\">$mgroup</td>";
        echo "<td align=right bgcolor=$color>$nmale</td>";
        echo "<td align=right bgcolor=$color>**</td>";
	echo "<td align=right bgcolor=$color>$mcs</td>";
	echo "<td align=right bgcolor=$color>$mct</td>";
	echo "<td align=right bgcolor=$color>$mobc</td>";
	echo "<td align=right bgcolor=$color>$mgen</td>";
	echo "<td align=right bgcolor=$color>$nmale</td>";
echo "<tr>";
	echo "<td bgcolor=$color><a href=\"shg_female.php\" target=\"display\">Female</a></td>";

	echo "<td align=right bgcolor=\"pink\":wq
>$fgroup</td>";
       echo "<td align=right bgcolor=$color>***</td>";
        echo "<td align=right bgcolor=$color>$nfemale</td>";
	echo "<td align=right bgcolor=$color>$fcs</td>";
        echo "<td align=right bgcolor=$color>$fct</td>";
        
	echo "<td align=right bgcolor=$color>$fobc</td>";
	echo "<td align=right bgcolor=$color>$fgen</td>";
	echo "<td align=right bgcolor=$color>$nfemale</td>";
echo"<tr>";
	echo "<td bgcolor=$color><a href=\"shg_mixed.php\" target=\"display\">Mixed</a></td>";
	echo "<td align=right bgcolor=\"pink\">$ugroup</td>";
         echo "<td align=right bgcolor=$color>$u_me_no</td>";
        echo "<td align=right bgcolor=$color>$u_fe_no</td>";
   $utotal=$u_me_no+$u_fe_no;
	echo "<td align=right bgcolor=$color>$ucscount</td>";
	echo "<td align=right bgcolor=$color>$uctcount</td>";
	echo "<td align=right bgcolor=$color>$uobccount</td>";
	echo "<td align=right bgcolor=$color>$ugencount</td>";
//	echo "<td align=right bgcolor=$color></td>";
/*{
$i++;
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,($j-1));
	echo "<tr>";
//	echo "<td align=right bgcolor=$color><a href=\"set_account.php?account_no=".$row['account_no']."&menu=fd\" target=\"target\">".$row['account_no']."</a></td>";*/
//echo"<tr>";
	echo "<td align=right bgcolor=$color>$utotal</td>";
//}
echo "<tr>";
$color="cyan";
echo "<td align=center bgcolor=$color><B>Total </B></td>";
echo "<td align=right bgcolor=$color><B>$member</B></td>";
echo "<td align=right bgcolor=$color><B></B></td>";
echo "<td align=right bgcolor=$color><B></B></td>";
echo "<td align=right bgcolor=$color><B>$tcs</B></td>";
echo "<td align=right bgcolor=$color><B>$tct</B></td>";
echo "<td align=right bgcolor=$color><B>".($mobc+$fobc+$uobccount)."</B></td>";
echo "<td align=right bgcolor=$color><B>$tgen</B></td>";
 echo "<td align=right bgcolor=$color><B>".($nmale+$nfemale+$utotal)."</B></td>";

//echo "<td align=right bgcolor=$color><B>".$total_interest_amount."</B></td>";
//echo "<td align=right bgcolor=$color><B></B></td>";
//echo "<td align=right bgcolor=$color><B>".$total_maturity_amount."</B></td>";
echo "</table>";



echo "<br>";

footer();

echo "</body>";
echo "</html>";
?>
