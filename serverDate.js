var xmlHttp;
function srvTime(){
	try {
		//FF, Opera, Safari, Chrome
		xmlHttp = new XMLHttpRequest();
	}
	catch (err1) {
		//IE
		try {
			xmlHttp = new ActiveXObject('Msxml2.XMLHTTP');
		}
		catch (err2) {
			try {
				xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
			}
			catch (eerr3) {
				//AJAX not supported, use CPU time.
				alert("AJAX not supported");
			}
		}
	}
	xmlHttp.open('HEAD',window.location.href.toString(),false);
	xmlHttp.setRequestHeader("Content-Type", "text/html");
	xmlHttp.send('');
	
	//var dateStr = xmlhttp.getResponseHeader('Date');
    //var serverTimeMillisGMT = Date.parse(new Date(Date.parse(dateStr)).toUTCString());
	
    //return serverTimeMillisGMT;
    
	return xmlHttp.getResponseHeader("Date");
	
	
}

var st = srvTime();
var serverTimeMillisGMT = Date.parse(new Date(Date.parse(st)).toUTCString());
var date = new Date(st);