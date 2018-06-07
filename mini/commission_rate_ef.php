<?
include "../config/config.php";
$staff_id=verifyAutho();
$time=date('d/m/Y H:i:s');
$op=$_REQUEST['op'];
$customer_id=$_REQUEST['id'];
$menu=$_REQUEST['menu'];
$type=trim($_REQUEST['type']);
$comm_rt=$_REQUEST['comm_rt'];
$opr_sal_rt=$_REQUEST['opr_sal_rt'];
$op_dt=$_REQUEST['op_dt'];
echo "<HTML><head>";
?>
<script language="javascript">

function val(f)
{
var d=parseInt(document.getElementById('op_dt').value.length);
if(d < 6)
	{
alert("You Must enter date");
return false;
	}
else{
 
var opd=document.getElementById('op_dt').value; 
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

var e=parseInt(document.getElementById('comm_rt').value.length);
//alert(d%4);
if(e == 0)
	{
alert("You Must enter Commision Rate");
return false;
	}
}

</script>
<?
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head><BODY bgcolor=\"silver\" onload=\"f1.wat_rt_hr.focus();\">";
echo "<center>";
echo "<font color=\"GREEN\"><H1>Commission rate master </H1></font></center>";
echo "<hr>";
echo "<table width=\"85%\" bgcolor=\"#F5F5DC\" align=\"CENTER\">";
echo "<tr><th colspan=\"5\" bgcolor=green><b><font color=White>Commission rate entry form</font></b></th>";
echo "<form name=\"f1\" method=\"POST\" action=\"commission_rate_ef.php?menu=$menu&op=i\" onsubmit=\"return val(this.form);\">";
echo "<tr><td align=\"left\"><font color=red size=\"2\">*</font>Commission rate:<input type=\"TEXT\" name=\"comm_rt\" id=\"comm_rt\" size=5 value=\"\" $HIGHLIGHT>";
//echo "<td align=\"left\"><font color=red size=\"2\">  *</font>Operator salary % rate :<input type=\"TEXT\" name=\"opr_sal_rt\" size=5 value=\"\" $HIGHLIGHT>";
echo "<td align=\"left\"><font color=red size=\"2\">*</font>With effect from:<input type=\"TEXT\" name=\"op_dt\" id=\"op_dt\" size=\"10\" value=\"".date('d/m/Y')."\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"date1\" value=\"...\" onclick=\"showCalendar(f1.op_dt,'dd/mm/yyyy','Choose Date')\">";
echo "<tr><td><td><input type=submit value=Submit align=\"right\">&nbsp;";
echo "<input type=\"RESET\" name=\"RESET_BUTTON\" value=\"Reset\"><br>";
echo "<tr><td><label align=\"right\"><font color=red size=\"2\">'*' marked filleds are mandetory.</font></label>";
//echo "<input type=Button value=Return onClick=\"Location.href='customer_statement.php?id=$customer_id'\"> ";
echo "</form>";
echo "</table>";
if($op=='i')
{
$sql_statement="select LC_Operator_Commission_Master_Vld_Fnc('$op_dt') as vld";
		$result=dBConnect($sql_statement);
		$row=pg_NumRows($result);
		if(pg_NumRows($result)>0)
			{
			
				$return=pg_result($result,'vld');
				//echo $return;
			}
				$return="1";  
		if($return!=0)
			{
			//$sql_statement="SELECT LC_Operator_Commission_Master_Save_Fnc($comm_rt,'$op_dt','$staff_id','$time')";
			$id_s="select nextval('seq_LC_Operator_Commission_Master')";
			$id_res=dBConnect($id_s);
			$com_id=pg_result($id_res,'nextval');
			$sql_statement="INSERT INTO lc_operator_commission_master (id , operator_comm_rate , with_effect_from , operator_code , entry_time) 				values ($com_id,$comm_rt,'$op_dt','$staff_id','$time')";
			//echo $sql_statement;		
			$result=dBConnect($sql_statement);
			if(pg_affected_rows($result)>0)
				{
				echo "<h4><font color=GREEN>Data inserted successfully.</font></h4>";
				}
			else
				{
				echo "<h4><font color=RED> Entry failour/font></h4>";
				}
			}
		else
			{
			echo "<h4><font color=RED>Duplicate entry / with effect from can not be less than existing with effect from date</font></h4>";
			}

}
echo "<hr>";
$sql_statement="select * from LC_Operator_Commission_Master order by with_effect_from";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<center>";
echo "<h4><font size=5 color=green>Please enter Commission rate !!!</font></h4>";
echo "</center>";
} 
else 
{
echo "<table width=\"100%\">";
echo "<tr><td bgcolor=\"green\" colspan=\"9\" align=\"center\"><font color=\"white\"><b>Commission rate list</b></font>";
// Place line comments if you do not need column header.
$color="green";
echo "<tr>";
echo "<th bgcolor=$color colspan=\"1\"><font color=\"white\">Id</font></th>";
echo "<th bgcolor=$color colspan=\"1\"><font color=\"white\">Rate</font></th>";
//echo "<th bgcolor=$color colspan=\"1\"><font color=\"white\">Operator %</font></th>";
echo "<th bgcolor=$color colspan=\"1/font color=\"white\">Effect date</font></th>";
$color=$TCOLOR;

for($j=0; $j<pg_NumRows($result); $j++) 
{
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	echo "<tr>";
	//echo "<td bgcolor=$color><a href=\"../customer_statement.php?menu=$menu&id=".$row['customer_id']."\" target=\"_blank\">".$row['customer_id']."</a></td>";id | operator_name | address | join_date  
	echo "<td bgcolor=$color>".ucwords($row['id'])."</td>";
	echo "<td bgcolor=$color align=\"middle\">".ucwords($row['operator_comm_rate'])."</td>";
	//echo "<td bgcolor=$color align=\"middle\">".ucwords($row['operator_rate_percent'])."</td>";
	echo "<td bgcolor=$color align=\"middle\">".ucwords($row['with_effect_from'])."</td>";
	//echo "<td align=center bgcolor=$color><a href=\"../mini_ac_open_ef.php?menu=$menu&op=c&id=$id&account_no=$account_no\" target=\"parent\">Show</td>";
}
echo "<tr>";
$color="cyan";
//echo "<td align=center bgcolor=$color colspan=\"9\"><b>Total:  $j Account  !!!!!!</b></td>";
echo "</table>";
}

echo "</body>";
echo "</HTML>";
?>
