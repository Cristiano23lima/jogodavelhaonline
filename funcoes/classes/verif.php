<?php 
	if(!isset($_SESSION)){
		session_start();
	}

	if(!$_SESSION['id']){
		session_destroy();
		header("location: login/");
	}
 ?>