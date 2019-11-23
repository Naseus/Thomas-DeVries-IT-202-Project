<?php
session_start();
if(isset($_SESSION['user'])){
	echo $_SESSION['user'] . "'s alg lab" ;
} else{
	echo "log-in to accsess the lab";
	exit();
}

try {
	require("config.php");
				$conn_string = "mysql:host=$host;dbname=$database;charset=utf8mb4";
				$db = new PDO($conn_string, $username, $password);
				$stmt1 = $db->prepare("select * from `Users` where username =:user");
				$userData = $stmt1->execute(array(":user" => $_SESSION['user']));
				$algDatabase = $userData["Alg_Lab_Reference"];
				$stmt2 = $db->prepare("select * from `$algDatabase`");
				$results = $stmt2->execute();
				echo $results;

		}catch(Exception $e){
			 echo $e->getMessage();
		}

function getLabData() {
	return $results;
}
function addAlg($algoritham, $length, $name) {
	$stmt =$db->prepare("INSERT into $algDatabase (`alg_name`,`alg`,`move_number`) VALUES (:name, :alg, :length)");
	$run = $stmt->execute(array(
		":name" => $name,
		":alg" => $algoritham,
		":length" => $length
	));
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
		$(document).ready(function(){
			$('input').submit(function(event){
				console.log("submit");
	
				let allButtons = $("move > button");
				allButtons.click(function(){
					console.log("ran");
					document.textArea.innerText += this.text + " "; 
				});
		});
		</script>

	</head>
	<body>
		<span id = "textArea" style = "block"/>
		<br>
		<button type="button" class = "move" value="R">R</button>
		<button type="button" class = "move" value="L">L</button>
		<button type="button" class = "move" value="U">U</button>
		<button type="button" class = "move" value="D">D</button>
		<button type="button" class = "move" value="F">F</button>
		<button type="button" class = "move" value="B">B</button>

		<input id = 'input' type = "submit" value= "Save Algoritham" />
		<br>
		<br>
		<a href="landing.php">Back</a>
	</body>
</html>