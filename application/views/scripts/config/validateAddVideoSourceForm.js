

/**
 * JS to display popup error message from server
 */ 
$(document).ready(
function(){
	
    errMsg = document.getElementById('errorPopup').value;
    if ((errMsg.length)>0)
    {
		alert(errMsg);
	}	
});

