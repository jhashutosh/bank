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
$id=$_REQUEST['id'];
echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "</head>";
echo"<body bgcolor='silver'>";
echo "<form method=\"POST\" action=\"electric_bill_add.php?mnth=$mnth&mini=$mini&id=$id\" name=\"f1\">";
echo"<table width='100%' bgcolor='grey'>";
echo"<tr>";
echo"<th bgcolor='#cacaca' colspan='2' >Mini-Name:$mini For";
echo"&nbsp;Month:".$month_array_name[$mnth]."</th></tr>";
echo"<tr><td></td></tr>";
echo"<tr><td align='center'>Amount:<input type='text' name='amnt'></td><td align='center'>Date:<input type='text' name='dat'>&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.dat,'dd/mm/yyyy','Choose Date')\" ></td></tr>";
echo"<tr><td align='right' colspan='2'><input type='submit' value='Save'></td></tr>";
echo"</body>";


?>
