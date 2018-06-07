<?
include "../config/config.php";
$status=$_REQUEST['status'];
$poperator_code=verifyAutho();
$month_array_name=array(
		"jan"=>"January",
		"feb"=>"February",
		"mar"=>"March",
		"apr"=>"April",
		"may"=>"May",
		"june"=>"June",
		"july"=>"July",
		"aug"=>"August",
		"sept"=>"September",
		"oct"=>"October",
		"nov"=>"November",
		"dec"=>"December"
		);
$mnth=$_REQUEST['mnth'];
$mini=$_REQUEST['mini'];
$dat=$_REQUEST['dat'];
$amnt=$_REQUEST['amnt'];
$id=$_REQUEST['id'];
$sql="select count(*) from electric_bill where mini_id=$id";
$res=dBConnect($sql);
$exist=pg_result($res,'count');
if($exist=='0')
$sql="insert into electric_bill (mini_id,$mnth) values ($id,$amnt)";
else
$sql="update electric_bill set $mnth=$amnt where mini_id=$id";
//echo $sql;
$result=dBConnect($sql);

echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo"<body bgcolor='silver'>";
echo "<div align='center'>Bill for <b>$mini is paid for </b><b>".$month_array_name[$mnth]."</b><br>";
echo"<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme(),myRefresh('../mini/electric_bill.php')\"></div>";
echo"</body>";

?>
<script language="JAVASCRIPT">
function closeme() { 
	close(); 
}
function myRefresh(URL){
	window.opener.location.href =URL;
    	self.close();
    	}

</script>
