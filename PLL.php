<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	session_start();
	if(!isset($_SESSION['user'])){
		header("Location: login.php");
		exit();
	}
	try {
		require("config.php");
			$conn_string = "mysql:host=$host;dbname=$database;charset=utf8mb4";
			$db = new PDO($conn_string, $username, $password);
			$stmt1 = $db->prepare("select * from `Users` where username =:user");
			$user = $stmt1->execute(array(":user" => $_SESSION['user']));
			$userData = $stmt1 ->fetch(PDO::FETCH_ASSOC);
			$algDatabase = $userData["Speed_Algs_Reference"];
	}catch(Exception $e){}
	//Creates a string for the frontend
	function getLabData() {
	$rtn = "";
	if(isset($_GET['alg'])) {
		try {
			global $db, $algDatabase;
			$stmt2 = $db->prepare("select * from `$algDatabase` where base_alg =:alg");
			$r = $stmt2->execute(array(":alg" => $_GET['alg']));
			$results = $stmt2 ->fetchAll(PDO::FETCH_ASSOC);
			foreach($results as $lst) {
				foreach($lst as $item) {
					$rtn .= $item . "_";
				}
				$rtn .= "!";
			}
		}catch(Exception $e){}
	}
	echo $rtn;
}
?>

<html>
	<head>
		<script>
			function test(x) {
				alert("Working" + x);
			}
		</script>
	</head>
	<body>
		<a href="javascript: test(&quot;R&apos; U R&apos; d&apos; R&apos; F&apos; R2 U&apos; R&apos; U R&apos; F R F&quot;);">V-Perm</a>
		<a href="LastLayer.php">Back</a>
	</body>
</html>