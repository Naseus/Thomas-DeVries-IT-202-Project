
<?php
function handleUsers() {
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	require('config.php');
	$conn_string = "mysql:host=$host;dbname=$database;charset=utf8mb4";
	try {
		$db = new PDO($conn_string, $username, $password);
		$select_qurey = "select id, username from `TestUsers`";
		$r = $stmt->execute();
		$response = json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
	}
	 catch(Exception $e){
		$response = "DB error: $e";
	}
	return $response;

	$response = getSampleUsers();
		echo "<br><pre>" . $response . "<pre><br>";

} 
?>


<html>
<head>
	<script >
		function validate() {
			console.log("RAN");
			let rtn = true;
			let form = document.forms[0];
			if(form.username == "") 
				rtn = false;
			if(form.password != form.passwordconfirm) 
				rtn = false;
			if(rtn)
				console.log("Succsess");
			return rtn;

		}
	</script>
	<style>
		input { border: 1px solid black; border-radius: 2px; margin-left: auto; margin-right:auto; padding 1%;}
		H1 {font-family:Arial; font-size: 20px; margin-left: auto; margin-right:auto;}
	</style>
</head>
<body>
	<H1>Login</H1>
	<form method = 'post' action = '#' onsubmit= "return validate();">
		<input name="username"  placeholder = "username" style width = "300px"/>
		<br>
		<input name="password" type="password"  placeholder = "password"/>
		<input name="passwordconfirm" type="password"  placeholder = "confirm password"/>
		<br>
		<input type="submit", value="Login"/>
	</form>
</body>
</html>
<?php handleUsers();?>
<?php echo "<br><pre>" . var_export($_POST, true) . "</pre><br>";?>

