
<script type="text/javascript" >

$(document).ready(
		function()
		{
			$("#test").click(function()
			{
				var username, tmp, response,userExist;
				username=document.getElementById('username').value;
			
				$.ajax(
				{
					url:"http://localhost/zf-tutorial/public/index.php/Usersmanagement/add",
					type:"POST",
					data:"format=json"+"&username="+username,
					async:false,
					success:function(response)
					{
	
						if (response.userExist==='true')
						{
							responseStr='User name:+username+' already exists';
						}
						else
						{
							responseStr='User name:+username+' does not exists';
						}
														
						alert(response.userExist);
					}// end of success function
			
				}// end of .ajax jquery parameters
			  )// end of .ajax
		     }// end of click function
			 )// end of click
	}//end of function 
)//end of redy parameters

</script>
		
<div id="test"> testing</div>

