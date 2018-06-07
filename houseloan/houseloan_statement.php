<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
if(empty($op)){
	$account_no=$_SESSION["current_account_no"];
	isPermissible($menu);
}
else{
	$account_no=$_REQUEST["account_no"];
}

$slno=$_REQUEST['slno'];
if(!empty($slno))
	{$WHERECONDITION="AND loan_serial_no='$slno'";//echo "<h1>Y$WHERECONDITION</h1>";
	}
else
	{$WHERECONDITION="";//echo "<h1>N$WHERECONDITION</h1>";
	}
echo "<html>";
echo "<head>";
echo "<title>Loan account statement";
echo "</title>";
echo "<script language=\"JAVASCRIPT\">";
echo "function closeme() { close(); }";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<h3>Account Statement [$account_no]";
echo "</h3><hr>";
$id=getCustomerId($account_no,$menu);
$flag=getGeneralInfo_Customer($id);
/////////////////////////////////////////////////////////////
echo "<table valign=\"top\" width=\"70%\" align=center>";
$COLOR=$TCOLOR;
echo "<tr bgcolor=orange>";
echo "<th rowspan=\"1\">Sl No";
echo "<th rowspan=\"1\">Account  No";
echo "<th rowspan=\"1\">Loan Amount";
echo "<th rowspan=\"1\">Prin./Month";
echo "<th rowspan=\"1\">Int./Month";
echo "<th rowspan=\"1\">....EMI....";
echo "<th rowspan=\"1\">No of Total EMI";
echo "<th rowspan=\"1\">No of Paid EMI";
echo "<th rowspan=\"1\">No of Due EMI";
//echo "<th rowspan=\"1\">Next Repay Date";loan_amt*((inst_rate-1)*(Math.pow(inst_rate,period)))/(Math.pow(inst_rate,period)-1)=emi;
//								(x.loan_amount*(x.inst-1)*pow(x.inst,x.period))/(pow(x.inst,x.period)-1) as emi
//$sql_statement="select x.slno,x.acno,x.loan_amount,x.inst AS inst,x.period,x.already_return,round((x.loan_amount*(x.inst/12/100)*pow(x.inst/12/100+1,x.period))/(pow(x.inst/12/100+1,x.period)-1)) as emi from (Select  a.account_no acno,a.loan_serial_no slno,a.loan_amount,int_due_rate as inst, round(b.period ) as period, b.already_return as already_return from loan_issue_dtl a,loan_ledger_hrd b where a. loan_serial_no=b. loan_serial_no and a.account_no='CAR-1') x";//$account_no

//$account_no= 'CAR-1'
$sql_statement="select x.slno,x.acno,x.loan_amount,x.inst AS inst,x.period,x.already_return,
round((x.loan_amount*(x.inst/12/100)*pow(x.inst/12/100+1,x.period))/(pow(x.inst/12/100+1,x.period)-1)) as emi 
from 
(
Select  distinct a.acno,a.slno,a.loan_amount,a.inst, a.period, b.already_return as already_return 
from
(
Select  a.account_no acno,a.loan_serial_no slno,a.loan_amount, a.inst as inst, round(a.period ) as period 
from loan_statement_ram a where a.account_no='$account_no' and tr_type='I'
) a,
(
Select  a.account_no acno,a.loan_serial_no slno, count(a.tr_type) as already_return 
from loan_statement_ram a where a.account_no='$account_no'  and tr_type='R' group by a.account_no,a.loan_serial_no
union all
Select  a.account_no acno,a.loan_serial_no slno, 0 as already_return 
from loan_statement_ram a where a.account_no='$account_no'  and a.loan_serial_no not in(select a.loan_serial_no slno from loan_statement_ram a where a.account_no='$account_no'  and tr_type='R')
) b
where a.acno=b.acno and a.slno=b.slno and a.acno='$account_no'
) 
x order by x.slno desc";

$result=dBConnect($sql_statement);
for($j=0; $j<pg_NumRows($result); $j++) {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
$principal_m=round($row['loan_amount']/$row['period']);
//$interest=$row['period']*$row['emi']-$row['loan_amount'];
$interest=round($row['emi']-$row['loan_amount']/$row['period']);
$t_no_emi=$row['period'];
//$paid_emi=round($row['already_return']/$row['emi']);
$paid_emi=$row['already_return'];
$due_emi=$row['period']-$paid_emi;
$sl=$row['slno'];
echo "<tr>";
echo "<td align=CENTER bgcolor=$color><a href=\"houseloan_statement.php?menu=$menu&account_no=$account_no&slno=$sl\" target=\"\"><font color=$focolor>".$row['slno']."</a></td>";
//echo "<td align=right bgcolor=$color>".$row['slno']."</td>";
echo "<td align=right bgcolor=$color>".$row['acno']."</td>";
echo "<td align=right bgcolor=$color>".$row['loan_amount']."</td>";
echo "<td align=right bgcolor=$color>".$principal_m."</td>";
echo "<td align=right bgcolor=$color>".$interest."</td>";
//echo "<td align=right bgcolor=$color>".$row['period']."</td>";
echo "<td align=right bgcolor=$color>".$row['emi']."</td>";
echo "<td align=right bgcolor=$color>".$t_no_emi."</td>";
echo "<td align=right bgcolor=$color>".$paid_emi."</td>";
echo "<td align=right bgcolor=$color>".$due_emi."</td>";
}
echo"</table>";





/*echo "<table valign=\"top\" width=\"70%\" align=center>";
$COLOR=$TCOLOR;
echo "<tr bgcolor=orange>";
echo "<th rowspan=\"1\">Sl No";
echo "<th rowspan=\"1\">Account  No";
echo "<th rowspan=\"1\">Loan Amount";
echo "<th rowspan=\"1\">Total Interest";
echo "<th rowspan=\"1\">EMI";
echo "<th rowspan=\"1\">No of Paid EMI";
echo "<th rowspan=\"1\">No of Due EMI";
//echo "<th rowspan=\"1\">Next Repay Date";
/*$sql_statement="select x.c1,x.c2,x.c3,x.c4,x.c3+x.c4 
from (Select  a.account_no c1,a.loan_serial_no c2, round(applied_amount-already_return*int_due_rate/100) as c3,round(loan_amount/ b.period ) as c4 from loan_issue_dtl a,loan_ledger_hrd b where a. loan_serial_no=b. loan_serial_no and a.account_no='$account_no') x";
$sql_statement="select x.slno,x.acno,x.loan_amount,x.inst AS inst,x.period,x.already_return,round((x.loan_amount*(x.inst/12/100)*pow(x.inst/12/100+1,x.period))/(pow(x.inst/12/100+1,x.period)-1)) as emi from (Select  a.account_no acno,a.loan_serial_no slno,a.loan_amount,int_due_rate as inst, round(b.period ) as period, b.already_return as already_return from loan_issue_dtl a,loan_ledger_hrd b where a. loan_serial_no=b. loan_serial_no and a.account_no='$account_no') x";//$account_no

$result=dBConnect($sql_statement);
for($j=0; $j<pg_NumRows($result); $j++) {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
$interest=$row['period']*$row['emi']-$row['loan_amount'];
$paid_emi=round($row['already_return']/$row['emi']);
$due_emi=$row['period']-$paid_emi;
$sl=$row['slno'];
echo "<tr>";
//echo "<td align=right bgcolor=$color>".$row['slno']."</td>";
echo "<td align=CENTER bgcolor=$color><a href=\"houseloan_statement.php?menu=$menu&account_no=$account_no&slno=$sl\" target=\"\"><font color=$focolor>".$row['slno']."</a></td>";
echo "<td align=right bgcolor=$color>".$row['acno']."</td>";
echo "<td align=right bgcolor=$color>".$row['loan_amount']."</td>";
echo "<td align=right bgcolor=$color>".$interest."</td>";
//echo "<td align=right bgcolor=$color>".$row['period']."</td>";
echo "<td align=right bgcolor=$color>".$row['emi']."</td>";
echo "<td align=right bgcolor=$color>".$paid_emi."</td>";
echo "<td align=right bgcolor=$color>".$due_emi."</td>";
}
echo"</table>";*/






/////////////////////////////////////////////////////////////
if($flag==1){
$sql_statement="SELECT * FROM  loan_statement where account_no='$account_no' $WHERECONDITION AND action_date<=current_date ORDER BY entry_time DESC";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4>Not found!!!</h4>";
} else {
$balance=total_loan_current_balance($account_no,$action_date);
echo "<table valign=\"top\" width=\"100%\" align=center>";
echo "<tr><td bgcolor=\"green\" colspan=\"13\" align=\"center\"><font color=\"white\">Statement</font><font color=BLACK size=+1><b>[Current Balance:Rs.".$balance."]</b></font>";
//echo "<tr><td bgcolor=\"GREEN\" colspan=\"11\" align=\"center\"><b><font color=\"WHITE\">Loan Details of Account No.: [<b>$account_no</b>]</font>";
$COLOR=$TCOLOR;
echo "<tr bgcolor=$COLOR>";
echo "<th rowspan=\"2\">Tran Id";
echo "<th rowspan=\"2\">Action Date";
//echo "<th rowspan=\"2\">Particulars";
echo "<th rowspan=\"2\">Issue(Rs.)";
echo "<th colspan=\"3\">Recovery(Rs.)";
echo "<th colspan=\"3\">Balance(Rs.)";
echo "<th Rowspan=\"2\">Operator code</th>";
echo "<th Rowspan=\"2\">Entry time</th>";
echo "<tr>";
echo "<th colspan=\"1\" bgcolor=\"$COLOR\">principal";
echo "<th colspan=\"1\" bgcolor=\"$COLOR\">Interest";
echo "<th colspan=\"1\" bgcolor=\"$COLOR\">Overdue";
//echo "<th colspan=\"1\" bgcolor=\"#9ACD32\">Total";
echo "<th colspan=\"1\" bgcolor=\"$COLOR\">principal";
echo "<th colspan=\"1\" bgcolor=\"$COLOR\">Interest";
echo "<th colspan=\"1\" bgcolor=\"$COLOR\">Overdue";
//echo "<th colspan=\"1\" bgcolor=\"#808000\">Total";

$color=$TCOLOR;
for($j=0; $j<pg_NumRows($result); $j++) {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
echo "<tr>";


/*
if($j==0){
	$ocrop=trim($row['loan_serial_no']);
	//echo "<h1>$ocrop</h1>";
}
if($ocrop!=trim($row['loan_serial_no'])){
	echo "<tr><td colspan=13 bgcolor=\"YELLOW\"></td></tr>";
	$ocrop=trim($row['loan_serial_no']);
	//echo "<h1>$ocrop</h1>";
}
*/
if($j==0){
	echo "<tr><td colspan=13 bgcolor=\"YELLOW\" align='center'><b>".getInterestRate($row['loan_serial_no'])."</td></tr>";
	$ocrop=trim($row['loan_serial_no']);

}
if($ocrop!=trim($row['loan_serial_no'])){
	echo "<tr><td colspan=13 bgcolor=\"YELLOW\" align='center'><b>".getInterestRate($row['loan_serial_no'])."</td></tr>";
	$ocrop=trim($row['loan_serial_no']);
	
}


echo "<td align=right bgcolor=$color><a href =\"../general/voucherdetails.php?tran_id=".$row['tran_id']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=700,height=500'); return false;\" >".$row['tran_id']."</td>";
echo "<td align=right bgcolor=$color>".$row['action_date']."</td>";
echo "<td align=right bgcolor=$color>".(float)$row['loan_amount']."</td>";
echo "<td align=right bgcolor=$color>".$row['r_principal']."</td>";
echo "<td align=right bgcolor=$color>".$row['r_due_int']."</td>";
echo "<td align=right bgcolor=$color>".$row['r_overdue_int']."</td>";
//$r_total=$row['r_principal']+$row['r_due_int']+$row['r_overdue_int'];
//echo "<td align=right bgcolor=$color>".$r_total."</td>";
echo "<td align=right bgcolor=$color>".(float)$row['b_principal']."</td>";
echo "<td align=right bgcolor=$color>".$row['b_due_int']."</td>";
echo "<td align=right bgcolor=$color>".$row['b_overdue_int']."</td>";
//$b_total=$row['b_principal']+$row['b_due_int']+$row['b_overdue_int'];
//echo "<td align=right bgcolor=$color>".$b_total."</td>";
echo "<td align=right bgcolor=$color>".$row['staff_id']."</td>";
echo "<td align=right bgcolor=$color>".$row['entry_time']."</td>";
	}
}
echo"</table>";
}
if(!empty($op)){
echo "<DIV ID=\"date_time\" style=\"position:relative; left:5; top:5\">";
echo "<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> </DIV> ";
}
echo "</body>";
echo "</html>";
?>
