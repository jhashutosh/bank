<?php

include "../config/config.php";
$staff_id=verifyAutho();
$crop_id=$_GET["crop_id"];
$chkinfo=@$_GET["chkinfo"] or exit("No Info Selected"); 
if(isset($chkinfo)){
  echo "<h1> Rs.".getCreditLimit($chkinfo,$crop_id)."/=</h1>";
}



?>
