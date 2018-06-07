<?
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$op=$_REQUEST['op'];
//echo $frmr_id;
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo"<head>";
echo"<title>list_loan</title>";
echo "<script src=\"../JS/loading2.js\">";
echo "</script>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<script language=\"JAVASCRIPT\">";
echo "function closeme() { close(); }";
echo "</script>";
echo"</head>";
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
if($menu=='ofl'){
		$l_name='Own Fund Loan';
		$s_page="../ofl/ofl_statement.php?menu=ofl&op=i&account_no=";
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
$cols=2;
if($op=='d'){$WHERE_CONDITION.=" AND status='d'"; $name="Due"; $cols=1;}
if($op=='o'){$WHERE_CONDITION.=" AND status='o'"; $name="Over Due";}
$WHERE_CONDITION.=" GROUP BY account_no ";

$sql_statement="SELECT COUNT(*) no_of_account,SUM(d) as d,sum(o) as o,sum(p) as p FROM (select account_no,SUM(due_int) as d,SUM(overdue_int) as o,SUM(principal) as p FROM loan_cal_int $WHERE_CONDITION) as foo";
//echo $sql_statement;

 
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$j=pg_result($result,'no_of_account');
$p=pg_result($result,'p');
$d=pg_result($result,'d');
$o=pg_result($result,'o');
}
}
echo"<body bgcolor='white'>";
//echo"<table valign=\"top\"width='100%' align='center'>";
echo "<table  width=\"100%\" bgcolor=\"BLACK\">";
echo "<tr><td bgcolor=\"Yellow\" colspan=\"10\" align=\"center\"><font color=\"\" size=+2><b>LIST OF $name $l_name Loan as on ".date('d.m.Y')."</font> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\" $HIGHLIGHT>&nbsp;<input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\" $HIGHLIGHT> ";

$color="GREEN";
echo "<tr>";
//echo $cols;
echo "<th bgcolor=$color Rowspan=\"2\" width=\"13%\"><font color=\"WHITE\">A/C No</th>";
echo "<th bgcolor=$color Rowspan=\"2\" width=\"51%\"><font color=\"WHITE\">Name</th>";
echo "<th bgcolor=$color  Rowspan=\"2\" width=\"10%\"><font color=\"WHITE\">Principal<br>(Rs.)</th>";
echo "<th bgcolor=$color  colspan=\"$cols\" width=\"9%\"><font color=\"WHITE\">Interest</th>";
echo "<th bgcolor=$color  Rowspan=\"2\" width=\"14%\"><font color=\"WHITE\">Total<br>(Rs.)</th>";
echo "<tr><th bgcolor=$color ><font color=\"WHITE\" width=\"60%\">Due</th>";
if($op!='d'){
	echo "<th bgcolor=$color ><font color=\"WHITE\" width=\"40%\">OverDue</th>";
	}
echo "<tr><td colspan=\"9\" align=center><iframe src=\"list_of_loan_frm.php?menu=$menu&op=$op\" width=\"100%\" height=\"500\" ></iframe></td></tr>";

echo "<tr bgcolor=\"AQUA\"><th colspan=\"2\" width=\"51%\">Total:  ".$j." Account Found!!!!!<th align=\"right\" width=\"19%\">".amount2Rs($p)."<th align=\"right\" width=\"8%\">".amount2Rs($d);
	if($op!='d'){
	echo "<th align=\"right\" width=\"8%\">".amount2Rs($o);
	}
	echo "<th align=\"right\" width=\"10%\">".amount2Rs($p+$d+$o);
echo"</table></body>";
?>
