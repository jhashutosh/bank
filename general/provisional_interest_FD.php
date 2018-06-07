<?php
include "../config/config.php";
$staff_id==verifyAutho();
$menu=$_REQUEST['menu'];
$title=strtoupper($menu)." Provissional Interest";
$ending_date=$_REQUEST["ending_date"];
if( empty($ending_date) ) { $ending_date=date("d.m.Y"); }
if($menu=='rd' || $menu=='mis'){$cols=5;}
else{$cols=6;}
if($menu=='fd'){$name="Fixed Deposits";$table="customer_fd"; $table1="fd_detail_view"; $no=4;}
if($menu=='ri'){$name="Re Investment Deposits";$table="customer_ri"; $no=4;}
if($menu=='rd'){$name="Recurring Deposits";$table="customer_rd"; $no=4;}
if($menu=='mis'){$name="MIS Deposits";$table="customer_mis"; $no=5;}
echo "<html>";
echo "<head>";
echo "<title>$title";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"ed.focus();\">";
echo "<hr>";
echo "<form method=\"POST\" action=\"provisional_interest.php?menu=$menu\">";
echo "<table width=\"100%\" bgcolor=\"YELLOW\"><tr>";
echo "<th>$title as on:<th><input type=\"TEXT\" name=\"ending_date\" id=\"ed\" size=\"15\" value=\"$ending_date\" $HIGHLIGHT>";
echo "&nbsp <input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Submit\">";
echo "</table></form>";
echo "<hr>";
$sql_statement="SELECT compute_main_deposit_pint('$menu','$ending_date') AS pint";
$result=dBConnect($sql_statement);
//echo $sql_statement; 
//echo $ending_date;
if(pg_NumRows($result)==0){
	echo "<br><font color=\"RED\">Failed to calculate.</font>";
} 
else{
	$current_balance=pg_result($result,'pint');
echo "<font size=\"+2\" color=\"GREEN\"><center>Total Payable Interest&nbsp;:&nbsp;&nbsp;<font color=\"BLUE\"<B>Rs.".amount2Rs($current_balance)."/=</B></font></font>";
echo "<table width=\"100%\">";
echo "<tr><th bgcolor=\"green\" colspan=\"$cols\" align=\"center\"><font color=\"white\">$title List</font>";
//Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color width=\"75\">Account No.</th>";
if($menu!='rd'){
echo "<th bgcolor=$color width=\"75\">Certificate No.</th>";
}
echo "<th bgcolor=$color width=\"175\">Name</th>";
echo "<th bgcolor=$color width=\"75\">Principal</th>";
echo "<th bgcolor=$color width=\"100\">Maturity Date</th>";
echo "<th bgcolor=$color width=\"100\">Interest</th>";
echo "<tr><td colspan=\"$cols\" align=center><iframe src=\"provisional_interest_db.php?menu=$menu\" width=\"100%\" height=\"300\" ></iframe>";
echo "<tr>";
//$sql_statement="SELECT SUM(principal) AS p,COUNT(*) as c,SUM(interest) AS i FROM provissional_interest WHERE trim(deposit_type)='$menu'";
$sql_statement="SELECT SUM(b.principal) AS p,COUNT(b.account_no) as c,SUM(a.interest) AS i 
from 
(
select deposit_type,account_no,cetificate_no,name,gl_code,principal,maturity_date,rate_of_int,interest FROM provissional_interest WHERE trim(deposit_type)='$menu'
union all
SELECT '$menu' as deposit_type,account_no,certificate_no as cetificate_no,name1 as name,gl_mas_code as gl_code, deposit_balance(account_no,'$ending_date') as principal,maturity_date,0 as rate_of_int,0 as interest  FROM $table WHERE (withdrawal_date IS NULL OR withdrawal_date>'$ending_date') AND action_date<'$ending_date' and account_no not in(select account_no FROM provissional_interest WHERE trim(deposit_type)='$menu' )
) a,
(select a.account_no,b.certificate_no,b.action_date,b.maturity_date,b.maturity_amount,b.name1,a.balance AS principal
from 
(select account_no,sum(deposit-withdrawal) as balance from
(SELECT account_no,action_date,SUM(case when dr_cr='Cr' THEN amount ELSE 0 END) as deposit,SUM(case when dr_cr='Dr' THEN amount ELSE 0 END) as withdrawal from $table1 group by account_no,action_date having action_date BETWEEN '1980-03-01' AND '$ending_date' ORDER BY action_date DESC) a group by account_no order by account_no) a,
(
SELECT  DISTINCT account_no,certificate_no,action_date,maturity_date,maturity_amount,name1 FROM customer_fd  WHERE certificate_no NOT IN (select certificate_no from $table where withdrawal_date<'$ending_date') ORDER BY account_no
) b
where a.account_no=b.account_no order by account_no) b
where  a.account_no=b.account_no";

/*$sql_statement="select a.account_no,b.certificate_no,b.action_date,b.maturity_date,b.maturity_amount,b.name1,a.balance 
from 
(select account_no,sum(deposit-withdrawal) as balance from
(SELECT account_no,action_date,SUM(case when dr_cr='Cr' THEN amount ELSE 0 END) as deposit,SUM(case when dr_cr='Dr' THEN amount ELSE 0 END) as withdrawal from fd_detail_view group by account_no,action_date having action_date BETWEEN '1980-03-01' AND '$end_date' ORDER BY action_date DESC) a group by account_no order by account_no) a,
(
SELECT  DISTINCT account_no,certificate_no,action_date,maturity_date,maturity_amount,name1 FROM customer_fd  WHERE certificate_no NOT IN (select certificate_no from customer_fd where withdrawal_date<'$end_date') ORDER BY account_no
) b
where a.account_no=b.account_no order by account_no";*/
//echo $sql_statement; 
$result=dBConnect($sql_statement);
$count_row=pg_result($result,'c');
$t_p=pg_result($result,'p');
$t_i=pg_result($result,'i');
$color="cyan";
echo "<th align=center bgcolor=$color colspan=\"3\"><B>Total: $count_row<th align=right bgcolor=$color>".amount2Rs($t_p);
echo "<th align=center bgcolor=$color><th align=right bgcolor=$color>".amount2Rs($t_i);
echo "</table>";
}
echo "</body>";
echo "</html>";
?>
