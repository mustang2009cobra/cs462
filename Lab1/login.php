<script type="text/javascript">
	$(document).ready(function(){
		$("#login").live('click', function(){
			$.ajax({
				type: "POST",
				url: "api/index.php",
				data: {
					cmd : "login",
					userEmail : $("#loginUserEmail").html(),
					userPassword : $("#loginUserPassword").html()
				}
			}).done(function(data){
				console.log(data);
			});
		});
		
		$("#createAccount").live('click', function(){
			$.ajax({
				type: "POST",
				url : "api/index.php",
				data : {
					cmd : "createAccount",
					userFirstName : $("#createUserFirstName").html(),
					userLastName : $("#createUserLastName").html(),
					userEmail : $("#createUserEmail").html(),
					userEmail
				}
			}).done(function(data){
				console.log(data);
			});
		});
	});

</script>