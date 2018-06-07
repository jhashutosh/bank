<?
include "../config/config.php";
$staff_id=verifyAutho();
$op=$_REQUEST['op'];
$customer_id=$_REQUEST['id'];
$menu=$_REQUEST['menu'];
$mininm=$_REQUEST['mininm'];
$op_dt=$_REQUEST['op_dt'];

$operator_name=$_REQUEST['operator_name'];
$mini_name=$_REQUEST['mini_name'];


$type=trim($_REQUEST['type']);
//$x=setminimaster('$id','$op_dt');
$sql_statement="SELECT setminioperatordetails('$mini_name','$operator_name','$op_dt') as integer";
//$result1=dBConnect($sql_statement);

//$sql_statement="SELECT setminimaster('$mininm','$op_dt')";
echo $sql_statement;
  //$sql_statement=$sql_statement."SELECT * FROM tmp_deposit_info WHERE account_no='$account_no' AND certificate_no='$certificate_no'";
  //$result1=dBConnect($sql_statement);
//echo $result1;
  /*if(pg_NumRows($result1)>0){
  $days=pg_result($result1,'days');
  $interest=pg_result($result1,'interest_amount');
  $maturity_rate=pg_result($result1,'rate_of_interest');
  $withdral_amount=pg_result($result1,'maturity_amount');
  $maturity_type=pg_result($result1,'maturity_type');
  }*/

echo "<HTML>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<BODY bgcolor=\"silver\" onload=\"op_dt.focus();\">";
/*if(empty($op)){
$flag=getGeneralInfo_Customer($id);
}
else{
$name="Bank Id :";
$flag=$flag=getBankInfo($id,$menu);
}
*/
echo"<hr>";
//echo "<table width=\"95%\" bgcolor=\"#F5F5DC\" align=\"CENTER\">";
//echo"<center>";
//echo"<font color=\"GREEN\"><H1>MINI MASTER </H1></font></center>";
//echo "<tr><th colspan=\"4\" bgcolor=green><b><font color=White>".$type_of_account1_array[trim($type)]." MINI Master Form</font></b></th>";
echo "<form name=\"f1\" method=\"POST\" action=\"mini_ac_open_evf.php?menu=$menu&op=$op\">";
//echo "<center><h1><font color=GREEN>Mini Number ". $mininm." Starting Date is : $op_dt</font></h1></center>";
echo"<h4>$mininm</h4>" ;
//echo ;

//echo "<tr><td><td align=RIGHT colspan=3><input type=submit value=Submit>&nbsp;";
//echo "  <input type=\"RESET\" name=\"RESET_BUTTON\" value=\"Reset\"><br>";
//echo "<input type=Button value=Return onClick=\"Location.href='customer_statement.php?id=$customer_id'\"> ";
//$x=setminimaster('$id','$op_dt');
echo "</form>";
echo "</table>";
?>*/
 <script language="JavaScript" type="text/javascript">
 var frmvalidator  = new Validator("f1");
 frmvalidator.addValidation("mininm","req","Please enter MINI Name");
</script>
<?
echo "</body>";
echo "</HTML>";
?>
