var xmlHttp = createXmlHttpRequestObject();

function createXmlHttpRequestObject (){

	var xmlHttp;

	if (window.XMLHttpRequest){
		try{
			xmlHttp = new XMLHttpRequest();
		} catch (e) {
			xmlHttp = false;
		}
	}else{
		try{
			xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (e) {
			xmlHttp = false;
		}
	}

	if (!xmlHttp) {
		alert("Could not create XML Object");
	} else {
		return xmlHttp;
	}
}

function process (pid, uid){
	description = encodeURIComponent(document.getElementById("errorDescription").value);
	if (description === ""){
		alert("Please enter an error description");
	}
	else{
		xmlHttp.open("GET", "process_error.php?pid="+pid+"&uid="+uid+"&description="+description, true);
		xmlHttp.onreadystatechange = handleServerResponse;
		xmlHttp.send();
	}
}

function handleServerResponse () {
	if (xmlHttp.readyState==4)
		if (xmlHttp.status==200) {
			xmlResponse = xmlHttp.responseXML;
			xmlDocumentElement = xmlResponse.documentElement;
			message = xmlDocumentElement.firstChild.textContent;
			/*var parentDiv = document.getElementById("errorDiv");
			var textarea = document.getElementById("errorDescription");
			var btn = document.getElementById("reportError");
			parentDiv.removeChild(textarea);
			parentDiv.removeChild(btn);
			var node = document.createTextNode(message);
			parentDiv.appendChild(node);*/
			alert(message);
			self.close();
	}
}