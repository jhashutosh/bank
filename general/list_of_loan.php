<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$op=$_REQUEST['op'];

if($menu=='pl'){
		$l_name='PLEDGE';
		$s_page="../pl/pl_statement.php?menu=pl&op=i&account_no=";
		}
if($menu=='sao'){
		$l_name='SAO';
		$s_page="../sao/sao_loan_statement.php?menu=sao&op=i&account_no=";
		}
if($menu=='kcc'){
		$l_name='KCC';
		$s_page="../kcc/kcc_loan_statement.php?menu=kcc&op=i&account_no=";
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
		$s_page="../mt/mt_statement.php?menu=mt&op=i&account_no=";
		}
if($menu=='ser'){
		$l_name='Service';
		$s_page="../service/service_statement.php?menu=ser&op=i&account_no=";
		}
if($menu=='car'){
		$l_name='car';
		$s_page="../carloan/car_statement.php?menu=car&op=i&account_no=";
		}
if($menu=='hdc'){
		$l_name='Hardco';
		$s_page="../hdc/hdc_statement.php?menu=hdc&op=i&account_no=";
		}
if($menu=='sgl'){
		$l_name='SHG';
		$s_page="../shg/shg_mem_detail.php?menu=shg&account_no=";
		}
echo "<script language=\"JAVASCRIPT\">";
echo "function closeme() { close(); }";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<body bgcolor=\"\">";

$sql_statement="DELETE FROM loan_cal_int;SELECT loan_calculation('$menu',current_date) as int";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_result($result,'int')=='k')
{

//==========================================FOR EMI SYSTEM====================================

	$sql_statement="select loan_cal_int.status from loan_cal_int where loan_serial_no is not null";
	$result=dBConnect($sql_statement);
	$row=pg_fetch_array($result,0);
	$status=$row['status'];
	if($status=='in')
	{	$cols=2;
		if($op=='d')
		{
			$sql_statement="select account_no,case when due_principal!=0 then sum(due_int) else 0 END as due_int,SUM(principal-overdue_principal) as principal FROM loan_cal_int GROUP BY account_no,due_principal";
			$cols=1;
			$name="Due";
		}
		if($op=='o')
		{
			$sql_statement="select account_no,case when due_principal=0 then sum(due_int) else 0 END as due_int, SUM(overdue_int) as overdue_int,SUM(overdue_principal) as principal FROM loan_cal_int GROUP BY account_no,due_principal";
		
			$name="OverDue";
		}
		if(empty($op))
		{
			$sql_statement="select account_no,SUM(due_int) as due_int,SUM(overdue_int) as overdue_int,SUM(principal) as principal FROM loan_cal_int GROUP BY account_no,due_int,overdue_int,principal";
		}
	$result=dBConnect($sql_statement);
	//echo $sql_statement; 

	echo "<table  width=\"100%\" bgcolor=\"BLACK\">";
	echo "<tr><td bgcolor=\"Yellow\" colspan=\"10\" align=\"center\"><font color=\"\" size=+2><b>LIST OF $name $l_name Loan as on ".date('d.m.Y')."</font> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\" $HIGHLIGHT>&nbsp;<input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\" $HIGHLIGHT> ";
	echo "</form>";
	$color="GREEN";
	echo "<tr>";
	//echo $cols;
	echo "<th bgcolor=$color Rowspan=\"2\"><font color=\"WHITE\">A/C No</th>";
	echo "<th bgcolor=$color Rowspan=\"2\"><font color=\"WHITE\">Name</th>";
	echo "<th bgcolor=$color Rowspan=\"2\"><font color=\"WHITE\">Principal<br>(Rs.)</th>";
	echo "<th bgcolor=$color colspan=\"$cols\"><font color=\"WHITE\">Interest</th>";
	echo "<th bgcolor=$color Rowspan=\"2\"><font color=\"WHITE\">Total<br>(Rs.)</th>";
	echo "<tr><th bgcolor=$color ><font color=\"WHITE\">Due</th>";
	if($op!='d')
	{
		echo "<th bgcolor='$color' ><font color=\"WHITE\">Overdue</th>";
	}
	if(pg_NumRows($result)>0)
	{
		for($j=0; $j<pg_NumRows($result); $j++)
		{
			$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
			$row=pg_fetch_array($result,$j);
			if(isOverDueEmi($row['account_no']))
			{
				$fcolor="#DC143C";
			}
			else
			{
				$fcolor="black";
			}
			
			
			echo "<tr>";
			echo "<td align=CENTER bgcolor=$color><a href=\"$s_page".$row['account_no']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes,top=100,left=150, width=1050,height=500'); return false;\"><font color=\"$fcolor\">".$row['account_no']."</a></td>";
			$id=getCustomerId($row['account_no'],$menu);
			echo "<td align=Center bgcolor=$color><font color=\"$fcolor\">".getName('customer_id',$id,'name1','customer_master')."</td>";
			$p+=(float)$row['principal'];
			echo "<td align=right bgcolor=$color ><font color=\"$fcolor\">".amount2Rs($row['principal'])."</td>";
			$d+=(float)$row['due_int'];
			echo "<td align=right bgcolor=$color ><font color=\"$fcolor\">".amount2Rs($row['due_int'])."</td>";
			if($op!='d')
			{
				$o+=(float)$row['overdue_int'];
				echo "<td align=right bgcolor=$color><font color=\"$fcolor\">".amount2Rs($row['overdue_int'])."</td>";
			}
			echo "<td align=right bgcolor=$color><font color=\"$fcolor\">".amount2Rs($row['principal']+$row['due_int']+$row['overdue_int'])."</font></td>";
		}
	}
	echo "<tr bgcolor=\"AQUA\"><th colspan=\"2\">Total:  ".$j." Account Found!!!!!<th align=\"right\">".amount2Rs($p)."<th align=\"right\">".amount2Rs($d);
	if($op!='d')
	{
		echo "<th align=\"right\">".amount2Rs($o);
	}
	echo "<th align=\"right\">".amount2Rs($p+$d+$o);


	}

	
//==========================================FOR NORMAL SYSTEM====================================lse
	{
		$WHERE_CONDITION=" WHERE loan_type='$menu'";
		$sql_statement="select account_no,SUM(due_int) as d,SUM(overdue_int) as o,SUM(principal) as p FROM loan_cal_int";
		$cols=2;
		if($op=='d'){$WHERE_CONDITION.=" AND loan_cal_int.status='d'"; $name="Due"; $cols=1;}
		if($op=='o'){$WHERE_CONDITION.=" AND loan_cal_int.status='o'"; $name="Over Due";}
		$WHERE_CONDITION.=" GROUP BY account_no ORDER BY account_no";
		$sql_statement.=$WHERE_CONDITION;
		//echo $sql_statement;
		$result=dBConnect($sql_statement);
	}
if ($status!='in')///status not in
{
	echo "<table  width=\"100%\" bgcolor=\"BLACK\">";
	echo "<tr><td bgcolor=\"Yellow\" colspan=\"10\" align=\"center\"><font color=\"\" size=+2><b>LIST OF $name $l_name Loan as on ".date('d.m.Y')."</font> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\" $HIGHLIGHT>&nbsp;<input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\" $HIGHLIGHT> ";
	echo "</form>";
	$color="GREEN";
	echo "<tr>";
	//echo $cols;
	echo "<th bgcolor=$color Rowspan=\"2\"><font color=\"WHITE\">A/C No</th>";
	echo "<th bgcolor=$color Rowspan=\"2\"><font color=\"WHITE\">Name</th>";
	echo "<th bgcolor=$color Rowspan=\"2\"><font color=\"WHITE\">Principal<br>(Rs.)</th>";
	echo "<th bgcolor=$color colspan=\"$cols\"><font color=\"WHITE\">Interest</th>";
	echo "<th bgcolor=$color Rowspan=\"2\"><font color=\"WHITE\">Total<br>(Rs.)</th>";
	echo "<tr><th bgcolor=$color ><font color=\"WHITE\">Due</th>";
	if($op!='d')
	{
		echo "<th bgcolor=$color><font color=\"WHITE\">Overdue</th>";
	}
	if(pg_NumRows($result)>0)
	{
		for($j=0; $j<pg_NumRows($result); $j++)
		{
			$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
			$row=pg_fetch_array($result,$j);
			if(isOverDue($row['account_no']))
			{
				$fcolor="#DC143C";
			}
			echo "<tr>";
			echo "<td align=CENTER bgcolor=$color><a href=\"$s_page".$row['account_no']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes,top=100,left=150, width=1050,height=500'); return false;\"><font color=\"$fcolor\">".$row['account_no']."</a></td>";
			$id=getCustomerId($row['account_no'],$menu);
			echo "<td align=Center bgcolor=$color><font color=\"$fcolor\">".getName('customer_id',$id,'name1','customer_master')."</td>";
			$p+=(float)$row['p'];
			echo "<td align=right bgcolor=$color ><font color=\"$fcolor\">".amount2Rs($row['p'])."</td>";
			$d+=(float)$row['d'];
			echo "<td align=right bgcolor=$color ><font color=\"$fcolor\">".amount2Rs($row['d'])."</td>";
			if($op!='d')
			{
				$o+=(float)$row['o'];
				echo "<td align=right bgcolor=$color><font color=\"$fcolor\">".amount2Rs($row['o'])."</td>";
			}
			echo "<td align=right bgcolor=$color><font color=\"$fcolor\">".amount2Rs($row['p']+$row['d']+$row['o'])."</font></td>";
		}
	}
	echo "<tr bgcolor=\"AQUA\"><th colspan=\"2\">Total:  ".$j." Account Found!!!!!<th align=\"right\">".amount2Rs($p)."<th align=\"right\">".amount2Rs($d);
	if($op!='d')
	{
		echo "<th align=\"right\">".amount2Rs($o);
	}
	echo "<th align=\"right\">".amount2Rs($p+$d+$o);
}
}////status in
else
{
	echo "Record Not Found";
}
?>

