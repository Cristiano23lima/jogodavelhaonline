<?php
	if($_POST){
		include "classes/dados.php";

		$usuario = (isset($_POST['email'])?$_POST['email']: null);
		$senha = (isset($_POST['senha'])?$_POST['senha']:null);

		//instanciando as classes conexao e usuarios
		$conexao = new Conexao();
		$usuarios = new Usuarios();

		$usuarios->setEmail($usuario);
		$usuarios->setSenha($senha);
		$login = $conexao->abrir_conexao()->prepare("SELECT * FROM tb_usuario WHERE email = :email and senha = :senha");
		$login->bindValue(":email", $usuarios->getEmail());
		$login->bindValue(":senha", md5($usuarios->getSenha()));
		if($login->execute() === true){
			$verif = $login->rowCount();
			session_start();
			if($verif){
				$dados = $login->fetch(PDO::FETCH_OBJ);
				$_SESSION['id'] = $dados->id;
				header("location: ../tabuleiro");
			}else{
				$_SESSION['error'] = 1;
				header("location: ../login/");
			}
		}else{
			$_SESSION['error'] = 0;
			header("location: ../login/");
		}
	}
?>