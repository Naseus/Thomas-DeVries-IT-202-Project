<?php
session_start();
echo "Welcome " . $_SESSION['user'];
?>
<html>
<head>	
</head>
<body>
	<br>
	<a href="AlgorithmLab.php">Algorithm Lab</a>
	<br>
	<a href="LastLayer.php">Speedsolving</a>
	<br>
	<br>
	<a href = "logout.php">Logout</a>
</body>
</html>