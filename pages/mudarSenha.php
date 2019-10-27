<?php 
	if ($_POST) {
		include "../../funcoes/classes/dados.php";
		$usuario = new Usuarios();
		$usuario->setSenha($_POST['novaSenha']);
		$senhaAntiga = isset($_POST['senhaAntiga'])?$_POST['senhaAntiga']:null;
		
		$crud = new Crud();
		$param = array(":id"=>$_SESSION['id']);
		$result = $crud->select("SELECT senha FROM tb_usuario WHERE id = :id", $param);
		if($result[0]['senha'] == $senhaAntiga){
			$param = array(":id"=>$_SESSION['id'], ":senha"=>$usuario->getSenha());
			$result = $crud->crud("UPDATE tb_usuario SET senha = :senha WHERE id = :id", $param);
			if($result){
				echo "Senha Alterada com sucesso";
				header("location: ../../index.php?mod=jogo&pg=status");
			}else{
				echo "Erro ao tentar alterar a sua senha";
				header("location: ../../index.php?mod=jogo&pg=status");
			}
		}else{
			echo "Senhas não coincidem";
			header("location: ../../index.php?mod=jogo&pg=status");
		}
	}
 ?>