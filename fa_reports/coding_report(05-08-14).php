<!doctype html>
<?
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
	<style>
		a{
		text-decoration:none;
	}
	</style>
<script type="text/javascript">

$(function(){
	$("#reportDate").datepicker({dateFormat :'dd/mm/yy'});
	$("#showReport").click(function(){
		var d=$("#reportDate").val();
		var msg='';
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
			var url3="../fa/report_bck.php?date="+$("#reportDate").val();
			if (window.XMLHttpRequest) 
	 		{xmlhttp=new XMLHttpRequest();}
			else		
	  		{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
			xmlhttp.onreadystatechange=function() {
	  		if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    		{
				
				if(xmlhttp.responseText==1){
					$.each($('#linkDiv a'),function(index,value){
						var href=$(this).attr('href').split('?');
						$(this).attr('href',href[0]+'?start_date='+d);
					});
					$("#loader").hide();
					$("#linkDiv").show();
				}
			}
	  		}	
			xmlhttp.open("POST",url3,true);
			xmlhttp.send();
			$("#loader").show();$("#linkDiv").hide();
			return true;
		}
		else{
			alert(msg);
			return false;
		}
		
		
	});
	
});
</script>
</head>
<body>

<div id="header" align="center" >
<table align='center' width='60%' bgcolor='silver'>
<tr><th align="center" colspan=1 bgcolor='#F4F4F4'>Finance Reports</th></td>
<tr><td align="center" colspan=1 bgcolor='silver'>Show Report on Date:
<input type="text" value="" id="reportDate" name="reportDate"></td></tr>
<input type="hidden" value="<?echo $fy;?>" id="finDate" name="finDate"></td></tr>
<td bgcolor='silver' align='right'><input type="button" value="Show" id="showReport" name="showReport"></td></tr>
</table>
</div>
<HR>
<div id="body">
<div id="loader" align="center"  style="display:none">
<img src='../JS/bigrotation2.gif'>
</div>
<div id="linkDiv" style="display:none" >
<table width='100%' align='center' bgcolor='silver' border='2'>
<tr><td>
<ul >
<li><h3><A id="a0" HREF="trial_before_new.php" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no, top=150,left=350, width=800,height=800'); return false;">Trial Balance(Before)</A>
<a style="margin-left:100px" HREF="trial_before_new_p.php" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no, top=150,left=350, width=800,height=800'); return false;">for Print</a></h3></li>
<li><h3><A id="a0" HREF="trial_before_new_dr.php" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no, top=150,left=350, width=800,height=800'); return false;">Cash Cum-Trial Balance-Dr(Before)</A>
<a style="margin-left:100px" HREF="trial_before_new_dr_p.php" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no, top=150,left=350, width=800,height=800'); return false;">for Print</a>
</h3></li>
<li><h3><A id="a0" HREF="trial_before_new_cr.php" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no, top=150,left=350, width=800,height=800'); return false;">Cash Cum-Trial Balance-Cr(Before)</A>
<a style="margin-left:100px" HREF="trial_before_new_cr_p.php" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no, top=150,left=350, width=800,height=800'); return false;">for Print</a>
</h3></li>
<li><h3><A id="a0" HREF="trial_new.php" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no, top=150,left=350, width=800,height=800'); return false;">Trial Balance(Adjusted)</A>
<a style="margin-left:100px" HREF="trial_new_p.php" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no, top=150,left=350, width=800,height=800'); return false;">for Print</a>
</h3></li>
<li><h3><A id="a0" HREF="trial_balance_nab.php" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no, top=150,left=350, width=800,height=800'); return false;">Trial Balance NAB(Adjusted)</A></li>
<li><h3><A id="a0" HREF="trial_new_dr.php" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no, top=150,left=350, width=800,height=800'); return false;">Cash Cum-Trial Balance-Dr(Adjusted)</A>
<a style="margin-left:100px" HREF="trial_new_dr_p.php" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no, top=150,left=350, width=800,height=800'); return false;">for Print</a>
</h3></li>
<li><h3><A id="a0" HREF="trial_new_cr.php" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no, top=150,left=350, width=800,height=800'); return false;">Cash Cum-Trial Balance-Cr(Adjusted)</A>
<a style="margin-left:100px" HREF="trial_new_cr_p.php" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no, top=150,left=350, width=800,height=800'); return false;">for Print</a>
</h3></li>
<li><h3><A id="a1" HREF="trading_new.php" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no, top=150,left=350, width=800,height=800'); return false;">Trading Account</A></h3></li>
<li><h3><A id="a2" HREF="profit_loss.php" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no, top=150,left=350, width=800,height=800'); return false;">Profit & Loss</A></h3></li>
<li><h3><A id="a3" HREF="profit_loss_ap_new.php" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no,top=150,left=350, width=800,height=800'); return false;">Profit & Loss Appropriation</A></h3></li>
<li><h3><A id="a4" HREF="a_balance_sheet.php" onClick="window.open(this.href,'_blank','toolbar=no,status=no,location=no,directories=no,resizeable=no, top=150,left=350, width=800,height=800'); return false;">Balance Sheet</A></h3></li>
</ul></td></tr>
</table>
</div>
</div>

</body>
