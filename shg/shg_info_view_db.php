<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$current_date=date('d.m.Y');
echo "<html>";
echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
$sum_no_of_member=0;
$sum_sb_bal=0.0;
$sum_fd_dep=0.0;
$sum_fd_mat=0.0;
$sum_rd_bal=0.0;
$sum_rd_mat=0.0;
$sum_ri_dep=0.0;
$sum_ri_mat=0.0;
$sql_statement="SELECT * FROM customer_shg ORDER BY CAST(SUBSTR(shg_no,5,length(shg_no)) AS INT) desc";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h4>Not found!!!</h4>";
} else {
echo "<table valign=\"top\" width=\"100%\"  bgcolor=\"BLACK\">";
//echo "<tr><td bgcolor=\"red\" colspan=\"11\" align=\"center\"><font color=\"white\">Summry of SHGs as on ".date('d/m/Y')."</font>";

// Place line comments if you do not need column header.
$color=$TCOLOR;
for($j=1; $j<=pg_NumRows($result); $j++) {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j-1));
echo "<tr>";
$g_id=$row['shg_no'];
$c_id=getCustomerIdFromGroupId($g_id);
//echo "customer_id is:$c_id";
echo "<td align=Center bgcolor=$color width=\"70\"><a href=\"../main/set_account.php?menu=$menu&account_no=$g_id\" target=\"_parent\">$g_id</a></td>";
echo "<td bgcolor=$color width=\"200\" >".ucwords($row['name1'])."</td>";
if(trim($row['sex1'])=='m'){$sex="Male";}
if(trim($row['sex1'])=='f'){$sex="Female";}
if(trim($row['sex1'])=='u'){$sex="Mixed";}
echo "<td align=Center bgcolor=$color width=\"46\">$sex</td>";
$member=$row['no_of_member'];
$total_mem=$total_mem+$member;
echo "<td align=right bgcolor=$color width=\"75\">".$member."</td>";
//echo "<td align=right bgcolor=$color width=\"132\">".$row['date_of_opening']."</td>";
$loan_el_date=date($row['loan_el_date']);
echo "<td align=center bgcolor=$color width=\"120\">".$loan_el_date."</td>";
$tmp=deposit_total_balance($c_id);
$sum=$sum+$tmp;
echo "<td align=right bgcolor=$color width=\"80\"><a href=\"shg_deposit_detail.php?group_no=$g_id\" target=\"_parent\">$tmp</a></td>";
$loan_amount=loan_total_balance($g_id);
$total_loan=$total_loan+$loan_amount;
echo "<td align=right bgcolor=$color width=\"80\"><a href=\"shg_loan_detail.php?group_no=$g_id\" target=\"_parent\">$loan_amount</a></td>";
$current_date=(is_string($current_date)?strtotime($current_date):$current_date);
$loan_el_date=(is_string($loan_el_date)?strtotime($loan_el_date):$loan_el_date);
$diff=$current_date-$loan_el_date;
//echo "differ:$diff";
if($diff>0){
echo "<td align=Center bgcolor=$color ><a href=\"../shg/loan_ledger_ef.php?menu=$menu&account_no=$g_id\" target=\"_parent\">Issue</a>/";
      }
else {
    echo "<td align=Center bgcolor=$color >Issue /";
  }
if($loan_amount>0){
echo "<a href=\"shg_info_detail.php?group_no=".$g_id."\" target=\"display\">Repay</a></td>";
}
else{
     echo "Repay</td>";
}
 
}
$color="cyan";
echo "<tr>";
echo "<td align=center bgcolor=$color colspan=3><B>Total: ".($j-1)."</B></td>";
echo "<td align=right bgcolor=$color><B>$total_mem</B></td>";
echo "<td align=right bgcolor=$color></td>";

echo "<td align=right bgcolor=$color><b>$sum</b></td>";
echo "<td align=right bgcolor=$color><B>$total_loan</B></td>";
echo "<td align=right bgcolor=$color></td>";
echo "</table>";
}

echo "</body>";
echo "</html>";

?>
