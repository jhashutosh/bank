<?php
include "../config/config.php";
$staff_id=verifyAutho();
$account_no=trim(strtoupper($_REQUEST["account_no"]));
$menu=$_REQUEST["menu"];
//echo "<h1>$menu</h1>";
$op=$_REQUEST['op'];
//echo "<h1>$op</h1>";
if($menu=='ccb'){$account_no=getData($account_no);}
$_SESSION['current_account_no']=$account_no;
$_SESSION['current_account_type']=$menu;
if(!strcmp($menu,'sb')){header("Location: ../sb/sb_account_statement.php?menu=$menu");}
if(!strcmp($menu,'fd')){header("Location: ../fd/fd_statement.php?menu=$menu"); }
if(!strcmp($menu,'rd')){header("Location: ../rd/rd_statement.php?menu=$menu");}
if(!strcmp($menu,'hsb')){header("Location: ../hsb/hsb_statement.php?menu=$menu");}
if(!strcmp($menu,'sh')){header("Location: ../share/share_statement.php?menu=$menu");}
if(!strcmp($menu,'ri')){header("Location: ../ri/ri_statement.php?menu=$menu");}
if(!strcmp($menu,'cust')){header("Location: ../customer/customer_statement.php?menu=$menu");}
if(!strcmp($menu,'mis')){header("Location: ../mis/mis_statement.php?menu=$menu"); }
if(!strcmp($menu,'kcc')){header("Location: ../kcc/kcc_loan_statement.php?menu=$menu"); }
if(!strcmp($menu,'shg')){header("Location: ../shg/shg_mem_detail.php?menu=$menu");}
if(!strcmp($menu,'mt')){header("Location: ../mtloan/mtloan_statement.php?menu=$menu");}
if(!strcmp($menu,'mtb')){header("Location: ../mtb/mtb_statement.php?menu=$menu");}
if(!strcmp($menu,'ks')){header("Location: ../ksloan/ksloan_statement.php?menu=$menu");}
if(!strcmp($menu,'pl')){header("Location: ../pl/pl_statement.php?menu=$menu");}
if(!strcmp($menu,'ccl')){header("Location: ../ccl/ccl_statement.php?menu=$menu");}
if(!strcmp($menu,'ser')){header("Location: ../service/service_statement.php?menu=$menu");}
if(!strcmp($menu,'fis')){header("Location: ../fisary/fis_statement.php?menu=$menu");}
if(!strcmp($menu,'car')){header("Location: ../carloan/car_statement.php?menu=$menu");}
if(!strcmp($menu,'hbl')){header("Location: ../house/house_statement.php?menu=$menu");}
if(!strcmp($menu,'kpl')){header("Location: ../kpl/kpl_statement.php?menu=$menu");}
if(!strcmp($menu,'sfl')){header("Location: ../sfl/sfl_statement.php?menu=$menu");}
if(!strcmp($menu,'ofl')){header("Location: ../ofl/ofl_statement.php?menu=$menu");}
if(!strcmp($menu,'bdl')){header("Location: ../bdl/bdl_statement.php?menu=$menu");}
if(!strcmp($menu,'spl')){header("Location: ../spl/spl_statement.php?menu=$menu");}
if(!strcmp($menu,'rsh')){header("Location: ../retail/jumper.php?menu=$menu&op=$op");}
if(!strcmp($menu,'jlg')){header("Location: ../jlg/jlg_mem_detail.php?menu=$menu");}
if(!strcmp($menu,'add')){header("Location: ../add/sb_account_statement.php?menu=$menu");}
if(!strcmp($menu,'lad')){header("Location: ../lad/lad_statement.php?menu=$menu");}
if(!strcmp($menu,'sao')){header("Location: ../sao/sao_loan_statement.php?menu=$menu");}
if(!strcmp($menu,'nf')){header("Location: ../nf/nf_statement.php?menu=$menu");}
//----------------------------sujoy--------------------------------
//if(!strcmp($menu,'lt')){header("Location: ../lt/lt_statement.php?menu=$menu");}
//if(!strcmp($menu,'staff')){header("Location: ../staffloan/staff_statement.php?menu=$menu");}
//-------------------------------------------------------------------------------
if(!strcmp($menu,'ln')){header("Location: ../land/land_statement.php?menu=$menu");}
if(!strcmp($menu,'ccb')){header("Location: ../ccb-oth/bank_statement.php?menu=$menu");}
if(!strcmp($menu,'cca')){header("Location: ../ccb-oth/ca/ca_statement.php?menu=$menu");}
if(!strcmp($menu,'csb')){header("Location: ../ccb-oth/sb/sb_statement.php?menu=$menu");}
if(!strcmp($menu,'cfd')){header("Location: ../ccb-oth/fd/fd_statement.php?menu=$menu");}
if(!strcmp($menu,'crd')){header("Location: ../ccb-oth/rd/rd_statement.php?menu=$menu");}
if(!strcmp($menu,'cri')){header("Location: ../ccb-oth/ri/ri_statement.php?menu=$menu");}
if(!strcmp($menu,'min')){header("Location: ../mini/mini_statement.php?menu=$menu");}

?>
