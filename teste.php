<?php 
	$conexao = new pdo("mysql:host=localhost;dbname=test", "root", "");


	$select = $conexao->prepare("SELECT CONCAT(cpf, '.') as cpf FROM cpfs");
	$select->execute();

	while($dados = $select->fetch(PDO::FETCH_OBJ)){
		echo "<p>cpf <strong>".$dados->cpf."</strong></p>";
	}

 ?>