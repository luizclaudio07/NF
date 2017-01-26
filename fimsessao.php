<?php 
	session_start();
	

	if(isset($_SESSION['CODUSER'])){
		session_destroy();
		
	} 

	header("Location: entrar.php");

 ?>