$(function()
{
	//---------------------init-------------------------------//

	$( "#tabs1" ).tabs();
	$( "#in_dt" ).datepicker({dateFormat :'dd/mm/yy'});//chalan date
	$("#popup").button().hover(function(event){
		$( "#dialog" ).slideDown("slow");	
	});
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
			$(".auto").autocomplete({
				source: product
			});
			$(".serc").autocomplete({
				source: vendor
			});
		}
	}
	xmlhttp.open("POST",url1,true);
	xmlhttp.send();
//--------------------------------------vendor search complete---------------------
	$("#search").change(function(){
		var url3="./product_search.php?op=b";
		var v_id=$("#search").val();
		url3=url3+'&v_id='+v_id;
		if (window.XMLHttpRequest) 
		{xmlhttp=new XMLHttpRequest();
		}
		else		
		{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function() {
	  		if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    		{
				$("#dialog").slideUp("slow");
				var a=xmlhttp.responseText.split('^');
				$("#ven_info").html(a[1]);
				$("#v_d").val(a[0]);
			}
		}
		xmlhttp.open("POST",url3,true);
		xmlhttp.send();
	});
//--------------------------------------add row---------------------
	$("#id1").delegate(".addrow","click",function()
	{
		document.getElementById('p_id').value=1;
		validationEachRow();
		if(document.getElementById('p_id').value==1){
			r=this.parentNode.parentNode;
			var root = r.parentNode;//the root
			var allRows = root.getElementsByTagName('tr');//the rows' collection 
			var cRow = r.cloneNode(true);//the clone of the 1st row 
			var cInp = cRow.getElementsByTagName('input');//the inputs' collection of the 1st row 
			for(var i=0;i<cInp.length;i++)
			{//changes the inputs' names (indexes the names) 
				cInp[i].setAttribute('name',cInp[i].getAttribute('name')+'_'+(allRows.length+1)); 
				cInp[i].setAttribute('id',cInp[i].getAttribute('id')+'_'+(allRows.length+1));// (indexes the id)
			} 
			$(cRow).find(".mfdt").removeClass("hasDatepicker");
			$(cRow).find(".exdt").removeClass("hasDatepicker");
			$(cRow).find(".batno").attr('readonly',true);
			$(cRow).find(".mfdt").attr('readonly',true);
			$(cRow).find(".purqty").attr('readonly',true);
			$(cRow).find(".exdt").attr('readonly',true);
			$(cRow).find(".auto").autocomplete({
				source: product
			});
			root.appendChild(cRow);//appends the cloned row as a new row
			var id=document.getElementById(cInp[0].getAttribute('id')).value=allRows.length-1;
			document.getElementById(cInp[1].getAttribute('id')).value='';
			document.getElementById(cInp[2].getAttribute('id')).value='';
			document.getElementById(cInp[3].getAttribute('id')).value='';
			document.getElementById(cInp[4].getAttribute('id')).value='';
			document.getElementById(cInp[5].getAttribute('id')).value='';
			document.getElementById(cInp[6].getAttribute('id')).value='';
			document.getElementById(cInp[7].getAttribute('id')).value='';
			document.getElementById(cInp[8].getAttribute('id')).value='';
			$.each($("#id1").find(".slNo"),function(index,value){
				$(this).val(index+1);
			});
		}
		else{
			return false;
		}
	});
//-----------------------------after select product----------------------------
	$("#id1").delegate(".auto","change",function()
	{
		var url2="./product_search.php?op=v";
		var p_id=$(this.parentNode.parentNode).find(".auto").val();
		var date=$( "#in_dt" ).val();
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
 			if(x[1]=='G-3')
			{
				node.find(".grp").val('1');
				node.find(".batno").attr('readonly',false);
				node.find(".mfdt").attr('readonly',false);
				node.find(".exdt").attr('readonly',false);
			node.find(".mfdt").removeClass("hasDatepicker");
			node.find(".exdt").removeClass("hasDatepicker");
			node.find( ".mfdt" ).datepicker({dateFormat :'dd/mm/yy'});
			node.find( ".exdt" ).datepicker({dateFormat :'dd/mm/yy'});
			}
			else
			{
				node.find(".grp").val('0');
				node.find(".batno").attr('readonly',true);
				node.find(".mfdt").attr('readonly',true);
				node.find(".exdt").attr('readonly',true);
			}
			node.find(".curstock").val(x[0]);
			node.find(".gr_id").val(x[1]);
			node.find(".purqty").attr('readonly',false);
			return true;
		}
	}
	xmlhttp.open("POST",url2,true);
	xmlhttp.send();
	});

//--------------------------submit---------------------------------
	$("body").delegate("#form1","submit",function()
	{
		document.getElementById('p_id').value=1;
		validationEachRow();
		if(document.getElementById('p_id').value==1){
			$.each($('#id1').find('.auto'),function(index,value)
			{
				if(index==0)
				{			
					document.getElementById('material').value+=this.value;
				}
				else
				{
					document.getElementById('material').value+=","+this.value;
				}
			});
			document.getElementById('material').value+="|";
			$.each($('#id1').find('.grp'),function(index,value)
			{
				if(index==0)
				{			
					document.getElementById('material').value+=this.value;
				}
				else
				{
					document.getElementById('material').value+=","+this.value;
				}	
			});
			document.getElementById('material').value+="|";
			$.each($('#id1').find('.purqty'),function(index,value)
			{
				if(index==0)
				{		
					document.getElementById('material').value+=this.value;
				}
				else
				{
					document.getElementById('material').value+=","+this.value;
				}
			});
			document.getElementById('material').value+="|";
			$.each($('#id1').find('.batno'),function(index,value)
			{
				if(index==0)
				{			
					document.getElementById('material').value+=this.value;
				}
				else
				{
					document.getElementById('material').value+=","+this.value;
				}
			});
			document.getElementById('material').value+="|";
			$.each($('#id1').find('.mfdt'),function(index,value)
			{
				if(index==0)
				{			
					document.getElementById('material').value+=this.value;
				}
				else
				{
					document.getElementById('material').value+=","+this.value;
				}
			});
			document.getElementById('material').value+="|";
			$.each($('#id1').find('.exdt'),function(index,value)
			{
				if(index==0)
				{			
					document.getElementById('material').value+=this.value;
				}
				else
				{
					document.getElementById('material').value+=","+this.value;
				}
					
			});
			return true;
		}
		else{
			alert("Enter Valid Data !!!!!!!!")
			return false;
		}
	});
//--------------------------------------validation each row---------------------
function validationEachRow(){
		if(document.getElementById('v_d').value.length==0)
		{
			document.getElementById('p_id').value=0;
			alert("Please Select Vendor First");
			document.getElementById('ven_info').focus();
			return false;
		
		}
		 if(document.getElementById('in_dt').value.length==0)
		{
			document.getElementById('p_id').value=0;
			alert("Please Enter Stock In Date");
			document.getElementById('in_dt').focus();
			return false;
		
		}
		 if(document.getElementById('chl_no').value.length==0)
		{
			document.getElementById('p_id').value=0;
			alert("Please Enter Chalan Number");
			document.getElementById('chl_no').focus();
			return false;
		
		}
		$.each($('#id1').find('.rowcl'),function(index,value){			
			if($(this).find(".auto").val().length==0)
			{
				document.getElementById('p_id').value=0;
				alert ("Please Enter The Currect Product"); 
				$(this).find(".auto").focus();
				return false;
			}
			if($(this).find(".curstock").val().length==0)
			{
				document.getElementById('p_id').value=0;
				$(this).find(".curstock").focus();
				return false;
			}
			if($(this).find(".purqty").val().length==0)
			{
				document.getElementById('p_id').value=0;
				$(this).find(".purqty").focus();
		
				return false;
			}
			if($(this).find(".grp").val()==1)
			{
				if($(this).find(".batno").val().length==0)

				{
					document.getElementById('p_id').value=0;
					$(this).find(".batno").focus();
					return false;
				}
				if($(this).find(".mfdt").val().length==0)
				{	
					document.getElementById('p_id').value=0;	
					$(this).find(".mfdt").focus();
					return false;
				}
				if($(this).find(".exdt").val().length==0)
				{
					document.getElementById('p_id').value=0;
					$(this).find(".exdt").focus();
					return false;
				}
			}		
		});
	}
//--------------------------------------vv---------------------  
	$("#id2").delegate("#search","change",function()
	{
		var url3="./product_search.php?op=s";
		var v_id=$("#search").val();
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
			if(xmlhttp.responseText==1){
				document.getElementById("search").value='CAN NOT FIND DATABASE';}
			else
			{
				document.getElementById("search").value='SORRY';
			}
		}
  		}	
	xmlhttp.open("POST",url3,true);
	xmlhttp.send();
	});
});
/*------------------------------------DEL ROW FUNCTION------------------------------------------------------*/
function delRow(r)
{
	var rowCount = $('#id1 tr').length;
	if(rowCount!=2){
		$(function() {
			$(r).remove();
			$.each($("#id1").find(".slNo"),function(index,value){
				$(this).val(index+1);
			});
		});
	}
}/*-------------------------END OF DEL ROW FUNCTION----------------------------------------------------*/
function numbersonly(e){
	var unicode=e.charCode? e.charCode : e.keyCode;
	if (unicode!=8){ 
		if (unicode<46||unicode>57||unicode==47) {
			return false;		
		}
	}
}/*-----------------------------END OF ONLY NUMBER INPUT FUNCTION---------------------------------*/
function checkDate(x,e){
	var unicode=e.charCode? e.charCode : e.keyCode;
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
