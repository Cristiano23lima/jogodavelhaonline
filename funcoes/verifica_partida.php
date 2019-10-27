<?php 
	if($_POST){
		$partida = (isset($_POST['partida'])?$_POST['partida']:null);
		session_start();
		$id = $_SESSION['id'];
		include "classes/dados.php";
		$crud = new Crud();
		$param = array(":id"=>$partida);
		$r = $crud->select("SELECT id_jogador1, id_jogador2 FROM tb_partida WHERE id = :id", $param);
		if($r){
			if($r[0][0] == $id){
				echo 0;
			}else if($r[0][1] == $id){
				echo 1;
			}
		}else{
			echo "Erro ao tentar verificar vez do jogador";
		}
	}
 ?>