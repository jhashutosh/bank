<?
include "../config/config.php";
$staff_id=verifyAutho();
$type=$_REQUEST['type'];
echo "<html>";
echo "<head>";
echo "<title>Voucher";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "sujoy";
echo "$type";
$color="#00CED1";
echo "<table align=center width=100% bgcolor=silver>";
echo "<tr><th colspan=12 bgcolor=green><font color=white size=6>Investment of $type Deposit</font></th>";
echo "<tr bgcolor=#00BFFF><th>A/C No<th>Name of Bank<th>Opening Date<th>Maturity Date<th>Opening Amount<th>Maturity Amount<th>Maturity Interest<th>Interest Payble<th>Interest Rate<th>Days<th>MRN<th>Operator Code";
echo "</table>";
echo "</body>";
echo "</html>";


?>
