<?
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
isPermissible($menu);
$account_no=$_SESSION['current_account_no'];
echo "<html>";
echo "<head>";
echo "<title>Table: shg_info";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
if(empty($account_no)){echo "<center><font color=RED size=+3><b>You have not inputed any Group No. !!!!!!!!";}
else{
$c_id=getCustomerIdFromGroupId($account_no);
$flag=getGeneralInfo_Customer($c_id);
$member_id=getMemberId($c_id);
if($flag==1){
$no_of_member=getSHGMember($c_id);
//-------------------------------------------------
//echo "<br>";
echo "<table valign=\"top\" width=\"100%\">";
echo "<tr><td bgcolor=\"green\" colspan=\"6\" align=\"center\"><font color=\"white\"><B>List of SHG Members[$account_no]</font>";
// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";
echo "<th bgcolor=$color>SL No</th>";
echo "<th bgcolor=$color>Name</th>";
echo "<th bgcolor=$color>Husband/Father's Name</th>";
echo "<th bgcolor=$color>Address</th>";
echo "<th bgcolor=$color>Caste</th>";
echo "<th bgcolor=$color></th>";
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$sql_statement="SELECT * FROM customer_master WHERE type_of_customer='$account_no'";
$result=dBConnect($sql_statement);
//echo $sql_statement; 
$record=pg_NumRows($result);
if($record==0) {
	//
	for($mno=1;$mno<=$no_of_member;$mno++){
	//echo "Hi how  are u";
	echo "<tr><td bgcolor=$color>$mno";
	echo "<td colspan=5 bgcolor=$color align=\"center\">";
	if($mno==1){$str="Leader Detail Entry Form";}
	else if($mno==2){$str="Sub Leader Detail Entry Form";}
	else{$str="Member Detail Entry Form";}
		
	echo "<A HREF=\"shg_member_ef.php?menu=shg&group_no=$account_no\" >$str </A><BR>";
           }
  } 
else {
           for($j=0; $j<pg_NumRows($result); $j++){
		$row=pg_fetch_array($result,($j));
		echo "<tr>";
		$sl_no=$row['customer_id'];
		echo "<td bgcolor=$color>".$sl_no;
		echo "<td bgcolor=$color>".ucwords($row['name1']);
		echo " ( ".ucwords($row['designation1']).")";
		echo "<td bgcolor=$color>".ucwords($row['father_name1']);
		echo "<td bgcolor=$color>".ucwords($row['address11']);
		echo "<td bgcolor=$color>".$caste_array[$row['caste1']];
		echo "<td bgcolor=$color align=\"center\">";
		echo "<A HREF=\"shg_member_uf.php?menu=shg&sl_no=$sl_no&o=e\" >edit</A> &nbsp; &nbsp;";
		echo "<A HREF=\"shg_member_uf.php?menu=shg&sl_no=$sl_no&o=d\" >detail</A>";
	      }
	        //$j=$j+1;
               if($record!=$no_of_member)
		 {
		   for($i=$record;$i<$no_of_member;$i++)
			{
			  echo "<tr><td bgcolor=$color>".($i+1);
			  echo "<td colspan=5 bgcolor=$color align=\"center\">";
                          echo "<A HREF=\"shg_member_ef.php?menu=shg&group_no=$account_no\" > New entry </A>";	        }
                  }
   }
echo "</table>";


//-----------------------------------accounting information---------------------------------
echo "<br>";
//$id=getCustomerIdFromGoupId($account);
$sql_statement="SELECT * FROM customer_account WHERE customer_id='$c_id' AND status='op' AND opening_date<=current_date";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<h1><center><font color=Green>New account.</center></font></h1>";
	} 
else {
	echo "<table valign=\"top\" width=\"100%\">";
	echo "<tr><td bgcolor=\"blue\" colspan=\"4\" align=\"center\"><font color=\"white\"><b>Summry of Accounts[$account_no]</font>";

// Place line comments if you do not need column header.
	$color=$TCOLOR;
	echo "<tr>";
	echo "<th bgcolor=$color>Account no</th>";
	echo "<th bgcolor=$color>Account type</th>";
	echo "<th bgcolor=$color>Balance/Maturity Value (Rs.)</th>";
	echo "<th bgcolor=$color>Remarks</th>";
	for($j=1; $j<=pg_NumRows($result); $j++) {
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,($j-1));
	echo "<tr>";
	echo "<td align=center bgcolor=$color><a href=\"../main/pop_up_account.php?menu=".trim($row['account_type'])."&account_no=".$row['account_no']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes,top=100,left=150, width=1050,height=500'); return false;\">".$row['account_no']."</A></td>";
	echo "<td align=center bgcolor=$color>".$type_of_account1_array[trim($row['account_type'])]."</td>";
	if(!strcmp(trim($row['account_type']),'sb')){
	$sb_flag=1;
	echo "<td align=right bgcolor=$color>".amount2Rs(sb_current_balance($row['account_no']))."</td>";
	}
	if(!strcmp(trim($row['account_type']),'fd')||!strcmp(trim($row['account_type']),'rd')||!strcmp(trim($row['account_type']),'ri')||!strcmp(trim($row['account_type']),'mis')){
	echo "<td align=right bgcolor=$color>".amount2Rs(sb_current_balance($row['account_no']));

	}
	if(!strcmp(trim($row['account_type']),'mt')||!strcmp(trim($row['account_type']),'pl')||!strcmp(trim($row['account_type']),'sfl')||!strcmp(trim($row['account_type']),'ccl')||!strcmp(trim($row['account_type']),'spl')||!strcmp(trim($row['account_type']),'bdl')||!strcmp(trim($row['account_type']),'kpl')||!strcmp(trim($row['account_type']),'sgl')){
$balance=total_loan_current_balance($row['account_no']);
echo "<td align=right bgcolor=$color>".amount2Rs($balance);
//echo "<td align=right bgcolor=$color>0</td>";
}
	echo "<td align=right bgcolor=$color>".$row['remarks'];
      }
 	echo "</table>";
 }
echo "<HR>";
//---------------------------------------------------------------------------------------
if(isSHG($c_id)){
	if(isopenSHG($c_id)){
if(empty($member_id)){
echo "<b>Create Membership :</b><blink><A HREF=\"customer_membership_ef.php?id=$id&type=m\">Member</a></blink>";
}
echo "<br><B>Open a new account:</B>";
if($sb_flag==1){
echo "&nbsp;Saving";
}
else {
echo "&nbsp; <A HREF=\"../customer/customer_ac_open_ef.php?id=$c_id&type=sb\">Saving</A>";
}
echo "&nbsp; <A HREF=\"../customer/customer_ac_open_ef.php?menu=$menu&id=$c_id&type=fd\">Fixed deposit</A>";
echo "&nbsp; <A HREF=\"../customer/customer_ac_open_ef.php?menu=$menu&id=$c_id&type=rd\">Recurring deposit</A>";
echo "&nbsp; <A HREF=\"../customer/customer_ac_open_ef.php?menu=$menu&id=$c_id&type=ri\">Reinvestment</A>";
//echo "&nbsp; <A HREF=\"../customer/customer_ac_open_ef.php?menu=$menu&id=$id&type=mis\">MIS</A>";
//echo "&nbsp; <A HREF=\"../customer/customer_ac_open_ef.php?menu=$menu&id=$id&type=pl\">Pledge</A>";
//echo "&nbsp; <A HREF=\"../customer/customer_ac_open_ef.php?menu=$menu&id=$c_id&type=lo\">Loan</A>";
//echo "&nbsp; <A HREF=\"../customer/customer_ac_open_ef.php?menu=$menu&id=$id&type=kcc\">KCC</A>";
    }
}}
//-----------------------------------------------------------------------------------------
  
  else{
     echo "Record Not Found !!!!!!!!!!!!!!";
    }
 }
//-------------------------------------------------
echo "<HR>";
echo "</body>";
echo "</html>";
?>
