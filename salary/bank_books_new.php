<?
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$op=$_REQUEST['op'];
$account_no=$_REQUEST['account_no'];
$type=$_REQUEST['type'];
$bank_name=$_REQUEST['bank_name'];
$branch_name=$_REQUEST['branch_name'];
$op_date=$_REQUEST['op_date'];
$op_balance=$_REQUEST['op_balance'];
$gl_code=$_REQUEST['gl_code'];
$gl_group=$_REQUEST['gl_group'];
$remarks=$_REQUEST['remarks'];
$date=$_REQUEST['date'];
$deposit=$_REQUEST['deposit'];
$cheque_no=$_REQUEST['cheque_no'];
echo "<html>";
echo "<head>";
echo "<title>Investment";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\"/>";
echo "</head>";
echo "<body bgcolor=\"silver\">";
if($op==c){
$color="#00CED1";
echo "<form name=\"form1\" method=\"post\" action=\"bank_books_new.php?menu=bb&op=i\">";
echo "<table align=center width=100% bgcolor=$color>";
echo "<tr><th colspan=\"8\" bgcolor=\"green\"><font color=white size=5>Create New Bank A/C</font></th>";
echo "<tr>";
echo "<td bgcolor=$color>Account No:<td><input type=TEXT name=\"account_no\" size=\"15\" $HIGHLIGHT>";
echo "<td bgcolor=$color>Account Type:<td><input type=TEXT name=\"type\" size=\"15\" $HIGHLIGHT>";
echo "<td bgcolor=$color>Bank Name:<td><input type=TEXT name=\"bank_name\" size=\"15\" $HIGHLIGHT>";
echo "<td bgcolor=$color>Branch Name:<td><input type=TEXT name=\"branch_name\" size=\"15\" $HIGHLIGHT>";
echo "<tr>";
echo "<td bgcolor=$color>Opening Date:<td><input type=TEXT name=\"op_date\" size=\"15\" $HIGHLIGHT>";
echo "<td bgcolor=$color>Opening Balance:<td><input type=TEXT name=\"op_balance\" size=\"15\" $HIGHLIGHT>";
echo "<td bgcolor=$color>Gl Code:<td><input type=TEXT name=\"gl_code\" size=\"15\" $HIGHLIGHT>";
echo "<td bgcolor=$color>Gl Group:<td><input type=TEXT name=\"gl_group\" size=\"15\" $HIGHLIGHT>";
echo "<tr>";
echo "<td bgcolor=$color>Remarks:<td colspan=6><textarea name=\"remarks\" rows=\"2\" cols=\"80\" $HIGHLIGHT></textarea>";
echo "<td><input type=\"submit\" value=\"submit\">";
echo "</table>";
echo "</form>";
echo "<hr>";

//----------------------grid view---------------------------------------
$sql_statement="SELECT * FROM bank_book_details";
//echo "$sql_statement";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
echo "<table align=center bgcolor=silver width=100%>";
echo "<tr><th colspan=8 bgcolor=green><font color=white size=4>Already Created Bank Account Details</font></th>";
echo "<tr bgcolor=#FF00FF><th>A/C No.<th>Account Type<th>Bank<th>Branch<th>Opening Date<th>Opening Balance<th>Gl Code<th>Gl Group";
		$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
		echo "<tr>";
		echo "<td bgcolor=$color>".$row['account_no'];
		echo "<td bgcolor=$color>".$row['type'];
		echo "<td bgcolor=$color>".$row['bank_name'];
		echo "<td bgcolor=$color>".$row['branch_name'];
		echo "<td bgcolor=$color>".$row['op_date'];
		echo "<td bgcolor=$color>".$row['op_balance'];
		echo "<td bgcolor=$color>".$row['gl_code'];
		echo "<td bgcolor=$color>".$row['gl_group'];
		

	}

  }
}
//-------------insert into database--------------------
if($op==i){
if(empty($remarks)){
$remarks="NULL";
}
echo "sujoy";
$t_id=getTranId();
$sql_statement="INSERT INTO bank_book_details(tran_id,account_no,type,bank_name,branch_name,op_date,op_balance,gl_code,gl_group,remarks) VALUES('$t_id','$account_no','$type','$bank_name','$branch_name','$op_date','$op_balance','$gl_code','$gl_group','$remarks')";
echo "$sql_statement";
$result=dBConnect($sql_statement);
if(pg_affected_rows($result)<1) {
	echo "<h4><font color=\"RED\">Failed to insert data into database.</font></h4>";

	} 
else{
	header("Location:../bankbooks/bank_books_new.php?menu=bb&op=c");
}
}


//-------------------------------For deposit------------------------------------------
if($op==d){

echo "<table align=center bgcolor=silver width=100%>";
echo "<tr><th colspan=8 bgcolor=green><font color=white size=6>Total Bank Report</font></th>";
echo "<tr bgcolor=#00CED1><th>A/C No.<th>Account Type<th>Bank Name<th>Balance<th>Deposit/Repayment<th>Transfer";
//<th>Withdrawls/Issue
$sql_statement1="SELECT sum(amount) as amount FROM gl_ledger_dtl WHERE gl_mas_code='28101'";
$result1=dBConnect($sql_statement1);
if(pg_NumRows($result1)>0){
		$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result1);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result1,$j);
		echo "<tr>";
		echo "<td bgcolor=$color colspan=3 align=center><B>Cash in hand";
		echo "<td bgcolor=$color>".$row['amount'];
		//echo "<td bgcolor=$color>DEPOSIT";
		echo "<td bgcolor=$color colspan=2 align=center><a href=\"bank_books_new.php?&op_balance=".$row['amount']."&type=Cash in hand&op=t\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes,top=100,left=150, width=1050,height=500'); return false;\">TRANSFER</a>";

		}
	}

$sql_statement="SELECT * FROM bank_book_details";
//echo "$sql_statement";
$result=dBConnect($sql_statement);
	if(pg_NumRows($result)>0){
		$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
		echo "<tr>";
		echo "<td bgcolor=$color>".$row['account_no'];
		echo "<td bgcolor=$color>".$row['type'];
		echo "<td bgcolor=$color>".$row['bank_name'].$row['branch_name'];
		echo "<td bgcolor=$color>".$row['op_balance'];
		echo "<td bgcolor=$color><a href=\"bank_books_new.php?account_no=".$row['account_no']."&type=".$row['type']."&bank_name=".$row['bank_name']."&branch_name=".$row['branch_name']."&balance=".$row['op_balance']."&op=D\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes,top=100,left=150, width=1050,height=500'); return false;\">DEPOSIT</a>";
		//echo "<td bgcolor=$color>WITHDRAWLS";
		echo "<td bgcolor=$color><a href=\"bank_books_new.php?account_no=".$row['account_no']."&type=".$row['type']."&bank_name=".$row['bank_name']."&op_balance=".$row['op_balance']."&branch_name=".$row['branch_name']."&op=t\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes,top=100,left=150, width=1050,height=500'); return false;\">TRANSFER</a>";
		

	}


}

}
//----------------------------DEPOSIT----------------------------------------
if($op==D){
echo "<table align=center bgcolor=silver width=100%>";
echo "<tr><th colspan=6 bgcolor=green><font color=white size=5>Deposit Statement</font></th>";
echo "<tr><th colspan=2 bgcolor=green><font color=white size=3>Type Of Account: $type</font></th><th colspan=2 bgcolor=green><font color=white size=3>Bank Name: $bank_name($branch_name)</font></th><th colspan=2 bgcolor=green><font color=white size=3>Account No: $account_no</font></th>";
echo "<hr>";
$sql_statement="SELECT * FROM bank_book_details WHERE account_no='$account_no'";
//echo "$sql_statement";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
echo "<table align=center bgcolor=silver width=100%>";
echo "<tr bgcolor=#00CED1><th>Date <th>Cheque No<th>Deposit<th>Withdrawls<th>Balance<th>Remarks";
		$color=$TCOLOR;
		for($j=0;$j<pg_NumRows($result);$j++){
		$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
 		$row=pg_fetch_array($result,$j);
		echo "<tr>";
		echo "<td bgcolor=$color>".$row['op_date'];
		echo "<td bgcolor=$color>".$row['cheque_no'];
		echo "<td bgcolor=$color>".$row['deposit'];
		echo "<td bgcolor=$color>".$row['withdrawls'];
		echo "<td bgcolor=$color>".$row['op_balance'];
		echo "<td bgcolor=$color>".$row['remarks'];

		}
echo "</table>";
}
echo "<hr>";
echo "<hr>";
echo "<table align=center bgcolor=#00CED1 width=80%>";
echo "<tr><th colspan=6 bgcolor=green><font color=white size=5>Input Form</font></th>";
echo "<tr>";
$color="#00CED1";
echo "<form name=\"frm1\" method=\"post\" action=\"bank_books_new.php?menu=bb&op=D&ol=I&account_no=$account_no&type=$type&bank_name=$bank_name&branch_name=$branch_name\">";
echo "<td bgcolor=$color>Date: <td><input type=TEXT name=\"date\" size=\"15\" $HIGHLIGHT>";
echo "<td bgcolor=$color>Deposit Amount: <td><input type=TEXT name=\"deposit\" size=\"15\" $HIGHLIGHT>";
echo "<td bgcolor=$color>Cheque No: <td><input type=TEXT name=\"cheque_no\" size=\"15\" $HIGHLIGHT>";
echo "<tr>";
echo "<td bgcolor=$color>Remarks:<td colspan=4><textarea name=\"remarks\" rows=\"2\" cols=\"50\" $HIGHLIGHT></textarea>";
echo "<td><input type=submit value=submit>";
echo "</form>";
if($ol==I){
if(empty($remarks)){
$remarks="NULL";
}
$t_id=getTranId();
$sql_statement="INSERT INTO bank_book_details(tran_id,account_no,type,bank_name,branch_name,op_date,deposit,cheque_no,remarks) VALUES('$t_id','$account_no','$type','$bank_name','$branch_name','$date','$deposit','$cheque_no','$remarks')";
//echo "$sql_statement";
$result=dBConnect($sql_statement);
if(pg_affected_rows($result)<1) {
	echo "<h4><font color=\"RED\">Failed to insert data into database.</font></h4>";

	} 
}
}

//-------------------------------Transfer---------------------------------------------
if($op==t){
$color="#00CED1";
echo "<table align=center bgcolor=$color width=100%>";
echo "<tr><th colspan=8 bgcolor=green><font color=white size=5>Transfer Details</font></th>";
echo "<hr>";
echo "<tr><th colspan=8 bgcolor=green><font color=white size=3>FROM</font></th>";
echo "<tr>";
if($type!='Cash in hand'){
echo "<td bgcolor=$color>Account No:<td><input type=TEXT name=\"account_no1\" value=\"$account_no\" size=\"15\" $HIGHLIGHT readonly>";
echo "<td bgcolor=$color>Bank Name:<td><input type=TEXT name=\"bank_name1\" value=\"$bank_name$branch_name\" size=\"15\" $HIGHLIGHT readonly>";
}
echo "<td bgcolor=$color>Account Type:<td><input type=TEXT name=\"type1\" value=\"$type\" size=\"15\" $HIGHLIGHT readonly>";
echo "<td bgcolor=$color>Balance:<td><input type=TEXT name=\"op_balance1\" value=\"$op_balance\" size=\"15\" $HIGHLIGHT readonly>";
echo "<tr><th colspan=8 bgcolor=green><font color=white size=3>TO</font></th>";
echo "<tr>";
echo "<td bgcolor=$color>Account No:<td>";
echo "<td bgcolor=$color>Bank Name:<td>";
echo "".bankSelection('bank_name','branch_name','bank_book_details')."";
echo "<td bgcolor=$color>Account Type:<td><input type=TEXT name=\"type\" size=\"15\" $HIGHLIGHT>";
echo "<td bgcolor=$color>Balance:<td><input type=TEXT name=\"op_balance2\" size=\"15\" $HIGHLIGHT>";
echo "<tr>";
echo "<td bgcolor=$color>Amount:<td><input type=TEXT name=\"amount\" size=\"15\" $HIGHLIGHT>";
echo "<td bgcolor=$color><td bgcolor=$color><td bgcolor=$color><td bgcolor=$color><td bgcolor=$color>";
echo "<td><input type=\"submit\" value=\"submit\">";
}
//=====================Monthly return of bank===============================
if($op==m){
$color="#00CED1";
echo "<table align=center bgcolor=silver width=100%>";
echo "<tr><th colspan=9 bgcolor=green><font color=white size=4>Monthly Return Of Bank</font></th>";
echo "<tr>";
echo "<th bgcolor=$color rowspan=2>A/C No</th>";
echo "<th bgcolor=$color rowspan=2>Account Type</th>";
echo "<th bgcolor=$color rowspan=2>Bank Name</th>";
echo "<th bgcolor=$color rowspan=2>Previous Year Balance <br>31st March</th>";
echo "<th bgcolor=$color colspan=3>Amount During the Month</th>";
echo "<th bgcolor=$color rowspan=2>Previous Month<br> Balance(Rs.)</th>";
echo "<th bgcolor=$color rowspan=2>This Month <br>Balance(Rs.)</th>";
echo "<tr>";
echo "<th bgcolor=$color rowspan=1>Deposit</th>";
echo "<th bgcolor=$color rowspan=1>Withdrawl</th>";
echo "<th bgcolor=$color rowspan=1>Received Interest</th>";
}


echo "</body>";
echo "</html>";
?>
