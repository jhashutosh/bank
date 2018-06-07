<?php
/*
*
*@params mode=dr for customer and mode=cr for vendor
*
*
*/
function advance_post($adv_desc,$mode,$t_id,$id,$amount){
  //echo "$adv_desc,$mode,$t_id,$id      dddddddddddddddddddddd";
  $sql="select ast_code,liab_code from advance_link where adv_desc='$adv_desc'";
  $res=dBConnect($sql);
  $row=pg_fetch_array($res,0);
  $ast_code=$row[0];
  $liab_code=$row[1];
  $sql_statement="select coalesce(sum(dr)-sum(cr),0) as dr_amt,'debit' from(SELECT account_no,gl_mas_code,sum(debit) dr,sum(credit) cr from mas_gl_tran where type='adv' and (account_no is not null and account_no <> '')   group by account_no,gl_mas_code having account_no='$id' and gl_mas_code in('".$row[0]."','".$row[1]."') ) as a";
  $result=dBConnect($sql_statement);
  echo $sql_statement;
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
 
 
// $t_id=$tran_id; 			
 if($mode=='dr'){
 $sql_statement="insert into gl_ledger_dtl (tran_id,gl_mas_code,amount,dr_cr,particulars,account_no) 
 values ('$t_id','$dr_code',$dr_amt,'Dr','adv','$id') ";
 if($dr_amt_liab>0)
 $sql_statement.=";insert into gl_ledger_dtl (tran_id,gl_mas_code,amount,dr_cr,particulars,account_no) 
 values ('$t_id','$dr_code_liab',$dr_amt_liab,'Dr','adv','$id')";
 //$sql_statement.=";insert into gl_ledger_dtl (tran_id,gl_mas_code,amount,dr_cr,particulars) values ('$t_id','28101',$amount,'Cr','')"; 
 		}
 else		{
  $sql_statement="insert into gl_ledger_dtl (tran_id,gl_mas_code,amount,dr_cr,particulars,account_no) 
 values ('$t_id','$cr_code',$cr_amt,'Cr','adv','$id') ";
 if($cr_amt_ast>0)
 $sql_statement.=";insert into gl_ledger_dtl (tran_id,gl_mas_code,amount,dr_cr,particulars,account_no) 
 values ('$t_id','$cr_code_ast',$cr_amt_ast,'Cr','adv','$id')";
 //$sql_statement.=";insert into gl_ledger_dtl (tran_id,gl_mas_code,amount,dr_cr,particulars) values ('$t_id','28101',$amount,'Dr','')"; 
 }
 $result=dBConnect($sql_statement);
     //echo "<hr>$sql_statement<hr>";

 		}
?>