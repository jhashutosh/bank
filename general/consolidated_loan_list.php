<?php
include "../config/config.php";

$loan_type_array=array(
		"kcc"=>"Kishan Credit Card Loan",
		//"pl"=>"Pledge Loan",
		"lad"=>"LAD Loan",
		//"ofl"=>"Own Fund Loan",
		"kpl"=>"KVP Loan (PL)",
		"mt" => "MT Loan",
		"ser"=>"Service Loan",
		"car"=>"Car Loan",
		"fis" => "Fisary Loan",
		//"mtb" =>"MTB Loan",
		//"hpl"=>"HPL Loan",
		"sfl"=>"Staff Loan",
		//"ccl"=>"Cash Credit Loan",
		"sgl"=>"SHG Loan",
		//"jgl"=>"JLG Loan",
		"all"=>"ALL Loan"
);

$staff_id=verifyAutho();
$menu=$_REQUEST['menu'];
$current_date=$_REQUEST["current_date"];
//echo $menu;
if(empty($current_date) ) { $current_date=date("d/m/Y"); }
echo "<script src=\"../JS/calendar.js\"></script>";
echo "<script language=\"JAVASCRIPT\">";
echo "function closeme() { close(); }";
echo "</script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\">";
if(!empty($menu)){
if($menu=='all')
$sql_statement="SELECT ln_list_all('$current_date')";
else
$sql_statement="SELECT ln_list('$menu','$current_date')";
//echo $sql_statement;
$result=dBConnect($sql_statement);}
echo "<div align='center'>";
if(!empty($menu)){
echo"<font size=+2><b>Yearly Report For <font color='darkblue'>".$loan_type_array[$menu]."</font>: </font><br>";
echo "<hr>";}
else {
//echo "<h3>Yearly L Report</h3>";
}
echo"</div>";
echo "<br>";
echo "<form name=\"f1\" action=\"consolidated_loan_list.php?menu=$menu\" method=\"POST\">";
echo "<table align=center bgcolor=\"#90EE90\"><tr><td  align=\"\"><b> Date as on :<td><input type=TEXT size=12 name=current_date id=cd value=$current_date $HIGHLIGHT>";
echo "&nbsp;<input type=\"button\" name=\"caldate\" value=\"...\" onclick=\"showCalendar(f1.current_date,'dd/mm/yyyy','Choose Date')\">";
if(empty($menu)){
echo"Select Loan Type : ";
makeSelectcategory($loan_type_array,'menu','');
}
else{
echo"<a href=\"consolidated_loan_list.php\" onClick=\"window.open(this.href,'_self','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1300,height=500'); return false;\">&nbsp;&nbsp;Select Other Loan&nbsp;&nbsp;</A>";
}
echo "&nbsp;<input type=\"Submit\"  value=\"Enter\">";
echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<input type=\"BUTTON\" name=\"CLOSE_BUTTON\" value=\"Close\" onclick=\"closeme()\"> ";
echo " <input type=\"BUTTON\" name=\"PRINT_BUTTON\" value=\"Print\" onclick=\"print()\"> ";
echo "</table></form>";
echo "<hr>";
if(!empty($menu)){
$sql_statement="SELECT * FROM ln_pr_rec";
//echo $sql_statement;
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
echo "<table valign=\"top\" width=\"100%\">";
echo "<tr>";
$color="#FFDEAD";
echo "<th bgcolor=$color>Month</th>";
echo "<th bgcolor=$color>Opening<br>Balance(Rs.)</th>";
echo "<th bgcolor=$color>No. of Account</th>";
echo "<th bgcolor=$color>Total Loan Issue(Rs)</th>";
echo "<th bgcolor=$color>Principal Received(Rs)</th>";
echo "<th bgcolor=$color>Due Interest Received(Rs)</th>";
echo "<th bgcolor=$color>Over Due Interest Received(Rs) </th>";
echo "<th bgcolor=$color>Total Received(Rs)</th>";
echo "<th bgcolor=$color>Closing<br>Balance(Rs)</th>";
$color=$TSCOLOR;
for($j=0; $j<pg_NumRows($result); $j++) {
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,$j);
echo "<tr>";
echo "<td bgcolor=Yellow >".$row['month_yr']."</td>";
$op_bal+=$row['op_bal'];
echo "<td bgcolor=$color align=\"RIGHT\"><a href=\"../general/con_ln_op_dtl.php?menu=$menu&months=".$row['month_yr']."&current_date=$current_date&id=".$row['op_bal']."\" target=\"_blank\">".amount2Rs($row['op_bal'])."</td>";
$no+=$row['no_of_account'];
echo "<td bgcolor=$color align=\"RIGHT\">".$row['no_acc']."</td>";

$loan_amount+=$row['tot_ln_iss'];
echo "<td bgcolor=$color align=\"RIGHT\"><a href=\"../general/con_ln_iss_dtl.php?menu=$menu&months=".$row['month_yr']."&current_date=$current_date&id=".$row['tot_ln_iss']."\" target=\"_blank\">".amount2Rs($row['tot_ln_iss'])."</td>";
$p_received+=$row['pr_rec'];
echo "<td bgcolor=$color align=\"RIGHT\"><a href=\"../general/con_pr_dtl.php?menu=$menu&months=".$row['month_yr']."&current_date=$current_date&id=".$row['p_received']."\" target=\"_blank\">".amount2Rs($row['pr_rec'])."</td>";
$d_i_received+=$row['d_int_rec'];
echo "<td bgcolor=$color align=\"RIGHT\">".amount2Rs($row['d_int_rec'])."</td>";
$od_i_received+=$row['od_int_rec'];
echo "<td bgcolor=$color align=\"RIGHT\">".amount2Rs($row['od_int_rec'])."</td>";
$t_received+=$row['tot_rec'];
echo "<td bgcolor=$color align=\"RIGHT\">".amount2Rs($row['tot_rec'])."</td>";
$cl_bal+=$row['cl_bal'];
echo "<td bgcolor=$color align=\"RIGHT\">".amount2Rs($row['cl_bal'])."</td>";
 }
echo "<tr bgcolor=AQUA><td></td>";
echo "<td align=\"RIGHT\"><B></td>";
echo "<td align=\"RIGHT\"></td>";
echo "<td align=\"RIGHT\"><B>".amount2Rs($loan_amount)."</td>";
echo "<td align=\"RIGHT\"><B>".amount2Rs($p_received)."</td>";
echo "<td align=\"RIGHT\"><B>".amount2Rs($d_i_received)."</td>";
echo "<td align=\"RIGHT\"><B>".amount2Rs($od_i_received)."</td>";
echo "<td align=\"RIGHT\"><B>".amount2Rs($t_received)."</td>";
echo "<td align=\"RIGHT\"><B></td>";
}
}

?>
