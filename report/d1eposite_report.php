<?
include "../config/config.php";
$staff_id=verifyAutho();
$gl_code=$_REQUEST['glc'];
$start_date=$_REQUEST["start_date"];
if(empty($start_date) ) { $start_date=$_REQUEST["sdt"]; }
if(empty($start_date) ) { $start_date='01.04.'.date("Y"); }
$end_date=$_REQUEST["end_date"];
if(empty($end_date) ) { $end_date=$_REQUEST["edt"]; }
if(empty($end_date) ) { $end_date=$current_date=date("d.m.Y"); }
//$menu=$_REQUEST['menu'];
$vdebit="0.00";
$vcredit="0.00";
$cldebit="0.00";
$clcredit="0.00";
$vdebit1="0.00";
$vcredit1="0.00";

$color21="lightgreen";
$color22="lightgrey";
echo "<html>";
echo "<head>";
echo "<title>  General Ledger";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script language=\"JAVASCRIPT\">";
echo "function closeme() { close(); }";
echo "</script>";
echo "</head>";
echo "<body bgcolor=\"silver\">";

//$sql_statement="select gl_mas_code, gl_mas_desc, account_no, action_date, tran_id, particulars, debit, credit from gl_ledger_rep('$start_date', '$end_date') where gl_mas_code like '$gl_code%' and debit+credit>0";
//echo $sql_statement;
//$result=dBConnect($sql_statement);
echo "<form name=\"f1\" action=\"gl_ledger.php?glc=$glc\" method=\"POST\">";
echo "<table align=center bgcolor=\"#90EE90\"><tr><td  align=\"\"><b>Date:<td><input type=TEXT size=12 name=end_date value=\"$end_date\" $HIGHLIGHT>"<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.end_date,'dd/mm/yyyy','Choose Date')\">;

echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";

echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> ";
echo "</table></form>";
echo "<table width=\"100%\" valign=\"top\"><tr><td valign=\"top\" width=\"98%\">";
echo "<table width=\"100%\">";

echo "<tr><td bgcolor=\"green\" colspan=\"9\" align=\"center\"><font color=\"white\"><b>General Ledger: Accountwise</b></font>";

// Place line comments if you do not need column header.
$color=$TCOLOR;

$vglcode='   ';
	$vdebit=0.00;
	$vcredit=0.00;
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
		$vdebit=0.00;
		$vcredit=0.00;

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

}


echo "</tr>";
		if($vdebit+$vcredit>0){
		echo "<tr>";
		echo "<td align=left bgcolor=$color>$end_date</td>";
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
echo "<th bgcolor=$color colspan=\"1\" width=\"10%\"></th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"30%\">Total</th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"20%\"></th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"20%\"></th>";
echo "<th bgcolor=$color colspan=\"1\" width=\"20%\"></th>";
echo "</table>";
echo "</td><td>";
echo "</td></tr>";
echo "<tr>";

echo "<br>";
footer();
echo "</body>";
echo "</html>";
?>
