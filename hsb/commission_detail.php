<?
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$a_id=$_REQUEST['agent'];

$agent_id=getData($a_id);
$op=$_REQUEST['op'];
$action_date=date('d.m.Y');
echo "<html>";
echo "<head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<script language=\"JAVASCRIPT\">";
echo "function closeme() 
{ 
close(); 
}";
echo "</script>";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"id.focus();\">";
if(empty($_REQUEST['op'])){
$sql_statement="SELECT * FROM commission_dtl WHERE agent_id='$agent_id' AND CURRENT_DATE between frm_date and action_date";
$result=dBConnect($sql_statement);
if(pg_num_rows($result)<1) {
$sql_statement1="SELECT coalesce(due_commission,0) FROM commission_dtl where agent_id='$agent_id' AND tran_id=(select max(tran_id) from commission_dtl where agent_id='$agent_id')";
//echo $sql_statement1;
$result1=dBConnect($sql_statement1);
$due_amt=pg_result($result1,'due_commission');
if(empty($due_amt)){$due_amt=0;}
$sql_statement2="SELECT CURRENT_DATE-DATE(date(extract('year' FROM CURRENT_DATE)||'-'||extract('MONTH' FROM CURRENT_DATE)||'-01')+INTERVAL '1 MONTH'-INTERVAL '1 DAY') as x";
$result2=dBConnect($sql_statement2);
$x=pg_result($result2,'x');
$sql_statement="SELECT agent_code,action_date,SUM(credit) as amount FROM mas_gl_tran l,customer_account ca where l.action_date BETWEEN DATE(EXTRACT('YEAR' FROM CURRENT_DATE)||'-'||EXTRACT('MONTH' FROM CURRENT_DATE)||'-01') AND CURRENT_DATE AND ca.agent_code='$agent_id' AND l.account_no=ca.account_no and ca.account_type='hsb'  GROUP BY agent_code,action_date";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_num_rows($result)<1) {
echo "<h4>No Record or ERROR!!!</h4>";
} else {
//echo "<font color=#000080 size=+2><I><b>Material Master Details</b></I></font>";
echo "<hr>";
echo "<table>";
}

echo "<table valign=\"top\" width=\"60%\" align=\"left\">";
$color=$TCOLOR;
echo "<tr><td bgcolor=\"GREEN\" colspan=\"4\" align=\"center\"><font color=\"white\" size=5><b>Commission Details of ".getName('agent_code',$agent_id,'a_name','agent_master')."</b></font>";
echo "<tr>";
echo "<th bgcolor=$color>Action Date</th>";
echo "<th bgcolor=$color>Amount Collection</th>";
echo "<th bgcolor=$color>Commission</th>";
for($j=1; $j<=pg_NumRows($result); $j++) {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j-1));
echo "<tr>";
echo "<td align=center bgcolor=$color>".$row[1]."</td>";
echo "<td align=center bgcolor=$color>".ucwords($row[2])."</td>";
$comm+=$row[2];
//$due_amt=$row['due_commission'];
$commission=$row[2]*2/100;
echo "<td align=center bgcolor=$color>$commission</td>";
$t_amount+=$commission;
}
echo "</table>";
echo "<form name=\"f1\" method=\"POST\" action=\"commission_detail.php?agent=$agent_id&menu=$menu&op=i\">";
echo "<table align=\"RIGHT\" BGCOLOR=\"BLACK\">";
echo "<tr>";
$color="#FFDEAD";
echo "<th align=left bgcolor=$color colspan=\"1\"><B>Total Commission:</th><th align=left bgcolor=$color colspan=\"1\"><input type=\"text\" value=\"$t_amount\" name=\"t_com\" $HIGHLIGHT READONLY>";
echo "<tr>";
//echo "<td align=center bgcolor=$color colspan=\"3\"><B>Due Commission:$due_amt</B></td>";
echo "<th align=left bgcolor=$color colspan=\"1\"><B>Due Commission:</th><th align=left bgcolor=$color colspan=\"1\"><input type=\"text\" value=\"$due_amt\" name=\"d_com\" $HIGHLIGHT READONLY>";
echo "<tr>";
$net_amt=$t_amount+$due_amt;

//echo "<td align=center bgcolor=$color colspan=\"3\"><B>Net Commission:$net_amt</B></td>";
echo "<th align=left bgcolor=$color colspan=\"1\"><B>Net Commission:</th><th align=left bgcolor=$color colspan=\"1\"><input type=\"text\" value=\"$net_amt\" name=\"net_com\" $HIGHLIGHT READONLY>";
if($x==0){
echo "<tr><th align=left bgcolor=$color colspan=\"1\">Paid Commission:<th align=left bgcolor=$color colspan=\"1\"><input type=\"text\" value=\"$net_amt\" name=\"p_com\" $HIGHLIGHT><input type=\"hidden\" value=\"$comm\" name=\"t_amount\" $HIGHLIGHT>";
echo "<tr><th bgcolor=$color colspan=\"2\" align=right><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Submit\">";
}
echo "</form></table>";
}

else{
echo "<h1>Commission Already Calculate and Paid to Agent: ".getName('agent_code',$agent_id,'a_name','agent_master')."</h1>";
}
}
if($_REQUEST['op']=='i')
{
     	$net_com=$_REQUEST['net_com'];
     	$p_com=$_REQUEST['p_com'];
	$t_amount=$_REQUEST['t_amount'];
	$agent_id=$_REQUEST['agent'];//echo $agent_id;
	$t_id=getTranId();
	$fy=getFy();
	$sql_statement="INSERT INTO commission_dtl (agent_id,frm_date,action_date,tran_id,commission_amt,collection_amt,paid_commission,due_commission,operator_code,entry_time) VALUES('$agent_id', date(extract('Year' FROM date('$action_date'))||'-'||extract('MONTH' FROM date('$action_date'))||'-01'),'$action_date','$t_id',$net_com,$t_amount,$p_com,($net_com-$p_com),'$staff_id',now())";
	$sql_statement.=";INSERT INTO gl_ledger_hrd (tran_id,action_date,type,fy,operator_code,entry_time)values('$t_id','$action_date','vou','$fy','$staff_id',now())";
	$sql_statement.=";INSERT INTO gl_ledger_dtl(tran_id,amount,dr_cr,account_no,gl_mas_code,particulars) VAlues('$t_id',$p_com,'Dr','$agent_id','63998','comm. paid')";
	$sql_statement.=";INSERT INTO gl_ledger_dtl(tran_id,amount,dr_cr,gl_mas_code,particulars) VAlues('$t_id',$p_com,'Cr','28101','cash')";
	
	//echo  $sql_statement;
	$result=dBConnect($sql_statement);
	if(pg_affected_rows($result)<1){
		echo "<br><h4><font color=\"RED\">Failed to Insert Data Into Database</font></h4>";
		}
	else{
		echo "<br><h4><font color=\"Green\">Note Down the Transaction No: $t_id</font></h4>";
  		}
}	
	

echo "</body>";
echo "</html>";
?>
