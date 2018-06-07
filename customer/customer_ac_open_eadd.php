<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$account_no=$_REQUEST['ac_no'];
$op=$_REQUEST['op'];
$customer_id=$_REQUEST['id'];
$type=$_REQUEST['type'];
$opening_date=$_REQUEST['op_dt'];
$nominee_status=$_REQUEST['r1'];
$n_name=$_REQUEST['n_name'];
$n_add=$_REQUEST['n_add'];
$n_age=$_REQUEST['n_age'];
$relation=$_REQUEST['relation'];
$minor_status=$_REQUEST['r2'];
$dob=$_REQUEST['ndob'];
$mode=$_REQUEST['mode'];
$code=$_REQUEST['code'];
$op_bal=$_REQUEST['op_bal'];
if($type=='jl')
{
	$type=='sb';
}
$typeIn=getIndex($type_of_account1_array,$type);
//echo "Type is :$type";
//echo "Type index is :$typeIn";
$mode=getIndex($account_operation_array,$mode);
$relation=getIndex($relation_array,$relation);
if(empty($op)){
	$flag='c';
	if($typeIn=='sb'||$typeIn=='pfsb'||$typeIn=='fd'||$typeIn=='ri'||$typeIn=='rd'||$typeIn=='mis'||$typeIn=='hsb'||$typeIn=='jl'){
		//if($typeIn=='sb'){$account_no=getId($typeIn);}
		$gl_code=getGlCode4Deposit($customer_id,$typeIn);
		}
	//echo $code;
	if($typeIn=='add'){$gl_code=getIndex($add_type_array,$code);}
	if($typeIn=='mt'){$gl_code=getIndex($mtloan_type_array,$code);}
	if($typeIn=='mtb'){$gl_code=getIndex($mtbloan_type_array,$code);}
	if($typeIn=='ks'){$gl_code=getIndex($ksloan_type_array,$code);}
	if($typeIn=='pl'){$gl_code=getIndex($pledge_type_array,$code);}
	if($typeIn=='kpl'){$gl_code=getIndex($kpl_type_array,$code);}
	if($typeIn=='bdl'){$gl_code=getIndex($bdl_type_array,$code);}
	if($typeIn=='sfl'){$gl_code=getIndex($sfl_type_array,$code);}
	if($typeIn=='ofl'){$gl_code=getIndex($ofl_type_array,$code);}
	if($typeIn=='ccl'){$gl_code=getIndex($ccl_type_array,$code);}
	if($typeIn=='spl'){$gl_code=getIndex($spl_type_array,$code);}
	if($typeIn=='lad'){$gl_code=getIndex($lad_type_array,$code);}
	if($typeIn=='ser'){$gl_code=getIndex($serloan_type_array,$code);}
	if($typeIn=='hbl'){$gl_code=getIndex($hbl_type_array,$code);}
	if($typeIn=='car'){$gl_code=getIndex($carloan_type_array,$code);}
	if($typeIn=='fis'){$gl_code=getIndex($fisloan_type_array,$code);}
	if($typeIn=='sao'){$gl_code=getIndex($sao_type_array,$code);}
	if($typeIn=='nf'){$gl_code=getIndex($nf_type_array,$code);}
	if($typeIn=='kcc'){$gl_code='23103';}
	
	}
else{
	$flag='b';

	if($typeIn=='sb'||$typeIn=='fd'||$typeIn=='ri'||$typeIn=='rd'||$typeIn=='mis'||$typeIn=='pfsb'||$typeIn=='ca'||$typeIn=='hsb'){
		$gl_code=getGlCodeBank($customer_id,$typeIn);
		}

}
//echo "gl_code is $gl_code";
echo "<HTML>";
echo "<BODY bgcolor=\"silver\">";
echo "<h1><b>".$typeIn." A/C. open Form</h1>";
echo "Type is :$type";
echo "Type index is :$typeIn";
echo "<h5>just check wait.....</h5><hr>";
$sql_statement="INSERT INTO customer_account (customer_id,opening_date,account_no, account_type,operation_mode,gl_mas_code,operator_code,entry_time,status,account_flag)values('$customer_id','$opening_date',upper('$account_no'),'$typeIn','$mode','$gl_code','$staff_id',now(),'op','$flag')";
echo $sql_statement;
if($typeIn=='sb'){
$t_id=getTranId();
if($op_bal>0){
	$sql_statement.=";INSERT INTO gl_ledger_hrd(tran_id,type,action_date,fy,remarks,operator_code,entry_time) VALUES ('$t_id','sb', '$opening_date','$fy','opeing sb','$staff_id',now())";
	//$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl(tran_id,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','28101',$op_bal,'Dr','opening sb')";
	$sql_statement=$sql_statement.";INSERT INTO gl_ledger_dtl (tran_id,account_no,gl_mas_code,amount,dr_cr, particulars) VALUES('$t_id','$account_no','$gl_code',$op_bal,'Cr','opening sb')";
}


}
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_affected_rows($result)<1)
 {
  echo "<h4><font color=RED>FAILED TO INSERT DATA INTO THE ACCOUNT TABLE</font></h4>";
 }
else{  
	if($nominee_status=="yes" )
	 {
 	  if($minor_status=="yes")
       	   {
             $sql_statement="INSERT INTO nomination (account_no,action_date,account_type,name,address,age, relation,dob, operator_code,entry_time) values('$account_no','$opening_date','$typeIn',lower('$n_name'),lower('$n_add'),$n_age, '$relation','$dob','$staff_id',now())";
	   }
	  else{
	     $sql_statement="INSERT INTO nomination (account_no,action_date,account_type,name, address,age,relation, operator_code,entry_time) values('$account_no','$opening_date','$typeIn', lower('$n_name'),lower('$n_add'),$n_age,'$relation','$staff_id',now())";
              }	
	 // echo   $sql_statement;
	  $result=dBConnect($sql_statement);
	  if(pg_affected_rows($result)<1)
 	   {
  		echo "<h4><font color=RED>FAILED TO INSERT DATA INTO THE NOMINEE TABLE</font></h4>";
 	   }
	  
          }
     		// echo "<center><h1><font color=GREEN>Your ". $type." A/C No. is : $account_no</font></h1></center>";
	     // echo "<h4>From today you are our one of the valuable family member thanks .........</h4>";
	     // echo "<h4><a href=\"../main/set_account.php?menu=$type&account_no=$account_no>Click</a> Here to go ".$type."</h4>";
	header("Location: ../main/open_account.php?menu=$typeIn&customer_id=$customer_id&account_no=$account_no");
 }
?>
