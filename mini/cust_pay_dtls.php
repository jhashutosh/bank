<?
include "../config/config.php";
$op=$_REQUEST['op'];
$cust_id=$_REQUEST['cust_id'];
if($op=='i')
{
//echo'ok';
$string=$_REQUEST['string'];
$tot_paymnt=$_REQUEST['pay_amt'];
$entry_date=$_REQUEST['pay_dt'];
$op_code=verifyAutho();
$entry_time=date('d/m/Y H:i:s');

$sql_statement="select LC_Customer_Payment_Details_Upd_Fnc('$string',$tot_paymnt,'$entry_date','$op_code','$entry_time',current_date)";
$res_statement=dBConnect($sql_statement);
//echo $sql_statement;
}

echo "<head>";
echo "<title>Customer Payment";
echo "</title>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
?>
<script language="javascript">

function val(f)
{
var e=parseInt(document.getElementById('pay_amt').value.length);
//alert(d%4);
if(e == 0)
	{
alert("You Must Give Payment Amount");
return false;
	}

var d=parseInt(document.getElementById('pay_dt').value.length);
if(d < 6)
	{
alert("You Must enter date");
return false;
	}
else{
 
var opd=document.getElementById('pay_dt').value; 
var flag=0;
var i;
var opds=opd.split('');
for(i=0;i<=opd.length;i++)
	{
if(opds[i]=='/')
{
flag=1;
break;
}
if(opds[i]=='.')
{flag=2;
break;
}
if(opds[i]=='-')
{flag=3;
break;
}

	}
//alert("hello"+flag)

if(flag==1)
opdar=opd.split('/');
if(flag==2)
opdar=opd.split('.');
if(flag==3)
opdar=opd.split('-');
var leap=0;
if(parseInt(opdar[2])%4==0 && parseInt(opdar[2])%100!=0 || parseInt(opdar[2])%400==0){
leap=1;
}

if(parseInt(opdar[1])==4||parseInt(opdar[1])==6||parseInt(opdar[1])==9||parseInt(opdar[1])==11){
//alert (opdar[0]+"<-date"+opdar[1]+"<-month"+opdar[2]+"<-year")
if( parseInt(opdar[0]) < 1 ||  parseInt(opdar[0]) > 30 ||  parseInt(opdar[1]) < 1 ||  parseInt(opdar[1]) > 12 ||  parseInt(opdar[2]) > 2050 ||  parseInt(opdar[2]) < 2000 )
     
flag=4;

     }
else if(parseInt(opdar[1])==2 && leap==1 ){

if( parseInt(opdar[0]) < 1 ||  parseInt(opdar[0]) > 29 ||  parseInt(opdar[1]) < 1 ||  parseInt(opdar[1]) > 12 ||  parseInt(opdar[2]) > 2050 ||  parseInt(opdar[2]) < 2000 )
flag=5;

}

else if(parseInt(opdar[1])==2 && leap==0){

if( parseInt(opdar[0]) < 1 ||  parseInt(opdar[0]) > 28 ||  parseInt(opdar[1]) < 1 ||  parseInt(opdar[1]) > 12 ||  parseInt(opdar[2]) > 2050 ||  parseInt(opdar[2]) < 2000 )
flag=6;

} 
else {
if( parseInt(opdar[0]) < 1 ||  parseInt(opdar[0]) > 31 ||  parseInt(opdar[1]) < 1 ||  parseInt(opdar[1]) > 12 ||  parseInt(opdar[2]) > 2050 ||  parseInt(opdar[2]) < 2000 )
flag=7;

}
if(flag==4||flag==5||flag==6||flag==7){

alert("Please Enter Correct Date in dd/mm/yyyy format \n within 01/01/2000 To 31/12/2050");
return false;
}
//return false;
}


}

</script>
<?
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"lightblue\">";
$color='#66CCFF';
$TBGCOLOR="WHITE";
$TCOLOR="FFFFCC";

echo"<table valign=\"top\" align='center' width='100%' bgcolor='000033'>"; 
echo"<tr><th colspan='11' bgcolor='000033' align='center'><font color='white'>*Customer Payment Details*</font></td></tr>";

echo "<tr><td  bgcolor='$color' align='center' colspan=\"1\" rowspan='1' width='8%'><font color='black' size='2'>Land Id</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\" rowspan='1' width='10%'><font color='black' size='2'>Crop</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  rowspan='1'  width='8%'><font color='black' size='2'>Mini Name</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  rowspan='1'  width='7%'><font color='black' size='2'>Bill No</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\" rowspan='1' ><font color='black' size='2'>Bill Date</font></td>";
echo"<td align='center' width='10%' bgcolor='$color'  rowspan='1' colspan=\"1\"><font color='black'>Total Amount</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"><font color='black' size='2'>Paid Amount</font></td>";
echo"<td  bgcolor='$color' align='center' colspan=\"1\"  rowspan='1' ><font color='black' size='2'>Due Amount</font></td>";
//echo"<td  bgcolor='$color' align='center' colspan=\"1\"  rowspan='1'  ><font color='black' size='2'>OverDue Amount</font></td>";
echo"<td  bgcolor='$color' align='center' colspan=\"1\"  rowspan='1'  width='15%'><font color='black' size='2'>Balance Amount</font></td>";
echo"</tr>";
//echo"<tr><td  width='7%' align='center' bgcolor='$color' >Due</td><td  align='center' width='7%' bgcolor='$color' >Overdue</td></tr>";

$string="";

$sql="select cpd.*,mcl.id_land_info,m.mini_name,initcap(crop_desc)
from LC_Customer_Payment_Details cpd,LC_Customer_Land_Crop_Info clci,LC_mini_customer_link mcl,lc_mini_master m,lc_crop_rate_master crm,crop_mas cm
where cpd.Id_LC_Customer_Land_Crop_Info=clci.id
and m.id=mcl.id_mini_master
and clci.id_crop_rate_master=crm.id
and crm.id_crop_mas=cast(cm.crop_id as integer)
and clci.Id_mini_customer_link=mcl.id
and mcl.id_customer_master='$cust_id'
and cpd.bal_amt>0
order by cpd.bill_no";
$res=dBConnect($sql);
//echo $sql;
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
/*
$select="select crm.overdue_date,crm.Overdue_rate,case when cpd.overdue_date is null then current_date-crm.overdue_date else current_date-cpd.overdue_date end  days,
case when round(crm.Overdue_rate*case when cpd.overdue_date is null then current_date-crm.overdue_date else current_date-cpd.overdue_date end *cpd.due_amt/36500,2) >0 then round(crm.Overdue_rate*case when cpd.overdue_date is null then current_date-crm.overdue_date else current_date-cpd.overdue_date end *cpd.due_amt/36500,2) else 0 end as od_amt,cpd.id from LC_Customer_Payment_Details cpd,LC_Crop_Rate_Master crm,LC_Customer_Land_Crop_Info clci,LC_mini_customer_link mcl where crm.With_effect_from >=(select start_dt from fy_list where fy=(select max(fy) from fy_list)) and crm.With_effect_from <=(select close_dt from fy_list where fy=(select max(fy) from fy_list)) and cpd.Id_LC_Customer_Land_Crop_Info=clci.id and clci.Id_crop_rate_master=crm.id and clci.Id_mini_customer_link=mcl.id and mcl.id_customer_master='$cust_id' and cpd.id=".$row['id'];
//echo $select;
$select_res=dBConnect($select);
$od=pg_result($select_res,'od_amt');
$od_tot=$od+$row['overdue_amt'];
$bal=$row['bal_amt']+$od;
$due_paid=$row['paid_amt']-$row['overdue_paid_amt'];
*/

//echo $row['bal_amt'];
$string=$string.$row['id_lc_customer_land_crop_info'].",".$row['bill_no'].",".$row['bill_date'].",".$row['tot_amt'].",".$row['paid_amt'].",".$row['due_amt'].",".$row['bal_amt']."|";
echo"<tr><td align='center' width='8%'bgcolor='$color' ><font color='000033'>".$row['id_land_info']."</font></td>";
echo"<td align='center' width='10%'bgcolor='$color' ><font color='000033'>".$row['initcap']."</font></td>";
echo"<td align='center' width='8%'bgcolor='$color' ><font color='000033'>".$row['mini_name']."</font></td>";
echo"<th align='center' width='7%' bgcolor='$color' ><font color='000033'>".$row['bill_no']."</font></th>";
echo"<td align='center' width='10%'bgcolor='$color' ><font color='000033'>".$row['bill_date']."</font></td>";
echo"<td align='right' width='10%'bgcolor='$color' ><font color='000033'>".$row['tot_amt']."</font></td>";
$tot_amt1=$row['tot_amt'];
$tot_amt=$tot_amt+$tot_amt1;
echo"<td align='right' width='10%'bgcolor='$color'><font color='000033'>".$row['paid_amt']."</font></td>";

$paid_amt1=$due_paid;
$paid_amt=$paid_amt+$paid_amt1;
//echo"<td align='right' width='10%'bgcolor='$color' ><font color='000033'>".$row['overdue_paid_amt']."</font></td>";
//$od_paid_amt1=$row['overdue_paid_amt'];
$od_paid_amt=$od_paid_amt+$od_paid_amt1;
echo"<td align='right' width='10%'bgcolor='$color' ><font color='000033'>".$row['due_amt']."</font></td>";
$due_amt1=$row['due_amt'];
$due_amt=$due_amt+$due_amt1;
//echo"<td align='right' width='8%'bgcolor='$color' ><font color='000033'></font></td>";
//$overdue_amt1=$od_tot;
//$overdue_amt=$overdue_amt+$overdue_amt1;
echo"<td align='right' width='15%'bgcolor='$color' ><font color='000033'>".$row['bal_amt']."</font></td>";
//$bal_amt1=$bal;
$bal_amt=$bal_amt+$row['bal_amt'];

//echo"<td align='center' width='15%'bgcolor='$color' ><font color='000033'>".$row['action_date']."</font></td>";
echo"</tr>";}
//echo $string;
echo"<tr BGCOLOR='#839EB8'><td colspan='5' align='center'><b>Total !!</b></td>";
echo"<td align='right'><b>".amount2Rs($tot_amt)."</b></td>";
echo"<td align='right'><b>".amount2Rs($paid_amt)."</b></td>";
//echo"<td align='right'><b>".amount2Rs($od_paid_amt)."</b></td>";
echo"<td align='right'><b>".amount2Rs($due_amt)."</b></td>";
//echo"<td align='right'><b>".amount2Rs($overdue_amt)."</b></td>";
echo"<td align='right'><b>".amount2Rs($bal_amt)."</b></td></tr>";
echo"<input type='hidden' name='tot_bal' id='tot_bal' value='$bal_amt'>";
echo"<form name='f1' action=\"cust_pay_dtls.php?op=i&cust_id=$cust_id\" method='post' onsubmit=\"return val(this.form);\">";
echo"<input type='hidden' name='string' value='$string'>";
echo"</table><table bgcolor=\"lightblue\"><tr bgcolor=\"lightblue\"><td colspan='7'><br><br><br></td></tr></table>";
echo"<table width='100%' align='center' bgcolor='000033'><tr BGCOLOR='#839EB8' ><td colspan='1'>Payment Amount :</td><td><input type='text' name='pay_amt' id='pay_amt' value='' $HIGHLIGHT></td><td>Payment Date:</td><td><input type='text' name='pay_dt' id='pay_dt'>&nbsp;&nbsp;<input type='button' name='date' value='..' onclick=\"showCalendar(f1.pay_dt,'dd/mm/yyyy','Choose Date')\"></td></tr><tr  BGCOLOR='#839EB8' ><td colspan='4' align='right'><input type='submit' name='submit' value='Give payment'></td></tr></table>";
echo"</form>";
echo"</body>";
?>
