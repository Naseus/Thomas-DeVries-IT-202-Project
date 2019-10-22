<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
function validate() {
        if(isset($_POST['pass1']) && isset($_POST['pass2'])){
                if($_POST['pass1'] == $_POST['pass2']) {
			echo "<br>". "Passwords Matched" ."<br>";
			return true;
		} else {
			echo "<br>" . "Passwords Don't Match" . "<br>";
			return false;
		}
		
        }
}
?>

<html>
<head>
<script>
function verify() {
	var form = document.forms[0];
	var password = form.pass1.value;
	var conf = form.pass2.value;
	let pv = document.getElementById("validation.password");
	console.log(password);
	console.log(conf);
	let succeeded = true;
	if(password == conf){
		pv.style.display = "none";
		form.pass2.className= "noerror";
	}else{
		pv.style.display = "block";	
		pv.innerText = "Passwords don't match";
		form.pass2.className = "error";
		succeeded = false;
	}
	var email = form.email.value;
	var ev = document.getElementById("validation.email");
	if(email.indexOf('@') <= -1) {
		 ev.style.display = "block";
                ev.innerText = "Email is invalid";
		form.email.className = "error";
		succeeded = false;		
	} else {
		ev.style.display = "none";
                form.email.className= "noerror";
	}
	var drop = form.dropdown;
	var dv = document.getElementById("validation.dropdown");
	if(drop.selectedIndex  == 0){
		form.dropdown.className = "error";
		 dv.style.display = "block";
                dv.innerText = "Select One";
		succeeded = false;
	} else {
		dv.style.display = "none";
                form.dropdown.className= "noerror";
	}
	return succeeded;
}
</script>
<style>
input { border: 1px solid black; }
.error {border: 1px solid red;}
.noerror {border: 1px solid black;}
</style>
</head>

<body>
<form method = 'post' action = '#' onsubmit = "return verify();">
<input name = 'username', type = 'text', placeholder = 'enter your username'/>

<input name = 'email' type = 'text' placeholder = 'name@examlpe.com'/>
<span id = 'validation.email' style = 'display:none;'></span>

<input name = 'pass1' type = 'password' placeholder = 'submit password'/>
<input name = 'pass2' type = 'password' placeholder = 're-submit password'/>
<span id = 'validation.password' style = 'display:none;'></span>

<select name = "dropdown">
	<option value = "Select One">Select One</option>
	<option value = "R2 u R' U R' U' R u' R2 y' R' U R"> Ga Perm</option>
	<option value = "L' U' L y' R2 u R' U R U' R u' R2"> Gb Perm</option>
	<option value = "R2 u' R U' R U R' u R2 y R U' R'"> Gc Perm</option>
	<option value = "R U R' y' R2 u' R U' R' U R' u R2">Gd Perm</option>
</select>
<span id = 'validation.dropdown' style = 'display:none;'></span>
<input type = 'submit', value = 'try it'/>
</form>
</body>
</html>
<?php validate();?>
<?php echo "<br><pre>" . var_export($_POST, true) . "</pre><br>";?>
