<?
include "../config/config.php";
$q=trim(strtolower($_REQUEST['q']));
$q1=trim(strtolower($_REQUEST['q1']));
$o=trim(strtolower($_REQUEST['o']));
$flag=$_REQUEST['f'];
//echo "<h1>$q</h1>";
if($flag=='dep')
{
	if(empty($q)){
		     }
	else if($q=='21100'){
				makeSelectAsset($immovable_asset_array,"gl_code","","onChange=\"f4(this.value,'21100');\"");
			    }

	else if($q=='21200'){
				makeSelectAsset($furniture_machinery_asset_array,"gl_code","","onChange=\"f4(this.value,'21200');\"");
			    }

	else if($q=='21300'){
				makeSelectAsset($vehicles_utilities_array,"gl_code","","onChange=\"f4(this.value,'21300');\"");
			    }
	else if($q=='21400' ){
				makeSelectAsset($livestock_array,"gl_code","","onChange=\"f4(this.value,'21400');\"");
			    }

	else if($q=='21900'){
				makeSelectAsset($miscellaneous_fixed_array,"gl_code","","onChange=\"f4(this.value,'21900');\"");
			    }
	else{
		makeSelect("","gl_code","");
	    }
	$code=makeSelectImovableDepreCode($immovable_depretation_array,$q1);
	echo "<td><input type=\"hidden\" name=\"code\" id=\"code\" size=\"10\" value=\"$code\" $HIGHLIGHT></td>";

	$depre_code=makeSelectDepreCode($immovable_depretation_array,$q1);
	echo "<td><input type=\"hidden\" name=\"depre\" id=\"depre\" size=\"10\" value=\"$depre_code\" $HIGHLIGHT></td>";

}
else
{
	if(empty($q)){
         	     }
	else if($q=='21100'){
				makeSelectAsset($immovable_asset_array,"gl_code","","onChange=\"f3(this.value,'21100');\"");
			    }

	else if($q=='21200'){
				makeSelectAsset($furniture_machinery_asset_array,"gl_code","","onChange=\"f3(this.value,'21200');\"");
			    }

	else if($q=='21300'){
				makeSelectAsset($vehicles_utilities_array,"gl_code","","onChange=\"f3(this.value,'21300');\"");
			    }
	else if($q=='21400' ){
				makeSelectAsset($livestock_array,"gl_code","","onChange=\"f3(this.value,'21400');\"");
			    }

	else if($q=='21900'){
				makeSelectAsset($miscellaneous_fixed_array,"gl_code","","onChange=\"f3(this.value,'21900');\"");
			    }
	else{

	     }
	if(empty($q1)){

			}
	else { 
		makeSelectAssetId("asset_id","asset_master",$q1);
		}
}

?>
