	//var xmlHttp
	alert('hi')
	/*function ShowInfo(){ 
		xmlHttp=GetXmlHttpObject()
		if (xmlHttp==null){
			alert ("Browser does not support HTTP Request")
			return
		} 
		var crop_id=document.getElementById("crop_id").value;
		//ShowPendingImage();
		var url="getinfo.php";
		url=url+"?crop_id="+crop_id+get_check_value();
		//alert(url)
		xmlHttp.onreadystatechange=stateChanged
		xmlHttp.open("GET",url,true)
		xmlHttp.send(null)
	
	}

	function get_check_value(){
	var c_value = "";
	//alert(document.orderform.music.length)
	for (var i=0; i < document.orderform.music.length; i++){
	   if (document.orderform.music[i].checked){
		      c_value = c_value +"&chkinfo[]="+ document.orderform.music[i].value;
      		}
   	}
  	return c_value;
	}
	function stateChanged(){ 
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){ 
			document.getElementById("show_info").innerHTML=xmlHttp.responseText
			} 
	}
	function GetXmlHttpObject(){
		var xmlHttp=null;
		try{
		 	// Firefox, Opera 8.0+, Safari
			xmlHttp=new XMLHttpRequest();
			}
		catch (e){
				// Internet Explorer
			try{
				xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
				}
			catch (e){
				xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
			}
		return xmlHttp;
		}

	function ShowPendingImage(){
		document.getElementById("show_info").innerHTML= "<image src=bigrotation2.gif> Please Wait!</image>";
 	
		
	}

	function HidePendingImage(){
		document.getElementById("show_info").innerHTML="";
	}
	*/
	/*function varify(){
		var flag;
		for (var i=0; i < document.orderform.music.length; i++){
	   		if (document.orderform.music[i].checked){
		     		flag=1;
      			}
   		}
		if(flag!=1){
		alert("You must Select atleast one Land information!!!!!!!! ");
		//document.orderform.music.focus();
  		return false;
	 	}
	}*/
