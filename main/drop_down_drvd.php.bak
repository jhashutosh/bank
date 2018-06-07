<?
include "../config/config.php";
$ratio_name=$_REQUEST['ratio_name'];
echo "<option value=\"\">Select</option>";
$sql_st="select ratio_name,id from ratio_level where id<> $ratio_name ";
$reslt=dBConnect($sql_st);
if(pg_NumRows($reslt)>0){
for($j=0;$j<pg_NumRows($reslt);$j++){
$row1=pg_fetch_array($reslt,$j);

echo"<option value=\"".$row1['id']."\" >".$row1['ratio_name']."</option>";
}}
?>
