<?
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$customer_id=$_REQUEST['customer_id'];
$mini_id=$_GET["mini_id"];
$customer_id=getData($customer_id);
$page=$_SESSION['page'];
$inr=$_REQUEST['inr'];
if($page==1){
$sql_statement="SELECT * FROM LC_Mini_Customer_Link WHERE Id_mini_master='$mini_id' AND Id_customer_master='$customer_id'";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0) {
			$response="Invalid Customer!!!!!Customer Already Exist into Database";
			
	}
echo $response;
}
if($page==2){
$sql_statement="SELECT * FROM LC_Mini_Operator_Link WHERE id_mini_master=$mini_id AND id_operator_master=$customer_id";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0) {
			$response="Invalid Operator!!!!!Operator Already Exist into Database";
			
	}
echo $response;
}
if($page==3){

	if($inr==1){
		$sql_statement="SELECT * FROM LC_Customerwise_Miniwise_Opening_Balance WHERE id_mini_customer_link=$mini_id";
		$result=dBConnect($sql_statement);
		if(pg_NumRows($result)>0) {
			$response=pg_result($result,'amount');
			$response.=",".pg_result($result,'balance_as_on');
						
		}
	echo $response;
	}
	else{

		$sql_statement="SELECT * FROM LC_Mini_Customer_Link WHERE id_mini_master=$mini_id" ;
		//echo $sql_statement;
		$result=dBConnect($sql_statement);
		$response= "<select name=\"cust_lnk\" id=\"cust_lnk\" onchange=\"onLoad(this.value);\">";
		$response.="<option value=''>SELECT</option>";
		 	if(pg_NumRows($result)==0) {
				$response.="<option value=''>Null</option>";
				}
			else{
			      //
		   		for($j=0; $j<pg_NumRows($result); $j++) {
		    			  $row=pg_fetch_array($result,$j); 
		     			  $response.="<option value=\"".$row['id']."\">".getName('customer_id',$row['id_customer_master'],'name1','customer_master')."</option>";
		  			  }
				}
		$response.= "</select>";
		echo $response;
	}
//return $response;

}


?>







