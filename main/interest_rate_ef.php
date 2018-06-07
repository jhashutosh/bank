<?php
include "../config/config.php";
$staff_id=verifyAutho();
$status=$_REQUEST['status'];
$menu=$_REQUEST['menu'];
$id=$_REQUEST['id'];
if ($menu=='fd'|| $menu=='hsb'){$method='day';}
if ($menu=='ri' || $menu=='rd'){$method='Months';}
if ($menu=='mis'){$method='year';}
echo "<html>";
echo "<head>";
echo "<title>Entry Form - Table: Interest_rate";
echo "</title>";
echo "<script src=\"../JS/calendar.js\">";
echo "</script>";
echo "</head>";
?>
<script>
function validator1(f)
	{	//alert("ok");
		var msg='';//alert("msg");
		if(f.rate.value.length==0 )
		{
			msg+="Please Give Rate..\n";//return false;
			//if(f.rate.value==0 ) 
		}
		if(msg==''){
			return true;
		}
		else{
			alert(msg);
			return false;
		}
	}
function numbersonly(e){
	var unicode=e.charCode? e.charCode : e.keyCode;
	//alert(unicode)
	if (unicode!=8){ 
		if (unicode<46||unicode>57||unicode==47) {
			return false;		
		}
	}
	
}

</script>
<?php
$bgcolor=empty($status)?"WHITE":"PINK";
echo "<body bgcolor=$bgcolor onload=\"period.focus();\">";
echo "<h1>";
$fName=empty($status)?"Entry":"Update";
echo "$fName Form -".strtoupper($menu)." interest rate";
echo "</h1>";
echo "<h3>Please fill-up this form";
echo "</h3>";
echo "<hr>";
	if(empty($status)){
       	$sql_statement="SELECT COUNT(*) FROM interest_rate where deposit_type='$menu'";
	//echo 	$sql_statement;
	$result=dBConnect($sql_statement);
	if(pg_NumRows($result)==0) {
		//echo "<h4>Not found!!!</h4>";
		// return ;
		$id=0;
	} else {
			$row=pg_fetch_array($result);
			$id=$row['count'];
		}
	$id=$menu."_rate-".($id+1);
	}
	else{
		$sql_statement="SELECT * FROM interest_rate where id='$id'";
		$result=dBConnect($sql_statement);
		if(pg_NumRows($result)==0) {
		echo "Record Not Found !!!!!!!!";
		}
		else{
		$period=pg_result($result,'period');
		$rate=pg_result($result,'rate');
		$scheme=$scheme_array[pg_result($result,'scheme')];
		$effective_date=pg_result($result,'year_witheffect');
		$remarks=pg_result($result,'remarks');
		}
	}
echo "<form method=\"POST\" action=\"interest_rate_evf.php?menu=$menu\"><br>";
echo "<table>";
echo "<tr><td align=\"left\">Id:<td><input type=\"TEXT\" name=\"id\" size=\"25\" value=\"$id\" Readonly $HIGHLIGHT><br>";
if ($menu!='sb'){
echo "<tr><td align=\"left\">Period:<td><input type=\"TEXT\" name=\"period\" id=\"period\" size=\"25\" value=\"$period\" $HIGHLIGHT>&nbsp;$method";
}
echo "<tr><td align=\"left\">Rate&nbsp;:<td><input type=\"TEXT\" name=\"rate\" id=\"rate\" size=\"22\" value=\"$rate\" $HIGHLIGHT>&nbsp;% p.a.";
echo "<tr><td align=\"left\">Year With Effect:<td><input type=\"TEXT\" name=\"effective_date\" size=\"25\" value=\"$effective_date\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(form1.effective_date,'dd/mm/yyyy','Choose Date')\">";
echo "<tr><td align=\"left\">Scheme:<td>";
makeSelect($scheme_array,"scheme","$scheme");
echo "<tr><td valign=\"top\" align=\"left\">Remarks:<td><textarea name=\"remarks\" rows=\"3\" cols=\"49\" $HIGHLIGHT>$remarks</textarea><br>";
echo "<input type=\"HIDDEN\" name=\"method\"  value=\"$method\">";
echo "<input type=\"HIDDEN\" name=\"status\"  value=\"$status\">";
echo "<tr><td><td align=\"right\"><input type=\"SUBMIT\" name=\"SUBMIT_BUTTON\" value=\"Submit\">";
echo "  <input type=\"RESET\" name=\"RESET_BUTTON\" value=\"Reset\"><br>";
echo "</table>";
echo "</form>";
echo "</body>";
echo "</html>";

?>
