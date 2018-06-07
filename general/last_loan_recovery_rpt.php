<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$op=$_REQUEST['op'];
$current_date=$_REQUEST["current_date"];
echo "<script src=\"../JS/calendar.js\"></script>";
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";
if(empty($current_date) ) { $current_date=date("d/m/Y"); }
if(empty($start_date) ){$start_date=date("d/m/Y",time()-31536000);}
if($menu=='pl'){
		$l_name='PLEDGE';
		$type='PL-';
		$s_page="../pl/pl_statement.php?menu=pl&op=i&account_no=";
		}
if($menu=='kcc'){
		$l_name='KCC';
		$type='KCC-';
		$s_page="../kcc/kcc_loan_statement.php?menu=kcc&op=i&account_no=";
		}
if($menu=='ofl'){
		$l_name='Own Fund';
		$s_page="../ofl/sfl_statement.php?menu=ofl&op=i&account_no=";
		}



if($menu=='ccl'){
		$l_name='Cash Credit';
		$type='CCL-';
		$s_page="../ccl/ccl_statement.php?menu=ccl&op=i&account_no=";
		}
if($menu=='kpl'){
		$l_name='Kishan Bikhash Pathra';
		$type='KPL-';
		$s_page="../kpl/kpl_statement.php?menu=kpl&op=i&account_no=";
		}
if($menu=='spl'){
		$l_name='SMP';
		$type='SPL-';
		$s_page="../spl/spl_statement.php?menu=spl&op=i&account_no=";
		}
if($menu=='bdl'){
		$l_name='Bond';
		$type='BDL-';
		$s_page="../bdl/bdl_statement.php?menu=bdl&op=i&account_no=";
		}
if($menu=='sfl'){
		$l_name='Staff';
		$type='SFL-';
		$s_page="../sfl/sfl_statement.php?menu=sfl&op=i&account_no=";
		}

if($menu=='mt'){
		$type='MT-';
		$l_name='MT';
		$s_page="../mtloan/mtloan_statement.php?menu=mt&op=i&account_no=";
		}
if($menu=='shg'){
		$l_name='SHG';
		$i_page="../shg/shg_loan_ledger_ef.php?menu=shg&account_no=";
		}
echo "<script language=\"JAVASCRIPT\">";
echo "function closeme() { close(); }";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<body bgcolor=\"\">";
echo "<hr>";
echo "<form name=\"f1\" action=\"last_loan_recovery_rpt.php?menu=$menu\" method=\"POST\">";
echo "<table align=center bgcolor=\"#90EE90\"><tr><td  align=\"\"><b>Report Date FROM :<td><input type=TEXT size=12 name=start_date id=cd value=$start_date $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.start_date,'dd/mm/yyyy','Choose Date')\">";
echo "&nbsp; <b>TO :&nbsp;<input type=TEXT size=12 name=current_date id=cd value=$current_date $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.current_date,'dd/mm/yyyy','Choose Date')\">";
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> ";
echo "</table></form>";
echo "<hr>";

//$sql_statement=" SELECT account_no,SUM(r_due_int) as d,SUM(r_overdue_int) as o,SUM(r_principal) as p FROM loan_statement WHERE tr_type='R' AND (action_date BETWEEN '$start_date' AND '$current_date') AND account_no LIKE '$type%' GROUP BY account_no HAVING (SUM(r_due_int)>0 OR SUM(r_overdue_int)>0 OR SUM(r_principal)>0)";


$sql_statement="SELECT a.account_no, a.action_date, b.tr_type,c.loan_amount,b.r_due_int, b.r_overdue_int,b.r_principal, b.b_due_int, b.b_overdue_int,b.b_principal from ( SELECT a.account_no, max(a.action_date) as action_date from loan_statement a,loan_ledger_hrd b where a.loan_serial_no=b.loan_serial_no and b.loan_type='$menu' and a.tr_type='R' and (a.action_date BETWEEN '$start_date' AND '$current_date') group by a.account_no ) a, loan_statement b, ( select a.account_no,max(a.tran_id) tran_id ,a.loan_amount from loan_statement a,loan_ledger_hrd b where a.loan_serial_no=b.loan_serial_no and b.loan_type='$menu' and a.tr_type='I' and (a.action_date BETWEEN '$start_date' AND '$current_date') group by a.account_no,a.loan_amount ) c where a.account_no=b.account_no and a.account_no=c.account_no and a.action_date=b.action_date and (b.action_date BETWEEN '$start_date' AND '$current_date') and b.tr_type='R' and (b.r_due_int>0 OR b.r_overdue_int>0 OR b.r_principal>0) order by a.account_no";


/*$sql_statement="SELECT  a.account_no, a.action_date, b.tr_type,c.loan_amount,b.r_due_int, b.r_overdue_int,b.r_principal, b.b_due_int, b.b_overdue_int,b.b_principal,t_i 
from
(
SELECT  account_no, max(action_date) as action_date
from  loan_statement 
where account_no like 'KCC%' and tr_type='R' and (action_date BETWEEN '$start_date' AND '$current_date')
group by account_no   
) a,
loan_statement b,
(

--select a.account_no,b.tran_id 
--from loan_statement a,
--(select account_no,max(tran_id) tran_id from loan_statement where  account_no like 'KCC%' and tr_type='I' and (action_date BETWEEN '$start_date' AND '$current_date') group by account_no) b,
--(select account_no,max(action_date) action_date from loan_statement where account_no like 'KCC%' and tr_type='R' and (action_date BETWEEN '$start_date' AND '$current_date') group by account_no) --c
--where a.account_no=b.account_no
--and a.account_no=c.account_no
--and b.tran_id in (select max(tran_id) tran_id from loan_statement where  account_no like 'KCC%' and tr_type='I' and (action_date BETWEEN '$start_date' AND '$current_date') group by account_no)

select account_no,max(tran_id) tran_id from loan_statement where  account_no like 'KCC%' and tr_type='I' and (action_date BETWEEN '$start_date' AND '$current_date') 
and 
group by account_no



) c
where a.account_no=b.account_no
and a.account_no=c.account_no
and a.action_date=b.action_date 
and (b.action_date BETWEEN '$start_date' AND '$current_date')
and b.tr_type='R' and (b.r_due_int>0 OR b.r_overdue_int>0 OR b.r_principal>0) 
order by a.account_no";*/



//echo $sql_statement;
$result=dBConnect($sql_statement);
echo "<table  width=\"100%\" bgcolor=\"BLACK\">";
echo "<tr><td bgcolor=\"#8A2BE2\" colspan=\"10\" align=\"center\"><font color=\"white\" size=+2><b>$l_name Loan Recovery Date Between $start_date and $current_date</font> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\" $HIGHLIGHT>&nbsp;<input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\" $HIGHLIGHT> ";
echo "</form>";
$color="#808000";
echo "<tr>";
echo "<th bgcolor=$color Rowspan=\"2\">A/C No</th>";
echo "<th bgcolor=$color Rowspan=\"2\">Name</th>";
echo "<th bgcolor=$color Rowspan=\"2\">Repay Date</th>";

echo "<th bgcolor=$color  Rowspan=\"2\">Loan<br>Amount</th>";
echo "<th bgcolor=$color  colspan=\"4\">Recovery</th>";
echo "<th bgcolor=$color  Rowspan=\"2\">Balance as on<br>$current_date</th>";
echo "<tr><th bgcolor=$color >Principal</th>";
echo "<th bgcolor=$color >Due</th>";
echo "<th bgcolor=$color>Overdue</th>";
echo "<th bgcolor=$color>Total Interest</th>";

if(pg_NumRows($result)>0){
	for($j=0; $j<pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	$current_balance=total_loan_current_balance($row['account_no'],$current_date);
        echo "<tr>";
	echo "<td align=CENTER bgcolor=$color><a href=\"$s_page".$row['account_no']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes,top=100,left=150, width=1050,height=500'); return false;\">".$row['account_no']."</a></td>";

	$id=getCustomerId($row['account_no'],$menu);
	echo "<td align=Center bgcolor=$color>".getName('customer_id',$id,'name1','customer_master')."</td>";

	echo "<td align=CENTER bgcolor=$color>".$row['action_date']."</a></td>";

	$lm+=(float)$row['p']+$current_balance;
	//echo "<td align=right bgcolor=$color >".amount2Rs($row['p']+$current_balance)."</td>";
         echo "<td align=right bgcolor=$color >".amount2Rs($row['loan_amount'])."</td>";
	$q+=(float)$row['loan_amount'];
	$p+=(float)$row['r_principal'];

	echo "<td align=CENTER bgcolor=$color>".$row['r_principal']."</a></td>";
	$d+=(float)$row['r_due_int'];

	echo "<td align=CENTER bgcolor=$color>".$row['r_due_int']."</a></td>";
	$o+=(float)$row['r_overdue_int'];

	echo "<td align=CENTER bgcolor=$color>".$row['r_overdue_int']."</a></td>";
	
	$t+=(float)$row['r_due_int']+(float)$row['r_overdue_int'];


	echo "<td align=CENTER bgcolor=$color>".$row['r_due_int']."</a></td>";



	$bal+=(float)$current_balance;
	echo "<td align=right bgcolor=$color>".amount2Rs($current_balance)."</td>";
		}

	}
	echo "<tr bgcolor=\"AQUA\"><th colspan=\"2\">Total:  ".$j." Account Found!!!!!<th align=\"right\"><th align=\"right\">".amount2Rs($q);
	echo "<th align=\"right\">".amount2Rs($p);
	echo "<th align=\"right\">".amount2Rs($d);
	echo "<th align=\"right\">".amount2Rs($o);

	echo "<th align=\"right\">".amount2Rs($t);

	echo "<th align=\"right\">".amount2Rs($bal);
?>
<script language="JavaScript" type="text/javascript">
 var frmvalidator  = new Validator("f1");
 frmvalidator.addValidation("current_date","req","Date Should not be Null!!!!!");
 frmvalidator.addValidation("start_date","req","Date Should not be Null!!!!!");
</script>
