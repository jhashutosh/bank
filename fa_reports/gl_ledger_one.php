<?php
include "../config/config.php";
$staff_id=verifyAutho();
$gl_code=$_REQUEST['glc'];
//$menu=$_REQUEST['menu'];
$vdebit="0";
$vcredit="0";
$cldebit="0";
$clcredit="0";
$vdebit1="0";
$vcredit1="0";
$color21="lightgreen";
$color22="lightgrey";
echo "<html>";
echo "<head>";
echo "<title>  General Ledger";
echo "</title>";
//echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";

echo "</head>";
echo "<body bgcolor=\"silver\">";
//echo "<form method=\"POST\" action=\"customer_account_list.php?menu=$menu\" method=\"POST\" name=f1>";
echo "<hr>";
//$sql_statement="SELECT * FROM customer_master WHERE customer_id like '%C-%'  order by cast(substring(customer_id,3) as int)";
//cast(substring(customer_id,3) as int)

$sql_statement="select gl_mas_code, gl_mas_desc, account_no, action_date, tran_id, particulars, debit, credit from gl_ledger_rep(current_date-100, current_date) where gl_mas_code like '$glc%' and debit+credit>0";
echo $sql_statement;
$result=dBConnect($sql_statement);

echo "<table width=\"100%\" valign=\"top\"><tr><td valign=\"top\" width=\"98%\">";
echo "<table width=\"100%\">";

echo "<tr><td bgcolor=\"green\" colspan=\"9\" align=\"center\"><font color=\"white\"><b>General Ledger: Accountwise</b></font>";

// Place line comments if you do not need column header.
$color=$TCOLOR;

$vglcode='   ';
	$vdebit=0;
	$vcredit=0;
for($j=0; $j<pg_NumRows($result); $j++) 
{
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);

        if($vglcode <> $row['gl_mas_code']){
		if($vdebit+$vcredit>0){
		echo "<tr>";
		echo "<td align=left bgcolor=$color></td>";
		echo "<td align=left bgcolor=$color></td>";
		echo "<td align=left bgcolor=$color>Balance c/f</td>";
		$bal=$vdebit-$vcredit;
		if($vdebit>$vcredit){
			echo "<td align=right bgcolor=$color> </td>";
			echo "<td align=right bgcolor=$color>".$bal."</td>";
		} else
		{
			echo "<td align=right bgcolor=$color>".-$bal."</td>";
			echo "<td align=right bgcolor=$color> </td>";

		}
		echo "<tr>";
		echo "<td align=left bgcolor=$color21></td>";
		echo "<td align=left bgcolor=$color21></td>";
		echo "<td align=left bgcolor=$color21>Total</td>";
		if($vdebit>$vcredit){
			echo "<td align=right bgcolor=$color21>".$vdebit."</td>";
			echo "<td align=right bgcolor=$color21>".$vdebit."</td>";
		} else{
			echo "<td align=right bgcolor=$color21>".$vcredit."</td>";
			echo "<td align=right bgcolor=$color21>".$vcredit."</td>";
		} 
		}
		echo "<tr>";
		$color=$TCOLOR;
		echo "<th bgcolor=$color colspan=\"5\" width=\"15%\">".$row['gl_mas_code']." - ".$row['gl_mas_desc']."</th>";



		echo "<tr>";
		echo "<th bgcolor=$color22 colspan=\"1\" width=\"15%\">Date</th>";
		echo "<th bgcolor=$color22 colspan=\"1\" width=\"15%\">Tran Id</th>";
		echo "<th bgcolor=$color22 colspan=\"1\" width=\"40%\">Particulars</th>";
		echo "<th bgcolor=$color22 colspan=\"1\" width=\"15%\">Debit</th>";
		echo "<th bgcolor=$color22 colspan=\"1\" width=\"15%\">Credit</th>";
		$vglcode = $row['gl_mas_code'];
		$vdebit=0;
		$vcredit=0;

	}
	echo "<tr>";
	echo "<td align=left bgcolor=$color>".$row['action_date']."</td>";
	echo "<td align=left bgcolor=$color>".$row['tran_id']."</td>";
	if(ltrim($row['account_no'])){
	echo "<td align=left bgcolor=$color>".$row['account_no']." - ".$row['particulars']."</td>";
} else{
	echo "<td align=left bgcolor=$color>".$row['particulars']."</td>";
}
	echo "<td align=right bgcolor=$color>".$row['debit']."</td>";
	echo "<td align=right bgcolor=$color>".$row['credit']."</td>";
	$vdebit=$vdebit+$row['debit'];
	$vcredit=$vcredit+$row['credit'];

	//$result=dBConnect($sql_statement2);
	//$row=pg_fetch_array($result);
	//echo "<td align=center bgcolor=$color>".$row1['account_type']."</td>";
}
	//echo "<tr>";
	//echo "<td align=left bgcolor=$color> </td>";
	//echo "<td align=centre bgcolor=$color>Total</td>";
	//echo "<td align=right bgcolor=$color>".$vdebit."</td>";
	//echo "<td align=right bgcolor=$color>".$vcredit."</td>";
		//echo "<td align=right bgcolor=$color>".$cldebit."</td>";
		//echo "<td align=right bgcolor=$color>".$clcredit."</td>"; 

echo "</tr>";
		if($vdebit+$vcredit>0){
		echo "<tr>";
		echo "<td align=left bgcolor=$color></td>";
		echo "<td align=left bgcolor=$color></td>";
		echo "<td align=left bgcolor=$color>Balance c/f</td>";
		$bal=$vdebit-$vcredit;
		if($vdebit>$vcredit){
			echo "<td align=right bgcolor=$color> </td>";
			echo "<td align=right bgcolor=$color>".$bal."</td>";
		} else
		{
			echo "<td align=right bgcolor=$color>".-$bal."</td>";
			echo "<td align=right bgcolor=$color> </td>";

		}
		echo "<tr>";
		echo "<td align=left bgcolor=$color21></td>";
		echo "<td align=left bgcolor=$color21></td>";
		echo "<td align=left bgcolor=$color21>Total</td>";
		if($vdebit>$vcredit){
			echo "<td align=right bgcolor=$color21>".$vdebit."</td>";
			echo "<td align=right bgcolor=$color21>".$vdebit."</td>";
		} else{
			echo "<td align=right bgcolor=$color21>".$vcredit."</td>";
			echo "<td align=right bgcolor=$color21>".$vcredit."</td>";
		} 
		}

echo "</tr><tr>";
$color="cyan";
echo "<td align=center bgcolor=$color colspan=\"9\"><b>Total: $j Account  !!!!!!</b></td>";
echo "</table>";
echo "</td><td>";
//$sql_statement="select a.gl_mas_code, b.gl_mas_desc, sum(debit) as debit, sum(credit) as credit, sum(debit-credit) as bal from mas_gl_tran as a , gl_master as b where a.gl_mas_code= b.gl_mas_code group by a.gl_mas_code, b.gl_mas_desc having sum(debit-credit)<=0";
//echo $sql_statement;
//$result=dBConnect($sql_statement);

//echo "<table width=\"100%\"><tr><td valign=\"top\">";
//echo "<td><td valign=\"top\">";


echo "</td></tr>";
echo "<tr><td align=left><table width=\"100%\"><tr> ";
echo "<th bgcolor=$color colspan=\"1\" width=\"10%\"></th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"30%\">Total</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"20%\">".$vdebit."</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"20%\">".$vcredit."</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"20%\">".$cldebit."</th>";
echo "</tr></table>";
echo "</td><td align=left>";




echo "</td></tr></table>";


echo "<br>";
footer();
echo "</body>";
echo "</html>";
?>
