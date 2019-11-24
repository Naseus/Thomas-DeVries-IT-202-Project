<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
if(!isset($_SESSION['user'])){
	header("login.php");
}

try {
	require("config.php");
				$conn_string = "mysql:host=$host;dbname=$database;charset=utf8mb4";
				$db = new PDO($conn_string, $username, $password);
				$stmt1 = $db->prepare("select * from `Users` where username =:user");
				$user = $stmt1->execute(array(":user" => $_SESSION['user']));
				$userData = $stmt1 ->fetch(PDO::FETCH_ASSOC);
				$algDatabase = $userData["Alg_Lab_Reference"];
				$stmt2 = $db->prepare("select * from `$algDatabase`");
				$r = $stmt2->execute();
				$results = $stmt2 ->fetchAll(PDO::FETCH_ASSOC);

		}catch(Exception $e){
		}
// CREATE A STRING FOR THE FRONTEND
function getLabData() {
	global $return;
	$rtn = "";
	foreach($return as $lst) {
		foreach($lst as $item) {
			$rtn += $item + " ";
		}
		$rtn += "!";
	}
	return $rtn;
}
// ADD AN ALGORITHAM TO THE DATABASE
function addAlg() {
	if(isset($_POST["algValue"]) && isset($_POST["name"])) {
		$algoritham = $_POST["algValue"];
		$length = count(str_word_count($_POST["algValue"], 1));
		$name = $_POST["name"];
		global $algDatabase, $db;
		$stmt =$db->prepare("INSERT into $algDatabase (`alg_name`,`alg`,`move_number`) VALUES (:name, :alg, :length)");
		$run = $stmt->execute(array(
			":name" => $name,
			":alg" => $algoritham,
			":length" => $length
		));
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
		//ONSUBMIT
		$(document).ready(function(){
			$('#algs').submit(function(event){
				this.algValue.value = $("#textArea").text();
				this.name.value = prompt("Enter a name for the Algoritham");
			});
		});
        notations = [
            ["L", "R", "U", "D", "F", "B"],[ "L\'", "R\'", "U\'", "D\'", "F\'", "B\'"], ["L2", "R2", "U2", "D2", "F2","B2"],
            ["l", "r", "u", "d", "f", "b"], ["l\'", "r\'", "u\'", "d\'", "f\'", "b\'"],[ "l2", "r2", "u2", "d2", "f2","b2"], 
            ["M", "E", "S", "M\'", "E\'", "S\'", "M2", "E2", "S2"], ["X", "Y", "Z", "X\'", "Y\'", "Z\'"]];
		//CREATING BUTTONS
		$(document).ready(function() {
  		//FIRST ROW
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
		// CREATE BACKSPACE
			b = $('<button/>', {
        		text: "Back",
        		id: 'btn_BACK',
       			click: function () { 
       					let lst = $("#textArea").text().split(" ");
      	 				console.log(lst[lst.length - 1]);   					
        				let rtn = "";
       					for(let text of lst) {
  	 						rtn += text + " ";
  	 						console.log(text);
       					}
      					$("#textArea").text(rtn);
       				}
 				});
     		$(b).appendTo($('#buttons'));
		});

		//CREATE TABLE
		function createTable() {
			let table = [[]];
			let algData ="R' U !R U F";/* <?php getLabData() ?>;*/
			let blocks = algData.split("!");
			for(let lst of blocks)
				table.push(lst.split(" "));
			for(let i = 0; i < table.length; i++) {
				let log = "";
				for (let j = 0; j < table[0].length; i++) {
					log += table[i][j];
				}
				console.log(log);
			}
		}
		console.log(createTable());

		</script>

	</head>
	<body>
		<span id = "textArea" style = "display:block"></span>
		<div id = buttons></div>
		<form id = 'algs' method = "POST">
			<input name = 'algValue' type = "hidden"/>
			<input name = 'name' type = "hidden">
			<input id = 'input' type = "submit" value= "Save Algoritham"/>
		</form>
		<div id = "algData"></div>
		<br>
		<br>
		<a href="landing.php">Back</a>
	</body>
</html>
<?php getLabData(); ?>
<?php echo addAlg(); ?>
