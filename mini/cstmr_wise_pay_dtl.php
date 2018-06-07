<?
include "../config/config.php";
$op=$_REQUEST['op'];
$frmr_nm=$_REQUEST['frmr_nm'];
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
alert("You must select customer's name")
return false;
}
}
</SCRIPT>
<?
echo "<body bgcolor=\"lightblue\">";
echo"<form action=\"cstmr_wise_pay_dtl.php\"  method='post' onsubmit=\"return select();\">";
echo"<table valign=\"top\" align='center' width='70%' bgcolor='#628784'>"; 
echo"<tr><th colspan='3' bgcolor='#628784' align='center'><font color='white'>*Customer Wise Bill Payment Details*</font></td></tr>";
echo"<tr bgcolor='#628784'><td colspan='1' bgcolor='#628784' align='right'><font color='white'>Select Customer Name</font></td>";

echo "<td align='left' colspan='1'><select name=\"frmr_nm\" id='frmr_nm'onChange=\"select()\" onKeyup=\"select()\"> <option value=''> Select</option>";
$sql="select distinct(initcap(c.name1)) as name1,c.customer_id from customer_master c,lc_mini_customer_link l where c.customer_id=l.id_customer_master";
$res=dBConnect($sql);
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);

echo"<option value=".$row['customer_id'].">".$row['name1']."</option>";
}

echo"</select></td><td  colspan='1' align='left'><input type='submit' name='submit' value='ok' onChange=\"select()\" onKeyup=\"select()\"></td></tr></table>";

if(!empty($frmr_nm)){
$cust_id=$_REQUEST['frmr_nm'];
$sql="select distinct(initcap(c.name1)) as name1 from customer_master c where c.customer_id='$cust_id'";
$res=dBConnect($sql);
$row=pg_fetch_array($res,0);
$name=$row['name1'];
echo"<table width='90%' align='center'><tr><td  colspan='1' align='center'bgcolor='#628784'><font color='white'>Customer Name:</td><td  colspan='1' align='center'bgcolor='#628784'><font color='white'>$name</td><td  colspan='1' align='center'bgcolor='#628784'><font color='white'>Customer Id:<td  colspan='1' align='center'bgcolor='#628784'><font color='white'>$cust_id</td>";
echo"<table width='90%' align='center'>";
//echo"<tr><td align='center' bgcolor='#628784' width='10%'><font color='000033'>Customer Id</font></td>";
//echo"<td align='center' bgcolor='#628784'  width='20%'><font color='000033'>Customer Name</font></td>";
echo"<td align='center' bgcolor='#628784'  width='5%'><font color='000033'>Bill No.</font></td>";
echo"<td align='center' bgcolor='#628784'  width='10%'><font color='000033'>Bill Date</font></td>";
echo"<td align='center' bgcolor='#628784'  width='15%'><font color='000033'>Total Amount</font></td>";
echo"<td align='center' bgcolor='#628784'  width='15%'><font color='000033'>Paid Amount</font></td>";
echo"<td align='center' bgcolor='#628784'  width='10%'><font color='000033'>Due Amount</font></td>";
echo"<td align='center' bgcolor='#628784'  width='10%'><font color='000033'>OverDue Amount</font></td>";
echo"<td align='center' bgcolor='#628784'  width='25%'><font color='000033'>Balance Amount</font></td>";
echo "<tr><td colspan=\"7\" align=center><iframe src=\"cust_wise_frame.php?frmr_nm=$frmr_nm\" width=\"100%\" height=\"200\" ></iframe></td></tr>";
echo "<tr><td align='center' colspan='2'bgcolor='#628784' ><font color='000033'>Total</td>";
echo "<td align='center' bgcolor='#628784' ><font color='000033'></td>";
echo "<td align='center' bgcolor='#628784' ><font color='000033'></td>";
echo "<td align='center' bgcolor='#628784' ><font color='000033'></td>";
echo "<td align='center' bgcolor='#628784' ><font color='000033'></td>";

echo "<td align='center' bgcolor='#628784' ><font color='000033'></td></tr>";
}
echo"</form></table></body>";
?>
