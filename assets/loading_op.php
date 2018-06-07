<?php
include "../config/config.php";
$q=trim(strtolower($_REQUEST['q']));
if(empty($q)){
makeSelectpost("","gl_code","");
}
else if($q=='21100'){
makeSelectpost($immovable_asset_array,"gl_code","");

}

else if($q=='21200'){
makeSelectpost($furniture_machinery_asset_array,"gl_code","");
}

else if($q=='21300'){
makeSelectpost($vehicles_utilities_array,"gl_code","");
}
else if($q=='21400' ){
makeSelectpost($livestock_array,"gl_code","");
}

else if($q=='21900'){
makeSelectpost($miscellaneous_fixed_array,"gl_code","");
}
else{
makeSelectpost("","gl_code","");

}

?>
