<?
include "../config/config.php";
//echo "<h1>hi</h1>";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$current_date=$_REQUEST["current_date"];
if(empty($current_date) ) { $current_date=date("d/m/Y"); }
echo "<html>";
echo "<head>";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"cd.focus();\">";
echo "<hr>";
echo "<form name=\"f1\" action=\"sb_current_balance.php?menu=$menu\" method=\"POST\">";
echo "<table align=center bgcolor=\"BLUE\"><tr><td  align=\"center\"><b>Current Balance as on :<td><input type=TEXT size=12 name=current_date id=cd value= $current_date $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.current_date,'dd/mm/yyyy','Choose Date')\">";
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "</table></form>";
echo "<hr><hr>";
//$sql_statement="SELECT current_balance('$current_date') as balance";
$sql_statement="SELECT master.gl_mas_code,initcap(b.gl_mas_desc) as gl_mas_desc, sum(credit-debit) as bal 
FROM 
( SELECT gl_mas_code,sum(debit) as debit, sum(credit) as credit, sum(credit-debit) as bal from mas_gl_tran as a WHERE action_date<=$current_date and gl_mas_code::text >= '10000'::text AND gl_mas_code::text <= '19999'::text GROUP BY gl_mas_code ) 
as master,
gl_master_vw as b 
WHERE master.gl_mas_code= b.gl_mas_code and bs_pl='L' GROUP BY master.gl_mas_code,b.gl_mas_desc HAVING master.gl_mas_code<>'12302' and master.gl_mas_code in('14101','14201','14301','14401')";
//echo $sql_statement;exit;
$result=dBConnect($sql_statement);


if(pg_NumRows($result)==0) {
echo "<h4>Not found!!!</h4>";
} else {
echo "<table width=\"90%\">";
for($j=1; $j<=pg_NumRows($result); $j++){
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j-1));
echo "<tr>";
echo "<td bgcolor=$color><a href=\"sb_current_balance.php?menu=sb&account_no=".$row['gl_mas_code']."\" target=\"_parent\" width=\"100\">".$row['account_no']."</a></td>";
	echo "<td  bgcolor=$color width=\"600\" >".ucwords($row['gl_mas_code'])."</td>";
	echo "<td  bgcolor=$color width=\"600\" >".ucwords($row['gl_mas_desc'])."</td>";
	echo "<td  bgcolor=$color width=\"600\" >".ucwords($row['bal'])."</td>";
	//echo "<td align=right bgcolor=$color width=\"100\">".$row['action_date']."</td>";
	echo "<td align=right bgcolor=$color width=\"\">".$row['bal']."</td>";
	}

echo "</table>";
}


//if(pg_NumRows($result)>0){
// $balance=pg_result($result,'balance');
// settype($balance,'int');
//echo "<center><font color=blue size=+3>Current Balance :</font><font size=+4><b>Rs. ".$balance."/=</font>(";
//money_int2string($balance);
//echo ")</b></center>";
//echo "<table align=CENTER width=85%>";
//echo "<tr bgcolor=YELLOW><th colspan=2>Current Balance as on $current_date";
//echo "<tr bgcolor=SKYBLUE><th>Particulars<th>Balance(Rs)";
//$member_balance=global_sb_current_balance('14101');
//echo "<tr bgcolor=$TBGCOLOR><td><a href=\"sb_current_balance_tabular.php?current_date=$current_date&code=14101&balance=$member_balance\">Member[14101]</a><td align=right><b>$gl_mas_code";
//$shg_balance=global_sb_current_balance('14201');
//echo "<tr bgcolor=$TCOLOR><td><a href=\"sb_current_balance_tabular.php?current_date=$current_date&code=14201&balance=$shg_balance\">SHG[14201]<td align=right><b>$gl_mas_desc";
//$non_balance=global_sb_current_balance('14301');
//echo "<tr bgcolor=$TBGCOLOR><td><a href=\"sb_current_balance_tabular.php?current_date=$current_date&code=14301&balance=$non_balance\">Non-Member[14301]</a><td align=right><b>$bal";
//$nrgs_balance=global_sb_current_balance('14401');
//echo "<tr bgcolor=$TCOLOR><td><a href=\"sb_current_balance_tabular.php?current_date=$current_date&code=14401&balance=$nrgs_balance\">NRGS<td align=right><b>$bal";
//echo "<tr bgcolor=cyan><td align=CENTER><a href=\"sb_current_balance_tabular.php?current_date=$current_date&code=all&balance=$balance\">Total:<td align=RIGHT><b>$balance";
//echo "</table>";
//}



//else{
//echo "<blink><h1><b><center>System Error!!!!!!!</h1>";
//}
echo "</body>";
echo "</html>";

?>
