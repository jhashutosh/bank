<?php
include "../config/config.php";
$staff_id=verifyAutho();
$op=$_REQUEST['op'];
$mode=$_REQUEST['mode'];
$amount=$_REQUEST['amount'];
$ac_date=$_REQUEST['ac_date'];
$fy=$_REQUEST['fy'];
//echo $op;
$adv_id=$_REQUEST['adv_typ'];
if($op=='i'){
$sql="select ast_code,liab_code from advance_link where id=$adv_id";
$res=dBConnect($sql);
$row=pg_fetch_array($res,0);
$ast_code=$row[0];
$liab_code=$row[1];
$sql_statement="select coalesce(sum(dr)-sum(cr),0) as dr_amt,'debit' from(SELECT account_no,gl_mas_code,sum(debit) dr,sum(credit) cr from mas_gl_tran where particulars='adv' and (account_no is not null and account_no <> '')   group by account_no,gl_mas_code having account_no='$id' and gl_mas_code in('".$row[0]."','".$row[1]."') ) as a";
$result=dBConnect($sql_statement);
//echo $sql_statement;
$dr_amt_exist=pg_result($result,'dr_amt');
//echo $dr_amt_exist;
//echo $mode;

   if ($dr_amt_exist>=0){
   
   
  		 if($mode=='dr'){  		 
  		 $dr_amt=$amount;
  		 $dr_code=$ast_code;   
   				}
   				
   		 else		{
   		 
   		 	if($amount>$dr_amt_exist){
   		 	
   		 	$cr_code_ast=$ast_code;
   		 	$cr_amt_ast=$dr_amt_exist;
   		 	
   		 	$cr_code=$liab_code;
   		 	$cr_amt=$amount-$dr_amt_exist;
   		 				}
   		 	else			{
   		 	$cr_code=$ast_code;
   		 	$cr_amt=$amount;
   		 				}
   		
   		
		    		}
   			}


		else	{
		
		 if($mode=='dr'){
		 
		 	if($amount>abs($dr_amt_exist)){
   		 	
   		 	$dr_code_liab=$liab_code;
   		 	$dr_amt_liab=abs($dr_amt_exist);
   		 	
   		 	$dr_code=$ast_code;
   		 	$dr_amt=$amount-abs($dr_amt_exist);
   		 				}
   		 	else			{
   		 	$dr_code=$liab_code;
   		 	$dr_amt=$amount;
   		 				}
   				}
   				
   		else		{
   			    $cr_amt=$amount;
   			    $cr_code=$liab_code;  		
   				}
  			}
 
 
 $t_id=getTranId(); 			
 if($mode=='dr'){
 $sql_statement="insert into gl_ledger_dtl (tran_id,gl_mas_code,amount,dr_cr,particulars,account_no) 
 values ('$t_id','$dr_code',$dr_amt,'Dr','adv','$id') ";
 if($dr_amt_liab>0)
 $sql_statement.=";insert into gl_ledger_dtl (tran_id,gl_mas_code,amount,dr_cr,particulars,account_no) 
 values ('$t_id','$dr_code_liab',$dr_amt_liab,'Dr','adv','$id')";
 $sql_statement.=";insert into gl_ledger_dtl (tran_id,gl_mas_code,amount,dr_cr,particulars) 
 values ('$t_id','28101',$amount,'Cr','adv')"; 
 		}
 else		{
  $sql_statement="insert into gl_ledger_dtl (tran_id,gl_mas_code,amount,dr_cr,particulars,account_no) 
 values ('$t_id','$cr_code',$cr_amt,'Cr','adv','$id') ";
 if($cr_amt_ast>0)
 $sql_statement.=";insert into gl_ledger_dtl (tran_id,gl_mas_code,amount,dr_cr,particulars,account_no) 
 values ('$t_id','$cr_code_ast',$cr_amt_ast,'Cr','adv','$id')";
  $sql_statement.=";insert into gl_ledger_dtl (tran_id,gl_mas_code,amount,dr_cr,particulars) 
 values ('$t_id','28101',$amount,'Dr','adv')"; 
 
 		}
 $sql_statement.=";insert into gl_ledger_hrd (tran_id,type,action_date,fy,operator_code,entry_time) values ('$t_id','adv','$ac_date','$fy','$staff_id',now())";
$result=dBConnect($sql_statement);
//echo $sql_statement;
if(pg_affected_rows($result)<1)
echo "<h4><font color='red'>Sorry Couldn't Process</h4>";
/*else
header("location:main.php");*/
}	
 ?>
<HTML>
<head>
<link rel="stylesheet" type="text/css" href="../css/test.css" />
<script src="../JS/calendar.js"></script>
</head>
<body>
<form name='f1' action='transaction.php?op=i&name=<?echo $name?>&id=<?php echo $id?>' method='post'>
<table align='center' width='80%' bgcolor='' border='1' class='border'>
<tr><td align='center' colspan='2' bgcolor='#606060'><font size=+1  color='#FFFBF0'>Advance Payment/Receive  <font size=+2><?php echo $name ?>&nbsp;&nbsp;[<?echo $id?>]</td></tr>
<tr><td align='right' bgcolor="#EFEFEF"><font color='#606060' size=2>Purpose</td>
<td bgcolor='#EFEFEF'><select name='adv_typ' id='adv_typ'>
<?php $sql="select id,adv_desc from advance_link";
$res=dBConnect($sql);
for($j;$j<pg_NumRows($res);$j++){
$row=pg_fetch_array($res,$j);
echo"<option value='".$row['id']."'>".ucwords($row['adv_desc'])."</option>";}?>
</select></td></tr>
<tr><td align='right' bgcolor='#EFEFEF'><font color='#606060' size=2>Advance Mode</td>
<td bgcolor='#EFEFEF'><input type='radio' name='mode' id='mode' value='dr'> Payment
<input type='radio' name='mode' id='mode'  value='cr'> Received</td></tr>
<tr><td align='right' bgcolor='#EFEFEF'><font color='#606060' size=2>Amount</td><td bgcolor='#EFEFEF'><input type='text' name='amount' id='amount' size='7' <?echo $HIGHLIGHT?>> Rs.</td></tr>
<tr><td align='right' bgcolor='#EFEFEF'><font color='#606060' size=2>Action Date</td><td bgcolor='#EFEFEF'> <input type="TEXT" name="ac_date" id="ac_date" size="12" onclick="showCalendar(f1.ac_date,'dd.mm.yyyy','Choose Date')" <?echo $HIGHLIGHT?> ><font color='red'> *</font>
</td></tr>
<tr><td align='right' colspan='2'><input type='submit' value='submit'></td></tr>
</table>
</form>
</body>
</HTML>
