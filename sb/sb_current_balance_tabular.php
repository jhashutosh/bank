<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$current_date=$_REQUEST['current_date'];
$status=$_REQUEST['code'];
//echo "status is:$status==$menu==$current_date==";
if(empty($current_date) ) {$current_date=date("d/m/Y");}
$balance=$_REQUEST['balance'];
//echo $balance;
if($menu=='sb'){
if($status=="14101"){$person="Individual Member";}
if($status=="14201"){$person="SHG";}
if($status=="14301"){$person="Individual Non-Member";}
if($status=="14401"){$person="NRGS";}
if($status=="all"){$person="All";}
}
if($menu=='sh'){
if($status=="11200"){$person="Individual Member";}
if($status=="11300"){$person="SHG";}
if($status=="11100"){$person="Government";}
if($status=="11900"){$person="Other";}
if($status=="all"){$person="All";}
}

if(empty($balance) ) { 
	$sql_statement="SELECT current_balance('$current_date') as balance";
	$result=dBConnect($sql_statement);
	if(pg_NumRows($result)>0){
//echo $sql_statement;
		if($status=="all"){
		$balance=pg_result($result,'balance');
 		settype($balance,'int');
		}
		else{
	 	$balance=global_sb_current_balance($status,$current_date);
		}
 	   }
	else{	
		$balance=amount2Rs(global_sb_current_balance($status,$current_date));
		//$balance=0;
  	    }
    }
echo "<html>";
echo "<head>";
echo "<title>Saving Bank Current Balance";
echo "</title>";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"cd.focus();\">";
echo "<hr>";
echo "<form name=\"f1\" action=\"sb_current_balance_tabular.php?menu=$menu&code=$status\" method=\"POST\">";
echo "<table align=center bgcolor=\"BLUE\"><tr><td  align=\"center\"><b>Current Balance as on :<td><input type=TEXT size=12 name=current_date id=cd value=$current_date $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.current_date,'dd/mm/yyyy','Choose Date')\">";
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "</table></form>";
echo "<hr>";
echo "<table align=center width=\"\">";
echo "<tr><td bgcolor=\"green\" colspan=\"3\" align=\"center\"><font color=\"white\">Current Balance of $person as on $current_date</font><font size=+1 color=\"Black\"<B>[Rs.$balance]</font></b>";
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color width=\"110\">A/C No.</th>";
echo "<th bgcolor=$color width=\"600\">Name</th>";
//echo "<th bgcolor=$color colspan=\"1\">Last Transaction Date</th>";
echo "<th bgcolor=$color colspan=\"1\">Balance</th>";
echo "<tr><td colspan=\"3\" align=\"center\"><iframe style='BORDER: solid 0px;' src=\"sb_current_balance_tabular_db.php?status=$status&menu=$menu&current_date=$current_date\" width=\"850\" height=\"310\" ></iframe></td></tr>";
echo "<tr>";
$color="cyan";
echo "<td align=center bgcolor=$color colspan=2><B>Total</B></td>";
echo "<td align=right bgcolor=$color><B>".$balance."</B></td>";
echo "</table>";
echo "</body>";
echo "</html>";
?>
