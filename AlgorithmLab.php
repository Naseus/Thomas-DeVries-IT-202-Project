<?php
session_start();
if(isset($_SESSION['user'])){
	echo $_SESSION['user'] . "'s alg lab" ;
} else{
	echo "log-in to accsess the lab";
	exit();
}
?>