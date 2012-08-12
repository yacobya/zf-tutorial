/**
 * 
 */
function validateForm()
{
	var password, passwordValid,username,role,lenght, errStr,aa,bb,cc;
		/* validate  password , user name and role legality - no blanks , alphanumeric, size? */ 
	
	//check that only alphanumeric characters  
	// check that pasword was confirmed
	password = document.getElementById('password').value;
	passwordValid = document.getElementById('passwordValid').value;
	role = document.getElementById('userRole').value;
	username=document.getElementById('username').value;
	//check name length
	errMsg=null;
	confirm= true;
	alphaNumRegex = /^[a-zA-Z0-9]+$/;
    aa=alphaNumRegex.test(password);
	if (username.length<3 || username.length>16 || password.length<8 || username.length>12)
	{
	     
		errMsg='user name or password length is illegal. name: 3-16 password 8-12';
		confirm=false;
	}else
		// check that names and password are only alpha numeric
		if 	(!(alphaNumRegex.test(password)&& alphaNumRegex.test(passwordValid)&& alphaNumRegex.test(username)))
		{
				aa=alphaNumRegex.test(password);
				bb= alphaNumRegex.test(passwordValid);
				cc= alphaNumRegex.test(username);
				errMsg='username and passsword must contain Alphanumerc characters only';
				confirm=false;   	
		}else
				// check password confirmation
				if (!(confirm = (password===passwordValid)?true : false))
					errMsg='password confirmation error';
				else
				{// check role
					if (!(confirm = (role==='user') || (role==='admin')||(role==='fieldEngineer')||(role==='superUser')) )
						confirm=false;
				}
			

			

	if (!confirm)
	{
		document.getElementById("errMsg").innerHTML=errMsg;
		alert (errMsg); 
	}
		
	return confirm;
}
