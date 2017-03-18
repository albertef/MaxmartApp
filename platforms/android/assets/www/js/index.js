window.onload = function() {
    document.addEventListener('deviceready', onDeviceReady, false);
}

function onDeviceReady() {
    this.receivedEvent('deviceready');
}

function receivedEvent(id) {
    var parentElement = document.getElementById(id);
    var listeningElement = parentElement.querySelector('.listening');
    var receivedElement = parentElement.querySelector('.received');

    listeningElement.setAttribute('style', 'display:none;');
    receivedElement.setAttribute('style', 'display:block;');
}

function copyTxt(event) {

	var copyTextareaBtn = document.querySelector('.js-textareacopybtn');
	
	var copytxt = document.getElementById('refnoid').innerHTML; 
	copytxt = copytxt.trim();
	var successcopy = copytxt.substring(copytxt.length - 8,copytxt.length);
	
	document.getElementById('copyhidden').innerHTML = successcopy;
	var copyTextarea = document.querySelector('.js-copytextarea');
	copyTextarea.select();
	
	try {
		var successful = document.execCommand('copy');
		document.getElementById('copyhidden').blur();
		var msg = successful ? 'successful' : 'unsuccessful';
		window.plugins.toast.showLongBottom('Ref.No copied ' + msg + 'ly', function(a){console.log('toast success: ' + a)}, function(b){alert('toast error: ' + b)})
		console.log('Copying text command was ' + msg);
	} 
	catch (err) {
		window.plugins.toast.showLongBottom('Oops, unable to copy', function(a){console.log('toast success: ' + a)}, function(b){alert('toast error: ' + b)})
		console.log('Oops, unable to copy');
	}
}

function trackEnquiry() {
	var trackref = document.getElementById('trackRef').value;
	
	//alert(trackref);
	//alert("http://www.maxmarttrading.com/mobile_app/form-api.php?track=" + trackref);
	
	var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == XMLHttpRequest.DONE ) {
           if (xmlhttp.status == 200) {
			   document.getElementById('trackResult').style.opacity = 1;
               document.getElementById('trackResult').innerHTML = xmlhttp.responseText;
           }
           else if (xmlhttp.status == 400) {
              alert('There was an error 400');
           }
           else {
               alert('Please check your internet connectivity');
           }
        }
    };

    xmlhttp.open("GET", "http://www.maxmarttrading.com/mobile_app/form-api.php?track=" + trackref, true);
    xmlhttp.send();
}

function mainForm(category){
    var name = document.getElementById('name').value;
    var email = document.getElementById('email').value;
    var phone = document.getElementById('phone').value;
    var company = document.getElementById('company').value;
	var category = category;
	var refno = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for( var i=0; i < 8; i++ ) {
        refno += possible.charAt(Math.floor(Math.random() * possible.length));
	}
    console.log(refno);
	localStorage.setItem('refno', refno);
	
	//alert("http://www.maxmarttrading.com/mobile_app/form-api.php?name=" + name + "&email=" + email + "&phone=" + phone + "&company=" + company + "&category=" + category + "&refno=" + refno);
	
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == XMLHttpRequest.DONE ) {
			if (xmlhttp.status == 200) {
               //alert(xmlhttp.responseText);
			   if(xmlhttp.responseText == "success"){
				   window.location = 'success.html';
			   }
			   else if(xmlhttp.responseText == "fail") {
				   window.location = 'fail.html';
			   }
			   else {
				   window.location = 'complete.html';
			   }
			}
			else if (xmlhttp.status == 400) {
				alert('There was an error 400');
			}
			else {
				alert('Please check your internet connectivity');
			}
        }
    };

    xmlhttp.open("GET", "http://www.maxmarttrading.com/mobile_app/form-api.php?name=" + name + "&email=" + email + "&phone=" + phone + "&company=" + company + "&category=" + category + "&refno=" + refno, true);
    xmlhttp.send();
}