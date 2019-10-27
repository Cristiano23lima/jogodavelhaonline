<?php 
	unset($_SESSION['id']);
	header('location: login/');
	echo "<script>window.location = 'login/'</script>";
 ?>