<?
include "../config/config.php";
//include "";
$staff_id=verifyAutho();
$end_date=$_REQUEST["end_date"];
$menu=$_REQUEST['menu'];
$type=$loan_module_array[trim($menu)];
if($menu=='kcc'){
	$s_page="../kcc/kcc_loan_statement.php?menu=kcc&op=i&account_no=";
	}	
if($menu=='pl'){
	$s_page="../pl/pl_statement.php?menu=pl&op=i&account_no=";
		}
if($menu=='ccl'){
	$s_page="../ccl/ccl_statement.php?menu=ccl&op=i&account_no=";
		}
if($menu=='kpl'){
	$s_page="../kpl/kpl_statement.php?menu=kpl&op=i&account_no=";
		}
if($menu=='spl'){
	$s_page="../spl/spl_statement.php?menu=spl&op=i&account_no=";
		}
if($menu=='bdl'){
	$s_page="../bdl/bdl_statement.php?menu=bdl&op=i&account_no=";
		}
if($menu=='sfl'){
	$s_page="../sfl/sfl_statement.php?menu=sfl&op=i&account_no=";
		}
if($menu=='lad'){
	$s_page="../lad/lad_statement.php?menu=lad&op=i&account_no=";
		}
if($menu=='mt'){
	$s_page="../mtloan/mtloan_statement.php?menu=mt&op=i&account_no=";
		}
if($menu=='ser'){
	$s_page="../service/service_statement.php?menu=ser&op=i&account_no=";
		}
if($menu=='fis'){
	$s_page="../fisary/fisary_statement.php?menu=fis&op=i&account_no=";
		}

if($menu=='onf'){
	$s_page="../onf/onf_statement.php?menu=onf&op=i&account_no=";
		}
if($menu=='car'){
	$s_page="../carloan/car_statement.php?menu=car&op=i&account_no=";
		}
if($menu=='nf'){
	$s_page="../nf/nf_statement.php?menu=nf&op=i&account_no=";
		}
if($menu=='sgl'){
	$s_page="../shg/loan_statement?menu=sgl&op=i&account_no=";
}
if($menu=='kcc'){$cols='24';}else{$cols='23';}
echo "<body bgcolor=\"silver\">";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/test.css\" />";
echo "<font size=+3>$SYSTEM_TITLE</font> <br><font size=+1><b>Report Date:".date('d.m.Y')."::".getPrintTime()."</b></font><hr>";
echo "<hr>";
//-------------------------------------------------------------------------------------------
$sql_statement="SELECT loan_type,loan_serial_no,crop_id,fy,account_no,issue_date,repay_date,npa_date as date_of_npa,customer_id,due_principal as balance_principal,
odue_principal as balance_principal_o,due_int as due_int,odue_int as overdue_int,
stnd_principal as standard,sub_principal as sub,sub_npa_amount,d1_principal as d1,d1_npa_amount,
d2_principal as d2, d2_npa_amount,d3_principal AS d3,d3_npa_amount,unsecure_principal as unsecured_asset,
unsecure_npa_amount,lost_asset_principal AS loss_asset,lost_asset_npa_amount
FROM npa_register where loan_type='$menu' ";
if($menu!="lad"){$sql_statement.="ORDER by CAST(SUBSTR(account_no,position('-'in account_no)+1,length(account_no))AS INT)";}
//echo $sql_statement; 
$result=dBConnect($sql_statement);
getNPA($end_date,&$sub,&$d1,&$d2,&$d3,&$us,&$la);
echo "<Table bgcolor=\"Black\" width=\"100%\" >";
echo "<tr><th bgcolor=\"Yellow\" colspan=\"$cols\" align=center><font color=\"BLACK\">NPA Register for $type Module</font>";
$color="GREEN";
echo "<tr>";
echo "<th bgcolor=$color Rowspan=\"2\">Account<br>No</th>";
echo "<th bgcolor=$color Rowspan=\"2\">Name</th>";
if($menu=='kcc'){
	echo "<th bgcolor=$color Rowspan=\"2\">Crop Name</th>";
}
echo "<th bgcolor=$color Rowspan=\"2\">Issue<br>date</th>";
echo "<th bgcolor=$color Rowspan=\"2\">Over_due<br>date</th>";//added
echo "<th bgcolor=$color Colspan=\"4\">Balance</th>";
echo "<th bgcolor=$color Rowspan=\"2\">..NPA..<br>date</th>";//added
echo "<th bgcolor=$color Colspan=\"2\">Standard</th>";
echo "<th bgcolor=$color Colspan=\"2\">Sub-Standard</th>";
echo "<th bgcolor=$color Colspan=\"2\">Doubtful-1</th>";
echo "<th bgcolor=$color Colspan=\"2\">Doubtful-2</th>";
echo "<th bgcolor=$color Colspan=\"2\">Doubtful-3</th>";
echo "<th bgcolor=$color Colspan=\"2\">Unsecure Assets</th>";
echo "<th bgcolor=$color Colspan=\"2\">Loss Assets</th>";

echo "<tr>";
echo "<th bgcolor=$color >Due Prin</th>";
echo "<th bgcolor=$color >OverDue Prin</th>";//added
echo "<th bgcolor=$color >Due Int.</th>";
echo "<th bgcolor=$color >OverDue Int.</th>";
echo "<th bgcolor=$color>Principal</th>";
echo "<th bgcolor=$color >0%</th>";
echo "<th bgcolor=$color>Principal</th>";
echo "<th bgcolor=$color >$sub %</th>";
echo "<th bgcolor=$color>Principal</th>";
echo "<th bgcolor=$color >$d1 %</th>";
echo "<th bgcolor=$color>Principal</th>";
echo "<th bgcolor=$color >$d2 %</th>";
echo "<th bgcolor=$color>Principal</th>";
echo "<th bgcolor=$color >$d3 %</th>";
echo "<th bgcolor=$color>Principal</th>";
echo "<th bgcolor=$color >$us %</th>";
echo "<th bgcolor=$color>Principal</th>";
echo "<th bgcolor=$color >$la %</th>";

if(pg_NumRows($result)>0){
//if(true){
for($j=1; $j<=pg_NumRows($result); $j++){
$color=($color==$TCOLOR)?$TBGCOLOR:$TCOLOR;
$row=pg_fetch_array($result,($j-1));
echo "<tr>";
echo "<th bgcolor=\"$color\"><a href=\"$s_page".$row['account_no']."\" onClick=\"window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,scrollbars=yes, top=100,left=150, width=1210,height=1000'); return false;\">".trim($row['account_no']);
$id=$row['customer_id'];
echo "<td bgcolor=\"$color\">".getName('customer_id',$id,'name1','customer_master');
if($menu=='kcc'){
	echo "<td bgcolor=\"$color\">".getName('crop_id',$row['crop_id'],'crop_desc','crop_mas')."[".$row['fy']."]";
}
echo "<td bgcolor=\"$color\" align=\"right\">".($row['issue_date']);
echo "<td bgcolor=\"$color\" align=\"right\">".($row['repay_date']); //added
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($row['balance_principal']);
$t_b_p+=$row['balance_principal'];
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($row['balance_principal_o']);//added
$t_b_p_o+=$row['balance_principal_o'];//added
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($row['due_int']);
$t_d_i+=$row['due_int'];
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($row['overdue_int']);
$t_od_i+=$row['overdue_int'];
echo "<td bgcolor=\"$color\" align=\"right\">".($row['date_of_npa']); //added
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($row['standard']);
$t_standard+=$row['standard'];
echo "<td bgcolor=\"$color\" align=\"right\">0";
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($row['sub']);
$t_sub+=$row['sub'];
$s_p=$row['sub_npa_amount'];
$t_s_p+=$s_p;
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($s_p);
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($row['d1']);
$t_d1+=$row['d1'];
$d1_p=$row['d1_npa_amount'];
$t_d1_p+=$d1_p;
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($d1_p);
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($row['d2']);
$t_d2+=$row['d2'];
$d2_p=$row['d2_npa_amount'];
$t_d2_p+=$d2_p;
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($d2_p);
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($row['d3']);
$t_d3+=$row['d3'];
$d3_p=$row['d3_npa_amount'];
$t_d3_p+=$d3_p;
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($d3_p);
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($row['unsecured_asset']);
$t_unsecure_asset+=$row['unsecured_asset'];
$t_unsecure_p+=$row['unsecure_npa_amount'];
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($row['unsecure_npa_amount']);
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($row['loss_asset']);
$t_loss_asset+=$row['loss_asset'];
echo "<td bgcolor=\"$color\" align=\"right\">".amount2Rs($row['lost_asset_npa_amount']);
$t_loss_p+=$row['lost_asset_npa_amount'];
  }

echo "<tr bgcolor=\"AQUA\"><th colspan=\"1\">Total:<th align=\"right\"><th align=\"right\"><th align=\"right\">";
if($menu=='kcc'){echo "<th align=\"right\">";}

echo"<th align=\"right\">".amount2Rs($t_b_p)."<th align=\"right\">".amount2Rs($t_b_p_o)."<th align=\"right\">".amount2Rs($t_d_i)."<th align=\"right\">".amount2Rs($t_od_i)."<th align=\"right\"><th align=\"right\">".amount2Rs($t_standard)."<th align=\"right\">0<th align=\"right\">".amount2Rs($t_sub)."<th align=\"right\">".amount2Rs($t_s_p)."<th align=\"right\">".amount2Rs($t_d1)."<th align=\"right\">".amount2Rs($t_d1_p)."<th align=\"right\">".amount2Rs($t_d2)."<th align=\"right\">".amount2Rs($t_d2_p)."<th align=\"right\">".amount2Rs($t_d3)."<th align=\"right\">".amount2Rs($t_d3_p)."<th align=\"right\">".amount2Rs($t_unsecure_asset)."<th align=\"right\">".amount2Rs($t_unsecure_p)."<th align=\"right\">".amount2Rs($t_loss_asset)."<th align=\"right\">".amount2Rs($t_loss_p);
}
echo "</body>";
echo "</html>";
//----------------------------------------------------------------------------------------------------
function getNPA($end_date,$sub,$d1,$d2,$d3,$us,$la){
$sql_statement="SELECT * FROM npa_mas where action_date=(SELECT MAX(action_date) FROM npa_mas where action_date<='$end_date')";
$result=dBConnect($sql_statement);
if(pg_NumRows($result)>0){
$sub=pg_result($result,'sub');
$d1=pg_result($result,'d1');
$d2=pg_result($result,'d2');
$d3=pg_result($result,'d3');
$us=pg_result($result,'unsec');
$la=pg_result($result,'lst_ast');
}
else{

$sub=0;
$d1=0;
$d2=0;
$d3=0;
$us=0;
$la=0;

}
}
?>
