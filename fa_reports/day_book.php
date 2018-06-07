<?php
include "../config/config.php";
$date=date('d/m/Y');
if(isset($_REQUEST['date'])== true)
{
$date=$_REQUEST['date'];
}

$op=$_REQUEST['op'];
$TBGCOLOR="WHITE";
$TCOLOR="#6FACC9";
$FCOLOR="WHITE";
$FBCOLOR="black";

//echo $type_of_account1_array ['fd'];
echo"<html>";
echo "<title>Daily Scroll History";
echo "</title>";
echo "<head>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\"/>";
echo "</head>";
echo"<body>";
echo"<form name='f1' action='day_book.php?op=i' method='post'>";
echo"<table width='100%' bgcolor='white'><tr>";
echo"<th bgcolor='grey' colspan='3' rowsspan='3'><font color='' size='4'>Daily Scroll History</font></th></tr><hr><tr bgcolor='white'><td colspan='3'><hr></td></tr>";
echo"<tr bgcolor='white'><td bgcolor='' align='center'>As On :&nbsp;&nbsp;&nbsp;<input type=\"TEXT\" name=\"date\" size=\"12\" value='$date' $HIGHLIGHT>";
echo "&nbsp<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.date,'dd/mm/yyyy','Choose Date')\"></td>";
echo"<td><input type=\"submit\" name=\"Submit\" value=\"Submit\"></td>";
echo "<td> <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> </td></tr>";
echo"</form>";
if($op=='i'){
//echo "<hr>";
//LOAN DAY BOOK
$sql_statement="select ca.customer_id,initcap(name1) as name,initcap((address11||' '||address12||' Pin-'||pin1))as address,tran_id,ls.account_no,loan_serial_no,lower(SUBSTR(ls.account_no,1,CASE WHEN (position('-' IN ls.account_no)-1)=-1 THEN 2 ELSE position('-' IN ls.account_no)-1 END)) as v_type,action_date,tr_type,loan_amount,r_due_int,r_overdue_int,r_principal,0 FROM loan_statement ls,customer_account ca,customer_master cm 
where ls.account_no=ca.account_no and cm.customer_id=ca.customer_id and action_date='$date' order by v_type";
$result=dBConnect($sql_statement);
echo "<table width=\"100%\"><tr>";
echo "<th  bgcolor=\"Yellow\" Colspan=12><font size=+2>Loan Day Book as on $date</font><tr>";
	$color="GREEN";
	echo "<tr>";
	echo "<th  bgcolor=$color Rowspan=2>Customer Id</th>";
	echo "<th  bgcolor=$color Rowspan=2>Customer Name</th>";
	echo "<th  bgcolor=$color Rowspan=2>Address</th>";
	echo "<th  bgcolor=$color Rowspan=2>Account No</th>";
	echo "<th  bgcolor=$color Rowspan=2>Rcpt. No</th>";
	echo "<th  bgcolor=$color Rowspan=2>Loan Amount</th>";
	echo "<th bgcolor=$color Colspan=3>Recovery</th>";
	echo "<th  bgcolor=$color Rowspan=2>Penal</th>";
	echo "<th  bgcolor=$color Rowspan=2>SF</th>";
	echo "<th  bgcolor=$color Rowspan=2>IC</th><tr>";
	echo "<th  bgcolor=$color>Principal</th>";
	echo "<th  bgcolor=$color>Due Int.</th>";
	echo "<th  bgcolor=$color>OD Int.</th>";
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	if(pg_NumRows($result)>0){
	for($j=0; $j<pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
      	echo "<tr>";
	echo "<th align=left bgcolor=$color>".$row['customer_id']."</td>";
	echo "<td align=left bgcolor=$color>".$row['name']."</td>";
	echo "<td align=left bgcolor=$color>".$row['address']."</td>";
	echo "<td align=right bgcolor=$color>".$row['account_no']."</td>";
	echo "<td align=right bgcolor=$color>".$row['tran_id']."</td>";
	echo "<td align=right bgcolor=$color>".amount2Rs($row['loan_amount'])."</td>";
	$t_loan_amount+=$row['loan_amount'];
	echo "<td align=right bgcolor=$color>".amount2Rs($row['r_principal'])."</td>";
	$t_r_principal+=$row['r_principal'];
	echo "<td align=right bgcolor=$color>".amount2Rs($row['r_due_int'])."</td>";
	$t_r_due_int+=$row['r_due_int'];
	echo "<td align=right bgcolor=$color>".amount2Rs($row['r_overdue_int'])."</td>";
	$t_r_overdue_int+=$row['r_overdue_int'];
	echo "<td align=right bgcolor=$color>".amount2Rs($row['pent'])."</td>";
	$t_pent+=$row['pent'];
	echo "<td align=right bgcolor=$color>".amount2Rs($row['sink_fund'])."</td>";
	$t_sink_fund+=$row['sink_fund'];
	echo "<td align=right bgcolor=$color>".amount2Rs($row['ic'])."</td></tr>";
	$t_ic+=$row['ic'];
	}
	echo "<tr bgcolor=AQUA><th colspan=\"5\">Total:";
	echo "<td align=right><b>".amount2Rs($t_loan_amount)."</td>";
	echo "<td align=right><b>".amount2Rs($t_r_principal)."</td>";
	echo "<td align=right><b>".amount2Rs($t_r_due_int)."</td>";
	echo "<td align=right><b>".amount2Rs($t_r_overdue_int)."</td>";
	echo "<td align=right><b>".amount2Rs($t_pent)."</td>";
	echo "<td align=right><b>".amount2Rs($t_sink_fund)."</td>";
	echo "<td align=right><b>".amount2Rs($t_ic)."</td>";
}
	else{
		echo "<tr><th bgcolor=WHITE colspan=\"12\" >Record Not Found </th>";
	}

echo "</table>";
// END LOAN DAY BOOK
//Deposit day book
$TBGCOLOR="WHITE";
$TCOLOR="#6FACC9";
$FCOLOR="darkblue";
$FBCOLOR="WHITE";
echo"<br><br>";
echo"<table width='100%' bgcolor=''>";
echo "<th  bgcolor=\"Yellow\" Colspan=12><font size=+2>Deposit Daily Report as on $date</font><tr>";
//echo"<tr><th>Certificate No</th><th>Customer Id</th><th>Customer Name</th><th>A/C No.</th><th>Recpt. No.</th><th>Deposit</th><th>Withdrawl</th><th>Days</th><th>Maturity Date</th><th>Maturity Amount</th><th>Interest Rate</th></tr>";
$sql_statement="SELECT lower(SUBSTR(fo.account_no,1,CASE WHEN (position('-' IN fo.account_no)-1)=-1 THEN 2 ELSE position('-' IN fo.account_no)-1 END)) as v_type,fo.*,dp.*,mas_sb_balance(fo.account_no,fo.entry_time,fo.action_date) as cur_bal FROM (SELECT * FROM mas_gl_tran where gl_mas_code IN ('14101','14201','14301','14401')
   UNION ALL
   SELECT * FROM mas_gl_tran where gl_mas_code IN ('14102','14202','14302','14402')
   UNION ALL
   SELECT * FROM mas_gl_tran where gl_mas_code IN ('14103','14203','14303','14403')
   UNION ALL
   SELECT * FROM mas_gl_tran where gl_mas_code IN ('14106','14206','14306','14406')
   UNION ALL
   SELECT * FROM mas_gl_tran where gl_mas_code IN ('14107','14207','14307','14407')
   UNION ALL
   SELECT * FROM mas_gl_tran where gl_mas_code IN ('12231','11200')) as fo 
   LEFT JOIN
   (SELECT * FROM deposit_info) dp on(fo.account_no=dp.account_no) 
  where fo.action_date='$date'  ORDER BY v_type";
$result=dBConnect($sql_statement);
//echo $sql_statement;
for($j=0; $j<pg_NumRows($result); $j++)
{
echo "<tr>";
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$fcolor=($fcolor==$FCOLOR)?$FBCOLOR:$FCOLOR;
$row=pg_fetch_array($result,$j);
$row1=pg_fetch_array($result,$j+1);
$row2=pg_fetch_array($result,$j+2);
if($j==0){


 if ($row['v_type']=='sb'|| $row['v_type']=='gf'|| $row['v_type']=='tf'|| $row['v_type']=='sh')
{ echo"<tr BGCOLOR='#839EB8'><th colspan='7' bgcolor='#0489B1'><font color=White>".$type_of_account1_array[trim($row['v_type'])]." List </th></tr>";
		echo "</tr><tr BGCOLOR='#839EB8'><th>Customer Id</th><th>Customer Name</th><th>".ucwords($row['v_type'])."  A/C No.</th><th>Rcpt. No.</th><th>Deposit</th><th>Withdrawl
		</th><th>Balance</th></tr><tr>";}
	elseif($row['v_type']=='rd' || $row['v_type']=='cc'|| $row['v_type']=='fd')
		{
		 echo"<tr BGCOLOR='#839EB8'><th colspan='12' bgcolor='#0489B1'><font color=White>".$type_of_account1_array[trim($row['v_type'])]." List </th></tr>";
		echo"</tr><tr BGCOLOR='#839EB8'><th>Certificate No</th><th>Customer Id</th><th>Customer Name</th><th>A/C No.</th><th>Recpt. No.</th><th>Deposit</th><th>Withdrawl
		</th><th>Balance</th><th>Months</th><th>Maturity Date</th><th>Maturity Amount</th><th>Interest Rate</th></tr><tr>";
}
}
if($row['v_type']!='sh')
{$sql="select a.customer_id,initcap(b.name1) as name1 from customer_account a,customer_master b where a.customer_id=b.customer_id and a.account_no='".$row[5]."'";}
else
{$sql="select a.customer_id,initcap( b.name1) as name1 from membership_info a,customer_master b where a.customer_id=b.customer_id and a.membership_no=".$row[5]."";}
$res=dBConnect($sql);
$r=pg_fetch_array($res,0);

if($row['v_type']=='fd'|| $row['v_type']=='rd' || $row['v_type']=='cc'){
//echo $sql;
echo "<td bgcolor='$color'><font color='$fcolor'>".$row['certificate_no'];
echo "<td bgcolor='$color'><font color='$fcolor'>".$r['customer_id'];
echo "<td bgcolor='$color'><font color='$fcolor'>".$r['name1'];
echo "<td bgcolor='$color'><font color='$fcolor'>".$row['account_no'];
echo "<td bgcolor='$color'><font color='$fcolor'>".$row['tran_id'];
echo "<td bgcolor='$color'><font color='$fcolor'>".$row['credit'];
$dep=$dep+$row['credit'];
echo "<td bgcolor='$color'><font color='$fcolor'>".$row['debit'];
$wid=$wid+$row['debit'];
if($row['credit']!=0){
echo "<td bgcolor='$color'><font color='$fcolor'>".$row['cur_bal'];
echo "<td bgcolor='$color'><font color='$fcolor'>".$row['period'];
echo "<td bgcolor='$color'><font color='$fcolor'>".$row['maturity_date'];
echo "<td bgcolor='$color'><font color='$fcolor'>".$row['maturity_amount'];
echo "<td bgcolor='$color'><font color='$fcolor'>".$row['interest_rate'];
}
else{
echo "<td bgcolor='$color'><font color='$fcolor'>";
echo "<td bgcolor='$color'><font color='$fcolor'>";
echo "<td bgcolor='$color'><font color='$fcolor'>";
echo "<td bgcolor='$color'><font color='$fcolor'>";
echo "<td bgcolor='$color'><font color='$fcolor'>";

}
}
elseif($row['v_type']=='sb'|| $row['v_type']=='gf'|| $row['v_type']=='tf'|| $row['v_type']=='sh'){
//echo $sql;
echo "<td bgcolor='$color'><font color='$fcolor'>".$r['customer_id'];
echo "<td bgcolor='$color'><font color='$fcolor'>".$r['name1'];
echo "<td bgcolor='$color'><font color='$fcolor'>".$row[5];
echo "<td bgcolor='$color'><font color='$fcolor'>".$row['tran_id'];
echo "<td bgcolor='$color'><font color='$fcolor'>".$row['credit'];
$dep=$dep+$row['credit'];
echo "<td bgcolor='$color'><font color='$fcolor'>".$row['debit'];
echo "<td bgcolor='$color'><font color='$fcolor'>".$row['cur_bal'];
$wid=$wid+$row['debit'];


}
if ($row['v_type']!= $row1['v_type'] && (!empty($row1['v_type'])))
{  
  if($row['v_type']=='sb'|| $row['v_type']=='gf'|| $row['v_type']=='tf'|| $row['v_type']=='sh')
		echo"<tr bgcolor='aqua'><td colspan='4' align='center'><b>Total !! </b></td><td>".amount2Rs($dep)."</td><td>".amount2Rs($wid)."</td><td></td></tr>";
	elseif($row['v_type']=='rd' || $row['v_type']=='cc' || $row['v_type']=='fd')
		echo"<tr bgcolor='aqua'><td colspan='5' align='center'>Total !!</td><td>".amount2Rs($dep)."</td><td>".amount2Rs($wid)."</td><td colspan='5'></td></tr>";	
			$wid=0;
 			$dep=0;

	 if ($row1['v_type']=='sb'|| $row1['v_type']=='gf'|| $row1['v_type']=='tf'|| $row1['v_type']=='sh')
		{ 
		echo"</tr><tr BGCOLOR='white' ><td><br></td></tr></table><table BGCOLOR='' align='center' width='80%'><tr BGCOLOR='#839EB8'><th colspan='7' bgcolor='#0489B1'><font color=White>".$type_of_account1_array[trim($row1['v_type'])]." List </th></tr>";
		echo "<tr BGCOLOR='#839EB8'><th>Customer Id</th><th>Customer Name</th><th>".ucwords($row1['v_type'])."  A/C No.</th><th>Rcpt. No.</th><th>Deposit</th><th>Withdrawl
		</th><th>Balance</th></tr><tr>";}
	elseif($row1['v_type']=='rd' || $row1['v_type']=='cc'|| $row1['v_type']=='fd')
		{ echo"</tr><tr BGCOLOR='white' ><td><br></td></tr></table><table BGCOLOR='' align='center' width='100%'><tr BGCOLOR='#839EB8'><th colspan='12' bgcolor='#0489B1'><font color=White>".$type_of_account1_array[trim($row1['v_type'])]." List </th></tr>";
		echo"<tr BGCOLOR='#839EB8'><th>Certificate No</th><th>Customer Id</th><th>Customer Name</th><th>A/C No.</th><th>Recpt. No.</th><th>Deposit</th><th>Withdrawl</th><th>Balance
		</th><th>Months</th><th>Maturity Date</th><th>Maturity Amount</th><th>Interest Rate</th></tr><tr>";
}}
echo"</tr>";
}
if($row['v_type']=='sb'|| $row['v_type']=='gf'|| $row['v_type']=='tf'|| $row['v_type']=='sh')
		echo"<tr bgcolor='aqua'><td colspan='4' align='center'>Total !! </td><td>".amount2Rs($dep)."</td><td>".amount2Rs($wid)."</td><td></td></tr>";
	elseif($row['v_type']=='rd' || $row['v_type']=='cc')
		echo"<tr bgcolor='aqua'><td colspan='5' align='center'>Total !!</td><td>".amount2Rs($dep)."</td><td>".amount2Rs($wid)."</td><td colspan='5'></td></tr>";	
}
echo"</table>";
//End Deposit
echo"<br><br>";
//PAYMENT VOUCHER
$sql_statement="SELECT tr.gl_mas_code,initcap(gl_mas_desc) as gl_mas_desc, SUM(debit) as debit,SUM(credit) as credit FROM  mas_gl_tran tr,gl_master gm where action_date='$date' AND gm.gl_mas_code=tr.gl_mas_code AND tr.gl_mas_code<>'28101' AND tr.tran_id IN (SELECT tran_id from gl_ledger_dtl where gl_mas_code='28101' and dr_cr='Cr' and tran_id IN (SELECT tran_id FROM gl_ledger_hrd WHERE action_date='$date')) GROUP BY tr.gl_mas_code,gl_mas_desc; "; 
///echo $sql_statement;
$result=dBConnect($sql_statement);
echo "<table width=\"100%\"><tr>";
echo "<th  bgcolor=\"Yellow\" Colspan=5><font size=+2>Payment Voucher as on $date</font></th></tr>";
	$color="GREEN";
	echo "<tr>";
	echo "<th align=left bgcolor=$color>SL_No</th>";
	echo "<th align=left bgcolor=$color >GL Code</th>";
	echo "<th align=left bgcolor=$color >Particulars</th>";
	echo "<th align=left bgcolor=$color >Dr.</th>";
	echo "<th align=right bgcolor=$color >Cr.</th>";
	if(pg_NumRows($result)>0){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	for($j=0; $j<pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
      	echo "<tr>";
	echo "<th align=left bgcolor=$color>".($j+1)."</td>";
	echo "<td align=left bgcolor=$color>".$row['gl_mas_code']."</td>";
	echo "<td align=left bgcolor=$color>".$row['gl_mas_desc']."</td>";

	echo "<td align=right bgcolor=$color>".amount2Rs($row['debit'])."</td>";
	echo "<td align=right bgcolor=$color>".amount2Rs($row['credit'])."</td>";
	$total_dr+=$row['debit'];
	$total_cr+=$row['credit'];

	}
	echo "<tr bgcolor=AQUA><th colspan=\"3\">Total Receipts & Payment :</th><th align=right>".amount2Rs($total_dr)."<th align=right>".amount2Rs($total_cr);
	}
	else{
		echo "<tr><th bgcolor=WHITE colspan=\"5\" >Record Not Found </td>";
	}

echo "</table>";
//----------------------------END OF PAYMENT VOUCHER
echo"<br><br>";
//START CASH BOOK
$sql_statement="SELECT tr.gl_mas_code,initcap(gl_mas_desc) as gl_mas_desc, SUM(debit) as debit ,SUM(credit) as credit FROM  mas_gl_tran tr,gl_master gm where action_date='$date' and gm.gl_mas_code=tr.gl_mas_code and tr.gl_mas_code<>'28101' AND tran_id IN (SELECT tran_id FROM mas_gl_tran where gl_mas_code='28101' and action_date='$date') GROUP BY tr.gl_mas_code,gl_mas_desc; "; 
///echo $sql_statement;
$result=dBConnect($sql_statement);
echo "<table width=\"100%\"><tr>";
echo "<th  bgcolor=\"Yellow\" Colspan=5><font size=+2>Cash Book as on $date</font></th></tr>";
	$color="GREEN";
	echo "<tr>";
	echo "<th align=left bgcolor=$color>SL_No</th>";
	echo "<th align=left bgcolor=$color >GL Code</th>";
	echo "<th align=left bgcolor=$color >Particulars</th>";
	echo "<th align=left bgcolor=$color >Receipts</th>";
	echo "<th align=right bgcolor=$color >Payments</th>";
	if(pg_NumRows($result)>0){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$total_cr=0;
	$total_dr=0;
	for($j=0; $j<pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
      	echo "<tr>";
	echo "<th align=left bgcolor=$color>".($j+1)."</td>";
	echo "<td align=left bgcolor=$color>".$row['gl_mas_code']."</td>";
	echo "<td align=left bgcolor=$color>".$row['gl_mas_desc']."</td>";
	echo "<td align=right bgcolor=$color>".amount2Rs($row['credit'])."</td>";
	echo "<td align=right bgcolor=$color>".amount2Rs($row['debit'])."</td>";
	$total_dr+=$row['debit'];
	$total_cr+=$row['credit'];

	}
	echo "<tr bgcolor=AQUA><th colspan=\"3\">Total Receipts & Payment :</th><th align=right>".amount2Rs($total_cr)."<th align=right>".amount2Rs($total_dr);
	}
	else{
		echo "<tr><th bgcolor=WHITE colspan=\"5\" >Record Not Found </td>";
	}

echo "</table>";
//END CASH BOOK
echo"<br><br>";
	//START BANK BOOK
$sql_statement="SELECT b_name,UPPER(account_type) as account_type ,br_name,UPPER(b_type) AS bank_type,zoo.* FROM(
SELECT account_no,SUM(op_bal) as op_bal,SUM(debit) as debit,SUM(credit) as credit,SUM(op_bal+debit-credit) AS cl_bal FROM (
SELECT account_no,0 as op_bal,SUM(debit) as debit,SUM(credit) as credit FROM mas_gl_tran where action_date='$date' and account_no IN(SELECT account_no FROM bank_bk_dtl WHERE account_type IN ('sb','ca')) GROUP BY account_no
UNION ALL
SELECT account_no,SUM(debit-credit) as op_bal,0 as debit,0 as credit FROM mas_gl_tran where action_date<'$date' and account_no IN(SELECT account_no FROM bank_bk_dtl WHERE account_type IN ('sb','ca')) GROUP BY account_no
) AS foo group by account_no) AS zoo,bank_bk_dtl bk where zoo.account_no=bk.account_no ORDER BY account_type";
$result=dBConnect($sql_statement);
//----------------------------------------------------------------------------------------------
echo "<table width=\"100%\"><tr>";
echo "<th  bgcolor=\"Yellow\" Colspan=9><font size=+2>Bank Book as on $date</font><tr>";
	$color="GREEN";
	echo "<tr>";
	echo "<th align=left bgcolor=$color>SL_No</th>";
	echo "<th align=left bgcolor=$color >Bank Name</th>";
	echo "<th align=left bgcolor=$color >Branch Name</th>";
	echo "<th align=left bgcolor=$color >Account No</th>";
	echo "<th align=right bgcolor=$color >Account Type</th>";
	echo "<th align=right bgcolor=$color>Opening_Balance</th>";
	echo "<th align=right bgcolor=$color >Deposits</th>";
	echo "<th align=right bgcolor=$color >Withdrawals</th>";
	echo "<th align=right bgcolor=$color >Closing Balance</th>";
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	if(pg_NumRows($result)>0){
	for($j=0; $j<pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
      	echo "<tr>";
	echo "<th align=left bgcolor=$color>".($j+1)."</td>";
	echo "<td align=left bgcolor=$color>".$row['b_name']."</td>";
	echo "<td align=left bgcolor=$color>".$row['br_name']."</td>";
	echo "<td align=right bgcolor=$color>".$row['account_no']."</td>";
	echo "<td align=right bgcolor=$color>".$row['account_type']."</td>";
	echo "<td align=right bgcolor=$color>".amount2Rs($row['op_bal'])."</td>";
	echo "<td align=right bgcolor=$color>".amount2Rs($row['debit'])."</td>";
	echo "<td align=right bgcolor=$color>".amount2Rs($row['credit'])."</td>";
	echo "<td align=right bgcolor=$color>".amount2Rs($row['cl_bal'])."</td>";
	}
}
else{
	echo "<tr><th bgcolor=$color colspan=\"9\" >Record Not Found </th>";	
}
echo "</table>";
//END BANK BOOK
//---------------------------------------------------------------------------------------------
echo"<br><br>";
//START CASH IN HAND 
$sql_statement="SELECT tr.gl_mas_code,gl_mas_desc,SUM(op_bal) as op_bal,SUM(debit) as debit,SUM(credit) as credit,SUM(op_bal+debit-credit) AS cl_bal FROM (
SELECT gl_mas_code,0 as op_bal,SUM(debit) as debit,SUM(credit) as credit FROM mas_gl_tran where action_date='$date' AND gl_mas_code='28101' group by gl_mas_code
UNION ALL
SELECT gl_mas_code,SUM(debit-credit) as op_bal,0 as debit,0 as credit FROM mas_gl_tran where action_date<'$date' AND gl_mas_code='28101' group by gl_mas_code) as tr,gl_master as gm 
where gm.gl_mas_code=tr.gl_mas_code GROUP BY tr.gl_mas_code,gl_mas_desc";
//echo $sql_statement;
$result=dBConnect($sql_statement);
//----------------------------------------------------------------------------------------------
echo "<table width=\"100%\" ><tr>";
echo "<th colspan=\"7\" bgcolor=\"Yellow\"><font size=+2>CASH IN HAND  as on $date</font><tr>";
	$color="GREEN";
	echo "<tr>";
	echo "<th align=left bgcolor=$color>SL_No</th>";
	echo "<th align=left bgcolor=$color >GL Code</th>";
	echo "<th align=left bgcolor=$color >Particulars</th>";
	echo "<th align=right bgcolor=$color>Opening_Balance</th>";
	echo "<th align=right bgcolor=$color >Inflow</th>";
	echo "<th align=right bgcolor=$color >Outflow</th>";
	echo "<th align=right bgcolor=$color >Closing Balance</th>";
	
	if(pg_NumRows($result)>0){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	for($j=0; $j<pg_NumRows($result); $j++){
	$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
	$row=pg_fetch_array($result,$j);
      	echo "<tr>";
	echo "<th align=left bgcolor=$color>".($j+1)."</td>";
	echo "<td align=left bgcolor=$color>".$row['gl_mas_code']."</td>";
	echo "<td align=left bgcolor=$color>".$row['gl_mas_desc']."</td>";
	echo "<td align=right bgcolor=$color>".amount2Rs($row['op_bal'])."</td>";
	echo "<td align=right bgcolor=$color>".amount2Rs($row['debit'])."</td>";
	echo "<td align=right bgcolor=$color>".amount2Rs($row['credit'])."</td>";
	echo "<td align=right bgcolor=$color>".amount2Rs($row['cl_bal'])."</td>";
	}
}
	else{
		echo "<tr><th align=right bgcolor=$color colspan=\"7\" >Record Not Found </th>";
	}
//END CASH IN HAND 

echo"</body>";
?>
