<?php
include "../config/config.php";
$q=strtolower($_REQUEST['q']);
$s_type=strtolower($_REQUEST['s_type']);
if(empty($q) || empty($s_type)){
echo "<input type=\"TEXT\" name=\"gl_code\" READONLY $HIGHLIGHT>";
}
else if($q=='fd' && $s_type=='ccb'){
echo "<input type=\"TEXT\" name=\"gl_code\" size=\"35\" VALUE=\"Investment in FD(SCB/CCB)[22402]\" READONLY $HIGHLIGHT >";
}
else if($q=='rd' && $s_type=='ccb'){
echo "<input type=\"TEXT\" name=\"gl_code\"  size=\"35\" VALUE=\"Investment in RD(SCB/CCB)[22401]\"READONLY $HIGHLIGHT>";
}
else if($q=='ri' && $s_type=='ccb'){
echo "<input type=\"TEXT\" name=\"gl_code\"  size=\"35\" VALUE=\"Investment in RI(SCB/CCB)[22403]\"READONLY $HIGHLIGHT>";
}
else if($q=='ri' && $s_type=='cm'){
echo "<input type=\"TEXT\" name=\"gl_code\"  size=\"35\" VALUE=\"Investment in RI(Other Banks)[22503]\"READONLY $HIGHLIGHT>";
}
else if($q=='rd' && $s_type=='cm'){
echo "<input type=\"TEXT\" name=\"gl_code\"  size=\"35\" VALUE=\"Investment in RD(Other Banks)[22501]\"READONLY $HIGHLIGHT>";
}
else if($q=='fd' && $s_type=='cm'){
echo "<input type=\"TEXT\" name=\"gl_code\"  size=\"35\" VALUE=\"Investment in RD(Other Banks)[22502]\"READONLY $HIGHLIGHT>";
}
else if($q=='oth' && $s_type=='cm'){
echo "<input type=\"TEXT\" name=\"gl_code\"  size=\"35\" VALUE=\"Investment in Others Deposits(Other Banks)[22599]\"READONLY $HIGHLIGHT>";
}
else if($q=='oth' && $s_type=='ccb'){
echo "<input type=\"TEXT\" name=\"gl_code\"  size=\"35\" VALUE=\"Investment in Others Deposits(SCB/CCB)[22499]\"READONLY $HIGHLIGHT>";
}
else if($q=='oth' && $s_type=='oth'){
echo "<input type=\"TEXT\" name=\"gl_code\"  size=\"35\" VALUE=\"Other Investments[22901]\"READONLY $HIGHLIGHT>";
}
else if($s_type=='po'){
echo "<input type=\"TEXT\" name=\"gl_code\"  size=\"35\" VALUE=\"Investment in Post Office[22601]\"READONLY $HIGHLIGHT>";
}
else{
echo "<input type=\"TEXT\" name=\"gl_code\" READONLY $HIGHLIGHT>";
//echo "<td bgcolor=\"#BDB76B\">Loan Catagory:<td bgcolor=\"#BDB76B\">";
}


?>
