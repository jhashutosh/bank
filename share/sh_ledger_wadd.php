<?php
include "../config/config.php";
$staff_id=verifyAutho();
$account_no=$_REQUEST["membership_no"];
$member_no=$_REQUEST["member_no"];
$menu=$_REQUEST['menu'];
$action_date=$_REQUEST['action_date'];
$unit=$_REQUEST['unit'];
$total_val_share=$_REQUEST['val_share'];
$remarks=$_REQUEST['remarks'];
echo "<html>";
echo "<head>";
echo "<title>Statement";
echo "</title>";
echo "</head>";
echo "<body bgcolor=\"silver\">";
$fy=getFy($action_date);
if(empty($fy)){
echo "<h1><center><b>You Can't Insert any value Into database Because Financial Year already Locked by administrator !!!!!!!!!";
}
else{
	$t_id=getTranId();
	$gl_code=getGlCode4mMember($account_no);
	$sql_statement="INSERT INTO gl_ledger_hrd(tran_id,type, action_date,fy,remarks, operator_code, entry_time) VALUES ('$t_id','sh','$action_date','$fy','$remarks','$staff_id',now())";

		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,account_no,amount,qty,dr_cr, particulars) VALUES('$t_id','$gl_code','$account_no',$total_val_share,$unit,'Dr','cl trf[$member_no]')";

		
		$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,qty,dr_cr, particulars,account_no) VALUES('$t_id','$gl_code',$total_val_share,'$unit','Cr','trf[$account_no]','$member_no')";
		
		       $sql_statement=$sql_statement.";update membership_info set status='cl',closing_date='$action_date' where membership_no='$account_no'";
	
	echo $sql_statement;
	$result=dBConnect($sql_statement);
	if(pg_affected_rows($result)<1) {
		echo "<br><h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
	} 
	else {
	header("location:../main/set_account.php?menu=sh&account_no=$account_no");
	}
}
echo "</body>";
echo "</html>";
?>
