<?
include "../config/config.php";
$staff_id==verifyAutho();
$menu=$_REQUEST['menu'];
$title=strtoupper($menu);
$ending_date=$_REQUEST["ending_date"];
if( empty($ending_date) ) { $ending_date=date("d.m.Y"); }
echo $ending_date;
if($menu=='rd' || $menu=='mis'){$cols=5;}
else{$cols=6;}
if($menu=='fd'){$name="Fixed Deposits";$table="customer_fd"; $no=4;}
if($menu=='ri'){$name="Re Investment Deposits";$table="customer_ri"; $no=4;}
if($menu=='rd'){$name="Recurring Deposits";$table="customer_rd"; $no=4;}
if($menu=='mis'){$name="MIS Deposits";$table="customer_mis"; $no=5;}
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
//$sql_statement="SELECT * FROM provissional_interest WHERE trim(deposit_type)='$menu'";
/*$sql_statement="select a.deposit_type,a.account_no,a.cetificate_no,a.name,a.gl_code,b.principal,a.maturity_date,a.rate_of_int,a.interest 
from 
(select deposit_type,account_no,cetificate_no,name,gl_code,principal,maturity_date,rate_of_int,interest FROM provissional_interest WHERE trim(deposit_type)='$menu') a,
(select account_no,type,gl_mas_code,sum(amount) as principal from rd_detail_view where  action_date<='$ending_date' group by account_no,type,gl_mas_code) b
where a.gl_code=b.gl_mas_code and a.account_no=b.account_no";*/

$sql_statement="select a.deposit_type,a.account_no,a.cetificate_no,a.name,a.gl_code,b.principal,a.maturity_date,a.rate_of_int,a.interest 
from 
(
select deposit_type,account_no,cetificate_no,name,gl_code,principal,maturity_date,rate_of_int,interest FROM provissional_interest WHERE trim(deposit_type)='$menu'
union all
SELECT '$menu' as deposit_type,account_no,certificate_no as cetificate_no,name1 as name,gl_mas_code as gl_code, deposit_balance(account_no,'$ending_date') as principal,maturity_date,0 as rate_of_int,0 as interest  FROM $table WHERE (withdrawal_date IS NULL OR withdrawal_date>'$ending_date') AND action_date<'$ending_date' and account_no not in(select account_no FROM provissional_interest WHERE trim(deposit_type)='$menu' )
) a,
(
select a.account_no,b.certificate_no,b.action_date,b.maturity_date,b.maturity_amount,b.name1,a.balance AS principal
from 
(select account_no,sum(deposit-withdrawal) as balance from
(SELECT account_no,action_date,SUM(case when dr_cr='Cr' THEN amount ELSE 0 END) as deposit,SUM(case when dr_cr='Dr' THEN amount ELSE 0 END) as withdrawal from fd_detail_view group by account_no,action_date having action_date BETWEEN '1980-03-01' AND '$ending_date' ORDER BY action_date DESC) a group by account_no order by account_no) a,
(
SELECT  DISTINCT account_no,certificate_no,action_date,maturity_date,maturity_amount,name1 FROM customer_fd  WHERE certificate_no NOT IN (select certificate_no from $table where withdrawal_date<'$ending_date') ORDER BY account_no
) b
where a.account_no=b.account_no order by account_no
) b
where  a.account_no=b.account_no";
$result=dBConnect($sql_statement);
echo $sql_statement; 
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
