<?php
include "../config/config.php";
$gl_sub_header_code=$_REQUEST['gl_sub_header_code'];
echo "<option value=\"\">Select</option>";
$sql_st="select gl_mas_code,gl_mas_desc from gl_master where gl_sub_header_code='$gl_sub_header_code' ";
$reslt=dBConnect($sql_st);
if(pg_NumRows($reslt)>0){
for($j=0;$j<pg_NumRows($reslt);$j++){
$row1=pg_fetch_array($reslt,$j);

echo"<option value=\"".$row1['gl_mas_code']."\">".$row1['gl_mas_desc']."</option>";
}}
?>
