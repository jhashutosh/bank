$(function()
{
//---------------------------------------init------------------------------------
	var url1="./product_search.php?op=m";
	var mas=new Array();
	var product=new Array();
	var vendor=new Array();
	if (window.XMLHttpRequest) 
 	{xmlhttp=new XMLHttpRequest();}
	else		
  	{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			mas=xmlhttp.responseText.split("|");
			product=mas[0].split(",");
			$(".pro").autocomplete({
				source: product
			});
		}
	}
	xmlhttp.open("POST",url1,true);
	xmlhttp.send();
	$( "#op_dt" ).datepicker({dateFormat :'dd/mm/yy'});
//-----------------------------------add row----------------------------------------------
	$("#op_st").delegate(".addrow1","click",function()
	{			
		document.getElementById('op_id').value=1;
		validationEachRow();
		if(document.getElementById('op_id').value==1)
		{
			r=this.parentNode.parentNode;
			var root = r.parentNode;
			var allRows = root.getElementsByTagName('tr');
			var cRow = r.cloneNode(true);
			var cInp = cRow.getElementsByTagName('input');
			for(var i=0;i<cInp.length;i++)
			{
				cInp[i].setAttribute('name',cInp[i].getAttribute('name')+'_'+(allRows.length+1)); 
				cInp[i].setAttribute('id',cInp[i].getAttribute('id')+'_'+(allRows.length+1));
			}
			$(cRow).find(".mfd").removeClass("hasDatepicker");
			$(cRow).find(".exd").removeClass("hasDatepicker");

			$(cRow).find(".btno").attr('readonly',true);
			$(cRow).find(".mfd").attr('readonly',true);
			$(cRow).find(".exd").attr('readonly',true);
			$(cRow).find(".pro").autocomplete({
				source: product
			});


			root.appendChild(cRow);
			var id=document.getElementById(cInp[0].getAttribute('id')).value=allRows.length-1;
			document.getElementById(cInp[1].getAttribute('id')).value='';
			document.getElementById(cInp[2].getAttribute('id')).value='';
			document.getElementById(cInp[3].getAttribute('id')).value='';
			document.getElementById(cInp[4].getAttribute('id')).value='';
			document.getElementById(cInp[5].getAttribute('id')).value='';
			document.getElementById(cInp[6].getAttribute('id')).value='';
			document.getElementById(cInp[7].getAttribute('id')).value='';					
			$.each($("#op_st").find(".cr"),function(index,value){
				$(this).val(index+1);
			});
		}
		else{
			return false;
		}
	});
//-----------------------------del row---------------------------
	$("body").delegate("#op_st .delrow","click",function(event)
	{
		var r=this.parentNode.parentNode;
		if($("#op_st .rowcl1").length!=1){
			$(r).remove();
			$.each($("#op_st").find(".cr"),function(index,value){
				$(this).val(index+1);
			});
		}
	});
//-------------------------------------------after product select-------------------------------
	$("#op_st").delegate(".pro","change",function()
	{
		var url2="./product_search.php?op=v";
		var op_id=$(this.parentNode.parentNode).find(".pro").val();
		url2=url2+'&op_id='+op_id;
		url2=url2+'&date='+$("#op_dt").val();
		var node=$(this.parentNode.parentNode);
		if (window.XMLHttpRequest) 
 		{xmlhttp=new XMLHttpRequest();}
		else		
  		{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
		xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    		{	//alert(xmlhttp.responseText);
				var x=xmlhttp.responseText.split(',');
	 			if(x[1]=='G-3')
				{
					node.find(".grpid").val('1');
					node.find(".btno").attr('readonly',false);
					node.find(".mfd").attr('readonly',false);
					node.find(".exd").attr('readonly',false);
					node.find(".mfd").removeClass("hasDatepicker");
					node.find(".exd").removeClass("hasDatepicker");
					node.find( ".mfd" ).datepicker({dateFormat :'dd/mm/yy'});
					node.find( ".exd" ).datepicker({dateFormat :'dd/mm/yy'});
				}
				else
				{
					node.find(".grpid").val('0');
					node.find(".btno").attr('readonly',true);
					node.find(".mfd").attr('readonly',true);
					node.find(".exd").attr('readonly',true);
				}
				node.find(".g_id").val(x[1]);
				node.find(".puqty").attr('readonly',false);
				return true;
			}
		}
		xmlhttp.open("POST",url2,true);
		xmlhttp.send();
	});
//-------------------------------------------submit form-----------------------------------------
	$("body").delegate("#op_stk","submit",function()
	{
		document.getElementById('op_id').value=1;
		validationEachRow();
		if(document.getElementById('op_id').value==1){
			$.each($('#op_st').find('.pro'),function(index,value)
			{
				if(index==0)
				{			
					document.getElementById('mate').value+=this.value;
				}
				else
				{
					document.getElementById('mate').value+=","+this.value;
				}
			});
			document.getElementById('mate').value+="|";
			$.each($('#op_st').find('.g_id'),function(index,value)
			{
				if(index==0)
				{			
					document.getElementById('mate').value+=this.value;
				}
				else
				{
					document.getElementById('mate').value+=","+this.value;
				}
			});
			document.getElementById('mate').value+="|";
			$.each($('#op_st').find('.puqty'),function(index,value)
			{
				if(index==0)
				{			
					document.getElementById('mate').value+=this.value;
				}
				else
				{
					document.getElementById('mate').value+=","+this.value;
				}
			});
			document.getElementById('mate').value+="|";
			$.each($('#op_st').find('.val'),function(index,value)
			{
				if(index==0)
				{			
					document.getElementById('mate').value+=this.value;
				}
				else
				{
					document.getElementById('mate').value+=","+this.value;
				}	
				
			});
			document.getElementById('mate').value+="|";
			$.each($('#op_st').find('.btno'),function(index,value)
			{
				if(index==0)
				{			
					document.getElementById('mate').value+=this.value;
				}
				else
				{
					document.getElementById('mate').value+=","+this.value;
				}
			});
			document.getElementById('mate').value+="|";
			$.each($('#op_st').find('.mfd'),function(index,value)
			{
				if(index==0)
				{			
					document.getElementById('mate').value+=this.value;
				}
				else
				{
					document.getElementById('mate').value+=","+this.value;
				}
			});
			document.getElementById('mate').value+="|";
			$.each($('#op_st').find('.exd'),function(index,value)
			{
				if(index==0)
				{			
					document.getElementById('mate').value+=this.value;
				}
				else
				{
					document.getElementById('mate').value+=","+this.value;
				}
					
			});
			return true;
		}
		else{
			alert("Enter Valid Data !!!!!!!!")
			return false;
		}
	});
//----------------------------------validation each row--------------------------
	function validationEachRow(){
		 if(document.getElementById('op_dt').value.length==0)
		{
			document.getElementById('op_id').value=0;
			alert("Please Enter Opening Date");
			document.getElementById('op_dt').focus();
			return false;
		
		}
		$.each($('#op_st').find('.rowcl1'),function(index,value){
			if($(this).find(".pro").val().length==0)
			{
				document.getElementById('op_id').value=0;
				alert ("Please Enter The Currect Product"); 
				$(this).find(".pro").focus();
				return false;
			}
			if($(this).find(".puqty").val().length==0)
			{
				document.getElementById('op_id').value=0;
				alert ("Please Enter The Stock Quentity"); 
				$(this).find(".puqty").focus();
				return false;
			}
			if($(this).find(".val").val().length==0)
			{
				document.getElementById('op_id').value=0;
				alert ("Please Enter The Present Value"); 
				$(this).find(".val").focus();
				return false;
			}
			if($(this).find(".grpid").val()==1)
			{
				if($(this).find(".btno").val().length==0)
				{
					document.getElementById('op_id').value=0;
					$(this).find(".btno").focus();
					return false;
				}
				if($(this).find(".mfd").val().length==0)
				{	
					document.getElementById('op_id').value=0;
					$(this).find(".mfd").focus();
					return false;
				}
				if($(this).find(".exd").val().length==0)
				{
					document.getElementById('op_id').value=0;
					$(this).find(".exd").focus();
					return false;
				}
			}
		});
	}
});
/*------------------------------------DEL ROW FUNCTION------------------------------------------------------*/
function delRow1(r){
	//var rowCount = $('#op_st tr').length;
	alert("row:"+r);
	/*if(rowCount!=2){
		$(function() 
		{
			$(r).remove();
			/*$.each($("#id1").find(".slNo"),function(index,value){
				$(this).val(index+1);
			});
			$.each($("#op_st").find(".cr"),function(index,value){
				$(this).val(index+1);
			});
		});
	}*/
}
function numbersonly(e){
	var unicode=e.charCode? e.charCode : e.keyCode;
	if (unicode!=8){ 
		if (unicode<46||unicode>57||unicode==47) {
			return false;		
		}
	}
}
function check_date(x,e){
	var unicode=e.charCode? e.charCode : e.keyCode;
	alert(unicode)
	if (unicode!=8){
		if (unicode<45||unicode>57) {
			return false;		
		}
		else{
			alert(x)
		}
	}
	else{
		 alert(x)
	}
}
