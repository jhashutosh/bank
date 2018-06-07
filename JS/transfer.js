/*----------------transfer-----------------------------*/
/*----------------transfer-----------------------------*/
/*----------------transfer-----------------------------*/
$(function(){
////////////--init---------------////////////
	$("#tranDate").datepicker({dateFormat :'dd/mm/yy'});
	$( "#chequeDate" ).datepicker({dateFormat :'dd/mm/yy'});
	//---------------------------
	var url3="./search_cust_type.php?cus=true&type=B";
	if (window.XMLHttpRequest)
 	{xmlhttp1=new XMLHttpRequest();}
	else		
  	{xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");}
	xmlhttp1.onreadystatechange=function()
	{
		if (xmlhttp1.readyState==4 && xmlhttp1.status==200)
		{//alert("bal"+xmlhttp1.responseText);
			customer=xmlhttp1.responseText.split(",");
			$("#s-customer #searchC").autocomplete({
				source: customer
			});
		}
	}
	xmlhttp1.open("POST",url3,true);
	xmlhttp1.send();
	//---------------------
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
			//vendor=mas[1].split(",");		
			$("#d_sellproductTable .product").autocomplete({
				source: product
			});
		}
	}
	xmlhttp.open("POST",url1,true);
	xmlhttp.send();
////////////--customer search-----///////////
	$("body").delegate("#s-customer #searchC","change",function(event)
	{
		if($(this).val().length!=0){
			$("#c_bill").slideDown('slow');
			var url4="./search_cust_type.php?des=true&c_id="+$(this).val()+"&type=B";
			if (window.XMLHttpRequest)
		 	{xmlhttp=new XMLHttpRequest();}
			else		
		  	{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
			xmlhttp.onreadystatechange=function()
			{
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{//alert(xmlhttp.responseText);
				$("#d-customer #desCustomer").html(xmlhttp.responseText);
				}
			}
			xmlhttp.open("POST",url4,true);
			xmlhttp.send();
			$("#d-customer #desCustomer").html("<img src='bigrotation2.gif'>");
		}
	});
////////////--table manipulation----/////////
	$("body").delegate("#d_sellproductTable .product","change",function(event)
	{
		var url2="./product_search.php?op=v";
		var p_id=$(this).val();
		var date=$( "#tranDate" ).val();
		url2=url2+'&p_id='+p_id+'&date='+date;
		var node=$(this.parentNode.parentNode);
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
			var x=xmlhttp.responseText.split(',');
			node.find(".stock").html(x[0]);
			node.find(".stock_uom").html(x[2]);
			node.find(".avg_rate").html(x[3]);
			node.find(".qty").attr('readonly',false);
			node.find(".qty_uom").html(x[2]);
			node.find(".rate").attr('readonly',false);
			return true;
		}
		}
		xmlhttp.open("POST",url2,true);
		xmlhttp.send();
		//--------select batch no-------------no.1
		var url21="./product_search.php?op=batch_no&mm_code="+this.value;
		if (window.XMLHttpRequest) 
 		{
  			xmlhttp11=new XMLHttpRequest();
  		}
		else		
  		{
  			xmlhttp11=new ActiveXObject("Microsoft.XMLHTTP");
 		}
		xmlhttp11.onreadystatechange=function() {
		if (xmlhttp11.readyState==4 && xmlhttp11.status==200)
    		{//alert(xmlhttp11.responseText)
			node.find(".batch_no").html(xmlhttp11.responseText);
			//return true;
			}
		}
		xmlhttp11.open("POST",url21,true);
		xmlhttp11.send();
		//------end-------no.1--end
	});
	$("body").delegate("#d_sellproductTable .batch_no_select","change",function(event)
	{
		var node=$(this.parentNode.parentNode.parentNode);
		var url2="./product_search.php?op=v";
		var p_id=node.find('.product').val();
		var date=$( "#tranDate" ).val();
		url2=url2+'&p_id='+p_id+'&date='+date;
		var batch_no=$(this).val();
		if (batch_no.length!=0) {
			url2+="&batch_no="+batch_no;
		}
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
			var x=xmlhttp.responseText.split(',');
			node.find(".stock").html(x[0]);
			return true;
		}
		}
		xmlhttp.open("POST",url2,true);
		xmlhttp.send();
	});
////////////--calculation------//////////////
	$("body").delegate("#d_sellproductTable .rate","keyup",function(event)
	{
		if(this.value.length==0){
		$(this.parentNode.parentNode).find(".total").html(0);
		return false;
		}
		var q=parseInt($(this.parentNode.parentNode).find(".qty").val(),10);
		$(this.parentNode.parentNode).find(".total").html((q*parseFloat((this.value),10)).toFixed(2));
		var tot=0;
		$.each($("#d_sellproductTable .total"),function(){
		tot+=parseFloat(this.innerHTML,10);	
		});
		$("#sellproductTable #totalSpan").html(tot.toFixed(2));
	});
	$("body").delegate("#d_sellproductTable .qty","keyup",function(event)
	{
		if(this.value.length==0){
		$(this.parentNode.parentNode).find(".total").html(0);
		return false;
		}
		if(parseInt(this.value,10)>parseInt($(this.parentNode.parentNode).find('.stock').html(),10)){
			alert("Quantity can not grater than stock");
			$(this).val(0);
			return false;
		}
		var q=parseInt($(this.parentNode.parentNode).find(".rate").val(),10);
		$(this.parentNode.parentNode).find(".total").html((q*parseFloat((this.value),10)).toFixed(2));
		var tot=0;
		$.each($("#d_sellproductTable .total"),function(){
		tot+=parseFloat(this.innerHTML,10);	
		});
		$("#sellproductTable #totalSpan").html(tot.toFixed(2));
	});
////////////--Key Press Event------//////////
	$("body").delegate("#d_sellproductTable .rate","keypress",function(event)
	{
		if(numbersonly(event)===false){return false}
	});
	$("body").delegate("#d_sellproductTable .qty","keypress",function(event)
	{
		if(numbersonly(event)===false){return false}
	});	
////////////--add & delete row------/////////
	$("body").delegate("#d_sellproductTable .addrow","click",function(event)
	{
		var r=this.parentNode.parentNode;
		var root = r.parentNode;
		var cRow = r.cloneNode(true);
		$(cRow).find(".product").val('');
		$(cRow).find(".mm-code").val('');
		$(cRow).find(".stock").html(0);
		$(cRow).find(".stock_uom").html('');
		$(cRow).find(".qty_uom").html('');
		$(cRow).find(".batch_no").html('');//-------no.2
		$(cRow).find(".avg_rate").html(0);
		$(cRow).find(".qty").val(0);
		$(cRow).find(".rate").val(0);
		$(cRow).find(".total").html(0);
		$(cRow).find(".qty").attr('readonly',true);
		$(cRow).find(".rate").attr('readonly',true);
		$(cRow).find(".product").autocomplete({
			source: product
		});
		root.appendChild(cRow);
		$.each($("#d_sellproductTable").find(".slNo"),function(index,value){
			$(this).html(index+1);
		});
	});
	$("body").delegate("#d_sellproductTable .delrow","click",function(event)
	{
		var r=this.parentNode.parentNode;
		if($("#d_sellproductTable tr").length!=2){
			$(r).remove();
			$.each($("#d_sellproductTable").find(".slNo"),function(index,value){
				$(this).html(index+1);
			});
		}
	});
////////////--Submit--------------///////////
	$("body").delegate("#sell_product #finalSubmit","click",function(event)
	{
		if(reqField()==true )
		{
			var product_data="product_data=";
			var branchName="branchName="+$("#searchC").val(); 
			var tranDate="tranDate="+$("#tranDate").val();
			var c=0;
			$.each($("#d_sellproductTable tr.productRow"),function()
			{
				if(rowValidation(this)==true)
				{
					product_data+=$(this).find(".product").val()+","+$(this).find(".qty").val()+","+$(this).find(".rate").val()+","+$(this).find(".batch_no_select").val()+"|";
					c=1;
				}
			});
			if(c==1)
			{
				var sendinfo=branchName+"&"+product_data+"&"+tranDate;
				if (window.XMLHttpRequest) 
				{xmlhttp=new XMLHttpRequest();
				}
				else		
				{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
				xmlhttp.onreadystatechange=function() {
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					//$("#success").html(xmlhttp.responseText);
					alert('Successfully data inserted into database\n'+xmlhttp.responseText);
					window.location='./transfer.php';
					location.reload('');
				}
				}
				xmlhttp.open("POST",'insert_transfer.php',true);
				xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");
				xmlhttp.send(sendinfo);
			}
			if(c==0){alert("Fillup Product Details");}
		}
		return false;
	});
////////////--validation function////////////
	function reqField(){
		var msg="";
		if($("#searchC").val()=='' ||$("#searchC").val()===null)
		{msg+="Enter Customer Name.\n";
		document.getElementById('searchC').focus();}
		if($("#tranDate").val()=='' ||$("#tranDate").val()===null)
		{msg+="Enter Date.\n";
		document.getElementById('tranDate').focus();}
		if($("#totalSpan").html()=='' ||parseFloat($("#totalSpan").html(),10)<=0)
		{msg+="Total Amount Can not be 0.\n";}
		if(msg==""){return true;}
		else{alert(msg); return false;}
	}
	function rowValidation(row){
		if($(row).find(".product").val()=='' 
		||parseFloat($(row).find(".qty").val(),10)<=0 
		||parseFloat($(row).find(".rate").val(),10)<=0
		||$(row).find(".batch_no_select").val()==''
		||$(row).find(".batch_no_select").val()==null){
			return false;
		}
		else{return true;}
	}
	function numbersonly(e){
		var unicode=e.charCode? e.charCode : e.keyCode;
		if (unicode!=8){ 
			if (unicode<46||unicode>57||unicode==47) {
				return false;		
			}
		}
	}
});