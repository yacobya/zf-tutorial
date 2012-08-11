/**
 * 
 */
function checkPassConfirm()
{
	var password, passwordValid;
	alert ('JS is here'); 

	password = document.getElementById('password').value;
	passwordValid = document.getElementById('passwordValid').value;
	confirm = (password===passwordValid)?true : false;// check password confirmation
	if (!confirm)
	{
//		document.write("<p>error confirmation</p>");
		document.getElementById("errMsg").innerHTML="Password confirmation error";
		alert ('confirmation error'); 
	}
		
	return confirm;
}


