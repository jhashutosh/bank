<?
include "../../config/config.php";
$staff_id=verifyAutho();
//$menu=$_REQUEST['menu'];
$vdebit="0";
$vcredit="0";
$cldebit="0";
$clcredit="0";
$vdebit1="0";
$vcredit1="0";
echo "<html>";
echo "<head>";
echo "<title>  Trial Balance";
echo "</title>";
//echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";

echo "</head>";
echo "<body bgcolor=\"silver\">";
//echo "<form method=\"POST\" action=\"customer_account_list.php?menu=$menu\" method=\"POST\" name=f1>";
echo "<hr>";
//$sql_statement="SELECT * FROM customer_master WHERE customer_id like '%C-%'  order by cast(substring(customer_id,3) as int)";
//cast(substring(customer_id,3) as int)

$sql_statement="select a.gl_mas_code, b.gl_mas_desc, sum(debit) as debit, sum(credit) as credit, sum(debit-credit) as bal from mas_gl_tran as a , gl_master as b where a.gl_mas_code= b.gl_mas_code group by a.gl_mas_code, b.gl_mas_desc having sum(debit-credit)>0";
echo $sql_statement;
$result=dBConnect($sql_statement);

echo "<table width=\"100%\" valign=\"top\"><tr><td valign=\"top\" width=\"50%\">";
echo "<table width=\"100%\">";

echo "<tr><td bgcolor=\"green\" colspan=\"9\" align=\"center\"><font color=\"white\"><b>Trial Balance</b></font>";

// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";

//echo "<th bgcolor=$color colspan=\"1\">Code</th>";
//echo "<th bgcolor=$color colspan=\"1\">Account Name</th>";
//echo "<th bgcolor=$color colspan=\"1\">Debit</th>";
//echo "<th bgcolor=$color colspan=\"1\">Credit</th>";
//echo "<th bgcolor=$color colspan=\"1\">Balance</th>";
//echo "<th bgcolor=$color colspan=\"1\">Balance-Cr</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"10%\">Code</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"30%\">Account Name</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"20%\">Debit</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"20%\">Credit</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"20%\">Balance</th>";

for($j=0; $j<pg_NumRows($result); $j++) 
{
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	$vdebit=$vdebit+$row['debit'];
	$vcredit=$vcredit+$row['credit'];
	echo "<tr>";
	echo "<td align=left bgcolor=$color>".$row['gl_mas_code']."</td>";
	echo "<td align=left bgcolor=$color>".$row['gl_mas_desc']."</td>";
	echo "<td align=right bgcolor=$color>".$row['debit']."</td>";
	echo "<td align=right bgcolor=$color>".$row['credit']."</td>";
        if ($row['bal'] > 0)
		{
		echo "<td align=right bgcolor=$color>".$row['bal']."</td>";
		//echo "<td align=right bgcolor=$color>"."</td>"; 
		$cldebit=$cldebit+$row['bal'];
		}
	else {
		echo "<td align=right bgcolor=$color>"."</td>"; 
		//echo "<td align=right bgcolor=$color>".-$row['bal']."</td>"; 
		$clcredit=$clcredit -$row['bal'];
}

	//$result=dBConnect($sql_statement2);
	//$row=pg_fetch_array($result);
	//echo "<td align=center bgcolor=$color>".$row1['account_type']."</td>";
}
	echo "<tr>";
	echo "<td align=left bgcolor=$color> </td>";
	echo "<td align=centre bgcolor=$color>Total</td>";
	echo "<td align=right bgcolor=$color>".$vdebit."</td>";
	echo "<td align=right bgcolor=$color>".$vcredit."</td>";
		echo "<td align=right bgcolor=$color>".$cldebit."</td>";
		//echo "<td align=right bgcolor=$color>".$clcredit."</td>"; 

echo "</tr>";
$color="cyan";
echo "<td align=center bgcolor=$color colspan=\"9\"><b>Total: $j Account  !!!!!!</b></td>";
echo "</table>";
echo "</td><td>";
$sql_statement="select a.gl_mas_code, b.gl_mas_desc, sum(debit) as debit, sum(credit) as credit, sum(debit-credit) as bal from mas_gl_tran as a , gl_master as b where a.gl_mas_code= b.gl_mas_code group by a.gl_mas_code, b.gl_mas_desc having sum(debit-credit)<=0";
//echo $sql_statement;
$result=dBConnect($sql_statement);

//echo "<table width=\"100%\"><tr><td valign=\"top\">";
//echo "<td><td valign=\"top\">";

echo "<table width=\"100%\">";

echo "<tr><td bgcolor=\"green\" colspan=\"9\" align=\"center\"><font color=\"white\"><b>Trial Balance</b></font>";

// Place line comments if you do not need column header.
$color=$TCOLOR;
echo "<tr>";

echo "<th bgcolor=$color colspan=\"1\">Code</th>";
echo "<th bgcolor=$color colspan=\"1\">Account Name</th>";
echo "<th bgcolor=$color colspan=\"1\">Debit</th>";
echo "<th bgcolor=$color colspan=\"1\">Credit</th>";
echo "<th bgcolor=$color colspan=\"1\">Balance</th>";
//echo "<th bgcolor=$color colspan=\"1\">Balance-Cr</th>";

for($j=0; $j<pg_NumRows($result); $j++) 
{
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
	$vdebit1=$vdebit1+$row['debit'];
	$vcredit1=$vcredit1+$row['credit'];
	echo "<tr>";
	echo "<td align=left bgcolor=$color>".$row['gl_mas_code']."</td>";
	echo "<td align=left bgcolor=$color>".$row['gl_mas_desc']."</td>";
	echo "<td align=right bgcolor=$color>".$row['debit']."</td>";
	echo "<td align=right bgcolor=$color>".$row['credit']."</td>";
        if ($row['bal'] > 0)
		{
		//echo "<td align=right bgcolor=$color>".$row['bal']."</td>";
		//echo "<td align=right bgcolor=$color>"."</td>"; 
		$cldebit=$cldebit+$row['bal'];
		}
	else {
		//echo "<td align=right bgcolor=$color>"."</td>"; 
		echo "<td align=right bgcolor=$color>".-$row['bal']."</td>"; 
		$clcredit=$clcredit -$row['bal'];
}

	//$result=dBConnect($sql_statement2);
	//$row=pg_fetch_array($result);
	//echo "<td align=center bgcolor=$color>".$row1['account_type']."</td>";
}
	echo "<tr>";
	echo "<td align=left bgcolor=$color> </td>";
	echo "<td align=centre bgcolor=$color>Total</td>";
	echo "<td align=right bgcolor=$color>".$vdebit1."</td>";
	echo "<td align=right bgcolor=$color>".$vcredit1."</td>";
		//echo "<td align=right bgcolor=$color>".$cldebit."</td>";
		echo "<td align=right bgcolor=$color>".$clcredit."</td>"; 

echo "</tr>";

echo "</table>";

echo "</td></tr>";
echo "<tr><td align=left><table width=\"100%\"><tr> ";
echo "<th bgcolor=$color colspan=\"1\" width=\"10%\"></th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"30%\">Total</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"20%\">".$vdebit."</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"20%\">".$vcredit."</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"20%\">".$cldebit."</th>";
echo "</tr></table>";
echo "</td><td align=left><table  width=\"100%\" ><tr>";
echo "<th bgcolor=$color colspan=\"1\" width=\"10%\"></th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"30%\">Total</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"20%\">".$vdebit1."</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"20%\">".$vcredit1."</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"20%\">".$clcredit."</th>";
echo "</tr></table>";




echo "</td></tr></table>";


echo "<br>";
footer();
echo "</body>";
echo "</html>";
?>
