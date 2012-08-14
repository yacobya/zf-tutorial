/**
 * 
 */
function validateForm()
{
	//check if user name valid and exists
	var username, role, password, 	passwordValid, confirm, errStr,checkNameRequest,userExist;
//	alert ('I am here');
	password = document.getElementById('password').value;
	passwordValid = document.getElementById('passwordValid').value;
	role = document.getElementById('userRole').value;
	username=document.getElementById('username').value;
	
	//check user already exist - AJAX

    checkNameRequest=new XMLHttpRequest();
    checkNameRequest.open("POST","/zf-tutorial/public/index.php/Usersmanagement/checkUserName/?username="+username,false);
    checkNameRequest.send();
    userExist=checkNameRequest.responseText;
/*
	
	//wait for response
	checkNameRequest.onreadystatechange=function()
	{
		if (checkNameRequest.readyState==4 && checkNameRequest.status==200)
   		{
    		userExist=xmlhttp.responseText;
    		if (userExist)
    		{
    			confirm=false;
    			errMsg='User already exists';
    		}
    		else
    		{
    			confirm=validateFields(password,passwordValid,role,username);
    			if (!confirm) 
    			{
    				errMsg = document.getElementById("errMsg").innerHTML=errMsg;
    			}
    						
    		}
    			
    	}
 */
    	confirm=validateFields(password,passwordValid,role,username);
    	if (!confirm)
    	{
    		alert (errMsg);
    	}
    			
		return confirm;
    	
 // 	}
  	
	
	//validate fields
	confirm=validateFields();
}
function validateFields(password,passwordValid,role,username)
{
	var password, passwordValid,username,role,lenght, errStr;
		/* validate  password , user name and role legality - no blanks , alphanumeric, size? */ 
	
	//check that only alphanumeric characters  
	// check that pasword was confirmed
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
				errMsg='username and passsword must contain Alphanumerc characters only';
				confirm=false;   	
		}else
				// check password confirmation
				if (!(confirm = (password===passwordValid)?true : false))
					errMsg='password confirmation error';
				else
				{// check role
					if (!(confirm = (role==='user') || (role==='admin')||(role==='fieldEngineer')||(role==='superUser')) )
					{
						confirm=false;
						errMsg='Illegal role';
					}
				}
			

			

	if (!confirm)
	{
		document.getElementById("errMsg").innerHTML=errMsg;
//		alert (errMsg);
		return confirm;
	}
	
	// check if user exists in DB
	
		
	return confirm;
}
