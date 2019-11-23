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
function addAlg() {
	echo ("RAN");
	if(isset($_POST["algValue"]) && isset($_POST["name"])) {
		$algoritham = $_POST["algValue"];
		$length = count(str_word_count($_POST["algValue"], 1));
		$name = $_POST["name"];
		echo ($_POST["name"]);
		echo ($_POST["algValue"]);
		$stmt =$db->prepare("INSERT into $algDatabase (`alg_name`,`alg`,`move_number`) VALUES (:name, :alg, :length)");
		$run = $stmt->execute(array(
			":name" => $name,
			":alg" => $algoritham,
			":length" => $length
		));
		echo ("DONE");
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
		$(document).ready(function(){
			$('#algs').submit(function(event){
				this.algValue.value = $("#textArea").text();
				this.name.value = prompt("Enter a name for the Algoritham");
			});
		});
        notations = [
            ["L", "R", "U", "D", "F", "B", "L\'", "R\'", "U\'", "D\'", "F\'", "B\'", "L2", "R2", "U2", "D2", "F2","B2"],
            ["l", "r", "u", "d", "f", "b", "l\'", "r\'", "u\'", "d\'", "f\'", "b\'", "l2", "r2", "u2", "d2", "f2","b2"], 
            ["M", "E", "S", "M\'", "E\'", "S\'", "M2", "E2", "S2"], ["X", "Y", "Z", "X\'", "Y\'", "Z\'"]];
		$(document).ready(function() {
  			for(n of notations[0]) {
     			b = $('<button/>', {
        			text: n,
        			id: 'btn_'+ n,
        			click: function () { 
        					$("#textArea").text($("#textArea").text() + $(this).text() + " ");
        					 }
    					});
     		$(b).appendTo($('#buttons'));
  			}
		});
		</script>

	</head>
	<body>
		<span id = "textArea" style = "display:block"></span>
		<div id = buttons></div>
		<form id = 'algs' method = "POST">
			<input name = 'algValue' type = "hidden"/>
			<input name = 'name' type = "hidden">
			<input id = 'input' type = "submit" value= "Save Algoritham" />
		</form>
		<br>
		<br>
		<a href="landing.php">Back</a>
	</body>
</html>
<?php addAlg(); ?>
