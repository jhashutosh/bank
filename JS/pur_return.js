	$( "#dateReturn" ).datepicker({dateFormat :'dd/mm/yy'});
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
			//product=mas[0].split(",");
			vendor=mas[1].split(",");		
			$("#searchVen").autocomplete({
				source: vendor
			});
		}
	}
	xmlhttp.open("POST",url1,true);
	xmlhttp.send();

	$("body").delegate(".autoChalBill","change",function(event)
	{
		if($("#searchVen").val().length!=0 
		&& $("#dateReturn").val().length!=0){
			var url2="./purchase_ret_data.php?op=m";
			url2+="&action_date="+$( "#dateReturn" ).val()
				+"&vendor="+$( "#searchVen" ).val();
			var chalBill=new Array();
			var chalan=new Array();
			var bill=new Array();
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
					chalBill=xmlhttp.responseText.split("|");
					chalan=chalBill[0].split(",");
					bill=chalBill[1].split(",");
					if(chalan.length>0){
						$("#chalanNo").attr("readonly",false).autocomplete({
							source: chalan
						});
					}
					if(bill.length>0){
						$("#billNo").attr("readonly",false).autocomplete({
							source: bill
						});
					}
				}
			}
			xmlhttp.open("POST",url2,true);
			xmlhttp.send();
		}
	});
	$("body").delegate("#chalanButton","click",function(event)
	{
		var v=document.getElementById("searchVen").value;
		var c=document.getElementById("chalanNo").value.split('[');
		if(document.getElementById("chalanNo").value!=null
		 || document.getElementById("chalanNo").value==''){
			var url3="./purchase_ret_data.php?challan_no="+c[0]+"&op=p&vendor="+v;
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
					$("#retDiv").html(xmlhttp.responseText);
					return false;
				}
	  		}
			xmlhttp.open("POST",url3,true);
			xmlhttp.send();
			$("#retDiv").html("<img src='bigrotation2.gif'>");
			$( "#retDiv").dialog({
			modal: true,
			autOpen:false,
			resizable:false,
			draggable:false,
			width:'700px',
			title:"Purchase Return"
			});
		}
	});
	$("body").delegate("#billButton","click",function(event)
	{
		var v=document.getElementById("searchVen").value;
		var b=document.getElementById("billNo").value.split('[');
		if(document.getElementById("billNo").value!=null 
		|| document.getElementById("billNo").value==''){
			var url3="./purchase_ret_data.php?bill_no="+b[0]+"&op=p&vendor="+v;
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
					$("#retDiv").html(xmlhttp.responseText);
					return false;
				}
	  		}
			xmlhttp.open("POST",url3,true);
			xmlhttp.send();
			$("#retDiv").html("<img src='bigrotation2.gif'>");
			$( "#retDiv").dialog({
			modal: true,
			autOpen:false,
			resizable:false,
			draggable:false,
			width:'700px',
			title:"Purchase Return"
			});
		}
	});
	///////submit////////////
	$("body").delegate("#retTable #submit","click",function(event)
	{
		if(1>0)
		{
			var vendor="vendor="+$("#searchVen").val();
			var url4="insert_return.php";
			var action_date="action_date="+$("#dateReturn").val();  
			var retbillno="retbillno="+$("#retTable #retbillno").val();
			var retchalno="retchalno="+$("#retTable #retchalno").val();
			var cash_check="cash_check=";
			var retQty="retQty=";
			var product="product=";
			var rate="rate=";
			var challan="challan=";
			var dis_rate="dis_rate=";
			if ($("#retTable #retbillno").val()=='' || $("#retTable #retbillno").val()==null) {
				url4+="?type=challan";
			}
			else{
				url4+="?type=bill";
				cash_check+= document.getElementById("cash_check").checked;
				$.each($("#retTable .rate"),function(){
					rate+=this.innerHTML+",";	
				});
				$.each($("#retTable .challan"),function(){
					challan+=this.value+",";	
				});
				$.each($("#retTable .dis_rate"),function(){
					dis_rate+=this.value+",";	
				});
			}
			$.each($("#retTable .product"),function(){
				product+=this.innerHTML+",";	
			});
			$.each($("#retTable .retQty"),function(){
				retQty+=this.value+",";	
			});
			var sendinfo=vendor+"&"+action_date+"&"+retbillno+"&"+retchalno+"&"+retQty+"&"+rate+"&"+dis_rate+"&"+product+"&"+cash_check+"&"+challan;
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
					//$("#sucess").html(xmlhttp.responseText);
					$("#retDiv").dialog("close");
					alert('Successfully data inserted into database');
					window.location='./return.php#ui-tabs-1';
					location.reload('');
				}
			}
			xmlhttp.open("POST",url4,true);
			xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");
			xmlhttp.send(sendinfo);
			return false;
		}
		else
		{alert("Please Fillup Information");return false;}
	});
	$("body").delegate("#retTable .retQty","blur",function(event)
	{
		var tq=parseFloat($(this.parentNode.parentNode).find(".qty").html(),10);
		var q=parseFloat(this.value,10);
		if(this.value.length==0 || q>tq){
		//$("#sellproductTable #totalSpan").html(0);
		$(this.parentNode.parentNode).find(".balQty").html($(this.parentNode.parentNode).find(".qty").html());
		this.value=0;
		return false;
		//$(this).val(0);
		}
		$(this.parentNode.parentNode).find(".balQty").html((tq-q).toFixed(2));
	});
	function rowValidation(row){
		if($(row).find(".product").val()=='' 
		||parseFloat($(row).find(".qty").val(),10)<=0 
		||parseFloat($(row).find(".rate").val(),10)<=0 ){
		
			return false;
		}
		else{return true;}
	}
