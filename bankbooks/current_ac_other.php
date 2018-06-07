<?
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$account_no=$_REQUEST['account_no'];
$account_type=$_REQUEST['account_type'];
$type_of=$_REQUEST['type_of'];
//$type_of_ln=$_REQUEST['type_of_ln'];
$bank_name=$_REQUEST['bank_name'];
$branch_name=$_REQUEST['branch_name'];
$op_date=$_REQUEST['op_date'];
$remarks=$_REQUEST['remarks'];
echo "<html>";
echo "<head>";
echo "<script src=\"../JS/loading.js\"></script>";
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";
echo "<title>Investment";
echo "</title>";
echo "<hr>";
$sql_statement="SELECT * FROM bank_bk_dtl where account_sub_type='ca' and b_name<>'AXIS BANK' AND status='op'";
//echo "$sql_statement";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
echo "<table align=center bgcolor=silver width=100%>";
echo "<tr><th colspan=5 bgcolor=#8A2BE2><font color=white>Current Bank Account Details</font></th>";
echo "<tr bgcolor=GREEN><th>Sl No.<th>A/C No.<th>Bank Name<th>Balance<th>Operation";
		$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
		echo "<tr>";
		echo "<td bgcolor=$color align=\"CENTER\"><B>".($j+1);
		echo "<td bgcolor=$color><B>".strtoupper($row['account_sub_type'])."[".$row['account_no']."]";
		echo "<td bgcolor=$color><B>".strtoupper($row['b_name']);
		if(trim($row['account_type'])!='ln'){
		$balance=(float)ccb_deposits_current_balance($row['account_no']);
		if($balance>0){
		echo "<td bgcolor=$color align=\"RIGHT\"><B>".amount2Rs($balance)." Dr.";
		}
		else{
		echo "<td bgcolor=$color align=\"RIGHT\"><B>".amount2Rs($balance)." Cr.";
		}
		echo "<td bgcolor=$color align=\"\"><B><a href=\"statement.php?menu=".$row['account_type']."&op=1&id=".$row['link_tb']."&account_no=".$row['account_no']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;\">Statement</a>";


$totalbalance=$totalbalance+$balance;


		}
//---------------------------------LOAN---------------------------------------------------------
		else{
			//$balance=(float)ccb_deposits_current_balance($row['account_no']);
		        $balance=total_loan_current_balance($row['account_no'],$action_date);
       			if($balance<0){
			$balance=abs($balance);
			echo "<td bgcolor=$color align=\"RIGHT\"><B>".amount2Rs($balance)." Dr.";
			}
			else{
			echo "<td bgcolor=$color align=\"RIGHT\"><B>".amount2Rs($balance)." Cr.";
			}
echo "<td bgcolor=$color align=\"\">";
		
if(!isOpenLoan($row['account_no'])){
		echo "<a href=\"loan_opening.php?menu=".$row['account_sub_type']."&op=1&id=".$row['link_tb']."&account_no=".$row['account_no']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=200,left=140, width=900,height=500'); return false;\"><b>Opening</a> ||&nbsp;";
}
echo "<a href=\"loan_issue.php?menu=".$row['account_sub_type']."&op=1&id=".$row['link_tb']."&account_no=".$row['account_no']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=720,height=380'); return false;\">Issue</a>&nbsp;||&nbsp;<a href=\"loan_statement.php?menu=".$row['account_sub_type']."&op=1&id=".$row['link_tb']."&account_no=".$row['account_no']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1200,height=580'); return false;\">Statement</a>&nbsp;||&nbsp;<a href=\"loan_repayment.php?menu=".$row['account_sub_type']."&op=&id=".$row['link_tb']."&account_no=".$row['account_no']."\">Repay</a>&nbsp;";
		}
		
	}


echo "<tr>";
$color="cyan";
echo "<td align=center bgcolor=$color><B>Total Account:".($j)." </B></td>";
echo "<td align=right bgcolor=$color><B></B></td>";
echo "<td align=right bgcolor=$color><B></B></td>";
echo "<td align=right bgcolor=$color><B>".$totalbalance."</B></td>";
echo "<td align=right bgcolor=$color><B></B></td>";

echo "<br>";
echo "</table>";


}

?>
