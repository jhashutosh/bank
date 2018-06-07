<?php
include "../config/config.php";
$staff_id=verifyAutho();
$operator_code=$staff_id;
$group_no=$_REQUEST["group_no"];
$loan_no=$_REQUEST["loan_no"];
$tran_dt=$_REQUEST["action_date"];
$loan_curr=$_REQUEST["loan_curr"];
$interest=$_REQUEST["due_int"];
$over_int=$_REQUEST["over_due_int"];
$amount=$_REQUEST["amount"];
$menu=$_REQUEST['menu'];
$tpa=$_REQUEST['tpa'];
//$expenses=$_REQUEST['expenses'];
$expenses=0;
$remarks=$_REQUEST['remarks'];
$repay_dt=$_REQUEST['repay_date'];
$db=pg_pConnect("host=$HOST dbname=$DATABASE");
$result=pg_Exec($db,$DATESTYLE);
echo "<body bgcolor=\"silver\">";
//echo "Amount=$amount ==Total=$tpa"; 
if($amount>$tpa)
{
 echo "<h1><center><b><font color=BLUE><Blink>Your payment too Higher Than your Due Amount !!!!!</b></font></blink></h1>";
 echo "<h3><center><b><font color=RED>Your payment should not excess Rs. ".($loan_curr+$interest+$over_int)."</b></font></h3>";
}
else
{
    if($amount>($interest+$over_int))
 	{
		//echo "Hi i'm here if";
		$recovery_int=$interest;
		$recovery_due_int=$over_int;
		$recovery_principal=($amount-($interest+$over_int));
		$balance_over=0;
		$balance_int=0;
		$temp=($amount-($interest+$over_int));
		//echo "temp->".$temp;
  		//echo "temp_loan->".$loan_curr;
		settype($loan_curr,"int");
		//echo "temp_loan->".$loan_curr;
		$balance_principal=$loan_curr-$temp;
		settype($balance_principal,"int");
		//echo "principal->".$balance_principal;
 	}
    else{
       if($amount>$over_int)
         {
	       echo "Hi i'm here now elseif ";
               $recovery_due_int=$over_int;
	       $recovery_principal=0;
	       $recovery_int=$amount-$over_int;
	       $balance_over=0;
	       $balance_int=$interest-$recovery_int;
	       $balance_principal=$loan_curr;	
	  }
       else
         {
 		//echo "Hi i'm here again else else";
                $recovery_due_int=$amount;
		$recovery_principal=0;
		$recovery_int=0;
		$balance_over=$over_int-$amount;
		$balance_int=$interest;
		$balance_principal=$loan_curr;
		
         }
     }
		
                /*echo "<br>rdi->".$recovery_due_int;
		echo "<br>rp->".$recovery_principal;
		echo "<br>rt->".$recovery_int;
		echo "<br>bod->".$balance_over;
		echo "<br>bt->".$balance_int;
		echo "<br>bp->".$balance_principal;*/
      if($balance_principal==0)
       {
	$sql_statement="INSERT INTO shg_loan_ledger (loan_account_no,action_date, recovery_amount_principal, recovery_amount_interest,recovery_over_interest, recovery_legal_expenses,balance_principal,balance_interest, balance_overdue_int, remarks,operator_code,status,entry_time) VALUES('$loan_no','$tran_dt',$recovery_principal,$recovery_int,$recovery_due_int,$expenses,$balance_principal,$balance_int,$balance_over,'$remarks','$operator_code','cl',now())";
	$sql_statement=$sql_statement.";UPDATE customer_account set status='cl' where account_type='ln' AND account_no='$loan_no'";
	$sql_statement=$sql_statement.";UPDATE shg_loan_info set loan_status='close',date_of_closing='$tran_dt' where loan_account_no='$loan_no'";
	//echo $sql_statement;
	}
     else
   	{	
		$sql_statement="INSERT INTO shg_loan_ledger (loan_account_no,action_date, recovery_amount_principal, recovery_amount_interest,recovery_over_interest, recovery_legal_expenses,balance_principal,balance_interest, balance_overdue_int, remarks,operator_code,status,entry_time) VALUES('$loan_no','$tran_dt',$recovery_principal,$recovery_int,$recovery_due_int,$expenses,$balance_principal,$balance_int,$balance_over,'$remarks','$operator_code','pt',now())";
  	 }
//echo $sql_statement;
     $result=pg_Exec($db,$sql_statement);
     if(pg_affected_rows($result)<1) {
	echo "<br><h5><font color=\"RED\">Failed to insert data into database.</font></h5>";
	}
     else{
	echo "<br><h5><font color=\"GREEN\">Data entered into database.</font></h5>";
	header("Location:shg_loan_statement.php?menu='ln'&account_no=$loan_no");
        }

}
echo "<br><br><br>";
footer();
echo "</body>";
echo "</html>";

?>
