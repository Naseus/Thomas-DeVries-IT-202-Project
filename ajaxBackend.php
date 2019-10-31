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

if(isset($_POST["type"])) {
	$type = $_POST["type"];
	$response = "nothing";
	switch($type) {
		case("add"):
			if(isset($_POST["num1"]) && isset($_POST["num2"])) {
				$a = $_POST["num1"];
	  			$b = $_POST["num2"];
				if(is_numeric($a) && is_numeric($b)) {
					$response = ((int)$num1 + (int)$num2);
				}else {
					$response = "enter a valid number";
				}			
			}
			break;
		case("echo"):
			if(isset($_POST["string1"])) {
				$response = $_POST["string1"];
			} else {
				$response = $_POST["string1"];
			}
			break;
		case("concat"):
			if(isset($_POST["string1"]) && isset($_POST["string2"])) {
				$response = $_POST["string1"] . $_POST["string2"];
			}
			break;
		case("db"):
			$response = getSampleUsers();
		break;
		default:
			$response = "$type has not yet been implemented";
		break;
	}
	echon $response;
}
?>
