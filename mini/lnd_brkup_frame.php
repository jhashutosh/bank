<?
include "../config/config.php";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
$c_id=$_REQUEST['c_id'];
$c_name=$_REQUEST['nm'];
$c_fa_name=$_REQUEST['fa_name'];
$op=$_REQUEST['op'];
$mini_id=$_REQUEST['mini_id'];
$op_bal=$_REQUEST['op_bal'];
$staff_id=verifyAutho();
$e_time=date('d/m/Y H:i:s');
$paid_date=$_REQUEST['pa_dt'];
$fy=$_SESSION['fy'];
$land_id=$_REQUEST['land_id'];
getDetailFy($fy,&$f_start_dt,&$f_end_dt);
$col_array=array("#FAFC93","#9CE6D6",'#F9B770');
//echo $f_start_dt;
$d_s="select cast ('$f_start_dt'  as date) -1 as date";
$dr=dBConnect($d_s);
$as_on=pg_fetch_result($dr,'date');
//echo $d_s;
//echo $as_on;
if($op=='pay'){
$sql="select LC_Customerwise_Miniwise_Opening_Balance_Save_Fnc('$c_id',$mini_id,'$land_id',$op_bal,'$as_on','$paid_date','$staff_id','$e_time')";
$res=dBConnect($sql);
}
if($op=='op'){
$sql="select LC_Customerwise_Miniwise_Opening_Balance_Save_Fnc('$c_id',$mini_id,'$land_id',$op_bal,'$as_on',null,'$staff_id','$e_time')";
$res=dBConnect($sql);

}
//echo $sql;
//echo $c_id;
echo"<head>";
echo"<title>customer mini frame</title>";
echo "<script src=\"../JS/loading2.js\">";
echo "</script>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo"</head>";
?>
<script language="javascript">
function op_date(f){
var d=parseInt(document.getElementById('pa_dt').value.length);
if(d < 6)
	{
alert("You Must enter date");
return false;
	}
else{
 
var opd=document.getElementById('pa_dt').value; 
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

function op_val(f){
var d=parseInt(document.getElementById('op_bal').value.length);
//alert(d%4);
if(d == 0)
	{
alert("You Must enter Opening Balance");
return false;
	}

}

</script>
<?
echo"<body bgcolor='white'>";
echo"<table valign=\"top\"width='100%' align='center'>";
$color='#ABF862';
$sql="select cm.name1, l.mouja_no,l.jl_no,mm.mini_name,l.land_id,/*lc.tot_crop_area,lc.tot_crop_area_val,*/mcl.id,mcl.id_customer_master,mm.id as mini_id
from land_info l,lc_mini_customer_link mcl,customer_master cm ,lc_mini_master mm/*,lc_customer_land_crop_info lc */
where l.land_id=mcl.id_land_info 
	and mcl.id_customer_master=cm.customer_id 
	and mcl.id_mini_master=mm.id 
	/*and lc.id_mini_customer_link=mcl.id*/
	and mcl.id_customer_master='$c_id'";
$res=dBConnect($sql);
//echo $sql;
$i=0;
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
$row1=pg_fetch_array($res,$j-1);
if($row['mini_name']!=$row1['mini_name'])
{
$color=$col_array[$i];
if($i==count($col_array)-1)
$i=0;
$i++;
	
}
echo "<tr>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width='10%'><font color='black' size='2'>".$row['land_id']."</font></td>";

echo "<td  bgcolor='$color' align='center' colspan=\"1\" width='10%'><font color='black' size='2'>".$row['mouja_no']."</font></td>";

echo "<td  bgcolor='$color' align='center' colspan=\"1\" width='10%'><font color='black' size='2'>".$row['jl_no']."</font></td>";
echo "<td  bgcolor='$color' align='center' colspan=\"1\" width='10%'><font color='black' size='2'>".$row['mini_name']."</font></td>";

//echo "<td  bgcolor='$color' align='center' colspan=\"1\" width='10%'><font color='black' size='2'>".$row['tot_crop_area']."</font></td>";
//echo "<td  bgcolor='$color' align='center' colspan=\"1\" width='10%'><font color='black' size='2'>".$row['tot_crop_area_val']."</font></td>";

$op_sql="select mcl.Id,cmob.paid_date,sum(cmob.Amount) op_bal
from  LC_Mini_Customer_Link mcl, 
LC_Customerwise_Miniwise_Opening_Balance cmob
where cmob.Id_mini_customer_link=mcl.id
and   mcl.id=".$row['id']."
/*and   cmob.Balance_as_on >=(select start_dt from fy_list where fy=(select max(fy) from fy_list)) 
and   cmob.Balance_as_on <=(select close_dt from fy_list where fy=(select max(fy) from fy_list))*/
group by mcl.Id,cmob.paid_date";
//echo $op_sql;
$op_res=dBConnect($op_sql);
$op=pg_fetch_result($op_res,'op_bal');
$op_dt=pg_fetch_result($op_res,'paid_date');
$col=(empty($op_dt))?'red':'green';
$op_dis=(empty($op))?"Opening Balance":$op;
$ro=(empty($op))?"":"READONLY";
//echo $op;
if(empty($op)){
echo"<form action='lnd_brkup_frame.php?c_id=$c_id&nm=$c_name&fa_name=$c_fa_name&op=op&mini_id=".$row['mini_id']."&land_id=".$row['land_id']."' method='post'  onSubmit=\"return op_val(this.form);\">";
echo "<td  bgcolor='$color' align='center' colspan=\"1\" width='25%'>";
echo"<input type='text' name='op_bal' id='op_bal' size='5' $HIGHLIGHT $ro>";
echo"<input type='submit' value='ok'></td>";
echo"</form>";}
else{
if(empty($op_dt)){
echo"<form name='f2' action='lnd_brkup_frame.php?c_id=$c_id&nm=$c_name&fa_name=$c_fa_name&op=pay&mini_id=".$row['mini_id']."&land_id=".$row['land_id']."' method='post' onSubmit=\"return op_date(this.form);\">";
echo "<td  bgcolor='$color' align='center' colspan=\"1\" width='25%'>";
echo"<input type='text' name='op_bal' size='4' value='$op' $HIGHLIGHT $ro> Payment Date :<input type='text' name='pa_dt' id='pa_dt' size='7' $HIGHLIGHT>";
echo"<input type='submit' value='pay'></td>";
echo"</form>";
}
else
echo "<td  bgcolor='$color' align='center' colspan=\"1\" width='20%'><font color='green'>$op </font> Payment Date : $op_dt</td>";
}

echo"</tr>";
}
echo"</table></body>";
?>

