<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<h1><center><font color=GREEN>Loan Report</font></h1><hr>";
echo "<ol>";
//echo "<li><a href=\"list_of_loan.php?menu=$menu\">List of Loan According to Account No.</a>";
//echo "<li><a href=\"consolidated_loan_list.php?menu=$menu\">Consolidated Loan List</a>";
echo "<li><a href=\"list_of_loan.php?menu=$menu\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=750,height=800'); return false;\">List of Loan According to Account No.</a>";
echo "<li><a href=\"member_list.php?menu=$menu\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=750,height=800'); return false;\">Member List</a>";

echo "<li><a href=\"consolidated_loan_list.php?menu=$menu\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1250,height=500'); return false;\">Consolidated Loan List</a>";
echo "<li><a href=\"list_of_loan.php?menu=$menu&op=d\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=750,height=800'); return false;\">List of Due Loan List</a>";
echo "<li><a href=\"list_of_loan.php?menu=$menu&op=o\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=750,height=800'); return false;\">List of Over Due Loan List</a>";
echo "<li><a href=\"loan_recovery_rpt.php?menu=$menu\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=50, width=900,height=800'); return false;\">Recovery Summary</a>";

echo "<li><a href=\"last_loan_recovery_rpt.php?menu=$menu\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=50, width=900,height=800'); return false;\">Last Recovery Summary</a>";


echo "<li><a href=\"loan_list.php?menu=$menu\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=50, width=720,height=1000'); return false;\">Details List</A>";
if($menu=='pl'){
echo "<li><a href=\"morgate_reg.php?menu=$menu\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=50, width=720,height=1000'); return false;\">Certificate Morgate Register</A>";
echo "<li><a href=\"release_reg.php?menu=$menu\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=50, width=720,height=1000'); return false;\">Certificate Release Register</A>";
}
if($menu=='kpl'){
echo "<li><a href=\"morgate_reg.php?menu=$menu\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=50, width=720,height=1000'); return false;\">Certificate Morgate Register</A>";
echo "<li><a href=\"release_reg.php?menu=$menu\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=50, width=720,height=1000'); return false;\">Certificate Release Register</A>";
}
if($menu=='bdl'){
echo "<li><a href=\"morgate_reg.php?menu=$menu\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=50, width=720,height=1000'); return false;\">Certificate Morgate Register</A>";
echo "<li><a href=\"release_reg.php?menu=$menu\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=50, width=720,height=1000'); return false;\">Certificate Release Register</A>";
}if($menu=='ccl'){
echo "<li><a href=\"morgate_reg.php?menu=$menu\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=50, width=720,height=1000'); return false;\">Certificate Morgate Register</A>";
echo "<li><a href=\"release_reg.php?menu=$menu\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=50, width=720,height=1000'); return false;\">Certificate Release Register</A>";
}if($menu=='spl'){
echo "<li><a href=\"morgate_reg.php?menu=$menu\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=50, width=720,height=1000'); return false;\">Certificate Morgate Register</A>";
echo "<li><a href=\"release_reg.php?menu=$menu\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=50, width=720,height=1000'); return false;\">Certificate Release Register</A>";
}
if($menu=='kcc'){
echo "<li><a href=\"crop_loan_list.php?menu=$menu\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=50, width=1210,height=750'); return false;\">Crop Wise Loan Statement</A>";
echo "<li><a href=\"subvention.php?menu=$menu\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=50, width=1210,height=750'); return false;\">Subvention Claim</A>";

echo "<li><a href=\"disbursed.php?menu=$menu\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=50, width=1210,height=750'); return false;\">Kcc Loan Disbursed</A>";

echo "<li><a href=\"loan_d_list.php?menu=$menu\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=50, width=720,height=1000'); return false;\">Crop wise Due Details List</A>";

echo "<li><a href=\"loan_od_list.php?menu=$menu\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=50, width=720,height=1000'); return false;\">Crop wise Overdue Details List</A>";
}
$sql_statement="SELECT count(*) FROM loan_repayment where loan_type='$menu' and npa_status='y'";
$result=dBConnect($sql_statement);
if(pg_result($result,'count')>0)
{echo "<li><a href=\"lost_asset.php?menu=$menu\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=50, width=910,height=750'); return false;\">Lost Asset</a>";
}


?>
