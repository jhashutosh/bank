<?php
include "../config/config.php";

$staff_id=verifyAutho();
$customer_id=$_REQUEST['id'];
$type=trim($_REQUEST['type']);
//echo "type is $type";
$adm=$_REQUEST['adm'];
//$account_no=getId('m');
$account_no=$_REQUEST['m_no'];
$opening_date=$_REQUEST['op_dt'];
$nominee_status=trim($_REQUEST['r1']);
//echo "<h1>$nominee_status</h1>";
$n_name=$_REQUEST['n_name'];
$n_add=$_REQUEST['n_add'];
$n_age=$_REQUEST['n_age'];
$gov_sh=$_REQUEST['gov_sh'];
$sh_sus=$_REQUEST['sh_sus'];
$member_status=$_REQUEST['l1'];
$relation=$_REQUEST['relation'];
$minor_status=$_REQUEST['r2'];
$dob=$_REQUEST['ndob'];
$no_of_share=$_REQUEST['no_of_share'];
$val_of_share=$_REQUEST['val_of_share']*$no_of_share;
//--------------------------change by sujoy---------------------
$val_ofshare=$_REQUEST['val_of_share'];
//$ldgr_folio=$_REQUEST['ldgr_folio'];
//
if($type=='I'){$gl_member_code='11200';}
elseif($type=='G'){$gl_member_code='11100';}
elseif($type=='S'){$gl_member_code='11300'; }
else {$gl_member_code='11400';} 

$relation=getIndex($relation_array,$relation);
echo "<HTML>";
echo "<head>";
//echo "<meta http-equiv=\"refresh\" content=\"1, url=land_info_t_ef.php?membership_no=$account_no\">";
echo "</head>";
echo "<BODY bgcolor=\"silver\">";
echo "<h1><b>Membership Form</h1>";
echo "<h5>just check wait.....</h5><hr>";
$fy1=$_SESSION['fy'];

if(empty($fy1)){
echo "<h1><center><b>You Can't Insert any value Into database Because Financial Year already Locked by administrator !!!!!!!!!";
}
else{
$t_id=getTranId();
$sql_statement="INSERT INTO membership_info (customer_id,membership_no,date_of_membership, gl_code,status,operator_code,entry_time,lf_no,membership_status,gov_sh,sh_suspense)values('$customer_id','$account_no','$opening_date', '$gl_member_code','op','$staff_id',now(),'$ldgr_folio','$member_status','$gov_sh','$sh_sus')";
//--------------------------for share purchare ---------------------------------------
$sql_statement=$sql_statement.";INSERT INTO gl_ledger_hrd(tran_id,type,action_date, fy,operator_code,entry_time)VALUES('$t_id','sh','$opening_date','$fy1','$staff_id', now())";
$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars)VALUES('$t_id','28101',($val_of_share+$adm),'Dr','share issue')";
$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code, qty,amount,dr_cr, particulars) VALUES('$t_id','$account_no','$gl_member_code',$no_of_share,$val_of_share,'Cr','opening')";
if($adm>0){
$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount, dr_cr, particulars) VALUES('$t_id','$account_no','57905',$adm,'Cr','Admissin Fee')";
}
//$sql_statement=$sql_statement.";INSERT INTO share_details(customer_id,opening_date,no_of_share,per_share,value_of_share) values('$customer_id','$opening_date','$no_of_share','$val_ofshare','$val_of_share')";
$sql_statement=$sql_statement.";UPDATE customer_master SET customer_status='mem' WHERE customer_id='$customer_id'";
//echo $sql_statement;
//$result=dBConnect($sql_statement);
/*if(pg_affected_rows($result)<1)
	 {
  		echo "<h4><font color=RED>FAILED TO INSERT DATA INTO THE MEMBERSHIP TABLE</	font></h4>";
	 }*/
  
	if($nominee_status=="yes" ){
	 	  if($minor_status=="yes"){
             		$sql_statement.=";INSERT INTO nomination (account_no,account_type,name,address,age, relation,dob,operator_code,entry_time) values('$account_no','sh','$n_name','$n_add',age,'$relation','$ndob','$staff_id', now())";
	   		}
	          else{
	     		$sql_statement.=";INSERT INTO nomination (account_no,account_type,name,address,age, relation,operator_code,entry_time) values('$account_no','sh','$n_name','$n_add',$n_age,'$relation','$staff_id', now())";
              	}
}	
	echo   $sql_statement;
	  $result=dBConnect($sql_statement);
	  if(pg_affected_rows($result)<1){
  	    echo "<h4><font color=RED>FAILED TO INSERT DATA INTO THE NOMINEE TABLE</font></h4>";
 	   	}
	  else{
		echo "<h4><font color=GREEN>SUCESS TO INSERT DATA INTO DATABASE</h4>";
		header("location:../main/set_account.php?menu=cust&account_no=$customer_id");
		}
    
}
?>
