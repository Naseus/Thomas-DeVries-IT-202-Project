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
				console.log("working");			
			$('#algs').submit(function(event){
			
				alert("submit");
			});
		});
        notations = [
            ["L", "R", "U", "D", "F", "B", "L\'", "R\'", "U\'", "D\'", "F\'", "B\'", "L2", "R2", "U2", "D2", "F2","B2"],
            ["l", "r", "u", "d", "f", "b", "l\'", "r\'", "u\'", "d\'", "f\'", "b\'", "l2", "r2", "u2", "d2", "f2","b2"], 
            ["M", "E", "S", "M\'", "E\'", "S\'", "M2", "E2", "S2"], ["X", "Y", "Z", "X\'", "Y\'", "Z\'"]];
        //btns = []
		$(document).ready(function() {
  			for(n of notations[0]) {
     			b = $('<button/>', {
        			text: n,
        			id: 'btn_'+ n,
        			click: function () { 
        					alert(n); }
    					});
     		  //btns.push(b);
     		console.log(b[0]);
     		console.log($(this));
     		console.log(this);
     		$(b).appendTo($(this.algs));
  			}
		});
		</script>

	</head>
	<body>
		<span id = "textArea" style = "block"></span>
		<br>
		<form id = 'algs'>
			<input id = 'input' type = "submit" value= "Save Algoritham" />
		</form>
		<br>
		<br>
		<a href="landing.php">Back</a>
	</body>
</html>