$(function(){
	$("input :button").button();
	$("input[type=button]").button();
	$( "#pay_des #pay_date" ).datepicker({dateFormat :'dd/mm/yy'});
	$( "#pay_payment_table #chequeDate" ).datepicker({dateFormat :'dd/mm/yy'});
	var mas=new Array();
	var product=new Array();
	var vendor=new Array();
////////////customer search///////////
	$("body").delegate("#pay_searchdiv #pay_type","blur",function(event)
	{
		if($(this).val()!='default'){
			var url3="./payment_cus_search.php?search=true&type="+$(this).val();
			if (window.XMLHttpRequest)
		 	{xmlhttp=new XMLHttpRequest();}
			else		
		  	{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
			xmlhttp.onreadystatechange=function()
			{
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{//alert(xmlhttp.responseText);
					$("#pay_searchdiv #pay_search").attr('readonly',false);
					customer=xmlhttp.responseText.split(",");
					$("#pay_searchdiv #pay_search").autocomplete({
						source: customer
					});
				}
			}
			xmlhttp.open("POST",url3,true);
			xmlhttp.send();
		}
		else{$("#pay_searchdiv #pay_search").attr('readonly',true).val('');}
	});
////////////customer description///////////
	$("body").delegate("#pay_searchdiv #pay_search","change",function(event)
	{
		if($(this).val().length!=0){
			$("#pay_des").slideDown('slow');
			var url4="./payment_cus_search.php?des=true&c_id="+$(this).val()+"&type="+$("#pay_searchdiv #pay_type").val();
			if (window.XMLHttpRequest)
		 	{xmlhttp=new XMLHttpRequest();}
			else		
		  	{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
			xmlhttp.onreadystatechange=function()
			{
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{//alert(xmlhttp.responseText);
				a=xmlhttp.responseText.split("|");
				$("#pay_des_left #pay_despara").html(a[0]);
				}
			}
			xmlhttp.open("POST",url4,true);
			xmlhttp.send();
			$("#pay_des_left #pay_despara").html("<img src='bigrotation2.gif'>");
		}
	});
////////////select payment///////////

	$("body").delegate("#pay_des #pay_pay","click",function(event)
	{
		var date=$("#pay_des #pay_date").val();
		var venId=$("#pay_searchdiv #pay_search").val();
		if(date.length!=0 && venId.length!=0 ){
			getDebitNo(venId,date);
			var url4="./payment_cus_search.php?selectbill=true&venId="+venId+"&payDate="+date;
			if (window.XMLHttpRequest)
		 	{xmlhttp=new XMLHttpRequest();}
			else
		  	{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
			xmlhttp.onreadystatechange=function()
			{
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{//alert(xmlhttp.responseText);
				$("#pay_amount_div").html(xmlhttp.responseText);
				}
			}
			xmlhttp.open("POST",url4,true);
			xmlhttp.send();//alert(url4);
			$("#pay_amount_div").dialog({
				modal: true,
				autOpen:false,
				resizable:false,
				draggable:false,
				width:'760px',
				title:"Payment"
			});
			$("#pay_amount_div").html("<img src='bigrotation2.gif'>");
		}
	});
	//---------------from payment_cus_search---------------
	$("button").button();
	$('body').delegate('#pay_billdiv #payment_methode1','click',function(event){
		$("#pay_bulk").hide('fast');
		$("#pay_billtable").slideDown('slow');

	});
	$('body').delegate('#pay_billdiv #payment_methode2','click',function(event){
		$("#pay_billtable").hide('fast');
		$("#pay_bulk").slideDown('slow');

	});
//-------bill wish-------------
	$("body").delegate("#pay_billtable .pay","blur",function(event)
	{//alert('hehe');
		if((this.value.length==0) || 
		(parseFloat(this.value,10)>
		parseFloat($(this.parentNode.parentNode).find(".due").html(),10))){

		//alert(parseFloat($(this.parentNode.parentNode).find(".due").html(),10).toFixed(2));
		//alert(parseFloat(this.value,10).toFixed(2));
		this.value=0;
		$(this.parentNode.parentNode).find(".dis").val(0);
		$(this.parentNode.parentNode).find(".netpay").html(0.00);
		return false;
		}
		$(this.parentNode.parentNode).find(".dis").val(0);
		$(this.parentNode.parentNode).find(".netpay").html(parseFloat(this.value,10).toFixed(2));
	});
	$("body").delegate("#pay_billtable .dis","blur",function(event)
	{
		if((this.value.length==0) || (parseFloat(this.value,10)>
		parseFloat($(this.parentNode.parentNode).find(".pay").val(),10))){
		$(this.parentNode.parentNode).find(".dis").val(0);
		$(this.parentNode.parentNode).find(".netpay").html(parseFloat($(this.parentNode.parentNode).find(".pay").val(),10).toFixed(2));
		return false;
		}
		$(this.parentNode.parentNode).find(".netpay").html(parseFloat(parseFloat($(this.parentNode.parentNode).find(".pay").val(),10).toFixed(2)-parseFloat(this.value,10).toFixed(2),10).toFixed(2));
	});
//-------------------bulk--------------------
	$("body").delegate("#pay_bulk .bulk_pay","blur",function(event)
	{
		if((this.value.length==0) || 
		(parseFloat(this.value,10)>
		parseFloat($("#pay_billdiv #pay_due").html(),10))){
		this.value=0;
		$("#pay_billdiv .bulk_dis").val(0);
		$("#pay_billdiv .bulk_netpay").html(0.00);
		return false;
		}
		$("#pay_billdiv .bulk_dis").val(0);
		$("#pay_billdiv .bulk_netpay").html(parseFloat(this.value,10).toFixed(2));
	});
	$("body").delegate("#pay_bulk .bulk_dis","blur",function(event)
	{
		if((this.value.length==0) || 
		(parseFloat(this.value,10)>
		parseFloat($("#pay_billdiv .bulk_pay").val(),10))){
		this.value=0;
		$("#pay_billdiv .bulk_netpay").html(parseFloat($("#pay_billdiv .bulk_pay").val(),10));
		return false;
		}
		$("#pay_billdiv .bulk_netpay").html(parseFloat(parseFloat($("#pay_billdiv .bulk_pay").val(),10)-parseFloat(this.value,10).toFixed(2),10).toFixed(2));
	});
//===================submit======================
	$("body").delegate("#pay_billtable #pay_submitbill","click",function(event)
	{
			var bill_data="bill_data=";
			$.each($("#pay_billtable tr.billtr"),function()
			{	if(rowValidation(this)==true)
				{
					bill_data+=	$(this).find(".billno").html()+","+
								$(this).find(".dis").val()+","+
								$(this).find(".netpay").html()+","+
								$(this).find(".glcode").val()+"|";
				}
			});
			if (window.XMLHttpRequest) 
			{xmlhttp=new XMLHttpRequest();
			}
			else		
			{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
			xmlhttp.onreadystatechange=function() {
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{$("#pay_amount_td").html(xmlhttp.responseText);
					$("#pay_amount_div").dialog("close");

					//alert('Successfully data inserted into database');
					//alert(xmlhttp.responseText);
				}
			}
			xmlhttp.open("POST",'payment_cus_search.php?billwish=true',true);
			xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");
			xmlhttp.send(bill_data);
	});
	$("body").delegate("#pay_bulk #pay_submitbulk","click",function(event)
	{
			var pay="pay="+$("#pay_bulk .bulk_netpay").html();
			var dis="dis="+$("#pay_bulk .bulk_dis").val();
			var sendinfo=pay+"&"+dis;
			if (window.XMLHttpRequest) 
			{xmlhttp=new XMLHttpRequest();
			}
			else		
			{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
			xmlhttp.onreadystatechange=function() {
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{$("#pay_amount_td").html(xmlhttp.responseText);
					$("#pay_amount_div").dialog("close");
					//alert('Successfully data inserted into database');
					//alert(xmlhttp.responseText);
				}
			}
			xmlhttp.open("POST",'payment_cus_search.php?bulkpay=true',true);
			xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");
			xmlhttp.send(sendinfo);
	});
	function rowValidation(row){
		if(parseFloat($(row).find(".pay").val(),10)<=0){
			return false;
		}
		else{return true;}
	}
	//---------------end of payment_cus_search-------------
/////////Key Press Event//////////
	$("body").delegate("#pay_des #pay_amount","keypress",function(event)
	{
		if(numbersonly(event)===false){return false}
	});
	$("body").delegate("#pay_des #pay_dis_amount","keypress",function(event)
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
//////////Submit///////////
	$("body").delegate("#pay_payment_table #finalSubmit","click",function(event)
	{
		if(reqField()==true )
		{
			var type="type="+$("#pay_searchdiv #pay_type").val(); 
			var name="name="+$("#pay_searchdiv #pay_search").val(); 
			//var payAmount="payAmount="+$("#pay_des #pay_amount").val();
			var payAmount="payAmount="+$("#pay_bill_tpay_hidden").val();
			var disAmount="disAmount="+$("#pay_bill_tdispay_hidden").val();			
			var bill_data="bill_data="+$("#pay_bill_sum_hidden").val();
			var paydate="paydate="+$("#pay_des #pay_date").val();
			var ca="ca="+parseFloat($("#pay_payment_table #cashAmount").val(),10);
			var ch="ch="+parseFloat($("#pay_payment_table #chequeAmount").val(),10);
			var dn="dn="+getDebitTotal();
			var ad="ad="+parseFloat($("#pay_payment_table #advanceAmount").val(),10);
			var forwrdBank="forwrdBank="+$("#pay_payment_table #forwrdBank").val();
			var chequeNo="chequeNo="+$("#pay_payment_table #chequeNo").val();
			var chequeDate="chequeDate="+$("#pay_payment_table #chequeDate").val();
			var bankName="bankName="+$("#pay_payment_table #bankName").val();
			var branch="branch="+$("#pay_payment_table #branch").val();
			var sendinfo=type+"&"+disAmount+"&"+name+"&"+payAmount+"&"+bill_data+"&"+paydate+"&"+"&"+ ca +"&"+ ch +"&"+ ad +"&"+ dn +"&"+ forwrdBank+"&"+ chequeNo +"&"+ chequeDate+"&"+ bankName+"&"+ branch;
			if (window.XMLHttpRequest) 
			{xmlhttp=new XMLHttpRequest();
			}
			else		
			{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
			xmlhttp.onreadystatechange=function() {
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{//$("#success").html(xmlhttp.responseText);
					alert('Successfully data inserted into database');
					//alert(xmlhttp.responseText);
					window.location='./transaction.php#ui-tabs-3';
					location.reload('');
				}
			}
			xmlhttp.open("POST",'insert_payment_product.php',true);
			xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");
			xmlhttp.send(sendinfo);
			
		}
		return false;
	});
/////////payment/////////////
	$("#pay_payment_table #cash_check").click(function(){
		$("#pay_payment_table #cashAmount").val(0);
		$("#pay_payment_table #cash_tr").slideToggle();
	});
	$("#pay_payment_table #cheque_check").click(function(){
		$("#pay_payment_table #chequeAmount").val(0);		
		$("#pay_payment_table #cheque_tr").slideToggle();
	});
	/*$("#pay_payment_table #credit_check").click(function(){
		$("#pay_payment_table #credit_tr").slideToggle();
	});*/
	$("#pay_payment_table #advance_check").click(function(){
		$("#pay_payment_table #advanceAmount").val(0);
		$("#pay_payment_table #advance_tr").slideToggle();
	});
	$("#pay_payment_table #advanceAmount").change(function(){
		if(parseFloat($(this).val(),10)>parseFloat($("#pay_payment_table #curAdvance").html(),10))
		{
			alert("Advance Amount can not grater than\n current Advance Amount");
			$(this).val(0);
			return false;
		}
		return true;
	});
/////////get debit note////////////
	function getDebitNo(vendorId,action_date){
			var url5="./payment_cus_search.php?debitNote=true&vendorId="+vendorId+"&action_date="+action_date;
			if (window.XMLHttpRequest)
		 	{xmlhttp5=new XMLHttpRequest();}
			else		
		  	{xmlhttp5=new ActiveXObject("Microsoft.XMLHTTP");}
			xmlhttp5.onreadystatechange=function()
			{
				if (xmlhttp5.readyState==4 && xmlhttp5.status==200)
				{//alert(xmlhttp.responseText);
				$("#debitTd").html(xmlhttp5.responseText);
				}
			}
			xmlhttp5.open("POST",url5,true);
			xmlhttp5.send();
			$("#debitTd").html("<img src='bigrotation2.gif'>");
	}
	function getDebitTotal(){
		var dn='';
		$.each($("#debitForm :checked"),function(){
			dn+=this.value+","+this.name+"|";
		});
		return dn;
	}
	function getDebitTotalAmount(){//alert(getDebitTotal())
		if(getDebitTotal()!='' && getDebitTotal()!= null){
			dn1=getDebitTotal().split('|');
			var t=0;
			for(i=0;i<dn1.length-1;i++){
				dn2=dn1[i].split(',');
				t+=parseFloat(dn2[0],10);
			}
			return t;
		}
		else{
			return 0;
		}
	}
/////////validation function////////////
	function reqField(){
		var msg="";
		if($("#pay_searchdiv #pay_type").val()=='default')
		{msg+="Select Type vendor or customer.\n";}
		if($("#pay_searchdiv #pay_search").val()=='' ||$("#pay_searchdiv #pay_search").val()===null)
		{msg+="Enter Customer Name.\n";
		document.getElementById('pay_search').focus();}
		if($("#pay_des #pay_date").val()=='' ||$("#pay_des #pay_date").val()===null)
		{msg+="Enter Payment Date.\n";
		document.getElementById('pay_date').focus();}
		if(parseFloat($("#pay_bill_tpay_hidden").val(),10) <=0 ||$("#pay_bill_tpay_hidden").val()==null)
		{msg+="Enter Payment Amount.\n";
		}
		if(msg==""){
			if(paymentValidation()==true)return true;
			else return false;
		}
		else{alert(msg); return false;}
	}
	function paymentValidation(){
		var ca=parseFloat($("#pay_payment_table #cashAmount").val(),10);
		var ch=parseFloat($("#pay_payment_table #chequeAmount").val(),10);
		var dn=parseFloat(getDebitTotalAmount(),10);
		var ad=parseFloat($("#pay_payment_table #advanceAmount").val(),10);
		var t=ca+ch+ad+dn;
		//alert('ca'+ca+'ch'+ch+'dn'+dn+'ad'+ad+'total:'+t);
		//alert("total bill:"+parseFloat($("#pay_bill_tpay_hidden").val(),10));
		if(t==parseFloat($("#pay_bill_tpay_hidden").val(),10)){
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
});
