<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
function validate() {
        if(isset($_POST['pass1']) && isset($_POST['pass2'])){
                if($_POST['pass1'] == $_POST['pass2']) {
			echo "<br>". "Passwords Matched" ."<br>";
			echo "<br><pre>" . var_export($_POST, true) . "</pre><br>";
		} else {
			echo "<br>" . "Passwords Don't Match" . "<br>";
		}
        }
}
?>

<html>
<head><head/>

<body>
<form method = 'post', action = '#'>
<input name = 'username', type = 'text', placeholder = 'enter your username'/>
<input name = 'pass1', type = 'password', placeholder = 'submit password'/>
<input name = 'pass2', type = 'password', placeholder = 're-submit password'/>
<input type = 'submit', value = 'try it'/>
</form>
</body>
</html>
<?php validate();?>
