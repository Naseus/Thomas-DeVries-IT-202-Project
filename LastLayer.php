<?php
	session_start();
	if(isset($_SESSION["user"])) {
		try {
			require("config.php");
				$conn_string = "mysql:host=$host;dbname=$database;charset=utf8mb4";
				$db = new PDO($conn_string, $username, $password);
				$stmt1 = $db->prepare("select * from `Users` where username =:user");
				$user = $stmt1->execute(array(":user" => $_SESSION['user']));
				$userData = $stmt1 ->fetch(PDO::FETCH_ASSOC);
		}catch(Exception $e){}
	}

	function learnedAlg($type) {
		if(isset($_SESSION["user"]) && !(empty($_SESSION["user"]))) {
			global $userData;
			echo count(explode("1", $userData[$type . "_learned"])) - 1;
		} else {
			echo 0;
		}
	}

?>
<html>
	<head>
		<script
			src="https://code.jquery.com/jquery-3.4.1.js"
  			integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  			crossorigin="anonymous">
		</script>
		<script>
			$(document).ready(function() {
				$('#oll').attr({"value": <?php learnedAlg("OLL");?>});
				$('#pll').attr({"value": <?php learnedAlg("PLL");?>});
			});
		</script>
	</head>
	<body>
		<br>
		<progress id="oll" max="57" value="0"></progress>
		<a href="OLL.php">OLL</a>
		<br>
		<progress id="pll" max="21" value="0"></progress>
		<a href="PLL.php">PLL</a>
		<br>
		<br>
		<a href="landing.php">Back</a>
	</body>
</html>