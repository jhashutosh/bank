<?php
include "../config/config.php";
$q=trim(strtolower($_REQUEST['q']));
if(empty($q)){
makeSelect("","gl_code","");
}
else if($q=='21100'){
makeSelect($immovable_asset_array,"gl_code","");
}

else if($q=='21200'){
makeSelect($furniture_machinery_asset_array,"gl_code","");
}

else if($q=='21300'){
makeSelect($vehicles_utilities_array,"gl_code","");
}
else if($q=='21400' ){
makeSelect($livestock_array,"gl_code","");
}

else if($q=='21900'){
makeSelect($miscellaneous_fixed_array,"gl_code","");
}
else{
makeSelect("","gl_code","");

}


?>
