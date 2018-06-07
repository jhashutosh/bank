<?php
include "../config/config.php";
$staff_id=verifyAutho();
if(isset($_REQUEST['menu']))
{
$menu=$_REQUEST['menu'];
}
else
{
$menu='';
}

$tran_id=trim($_REQUEST['tran_id']);
$action_date=(empty($_REQUEST['action_date']))?date('d.m.Y'):$_REQUEST['action_date'];
echo "<html>";
echo "<head>";
echo "<title>Vouchar Details";
echo "</title>";
echo "<script language=\"JAVASCRIPT\">";
echo "function closeme() { close(); }";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"tran_id.focus();\">";
//------------------------------------------------------------------------------------------------
echo "<form name=\"form1\" action=\"voucherdetails.php\" method=\"post\">";
echo "<table align =\"center\" width =\"100%\" class=\"border\"><tr>";
echo "<td>Enter Transaction Id :&nbsp;<td><input type=\"TEXT\" name=\"tran_id\" id=\"tran_id\" value=\"$tran_id\" onclick=\"this.value=' '\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"SUBMIT\" VALUE=\"ENTER\">";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> ";
echo "</table>";
echo "</form>";
echo "<hr>";

//------------------------------------------------------------------------------------------------
if(!empty($tran_id)){
// HEADER INFORMATION 
$sql_statement="SELECT * FROM gl_ledger_hrd WHERE tran_id='$tran_id'";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0){
 echo "<h1><font color=red><b>Sorry Header Information Not Found!!!!!!!!!</b></font></h1>";
}
else{
echo "<table align =\"center\" width =\"60%\" class=\"border\">";
$cheque_no=pg_result($result,'cheque_no');
$type=pg_result($result,'type');
$remarks=pg_result($result,'remarks');
$certificate_no=pg_result($result,'certificate_no');
$color="#BDB76B";
echo "<tr><th colspan=\"4\" bgcolor=$color>Transaction Header";
echo "<tr><td bgcolor=$color>Transaction Id:";
echo "<td bgcolor=$color><b>$tran_id";
echo "<td bgcolor=$color>Action Date:";
echo "<td bgcolor=$color><b>".pg_result($result,'action_date');
echo "<tr><td bgcolor=$color>Cheque No.:";
echo "<td bgcolor=$color><b>".$cheque_no;
echo "<td bgcolor=$color>Cheque Date:";
echo "<td bgcolor=$color><b>".pg_result($result,'cheque_dt');
echo "<tr><td bgcolor=$color>Vouchar Type:";
echo "<td bgcolor=$color><b>".$type;
	if($type=='sb'){
		echo "<td bgcolor=$color>Cheque Status:";
		echo "<td bgcolor=$color><b>".$certificate_no;
	}
	else{
	echo "<td bgcolor=$color>Ref. No.";
	echo "<td bgcolor=$color><b><a href =\"../general/voucherdetails.php?tran_id=".$certificate_no."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=700,height=500'); return false;\" >".$certificate_no;
	}
echo "<tr><td bgcolor=$color valign=\"middle\">Naration";
echo "Narration:<td colspan=3><textarea name=\"remarks\" rows=\"3\"  cols=\"50\" readonly $HIGHLIGHT>$remarks</textarea>";
echo "</table>";
echo "<hr>";
}
//----------------------------------------------------------------------------------------------
//ledger detail INFORMATION 

$sql_statement="SELECT a.tran_id, CASE 
      WHEN b.gl_mas_code='14101' and a.gl_mas_code='14301' THEN b.gl_mas_code 
      WHEN b.gl_mas_code='14102' and a.gl_mas_code='14302' THEN b.gl_mas_code 
      WHEN b.gl_mas_code='14103' and a.gl_mas_code='14303' THEN b.gl_mas_code 
      WHEN b.gl_mas_code='14104' and a.gl_mas_code='14304' THEN b.gl_mas_code 
      WHEN b.gl_mas_code='14105' and a.gl_mas_code='14305' THEN b.gl_mas_code 
      ELSE a.gl_mas_code
      END as gl_mas_code,qty,amount,dr_cr,particulars,a.account_no FROM gl_ledger_dtl a
LEFT JOIN
(SELECT customer_id,opening_date,account_no,gl_mas_code,status from customer_account a WHERE opening_date=(SELECT MAX(opening_date) FROM customer_account b WHERE entry_time=(SELECT MAX(entry_time)FROM customer_account c WHERE a.customer_id=c.customer_id AND b.customer_id=c.customer_id AND opening_date<='$action_date'))) as b on a.account_no=b.account_no
WHERE tran_id='$tran_id' ORDER BY dr_cr DESC";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)==0){
 echo "<h1><font color=red><b>Sorry Details Information Not Found!!!!!!!!!</b></font></h1>";
}
else{
echo "<table align =\"center\" width =\"100%\" Bgcolor=\"\" class=\"border\"><tr>";
echo "<th bgcolor=GREEN rowspan=\"2\">Sl No.<th bgcolor=GREEN rowspan=\"2\">Particulars<th bgcolor=GREEN colspan=\"2\">Amount (Rs)<th bgcolor=GREEN rowspan=\"2\">Remarks";
echo "<tr><th bgcolor=GREEN colspan=\"1\">Dr.<th bgcolor=GREEN colspan=\"1\">Cr.";
$color==$TCOLOR;
$c_amount=0;
$d_amount=0;
for($j=0; $j<pg_NumRows($result); $j++) {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
echo "<tr>";
$d_c=trim($row['dr_cr']);
$idValue=$row['gl_mas_code'];
echo "<td bgcolor=$color align=\"Center\">".($j+1);
//echo "<td bgcolor=$color>$ac_no";
$name=getName('gl_mas_code',$idValue,'gl_mas_desc','gl_master');
echo "<td bgcolor=$color>".$name;

if($d_c=='Dr'){
	echo "<td bgcolor=$color align=\"RIGHT\">".amount2Rs($row['amount']);
	echo "<td bgcolor=$color align=\"RIGHT\">0";
	$d_amount+=$row['amount'];
	}
else{
	echo "<td bgcolor=$color align=\"RIGHT\">0";
	echo "<td bgcolor=$color align=\"RIGHT\">".amount2Rs($row['amount']);
	$c_amount+=$row['amount'];
	}
if(empty($row['accout_no'])){
	echo "<td bgcolor=$color >".$row['particulars'];
	}
else{
	echo "<td bgcolor=$color >".$row['accout_no']."[".$row['particulars']."]";
    }

  }
echo "<tr>";
echo "<th colspan=\"2\" align=\"CENTER\" bgcolor=AQUA>Total :$j Entry Found<th bgcolor=AQUA align=\"RIGHT\">".amount2Rs($d_amount)."<th bgcolor=AQUA align=\"RIGHT\">".amount2Rs($c_amount);
echo "<th bgcolor=AQUA>";
}

}


?>
