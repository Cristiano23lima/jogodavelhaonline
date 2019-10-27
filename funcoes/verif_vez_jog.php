<?php 
	if ($_POST) {
		include "classes/dados.php";

		$crud = new Crud();
		$jogada = new Jogadas();

		$jogada->setId_partida(isset($_POST['partida'])?$_POST['partida']:null);

		$param = array(":partida"=>$jogada->getId_partida());
		$r = $crud->select("SELECT vez FROM tb_jogo WHERE id_partida = :partida", $param);
		echo $r[0][0];
	}
 ?>