<?php 
	if($_POST){
		$senha = (isset($_POST['senha'])?$_POST['senha']:null);
		session_start();
		include "classes/dados.php";

		$crud = new Crud();
		$param = array(":id"=>$_SESSION['id']);
		$result = $crud->select("SELECT senha FROM tb_usuario WHERE id = :id", $param);

		if($result[0]['senha'] == $senha){
			echo 1;//mandar o valor 1 dizendo que as senhas se coincedem
		}else{
			echo "Senha é diferente";//manda mensagem de erro dizendo que as senhas não coincidem
		}
	}
 ?>