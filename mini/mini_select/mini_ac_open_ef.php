<?
include "../config/config.php";
$staff_id=verifyAutho();
$time=date('d/m/Y H:i:s ');
$op=$_REQUEST['op'];
$id=$_REQUEST['id'];
$mm=$_REQUEST['mini_name'];
$account_no=$_REQUEST['id'];
$address11=strtolower($_REQUEST['address11']);
$pan_card_no1=$_REQUEST['pan_card_no1'];
$VILL_DEFAULT=$_REQUEST['address11'];
$menu=$_REQUEST['menu'];
$type=trim($_REQUEST['type']);
$op_dt=$_REQUEST['op_dt'];
//$mini_name=$_REQUEST['mini_name'];
echo "<HTML>";
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<BODY bgcolor=\"silver\" onload=\"op_dt.focus();\">";
//if(empty($op)){
$flag=getGeneralInfo_Customer($id);
//}
/*else{
$name="Bank Id :";
$flag=$flag=getBankInfo($id,$menu);
}*/
if($op=='i')
{
$sql_statement="SELECT setcustomerminidetails('$id','$mm','$op_dt','$staff_id','$time') as integer";
$result=dBConnect($sql_statement);
			if(pg_NumRows($result)>>0)
 	   			{
				echo "<h4><font color=GREEN>Data Inserted Successfully.</font></h4>";
 	  			 }
			else
				{
				echo "<h4><font color=RED>FAILED TO INSERT DATA INTO THE TABLE</font></h4>";
				}
}
echo"<hr>";
echo"<h3 align=\"center\"> <font color=green>Customer Mini Relation</font></h3>";
echo "<table width=\"65%\" bgcolor=\"#F5F5DC\" align=\"CENTER\">";
echo "<tr><th colspan=\"4\" bgcolor=green><b><font color=White>".$type_of_account1_array[trim($type)]." Customer mini relation</font></b></th>";
echo "<form name=\"f1\" method=\"POST\" action=\"mini_ac_open_ef.php?menu=$menu&op=i&id=$id\">";
//if($op=
echo "<tr><td align=\"left\"><font color=red size=\"2\">*</font>Mini Name:"; makeSelectSubmit4mdbminicmr('id_customer_master','mini_name','vw_mini_cust_mini_dtls_customer_mini_link',$account_no,'mini_name');
echo "<td align=\"left\"><font color=red size=\"2\">*</font>Link Date:<td><input type=\"TEXT\" name=\"op_dt\" id=\"op_dt\" size=\"10\" value=\"".date('d/m/Y')."\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"date1\" value=\"...\" onclick=\"showCalendar(f1.op_dt,'dd/mm/yyyy','Choose Date')\">";
echo "<tr><td><td align=RIGHT colspan=3><input type=submit value=Submit>&nbsp;";
//echo "<input type=Button value=Return onClick=\"Location.href='customer_statement.php?id=$customer_id'\"> ";
echo "<tr><td><label align=\"right\"><font color=red size=\"2\">'*' marked filleds are mandetory.</font></label>";
echo "</form>";
echo "</table>";

echo"<hr>";
$sql_statement="SELECT mm.Mini_name mini,cmd.Id_Mini_Master ,cmd.Link_date as ldate,cmd.Id_Customer_Master from Customer_Mini_Details cmd, Mini_Master mm where mm.Id=cmd.Id_Mini_Master and cmd.Id_Customer_Master='$account_no'";
//SELECT mm.Mini_name mini,cmd.Id_Mini_Master ,cmd.Link_date as ldate,cmd.Id_Customer_Master from Customer_Mini_Details cmd, Mini_Master mm where mm.Id=cmd.Id_Mini_Master and cmd.Id_Customer_Master='C-3';
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0) {
echo "<center>";
echo "<h4><font size=5 color=green><blink>Please enter mini details!!!</blink></font></h4>";
echo "</center>";
} 
else 
{
echo "<table width=\"100%\">";
echo "<tr><td bgcolor=\"green\" colspan=\"9\" align=\"center\"><font color=\"white\"><b>Mini list of $account_no</b></font>";
// Place line comments if you do not need column header.
$color='green';
echo "<tr>";
echo "<th bgcolor=$color><font color=\"white\">Mini</font></th>";
echo "<th bgcolor=$color colspan=\"1\"><font color=\"white\">Link date</font></th>";
echo "<th bgcolor=$color colspan=\"1\"><font color=\"white\">Water usage?</font></th>";
echo "<th bgcolor=$color colspan=\"1\"><font color=\"white\">Bill payment?</font></th>";
$color=$TCOLOR;
for($j=0; $j<pg_NumRows($result); $j++) 
{
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	echo "<tr>";
	//echo "<td bgcolor=$color><a href=\"../customer_statement.php?menu=$menu&id=".$row['customer_id']."\" target=\"_blank\">".$row['customer_id']."</a></td>";
	echo "<td bgcolor=$color align=\"middle\">".ucwords($row['mini'])."</td>";
	echo "<td bgcolor=$color align=\"middle\">".ucwords($row['ldate'])."</td>";
//<a href=\"$c_page".$row['acno']."\" 		        target=	\"_parent	\"><font color=$focolor>Matued</a>
	echo "<td align=center bgcolor=$color><a href=\"../mini/mini_water_usage.php?menu=$menu&account_no=$account_no\"	 target=\"\">Go</a></td>";
	echo "<td align=center bgcolor=$color><a href=\"../mini/water_bill_payment.php?menu=$menu&account_no=$account_no\" 	target=\"\">Go</a></td>";
}
echo "<tr>";
$color="cyan";
//echo "<td align=center bgcolor=$color colspan=\"9\"><b>Total:  $j Account  !!!!!!</b></td>";
echo "</table>";
}


?>
 <script language="JavaScript" type="text/javascript">
 var frmvalidator  = new Validator("f1");
 frmvalidator.addValidation("account_no","req","Please enter Account No.");
</script>
<?
echo "</body>";
echo "</HTML>";
?>
