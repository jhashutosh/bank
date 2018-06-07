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
echo "<form name=\"f1\" action=\"loan_recovery_rpt.php?menu=$menu\" method=\"POST\">";
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
$sql_statement=" SELECT account_no,SUM(r_due_int) as d,SUM(r_overdue_int) as o,SUM(r_principal) as p FROM loan_statement WHERE tr_type='R' AND (action_date BETWEEN '$start_date' AND '$current_date') AND account_no LIKE upper('%$menu%') GROUP BY account_no HAVING (SUM(r_due_int)>0 OR SUM(r_overdue_int)>0 OR SUM(r_principal)>0)";
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
echo "<th bgcolor=$color  Rowspan=\"2\">Loan<br>Amount</th>";
echo "<th bgcolor=$color  colspan=\"3\">Recovery</th>";
echo "<th bgcolor=$color  Rowspan=\"2\">Balance as on<br>$current_date</th>";
echo "<tr><th bgcolor=$color >Principal</th>";
echo "<th bgcolor=$color >Due</th>";
echo "<th bgcolor=$color>Overdue</th>";

if(pg_NumRows($result)>0){
	for($j=0; $j<pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	$current_balance=total_loan_current_balance($row['account_no'],$current_date);
        echo "<tr>";
	echo "<td align=CENTER bgcolor=$color><a href=\"$s_page".$row['account_no']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes,top=100,left=150, width=1050,height=500'); return false;\">".$row['account_no']."</a></td>";
	$id=getCustomerId($row['account_no'],$menu);
	echo "<td align=Center bgcolor=$color>".getName('customer_id',$id,'name1','customer_master')."</td>";
	$lm+=(float)$row['p']+$current_balance;
	echo "<td align=right bgcolor=$color >".amount2Rs($row['p']+$current_balance)."</td>";
	$p+=(float)$row['p'];
	echo "<td align=right bgcolor=$color >".amount2Rs($row['p'])."</td>";
	$d+=(float)$row['d'];
	echo "<td align=right bgcolor=$color >".amount2Rs($row['d'])."</td>";
	$o+=(float)$row['o'];
	echo "<td align=right bgcolor=$color>".amount2Rs($row['o'])."</td>";
//	echo "<td align=right bgcolor=$color>".amount2Rs($row['lm']-$row['p'])."</td>";
	$bal+=(float)$current_balance;
	echo "<td align=right bgcolor=$color>".amount2Rs($current_balance)."</td>";
		}

	}
	echo "<tr bgcolor=\"AQUA\"><th colspan=\"2\">Total:  ".$j." Account Found!!!!!<th align=\"right\">".amount2Rs($lm)."<th align=\"right\">".amount2Rs($p);
	echo "<th align=\"right\">".amount2Rs($d);
	echo "<th align=\"right\">".amount2Rs($o);
	echo "<th align=\"right\">".amount2Rs($bal);
?>
<script language="JavaScript" type="text/javascript">
 var frmvalidator  = new Validator("f1");
 frmvalidator.addValidation("current_date","req","Date Should not be Null!!!!!");
 frmvalidator.addValidation("start_date","req","Date Should not be Null!!!!!");
</script>
