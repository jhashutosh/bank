<?php
include "../config/config.php";
//$current_date=(is_string($current_date)?strtotime($current_date):$current_date);
//$loan_el_date=(is_string($loan_el_date)?strtotime($loan_el_date):$loan_el_date);
//$amount="12365";
//echo amount2Rs($amount);
$action_date=date('d.m.Y')-time('86400');
echo $action_date;
?>
