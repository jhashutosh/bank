<?php
include "../config/config.php";
$staff_id=verifyAutho();
echo "<html>";
echo "</script>";
echo "<title>Statement";
echo "</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
//
echo "</head>";
echo "<body bgcolor=\"\">";
echo "<font size=+2><b>Voucher Show</b></font>";
echo "<hr>";
echo "<li><A HREF=\"voucherdetails.php\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=700,height=500'); return false;\" >Show According Transaction </A>";

echo "<li><A HREF=\"voucherDaily.php\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=50, width=900,height=750'); return false;\" >Show Date Between </A>";

echo "<li><A HREF=\"tran_delete.php\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=50, width=900,height=750'); return false;\" >Delete Process SB/VOUCHER </A>";

//echo "<li><A HREF=\"tran_amt_update.php\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=50, width=900,height=750'); return false;\" >Amount Update </A>";


?>
