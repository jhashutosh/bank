//-----------------------------------------------------purchase--------//
//-----------------------------------------------------purchase--------//
//-----------------------------------------------------purchase--------//
$(function(){
	$("#select-c").button();
	$("#changeV").button().click(function(){
		$("#vendor").slideDown('slow');
	});
	$( "#billdate" ).datepicker({dateFormat :'dd/mm/yy'});
	var url1="./product_search.php?op=m";
	var mas=new Array();
	var product=new Array();
	var vendor=new Array();
	if (window.XMLHttpRequest) 
 	{
  		xmlhttp=new XMLHttpRequest();
  	}
	else		
  	{
  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
 	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		mas=xmlhttp.responseText.split("|");
		product=mas[0].split(",");
		vendor=mas[1].split(",");
		$("#searchV").autocomplete({
			source: vendor
		});
		}
	}
	xmlhttp.open("POST",url1,true);
	xmlhttp.send();
	$("#searchV").change(function(){
		$("#vendor").hide('slow');
		$("#product").html("");
		var url3="./product_search.php?op=b1";
		var v_id=$("#searchV").val();
		url3=url3+'&v_id='+v_id;
		if (window.XMLHttpRequest) 
 		{
  			xmlhttp=new XMLHttpRequest();
  		}
		else		
  		{
  			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
 		}
		xmlhttp.onreadystatechange=function() {
  		if (xmlhttp.readyState==4 && xmlhttp.status==200)
    		{
			//var a=xmlhttp.responseText.split('^');
			$("#desVendor").html(xmlhttp.responseText);
		}
  		}	
		xmlhttp.open("POST",url3,true);
		xmlhttp.send();
		$("#desVendor").html("<img src='bigrotation2.gif'>");
	});
	////////////chalan popup///////
	$("#select-c").click(function(){
		if(reqField()==true){
		var v=document.getElementById("searchV").value;
		var d=document.getElementById("billdate").value;
		var url4="./pdata.php?chalan=true&v="+v+"&d="+d;
		if (window.XMLHttpRequest) 
 		{
  			xmlhttp=new XMLHttpRequest();
  		}
		else		
  		{
  			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
 		}
		xmlhttp.onreadystatechange=function() {
  			if (xmlhttp.readyState==4 && xmlhttp.status==200)
    			{
				$("#dChalan").html(xmlhttp.responseText);
				return false;
			}
  		}
		xmlhttp.open("POST",url4,true);
		xmlhttp.send();
		$("#dChalan").html("<img src='bigrotation2.gif'>");
		$( "#chalan").dialog({
		modal: true,
		autOpen:false,
		resizable:false,
		draggable:false,
		width:'300px',
		title:"Select Chalan"
		});
		}
		else{return false;}
	});
	$("body").delegate("#submitChalan","click",function()
	{
	var r="r=";
	var r1="r1=";
	$.each($("#chalanForm :checked"),function(){
		r+=this.value+",";
		r1+=this.name+",";	
	});
	if (window.XMLHttpRequest) 
	{
		xmlhttp=new XMLHttpRequest();
	}
	else		
	{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
	if (xmlhttp.readyState==4 && xmlhttp.status==200)
	{
		$("#chalan").dialog("close");
		$("#product").html(xmlhttp.responseText);
	}
	}
	xmlhttp.open("POST",'pdata.php',true);
	xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");
	r+="&"+r1;
	xmlhttp.send(r);
	return false;
	});
	/////calculating////////
	$("body").delegate("#productTable .rate","keyup",function(event)
	{
		if(this.value.length==0){
		$("#productTable #totalSpan").html(0);
		$(this.parentNode.parentNode).find(".total").html(0);
		return false;
		}
		var q=parseInt($(this.parentNode.parentNode).find(".qty").html(),10);
		$(this.parentNode.parentNode).find(".total").html((q*parseFloat((this.value),10)).toFixed(2));
		 tot=0;
		$.each($("#productTable .total"),function(){
		tot+=parseFloat(this.innerHTML,10);	
		});
		$("#productTable #totalSpan").html(tot.toFixed(2));
	});
	$("body").delegate("#productTable #discount","keyup",function(event)
	{
		var t=parseFloat($("#productTable #totalSpan").html(),10);
		if(this.value.length==0){
		$("#productTable #tdiscount").val(0);
		$("#productTable #dtotal").html(t);
		return false;}
		if(this.value>=100){
		$("#productTable #tdiscount").val(0);
		$("#productTable #dtotal").html(0);
		$(this).val(0);
		return false;
		}
		else{
		
		var dtot=(parseFloat(this.value,10)/100)*t;
		$("#productTable #dtotal").html(t-dtot.toFixed(2));
		$("#productTable #tdiscount").val(dtot.toFixed(2));
		}
	});
	$("body").delegate("#productTable #tdiscount","keyup",function(event)
	{
		var t=parseFloat($("#productTable #totalSpan").html(),10);
		if(this.value.length==0){
		$("#productTable #dtotal").html(t);
		return false;
		}
		
		var d=parseFloat($(this).val(),10);
		$("#productTable #dtotal").html((t-d).toFixed(2));
		$("#productTable #discount").val(0);
	});
	/////key press event///////
	$("body").delegate("#productTable .rate","keypress",function(event)
	{
		if(numbersonly(event)===false){return false}
	});
	$("body").delegate("#productTable #discount","keypress",function(event)
	{
		if(numbersonly(event)===false){
		return false;}
	});
	$("body").delegate("#productTable #tdiscount","keypress",function(event)
	{
		if(numbersonly(event)===false){
		return false;}
	});
	/////////validation function
	function reqField(){
		var msg="";
		if($("#billno").val()=='' ||$("#billno").val()===null)
		{msg+="Enter Bill No.\n";}
		if($("#billdate").val()=='' ||$("#billdate").val()===null)
		{msg+="Enter Bill Date.\n";}
		if(msg==""){return true;}
		else{alert(msg); return false;}
	}
	function numbersonly(e){
	var unicode=e.charCode? e.charCode : e.keyCode;
	if (unicode!=8){ 
		if (unicode<46||unicode>57||unicode==47) {
			return false;		
		}
	}
	}
	///////submit////////////
	$("body").delegate("#productTable #submit","click",function(event)
	{
		var total=parseFloat($("#productTable #dtotal").html(),10);
		if(total>0)
		{
			var vendor="vendor="+$("#searchV").val(); 
			var billno="billno="+$("#billno").val();
			var billdate="billdate="+$("#billdate").val();
			var total="total="+$("#totalSpan").html();
			var tdiscount="tdiscount="+$("#tdiscount").val();
			var totalWdis="tWithdis="+$("#dtotal").html();
			var stk_link="stk_link="+$("#stk_link").val();
			var chalan_r="chalan_r="+$("#chalan_r").val();
			var mm_code="mm_code=";
			var qty="qty=";
			var rate="rate=";

			$.each($("#productTable .mm-code"),function(){
			mm_code+=this.value+",";	
			});
			$.each($("#productTable .qty"),function(){
			qty+=this.innerHTML+",";	
			});
			$.each($("#productTable .rate"),function(){
			rate+=this.value+",";	
			});
			var sendinfo=vendor+"&"+billno+"&"+billdate+"&"+total+"&"+tdiscount+"&"+totalWdis +"&"+ stk_link +"&"+chalan_r +"&"+mm_code +"&"+qty +"&"+ rate;
			if (window.XMLHttpRequest) 
			{
				xmlhttp=new XMLHttpRequest();
			}
			else		
			{
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				$("#sucess").html(xmlhttp.responseText);
					alert('Successfully data inserted into database');
					//window.location='./transaction.php#ui-tabs-1';
					//location.reload('');				
			}
			}
			xmlhttp.open("POST",'save_pdata.php',true);
			xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");
			
			xmlhttp.send(sendinfo);
			return false;

			
		}
		else
		{alert("Please Fillup Information");return false;}
	});
});
