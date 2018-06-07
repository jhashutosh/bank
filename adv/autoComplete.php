<?php
include "../config/config.php";
$staff_id=verifyAutho();
$input = strtolower($_GET['input']);
$len = strlen($input);
$op=trim($_SESSION['op']);
if($op=='c')
$sql_statement="select * from (SELECT customer_id as id,initcap(name1) as name FROM customer_master) as foo where ";
if($op=='v')
$sql_statement="SELECT * FROM retail_master WHERE type='V' and ";
$aResults = array();
if ($len)
	{
	$sql_statement.="upper(name) LIKE upper('%$input%')";
	$result=dBConnect($sql_statement);
	for($i=0; $i<pg_NumRows($result); $i++){
	$row=pg_fetch_array($result,$i);
	$id=$row['name']."[".$row['id']."]";
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
