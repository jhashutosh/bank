<?php
include "variable_array_config.php";
function deregisterSession(){
	session_start();
	session_cache_expire();
	session_destroy();
}
function registerSession(){
	session_start();
}
function makeSelectSubmit($element_array,$element,$default){

	echo "<SELECT name=\"".$element."\" id=\"select_id\"  onchange=\"onSubmits(this.form);\">";
	
	if(!empty($default)){
		echo "<option>".$default;
	}
	
	while(list($key,$val)=each($element_array)){
		if($val!=$default){
			echo "<option>".$val;
		}
	}
	echo "</select>";
}
//-------------------------------------------------------------------------
function isOverDueEmi($account_no){
$sql_statement="SELECT * FROM loan_cal_int WHERE account_no='$account_no' AND overdue_principal >'0';";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0) {
  return true;
  }
}

//-------------------------------------------------------------------------
function getInterestRate($ln_sl){
$sql_statement="SELECT int_due_rate,int_overdue_rate,period,repay_date FROM loan_ledger_hrd where loan_serial_no='$ln_sl'";
$result=dBConnect($sql_statement);
//echo $sql_statement;
if(pg_NumRows($result)>0){
   $period=pg_result($result,'period');
if(!empty($period)) $period="Period :".round($period)." months";
else $period="";
   $due_int=pg_result($result,'int_due_rate');
   $over_due_int=pg_result($result,'int_overdue_rate');
   $repay_date=pg_result($result,'repay_date');
   return "Due Interest Rate:   $due_int% And Over Due Interest Rate:   $over_due_int% And Repay_date : $repay_date  $period";
	   }

}

//===========================================================PAYROLL================================================
function makeselectemp($name,$js)
{$sql_statement="SELECT * from emp_master order by emp_id";
  //echo  $sql_statement;
 $result=dBConnect($sql_statement);
 echo "<select name=\"$name\"  $js>";
 echo"<option>select</option>"; 
 if(pg_NumRows($result)==0) {
 echo "<option>Null</option>";
}
else{ 

      for($j=1; $j<=pg_NumRows($result); $j++) {
      $row=pg_fetch_array($result,($j-1)); 
      echo "<option value=".$row['emp_id'].">".$row['emp_id']."</option>";
    }
}
echo "</select>";
}


function makeselectempname($name,$id,$desc)
{$sql_statement="SELECT * from emp_master order by $desc";
  //echo  $sql_statement;
 $result=dBConnect($sql_statement);
 echo "<select name=\"$name\">";
 echo"<option>select</option>"; 
 if(pg_NumRows($result)==0) {
 echo "<option>Null</option>";
}
else{ 

      for($j=1; $j<=pg_NumRows($result); $j++) {
      $row=pg_fetch_array($result,($j-1)); 
      echo "<option value=".$row[$id].">".$row[$desc]."</option>";
    }
}
echo "</select>";
}
//==============================================================================================

function crop_name_Selection($name){
//$sql_statement="SELECT crop_id from loan_policy WHERE loan_type='kcc'";
//$sql_statement="SELECT crop_id FROM loan_policy WHERE loan_type='kcc'";
$sql_statement="SELECT crop_id,crop_desc from crop_mas";
$result=dBConnect($sql_statement);
//echo $sql_statement;
if(pg_NumRows($result)>0)
{
echo "<SELECT name=\"".$name."\" id=\"".$name."\"  onchange=\"onSubmits(this.form);\">";
echo "<option>Select </option>";
for($i=0;$i<pg_NumRows($result);$i++)
{
	$row=pg_fetch_array($result,$i);
	echo "<option value=\"".$row['crop_id']."\">\"".$row['crop_desc']."\"</option>";
	 //echo "<option value=\"".$row['crop_id']."\">".getNameID('crop_id',$row['crop_id'],'crop_desc','crop_mas')."[".$row['fy']."]";
	//echo "<option value=\"".$row['crop_id']."\">".getcropname('crop_id',$row['crop_id']);
	}

 }
else
{
echo "<option>Null</option>";
}
echo "</select>";
}

//==========================================================================================

function makeselectgrant($name,$js)
{$grid="select grant_no from emp_adhoc_grant_mas";
$grres=dBConnect($grid);
 echo "<select name=\"$name\" $js>";
 echo"<option>select</option>"; 
 if(pg_NumRows($grres)==0) {
 echo "<option>Null</option>";
}
else{ 

     for($j=1; $j<=pg_NumRows($grres); $j++){
                   $rgr=pg_fetch_array($grres,($j-1));
                   echo "<option value=".$rgr['grant_no'].">".$rgr['grant_no']."</option>";
    }
}
echo "</select>";
}


function makeselectempgrant($name,$js)
{$grid="select emp_id,name from emp_master";
$grres=dBConnect($grid);
 echo "<select name=\"$name\" $js>";
 echo"<option>select</option>"; 
 if(pg_NumRows($grres)==0) {
 echo "<option>Null</option>";
}
else{ 

     for($j=1; $j<=pg_NumRows($grres); $j++){
                   $rgr=pg_fetch_array($grres,($j-1));
                   echo "<option value=".$rgr['emp_id'].">".$rgr['name']."</option>";
    }
}
echo "</select>";
}

function getWorkingDays($name,$mn){

$sql="select working_days from month_working_days where month=$mn";
$result=dBConnect($sql);
$row=pg_fetch_array($result);
echo"<input type='text' name='$name' id='$name' value='".$row['working_days']."' size='3' onfocus=\"work_days()\"onChange=\"work_days()\" onKeyup=\"work_days()\"  onKeyup=\"onSubmits(this.form);\" READONLY $HIGHLIGHT>";
//echo $row['working_days'];
}




//==========================================================================================
/*function makeSelectFromDBWithCode($id,$desc,$table,$name,$WHERE){
 if (empty($WHERE)){
 	$sql_statement="SELECT  $id,$desc from $table order by $id";
	}
 else{
	$sql_statement="SELECT  $id,$desc from $table $WHERE ORDER BY $id";
	}
 //echo $sql_statement;
 $result=dBConnect($sql_statement);
 echo "<select name=\"$name\" id=\"$name\">";
 if(pg_NumRows($result)==0) {
 echo "<option>Null</option>";
}
else{
      //
      for($j=1; $j<=pg_NumRows($result); $j++) {
      $row=pg_fetch_array($result,($j-1)); 
      echo "<option value=\"".$row[$id]."\">".ucwords($row[$desc])."[".$row[$id]."]</option>";
    }
}
echo "</select>";
}*/


function makeSelectFromDBWithCode($id,$desc,$table,$name,$WHERE){
 if (empty($WHERE)){
 	$sql_statement="SELECT  $id,$desc from $table order by $id";
	}
 else{
	$sql_statement="SELECT  $id,$desc from $table $WHERE ORDER BY $id";
	}
 //echo $sql_statement;
 $result=dBConnect($sql_statement);
 echo "<select name=\"$name\" id=\"$name\">";
 if(pg_NumRows($result)==0) {
 echo "<option>Null</option>";
}
else{
      //
	echo "<option value=\"\">Select</option>";
      for($j=1; $j<=pg_NumRows($result); $j++) {
      $row=pg_fetch_array($result,($j-1)); 
      echo "<option value=\"".$row[$id]."\">".ucwords($row[$desc])."[".$row[$id]."]</option>";
    }
}
echo "</select>";
}
function makeSelectFromDBWithCode1($id,$desc,$table,$name,$WHERE){
 if (empty($WHERE)){
 	$sql_statement="SELECT  $id,$desc from $table order by $id";
	}
 else{
	$sql_statement="SELECT  $id,$desc from $table $WHERE ORDER BY $id";
	}
 //echo $sql_statement;
 $result=dBConnect($sql_statement);
 echo "<select name=\"$name\" id=\"$name\">";
 if(pg_NumRows($result)==0) {
 echo "<option>Null</option>";
}
else{
      //
      for($j=1; $j<=pg_NumRows($result); $j++) {
      $row=pg_fetch_array($result,($j-1)); 
      echo "<option value=\"".$row[$id]."\">".ucwords($row[$desc])."[".$row[$id]."]</option>";
    }
}
echo "</select>";
}

//==========================================================================================
function makeSelectFromDBWithCodeCondition($id,$desc,$table,$name){
 $sql_statement="SELECT  $id,$desc FROM $table WHERE $id>=22401 and $id<=22901 order by $id";
// echo $sql_statement;
 $result=dBConnect($sql_statement);
 echo "<select name=\"$name\" id=\"$name\">";
 if(pg_NumRows($result)==0) {
 echo "<option>Null</option>";
}
else{
      //
      for($j=1; $j<=pg_NumRows($result); $j++) {
      $row=pg_fetch_array($result,($j-1)); 
      echo "<option value=\"".$row[$id]."\">".ucwords($row[$desc])."[".$row[$id]."]</option>";
    }
}
echo "</select>";
}
//======================================================================

function getGlCode4mbankAccount($account_no,$action_date){
if(empty($action_date))
{$action_date='CURRENT_DATE';}
else
{$action_date="'".$action_date."'";}
$sql_statement="SELECT gl_code from bank_bk_dtl where account_no='$account_no' AND op_date=(SELECT MAX(op_date) FROM bank_bk_dtl WHERE account_no='$account_no' AND op_date<=$action_date) AND status<>'cl'";

//$sql_statement="SELECT gl_mas_code from customer_account where account_no='$account_no' AND opening_date=(SELECT MAX(opening_date) FROM customer_account WHERE account_no='$account_no') AND status<>'cl'";
//echo "<h2>$sql_statement</h2>";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
  $gl_code=pg_result($result,'gl_code');
   }
else{
   //echo "Record Not Found!!!!!!!!!!!";  
}
  return $gl_code;
}







function makeSelectSubmit4mdb($id,$desc,$table,$name){
$sql_statement="SELECT  $id,$desc from $table order by $desc";
// echo $sql_statement;
 $result=dBConnect($sql_statement);
 echo "<select name=\"$name\" id=\"$name\"  onchange=\"onSubmits(this.form);\">";
 if(pg_NumRows($result)==0) {
 echo "<option>Null</option>";
}
else{
      echo "<option>Select</option>";
      for($j=1; $j<=pg_NumRows($result); $j++) {
      $row=pg_fetch_array($result,($j-1)); 
      echo "<option value=\"".$row[$id]."\">".ucwords($row[$desc])."</option>";
    }
}
echo "</select>";

}

function makeSelectSubmit4mdbbank($id,$desc,$table,$name){
$sql_statement="SELECT  $id,$desc from $table where b_type='ccb' and account_type='sb' order by $desc";
//echo $sql_statement;
 $result=dBConnect($sql_statement);
 echo "<select name=\"$name\" id=\"$name\"  onchange=\"onSubmits(this.form);\">";
 if(pg_NumRows($result)==0) {
 echo "<option>Null</option>";
}
else{
      echo "<option value=\"\">Select</option>";
      for($j=1; $j<=pg_NumRows($result); $j++) {
      $row=pg_fetch_array($result,($j-1)); 
      echo "<option value=\"".$row[$id]."\">".ucwords($row[$desc])."</option>";
    }
}
echo "</select>";

}


//--------------------------sujoy select cropname---------------------------------
function selectcropname($id){
$sql_statement="SELECT crop_desc FROM crop_mas WHERE crop_id=$id-1";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
   $name=pg_result($result,'crop_desc');
   }
else{
	$name=null;
}
return $name;

}
//----------------------------------loan_amount--------------------------------

function getLoanAmount($kcc_account_no){
$sql_statement="SELECT sum(loan_amount) as amount FROM loan_issue_dtl WHERE account_no='$kcc_account_no'";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
   $amount=pg_result($result,'amount');

   }
else{
	$amount=null;

}
return $amount;

}
//------------------------------------actiondate-----------------------------
function getActionDate($kcc_account_no){
$sql_statement="SELECT action_date FROM loan_issue_dtl WHERE account_no='$kcc_account_no' order by action_date";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
   $action_date=pg_result($result,'action_date');

   }
else{
	$action_date=null;

}
return $action_date;

}
//----------------repaymentamount--------------------------------
function getLoanRepaymentAmount($kcc_account_no){
$sql_statement="SELECT sum(r_total_amount) as return_amount FROM loan_return_dtl WHERE account_no='$kcc_account_no'";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
   $return_amount=pg_result($result,'return_amount');

   }
else{
	$return_amount=0;

}
return $return_amount;

}
//--------------------------------------------repaymentdate-------------------
function getRepaymentDate($kcc_account_no){
$sql_statement="SELECT action_date FROM loan_return_dtl WHERE account_no='$kcc_account_no' ORDER BY action_date desc";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
   $rep_date=pg_result($result,'action_date');

   }
else{
	$rep_date=null;

}
return $rep_date;

}

//===========================================================================================
function cropSelection($name){
//$sql_statement="SELECT crop_id from loan_policy WHERE loan_type='kcc'";
//$sql_statement="SELECT crop_id FROM loan_policy WHERE loan_type='kcc'";
//$stdate;
//$endate;
$fy=$_SESSION["fy"];
//getDetailFy($fy,$stdate,$endate);

$sql_statement="SELECT crop_id,fy from loan_policy WHERE loan_type='kcc' AND (fy='$fy')";
$result=dBConnect($sql_statement);
//echo $sql_statement;
if(pg_NumRows($result)>0)
{
echo "<SELECT name=\"".$name."\" id=\"".$name."\"  onchange=\"onSubmits(this.form);\">";
echo "<option>Select </option>";
for($i=0;$i<pg_NumRows($result);$i++)
{
	$row=pg_fetch_array($result,$i);
	 echo "<option value=\"".$row['crop_id']."\">".getName('crop_id',$row['crop_id'],'crop_desc','crop_mas')."[".$row['fy']."]";
	//echo "<option value=\"".$row['crop_id']."\">".getcropname('crop_id',$row['crop_id']);
	}

 }
else
{
echo "<option>Null</option>";
}
echo "</select>";
}


//================================
function getAddress($idAddress,$idValue,$feild,$table){
$sql_statement="SELECT $feild FROM $table WHERE $idAddress='$idValue'";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0) {
  $address=pg_result($result,0);
  //return ucwords($address);
return ucwords($address)."[".$idValue."]";
  }
}
function getFather($idFather,$idValue,$feild,$table){
$sql_statement="SELECT $feild FROM $table WHERE $idFather='$idValue'";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0) {
  $father=pg_result($result,0);
  //return ucwords($address);
return ucwords($father)."[".$idValue."]";
  }
}
//=======================

//==========================================================================================
function crop_insurance($loan_sl_no,$crop_id,$action_date,$amount){
$sql_statement="SELECT * FROM loan_policy WHERE crop_id='$crop_id' AND (start_date<= '$action_date' AND end_date>='$action_date')";
$result=dBConnect($sql_statement);
//echo $sql_statement;
if(pg_NumRows($result)>0){
	$insurance=pg_result($result,'crop_insurance');
	//$c_limit=pg_result($result,'credit_limit');
	//echo "insurace is :" .$insurance;
	}
//$percentage=(($insurance*100)/$c_limit);//percentage of crop Insurance
//echo "<h1>$amount";
//echo "<h1>$insurance</h1>";

$insurance=(($amount*$insurance)/100);
$insurance=round(sprintf("%-12.2f",$insurance));
return $insurance;
}
//==========================================================================================
function recoverDetails($ln_sl,&$p,&$d,&$o){
$sql_statement="SELECT SUM(CASE WHEN loan_serial_no='$ln_sl' THEN r_principal ELSE 0 END) as p,SUM(CASE WHEN loan_serial_no='$ln_sl' THEN  r_due_int  ELSE 0 END) as d,SUM(CASE WHEN loan_serial_no='$ln_sl' THEN r_overdue_int  ELSE 0 END) as o FROM loan_return_dtl";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
	$p=pg_result($result,'p');
	$d=pg_result($result,'d');
	$o=pg_result($result,'o');
	//
   }
   
}

//=========================================================================================
function recoverinstDetails($ln_sl,$action_date,&$odp,&$rdp,&$rdi,&$rodi,&$tamt,&$rp){
$sql_statement="select sum(r_overdue_principal) as odp, sum(r_due_principal) as rdp,sum(r_due_int) as rdi,sum(r_overdue_int) as rodi,sum(r_total_amount) as tamt,sum(r_principal) as rp from loan_return_dtl where loan_serial_no='$ln_sl' and action_date<='$action_date'";
    //echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
	$odp=pg_result($result,'odp');
	$rdp=pg_result($result,'rdp');
	$rdi=pg_result($result,'rdi');
	$rodi=pg_result($result,'rodi');
	$tamt=pg_result($result,'tamt');
	$rp=pg_result($result,'rp');

   }
   
}
//=========================================================================================
function checkKCCGl($account_no,$action_date,$gl_code_loan,$menu){
if($gl_code_loan=='d'||$gl_code_loan=='o'){
 return true;
}
else{
$o_gl_code=getGlCode4mCustomerAccount($account_no,$action_date);
//echo "<h1>$gl_code</h1>";
if($o_gl_code=='23104'){
return true;
}
else{
$gl_code=$o_gl_code+1;
$id=getCustomerId($account_no,$menu);
$sql_statement="INSERT INTO customer_account (customer_id,opening_date,account_no, account_type,operation_mode,gl_mas_code,operator_code,entry_time,status,account_flag)values('$id','$action_date','$account_no','$menu','$mode','$gl_code','sys',now(),'op','c')";
$sql_statement=$sql_statement."; UPDATE customer_account SET status='m',operator_code='sys' WHERE account_no='$account_no' AND gl_mas_code='$o_gl_code'";
$result=dBConnect($sql_statement);
//echo $sql_statement;
if(pg_affected_rows($result)<1){
	return false;
} else {
	        return true;
	}
    }
  }
}
//==========================================================================================
function SelectPledgeDocument($element_array,$name){
echo "<SELECT name=\"$name\" id=\"$name\"  onchange=\"checkSelect(this.value);\">";
echo "<option>Select</option>";
while(list($key,$val)=each($element_array)){

echo "<option value=\"$key\">$val</option>";
}
echo "</SELECT>";

}
//=========================================================================================
/*function ccb_deposits_current_balance($account_no,$action_date){
$gl_code=getGlCode4mCustomerAccount($account_no);
if(empty($action_date)){$action_date="current_date";}
else {$action_date="'".$action_date."'";}
//$sql_statement="SELECT (SUM(CASE WHEN dr_cr='Dr' AND account_no='$account_no' THEN amount ELSE 0 END) - SUM(CASE WHEN dr_cr='Cr' AND account_no='$account_no' THEN amount ELSE 0 END)) as  balance from gl_ledger_hrd glh,gl_ledger_dtl gld WHERE glh.tran_id=gld.tran_id AND action_date<=$action_date";
//echo $sql_statement;
$sql_statement="SELECT SUM(debit-credit) as balance FROM mas_gl_tran where account_no='$account_no' and action_date<=$action_date and gl_mas_code IN (SELECT gl_code FROM bank_bk_dtl where account_no='$account_no')";  
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
//echo "<h4>Not found!!!</h4>";
	return 0.0;
} else {
	        $balance=pg_result($result,'balance');
                $balance=(float)$balance;
		return $balance;
	      }
}
*/

function ccb_deposits_current_balance($account_no,$action_date){
$gl_code=getGlCode4mCustomerAccount($account_no,'');
if(empty($action_date)){$action_date="current_date";}
else {$action_date="'".$action_date."'";}
//$sql_statement="SELECT (SUM(CASE WHEN dr_cr='Dr' AND account_no='$account_no' THEN amount ELSE 0 END) - SUM(CASE WHEN dr_cr='Cr' AND account_no='$account_no' THEN amount ELSE 0 END)) as  balance from gl_ledger_hrd glh,gl_ledger_dtl gld WHERE glh.tran_id=gld.tran_id AND glh.action_date<=$action_date";
$sql_statement="SELECT SUM(debit-credit) as balance FROM mas_gl_tran where account_no='$account_no' and action_date<=$action_date and gl_mas_code IN (SELECT gl_code FROM bank_bk_dtl where account_no='$account_no')";  


//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
//echo "<h4>Not found!!!</h4>";
	return 0.0;
} else {
	        $balance=pg_result($result,'balance');
                $balance=(float)$balance;
		return $balance;
	      }
}
//=========================================================================================
function getSecurityInfo($land_id,&$area,&$val){
$sql_statement="SELECT * FROM land_info WHERE land_id='$land_id'";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0) {
   $area=pg_result($result,'land_area'); 
   $val=pg_result($result,'land_value');
 }
}
//-------------------------------------newchange-------------------------
function getValueInfo($land_id,&$karbanama){
$sql_statement="SELECT * FROM land_info WHERE land_id='$land_id'";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0) {
   //$area=pg_result($result,'land_area'); 
   $karbanama=pg_result($result,'karbanama_bond_value');
 }
}
//--------------------------------------------------------------------------------------
function nextValue($sequence_name){
	$sql_statement="SELECT nextval('$sequence_name')";
	//echo $sql_statement;
	$result=dBConnect($sql_statement);
	if(pg_NumRows($result)==0) {
		echo "<strong>System Error!!!</strong>";
	} else {
		for ($i=0; $i<pg_NumRows($result);$i++) {
			$row=pg_fetch_array($result,$i);
			return $row[0];
		}
	}
}
//===================================KCC CREDIT LIMIT=========================================
function getCreditLimit($land_id,$crop_id){
$MAX_KCC_LOAN=200000;//HERE DECLARE THE MAXIMUM KCC LOAN AMOUNT  
//echo "$VILL_DEFAULT";
$fy=$_SESSION["fy"];
for ($i=0;$i<count($land_id);$i++){
	$sql_statement="SELECT  * FROM land_info WHERE land_id='$land_id[$i]'";
	//echo $sql_statement;
	$result=dBConnect($sql_statement);
	$t_land+=pg_result($result,'land_area');
	}
//$sql_statement="SELECT * FROM loan_policy WHERE crop_id='$crop_id'";
$sql_statement="SELECT * FROM loan_policy WHERE crop_id='$crop_id' AND fy='$fy'";
//echo $sql_statement;
$result=dBConnect($sql_statement);
$credit_limit=pg_result($result,'credit_limit')	;
//$min_land=pg_result($result,'min_land_area');
$min_land=1;
$insurance=pg_result($result,'crop_insurance');
$t_credit_limit=($t_land*$credit_limit)/$min_land;
$t_credit_limit+=($insurance*$t_credit_limit/100);//FOR CROP INSURANCE
if ($t_credit_limit>$MAX_KCC_LOAN){
	$t_credit_limit=$MAX_KCC_LOAN;
	}

return (int)$t_credit_limit;
}
//=============================================================================================
function getKarbanamaValue($loan_sl_no,$account_no){
$sql_statement="SELECT SUM(security_value) as kar_val FROM loan_security WHERE loan_serial_no= '$loan_sl_no' AND account_no='$account_no'";
//$sql_statement="select karbanama_bond_value from land_info";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
return pg_result($result,'kar_val');
 }

}
//---------------------------new change--------------------------------------
function getKarbanamabondValue($loan_sl_no){
//$sql_statement="SELECT SUM(security_value) as kar_val FROM loan_security WHERE loan_serial_no= '$loan_sl_no' AND account_no='$account_no'";
$sql_statement="select sum(karbanama_bond_value) as kar_val from loan_security where loan_serial_no='$loan_sl_no'";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
return pg_result($result,'kar_val');
 }

}
//------------------------------------------getsharevalue--------------------------
function getTotalShareValue($customer_id){
$sql_statement="SELECT sum(value_of_share) as share_value FROM share_details WHERE customer_id='$customer_id'";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
return pg_result($result,'share_value');
 }

}
//=============================================================================================
function getKccDueDate($fy,$crop_id){
$sql_statement="SELECT due_date FROM loan_policy WHERE loan_type='kcc' AND fy='$fy' AND crop_id='$crop_id'";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
return pg_result($result,'due_date');
 }

}
//---------------------------------------------------------------------------------------
function getName($idName,$idValue,$feild,$table){
$sql_statement="SELECT $feild FROM $table WHERE $idName='$idValue'";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0) {
  $name=pg_result($result,0);
  //return ucwords($name);
return ucwords($name)."[".$idValue."]";
  }
}
//--------------------------------------change--------------------------------------
function getcropname($idName,$idValue)
{
$sql_statement="SELECT crop_name FROM loan_policy WHERE loan_type='kcc' and $idName='$idValue'";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0) {
  $name=pg_result($result,0);
  //return ucwords($name);
return $name;
  }
}
//------------------------------------sujoy cropname-----------------------
function cropname($crop_id)
{
$sql_statement="SELECT * FROM loan_policy WHERE crop_id='$crop_id'";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0) {
  $name=pg_result($result,'crop_name');
  }
return $name;
}
//---------------------------------------------new---------------------------
function gcropname($idValue)
{
$sql_statement="SELECT crop_name FROM loan_policy WHERE loan_type='kcc' and crop_id=$idValue";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0) {
  $name=pg_result($result,0);
  //return ucwords($name);
return $name;
  }
}
//===========================================================================================
function isOverDue($account_no){
$sql_statement="SELECT * FROM loan_cal_int WHERE account_no='$account_no' AND status='o'";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0) {
  return true;
  }
}
//===========================================================================================
function getId($type)
{
//echo "type is $type";
if($type=='sb'){$code='SB-'; $id='sb_id';}
if($type=='fd'){$code='FD-'; $id='fd_id';}

if($type=='ri'){$code='RI-'; $id='ri_id';}

if($type=='rd'){$code='RD-'; $id='rd_id';}
if($type=='mis'){$code='MIS-'; $id='mis_id';}
if($type=='m'){$code='M-'; $id='m_id';}
if($type=='ks'){$code='KS-';$id='ks_id';}
if($type=='st'){$code='ST-';$id='st_id';}
if($type=='ln'){$code='L-';$id='land_id';}
if($type=='pl'){$code='PL-';$id='pl_id';}
if($type=='kcc'){$code='KCC-';$id='kcc_id';}
if($type=='shg'){$code='SG-';$id='s_id';}
if($type=='sgl'){$code='SGL-';$id='sgl_id';}
if($type=='jgl'){$code='JGL-';$id='jlgl_id';}
if($type=='ls'){$code='LS-';$id='lease_id';}

$id=$code.nextValue($id);

return $id;
}
//============================================================================================
function getAcer($satak){
$satak=explode(".",$satak);
$l=COUNT($satak);
if($l>1){$after_point=$satak[1];}
$satak=$satak[0];
$acer=$satak/100;
settype($acer,"int");
$satak=$satak%100;
if($acer>0){
	if($satak>0){
		if($l>1){
 			$acer=$acer." acer & ".$satak.".$after_point satak" ;
			}
		else{
			$acer=$acer." acer & ".$satak." satak" ;
			}
	}
	else{
		if($l>1){
			$acer=$acer." acer "."& 0.".$after_point." satak";
			}
		else{
			$acer=$acer." acer";
		   	}
	}
}
else{
	if($l>1){
  		$acer=$satak.".$after_point satak" ;
	}
	else{
	$acer=$satak." satak";	
	}
}
return $acer;
}
//--------------------------------------------------------------------------------------------
function getCustomerIdFromGroupId($id){
$sql_statement="SELECT customer_id from shg_info where shg_no='$id' ";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "sorry";
}
else{
   $g_id=pg_result($result,'customer_id');
 }
return $g_id;
}
//-----------------------------------------------------------------------------------------
function getSHGInfo($id,&$no_of_member,&$leader,&$group_id,&$gp_type){
$sql_statement="SELECT * from shg_info where customer_id='$id'";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0) {
   $group_id=pg_result($result,'shg_no');
   $gp_type=pg_result($result,'gp_type');
   $no_of_member=pg_result($result,'no_of_member');
   $leader=ucwords(pg_result($result,'leader_name'))."(L)/".ucwords(pg_result($result,'sub_leader_name'))."(S)";
 }
return;
}
//-------------------------------------------------------------------------------------------//
function getMemberId($id){
$sql_statement="SELECT membership_no from membership_info where customer_id='$id' And closing_date IS NULL";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0) {
return pg_result($result,'membership_no');
 }

}
//--------------------------------------------------------------------------------------------//
function getCustomerId($id,$menu){
  $id=strtoupper($id);
  $sql_statement="SELECT customer_id from customer_account where account_no='$id' AND account_type='$menu'";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
$c_id=null;
}
else{
   $c_id=pg_result($result,'customer_id');
 }
return $c_id;
}
//----------------------------sujoy-------------------------------------
function getCustomerName($customer_id)
{
$sql_statement="SELECT name1 FROM customer_master WHERE customer_id='$customer_id'";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
$c_id=null;
}
else{
   $c_id=pg_result($result,'name1');
 }














return $c_id;

}
//--------------------------getcustomerid from kccid--------------------------------
function getCustomerNameFromKCCAccount($kcc_account_no)
{
$sql_statement="SELECT customer_id FROM loan_ledger_hrd WHERE account_no='$kcc_account_no'";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
$c_id=null;

}else
{
 $c_id=pg_result($result,'customer_id');


}
return $c_id;
}
//-------------------------------------------------------------------------------------------//
function getCustomerIdFromMember($id){
$sql_statement="SELECT customer_id FROM membership_info WHERE membership_no='$id'";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
$c_id=null;
}
else{
   $c_id=pg_result($result,'customer_id');
 }
return $c_id;
}
//----------------------------------------------------------------------------------
function getReportingBoss(){
 global $HOST,$DATABASE,$DATESTYLE;
 $sql_statement="SELECT id,name from staff";
 $result=dBConnect($sql_statement);
 echo "<select name=\"boss\">";
 if(pg_NumRows($result)==0) {
 echo "<option>Null</option>";
}
else{
      for($j=1; $j<=pg_NumRows($result); $j++) {
      $row=pg_fetch_array($result,($j-1)); 
      echo "<option value=\"".$row['id']."\">".$row['name']."</option>";
    }
}
echo "</select>";
}
//-----------------------------------------------------------------------------------
function makeSelectFromDB($table,$feild,$name){
  $sql_statement="SELECT $feild from $table ORDER BY $feild DESC";
  //echo  $sql_statement;
 $result=dBConnect($sql_statement);
 echo "<select name=\"$name\">"; 
 if(pg_NumRows($result)==0) {
 echo "<option>Null</option>";
}
else{ 
      if($table=='staff')
	{
	echo "<option>all</option>";
	}
      for($j=1; $j<=pg_NumRows($result); $j++) {
      $row=pg_fetch_array($result,($j-1)); 
      echo "<option>".$row[$feild]."</option>";
    }
}
echo "</select>";
}
//----------------------------------------------------------------------------------------------
function existStaffId($id){
 $sql_statement="SELECT * from staff where id='$id'";
 //echo $sql_statement;
 $result=dBConnect($sql_statement);
 if(pg_NumRows($result)<1)
  {
   echo "<font color=Red><b>****This Id Not Exist in our Database choose another one!!!!</b></font>";
   $id=null;
  }
 else{
 $id=$id;
 }
 return $id;

}
//============================================================================================
function isStaff($customer_id){
 $sql_statement="SELECT * from customer_master where customer_id='$customer_id' AND type_of_customer='st'";
 //echo $sql_statement;
 $result=dBConnect($sql_statement);
 if(pg_NumRows($result)>0){
    return true;
  } else{
    return false;
   }
}

//-----------------------------------------------------------------------------------
function checkStaffId($id){
 $sql_statement="SELECT * from staff where id='$id'";
 //echo $sql_statement;
 $result=dBConnect($sql_statement);
 if(pg_NumRows($result)>0)
  {
   echo "<font color=Red><b>****Id Already Exist choose another one!!!!</b></font>";
   $id=null;
  }
 else{
 $id=$id;
 }
 return $id;

}
//--------------------------------------------------------------------------------------------
function getPrintTime()
{
	$sql_statement="SELECT substr(CAST(now() AS VARCHAR),12,8) as time";
 	$result=dBConnect($sql_statement);
 	if(pg_NumRows($result)>0)
	{
 		$id=pg_result($result,'time');
 	}
 	return $id;
}
//============================================================================================
function getLoanInt($type,$action_date,&$due,&$over,$crop_id){
if(empty($crop_id)){$CONDITION=" ";}
else{$CONDITION=" AND crop_id='$crop_id'";}
$sql_statement="SELECT * FROM loan_policy WHERE start_date=(SELECT MAX(start_date) FROM loan_policy WHERE loan_type='$type' AND start_date<='$action_date'".$CONDITION. ")AND loan_type='$type'".$CONDITION;
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
  $over=pg_result($result,'int_overdue_rate');
  $due=pg_result($result,'int_due_rate');
 
	}

}
//getLoanInt('pl','1/5/2009',&$due,&$over);
//-------------------------------------------------------------------------------
function getSHGMember($c_id){
 $sql_statement="SELECT no_of_member from shg_info where customer_id='$c_id'";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "sorry";
}
else{
   $no_of_member=pg_result($result,'no_of_member');
 }
return $no_of_member;
}
//-------------------------------------------------------------------------------------------
function checkLoanAccount($account_no){
$sql_statement="SELECT * from shg_info where customer_id='$c_id'";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "sorry";
}
else{
   $no_of_member=pg_result($result,'no_of_member');
 }
return $no_of_member;
}
//--------------------------------------------------------------------------------------------

//---------------------------------------------------------------------------------------------
function glBalance($gl_code,$year_month,$dr_cr){
$WHERE_CONDITIONS="WHERE year_month='$year_month' AND ( ";
$arr=explode(",",$gl_code);
$n=count($arr);
for($i=0; $i<($n-1);$i++){
if($arr[$i]=='14101'||$arr[$i]=='14102'||$arr[$i]=='14103'||$arr[$i]=='14104'||$arr[$i]=='14104'||$arr[$i]=='14301'||$arr[$i]=='14302'||$arr[$i]=='14303'||$arr[$i]=='14304'||$arr[$i]=='14305'){
$sql_statement="SELECT getGLBalance('$arr[$i]','$year_month') as balance";
//echo "<h1>hi"; 
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
	//echo "<h4>Not found!!!</h4>";
	return 0;
	} 
else {
	$balance+=pg_result($result,'balance');
        $balance=(float)$balance;
	//$flag=true;
     }
}
else{
		$WHERE_CONDITIONS="$WHERE_CONDITIONS gl_code='$arr[$i]' OR";
	    }
	}
if($arr[$i]=='14101'||$arr[$i]=='14102'||$arr[$i]=='14103'||$arr[$i]=='14104'||$arr[$i]=='14104'||$arr[$i]=='14301'||$arr[$i]=='14302'||$arr[$i]=='14303'||$arr[$i]=='14304'||$arr[$i]=='14305'){
$sql_statement="SELECT getGLBalance('$arr[$i]','$year_month') as balance";
//echo $sql_statement
}
else{
$WHERE_CONDITIONS="$WHERE_CONDITIONS gl_code='$arr[$i]')";
if($dr_cr=='Dr'){
	$sql_statement="SELECT (SUM(CASE WHEN trim(dr_cr)='Dr' THEN amount ELSE 0 END)-SUM(CASE WHEN trim(dr_cr)='Cr' THEN amount ELSE 0 END)) AS balance FROM gl_current_balance $WHERE_CONDITIONS";


	}
else{
	$sql_statement="SELECT (SUM(CASE WHEN trim(dr_cr)='Cr' THEN amount ELSE 0 END)-SUM(CASE WHEN trim(dr_cr)='Dr' THEN amount ELSE 0 END)) AS balance FROM gl_current_balance $WHERE_CONDITIONS";
  }
}
//echo $sql_statement;	
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
	//echo "<h4>Not found!!!</h4>";
	return 0;
	} 
else {
	$balance+=pg_result($result,'balance');
        $balance=(float)$balance;
	
	      }

return $balance;
}
//=============================================================================================
function glBalanceFromDetails($tdate,$code,$d_c){

	if($d_c=='Cr'){
		$sql_statement="SELECT (SUM(CASE WHEN trim(dr_cr)='Cr' AND action_date< $tdate THEN amount ELSE 0 END) - SUM(CASE WHEN trim(dr_cr)='Dr' AND action_date< $tdate THEN amount ELSE 0 END)) as balance from gl_ledger_dtl d,gl_ledger_hrd h WHERE h.tran_id=d.tran_id AND gl_mas_code='$code'";
}	else{
		$sql_statement="SELECT (SUM(CASE WHEN trim(dr_cr)='Dr' AND action_date< $tdate THEN amount ELSE 0 END) - SUM(CASE WHEN trim(dr_cr)='Cr' AND action_date< $tdate THEN amount ELSE 0 END)) as balance from gl_ledger_dtl d,gl_ledger_hrd h WHERE h.tran_id=d.tran_id AND gl_mas_code='$code'";
} 
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
	return 0;
} else {
	$balance=pg_result($result,'balance');
        $balance=(float)$balance;
	return $balance;
	}

}

//=============================================================================================
function getTransactionHistory($gl_code,$tdate,&$val_d,&$val_w,&$no){
$WHERE_CONDITIONS="(";
$arr=explode(",",$gl_code);
$n=count($arr);
for($i=0; $i<($n-1);$i++){
	$WHERE_CONDITIONS="$WHERE_CONDITIONS gl_mas_code='$arr[$i]' OR";
	}	
$WHERE_CONDITIONS="$WHERE_CONDITIONS gl_mas_code='$arr[$i]')";
$sql_statement="SELECT SUM(CASE WHEN trim(dr_cr)='Cr' THEN amount ELSE 0 END) as deposits,SUM(CASE WHEN trim(dr_cr)='Dr' THEN amount ELSE 0 END) as withdrawal,COUNT(*) as No FROM gl_ledger_dtl gld,gl_ledger_hrd glh WHERE gld.tran_id=glh.tran_id AND $WHERE_CONDITIONS AND action_date>='$tdate' and action_date<(date('$tdate')+INTERVAL '1 months')";
//echo $sql_statement;	
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
	//echo "<h4>Not found!!!</h4>";
	$val_d=0;
	$val_w=0;
	$no=0;
	} else {
	        $val_d=(float)pg_result($result,'deposits');
                $val_w=(float)pg_result($result,'withdrawal');
		$no=(float)pg_result($result,'No');
		
		return $balance;
	      }

}
//===========================================================================================
function getAccountInfo($tdate,$gl_code){
$WHERE_CONDITIONS="(";
$arr=explode(",",$gl_code);
$n=count($arr);
for($i=0; $i<($n-1);$i++){
	$WHERE_CONDITIONS="$WHERE_CONDITIONS gl_mas_code='$arr[$i]' OR";
	}	
$WHERE_CONDITIONS="$WHERE_CONDITIONS gl_mas_code='$arr[$i]')";
$sql_statement="SELECT COUNT(*) as No FROM customer_account WHERE opening_date<$tdate AND status='op' AND $WHERE_CONDITIONS";
//echo $sql_statement;	
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
return 0;
}else{
return pg_result($result,'No');
  }
}
//=============================================================================================
function getOpenAccountInfo($st_dt,$end_dt,$gl_code){
$WHERE_CONDITIONS="(";
$arr=explode(",",$gl_code);
$n=count($arr);
for($i=0; $i<($n-1);$i++){
	$WHERE_CONDITIONS="$WHERE_CONDITIONS gl_mas_code='$arr[$i]' OR";
	}	
$WHERE_CONDITIONS="$WHERE_CONDITIONS gl_mas_code='$arr[$i]')";
$sql_statement="SELECT COUNT(*) as No FROM customer_account WHERE status='op' AND opening_date>=$st_dt AND opening_date>=$st_dt AND $WHERE_CONDITIONS";
//echo $sql_statement;	
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
return 0;
}else{
return pg_result($result,'No');
  }

}
//============================================================================================
function getInfoSHG($action_date,&$no_g,&$no_m){
//$sql_statement="SELECT COUNT(*) as no_g,SUM(no_of_member) as no_m FROM shg_info WHERE status='op' AND opening_date<$action_date";
$sql_statement="SELECT COUNT(*) as no_g,SUM(no_of_member) as no_m FROM shg_info WHERE opening_date<$action_date AND (closing_date IS NULL OR closing_date>$action_date) ";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0){
return 0;
}else{
$no_g=pg_result($result,'no_g');
$no_m=pg_result($result,'no_m');
  }
}
//=============================================================================================
function getOpenInfoSHG($st_dt,$end_dt){
$sql_statement="SELECT COUNT(*) as no_g FROM shg_info WHERE status='op' AND opening_date BETWEEN $st_dt AND $end_dt";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0){
return 0;
}else{
  return pg_result($result,'no_g');
  }
}
//============================================================================================
function getSHGType($end_dt,$type){
$sql_statement="SELECT COUNT(*) as no_g FROM shg_info WHERE status='op' AND opening_date< $end_dt AND shg_type='$type'";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0){
return 0;
}else{
  return pg_result($result,'no_g');
  }
}
//============================================================================================
function getSHGDetailInfo($action_date,$WHERE_CONDITION){
$sql_statement="SELECT COUNT(*) as no FROM customer_master WHERE $WHERE_CONDITION AND type_of_customer IN (SELECT shg_no FROM shg_info WHERE opening_date<$action_date)";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0){
return 0;
}else{
  return pg_result($result,'no');
  }

}
//---------------------------------------------------------------------------------------------
function getNextVal($id){
 $sql_statement="SELECT nextval('$id') as id";
 $result=dBConnect($sql_statement);
 if(pg_NumRows($result)!=0) {
 $id=pg_result($result,'id');
 }
 return $id;
}
//---------------------------------------------------------------------------------------------LINUX============
/*function dBConnect($sql_statement){
	global $HOST,$DATABASE,$DATESTYLE,$PORT,$USER,$PASSWORD;
	$conString="host=$HOST port=$PORT dbname=$DATABASE user=$USER password=$PASSWORD";
	//echo $conString;
	$db=pg_Connect("host=".$HOST." dbname=".$DATABASE);
	//$db=pg_connect($conString) or die("Connection Error");
	$result=pg_Exec($db,$DATESTYLE);
	$result=pg_Exec($db,$sql_statement);
	//echo $sql_statement;
	return $result;

}*/


//====================WINDOWS

function dBConnect($sql_statement){
	global $HOST,$DATABASE,$DATESTYLE,$PORT,$USER,$PASSWORD;
	$conString="host=$HOST port=$PORT dbname=$DATABASE user=$USER password=$PASSWORD";
	//echo $conString;
	//$db=pg_Connect("host=".$HOST." dbname=".$DATABASE);
	$db=pg_connect($conString) or die("Connection Error");
	$result=pg_Exec($db,$DATESTYLE);
	$result=pg_Exec($db,$sql_statement);
	//echo $sql_statement;
	return $result;

}


function getLoanBalance($loan_sl_no){
$sql_statement="SELECT SUM(loan_amount-r_principal)as loan_balance FROM loan_statement where loan_serial_no='$loan_sl_no'";
//echo "<h2> $sql_statement</h2>";

$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$loan_bal=pg_result($result,'loan_balance');
}
else{$loan_bal=0;}
return $loan_bal;
}
//--------------------------------------------------------------------------------------------

function getGlCode4Deposit($customer_id,$status){
// echo "status is $status";
 $sql_statement="SELECT type_of_customer FROM customer_master where customer_id='$customer_id'";
//echo $sql_statement;
 $result=dBConnect($sql_statement);
 if(pg_NumRows($result)>0){
 $type=pg_result($result,'type_of_customer');
echo $type;
 switch(trim($status)){
 case 'sb':
	  switch($type){
 		case "so":
 		case "jn":
		case 'jl':
			$code='14201';
			break;
 		case "or":
			$code=searchMember($customer_id);
     			if(empty($code)){
			$code='14301';//non-member
			}
			else{
			$code='14101';//member
			}
     		break;
 		case "gp":
    			$code='14201';//SHG
    		break;
 		case "nr":
    			$code='14401';//NREGS
    		break;
   		}

 break;

case 'sd':
	  switch($type){
 		case "so":
 		case "jn":
 		case "or":
			$code=searchMember($customer_id);
     			if(empty($code)){
			$code='18915';//non-member
			}
			else{
			$code='18914';//member

			}

     		
    		break;
 		case "nr":
    			$code=findGlCode('Sundy deposit(nrgs)');
    		break;
   		}
 break;



 case 'fd':
	
	switch($type){
 		case "so":
 		case "jn":
 		case "or":
			$code=searchMember($customer_id);
     			if(empty($code)){
			$code='14303';//non-member
			}
			else{
			$code='14103';//member
			}
     		break;
 		case "gp":
    			$code='14203';//SHG
    		break;
 		case "nr":
    			$code=findGlCode('fixed deposit(nrgs)');
    		break;
   		}
break;         
case 'ri':
	switch($type){
 		case "so":
 		case "jn":
 		case "or":
			$code=searchMember($customer_id);
     			if(empty($code)){
			$code='14304';//non-member
			}
			else{
			$code='14104';//member
			}
     		break;
 		case "gp":
    			$code='14204';//SHG
    		break;
 		case "nr":
    			$code=findGlCode('reinvestment term deposit(nrgs)');
    		break;
   		}
 
break;
case 'rd':
	switch($type){
 		case "so":
 		case "jn":
 		case "or":
			$code=searchMember($customer_id);
     			if(empty($code)){
			$code='14302';//non-member
			}
			else{
			$code='14102';//member
			}
     		break;
 		case "gp":
    			$code='14202';//SHG
    		break;
 		case "nr":
    			$code=findGlCode('recurring deposit(nrgs)');
    		break;
   		}
break;
//sas
 case 'pfsb':
	  switch($type){
 		case "so":
 		case "jn":
 		case "or":
			$code=searchMember($customer_id);
     			if(empty($code)){
			$code='12216';//non-member
			}
			else{
			$code='12216';//member
			}
     		break;
 	



   		}
 break;



 case 'hsb':
	  switch($type){
 		case "so":
 		case "jn":
 		case "nr":
			$code=searchMember($customer_id);
     			if(empty($code)){
			$code='14305';//non-member
			}
			else{
			$code='14105';//member
			}
     		break;
 	



   		}
 break;








//sas
case 'mis':
	switch($type){
 		case "so":
 		case "jn":
 		case "or":
			$code=searchMember($customer_id);
     			if(empty($code)){
			$code='14306';//non-member
			}
			else{
			$code='14106';//member
			}
     		break;
 		case "gp":

    			$code='14206';//SHG
    		break;
 		case "nr":
    			$code=findGlCode(' mis deposit(nregs)');
    		break;
   		}
 
break; 

	}						
 }
else{
   echo "System error";
}
return $code;
}
function getGlCode4Deposit($customer_id,$status){
 //echo "status is $status";
 $sql_statement="SELECT type_of_customer FROM customer_master where customer_id='$customer_id'";
 //echo $sql_statement;
 $result=dBConnect($sql_statement);
 if(pg_NumRows($result)>0){
 $type=pg_result($result,'type_of_customer');
 switch(trim($status)){
 case 'sb':
	  switch($type){
 		case "so":
 		case "jn":
 		case "or":
			$code=searchMember($customer_id);
     			if(empty($code)){
			$code='14301';//non-member
			}
			else{
			$code='14101';//member
			}
     		break;
 		case "gp":
    			$code='14201';//SHG
    		break;
    		case "jl":
    			$code='14501';//JLG
    		break;
 		case "nr":
    			$code=findGlCode('savings deposit(nregs)');
    		break;
   		}
 break;
 case 'fd':
	
	switch($type){
 		case "so":
 		case "jn":
 		case "or":
			$code=searchMember($customer_id);
     			if(empty($code)){
			$code='14303';//non-member
			}
			else{
			$code='14103';//member
			}
     		break;
 		case "gp":
    			$code='14203';//SHG
    		break;
    		case "jl":
    			$code='14503';//SHG
    		break;
 		case "nr":
    			$code=findGlCode('fixed deposit(nrgs)');
    		break;
   		}
break;         
case 'ri':
	switch($type){
 		case "so":
 		case "jn":
 		case "or":
			$code=searchMember($customer_id);
     			if(empty($code)){
			$code='14304';//non-member
			}
			else{
			$code='14104';//member
			}
     		break;
 		case "gp":
    			$code='14204';//SHG
    		break;
    		case "jl":
    			$code='14504';//JLG
    		break;
 		case "nr":
    			$code=findGlCode('reinvestment term deposit(nrgs)');
    		break;
   		}
 
break;
case 'rd':
	switch($type){
 		case "so":
 		case "jn":
 		case "or":
			$code=searchMember($customer_id);
     			if(empty($code)){
			$code='14302';//non-member
			}
			else{
			$code='14102';//member
			}
     		break;
 		case "gp":
    			$code='14202';//SHG
    		break;
    		case "jl":
    			$code='14502';//JLG
    		break;
 		case "nr":
    			$code=findGlCode('recurring deposit(nrgs)');
    		break;
   		}
break;
case 'mis':
	switch($type){
 		case "so":
 		case "jn":
 		case "or":
			$code=searchMember($customer_id);
     			if(empty($code)){
			$code='14306';//non-member
			}
			else{
			$code='14106';//member
			}
     		break;
 		case "gp":
    			$code='14206';//SHG
    		break;
 		case "nr":
    			$code=findGlCode(' mis deposit(nrgs)');
    		break;
   		}
 
break; 

	}						
 }
else{
   echo "System error";
}
return $code;
}
//-------------------------------------------------------------------------------------------------
function searchMember($customer_id){
 $sql_statement="SELECT * FROM membership_info where customer_id='$customer_id'";
 $result=dBConnect($sql_statement);
 if(pg_NumRows($result)>0){
 $code="ok";
 }
 else{
 	$code=null;
     }
return $code;
}
//--------------------------------------------------------------------------------------------
function findGlCode($desc){
$sql_statement="select gl_mas_code from gl_master where gl_mas_desc like '%$desc'";
//echo "$sql_statement";
$result=dBConnect($sql_statement);
 if(pg_NumRows($result)>0){
  $gl_code=pg_result($result,'gl_mas_code');
  //echo $gl_code;
 }
else{
   echo "Record Not Found!!!!!!!!!!!";  
}
  return $gl_code;
}
//==========================================================================================


function findGlDesc($code){
$sql_statement="select gl_mas_desc from gl_master where gl_mas_code='$code'";
//echo "$sql_statement";
$result=dBConnect($sql_statement);
 if(pg_NumRows($result)>0){
  $gl_desc=pg_result($result,'gl_mas_desc');
   return $gl_desc;
  }
 
}
//-------------------------------------------------------------------------------------------
function getFy($action_date){
registerSession();
$fy1=$_SESSION['fy'];
if(empty($action_date)){ $action_date=date('d.m.Y');}
$sql_statement="SELECT * FROM fy_list where fy='$fy1' AND ended IS NULL AND '$action_date' BETWEEN  start_dt AND close_dt";
//$sql_statement="SELECT * FROM fy_list where fy='$fy1' AND ended IS NULL AND start_dt<='$action_date' AND close_dt>='$action_date'";
$result=dBConnect($sql_statement);
 if(pg_NumRows($result)>0){
 return $fy1;
 }
 }
//---------------------------------------------------------------------------------------------
function getGlCode4mCustomerAccount($account_no,$action_date){
if(empty($action_date))
{$action_date='CURRENT_DATE';}
else
{$action_date="'".$action_date."'";}
$sql_statement="SELECT gl_mas_code from customer_account where account_no='$account_no' AND opening_date=(SELECT MAX(opening_date) FROM customer_account WHERE account_no='$account_no' AND opening_date<=$action_date) AND status<>'cl'";
//echo "<h2>$sql_statement</h2>";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
  $gl_code=pg_result($result,'gl_mas_code');
   }
else{
   //echo "Record Not Found!!!!!!!!!!!";  
}
  return $gl_code;
}
//--------------------------------------------------------------------------------------------
function checkloanEl($group_no,&$loan_el_date){
	$sql_statement="SELECT loan_el_date,loan_el_date-current_date as status from customer_shg where shg_no='$group_no'";
	//echo $sql_statement; 
	$result=dBConnect($sql_statement);
        if(pg_NumRows($result)==0){echo "<h1><b><center>SHG No. is Wrong!!!! please check the shg No. and try again<br></h1>";}
	else{
	$loan_el_date=pg_result($result,'loan_el_date');
	$status=pg_result($result,'status');
	//echo "i'm : $status";
	if($status<=0){return true;}
	else{return false;}
       }
}
//--------------------------------------------------------------------------------------------
function loan_total_balance($group_no){
       	$sql_statement="SELECT account_no FROM shg_account WHERE (account_type='sgl') AND shg_no='$group_no' ";
	//echo $sql_statement;
	$result=dBConnect($sql_statement);
	if(pg_NumRows($result)==0) {
		//echo "<h4>Not found!!!</h4>";
		return 0.0;
	} 
	else{
      	for($j=0; $j<pg_NumRows($result); $j++){
      	$row=pg_fetch_array($result,$j); 
	$amount+=total_loan_current_balance($row['account_no'],'');;
       		}
	}
  
 return $amount;
}
//---------------------------------------------------------------------------------------------
function deposit_total_balance($c_id){
        //$c_id=getCustomerIdFromGroupId($account_no);
	// Customization required for WHERE CLAUSE
	$sql_statement="SELECT account_no FROM customer_account WHERE (account_type='sb' OR account_type='fd' OR account_type='ri' OR account_type='rd' OR account_type='mi') AND customer_id='$c_id'";
	//echo $sql_statement;
	$result=dBConnect($sql_statement);
	if(pg_NumRows($result)==0) {
		//echo "<h4>Not found!!!</h4>";
		return 0.0;
	} 
	else{
      	for($j=0; $j<pg_NumRows($result); $j++){
      	$row=pg_fetch_array($result,$j); 
	$amount+=sb_current_balance($row["account_no"]);
       		}
	}
  
 return $amount;
}
//---------------------------------------------------------------------------------------------
/*function loan_current_balance($account_no,$sl_no,$action_date){
	// Customization required for WHERE CLAUSE
	 $sql_statement="SELECT b_principal as balance FROM loan_statement WHERE loan_serial_no='$sl_no' and account_no='$account_no' AND action_date<=";
         if(empty($action_date)){$sql_statement=$sql_statement."current_date ";}
	 else{$sql_statement=$sql_statement."'$action_date' ";}
	$sql_statement=$sql_statement."ORDER BY entry_time DESC LIMIT 1";
	//echo $sql_statement;
	$result=dBConnect($sql_statement);
	if(pg_NumRows($result)==0) {
		//echo "<h4>Not found!!!</h4>";
		return 0;
	} else {
		        $balance=pg_result($result,'balance');
                        $balance=(float)$balance;
			return $balance;
		
	      }
}*/
function loan_current_balance($account_no,$sl_no,$action_date){
	// Customization required for WHERE CLAUSE
	 $sql_statement="SELECT SUM(loan_amount-r_principal) as balance FROM loan_statement WHERE loan_serial_no='$sl_no' and account_no='$account_no' AND action_date<=";
         if(empty($action_date)){$sql_statement=$sql_statement."current_date ";}
	 else{$sql_statement=$sql_statement."'$action_date' ";}
	//$sql_statement=$sql_statement."ORDER BY entry_time DESC LIMIT 1";
	//echo $sql_statement;
	$result=dBConnect($sql_statement);
	if(pg_NumRows($result)==0) {
		//echo "<h4>Not found!!!</h4>";
		return 0;
	} else {
		        $balance=pg_result($result,'balance');
                        $balance=(float)$balance;
			return $balance;
		
	      }
}
//============================================================================================
/*function total_loan_current_balance($account_no,$action_date){
	// Customization required for WHERE CLAUSE
	 $sql_statement="SELECT loan_serial_no FROM loan_ledger_hrd WHERE account_no='$account_no' AND issue_date<=";
	 //$sql_statement="SELECT loan_serial_no FROM loan_ledger_hrd WHERE account_no='$account_no';
         if(empty($action_date)){$sql_statement=$sql_statement."current_date ";}
	 else{$sql_statement=$sql_statement."'$action_date' ";}
	//echo $sql_statement;
	$result=dBConnect($sql_statement);
	if(pg_NumRows($result)==0) {
		//echo "<h4>Not found!!!</h4>";
		return 0;
	} else {
		for($j=0; $j<pg_NumRows($result); $j++){
      		$row=pg_fetch_array($result,$j); 
		$amount+=loan_current_balance($account_no,$row['loan_serial_no'],$action_date);
		}
	  return $amount;
	     }
}
*/

function total_loan_current_balance($account_no,$action_date){
	// Customization required for WHERE CLAUSE
	 $sql_statement="SELECT loan_serial_no FROM loan_ledger_hrd WHERE account_no='$account_no' AND issue_date<=";
	 //$sql_statement="SELECT loan_serial_no FROM loan_ledger_hrd WHERE account_no='$account_no';
         if(empty($action_date)){$sql_statement=$sql_statement."current_date ";}
	 else{$sql_statement=$sql_statement."'$action_date' ";}
	//echo $sql_statement;
	$result=dBConnect($sql_statement);
	if(pg_NumRows($result)==0) {
		//echo "<h4>Not found!!!</h4>";
		return 0;
	} else {
		for($j=0; $j<pg_NumRows($result); $j++){
      		$row=pg_fetch_array($result,$j); 
		$amount+=loan_current_balance($account_no,$row['loan_serial_no'],$action_date);
		}
	  return $amount;
	     }



}
//============================================================================================
function global_sb_current_balance($status,$action_date){
 	if(empty($action_date)){$action_date="current_date";}
	 else {$action_date="'".$action_date."'";}
 $sql_statement="SELECT SUM(credit-debit) AS balance FROM mas_gl_tran where action_date<=$action_date AND CAST(gl_mas_code as INT) IN ($status)";
 //echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0)
{
 	$balance=0;
}
else
    {     
	$balance=pg_result($result,'balance');
    }
settype($balance,"int");
return $balance;
}
//---------------------------------------------------------------------------------------------
function sb_current_balance($account_no,$action_date){
	//$gl_code=getGlCode4mCustomerAccount($account_no);
	 if(empty($account_no)){$account_no="SB-";}
	 if(empty($action_date)){$action_date="current_date";}
	 else {$action_date="'".$action_date."'";}
	$sql_statement="SELECT SUM(credit-debit) AS balance FROM mas_gl_tran where action_date<=$action_date and account_no='$account_no' and gl_mas_code not like '6%'";
 
        // echo $sql_statement;
	$result=dBConnect($sql_statement);
	if(pg_NumRows($result)==0) {

		//echo "<h4>Not found!!!</h4>";
		return 0.0;
	} else {
		        $balance=pg_result($result,'balance');
                        $balance=(float)$balance;
			return $balance;
		
	      }
}
//--------------------------------------------------------------------------------------------
function share_current_balance($account_no,&$no,&$val,$action_date){
	$gl_code=getGlCode4mMember($account_no);
	$sql_statement="SELECT (SUM(CASE WHEN dr_cr='Cr' AND gl_mas_code='$gl_code' THEN qty ELSE 0 END) - SUM(CASE WHEN dr_cr='Dr' AND gl_mas_code='$gl_code' THEN qty ELSE 0 END)) as qty,(SUM(CASE WHEN dr_cr='Cr' AND gl_mas_code='$gl_code' THEN amount ELSE 0 END) - SUM(CASE WHEN dr_cr='Dr' AND gl_mas_code='$gl_code' THEN amount ELSE 0 END)) as value FROM share_detail_view where account_no='$account_no' and action_date<=";
         if(empty($action_date)){$sql_statement=$sql_statement."current_date";}
	 else{$sql_statement=$sql_statement."'$action_date'";}
	//echo $sql_statement;
	$result=dBConnect($sql_statement);
	if(pg_NumRows($result)==0) {
		//echo "<h4>Not found!!!</h4>";
			$no=0.0;
			$val=0.0;
		
	} else {
		        $no=pg_result($result,'qty');
			$val=pg_result($result,'value');
			$val=sprintf("%-12.0f",$val);
			$no=sprintf("%-12.0f",$no);
	      }

}
//--------------------------------------------------------------------------------------------
function getGlCode4mMember($account_no){
$sql_statement="SELECT gl_code from membership_info where membership_no='$account_no'";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
   $gl_code=pg_result($result,'gl_code');
   return $gl_code;
	}
}
//---------------------------------------------------------------------------------------------
function shg_loan_limit($group_no){
	$sb=shg_sb_total_balance($group_no);
	//echo $sb;
	$loan_balance=loan_total_balance($group_no);
 	$limit=($sb*4)-$loan_balance;
	return $limit;
}
//----------------------------------------------------------------------------------------------
function shg_sb_total_balance($group_no){
	//
	$sql_statement="SELECT account_no FROM shg_account WHERE shg_no='$group_no' AND account_type='sb'";
	//echo $sql_statement;
	$result=dBConnect($sql_statement);
	if(pg_NumRows($result)==0) {
		//echo "<h4>Not found!!!</h4>";
		return 0.0;
	} else {
			$balance=(float)sb_current_balance(pg_result($result,'account_no'),'');
			return $balance;
		}
	
}
//---------------------------------------------------------------------------------------------
//EMI_calculation($principal,$rate,$months);
function EMI_calculation($principal,$rate,$months){
$rate/=1200;
$emi=($rate+($rate/(pow((1+$rate),$months)-1)))*$principal;
$emi=sprintf("%-12.2f",$emi);
return $emi;
}
//---------------------------------------------------------------------------------------------
function getGlCode4LN($typeIn,$menu){
switch($typeIn){
  case 'mt':
	switch($menu){
		case 'shg':
		$code='23213';
		break;
		case 'ln':
		$code='23215';
		break;
		}
  break;
  case 'st':
	switch($menu){
		case 'shg':
		$code='23113';
		break;
		}
  break;
 }
return $code;
}
//============================================================================================
function getSourceType($id){
$sql_statement="SELECT trim(bank_type) as t FROM bank_dtl WHERE bank_id='$id'";
	$result=dBConnect($sql_statement);
	if(pg_NumRows($result)==0) {
		$s_type=null;
	} else {
		$s_type=pg_result($result,'t');
		
		}
	return $s_type;
}
//============================================================================================
function shgAccount($group_id,$account_type){
	$sql_statement="SELECT account_no  FROM shg_account WHERE shg_no='$group_id' AND account_type=lower('$account_type')";
	$result=dBConnect($sql_statement);
	if(pg_NumRows($result)==0) {
		$account_no=null;
	} else {
		for($j=0; $j<pg_NumRows($result); $j++){
      		$row=pg_fetch_array($result,$j);
		if($j!=0){$account_no.=',';}
		$account_no.=$account_no;
				}
		}
	return $account_no;
}
//--------------------------------------------------------------------------------------------
function getGlCode4interestPaid($gl_code,$status){
switch(trim($status)){
 case 'sb':
	  switch($gl_code){
 		
 		case "14101":
			$int_code="62101";
     		break;
 		case "14201":
    			$int_code="62201";
    		break;
 		case "14301":
    			$int_code="62301";//
    		break;
		case "14401":
    			$int_code="62401";
    		break;
    		
   		}
 break;
 case 'fd':
	
	switch($gl_code){
 		
 		case "14101":
			$int_code="62101";
     		break;
 		case "14201":
    			$int_code="62201";
    		break;
 		case "14301":
    			$int_code="62301";//
    		break;
		case "14401":
    			$int_code="62401";
    		break;
    		
   		}
break;         
case 'ri':
	switch($gl_code){
 		case "14101":
			$int_code="62101";
     		break;
 		case "14201":

    			$int_code="62201";
    		break;
 		case "14301":
    			$int_code="62301";//
    		break;
		case "14401":
    			$int_code="62401";
    		break;
    		
   		}
 


break;

case 'rd':
	switch($gl_code){
 		case "14101":
			$int_code="62101";
     		break;
 		case "14201":
    			$int_code="62201";
    		break;
 		case "14301":
    			$int_code="62301";//
    		break;
		case "14401":
    			$int_code="62401";
    		break;
    		
   		}
break;
case 'mis':
	switch($gl_code){
 		case "14101":
			$int_code="62101";
     		break;
 		case "14201":
    			$int_code="62201";
    		break;
 		case "14301":
    			$int_code="62301";//
    		break;
		case "14401":
    			$int_code="62401";
    		break;
    		
   		}
 
break; 
}						
return $int_code;
}
//===========================================================================================
function countRows($table){
$sql_statement="SELECT COUNT(*) as count from $table";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
   $id=pg_result($result,'count');
   }
else{
	$id=0;
}
return $id+1;
}
//============================================================================================
function getGlBalance($code){
$sql_statement="SELECT * from gl_current_balance WHERE gl_code='$code' AND year_month=to_char(CURRENT_DATE,'yyyy-mm')";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
   $balance=(float)pg_result($result,'amount');
   $balance=$balance." ".pg_result($result,'dr_cr');

   }
else{
	$balance=0;}
return $balance;
}
//============================================================================================
function checkLand($gp,$dag_no,$jl_no,$mouja){
$sql_statement="SELECT *  from land_info WHERE (gp='$gp' AND dag_no='$dag_no' AND jl_no='$jl_no' AND mouja_no='$mouja') AND status<>'s'";
//echo $sql_statement;
$result=dBConnect($sql_statement);
//echo "no of row:".pg_NumRows($result);
if(pg_NumRows($result)>0){
   $flag=pg_result($result,'customer_id');

   }
//echo "flag is: $flag";
return $flag;
}
//=============================================================================================
function checkBank($bname,$br_name){
$sql_statement="SELECT * FROM bank_dtl WHERE bank_name=upper('$bname') AND branch_name=upper('$br_name')";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)<1){
   $flag=true;
   return $flag;
   }
}
//=============================================================================================
function getData($data){
$c_pieces=explode("[",$data);
$data=substr($c_pieces[1],0,(strlen($c_pieces[1])-1));
return $data;
}
//=============================================================================================
function getGlCodeBank($bank_id,$typeIn){
$bank_type=getBankType($bank_id);
switch($bank_type){
case 'ccb':
   switch($typeIn){
	case 'ca':
		$code='28201';
	break;
	case 'sb':
		$code='28202';
	break;
	case 'fd':
		$code='22402';
	break;
	case 'rd':
		$code='22401';
	break;
	case 'ri':
		$code='22403';
	break;
	case 'mis':

		$code='22499';
	break;

	}
break;
case 'ot':
switch($typeIn){
	case 'ca':
		$code='28301';
	break;
	case 'sb':
		$code='28302';
	break;
	case 'fd':
		$code='22502';
	break;
	case 'rd':
		$code='22501';
	break;
	case 'ri':
		$code='22503';
	break;
	case 'mis':
		$code='22599';
	break;

	}
break;
case 'po':
	$code='22601';
break;
}
return $code;
}
//============================================================================================
function getBankType($bank_id){
$sql_statement="SELECT bank_type from bank_dtl where bank_id=$bank_id";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
   $type=pg_result($result,0);
   return $type;
   }
}
//=============================================================================================
function checkRD($account_no){
$sql_statement="SELECT * from deposit_info WHERE account_no='$account_no'";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
   $flag=pg_result($result,'principal');
   return $flag;
   }

}

//---------------------------Anindya-----------------------------------------------------------
// use to show land information:
function getLand($customer_id)
{
$sql_statement="SELECT sum(land_area) as land from land_info WHERE customer_id='$customer_id' AND closing_date IS NULL";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0)
   {
   $flag=pg_result($result,'land');
   }
else{
$flag=0;
}
return (float)$flag;
}
//------------------------------------shg close------------------------
function isSHG($id){
$sql_statement="SELECT * FROM shg_info where customer_id='$id'";


$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0) {
   return true;
 }
else{
return false;
}
}
function isopenSHG($id){
$sql_statement="SELECT * FROM shg_info where customer_id='$id' AND status='op'";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0) {
   return true;
 }
else{
return false;
}
}
//===========================================================================================
function isopenLoan($account_no){
$sql_statement="SELECT * FROM loan_ledger_hrd where account_no='$account_no' AND status='op'";
//echo $sql_statement; 
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0) {
   return true;
 }
else{
return false;
}
}
//----------------------------------------------------------------------------
function isopening($account_no){
$sql_statement="SELECT * FROM loan_ledger_hrd where account_no='$account_no'";
//echo $sql_statement; 
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0) {
   return true;
 }
else{
return false;
}
}
//---------------------------------new------------------------------------
function totalvalue($gl_code,$year_month,$dr_cr){
  $amount=glBalance($gl_code,$year_month,$dr_cr);
  /*if($amount<0){
	$amount=abs($amount);
	$amount=($amount);
	$amount="(".$amount.")";
	}
  else{
	$amount=amount2Rs($amount);
      }*/
	
  
  return amount2Rs($amount);
}
//-------------------------------------------------------------------------------------------
function gl_sub_header($gl_code,$year_month,$dr_cr){
$WHERE_CONDITIONS="WHERE ";
$arr=explode(",",$gl_code);
$n=count($arr);
for($i=0; $i<($n-1);$i++){
	$WHERE_CONDITIONS="$WHERE_CONDITIONS gl_sub_header_code='$arr[$i]' OR";
	}	
$WHERE_CONDITIONS="$WHERE_CONDITIONS gl_sub_header_code='$arr[$i]'";
$sql_statement="SELECT gl_mas_code FROM gl_master $WHERE_CONDITIONS";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
for($j=1; $j<pg_NumRows($result); $j++){
$row=pg_fetch_array($result,($j-1));
$gl_mas_code.=$row[0].',';
}
$row=pg_fetch_array($result,($j-1));
$gl_mas_code.=$row[0];
$amount=totalvalue($gl_mas_code,$year_month,$dr_cr);
if(empty($amount)){$amount=0;}
}
else{
}
return $amount;
}

//=============================================================================================
function gl_header($gl_code,$year_month,$dr_cr){
$WHERE_CONDITIONS="WHERE ";
$arr=explode(",",$gl_code);
$n=count($arr);
for($i=0; $i<($n-1);$i++){
	$WHERE_CONDITIONS="$WHERE_CONDITIONS gl_header_code='$arr[$i]' OR";
	}	
$WHERE_CONDITIONS="$WHERE_CONDITIONS gl_header_code='$arr[$i]'";
$sql_statement="SELECT gl_sub_header_code FROM gl_sub_header $WHERE_CONDITIONS";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
for($j=1; $j<pg_NumRows($result); $j++){
$row=pg_fetch_array($result,($j-1));
$gl_sub_code.=$row[0].',';
}
$row=pg_fetch_array($result,($j-1));
$gl_sub_code.=$row[0];
$amount=gl_sub_header($gl_sub_code,$year_month,$dr_cr);
if(empty($amount)){$amount=0;}
}
else{
 
}
return $amount;
}
//=============================================================================================
function gl_headerValue($value,$year_month,$dr_cr){
$sql_statement="SELECT gl_header_code FROM gl_header WHERE status='$value'";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
for($j=1; $j<pg_NumRows($result); $j++){
$row=pg_fetch_array($result,($j-1));
$gl_code.=$row[0].',';
}
$row=pg_fetch_array($result,($j-1));
$gl_code.=$row[0];
$amount=gl_header($gl_code,$year_month,$dr_cr);
if(empty($amount)){$amount=0;}
}
else{
 
}
return $amount;
}
//============================================================================================
function findSBAccount($account_no){
$sql_statement="SELECT account_no FROM customer_account WHERE account_type='sb' AND status='op' and customer_id=(SELECT customer_id FROM customer_account WHERE account_no='$account_no')";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$account_sb=pg_result($result,'account_no');
}
return $account_sb;
}
//=============================================================================================
function pl_document($account_no,&$loan_sl_no,&$sum_amount){
$sql_statement="SELECT SUM(security_value) as sum_amount,loan_serial_no FROM loan_security WHERE account_no='$account_no' AND status is NULL GROUP BY loan_serial_no";

//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$sum_amount=pg_result($result,'sum_amount');
$loan_sl_no=pg_result($result,'loan_serial_no');
}
}
//=============================================================================================
function amount2Rs($amount){
$amount=explode("-",$amount);
$l=COUNT($amount);
if($l>1){
$minus='-';
$amount=$amount[1];
}
else{ $amount=$amount[0];}
$amount=explode(".",$amount);
$l=COUNT($amount);
if($l>1){
$after_point=$amount[1];
}
$amount=$amount[0];
$len=strlen($amount);
switch($len){
case 1:
case 2:
case 3:
   $str=$amount;
break;
case 4:
case 5:
	$j=$amount/1000;
	settype($j,"int");
	$sub=substr($amount,strlen($j),$len);
	$amount=$j.','.$sub;
	$str=$amount;
break;
case 6:
case 7:
	$j=$amount/100000;
	settype($j,"int");
	//echo $amount."->$j";
	$sub=substr($amount,(strlen($j)+2),$len);
	$amount=$j.','.substr($amount,strlen($j),2).','.$sub;
	$str=$amount;
	break;
case 8:
case 9:
case 10:		
	$j=$amount/10000000;
	settype($j,"int");
	$sub=substr($amount,(strlen($j)+4),$len);
	$amount=$j.','.substr($amount,strlen($j),2).','.substr($amount,(strlen($j)+2),2).','.$sub;
	$str=$amount;

break;
}
if(empty($str)){$str='0';}
if(empty($after_point)){$after_point='00';}

$str.=".".$after_point;

if(!empty($minus)){$str=$minus.$str;}
return $str;
}
//===========================================================================================
function getInterestDtl($member_id,&$d,&$od,&$bp){
$sql_statement="SELECT * FROM shg_mem_loan_dtl WHERE mem_id='$member_id'";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$d=pg_result($result,'b_d_i');
$od=pg_result($result,'b_od_i');
$bp=pg_result($result,'b_p');

}
}
//===========================MONOJIT ZONE ==============================
function makeSelectwithJS($element_array,$element,$default,$id,$JSfunc){

	echo "<SELECT name=\"".$element."\" id=\"$id\" $JSfunc><option>";
	

	if(!empty($default)){
		echo "<option>".$default;
	}
	
	while(list($key,$val)=each($element_array)){
		if($val!=$default){
			echo "<option Value=\"$key\">".$val;
		}
	}
	echo "</select>";
}
//--------------------------------------------------------------------
function getGlCode4mBank($account_no,$menu){
$sql_statement="SELECT gl_code FROM bank_bk_dtl WHERE account_no='$account_no'";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$gl_code=pg_result($result,'gl_code');
return $gl_code;
    }

}
//============================================================================================
function makeSelectValue($element_array,$element,$default){

	echo "<SELECT name=\"".$element."\" id=\"$element\">";
	
	if(!empty($default)){
		echo "<option>".$default;
	}
	
	while(list($key,$val)=each($element_array)){
		if($val!=$default){
			
			echo "<option value=\"$key\">".$val;
		}
	}
	echo "</select>";
}
//=================================================================================================
function getBankInfo($bcode){
$sql_statement="SELECT * FROM bank_bk_dtl WHERE link_tb=$bcode";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0){
$flag=0;
echo "<h1><b><center><blink><font color=\"red\">This is Not valid Bank $name !!!</b></h1></blink></font>";
}
else{
echo "<hr><table width=\"100%\" valign=\"top\" align=Center bgcolor=WHITE>";
echo "<th bgcolor=\"GREEN\" colspan=\"3\" align=\"center\"><font color=\"white\">General Information of Bank</font>";
$row=pg_fetch_array($result,0);
$b_type=trim($row['b_type']);
echo "<tr><td>Bank code: <b>".$row['link_tb'];
echo "<td>Bank Name: <b>".$row['b_name']."</b><td>Branch Name: <b>".$row['br_name'];
echo "<tr><td>Account No: <b>".$row['account_no']."</B><td>Account Type: <b>".strtoupper($row['account_sub_type'])."</b><td>Bank Type: <b>".strtoupper(trim($b_type));
echo "</table><hr>";
$flag=1;
}
return $flag;
}
//===========================vendor=============================================
function selectVendorName($v_name,$parameter,$except_account_no){
if(empty($except_account_no)){$WHERE_CONDITION='WHERE';}
else{$WHERE_CONDITION="WHERE account_no<>'$except_account_no' AND ";}
$sql_statement="SELECT * FROM vendor_master";

 //echo $sql_statement;
 $result=dBConnect($sql_statement);
 echo "<select name=\"$v_name\" id=\"$v_name\" $parameter>";
 if(pg_NumRows($result)==0) {
 echo "<option></option>";
//echo "NULL";
}
else{
      //
      for($j=0; $j<pg_NumRows($result); $j++) {
      $row=pg_fetch_array($result,$j); 
      echo "<option value=\"".$row['v_code']."\">".ucwords($row['v_name'])."</option>";
    }
}
echo "</select>";
}

//===========================material product=============================================
function selectMaterialName($mm_desc,$parameter,$except_account_no){
if(empty($except_account_no)){$WHERE_CONDITION='WHERE';}
else{$WHERE_CONDITION="WHERE account_no<>'$except_account_no' AND ";}
$sql_statement="SELECT * FROM material_master1";
 //echo $sql_statement;
 $result=dBConnect($sql_statement);
 echo "<select name=\"$mm_desc\" id=\"$mm_desc\" $parameter>";
 if(pg_NumRows($result)==0) {
 echo "<option></option>";
//echo "NULL";
}
else{
      //
      for($j=0; $j<pg_NumRows($result); $j++) {
      $row=pg_fetch_array($result,$j); 
      echo "<option value=\"".$row['mm_code']."\">".ucwords($row['mm_desc'])."</option>";
    }
}
echo "</select>";
}

//=============================================================================================
function selectBankAccount($name,$parameter,$except_account_no){
if(empty($except_account_no)){$WHERE_CONDITION='WHERE';}
else{$WHERE_CONDITION="WHERE account_no<>'$except_account_no' AND ";}
$sql_statement="SELECT * FROM bank_bk_dtl $WHERE_CONDITION (account_type='sb' OR account_type='ca')";
 //echo $sql_statement;
 $result=dBConnect($sql_statement);
 echo "<select name=\"$name\" id=\"$name\" $parameter>";
 if(pg_NumRows($result)==0) {
 echo "<option></option>";
//echo "NULL";
}
else{
      //
      for($j=0; $j<pg_NumRows($result); $j++) {
      $row=pg_fetch_array($result,$j); 
      echo "<option value=\"".$row['account_no']."\">".ucwords($row['b_name'])."[".strtoupper($row['account_type'])."-".$row['account_no']."]</option>";
    }
}
echo "</select>";
}
//=============================================================================================
function reverseJV($t_id,$action_date){
$sql_statement="SELECT * FROM gl_ledger_hrd WHERE tran_id='$t_id'";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$tran_id=getTranId();
$fy=getFy($action_date);
$staff_id=$staff_id=verifyAutho();
$type=pg_result($result,'type');
$remarks=pg_result($result,'remarks');
$sql_statement="INSERT INTO gl_ledger_hrd(tran_id,type,certificate_no,action_date, fy,remarks,operator_code,entry_time) VALUES ('$tran_id','jv','bounced','$action_date', '$fy','Reverse Entry Of $t_id','$staff_id',CAST(('$action_date'||SUBSTR(now(),11,length(now()))) AS TIMESTAMP))";
//------------------------------------------------------------------------------------------
$sql_statement1="SELECT * FROM gl_ledger_dtl WHERE tran_id='$t_id' ORDER BY dr_cr";
$result=dBConnect($sql_statement1);
for($j=0;$j<pg_NumRows($result);$j++){
$row=pg_fetch_array($result,$j);
$d_c=$row['dr_cr'];
if($d_c=='Dr'){$d_c='Cr';}
else{$d_c='Dr';}
 $sql_statement.=";INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,qty,amount,dr_cr, particulars) VALUES('".$row['tran_id']."','".$row['account_no']."','".$row['gl_mas_code']."',".$row['qty'].",".$row['amount'].",'$d_c','".$row['particulars']."')";
 	}
//echo  $sql_statement;
//$result=dBConnect($sql_statement);
if(pg_affected_rows($result)<1) {
	echo "<br><h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
	} 
else {
      return true;
      }
        
   }
}
//============================================================================================
function getHeaderInfo($tran_id,$d_c,$action_date){
$action_date=(empty($action_date))?date('d.m.Y'):$action_date;
$sql_statement="SELECT a.tran_id, CASE 
      WHEN b.gl_mas_code='14101' and a.gl_mas_code='14301' THEN b.gl_mas_code 
      WHEN b.gl_mas_code='14102' and a.gl_mas_code='14302' THEN b.gl_mas_code 
      WHEN b.gl_mas_code='14103' and a.gl_mas_code='14303' THEN b.gl_mas_code 
      WHEN b.gl_mas_code='14104' and a.gl_mas_code='14304' THEN b.gl_mas_code 
      WHEN b.gl_mas_code='14105' and a.gl_mas_code='14305' THEN b.gl_mas_code 
      ELSE a.gl_mas_code
      END as gl_mas_code,qty,amount,dr_cr,particulars,a.account_no FROM gl_ledger_dtl a
LEFT JOIN
(SELECT customer_id,opening_date,account_no,gl_mas_code,status from customer_account a WHERE opening_date=(SELECT MAX(opening_date) FROM customer_account b WHERE entry_time=(SELECT MAX(entry_time)FROM customer_account c WHERE a.customer_id=c.customer_id AND b.customer_id=c.customer_id AND opening_date<='$action_date'))) as b on a.account_no=b.account_no
WHERE tran_id='$tran_id' AND dr_cr='$d_c'";

$result=dBConnect($sql_statement);
for($j=0;$j<pg_NumRows($result);$j++){
$row=pg_fetch_array($result,$j);
$str.=ucwords(findGlDesc($row['gl_mas_code']))."[".$row['gl_mas_code']."]->Rs.".amount2Rs((float)$row['amount']);
//echo "<BR>";
$str.="<br>";

	}
return $str;
}
//============================================================================================
function customerAccountNo($customer_id,$type){
$sql_statement="SELECT account_no FROM customer_account WHERE customer_id='$customer_id' AND account_type='$type' AND status='op'";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
$c_id=null;
}
else{
   $account_no=pg_result($result,'account_no');
 }
return $account_no;
}
//============================================================================================
function accountVarification($account_no){
$sql_statement="SELECT account_no FROM customer_account WHERE account_no=upper('$account_no') AND status='op'";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
return false;
}
else{
   return true;
  }
}
//================================RETAIL SHOP ZONE========================================
function getGlOpCl($mg_code,$type){
$sql_statement="SELECT $type FROM material_group WHERE mg_code='$mg_code'";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
return NULL;
}
else{
   return pg_result($result,$type);
  }

}

//============================================================================================
function getVatRate($mg_code){
$sql_statement="SELECT vat_rate FROM vat_master WHERE mg_code='$mg_code' AND effective_dt=(SELECT  MAX(effective_dt) FROM vat_master WHERE mg_code='$mg_code')";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0) {
return pg_result($result,'vat_rate');
	}
else{
return 0;
}
}
//=============================================================================================
function getUOM($mm_code){
$sql_statement="SELECT uom FROM material_master WHERE mm_code='$mm_code'";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0) {
return pg_result($result,'uom');
	}
}
//=============================================================================================
function kg2Bag($qty,$uom){
if($uom=='kg'){
	if($qty>49){
	$qty=explode(".",$qty);
	$l=COUNT($qty);
	if($l>1){
		$after_point=$qty[1];
		if($after_point>0){
		$after_point*=1000;
		$after_point=$after_point." gram";
		}
		else{$after_point=null;}       
	}
 
	$qty=$qty[0];
	$bag=$qty/50;
	settype($bag,"int");
	$kg=$qty%50;
	$bag=$bag." bag";
	if($kg>0){$kg=$kg." kg";}
	else{$kg=null;}
	$str=$bag." ".$kg;
	if($l>1){$str=trim($str)." ".$after_point;}
	}
	else{
	$qty=explode(".",$qty);
	$l=COUNT($qty);
	if($l>1){
		$after_point=$qty[1];
		if($after_point>0){
		$after_point*=1000;
		$after_point=$after_point." gram";
		}
		else{$after_point=null;}       
	}
 
	$qty=$qty[0];
	$str=$qty." kg";
	$str=trim($str)." ".$after_point;
	}
}
else{
$str=$qty." ".$uom;
}
return $str;
}
//=============================================================================================
function getCustomerInfo($customer_id){
$sql_statement="SELECT * FROM customer_master WHERE customer_id='$customer_id'";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0) {
$name=pg_result($result,'name1');
$fname=pg_result($result,'father_name1');
$add1=pg_result($result,'address11');
$add2=pg_result($result,'address12');
$add3=pg_result($result,'address13');
$ph=pg_result($result,'telephone1');
$str="Name : ".ucwords($name)."\n";
$str.="C/O : ".ucwords($fname)."\n";
$str.="Address: ".ucwords($add1)." ".ucwords($add2)." ".ucwords($add3)."\n";
$str.="Ph : ".$ph."\n";
	}
return $str;
}
//============================================================================================

//=============================================================================================
function getCustomerStatus($customer_id){
$sql_statement="SELECT customer_status FROM customer_master WHERE customer_id='$customer_id'";
//echo "<h2> $sql_statement</h2>";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0) {
return pg_result($result,'customer_status');
	}
}
//=============================================================================================
function getGlCodeRetail($mg_code,$status,$type,&$gl_code_t,&$gl_code_dc){
$sql_statement="SELECT gl_code_t,gl_code_dc FROM match_group WHERE mg_code='$mg_code' AND v_c_type=trim('$status') AND tran_type='$type'";
//echo"<h1> $sql_statement</h1>";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0) {
$gl_code_t=pg_result($result,'gl_code_t');
$gl_code_dc=pg_result($result,'gl_code_dc');
	}

}

//=============================================================================================
function getGlCodeRetail1($status,$type,&$gl_code_t,&$gl_code_dc){
$sql_statement="SELECT gl_code_t,gl_code_dc FROM match_group WHERE v_c_type=trim('$status') AND tran_type='$type'";
//echo"<h1> $sql_statement</h1>";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0) {
$gl_code_t=pg_result($result,'gl_code_t');
$gl_code_dc=pg_result($result,'gl_code_dc');
	}

}

//=============================================================================
function getVendorStatus($v_id){
$sql_statement="SELECT v_cat FROM vendor_master WHERE v_code='$v_id'";
//echo"<h1> $sql_statement</h1>";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0) {
return pg_result($result,'v_cat');
	}


}
//=============================================================================
function getDetailFy($fy,&$f_start_dt,&$f_end_dt){
$x=$_SESSION['fy'];
$x=explode('-',$x);
$f_end_dt="31/03/".$x[1];
$f_start_dt="01/04/".$x[0];
}
//================================================================================================================================
function getGlCode4mLoanLedger($loan_sl,$gl_status){
$sql_statement="SELECT gl_code FROM loan_ledger_hrd WHERE loan_serial_no='$loan_sl' AND gl_status='$gl_status'";
//echo"<h1> $sql_statement</h1>";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0) {
return pg_result($result,'gl_code');
	}

else{
$gl_code=oDPrincipal($loan_sl);
if (!empty($gl_code)){return $gl_code;}
	}
}
//---------------------------------------------------------------------------------------------
function oDPrincipal($ln_sl){
$sql_statement="SELECT account_no,gl_code,repay_date+1 as repay_date,(already_paid-already_return) as balance, to_char(repay_date+1,'ddmmyy') as tran_code FROM loan_ledger_hrd WHERE loan_serial_no='$ln_sl'";
//echo"<h1> $sql_statement</h1>";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0) {
	$gl_code=pg_result($result,'gl_code');
	$balance=pg_result($result,'balance');
	$account_no=pg_result($result,'account_no');
	$repay_dt=pg_result($result,'repay_date');
	$tran_code=pg_result($result,'tran_code');
	$tran_code=nextValue('tran_id')."/".$tran_code;
	$fy=$_SESSION['fy'];
	$nw_gl_code=$gl_code+1;
	//echo "<h1>$gl_code</h1>";
	$sql_statement="UPDATE loan_ledger_hrd SET gl_code='$nw_gl_code',gl_status='o' WHERE loan_serial_no='$ln_sl'";
	//transfer due principal to overdue principal
	//gl_ledger_hrd
	$sql_statement.="; INSERT INTO gl_ledger_hrd(tran_id,action_date,type,fy, operator_code,entry_time) VALUES ('$tran_code','$repay_dt','jv','$fy','sys',CAST('$repay_dt'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
	//gl_ledger_dtl
	$sql_statement.="; INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr,particulars) VALUES('$tran_code','$ln_sl', '$nw_gl_code',$balance,'Dr','trf')";
	$sql_statement.="; INSERT INTO gl_ledger_dtl(tran_id,account_no,gl_mas_code,amount,dr_cr,particulars) VALUES('$tran_code','$ln_sl', '$gl_code',$balance,'Cr','trf')";
	//echo "<h1>$sql_statement</h1>";
	$result=dBConnect($sql_statement);
	if(pg_affected_rows($result)<1){
		echo "<h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
			}
	else{
		return $nw_gl_code;
	} 
    }
else{
	echo "<h1>Not Found!!!!!!!</h1>";
}

}
//====================================================================================================================
function getCustType($id){
$sql_statement="SELECT type_of_customer FROM customer_master WHERE customer_id='$id'";
//echo "<h2> $sql_statement</h2>";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0) {
return pg_result($result,'type_of_customer');
	}

}
function makeSelectpass($element_array,$element,$default){

	echo "<SELECT name=\"".$element."\" id=\"".$element."\">";
	
	if(!empty($default)){
		echo "<option>".$default;
	}
	else{
echo "<option value=''>Select";
}
	while(list($key,$val)=each($element_array)){
		if($val!=$default){
		
			echo "<option value=\"".$key."\">".$val;
		}
	}
	echo "</select>";
}

function makeSelectFromDbwithId($table,$feild1,$feild2,$name){
  $sql_statement="SELECT $feild1,$feild2 from $table ORDER BY $feild1";
 $result=dBConnect($sql_statement);
 echo "<select name=\"$name\" id=\"$name\" onchange=\"this.form.submit();\">"; 
 if(pg_NumRows($result)==0) {
 echo "<option>Null</option>";
}
else{echo "<option value=\"$name\">select</option>";
      for($j=1; $j<=pg_NumRows($result); $j++) {
      $row=pg_fetch_array($result,($j-1)); 
      echo "<option value='".$row[$feild1]."'>".$row[$feild2]."</option>";
    }
}
echo "</select>";
}


//------------------------------------------------------------------------------------------------------------------------
function getAccountNo($customer_id,$account_type,&$account_no,&$gl_code){
$sql_statement="SELECT account_no,gl_mas_code FROM customer_account WHERE customer_id='$customer_id' AND account_type='$account_type'";
//echo "<h2> $sql_statement</h2>";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0) {
$account_no=pg_result($result,'account_no');
$gl_code=pg_result($result,'gl_mas_code');
	}
}

//+++++++++++++++++++++++++++++++++++++ASSET  CODE+++++++++++++++++++++++

function makeSelectFromDBWithCodeAsset($id,$desc,$table,$name,$WHERE){
// if (empty($WHERE)){
// 	$sql_statement="SELECT  $id,$desc from $table order by $id";
//	}
 //else{
	$sql_statement="SELECT  $id,$desc from $table where $id>'64100' and $id<'64999' ORDER BY $id";
//	}
// echo $sql_statement;
 $result=dBConnect($sql_statement);
 echo "<select name=\"$name\" id=\"$name\">";

if(pg_NumRows($result)==0) 
	{
 		echo "<option>Null</option>";
	}
else
	{
      		for($j=1; $j<=pg_NumRows($result); $j++) 
		{
      			$row=pg_fetch_array($result,($j-1)); 
     			echo "<option value=\"".$row[$id]."\">".ucwords($row[$desc])."[".$row[$id]."]</option>";
    		}
	}
echo "</select>";
}
//-----------------------------------------------------------------------------------------
function getVendorInfo($id){
//$sql_statement="SELECT UPPER(v_name) as v_name,UPPER(v_address1) as v_address1,UPPER(v_address2) as v_address2,UPPER(v_address3) as v_address3,pin,contact_no FROM vendor_master WHERE v_code='$id'";
$sql_statement="SELECT UPPER(name) as v_name,UPPER(address1) as v_address1,UPPER(address2) as v_address2,UPPER(address3) as v_address3,pin,contact_no 
FROM retail_master 
WHERE id='$id'";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0) {
$name=pg_result($result,'v_name');
$add1=pg_result($result,'v_address1');
$add2=pg_result($result,'v_address2');
$add3=pg_result($result,'v_address3');
$pin=pg_result($result,'pin');
$ph=pg_result($result,'contact_no');
$str="";
$str.="Name	:-".ucwords($name)."\n";
$str.="Address	:-".ucwords($add1)."\n";
$str.="P.O		:-".ucwords($add2)."\n";
$str.="P.S		:-".ucwords($add3)."\n";
$str.="Pin		:-".$pin."\n";
$str.="Ph		:-".$ph."\n";

	}
return $str;
}


function checkHSB($account_no){
$sql_statement="SELECT * from deposit_info WHERE account_no='$account_no'";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
   $flag=pg_result($result,'principal');
   return $flag;
   }

}
/////////////////////-------------------------------------------------------------------
?>

