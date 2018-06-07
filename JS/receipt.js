$(function(){
	$("input :button").button();
	$("input[type=button]").button();
	$( "#rec_des #rec_date" ).datepicker({dateFormat :'dd/mm/yy'});
	$( "#rec_receipt_table #chequeDate" ).datepicker({dateFormat :'dd/mm/yy'});
	var mas=new Array();
	var product=new Array();
	var vendor=new Array();
////////////customer search///////////
	$("body").delegate("#rec_searchdiv #rec_type","blur",function(event)
	{
		if($(this).val()!='default'){
			var url3="./receipt_cus_search.php?search=true&type="+$(this).val();
			if (window.XMLHttpRequest)
		 	{xmlhttp=new XMLHttpRequest();}
			else		
		  	{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
			xmlhttp.onreadystatechange=function()
			{
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{//alert(xmlhttp.responseText);
					$("#rec_searchdiv #rec_search").attr('readonly',false);
					customer=xmlhttp.responseText.split(",");
					$("#rec_searchdiv #rec_search").autocomplete({
						source: customer
					});
				}
			}
			xmlhttp.open("POST",url3,true);
			xmlhttp.send();
		}
		else{$("#rec_searchdiv #rec_search").attr('readonly',true).val('');}
	});
////////////customer description///////////

	$("body").delegate("#rec_searchdiv #rec_search","change",function(event)
	{
		if($(this).val().length!=0){
			$("#rec_des").slideDown('slow');
			var url4="./receipt_cus_search.php?des=true&c_id="+$(this).val()+"&type="+$("#rec_searchdiv #rec_type").val();
			if (window.XMLHttpRequest)
		 	{xmlhttp=new XMLHttpRequest();}
			else		
		  	{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
			xmlhttp.onreadystatechange=function()
			{
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{//alert(xmlhttp.responseText);
				a=xmlhttp.responseText.split("|");
				$("#rec_des_left #rec_despara").html(a[0]);
				}
			}
			xmlhttp.open("POST",url4,true);
			xmlhttp.send();
			$("#rec_des_left #rec_despara").html("<img src='bigrotation2.gif'>");
		}
	});
////////////select receipt///////////

	$("body").delegate("#rec_des #rec_rec","click",function(event)
	{
		var date=$("#rec_des #rec_date").val();
		var venId=$("#rec_searchdiv #rec_search").val();
		if(date.length!=0 && venId.length!=0 ){
			getCreditNo(venId,date);
			var url4="./receipt_cus_search.php?selectbill=true&venId="+venId+"&recDate="+date;
			if (window.XMLHttpRequest)
		 	{xmlhttp=new XMLHttpRequest();}
			else
		  	{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
			xmlhttp.onreadystatechange=function()
			{
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{//alert("ajax:::::"+xmlhttp.responseText);
				$("#rec_amount_div").html(xmlhttp.responseText);

				}
			}
			xmlhttp.open("POST",url4,true);
			xmlhttp.send();//alert(url4);
			$("#rec_amount_div").dialog({
				modal: true,
				autOpen:false,
				resizable:false,
				draggable:false,
				width:'760px',
				title:"receipt"
			});
			$("#rec_amount_div").html("<img src='bigrotation2.gif'>");
		}
	});
	//---------------from receipt_cus_search---------------
	$("button").button();
	$('body').delegate('#rec_billdiv #receipt_methode1','click',function(event){
		$("#rec_bulk").hide('fast');
		$("#rec_billtable").slideDown('slow');

	});
	$('body').delegate('#rec_billdiv #receipt_methode2','click',function(event){
		$("#rec_billtable").hide('fast');
		$("#rec_bulk").slideDown('slow');

	});
//-------bill wish-------------
	$("body").delegate("#rec_billtable .rec","blur",function(event)
	{
		if((this.value.length==0) || 
		(parseFloat(this.value,10)>
		parseFloat($(this.parentNode.parentNode).find(".due").html(),10))){

		//alert(parseFloat($(this.parentNode.parentNode).find(".due").html(),10).toFixed(2));
		//alert(parseFloat(this.value,10).toFixed(2));
		this.value=0;
		$(this.parentNode.parentNode).find(".dis").val(0);
		$(this.parentNode.parentNode).find(".netrec").html(0.00);
		return false;
		}
		$(this.parentNode.parentNode).find(".dis").val(0);
		$(this.parentNode.parentNode).find(".netrec").html(parseFloat(this.value,10).toFixed(2));
	});
	$("body").delegate("#rec_billtable .dis","blur",function(event)
	{
		if((this.value.length==0) || (parseFloat(this.value,10)>
		parseFloat($(this.parentNode.parentNode).find(".rec").val(),10))){
		$(this.parentNode.parentNode).find(".dis").val(0);
		$(this.parentNode.parentNode).find(".netrec").html(parseFloat($(this.parentNode.parentNode).find(".rec").val(),10).toFixed(2));
		return false;
		}
		$(this.parentNode.parentNode).find(".netrec").html(parseFloat(parseFloat($(this.parentNode.parentNode).find(".rec").val(),10).toFixed(2)-parseFloat(this.value,10).toFixed(2),10).toFixed(2));
	});
//-------------------bulk--------------------
	$("body").delegate("#rec_bulk .bulk_rec","blur",function(event)
	{
		if((this.value.length==0) || 
		(parseFloat(this.value,10)>
		parseFloat($("#rec_billdiv #rec_due").html(),10))){
		this.value=0;
		$("#rec_billdiv .bulk_dis").val(0);
		$("#rec_billdiv .bulk_netrec").html(0.00);
		return false;
		}
		$("#rec_billdiv .bulk_dis").val(0);
		$("#rec_billdiv .bulk_netrec").html(parseFloat(this.value,10).toFixed(2));
	});
	$("body").delegate("#rec_bulk .bulk_dis","blur",function(event)
	{
		if((this.value.length==0) || 
		(parseFloat(this.value,10)>
		parseFloat($("#rec_billdiv .bulk_rec").val(),10))){
		this.value=0;
		$("#rec_billdiv .bulk_netrec").html(parseFloat($("#rec_billdiv .bulk_rec").val(),10));
		return false;
		}
		$("#rec_billdiv .bulk_netrec").html(parseFloat(parseFloat($("#rec_billdiv .bulk_rec").val(),10)-parseFloat(this.value,10).toFixed(2),10).toFixed(2));
	});
//===================submit======================
	$("body").delegate("#rec_billtable #rec_submitbill","click",function(event)
	{
			var bill_data="bill_data=";
			$.each($("#rec_billtable tr.billtr"),function()
			{	if(rowValidation(this)==true)
				{
					bill_data+=	$(this).find(".billno").html()+","+
								$(this).find(".dis").val()+","+
								$(this).find(".netrec").html()+","+
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
				{$("#rec_amount_td").html(xmlhttp.responseText);
					$("#rec_amount_div").dialog("close");
					//alert('Successfully data inserted into database');
					//alert(xmlhttp.responseText);
				}
			}
			xmlhttp.open("POST",'receipt_cus_search.php?billwish=true',true);
			xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");
			xmlhttp.send(bill_data);
	});
	$("body").delegate("#rec_bulk #rec_submitbulk","click",function(event)
	{
			var rec="rec="+$("#rec_bulk .bulk_netrec").html();
			var dis="dis="+$("#rec_bulk .bulk_dis").val();
			var sendinfo=rec+"&"+dis;
			if (window.XMLHttpRequest) 
			{xmlhttp=new XMLHttpRequest();
			}
			else		
			{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
			xmlhttp.onreadystatechange=function() {
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{$("#rec_amount_td").html(xmlhttp.responseText);
					$("#rec_amount_div").dialog("close");

					//alert('Successfully data inserted into database');
					//alert(xmlhttp.responseText);
				}
			}
			xmlhttp.open("POST",'receipt_cus_search.php?bulkrec=true',true);
			xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");
			xmlhttp.send(sendinfo);
	});
	function rowValidation(row){
		if(parseFloat($(row).find(".rec").val(),10)<=0  ){
			return false;
		}
		else{return true;}
	}
	//---------------end of receipt_cus_search-------------
/////////Key Press Event//////////
	$("body").delegate("#rec_des #rec_amount","keypress",function(event)
	{
		if(numbersonly(event)===false){return false}
	});
	$("body").delegate("#rec_des #rec_dis_amount","keypress",function(event)
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
	$("body").delegate("#rec_receipt_table #finalSubmit","click",function(event)
	{
		if(reqField()==true )
		{
			var type="type="+$("#rec_searchdiv #rec_type").val(); 
			var name="name="+$("#rec_searchdiv #rec_search").val(); 
			//var recAmount="recAmount="+$("#rec_des #rec_amount").val();
			var recAmount="recAmount="+$("#rec_bill_trec_hidden").val();
			var disAmount="disAmount="+$("#rec_bill_tdisrec_hidden").val();			
			var bill_data="bill_data="+$("#rec_bill_sum_hidden").val();
			var recdate="recdate="+$("#rec_des #rec_date").val();
			var ca="ca="+parseFloat($("#rec_receipt_table #cashAmount").val(),10);
			var ch="ch="+parseFloat($("#rec_receipt_table #chequeAmount").val(),10);
			var cn="cn="+getCreditTotal();
			var ad="ad="+parseFloat($("#rec_receipt_table #advanceAmount").val(),10);
			var forwrdBank="forwrdBank="+$("#rec_receipt_table #forwrdBank").val();
			var chequeNo="chequeNo="+$("#rec_receipt_table #chequeNo").val();
			var chequeDate="chequeDate="+$("#rec_receipt_table #chequeDate").val();
			var bankName="bankName="+$("#rec_receipt_table #bankName").val();
			var branch="branch="+$("#rec_receipt_table #branch").val();
			var sendinfo=type+"&"+name+"&"+recAmount+"&"+disAmount+"&"+bill_data+"&"+recdate+"&"+"&"+ ca +"&"+ ch +"&"+ ad  +"&"+ cn+"&"+ forwrdBank+"&"+ chequeNo +"&"+ chequeDate+"&"+ bankName+"&"+ branch;
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
					window.location='./transaction.php#ui-tabs-4';
					location.reload('');
				}
			}
			xmlhttp.open("POST",'insert_receipt_product.php',true);
			xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");
			xmlhttp.send(sendinfo);
		}
		return false;
	});
/////////receipt/////////////
	$("#rec_receipt_table #cash_check").click(function(){
		$("#rec_receipt_table #cashAmount").val(0);
		$("#rec_receipt_table #cash_tr").slideToggle();
	});
	$("#rec_receipt_table #cheque_check").click(function(){
		$("#rec_receipt_table #chequeAmount").val(0);		
		$("#rec_receipt_table #cheque_tr").slideToggle();
	});
	/*$("#rec_receipt_table #credit_check").click(function(){
		$("#rec_receipt_table #credit_tr").slideToggle();
	});*/
	$("#rec_receipt_table #advance_check").click(function(){
		$("#rec_receipt_table #advanceAmount").val(0);
		$("#rec_receipt_table #advance_tr").slideToggle();
	});
	$("#rec_receipt_table #advanceAmount").change(function(){
		if(parseFloat($(this).val(),10)>parseFloat($("#rec_receipt_table #curAdvance").html(),10))
		{
			alert("Advance Amount can not grater than\n current Advance Amount");
			$(this).val(0);			
			return false;
		}
		return true;
	});
	function getCreditNo(vendorId,action_date){
			var url5="./receipt_cus_search.php?creditNote=true&vendorId="+vendorId+"&action_date="+action_date;
			if (window.XMLHttpRequest)
		 	{xmlhttp5=new XMLHttpRequest();}
			else		
		  	{xmlhttp5=new ActiveXObject("Microsoft.XMLHTTP");}
			xmlhttp5.onreadystatechange=function()
			{
				if (xmlhttp5.readyState==4 && xmlhttp5.status==200)
				{//alert(xmlhttp5.responseText);
				$("#creditTd").html(xmlhttp5.responseText);
				}
			}
			xmlhttp5.open("POST",url5,true);
			xmlhttp5.send();
			$("#creditTd").html("<img src='bigrotation2.gif'>");
	}
	function getCreditTotal(){
		var cn='';
		$.each($("#creditForm :checked"),function(){
			cn+=this.value+","+this.name+"|";
		});
		return cn;
	}
	function getCreditTotalAmount(){//alert(getCreditTotal())
		if(getCreditTotal()!='' && getCreditTotal()!= null){
			cn1=getCreditTotal().split('|');
			var t=0;
			for(i=0;i<cn1.length-1;i++){
				cn2=cn1[i].split(',');
				t+=parseFloat(cn2[0],10);
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
		if($("#rec_searchdiv #rec_type").val()=='default')
		{msg+="Select Type vendor or customer.\n";}
		if($("#rec_searchdiv #rec_search").val()=='' ||$("#rec_searchdiv #rec_search").val()===null)
		{msg+="Enter Customer Name.\n";
		document.getElementById('rec_search').focus();}
		if($("#rec_des #rec_date").val()=='' ||$("#rec_des #rec_date").val()===null)
		{msg+="Enter receipt Date.\n";
		document.getElementById('rec_date').focus();}
		if(parseFloat($("#rec_bill_trec_hidden").val(),10) <=0 ||$("#rec_bill_trec_hidden").val()==null)
		{msg+="Enter receipt Amount.\n";
		}
		if(msg==""){
			if(receiptValidation()==true)return true;
			else return false;
		}
		else{alert(msg); return false;}
	}
	function receiptValidation(){
		var ca=parseFloat($("#rec_receipt_table #cashAmount").val(),10);
		var ch=parseFloat($("#rec_receipt_table #chequeAmount").val(),10);
		var cn=parseFloat(getCreditTotalAmount(),10);
		var ad=parseFloat($("#rec_receipt_table #advanceAmount").val(),10);
		var t=ca+ch+ad+cn;
		if(t==parseFloat($("#rec_bill_trec_hidden").val(),10)){
			return true;		
		}
		else{alert("receipt Amount is Not same as total Amount");return false;}
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
