<?
include "../config/config.php";
$c_id=$_REQUEST['cust_id'];
$c_name=$_REQUEST['nm'];
$c_fa_name=$_REQUEST['fa_name'];
$s=$_REQUEST['s'];
$current=$_REQUEST['c'];
echo "<head>";
?>
<SCRIPT>
function f2(str){
a=str.split('|')
//alert(a[0]+"c_id->"+a[1])
showcrop(a[0],a[1])
}
</SCRIPT>
<?
//echo $c_id;
echo "<title>Mini Report";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script language=\"JavaScript\" src=\"../JS/loading_mini.js\" type=\"text/javascript\"></script>";
echo "</head>";
$sql="select * from LC_Season_Master
where current_date between Season_start_dt and Season_end_dt";
$res=dBConnect($sql);
$season_id=pg_result($res,'id');
$str=$season_id."|".$c_id;
//echo $str;
echo "<body bgcolor=\"#C8A7E0\" onload=\"f2('$str');\">";
if(empty($s)){
echo"<table valign=\"top\" width='100%' bgcolor='#DFB0DA'>"; 
echo"<tr><th colspan='6' bgcolor='#C292BD' align='center'><font color='white'>*Customer Mini Opening Information*</font></td></tr>";

echo"<tr bgcolor='silver'><td>Farmer's Id : </td><td>$c_id</td><td>Farmer's Name :</td><td>$c_name</td><td>Father's Name : </td><td colspan=''>$c_fa_name</td></tr></table>";
echo"<table width='100%'><tr><th bgcolor='#7C70B9'><font size='3' color='#C7BCFE'>Select Season :</th>";
$seas_sql="select * from lc_season_master";
$seas_res=dBConnect($seas_sql);
//echo"<select name='season' onchange=\"f2(this.value);\"><option value=''>Select</option><option value='a"."|".$c_id."'>All</option>";
for($j=0;$j<pg_NumRows($seas_res);$j++){
$row=pg_fetch_array($seas_res,$j);
//echo"<option value=".$row['id']."|".$c_id.">".$row['season_desc']."</option>";
if($season_id==$row['id'])
echo"<td bgcolor='#7C70B9' align='center'><input type='radio' checked name='season' value='".$row['id']."|".$c_id."' onclick=\"f2(this.value);\">".$row['season_desc']."<br><font color='#C1F4F8'>(".$row['season_start_dt']." - ".$row['season_end_dt'].")</td>";
else
echo"<td  bgcolor='#7C70B9' align='center' ><input type='radio' name='season' value='".$row['id']."|".$c_id."' onclick=\"f2(this.value);\">".$row['season_desc']."<br><font color='#C1F4F8'>(".$row['season_start_dt']." - ".$row['season_end_dt'].")</td>";
}
echo"<td align='center' bgcolor='#7C70B9' ><input type='radio' name='season' value='a"."|".$c_id."' onclick=\"f2(this.value);\"> All<br><font color='#C1F4F8'>2013-2014</td></tr>";
}
echo"<tr><td  colspan='8'><span id=\"textHint\"></span></td></tr>";
if($s){
$c_id=$_REQUEST['c_id'];

if($s=='a'){
$sql="select * from lc_season_master order by season_start_dt";
$res=dBConnect($sql);
$td=pg_NumRows($res);
$cols=5+$td;
//echo $cols;
}
else{
$sql="select * from lc_season_master where id=$s";
$res=dBConnect($sql);
$season=pg_result($res,'season_desc');
$td=pg_NumRows($res);
$cols=5+$td;
//echo $cols;
}
//echo $c_id;
echo "<br><hr><br>";
echo"<table width='100%' bgcolor='#755F85'>";
echo"<td align='center' width='10%'bgcolor='#BA97D4' rowspan='2'><font color='000033'>Land Id</font></td>";
echo"<td align='center' width='20%'bgcolor='#BA97D4' rowspan='2'><font color='000033'>Mouja Name || JL No</font></td>";
echo"<td align='center' width='10%'bgcolor='#BA97D4' rowspan='2'><font color='000033'>Mini</font></td>";
if($s=='a'){
echo"<td align='center' width='15%'bgcolor='#BA97D4' rowspan='2'><font color='000033'>Total Land Area</font></td>";
echo"<td align='center' width='15%'bgcolor='#BA97D4' rowspan='2'><font color='000033'>Total Crop Area Value</font></td>";}
else{
echo"<td align='center' width='15%'bgcolor='#BA97D4' rowspan='2'><font color='000033'>Land Area</font></td>";
echo"<td align='center' width='15%'bgcolor='#BA97D4' rowspan='2'><font color='000033'>Crop Area Value</font></td>";

}
echo"<td align='center' bgcolor='#BA97D4' colspan='$td'><font color='000033'>Crop in Season</font></td></tr>";
echo"<tr>";
if($s=='a'){

for($j=0;$j<pg_NumRows($res);$j++)
{$row=pg_fetch_array($res,$j);
echo "<td align='center' width='8%' bgcolor='#BA97D4'>".$row['season_desc']."</td>";
}
}
else echo "<td align='center'  bgcolor='#BA97D4'>$season</td>";
echo"</td></tr>";
echo "<tr><td colspan=\"$cols\" align=center><iframe src=\"cust_crop_frame.php?c_id=$c_id&season_id=$s\" width=\"100%\" height=\"300\" ></iframe></td></tr>
</table>";
}
echo"</table>";
echo"</body>";
?>
