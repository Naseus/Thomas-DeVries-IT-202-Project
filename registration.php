<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
?>

<html>
	<script
	src="https://code.jquery.com/jquery-3.4.1.js"
  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  crossorigin="anonymous">
	</script>
	<script>
		$(document).ready(function(){
			$('#register').ready(function(event){
				let rtn = true;
				let alertvalue = "";
				console.log($(this));
				if(this.username.value.length == 0) {
					rtn = false;
				}
					alertvalue += "Enter a username\n";
				if(this.password.value == this.confirm.value || this.password.value.length == 0 || this.confirm.value.length == 0){
					rtn = false;
					alertvalue += "passwords don't match";
					}
				if(alertvalue > 0)
					alert(alertvalue);
				return rtn;
			});
		});
	</script>
	<body>
		<form id = "register" method = "POST"/>
			<input name = "username" type = "text" placeholder="Username"/>
			<input name = "email" type = "email" placeholder="name@domain.com" />
			<br>
			<input name = "password" type = "password" placeholder = "password" />
			<input name = "confirm" type = "password" placeholder = "password" />	
			<br>
			<input name = "submit" type = "submit" value="Enter" />		
		</form>
	</body>
</html>
