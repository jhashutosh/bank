<?php
include "../config/config.php";
registerSession();
$account=trim($_SESSION['current_account_no']);
$id=$_REQUEST['id'];
$menu=$_REQUEST['menu'];
//isPermissible($menu);
echo "<html>";
echo "<head>";
echo "<title>Customer Details";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
if ($id==null){$id=strtoupper($account);}
$flag=getGeneralInfo_Customer($id);
if($flag==1){
echo "<hr>";
//------------------------------------------------------------------------------------------------
//$sql_statement="SELECT * FROM customer_account WHERE customer_id='$id' and (status='op' or status='cl') and account_type<>'jlg'";
$sql_statement="SELECT * FROM customer_account a WHERE customer_id='$id' and (status='op' or status='cl') and opening_date=(select max(opening_date) from customer_account b where a.account_no=b.account_no) and account_type<>'jlg'";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h1><center><font color=Green>New Customer</center></font></h1>";
} else { //1 open
echo "<table valign=\"top\" width=\"100%\">";
echo "<tr><td bgcolor=\"blue\" colspan=\"4\" align=\"center\"><font color=\"white\">Summry of Accounts</font>";

// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
//echo "<th bgcolor=$color>Group no</th>";
echo "<th bgcolor=$color>Account no</th>";
echo "<th bgcolor=$color>Account type</th>";
echo "<th bgcolor=$color>Balance/Maturity Value (Rs.)</th>";
echo "<th bgcolor=$color>Remarks</th>";
for($j=1; $j<=pg_NumRows($result); $j++) {//2 open
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j-1));
echo "<tr>";
//payroll//
	if($row['account_type']=='pfsb')
	{
		echo "<td align=center bgcolor=$color><font color='blue'>".$row['account_no']."</td>";
	}
	else
	{
		echo "<td align=center bgcolor=$color><a href=\"../main/pop_up_account.php?menu=".trim($row['account_type'])."&account_no=".$row['account_no']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes,top=100,left=150, width=1050,height=500'); return false;\">".$row['account_no']."</A></td>";
	}
//payroll//
echo "<td bgcolor=$color>".$type_of_account1_array[trim($row['account_type'])]."</td>";
if(!strcmp(trim($row['account_type']),'sb')){
$sb_flag=1;
echo "<td align=right bgcolor=$color>".amount2Rs(sb_current_balance($row['account_no'],''))." <B>Cr.</td>";
}
//sas
if(!strcmp(trim($row['account_type']),'pfsb')){
	$sql="select op_bal+total_empl_cont_pf_amt+total_emplee_cont_pf_amt as bal from emp_pf_dtl where pf_ac_no='".$row['account_no']."'"; 
	$res=dBConnect($sql);
	$bal=pg_result($res,'bal');
$pfsb_flag=1;
echo "<td align=right bgcolor=$color>".amount2Rs($bal)." <b>Cr.</td>";
}
//sas
if(!strcmp(trim($row['account_type']),'fd')){
echo "<td align=right bgcolor=$color>".amount2Rs(sb_current_balance($row['account_no'],''))." <B>Cr.</td>";
//echo fd_maturity_amount($row['account_no'])."</td>";
}
if(!strcmp(trim($row['account_type']),'rd')){
echo "<td align=right bgcolor=$color>".amount2Rs(sb_current_balance($row['account_no']))." <B>Cr.</td>";
//echo rd_maturity_amount($row['account_no'])."</td>";
}
if(!strcmp(trim($row['account_type']),'ri')){
echo "<td align=right bgcolor=$color>".amount2Rs(sb_current_balance($row['account_no']))." <B>Cr.</td>";
//echo ri_maturity_amount($row['account_no'])."</td>";
}
/*if(!strcmp(trim($row['account_type']),'mis')){
echo "<td align=right bgcolor=$color>".amount2Rs(sb_current_balance($row['account_no']))." <B>Cr.</td>";
//echo ri_maturity_amount($row['account_no'])."</td>";
}
if(!strcmp(trim($row['account_type']),'hsb')){
echo "<td align=right bgcolor=$color>".amount2Rs(sb_current_balance($row['account_no']))." <B>Cr.</td>";
//echo ri_maturity_amount($row['account_no'])."</td>";
}*/
if(!strcmp(trim($row['account_type']),'add')) {
$add_flag=1;
$amount=sb_current_balance($row['account_no']);
if($amount>0){
	echo "<td align=right bgcolor=$color>".amount2Rs($amount)." <b>Dr</td>";
	}
else{
	
	echo "<td align=right bgcolor=$color>".amount2Rs(abs($amount))." <b>Dr</b></td>";
	
}
}

if(!strcmp(trim($row['account_type']),'kcc')){
//$loan=loan_current_balance($row['account_no']);
$balance=total_loan_current_balance($row['account_no']);
echo "<td align=right bgcolor=$color>".amount2Rs($balance)." <B>Dr.</td>";
$flag_kcc=1;
}
if(!strcmp(trim($row['account_type']),'sao')){
//$loan=loan_current_balance($row['account_no']);
$balance=total_loan_current_balance($row['account_no']);
echo "<td align=right bgcolor=$color>".amount2Rs($balance)." <B>Dr.</td>";
//$flag_sao=1;
}


/*if(!strcmp(trim($row['account_type']),'mtb')){
//$loan=loan_current_balance($row['account_no']);
$balance=total_loan_current_balance($row['account_no']);
echo "<td align=right bgcolor=$color>".amount2Rs($balance)." <B>Dr.</td>";
//$flag_mtb=1;
}
*/
if(!strcmp(trim($row['account_type']),'pl')||!strcmp(trim($row['account_type']),'sgl')||!strcmp(trim($row['account_type']),'mt')||!strcmp(trim($row['account_type']),'lad')||!strcmp(trim($row['account_type']),'ccl')||!strcmp(trim($row['account_type']),'sfl')||!strcmp(trim($row['account_type']),'ks')||!strcmp(trim($row['account_type']),'kpl')||!strcmp(trim($row['account_type']),'ofl')||!strcmp(trim($row['account_type']),'bdl')||!strcmp(trim($row['account_type']),'nf')||!strcmp(trim($row['account_type']),'spl')||!strcmp(trim($row['account_type']),'sao')||!strcmp(trim($row['account_type']),'ser')||!strcmp(trim($row['account_type']),'hbl')||!strcmp(trim($row['account_type']),'car')||!strcmp(trim($row['account_type']),'mtb')||!strcmp(trim($row['account_type']),'fis')){
$balance=total_loan_current_balance($row['account_no'],'');
echo "<td align=right bgcolor=$color>".amount2Rs($balance)." <B>Dr.</td>";;
}
echo "<td align=right bgcolor=$color>".$row['remarks']."</td>";
} //2 close
echo "</table>";
}//1 close
echo "<HR>";
$group_type='';
getSHGInfo($id,$no_of_member,$leader,$group_id,$group_type);

$member_id=getMemberId($id);
if(empty($member_id)){
       echo "<b>Create Membership :</b><blink><A HREF=\"customer_membership_ef.php?id=$id&type=m\">Member</a></blink><br>";
       }
echo "<B>Open a new account:</B>";
echo "<br><b>Deposits:";
// here change
if(!$sb_flag==1){
//echo "&nbsp;Saving";
echo "&nbsp; <A HREF=\"customer_ac_open_ef.php?id=$id&type=sb\">Saving&nbsp;||</A>";
}
if(!$add_flag==1){
	//echo "&nbsp; <A HREF=\"customer_ac_open_ef.php?id=$id&type=add\">Advance&nbsp;||</A>";
	}
//payroll
$sql="select count(*) from emp_master where customer_id='$id'";
$res=dBConnect($sql);
$row=pg_fetch_array($res,0);
if($row['count']==1){
if(!$pfsb_flag==1)
echo "&nbsp; <A HREF=\"customer_ac_open_ef.php?id=$id&type=pfsb\">PF Savings &nbsp;||</A>";
}
//payroll
echo "&nbsp; <A HREF=\"customer_ac_open_ef.php?menu=$menu&id=$id&type=fd\">Fixed deposit&nbsp;||</A>";
echo "&nbsp; <A HREF=\"customer_ac_open_ef.php?menu=$menu&id=$id&type=rd\">Recurring deposit&nbsp;||</A>";
echo "&nbsp; <A HREF=\"customer_ac_open_ef.php?menu=$menu&id=$id&type=ri\">Reinvestment&nbsp;||</A>";
//echo "&nbsp; <A HREF=\"customer_ac_open_ef.php?menu=$menu&id=$id&type=mis\">MIS&nbsp;||</A>";
//echo "&nbsp; <A HREF=\"customer_ac_open_ef.php?menu=$menu&id=$id&type=hsb\">HSB&nbsp;</A>";
echo "<br>";
//getSHGInfo($id,$no_of_member,$leader,$group_id);
if(empty($group_id)){
//if(empty($group_id_jlg)){
// loan section
echo "<b>Loan:";
//echo "&nbsp; <A HREF=\"customer_ac_open_ef.php?menu=$menu&id=$id&type=pl\">Pledge</A>";
echo "&nbsp;||&nbsp; <A HREF=\"customer_ac_open_ef.php?menu=$menu&id=$id&type=lad\">LAD Loan</A>";
echo "&nbsp;||&nbsp; <A HREF=\"customer_ac_open_ef.php?menu=$menu&id=$id&type=ofl\">Own Fund Loan</A>";
if(!empty($member_id)){
	//echo "&nbsp;||&nbsp; <A HREF=\"customer_ac_open_ef.php?menu=$menu&id=$id&type=mt\">MTLoan</A>";
	if(empty($flag_kcc))
	{
		echo "&nbsp;||&nbsp; <A HREF=\"customer_ac_open_ef.php?menu=$menu&id=$id&type=kcc\">KCC</A>";
	}

	if(empty($flag_sao))
	{
		echo "&nbsp;||&nbsp; <A HREF=\"customer_ac_open_ef.php?menu=$menu&id=$id&type=sao\">SAO</A>";
	}

	if(empty($flag_mtb))
	{
		echo "&nbsp;||&nbsp; <A HREF=\"customer_ac_open_ef.php?menu=$menu&id=$id&type=mtb\">MTB</A>";
	}

}
echo "&nbsp;||&nbsp; <A HREF=\"customer_ac_open_ef.php?menu=$menu&id=$id&type=ccl\">Cash Credit Loan</A>";
echo "&nbsp;||&nbsp; <A HREF=\"customer_ac_open_ef.php?menu=$menu&id=$id&type=ser\">Personal Service Loan</A>";
echo "&nbsp;||&nbsp; <A HREF=\"customer_ac_open_ef.php?menu=$menu&id=$id&type=hbl\">HBL Loan</A>";
//echo "&nbsp;||&nbsp; <A HREF=\"customer_ac_open_ef.php?menu=$menu&id=$id&type=ks\">KS Loan</A>";
echo "&nbsp;||&nbsp; <A HREF=\"customer_ac_open_ef.php?menu=$menu&id=$id&type=sfl\">Staff Loan</A>";
echo "&nbsp;||&nbsp; <A HREF=\"customer_ac_open_ef.php?menu=$menu&id=$id&type=kpl\">KVP Loan</A>";
//echo "&nbsp;||&nbsp; <A HREF=\"customer_ac_open_ef.php?menu=$menu&id=$id&type=fis\">Fisary Loan</A>";
//echo "&nbsp;||&nbsp; <A HREF=\"customer_ac_open_ef.php?menu=$menu&id=$id&type=spl\">SMP Loan</A>";
//echo "&nbsp;||&nbsp; <A HREF=\"customer_ac_open_ef.php?menu=$menu&id=$id&type=bdl\">Bond Loan</A>";
//echo "&nbsp;||&nbsp; <A HREF=\"customer_ac_open_ef.php?menu=$menu&id=$id&type=nf\">Non Farm Loan</A>";
//}
if(empty($group_id)){
echo "<BR><b>Land:";

echo "&nbsp; <A HREF=\"../land/land_ledger_ef.php?status=$menu&menu=ln\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=120,left=150, width=1000,height=450'); return false;\">Add</A>";
echo "&nbsp;||&nbsp; <A HREF=\"../land/land_statement.php?status=$menu&menu=ln\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=120,left=150, width=1000,height=600'); return false;\">Statement</A>";
echo "&nbsp;||&nbsp; <A HREF=\"../land/land_ledger_lef.php?status=$menu&menu=ln\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=120,left=150, width=1000,height=450'); return false;\">Less</A>";
//echo "<BR><b>Pond:";

//echo "&nbsp; <A HREF=\"../pond/pond_ledger_ef.php?status=$menu&menu=po\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=120,left=150, width=1000,height=450'); return false;\">Add</A>";
//echo "&nbsp;||&nbsp; <A HREF=\"../pond/pond_statement.php?status=$menu&menu=po\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=120,left=150, width=1000,height=600'); return false;\">Statement</A>";
//echo "&nbsp;||&nbsp; <A HREF=\"../pond/pond_ledger_lef.php?status=$menu&menu=po\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=120,left=150, width=1000,height=450'); return false;\">Less</A>";
echo "<BR><b>Lease:";

echo "&nbsp; <A HREF=\"../lease/land_ledger_ef.php?status=$menu&menu=ls\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=120,left=150, width=1000,height=450'); return false;\">Add</A>";
echo "&nbsp;||&nbsp; <A HREF=\"../lease/land_statement.php?status=$menu&menu=ls\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=120,left=150, width=1000,height=600'); return false;\">Statement</A>";
echo "&nbsp;||&nbsp; <A HREF=\"../lease/land_ledger_lef.php?status=$menu&menu=ls\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=120,left=150, width=1000,height=450'); return false;\">Less</A>";
}
}
//echo "<BR>";
		//}
	//}
}
echo "</body>";
echo "</html>";
?>
