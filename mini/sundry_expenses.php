<?
include "../config/config.php";
//
function makeSelectFromDBWithCodeMini($id,$desc,$table,$name,$WHERE){
 if (empty($WHERE)){
 	$sql_statement="SELECT  $id,$desc from $table order by $id";
	}
 else{
	$sql_statement="SELECT  $id,$desc from $table $WHERE ORDER BY $id";
	}
// echo $sql_statement;
 $result=dBConnect($sql_statement);
 echo "<select name=\"$name\" id=\"$name\">";
 if(pg_NumRows($result)==0) {
 echo "<option>Null</option>";
}
else{
      //
      for($j=1; $j<=pg_NumRows($result); $j++) {
      $row=pg_fetch_array($result,($j-1)); 
      echo "<option value=\"".$row[$id]."\">".ucwords($row[$desc])."[".$row[$id]."]</option>";
    }
}
echo "</select>";
}
//==========================================================================================
function makeSelectSubmit4mdbminiSun($id,$desc,$table,$name){
$sql_statement="SELECT  $id,$desc from $table order by $desc";
//$sql_statement="SELECT $desc from $table order by $id";
//echo $sql_statement;
 $result=dBConnect($sql_statement);
 echo "<select name=\"$name\" id=\"$name\"  onchange=\"onSubmits(this.form);\">";
 if(pg_NumRows($result)==0) {
 echo "<option>Null</option>";
}
else{
      echo "<option>Select</option>";
	//echo "<option>All</option>";
      for($j=1; $j<=pg_NumRows($result); $j++) {
      $row=pg_fetch_array($result,($j-1)); 
      echo "<option value=\"".$row[$desc]."\">".ucwords($row[$desc])."</option>";
	//echo "<option value=\"".ucwords($row[$desc])."\">".$row[$id]."</option>";
    }
}
echo "</select>";

}

//
$operator_id=verifyAutho();
$time=date('d/m/Y H:i:s ');

if($op=='i'){
$amount=$_REQUEST['amount'];
$code=$_REQUEST['code'];
$mini_name=$_REQUEST['mini_name'];
$particular=$_REQUEST['particular'];
$dt=$_REQUEST['dt'];
$year_month=$_REQUEST['year_month'];
$action_date='31.03.2011';
$fy=getFy();
$t_id=getTranId();

$sysdate=date('d/m/y');
$sql_statement="select LC_Sundry_Expenses_Payment_Fnc('$code','$mini_name',$amount,'$dt','$staff_id','$time','$sysdate')";
			$result=dBConnect($sql_statement);
			echo $sql_statement;
			if(pg_NumRows($result)>0)
 	   			{
				echo "<h4><font color=GREEN>Data Inserted Successfully.</font></h4>";
 	  			 }
			else
				{
				echo "<h4><font color=RED>FAILED TO INSERT DATA INTO THE TABLE</font></h4>";
				}

}
echo "<html>";
echo "<head>";
echo "<title>Entry Permission";
echo "</title>";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\">";
echo "<form method=\"POST\" action=\"sundry_expenses.php?op=i\" name=\"f1\">";
echo "<table bgcolor=#E6E6FA align=center width=90%>";
echo "<tr><th colspan=\"2\" bgcolor=\"#839EB8\"><font size=4 color=white>Sundry Expenses Opening Balance Entry Form </font></th></tr>";
echo "<tr><td align=\"right\">General Ledger:<td align=\"left\">"; makeSelectFromDBWithCodeMini('gl_mas_code','gl_mas_desc','LC_Mini_Gl_Master','code');
echo "<tr><td align=\"right\">Mini Name:<td align=\"left\">"; makeSelectSubmit4mdbminiSun('id','mini_name','lc_mini_master','mini_name');
echo "<tr><td align=\"right\">Amount:<td align=\"left\" <input type=\"text\" name=\"amount\" size=\"7\" $HIGHLIGHT>";
echo "<tr><td align=\"right\">Date:<td align=\"left\"><input type=\"TEXT\" name=\"dt\" id=\"dt\" size=\"10\" value=\"\" $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"date\" value=\"...\" onclick=\"showCalendar(f1.dt,'dd/mm/yyyy','Choose Date')\">";
echo "<tr><td align=\"right\">Particular:<td align=\"left\"><input type=\"TEXT\" name=\"particular\" id=\"particular\" size=\"50\" value=\"$particular\" $HIGHLIGHT>";
echo "<INPUT TYPE=\"HIDDEN\" name=\"year_month\" VALUE=\"2010-3\">";
echo "<tr><td><td align=RIGHT><INPUT TYPE=\"SUBMIT\" VALUE=\"Enter\">";
echo "</table>";
echo"<HR>";
echo"<table bgcolor=#E6E6FA align=center width=100%>";
echo "<tr><td  bgcolor='#839EB8' align='center' colspan=\"1\"  width='25%'><font color='black' size='2'>Transaction id</font></td>";
echo "<td  bgcolor='#839EB8' align='center' colspan=\"1\"width='15%'><font color='black' size='2'>Gl Mas_Code</font></td>";
echo"<td align='center' width='20%' bgcolor='#839EB8' colspan=\"1\"><font color='black'>Amount</font></td>";
echo "<td  bgcolor='#839EB8' align='center' colspan=\"1\"  width='15%'><font color='black' size='2'>Account Header</font></td>";
echo"<td  bgcolor='#839EB8' align='center' colspan=\"1\"  width='25%'><font color='black' size='2'>Particulars</font></td>";

echo"</tr><tr><td colspan=\"5\" align=center><iframe src=\"sundry_ex_frm.php?c=$op_id\" width=\"100%\" height=\"200\" ></iframe></td></tr></table>";
echo "</form>";

echo "</body>";
echo "</html>";
?>
