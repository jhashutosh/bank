<?php
include "../config/config.php";
$staff_id=verifyAutho();
$CONDITIONS=$_REQUEST['c'];
$menu=$_REQUEST['menu'];
if($menu=='kcc'){
	$i_page="../kcc/kcc_loan_issue.php?menu=kcc&account_no=";
	$r_page="../kcc/kcc_loan_repayment.php?menu=kcc&account_no=";
	$s_page="../kcc/kcc_loan_statement.php?menu=kcc&op=i&account_no=";
	}
if($menu=='sao'){
	$i_page="../sao/sao_loan_issue.php?menu=sao&account_no=";
	$r_page="../sao/sao_loan_repayment.php?menu=sao&account_no=";
	$s_page="../sao/sao_loan_statement.php?menu=sao&op=i&account_no=";
	}	
if($menu=='pl'){$i_page="../pl/pl_loan_issue_ef.php?menu=pl&account_no=";
		$r_page="../pl/pl_loan_repayment.php?menu=pl&account_no=";
		$s_page="../pl/pl_statement.php?menu=pl&op=i&account_no=";
		}
if($menu=='ccl'){$i_page="../ccl/ccl_loan_issue_ef.php?menu=ccl&account_no=";
		$r_page="../ccl/ccl_loan_repayment.php?menu=ccl&account_no=";
		$s_page="../ccl/ccl_statement.php?menu=ccl&op=i&account_no=";
		}
if($menu=='kpl'){$i_page="../kpl/kpl_loan_issue_ef.php?menu=kpl&account_no=";
		$r_page="../kpl/kpl_loan_repayment.php?menu=kpl&account_no=";
		$s_page="../kpl/kpl_statement.php?menu=kpl&op=i&account_no=";
		}
if($menu=='ofl'){$i_page="../ofl/ofl_loan_issue_ef.php?menu=ofl&account_no=";
		$r_page="../ofl/ofl_loan_repayment.php?menu=ofl&account_no=";
		$s_page="../ofl/ofl_statement.php?menu=ofl&op=i&account_no=";
		}
if($menu=='lad'){$i_page="../lad/lad_loan_issue_ef.php?menu=lad&account_no=";
		$r_page="../lad/lad_loan_repayment.php?menu=lad&account_no=";
		$s_page="../lad/lad_statement.php?menu=lad&op=i&account_no=";
		}
if($menu=='spl'){$i_page="../spl/spl_loan_issue_ef.php?menu=spl&account_no=";
		$r_page="../spl/spl_loan_repayment.php?menu=spl&account_no=";
		$s_page="../spl/spl_statement.php?menu=spl&op=i&account_no=";
		}
if($menu=='ser'){$i_page="../service/service_loan_issue_ef.php?menu=ser&account_no=";
		$r_page="../service/service_loan_repayment.php?menu=ser&account_no=";
		$s_page="../service/service_statement.php?menu=ser&op=i&account_no=";
		}


/*if($menu=='hbl'){$i_page="../house/house_loan_issue_ef.php?menu=hbl&account_no=";
		$r_page="../house/house_loan_repayment.php?menu=hbl&account_no=";
		$s_page="../house/house_statement.php?menu=hbl&op=i&account_no=";
		}*/




if($menu=='car'){$i_page="../carloan/car_loan_issue_ef.php?menu=car&account_no=";
		$r_page="../carloan/car_loan_repayment.php?menu=car&account_no=";
		$s_page="../carloan/car_statement.php?menu=car&op=i&account_no=";
		}
if($menu=='fis'){$i_page="../fisary/fis_loan_issue_ef.php?menu=fis&account_no=";
		$r_page="../fisary/fis_loan_repayment.php?menu=fis&account_no=";
		$s_page="../fisary/fis_statement.php?menu=fis&op=i&account_no=";
		}
if($menu=='bdl'){$i_page="../bdl/bdl_loan_issue_ef.php?menu=bdl&account_no=";
		$r_page="../bdl/bdl_loan_repayment.php?menu=bdl&account_no=";
		$s_page="../bdl/bdl_statement.php?menu=bdl&op=i&account_no=";
		}
if($menu=='sfl'){$i_page="../sfl/sfl_loan_issue_ef.php?menu=sfl&account_no=";
		$r_page="../sfl/sfl_loan_repayment.php?menu=sfl&account_no=";
		$s_page="../sfl/sfl_statement.php?menu=sfl&op=i&account_no=";
		}

if($menu=='mt'){$i_page="../mtloan/mtloan_ledger_ef.php?menu=mt&account_no=";
		$r_page="../mtloan/mtl_loan_repayment.php?menu=mt&account_no=";
		$s_page="../mtloan/mtloan_statement.php?menu=mt&op=i&account_no=";
		}
if($menu=='sgl'){
		$i_page="../shg/loan_ledger_ef.php?menu=shg&account_no=";
		$r_page="../shg/loan_ledger_efr.php?menu=shg&account_no=";
		$s_page="../shg/loan_statement.php?menu=sgl&op=i&account_no=";}
if($menu=='jlg'){
		$s_page="../jlg/loan_statement.php?menu=jlg&op=i&account_no=";}

echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
$sql_statement="select account_no,round(SUM(due_int)) as d,round(SUM(overdue_int)) as o,round(SUM(principal)) as p from loan_cal_int  $CONDITIONS group by account_no ORDER BY cast(substr(account_no,position ('-' in account_no)+1) as integer)";
//$sql_statement="select account_no,due_int,overdue_int,principal from loan_cal_int  $CONDITIONS group by account_no";
//echo $sql_statement; 
$result=dBConnect($sql_statement);
echo "<Table bgcolor=\"Black\" width=\"120%\" >";
if(pg_NumRows($result)>0){
for($j=1; $j<=pg_NumRows($result); $j++){
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;

$row=pg_fetch_array($result,($j-1));
if(isOverDue($row['account_no'])){
$fcolor="#FF0432";
}
else{
$fcolor="BLACK";
}
echo "<tr>";
echo "<td align=CENTER bgcolor=$color width =\"68\"><a href=\"$s_page".$row['account_no']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes,top=100,left=150, width=1050,height=500'); return false;\"><font color=$fcolor>".$row['account_no']."</a></td>";
$id=getCustomerId($row['account_no'],$menu);
echo "<td align=Center bgcolor=$color width =\"200\"><font color=$fcolor>".getName('customer_id',$id,'name1','customer_master')."</td>";
echo "<td align=right bgcolor=$color width=\"80\"><font color=$fcolor>".(float)$row['p']."</td>";
echo "<td align=right bgcolor=$color width =\"75\"><font color=$fcolor>".$row['d']."</td>";
echo "<td align=right bgcolor=$color width =\"75\"><font color=$fcolor>".$row['o']."</td>";
echo "<td align=right bgcolor=$color width =\"75\"><font color=$fcolor>".($row['p']+$row['d']+$row['o'])."</td>";
if($menu=='kcc'){
echo "<td align=right bgcolor=$color width=\"70\"><font color=$fcolor>".getAcer(getLand($id));
$membership_id=getMemberId($id);
share_current_balance($membership_id,$no,$val);
echo "<td align=right bgcolor=$color width=\"80\"><font color=$fcolor>$val";
}
if(!empty($row['p'])&&$menu!='kcc'){
echo "<td align=CENTER bgcolor=$color>Issue  || <a href=\"$r_page".$row['account_no']."\" target=\"_parent\">Repay</a></td>";
}
else{

echo "<td align=CENTER bgcolor=$color><a href=\"$i_page".$row['account_no']."\" target=\"_parent\"><font color=$fcolor>Issue</a>  ||";
if($row['p']==0){
echo "<font color=$fcolor> Repay</td>";

}
else{
echo " <a href=\"$r_page".$row['account_no']."\" target=\"_parent\"><font color=$fcolor>Repay</a></td>";
}
}
  }
}
?>
