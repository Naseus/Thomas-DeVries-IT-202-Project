<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
?>

<html>
	<script
	src="https://code.jquery.com/jquery-3.4.1.js"
  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  crossorigin="anonymous">
	</script>
	<script>
		$(document).ready(function(){
			$('#register').submit(function(event){
				let rtn = true;
				let alertvalue = "";
				if(this.username.value.length == 0) {
					rtn = false;
					alertvalue += "Enter a username\n";
					this.username.className = "error";
				} else {
					this.username.className = "noerror";
				}

				if(this.email.value.length == 0){
					rtn = false;
					alertvalue += "Email is invalid\n";	
					this.email.className = "error";				
				} else {
					this.email.className = "noerror";
				}
				if(this.password.value != this.confirm.value || this.password.value.length == 0 || this.confirm.value.length == 0){
					rtn = false;
					alertvalue += "passwords don't match";
					this.password.className = "error";
					this.confirm.className = "error";
					} else {
						this.password.className = "noerror";
					this.confirm.className = "noerror";
					}
				if(alertvalue.length > 0)
					alert(alertvalue);
				console.log(rtn);
				return rtn;
			});
		});
	</script>
		<style>
		input { border: 1px solid black; border-radius: 2px; margin-left: auto; margin-right:auto; padding:0.1%;}
		H1 {font-family:Arial; font-size: 20px; margin-left: auto; margin-right:auto;}
		.error {border: 1px solid red; border-radius: 2px; margin-left: auto; margin-right:auto; padding:0.1%;}
		.noerror {border: 1px solid black; border-radius: 2px; margin-left: auto; margin-right:auto; padding:0.1%;}
	</style>
	<body>
		<H1>Registration</H1>
		<HR>
		<form id = "register" method = "POST"/>
			<input name = "username" type = "text" placeholder="Username"/>
			<input name = "email" type = "email" placeholder="name@domain.com" />
			<br>
			<input name = "password" type = "password" placeholder = "password" />
			<input name = "confirm" type = "password" placeholder = "password" />	
			<br>
			<input name = "submit" type = "submit" value="Enter" />		
		</form>
	</body>
</html>

<?php
	if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['confirm']) && isset($_POST['email'])) {
		if(empty($_POST['username']) || empty($_POST['password']) || empty($_POST['confirm']) || empty($_POST['email'])) {
			exit();
		}
		$user =  $_POST['username'];
		$pass = $_POST['password'];
		$conf = $_POST['confirm'];
		$email = $_POST['email'];
		$isValid = true;
		if($pass != $conf) {
			$isValid = false;
		}
		if($isValid) {
			try {
				$hash = password_hash($pass, PASSWORD_BCRYPT);
				require("config.php");
				$conn_string = "mysql:host=$host;dbname=$database;charset=utf8mb4";
				$db = new PDO($conn_string, $username, $password);
				$stmt1 = $db->prepare("INSERT into `Users` (`username`, `email`, `password`) VALUES (:username, :email, :password)");
				$result = $stmt1->execute(
					array(":username"=>$user,
							":password"=>$hash,
							":email"=>$email
					)
				);
				echo var_export($result, true);

				$select_query = "select * from `Users` where username = :username";
				$extract_stmt = $db ->prepare($select_query);
				$r = $extract_stmt-> execute(array(":username"=> $user));
				$response = $extract_stmt ->fetch(PDO::FETCH_ASSOC);
				$labName = "Alg_Lab_" . $response["id_number"];
				echo "<br><pre>" . $labName . "</pre><br>";


				$stmt2 = $db->prepare("UPDATE  `Users` SET `alg_lab_ref`=:ref WHERE `id_number`=:id");
				$result = $stmt2->execute(
					array(":ref"=>$labName,
					 		":id" =>$response["id_number"])
				);
				unset($r);


				$query = "create table if not exists `$labName`(
				`alg_name` varchar(30) not null,
				`alg` varchar(60) not null unique,
				`moveNumber` int default 0,
				PRIMARY KEY(`alg_name`)
				) CHARACTER SET utf8 COLLATE utf8_general_ci";
				$create_stmt = $db->prepare($query);
				$r = $create_stmt->execute();
				//header("location: login.php");

			}catch(Exception $e){
			 	echo $e->getMessage();
			 }

		}
	}
?>