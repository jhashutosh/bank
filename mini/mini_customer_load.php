<?
include "../config/config.php";
$staff_id=verifyAutho();
$input = strtolower($_GET['input']);
$len = strlen($input);
$page=$_SESSION['page'];
if($page==1){
	$sql_statement="SELECT name1,customer_id FROM customer_master WHERE ";
}
else{
	$sql_statement="SELECT operator_name as name1,id as customer_id FROM LC_Operator_Master WHERE ";
}
$aResults = array();
if ($len)
	{
	if($page==1){
		$sql_statement.="upper(name1) LIKE upper('$input%')";
	}
	else{
		$sql_statement.="upper(operator_name) LIKE upper('$input%')";
		}
	$result=dBConnect($sql_statement);
	for($i=0; $i<pg_NumRows($result); $i++){
	$row=pg_fetch_array($result,$i);
	$id=$row['name1']."[".$row['customer_id']."]";
	$aResults[] = array( "id"=>($i+1) ,"value"=>htmlspecialchars($id), "info"=>htmlspecialchars($desc_code));
		
		}
						
	}
	
	header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
	header ("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header ("Pragma: no-cache"); // HTTP/1.0
	if (isset($_REQUEST['json']))
	{
		header("Content-Type: application/json");
	
		echo "{\"results\": [";
		$arr = array();
		for ($i=0;$i<count($aResults);$i++)
		{
			$arr[] = "{\"id\": \"".$aResults[$i]['id']."\", \"value\": \"".$aResults[$i]['value']."\", \"info\": \"\"}";
		}
		echo implode(", ", $arr);
		echo "]}";
	}
	else
	{
		header("Content-Type: text/xml");

		echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?><results>";
		for ($i=0;$i<count($aResults);$i++)
		{
			echo "<rs id=\"".$aResults[$i]['id']."\" info=\"".$aResults[$i]['info']."\">".$aResults[$i]['value']."</rs>";
		}
		echo "</results>";
	}
?>
