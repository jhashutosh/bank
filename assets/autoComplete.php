<?
include "../config/config.php";
$staff_id=verifyAutho();
$op=$_REQUEST['op'];
$input = strtolower($_GET['input']);
$len = strlen($input);	
$aResults = array();
if ($len){
	//for customer
	if($op=='c'){
		$sql_statement="SELECT * FROM customer_master WHERE name1 LIKE '$input%'";
	
	$result=dBConnect($sql_statement);
	for($i=0; $i<pg_NumRows($result); $i++){
	$row=pg_fetch_array($result,$i);
	$id=$row['name1']."[".$row['customer_id']."]";
	$aResults[] = array( "id"=>($i+1) ,"value"=>htmlspecialchars($id), "info"=>htmlspecialchars($desc_code));
	        }
	   }
//for vendor
	if($op=='v'){
		$sql_statement="SELECT * FROM vendor_master WHERE v_name LIKE '$input%'";
	
	$result=dBConnect($sql_statement);
	for($i=0; $i<pg_NumRows($result); $i++){
	$row=pg_fetch_array($result,$i);
	$id=$row['v_name']."[".$row['v_code']."]";
	$aResults[] = array( "id"=>($i+1) ,"value"=>htmlspecialchars($id), "info"=>htmlspecialchars($desc_code));
	        }
	   }
  	//for material  
	 if($op=='m'){
		$sql_statement="SELECT * FROM material_master WHERE mm_stock >0 AND mm_desc LIKE '$input%'";
	
	$result=dBConnect($sql_statement);
	for($i=0; $i<pg_NumRows($result); $i++){
	$row=pg_fetch_array($result,$i);
	$id=$row['mm_desc']."[".$row['mm_code']."]";
	$desc_code="Stock[".$row['mm_stock']."]";
	
	$aResults[] = array( "id"=>($i+1) ,"value"=>htmlspecialchars($id), "info"=>htmlspecialchars($desc_code));
	        }
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
