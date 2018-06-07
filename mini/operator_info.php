<?
include "../config/config.php";
$op=$_REQUEST['op'];
echo "<head>";
echo "<title>Personal statement";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"#85BACB\">";
$color='#B7C2CF';
?>
<style type='text/css' >
.imgClass { 
    background-image: url(submit-button-png-hi.png);
    background-position:  0px 0px;
    background-repeat: no-repeat;
    width: 32px;
    height:16px;
    border: 0px;
    background-color: none;
    cursor: pointer;
    outline: 0;
}

.imgClass:active{ 
      background-position:  0px -0px;
      width: 37px;
      height:21px;		
	}

</style>
<?
echo"<form action='operator_info.php?op=v' method='post'>";
echo"<table valign=\"top\" align='center' width='90%' bgcolor='#759696'>"; 
echo"<tr><th colspan='5' bgcolor='#759696' align='center'><font color='white'>*Operator Info*</font></td></tr>";
echo"<tr><td align='center' width='10%'bgcolor='$color' ><font color='000033'>Operator Id</font></td>";
echo"<td align='center' width='25%'bgcolor='$color' ><font color='000033'>Name</font></td>";
echo"<td align='center' width='25%'bgcolor='$color' ><font color='000033'>Address</font></td>";
echo"<td align='center' width='15%'bgcolor='$color' ><font color='000033'>Paid Amount</font></td>";
echo"<td align='center' width='25%'bgcolor='$color'><font color='000033'>Due Payment </font></td></tr>";
echo "<tr><td colspan=\"5\" align=center><iframe src=\"optr_inf_frame.php\" width=\"100%\" height=\"300\" ></iframe></td></tr>";
$sql="SELECT sum(foo.paid) as paid ,sum(foo.due) as due ,count(foo.id_operator_master)/*,initcap(om.operator_name) as name,om.address,om.id */FROM(
select sum(osd.paid_amt) as paid ,sum(osd.due_amt) as due,osd.id_mini_operator_link,mol.id_operator_master/*,om.operator_name,om.address,om.id */
from LC_Mini_Operator_Link mol,lc_operator_salary_details osd
where osd.id_mini_operator_link=mol.id
group by osd.id_mini_operator_link,mol.id_operator_master) as foo,LC_Operator_Master om
WHERE foo.id_operator_master=om.id;";
$res=dBConnect($sql);
$paid=pg_fetch_result($res,'paid');
$due=pg_fetch_result($res,'due');
$count=pg_fetch_result($res,'count');
echo"<tr><th align='center' colspan='3' bgcolor='$color'><font color='000033'>TOTAL !! $count   Operators </font></th>";
echo"<th align='center' bgcolor='$color'><font color='000033'>$paid</font></th>";
echo"<th align='center' bgcolor='$color'><font color='000033'>$due</font></th></tr>";
//echo"<th align='center' bgcolor='$color'><font color='000033'><input type='button' height=32 width=16 class=\"imgClass\" ></font></th>";
echo"</table>";

echo"</body>";
?>
