<?php
echo "<pre>" . var_export($_GET,true) . "</pre>";

if(isset($_GET['name'])) {
	echo "<br>Hello, " . $_GET['name'] . "<br>";
}

if(isset($_GET['number'])) {
	echo "<br>" . $_GET['number'] . " should be a number . . . ";
	echo "<br> but it might not be <br>";
}

if(isset($_GET['number']) && isset($_GET['number2'])) {
	$sum = intval($_GET['number']) + intval($_GET['number']);
	echo "<br>" . $sum . " is the sum of " . $_GET['number'] . " and " . $_GET['number2'] . "<br>";
}

if(isset($_GET['string1']) && isset($_GET['string2'])) {
	$cat = $_GET['string1'] . $_GET['string2'];
	echo "<br>" . $cat . " is the concatination of " . $_GET['string1'] . " and " . $_GET['string2'] . "<br>";
}
?>
