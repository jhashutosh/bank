<!doctype html>
<?php
include "../config/config.php";
$staff_id=verifyAutho();
$v_id=$_REQUEST['q'];
$fy=$_SESSION['fy'];
//echo $fy;
?>
<html>
<head>
<link rel="stylesheet" href="../JS/themes/base/jquery.ui.all.css">
	<script src="../JS/jquery-1.9.1.js"></script>
	<script src="../JS/ui/jquery.ui.core.js"></script>
	<script src="../JS/ui/jquery.ui.widget.js"></script>
	<script src="../JS/ui/jquery-ui-1.10.3.custom.min.js"></script>
<script type="text/javascript">

$(function(){
		$("#reportDate").datepicker({dateFormat :'dd/mm/yy'});
	$("#showReport").click(function(){
		
		var msg='';//alert("msg");
		if($("#reportDate").val()==null || $("#reportDate").val()=='') {
			msg+="Its A mandatory Field Enter Date.\n";
		}
		
		ar1=$("#reportDate").val().split('/');
		//alert($("#reportDate").val());
		ar2=$("#finDate").val().split('-');//alert($("#finDate").val());
		if(ar2[0]>ar1[2] || ar2[1]<ar1[2])
		{
			msg+="Date must be within the Financial Year\n";
		}
		if(msg==''){
			var url3="./report_bck.php?date="+$("#reportDate").val();
			if (window.XMLHttpRequest) 
	 		{xmlhttp=new XMLHttpRequest();}
			else		
	  		{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
			xmlhttp.onreadystatechange=function() {
	  		if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    		{
				if(xmlhttp.responseText==1){
					$("#loader").hide();
					$("#linkDiv").show();
				}
			}
	  		}	
			xmlhttp.open("POST",url3,true);
			xmlhttp.send();$("#loader").show();
			return true;
		}
		else{
			alert(msg);
			return false;
		}
		
		
	});
	$("#reportDate").change(function(){
		var url1="risk_wht_rpt_sh.php?date="+$("#reportDate").val();
		$("#a1").attr('href',url1);
		});
	$("#reportDate").change(function(){
		var url1="risk_wht_rpt_gl.php?date="+$("#reportDate").val();
		$("#a2").attr('href',url1);	
	});
});
</script>
</head>
<body>

<div id="header" align="center" >
<table align='center' width='60%' bgcolor='silver'>
<tr><th align="center" colspan=1 bgcolor='#F4F4F4'>MIS Reports</th></td>
<tr><td align="center" colspan=1 bgcolor='silver'>Show Report on Date:
<input type="text" value="" id="reportDate" name="reportDate"></td></tr>
<input type="hidden" value="<?php echo $fy;?>" id="finDate" name="finDate"></td></tr>
<td bgcolor='silver' align='right'><input type="button" value="Show" id="showReport" name="showReport"></td></tr>
</table>
</div>
<HR>
<div id="body">
<div id="loader" align="center"  style="display:none">
<img src='../JS/bigrotation2.gif'>
</div>
<div id="linkDiv" style="display:none" >
<table width='80%' align='center' bgcolor='silver' border='2'>
<tr><td>
<!--<ul >
<li><h3><A HREF="worcap.php" onClick="window.open(this.href,'_blank',' top=150,left=350, width=900,height=300','scrollbar=true'); return false;">Working Capital</A></h3></li>
<li><h3><A id="a1" HREF='#' onClick="window.open(this.href,'_blank',' top=150,left=350, width=900,height=300'); return false;">Risk Weighted Assets(Sub Header Wise)</A></h3></li>
<li><h3><A id="a2" HREF="#" onClick="window.open(this.href,'_blank',' top=150,left=350, width=900,height=300'); return false;">Risk Weighted Assets(General Ledger Wise)</A></h3></li>
<li><h3><A HREF="ratio_rpt.php" onClick="window.open(this.href,'_blank',' top=150,left=350, width=900,height=800'); return false;">Ratio</A></h3></li>
</ul>-->
<ul >
<li><h3><A HREF="worcap.php" target='_blank'>Working Capital</A></h3></li>

<li><h3><A id="a2" HREF="#" target='_blank'>Risk Weighted Assets(General Ledger Wise)</A></h3></li>
<li><h3><A HREF="ratio_rpt.php" target='_blank'>Ratio</A></h3></li>
</ul>
</td></tr>
</table>
</div>
</div>

</body>
