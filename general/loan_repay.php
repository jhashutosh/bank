<?php
include "../config/config.php";
$staff_id=verifyAutho();

$menu=$_REQUEST['menu'];
isPermissible($menu);

if($menu=='kcc'){$l_name='KCC';$status='../kcc/kcc_loan_repayment.php?menu=kcc';}
if($menu=='lad'){$l_name='LAD';$status='../lad/lad_loan_repayment.php?menu=lad';}
if($menu=='mt'){$l_name='MT';$status='../mtloan/mtl_loan_repayment.php?menu=mt';}
if($menu=='ks'){$l_name='KS';$status='../ksloan/ksl_loan_repayment.php?menu=ks';}
if($menu=='pl'){$l_name='PLEDGE';$status='../pl/pl_loan_repayment.php?menu=pl';}
if($menu=='ofl'){$l_name='OFL';$status='../ofl/ofl_loan_repayment.php?menu=ofl';}
//if($menu=='shg'){$l_name='SHG';$status='sgl';}
if($menu=='ccl'){$l_name='Cash Credit';$status='../ccl/ccl_loan_repayment.php?menu=ccl';}
if($menu=='kpl'){$l_name='Kishan Bikhash Pathra';$status='../kpl/kpl_loan_repayment.php?menu=kpl';}
if($menu=='bdl'){$l_name='Bond';$status='../bdl/bdl_loan_repayment.php?menu=bdl';}
if($menu=='sfl'){$l_name='Staff';$status='../sfl/sfl_loan_repayment.php?menu=sfl';}
if($menu=='ser'){$l_name='Service';$status='../service/service_loan_repayment.php?menu=ser';}

if($menu=='hbl'){$l_name='House';$status='../house/house_loan_repayment.php?menu=hbl';}

if($menu=='car'){$l_name='car';$status='../carloan/car_loan_repayment.php?menu=car';}
if($menu=='fis'){$l_name='Fisary';$status='../fisary/fis_loan_repayment.php?menu=fis';}
if($menu=='spl'){$l_name='SMP';$status='../spl/spl_loan_repayment.php?menu=spl';}
if($menu=='sao'){$l_name='SAO';$status='../sao/sao_loan_repayment.php?menu=sao';}
if($menu=='mtb'){$l_name='MTB';$status='../mtb/mtb_loan_repayment.php?menu=mtb';}
if($menu=='nf'){$l_name='NF';$status='../nf/nf_loan_repayment.php?menu=nf';}
echo "<script language=\"JavaScript\" src=\"../JS/gen_validatorv31.js\" type=\"text/javascript\"></script>";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"ac.focus();\">";
echo "<h1>$l_name Loan Repayment Form</h1>";
echo "varify before submit";
echo "<hr>";
echo "<form name=\"f1\" action=\"$status\" method=\"post\">";
echo "<table bgcolor=\"BLACK\" width=\"70%\" align=\"CENTER\">";
echo "<tr bgcolor=YELLOW><td align=\"RIGHT\">Action Date :<td><input type=\"TEXT\" name=\"action_date\" size=\"12\" id=\"ac\" VALUE=\"".date('d.m.Y')."\" $HIGHLIGHT>&nbsp;<input type=\"SUBMIT\" VALUE=\"Enter\" $HIGHLIGHT>"; 
echo "</form>";
?>
<script language="JavaScript" type="text/javascript">
 var frmvalidator  = new Validator("f1");
 frmvalidator.addValidation("action_date","req","Please enter Issuing Date");
</script>
