<<<<<<< HEAD
<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
function handleUsers() {

		if(!(isset($_POST["username"]) && isset($_POST["password"]))) {
		return;
	}

	require('config.php');
	$conn_string = "mysql:host=$host;dbname=$database;charset=utf8mb4";
	try {
		$db = new PDO($conn_string, $username, $password);
		$select_query = "select * from `TestUsers` where username = :username";
		$stmt = $db ->prepare($select_query);
		$r = $stmt-> execute(array(":username"=> $_POST["username"]));
		$response = $stmt ->fetch(PDO::FETCH_ASSOC);
		print_r($stmt->errorInfo());
	}
	 catch(Exception $e){
		$response = "DB error: $e";
		return "Invalid User";
	}
	if(!(isset($_POST["username"]) && isset($_POST["password"]))) {
		return "We breaking";
	}

	if($_POST["username"] == $response["username"] && $_POST["password"] == $response["pin"]) {
		session_start();
		return "Welcome " . $response["username"];
	}
	if($_POST["username"] == $response["username"]) {
		 return "Invalid User";
	 if($_POST["password"] == $response["pin"]) {
	 	return "Invalid User";
	}
} 
?>


<html>
<head>
	<script >
		function validate() {
			let rtn = true;
			let form = document.forms[0];
			console.log(form.username);			
			if(form.username.value == "") 
				rtn = false;
			if(form.password.value != form.passwordconfirm.value) 
				rtn = false;
			if(rtn)
				console.log("Succsess");
			return rtn;

		}
	</script>
	<style>
		input { border: 1px solid black; border-radius: 2px; margin-left: auto; margin-right:auto; padding:0.1%;}
		H1 {font-family:Arial; font-size: 20px; margin-left: auto; margin-right:auto;}
	</style>
</head>
<body>
	<H1>Login</H1>
	<HR>
	<form method = 'post' action = '#' onsubmit= "return validate();">
		<input name="username"  placeholder = "username" style width = "300px"/>
		<br>
		<input name="password" type="password"  placeholder = "password"/>
		<input name="passwordconfirm" type="password"  placeholder = "confirm password"/>
		<br>
		<input type="submit" value="Login"/>
	</form>
</body>
</html>
<?php echo "<br><pre>" . "response: ". handleUsers() . "</pre><br>"?>

=======
<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
function handleUsers() {

		if(!(isset($_POST["username"]) && isset($_POST["password"]))) {
		return;
	}

	require('config.php');
	$conn_string = "mysql:host=$host;dbname=$database;charset=utf8mb4";
	try {
		$db = new PDO($conn_string, $username, $password);
		$select_query = "select * from `TestUsers` where username = :username";
		$stmt = $db ->prepare($select_query);
		$r = $stmt-> execute(array(":username"=> $_POST["username"]));
		$response = $stmt ->fetch(PDO::FETCH_ASSOC);
		print_r($stmt->errorInfo());
	}
	 catch(Exception $e){
		$response = "DB error: $e";
		return "Invalid User";
	}
	if(!(isset($_POST["username"]) && isset($_POST["password"]))) {
		return "We breaking";
	}

	if($_POST["username"] == $response["username"] && $_POST["password"] == $response["pin"]) {
		session_start();
		return "Welcome " . $response["username"];
	}
	if($_POST["username"] == $response["username"]) {
		 return "Invalid User";
	 if($_POST["password"] == $response["pin"]) {
	 	return "Invalid Password"
	}
} 
?>


<html>
<head>
	<script >
		function validate() {
			let rtn = true;
			let form = document.forms[0];
			console.log(form.username);			
			if(form.username.value == "") 
				rtn = false;
			if(form.password.value != form.passwordconfirm.value) 
				rtn = false;
			if(rtn)
				console.log("Succsess");
			return rtn;

		}
	</script>
	<style>
		input { border: 1px solid black; border-radius: 2px; margin-left: auto; margin-right:auto; padding:0.1%;}
		H1 {font-family:Arial; font-size: 20px; margin-left: auto; margin-right:auto;}
	</style>
</head>
<body>
	<H1>Login</H1>
	<HR>
	<form method = 'post' action = '#' onsubmit= "return validate();">
		<input name="username"  placeholder = "username" style width = "300px"/>
		<br>
		<input name="password" type="password"  placeholder = "password"/>
		<input name="passwordconfirm" type="password"  placeholder = "confirm password"/>
		<br>
		<input type="submit" value="Login"/>
	</form>
</body>
</html>
<?php echo "<br><pre>" . "response: ". handleUsers() . "</pre><br>"?>

>>>>>>> origin/master
