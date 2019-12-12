<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	session_start();
	if(isset($_SESSION["user"])) {
		try {
			require("config.php");
				$conn_string = "mysql:host=$host;dbname=$database;charset=utf8mb4";
				$db = new PDO($conn_string, $username, $password);
				$stmt1 = $db->prepare("select * from `Users` where username =:user");
				$user = $stmt1->execute(array(":user" => $_SESSION['user']));
				$userData = $stmt1 ->fetch(PDO::FETCH_ASSOC);
				$algDatabase = $userData["Speed_Algs_Reference"];
		}catch(Exception $e){}
	}
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
// GETS THE ALGS THAT WERE CHECKED AS LEARNED
function learnedAlgs() {
	if(isset($_SESSION["user"]) && !(empty($_SESSION["user"]))) {
		global $userData;
		echo $userData["OLL_learned"];
	}
}
//	HANDLES THE DATA SUMBITED TO THE BACKEND
function handleData() {
	if(isset($_GET['backsubmit']) && ! empty($_GET['backsubmit'])) {
		updateLearnedAlgs();
		header("location: LastLayer.php");
	}
	if(isset($_POST['newAlg']) && isset($_GET['alg'])) {
		addAlg();
	}
	if(isset($_POST["delete"])) {
		delete();
	}
	if(isset($_GET['alg'])){
	updateLearnedAlgs();
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
		header("location: login.php");
		exit();
	}
	$notations = array("L", "R", "U", "D", "F", "B", "L'", "R'", "U'", "D'", "F'", "B'", "L2", "R2", "U2", "D2", "F2","B2",
            "l", "r", "u", "d", "f", "b", "l'", "r'", "u'", "d'", "f'", "b'", "l2", "r2", "u2", "d2", "f2","b2", 
            "M", "E", "S", "M'", "E'", "S'", "M2", "E2", "S2", "X", "Y", "Z", "X'", "Y'", "Z'");

	if(!empty($_POST["newAlg"]) && !empty($_GET["alg"])) {
		$alg = $_POST["newAlg"];
		$baseAlg = $_GET["alg"];
		$lst = explode(" ", $alg);
	// Backend validation ADD FRONT END
	for($i = 0; $i < count($lst); $i++) {
		for($j = 0; $j < count($notations); $j++) {
        	$break = true;
				if(strcmp($lst[$i],$notations[$j]) == 0) {
					$break = false;
                    break;
				}
		}
		if($break) {
            return;
            }
	}
		$length = count(str_word_count($alg, 1));
		global $algDatabase, $db;
		$stmt =$db->prepare("INSERT into $algDatabase (`alg`,`base_alg`,`alg_type`,`move_number`) VALUES (:alg, :base_alg,:type, :length)");
		$run = $stmt->execute(array(
			":alg" => $alg,
			":base_alg" => $baseAlg,
			":type" => "OLL",
			":length" => $length
		));
	}
}

// UPDATE STORED VALUES FOR CHECKBOXES
function updateLearnedAlgs() {
	global $userData, $db;
	$curr = $userData["OLL_learned"];
	$temp = "";
	for($i = 0; $i < strlen($curr); $i++) {
		if(isset($_GET[$i])) {
			$temp .= "1";
		} else {
			$temp .= "0";
		}
	$stmt = $db-> prepare("UPDATE `Users` SET `OLL_learned` = :learned WHERE username =:user ");
	$run = $stmt->execute(array(
			":learned" => $temp,
			":user" => $_SESSION["user"]
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
			checkLearned();
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
						if(arr.length <= 1)
							window.location.href = "login.php";
						document.forms[1].newAlg.value = prompt();
					}
				}));
			$('#selectedBaseAlg').text(arr[0]);
			let picId = "PLL/" + arr[0] + ".png";
			console.log(picId);
			$('#algPicture').attr({"src": picId});
		});
		// GENERATE THE LIST OF ALGS
	$(document).ready(function() {
		algs = ["R U2 R2' F R F' U2' R' F R F'", "F R U R' U' F' f R U R' U' f", "f R U R' U' f' U' F R U R' U' F'", "f R U R' U' f' U F R U R' U' F'", "l' U2 L U L' U l",
				 "r U2' R' U' R U' r'", "r U R' U R U2' r'", "R U2' R' U2 R' F R F'", "R U R' U' R' F R2 U R' U' F'", "R U R' y R' F R U' R' F' R", 
				 "F' L' U' L U F y F R U R' U' F'", "F R U R' U' F' U F R U R' U' F'"];
		for(let i = 0; i < algs.length; i ++) {
			$link = $('<a>',{
    			text: "" + (i + 1),
    			href: 'javascript: submitAlg("' + algs[i] + '");'
			});
			$box = $('<input>', {
				type: "checkbox",
				name: "" + i,
				id: "" + i + "_learned"
			});
			$('#setAlg').append($box);
			$('#setAlg').append($link);
			$('#setAlg').append($('<br>'));

		}
	}); 
	// CHECK BOXES FOR KNOWN ALGS
	function checkLearned() {
		let learned = "<?php learnedAlgs();?>".split("");
		for(var i = 0; i < learned.length; i++) {
			let $thisBox = $( "#" + i + "_learned");
			console.log($thisBox);
			console.log(learned[i]);
			if(learned[i] == 1) 
				$thisBox.prop('checked', true);
		}
	}
	// HANDLES ALGS BEING PASSED TO THE GET
	function submitAlg(x) {
		$("#setAlg").submit(function() {
			this.alg.value = x;
		});
		$("#setAlg").submit();
	}
	//SET BACKSUBMIT AND SUBMIT
	function saveAndExit() {
		$("#setAlg").submit(function() {
			this.backsubmit.value = "exit";
		});
		$("#setAlg").submit();	
	}
		</script>
	</head>
	<body>

		<!-- div WITH LIST OF ALGORITHMS -->
		<div id = algList>
			<form id = 'setAlg' method = "GET">
			<input name = 'alg' type = 'hidden'/>
			<input name = 'backsubmit' type = 'hidden'/>
			</form>
			<br>
			<br>
			<a href="javascript: saveAndExit();">Back</a>
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
		<a href = 'OLL.php'>Back</a>
		</div>
	</body>
</html>
