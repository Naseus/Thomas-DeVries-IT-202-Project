<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	session_start();
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
	$rtn = "###";
	if(isset($_GET['alg']) && !empty($_GET['alg'])) {
		$rtn = $_GET['alg'] . "!";
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
//	HANDLES THE DATA SUMBITED TO THE BACKEND
function handleData() {
	if(isset($_POST['newAlg']) && isset($_GET['alg'])) {
		addAlg();
	}
	if(isset($_POST["delete"])) {
		delete();
	}
}
// DELETES AN ALGORITHM FROM THE DATABASE
function delete() {
	global $algDatabase, $db;
	$stmt = $db -> prepare("DELETE FROM $algDatabase WHERE alg = :alg");
	$user = $stmt->execute(array(":alg" => $_POST["delete"]));
}

// ADD AN ALGORITHM TO THE DATABASE
function addAlg() {
	if(!isset($_SESSION["user"]) || empty($_SESSION["user"])) {
		header("login.php");
		exit();
		echo($_SESSION['user']);
	}
	if(!empty($_POST["newAlg"]) && !empty($_GET["alg"])) {
		$alg = $_POST["newAlg"];
		$baseAlg = $_GET["alg"];
		$length = count(str_word_count($alg, 1));
		global $algDatabase, $db;
		$stmt =$db->prepare("INSERT into $algDatabase (`alg`,`base_alg`,`alg_type`,`move_number`) VALUES (:alg, :base_alg,:type, :length)");
		$run = $stmt->execute(array(
			":alg" => $alg,
			":base_alg" => $baseAlg,
			":type" => "PLL",
			":length" => $length
		));
	}
}
?>

<?php handleData();?>

<html>
	<head>
		<script
			src="https://code.jquery.com/jquery-3.4.1.js"
  			integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  			crossorigin="anonymous">
		</script>
		<script>
	//CREATE PAGE
	$(document).ready(function() {
		//CHECK IF AN ALG IS SET
		let arr = [];
		let algData ="<?php getLabData() ?>";
		if(algData == "###") {
			$('#algList').css('display', 'block');
			$('#selectedAlg').css('display', 'none');
			return;
		}
		$('#algList').css('display', 'none');
		$('#selectedAlg').css('display', 'block');
		//CREATE TABLE
		let blocks = algData.split("!");
		for(let lst of blocks)
			arr.push(lst.split("_"));
		arr.pop();
		for(let i = 1; i < arr.length; i++) 
			arr[i].pop();
			let $table = $("<table>");
			let $headTr = $("<tr>");
			$('#algData').append($table);
			$table.append($headTr);
			$headTr.append($("<th>", { text: "Algorithm"}));
			$headTr.append($("<th>", { text: "Delete"}));
			for(let i = 1; i < arr.length; i ++) {
				let $tr = $("<tr>");
				$table.append($tr);
				$tr.append($("<td>", { text: arr[i][0]}));
				$btnTd = ("<td>");
				$tr.append($('<input/>',{
					value: "X",
					id:"Delete_" + arr[i][0],
					type: "submit",
					click: function () { 
						document.forms[1].delete.value = $(this).attr("id").split("_")[1];
					}
				}));
			}
			let $addRow = $("<tr>");
			$table.append($addRow);
			$addRow.append($('<td>', {text: "add"}));
			$addRow.append($('<input/>',{
					value: "+",
					id:"add",
					type: "submit",
					click: function () { 
						document.forms[1].newAlg.value = prompt();
					}
				}));
			$('#selectedBaseAlg').text(arr[0]);
			let picId = "./PLL/" + arr[0] + ".png";
			$('#algPicture').attr("scr") = picId;

		});
	function submitAlg(x) {
		$("#setAlg").submit(function() {
			this.alg.value = x;
		});
		$("#setAlg").submit();
	}
		</script>
	</head>
	<body>
		<form id = 'setAlg' method = "GET">
			<input name = 'alg' type = 'hidden'/>
		</form>
		<!-- div WITH LIST OF ALGORITHMS -->
		<div id = algList>
			<a href="javascript: submitAlg(&quot;R2 u R&apos; U R&apos; U&apos; R u&apos; R2 y&apos; R&apos; U R&quot;);">Ga-Perm</a>
			<br>
			<a href="javascript: submitAlg(&quot;R&apos; U&apos; R U D&apos; R2 U R&apos; U R U&apos; R U&apos; R2 D&quot;);">Gb-Perm</a>
			<br>
			<a href="javascript: submitAlg(&quot;R2 u&apos; R U&apos; R U R&apos; u R2 y R U&apos; R&apos;&quot;);">Gc-Perm</a>
			<br>
			<a href="javascript: submitAlg(&quot;R U R&apos; y&apos; R2 u&apos; R U&apos; R&apos; U R&apos; u R2&quot;);">Gd-Perm</a>
			
			<br>
			<a href="javascript: submitAlg(&quot;R U&apos; R U R U R U&apos; R&apos; U&apos; R2&quot;);">Ua-Perm</a>
			<br>
			<a href="javascript: submitAlg(&quot;R2 U R U R&apos; U&apos; R&apos; U&apos; R&apos; U R&apos;&quot;);">Ub-Perm</a>
			<br>
			<a href="javascript: submitAlg(&quot;M2 U M2 U M&apos; U2 M2 U2 M&apos; U2&quot;);">Z-Perm</a>
			<br>
			<a href="javascript: submitAlg(&quot;M2 U M2 U2 M2 U M2&quot;);">H-Perm</a>
			

			<br>
			<a href="javascript: submitAlg(&quot;l&apos; U R&apos; D2 R U&apos; R&apos; D2 R2&quot;);">Aa-Perm</a>
			<br>
			<a href="javascript: submitAlg(&quot;l U&apos; R D2 R&apos; U R D2 R2&quot;);">Ab-Perm</a>
			<br>
			<a href="javascript: submitAlg(&quot;x&apos; R U&apos; R&apos; D R U R&apos; D&apos; R U R&apos; D R U&apos; R&apos; D&apos;&quot;);">E-Perm</a>
			<br>
			

			<a href="javascript: submitAlg(&quot;R U R&apos; U&apos; R&apos; F R2 U&apos; R&apos; U&apos; R U R&apos; F&apos;&quot;);">T-Perm</a>
			<br>
			<a href="javascript: submitAlg(&quot;R&apos; U2 R&apos; d&apos; R&apos; F&apos; R2 U&apos; R&apos; U R&apos; F R U&apos; F&quot;);">F-Perm</a>
			<br>
			<a href="javascript: submitAlg(&quot;R&apos; U L&apos; U2 R U&apos; R&apos; U2 L R U&apos;&quot;);">Ja-Perm</a>
			<br>
			<a href="javascript: submitAlg(&quot;R U R&apos; F&apos; R U R&apos; U&apos; R&apos; F R2 U&apos; R&apos; U&apos;&quot;);">Jb-Perm</a>
			<br>
			<a href="javascript: submitAlg(&quot;L U2&apos; L&apos; U2&apos; L F&apos; L&apos; U&apos; L U L F L2&apos; U&quot;);">Ra-Perm</a>
			<br>
			<a href="javascript: submitAlg(&quot;R&apos; U2 R U2 R&apos; F R U R&apos; U&apos; R&apos; F&apos; R2 U&apos;&quot;);">Rb-Perm</a>
			<br>
			<a href="javascript: submitAlg(&quot;R&apos; U R&apos; d&apos; R&apos; F&apos; R2 U&apos; R&apos; U R&apos; F R F&quot;);">V-Perm</a>
			<br>
			<a href="javascript: submitAlg(&quot;F R U&apos; R&apos; U&apos; R U R&apos; F&apos; R U R&apos; U&apos; R&apos; F R F&apos;&quot;);">Y-Perm</a>
			<br>
			<a href="javascript: submitAlg(&quot;L U&apos; R U2 L&apos; U R&apos; L U&apos; R U2 L&apos; U R&apos; U&quot;);">Na-Perm</a>
			<br>
			<a href="javascript: submitAlg(&quot;R&apos; U L&apos; U2 R U&apos; L R&apos; U L&apos; U2 R U&apos; L U&apos;&quot;);">Nb-Perm</a>
		
			<br>
			<br>
			<a href="LastLayer.php">Back</a>
		</div>
		<br>
		<div id = "selectedAlg">
			<img id ="algPicture" alt = "alg">
			<br>
			<span id = 'selectedBaseAlg' ></span>
		<!--  FORM FOR TABLE -->
			<form id = "algData" method = "POST">
				<input name = 'delete' type = "hidden"/>
				<input name = 'newAlg' type = "hidden"/>
			</form>
		<br>
		<a href = 'PLL.php'>Back</a>
		</div>
	</body>
</html>
<?php 	echo($_SESSION['user']); ?>
