<?php
include "../config/config.php";
$staff_id=verifyAutho();
$customer_id=trim(strtoupper($_REQUEST['customer_id']));
$account_no=trim(strtoupper($_REQUEST['account_no']));
$menu=$_REQUEST['menu'];
$op=$_REQUEST['op'];
//echo "<h1>$op</h1>";
if($menu=='ccb'){$account_no=getData($account_no);}
$_SESSION['current_customer_id']=$customer_id;
$_SESSION['current_account_no']=$account_no;
$_SESSION['current_account_type']=$menu;
if(!strcmp($menu,'tf')){header("Location: ../tf/tf_ledger_ef.php?menu=$menu&customer_id=$customer_id&account_no=$account_no");}//c
if(!strcmp($menu,'sb')){header("Location: ../sb/sb_ledger_ef.php?deposit=1&menu=$menu&customer_id=$customer_id&account_no=$account_no");}//c
if(!strcmp($menu,'fd')){header("Location: ../fd/fd_ledger_ef.php?menu=$menu&customer_id=$customer_id&account_no=$account_no");}//c
if(!strcmp($menu,'ri')){header("Location: ../ri/ri_ledger_ef.php?menu=$menu&customer_id=$customer_id&account_no=$account_no");}
if(!strcmp($menu,'rd')){header("Location: ../rd/rd_ledger_ef.php?menu=$menu&customer_id=$customer_id&account_no=$account_no");}//c
if(!strcmp($menu,'mis')){header("Location: ../mis/mis_ledger_ef.php?menu=$menu&customer_id=$customer_id&account_no=$account_no"); }
if(!strcmp($menu,'cc')){header("Location: ../cc/cc_ledger_ef.php?menu=$menu&customer_id=$customer_id&account_no=$account_no");}//c
if(!strcmp($menu,'hsb')){header("Location: ../hsb/hsb_statement.php?menu=$menu");}
if(!strcmp($menu,'sh')){header("Location: ../share/share_statement.php?menu=$menu");}


if(!strcmp($menu,'kcc')){header("Location: ../kcc/kcc_loan_issue.php?menu=$menu&customer_id=$customer_id&account_no=$account_no"); }
if(!strcmp($menu,'shg')){header("Location: ../shg/shg_mem_detail.php?menu=$menu");}
if(!strcmp($menu,'mt')){header("Location: ../mtloan/mt_loan_issue_ef.php?menu=$menu&customer_id=$customer_id&account_no=$account_no");}
if(!strcmp($menu,'ser')){header("Location: ../service/service_loan_issue_ef.php?menu=$menu&customer_id=$customer_id&account_no=$account_no");}

//if(!strcmp($menu,'hbl')){header("Location: ../house/house_loan_issue_ef.php?menu=$menu&customer_id=$customer_id&account_no=$account_no");}
if(!strcmp($menu,'hbl')){header("Location: ../ofl/ofl_loan_issue_ef.php?menu=$menu&customer_id=$customer_id&account_no=$account_no");}
if(!strcmp($menu,'car')){header("Location: ../carloan/car_loan_issue_ef.php?menu=$menu&customer_id=$customer_id&account_no=$account_no");}
if(!strcmp($menu,'lad')){header("Location: ../lad/lad_loan_issue_ef.php?menu=$menu&customer_id=$customer_id&account_no=$account_no");}//mortgage
if(!strcmp($menu,'pl')){header("Location: ../pl/pl_loan_issue_ef.php?menu=$menu&customer_id=$customer_id&account_no=$account_no");}//mortgage
if(!strcmp($menu,'ccl')){header("Location: ../ccl/ccl_loan_issue_ef.php?menu=$menu&customer_id=$customer_id&account_no=$account_no");}//cash crt.
if(!strcmp($menu,'kpl')){header("Location: ../kpl/kpl_loan_issue_ef.php?menu=$menu&customer_id=$customer_id&account_no=$account_no");}//govt.
if(!strcmp($menu,'sfl')){header("Location: ../sfl/sfl_loan_issue_ef.php?menu=$menu&customer_id=$customer_id&account_no=$account_no");}//stuff
if(!strcmp($menu,'pcl')){header("Location: ../pcl/pcl_loan_issue_ef.php?menu=$menu&customer_id=$customer_id&account_no=$account_no");}//personal ???
if(!strcmp($menu,'ofl')){header("Location: ../ofl/ofl_loan_issue_ef.php?menu=$menu&customer_id=$customer_id&account_no=$account_no");}
if(!strcmp($menu,'bdl')){header("Location: ../bdl/bdl_loan_issue_ef.php?menu=$menu&customer_id=$customer_id&account_no=$account_no");}
if(!strcmp($menu,'spl')){header("Location: ../spl/spl_loan_issue_ef.php?menu=$menu&customer_id=$customer_id&account_no=$account_no");}
if(!strcmp($menu,'fis')){header("Location: ../fisary/fis_loan_issue_ef.php?menu=$menu&customer_id=$customer_id&account_no=$account_no");}
if(!strcmp($menu,'rsh')){header("Location: ../retail/jumper.php?menu=$menu&op=$op");}
if(!strcmp($menu,'ln')){header("Location: ../land/land_statement.php?menu=$menu");}
if(!strcmp($menu,'ccb')){header("Location: ../ccb-oth/bank_statement.php?menu=$menu");}
if(!strcmp($menu,'cca')){header("Location: ../ccb-oth/ca/ca_statement.php?menu=$menu");}
if(!strcmp($menu,'csb')){header("Location: ../ccb-oth/sb/sb_statement.php?menu=$menu");}
if(!strcmp($menu,'cfd')){header("Location: ../ccb-oth/fd/fd_statement.php?menu=$menu");}
if(!strcmp($menu,'crd')){header("Location: ../ccb-oth/rd/rd_statement.php?menu=$menu");}
if(!strcmp($menu,'cri')){header("Location: ../ccb-oth/ri/ri_statement.php?menu=$menu");}
if(!strcmp($menu,'min')){header("Location: ../mini/mini_statement.php?menu=$menu");}
//echo "<h1>$menu  $customer_id  $account_no</h1>";
?>
