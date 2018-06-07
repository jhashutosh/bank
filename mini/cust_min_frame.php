<?
include "../config/config.php";
$col_array=array('#FFDEAD','#ABF862',"#9CE6D6",'#B3A3EB','silver');
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo"<head>";
echo"<title>customer mini frame</title>";
echo "<script src=\"../JS/loading2.js\">";
echo "</script>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo"</head>";

echo"<body bgcolor='silver'>";

echo"<form  name='f1' action='cust_min_frame.php' method='post' >";
echo"<table valign=\"top\"width='100%' align='center'>";
$sql="select mcl.Id_customer_master,initcap(custm.name1) as name1,initcap(custm.father_name1) as father_name1,
sum(clci.Tot_crop_area) crop_area,
sum(cpd.Bal_amt) bal_amt
from   LC_Customer_Land_Crop_Info clci, 
LC_Mini_Customer_Link mcl, 
customer_master custm,
LC_Customer_Payment_Details cpd
where   clci.Id_mini_customer_link=mcl.Id
and mcl.Id_customer_master=custm.customer_id 
and   cpd.Id_LC_Customer_Land_Crop_Info=clci.id
/*and   cpd.Bill_date >=(select start_dt-1 from fy_list where fy=(select max(fy) from fy_list)) 
and   cpd.Bill_date <=(select close_dt from fy_list where fy=(select max(fy) from fy_list))*/
group by mcl.Id_customer_master,custm.name1,custm.father_name1,custm.customer_id order by cast(substr(custm.customer_id,'3') as integer)";
//echo $sql;
$res=dBConnect($sql);
$TBGCOLOR="white";
$TCOLOR="#B3A3EB";
$i=0;
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
$row1=pg_fetch_array($res,$j-1);
$pnd=0;
$paid=0;
/*if($row['id_customer_master']!=$row1['id_customer_master'])
{
$color=$col_array[$i];
if($i==count($col_array)-1)
$i=0;
$i++;
	
}*/
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
echo "<tr>";
echo "<td   bgcolor='$color' align='center' colspan=\"1\"  width='8%'><font color='black' size='2'>".$row['id_customer_master']."</font></td>";

echo "<td  bgcolor='$color' align='center' colspan=\"1\" width='13%'><font color='black' size='2'>".$row['name1']."</font></td>";

echo "<td  bgcolor='$color' align='center' colspan=\"1\" width='12%'><font color='black' size='2'>".$row['father_name1']."</font></td>";

echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"10%\"><a href=\"cust_crop_dtls.php?cust_id=".$row['id_customer_master']."&nm=".$row['name1']."&fa_name=".$row['father_name1']."\" onClick=\"window.open(this.href,'_parent','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=150,left=120, width=1100,height=650'); \">".$row['crop_area']."</td>";

$op_sql=" select sum(amount),case when paid_date is null then 0 else 1 end as dt from lc_customerwise_miniwise_opening_balance ob,lc_mini_customer_link l where ob.id_mini_customer_link=l.id and l.id_customer_master='".$row['id_customer_master']."' group by  l.id_customer_master,dt";
$op_res=dBConnect($op_sql);
//echo $op_sql;
for($i=0;$i<pg_NumRows($op_res);$i++){
$r=pg_fetch_array($op_res,$i);
if($r['dt']=='0')
$pnd='Pending : '.$r['sum'];
if($r['dt']=='1')
$paid='Paid : '.$r['sum'];
}
//echo $paid;
if (!empty($r['sum']))
echo "<td  bgcolor='$color' align='center' colspan=\"1\" width='18%'><a href=\"lnd_brkup.php?c_id=".$row['id_customer_master']."&nm=".$row['name1']."&fa_name=".$row['father_name1']."\" onClick=\"window.open(this.href,'_parent','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=150,left=120, width=1100,height=650'); color='red'\"><font color='red'>$pnd</font> || <font color='green'>$paid</font></td>";
else 
echo "<td  bgcolor='$color' align='center' colspan=\"1\" width='18%'><a href=\"lnd_brkup.php?c_id=".$row['id_customer_master']."&nm=".$row['name1']."&fa_name=".$row['father_name1']."\" onClick=\"window.open(this.href,'_parent','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=150,left=120, width=1100,height=650'); color='red'\">Give Opening Balance</font></td>";


echo "<td  bgcolor='$color' align='center' colspan=\"1\"  width=\"8%\"><a href=\"cust_pay_dtls.php?cust_id=".$row['id_customer_master']."\" onClick=\"window.open(this.href,'_parent','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=150,left=120, width=1100,height=650'); \">".$row['bal_amt']."</td>";
echo"</tr>";
}
echo"</table></form></body>";
?>



