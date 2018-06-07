<?
include "../config/config.php";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo"<head>";
echo"<title>customer_wise frame</title>";
echo "<script src=\"../JS/loading2.js\">";
echo "</script>";
$c_id=$_REQUEST['c'];
$frmr_nm=$_REQUEST['frmr_nm'];
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo"</head>";
$TBGCOLOR='#9A95F1';
$TCOLOR='#C7C6D7';
echo"<body bgcolor='grey'>";
echo"<table valign=\"top\"width='100%'align='center'>";
$sql="select mcl.id_customer_master,initcap(cm.name1) as name1,cpd.bill_no,cpd.bill_date,
sum(cpd.Tot_amt) as tot_amt,sum(cpd.Paid_amt) as paid_amt,sum(cpd.Due_amt) as due_amt,sum(cpd.Overdue_amt) as overdue_amt,sum(cpd.Bal_amt) as bal_amt
from  LC_Customer_Payment_Details cpd, LC_Customer_Land_Crop_Info clci, LC_Mini_Customer_Link mcl, customer_master cm
where cpd.Id_LC_Customer_Land_Crop_Info=clci.id
and   clci.id_Mini_Customer_Link=mcl.id
and   mcl.id_customer_master=cm.customer_id
and   mcl.id_customer_master='$frmr_nm'
and   cpd.Paid_amt>0
--and   cpd.bill_date >=(select start_dt from fy_list where fy=(select max(fy) from fy_list)) 
--and   cpd.bill_date <=(select close_dt from fy_list where fy=(select max(fy) from fy_list))
group by mcl.id_customer_master,cm.name1,cpd.bill_no,cpd.bill_date
order by mcl.id_customer_master";
$res=dBConnect($sql);
//echo $sql;
for($j=0;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;

echo "<tr>";
//echo"<tr style='height:30px'><td align='center'  width='9%'bgcolor='$color' ><font color='000033'>".$row['id_customer_master']."</font></td>";
//echo"<td align='center' width='20%'bgcolor='$color' ><font color='000033'>".$row['name1']."</font></td>";
echo"<td align='center' width='5%'bgcolor='$color' ><font color='000033'>".$row['bill_no']."</font></td>";
echo"<td align='center' width='10%'bgcolor='$color' ><font color='000033'>".$row['bill_date']."</font></td>";
echo"<td align='center' width='15%'bgcolor='$color'><font color='000033'>".$row['tot_amt']."</font></td>";
echo"<td align='center' width='15%'bgcolor='$color'><font color='000033'>".$row['paid_amt']."</font></td>";
echo"<td align='center' width='10%'bgcolor='$color' ><font color='000033'>".$row['due_amt']."</font></td>";
echo"<td align='center' width='10%'bgcolor='$color' ><font color='000033'>".$row['overdue_amt']."</font></td>";
echo"<td align='center' width='25%'bgcolor='$color' ><font color='000033'>".$row['bal_amt']."</font></td>";
echo"</tr>";

}
echo"</table></body>";
?>
