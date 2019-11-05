<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
function handleUsers() {
	if(isset($_POST["username"]) && isset($_POST["password"])) {
		require('config.php');
		$conn_string = "mysql:host=$host;dbname=$database;charset=utf8mb4";
		try {
			$db = new PDO($conn_string, $username, $password);
			$select_query = "select * from `TestUsers` where username = :username";
			$stmt = $db ->prepare($select_query);
			$r = $stmt-> execute(array(":username"=> $_POST["username"]));
			$response = $stmt ->fetch(PDO::FETCH_ASSOC);
		}
		 catch(Exception $e){
			$response = "DB error: $e";
			return "Invalid User";
		}
		if($_POST["username"] != $response["username"]) {
			 return "Invalid User";
		}
		 if($_POST["password"] != $response["pin"]) {
		 	return "Invalid password";
		}
		if($_POST["username"] == $response["username"] && $_POST["password"] == $response["pin"]) {
			echo "<br><pre>" . var_export($response) . "</pre><br>";
			return "Welcome " . $response["username"];
		}
	}
} 
?>


<html>
<head>
	<script>
		function validate() {
			let rtn = true;
			let form = document.forms[0];
    		let vele = document.getElementById("validation");
    		vele.innerText = "";
			vele.style.display = "none";
			if(form.username.value.length <= 0) { 
				vele.style.display = "block";	
				vele.innerText = "username is empty \n";
				form.username.className = "error";
				rtn = false;
			}else {
				form.username.className = "noerror";				
			}
			if(form.password.value != form.passwordconfirm.value) {
				vele.style.display = "block";	 
				vele.innerText += "passwords dont match";
				form.password.className = "error";
				form.passwordconfirm.className = "error";
				rtn = false;				
			} else {
				form.password.className = "noerror";
				form.passwordconfirm.className = "noerror";
			}
			console.log(rtn);
			return rtn;

		}

	</script>
	<style>
		input { border: 1px solid black; border-radius: 2px; margin-left: auto; margin-right:auto; padding:0.1%;}
		H1 {font-family:Arial; font-size: 20px; margin-left: auto; margin-right:auto;}
		.error {border: 1px solid red; border-radius: 2px; margin-left: auto; margin-right:auto; padding:0.1%;}
		.noerror {border: 1px solid black; border-radius: 2px; margin-left: auto; margin-right:auto; padding:0.1%;}
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
		<span id = 'validation' style = 'display:none;'></span>
	</form>
</body>
</html>
<?php echo "<br><pre>" . "response: ". handleUsers() . "</pre><br>"?>
