<?php
include "../config/config.php";
$q=strtolower($_REQUEST['q']);
$s_type=strtolower($_REQUEST['s_type']);
if(empty($q) || empty($s_type)){
//echo "<td bgcolor=\"#BDB76B\">Loan Catagory:<td bgcolor=\"#BDB76B\">";
makeSelectValue("","gl_code","");
}
else if($q=='ln' && $s_type=='ccb'){
//echo "<td bgcolor=\"#BDB76B\">Loan Catagory:<td bgcolor=\"#BDB76B\">";
makeSelectValue($ccb_loan_array,"gl_code","");
}

else if($q=='ln' && $s_type=='cm'){
//echo "<td bgcolor=\"#BDB76B\">Loan Catagory:<td bgcolor=\"#BDB76B\">";
makeSelectValue($comercial_loan_array,"gl_code","");
}

else if($q=='ln' && $s_type=='ot'){
//echo "<td bgcolor=\"#BDB76B\">Loan Catagory:<td bgcolor=\"#BDB76B\">";
makeSelectValue($other_loan_array,"gl_code","");
}
else if($q=='ln' && $s_type=='gvt'){
//echo "<td bgcolor=\"#BDB76B\">Loan Catagory:<td bgcolor=\"#BDB76B\">";
makeSelectValue($govt_loan_array,"gl_code","");
}
else{
makeSelectValue("","gl_code","");
//echo "<td bgcolor=\"#BDB76B\">Loan Catagory:<td bgcolor=\"#BDB76B\">";
}


?>
