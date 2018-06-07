<?
include "../config/config.php";
$op=$_REQUEST['op'];
echo "<head>";
echo "<title>Personal statement";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
?>
<SCRIPT>
function select(){
var frm_id=document.getElementById('frmr_nm').value.length;
if(frm_id==0)
{
alert("You must select Farmer's name")
return false;
}
}
</SCRIPT>
<?
echo "<body bgcolor=\"lightblue\">";
echo"<form action='prsnl_st_frmr.php?op=v' method='post' onsubmit=\"return select();\">";
echo"<table valign=\"top\" align='center' width='70%' bgcolor='000033'>"; 
echo"<tr><th colspan='3' bgcolor='000033' align='center'><font color='white'>*Personal Statement of Farmer*</font></td></tr>";
echo"<tr bgcolor='000033'><td colspan='1' bgcolor='000033' align='right'><font color='white'>Farmer's Name</font></td>";
echo "<td align='left' colspan='1'><select name=\"frmr_nm\" id='frmr_nm'onChange=\"select()\" onKeyup=\"select()\"> <option value=''> Select</option>";
$sql="select c.name1,c.customer_id from customer_master c,lc_mini_customer_link l where c.customer_id=l.id_customer_master";
$res=dBConnect($sql);
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
//echo $sql;
echo"<option value=".$row['customer_id'].">".$row['name1']."</option>";
}
echo"</select></td><td  colspan='1' align='left'><input type='submit' name='submit' value='ok' onChange=\"select()\" onKeyup=\"select()\"></td></tr></table>";
echo"</form>";
if($op){

$frmr_id=$_REQUEST['frmr_nm'];
echo"<table width='100%'>";
echo"<tr><td align='center' width='15%'bgcolor='66CCFF' ><font color='000033'>Date</font></td>";
echo"<td align='center' width='15%'bgcolor='66CCFF' ><font color='000033'> Paid Amount</font></td>";
echo"<td align='center' width='20%'bgcolor='66CCFF' ><font color='000033'>Mini Usage Amount</font></td>";
echo"<td align='center' width='15%'bgcolor='66CCFF'><font color='000033'>Due Amount</font></td>";
echo"<td align='center' width='15%'bgcolor='66CCFF' ><font color='000033'>OverDue Amount</font></td>";
echo"<td align='center' width='20%'bgcolor='66CCFF' ><font color='000033'>Balance Amount</font></td>";
echo "<tr><td colspan=\"6\" align=center><iframe src=\"frmr_frame.php?c=$frmr_id\" width=\"100%\" height=\"200\" ></iframe></td></tr>";
echo "<tr><td align='center' width='15%'bgcolor='66CCFF' ><font color='000033'>Total</td>";
echo "<td align='center' width='15%'bgcolor='66CCFF' ><font color='000033'>Amount Total</td>";
echo "<td align='center' width='20%'bgcolor='66CCFF' ><font color='000033'>Mini Usage Total</td>";
echo "<td align='center' width='15%'bgcolor='66CCFF' ><font color='000033'></td>";
echo "<td align='center' width='15%'bgcolor='66CCFF' ><font color='000033'></td>";
echo "<td align='center' width='20%'bgcolor='66CCFF' ><font color='000033'>Balance Amount Total</td></tr>";
echo"</table>";}

echo"</body>";
?>
