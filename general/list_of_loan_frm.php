<?
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$op=$_REQUEST['op'];

if($menu=='pl'){
		$l_name='PLEDGE';
		$s_page="../pl/pl_statement.php?menu=pl&op=i&account_no=";
		$size=4;
		}
if($menu=='ccl'){
		$l_name='Cash Credit';
		$s_page="../ccl/ccl_statement.php?menu=ccl&op=i&account_no=";
		$size=5;
		}

if($menu=='house'){
		$l_name='House Building';
		$s_page="../houseloan/houseloan_statement.php?menu=house&op=i&account_no=";
		}

if($menu=='hpl'){
		$l_name='Car Loan';
		$s_page="../hpl/hpl_statement.php?menu=hpl&op=i&account_no=";
		$size=5;
		}

if($menu=='edu'){
		$l_name='Education Loan';
		$s_page="../educationloan/eduloan_statement.php?menu=edu&op=i&account_no=";

		$size=5;
		}
if($menu=='pcl'){
		$l_name='Personal Loan';
		$s_page="../personalloan/mtloan_statement.php?menu=pcl&op=i&account_no=";
		$size=5;
		}

if($menu=='fl'){
		$l_name='Fishery Loan';
		$s_page="../floan/fl_statement.php?menu=fl&op=i&account_no=";
		$size=4;
		}
if($menu=='adv'){
		$l_name='Advance Loan';
		$s_page="../adv/adv_statement.php?menu=adv&op=i&account_no=";
		$size=5;
		}


if($menu=='kcc'){
		$l_name='Kcc Loan';
		$s_page="../kcc/kcc_loan_statement.php?menu=kcc&op=i&account_no=";
		$size=5;
		}


if($menu=='kpl'){
		$l_name='Kishan Bikhash Pathra';
		$s_page="../kpl/kpl_statement.php?menu=kpl&op=i&account_no=";

		$size=5;
		}
if($menu=='spl'){
		$l_name='SMP';
		$s_page="../spl/spl_statement.php?menu=spl&op=i&account_no=";
		$size=5;
		}
if($menu=='bdl'){
		$l_name='Bond';
		$s_page="../bdl/bdl_statement.php?menu=bdl&op=i&account_no=";
		$size=5;
		}
if($menu=='sfl'){
		$l_name='Staff';
		$s_page="../sfl/sfl_statement.php?menu=sfl&op=i&account_no=";
		$size=5;
		}

if($menu=='mt'){
		$l_name='MT';
		$s_page="../mt/mt_statement.php?menu=mt&op=i&account_no=";
		$size=4;
		}
if($menu=='mtb'){
		$l_name='MTB';
		$s_page="../mtb/mtb_statement.php?menu=mtb&op=i&account_no=";
		$size=5;
		}
if($menu=='lad'){
		$l_name='LAD';
		$s_page="../lad/lad_statement.php?menu=lad&op=i&account_no=";
		$size=5;
		}

/*if($menu=='mtb'){
		$l_name='MTB';
		$s_page="../mtb/mtb_statement.php?menu=mtb&op=i&account_no=";
		}*/

if($menu=='sgl'){
		$l_name='SHG';
		$s_page="../shg/loan_statement.php?menu=sgl&op=i&account_no=";
		$size=5;
		}
echo "<script language=\"JAVASCRIPT\">";
echo "function closeme() { close(); }";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<body bgcolor=\"\">";


if($menu=='mt'||$menu=='mtb1'){

	if($menu=='mt'){
	$sql_statement="truncate table loan_cal_int;SELECT loan_calculation_nimo_mt_list('$menu',current_date) as int";
	$result=dBConnect($sql_statement);
	//echo $sql_statement;
	}
	if($menu=='mtb1'){
	$sql_statement="truncate table loan_cal_int;SELECT loan_calculation_nimo_mtb_list('$menu',current_date) as int";
	$result=dBConnect($sql_statement);
	//echo $sql_statement;
	}
}

else
{
$sql_statement="truncate table loan_cal_int;SELECT loan_calculation('$menu',current_date) as int";
//echo $sql_statement;
$result=dBConnect($sql_statement);
}

if(pg_result($result,'int')=='k'){
$WHERE_CONDITION=" WHERE loan_type='$menu'";
$sql_statement="select account_no,SUM(due_int) as d,SUM(overdue_int) as o,SUM(principal) as p FROM loan_cal_int ";
//echo $sql_statement;
$cols=2;
if($op=='d'){$WHERE_CONDITION.=" AND status='d'"; $name="Due"; $cols=1;}
if($op=='o'){$WHERE_CONDITION.=" AND status='o'"; $name="Over Due";}
$WHERE_CONDITION.=" GROUP BY account_no ";
$sql_statement.=$WHERE_CONDITION;
if($menu=='lad'){$ORDER_BY=' order by account_no';}
else{$ORDER_BY=" ORDER BY CAST(SUBSTR(account_no,$size,length(account_no)) as BIGINT)";}
$sql_statement.=$ORDER_BY;
//echo $sql_statement; 
$result=dBConnect($sql_statement);
echo "<table  width=\"100%\" bgcolor=\"BLACK\">";

if(pg_NumRows($result)>0){
	for($j=0; $j<pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	if(isOverDue($row['account_no'])){
		$fcolor="#DC143C";
		}
	else{
		$fcolor="BLACK";
	}

	echo "<tr>";
	echo "<td align=CENTER bgcolor=$color width=\"12%\"><a href=\"$s_page".$row['account_no']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes,top=100,left=150, width=1050,height=500'); return false;\"><font color=\"$fcolor\">".$row['account_no']."</a></td>";
	$id=getCustomerId($row['account_no'],$menu);
	echo "<td align=Center bgcolor=$color width=\"53%\"><font color=\"$fcolor\" >".getName('customer_id',$id,'name1','customer_master')."</td>";
	$p+=(float)$row['p'];
	echo "<td align=right bgcolor=$color width=\"19%\"><font color=\"$fcolor\" >".amount2Rs($row['p'])."</td>";
	$d+=(float)$row['d'];
	echo "<td align=right bgcolor=$color  width=\"8%\"><font color=\"$fcolor\">".amount2Rs($row['d'])."</td>";
	if($op!='d'){
	$o+=(float)$row['o'];
	echo "<td align=right bgcolor=$color width=\"8%\"><font color=\"$fcolor\" >".amount2Rs($row['o'])."</td>";
	}
	echo "<td align=right bgcolor=$color width=\"8%\"><font color=\"$fcolor\" >".amount2Rs($row['p']+$row['d']+$row['o'])."</font></td>";
		}

	}
	
  }
else{
echo "Record Not Found";
}

?>
