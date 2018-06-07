/*----------------sale-----------------------------*/
/*----------------sale-----------------------------*/
/*----------------sale-----------------------------*/
$(function(){
	$("input :button").button();
	$("#payment_table #finalSubmit").button();
	$( "#saledate" ).datepicker({dateFormat :'dd/mm/yy'});
	$( "#chequeDate" ).datepicker({dateFormat :'dd/mm/yy'});
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
////////////customer search///////////
	$("body").delegate("#s-customer #typeC","blur",function(event)
	{
		if($(this).val()!='default'){
			var url3="./search_cust_type.php?cus=true&type="+$(this).val();
			if (window.XMLHttpRequest)
		 	{xmlhttp=new XMLHttpRequest();}
			else		
		  	{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
			xmlhttp.onreadystatechange=function()
			{
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{//alert(xmlhttp.responseText);
				$("#s-customer #searchC").attr('readonly',false);
				customer=xmlhttp.responseText.split(",");
				$("#s-customer #searchC").autocomplete({
					source: customer
				});
				}
			}
			xmlhttp.open("POST",url3,true);
			xmlhttp.send();
		}
		else{$("#s-customer #searchC").attr('readonly',true).val('');}
	});
	$("body").delegate("#s-customer #searchC","change",function(event)
	{
		if($(this).val().length!=0){
			$("#c_bill").slideDown('slow');
			var url4="./search_cust_type.php?des=true&c_id="+$(this).val()+"&type="+$("#s-customer #typeC").val();
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
////////table manipulation/////////
	$("body").delegate("#d_sellproductTable .product","change",function(event)
	{
		var url2="./product_search.php?op=v";
		var p_id=$(this).val();
		var date=$( "#saledate" ).val();
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
    		{//alert(xmlhttp.responseText);
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
	});
/////////calculation//////////////
	$("body").delegate("#d_sellproductTable .rate","keyup",function(event)
	{
		if(this.value.length==0){
		//$("#sellproductTable #totalSpan").html(0);
		$(this.parentNode.parentNode).find(".total").html(0);
		return false;
		//$(this).val(0);
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
		//$("#sellproductTable #totalSpan").html(0);
		$(this.parentNode.parentNode).find(".total").html(0);
		return false;
		//$(this).val(0);
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
	$("body").delegate("#sellproductTable #discount","keyup",function(event)
	{
		var t=parseFloat($("#sellproductTable #totalSpan").html(),10);
		var carchrg=parseFloat($("#carCharge").val(),10);t+=carchrg;
		if(this.value.length==0){
		$("#sellproductTable #tdiscount").val(0);
		$("#sellproductTable #dtotal").html(t);
		return false;
		}

		if(this.value>=100){
		$("#sellproductTable #tdiscount").val(0);
		var carchrg=$("#carCharge").val();
		$("#sellproductTable #dtotal").html(carchrg);

		$(this).val(0);
		return false;
		}
		else{
		
		var dtot=(parseFloat(this.value,10)/100)*t;
		//var carchrg=$("#carCharge").val();dtot+=carchrg;
		$("#sellproductTable #dtotal").html(t-dtot.toFixed(2));
		$("#sellproductTable #tdiscount").val(dtot.toFixed(2));
		}
	});
	$("body").delegate("#sellproductTable #tdiscount","keyup",function(event)
	{
		var t=parseFloat($("#sellproductTable #totalSpan").html(),10);
		var carchrg=parseFloat($("#carCharge").val(),10);t+=carchrg;
		if(this.value.length==0){
		$("#sellproductTable #dtotal").html(t);
		return false;
		}
		if(this.value>=t){
		$("#sellproductTable #dtotal").html(t);
		$("#sellproductTable #tdiscount").val(0);
		return false;
		}
		var d=parseFloat($(this).val(),10);
		$("#sellproductTable #dtotal").html((t-d).toFixed(2));
		$("#sellproductTable #discount").val(0);
	});
/////////Key Press Event//////////
	$("body").delegate("#d_sellproductTable .rate","keypress",function(event)
	{
		if(numbersonly(event)===false){return false}
	});
	$("body").delegate("#d_sellproductTable .qty","keypress",function(event)
	{
		if(numbersonly(event)===false){return false}
	});
	$("body").delegate("#sellproductTable #discount","keypress",function(event)
	{
		if(numbersonly(event)===false){return false}
	});
	$("body").delegate("#sellproductTable #tdiscount","keypress",function(event)
	{
		if(numbersonly(event)===false){return false}
	});
	$("body").delegate("#c_bill #carCharge","keypress",function(event)
	{
		if(numbersonly(event)===false){return false}
	});
	
/////////add & delete row/////////
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
//////////Submit///////////
	$("body").delegate("#payment_table #finalSubmit","click",function(event)
	{
		if(reqField()==true )
		{
			var product_data="product_data=";
			var cusType="cusType="+$("#typeC").val(); 
			var cusName="cusName="+$("#searchC").val(); 
			var billno="billno="+$("#s_billno").val();
			var billdate="saledate="+$("#saledate").val();
			var carCharge="carCharge="+$("#carCharge").val();
			var tdiscount="tdiscount="+$("#tdiscount").val();
			var c=0;
			$.each($("#d_sellproductTable tr.productRow"),function()
			{	if(rowValidation(this)==true)
				{
					product_data+=$(this).find(".product").val()+","+$(this).find(".qty").val()+","+$(this).find(".rate").val()+"|";
					c=1;
				}
			});
			if(c==1 && paymentValidation()==true)
			{
				var ca="ca="+parseFloat($("#payment_table #cashAmount").val(),10);
				var ch="ch="+parseFloat($("#payment_table #chequeAmount").val(),10);
				var cr="cr="+parseFloat($("#payment_table #creditAmount").val(),10);
				var ad="ad="+parseFloat($("#payment_table #advanceAmount").val(),10);
				var forwrdBank="forwrdBank="+$("#payment_table #bank_ac_no").val();
				var chequeNo="chequeNo="+$("#payment_table #chequeNo").val();
				var chequeDate="chequeDate="+$("#payment_table #chequeDate").val();
				var bankName="bankName="+$("#payment_table #bankName").val();
				var branch="branch="+$("#payment_table #branch").val();
				var sendinfo=cusType+"&"+cusName+"&"+billno+"&"+billdate+"&"+carCharge+"&"+tdiscount +"&"+ product_data +"&"+ ca +"&"+ ch +"&"+ cr+"&"+ ad  +"&"+ forwrdBank+"&"+ chequeNo +"&"+ chequeDate+"&"+ bankName+"&"+ branch;
				if (window.XMLHttpRequest) 
				{xmlhttp=new XMLHttpRequest();
				}
				else		
				{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
				xmlhttp.onreadystatechange=function() {
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					//$("#success-sale").html(xmlhttp.responseText);
					var mth_link=xmlhttp.responseText;
					alert('Successfully data inserted into database');
					//window.location='./transaction.php#ui-tabs-2';
					
					window.location='./bill_details.php?type=S&mth_link='+mth_link;
					//location.reload('');
				}
				}
				xmlhttp.open("POST",'insert_sale_product.php',true);
				xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");
			
				xmlhttp.send(sendinfo);
			}
			if(c==0){alert("Fillup Product Details");}
			
		}
		return false;
	});
/////////payment/////////////
	$("#payment_table #cash_check").click(function(){
		$("#payment_table #cashAmount").val(0);
		$("#payment_table #cash_tr").toggle();
	});
	$("#payment_table #cheque_check").click(function(){
		$("#payment_table #chequeAmount").val(0);
		$("#payment_table #cheque_tr").toggle();
	});
	$("#payment_table #credit_check").click(function(){
		$("#payment_table #creditAmount").val(0);
		$("#payment_table #credit_tr").toggle();
	});
	$("#payment_table #advance_check").click(function(){
		$("#payment_table #advanceAmount").val(0);
		$("#payment_table #advance_tr").toggle();
	});
	$("#payment_table #advanceAmount").change(function(){
		if(parseFloat($(this).val(),10)>parseFloat($("#payment_table #curAdvance").html(),10))
		{
			alert("Advance Amount can not grater than\n current Advance Amount");
			$("#payment_table #advanceAmount").val(0);
			return false;
		}
		return true;
	});
/////////validation function////////////
	function reqField(){
		var msg="";
		if($("#typeC").val()=='default')
		{msg+="Select Customer Type.\n";}
		if($("#searchC").val()=='' ||$("#searchC").val()===null)
		{msg+="Enter Customer Name.\n";
		document.getElementById('searchC').focus();}
		if($("#s_billno").val()=='' ||$("#s_billno").val()===null)
		{msg+="Enter Bill No.\n";
		document.getElementById('s_billno').focus();}
		if($("#saledate").val()=='' ||$("#saledate").val()===null)
		{msg+="Enter Sale Date.\n";
		document.getElementById('saledate').focus();}
		if($("#carCharge").val()=='' ||parseFloat($("#carCharge").val(),10)<0)
		{msg+="Enter Transport Charge.\n";
		document.getElementById('carCharge').focus();}
		if($("#totalSpan").html()=='' ||parseFloat($("#totalSpan").html(),10)<=0)
		{msg+="Total Amount Can not be 0.\n";}
		if($("#dtotal").html()=='' ||parseFloat($("#dtotal").html(),10)<=0)
		{msg+="Total Amount with discount Can not be 0.\n";}

		if(msg==""){return true;}
		else{alert(msg); return false;}
	}
	function rowValidation(row){
		if($(row).find(".product").val()=='' 
		||parseFloat($(row).find(".qty").val(),10)<=0 
		||parseFloat($(row).find(".rate").val(),10)<=0 ){
		
			return false;
		}
		else{return true;}
	}
	function paymentValidation(){
		var ca=parseFloat($("#payment_table #cashAmount").val(),10);
		var ch=parseFloat($("#payment_table #chequeAmount").val(),10);
		var cr=parseFloat($("#payment_table #creditAmount").val(),10);
		var ad=parseFloat($("#payment_table #advanceAmount").val(),10);
		var t=ca+ch+cr+ad;
		if(t==parseFloat($("#dtotal").html(),10)){
			return true;		
		}
		else{alert("Payment Amount is Not same as total Amount");return false;}
	}
	function numbersonly(e){
	var unicode=e.charCode? e.charCode : e.keyCode;
	if (unicode!=8){ 
		if (unicode<46||unicode>57||unicode==47) {
			return false;		
		}
	}
	}
	$("#newCusform2").submit(function()
	{	var msg='';
		if(this.cusName.value==null || this.cusName.value=='')
		{
			msg+="Please enter Name\n";
		}
		if(this.village.value==null || this.village.value=='') {
			msg+="Please enter village\n";
		}
		if(this.cusFname.value==null || this.cusFname.value==''){
			msg+="Please enter father Name";
			
		}
		if(msg==''){
			return true;
		}
		else{
			alert(msg);
			return false;
		}
	});
	$("#newCusform1").submit(function()
	{	var msg='';
		if(this.SdName.value==null || this.SdName.value=='')
		{
			msg+="Please enter Name\n";
		}
		if(this.vill.value==null || this.vill.value=='') {
			msg+="Please enter village\n";
		}
		
		if(msg==''){
			return true;
		}
		else{
			alert(msg);
			return false;
		}
	});
});
