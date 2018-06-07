<?
include "../config/config.php";
$staff_id=verifyAutho();
$subhdr=$_REQUEST['sub_hdr'];
if(empty($subhdr))
{ echo"<font color='red'>Please Select GL Sub Header Code</font>";}
else{
$sql_statement="select * from  gl_master where gl_sub_header_code='$subhdr'";
//echo $sql_statement;
$result=dBConnect($sql_statement);
$row=pg_fetch_array($result,0);
echo "GL Mas Code :";
if(pg_NumRows($result)>0)
{
	echo"<select  name='gl_mas_cd' id=\"gl_mas_cd\">";
		for($j=0;$j<pg_NumRows($result);$j++)
		{$row=pg_fetch_array($result,$j);
		echo"<option value=".$row['gl_mas_code'].">".ucwords($row['gl_mas_desc'])."[".$row['gl_mas_code']."]</option>";
		}
	echo"</select>";
}
else
{
	echo "NOT FOUND !!";
}
}

?>
