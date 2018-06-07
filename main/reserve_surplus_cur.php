<?php
include "../config/config.php";
$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$op=$_REQUEST['op'];
$TCOLOR='#B0C4DE';
$TBGCOLOR='#FFB6C1';
$action_date=$_REQUEST['op_dt'];
if(empty($action_date)){$action_date=date('d/m/Y');}
$fy1=$_SESSION['fy'];

if($op=='e'){
$rate=$_REQUEST['rate'];
$code=$_REQUEST['gl_code'];
//echo $code;


//echo $fy;
$sql_statement="INSERT INTO res_ser_dtl(gl_code,action_date,fy,rate,operator_code,entry_time) VALUES('$code','$action_date','$fy1',$rate,'$staff_id',CAST('$action_date'||SUBSTR(CAST(now() AS VARCHAR),11,LENGTH(CAST(NOW() AS VARCHAR))) AS TIMESTAMP))";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_affected_rows($result)<1) {
   echo "<h1><blink>sorry database not updated due to some reason!!!!!!!!!!!!!!!!!!</h1>";
     }
else{$flag=1;
}
 }
echo "<html>";
echo "<head>";
echo "<title>Entry Permission";
echo "</title>";
echo "<script src=\"../JS/calendar.js\"></script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "</head>";
echo "<body bgcolor=\"silver\" onload=\"op_dt.focus()\">";
echo "<form method=\"POST\" action=\"reserve_surplus_cur.php?op=e\" name=\"f1\" onSubmit=\"return validator1(this);\">";
echo "<br><br>";
echo "<table bgcolor=black align=center width=80%>";
echo "<tr><th colspan=\"2\" bgcolor=\"#800080\"><font size=6 color=white>Reserve & Surplus Current Balance Entry Form </font></th></tr>";
echo "<tr bgcolor=#00CED1><td>Action Date:<td><input type=\"TEXT\" name=\"op_dt\" id=\"op_dt\" size=\"10\" value=\"$action_date\" $HIGHLIGHT>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"button\" name=\"date1\" value=\"...\" onclick=\"showCalendar(f1.op_dt,'dd/mm/yyyy','Choose Date')\">";
echo "<tr bgcolor=#00CED1><td align=\"left\">General Ledger:<td>";

makeSelectRFCCode($fy1,'gl_code');
echo "<tr bgcolor=#00CED1><td align=\"left\">Rate:<td> <input type=\"text\" name=\"rate\" id=\"rate\" onblur=\"return validator1(this);\" onkeypress=\"return numbersonly(event);\" size=\"4\" $HIGHLIGHT>&nbsp;%";
echo "<tr bgcolor=#00CED1><td><td align=RIGHT><INPUT TYPE=\"SUBMIT\" VALUE=\"Enter\">";
echo "</table>";
echo "</form>";
echo"<HR>";
echo "<br>";
//------------------------------------display---------------------------------------------
$sql_statement="select a.*,b.* from res_ser_dtl a,gl_master b where a.gl_code=b.gl_mas_code and a.fy='$fy1'" ;
$result=dbConnect($sql_statement);
//echo $sql_statement;
if(pg_NumRows($result)==0)
{
echo "<h2>Till Now There Is No Record !!!</h2>";
} else
{
echo "<table bgcolor=black align=center valign=\"top\" width=\"80%\">";
echo "<tr><td bgcolor=\"#800080\" colspan=\"5\" align=\"center\"><font color=\"white\" size=+1>Reserve & Surplusses Details</font>";
$color='#ADFF2F';
echo "<tr>";
echo "<th bgcolor='$color' width=\"40%\" >Reserve And Surplusses Code</th>";
echo "<th bgcolor='$color' width=\"10%\" >Rate</th>";
echo "<th bgcolor='$color' width=\"15%\" >Action Date</th>";
echo "<th bgcolor='$color' width=\"15%\" >Financial Year</th>";
echo "<th bgcolor='$color' width=\"20%\" >Operater</th>";
for($j=0; $j<pg_NumRows($result); $j++) {
echo "<tr>";
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
echo "<td align=left bgcolor=$color width=\"40%\">".ucwords($row['gl_mas_desc'])."[".$row['gl_code']."]</td>";
echo "<td align=left bgcolor=$color width=\"15%\">".$row['rate']."</td>";
echo "<td align=left bgcolor=$color width=\"15%\">".$row['action_date']."</td>";
echo "<td align=left bgcolor=$color width=\"10%\">".$row['fy']."</td>";
echo "<td align=left bgcolor=$color width=\"20%\">".$row['operator_code']."</td></tr>";
}
echo "</table>";}


//===============================================================================================================================================
function makeSelectRFCCode($fy1,$name){

//echo $fy;
	$sql_statement="SELECT DISTINCT m.gl_mas_code,gm.gl_mas_desc FROM mas_gl_tran m,gl_master gm 
where m.gl_mas_code=gm.gl_mas_code AND CAST(m.gl_mas_code AS INT) BETWEEN 12100 and 12299 
 AND m.gl_mas_code NOT IN (SELECT gl_code FROM res_ser_dtl where fy='$fy1')ORDER BY m.gl_mas_code";
//echo $sql_statement;
 $result=dBConnect($sql_statement);
 echo "<select name=\"$name\" id=\"$name\">";

if(pg_NumRows($result)==0) 
	{
 		echo "<option>Null</option>";
	}
else
	{
      		for($j=1; $j<=pg_NumRows($result); $j++) 
		{
      			$row=pg_fetch_array($result,($j-1)); 
     			echo "<option value=\"".$row['gl_mas_code']."\">".ucwords($row['gl_mas_desc'])."[".$row['gl_mas_code']."]</option>";
    		}
	
//---------------------------------------------for extra Fund Creation -----------------------------------------------------
		$sql_statement1="SELECT * FROM gl_master 
WHERE CAST(gl_mas_code AS INT) BETWEEN 12100 and 12299 AND 
	gl_mas_code NOT IN (
		SELECT DISTINCT gl_mas_code FROM mas_gl_tran WHERE  CAST(gl_mas_code AS INT) BETWEEN 12100 and 12299 
		UNION ALL 
		SELECT gl_code FROM res_ser_dtl where fy='$fy1'
			)   ORDER BY gl_mas_code";
		//echo $sql_statement1;
		 $result1=dBConnect($sql_statement1);
		if(pg_NumRows($result1)>0){
		echo "<option value=''>--------------------------------------------------------</option>";
		for($i=1; $i<=pg_NumRows($result1); $i++) 
				{
		      			$row1=pg_fetch_array($result1,($i-1)); 
		     			echo "<option value=\"".$row1['gl_mas_code']."\">".ucwords($row1['gl_mas_desc'])."[".$row1['gl_mas_code']."]</option>";
		    		}

		}
}
echo "</select>";
}
//===============================================================================================================================================

?>
<SCRIPT>
function validator1(f)
	{	
		//alert(f.rate.value);
		if(f.gl_code.value.length==0){
		alert("Please Select the GL Code");
		f.gl_code.focus();
		return false;

		}
				
		

		if(f.rate.value==null || f.rate.value=='' || f.rate.value<1 || f.rate.value>20)
		{
			alert("Please Give Rate And Between 1 to 20 %..\n");
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
</SCRIPT>
