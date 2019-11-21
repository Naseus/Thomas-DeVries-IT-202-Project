<?php
start_session();
if(isset($_SESSION['user'])){
	echo $_SESSION['user'] . " time for database stuff" ;
} else {
	exit();
}
?>
<html>
<body>
	<a href="Landing.php">OLL Lab</a>
	<a href="Landing.php">PLL</a>
</body>
</html>