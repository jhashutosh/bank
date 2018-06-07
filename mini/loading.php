<?
include "../config/config.php";
$q=strtolower($_REQUEST['q']);
$resp="<SELECT name=\"gl_mas_desc\" id=\"gl_mas_desc\" >";

$resp.="<option value=\"\">Select</option>";


$sql_statement="SELECT gl_mas_code,upper(gl_mas_desc) as gl_mas_desc FROM gl_master where gl_sub_header_code='$q'";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
	

	for($j=0;$j<pg_NumRows($result);$j++){
		$row=pg_fetch_array($result,$j);
		$resp.="<option value=".$row['gl_mas_code'].">".$row['gl_mas_desc']."</option>";
	}

	

	}

$resp.="</SELECT>";

echo $resp;

?>
