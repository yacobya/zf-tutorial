/**
 * 
 */

function validateForm()
{
	//check if user name valid and exists
	var username, role, password, 	passwordValid, confirm, checkNameRequest,userExist;
//	alert ('I am here');
	password = document.getElementById('password').value;
	passwordValid = document.getElementById('passwordValid').value;
	role = document.getElementById('userRole').value;
	username=document.getElementById('username').value;
	//check fields by script
   	errStr=validateFields(password,passwordValid,role,username);
	
	if (errStr!=null)
		if (errStr.length>0)
		{
			alert (errStr);
			return false;
	    }
	   			
			
    return true;
    	
}
  	

	
//validate fields

function validateFields(password,passwordValid,role,username)
{
	var password, passwordValid,username,role,lenght,userExist;
		/* validate  password , user name and role legality - no blanks , alphanumeric, size? */ 
	
	//check that only alphanumeric characters  
	// check that pasword was confirmed
	//check name length
	errMsg=null;
	confirm= true;

	alphaNumRegex = /^[a-zA-Z0-9]+$/;
    aa=alphaNumRegex.test(password);
	if (username.length<3 || username.length>16 || password.length<8 || password.length>12)
		return 'user name or password length is illegal. name: 3-16 password 8-12';
		
	// check that names and password are only alpha numeric
	if 	(!(alphaNumRegex.test(password)&& alphaNumRegex.test(passwordValid)&& alphaNumRegex.test(username)))
		return 'username and passsword must contain Alphanumerc characters only';
		
	// check password confirmation
	if (!(confirm = (password===passwordValid)?true : false))
		return 'password confirmation error';
	
	// check role
	if (!(confirm = (role==='user') || (role==='admin')||(role==='fieldEngineer')||(role==='superUser')) )
		errMsg='Illegal role';
				
	return null;
}


// popup error message from server
$(document).ready(
function(){
	
    errMsg = document.getElementById('errorPopup').value;
    if ((errMsg.length)>0)
    {
		alert(errMsg);
	}	
});


		//check user already exist - AJAx
		/*
    checkNameRequest=new XMLHttpRequest();
    checkNameRequest.open("POST","/zf-tutorial/public/index.php/Usersmanagement/checkUserName/?username="+username,false);
    checkNameRequest.send();
    userExist=checkNameRequest.responseText;

	
	//wait for response from server
	checkNameRequest.onreadystatechange=function()
	{
		if (checkNameRequest.readyState==4 && checkNameRequest.status==200)
   		{
    		userExist=xmlhttp.responseText;
    		if (userExist)
    		{
    			errMsg='Ajax User already exists';
    			alert (errMsg); 
    			return false;
    		}
    			
    	}
    }
*/