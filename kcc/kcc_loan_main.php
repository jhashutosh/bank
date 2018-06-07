<?php
include "../config/config.php";
$menu=$_REQUEST['menu'];
$account_no=$_REQUEST['account_no'];
$op=$_REQUEST['op'];
$staff_id=verifyAutho();
$l_name='KCC';
$status='kcc';
$i_page="../kcc/kcc_loan_issue.php?menu=kcc&account_no=$account_no";
$r_page="../kcc/kcc_loan_repayment.php?menu=kcc&account_no=$account_no";
$s_page="../kcc/kcc_loan_statement.php?menu=kcc&op=i&account_no=$account_no";
/*
if(!empty($account_no)){
	$arr=explode(",",$account_no); // Multiple entry seperated by ,
	$n=count($arr);
	for($i=0; $i<($n-1);$i++){
		$WHERE_CONDITIONS="$WHERE_CONDITIONS AND account_no='$arr[$i]' OR ";
	}
 
	$WHERE_CONDITIONS="WHERE $WHERE_CONDITIONS AND account_no='$arr[$i]'"; 
	$name='Account No List';
	
} else {

	if($op=='d'||$op=='o'||$op=='i'){
		$WHERE_CONDITIONS="WHERE $WHERE_CONDITIONS AND loan_type='$status' AND status='$op'"; 
       }else{
		$WHERE_CONDITIONS="WHERE $WHERE_CONDITIONS AND loan_type='$status'";
	
	    } */
	if($op=='d'){
		$sql_statement="select account_no,sum(loan_amount-r_principal) as principal, sum(due_interest-r_due_int) as due_int, sum(od_interest-r_od_int) as od_int from get_mas_bal_dt(current_date) group by account_no having sum(due_interest-r_due_int)>0 and sum(od_interest-r_od_interest)<=0";
	} else if($op=='o'){
		$sql_statement="select account_no,sum(loan_amount-r_principal) as principal, sum(due_interest-r_due_int) as due_int, sum(od_interest-r_od_int) as od_int from get_mas_bal_dt(current_date) group by account_no having sum(od_interest-r_od_int)>0";
	}  else {
		$sql_statement="select account_no,sum(loan_amount-r_principal) as principal, sum(due_interest-r_due_int) as due_int, sum(od_interest-r_od_int) as od_int from get_mas_bal_dt(current_date) group by account_no";
	//$name=$name;
	}

echo "<html>";
echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
?>
<script language="javascript">
function onSubmits(f)
{
  f.submit();
}
</script>

<?php

echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<form action=\"kcc_loan_main.php\">";

echo "<table width=\"100%\" bgcolor=\"yellow\" align=\"center\"><tr><th>";
echo "Viewing Option :&nbsp";
echo "<select name=\"op\" onchange=\"onSubmits(this.form);\">";
echo "<option value=\"s\">Select";
echo "<option value=\"a\">All List";
echo "<option value=\"d\">Due List";
echo "<option value=\"o\">Overdue List";
//echo "<option value=\"i\">New List";
echo "</select>"; 

echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
Search By Account No: <input type=\"\" name=\"account_no\" id=\"account_no\" $HIGHLIGHT>&nbsp;<input type=\"SUBMIT\" value=\"Enter\">";
echo "</table>";
//echo "<iframe width=\"900%\" height=\"350\">";
echo "<table  width=\"100%\">";
echo "<tr><td bgcolor=\"#808000\" colspan=\"10\" align=\"center\"><font color=\"white\"><b>MAIN MENU OF $l_name of $name as on ".date('d.m.Y')."</font>";
echo "</form>";
$color="GREEN";
echo "<tr>";
echo "<th bgcolor=$color width =\"80\" Rowspan=\"2\">A/C No</th>";
echo "<th bgcolor=$color width =\"150\" Rowspan=\"2\">Name</th>";
echo "<th bgcolor=$color width=\"80\" Rowspan=\"2\">Principal<br>(Rs.)</th>";
echo "<th bgcolor=$color width =\"75\" colspan=\"2\">Interest</th>";
echo "<th bgcolor=$color width =\"80\" Rowspan=\"2\">Total<br>(Rs.)</th>";
echo "<th bgcolor=$color width=\"70\"Rowspan=\"2\">Total Land</th>";
echo "<th bgcolor=$color width=\"80\" Rowspan=\"2\">Value of Share(Rs.)</th>";
echo "<th bgcolor=$color Rowspan=\"2\">Operation</th>";
echo "<tr><th bgcolor=$color width =\"100\">Due</th>";
echo "<th bgcolor=$color width =\"100\">Overdue</th>";
echo "<table bgcolor=\"aqua\" width=\"100%\">";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
for($j=1; $j<=pg_NumRows($result); $j++){
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j-1));
if($row['od_int']>0){
$color=$color;
$fcolor="#DC143C";
}
else{
$color=$color;
$fcolor="black";
}


echo "<tr>";
echo "<td align=CENTER bgcolor=$color width =\"80\"><a href=\"$s_page".$row['account_no']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes,top=100,left=150, width=1050,height=500'); return false;\"><font color=$fcolor>".$row['account_no']."</font></a></td>";
$menu='kcc';
$id=getCustomerId($row['account_no'],$menu);
echo "<td align=Center bgcolor=$color width =\"150\"><font color=$fcolor>".getName('customer_id',$id,'name1','customer_master')."</font></td>";
echo "<td align=right bgcolor=$color width=\"80\"><font color=$fcolor>".$row['principal']."</font></td>";
echo "<td align=right bgcolor=$color width =\"100\"><font color=$fcolor>".$row['due_int']."</font></td>";
echo "<td align=right bgcolor=$color width =\"100\"><font color=$fcolor>".$row['od_int']."</font></td>";
echo "<td align=right bgcolor=$color width =\"80\"><font color=$fcolor>".($row['principal']+$row['due_int']+$row['od_int'])."</font></td>";
echo "<td align=right bgcolor=$color width=\"70\"><font color=$fcolor>".getAcer(getLand($id))."</font>";
$membership_id=getMemberId($id);
share_current_balance($membership_id,$no,$val);
echo "<td align=right bgcolor=$color width=\"80\"><font color=$fcolor>$val</font>";

echo "<td align=CENTER bgcolor=$color><a href=\"$i_page".$row['account_no']."\" target=\"_child\">Issue</a>  || <a href=\"$r_page".$row['account_no']."\" target=\"_child\">Repay</a></td>";
  }

}
//echo "</iframe></td></tr>";
//echo "<tr bgcolor=\"AQUA\"><th colspan=\"2\">Total:  ".$row['no_row']." Account Found!!!!!<th align=\"right\">".$row['principal']."<th align=\"right\">".$row['due_int']."<th align=\"right\">".$row['od_int']."<th align=\"right\">".($row['principal']+$row['due_int']+$row['od_int'])."<th>";
echo "</table>";
echo "</iframe>";
echo "</body>";
echo "</html>";

?>
