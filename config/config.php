<?php
include "config_customer.php";
include "error.php";
//---------------------------------Authentication ---------------------------------------
function project_init(){
$test=strcmp($HTTP_USER_AGENT,'Mozilla/5.0');
}
function verifyAutho(){ // verify authorisation
	registerSession();
	$staff_id=$_SESSION['staff_id'];
	$_SESSION['fy']=$_SESSION['tmpFy'];
	$sql_statement="SELECT * FROM staff WHERE id='$staff_id'";
//echo $sql_statement;
	$result=dBConnect($sql_statement);
	if(pg_NumRows($result)==0){
	header("Location: ../index.php");
	}
	else{
		$role=pg_result($result,'role');
		if(trim($role)!=trim($_SESSION['role'])){
		header("Location: ../index.php");
		}

	}

	if(empty($staff_id)){
	  if( strcmp($SERVER_PROTOCOL,"HTTP/1.0") ){
			header("Cache-control: no-cache, must-revalidate"); // 1.1
		} 
		else {
			header("Pragma: no-cache"); // 1.0
		}
		header("Location: ../index.php");
		
	} 
	return $staff_id;	
}
//================
function getIndex1($element_array,$element){
	//print  $element_array;
	while(list($key,$val)=each($element_array)){
		if(!strcmp($element,$key)) { return $val; }
	}
}

//====================================PAYROLL=============================
function makeSelectcategory($element_array,$element,$default){

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








//--------------------------------------------------------------------------------------------
/*function isAdmin(){
	registerSession();
	$staff_id=$_SESSION['staff_id'];
	$sql_statement="SELECT * FROM staff where role='admin' AND id='$staff_id'";
	//echo $sql_statement;
	$result=dBConnect($sql_statement);
	if(pg_NumRows($result)==0){
		return false;
 	}
	else{
 		return true;
 	}
}*/
	
//--------------------------------------------------------------------------------------------
function isPermissible($menu){ // whether operation is permisible
	registerSession();
	$staff_id=$_SESSION['staff_id'];
	$active_account_type=$_SESSION['current_account_type'];
	echo $active_account_type;
	if(empty($staff_id)){
	//  if(strcmp($SERVER_PROTOCOL,"HTTP/1.0") ){
		//	header("Cache-control: no-cache, must-revalidate"); // 1.1
	//	} 
	//  else {
//			header("Pragma: no-cache"); // 1.0
	//	}
	header("Location: ../index.php");
	} 
	if(!strcmp($menu,$active_account_type)){
		return true;
	} else {
		header("Location: ../main/action_not_permitted.php");
 		echo "menu is:$menu";
		echo "active_menu is:$active_account_type)";
		return false;
	}

	return true;	
}
//---------------------------------------------------------------------------------------------

// Integer to by spelling, started  here

  function convrtstrl($n) { 
	$flag=0;
	$text="";
	$m=(integer)($n/10);
	$remainder=$n % 10;
	$range="";
	switch ($m) {
		case 9:
			$range=" Ninety ";
			break;
		case 8:
			$range=" Eighty ";
			break;
			case 7:
		$range=" Seventy ";
		break;
		case 6:
			$range=" Sixty ";
			break;
		case 5:
			$range=" Fifty ";
			break;
		case 4:
			$range=" Forty ";
			break;
		case 3:
			$range=" Thirty ";
			break;
		case 2:
			$range=" Twenty ";
			break;
		case 1:
			$flag=1; // flag to detect 11 to 19
			switch ($remainder) {
				case 9:
					$text=" Nineteen ";
					break;
				case 8:
					$text=" Eighteen ";
					break;
				case 7:
					$text=" Seventeen ";
					break;
				case 6:
					$text=" Sixteen ";
					break;
				case 5:
					$text=" Fifteen ";
					break;
				case 4:
					$text=" Fourteen ";
					break;
				case 3:
					$text=" Thirteen ";
					break;
				case 2:
					$text=" Twelve ";
					break;
				case 1:
					$text=" Eleven ";
					break;
				case 0:
					$text=" Ten ";
					break;
				}			
			break;
		case 0:
			break;

		}

	if($flag==0) {
		switch ($remainder) {
			case 9:
				$text=" Nine ";
				break;
			case 8:
				$text=" Eight ";
				break;
			case 7:
				$text=" Seven ";
				break;
			case 6:
				$text=" Six ";
				break;
			case 5:
				$text=" Five ";
				break;
			case 4:
				$text=" Four ";
				break;
			case 3:
				$text=" Three ";
				break;
			case 2:
				$text=" Two ";
				break;
			case 1:
				$text=" One ";
				break;
			}
	}			
	$text=$range.$text;
	return $text;
	}  // end of convrtstrl()

function money_int2string($n) {

// This function is written to convert any number to string. Maximum limit is 99 crore 99 lack 99 thousand 9 hundred 
// 99. Minimum is 0 (Zero). Any negative number will give zero which is wrong.


if($n<=0) {
	return "Zero";
	} else {
		if($n>=1000000000) {
		return "Unable to convert it! ";
		}
	}

$text="";
$remainder=$n;

while ($n>99) {
	$m=floor(log10((float)$n));

	switch ($m) {
		case 8:
		case 7:
			$range=" Crore ";
			$d=7;
			break;
		case 6:
		case 5:
			$range=" Lakh ";
			$d=5;
			break;
		case 4:
		case 3:
			$range=" Thousand ";
			$d=3;
			break;
		case 2:
			$range=" Hundred ";
			$d=2;
			break;

		}	

	$divisor=(integer)pow((float)10,(float)$d);
	$dividend=(integer)($n/$divisor);
	$remainder=$n % $divisor;

	//echo "<br>",$m," ", $dividend, "  ",$remainder;


	$text=$text.convrtstrl($dividend).$range;
	$n=$remainder;
	}
$text=$text.convrtstrl($remainder);
return $text;
}

function money2string($m) {
	$part=split("\.",$m,2);
	//echo "$part[0]| $part[1]|";
	$text=money_int2string((integer)$part[0]); 

	if((integer)$part[1]>0){
		$text=$text." and ".money_int2string((integer)$part[1])." paise "; 
	} 
	return $text;
}
//---------------------End of integer to spelling----------


function isAdministrator($id){ // $id=$staff_id 
  // to verify whether the staff is admin or not
	
	global $HOST,$DATABASE,$DATESTYLE;

	$db=pg_Connect("host=".$HOST." dbname=".$DATABASE);
	$result=pg_Exec($db,$DATESTYLE);

	// verify the role 
	$result=pg_Exec($db,"SELECT role FROM staff WHERE id='".$id."'");
	if(pg_NumRows($result)==0){
		return false; // false
	} else {
		$role=pg_result($result,'role');
		return ereg("admin",$role);
	}
}


/*function makeSelect($element_array,$element,$default){

	echo "<SELECT name=\"".$element."\">";
	
	if(!empty($default)){
		echo "<option>".$default;
	}
	
	while(list($key,$val)=each($element_array)){
		if($val!=$default){
		
			echo "<option>".$val;
		}
	}
	echo "</select>";
}*/
function makeSelect($element_array,$element,$default){

	echo "<SELECT name=\"".$element."\" id=\"".$element."\">";
	
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
//----------------------------------------------------------------------------------------
function makeSelectDisabled($element_array,$element,$default){

	echo "<SELECT name=\"".$element."\" disabled>";
	
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
//------------------------------------------------------------------------------------------
function getIndex($element_array,$element){
	//print  $element_array;
	while(list($key,$val)=each($element_array)){
		if(!strcmp($element,$val)) { return $key; }
	}
}
//------------------------------------------------------------------------------------------
function isActive_sb_account($account_no){
$sql_statement="SELECT * FROM customer_account where account_no='$account_no' AND closing_date IS NULL";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0){
	return 'cl';
 }
else{
 	return 'op';
 }
}
//-------------------------------------------------------------------------------------------
function getTranId(){

//echo "TRANSACTION_ID is $TRANSACTION_ID";
$new_date="/".date("d",time()).date("m",time()).date("y",time());
$id=nextValue("tran_id");
$id=$id.$new_date;
return $id;   
}

//-------------------------------------------------------------------------------------------
function isexists($element_array,$element){
	while(list($key,$val)=each($element_array)){
		if(!strcmp($element,$key)) { return 1; }
	}
	return 0;
}
// ----------------------------------------------------------------------------------------
// Now compute interest, maturity value etc.
// This function is under development and can only compute 
// cummelative interest. 
function compute_deposit($scheme,$amount_deposit,$period,&$rate_of_interest,&$total_interest,&$maturity_amount,$opening_date,$menu){
        $sql_statement="select rate from interest_rate where id =(select id from interest_rate where period=(select MAX(period) from interest_rate WHERE period<=$period AND deposit_type='$menu' AND scheme='$scheme') AND year_witheffect=(SELECT MAX(year_witheffect) from interest_rate where year_witheffect<='$opening_date' AND period=(SELECT MAX(period) from interest_rate where period<=$period AND deposit_type='$menu' AND scheme='$scheme') AND deposit_type='$menu' AND scheme='$scheme') AND scheme='$scheme' AND deposit_type='$menu')";
	//echo $sql_statement;
	$result=dBConnect($sql_statement);
	if(pg_NumRows($result)==0) {
		$rate_of_interest=0;
	} else {
		$rate_of_interest=pg_result($result,'rate');
		}
	switch($menu){
	case 'fd':
	$maturity_amount=compute_fd($amount_deposit,$rate_of_interest,$period);
	break;
	case 'ri':
	$maturity_amount=compute_ri($amount_deposit,$rate_of_interest,$period);
	break;
	case 'rd':
	$maturity_amount=compute_rd($amount_deposit,$rate_of_interest,$period);
	$amount_deposit*=$period;
	break;
	case 'mis':
	$maturity_amount=compute_mis($amount_deposit,$rate_of_interest,$period);
	//$amount_deposit*=12*$period;
	break;
	}
	$total_interest=$maturity_amount-$amount_deposit;
	$maturity_amount=trim(sprintf("%-12.0f",$maturity_amount));
	$total_interest=sprintf("%-12.0f",$total_interest);
	
	return;
}
//----------------------------------------------------------------------------------------------
function compute_fd($principal,$rate,$time){
		$i=($rate/100.00);
//  		$amount=($principal*$i*$time)/12;
		$amount=($principal*$i*$time)/365;
		return $amount+$principal;
	}
//---------------------------------------------------------------------------------------------
function compute_ri($principal,$rate,$time){
		
		$n=($time*4.00)/12;   // No. of quarters
	        $i=$rate/400.00; // per quarter per 1 rupee, etc
		$amount=$principal*pow((1+$i),$n);
		return $amount;
	}
//----------------------------------------------------------------------------------------------
function compute_rd($principal,$rate,$time){
		$time=$time/3;
		$i=$rate/400;
		$j=1-pow(($i+1),-1/3);
		$k=$principal*((pow((1+$i),$time))-1);
		$amount=$k/$j;
		return $amount;
        }
	
//----------------------------------------------------------------------------------------------
function compute_mis($principal,$rate,$time){
		$rate=$rate/100;
		$amount=$principal*$rate*$time;
		return $amount+$principal;
	}
//----------------------------------------------------------------------------------------------
function maturity_date($opening_date,$period,$type){
        switch($type){
		case 'd':
		 $sql_statement="SELECT CAST(CAST('$opening_date' AS DATE) + interval '$period days' AS date) AS maturity_date";
		break;
		case 'm':
		 $sql_statement="SELECT CAST(CAST('$opening_date' AS DATE) + interval '$period months' as DATE) AS maturity_date";
		break;
		case 'y':
		 $sql_statement="SELECT CAST(CAST('$opening_date' AS DATE) + interval '$period years' AS DATE) AS maturity_date";
		break;
	}
        //echo "sql".$sql_statement;
	$result=dBConnect($sql_statement);
	if(pg_NumRows($result)==0) {
		return  '01.01.1970';
	} else {	
		  $maturity_date=pg_result($result,'maturity_date');
		//echo  $maturity_date;
		  return $maturity_date;	
		}
	}
//---------------------------------------------------------------------------------------------
// Now compute interest, maturity value etc.
// This function is under development.

//----------------------------------------------------------


//--------------------------------------------------------------

function installment($rate,$principal){
	$month_installment=$rate*$principal/1200;
	return $month_installment;
	}

function mis_current_balance($account_no){
	global $HOST,$DATABASE,$DATESTYLE;
	
	$db=pg_pConnect("host=$HOST dbname=$DATABASE");
	$result=pg_Exec($db,$DATESTYLE);
	// Customization required for WHERE CLAUSE

	$sql_statement="SELECT balances FROM mis_ledger WHERE account_no='$account_no' ORDER BY entry_time DESC";
	$result=pg_Exec($db,$sql_statement);
	if(pg_NumRows($result)==0) {
		//echo "<h4>Not found!!!</h4>";
		return 0.0;
	} else {
		for($j=1; $j<=pg_NumRows($result); $j++) {
			$row=pg_fetch_array($result,($j-1));
			$balance=(float)$row["balances"];
			return $balance;
		}
	}
}
 
//------------------------------------for Customer -----------------------------------------//
function getGeneralInfo_Customer($id){
$sql_statement="SELECT * FROM customer_master WHERE customer_id='$id'";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
$flag=0;
echo "<h1><b><center><blink><font color=\"red\">This is Not valid Customer Account No. !!!</b></h1></blink></font>";
echo "<center><b>Just Check it and Try agian ..........";
} else {
echo "<table width=\"100%\" valign=\"top\">";
echo "<th bgcolor=\"red\" colspan=\"3\" align=\"center\"><font color=\"white\">General Information</font>";
for($j=1; $j<=pg_NumRows($result); $j++) {
$row=pg_fetch_array($result,($j-1));
//h=".$row['customer_id']."&
echo "<tr><td>Customer Id: <b>".$row['customer_id']."<td  valign=\"center\"> <b><font size=\"2\" color=\"Green\">Land :</font></b>"."[<A HREF=\"../land/land_statement.php?menu=ln&customer_id=$id\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=120,left=150, width=1000,height=600'); return false;\">".getAcer(getLand($row['customer_id']))."</a>]"."</B><td>Date of Opening: <b>".$row['date_of_opening']."</b><br>";//here we use getLand fu to get al

$member_id=getMemberId($id);
$type_of_customer=trim($row['type_of_customer']);
$customer_type=getCustomerType($type_of_customer);
if($member_id==null){
echo "<tr><td valign=\"top\">Type of customer: <b>".$customer_type;
}
else{
    $account_no=$member_id;
    echo "<tr><td>Membership No.:$member_id <b><a href=\"#\"</a></B>";
    echo "<td valign=\"top\">Type of customer: <b>".$customer_type;
    // $account_no=$member_id;
    share_current_balance($account_no,$no,$val,date('Y/m/d'));
    echo "<td valign=\"top\">Value of Share: <b>Rs.".$val;
}
// here change
if (($type_of_customer=="so")or ($type_of_customer=="nr") or ($type_of_customer=="st") or ($type_of_customer=="ot"))
    {
      echo "<br><tr><td>Shri/Smt. <b>".ucwords($row['name1'])."</b>";

      // here change
      echo "<font size=\"-1\">[<a href=\"../customer/signature.php?A=".$row['customer_id']."\">photo & sig.</a>][<a href=\"document.php?A=".$row['customer_id']."\">Document</a>][<a href=\"../general/nominy.php\">Nominy.</a>]</font>";

	 echo "<br><tr><td>Father/Hus. <b>".ucwords($row['father_name1'])."</b>";

      echo  "<br>".ucwords($row['address11']).",".ucwords($row['address12'])."<br>".ucwords($row['address13']).", PIN ".$row['pin1'];
      echo "<br>Voter Card No. :".$row['voter_id_no1'];
      echo "<br>Pan Card No. :".$row['pan_card_no1'];
    }

else{
   if($type_of_customer=="jn" ||$type_of_customer=="or"){
      if($type_of_customer=="jn")
  	 {
  	 echo "<br><tr><td>Shri/Smt. <b>".ucwords($row['name1'])."</b><font size=\"-1\">";

   	 // here change
   	 echo "[<a href=\"signature.php?A=".$row['customer_id']."\">photo & sig.</a>][<a href=\"large_signature.php?A=".$row['customer_id']."\">Document</a>][<a href=\"../general/nominy.php\">Nominy.</a>]</font>";
	 echo "<br><tr><td>Father/Hus. <b>".ucwords($row['father_name1'])."</b>";

   	 echo  "<br>".ucwords($row['address11']).",".ucwords($row['address21'])."<br>".ucwords($row['address31']).", PIN ".$row['pin1'];
   	 echo "<br>Voter Card No. :".$row['voter_id_no1'];
	}
    if($type_of_customer=="or"){
	 echo "<br><tr><td>Organisation: <b>".ucwords($row['name1'])."</b>";

   	 echo  "<br>".ucwords($row['address11']).",".ucwords($row['address12'])."<br>".ucwords($row['address13']).", PIN ".$row['pin1'];
        }
   	 echo "<br>Pan Card No. :".$row['pan_card_no1'];
 //--------------for second name holder-----------
   	 echo "<td>Shri/Smt. <b>".ucwords($row['name2'])."</b>";
   	 echo "[<a href=\"signature.php?A=".$row['customer_id']."\">photo & sig.</a>] ";
   	 echo  "<br>".ucwords($row['address12']).",".ucwords($row['address22'])."<br>".ucwords($row['address32']).", PIN ".$row['pin2'];
    	 echo "<br>Voter Card No. :".$row['voter_id_no2'];
   	 echo "<br>Pan Card No. :".$row['pan_card_no2'];
//------------for third name holeder -------------------
 if(!empty($row['name3']))
  {
   echo "<td>Shri/Smt. <b>".ucwords($row['name3'])."</b>";
   echo "[<a href=\"signature.php?A=".$row['customer_id']."\">photo & sig.</a>] ";
   echo  "<br>".ucwords($row['address13']).",".ucwords($row['address23'])."<br>".ucwords($row['address33']).", PIN ".$row['pin3'];
   echo "<br>Voter Card No. :".$row['voter_id_no3'];
   echo "<br>Pan Card No. :".$row['pan_card_no3'];
   }
 }
 if($type_of_customer=="gp"||$type_of_customer=="jl"){
	echo "<tr><td>Group Name: <b>".ucwords($row['name1'])."</b>";
	echo  "<br>".ucwords($row['address11']).",".ucwords($row['address12'])."<br>".ucwords($row['address13']).", PIN ".$row['pin1'];
	getSHGInfo($id,$no_of_member,$leader,$group_id);
   	echo "<br>Leader :<b>".ucwords($leader);
   	echo "</b><br>No. of Member:".$no_of_member;
	echo "<td>Group No.: <b>".$group_id."</b>";
       }
    }
 }
echo "</table>";
$flag=1;
}
return $flag;
}
//-----------------------------------------------------------------------------------
function getCustomerType($id){
//echo "type of customer id:$id";
switch($id){
case "so":
$customer_type= "Sole Account";
//echo "type of customer:$customer_type";
break;
case "jn":
$customer_type="Joint Account";
break;
case "or":
$customer_type="Organisational";
break;
case "gp":
$customer_type="Self Help Group";
break;
case "jl":
$customer_type="Joint Librability Group";
break;
case "nr":
$customer_type="NREGS";
break;
case "ot":
$customer_type="Others";
break;
}

return $customer_type;
}
//------------------------------------------------------------------------------------------
function getCustomerMode($id){
//echo "type of customer id:$id";
switch($id){
case "si":
$customer_mode= "Single operation";
//echo "type of customer:$customer_type";
break;
case "jo":
$customer_mode="Joint operation";
break;
case "es":
$customer_mode="Either/Survivor";
break;
}
return $customer_mode;
}
//----------------------------------------------------------------------------
function getGlCodeInterest($gl_code,$menu){
switch($menu){
	case 'sb':
		switch($gl_code){
			case 14101:
				$gl_code_int=62101;
			break;
			case 14201:
				$gl_code_int=62201;
			break;
			case 14301:
				$gl_code_int=62301;
			break;
			case 14401:
				$gl_code_int=62401;
			break;
			}
	break;
	case 'fd':
		switch($gl_code){
			case 14103:
				$gl_code_int=62103;
			break;
			case 14203:
				$gl_code_int=62203;
			break;
			case 14303:
				$gl_code_int=62303;
			break;
			case 14403:
				$gl_code_int=62403;
			break;

			case 22402:
				$gl_code_int=51402;
			break;
			}
	break;	
	case 'ri':
		switch($gl_code){
			case 14104:
				$gl_code_int=62104;
			break;
			case 14204:
				$gl_code_int=62204;
			break;
			case 14304:
				$gl_code_int=62304;
			break;
			case 14404:
				$gl_code_int=62404;
			break;

			case 22403:
				$gl_code_int=51403;
			break;
			}
	break;	
	case 'rd':
		switch($gl_code){
			case 14102:
				$gl_code_int=62102;
			break;
			case 14202:
				$gl_code_int=62202;
			break;
			case 14302:
				$gl_code_int=62302;
			break;
			case 14402:
				$gl_code_int=62402;
			break;
			case 22401:
				$gl_code_int=51401;
			break;
			}
	break;	


	
	case 'hsb':
		switch($gl_code){
			case 14105:
				$gl_code_int=62105;
			break;
			case 14305:
				$gl_code_int=62305;
			break;
			
			}
	break;	


	case 'mis':
		switch($gl_code){
			case 14106:
				$gl_code_int=62106;
			break;
			case 14206:
				$gl_code_int=62206;
			break;
			case 14306:
				$gl_code_int=62306;
			break;
			case 14406:
				$gl_code_int=62406;
			break;
			}
	break;	

	}
return $gl_code_int;
}
//---------------------------------------------------------------------------------------------
function RegetIndex($element_array,$element){
	while(list($key,$val)=each($element_array)){
		if(!strcmp($element,$key)) { return $val; }
	}
}
//----------------------------------sujoy--------------------------------------
function getShareValue($member_id)
{
$sql_statement="SELECT sum(amount) as total FROM gl_ledger_dtl WHERE account_no='$member_id'";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0) {
 $flag=pg_result($result,'total');
}
return $flag;
}
//--------------------------------------sujoy--------------------------------------
function makeSelectdesign($element_array,$element,$default){

	echo "<SELECT name=\"".$element."\">";
	
	if(!empty($default)){
		echo "<option>".$default;
	}
	
	while(list($key,$val)=each($element_array)){
		if($val!=$default){
			//echo "<option>"sujoy;
			echo "<option>".$val;
			//return $val;
		}
		//return $val;
	}
	echo "</select>";
}
//=============================================================================================
function getGLCodeLoanInterest($gl,$type){

if($type=='d'){
 	switch($gl){
	case '23103':
	case '23104':
	$i_gl_code="52103";
	break;

	case '23101':
	case '23102':
	$i_gl_code="52101";
	break;

	case '23105':
	case '23106':
	$i_gl_code="52105";
	break;
	case '23107':
	case '23108':
	$i_gl_code="52107";
	break;
	case '23109':
	case '23110':
	$i_gl_code="52109";
	break;
	case '23113':
	case '23114':
	$i_gl_code="52113";
	break;
	case '23115':
	case '23116':
	$i_gl_code="52115";
	break;
	case '23119':
	case '23120':
	$i_gl_code="52119";
	break;
	case '23211':
	case '23212':
	$i_gl_code="52211";
	break;
	case '23205':
	case '23206':
	$i_gl_code="52205";
	break;
	case '23207':
	case '23208':
	$i_gl_code="52207";
	break;
	case '23213':
	case '23214':
	$i_gl_code="52213";
	break;
	case '23215':
	case '23216':
	$i_gl_code="52215";
	break;
	case '23219':
	case '23220':
	$i_gl_code="52219";	
	break;
	case '23225':
	case '23226':
	$i_gl_code="52225";

	break;
	case '23401':
	case '23402':
	$i_gl_code="52401";
	break;

	case '23201':
	case '23202':
	$i_gl_code="52201";
	break;

        case '23125':
	case '23126':
	$i_gl_code="52125";
	break;

	case '23121':
	case '23122':
	$i_gl_code="52121";
	break;

	case '23123':
	case '23124':
	$i_gl_code="52123";
	break;

	case '23117':
	case '23118':
	$i_gl_code="52117";
	break;


	case '23305':
	case '23306':
	$i_gl_code="52305";
	break;

	case '23307':
	case '23308':
	$i_gl_code="52307";
	break;

	case '23301':
	case '23302':
	$i_gl_code="52301";
	break;
	}
}
if($type=='o'){
	switch($gl){
	case '23103':
	case '23104':
	$i_gl_code="52104";
	break;

	case '23101':
	case '23102':
	$i_gl_code="52102";
	break;
	case '23105':
	case '23106':
	$i_gl_code="52106";
	break;
	case '23107':
	case '23108':
	$i_gl_code="52108";
	break;
	case '23109':
	case '23110':
	$i_gl_code="52110";
	break;
	case '23113':
	case '23114':
	$i_gl_code="52114";
	break;
	case '23115':
	case '23116':
	$i_gl_code="52116";
	break;
	case '23205':
	case '23206':
	$i_gl_code="52206";
	break;
	case '23211':
	case '23212':
	$i_gl_code="52212";
	break;
	case '23213':
	case '23214':
	$i_gl_code="52214";
	break;
	case '23215':
	case '23216':
	$i_gl_code="52216";
	break;
	case '23207':
	case '23208':
	$i_gl_code="52208";
	break;
	case '23219':
	case '23220':
	$i_gl_code="52220";
	break;
	case '23401':
	case '23402':
	$i_gl_code="52402";
	break;
	case '23201':
	case '23202':
	$i_gl_code="52202";
	break;
        case '23125':
	case '23126':
	$i_gl_code="52126";
	break;
	case '23119':
	case '23120':
	$i_gl_code="52120";
	break;
	case '23121':
	case '23122':
	$i_gl_code="52122";
	break;
	case '23123':
	case '23124':
	$i_gl_code="52124";
	break;
		
	case '23225':
	case '23226':
	$i_gl_code="52226";
	break;
	case '23117':
	case '23118':
	$i_gl_code="52118";
	break;


	case '23305':
	case '23306':
	$i_gl_code="52306";
	break;

	case '23307':
	case '23308':
	$i_gl_code="52308";
	break;

	case '23301':
	case '23302':
	$i_gl_code="52302";
	break;
	}

 }
return $i_gl_code;
}
// For Depreciation 
function makeSelectpost($element_array,$element,$default){

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

//
?>

