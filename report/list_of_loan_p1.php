<?
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$op=$_REQUEST['op'];
getDetailFy($fy,&$f_start_dt,&$f_end_dt);
if($menu=='pl'){
		$l_name='PLEDGE';
		$s_page="../pl/pl_statement.php?menu=pl&op=i&account_no=";
		}
if($menu=='ccl'){
		$l_name='Cash Credit';
		$s_page="../ccl/ccl_statement.php?menu=ccl&op=i&account_no=";
		}
if($menu=='kpl'){
		$l_name='Kishan Bikhash Pathra';
		$s_page="../kpl/kpl_statement.php?menu=kpl&op=i&account_no=";
		}
if($menu=='spl'){
		$l_name='SMP';
		$s_page="../spl/spl_statement.php?menu=spl&op=i&account_no=";
		}
if($menu=='bdl'){
		$l_name='Bond';
		$s_page="../bdl/bdl_statement.php?menu=bdl&op=i&account_no=";
		}
if($menu=='sfl'){
		$l_name='Staff';
		$s_page="../sfl/sfl_statement.php?menu=sfl&op=i&account_no=";
		}

if($menu=='mt'){
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
$sql_statement="DELETE FROM loan_cal_int;SELECT loan_calculation('$menu','$f_start_dt') as int";
//echo "<h1>$sql_statement</h1>";
$result=dBConnect($sql_statement);
if(pg_result($result,'int')=='k'){
$WHERE_CONDITION=" WHERE loan_type='$menu'";
$sql_statement="select account_no,SUM(due_int) as d,SUM(overdue_int) as o,SUM(principal) as p FROM loan_cal_int";
$cols=2;
if($op=='d'){$WHERE_CONDITION.=" AND status='d'"; $name="Due";}
if($op=='o'){$WHERE_CONDITION.=" AND status='o'"; $name="Over Due";$cols=1;}
$WHERE_CONDITION.=" GROUP BY account_no ORDER BY account_no";
$sql_statement.=$WHERE_CONDITION;
//echo $sql_statement; 
$result=dBConnect($sql_statement);
echo "<table  width=\"100%\" bgcolor=\"BLACK\">";
echo "<tr><td bgcolor=\"Yellow\" colspan=\"10\" align=\"center\"><font color=\"\" size=+2><b>LIST OF $name $l_name Loan as on ".date('d.m.Y')."</font> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\" $HIGHLIGHT>&nbsp;<input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\" $HIGHLIGHT> ";
echo "</form>";
$color="GREEN";
echo "<tr>";
//echo $cols;
echo "<th bgcolor=$color Rowspan=\"2\"><font color=\"WHITE\">A/C No</th>";
echo "<th bgcolor=$color Rowspan=\"2\"><font color=\"WHITE\">Name</th>";
echo "<th bgcolor=$color  Rowspan=\"2\"><font color=\"WHITE\">Principal<br>(Rs.)</th>";
echo "<th bgcolor=$color  colspan=\"$cols\"><font color=\"WHITE\">Interest</th>";
echo "<th bgcolor=$color  Rowspan=\"2\"><font color=\"WHITE\">Total<br>(Rs.)</th>";
echo "<tr><th bgcolor=$color ><font color=\"WHITE\">OverDue</th>";
if($op!='o'){
echo "<th bgcolor=$color><font color=\"WHITE\">Due</th>";
}
if(pg_NumRows($result)>0){
	for($j=0; $j<pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	if(isOverDue($row['account_no'])){
		$fcolor="#DC143C";
		}
	echo "<tr>";
	echo "<td align=CENTER bgcolor=$color><a href=\"$s_page".$row['account_no']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes,top=100,left=150, width=1050,height=500'); return false;\"><font color=\"$fcolor\">".$row['account_no']."</a></td>";
	$id=getCustomerId($row['account_no'],$menu);
	echo "<td align=Center bgcolor=$color><font color=\"$fcolor\">".getName('customer_id',$id,'name1','customer_master')."</td>";
	$p+=(float)$row['p'];
	echo "<td align=right bgcolor=$color ><font color=\"$fcolor\">".amount2Rs($row['p'])."</td>";
	$d+=(float)$row['d'];
	//echo "<td align=right bgcolor=$color ><font color=\"$fcolor\">".amount2Rs($row['d'])."</td>";
	if($op!='d'){
	$o+=(float)$row['o'];
	echo "<td align=right bgcolor=$color><font color=\"$fcolor\">".amount2Rs($row['o'])."</td>";
	}
	echo "<td align=right bgcolor=$color><font color=\"$fcolor\">".amount2Rs($row['p']+$row['o'])."</font></td>";
		}

	}
	echo "<tr bgcolor=\"AQUA\"><th colspan=\"2\">Total:  ".$j." Account Found!!!!!<th align=\"right\">".amount2Rs($p);
	if($op!='d'){
	echo "<th align=\"right\">".amount2Rs($o);
	}
	echo "<th align=\"right\">".amount2Rs($p+$o);
  }
else{
echo "Record Not Found";
}

?>
