<?php
include "../config/config.php";
registerSession();
if(isset($_REQUEST['menu']))
{
	$menu=$_REQUEST['menu'];
}
else
{
	$menu='';
}
$account=trim($_SESSION['current_account_no']);
function add_nominy($account_no,$typeIn){
	global $TBGCOLOR,$TCOLOR,$type_of_account1_array,$relation_array;
	echo "<table width=\"100%\">";
	echo "<form name=\"f1\" method=\"POST\" action=\"nominy.php\">";
	echo "<tr><td bgcolor=\"blue\" colspan=\"5\" align=\"center\"><font color=\"white\" size=\"4\">Nominy Information  Add </font>";
	echo "<tr><td>Account No. : <td><input type=\"TEXT\" name=\"account_no\" size=10 value=\"$account_no\" readonly $HIGHLIGHT>";
	echo "<tr><td>Nomination :<td> <input type=RADIO value=yes name=r1 onClick=enable_txt(this.value)>Yes&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "<input type=RADIO value=no name=r1 CHECKED onClick=enable_txt(this.value)>No";
	echo "<tr><td>Name of Nominee:<td><input type=TEXT name=n_name size=15 disabled $HIGHLIGHT>";
	echo "<td>Address:<td><input type=TEXT name=n_add size=25 disabled $HIGHLIGHT>";
	echo "<tr><td>Age:<td><input type=TEXT name=n_age size=10  disabled $HIGHLIGHT>";
	echo "<td>Relation:<td>";
	makeSelectDisabled($relation_array,'relation');
	echo "<tr><td>If Nominee is minor:<td>";
	echo "<input type=RADIO value=yes name=r2 onClick=enable_button(this.value);> Yes&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "<input type=RADIO value=no name=r2 CHECKED onClick=enable_button(this.value);>No";
	echo "<tr><td>Date of Birth:<td><input type=\"TEXT\" name=\"ndob\" size=\"25\" disabled value=\"\" readonly>";
	echo "&nbsp;<input type=\"button\" name=\"b1\" value=\"...\" disabled onclick=\"showCalendar(f1.ndob,'dd/mm/yyyy','Choose Date')\">";
	echo "<input type=\"HIDDEN\" name=\"typeIn\" value=\"$typeIn\">";
	echo "<td><input type=submit value=Add name=add_rec>&nbsp;";

	echo "</form>";
	echo "</table>";

}//end of add function
//add_rec start
if(isset($_REQUEST['add_rec']))
{
	$account_no=$_REQUEST['account_no'];
	$typeIn=$_REQUEST['typeIn'];
	$n_name=$_REQUEST['n_name'];
	$n_add=$_REQUEST['n_add'];
	$n_age=$_REQUEST['n_age'];
	$relation=$_REQUEST['relation'];
	$minor_status=$_REQUEST['r2'];
	$dob=$_REQUEST['ndob'];
	$relation=getIndex($relation_array,$relation);
	if($minor_status=="yes")
	       	   {

		     $sql_statement="INSERT INTO nomination (account_no,action_date,account_type,name,address,age, relation,dob, operator_code,entry_time) values('$account_no','$opening_date','$typeIn',lower('$n_name'),lower('$n_add'),$n_age, '$relation','$dob','$staff_id',now())";
		   }
		  else{
		     $sql_statement="INSERT INTO nomination (account_no,action_date,account_type,name, address,age,relation, operator_code,entry_time) values('$account_no',now(),'$typeIn', lower('$n_name'),lower('$n_add'),$n_age,'$relation','$staff_id',now())";
	//echo   $sql_statement;
		  $result=dBConnect($sql_statement);

		      }	
	}//add_rec end

// For update nominy
if(isset($_REQUEST['update']))
{
	$account_no=$_REQUEST['account_no'];
	$name=$_REQUEST['name'];
	$age=$_REQUEST['age'];
	$address=$_REQUEST['address'];
	$relation=$_REQUEST['relation'];
	$relation=getIndex($relation_array,$_REQUEST["relation"]);
	$sql_statement="UPDATE nomination SET name='$name',
	 	age='$age',address='$address',relation='$relation' where account_no='$account_no'"; 
	$result=dBConnect($sql_statement);

}

function nominy($value,$account){
	global $TBGCOLOR,$TCOLOR,$type_of_account1_array,$relation_array;
	$acount_type=RegetIndex($type_of_account1_array,$value);
	//echo "<h1>hello:$acount_type</h>";  
	echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
	if($value=='sh'){
		$sql_statement="SELECT membership_no as account_no FROM membership_info WHERE customer_id='$account'";
	}
	else{
		$sql_statement="SELECT account_no FROM customer_account WHERE customer_id='$account' AND account_type='$value'";
	}
	 if($value=='sb')
	{
		$sql_statement .=" AND status<>'m'";
	}
	//echo $sql_statement;
	$result1=dBConnect($sql_statement);
	for($i=1; $i<=pg_NumRows($result1); $i++) {
		$row=pg_fetch_array($result1);
		$account_no=$row['account_no'];
		if($account_no)
		{
			$sql_statement="SELECT name,address,relation,age FROM nomination WHERE account_no='$account_no'";
			//echo $sql_statement;
			$result=dBConnect($sql_statement);
			echo "<table valign=\"top\" width=\"100%\">";

			if(pg_NumRows($result)==0) {
			//echo "<h1><center><font color=Green>There is no nominy  <a href=> Add Nominy</a></center></font></h1>";
				echo "<tr><td bgcolor=\"red\" colspan=\"5\" align=\"center\"><font color=\"white\">Nominy Information of  $acount_type No=$account_no</font>";
				echo "<tr><td bgcolor=\"$TCOLOR\" colspan=\"5\" align=\"center\"><font color=\"blue\"> No Nominy Information of  $acount_type No=$account_no <a href=\"nominy.php?account_no=$account_no&add=add&typeIn=$value\">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Add Nomination</a></font>";
			} 
			else {
				echo "<form method=\"POST\" action=\"nominy.php?account_no=$account_no\"><br>";
				//echo "<table valign=\"top\" width=\"100%\">";
				echo "<tr><td bgcolor=\"blue\" colspan=\"5\" align=\"center\"><font color=\"white\">Nominy Information of $acount_type  No=$account_no</font>";

				// Place line comments if you do not need column header.
				$color=$TCOLOR;
				echo "<tr>";
				//echo "<th bgcolor=$color>Group no</th>";
				echo "<th bgcolor=$color>Name</th>";
				echo "<th bgcolor=$color>Age</th>";
				echo "<th bgcolor=$color>Address</th>";
				echo "<th bgcolor=$color>Relation</th>";
				echo "<th bgcolor=$color>Opreation</th>";
				for($j=1; $j<=pg_NumRows($result); $j++) 
				{
					$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
					$row=pg_fetch_array($result,($j-1));
					echo "<tr>";
					echo "<td align=left bgcolor=$color><input type=\"TEXT\" name=\"name\" size=\"10\" value=\"".ucwords($row['name'])."\" id=\"name\"></td>";
					echo "<td align=left bgcolor=$color><input type=\"TEXT\" name=\"age\" size=\"10\" value=\"".ucwords($row['age'])."\" id=\"name\"></td>";
					echo "<td align=left bgcolor=$color><input type=\"TEXT\" name=\"address\" size=\"20\" value=\"".ucwords($row['address'])."\" id=\"name\"></td>";
					$relation=$row['relation'];
					$relation=RegetIndex($relation_array,trim($relation));
					echo "<td align=left bgcolor=$color>";
					makeSelect($relation_array,"relation",$relation);
					echo "</td>";
					echo "<td align=\"center\" bgcolor=$color><input type=\"SUBMIT\" name=\"update\" value=\"Update \">";
				//<input type=\"TEXT\" name=\"relation\" size=\"10\" value=\"".ucwords($row['relation'])."\" id=\"name\">
				}
				echo "</form>";
			}
		}
		echo "</table>";
	}
}
echo "<html>";
echo "<head>";
echo "<title>Nominy Details";
echo "</title>";
echo "<script src=\"../JS/validation.js\">";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
//echo "<p><font size=3><A HREF=\"../customer/customer_statement.php?menu=cust\">back</A></font></p>";
if(isset($_REQUEST['add'])){
	$account_no=$_REQUEST['account_no'];
	$typeIn=$_REQUEST['typeIn'];
	add_nominy($account_no,$typeIn);
}
else
{
	$type_of_account = array ('sb','fd','rd','ri','mis','sh');  
	      
	foreach ($type_of_account as $value)
	{
		nominy($value,$account);
	}
}		

echo "<p><font size=3><A HREF=\"../customer/customer_statement.php?menu=cust\">back</A></font></p>";
echo "</body>";
echo "</html>";
?>
