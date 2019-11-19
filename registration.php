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
			$('#register').submit(function(event){
				let rtn = true;
				let alertvalue = "";
				if(this.username.value.length == 0) {
					rtn = false;
					alertvalue += "Enter a username\n";
				}

				if(this.email.value.length == 0){
					rtn = false;
					alertvalue += "Email is invalid\n";					
				}
				if(this.password.value != this.confirm.value || this.password.value.length == 0 || this.confirm.value.length == 0){
					rtn = false;
					alertvalue += "passwords don't match";
					}
				if(alertvalue.length > 0)
					alert(alertvalue);
				console.log(rtn);
				return rtn;
			});
		});
	</script>
		<style>
		input { border: 1px solid black; border-radius: 2px; margin-left: auto; margin-right:auto; padding:0.1%;}
		H1 {font-family:Arial; font-size: 20px; margin-left: auto; margin-right:auto;}
		.error {border: 1px solid red; border-radius: 2px; margin-left: auto; margin-right:auto; padding:0.1%;}
		.noerror {border: 1px solid black; border-radius: 2px; margin-left: auto; margin-right:auto; padding:0.1%;}
	</style>
	<body>
		<H1>Registration</H1>
		<HR>
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

<?php
	if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['confirm']) && isset($_POST['email'])) {
		if(empty($_POST['username']) || empty($_POST['password']) || empty($_POST['confirm']) || empty($_POST['email'])) {
			exit();
		}
		$user =  $_POST['username'];
		$pass = $_POST['password'];
		$conf = $_POST['confirm'];
		$email = $_POST['email'];
		echo "<br><pre>" . $user . "<pre><br>";
		echo "<br><pre>" . $email . "<pre><br>";
		echo "<br><pre>" . $pass . "<pre><br>";
		echo "<br><pre>" . $conf . "<pre><br>";

	}
?>