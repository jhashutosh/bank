<?
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$op=$_REQUEST['op'];
$bank_name=$_REQUEST['bankname'];
$type=$_REQUEST['t_investment'];
$amount=$_REQUEST['amount'];
$account_no=$_REQUEST['account_no'];
$open_date=$_REQUEST['open_date'];
$r_int=$_REQUEST['r_int'];
$mt_date=$_REQUEST['mt_date'];
$mrn=$_REQUEST['mrn'];
$gl_code=$_REQUEST['type'];
$receipt_no=$_REQUEST['receipt_no'];
$maturity_amount=$_REQUEST['maturity_amount'];
$gl_mas_codeb=$_REQUEST['gl_mas_codeb'];
$cheque_no=$_REQUEST['cheque_no'];
$cheque_dt=$_REQUEST['cheque_date'];
if(empty($cheque_dt)){$cheque_dt=$DOB_DEFAULT;}
echo "<html>";
echo "<head>";
echo "<title>Investment";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
$color="#00CED1";
echo "<table align=center width=\"100%\" bgcolor=$color>";
echo "<form name=\"frm\" method=\"post\" action=\"investment.php?menu=inv&op=i\">";
echo "<tr><th colspan=\"8\" bgcolor=\"green\"><font color=white size=5>Investment Details</font></ht>";
echo "<tr>";
echo "<td bgcolor=$color>Name of Organisation:<td><input type=TEXT name=\"bankname\" size=\"15\" $HIGHLIGHT>";
//echo "<td bgcolor=$color>Type of Investment:<td><input type=TEXT name=\"t_investment\" size=\"12\" $HIGHLIGHT>";
//------------------------------necessary this function--------------------------------
echo "<td bgcolor=$color>Type of Investment:<td copspan=\"2\">";
//echo "".makeSelectFromDBWithCodeCondition("gl_mas_code","gl_mas_desc","gl_master","type")."";
echo "<td bgcolor=$color>Opening value Rs.:<td><input type=TEXT name=\"amount\" size=\"15\" $HIGHLIGHT>";
echo "<td bgcolor=$color>A/C No:<td><input type=TEXT name=\"account_no\" size=\"15\" $HIGHLIGHT>";
echo "<tr>";
echo "<td bgcolor=$color>Opening Date:<td><input type=TEXT name=\"open_date\" size=\"12\" $HIGHLIGHT>";
echo "<td bgcolor=$color>Maturity Date:<td><input type=TEXT name=\"mt_date\" size=\"12\" $HIGHLIGHT>&nbsp;&nbsp;Receipt No:&nbsp;&nbsp;<input type=TEXT name=\"receipt_no\" size=\"12\" $HIGHLIGHT>";
//echo "<td bgcolor=$color>Receipt No:<td><input type=TEXT name=\"mt_date\" size=\"12\" $HIGHLIGHT>";
echo "<td bgcolor=$color>Interest Rate:<td><input type=TEXT name=\"r_int\" size=\"10\" $HIGHLIGHT>%";
echo "<td bgcolor=$color>Meeting Resolution No:<td><input type=TEXT name=\"mrn\" size=\"15\" $HIGHLIGHT>";
echo "<tr>";
echo "<td bgcolor=$color>Maturity Amount:<td><input type=TEXT name=\"maturity_amount\" size=\"12\" $HIGHLIGHT>";
echo "<td bgcolor=$color>Bank Account code:<td><input type=TEXT name=\"gl_mas_codeb\" size=\"15\" $HIGHLIGHT>";
echo "<td bgcolor=$color>Cheque No:<td><input type=TEXT name=\"cheque_no\" size=\"15\" $HIGHLIGHT>";
echo "<td bgcolor=$color>Cheque dt:<td><input type=TEXT name=\"cheque_date\" size=\"15\" $HIGHLIGHT>";
echo "<tr><th><th><th><th><th><th><th><th align=\"right\"><input type=\"submit\" value=\"submit\">";
echo "</form>";
echo "</table>";

if($op==i){
$t_id=getTranId();
$sql_statement="INSERT INTO investment_details(tran_id,name_bank,amount,account_no,opening_date, r_interest,maturity_date,mrn,gl_code,receipt_no,maturity_amount,gl_mas_code, cheque_no, cheque_dt) VALUES('$t_id','$bank_name',$amount,'$account_no','$open_date',$r_int,'$mt_date','$mrn',$gl_code,'$receipt_no',$maturity_amount, $gl_mas_codeb, '$cheque_no' , '$cheque_dt' )";
//echo "$sql_statement";
$result=dBConnect($sql_statement);
if(pg_affected_rows($result)<1) {
	echo "<h4><font color=\"RED\">Failed to insert data into database.</font></h4>";

	} 
//else {
//	echo "<center><font color=\"green\" size=\"5\">Please Write drown Traction Id is :<b>$t_id</font></center>";
 // }
}
echo "<hr>";

$sql_statement="SELECT * FROM investment_details order by maturity_date desc";
//echo "$sql_statement";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
echo "<table align=center bgcolor=silver width=100%>";
echo "<tr><th colspan=9 bgcolor=green><font color=white size=4>Investment Details</font></th>";
echo "<tr bgcolor=#FF00FF><th>Name of Bank<th>Account No<th>Amount<th>Opening Date<th>Maturity Date<th>Maturity Amount<th>Interest Rate<th>Receipt No<th>Meeting Res No<th>Ledger";
		$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
		echo "<tr>";
		echo "<td bgcolor=$color>".$row['name_bank'];
		echo "<td bgcolor=$color>".$row['account_no'];
		echo "<td bgcolor=$color>".$row['amount'];
		echo "<td bgcolor=$color>".$row['opening_date'];
		echo "<td bgcolor=$color>".$row['maturity_date'];
                echo "<td bgcolor=$color>".$row['maturity_amount'];
		echo "<td bgcolor=$color>".$row['r_interest'];
		echo "<td bgcolor=$color>".$row['receipt_no'];
		echo "<td bgcolor=$color>".$row['mrn'];
		echo "<td bgcolor=$color><a href=\"investment_ledger.php?type=".$row['type']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes,top=100,left=150, width=1050,height=500'); return false;\">ledger</a>";

	}

  }


echo "</body>";
echo "</html>";

?>
