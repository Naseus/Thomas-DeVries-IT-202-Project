<?php
session_start();
if(isset($_SESSION['user'])){
	echo $_SESSION['user'] . " time for database stuff";
} 
?>
<html>
<body>
	<br>
	<a href="OLL.php">OLL Lab</a>
	<br>
	<a href="PLL.php">PLL</a>
	<br>
	<br>
	<a href="landing.php">Back</a>
</body>
</html>