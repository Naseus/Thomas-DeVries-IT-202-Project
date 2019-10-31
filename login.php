<html>
<head>
<style>
input{ border: 1px solid black; border-radius: 2px; margin-left: auto; margin-right:auto; padding 1%;}
H1 {font-family:Arial; font-size: 20px; margin-left: auto; margin-right:auto;}
</style>
</head>
<body>
<H1>Login</H1>
<HR>
<form onsubmit = "<?php handleUser(); ?>">
<input name="username"  placeholder = "username" style width = 300px onchange="validate(this);" />
<br>
<input name="email" type="email" placeholder = "email@domain.com"/>
<input name="emailconfirm" type="email"  placeholder = "email@domain.com"/>
<br>
<input name="password" type="password"  placeholder = "password"/>
<input name="passwordconfirm" type="password"  placeholder = "confirm password"/>
<br>
<input type="submit" value="Login"/>
</form>
</body>
</html>

<?php
function getSampleUsers() {
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
}

function handleUsers() {
	$response = getSampleUsers();
		echo "<br>" . $response . "<br>";

} 
?>
