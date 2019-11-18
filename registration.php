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
		$(document).ready(function(event){
			$("#register").ready(function(event){
				rtn = true;
				alertvalue = "";
				if(this.username.length == 0) {
					rtn = false;
				}
					alertvalue += "Enter a username\n";
				if(this.password.value == this.confirm.value || this.password.length == 0 ||this.confirm.length == 0){
					rtn = false;
					alertvalue += "passwords don't match"
					}
				if(alertvalue > 0)
					alert("alertvalue")
				return rtn;
			});
		});
	</script>
	<body>
		<form id = "register" method = "POST">
			<input id = "username" type = "text" placeholder="Username"/>
			<input id = "email" type = "email" placeholder="name@domain.com" />
			<br>
			<input id = "password" type = "password" placeholder = "password" />
			<input id = "confirm" type = "password" placeholder = "password" />	
			<br>
			<input id = "submit" type = "submit" placeholder="Enter" />		
		</form>
	</body>
</html>